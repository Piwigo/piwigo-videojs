<?php
/*
Plugin Name: VideoJS
Version: 2.7.a
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
add_event_handler('render_element_content', 'vjs_render_media', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);

// Hook to display a fallback thumbnail if not defined
add_event_handler('get_mimetype_location', 'vjs_get_mimetype_icon', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);

// Hook to change the picture data to template
//add_event_handler('picture_pictures_data', 'vjs_pictures_data');

// Hook to sync geotag metadata on upload or sync
add_event_handler('format_exif_data', 'vjs_format_exif_data', EVENT_HANDLER_PRIORITY_NEUTRAL, 3);

// Hook to display metadata on picture page
add_event_handler('get_element_metadata_available', 'vjs_metadata_available');

// If admin do the init
if (defined('IN_ADMIN')) {
	include_once(VIDEOJS_PATH.'/admin/admin_boot.php');
}

function vjs_format_exif_data($exif, $filename, $map)
{
	global $conf, $picture;

	//print_r( $picture['current']);
	// do nothing if the current picture is actually an image !
	if (!isset($picture['current']))
		return $exif;

	if ((array_key_exists('src_image', @$picture['current'])
		&& @$picture['current']['src_image']->is_original()) )
	{
		return $exif;
	}

	// In case it is not an image but not a supported video file by the plugin
	if (vjs_valid_extension(get_extension($picture['current']['path'])) === false)
	{
		return $exif;
	}

	// If video, let's check
	//print $filename."\n";
	//print_r($exif)."\n<br/>\n";
	//print_r($map)."\n<br/>\n";
	$filename=$picture['current']['path'];
	// TODO read from DB, instead of reading live MediaInfo result
	// Generate default value
	$sync_options = array(
		'mediainfo'        => 'mediainfo',
		'ffmpeg'           => 'ffmpeg',
		'metadata'         => true,
		'poster'           => true,
		'postersec'        => 4,
		'output'           => 'jpg',
		'posteroverlay'    => false,
		'posteroverwrite'  => true,
		'thumb'            => false,
		'thumbsec'         => 5,
		'thumbsize'        => "120x68",
		'simulate'         => true,
		'cat_id'           => 0,
		'subcats_included' => true,
	);
	// Override default value from configuration
	if (isset($conf['vjs_sync']))
	{
	    $sync_options = unserialize($conf['vjs_sync']);
	}
	// Do the Check dependencies, MediaInfo & FFMPEG, share with batch manager & photo edit & admin sync
	require_once(dirname(__FILE__).'/include/function_dependencies.php');
	require_once(dirname(__FILE__).'/include/mediainfo.php');
	if (isset($exif) and ($exif != null) and isset($general))
	{
		// Replace some value by human readable string
		if (isset($general->FileSize_String))
		{
			$exif['filesize'] = (string)$general->FileSize_String;
		}
		if (isset($general->Duration_String))
		{
			$exif['duration'] = (string)$general->Duration_String;
		}
		if (isset($video->BitRate_String))
		{
			$exif['bitrate'] = (string)$video->BitRate_String;
		}
		if (isset($audio->SamplingRate_String))
		{
			$exif['sampling_rate'] = (string)$audio->SamplingRate_String;
		}
		if (isset($exif['width']) and isset($exif['height']))
		{
			$exif['resolution'] = $exif['width'] ."x". $exif['height'];
		}
		ksort($exif);
	}
	//print_r($exif)."\n<br/>\n";
	return $exif;
}

function vjs_metadata_available($show_metadata, $element_path)
{
	//print "VideoJS metadata_available\n";
	//print_r($element_path);
	return 1;
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

	// In case it is not an image but not a supported video file by the plugin
	if (vjs_valid_extension(get_extension($picture['current']['path'])) === false)
	{
		return $content;
	}

	// In case, we handle a large video, we define a MAX_HEIGHT
	// variable to limit the display size.
	$MAX_HEIGHT = isset($conf['vjs_conf']['max_height']) ? $conf['vjs_conf']['max_height'] : '480';
	if (isset($user['maxheight']) and $user['maxheight']!='')
	{
		$MAX_HEIGHT = $user['maxwidth'];
	}
	//print "MAX_HEIGHT=" . $MAX_HEIGHT;
	//print_r($user);

	$extension = vjs_get_mimetype_from_ext(get_extension($picture['current']['path']));
	//print "extension\n";
	//print_r($extension);

	// Video file -- Guess resolution base on height
	if (isset($picture['current']['width']))
	{
		$width = $picture['current']['width'];
	}
	if (isset($picture['current']['height']))
	{
		$height = $picture['current']['height'];
	}
	if ( !isset($width) || !isset($height))
	{
		// If guess was unsuccessful, fallback to default 16/9 resolution 720x480
		// This is the case for ogv video for example.
		$height = 480;
		$width  = round(16 * 480 / 9, 0);
	}
	//print "Video height=" . $height . " width=". $width;

	// Resize if video is too height
	//print $height .">". $MAX_HEIGHT;
	if ( $height > $MAX_HEIGHT )
	{
		$height = $MAX_HEIGHT;
		$width  = round(16 * $MAX_HEIGHT / 9, 0);
		//print "MAX_HEIGHT height=" . $height . " width=". $width;
	}

	// Upscale if video is too small
	$upscale = isset($conf['vjs_conf']['upscale']) ? strbool($conf['vjs_conf']['upscale']) : false;
	if ( $upscale and $height < $MAX_HEIGHT )
	{
		$height = $MAX_HEIGHT;
		$width  = round(16 * $MAX_HEIGHT / 9, 0);
		//print "UPSCALE height=" . $height . " width=". $width;
	}

	// Load parameter, fallback to default if unset
	$skin = isset($conf['vjs_conf']['skin']) ? $conf['vjs_conf']['skin'] : 'vjs-default-skin';
	$customcss = isset($conf['vjs_customcss']) ? $conf['vjs_customcss'] : '';
	$preload = isset($conf['vjs_conf']['preload']) ? $conf['vjs_conf']['preload'] : 'none';
	$loop = isset($conf['vjs_conf']['loop']) ? strbool($conf['vjs_conf']['loop']) : false;
	$controls = isset($conf['vjs_conf']['controls']) ? strbool($conf['vjs_conf']['controls']) : false;
	$volume = isset($conf['vjs_conf']['volume']) ? $conf['vjs_conf']['volume'] : '1';
	$language = isset($conf['vjs_conf']['language']) ? $conf['vjs_conf']['language'] : 'en';

	// Slideshow : The video needs to be launch automatically in
	// slideshow mode. The refresh of the page is set to the
	// duration of the video.
	$autoplay = isset($conf['vjs_conf']['autoplay']) ? strbool($conf['vjs_conf']['autoplay']) : false;
	if ( $page['slideshow'] )
	{
		$refresh = 20; // TODO move to separate DB to actualy get this details information
		$autoplay = true;
		$loop = false;
	}

	// Assing the CSS file according to the skin
	$available_skins = array(
		'vjs-default-skin' => 'video-js.min.css',
		'vjs-bluebox-skin' => 'bluebox-skin.css',
		'vjs-redtube-skin' => 'redtube-skin.css',
	);
	$skincss = $available_skins[$skin];

	// Guess the poster extension
	$file_wo_ext = pathinfo($picture['current']['path']);
	$file_dir = dirname($picture['current']['path']);
	$poster = embellish_url( $picture['current']['src_image']->get_path() );
	//print $poster;

	$parts = pathinfo($picture['current']['element_url']);
	// Try to find multiple video source
	$vjs_extensions = array('ogg', 'ogv', 'mp4', 'm4v', 'webm', 'webmv');
	$files_ext = array_merge(array(), $vjs_extensions, array_map('strtoupper', $vjs_extensions));
	// Add the current file in array
	$videos[] = array(
				'src' => embellish_url($picture['current']['element_url']),
				'ext' => $extension,
				'resolution' => 'SD'
			);
	// Add any other video source format
	foreach ($files_ext as $file_ext) {
		$file = $file_dir."/pwg_representative/".$file_wo_ext['filename'].".".$file_ext;
		$file_hd = $file_dir."/pwg_representative/".$file_wo_ext['filename']."_hd.".$file_ext;
		if (file_exists($file)){
			array_push($videos,
				   array (
					'src' => embellish_url(
						      get_gallery_home_url() . $file
						     ),
					'ext' => vjs_get_mimetype_from_ext($file_ext),
					'resolution' => 'SD'
					)
				  );
		} else if (file_exists($file_hd)){
                        array_push($videos,
                                   array (
                                        'src' => embellish_url(
                                                      get_gallery_home_url() . $file_hd
                                                     ),
                                        'ext' => vjs_get_mimetype_from_ext($file_ext),
                                        'resolution' => 'HD'
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

	/* Try to find WebVTT */
	$file = $file_dir."/pwg_representative/".$file_wo_ext['filename'].".vtt";
	$subtitles = null;
	if (file_exists($file))
		$subtitles ='<track kind="subtitles" src="'. embellish_url( get_gallery_home_url() . $file) .'" srclang="'. $language .'" label="English"></track>';

	/* Thumbnail videojs plugin */
	$thumbnails_plugin = isset($conf['vjs_conf']['plugins']['thumbnails']) ? strbool($conf['vjs_conf']['plugins']['thumbnails']) : false;
	$thumbnails = array();
	if ($thumbnails_plugin)
	{
		$filematch = $file_dir."/pwg_representative/".$file_wo_ext['filename']."-th_*";
		$matches = glob($filematch);

		if ( is_array ( $matches ) ) {
			foreach ( $matches as $filename) {
			     $ext = explode("-th_", $filename);
			     $second = explode(".", $ext[1]);
			     include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
			     include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
			     $rotate = pwg_image::get_rotation_angle_from_code($picture['current']['rotation']);
			     // ./galleries/videos/pwg_representative/trailer_480p-th_0.jpg
			     //echo "$filename second " . $second[0]. "\n";
			     $thumbnails[] = array(
							'second' => $second[0],
							'source' => embellish_url(get_gallery_home_url() . $filename),
							'rotate' => $rotate,
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
		// TODO Disable if playing on iOS, as it read the metadata itself
		if ($picture['current']['rotation'] != null)
		{
			include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
			include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
			// rotation is $picture['current']['rotation']
			// zoom is witdh / height
			$rotate = pwg_image::get_rotation_angle_from_code($picture['current']['rotation']);
			$zoomrotate = array(
						'rotate' => $rotate,
						'zoom'   => round($width / $height, 1, PHP_ROUND_HALF_DOWN)
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
		$derivatives = unserialize($conf['derivatives']);
		if (is_array($derivatives) and !empty($derivatives) and $derivatives['w']->file != null)
		{
			$watermark = array(
						'file'    => embellish_url(get_gallery_home_url() . $derivatives['w']->file),
						'xpos'    => $derivatives['w']->xpos,
						'ypos'    => $derivatives['w']->ypos,
						'xrepeat' => $derivatives['w']->xrepeat,
						'opacity' => $derivatives['w']->opacity,
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
			'VIDEOJS_POSTER_URL' => embellish_url(get_gallery_home_url().$poster),
			'VIDEOJS_PATH'       => embellish_url(get_gallery_home_url().VIDEOJS_PATH),
			'WIDTH'              => $width,
			'RATIO'              => round($height/$width*100, 2),
			'OPTIONS'            => $options,
			'VIDEOJS_SKIN'       => $skin,
			'VIDEOJS_SKINCSS'    => $skincss,
			'VIDEOJS_CUSTOMCSS'  => $customcss,
			'volume'             => $volume,
			'subtitles'          => $subtitles,
			'thumbnails'         => $thumbnails,
			'zoomrotate'         => $zoomrotate,
			'watermark'          => $watermark,
			'videos'             => $videos,
		)
	);

	// Return the rendered html
	$vjs_content = $template->parse('vjs_content', true);
	return $vjs_content;
}

function vjs_get_mimetype_icon($location, $element_info)
{
	if (in_array($element_info, array('ogg', 'ogv', 'mp4', 'm4v', 'webm', 'webmv')))
	{
		$location = 'plugins/'
			. basename(dirname(__FILE__))
			. '/mimetypes/' . $element_info . '.png';
	}
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

function vjs_valid_extension($file_ext)
{
	$vjs_types = array(
			'ogg'   => 'video/ogg',
			'ogv'   => 'video/ogg',
			'mp4'   => 'video/mp4',
			'm4v'   => 'video/mp4',
			'webm'  => 'video/webm',
			'webmv' => 'video/webm'
			);
	return array_key_exists(strtolower($file_ext), $vjs_types) ? true : false;
}

function vjs_dbSet($fields, $data = array())
{
    if (!$data) $data = &$_POST;
    $set='';
    foreach ($fields as $field)
    {
        if (isset($data[$field]) and strlen($data[$field]) > 0)
        {
            $set.="`$field`='".pwg_db_real_escape_string($data[$field])."', ";
        }
    }
    return substr($set, 0, -2);
}

?>
