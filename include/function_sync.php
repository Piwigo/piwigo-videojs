<?php
/***********************************************
* File      :   function_sync.php
* Project   :   piwigo-videojs
* Descr     :   Handle the syncronisation process
*
* Created   :   9.07.2013
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

//setlocale(LC_ALL, "en_US.UTF-8");
include_once("function_frame.php");
include_once("function_caller.php");

/***************
 *
 * Start the sync work
 *
 */

// Init value for result table
$videos = 0;
$metadata = 0;
$representative_created = false;
$posters = 0;
$thumbs = 0;
!isset($errors) and $errors = array();
!isset($warnings) and $warnings = array();
!isset($infos) and $infos = array();

// Check dependencies: MediaInfo & FFmpeg, share with batch manager & photo edit & admin sync
include("function_dependencies.php");

global $logger;
if (!$sync_options['metadata'] and !$sync_options['representative'] and !$sync_options['poster'] and !$sync_options['thumb'])
{
    $errors[] = l10n('SYNC_NONE');
}

// Do the job
$result = pwg_query($query);
while ($row = pwg_db_fetch_assoc($result))
{
 	/* Check full-res file */
    $filename = $row['path'];
    if (!is_file($filename)) {
		$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('FILE_NOT_READABLE');
    	$logger->debug('sync: No full-res. file "'.$filename.'"');
    	continue;
    }
    
	/* Will report it */
	$videos++;
	$sync_arr = array();
	$sync_arr['file'] = $filename;
	$logger->debug('sync: $filename = '.$filename);
	
	/* Ensure file is readabale */
	if (!is_readable($filename)) {
		$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('FILE_NOT_READABLE');
		$logger->debug('sync: Unable to read file for synchronisation process');
		continue;
	}

	/* Retrieve metadata if requested */
	$exif = array();
	if ($sync_options['metadata'])
	{
		/* Retrieve metadata with MediaInfo, FFprobe or ExifTool */
		if (isset($sync_options['mediainfo']) and $sync_options['mediainfo']) { include('mediainfo.php'); }
		if (isset($sync_options['ffprobe']) and $sync_options['ffprobe']) { include('ffprobe.php'); }
		if (isset($sync_options['exiftool']) and $sync_options['exiftool']) { include('exiftool.php'); }
		
		/* Did we retrieve metadata successfully? */
		if (isset($exif))
		{
			$exif = array_filter($exif);
			if (isset($exif['error']))
			{
				$errors[] = $exif['error'];
			}
			else if (!empty($exif) and count($exif) > 0)
			{
				/* Will report it */
				$metadata++;
				$infos[] = l10n('VIDEO').' '.$filename. ' — '.l10n('SYNC_METADATA').': '.count($exif).' '.vjs_pprint_r($exif);
				$sync_arr['metadata'] = count($exif).' '.vjs_pprint_r($exif);
				
				/* Save metadata */
				if ($sync_options['metadata'] and !$sync_options['simulate'])
				{
					/* Update Piwigo SQL table */
					$dbfields = explode(",", "filesize,width,height,latitude,longitude,date_creation,rotation");
					$query = "UPDATE ".IMAGES_TABLE." SET ".vjs_dbSet($dbfields, $exif).", `date_metadata_update`=CURDATE() WHERE `id`=".$row['id'].";";
					pwg_query($query);
	
					/* Update VideoJS SQL table */
					$sqlMetadata = pwg_db_real_escape_string(serialize($exif));
					$query = "INSERT INTO ".$prefixeTable."image_videojs (metadata,date_metadata_update,id) VALUES ('".$sqlMetadata."',CURDATE(),'".$row['id']."') ON DUPLICATE KEY UPDATE metadata='".$sqlMetadata."',date_metadata_update=CURDATE(),id='".$row['id']."';";
					pwg_query($query);
				}
			}
		}
	}
	else	/* Fetch metadata as we will need $exif['DurationSeconds'] */
	{
		/* Will report it */
		$infos[] = l10n('VIDEO').' '.$filename.' — '.l10n('SYNC_DATABASE');
		$sync_arr['database'] = l10n('SYNC_DATABASE');
		
		/* Fetch metadata from the database */
		$query = "SELECT * FROM ".$prefixeTable."image_videojs WHERE `id`=".$row['id'].";";
		$sql_metadata = pwg_query($query);
		$videojs_metadata = pwg_db_fetch_assoc($sql_metadata);
		if (is_array($exif) and isset($videojs_metadata) and is_array($videojs_metadata) and isset($videojs_metadata['metadata']))
		{
			$video_metadata = unserialize($videojs_metadata['metadata']);
			$exif = array_merge($exif, $video_metadata);
		}
		if (!isset($exif['DurationSeconds']) and ($sync_options['poster'] or $sync_options['thumb']))
		{
			/* Will report it */
			$warnings[] = l10n('VIDEO').' '.$filename.' — '.l10n('SYNC_DURATION_ERROR');
		}
	}

	/* Should we create a poster? */
	if ($sync_options['poster'])
	{
		/* Full-res file available? */
		$file_wo_ext = pathinfo($row['path']);
		//$file_wo_ext['filename'] ? '' : $file_wo_ext['filename'] = substr($filename,0 ,-5);
		if (!isset($file_wo_ext['filename']) or (isset($file_wo_ext['filename']) and strlen($file_wo_ext['filename']) == 0))
		{
			/* Will report it */
			$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('FILE_NOT_READABLE');
			continue;
		}
		$output_dir = dirname($row['path']) . '/pwg_representative/';
		//$output_dir = PWG_DERIVATIVE_DIR . dirname($row['path']) . '/pwg_representative/';
		$in = $filename;
		$out = $output_dir.$file_wo_ext['filename'].'.'.$sync_options['output'];
		
		/* Create folder if needed */
		if (!is_dir($output_dir))
		{
			mkdir($output_dir);
		}
		
		/* Check access rights to folder */
		if (!is_writable($output_dir))
		{
			/* Will report it */
			$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('DIR_NOT_WRITABLE');
			continue;
		}
		
		if (isset($exif['DurationSeconds']) and $sync_options['postersec'] and !$sync_options['simulate'])
		{   /* We really want to create the poster */
			$posters++;
			
			/* Delete any previous poster, avoid duplication on different output format */
			$extensions = array('jpg', 'jpeg', 'png', 'gif');
			foreach ($extensions as $extension)
			{
				/* Extension in lowercase */
				$ifile = $output_dir.$file_wo_ext['filename'].'.'.strtolower($extension);
				if (is_file($ifile))
				{
					unlink($ifile);
				}
				
				/* Extension in uppercase */
				$ifile = $output_dir.$file_wo_ext['filename'].'.'.strtoupper($extension);
				if (is_file($ifile))
				{
					unlink($ifile);
				}
			}
			
			/* If video is shorter fallback to half duration */
			$posterSec = $sync_options['postersec'];
			if ($sync_options['postersec'] > $exif['DurationSeconds'])
			{
				/* Will report it */
				$warnings[] = l10n('VIDEO').' '.$filename.' — '.l10n('SYNC_DURATION_SHORT');
				$posterSec = (int)round($exif['DurationSeconds']/2, 2, PHP_ROUND_HALF_DOWN);
				$logger->debug(l10n('VIDEO').' '.$filename.' — '.l10n('SYNC_DURATION_SHORT'));
			}
			
			/* Default output to JPG */
			$ffmpeg = $sync_options['ffmpeg'] ." -ss ".$posterSec." -i \"".$in."\" -vcodec mjpeg -vframes 1 -an -f rawvideo -y \"".$out. "\"";
			if ($sync_options['output'] == "png")
			{
				$ffmpeg = $sync_options['ffmpeg'] ." -ss ".$posterSec." -i \"".$in."\" -vcodec png -vframes 1 -an -f rawvideo -y \"".$out. "\"";
			}
			
			/* Create poster */
			$retval = execCMD($ffmpeg);
			if ($retval != 0 or !file_exists($out) or !filesize($out))
			{
				/* Will report it */
				$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('POSTER_ERROR');
				$logger->debug(l10n('VIDEO').' '.$filename.' — '.l10n('POSTER_ERROR'));
			}
			else	/* We have a poster, lets update the database */
			{
				/* Will report it */
				$infos[] = l10n('POSTER').' '.$out;
				$sync_arr['poster'] = $out;
				$logger->debug('sync: $out = '.$out);

				/* Will not need to adopt this poster */
				$representative_created = true;
				
				/* Update database */
				$query = "UPDATE ".IMAGES_TABLE." SET `representative_ext`='".$sync_options['output']."' WHERE `id`=".$row['id'].";";
				pwg_query($query);

				/* Delete previous thumbnails, new ones will be autogenerated by Piwigo on request */
				delete_element_derivatives($row);

				/* Generate the overlay (film effect) */
				if ($sync_options['posteroverlay'])
				{
					add_movie_frame($out);
				}
			}
		}
	} /* End poster */

	/* Should we adopt a poster? */
	if ($sync_options['representative'] and !$representative_created)
	{
		$logger->debug(l10n('VIDEO').' '.$filename.' — Adopt poster…');
		/* Initialisation */
		$output_dir = dirname($row['path']) . '/pwg_representative/';
		$file_wo_ext = pathinfo($row['path']);
		$out = '';
		$query = '';
		
		/* Check if there already exists a poster */
		$representative_ext = isset($representative_ext) ? $row['representative_ext'] : '';
		$extensions = array('jpg', 'jpeg', 'png', 'gif');
		foreach ($extensions as $extension)
		{
			/* Extension in lowercase */
			$ilcfile = $output_dir.$file_wo_ext['filename'].'.'.strtolower($extension);
//  			$logger->debug('sync: $ilcfile = '.$ilcfile);
			if (is_file($ilcfile) and $representative_ext != $extension)
			{
				/* We have a poster, create query for updating the database */
				$query = "UPDATE ".IMAGES_TABLE." SET representative_ext = '".$extension."' WHERE id = ".$row['id'].";";
				$out = $ilcfile;
// 				$logger->debug('sync: $query = '.$query);
			}
			
			/* Extension in uppercase */
			$iucfile = $output_dir.$file_wo_ext['filename'].'.'.strtoupper($extension);
// 			$logger->debug('sync: $iucfile = '.$iucfile);
			if (is_file($iucfile) and $representative_ext != $extension)
			{
				/* We have a poster, create query for updating the database */
				$query = "UPDATE ".IMAGES_TABLE." SET representative_ext = '".$extension."' WHERE id = ".$row['id'].";";
				$out = $iucfile;
// 				$logger->debug('sync: $query = '.$query);
				
				/* Rename file with extension in lowercase */
				if (is_file($ilcfile)) 
				{
					unlink($iucfile);				// Keep file with extension in lowercase
				}
				else 
				{
					rename($iucfile, $ilcfile);		// Rename file with extension in lowercase
				}
			}
		}
		
		/* Update database */
		if (!empty($query))
		{	
			/* We really want to adopt the poster */
			$posters++;
			
			/* Will report it */
			$infos[] = l10n('POSTER').' '.$out;
			$sync_arr['poster'] = $out;
			$logger->debug('sync: adopt poster '.$out);

			/* Update the database */
			if (!$sync_options['simulate'])
			{
				pwg_query($query);
			}
		}
	}
	
	/* Create multiple frames for VideoJS player */
	if ($sync_options['thumb'])
	{
		if (isset($exif['DurationSeconds']) and isset($sync_options['thumbsec']) and isset($sync_options['thumbsize']))
		{
			/* Initialise file name and path */
			$file_wo_ext = pathinfo($filename);
			if (!isset($file_wo_ext['filename']) and strlen($file_wo_ext['filename']) == 0)
			{
				/* Will report it */
				$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('FILE_NOT_READABLE');
				continue;
			}
			$output_dir = dirname($row['path']) . '/pwg_representative/';
			//$output_dir = PWG_DERIVATIVE_DIR . dirname($row['path']) . '/pwg_representative/';

			/* Check access rights to folder */
			if (!is_dir($output_dir) or !is_writable($output_dir))
			{
				/* Will report it */
				$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('DIR_NOT_WRITABLE');
				continue;
			}
			
			if ($sync_options['thumbsec'] and !$sync_options['simulate'])
			{   /* We really want to create the frames */
				/* Delete any previous frames, avoiding duplication on different output format */
				$filematch = $output_dir.$file_wo_ext['filename']."-th_*";
				$matches = glob($filematch);
				if ( is_array ( $matches ) ) {
					foreach ( $matches as $eachfile) {
						if(is_file($eachfile))
						{
							unlink($eachfile);
						}
					}
				}
	
				/* Override the thumbsize (default 120x68) in order to respect the video aspect ratio base on the user specified width */
				/* https://github.com/xbgmsharp/piwigo-videojs/issues/52 */
				$thumb_width = preg_split("/x/", $sync_options['thumbsize']);
				
				/* Invalid width x height fallback to default thumbsize (default 120x68) */
				if (!isset($thumb_width[0]))
				{
					/* Will report it */
					$warnings[] = l10n('VIDEO').' '.$filename.' — '.l10n('SYNC_THUMBSIZE_ERROR');
					$thumb_width[0] = "120";
				}
				
				/* Takes output width (ow), divides it by aspect ratio (a), truncates digits after decimal point */
				$scale = "scale='".$thumb_width[0].":trunc(ow/a)'";
		
				/* Loop over all frames */
				$in = $filename;
				for ($second=0; $second <= $exif['DurationSeconds']; $second += $sync_options['thumbsec'])
				{
					/* Output filename */
					$out = $output_dir.$file_wo_ext['filename']."-th_".$second.'.'.$sync_options['output'];
					
					/* Will report it */
					$thumbs++;
					$infos[] = l10n('SYNC_THUMB').' — '.$second.' s — '.$out;
					$sync_arr['thumbnail'][] = $second.' s — '.$out;
					
					/* Create frame, default output to JPG */
					$ffmpeg = $sync_options['ffmpeg'] ." -ss ".$second." -i \"".$in."\" -vcodec mjpeg -vframes 1 -an -f rawvideo -vf ".$scale." -y \"".$out. "\"";
					if ($sync_options['output'] == "png")
					{
						$ffmpeg = $sync_options['ffmpeg'] ." -ss ".$second." -i \"".$in."\" -vcodec png -vframes 1 -an -f rawvideo -vf ".$scale." -y \"".$out. "\"";
					}
					$retval = execCMD($ffmpeg);
					
					/* Frame produced successfully? */
					if ($retval != 0 or !file_exists($out) or !filesize($out))
					{
						/* Will report it */
						$errors[] = l10n('VIDEO').' '.$filename.' — '.l10n('SYNC_THUMB_ERROR');
					}
				}
			}
		}
	} /* End thumbnails */
	
	/* Report for custom page_info */
	$sync_infos[] = $sync_arr;
}

/***************
 *
 * End the sync work
 *
 */
