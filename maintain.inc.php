<?php
function plugin_install()
{
    $q = 'INSERT INTO '.CONFIG_TABLE.' (param,value,comment) 
          VALUES ("videojs_skin", "bm", "Skin used by the piwigo-videojs plugin");';
    pwg_query( $q );
}

function plugin_uninstall() 
{
    $q = 'DELETE FROM '.CONFIG_TABLE.' WHERE param = "videojs_skin";';
    pwg_query( $q );

    // TODO : Do we need to purge the videos from the images table? 
}
?>
