<?php
/***********************************************
* File      :   maintain.inc.php
* Project   :   piwigo-videojs
* Descr     :   Install / Uninstall method
*
* Created   :   24.06.2012
*
* Copyright 2012-2024 <xbgmsharp@gmail.com>
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

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $prefixeTable;
define('videojs_table', $prefixeTable.'image_videojs');

function plugin_install()
{
	if (!defined('VIDEOJS_PATH'))
		define('VIDEOJS_PATH', PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)).'/');

	$default_config = array(
		'skin'		  => 'vjs-default-skin',
		'max_height'  => '720',
		'preload'	  => 'auto',
		'controls'	  => true,
		'autoplay'	  => false,
		'loop'		  => false,
		'volume'	  => '1',
		'upscale'	  => false,
		'plugins'	  => array(
					'zoomrotate'    => false,
					'thumbnails'    => false,
					'watermark'     => false,
					'resolution'    => false,
				),
		'player'	=> 'html5-player.tpl',
		'metadata'	=> true,
	);

	/* Add configuration to the config table */
	$conf['vjs_conf'] = serialize($default_config);
	conf_update_param('vjs_conf', $conf['vjs_conf']);

	/* Add a comment to the entry */
	$q = 'UPDATE '.CONFIG_TABLE.' SET `comment` = "Configuration settings for piwigo-videojs plugin" WHERE `param` = "vjs_conf";';
	pwg_query( $q );

	/* Keep customCSS separate as it can be big entry */
	conf_update_param('vjs_customcss', '');

	/* Add a comment to the entry */
	$q = 'UPDATE '.CONFIG_TABLE.' SET `comment` = "Custom CSS used by the piwigo-videojs plugin" WHERE `param` = "vjs_customcss";';
	pwg_query( $q );

	/* Table to hold videos metadata details */
	$q = 'CREATE TABLE IF NOT EXISTS `'.videojs_table.'` (
			`id` mediumint(8) unsigned NOT NULL,
			`metadata` text DEFAULT NULL,
			`date_metadata_update` DATE DEFAULT NULL,
			PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8
		;';
	pwg_query($q);
}

function plugin_uninstall()
{
	global $prefixeTable;

	/* Drop VideoJS configuration settings */
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param LIKE "%vjs_%";';
	pwg_query( $q );

	/* Drop VideoJS metadata table */
	$q = 'DROP TABLE IF EXISTS '.$prefixeTable.'image_videojs'.';';
	pwg_query( $q );
	// TODO : Do we need to purge the videos from the images table?
}

function plugin_activate()
{
	global $conf;

	if (!is_array($conf['vjs_conf']))
		$conf['vjs_conf'] = unserialize($conf['vjs_conf']);

	if ( (!isset($conf['vjs_conf'])) or (!isset($conf['vjs_customcss']))
	    or (!empty($conf['vjs_conf']))
	    or (count($conf['vjs_conf'], COUNT_RECURSIVE) != 12))
	{
		plugin_install();
	}
}
?>
