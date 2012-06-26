<?php
$lang['submit'] = 'Valider';

$lang['Howto'] = 'Ce plugin ajoute un lecture video HTML5 base sur le lecteur OpenSource <a href="http://videojs.com/">videojs</a>.';
$lang['Howto1'] = 'Step by step demo:<br/>
* Create a new Album (MyVideoClip) via the admin panel or directly in your \'galleries\' directory.<br/>
* Download and upload both file in the newly album (eg: galleries/MyVideoClip):<br/>
* The poster, http://video-js.zencoder.com/oceans-clip.jpg<br/>
* The video, http://video-js.zencoder.com/oceans-clip.mp4<br/>
* Rename the poster image to \'oceans-clip.jpg.poster\', this way it is not handle as an image.<br/>
* Synchronize<br/>
';

$lang['Howto2'] = 'Complete description:<br/>
* The video clip must be a support format and must contain no space neither special character.<br/>
* The poster must have the same size of the video and must be call \'.poster\'.<br/>
* The original video size is keep as long as it is below 720px width.<br/>
If the video is HDReady (1280*720) or FullHD (1920*1080), the video will be scale via an impressive math formula (divide by 2).<br/>
The display resolution will for HDReady will be 640*360 and for FullHD 960*540.<br/>';

$lang['Howto3'] = 'Independent note from the plugin or Piwigo:<br/>
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

$lang['pref'] = 'HTML5 video tag préférences';
$lang['pref2'] = 'Plugin préférences';

$lang['skin'] = 'Skin';
$lang['preload'] = 'Preload';
$lang['controls'] = 'Controls';
$lang['autoplay'] = 'Autoplay';
$lang['loop'] = 'Loop';
$lang['width'] = 'Max Width';

?>
