{html_head}
<style>
{literal}
.video-js{ width: 80%; }
.videocontent{ max-width: {/literal}{$WIDTH}{literal}px; min-width: 400px; margin: 0 auto; }
{/literal}
</style>
{/html_head}

<div class="wrapper">
 <div class="videocontent">
{literal}
<video id="my_video_1" class="video-js" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} x-webkit-airplay="allow" width="auto" height="auto">
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
</div>
