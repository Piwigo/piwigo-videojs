<?php 
/*
Version: 0.1
Plugin Name: videojs
Plugin URI: https://github.com/xbmgsharp/piwigo-videojs
Author: xbmgsharp
Description: videojs integration for piwigo
*/

// Chech whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Define the path to our plugin.
define('VIDEOJS_PATH', PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)).'/');

global $conf;

// Register the allowed extentions to the global conf in order
// to sync them with other contents
$videojs_extensions = array(
    'ogg', 
    'mp4', 
    'm4v', 
    'ogv', 
    'webm', 
    'webmv',
);
$conf['file_ext'] = array_merge($conf['file_ext'], $videojs_extensions);

// Hook on to an event to display videos as standard images
add_event_handler('render_element_content', 'render_media', 40, 2 );

// Hook to display a fallback thumbnail if not defined
add_event_handler('get_thumbnail_location', 'get_mimetype_icon', 60, 2);

// Hook to a admin config page
add_event_handler('get_admin_plugin_menu_links', 'videojs_admin_menu' );

function videojs_admin_menu($menu)
{
  array_push($menu,
      array(
        'NAME' => 'videojs',
        'URL'  => get_admin_plugin_menu_link(dirname(__FILE__).'/admin.php')
      )
    );
  return $menu;
}

function render_media($content, $picture)
{
    global $template, $picture, $page, $conf, $user, $refresh;
	//print_r( $picture['current']);
    // do nothing if the current picture is actually an image !
	// but doesn't not work ???
    if ( @$picture['current']['is_picture'] ) 
	{
		return $content;
	}
	
    // In case, the we handle a large video, we define a MAX_WIDTH
    // variable to limit the display size.
    if (isset($user['maxwidth']) and $user['maxwidth']!='')
	{
        $MAX_WIDTH = $user['maxwidth'];
    }
    else
	{
        $MAX_WIDTH = '720';
    }
	//print "$MAX_WIDTH=" . $MAX_WIDTH;
	//print_r($user);

    // Get video infos with getID3 lib
    require_once(dirname(__FILE__) . '/include/getid3/getid3.php');
    $getID3 = new getID3;
    $fileinfo = $getID3->analyze($picture['current']['path']);
	//print "getID3\n";
	//print_r($fileinfo);

    $extension = strtolower(get_extension($picture['current']['path']));
	//print "extension\n";
	//print_r($extension);

    if(isset($fileinfo['video']))
	{
        // -- video file --
        // guess resolution
        if (isset($fileinfo['video']['resolution_x']) )
		{
            $width = $fileinfo['video']['resolution_x'];
        }
        if (isset($fileinfo['video']['resolution_y']) )
		{
            $height = $fileinfo['video']['resolution_y'];
        }
        if ( !isset($width) || !isset($height))
		{
            // If guess was unsuccessful, fallback to default 16/9 resolution
            // This is the case for ogv video for example. 
            $width = $MAX_WIDTH;
            $height = intval( 9 * ($width / 16 ));
        } 
    }
	else // Not a supported video format or an image
	{
		return $content;
	}

    // Resize if video is too large
    if ( $width > $MAX_WIDTH )
	{
        //$height = intval($height * ($MAX_WIDTH / $width));
        //$width  = $MAX_WIDTH;
		$height = intval($height / 2);
		$width = intval($width / 2);
    }

    // Slideshow : The video needs to be launch automatically in
    // slideshow mode. The refresh of the page is set to the
    // duration of the video.
    $AUTOPLAY = '';
    if ( $page['slideshow'] )
	{
        $refresh = $fileinfo['playtime_seconds'];
        $AUTOPLAY = 'play';
    }

    // Load parameter, fallback to blue monday if unset 
    $skin = isset($conf['videojs_skin']) ? $conf['videojs_skin'] : 'vjs-default-skin';

    // Select the template
    $template->set_filenames(
		array('vjs_content' => dirname(__FILE__)."/template/vjs-player.tpl")
    );

	$parts = pathinfo($picture['current']['element_url']);
	$thumb = get_gallery_home_url() . $parts['dirname'] . "/thumbnail/TN-" . $parts['filename'] . ".jpg";
	//print $thumb;

    // Assign the template variables
    // We use here the piwigo's get_gallery_home_url function to build 
    // the full URL as suggested by videojs for flash fallback compatibility
    $template->assign(
        array(
            'VIDEOJS_MEDIA_URL'	=> embellish_url(get_gallery_home_url() . $picture['current']['element_url']),
			'VIDEOJS_THUMB_URL'	=> $thumb,
            'VIDEOJS_PATH'     => VIDEOJS_PATH,
            'VIDEOJS_FULLPATH' => realpath(dirname(__FILE__)),
            'WIDTH'            => $width,
            'HEIGHT'           => $height,
            'TYPE'             => $extension,
            'AUTOPLAY'         => $AUTOPLAY,
			'VJSSKIN'          => $skin,
        )
    );

    // Return the rendered html
    $vjs_content = $template->parse('vjs_content', true);
    return $vjs_content;
}

function get_mimetype_icon ($location, $element_info)
{
    if ( empty( $element_info['tn_ext'] ) ) {
        $extension = strtolower(get_extension($element_info['path']));
        if ( $extension == 'webm') {
            $location= 'plugins/'
                       . basename(dirname(__FILE__))
                       . '/mimetypes/webm.png';
        }
        $location= 'plugins/'
                   . basename(dirname(__FILE__))
                   . '/mimetypes/' . $extension . '.png';
    }
    return $location;
}

?>
