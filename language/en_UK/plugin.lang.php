<?php

$lang['HTML5'] = 'HTML5 video tag settings';
$lang['PRELOAD'] = 'Preload';
$lang['PRELOAD_DESC'] = 'The preload attribute informs the browser whether or not the video data should begin downloading as soon as the video tag is loaded.';
$lang['CONTROLS'] = 'Controls';
$lang['CONTROLS_DESC'] = 'The controls option sets whether or not the player has controls that the user can interact with';
$lang['AUTOPLAY'] = 'Autoplay';
$lang['AUTOPLAY_DESC'] = 'If autoplay is true, the video will start playing as soon as the page is loaded (without any interaction from the user). NOT SUPPORTED BY APPLE iOS DEVICES.';
$lang['LOOP'] = 'Loop';
$lang['LOOP_DESC'] = 'The loop attribute causes the video to start over as soon as it ends.';
$lang['VOLUME'] = 'Volume';
$lang['VOLUME_DESC'] = 'The volume option sets the volume level. 0 is off (muted), 1.0 is all the way up, 0.5 is half way.';
$lang['LANGUAGE'] = 'Language';
$lang['LANGUAGE_DESC'] = 'Select the player language.';

$lang['METADATA_DESC'] = 'Metadata desc';
$lang['PLAYER_DESC'] = 'Select the vjs player version.';

$lang['PLUGIN'] = 'Plugin settings';
$lang['SKIN'] = 'Skin';
$lang['SKIN_DESC'] = 'Select the style you want to apply to the player or <a href="http://designer.videojs.com/" target="_blank">create your own skin</a>.';
$lang['CUSTOMCSS'] = 'Custom CSS';
$lang['CUSTOMCSS_DESC'] = 'Custom CSS to copy paste from the <a href="http://www.videojs.com/" target="_blank">VideoJS website</a>.';
$lang['HEIGHT'] = 'Max Height';
$lang['HEIGHT_DESC'] = 'The max height attribute sets the maximum display height of the video. If the video height is bigger than max height, it will downscale the video size to max height.';
$lang['UPSCALE'] = 'Upscale';
$lang['UPSCALE_DESC'] = 'If the video height is smaller than max height, it will upscale the video size to max height.';

$lang['VIDEOJSPLUGIN'] = 'VideoJS plugins';
$lang['ZOOMROTATE'] = 'ZoomRotate';
$lang['ZOOMROTATE_DESC'] = 'Rotate and zoom a video if applicable, use the rotation metadata.';
$lang['THUMBNAILS'] = 'Thumbnails';
$lang['THUMBNAILS_DESC'] = 'Displays thumbnail images over the progress bar.';
$lang['WATERMARK'] = 'Watermark';
$lang['WATERMARK_DESC'] = 'Displays watermark over the video.';
$lang['RESOLUTION'] = 'Resolution';
$lang['RESOLUTION_DESC'] = 'Resolution switcher.';

$lang['SYNC_ERRORS'] = 'Errors';
$lang['SYNC_WARNINGS'] = 'Warnings';
$lang['SYNC_INFOS'] = 'Detailed information';

$lang['SYNC_METADATA_DESC'] = 'Will overwrite the information in the database with the metadata from the video.';
$lang['SYNC_POSTER'] = 'Create a poster at position in second';
$lang['SYNC_POSTER_DESC'] = 'Create a poster from the video at specify position.';
$lang['SYNC_POSTEROVERWRITE'] = 'Overwrite existing posters';
$lang['SYNC_POSTEROVERWRITE_DESC'] = 'Overwrite existing thumbnails with new ones. If uncheck it should only run for newly added video.';
$lang['SYNC_OUTPUT'] = 'Output format';
$lang['SYNC_OUTPUT_DESC'] = 'Select the output format for the poster and thumbnail.';
$lang['SYNC_POSTEROVERLAY'] = 'Add film effect';
$lang['SYNC_POSTEROVERLAY_DESC'] = 'Apply an overlay on the poster creation.';
$lang['SYNC_THUMBSEC'] = 'Create a thumbnail at every seconds';
$lang['SYNC_THUMBSEC_DESC'] = 'Create a thumbnail every x seconds.';
$lang['SYNC_THUMBSIZE'] = 'Size of the thumbnail';
$lang['SYNC_THUMBSIZE_DESC'] = 'Size in pixel, keep it small, default is fine, Youtube use 190x68.';

?>
