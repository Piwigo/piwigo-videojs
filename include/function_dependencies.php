<?php
/***********************************************
* File      :   function_dependencies.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   26.09.2014
*
* Copyright 2012-2014 <xbgmsharp@gmail.com>
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

if ($sync_options['metadata'])
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system($sync_options['mediainfo'] ." >NUL 2>NUL", $retval); // redirect any output
    } else {
        system($sync_options['mediainfo'] ." 1>&2 /dev/null", $retval); // redirect any output
    }
    if($retval == 127 or $retval == 9009) // Linux or windows exit code for command not found.
    {
        $warnings[] = "Metadata parsing disable because MediaInfo is not installed on the system, eg: '/usr/bin/mediainfo'.";
        $sync_options['metadata'] = false;
    }
}

if ($sync_options['poster'] or $sync_options['thumb'])
{
    $retval = 0;
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system($sync_options['ffmpeg'] ." >NUL 2>NUL", $retval); // redirect any output
    } else {
        system($sync_options['ffmpeg'] ." 1>&2 /dev/null", $retval); // redirect any output
    }
    if($retval == 127 or $retval == 9009) // Linux or windows exit code for command not found.
    {
        $warnings[] = "Poster creation disable because FFmpeg is not installed on the system, eg: '/usr/bin/ffmpeg'.";
        $sync_options['poster'] = false;
        $sync_options['thumb'] = false;
    }
}

?>