<?php
/***********************************************
* File      :   admin_boot.php
* Project   :   piwigo-videojs
* Descr     :   Generate the admin panel
*
* Created   :   6.06.2013
*
* Copyright 2012-2018 <xbgmsharp@gmail.com>
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

// Hook to add an admin config page
add_event_handler('get_admin_plugin_menu_links', 'vjs_admin_menu');
function vjs_admin_menu($menu)
{
	array_push($menu,
		array(
			'NAME' => 'VideoJS',
			'URL'  => get_admin_plugin_menu_link(dirname(__FILE__).'/admin.php')
		)
	);
	return $menu;
}

// Batch_manager support
include_once(dirname(__FILE__).'/admin_batchmanager.php');

// Hook to add an photo edit tab in photo edit
add_event_handler('tabsheet_before_select','vjs_add_tab', 55, 2);
function vjs_add_tab($sheets, $id)
{
	if ($id == 'photo')
	{
		$query = "SELECT id FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
		$result = pwg_query($query);
		if (!pwg_db_num_rows($result)) return $sheets;

		$sheets['videojs'] = array(
			'caption' => 'VideoJS',
			'url' => get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_photo.php&amp;image_id='.$_GET['image_id'],
			);

		unset($sheets['coi'], $sheets['update']);
		unset($sheets['rotate'], $sheets['update']);

		/* Replace the RotateImage by a our own */
		$sheets['rotate'] = array(
			'caption' => 'Rotate',
			'url' => get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_rotate.php&amp;image_id='.$_GET['image_id'],
			);
	}

	return $sheets;
}

// Hook to delete extra elements created by the plugin
// Does apply to batch manager and photo-edit pages
add_event_handler('begin_delete_elements', 'vjs_begin_delete_elements');
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

  // Find details base on ID and if supported video files
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
function vjs_pprint_r(array $array, $glue = ', <br/>', $size = 10)
{
        // Split $EXIF keys array in chuck of $size for nicer display
        $chunk_arr = array_chunk( array_keys($array), $size, true);

        // Generate ouput
        $output = "\r\n<br/>";
        foreach ( $chunk_arr as $row ) {
                foreach ( $row as $key ) {
                        //printf('[%2s] ', $key);
                        $output .= $key.", ";
                }
                $output .= "<br/>";
        }

        // Removes last $glue from string
        strlen($glue) > 0 and $output = substr($output, 0, -strlen($glue));

        return (string) $output;
}

?>
