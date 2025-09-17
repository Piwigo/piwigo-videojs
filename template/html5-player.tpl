{html_head}{literal}
<style>
.video-js{ margin: 0 auto; }
.video-container {
    width: 100%;
    max-width: {$DERIV_MAX_WIDTH}px;
    max-height: 100vh;
    margin: 0 auto;
}
</style>
{/literal}{/html_head}

<div class="video-container">
{literal}
<video id="my_video_1" class="video-js" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} x-webkit-airplay="allow" style="width:100%;height:100%;">
{/literal}
{if not empty($videos)}
{foreach from=$videos item=video}
{literal}    <source src={/literal}"{$video.src}"{literal} type='{/literal}{$video.ext}{literal}'>{/literal}
{/foreach}
{/if}
{literal}
    <p>Video Playback Not Supported<br/>Your browser does not support the video tag.</p>
</video>
</div>
{/literal}
