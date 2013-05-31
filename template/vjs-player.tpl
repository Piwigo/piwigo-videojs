{html_head}
<link href="{$VIDEOJS_PATH}video-js/{$VIDEOJS_SKINCSS}" rel="stylesheet">
{$VIDEOJS_CUSTOMCSS}
<script src="{$VIDEOJS_PATH}video-js/video.js"></script>
<script>
  videojs.options.flash.swf = "{$VIDEOJS_PATH}video-js/video-js.swf"
</script>
{/html_head}

<div style="margin: 0 auto; width:{$WIDTH}px; min-width:480px">

{literal}
<video id="my_video_1" class="video-js {/literal}{$VIDEOJS_SKIN}{literal}" {/literal}{$OPTIONS}{literal} width={/literal}"{$WIDTH}"{literal} height={/literal}"{$HEIGHT}"{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} data-setup='{}'>
  <source src={/literal}"{$VIDEOJS_MEDIA_URL}"{literal} type='video/{/literal}{$TYPE}{literal}'>
  <p>Video Playback Not Supported<br/>Your browser does not support the video tag.</p>
</video>
{/literal}

</div>
