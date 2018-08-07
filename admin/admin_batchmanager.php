<?php
/***********************************************
* File      :   admin_batchmanager.php
* Project   :   piwigo-videojs
* Descr     :   handle batch manager
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
	if ($prefilter==="videojs0")
		$filter = "";
	else if ($prefilter==="videojs1")
		$filter = "AND `representative_ext` IS NOT NULL";
	else if ($prefilter==="videojs2")
		$filter = "AND `representative_ext` IS NULL";

	if ( isset($filter) )
	{
		$query = "SELECT id FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." ".$filter;
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
    <legend>Metadata</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="vjs_metadata" value="1" checked="checked" /> filesize, width, height, latitude, longitude, date_creation, rotation</label>
	<br/><small>Will overwrite the information in the database with the metadata from the video.</small>
	<br/><small><strong>Require <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">\'MediaInfo\' or \'ffprobe\' or \'Exiftool\'</a> to be install.</strong></small>
      </li>
    </ul>
    <legend>Poster</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="vjs_poster" value="1" checked="checked" /> Create a poster at position in second:</label>
	<!-- <input type="range" name="vjs_postersec" value="4" min="0" max="60" step="1"/> -->
	<input type="text" name="vjs_postersec" value="4" size="2" required/>
	<br/><small>Create a poster from the video at specify position.</small>
	<br/><small><strong>Require <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">\'FFmpeg\'</a> to be install.</strong></small>
      </li>
      <li>
	<label><input type="checkbox" name="vjs_posteroverwrite" value="1" checked="checked"> Overwrite existing posters</label>
	<br/><small>Overwrite existing thumbnails with new ones. If uncheck it should only run for newly added video.</small>
      </li>
      <li>
	<label><span class="property">Output format : </span></label>
	<label><input type="radio" name="vjs_output" value="jpg" checked="checked"/> JPG</label>
	<label><input type="radio" name="vjs_output" value="png" /> PNG</label>
	<br/><small>Select the output format for the poster and thumbnail.</small>
      </li>
      <li>
	<label><input type="checkbox" name="vjs_posteroverlay" value="1" /> Add film effect</label>
	<br/><small>Apply an overlay on the poster creation.</small>
      </li>
    </ul>
    <legend>Thumbnail</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="vjs_thumb" value="1" /> Create a thumbnail at every seconds:</label>
	<!-- <input type="range" name="vjs_thumbsec" value="5" min="0" max="60" step="1"/> -->
	<input type="text" name="vjs_thumbsec" value="5" size="2" required/>
	<br/><small>Create a thumbnail every x seconds. <strong>Use by the videoJS plugin thumbnail</strong>.</small>
      </li>
      <li>
	<label>Size of the thumbnail:</label>
	<input type="text" name="vjs_thumbsize" value="120x68" size="5" placeholder="120x68" required/>
	<br/><small>Size in pixel, keep it small, default is fine, Youtube use 190x68.</small>
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

	global $page, $conf, $prefixeTable;

	$query = "SELECT `id`, `file`, `path`
			FROM ".IMAGES_TABLE."
			WHERE id IN (".implode(',',$collection).")";

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

	if(isset($_POST['submit']))
	{
	    // Override default value from the form
	    $sync_options_form = array(
	        'metadata'          => isset($_POST['vjs_metadata']),
	        'poster'            => isset($_POST['vjs_poster']),
	        'postersec'         => $_POST['vjs_postersec'],
	        'output'            => $_POST['vjs_output'],
	        'posteroverlay'     => isset($_POST['vjs_posteroverlay']),
	        'posteroverwrite'   => isset($_POST['vjs_posteroverwrite']),
	        'thumb'             => isset($_POST['vjs_thumb']),
	        'thumbsec'          => $_POST['vjs_thumbsec'],
	        'thumbsize'         => $_POST['vjs_thumbsize'],
	        'simulate'          => false,
	    );

	    // Merge default value with user data from the form
	    $sync_options = array_merge($sync_options, $sync_options_form);
	}

	// Do the work, share with admin sync and photo
	require_once(dirname(__FILE__).'/../include/function_sync2.php');

	$page['errors'] = $errors;
	$page['warnings'] = $warnings;
	$page['infos'] = $infos;
}

// Hook to perform the action on in single mode
add_event_handler('loc_begin_element_set_unit', 'vjs_loc_begin_element_set_unit');
function vjs_loc_begin_element_set_unit()
{
	if (!isset($_POST['submit']))
	      return;

	global $page, $conf, $prefixeTable;

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

	$collection = explode(',', $_POST['element_ids']);
	foreach ($collection as $id)
	{
		if (!isset($_POST['vjs_metadata-'.$id]) and !isset($_POST['vjs_poster-'.$id]) and !isset($_POST['vjs_thumb-'.$id]))
			return;

		// Override default value from the form
		$sync_options_form = array(
		    'metadata'          => isset($_POST['vjs_metadata-'.$id]),
		    'poster'            => isset($_POST['vjs_poster-'.$id]),
		    'postersec'         => $_POST['vjs_postersec-'.$id],
		    'output'            => $_POST['vjs_output-'.$id],
		    'posteroverlay'     => isset($_POST['vjs_posteroverlay-'.$id]),
		    'posteroverwrite'   => isset($_POST['vjs_posteroverwrite-'.$id]),
		    'thumb'             => isset($_POST['vjs_thumb-'.$id]),
		    'thumbsec'          => $_POST['vjs_thumbsec-'.$id],
		    'thumbsize'         => $_POST['vjs_thumbsize-'.$id],
		    'simulate'          => false,
		);

		// Merge default value with user data from the form
		$sync_options = array_merge($sync_options, $sync_options_form);

		$query = "SELECT `id`, `file`, `path`
				FROM ".IMAGES_TABLE."
				WHERE `id`='".$id."';";

		// Do the work, share with admin sync and photo
		include(dirname(__FILE__).'/../include/function_sync2.php');

		$page['errors'] = array_merge($page['errors'], $errors);
		$page['infos'] = array_merge($page['infos'], $infos);
		$page['warnings'] = array_merge($page['warnings'], $warnings);
	}
}

// Hoook for batch manager in single mode
add_event_handler('loc_end_element_set_unit', 'vjs_loc_end_element_set_unit');
function vjs_loc_end_element_set_unit()
{
	global $template, $conf, $page, $is_category, $category_info;

	$var = $template->get_template_vars();
	if (!isset($var['elements'])) return;
	foreach ($var['elements'] as $element)
	{
		if(!empty($element['representative_ext']) and $element['representative_ext'] != NULL)
			$template->set_prefilter('batch_manager_unit', 'vjs_prefilter_batch_manager_unit');
	}
}

function vjs_prefilter_batch_manager_unit($content)
{
	$needle = '</table>';
	$pos = strpos($content, $needle);
	if ($pos!==false)
	{
		$add = '<tr><td><strong>{\'VideoJS\'|@translate}</strong></td>
		  <td style="border: 2px solid rgb(221, 221, 221);">
    <legend>Metadata</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="vjs_metadata-{$element.id}" value="1"/> filesize, width, height, latitude, longitude, date_creation, rotation</label>
	<br/><small>Will overwrite the information in the database with the metadata from the video.</small>
	<br/><small><strong>Require <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">\'MediaInfo\' or \'ffprobe\' or \'Exiftool\'</a> to be install.</strong></small>
      </li>
    </ul>
    <legend>Poster</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="vjs_poster-{$element.id}" value="1"/> Create a poster at position in second:</label>
	<!-- <input type="range" name="vjs_postersec-{$element.id}" value="4" min="0" max="60" step="1"/> -->
	<input type="text" name="vjs_postersec-{$element.id}" value="4" size="2" required/>
	<br/><small>Create a poster from the video at specify position.</small>
	<br/><small><strong>Require <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">\'FFmpeg\'</a> to be install.</strong></small>
      </li>
      <li>
	<label><input type="checkbox" name="vjs_posteroverwrite-{$element.id}" value="1" checked="checked"> Overwrite existing posters</label>
	<br/><small>Overwrite existing thumbnails with new ones. If uncheck it should only run for newly added video.</small>
      </li>
      <li>
	<label><span class="property">Output format : </span></label>
	<label><input type="radio" name="vjs_output-{$element.id}" value="jpg" checked="checked"/> JPG</label>
	<label><input type="radio" name="vjs_output-{$element.id}" value="png" /> PNG</label>
	<br/><small>Select the output format for the poster and thumbnail.</small>
      </li>
      <li>
	<label><input type="checkbox" name="vjs_posteroverlay-{$element.id}" value="1" /> Add film effect</label>
	<br/><small>Apply an overlay on the poster creation.</small>
      </li>
    </ul>
    <legend>Thumbnail</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="vjs_thumb-{$element.id}" value="1" /> Create a thumbnail at every seconds:</label>
	<!-- <input type="range" name="vjs_thumbsec-{$element.id}" value="5" min="0" max="60" step="1"/> -->
	<input type="text" name="vjs_thumbsec-{$element.id}" value="5" size="2" required/>
	<br/><small>Create a thumbnail every x seconds. <strong>Use by the videoJS plugin thumbnail</strong>.</small>
      </li>
      <li>
	<label>Size of the thumbnail:</label>
	<input type="text" name="vjs_thumbsize-{$element.id}" value="120x68" size="5" placeholder="120x68" required/>
	<br/><small>Size in pixel, keep it small, default is fine, Youtube use 190x68.</small>
      </li>
    </ul>
		  </td>
		</tr>';
		$content = substr_replace($content, $add, $pos, 0);
	}
	return $content;
}

?>
