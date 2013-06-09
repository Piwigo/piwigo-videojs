<?php
/***********************************************
* File      :   admin_sync.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   4.06.2013
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

// Check the presence of the DB schema
$gpsdata = true;
$q = 'SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "'.IMAGES_TABLE.'" AND COLUMN_NAME = "lat" OR COLUMN_NAME = "lon"';
$result = pwg_db_fetch_array( pwg_query($q) );
if($result['nb'] != 2)
{
    $gpsdata = false;
}

// Geneate default value
$sync_options = array(
    'metadata'          => true,
    'thumb'             => true,
    'thumbsec'          => 1,
    'simulate'          => true,
    'cat_id'            => 0,
    'subcats_included'  => true,
    'sync_gps'          => $gpsdata,
);

if ( isset($_POST['submit']) and isset($_POST['thumbsec']) )
{
    // Override default value from the form
    $sync_options = array(
        'metadata'          => isset($_POST['metadata']),
        'thumb'             => isset($_POST['thumb']),
        'thumbsec'          => $_POST['thumbsec'],
        'simulate'          => isset($_POST['simulate']),
        'cat_id'            => isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0,
        'subcats_included'  => isset($_POST['subcats_included']),
        'sync_gps'          => $gpsdata,
    );

    if ( $sync_options['cat_id'] != 0 )
    {
        $query='
            SELECT id FROM '.CATEGORIES_TABLE.'
            WHERE ';
            if ( $sync_options['subcats_included'])
                $query .= 'uppercats REGEXP \'(^|,)'.$sync_options['cat_id'].'(,|$)\'';
            else
                $query .= 'id='.$sync_options['cat_id'];
        $cat_ids = array_from_query($query, 'id');
        $query="
            SELECT `id`, `file`, `path`
            FROM ".IMAGES_TABLE." INNER JOIN ".IMAGE_CATEGORY_TABLE." ON id=image_id
            WHERE (`file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv')
            AND category_id IN (".implode(',', $cat_ids).")
            GROUP BY id";
    }
    else
    {
        $query = "SELECT `id`, `file`, `path`
            FROM ".IMAGES_TABLE."
            WHERE `file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv' GROUP BY id";
    }

    // Init value for result table
    $videos = hash_from_query( $query, 'id');
    $datas = 0;
    $thumbs = 0;
    $errors = array();
    $infos = array();

    if (!$sync_options['sync_gps'])
    {
        $errors[] = "latitude and longitude disable because the require plugin is not present, eg: 'OpenStreetMap'.";
    }
    if (!is_file("/usr/bin/ffmpeg") and $sync_options['thumb'])
    {
	$errors[] = "Thumbnail creation disable because ffmpeg is not installed on the system, eg: '/usr/bin/ffmpeg'.";
	$sync_options['thumb'] = false;
    }
    if (!$sync_options['metadata'] and !$sync_options['thumb'])
    {
        $errors[] = "You ask me to do nothing, are you sure?";
    }

    // Get video infos with getID3 lib
    require_once(dirname(__FILE__) . '/../include/getid3/getid3.php');
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
                    $exif['filesize'] = $fileinfo['filesize'];
            }
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
                    $exif['lat'] = $fileinfo['tags']['quicktime']['gps_latitude'][0];
            }
            if (isset($fileinfo['tags']['quicktime']['gps_longitude'][0]) and $sync_options['sync_gps'])
            {
                    $exif['lon'] = $fileinfo['tags']['quicktime']['gps_longitude'][0];
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
                    $exif['DateTimeOriginal'] = substr($fileinfo['tags']['quicktime']['creation_date'][0], 1);
            }
            //print_r($exif);
            if (isset($exif) and $sync_options['metadata'])
            {
                $datas++;
                $infos[] = $filename. ' metadata: '.implode(",", array_keys($exif));
                if ($sync_options['metadata'] and !$sync_options['simulate'])
                {
                    $dbfields = explode(",", "filesize,width,height,lat,lon");
                    $query = "UPDATE ".IMAGES_TABLE." SET ".vjs_dbSet($dbfields, $exif).", `date_metadata_update`=CURDATE() WHERE `id`=".$row['id'].";";
                    pwg_query($query);
                }
            }

            $file_wo_ext = pathinfo($row['file']);
            $output_dir = dirname($row['path']) . '/pwg_representative/';
            $in = $filename;
            $out = $output_dir.$file_wo_ext['filename'].'.jpg';
            if ($sync_options['thumb'])
            {
                $thumbs++;
		$infos[] = $filename. ' thumbnail : '.$out;

		if (!is_dir($output_dir) or !is_writable($output_dir))
		{
			$errors[] = "Directory ".$output_dir." doesn't exist or wrong permission";
		}
                if ($sync_options['thumb'] and !$sync_options['simulate'])
                {
                    $ffmpeg = "/usr/bin/ffmpeg -itsoffset -".$sync_options['thumbsec']." -i ".$in." -vcodec mjpeg -vframes 1 -an -f rawvideo -y ".$out;
		    //echo $ffmpeg;
                    $log = system($ffmpeg, $retval);
                    /*$infos[] = $filename. ' thumbnail : '. $retval. " ". print_r($log, True);
		    if($retval != 0)
		    {
			$errors[] = "Error running ffmpeg, try it manually";
		    }*/
                    $query = "UPDATE ".IMAGES_TABLE." SET `representative_ext`='jpg' WHERE `id`=".$row['id'].";";
                    pwg_query($query);
		}
            }
        }
    }

    // Send sync result to template
    $template->assign('sync_errors', $errors );
    $template->assign('sync_infos', $infos );

    // Send result to templates
    $template->assign(
        'update_result',
        array(
            'NB_ELEMENTS_THUMB' => $thumbs,
            'NB_ELEMENTS_EXIF' => $datas,
            'NB_ELEMENTS_CANDIDATES' => count($videos),
            'NB_ERRORS' => count($errors),
    ));
}

// All videos with supported extensions
$SQL_VIDEOS = "(`file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv')";

// All videos with supported extensions by VideoJS
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE ".$SQL_VIDEOS.";";
list($nb_videos) = pwg_db_fetch_array( pwg_query($query) );

// All videos with supported extensions by VideoJS and thumb
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE `representative_ext` IS NOT NULL AND ".$SQL_VIDEOS.";";
list($nb_videos_thumb) = pwg_db_fetch_array( pwg_query($query) );

// All videos with supported extensions by VideoJS and with GPS data
if ($sync_options['sync_gps'])
{
    $query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE `lat` IS NOT NULL and `lon` IS NOT NULL AND ".$SQL_VIDEOS.";";
    list($nb_videos_geotagged) = pwg_db_fetch_array( pwg_query($query) );
}
else
{
    $nb_videos_geotagged = 0;
}

$query = 'SELECT id, CONCAT(name, IF(dir IS NULL, " (V)", "") ) AS name, uppercats, global_rank  FROM '.CATEGORIES_TABLE;
display_select_cat_wrapper($query,
                           array( $sync_options['cat_id'] ),
                           'categories',
                           false);

// Send value to templates
$template->assign(
        array(
            'SUBCATS_INCLUDED_CHECKED' => $sync_options['subcats_included'] ? 'checked="checked"' : '',
            'NB_VIDEOS' => $nb_videos,
            'NB_VIDEOS_GEOTAGGED' => $nb_videos_geotagged,
            'NB_VIDEOS_THUMB'   => $nb_videos_thumb,
        )
);

function vjs_dbSet($fields, $data = array())
{
    if (!$data) $data = &$_POST;
    $set='';
    foreach ($fields as $field)
    {
        if (isset($data[$field]))
        {
            //$set.="`$field`='".mysql_real_escape_string($data[$field])."', ";
            $set.="`$field`='".$data[$field]."', ";
        }
    }
    return substr($set, 0, -2);
}

?>
