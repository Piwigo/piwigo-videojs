<?php
/***********************************************
* File      :   ffprobe.php
* Project   :   piwigo-videojs
* Descr     :   Handle metadata video parsing
*
* Created   :   21.07.2018
*
* Copyright 2012-2025 <xbgmsharp@gmail.com>
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

try {
	putenv('LANG=en_US.UTF-8');
	$json = shell_exec($sync_options['ffprobe'] ." -hide_banner -loglevel fatal -show_error -show_format -show_streams -show_programs -show_chapters -show_private_data -print_format json \"". $filename."\"");
	if (!isset($json) or empty($json))
		die("ffprobe error reading file. Is ffprobe install? Is ffprobe in path?<br/>Is the video accessible & readable, Try to run the command manually.<br/>". $sync_options['ffprobe'] ." -hide_banner -loglevel fatal -show_error -show_format -show_streams -print_format json '". $filename ."'");
	$output = json_decode($json, true);
} catch (Exception $e) {
	die("ffprobe error reading file. Is ffprobe install? Is ffprobe in path?<br/>Is the video accessible & readable, Try to run the command manually.<br/>". $sync_options['ffprobe'] ." -hide_banner -loglevel fatal -show_error -show_format -show_streams -print_format json '". $filename ."'");
}

// Could we extract the metadata?
if ( !isset($output) and !is_array($output))
{
	$exif['error'] = "ffprobe error reading file: <br/>'". $filename."'";
}

// Any error reported by ffprobe? 
if ( isset($output['error']) and isset($output['error']['string']))
{
	$exif['error'] = "ffprobe error reading output json: <br/>'". $output['error']['string']."'";
}

// Was the format and streams returned?
if ( !isset($output['format']) and !isset($output['streams']))
{
	if (!is_array($output)) { $exif['error'] = "ffprobe error reading output json: <br/>'". $output."'"; }
}

// var_dump($output);
if (isset($output['format']))
{
	$general = $output['format'];
}

/* Find which stream is audio and video if any */
if (isset($output['streams']) and is_array($output['streams']) and !empty($output['streams']) and (count($output['streams']) > 0))
{
	foreach ($output['streams'] as $stream)
	{
		if ($stream['codec_type'] == 'video')
		{
			$video = $stream;
		}
		if ($stream['codec_type'] == 'audio')
		{
			$audio = $stream;
		}
	}
}

include_once("function_metadata.php");

/* For debugging */
/*
global $logger;
$logger->debug('ffprobe: ===================================>>');
$logger->debug('ffprobe: ===> $general...');
logMetadata('ffprobe', $general);
$logger->debug('ffprobe: ===> $video...');
logMetadata('ffprobe', $video);
$logger->debug('ffprobe: ===> $audio...');
logMetadata('ffprobe', $audio);
$logger->debug('ffprobe: <<===================================');
 */

/* For the Piwigo SQL table */
if (isset($general['size']))
{
	// The size must be stored in kB
	$exif['filesize'] = (float)$general['size'] / 1024;
}
if (isset($video['width']))
{
	$exif['width'] = (string)$video['width'];
}
if (isset($video['height']))
{
	$exif['height'] = (string)$video['height'];
}
if (isset($video['tags']['rotate']) and (int)$video['tags']['rotate'] != 0)
{
	include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
	$rotation_code = pwg_image::get_rotation_code_from_angle((int)$video['tags']['rotate']);
	$exif['rotation'] = $rotation_code;
}
if (isset($general['tags']['creation_time']))
{
//	$logger->debug('ffprobe: date creation is '.$general['tags']['creation_time']);
	$exif['date_creation'] = date('Y-m-d H:i:s', strtotime((string)$general['tags']['creation_time']));
}
if (isset($general['tags']['location']))
{
	$gps = (string)$general['tags']['location'];
	$value = preg_split('/(\+|\-|\/)/', $gps, -1, PREG_SPLIT_DELIM_CAPTURE);
	$exif['latitude'] = $value[1].$value[2];
	$exif['longitude'] = $value[3].rtrim($value[4],'/');
}

/* For the VideoJS SQL table */
if (isset($general['size']))
{
    // In a readable format
	$exif['FileSize'] = formatBytes((float)$general['size']);
}
if (isset($general['duration']))
{
	// Duration as "hh:mm:ss.xxx"
	$exif['Duration'] = formatDuration((float)$general['duration']);
	// Number of seconds
	$exif['DurationSeconds'] = round((float)$general['duration'], 3);
}
if (isset($general['bit_rate']))
{
	$exif['AvgBitrate'] = formatBitRate((float)$general['bit_rate']);
}

/* Video */
if (isset($video['bit_rate']))
{
    $exif['VideoBitrate'] = (string)$video['bit_rate'];
}
if (isset($video['avg_frame_rate']))
{
	$parts = explode("/", $video['avg_frame_rate']);
	if (is_array($parts) && (float)$parts[1] != 0) {
		$rate = (float)$parts[0] / (float)$parts[1];
		$exif['VideoFrameRate'] = round($rate,2).' fps';
	}
}
if (isset($video['codec_tag_string']))
{
	$exif['VideoCodecID'] = $video['codec_tag_string'];
}
if (isset($video['codec_long_name']))
{
    $exif['VideoCodecInfo'] = (string)$video['codec_long_name'];
}

/* Audio */
if (isset($audio['codec_tag_string']))
{
	$exif['AudioCodecID'] = $audio['codec_tag_string'];
}
if (isset($audio['codec_long_name']))
{
	$exif['AudioCodecInfo'] = $audio['codec_long_name'];
}
if (isset($audio['channels']))
{
	$exif['AudioChannels'] = (string)$audio['channels'];
}
if (isset($audio['sample_rate']))
{
	$exif['AudioSampleRate'] = ((float)$audio['sample_rate']/1000).' kHz';
}

/* Title, Author, etc. */
if (isset($general['tags']['title']))
{
    $exif['Title'] = $general['tags']['title'];
}
if (isset($general['tags']['genre']))
{
    $exif['Genre'] = $general['tags']['genre'];
}
if (isset($general['tags']['artist']))
{
    $exif['Artist'] = $general['tags']['artist'];
}
if (isset($general['tags']['description']))
{
    $exif['Description'] = $general['tags']['description'];
}

/* Camera, Software */

?>
