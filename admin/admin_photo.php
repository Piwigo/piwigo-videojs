<?php
/***********************************************
* File      :   admin_photo.php
* Project   :   piwigo-videojs
* Descr     :   Video edit in admin photo panel
*
* Created   :   10.07.2013
*
* Copyright 2012-2025 <xbgmsharp@gmail.com>
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

// Check access and exit when user status is not ok
check_status(ACCESS_ADMINISTRATOR);

if (!isset($_GET['image_id']) or !isset($_GET['section']))
{
    die('Invalid data!');
}

check_input_parameter('image_id', $_GET, false, PATTERN_ID);

$admin_photo_base_url = get_root_url().'admin.php?page=photo-'.$_GET['image_id'];
$self_url = get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_photo.php&amp;image_id='.$_GET['image_id'];
$delete_url = get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_photo.php&amp;delete_extra=1&amp;image_id='.$_GET['image_id'].'&amp;pwg_token='.get_pwg_token();

global $template, $page, $conf, $prefixeTable;

include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
$tabsheet = new tabsheet();
$tabsheet->set_id('photo');
$tabsheet->select('videojs');
$tabsheet->assign();

$template->set_filenames(
  array(
    'plugin_admin_content' => dirname(__FILE__).'/admin_photo.tpl'
    )
  );

// Get image details if video type
$query = "SELECT * FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
$picture = pwg_db_fetch_assoc(pwg_query($query));

// Ensure we have an image path
if (!isset($picture['path'])) {
    die("Error reading file id: '". $_GET['image_id']."'");
}

// Delete the extra data
if (isset($_GET['delete_extra']) and $_GET['delete_extra'] == 1)
{
    check_pwg_token();
    vjs_begin_delete_elements(array($picture['id']));
    array_push( $page['infos'], 'Thumbnails and Subtitle and extra videos source deleted');
}

// Set the video orientation (database only, no action done on the video)
if (isset($_POST['videojs_rotate']) and isset($_POST['angle']))
{
    check_pwg_token();

    if (!is_numeric($_POST['angle']))
    {
        die('Invalid data!');
    }

    $rotation_code = pwg_image::get_rotation_code_from_angle($_POST['angle']);
    $query = "UPDATE ".IMAGES_TABLE." SET rotation='".$rotation_code."', `date_metadata_update`=CURDATE() WHERE `id`=".$picture['id'].";";
    pwg_query($query);

    // Delete previous derivatives
    delete_element_derivatives($picture);

    array_push($page['infos'], l10n('The photo was updated'));

    // Reload the picture with its new orientation
    $query = "SELECT * FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
    $picture = pwg_db_fetch_assoc(pwg_query($query));
}

// Get user's sync options
$sync_options = $conf['vjs_sync'];

// Sync metadata, posters and thumbnails as requested, share code
if (isset($_POST['vjs_sync']))
{
    check_pwg_token();

    $sync_options = vjs_sync_options_from_post($sync_options);
    $sync_options['subcats_included'] = false;

    $query = "SELECT * FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
    require_once(dirname(__FILE__).'/../include/function_sync.php');
    $page['errors'] = $errors;
    $page['warnings'] = $warnings;
    $page['infos'] = $infos;

    // Reload the picture, its poster may have changed
    $query = "SELECT * FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
    $picture = pwg_db_fetch_assoc(pwg_query($query));
}

// Fetch metadata from db
$exif = array();
$query = "SELECT * FROM ".$prefixeTable."image_videojs WHERE `id`=".$_GET['image_id'].";";
$result = pwg_query($query);
$videojs_metadata = pwg_db_fetch_assoc($result);
if (isset($videojs_metadata) and isset($videojs_metadata['metadata']))
{
    $video_metadata = unserialize($videojs_metadata['metadata']);
    //print_r($video_metadata);
    $exif = $video_metadata;
    // Add some value by human readable string
    if (isset($exif['width']) and isset($exif['height']))
    {
        $exif['Resolution'] = $exif['width'] ."x". $exif['height'];
    }
    include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
    isset($exif['rotation']) and $exif['rotation'] = pwg_image::get_rotation_angle_from_code($exif['rotation']) ."°";
    ksort($exif);
}

// Try to find multiple video sources
// global $logger;
$output_dir = dirname($picture['path']) . '/pwg_representative/';
$parts = pathinfo($picture['path']);
$extension = $parts['extension'];
$vjs_extensions = array('ogg', 'ogv', 'mp4', 'm4v', 'webm', 'webmv');
$files_ext = array_merge(array(), $vjs_extensions, array_map('strtoupper', $vjs_extensions) );
// Add the current file in array
$videossrc[] = embellish_url($picture['path']);
foreach ($files_ext as $file_ext) {
    $file = $output_dir.$parts['filename'].'.'.$file_ext;
    if (file_exists($file)){
        $videossrc[] = embellish_url($output_dir.$parts['filename'].'.'.$file_ext);
    }
}
//print_r($videossrc);
$infos['videoCount'] = count($videossrc);
$infos['videos'] = $videossrc;

/* Try to guess the poster extension */
$poster = '';
$extensions = array('jpg', 'jpeg', 'png', 'gif');
foreach ($extensions as $extension)
{
    /* Extension in lowercase */
    $ilcfile = $output_dir.$parts['filename'].'.'.strtolower($extension);
//    $logger->debug('photo: $ilcfile = '.$ilcfile);
    if (is_file($ilcfile))
    {
        $poster = $ilcfile;
//        $logger->debug('photo: $poster[] = '.$ilcfile);
        break;
    }
    
    /* Extension in uppercase */
    $iucfile = $output_dir.$parts['filename'].'.'.strtoupper($extension);
//    $logger->debug('photo: $iucfile = '.$iucfile);
    if (is_file($iucfile) and $representative_ext != $extension)
    {
        /* We have a poster, create query for updating the database */
        $poster = $iucfile;
//        $logger->debug('photo: $poster[] = '.$iucfile);
        break;
    }
}

// If none found, will display a question mark icon
if (strlen($poster) > 0)
{
    $poster = embellish_url($poster);
}
//print $poster;
$infos['poster'] = $poster;

/* Thumbnail videojs plugin */
$filematch = $output_dir.$parts['filename'].'-th_*';
$matches = glob($filematch);
$thumbnails = array();
$sort = array(); // A list of sort columns and their data to pass to array_multisort
if ( is_array ( $matches ) and !empty($matches) ) {
    foreach ( $matches as $filename) {
         $ext = explode("-th_", $filename);
         $second = explode(".", $ext[1]);
         $thumbnails[] = array(
                   'second' => $second[0],
                   'source' => embellish_url($filename)
                );
         $sort['second'][$second[0]] = $second[0];
    }
}
//print_r($thumbnails);
// Sort thumbnails by second
!empty($sort['second']) and array_multisort($sort['second'], SORT_ASC, $thumbnails);
$infos['thumbnailCount'] = count($thumbnails);
$infos['thumbnails'] = $thumbnails;

/* Try to find WebVTT */
$file = $output_dir.$parts['filename'].'.vtt';
file_exists($file) ? $subtitle = embellish_url(get_gallery_home_url() .$file) : $subtitle = null;
if (isset($subtitle))
{
    $infos['subtitle'] = $subtitle;
}

/*
$infos = array_merge(
                array(l10n('VIDEO_SRC') => count($videossrc)),
                array('videos' => $videossrc),
                array('poster' => $poster),
                array(l10n('SYNC_THUMB') => count($thumbnails)),
                array('thumbnails' => $thumbnails),
                array('Subtitle' => $subtitle)
            );
//print_r($infos); */

$template->assign(array(
    'IMAGE_ID'   => $_GET['image_id'],
    'PWG_TOKEN'  => get_pwg_token(),
    'F_ACTION'   => $self_url,
    'SYNC_OPTIONS' => vjs_sync_options_html($sync_options, false, true),
    'angles'     => array(
        array('value' =>   0, 'name' => l10n('0°')),
        array('value' =>  90, 'name' => l10n('90° right')),
        array('value' => 270, 'name' => l10n('90° left')),
        array('value' => 180, 'name' => l10n('180°')),
    ),
    'angle_selected' => pwg_image::get_rotation_angle_from_code($picture['rotation']),
    'DELETE_URL' => $delete_url,
    'TN_SRC'     => DerivativeImage::thumb_url($picture),
    'TITLE'      => render_element_name($picture),
    'EXIF'       => $exif,
    'INFOS'      => $infos,
));

$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
