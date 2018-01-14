<?php
/***********************************************
* File      :   function_frame.php
* Project   :   piwigo-videojs
* Descr     :   Generate the thumbnail with frame
* Base on   :   Embedded Videos plugin
*
* Created   :   21.06.2013
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

/**
 * add movie frame to an image (need GD library)
 * @param: string source
 * @param: string destination (if null, the source is modified)
 * @return: void
 */
function add_movie_frame($src, $dest=null)
{
  if (empty($dest))
  {
    $dest = $src;
  }
  
  // we need gd library
  if (!function_exists('imagecreatetruecolor'))
  {
    if ($dest != $src) copy($src, $dest);
    return;
  }
  
  // open source image
  switch (strtolower(get_extension($src)))
  {
    case 'jpg':
    case 'jpeg':
      $srcImage = imagecreatefromjpeg($src);
      break;
    case 'png':
      $srcImage = imagecreatefrompng($src);
      break;
    case 'gif':
      $srcImage = imagecreatefromgif($src);
      break;
    default:
      if ($dest != $src) copy($src, $dest);
      return;
  }
  
  // source properties
  $srcWidth = imagesx($srcImage);
  $srcHeight = imagesy($srcImage);
  $const = intval($srcWidth * 0.04);
  $bandRadius = floor($const/8);

  // band properties
  $imgBand = imagecreatetruecolor($srcWidth + 6*$const, $srcHeight + 3*$const);
  
  $black = imagecolorallocate($imgBand, 0, 0, 0);
  $white = imagecolorallocate($imgBand, 245, 245, 245);
  
  // and dots
  $y_start = intval(($srcHeight + 3*$const) / 2);
  $aug = intval($y_start / 5) + 1;
  $i = 0;

  while ($y_start + $i*$aug < $srcHeight + 3*$const)
  {
    imagefilledroundrectangle($imgBand, (3/4)*$const, $y_start + $i*$aug - $const/2, (9/4)*$const - 1, $y_start + $i*$aug + $const/2 - 1, $white, $bandRadius);
    imagefilledroundrectangle($imgBand, (3/4)*$const, $y_start - $i*$aug - $const/2, (9/4)*$const - 1, $y_start - $i*$aug + $const/2 - 1, $white, $bandRadius);

    imagefilledroundrectangle($imgBand, $srcWidth + (15/4)*$const, $y_start + $i*$aug - $const/2, $srcWidth + (21/4)*$const - 1, $y_start + $i*$aug + $const/2 - 1, $white, $bandRadius);
    imagefilledroundrectangle($imgBand, $srcWidth + (15/4)*$const, $y_start - $i*$aug - $const/2, $srcWidth + (21/4)*$const - 1, $y_start - $i*$aug + $const/2 - 1, $white, $bandRadius);

    ++$i;
  }

  // add source to band
  imagecopy($imgBand, $srcImage, 3*$const, (3/2)*$const, 0, 0, $srcWidth, $srcHeight);
  
  // save image
  switch (strtolower(get_extension($dest)))
  {
    case 'jpg':
    case 'jpeg':
      imagejpeg($imgBand, $dest, 85);
      break;
    case 'png':
      imagepng($imgBand, $dest);
      break;
    case 'gif':
      imagegif($imgBand, $dest);
      break;
  }
}

/**
 * create a rectangle with round corners
 * http://www.php.net/manual/fr/function.imagefilledrectangle.php#42815
 */
function imagefilledroundrectangle(&$img, $x1, $y1, $x2, $y2, $color, $radius)
{
  imagefilledrectangle($img, $x1+$radius, $y1, $x2-$radius, $y2, $color);
  
  if ($radius > 0)
  {
    imagefilledrectangle($img, $x1, $y1+$radius, $x2, $y2-$radius, $color);
    imagefilledellipse($img, $x1+$radius, $y1+$radius, $radius*2, $radius*2, $color);
    imagefilledellipse($img, $x2-$radius, $y1+$radius, $radius*2, $radius*2, $color);
    imagefilledellipse($img, $x1+$radius, $y2-$radius, $radius*2, $radius*2, $color);
    imagefilledellipse($img, $x2-$radius, $y2-$radius, $radius*2, $radius*2, $color);
  }
}

?>
