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
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation
*
* This program is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
* USA.
*
************************************************/

define('VIDEOJS_PATH' , PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)) . '/');

function plugin_install()
{
	// TODO Remove when move from 0.3 to 0.4
	// It is a left from v0.1 and v0.2
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "videojs_skin";';
	pwg_query( $q );

	$q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment) 
		VALUES ("vjs_skin", "vjs-default-skin", "Skin used by the piwigo-videojs plugin");';
	pwg_query( $q );
	$q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment) 
		VALUES ("vjs_preload", "auto", "HTML5 video tag used by the piwigo-videojs plugin");';
	pwg_query( $q );
	$q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment) 
		VALUES ("vjs_controls", "true", "HTML5 video tag used by the piwigo-videojs plugin");';
	pwg_query( $q );
	$q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment) 
		VALUES ("vjs_autoplay", "true", "HTML5 video tag used by the piwigo-videojs plugin");';
	pwg_query( $q );
	$q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment) 
		VALUES ("vjs_loop", "false", "HTML5 video tag used by the piwigo-videojs plugin");';
	pwg_query( $q );
	$q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment) 
		VALUES ("vjs_max_width", "720", "Max WITH used by the piwigo-videojs plugin");';
	pwg_query( $q );
}

function plugin_uninstall() 
{
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "vjs_skin";';
	pwg_query( $q );
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "vjs_preload";';
	pwg_query( $q );
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "vjs_controls";';
	pwg_query( $q );
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "vjs_autoplay";';
	pwg_query( $q );
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "vjs_loop";';
	pwg_query( $q );
	$q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "vjs_max_width";';
	pwg_query( $q );
	// TODO : Do we need to purge the videos from the images table?
}
?>
