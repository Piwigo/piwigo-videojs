<?php
/***********************************************
* File      :   exiftool.php
* Project   :   piwigo-videojs
* Descr     :   Handle general video parsing
*
* Created   :   02.04.2015
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
$json = shell_exec($sync_options['exiftool'] ." -struct -n -json \"". $filename."\"");
if (!isset($json) or empty($json))
	die("Exiftool error reading file. Is Exiftool install? Is Exiftool in path?<br/>Is the video accessible & readable, Try to run the command manually.<br/>". $sync_options['exiftool'] ." -json '". $filename ."'");
$output = json_decode($json, true);
//print_r($output);
} catch (Exception $e) {
	die("Exiftool error reading file. Is Exiftool install? Is Exiftool in path?<br/>Is the video accessible & readable, Try to run the command manually.<br/>". $sync_options['exiftool'] ." -json '". $filename ."'");
}

if ( !isset($output) and !is_array($output))
{
	$exif['error'] = "Exiftool error reading file: <br/>'". $filename."'";
}

if (isset($output[0]))
{
	$general = $output[0];
}

/* General */
if (isset($general['FileSize']))
{
	$exif['filesize'] = round($general['FileSize']/1024);
}
if (isset($general['Duration']))
{
	$exif['duration'] = round($general['Duration']*1000, 0);
}
if (isset($general['TrackDuration']))
{
	$exif['playtime_seconds'] = round($general['TrackDuration'], 0);
}
if (isset($general['AvgBitrate']))
{
	$exif['bitrate'] = (string)$general['AvgBitrate'];
}
if (isset($general['MediaCreateDate']))
{
	$exif['date_creation'] = date('Y-m-d H:i:s', strtotime((string)$general['MediaCreateDate']));
}
if (isset($general['GPSLatitude']) and isset($general['GPSLongitude']))
{
	$exif['latitude'] = $general['GPSLatitude'];
	$exif['longitude'] = $general['GPSLongitude'];
}
if (isset($general['MajorBrand']))
{
	$exif['codecid'] = $general['MajorBrand'];
}
if (isset($general['MIMEType']))
{
	$exif['type'] = $general['MIMEType'];
}
if (isset($general['FileType']))
{
	$exif['format'] = $general['FileType'];
}

/* Video */
if (isset($general['ImageWidth']))
{
	$exif['width'] = (string)$general['ImageWidth'];
}
if (isset($general['ImageHeight']))
{
	$exif['height'] = (string)$general['ImageHeight'];
}
if (isset($general['Rotation']) and (int)$general['Rotation'] != 0)
{
	include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
	$rotation_code = pwg_image::get_rotation_code_from_angle((int)$general['Rotation']);
	$exif['rotation'] = $rotation_code;
}
if (isset($general['VideoFrameRate']))
{
	$exif['frame_rate'] = $general['VideoFrameRate'];
}

/* Audio */
if (isset($general['AudioChannels']))
{
	$exif['channel'] = (string)$general['AudioChannels'];
}
if (isset($general['AudioSampleRate']))
{
	$exif['sampling_rate'] = (string)$general['AudioSampleRate'];
}

?>
