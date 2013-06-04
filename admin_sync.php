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

// Geneate default value
$sync_options = array(
    'metadata' => true,
    'thumb' => true,
    'thumbsec' => 1,
    'simulate' => true,
    'cat_id' => 0,
    'subcats_included' => true,

);

if ( isset($_POST['submit']) and isset($_POST['thumbsec']) )
{
    // Override default value from the form
    $sync_options = array(
        'metadata' => isset($_POST['metadata']),
        'thumb' => isset($_POST['thumb']),
        'thumbsec' => isset($_POST['thumbsec']),
        'simulate' => isset($_POST['simulate']),
        'cat_id' => isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0,
        'subcats_included' => isset($_POST['subcats_included']),
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
            // Get video infos with getID3 lib
            require_once(dirname(__FILE__) . '/include/getid3/getid3.php');
            $getID3 = new getID3;
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
            if (isset($fileinfo['tags']['quicktime']['gps_latitude'][0]))
            {
                    $exif['lat'] = $fileinfo['tags']['quicktime']['gps_latitude'][0];
            }
            if (isset($fileinfo['tags']['quicktime']['gps_longitude'][0]))
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
            if (isset($exif))
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
            if (is_dir($output_dir))
            {
                $thumbs++;
                $infos[] = $filename. ' thumbnail : '.$out;
                if ($sync_options['thumb'] and !$sync_options['simulate'])
                {
                    $ffmepg = "/usr/bin/ffmpeg -itsoffset -".$sync_options['thumbsec']." -i ".$in." -vcodec mjpeg -vframes 1 -an -f rawvideo ".$out;
                    $log = system($ffmepg, $retval);
                    //$infos[] = $filename. ' thumbnail : '. $retval. " ". print_r($log, True);
                    $query = "UPDATE ".IMAGES_TABLE." SET `representative_ext`='jpg' WHERE `id`=".$row['id'].";";
                    pwg_query($query);
                }
            }
        }
    }
    $template->assign('sync_errors', $errors );
    $template->assign('sync_infos', $infos );

    $template->assign(
        'update_result',
        array(
            'NB_ELEMENTS_THUMB' => $thumbs,
            'NB_ELEMENTS_EXIF' => $datas,
            'NB_ELEMENTS_CANDIDATES' => count($videos),
            'NB_ERRORS' => count($errors),
    ));
}

// All videos with supported extensions by VideoJS
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE `file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv'";
list($nb_videos) = pwg_db_fetch_array( pwg_query($query) );

// All videos with GPS data
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE `lat` IS NOT NULL and `lon` IS NOT NULL AND (`file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv')";
list($nb_videos_geotagged) = pwg_db_fetch_array( pwg_query($query) );

$query = 'SELECT id, CONCAT(name, IF(dir IS NULL, " (V)", "") ) AS name, uppercats, global_rank  FROM '.CATEGORIES_TABLE;
display_select_cat_wrapper($query,
                           array( $sync_options['cat_id'] ),
                           'categories',
                           false);
$template->assign(
        array(
            'SUBCATS_INCLUDED_CHECKED' => $sync_options['subcats_included'] ? 'checked="checked"' : '',
            'NB_VIDEOS' => $nb_videos,
            'NB_VIDEOS_GEOTAGGED' => $nb_videos_geotagged,
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
                    $set.="`$field`='".mysql_real_escape_string($data[$field])."', ";
            }
    }
    return substr($set, 0, -2);
}

?>
