<?php
/***********************************************
* File      :   admin_sync.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin sync panel
*
* Created   :   4.06.2013
*
* Copyright 2012-2018 <xbgmsharp@gmail.com>
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

// Generate default value
$sync_options = array(
    'mediainfo'         => 'mediainfo',
    'ffmpeg'            => 'ffmpeg',
    'exiftool'          => 'exiftool',
    'ffprobe'           => 'ffprobe',
    'metadata'          => true,
    'poster'            => true,
    'postersec'         => 4,
    'output'            => 'jpg',
    'posteroverlay'     => false,
    'posteroverwrite'   => true,
    'thumb'             => false,
    'thumbsec'          => 5,
    'thumbsize'         => "120x68",
    'simulate'          => true,
    'cat_id'            => 0,
    'subcats_included'  => true,
);

// Merge default value with user configuration
if (isset($conf['vjs_sync']))
{
    $sync_options = array_merge(unserialize($conf['vjs_sync']), $sync_options);
}

if(isset($_POST['mediainfo']) && isset($_POST['ffmpeg'])) {
    // Override default value from the form
    $sync_options_form = array(
	'mediainfo'         => $_POST['mediainfo'],
	'ffmpeg'            => $_POST['ffmpeg'],
	'exiftool'          => $_POST['exiftool'],
	'ffprobe'           => $_POST['ffprobe'],
        'metadata'          => isset($_POST['metadata']),
        'poster'            => isset($_POST['poster']),
        'postersec'         => $_POST['postersec'],
        'output'            => $_POST['output'],
        'posteroverlay'     => isset($_POST['posteroverlay']),
        'posteroverwrite'   => isset($_POST['posteroverwrite']),
        'thumb'             => isset($_POST['thumb']),
        'thumbsec'          => $_POST['thumbsec'],
        'thumbsize'         => $_POST['thumbsize'],
        'simulate'          => isset($_POST['simulate']),
        'cat_id'            => isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0,
        'subcats_included'  => isset($_POST['subcats_included']),
    );

    // Merge default value with user configuration
    $sync_options = array_merge(unserialize($conf['vjs_sync']), $sync_options_form);

    // Update config to DB
    conf_update_param('vjs_sync', serialize($sync_options));
}

// Check dependencies
$warnings = array();

// Do the Check dependencies, MediaInfo & FFMPEG, share with batch manager & photo edit & admin sync
include(dirname(__FILE__).'/../include/function_dependencies.php');

if ($sync_options['posteroverlay'] and !function_exists('gd_info'))
{
	$warnings[] = "GD library is missing to add overlay movie frame";
}
if ($sync_options['metadata'] and $sync_binaries['mediainfo'] and !class_exists('SimpleXMLElement'))
{
	$warnings[] = "XML library is missing to use mediainfo";
}

$template->assign('sync_warnings', $warnings);
$template->assign($sync_options); // send config value to template
$template->assign('sync_options', $sync_options); // send config value to template
$template->assign('sync_binaries', $sync_binaries); // send external tools binary to template

if ( isset($_POST['submit']) and isset($_POST['postersec']) )
{
    // Filter on existing poster
    $OVERWRITE = "";
    if (!$sync_options['posteroverwrite'])
    {
        $OVERWRITE = " AND `representative_ext` IS NULL ";
    }

    // Filter on selected ablum
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
            WHERE ". SQL_VIDEOS ." ". $OVERWRITE ."
            AND category_id IN (".implode(',', $cat_ids).")
            GROUP BY id";
    }
    else
    {
        $query = "SELECT `id`, `file`, `path`
            FROM ".IMAGES_TABLE."
            WHERE ". SQL_VIDEOS ." ". $OVERWRITE .";";
    }

    // Do the work, share with batch manager
    require_once(dirname(__FILE__).'/../include/function_sync2.php');

    // Send sync result to template
    $template->assign('sync_errors', $errors );
    $template->assign('sync_warnings', $warnings );
    $template->assign('sync_infos', $infos );

    // Send result to templates
    $template->assign(
        'update_result',
        array(
            'NB_ELEMENTS_POSTER'        => $posters,
            'NB_ELEMENTS_THUMB'         => $thumbs,
            'NB_ELEMENTS_EXIF'          => $metadata,
            'NB_ELEMENTS_CANDIDATES'    => $videos,
            'NB_ERRORS'                 => count($errors),
            'NB_WARNINGS'               => count($warnings),
    ));
}

/* Get statistics */
// All videos with supported extensions by VideoJS
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS.";";
list($nb_videos) = pwg_db_fetch_row( pwg_query($query) );

// All videos with supported extensions by VideoJS and thumb
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE `representative_ext` IS NOT NULL AND ".SQL_VIDEOS.";";
list($nb_videos_thumb) = pwg_db_fetch_row( pwg_query($query) );

// All videos with supported extensions by VideoJS and with GPS data
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE `latitude` IS NOT NULL and `longitude` IS NOT NULL AND ".SQL_VIDEOS.";";
list($nb_videos_geotagged) = pwg_db_fetch_row( pwg_query($query) );


if (isset($_POST['cat_id']) and is_numeric($_POST['cat_id']))
{
	$cat_selected = array($sync_options['cat_id']);
}
else
{
	$cat_selected = array();
}
$query = 'SELECT id, CONCAT(name, IF(dir IS NULL, " (V)", "") ) AS name, uppercats, global_rank  FROM '.CATEGORIES_TABLE;
display_select_cat_wrapper($query,
                           $cat_selected,
                           'categories',
                           false);

// send value to template
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
