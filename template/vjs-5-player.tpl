{html_head}
<link href="{$VIDEOJS_PATH}video-js-5/video-js.min.css" rel="stylesheet">
{if not empty($thumbnails)}
<link href="{$VIDEOJS_PATH}video-js-5/videojs.thumbnails.css" rel="stylesheet">
{/if}
{if not empty($watermark)}
<link href="{$VIDEOJS_PATH}video-js-5/videojs.watermark.css" rel="stylesheet">
{/if}
{if not empty($resolution)}
<link href="{$VIDEOJS_PATH}video-js-5/videojs-resolution-switcher.css" rel="stylesheet">
{/if}
<script src="{$VIDEOJS_PATH}video-js-5/video.min.js"></script>
{if not empty($thumbnails)}
<script type="text/javascript" src="{$VIDEOJS_PATH}video-js-5/videojs.thumbnails.js"></script>
{/if}
{if not empty($zoomrotate)}
<script type="text/javascript" src="{$VIDEOJS_PATH}video-js-5/videojs.zoomrotate.js"></script>
{/if}
{if not empty($resolution)}
<script type="text/javascript" src="{$VIDEOJS_PATH}video-js-5/videojs-resolution-switcher.js"></script>
{/if}
<script type="text/javascript">
  videojs.options.flash.swf = "{$VIDEOJS_PATH}video-js-5/video-js.swf"
</script>
<style>
{literal}
.video-container {
    width: 100%;
    max-width: {/literal}{$WIDTH}{literal}px;
    margin: 0 auto;
    position: relative;
    display: flex;
    justify-content: center;
}

.video-js {
    position: relative;
    padding-top: {/literal}{$RATIO}{literal}%;
    width: 100%;
    height: 0;
    max-width: {/literal}{$WIDTH}{literal}px;
}

/* Ensure video element maintains aspect ratio */
.video-js .vjs-tech {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain !important;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .video-container {
        max-width: 100vw;
        max-height: 80vh;
    }
    
    .video-js {
        max-height: 80vh;
    }
}
{/literal}
</style>
{/html_head}
<div class="video-container">
<video id="my_video_1" class="video-js vjs-big-play-centered {$VIDEOJS_SKIN}" {$OPTIONS} poster="{$VIDEOJS_POSTER_URL}">
{if not empty($videos)}
{foreach from=$videos item=video}
    <source src="{$video.src}" type="{$video.ext}">
{/foreach}
{/if}
    <p>Video Playback Not Supported<br/>Your browser does not support the video tag.</p>
</video>
</div>
{literal}
<script type="text/javascript">
videojs("my_video_1", {}, function(){
    var player = this;
    player.volume({/literal}{$volume}{literal});
    
    // Force aspect ratio
    var tech = player.el().querySelector('.vjs-tech');
    if (tech) {
        tech.style.objectFit = 'contain';
    }
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
