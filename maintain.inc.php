<?php
define('VIDEOJS_PATH' , PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)) . '/');

function plugin_install()
{
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
