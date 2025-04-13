<?php
/***********************************************
* File      :   function_metadata.php
* Project   :   piwigo-videojs
* Descr     :   Executes external programs with system() or exec()
*               according to availability
*
* Created   :   23.03.2025
*
* Copyright 2025 <eddy@lelievre-berna.net>
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

// Returns the file size in KB, MB, GB or TB
function formatBytes($bytes, $precision = 1) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
   
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1000, $pow);
   
    return round($bytes, $precision).' '.$units[$pow];
}

// Returns the data rate in Kbit/s, Mbit/s
function formatBitRate($bps, $precision = 1) { 
    $units = array('bit/s', 'Kbit/s', 'Mbit/s', 'Gbit/s'); 
   
    $bps = max($bps, 0); 
    $pow = floor(($bps ? log($bps) : 0) / log(1000));
    $pow = min($pow, count($units) - 1); 
    $bps /= pow(1000, $pow);
   
    return round($bps, $precision).' '.$units[$pow];
}

// Returns the video duration as "hh:mm:ss.sss"
function formatDuration($secs) {
	$hours = floor($secs / 3600);
	$secsMinutes = $secs - $hours * 3600;
	$minutes = floor($secsMinutes / 60);
	$seconds = round($secsMinutes - $minutes * 60, 3);
	
	return sprintf("%02d:%02d:%02.3f", $hours, $minutes, $seconds);
}

// Logs arrays, sub-arrays… of metadata
function logMetadata($prefix, $general) {
	global $logger;
	foreach ($general as $key => $value) {
		if (is_array($value)) {
			logMetadata($prefix.' ['.$key.']', $value);
		} else {
			$logger->debug($prefix.' ['.$key.'] => '.$value);
		}
	}
}
