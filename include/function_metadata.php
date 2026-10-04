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

/* Returns the first non-empty value found in $source (array or SimpleXMLElement)
 * for the given key names, as a trimmed string. Array values are joined with ', '. */
function vjs_first_text($source, $names) {
	foreach ($names as $name)
	{
		/* MediaInfo (SimpleXMLElement) stores its fields as child elements */
		if ($source instanceof SimpleXMLElement and isset($source->{$name}))
		{
			$value = $source->{$name};
		}
		else if (isset($source[$name]))
		{
			$value = $source[$name];
		}
		else
		{
			continue;
		}
		if (is_array($value))
		{
			$value = implode(', ', array_filter(array_map('strval', $value), 'strlen'));
		}
		$value = trim((string)$value);
		if (strlen($value) > 0)
		{
			return $value;
		}
	}
	return '';
}

/* Cleans up a keyword list (separated by , ; or newlines): returns it as 'a, b, c' without duplicates */
function vjs_clean_keywords($keywords) {
	$list = array();
	foreach (preg_split('/[,;\r\n]+/', (string)$keywords) as $keyword)
	{
		$keyword = trim($keyword);
		if (strlen($keyword) > 0 and !in_array(mb_strtolower($keyword), array_map('mb_strtolower', $list)))
		{
			$list[] = $keyword;
		}
	}
	return implode(', ', $list);
}

/* Returns the altitude (e.g. '29.2 m') of an ISO 6709 location such as '+35.6445-139.7455+029.201/', or '' */
function vjs_iso6709_altitude($gps) {
	$value = preg_split('/(\+|\-|\/)/', (string)$gps, -1, PREG_SPLIT_DELIM_CAPTURE);
	if (isset($value[5]) and isset($value[6]) and ($value[5] === '+' or $value[5] === '-') and is_numeric($value[6]))
	{
		return (float)($value[5].$value[6]).' m';
	}
	return '';
}

/* Returns 'HDR10 (PQ)' or 'HLG' from a transfer characteristic given by name or by
 * ITU-T H.273 code (16 = SMPTE ST 2084, 18 = ARIB STD-B67), 'Dolby Vision' if flagged, or '' */
function vjs_hdr_label($transfer, $dolbyVision = false) {
	$transfer = strtolower(trim((string)$transfer));
	$hdr = array();
	if ($transfer === '16' or strpos($transfer, '2084') !== false or $transfer === 'pq')
	{
		$hdr[] = 'HDR10 (PQ)';
	}
	else if ($transfer === '18' or strpos($transfer, 'b67') !== false or $transfer === 'hlg')
	{
		$hdr[] = 'HLG';
	}
	if ($dolbyVision)
	{
		$hdr[] = 'Dolby Vision';
	}
	return implode(' + ', $hdr);
}

/* Summarizes tracks from their languages: '2 (eng, fra)', or '1' if no language is known */
function vjs_track_summary($languages) {
	$known = array();
	foreach ($languages as $language)
	{
		$language = trim((string)$language);
		if ($language !== '' and strtolower($language) !== 'und' and !in_array($language, $known))
		{
			$known[] = $language;
		}
	}
	return count($languages).(count($known) > 0 ? ' ('.implode(', ', $known).')' : '');
}

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
