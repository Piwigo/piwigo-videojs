<?php
/*
Plugin Name: VideoJS
Version: 1.0.2
Description: videojs integration for piwigo
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=610
Author: xbmgsharp
Author URI: https://github.com/xbgmsharp/piwigo-videojs
*/

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Define the path to our plugin.
define('VIDEOJS_PATH', PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)).'/');

global $conf;

// Prepare configuration
$conf['vjs_conf'] = unserialize($conf['vjs_conf']);
$conf['derivatives'] = unserialize($conf['derivatives']);

// Register the allowed extentions to the global conf in order
// to sync them with other contents
$vjs_extensions = array(
    'ogg',
    'ogv',
    'mp4',
    'm4v',
    'webm',
    'webmv',
);
$conf['file_ext'] = array_merge ($conf['file_ext'], $vjs_extensions, array_map('strtoupper', $vjs_extensions) );

// Hook on to an event to display videos as standard images
add_event_handler('render_element_content', 'vjs_render_media', 40, 2);

// Hook to display a fallback thumbnail if not defined
add_event_handler('get_mimetype_location', 'vjs_get_mimetype_icon', 60, 2);

// Hook to change the picture data to template
//add_event_handler('picture_pictures_data', 'vjs_pictures_data');

// Hook to sync geotag metadata on upload or sync
//add_event_handler('format_exif_data', 'vjs_format_exif_data', EVENT_HANDLER_PRIORITY_NEUTRAL, 3);

// Hook to display metadata on picture page
//add_event_handler('get_element_metadata_available', 'vjs_metadata_available');

// If admin do the init
if (defined('IN_ADMIN')) {
	include_once(VIDEOJS_PATH.'/admin/admin_boot.php');
}

function vjs_format_exif_data($exif, $file, $map)
{

}

function vjs_metadata_available($content)
{

}

function vjs_render_media($content, $picture)
{
	global $template, $picture, $page, $conf, $user, $refresh;

	//print_r( $picture['current']);
	// do nothing if the current picture is actually an image !
	if ( (array_key_exists('src_image', @$picture['current'])
		&& @$picture['current']['src_image']->is_original()) )
	{
		return $content;
	}

	// In case, we handle a large video, we define a MAX_WIDTH
	// variable to limit the display size.
	if (isset($user['maxwidth']) and $user['maxwidth']!='')
	{
		$MAX_WIDTH = $user['maxwidth'];
	}
	else
	{
		$MAX_WIDTH = isset($conf['vjs_conf']['max_width']) ? $conf['vjs_conf']['max_width'] : '720';
	}
	//print "MAX_WIDTH=" . $MAX_WIDTH;
	//print_r($user);

	// Avoid Conflict with other plugin using getID3
	if( !class_exists('getID3')){
		// Get video infos with getID3 lib
		require_once(dirname(__FILE__) . '/include/getid3/getid3.php');
	}
	$getID3 = new getID3;
	$fileinfo = $getID3->analyze($picture['current']['path']);
	//print "getID3\n";
	//print_r($fileinfo);

	$extension = vjs_get_mimetype_from_ext(get_extension($picture['current']['path']));
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
	//print $width .">". $MAX_WIDTH;
	if ( $width > $MAX_WIDTH )
	{
		$height = intval($height * ($MAX_WIDTH / $width));
		$width  = $MAX_WIDTH;
		//$height = intval($height / 2);
		//$width = intval($width / 2);
	}
	// Upscale if video is too small
	$upscale = isset($conf['vjs_conf']['upscale']) ? strbool($conf['vjs_conf']['upscale']) : false;
	if ( $upscale and $width < $MAX_WIDTH )
	{
		$height = intval($height * ($MAX_WIDTH / $width));
		$width  = $MAX_WIDTH;
	}

	// Load parameter, fallback to default if unset
	$skin = isset($conf['vjs_conf']['skin']) ? $conf['vjs_conf']['skin'] : 'vjs-default-skin';
	$customcss = isset($conf['vjs_customcss']) ? $conf['vjs_customcss'] : '';
	$preload = isset($conf['vjs_conf']['preload']) ? $conf['vjs_conf']['preload'] : 'none';
	$loop = isset($conf['vjs_conf']['loop']) ? strbool($conf['vjs_conf']['loop']) : false;
	$controls = isset($conf['vjs_conf']['controls']) ? strbool($conf['vjs_conf']['controls']) : false;
	$volume = isset($conf['vjs_conf']['volume']) ? $conf['vjs_conf']['volume'] : '1';

	// Slideshow : The video needs to be launch automatically in
	// slideshow mode. The refresh of the page is set to the
	// duration of the video.
	$autoplay = isset($conf['vjs_conf']['autoplay']) ? strbool($conf['vjs_conf']['autoplay']) : false;
	if ( $page['slideshow'] )
	{
		$refresh = $fileinfo['playtime_seconds'];
		$autoplay = true;
		$loop = false;
	}

	// Assing the CSS file according to the skin
	$available_skins = array(
		'vjs-default-skin' => 'video-js.min.css',
		'vjs-redtube-skin' => 'redtube-skin.css',
		'vjs-darkfunk-skin' => 'darkfunk-skin.css',
		'vjs-redsheen-skin' => 'redsheen-skin.css',
	);
	$skincss = $available_skins[$skin];

	// Try to guess the poster extension
	$parts = pathinfo($picture['current']['element_url']);
	$poster = embellish_url( vjs_get_poster_file( Array(
		$fileinfo['filepath']."/pwg_representative/".$parts['filename'].".jpg" =>
			get_gallery_home_url() . $parts['dirname'] . "/pwg_representative/".$parts['filename'].".jpg",
		$fileinfo['filepath']."/pwg_representative/".$parts['filename'].".png" =>
			get_gallery_home_url() . $parts['dirname'] . "/pwg_representative/".$parts['filename'].".png",
	)));
	//print $poster;
	// poster should be $picture['current']['src_image']['rel_path']

	// Try to find multiple video source
	$vjs_extensions = array('ogg', 'ogv', 'mp4', 'm4v', 'webm', 'webmv');
	$files_ext = array_merge(array(), $vjs_extensions, array_map('strtoupper', $vjs_extensions) );
	// Add the current file in array
	$videos[] = array(
				'src' => embellish_url(get_gallery_home_url() . $picture['current']['element_url']),
				'ext' => $extension,
			);
	foreach ($files_ext as $file_ext) {
		$file = $fileinfo['filepath']."/pwg_representative/".$parts['filename'].".".$file_ext;
		if (file_exists($file)){
			array_push($videos,
				   array (
					'src' => embellish_url(
						      get_gallery_home_url() . $parts['dirname'] . "/pwg_representative/".$parts['filename'].".".$file_ext
						     ),
					'ext' => vjs_get_mimetype_from_ext($file_ext)
					)
				  );
		}
	}
	//print_r($videos);
	// Sort array to have MP4 first in the source list for iOS support
	foreach ($videos as $key => $row) {
		$src[$key] = $row['src'];
		$ext[$key] = $row['ext'];
	}
	array_multisort($src, SORT_ASC, $ext, SORT_ASC, $videos);
	//print_r($videos);

	/* Thumbnail videojs plugin */
	$thumbnails_plugin = isset($conf['vjs_conf']['plugins']['thumbnails']) ? strbool($conf['vjs_conf']['plugins']['thumbnails']) : false;
	$thumbnails = array();
	if ($thumbnails_plugin)
	{
		$filematch = $parts['dirname']."/pwg_representative/".$parts['filename']."-th_*";
		$matches = glob($filematch);

		if ( is_array ( $matches ) ) {
			$thumbnails = array();
			foreach ( $matches as $filename) {
			     $ext = explode("-th_", $filename);
			     $second = explode(".", $ext[1]);
			     // ./galleries/videos/pwg_representative/trailer_480p-th_0.jpg
			     //echo "$filename second " . $second[0]. "\n";
			     $thumbnails[] = array(
						   'second' => $second[0],
						   'source' => embellish_url(get_gallery_home_url() . $filename)
						);
			}
		}
		//$thumbnails = array( array('second' => 0, 'source' => $poster), array('second' => 5, 'source' => $poster));
		//print_r($thumbnails);
	}

	/* ZoomRotate videojs plugin */
	$zoomrotate_plugin = isset($conf['vjs_conf']['plugins']['zoomrotate']) ? strbool($conf['vjs_conf']['plugins']['zoomrotate']) : false;
	$zoomrotate = array();
	if ($zoomrotate_plugin)
	{
		// TODO Disable if playing on iOS, as it read the metadata
		if ($picture['current']['rotation'] != null)
		{
			include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
			include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
			// rotation is $picture['current']['rotation']
			// zoom is witdh / height
			$rotate = pwg_image::get_rotation_angle_from_code($picture['current']['rotation']);
			$zoomrotate = array(
						'rotate'	=> $rotate,
						'zoom'		=> round($width / $height, 1, PHP_ROUND_HALF_DOWN)
					);
			// Change the video player size
			$tmp_width = $width;
			$tmp_height = $height;
			$width = $tmp_height;
			$height = $tmp_width;
		}
	}

	/* Watermark videojs plugin */
	$watermark_plugin = isset($conf['vjs_conf']['plugins']['watermark']) ? strbool($conf['vjs_conf']['plugins']['watermark']) : false;
	$watermark = array();
	if ($watermark_plugin)
	{
		if ($conf['derivatives']['w']->file != null)
		{
			$watermark = array(
						'file'		=> embellish_url(get_gallery_home_url() . $conf['derivatives']['w']->file),
						'xpos'		=> $conf['derivatives']['w']->xpos,
						'ypos'		=> $conf['derivatives']['w']->ypos,
						'xrepeat'	=> $conf['derivatives']['w']->xrepeat,
						'opacity'	=> $conf['derivatives']['w']->opacity,
					);
		}
	}

	// Generate HTML5 tags
	// Why the data-setup attribute does not work if only one video
	$options = "";
	if ($controls)
	{
		$options .= "controls";
	}
	if ($autoplay)
	{
		$options .= " autoplay ";
	}
	if ($loop)
	{
		$options .= " loop ";
	}
	$options .= ' preload="'. $preload .'"';

	// Select the template
	$template->set_filenames(
		array('vjs_content' => dirname(__FILE__)."/template/vjs-player.tpl")
	);

	// Assign the template variables
	// We use here the piwigo's get_gallery_home_url function to build
	// the full URL as suggested by videojs for flash fallback compatibility
	$template->assign(
		array(
			'VIDEOJS_MEDIA_URL'	=> embellish_url(get_gallery_home_url() . $picture['current']['element_url']),
			'VIDEOJS_POSTER_URL'	=> $poster,
			'VIDEOJS_PATH'		=> VIDEOJS_PATH,
			'VIDEOJS_FULLPATH'	=> realpath(dirname(__FILE__)),
			'WIDTH'			=> $width,
			'HEIGHT'		=> $height,
			'TYPE'			=> $extension,
			'OPTIONS'		=> $options,
			'VIDEOJS_SKIN'		=> $skin,
			'VIDEOJS_SKINCSS'	=> $skincss,
			'VIDEOJS_CUSTOMCSS'	=> $customcss,
			'volume'		=> $volume,
			'thumbnails'	=> $thumbnails,
			'zoomrotate'	=> $zoomrotate,
			'watermark'		=> $watermark,
			'videos'		=> $videos,
		)
	);

	// Return the rendered html
	$vjs_content = $template->parse('vjs_content', true);
	return $vjs_content;
}

function vjs_get_mimetype_icon($location, $element_info)
{
	$location= 'plugins/'
		. basename(dirname(__FILE__))
		. '/mimetypes/' . $element_info . '.png';
	return $location;
}

function strbool($value)
{
	return $value ? true : false;
}

function vjs_get_poster_file($file_list)
{
	foreach ($file_list as $file=>$url) {
		//print $file."=>".$url."<br/>\n";
		if (file_exists($file)) return $url;
	}
	return '';
}

function vjs_get_mimetype_from_ext($file_ext)
{
	$vjs_types = array(
			   'ogg'   => 'video/ogg',
			   'ogv'   => 'video/ogg',
			   'mp4'   => 'video/mp4',
			   'm4v'   => 'video/mp4',
			   'webm'  => 'video/webm',
			   'webmv' => 'video/webm'
			);
	return $vjs_types[strtolower($file_ext)];
}

function vjs_dbSet($fields, $data = array())
{
    if (!$data) $data = &$_POST;
    $set='';
    foreach ($fields as $field)
    {
        if (isset($data[$field]))
        {
            $set.="`$field`='".pwg_db_real_escape_string($data[$field])."', ";
        }
    }
    return substr($set, 0, -2);
}

?>
