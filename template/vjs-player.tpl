{html_head}
<link href="{$VIDEOJS_PATH}video-js/{$VIDEOJS_SKINCSS}" rel="stylesheet">
{$VIDEOJS_CUSTOMCSS}
{if not empty($thumbnails)}
<link href="{$VIDEOJS_PATH}video-js/videojs.thumbnails.css" rel="stylesheet">
{/if}
{if not empty($watermark)}
<link href="{$VIDEOJS_PATH}video-js/videojs.watermark.css" rel="stylesheet">
{/if}
<script src="{$VIDEOJS_PATH}video-js/video.js"></script>
{if not empty($thumbnails)}
<script src="{$VIDEOJS_PATH}video-js/videojs.thumbnails.js"></script>
{/if}
{if not empty($zoomrotate)}
<script src="{$VIDEOJS_PATH}video-js/videojs.zoomrotate.js"></script>
{/if}
{if not empty($watermark)}
<script src="{$VIDEOJS_PATH}video-js/videojs.watermark.js"></script>
{/if}
<script>
  videojs.options.flash.swf = "{$VIDEOJS_PATH}video-js/video-js.swf"
</script>
{/html_head}

<div style="margin: 0 auto; width:{$WIDTH}px; min-width:480px">

{literal}
<video id="my_video_1" class="video-js {/literal}{$VIDEOJS_SKIN}{literal}" {/literal}{$OPTIONS}{literal} width={/literal}"{$WIDTH}"{literal} height={/literal}"{$HEIGHT}"{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} data-setup='{}'>
{/literal}
{if not empty($videos)}
{foreach from=$videos item=video}
{literal}    <source src={/literal}"{$video.src}"{literal} type='{/literal}{$video.ext}{literal}'>{/literal}
{/foreach}
{/if}
{literal}
    <p>Video Playback Not Supported<br/>Your browser does not support the video tag.</p>
</video>
{/literal}

</div>

{literal}
<script>
// initialize video.js
var my_video_volume = videojs('my_video_1');
my_video_volume.volume({/literal}{$volume}{literal});
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