<?php
/***********************************************
* File      :   mediainfo.php
* Project   :   piwigo-videojs
* Descr     :   Handle metadata video parsing
*
* Created   :   9.07.2013
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
$output = shell_exec($sync_options['mediainfo'] ." --Full --Output=XML --Language=raw \"". $filename."\" 2>&1 ");
//$log = shell_exec("mediainfo --Output=XML ". $filename);
$xml = new SimpleXMLElement($output);
//$xml = simplexml_load_file("/tmp/mediainfo.xml");
//print_r($xml);
} catch (Exception $e) {
	die("Mediainfo error reading file. Is MediaInfo install? Is MediaInfo in path?<br/>Is the video accessible & readable, Try to run the command manually.<br/>". $sync_options['mediainfo'] ." --Full --Output=XML --Language=raw '". $filename ."'<br/>output: ". $output);
}

if (!isset($xml->media)&&!isset($xml->File))
{
	$exif['error'] = "Mediainfo error reading file: <br/>'". $filename."'";
}
/*
[version] => 0.7.58 Initial usage of MediaInfo
[version] => 0.7.64 Change XML Output
[version] => 0.7.72 [mediainfo:bugs] #886 XML Output broken / https://sourceforge.net/p/mediainfo/bugs/886/
[version] => from v0.7.83 to v0.7.86 [mediainfo:bugs] #1002 XML version / https://sourceforge.net/p/mediainfo/bugs/1002/
[version] => 0.2 starting version 18.x
*/
if (isset($xml["version"]))
{
	if (version_compare($xml["version"], '0.1') == 0)
	{
		$exif['warning'] = 'Please use at least MediaInfo version 0.7.87 or higher due to known bug: <a href="https://sourceforge.net/p/mediainfo/bugs/1002/" target="_blank">XML version is broken</a>.<br/>Upgrade or downgrade.<br/><a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">Please refer to the documentation</a>';
	}
	if (version_compare($xml["version"], '0.7.64', '<=') and version_compare($xml["version"], '0.7.72', '>='))
	{
		$exif['error'] = "Please use at least MediaInfo version 0.7.64 or higher, not " . $xml["version"];
	}
	if (version_compare($xml["version"], '0.7.72') == 0)
	{
		$exif['error'] = 'Please DO NOT use MediaInfo version 0.7.72 due to important known bug: <a href="https://sourceforge.net/p/mediainfo/bugs/886/" target="_blank">XML output is broken</a>.<br/>Upgrade or downgrade.<br/><a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">Please refer to the documentation</a>';
	}
        // Version 18.x, again the version is not related to the software version...
	// https://sourceforge.net/p/mediainfo/discussion/297610/thread/13418119/#bcb9/e2cf
	if (version_compare($xml["version"], '0.2') == 0)
	{
		$exif['warning'] = 'MediaInfo version 18.x or higher detected, please use ffprobe or Exiftool instead.';
	}
}

/* General */
if (isset($xml->media))
{
        $general = $xml->media->track[0];
}else{
        $general = $xml->File->track[0];
}

if (isset($general->Format))
{
    $exif['format'] = (string)$general->Format;
}
if (isset($general->Format_Profile))
{
    $exif['formatprofile'] = (string)$general->Format_Profile;
}
if (isset($general->CodecID))
{
    $exif['codecid'] = (string)$general->CodecID;
}
if (isset($general->InternetMediaType)) //Not present in XML schema version 2.0beta1 (https://mediaarea.net/mediainfo/mediainfo_2_0.xsd).
{
    $exif['type'] = (string)$general->InternetMediaType;
}
if (isset($general->FileSize))
{
    $exif['filesize'] = round($general->FileSize/1024);
}
if (isset($general->Duration))
{
    $exif['duration'] = (string)$general->Duration;
    if ($xml["version"] != '0.2') { // Old format
       $exif['playtime_seconds'] = (int)($general->Duration);
    } else { // New format
       $exif['playtime_seconds'] = round($general->Duration, 0);
    }
}
if (isset($general->BitRate_String))  //Not present in XML schema version 2.0beta1 (https://mediaarea.net/mediainfo/mediainfo_2_0.xsd).
{
    $exif['overall_bit_rate'] = (string)$general->BitRate_String;
}
if (isset($general->xyz) or isset($general->comapplequicktimelocationISO6709))	//Not present in XML schema version 2.0beta1 (https://mediaarea.net/mediainfo/mediainfo_2_0.xsd).
{
    isset($general->xyz) ? $gps = (string)$general->xyz : $gps = (string)$general->comapplequicktimelocationISO6709;
    //$test = "+35.6445-139.7455-029.201/";
    //print_r(preg_split('/(\+|\-)/', $general->xyz, -1, PREG_SPLIT_DELIM_CAPTURE));
    $value = preg_split('/(\+|\-|\/)/', $gps, -1, PREG_SPLIT_DELIM_CAPTURE);
    $exif['latitude'] = $value[1].$value[2];
    $exif['longitude'] = $value[3].$value[4];
}
if (isset($general->Model) or isset($general->comapplequicktimemodel)) 	//Not present in XML schema version 2.0beta1 (https://mediaarea.net/mediainfo/mediainfo_2_0.xsd).
{
    isset($general->Model) ? $exif['model'] = (string)$general->Model : $exif['model'] = (string)$general->comapplequicktimemodel;
}
if (isset($general->comapplequicktimesoftware) and isset($exif['model']))  //Not present in XML schema version 2.0beta1 (https://mediaarea.net/mediainfo/mediainfo_2_0.xsd).
{
    $exif['model'] .= " ". (string)$general->comapplequicktimesoftware;
}
if (isset($general->Make) or isset($general->comapplequicktimemake)) //Not present in XML schema version 2.0beta1 (https://mediaarea.net/mediainfo/mediainfo_2_0.xsd).
{
    isset($general->Make) ? $exif['make'] = (string)$general->Make : $exif['make'] = (string)$general->comapplequicktimemake;
}
if (isset($general->Recorded_Date))
{
    $exif['date_creation'] = (string)$general->Recorded_Date;
}
if (!isset($exif['date_creation']) and isset($general->Encoded_Date))
{// http://piwigo.org/forum/viewtopic.php?pid=158021#p158021
    $exif['date_creation'] = date('Y-m-d H:i:s', strtotime((string)$general->Encoded_Date));
}


/* Video */
if (isset($xml->media))
{
        $video = $xml->media->track[1];
}else{
        $video = $xml->File->track[1];
}

if (isset($video->BitRate))
{
    $exif['bitrate'] = (string)$video->BitRate;
}
if (isset($video->Width))
{
    $exif['width'] = (string)$video->Width;
}
if (isset($video->Height))
{
    $exif['height'] = (string)$video->Height;
}
if (isset($video->DisplayAspectRatio))
{
    $exif['display_aspect_ratio'] = (string)$video->DisplayAspectRatio;
}
if (isset($video->Rotation) and (int)$video->Rotation != 0)
{
    include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
    //print (int)$video->Rotation[0];
    $rotation_code = pwg_image::get_rotation_code_from_angle((int)$video->Rotation);
    $exif['rotation'] = $rotation_code;
}
if (isset($video->FrameRate))
{
    $exif['frame_rate'] = (string)$video->FrameRate;
}

/* Audio */
if (isset($xml->media))
{
        $audio = $xml->media->track[2];
}else{
        $audio = $xml->File->track[2];
}

if (isset($audio->Channels))
{
    $exif['channel'] = (string)$audio->Channels;
}
if (isset($audio->SamplingRate))
{
    $exif['sampling_rate'] = (string)$audio->SamplingRate;
}

if (isset($audio->Channel_s_))
{
    $exif['channel'] = (string)$audio->Channel_s_;
}
if (isset($audio->SamplingRate))
{
    $exif['sampling_rate'] = (string)$audio->SamplingRate;
}

?>
