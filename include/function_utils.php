<?php
/***********************************************
* File      :   function_utils.php
* Project   :   piwigo-videojs
* Descr     :   Utility functions
*
* Created   :   2022/05/20
*
* Copyright 2022 <bcl@brianlane.com>
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

function check_date($value) {
    if (preg_match('/^(\d{4}).(\d{2}).(\d{2}) (\d{2}).(\d{2}).(\d{2})/', $value, $matches))
    {
        $norm_date = $matches[1].'-'.$matches[2].'-'.$matches[3].' '.$matches[4].':'.$matches[5].':'.$matches[6];
        if ($norm_date != '0000-00-00 00:00:00')
        {
            return $norm_date;
        }
    }
    elseif (preg_match('/^(\d{4}).(\d{2}).(\d{2})/', $value, $matches))
    {
        return $matches[1].'-'.$matches[2].'-'.$matches[3];
    }
    return Null;
}
