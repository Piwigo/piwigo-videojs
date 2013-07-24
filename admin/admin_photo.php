<?php
/***********************************************
* File      :   admin_photo.php
* Project   :   piwigo-videojs
* Descr     :   Video edit in photo panel
*
* Created   :   10.07.2013
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

check_input_parameter('image_id', $_GET, false, PATTERN_ID);

$admin_photo_base_url = get_root_url().'admin.php?page=photo-'.$_GET['image_id'];
//$self_url = VIDEOJS_ADMIN.'-photo&amp;image_id='.$_GET['image_id'];

global $template, $page, $conf;

echo "admin_photo";

include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
$tabsheet = new tabsheet();
$tabsheet->set_id('photo');
$tabsheet->select('videojs');
$tabsheet->assign();

// +-----------------------------------------------------------------------+
// | Picture infos                                                         |
// +-----------------------------------------------------------------------+
$query = '
SELECT *
  FROM '.IMAGES_TABLE.'
  WHERE id = '.$_GET['image_id'].'
;';
$picture = pwg_db_fetch_assoc(pwg_query($query));

$template->assign(array(
  'F_ACTION' => "/piwigo/admin.php?page=plugin-videojs-photo&image_id=23",
//  'VJSVIDEO' => $vjsvideo,
  'TN_SRC' => DerivativeImage::thumb_url($picture).'?'.time(),
  'TITLE' => render_element_name($picture),
));

$template->set_filename('gvideo_content', dirname(__FILE__).'/template/photo.tpl');


// Hook to show details in the tab of photo edit
add_event_handler('loc_begin_element_set_global', 'vjs_set_template_data');
function vjs_set_template_data() {
	global $template,$lang;

	load_language('plugin.lang', dirname(__FILE__).'/');

	include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');

	$angles = array (
		array('value' => 270, 'name' => l10n('90° right')),
		array('value' =>  90, 'name' => l10n('90° left')),
		array('value' => 180, 'name' => l10n('180°'))
	);

	$template->assign(array(
	  'RI_PWG_TOKEN' => get_pwg_token(),
	  'angles' => $angles,
	  'angle_value' => 90,
	  'library' => pwg_image::get_library()
	));
	$template->set_filename('videojs', realpath(dirname(__FILE__).'/admin_image.tpl'));
	$template->append('element_set_global_plugins_actions', array(
	  'ID' => 'videojs',
	  'NAME' => l10n('Video'),
	  'CONTENT' => $template->parse('videojs', true))
	);
}

// Hook to do the action in the tab of photo edit
add_event_handler('element_set_global_action', 'vjs_element_action', 55, 2);
function vjs_element_action($action, $collection) {
	if ($action == 'videojs') {
	  add_event_handler('get_derivative_url', 'vjs_force_refresh', EVENT_HANDLER_PRIORITY_NEUTRAL, 4);
	}
}