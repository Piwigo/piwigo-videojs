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
        $warnings[] = l10n('SYNC_POSTEROVERLAY_ERROR');
}
if ($sync_options['metadata'] and isset($sync_options['mediainfo']) and !class_exists('SimpleXMLElement'))
{
        $warnings[] = l10n('SYNC_MEDIAINFO_ERROR');
}

// Do the dependencies checks for MediaInfo & FFmpeg & FFprobe & ExifTool
function check($binary)
{
	global $logger;
//	$logger->debug('checking '.$binary.':');

	// Determine appropriate argument
	if (str_contains($binary, 'exiftool')) {
		$cmd = $binary.' -ver';
	}
	else if (str_contains($binary, 'ffmpeg') || str_contains($binary, 'ffprobe')) {
		$cmd = $binary.' -version';
	} 
	else if (str_contains($binary, 'mediainfo')) {
		$cmd = $binary.' --Version';
	}
	else { 
		return false; 
	}
	
	// Execute the test
    $retval = 0;
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		$retval = execCMD($cmd.' >NUL 2>NUL'); 			// redirect any output
    }
    else {
		$retval = execCMD($cmd.' 2>&1 >/dev/null');		// redirect any output
    }
    
    // Command found?
	if ($retval == 0) {
        return true;
    }
    else {
	    $logger->debug('ERROR: Calling '.$binary.' did fail.');
	    return false;
    }
}

/* Concat custom binary directory from local config local/config/config.inc.php */
$sync_binaries = array(
	'exiftool'	=> isset($conf['vjs_exiftool_dir']) ? $conf['vjs_exiftool_dir'].$sync_options['exiftool'] : $sync_options['exiftool'],
	'ffprobe'	=> isset($conf['vjs_ffprobe_dir']) ? $conf['vjs_ffprobe_dir'].$sync_options['ffprobe'] : $sync_options['ffprobe'],
	'ffmpeg'	=> isset($conf['ffmpeg_dir']) ? $conf['ffmpeg_dir'].$sync_options['ffmpeg'] : $sync_options['ffmpeg'],
	'mediainfo'	=> isset($conf['vjs_mediainfo_dir']) ? $conf['vjs_mediainfo_dir'].$sync_options['mediainfo'] : $sync_options['mediainfo'],
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
			$warnings[] = l10n('SYNC_POSTER_ERROR');
			$sync_options['poster'] = false;
			$sync_options['thumb'] = false;
		}
	}
}

if (!$sync_options['mediainfo'] and !$sync_options['exiftool'] and !$sync_options['ffprobe'])
{
       $warnings[] = l10n('SYNC_METADATA_ERROR');
       $sync_options['metadata'] = false;
}

//print_r($sync_binaries);
//print_r($sync_options);
?>
