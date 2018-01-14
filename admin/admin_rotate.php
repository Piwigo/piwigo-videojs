<?php
/***********************************************
* File      :   admin_rotate.php
* Project   :   piwigo-videojs
* Descr     :   Video rotate in admin photo panel
* Base      :   Base on RotateImage plugin adapt for video
*
* Created   :   16.03.2015
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

// Check access and exit when user status is not ok
check_status(ACCESS_ADMINISTRATOR);

if (!isset($_GET['image_id']) or !isset($_GET['section']))
{
        die('Invalid data!');
}

check_input_parameter('image_id', $_GET, false, PATTERN_ID);

include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
include_once(PHPWG_ROOT_PATH.'admin/include/image.class.php');

load_language('plugin.lang', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
load_language('plugin.lang', VIDEOJS_PATH);

global $template, $page, $conf;

$admin_photo_base_url = get_root_url().'admin.php?page=photo-'.$_GET['image_id'];
$self_url = get_root_url().'admin.php?page=plugin&amp;section=piwigo-videojs/admin/admin_rotate.php&amp;image_id='.$_GET['image_id'];

if (isset($_POST['videojs_rotate']) and isset($_POST['angle']))
{
  check_pwg_token();

  if (!empty($_POST['angle']) and (strlen($_POST['angle']) != 0) and !is_numeric($_POST['angle']))
  {
    die('Invalid data!');
  }

  /* Update the database - No action done on the video */
  $rotation_code = pwg_image::get_rotation_code_from_angle($_POST['angle']);
  $query = "UPDATE ".IMAGES_TABLE." SET rotation='".$rotation_code."', `date_metadata_update`=CURDATE() WHERE `id`=".$_GET['image_id'].";";
  pwg_query($query);

  /* Retrieve direct information about picture */
  $query = "SELECT id,path,representative_ext FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
  $row = pwg_db_fetch_assoc(pwg_query($query));

  /* Delete previous derivatives */
  delete_element_derivatives($row);

  array_push(
    $page['infos'],
    l10n('The photo was updated')
    );
}

// +-----------------------------------------------------------------------+
// | Tabs                                                                  |
// +-----------------------------------------------------------------------+

$tabsheet = new tabsheet();
$tabsheet->set_id('photo');
$tabsheet->select('rotate');
$tabsheet->assign();

// +-----------------------------------------------------------------------+
// |                             template init                             |
// +-----------------------------------------------------------------------+

$template->set_filenames(
  array(
    'plugin_admin_content' => dirname(__FILE__).'/admin_rotate.tpl'
    )
  );

// Retrieve direct information about picture
$query = "SELECT * FROM ".IMAGES_TABLE." WHERE ".SQL_VIDEOS." AND id = ".$_GET['image_id'].";";
$row = pwg_db_fetch_assoc(pwg_query($query));

$angles = array(
  array('value' =>   0, 'name' => l10n('0°')),
  array('value' =>  90, 'name' => l10n('90° right')),
  array('value' => 270, 'name' => l10n('90° left')),
  array('value' => 180, 'name' => l10n('180°'))
);

$template->assign(
  array(
    'F_ACTION' => $self_url,
    'TN_SRC' => DerivativeImage::thumb_url($row),
    'TITLE' => render_element_name($row),
    'angles' => $angles,
    'angle_selected' => pwg_image::get_rotation_angle_from_code($row['rotation']),
    'library' => pwg_image::get_library(),
    'PWG_TOKEN' => get_pwg_token(),
    )
  );

// +-----------------------------------------------------------------------+
// | sending html code                                                     |
// +-----------------------------------------------------------------------+

$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>
