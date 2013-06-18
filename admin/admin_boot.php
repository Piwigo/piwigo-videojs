<?php
/***********************************************
* File      :   admin_boot.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   6.06.2013
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

// Hook to add a new filter in the batch mode
add_event_handler('get_batch_manager_prefilters', 'vjs_get_batch_manager_prefilters');
function vjs_get_batch_manager_prefilters($prefilters)
{
	$prefilters[] = array('ID' => 'videojs0', 'NAME' => l10n('All videos'));
	$prefilters[] = array('ID' => 'videojs1', 'NAME' => l10n('All videos with poster'));
	$prefilters[] = array('ID' => 'videojs2', 'NAME' => l10n('All videos without poster'));
	return $prefilters;
}

// Hook to perfom the filter in the batch mode
add_event_handler('perform_batch_manager_prefilters', 'vjs_perform_batch_manager_prefilters', 50, 2);
function vjs_perform_batch_manager_prefilters($filter_sets, $prefilter)
{
	// All videos with supported extensions
	$SQL_VIDEOS = "(`file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv')";

	if ($prefilter==="videojs0")
		$filter = "";
	else if ($prefilter==="videojs1")
		$filter = "AND `representative_ext` IS NOT NULL";
	else if ($prefilter==="videojs2")
		$filter = "AND `representative_ext` IS NULL";

	if ( isset($filter) )
	{
		$query = "SELECT id FROM ".IMAGES_TABLE." WHERE ".$SQL_VIDEOS." ".$filter;
		$filter_sets[] = array_from_query($query, 'id');
	}
	return $filter_sets;
}

// Hook to show action when selected
add_event_handler('loc_end_element_set_global', 'vjs_loc_end_element_set_global');
function vjs_loc_end_element_set_global()
{
	global $template;
	$template->append('element_set_global_plugins_actions',
		array('ID' => 'videojs', 'NAME'=>l10n('Videos'), 'CONTENT' => '
    <ul>
      <li>
	<label><input type="checkbox" name="vjs_metadata" value="1" checked="checked" /> filesize, width, height, latitude, longitude</label>
	<br/><small>Will overwrite the information in the database with the metadata from the video.</small>
	<br/><small><strong>Support of latitude, longitude required <a href="http://piwigo.org/ext/extension_view.php?eid=701" target="_blanck">\'OpenStreetMap\'</a> or \'RV Maps & Earth\' plugin.</strong></small>
      </li>
      <li>
	<label><input type="checkbox" name="vjs_thumb" value="1" checked="checked" /> Create thumbnail at position in second:</label>
	<!-- <input type="range" name="vjs_thumbsec" value="4" min="0" max="60" step="1"/> -->
	<input type="text" name="vjs_thumbsec" value="4" size="2" required/>
	<br/><small>Create a thumbnail from the video at specify position, it will overwrite any existing poster.</small>
      </li>
      <li>
	<label><span class="property">Output format : </span></label>
	<label><input type="radio" name="vjs_thumbouput" value="jpg" checked="checked"/> JPG</label>
	<label><input type="radio" name="vjs_thumbouput" value="png" /> PNG</label>
	<br/><small>Select the output format for the thumbnail</small>
      </li>
    </ul>
'));
}

// Hook to perform the action on in global mode
add_event_handler('element_set_global_action', 'vjs_element_set_global_action', 50, 2);
function vjs_element_set_global_action($action, $collection)
{
	if ($action!=="videojs")
		return;

	global $page;

	$query = "SELECT `id`, `file`, `path`
			FROM ".IMAGES_TABLE."
			WHERE (`file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv')
			AND id IN (".implode(',',$collection).")";

	// Override default value from the form
	$sync_options = array(
		'metadata' 	=> isset($_POST['vjs_metadata']),
		'thumb' 	=> isset($_POST['vjs_thumb']),
		'thumbsec' 	=> $_POST['vjs_thumbsec'],
		'thumbouput'    => $_POST['vjs_thumbouput'],
		'simulate' 	=> false,
		'sync_gps' 	=> true,
	);

	// Do the work, share with batch manager
	require_once(dirname(__FILE__).'/../include/function_sync.php');

	$page['errors'] = $errors;
	$page['infos'] = $infos;
}

// Hook to perform the action on in single mode
add_event_handler('loc_begin_element_set_unit', 'vjs_loc_begin_element_set_unit');
function vjs_loc_begin_element_set_unit()
{
	global $page;
	
	if (!isset($_POST['submit']))
	      return;

	$collection = explode(',', $_POST['element_ids']);
	foreach ($collection as $id)
	{
		if (!isset($_POST['thumbsec-'.$id]))
			return

		// Override default value from the form
		$sync_options = array(
			'metadata'	=> isset($_POST['vjs_metadata-'.$id]),
			'thumb'		=> isset($_POST['vjs_thumb-'.$id]),
			'thumbsec'	=> $_POST['vjs_thumbsec-'.$id],
			'thumbouput'    => $_POST['vjs_thumbouput-'.$id],
			'simulate'	=> false,
			'sync_gps'	=> true,
		);

		$query = "SELECT `id`, `file`, `path`
				FROM ".IMAGES_TABLE."
				WHERE (`file` LIKE '%.ogg' OR `file` LIKE '%.mp4' OR `file` LIKE '%.m4v' OR `file` LIKE '%.ogv' OR `file` LIKE '%.webm' OR `file` LIKE '%.webmv')
				AND `id`='".$id."';";

		// Do the work, share with batch manager
		include(dirname(__FILE__).'/../include/function_sync.php');

		$page['errors'] = array_merge($page['errors'], $errors);
		$page['infos'] = array_merge($page['infos'], $infos);
	}
}

// Hoook for batch manager in single mode
add_event_handler('loc_end_element_set_unit', 'vjs_loc_end_element_set_unit');
function vjs_loc_end_element_set_unit()
{
	global $template, $conf, $page, $is_category, $category_info;
	$template->set_prefilter('batch_manager_unit', 'vjs_prefilter_batch_manager_unit');
}

function vjs_prefilter_batch_manager_unit($content)
{
	$needle = '</table>';
	$pos = strpos($content, $needle);
	if ($pos!==false)
	{
		$add = '<tr><td><strong>{\'VideoJS\'|@translate}</strong></td>
		  <td>
		    <label><input type="checkbox" name="vjs_metadata-{$element.id}" value="1" checked="checked" /> filesize, width, height, latitude, longitude</label>
		    <br/><small>Will overwrite the information in the database with the metadata from the video.</small>
		    <br/><small><strong>Support of latitude, longitude required <a href="http://piwigo.org/ext/extension_view.php?eid=701" target="_blanck">\'OpenStreetMap\'</a> or \'RV Maps & Earth\' plugin.</strong></small>
		    <br/>
		    <label><input type="checkbox" name="vjs_thumb-{$element.id}" value="1" checked="checked" /> Create thumbnail at position in second:</label>
		    <!-- <input type="range" name="vjs_thumbsec" value="4" min="0" max="60" step="1"/> -->
		    <input type="text" name="vjs_thumbsec-{$element.id}" value="4" size="2" required/>
		    <br/><small>Create a thumbnail from the video at specify position, it will overwrite any existing poster.</small>
		    <br/>
		    <label><span class="property">Output format : </span></label>
		    <label><input type="radio" name="vjs_thumbouput" value="jpg" checked="checked"/> JPG</label>
		    <label><input type="radio" name="vjs_thumbouput" value="png" /> PNG</label>
		    <br/><small>Select the output format for the thumbnail</small>
		    <br/>
		  </td>
		</tr>';
		$content = substr_replace($content, $add, $pos, 0);
	}
	return $content;
}

?>
