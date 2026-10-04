<?php
/***********************************************
* File      :   function_common.php
* Project   :   piwigo-videojs
* Descr     :   Helpers shared by the admin panel, the sync and the upload hook
*
* Created   :   6.06.2013
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

// Define all videos with supported extensions
define('SQL_VIDEOS', "(LOWER(`file`) LIKE '%.ogg' OR LOWER(`file`) LIKE '%.ogv' OR
                LOWER(`file`) LIKE '%.mp4' OR LOWER(`file`) LIKE '%.m4v' OR
                LOWER(`file`) LIKE '%.webm' OR LOWER(`file`) LIKE '%.webmv')");


// Function to delete extra elements created by the plugin
function vjs_begin_delete_elements($ids)
{
  if (count($ids) == 0)
  {
    return 0;
  }

  $vjs_extensions = array(
        'ogg',
        'ogv',
        'mp4',
        'm4v',
        'webm',
        'webmv',
  );
  $files_ext = array_merge(array(), $vjs_extensions, array_map('strtoupper', $vjs_extensions) );

  // Find details based on ID and if supported video files
  $query = '
SELECT
    id,
    path,
    representative_ext
  FROM '.IMAGES_TABLE.'
  WHERE id IN ('.implode(',', $ids).') AND '.SQL_VIDEOS.'
;';
  $result = pwg_query($query);
  while ($row = pwg_db_fetch_assoc($result))
  {
    if (url_is_remote($row['path']))
    {
      continue;
    }

    $files = array();
    $files[] = get_element_path($row);

    $ok = true;
    if (!isset($conf['never_delete_originals']))
    {
      foreach ($files as $path)
      {
        // Don't delete the actual video or representative
        // It is done by PWG core

        // Delete any other video source format
        $file_wo_ext = pathinfo($path);
        $file_dir = dirname($path);
        foreach ($files_ext as $file_ext)
        {
            $path_ext = $file_dir."/pwg_representative/".$file_wo_ext['filename'].".".$file_ext;
            if (is_file($path_ext) and !unlink($path_ext))
            {
              $ok = false;
              trigger_error('"'.$path_ext.'" cannot be removed', E_USER_WARNING);
              break;
            }
        }

        // Delete video thumbnails
        $filematch = $file_dir."/pwg_representative/".$file_wo_ext['filename']."-th_*";
        $matches = glob($filematch);
        if (is_array($matches))
        {
            foreach($matches as $filename)
            {
                if (is_file($filename) and !unlink($filename))
                {
                   $ok = false;
                   trigger_error('"'.$filename.'" cannot be removed', E_USER_WARNING);
                   break;
                }
            }
        } // End videos thumbnails
      } // End for each files
    } // End IF
  } // End While
} // End function

/* Plugin admin functions */

/* Parse array fields to SQL query */
function vjs_dbSet($fields, $data = array())
{
    if (!$data) $data = &$_POST;
    $set='';
    foreach ($fields as $field)
    {
        if (isset($data[$field]) and strlen($data[$field]) > 0)
        {
            $set.="`$field`='".pwg_db_real_escape_string($data[$field])."', ";
        }
    }
    return substr($set, 0, -2);
}

/* Pretty Print recursive */
function vjs_pprint_r(array $array, $glue = '<br/>&nbsp;&nbsp;&nbsp;&nbsp;', $size = 6)
{
        // Sort the keys alphabetically, the ones starting with a lowercase letter (Piwigo fields) first
        $keys = array_keys($array);
        usort($keys, function ($a, $b) {
                $lowerA = (int) ctype_lower(substr((string) $a, 0, 1));
                $lowerB = (int) ctype_lower(substr((string) $b, 0, 1));
                return $lowerA !== $lowerB ? $lowerB - $lowerA : strcasecmp((string) $a, (string) $b);
        });

        // Split $EXIF keys array in chuck of $size for nicer display
        $chunk_arr = array_chunk( $keys, $size, true);

        // Generate ouput
        $output = '';
        foreach ( $chunk_arr as $row ) {
                foreach ( $row as $key ) {
                        //printf('[%2s] ', $key);
                        $output .= $key.', ';
                }
                $output .= $glue;
        }

        // Removes last $glue from string
        strlen($glue) > 0 and $output = substr($output, 0, -strlen(', '.$glue));

        return (string) $output;
}

?>
