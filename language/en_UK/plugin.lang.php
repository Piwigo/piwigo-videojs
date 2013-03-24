<?php
$lang['submit'] = 'Submit';

$lang['Howto'] = 'This plugin add HTML5 Video player OpenSource <a href="http://videojs.com/">videojs</a>.';
$lang['Howto1'] = 'Howto:<br/>
* Create a new album (MyVideoClip) via the admin panel or directly in your \'galleries\' directory.<br/>
* Upload your video into the new album (eg: galleries/MyVideoClip).<br/>
* Create a directory in your new Album call \'thumbnail\' or \'pwg_representative\' (eg: galleries/MyVideoClip/pwg_representative)<br/>
* Upload the poster image with the prefix \'TN-\' into the new thumbnail (eg: galleries/MyVideoClip/thumbnail/TN-oceans-clip.jpg)<br/>
* Or upload the poster image with NO prefix into the pwg_representative directory (eg: galleries/MyVideoClip/pwg_representative/oceans-clip.jpg).<br/>
* Synchronize<br/>
';

$lang['Howto2'] = 'Requirement:<br/>
* The video clip must be a support format and must contain no space neither special character.<br/>
* The poster must have the same size of the video.<br/>
* The poster must be in the subdirecotry of the album in thumbnail or pwg_representative.<br/>
* The poster must have the prefix \'TN-\' if in thumbnail.<br/>
* The poster can be a \'.jpg\' or \'.png\' file.<br/>
* The original video size is keep as long as it is below the max_width parameter in the admin panel.<br/>
If the video is HDReady (1280*720) or FullHD (1920*1080), the video will be scale via an impressive math formula (divide by 2).<br/>
The display resolution will for HDReady will be 640*360 and for FullHD 960*540.<br/>
Sample layout:<br/>
+-- honeymoon<br/>
    |-- hotel.png<br/>
    |-- video-from-plane.avi<br/>
    |-- video-from-ski.mp4<br/>
    +-- pwg_representative<br/>
    |   +-- video-from-plane.jpg<br/>
    +-- thumbnail<br/>
        +-- TN-video-from-ski.png<br/>
';

$lang['Howto3'] ='
Independent note from the plugin or Piwigo:<br/>
* Ensure your server is using the correct mime-types.<br/>
Firefox will NOT play the Ogg video if the mime-type is wrong.<br/>
Place these lines in your .htaccess file (in Piwigo root directory) to send the correct mime-types to browsers<br/>
<br/>
AddType video/ogg  .ogv<br/>
AddType video/mp4  .mp4<br/>
AddType video/webm .webm<br/>
<br/>
* Some web hosts, in trying to save bandwidth, gzip everything by default—including video files! In Firefox and Opera, seeking will not be possible or the video may not play at all if a video file is gzipped. If this is occurring to you please check your server / hosts and disable the gzipping of Ogg and other media files. You can switch off gzipping for video files in your .htaccess file by adding this line:<br/>
<br/>
SetEnvIfNoCase Request_URI \.(og[gv]|mp4|m4v|webm)$ no-gzip dont-vary<br/>';

$lang['Howto4'] = 'Please test your video and poster via the <a href="http://videojs.com/tag-builder/">HMTL5 Video Tag Builder</a>.<br/>Please check <a href="http://videojs.com/#section4">videojs compatibility</a> for supporterd video format and broswer.';

$lang['pref'] = 'HTML5 video tag settings';
$lang['pref2'] = 'Plugin settings';

$lang['skin'] = 'Skin';
$lang['preload'] = 'Preload';
$lang['controls'] = 'Controls';
$lang['autoplay'] = 'Autoplay';
$lang['loop'] = 'Loop';
$lang['width'] = 'Max Width';

?>
