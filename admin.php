<?php
/***********************************************
* File      :   admin.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   24.06.2012
*
* Copyright 2012 <xbgmsharp@gmail.com>
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

// Setup plugin Language
load_language('plugin.lang', VIDEOJS_PATH);

// Fetch the template.
global $template, $conf, $lang;

// Load parameter
$skin = $conf['vjs_skin'];
$preload = $conf['vjs_preload'];
$controls = $conf['vjs_controls'] ? 'true' : 'false';
$autoplay = $conf['vjs_autoplay'] ? 'true' : 'false';
$loop = $conf['vjs_loop'] ? 'true' : 'false';
$max_width = $conf['vjs_max_width'];

// Available skins
$available_skins = array(
	'vjs-default-skin' => 'default',
	'tubecss' => 'tubecss',
);

// Available preload value
$available_preload = array(
	'auto' => 'Auto',
	'none' => 'None',
);

// Available width value
$available_width = array(
	'480' => 'EDTV: (720x480) ie: 480p',
	'720' => 'HDReady: (1280x720) ie: 720p',
	'1080' => 'FullHD: (1920x1080) ie: 1080p',
);

// Update conf if submitted in admin site
if (isset($_POST['submit']) && !empty($_POST['vjs_skin']))
{
	$query = "UPDATE ". CONFIG_TABLE ." SET value='". $_POST['vjs_skin'] ."' WHERE param='vjs_skin'";
	pwg_query($query);
	$query = "UPDATE ". CONFIG_TABLE ." SET value='". $_POST['vjs_preload'] ."' WHERE param='vjs_preload'";
	pwg_query($query);
	$query = "UPDATE ". CONFIG_TABLE ." SET value='". $_POST['vjs_controls'] ."' WHERE param='vjs_controls'";
	pwg_query($query);
	$query = "UPDATE ". CONFIG_TABLE ." SET value='". $_POST['vjs_autoplay'] ."' WHERE param='vjs_autoplay'";
	pwg_query($query);
	$query = "UPDATE ". CONFIG_TABLE ." SET value='". $_POST['vjs_loop'] ."' WHERE param='vjs_loop'";
	pwg_query($query);
	$query = "UPDATE ". CONFIG_TABLE ." SET value='". $_POST['vjs_max_width'] ."' WHERE param='vjs_max_width'";
	pwg_query($query);

	// keep the value in the admin form
	$skin = $_POST['vjs_skin'];
	$preload = $_POST['vjs_preload'];
	$controls = $_POST['vjs_controls'];
	$autoplay = $_POST['vjs_autoplay'];
	$loop = $_POST['vjs_loop'];
	$max_width = $_POST['vjs_max_width'];
}

// send value to template
$template->assign(
	array(
		'SELECTED_SKIN'		=> $skin,
		'AVAILABLE_SKINS'	=> $available_skins,
		'SELECTED_PRELOAD'	=> $preload,
		'AVAILABLE_PRELOAD'	=> $available_preload,
		'SELECTED_WIDTH'	=> $max_width,
		'AVAILABLE_WIDTH'	=> $available_width,
		'CONTROLS'			=> $controls,
		'AUTOPLAY'			=> $autoplay,
		'LOOP'				=> $loop,
	)
);

// Add our template to the global template
$template->set_filenames(
	array(
		'plugin_admin_content' => dirname(__FILE__).'/admin.tpl'
	) 
);

// Assign the template contents to ADMIN_CONTENT
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>
