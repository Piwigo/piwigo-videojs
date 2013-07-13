<?php
/***********************************************
* File      :   function_sync2.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   9.07.2013
*
* Copyright 2012-2013 <xbgmsharp@gmail.com>
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

/*
if ($sync_options['metadata'])
{
    $output = trim(shell_exec('type -P mediainfo')); // Does it works on Windows
    if (empty($output))
    {
        $warnings[] = "Metadata parsing disable because MediaInfo is not installed on the system, eg: '/usr/bin/mediainfo'.";
        $sync_options['metadata'] = false;
    }
}
*/

if (!$sync_options['sync_gps'])
{
    $warnings[] = "latitude and longitude disable because the require plugin is not present, eg: 'OpenStreetMap'.";
}

/*
if ($sync_options['poster'] or $sync_options['thumb'])
{
    $output = trim(shell_exec('type -P ffmpeg')); // Does it works on Windows
    if (empty($output))
    {
        $warnings[] = "Poster creation disable because FFmpeg is not installed on the system, eg: '/usr/bin/ffmpeg'.";
        $sync_options['poster'] = false;
        $sync_options['thumb'] = false;
    }
}
*/

if (!$sync_options['metadata'] and !$sync_options['poster'] and !$sync_options['thumb'])
{
    $errors[] = "You ask me to do nothing, are you sure?";
}

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
        $exif = array();
        include("mediainfo.php");
        //print_r($exif);
        if (isset($exif) and $sync_options['metadata'])
        {
            $metadata++;
            $infos[] = $filename. ' metadata: '.implode(",", array_keys($exif));
            //$infos[] = $filename. ' metadata: '.count($exif);
            if ($sync_options['metadata'] and !$sync_options['simulate'])
            {
                $dbfields = explode(",", "filesize,width,height,lat,lon,date_creation,rotation");
                $query = "UPDATE ".IMAGES_TABLE." SET ".vjs_dbSet($dbfields, $exif).", `date_metadata_update`=CURDATE() WHERE `id`=".$row['id'].";";
                pwg_query($query);

                //$dbfields = explode(",", "format,type,duration,overall_bit_rate,model,make,display_aspect_ratio,width,height,frame_rate,channel,sampling_rate");
                //$query = "UPDATE '".$prefixeTable."image_videojs' SET ".vjs_dbSet($dbfields, $exif).", `date_metadata_update`=CURDATE() WHERE `id`=".$row['id'].";";
                //pwg_query($query);
            }
        }

        /* Create poster */
        if ($sync_options['poster'])
        {
            $thumbs++;
            /* Init value */
            $file_wo_ext = pathinfo($row['file']);
            $output_dir = dirname($row['path']) . '/pwg_representative/';
            $in = $filename;
            $out = $output_dir.$file_wo_ext['filename'].'.'.$sync_options['output'];
            /* report it */
            $infos[] = $filename. ' poster: '.$out;

            if (!is_dir($output_dir))
            {
                mkdir($output_dir);
            }
            if (!is_writable($output_dir))
            {
                $errors[] = "Directory ".$output_dir." has wrong permission";
            }
            else if ($sync_options['postersec'] and !$sync_options['simulate'])
            {
                if (isset($exif['playtime_seconds']) and $sync_options['postersec'] > $exif['playtime_seconds'])
                {
                    $errors[] = "Movie ". $filename ." is shorter than ". $sync_options['postersec'] ." secondes, fallback to ". $exif['playtime_seconds'] ." secondes";
                    $sync_options['postersec'] = (int)$exif['playtime_seconds'];
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
            if (isset($exif['playtime_seconds']) and isset($sync_options['thumbsec']) and isset($sync_options['thumbsize']))
            {
                /* Init value */
                $file_wo_ext = pathinfo($row['file']);
                $output_dir = dirname($row['path']) . '/pwg_representative/';

                if (!is_dir($output_dir) or !is_writable($output_dir))
                {
                    $errors[] = "Directory ".$output_dir." doesn't exist or wrong permission";
                }
                else if ($sync_options['thumbsec'] and !$sync_options['simulate'])
                {
                    $in = $filename;
                    for ($second=0; $second <= $exif['playtime_seconds']; $second+=$sync_options['thumbsec'])
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
        } /* End thumbnail */
    }
}

/***************
 *
 * End the sync work
 *
 */
