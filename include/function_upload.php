<?php
/***********************************************
* File      :   function_upload.php
* Project   :   piwigo-videojs
* Descr     :   Refresh metadata, poster and thumbnails when a video is uploaded or replaced
*
* Created   :   4.10.2026
*
* Copyright 2012-2025 <xbgmsharp@gmail.com>
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

include_once(dirname(__FILE__).'/function_common.php');

// Hook called by add_uploaded_file() once the new file is in place, and before
// Piwigo reads its metadata. When a file is replaced, Piwigo has deleted the
// old poster but keeps the old 'representative_ext' in the database, and then
// fails to open the missing poster. Align it with the poster actually on disk
// (Piwigo may have just generated one). Priority 60 runs after Piwigo's own
// 'upload_file' handlers.
add_event_handler('upload_file', 'vjs_upload_file', 60, 2);
function vjs_upload_file($representative_ext, $file_path)
{
    global $logger;

    try
    {
        // Only for an existing video: for a new upload there is no row yet
        $query = 'SELECT id FROM '.IMAGES_TABLE.'
            WHERE path = \''.pwg_db_real_escape_string($file_path).'\' AND '.SQL_VIDEOS.';';
        $result = pwg_query($query);
        if ($row = pwg_db_fetch_assoc($result))
        {
            $value = is_string($representative_ext) && $representative_ext !== ''
                ? '\''.pwg_db_real_escape_string($representative_ext).'\'' : 'NULL';
            pwg_query('UPDATE '.IMAGES_TABLE.' SET representative_ext = '.$value.' WHERE id = '.$row['id'].';');
        }
    }
    catch (Throwable $e)
    {
        $logger->error('['.__FUNCTION__.'] '.$e->getMessage());
    }

    return $representative_ext;
}

// Hook called at the end of add_uploaded_file(), for a new upload and for a
// file replaced (e.g. with the Photo Update plugin). Piwigo has then deleted
// the old file and poster but neither the VideoJS thumbnails and extra sources
// nor the stored metadata. Clean them and run the sync for this video.
add_event_handler('loc_end_add_uploaded_file', 'vjs_end_add_uploaded_file');
function vjs_end_add_uploaded_file($image_infos)
{
    global $conf, $prefixeTable, $logger;

    if (!isset($image_infos['id']) or !is_numeric($image_infos['id']))
    {
        return;
    }
    $image_id = (int) $image_infos['id'];

    try
    {
        // Do nothing for pictures and for videos not supported by the plugin
        $query = 'SELECT id, file, path, representative_ext
            FROM '.IMAGES_TABLE.'
            WHERE id = '.$image_id.' AND '.SQL_VIDEOS.';';
        if (!pwg_db_num_rows(pwg_query($query)))
        {
            return;
        }

        // Delete thumbnails, extra video sources, stored metadata and the
        // reference to the deleted poster (adopted again if a file exists)
        vjs_begin_delete_elements(array($image_id));
        pwg_query('DELETE FROM '.$prefixeTable.'image_videojs WHERE id = '.$image_id.';');
        pwg_query('UPDATE '.IMAGES_TABLE.' SET representative_ext = NULL WHERE id = '.$image_id.';');
        $query = 'SELECT id, file, path, representative_ext
            FROM '.IMAGES_TABLE.'
            WHERE id = '.$image_id.';';

        // Saved sync options, but always refresh metadata and poster;
        // thumbnails only if requested
        $sync_options = $conf['vjs_sync'];
        $sync_options['metadata'] = true;
        $sync_options['representative'] = true;
        $sync_options['poster'] = true;
        $sync_options['posteroverwrite'] = true;
        $sync_options['thumboverwrite'] = true;
        $sync_options['simulate'] = false;
        $sync_options['subcats_included'] = false;

        $errors = array();
        $warnings = array();
        $infos = array();
        include(dirname(__FILE__).'/function_sync.php');

        foreach (array_merge($errors, $warnings) as $message)
        {
            $logger->warn('['.__FUNCTION__.'] #'.$image_id.' '.$message);
        }
    }
    catch (Throwable $e)
    {
        // Never break the upload because of the synchronisation
        $logger->error('['.__FUNCTION__.'] #'.$image_id.' '.$e->getMessage());
    }
}
?>
