<?php
/***********************************************
* File      :   admin_photo.php
* Project   :   piwigo-videojs
* Descr     :   Video edit in photo panel
*
* Created   :   10.07.2013
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

// Check access and exit when user status is not ok
check_status(ACCESS_ADMINISTRATOR);

if (!isset($_GET['image_id']) or !isset($_GET['section']))
{
	die('Invalid data!');
}

check_input_parameter('image_id', $_GET, false, PATTERN_ID);

$admin_photo_base_url = get_root_url().'admin.php?page=photo-'.$_GET['image_id'];
$self_url = get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_photo.php&amp;image_id='.$_GET['image_id'];
$sync_url = get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_photo.php&amp;sync_metadata=1&amp;image_id='.$_GET['image_id'];

load_language('plugin.lang', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
load_language('plugin.lang', VIDEOJS_PATH);

global $template, $page, $conf;

if (isset($_POST['submit']))
{
	check_pwg_token();
}

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

// Override default value from configuration
// Override default value from configuration
if (isset($conf['vjs_sync']))
{
    $sync_options = unserialize($conf['vjs_sync']);
}
// Do the Check dependencies, MediaInfo & FFMPEG, share with batch manager & photo edit & admin sync
require_once(dirname(__FILE__).'/../include/function_dependencies.php');

$query = "SELECT * FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
$picture = pwg_db_fetch_assoc(pwg_query($query));

//if (!$sync_options['metadata'] or !isset($picture['path'])) {
if (!isset($picture['path'])) {
	//print_r($sync_options);
	die("Mediainfo error reading file id: '". $_GET['image_id']."'");
}

$filename = $picture['path'];
// Get the metadata video information
include_once(dirname(__FILE__).'/../include/mediainfo.php');
if (isset($exif))
{
	if (isset($_GET['sync_metadata']) and $_GET['sync_metadata'] == 1)
	{
		$dbfields = explode(",", "filesize,width,height,latitude,longitude,date_creation,rotation");
		$query = "UPDATE ".IMAGES_TABLE." SET ".vjs_dbSet($dbfields, $exif).", `date_metadata_update`=CURDATE() WHERE `id`=".$_GET['image_id'].";";
		pwg_query($query);
		array_push( $page['infos'], ' metadata: '.implode(",", $dbfields));
	}
	// replace some value by human readable string
	$exif['name'] = (string)$general->CompleteName;
	$exif['filename'] = (string)$general->FileName;
	$exif['filesize'] = (string)$general->FileSize_String;
	$exif['duration'] = (string)$general->Duration_String;
	$exif['bitrate'] = (string)$video->BitRate_String;
	$exif['sampling_rate'] = (string)$audio->SamplingRate_String;
	ksort($exif);
}

// Try to guess the poster extension
$parts = pathinfo($picture['path']);
$poster = vjs_get_poster_file( Array(
	(string)$general->FolderName."/pwg_representative/".$parts['filename'].".jpg" =>
		get_gallery_home_url() . $parts['dirname'] . "/pwg_representative/".$parts['filename'].".jpg",
	(string)$general->FolderName."/pwg_representative/".$parts['filename'].".png" =>
		get_gallery_home_url() . $parts['dirname'] . "/pwg_representative/".$parts['filename'].".png",
));
// If none found, it create an strpos error
if (strlen($poster) > 0) { $poster = embellish_url($poster); }
//print $poster;

// Try to find multiple video source
$extension = $parts['extension'];
$vjs_extensions = array('ogg', 'ogv', 'mp4', 'm4v', 'webm', 'webmv');
$files_ext = array_merge(array(), $vjs_extensions, array_map('strtoupper', $vjs_extensions) );
// Add the current file in array
$videos[] = array(
			'src' => embellish_url(get_gallery_home_url() . $picture['path']),
			'ext' => $extension,
		);
foreach ($files_ext as $file_ext) {
	$file = (string)$general->FolderName."/pwg_representative/".$parts['filename'].".".$file_ext;
	if (file_exists($file)){
		array_push($videos,
			   array (
				'src' => embellish_url(
						  get_gallery_home_url() . $parts['dirname'] . "/pwg_representative/".$parts['filename'].".".$file_ext
						 ),
				'ext' => vjs_get_mimetype_from_ext($file_ext)
				)
			  );
	}
}
//print_r($videos);

$filematch = $parts['dirname']."/pwg_representative/".$parts['filename']."-th_*";
$matches = glob($filematch);
$thumbnails = array();
if ( is_array ( $matches ) ) {
	foreach ( $matches as $filename) {
		 $ext = explode("-th_", $filename);
		 $second = explode(".", $ext[1]);
		 // ./galleries/videos/pwg_representative/trailer_480p-th_0.jpg
		 //echo "$filename second " . $second[0]. "\n";
		 $thumbnails[] = array(
				   'second' => $second[0],
				   'source' => embellish_url(get_gallery_home_url() . $filename)
				);
	}
}
//print_r($thumbnails);

$infos = array_merge(
				array('Poster' => $poster),
				array('Videos source' => count($videos)),
				array('videos' => $videos),
				array('Thumbnails' => count($thumbnails)),
				array('thumbnails' => $thumbnails)
				);
//print_r($infos);

$template->assign(array(
	'PWG_TOKEN' => get_pwg_token(),
	'F_ACTION' => $self_url,
	'SYNC_URL' => $sync_url,
	'TN_SRC' => DerivativeImage::thumb_url($picture).'?'.time(),
	'TITLE' => render_element_name($picture),
	'EXIF' => $exif,
	'INFOS' => $infos,
));

$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
