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
    'metadata'          => true,
    'thumb'             => true,
    'thumbsec'          => 1,
    'thumbouput'        => 'jpg',
    'thumboverlay'      => false,
    'simulate'          => true,
    'cat_id'            => 0,
    'subcats_included'  => true,
    'sync_gps'          => true,
);

if ( isset($_POST['submit']) and isset($_POST['thumbsec']) )
{
    // Override default value from the form
    $sync_options = array(
        'metadata'          => isset($_POST['metadata']),
        'thumb'             => isset($_POST['thumb']),
        'thumbsec'          => $_POST['thumbsec'],
        'thumbouput'        => $_POST['thumbouput'],
        'thumboverlay'      => isset($_POST['thumboverlay']),
        'simulate'          => isset($_POST['simulate']),
        'cat_id'            => isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0,
        'subcats_included'  => isset($_POST['subcats_included']),
        'sync_gps'          => true,
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

    // Do the work, share with batch manager
    require_once(dirname(__FILE__).'/../include/function_sync.php');

    // Send sync result to template
    $template->assign('sync_errors', $errors );
    $template->assign('sync_infos', $infos );

    // Send result to templates
    $template->assign(
        'update_result',
        array(
            'NB_ELEMENTS_THUMB' => $thumbs,
            'NB_ELEMENTS_EXIF' => $metadata,
            'NB_ELEMENTS_CANDIDATES' => $videos,
            'NB_ERRORS' => count($errors),
    ));
}

// Check the presence of the DB schema
$sync_options['sync_gps'] = true;
$q = 'SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "'.IMAGES_TABLE.'" AND COLUMN_NAME = "lat" OR COLUMN_NAME = "lon"';
$result = pwg_db_fetch_array( pwg_query($q) );
if($result['nb'] != 2)
{
    $sync_options['sync_gps'] = false;
}

/* Get statistics */
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
            'SUBCATS_INCLUDED_CHECKED'  => $sync_options['subcats_included'] ? 'checked="checked"' : '',
            'NB_VIDEOS'                 => $nb_videos,
            'NB_VIDEOS_GEOTAGGED'       => $nb_videos_geotagged,
            'NB_VIDEOS_THUMB'           => $nb_videos_thumb,
            'VIDEOJS_PATH'              => VIDEOJS_PATH,
        )
);

?>
