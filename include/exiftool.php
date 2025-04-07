<?php
/***********************************************
* File      :   exiftool.php
* Project   :   piwigo-videojs
* Descr     :   Handle general video parsing
*
* Created   :   02.04.2015
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

include_once("function_metadata.php");

/* For debugging */
global $logger;
$logger->debug('exiftool: ===================================>>');
logMetadata('exiftool', $general);
$logger->debug('exiftool: <<===================================');

/* For the Piwigo SQL table */
if (isset($general['FileSize']))
{
	// The size must be stored in kB
	$exif['filesize'] = (float)$general['FileSize'] / 1024;
}
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
if (isset($general['MediaCreateDate']))
{
	if (str_contains($general['MediaCreateDate'], ':'))
	{
		if ((strcmp($general['MediaCreateDate'], "0000:00:00 00:00:00") !== 0) and
			($timestamp = strtotime($general['MediaCreateDate'])) === true)
		{
			$exif['date_creation'] = date('Y-m-d H:i:s', strtotime($timestamp));
		}
	}
	else
	{
		$exif['date_creation'] = date('Y-m-d H:i:s', substr($general['MediaCreateDate'], 0, 10));
	}
}
if (isset($general['GPSLatitude']) and isset($general['GPSLongitude']))
{
	$exif['latitude'] = $general['GPSLatitude'];
	$exif['longitude'] = $general['GPSLongitude'];
}

/* For the VideoJS SQL table */
if (isset($general['FileSize']))
{
    // In a readable format
	$exif['FileSize'] = formatBytes((float)$general['FileSize']);
}
if (isset($general['FileType']))
{
	$exif['FileType'] = $general['FileType'];
}
if (isset($general['MIMEType']))
{
	$exif['MIMEtype'] = $general['MIMEType'];
}
if (isset($general['Duration']))
{
	// Duration as "hh:mm:ss.xxx", Duration of number of seconds
	if (is_array($general['Duration']))
	{
		$durationArray = $general['Duration'];
		$duration = $durationArray['Scale'] * $durationArray['Value'];
		$exif['Duration'] = formatDuration((float)($duration * 1000));
		$exif['DurationSeconds'] = round((float)($duration * 1000), 3);
	}
	else 
	{
		$exif['Duration'] = formatDuration((float)$general['Duration']);
		$exif['DurationSeconds'] = round((float)$general['Duration'], 3);
	}
}
if (!isset($exif['Duration']) and isset($general['TrackDuration']))
{
	// Duration as "hh:mm:ss.xxx"
	$exif['Duration'] = formatDuration((float)$general['TrackDuration']);
	// Duration of number of seconds
	$exif['DurationSeconds'] = round($general['TrackDuration'], 3);
}
if (isset($general['AvgBitrate']))
{
	$exif['AvgBitrate'] = formatBitRate((float)$general['AvgBitrate']);
}

/* Video */
if (isset($general['VideoFrameRate']))
{
	$exif['VideoFrameRate'] = round($general['VideoFrameRate'],2).' fps';
}
if (isset($general['MajorBrand']))
{
	$exif['VideoCodecID'] = $general['MajorBrand'];
}

/* Audio */
if (isset($general['AudioFormat']))
{
	$exif['AudioCodecID'] = $general['AudioFormat'];
}
if (isset($general['AudioBitsPerSample']))
{
	$exif['AudioBitsPerSample'] = (string)$general['AudioBitsPerSample'];
}
if (isset($general['AudioChannels']))
{
	$exif['AudioChannels'] = (string)$general['AudioChannels'];
}
if (isset($general['AudioSampleRate']))
{
	$exif['AudioSampleRate'] = ((float)$general['AudioSampleRate']/1000).' kHz';
}

/* Title, Author, etc. */
if (isset($general['Title']))
{
    $exif['Title'] = $general['Title'];
}
if (isset($general['Genre']))
{
    $exif['Genre'] = $general['Genre'];
}
if (isset($general['Artist']))
{
    $exif['Artist'] = $general['Artist'];
}
if (isset($general['Description']))
{
    $exif['Description'] = $general['Description'];
}

/* Camera, Software */

?>
