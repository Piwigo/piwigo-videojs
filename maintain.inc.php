<?php
/***********************************************
* File      :   maintain.inc.php
* Project   :   piwigo-videojs
* Descr     :   Install / Uninstall method
*
* Created   :   24.06.2012
*
* Copyright 2012 <xbgmsharp@gmail.com>
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
define('VIDEOJS_PATH' , PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)) . '/');

function plugin_install()
{

	// Remove unused directory from 0.4 and 0.5 to 0.6
	$toremove = array("skin", "js", "language/es_ES");
	foreach ($toremove as $dir)
	{
		if (is_dir(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'piwigo-videojs/'.$dir))
		{
			deltree(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'piwigo-videojs/'.$dir);
		}
	}
	$toremove = array("language/index.htm", "language/fr_FR/index.htm", "language/en_UK/index.htm");
	foreach ($toremove as $file)
	{
		@unlink(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'piwigo-videojs/'.$file);
	}

	// It is a left over from v0.1 and v0.2 - TO REMOVE in 0.7
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "videojs_skin";';
	pwg_query( $q );

	// Clean up any previous entry from 0.4 to 0.5 - TO REMOVE in 0.7
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param LIKE "%vjs_%" LIMIT 7;';
	pwg_query( $q );

	$default_config = array(
		'skin'		=> 'vjs-default-skin',
		'max_width'	=> '720',
		'preload'	=> 'auto',
		'controls'	=> true,
		'autoplay'	=> false,
		'loop'		=> false,
	);

	/* Add configuration to the config table */
	$conf['vjs_conf'] = serialize($default_config);
	conf_update_param('vjs_conf', $conf['vjs_conf']);

	$q = 'UPDATE '.CONFIG_TABLE.' SET `comment` = "Configuration settings for piwigo-videojs plugin" WHERE `param` = "vjs_conf";';
	pwg_query( $q );
	/* Keep customCSS separate as it can be big entry */
	$q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
		VALUES ("vjs_customcss", "", "Custom CSS used by the piwigo-videojs plugin");';
	pwg_query( $q );
}

function plugin_uninstall()
{
	if (is_dir(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'piwigo-videojs'))
	{
		deltree(PHPWG_ROOT_PATH.PWG_LOCAL_DIR.'piwigo-videojs');
	}
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param LIKE "%vjs_%" LIMIT 2;';
	pwg_query( $q );
	// TODO : Do we need to purge the videos from the images table?
}

function plugin_activate()
{
	global $conf;

	if ( (!isset($conf['vjs_conf'])) or (!isset($conf['vjs_customcss'])) )
	{
		plugin_install();
	}
}

function deltree($path)
{
	if (is_dir($path))
	{
		$fh = opendir($path);
		while ($file = readdir($fh))
		{
			if ($file != '.' and $file != '..')
			{
				$pathfile = $path . '/' . $file;
				if (is_dir($pathfile))
				{
					deltree($pathfile);
				}
				else
				{
					@unlink($pathfile);
				}
			}
		}
		closedir($fh);
		return @rmdir($path);
	}
}


?>
