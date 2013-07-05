<?php
/***********************************************
* File      :   maintain.inc.php
* Project   :   piwigo-videojs
* Descr     :   Install / Uninstall method
*
* Created   :   24.06.2012
*
* Copyright 2012-2013 <xbgmsharp@gmail.com>
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

function plugin_install()
{
	if (!defined('VIDEOJS_PATH'))
		define('VIDEOJS_PATH', PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)).'/');

	// Remove unused directory or files from 0.4 and 0.5 to 0.6
	$toremove = array("skin", "js", "language/es_ES");
	foreach ($toremove as $dir)
	{
		if (is_dir(VIDEOJS_PATH.$dir))
		{
			deltree(VIDEOJS_PATH.$dir);
		}
	}
	$toremove = array("language/index.htm", "language/fr_FR/index.htm", "language/en_UK/index.htm", "admin.tpl", "admin.php");
	foreach ($toremove as $file)
	{
		if (is_file(VIDEOJS_PATH.$file))
		{
			@unlink(VIDEOJS_PATH.$file);
		}
	}

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

	/* Add a comment to the entry */
	$q = 'UPDATE '.CONFIG_TABLE.' SET `comment` = "Configuration settings for piwigo-videojs plugin" WHERE `param` = "vjs_conf";';
	pwg_query( $q );

	/* Keep customCSS separate as it can be big entry */
	conf_update_param('vjs_customcss', '');

	/* Add a comment to the entry */
	$q = 'UPDATE '.CONFIG_TABLE.' SET `comment` = "Custom CSS used by the piwigo-videojs plugin" WHERE `param` = "vjs_customcss";';
	pwg_query( $q );
}

function plugin_uninstall()
{
	/* Delete all files */
/* Don't remove myself on restore settings
	if (is_dir(VIDEOJS_PATH))
	{
		deltree(VIDEOJS_PATH);
	}
*/
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param LIKE "%vjs_%" LIMIT 2;';
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
	    or (count($conf['vjs_conf']) != 6))
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
