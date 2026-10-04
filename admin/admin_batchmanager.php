<?php
/***********************************************
* File      :   admin_batchmanager.php
* Project   :   piwigo-videojs
* Descr     :   handle batch manager
*
* Created   :   4.06.2013
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

// Hook to add a new filter in the batch mode
add_event_handler('get_batch_manager_prefilters', 'vjs_get_batch_manager_prefilters');
function vjs_get_batch_manager_prefilters($prefilters)
{
    $prefilters[] = array('ID' => 'videojs0', 'NAME' => l10n('VIDEOS_ALL'));
    $prefilters[] = array('ID' => 'videojs1', 'NAME' => l10n('VIDEOS_W_POSTER'));
    $prefilters[] = array('ID' => 'videojs2', 'NAME' => l10n('VIDEOS_WO_POSTER'));
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
    global $template, $conf;

    $template->append('element_set_global_plugins_actions',
        array('ID' => 'videojs', 'NAME'=>l10n('VIDEOS_METADATA_POSTERS'), 'CONTENT' => vjs_sync_options_html($conf['vjs_sync'])));
}

// Build the sync options form fields, shared with the VideoJS tab of the photo edit page
function vjs_sync_options_html($sync_options, $metadata_title = true, $thumbsize_inline = false)
{
    $metadata_checked ='';
    if ($sync_options['metadata']) {
        $metadata_checked = 'checked="checked"';
    }
    $representative_checked = '';
    if ($sync_options['representative']) {
        $representative_checked = 'checked="checked"';
    }
    $poster_checked = '';
    if ($sync_options['poster']) {
        $poster_checked = 'checked="checked"';
    }
    $posteroverwrite_checked = '';
    if ($sync_options['posteroverwrite']) {
        $posteroverwrite_checked = 'checked="checked"';
    }
    $jpg_output_checked = '';
    $png_output_checked = '';
    if ($sync_options['output'] == 'jpg') {
        $jpg_output_checked = 'checked="checked"';
    }
    else if ($sync_options['output'] == 'png') {
        $png_output_checked = 'checked="checked"';
    }
    else {
        $jpg_output_checked = 'checked="checked"';
    }
    $posteroverlay_checked = '';
    if ($sync_options['posteroverlay']) {
        $posteroverlay_checked ='checked="checked"';
    }
    $thumb_checked = '';
    if ($sync_options['thumb']) {
        $thumb_checked = 'checked="checked"';
    }
    
    return '
    '.($metadata_title ? '<legend>'.l10n('SYNC_METADATA').'</legend>' : '').'
    <small><strong>'.l10n('SYNC_REQUIRE').'</strong></small>
    <ul>
      <li>
        <label><input type="checkbox" name="vjs_metadata" value="1" '.$metadata_checked.'/> '.l10n('Synchronize metadata').'</label>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_METADATA_DESC').'"></a>
      </li>
    </ul>
    <legend>'.l10n('SYNC_POSTER_TITLE').'</legend>
    <ul>
      <li>
        <label><input type="checkbox" name="vjs_representative" value="1" '.$representative_checked.'> '.l10n('SYNC_REPRESENTATIVES').' </label>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_REPRESENTATIVES_DESC').'"></a>
      </li>
    </ul>
    <small><strong>'.l10n('SYNC_POSTER_REQUIRE').'</strong></small>
    <ul>
      <li>
        <label><input type="checkbox" name="vjs_poster" value="1" '.$poster_checked.'> '.l10n('SYNC_POSTER').'</label>
        <input type="text" name="vjs_postersec" value="'.$sync_options['postersec'].'" size="2" required/>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_POSTER_DESC').'"></a>
      </li>
      <li>
        <label><input type="checkbox" name="vjs_posteroverwrite" value="1" '.$posteroverwrite_checked.'> '.l10n('SYNC_POSTEROVERWRITE').'</label>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_POSTEROVERWRITE_DESC').'"></a>
      </li>
      <li>
        <label>'.l10n('SYNC_OUTPUT').'</label>
        <label><input type="radio" name="vjs_output" value="jpg" '.$jpg_output_checked.'/> JPG</label>
        &nbsp;<label><input type="radio" name="vjs_output" value="png" '.$png_output_checked.'/> PNG</label>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_OUTPUT_DESC').'"></a>
      </li>
      <li>
        <label><input type="checkbox" name="vjs_posteroverlay" value="1" '.$posteroverlay_checked.'> '.l10n('SYNC_POSTEROVERLAY').'</label>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_POSTEROVERLAY_DESC').'"></a>
      </li>
    </ul>
    <legend>'.l10n('SYNC_THUMB').'</legend>
    <small><strong>'.l10n('SYNC_POSTER_REQUIRE').'</strong></small>
    <ul>
      <li>
        <label><input type="checkbox" name="vjs_thumb" value="1" '.$thumb_checked.'/> '.l10n('SYNC_THUMBSEC').'</label>
        <input type="text" name="vjs_thumbsec" value="'.$sync_options['thumbsec'].'" size="2" required/>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_THUMBSEC_DESC').'"></a>
      </li>
      <li>
        <label>'.l10n('SYNC_THUMBSIZE').'</label><br/>
        <input type="text" name="vjs_thumbsize" value="'.$sync_options['thumbsize'].'" size="6" placeholder="120x68" required/>
        <a class="icon-info-circled-1" title="'.l10n('SYNC_THUMBSIZE_DESC').'"></a>
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

    $query = 'SELECT id, file, path, representative_ext
            FROM '.IMAGES_TABLE.'
            WHERE id IN ('.implode(',',$collection).')';

    // Update sync options if submitted in admin site
    $sync_options = $conf['vjs_sync'];
    if (isset($_POST['submit']))
    {
        $sync_options = vjs_sync_options_from_post($sync_options);
    }

    // Do the work, share with admin sync and photo
    require_once(dirname(__FILE__).'/../include/function_sync.php');

    $page['errors'] = $errors;
    $page['warnings'] = $warnings;
    $page['infos'] = $infos;
}
?>
