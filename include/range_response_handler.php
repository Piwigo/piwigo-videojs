<?php
/***********************************************
* File      :   range_request_header.php
* Project   :   piwigo-videojs
* Descr     :   Returns videos with range headers for partial content downloads
*
* Created   :   12.05.2026
* Author    :   @quacainia
*
* Copyright 2012-2026 <xbgmsharp@gmail.com>
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

// Include the Sendfile library
require_once(VIDEOJS_PATH . 'include/http-send-file/Sendfile.php');

use Diversen\Sendfile;

// Allowed video file extensions
$allowed_extensions = array('ogg', 'ogv', 'mp4', 'm4v', 'webm', 'webmv', 'strm');

global $file, $element_info;

// We only want to handle range requests for files being served through action.php
// The file path is available in the local scope from action.php
if (!isset($file) || empty($file)) {
    return;
}

// Check if file has an allowed video extension
$file_ext = strtolower(get_extension($file));
if (!in_array($file_ext, $allowed_extensions)) {
    return;
}

// Only handle local files (not remote URLs)
if (url_is_remote($file)) {
    return;
}

if (!@is_readable($file)) {
    return;
}

try {
    $sendfile = new Sendfile();

    // 10 MiB/s, which is sufficient for 4k, potentially should be configurable
    $sendfile->throttle(0.1, 1048576);

    // Set content type if available from action.php
    if (isset($ctype) && !empty($ctype)) {
        $sendfile->setContentType($ctype);
    }

    $http_headers = array();

    // Set content disposition (filename) if available
    if (isset($element_info['file']) && !empty($element_info['file'])) {
        // Use our own headers as `SendFile` doesn't support `inline` disposition
        if (isset($_GET['download'])) {
            $http_headers[] = 'Content-Disposition: attachment; filename="' . htmlspecialchars_decode($element_info['file']) . '";';
            $http_headers[] = 'Content-Transfer-Encoding: binary';
        } else {
            $http_headers[] = 'Content-Disposition: inline; filename="'
                . basename($file) . '";';
        }
    }

    foreach ($http_headers as $header) {
        header($header);
    }

    // Send the file with range support
    $sendfile->send($file, false);

    // If send() completes without range request, exit to prevent double output
    exit();
} catch (Exception $e) {
    // Silently fail and let normal processing continue
    return;
}
