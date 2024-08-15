<?php
/***********************************************
* File      :   function_caller.php
* Project   :   piwigo-videojs
* Descr     :   Executes external programs with system() or exec()
*               according to availability
*
* Created   :   26.12.2023
*
* Copyright 2023 <eddy@lelievre-berna.net>
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

// Returns if system() or exec() is allowed
function isAvailable($func)
{
    if (ini_get('safe_mode')) return false;
    $disabled = ini_get('disable_functions');
    if ($disabled) {
        $disabled = explode(',', $disabled);
        $disabled = array_map('trim', $disabled);
        return !in_array($func, $disabled);
    }
    return true;
}

function execCMD($cmd)
{
	global $logger;
	$retval = null;
	$output = null;
	
	if (isAvailable('system')) {
		$output = system($cmd, $retval);
		$logger->info('system('.$cmd.') returns '.$output.', retval: '.$retval);
		return $retval;
	} 
	else if (isAvailable('exec')) {
		exec($cmd, $output, $retval);
		$outputStr = implode(',', $output);
		$logger->info('exec('.$cmd.') returns '.$outputStr.', retval: '.$retval);
		return $retval;
	}
	return 127;
}
