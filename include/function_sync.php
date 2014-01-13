<?php
/***********************************************
* File      :   function_sync.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   9.06.2013
*
* Copyright 2012-2014 <xbgmsharp@gmail.com>
*
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
************************************************/

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

include_once("function_frame.php");

/***************
 *
 * Start the sync work
 *
 */

// Check the presence of the DB schema
$sync_options['sync_gps'] = true;
$q = 'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "'.IMAGES_TABLE.'" AND COLUMN_NAME = "lat" OR COLUMN_NAME = "lon"';
list($result) = pwg_db_fetch_row( pwg_query($q) );
if($result != 4)
{
    $sync_options['sync_gps'] = false;
}

// Init value for result table
$videos = 0;
$metadata = 0;
$thumbs = 0;
$errors = array();
$warnings = array();
$infos = array();

if (!$sync_options['sync_gps'])
{
    $warnings[] = "latitude and longitude disable because the require plugin is not present, eg: 'OpenStreetMap'.";
}

if ($sync_options['poster'] or $sync_options['thumb'])
{
    $log = system("ffmpeg -version 2>&1", $retval); // Does it works on Windows
    if (($retval != 0))
    {
        $warnings[] = "Poster creation disable because ffmpeg is not installed on the system, eg: '/usr/bin/ffmpeg'.";
        $sync_options['poster'] = false;
        $sync_options['thumb'] = false;
    }
}

if (!$sync_options['metadata'] and !$sync_options['poster'] and !$sync_options['thumb'])
{
    $errors[] = "You ask me to do nothing, are you sure?";
}

// Avoid Conflict with other plugin using getID3
if( !class_exists('getID3')){
    // Get video infos with getID3 lib
    require_once(dirname(__FILE__) . '/../include/getid3/getid3.php');
}
$getID3 = new getID3;
// Do the job
$result = pwg_query($query);
while ($row = pwg_db_fetch_assoc($result))
{
    //print_r($row);
    $filename = $row['path'];
    if (is_file($filename))
    {
        $videos++;
        //echo $filename;
        $fileinfo = $getID3->analyze($filename);
        //print_r($fileinfo);
        $exif = array();
        if (isset($fileinfo['filesize']))
        {
                $exif['filesize'] = round($fileinfo['filesize']/1024);
        }
        /*
        if (isset($fileinfo['playtime_string']))
        {
                $exif['playtime_string'] = $fileinfo['playtime_string'];
        }
        */
        if (isset($fileinfo['video']['resolution_x']))
        {
                $exif['width'] = $fileinfo['video']['resolution_x'];
        }
        if (isset($fileinfo['video']['resolution_y']))
        {
                $exif['height'] = $fileinfo['video']['resolution_y'];
        }
        if (isset($fileinfo['tags']['quicktime']['gps_latitude'][0]) and $sync_options['sync_gps'])
        {
                $exif['latitude'] = $fileinfo['tags']['quicktime']['gps_latitude'][0];
        }
        if (isset($fileinfo['tags']['quicktime']['gps_longitude'][0]) and $sync_options['sync_gps'])
        {
                $exif['longitude'] = $fileinfo['tags']['quicktime']['gps_longitude'][0];
        }
        if (isset($fileinfo['tags']['quicktime']['model'][0]))
        {
                $exif['Model'] = substr($fileinfo['tags']['quicktime']['model'][0], 2);
        }
        if (isset($fileinfo['tags']['quicktime']['software'][0]))
        {
                $exif['Model'] .= " ". substr($fileinfo['tags']['quicktime']['software'][0], 2);
        }
        if (isset($fileinfo['tags']['quicktime']['make'][0]))
        {
                $exif['Make'] = $fileinfo['tags']['quicktime']['make'][0];
        }
        if (isset($fileinfo['tags']['quicktime']['creation_date'][0]))
        {
                // ?2013-03-25T09:46:54+0900
                $exif['DateTimeOriginal'] = substr($fileinfo['tags']['quicktime']['creation_date'][0], 1);
        }
        //print_r($exif);
        if (isset($exif) and $sync_options['metadata'])
        {
            $metadata++;
            $infos[] = $filename. ' metadata: '.implode(",", array_keys($exif));
            if ($sync_options['metadata'] and !$sync_options['simulate'])
            {
                $dbfields = explode(",", "filesize,width,height,latitude,longitude");
                $query = "UPDATE ".IMAGES_TABLE." SET ".vjs_dbSet($dbfields, $exif).", `date_metadata_update`=CURDATE() WHERE `id`=".$row['id'].";";
                pwg_query($query);
            }
        }

        /* Create poster */
        if ($sync_options['poster'])
        {
            $thumbs++;
            /* Init value */
            $file_wo_ext = pathinfo($row['file']);
            $output_dir = dirname($row['path']) . '/pwg_representative/';
            if ($conf['piwigo_db_version'] == "2.4")
            {
                $file_wo_ext['filename'] = "TN-" . $file_wo_ext['filename'];
                $output_dir = dirname($row['path']) . '/thumbnail/';
            }
            $in = $filename;
            $out = $output_dir.$file_wo_ext['filename'].'.'.$sync_options['output'];
            /* report it */
            $infos[] = $filename. ' poster: '.$out;

            if (!is_dir($output_dir) or !is_writable($output_dir))
            {
                $errors[] = "Directory ".$output_dir." doesn't exist or wrong permission";
            }
            else if ($sync_options['postersec'] and !$sync_options['simulate'])
            {
                if (isset($fileinfo['playtime_seconds']) and $sync_options['postersec'] > $fileinfo['playtime_seconds'])
                {
                    $errors[] = "Movie ". $filename ." is shorter than ". $sync_options['postersec'] ." secondes, fallback to ". (int)$fileinfo['playtime_seconds'] ." secondes";
                    $sync_options['postersec'] = (int)$fileinfo['playtime_seconds'];
                }
                $ffmpeg = "ffmpeg -itsoffset -".$sync_options['postersec']." -i ".$in." -vcodec mjpeg -vframes 1 -an -f rawvideo -y ".$out;
                if ($sync_options['output'] == "png")
                {
                    $ffmpeg = "ffmpeg -itsoffset -".$sync_options['postersec']." -i ".$in." -vcodec png -vframes 1 -an -f rawvideo -y ".$out;
                }
                //echo $ffmpeg;
                $log = system($ffmpeg, $retval);
                //$infos[] = $filename. ' poster : retval:'. $retval. ", log:". print_r($log, True);
                if($retval != 0 or !file_exists($out))
                {
                    $errors[] = "Error poster running ffmpeg, try it manually:\n<br/>". $ffmpeg;
                }
		else
		{
                    /* Update DB */
                    $query = "UPDATE ".IMAGES_TABLE." SET `representative_ext`='".$sync_options['output']."' WHERE `id`=".$row['id'].";";
                    pwg_query($query);

                    /* Delete any previous square or thumbnail or small images */
                    $idata = "_data/i/".dirname($row['path']).'/pwg_representative/';
                    $extensions = array('-th.jpg', '-sq.jpg', '-th.png', '-sq.png', '-sm.png', '-sm.png');
                    foreach ($extensions as $extension)
                    {
                        $ifile = $idata.$file_wo_ext['filename'].$extension;
                        if(is_file($ifile))
                        {
                            unlink($ifile);
                        }
                    }

                    /* Generate the overlay */
                    if($sync_options['posteroverlay'])
                    {
                        add_movie_frame($out);
                        $infos[] = $filename. ' overlay: '.$out;
                    }
		}
            }
        }

        /* Create multiple thumbnails */
        if ($sync_options['thumb'])
        {
            if (isset($fileinfo['playtime_seconds']) and isset($sync_options['thumbsec']) and isset($sync_options['thumbsize']))
            {
                /* Init value */
                $file_wo_ext = pathinfo($row['file']);
                if ($conf['piwigo_db_version'] == "2.4")
                {
                    $output_dir = dirname($row['path']) . '/thumbnail/';
                }

                if (!is_dir($output_dir) or !is_writable($output_dir))
                {
                    $errors[] = "Directory ".$output_dir." doesn't exist or wrong permission";
                }
                else if ($sync_options['thumbsec'] and !$sync_options['simulate'])
                {
                    for ($second=0; $second <= (int)$fileinfo['playtime_seconds']; $second+=$sync_options['thumbsec'])
                    {
                        $out = $output_dir.$file_wo_ext['filename']."-th_".$second.'.'.$sync_options['output'];
                        $infos[] = $filename. ' thumbnail: '.$second.' seconds '.$out;
                        /* Lets do it */
                        $ffmpeg = "ffmpeg -itsoffset -".$second." -i ".$in." -vcodec mjpeg -vframes 1 -an -f rawvideo -s ".$sync_options['thumbsize']." -y ".$out;
                        if ($sync_options['output'] == "png")
                        {
                            $ffmpeg = "ffmpeg -itsoffset -".$second." -i ".$in." -vcodec png -vframes 1 -an -f rawvideo -s ".$sync_options['thumbsize']." -y ".$out;
                        }
                        $log = system($ffmpeg, $retval);
                        //$infos[] = $filename. ' thumbnail : retval:'. $retval. ", log:". print_r($log, True);
                        if($retval != 0 or !file_exists($out))
                        {
                            $errors[] = "Error thumbnail running ffmpeg, try it manually:\n<br/>". $ffmpeg;
                        }
                    }
                }
            }
        }
    }
}

/***************
 *
 * End the sync work
 *
 */
