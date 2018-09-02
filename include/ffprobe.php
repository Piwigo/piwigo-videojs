<?php
/***********************************************
* File      :   ffprobe.php
* Project   :   piwigo-videojs
* Descr     :   Handle metadata video parsing
*
* Created   :   21.07.2018
*
* Copyright 2012-2018 <xbgmsharp@gmail.com>
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
//print_r($output);
} catch (Exception $e) {
	die("ffprobe error reading file. Is ffprobe install? Is ffprobe in path?<br/>Is the video accessible & readable, Try to run the command manually.<br/>". $sync_options['ffprobe'] ." -hide_banner -loglevel fatal -show_error -show_format -show_streams -print_format json '". $filename ."'");
}

if ( !isset($output) and !is_array($output))
{
	$exif['error'] = "ffprobe error reading file: <br/>'". $filename."'";
}

if ( isset($output['error']) and isset($output['error']['string']))
{
	$exif['error'] = "ffprobe error reading output json: <br/>'". $output['error']['string']."'";
}

if ( !isset($output['format']) and !isset($output['streams']))
{
	if (!is_array($output)) { $exif['error'] = "ffprobe error reading output json: <br/>'". $output."'"; }
}

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

/* General */
if (isset($general['size']))
{
	$exif['filesize'] = round($general['size']/1024);
}
if (isset($general['duration']))
{
	$exif['duration'] = round($general['duration']*1000, 0);
	$exif['playtime_seconds'] = round($general['duration'], 0);
}
if (isset($general['bit_rate']))
{
	$exif['bitrate'] = (string)$general['bit_rate'];
}
if (isset($general['tags']['creation_time']))
{
	$exif['date_creation'] = date('Y-m-d H:i:s', strtotime((string)$general['tags']['creation_time']));
}
if (isset($general['tags']['location']))
{
	$gps = (string)$general['tags']['location'];
	$value = preg_split('/(\+|\-|\/)/', $gps, -1, PREG_SPLIT_DELIM_CAPTURE);
	$exif['latitude'] = $value[1].$value[2];
	$exif['longitude'] = $value[3].$value[4];
}
if (isset($general['tags']['major_brand']))
{
	$exif['codecid'] = $general['tags']['major_brand'];
}

/* Video */
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
if (isset($video['tags']['avg_frame_rate']))
{
	$exif['frame_rate'] = $video['tags']['avg_frame_rate'];
}

/* Audio */
if (isset($audio['channels']))
{
	$exif['channel'] = (string)$audio['channels'];
}
if (isset($audio['sample_rate']))
{
	$exif['sampling_rate'] = (string)$audio['sample_rate'];
}

?>
