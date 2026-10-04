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
// */

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
	// Account for negative numbers
	$angle = ((int)$video['tags']['rotate'] + 360) % 360;
	$rotation_code = pwg_image::get_rotation_code_from_angle($angle);
	$exif['rotation'] = $rotation_code;
} elseif (isset($video['side_data_list'][0]['rotation']) and (int)$video['side_data_list'][0]['rotation'] != 0) {
	include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
	// Account for negative numbers
	$angle = ((int)$video['side_data_list'][0]['rotation'] + 360) % 360;
	$rotation_code = pwg_image::get_rotation_code_from_angle($angle);
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
	if (($altitude = vjs_iso6709_altitude($gps)) !== '') { $exif['GPSAltitude'] = $altitude; }
}

/* Author: 'author', then 'artist', then 'com.apple.quicktime.author' */
foreach (array('author', 'artist', 'com.apple.quicktime.author') as $authorTag)
{
	if (isset($general['tags'][$authorTag]) and strlen(trim((string)$general['tags'][$authorTag])) > 0)
	{
		$exif['author'] = trim((string)$general['tags'][$authorTag]);
		break;
	}
}

/* Name, comment and tags, for the Piwigo SQL tables (used only to fill empty fields and add tags) */
$tags_lc = isset($general['tags']) ? array_change_key_case($general['tags'], CASE_LOWER) : array();
if (($value = vjs_first_text($tags_lc, array('title'))) !== '') { $exif['name'] = $value; }
if (($value = vjs_first_text($tags_lc, array('description', 'comment', 'synopsis'))) !== '') { $exif['comment'] = $value; }
if (($value = vjs_clean_keywords(vjs_first_text($tags_lc, array('keywords', 'category')))) !== '') { $exif['tags'] = $value; }

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
	if (is_array($parts) && count($parts) >= 2 && $parts[1] != 0) {
		$rate = (float)$parts[0] / (float)$parts[1];
		$exif['VideoFrameRate'] = round($rate,2).' fps';
	}
}
if (!isset($exif['VideoFrameRate']) && isset($general['duration']) && isset($video['nb_frames'])) {
	// Case where the frame rate could not be deduced from 'avg_frame_rate'
	if ($video['nb_frames'] > 0) {
		$rate = $video['nb_frames'] / (float)$general['duration'];
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

if (($value = vjs_first_text($tags_lc, array('copyright'))) !== '') { $exif['Copyright'] = $value; }

/* Video details */
if (isset($video['display_aspect_ratio']) and $video['display_aspect_ratio'] !== '0:1')
{
	$exif['AspectRatio'] = (string)$video['display_aspect_ratio'];
}
if (isset($video['profile']) and strlen((string)$video['profile']) > 0)
{
	$exif['VideoProfile'] = (string)$video['profile'];
	// The level is coded as 41 for H.264 level 4.1, 120 for HEVC level 4.0; -99 is unknown
	if (isset($video['level']) and is_numeric($video['level']) and (int)$video['level'] > 0)
	{
		$divisor = ($video['codec_name'] == 'hevc') ? 30 : (($video['codec_name'] == 'h264') ? 10 : 1);
		$exif['VideoProfile'] .= ' @ L'.round((int)$video['level'] / $divisor, 1);
	}
}
if (isset($video['pix_fmt']))
{
	$exif['PixelFormat'] = (string)$video['pix_fmt'];
	if (preg_match('/^(?:yuvj?|yuva)(4(?:20|22|44))/', $video['pix_fmt'], $matches))
	{
		$exif['ChromaSubsampling'] = implode(':', str_split($matches[1]));
	}
}
if (isset($video['bits_per_raw_sample']) and (int)$video['bits_per_raw_sample'] > 0)
{
	$exif['VideoBitDepth'] = (string)$video['bits_per_raw_sample'];
}
if (isset($video['field_order']) and $video['field_order'] !== 'unknown')
{
	$exif['ScanType'] = ($video['field_order'] == 'progressive') ? 'Progressive' : 'Interlaced';
}
if (isset($video['color_primaries'])) { $exif['ColorPrimaries'] = (string)$video['color_primaries']; }
if (isset($video['color_transfer'])) { $exif['TransferCharacteristics'] = (string)$video['color_transfer']; }
if (isset($video['color_space'])) { $exif['MatrixCoefficients'] = (string)$video['color_space']; }
$dolbyVision = false;
if (isset($video['side_data_list']) and is_array($video['side_data_list']))
{
	foreach ($video['side_data_list'] as $sideData)
	{
		if (isset($sideData['side_data_type']) and stripos($sideData['side_data_type'], 'DOVI') !== false) { $dolbyVision = true; }
	}
}
if (($value = vjs_hdr_label(isset($video['color_transfer']) ? $video['color_transfer'] : '', $dolbyVision)) !== '')
{
	$exif['HDR'] = $value;
}

/* Audio, subtitle tracks and chapters */
$audioLanguages = array();
$subtitleLanguages = array();
if (isset($output['streams']) and is_array($output['streams']))
{
	foreach ($output['streams'] as $stream)
	{
		$language = isset($stream['tags']['language']) ? $stream['tags']['language'] : '';
		if ($stream['codec_type'] == 'audio') { $audioLanguages[] = $language; }
		if ($stream['codec_type'] == 'subtitle') { $subtitleLanguages[] = $language; }
	}
}
if (count($audioLanguages) > 0) { $exif['AudioTracks'] = vjs_track_summary($audioLanguages); }
if (count($subtitleLanguages) > 0) { $exif['SubtitleTracks'] = vjs_track_summary($subtitleLanguages); }
if (isset($output['chapters']) and is_array($output['chapters']) and count($output['chapters']) > 0)
{
	$exif['Chapters'] = (string)count($output['chapters']);
}

/* Camera, Software */
if (isset($general['tags']['com.apple.quicktime.make']))
{
    $exif['Make'] = $general['tags']['com.apple.quicktime.make'];
}
if (isset($general['tags']['com.apple.quicktime.model']))
{
    $exif['Model'] = $general['tags']['com.apple.quicktime.model'];
}
if (isset($general['tags']['com.apple.quicktime.software']))
{
    $exif['Software'] = $general['tags']['com.apple.quicktime.software'];
}

?>
