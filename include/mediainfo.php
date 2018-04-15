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
$output = shell_exec($sync_options['mediainfo'] ." --Full --Output=OLDXML --Language=raw \"". $filename."\"");
//$log = shell_exec("mediainfo --Output=XML ". $filename);
$xml = new SimpleXMLElement($output);
//$xml = simplexml_load_file("/tmp/mediainfo.xml");
//print_r($xml);
} catch (Exception $e) {
	die("Mediainfo error reading file. Is MediaInfo install? Is MediaInfo in path?<br/>Is the video accessible & readable, Try to run the command manually.<br/>". $sync_options['mediainfo'] ." --Full --Output=OLDXML --Language=raw '". $filename ."'");
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
*/
if (isset($xml["version"]))
{
	if (version_compare($xml["version"], '0.1') == 0)
	{
		$exif['warning'] = 'Please use at least MediaInfo version 0.7.87 or higher due to known bug: <a href="https://sourceforge.net/p/mediainfo/bugs/1002/" target="_blank">XML version is broken</a>.<br/>Upgrade or downgrade.<br/><a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">Please refer to the documentation</a>';
	}
	if (version_compare($xml["version"], '0.7.64') < 0)
	{
		$exif['error'] = "Please use at least MediaInfo version 0.7.64 or higher, not " . $xml["version"];
	}
	if (version_compare($xml["version"], '0.7.72') == 0)
	{
		$exif['error'] = 'Please DO NOT use MediaInfo version 0.7.72 due to Important known bug: <a href="https://sourceforge.net/p/mediainfo/bugs/886/" target="_blank">XML output is broken</a>.<br/>Upgrade or downgrade.<br/><a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">Please refer to the documentation</a>';
	}
}

/*
 *General
    [CompleteName] => /var/www/piwigo/galleries/videos/IMG_1090.mp4
    [InternetMediaType] => video/mp4
    [Format] => MPEG-4
    [FileSize] => 4.99 MiB
    [Duration] => 11s 322ms
    [OverallBitRate_String] => 3 699 Kbps
    [Recorded_Date] => 2013-06-04T17:02:15+0900
    [Encoded_Date] => UTC 2013-06-04 08:02:16
    [Tagged_Date] => UTC 2013-06-04 08:02:28
    [Encoded_Application] => 5.1.1
    [Encoded_Library] => Apple QuickTime
    [Make] => Apple
    [xyz] => +35.6445+139.7455+029.201/
    [Model] => iPhone 3GS
    [comapplequicktimemodel] => iPhone 3GS
    [comapplequicktimesoftware] => 5.1.1
    [comapplequicktimemake] => Apple
    [comapplequicktimelocationISO6709] => +35.6445+139.7455+029.201/
    [comapplequicktimecreationdate] => 2013-06-04T17:02:15+0900
*/
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
    $exif['playtime_seconds'] = (int)($general->Duration/1000);
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
    $value = preg_split('/(\+|\-)/', $gps, -1, PREG_SPLIT_DELIM_CAPTURE);
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
/*
print $general->Format."<br/>\n";
print $general->FileSize."<br/>\n";
print $general->Duration."<br/>\n";
print $general->Recorded_Date."<br/>\n";
print $general->Make."<br/>\n";
print $general->xyz."<br/>\n";
print $general->Model."<br/>\n";
*/

/*
 *Video
    [BitRate] => 3592927
    [Width] => 640 pixels
    [Height] => 480 pixels
    [Display_aspect_ratio] => 4:3
    [Rotation] => 90°
    [Frame_rate] => 29.970 fps
*/
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
/*
print $video->Bit_rate[0]."<br/>\n";
print $video->Width[0]."<br/>\n";
print $video->Height[0]."<br/>\n";
print $video->Display_aspect_ratio[0]."<br/>\n";
print $video->Rotation[0]."<br/>\n";
print $video->Frame_rate[0]."<br/>\n";
*/

/*
 *Audio
    [Bit_rate] => 64.0 Kbps
    [Channel_s_] => 1 channel
    [Sampling_rate] => 44.1 KHz
*/
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


/*
print $audio->Bit_rate."<br/>\n";
print $audio->Channel_s_."<br/>\n";
print $audio->Channel_positions."<br/>\n";
print $audio->Sampling_rate."<br/>\n";
*/

?>
