<?php
/***********************************************
* File      :   admin_boot.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   6.06.2013
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

// Videos definition and helpers, shared with the sync and the upload hook
include_once(dirname(__FILE__).'/../include/function_common.php');

// Batch_manager support
include_once(dirname(__FILE__).'/admin_batchmanager.php');

// Hook to add a photo edit tab in photo edit
add_event_handler('tabsheet_before_select','vjs_add_tab', 55, 2);
function vjs_add_tab($sheets, $id)
{
	if ($id == 'photo')
	{
		$query = "SELECT id FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
		$result = pwg_query($query);
		if (!pwg_db_num_rows($result)) return $sheets;

		$sheets['videojs'] = array(
			'caption' => 'VideoJS',
			'url' => get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_photo.php&amp;image_id='.$_GET['image_id'],
			);

		// The VideoJS tab replaces Rotate and Center of Interest for videos;
		// other tabs (such as Update from Photo Update) are left untouched
		unset($sheets['coi'], $sheets['rotate']);
	}

	return $sheets;
}

// Hook to delete extra elements created by the plugin
// Does apply to batch manager and photo-edit pages
add_event_handler('begin_delete_elements', 'vjs_begin_delete_elements');
?>
