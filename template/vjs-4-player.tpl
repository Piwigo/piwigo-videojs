{html_head}
<link href="{$VIDEOJS_PATH}video-js-4/{$VIDEOJS_SKINCSS}" rel="stylesheet">
{$VIDEOJS_CUSTOMCSS}
<link href="{$VIDEOJS_PATH}video-js-4/video-js-resolutions.css" rel="stylesheet"/>
{if not empty($thumbnails)}
<link href="{$VIDEOJS_PATH}video-js-4/videojs.thumbnails.css" rel="stylesheet">
{/if}
{if not empty($watermark)}
<link href="{$VIDEOJS_PATH}video-js-4/videojs.watermark.css" rel="stylesheet">
{/if}
<script src="{$VIDEOJS_PATH}video-js-4/video.js"></script>
<script type="text/javascript" src="{$VIDEOJS_PATH}video-js-4/video-js-resolutions.js"></script>
{if not empty($thumbnails)}
<script type="text/javascript" src="{$VIDEOJS_PATH}video-js-4/videojs.thumbnails.js"></script>
{/if}
{if not empty($zoomrotate)}
<script type="text/javascript" src="{$VIDEOJS_PATH}video-js-4/videojs.zoomrotate.js"></script>
{/if}
{if not empty($watermark)}
<script type="text/javascript" src="{$VIDEOJS_PATH}video-js-4/videojs.watermark.js"></script>
{/if}
<script type="text/javascript">
  videojs.options.flash.swf = "{$VIDEOJS_PATH}video-js-4/video-js.swf"
</script>
<style>
{literal}
.video-js {padding-top: {/literal}{$RATIO}{literal}%}
.vjs-fullscreen {padding-top: 0px}
.videocontent{ width:80%; max-width:{/literal}{$WIDTH}{literal}px; margin: 0 auto;}
{/literal}
</style>
{/html_head}

<div class="wrapper">
 <div class="videocontent">
{literal}
<video id="my_video_1" class="video-js {/literal}{$VIDEOJS_SKIN}{literal}" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} datasetup='{}' x-webkit-airplay="allow" width="auto" height="auto">
{/literal}
{if not empty($videos)}
{foreach from=$videos item=video}
{literal}    <source src={/literal}"{$video.src}"{literal} data-res='{/literal}{$video.resolution}{literal}' type='{/literal}{$video.ext}{literal}'>{/literal}
{/foreach}
{/if}
{literal}
    <p>Video Playback Not Supported<br/>Your browser does not support the video tag.</p>
</video>
{/literal}
 </div>
</div>

{literal}
<script type="text/javascript">
// Once the video is ready
videojs("my_video_1", {}, function(){
	var my_video_volume = videojs('my_video_1');
	my_video_volume.volume({/literal}{$volume}{literal});
  // enable resolutions plugin
  my_video_volume.resolutions();
});
</script>
{/literal}

{if not empty($thumbnails)}
{literal}
<script>
// initialize video.js
var my_video_thumb = videojs('my_video_1');
// Set value to the thumbnails plugin
my_video_thumb.thumbnails({{/literal}
  {foreach from=$thumbnails item=thumbnail}
  {$thumbnail.second}{literal}: {
    src: '{/literal}{$thumbnail.source}{literal}'
  },{/literal}
  {/foreach}
{literal}});
</script>{/literal}
{/if}

{if not empty($zoomrotate)}
{literal}
<script>
// initialize video.js
var my_video_zoomrotate = videojs('my_video_1');
// Set value to the zoomrotate plugin
my_video_zoomrotate.zoomrotate({
  rotate: {/literal}{$zoomrotate.rotate}{literal},
  zoom: {/literal}{$zoomrotate.zoom}{literal}
  });
</script>
{/literal}
{/if}

{if not empty($watermark)}
{literal}
<script>
// initialize video.js
var my_video_id = videojs('my_video_1');
// Set value to the watermark plugin
my_video_id.watermark({
  file: '{/literal}{$watermark.file}{literal}',
  xpos: {/literal}{$watermark.xpos}{literal},
  ypos: {/literal}{$watermark.ypos}{literal},
  xrepeat: {/literal}{$watermark.xrepeat}{literal},
  opacity: {/literal}{$watermark.opacity}{literal},
  });
</script>
{/literal}
{/if}
