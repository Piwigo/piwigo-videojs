<?php
/***********************************************
* File      :   function_dependencies.php
* Project   :   piwigo-videojs
* Descr     :   Check for external program dependencies
*
* Created   :   26.09.2014
*
* Copyright 2012-2024 <xbgmsharp@gmail.com>
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

include_once("function_caller.php");

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Check 'gd_info' and 'SimpleXMLElement'
if ($sync_options['posteroverlay'] and !function_exists('gd_info'))
{
        $warnings[] = "GD library is missing to add overlay movie frame";
}
if ($sync_options['metadata'] and isset($sync_options['mediainfo']) and !class_exists('SimpleXMLElement'))
{
        $warnings[] = "XML library is missing to use mediainfo";
}

// Do the dependencies checks for MediaInfo & FFMPEG & FFPROBE & exiftool
function check($binary)
{
	global $logger;
    $retval = 0;
    $logger->info(__FUNCTION__.' : checking '.$binary);
    
    # the version argument parameter
    $binary_version_arg = array(
        'exiftool' => '-ver',
        'ffmpeg' => '-version',
        'ffprobe' => '-version',
        'mediainfo' => '--Version'
    );

    if (array_key_exists($binary, $binary_version_arg)){
        $binary_args = $binary_version_arg[$binary];
    } else {
        $binary_args = '';
    }

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		$retval = execCMD($binary . " " . $binary_args . " >NUL 2>NUL"); // redirect any output
    } else {
		$retval = execCMD($binary . " " . $binary_args . " 2>&1 > /dev/null"); // redirect any output
    }
	if($retval == 0) { // Command found?
        return true;
    } else {
	    $logger->info(__FUNCTION__.' : system() and exec() unavailable!');
	    return false;
    }
}

/* Concat custom binary directory from local config local/config/config.inc.php */
$sync_binaries = array(
	'mediainfo'	=> isset($conf['vjs_mediainfo_dir']) ? $conf['vjs_mediainfo_dir'].$sync_options['mediainfo'] : $sync_options['mediainfo'],
	'exiftool'	=> isset($conf['vjs_exiftool_dir']) ? $conf['vjs_exiftool_dir'].$sync_options['exiftool'] : $sync_options['exiftool'],
	'ffprobe'	=> isset($conf['vjs_ffprobe_dir']) ? $conf['vjs_ffprobe_dir'].$sync_options['ffprobe'] : $sync_options['ffprobe'],
	'ffmpeg'	=> isset($conf['ffmpeg_dir']) ? $conf['ffmpeg_dir'].$sync_options['ffmpeg'] : $sync_options['ffmpeg'],
);

// For each external tools try
foreach ($sync_binaries as $binary => $path)
{
	if (check($path))
	{
		$sync_options[$binary] = $path;
	}
	else /* If failed */
	{
		$sync_options[$binary] = false;
		if ($binary == 'ffmpeg')
		{
			$warnings[] = "Poster and Thumbnail creation disable because FFmpeg is not installed on the system, eg: '/usr/bin/ffmpeg'.";
			$sync_options['poster'] = false;
			$sync_options['thumb'] = false;
		}
	}
}

if (!$sync_options['mediainfo'] and !$sync_options['exiftool'] and !$sync_options['ffprobe'])
{
       $warnings[] = "Metadata parsing disable because 'mediainfo' or 'exiftool' or 'ffprobe' is not installed on the system, eg: '/usr/bin/".$binary."'.";
       $sync_options['metadata'] = false;
}

//print_r($sync_binaries);
//print_r($sync_options);
?>
