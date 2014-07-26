<?php
/***********************************************
* File      :   admin_boot.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   6.06.2013
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

// Define all videos with supported extensions
define('SQL_VIDEOS', "(LOWER(`file`) LIKE '%.ogg' OR LOWER(`file`) LIKE '%.ogv' OR
                LOWER(`file`) LIKE '%.mp4' OR LOWER(`file`) LIKE '%.m4v' OR
                LOWER(`file`) LIKE '%.webm' OR LOWER(`file`) LIKE '%.webmv')");

// Hook to add an admin config page
add_event_handler('get_admin_plugin_menu_links', 'vjs_admin_menu');
function vjs_admin_menu($menu)
{
	array_push($menu,
		array(
			'NAME' => 'VideoJS',
			'URL'  => get_admin_plugin_menu_link(dirname(__FILE__).'/admin.php')
		)
	);
	return $menu;
}

// Batch_manager support
include_once(dirname(__FILE__).'/admin_batchmanager.php');

// Hook to add an photo edit tab in photo edit
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

		unset($sheets['coi'], $sheets['update']);
		unset($sheets['rotate'], $sheets['update']);
	}

	return $sheets;
}

?>
