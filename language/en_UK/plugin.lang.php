<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2015 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+
$lang['INTRO_CONFIG'] = 'This plugin:';
$lang['INTRO_VIDEOJS'] = 'adds the open source HTML5 video player <a href="http://www.videojs.com/" target="_blank">VideoJS</a>';
$lang['INTRO_METADATA'] = 'extracts metadata with <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> or <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a> (if available)';
$lang['INTRO_THUMB'] = 'produces thumbnails with <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a> (if available)';
$lang['INTRO_SUPPORT'] = 'Refer to the <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">plugin documentation</a> for additional information and look at the <a href="https://piwigo.org/forum/" target="_blank">forums</a> if you encounter any issues.<br/>To report bugs and suggest new features, please create a new <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">issue</a>.';

$lang['STATS'] = 'Statistics';
$lang['MOVIE'] = 'Movie';
$lang['VIDEOS'] = 'videos in your gallery';
$lang['VIDEOS_THUMB'] = 'videos with poster in your gallery';
$lang['VIDEOS_GEOTAGGED'] = 'geotagged videos in your gallery';

$lang['HTML5'] = 'HTML5 video tag settings';
$lang['PRELOAD'] = 'Preload:';
$lang['PRELOAD_DESC'] = 'The preload attribute informs the browser whether or not the video data should begin downloading as soon as the video tag is loaded.';
$lang['CONTROLS'] = 'Controls:';
$lang['CONTROLS_DESC'] = 'The controls option sets whether or not the player has controls that the user can interact with';
$lang['AUTOPLAY'] = 'Autoplay';
$lang['AUTOPLAY_DESC'] = 'If autoplay is true, the video will start playing as soon as the page is loaded (without any interaction from the user). NOT SUPPORTED BY APPLE iOS DEVICES.';
$lang['LOOP'] = 'Loop:';
$lang['LOOP_DESC'] = 'The loop attribute causes the video to start over as soon as it ends.';
$lang['VOLUME'] = 'Volume:';
$lang['VOLUME_DESC'] = 'The volume option sets the volume level. 0 is off (muted), 1.0 is all the way up, 0.5 is half way.';
$lang['LANGUAGE'] = 'Language:';
$lang['LANGUAGE_DESC'] = 'Select the player language.';

$lang['METADATA'] = 'Metadata';
$lang['METADATA_FILE'] = 'Show file:';
$lang['METADATA_DESC'] = 'Whether or not to show metadata.';

$lang['PLAYER'] = 'Player';
$lang['PLAYER_TYPE'] = 'Type:';
$lang['PLAYER_DESC'] = 'Select the player type and version.';

$lang['VIDEOJS_SETTINGS'] = 'VideoJS settings';
$lang['SKIN'] = 'Skin:';
$lang['SKIN_DESC'] = 'Select the style you want to apply to the player or <a href="http://designer.videojs.com/" target="_blank">create your own skin</a>.';
$lang['CUSTOMCSS'] = 'Custom CSS:';
$lang['CUSTOMCSS_DESC'] = 'Custom CSS to copy paste from the <a href="http://www.videojs.com/" target="_blank">VideoJS website</a>.';
$lang['HEIGHT'] = 'Max Height:';
$lang['HEIGHT_DESC'] = 'The max height attribute sets the maximum display height of the video. If the video height is bigger than max height, it will downscale the video size to max height.';
$lang['UPSCALE'] = 'Upscale:';
$lang['UPSCALE_DESC'] = 'If the video height is smaller than max height, it will upscale the video size to max height.';
$lang['ZOOMROTATE'] = 'Rotate, zoom:';
$lang['ZOOMROTATE_DESC'] = 'Rotate and zoom a video if applicable, use the rotation metadata.';
$lang['THUMBNAILS'] = 'Thumbnails:';
$lang['THUMBNAILS_DESC'] = 'Displays thumbnail images over the progress bar.';
$lang['WATERMARK'] = 'Watermark:';
$lang['WATERMARK_DESC'] = 'Displays watermark over the video.';
$lang['RESOLUTION'] = 'Resolution:';
$lang['RESOLUTION_DESC'] = 'Resolution switcher.';

$lang['SYNC_INTRO'] = 'Synchronization of metadata and thumbnail creation for videos:';
$lang['SYNC_NONE'] = 'You asked me to do nothing!';
$lang['SYNC_INFOS'] = 'Detailed information';
$lang['SYNC_RESULTS'] = 'Synchronization results';
$lang['SYNC_DETECTED'] = 'video(s) detected';
$lang['SYNC_METADATA_ADDED'] = 'video(s) with metadata added';
$lang['SYNC_POSTERS_NEW'] = 'poster(s) created';
$lang['SYNC_THUMBS_NEW'] = 'VideoJS thumbnail(s) created';
$lang['SYNC_WARNINGS'] = 'Warnings';
$lang['SYNC_WARNINGS_COUNT'] = 'warning(s) during synchronization';
$lang['SYNC_ERRORS'] = 'Errors';
$lang['SYNC_ERROR_COUNT'] = 'error(s) during synchronization';
$lang['FILE_NOT_READABLE'] = 'file not readable';
$lang['DIR_NOT_WRITABLE'] = 'directory without write access';

$lang['SYNC_METADATA'] = 'Metadata';
$lang['METADATA_COUNT'] = 'Number of metadata items:';
$lang['SYNC_DATABASE'] = 'Metadata extracted from the database';
$lang['SYNC_REQUIRE'] = 'Requires <a href="https://exiftool.org" target="_blank">ExifTool</a>, <a href="http://mediaarea.net/en/MediaInfo" target="_blank">MediaInfo</a> or <a href="http://www.ffmpeg.org" target="_blank">FFprobe</a>';
$lang['SYNC_METADATA_DESC'] = 'Will overwrite the information in the database with the metadata from the video.';
$lang['SYNC_METADATA_ERROR'] = 'Metadata cannot be retrieved because ExifTool, FFprobe or MediaInfo are not installed or their paths are incorrect.';
$lang['SYNC_MEDIAINFO_ERROR'] = 'Metadata cannot be retrieved with MediaInfo because the XML library is missing';
$lang['SYNC_DELETE'] = 'Delete VideoJS thumbnails and extra video sources';
$lang['SYNC_DELETE_ASK'] = 'Are you sure? Extra video sources and VideoJS thumbnails will be deleted.';
$lang['SYNC_DELETE_DESC'] = 'Useful for videos that do not include an orientation metadata and which are displayed with a VideoJS player in conjonction with the videojs-zoomrotate plugin. The video and its poster remain untouched. Only the orientation parameter stored in the database is updated.';

$lang['POSTER'] = 'Poster';
$lang['POSTER_ERROR'] = 'FFmpeg could not generate the poster, check logs and try manually';
$lang['SYNC_REPRESENTATIVES'] = 'Adopt posters uploaded manually';
$lang['SYNC_REPRESENTATIVES_DESC'] = 'For each video, updates the information related with its poster.';
$lang['SYNC_POSTER_TITLE'] = 'Posters for photo gallery';
$lang['SYNC_POSTER'] = 'Create posters at position in seconds:';
$lang['SYNC_POSTER_DESC'] = 'Create	a poster from the video at the specified position in seconds.';
$lang['SYNC_POSTER_REQUIRE'] = 'Requires <a href="http://www.ffmpeg.org" target="_blank">FFmpeg</a>';
$lang['SYNC_POSTER_ERROR'] = 'Poster and thumbnail creation disabled because FFmpeg is not installed or its path is incorrect.';
$lang['SYNC_POSTEROVERWRITE'] = 'Overwrite existing posters';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Overwrite existing thumbnails with new ones. If uncheck it should only run for newly added video.';
$lang['SYNC_OUTPUT'] = 'Format:';
$lang['SYNC_OUTPUT_DESC'] = 'Select the output format for the poster and thumbnail.';
$lang['SYNC_POSTEROVERLAY'] = 'Add film effect';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Apply an overlay on the poster creation.';
$lang['SYNC_POSTEROVERLAY_ERROR'] = 'Film effect disabled because the GD library is missing.';
$lang['SYNC_DURATION_ERROR'] = 'unknown duration, the poster cannot be created';
$lang['SYNC_DURATION_SHORT'] = 'too short duration, poster produced at another position';

$lang['SYNC_THUMB'] = 'VideoJS thumbnails';
$lang['SYNC_THUMB_ERROR'] = 'FFmpeg could not generate the thumbnails, check logs and try manually';
$lang['SYNC_THUMBSEC'] = 'Create a thumbnail every N seconds where N =';
$lang['SYNC_THUMBSEC_DESC'] = 'These thumbnails are only used by VideoJS.';
$lang['SYNC_THUMBSIZE'] = 'Size of the thumbnail:';
$lang['SYNC_THUMBSIZE_DESC'] = 'Size in pixel, keep it small, default is fine, Youtube use 190x68.';
$lang['SYNC_THUMBSIZE_ERROR'] = 'Invalid thumbnail size, fallback to default value of 120 px';

$lang['VIDEOS_ALL'] = 'All videos';
$lang['VIDEOS_W_POSTER'] = 'All videos with poster';
$lang['VIDEOS_WO_POSTER'] = 'All videos without poster';
$lang['VIDEOS_METADATA_POSTERS'] = 'Video metadata and posters';
