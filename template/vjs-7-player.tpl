{html_head}
<link href="{$VIDEOJS_PATH}video-js-7/video-js.min.css" rel="stylesheet">
<script src="{$VIDEOJS_PATH}video-js-7/video.min.js"></script>
{/html_head}

{literal}
<video id="my_video_1" class="video-js vjs-fluid" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} datasetup='{}' x-webkit-airplay="allow">
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

