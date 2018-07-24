<?php
/***********************************************
* File      :   function_dependencies.php
* Project   :   piwigo-videojs
* Descr     :   Check for external program dependencies
*
* Created   :   26.09.2014
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

// Do the dependencies checks for MediaInfo & FFMPEG & FFPROBE & exiftool
if (!function_exists('check'))   { // Avoid Fatal error: Cannot redeclare
function check($binary, $sync_options)
{
    $retval = 0;
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system($sync_options[$binary] ." >NUL 2>NUL", $retval); // redirect any output
    } else {
        system($sync_options[$binary] ." 1>&2 /dev/null", $retval); // redirect any output
    }
    //print $retval;
    if($retval == 127 or $retval == 9009) // Linux or windows exit code for command not found.
    {
        return false;
    } else {
        return true;
    }
}
}

// For each external tools try
$binaries = array('mediainfo', 'ffprobe', 'exiftool', 'ffmpeg');
$sync_binaries = [];
foreach ($binaries as $binary)
{
 $sync_binaries[$binary] = check($binary, $sync_options);
 /* If failed */
 if (!$sync_binaries[$binary])
 {
    if ($binary != 'ffmpeg')
    {
       $warnings[] = "Metadata parsing disable because ".$binary." is not installed on the system, eg: '/usr/bin/".$binary."'.";
       $sync_options['metadata'] ? true : false;
    }
    if ($binary == 'ffmpeg')
    {
      $warnings[] = "Poster and Thumbnail creation disable because FFmpeg is not installed on the system, eg: '/usr/bin/ffmpeg'.";
      $sync_options['poster'] = false;
      $sync_options['thumb'] = false;
    }
 }
}
//print_r($sync_binaries);
//print_r($sync_options);
?>
