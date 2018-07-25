<?php
/***********************************************
* File      :   admin_config.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin config panel
*
* Created   :   24.06.2012
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

// Load parameter
$customcss = $conf['vjs_customcss'] ? $conf['vjs_customcss'] : '';

// Available skins
$available_skins = array(
	'vjs-default-skin' => 'default',
	'vjs-bluebox-skin' => 'bluebox',
	'vjs-redtube-skin' => 'redtube',
);

// Available player
$available_players = array(
	'vjs-7-player.tpl' => 'Video.js v7',
	'vjs-6-player.tpl' => 'Video.js v6',
	'vjs-5-player.tpl' => 'Video.js v5',
	'vjs-4-player.tpl' => 'Video.js v4',
	'html5-player.tpl' => 'Native Browser',
);

// Available preload value
$available_preload = array(
	'auto' => 'Auto',
	'none' => 'None',
);

// Available language value from the directory to be dynamic
$available_languages = array('en');
if ($handle = opendir(dirname(__FILE__).'/../video-js-4/lang/')) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry == '.' || $entry == '..') {
			continue;
		}
		array_push($available_languages, preg_replace('/.js/', '', $entry));
	}
	closedir($handle);
}

// Available width value
// http://en.wikipedia.org/wiki/Display_resolution
$available_height = array(
	'480' => 'EDTV: (720x480) ie: 480p',
	'576' => 'EDTV: (720×576) ie: 576p',
	'720' => 'HDReady: (1280x720) ie: 720p',
	'1080' => 'FullHD: (1920x1080) ie: 1080p',
	'2160' => '4k UHDTV: (3840×2160) ie: 2160p',
	'4320' => '8k UHDTV: (7680×4320) ie: 4320p',
);

// Update conf if submitted in admin site
if (isset($_POST['submit']) && !empty($_POST['vjs_skin']))
{
	// keep the value in the admin form
	$conf['vjs_conf'] = array(
		'skin'          => $_POST['vjs_skin'],
		'max_height'    => $_POST['vjs_max_height'],
		'preload'       => $_POST['vjs_preload'],
		'controls'      => get_boolean($_POST['vjs_controls']),
		'autoplay'      => get_boolean($_POST['vjs_autoplay']),
		'loop'          => get_boolean($_POST['vjs_loop']),
		'volume'        => $_POST['vjs_volume'],
		'language'      => $_POST['vjs_language'],
		'upscale'       => get_boolean($_POST['vjs_upscale']),
		'plugins'       => array(
							'zoomrotate'    => get_boolean($_POST['vjs_zoomrotate']),
							'thumbnails'    => get_boolean($_POST['vjs_thumbnails']),
							'watermark'     => get_boolean($_POST['vjs_watermark']),
						),
		'player'	=> $_POST['vjs_player'],
		'metadata'	=> get_boolean($_POST['vjs_metadata']),
	);
	$customcss = $_POST['vjs_customcss'];

	// Update config to DB
	conf_update_param('vjs_conf', serialize($conf['vjs_conf']));
	$query = "UPDATE ". CONFIG_TABLE ." SET value='". $_POST['vjs_customcss'] ."' WHERE param='vjs_customcss'";
	pwg_query($query);

	// the prefilter changes, we must delete compiled templatess
	$template->delete_compiled_templates();

	array_push($page['infos'], l10n('Your configuration settings are saved'));
}

/* Get statistics */
// All videos with supported extensions by VideoJS
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS.";";
list($nb_videos) = pwg_db_fetch_row( pwg_query($query) );

// All videos with supported extensions by VideoJS and thumb
$query = "SELECT COUNT(*) FROM ".IMAGES_TABLE." WHERE `representative_ext` IS NOT NULL AND ".SQL_VIDEOS.";";
list($nb_videos_thumb) = pwg_db_fetch_row( pwg_query($query) );

// send value to template
$template->assign($conf['vjs_conf']);
$template->assign(
	array(
            'AVAILABLE_PLAYERS'     => $available_players,
            'AVAILABLE_SKINS'       => $available_skins,
            'AVAILABLE_PRELOAD'     => $available_preload,
            'AVAILABLE_LANGUAGES'   => $available_languages,
            'AVAILABLE_HEIGHT'      => $available_height,
            'CUSTOM_CSS'            => htmlspecialchars($customcss),
            'NB_VIDEOS'             => $nb_videos,
            'NB_VIDEOS_THUMB'       => $nb_videos_thumb,
	)
);

?>
