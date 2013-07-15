<?php
/***********************************************
* File      :   mediainfo.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   9.07.2013
*
* Copyright 2012-2013 <xbgmsharp@gmail.com>
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

$output = shell_exec("mediainfo --Full --Output=XML --Language=raw ". $filename);
//$log = shell_exec("mediainfo --Output=XML ". $filename);
$xml = new SimpleXMLElement($output);
//$xml = simplexml_load_file("/tmp/mediainfo.xml");
//print_r($xml);

/*
 *General
    [Complete_name] => /var/www/piwigo/galleries/videos/IMG_1090.mp4
    [Internet_media_type] => video/mp4
    [Format] => MPEG-4
    [File_size] => 4.99 MiB
    [Duration] => 11s 322ms
    [Overall_bit_rate] => 3 699 Kbps
    [Recorded_date] => 2013-06-04T17:02:15+0900
    [Encoded_date] => UTC 2013-06-04 08:02:16
    [Tagged_date] => UTC 2013-06-04 08:02:28
    [Writing_application] => 5.1.1
    [Writing_library] => Apple QuickTime
    [Make] => Apple
    [xyz] => +35.6445+139.7455+029.201/
    [Model] => iPhone 3GS
    [comapplequicktimemodel] => iPhone 3GS
    [comapplequicktimesoftware] => 5.1.1
    [comapplequicktimemake] => Apple
    [comapplequicktimelocationISO6709] => +35.6445+139.7455+029.201/
    [comapplequicktimecreationdate] => 2013-06-04T17:02:15+0900
*/
$general = $xml->File->track[0];
if (isset($general->Format[0]))
{
    $exif['format'] = (string)$general->Format[0];
}
if (isset($general->Internet_media_type))
{
    $exif['type'] = (string)$general->Internet_media_type;
}
if (isset($general->File_size[0]))
{
    $exif['filesize'] = round($general->File_size[0]/1024);
}
if (isset($general->Duration[0]))
{
    $exif['duration'] = (string)$general->Duration[4];
    $exif['playtime_seconds'] = (int)($general->Duration[0]/1000);
}
if (isset($general->Overall_bit_rate[0]))
{
    $exif['overall_bit_rate'] = (string)$general->Overall_bit_rate[0];
}
if (isset($general->xyz[0]) and $sync_options['sync_gps'])
{
    //$test = "+35.6445-139.7455-029.201/";
    //print_r(preg_split('/(\+|\-)/', $general->xyz[0], -1, PREG_SPLIT_DELIM_CAPTURE));
    $value = preg_split('/(\+|\-)/', $general->xyz[0], -1, PREG_SPLIT_DELIM_CAPTURE);
    $exif['lat'] = $value[1].$value[2];
    $exif['lon'] = $value[3].$value[4];
}
if (isset($general->Model[0]))
{
    $exif['model'] = (string)$general->Model[0];
}
if (isset($general->comapplequicktimesoftware))
{
    $exif['model'] .= " ". (string)$general->comapplequicktimesoftware;
}
if (isset($general->Make[0]))
{
    $exif['make'] = (string)$general->Make[0];
}
if (isset($general->Recorded_date))
{
    $exif['date_creation'] = (string)$general->Recorded_date;
}
/*
print $general->Format[0]."<br/>\n";
print $general->File_size[0]."<br/>\n";
print $general->Duration[0]."<br/>\n";
print $general->Recorded_date[0]."<br/>\n";
print $general->Make[0]."<br/>\n";
print $general->xyz[0]."<br/>\n";
print $general->Model[0]."<br/>\n";
*/

/*
 *Video
    [Bit_rate] => 3 623 Kbps
    [Width] => 640 pixels
    [Height] => 480 pixels
    [Display_aspect_ratio] => 4:3
    [Rotation] => 90°
    [Frame_rate] => 29.970 fps
*/
$video = $xml->File->track[1];
if (isset($video->Width[0]))
{
    $exif['width'] = (string)$video->Width[0];
}
if (isset($video->Height[0]))
{
    $exif['height'] = (string)$video->Height[0];
}
if (isset($video->Display_aspect_ratio[1]))
{
    $exif['display_aspect_ratio'] = (string)$video->Display_aspect_ratio[1];
}
if (isset($video->Rotation[0]) and (int)$video->Rotation[0] != 0)
{
    include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');
    //print (int)$video->Rotation[0];
    $rotation_code = pwg_image::get_rotation_code_from_angle((int)$video->Rotation[0]);
    $exif['rotation'] = $rotation_code;
}
if (isset($video->Frame_rate[0]))
{
    $exif['frame_rate'] = (string)$video->Frame_rate[0];
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
$audio = $xml->File->track[2];
if (isset($audio->Channel_s_[0]))
{
    $exif['channel'] = (string)$audio->Channel_s_[0];
}
if (isset($audio->Sampling_rate[0]))
{
    $exif['sampling_rate'] = (string)$audio->Sampling_rate[0];
}
/*
print $audio->Bit_rate[0]."<br/>\n";
print $audio->Channel_s_[0]."<br/>\n";
print $audio->Channel_positions[0]."<br/>\n";
print $audio->Sampling_rate[0]."<br/>\n";
*/

?>
