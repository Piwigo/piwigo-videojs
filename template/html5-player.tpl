{html_head}{literal}
<style>
.video-js{ max-height: {/literal}{$DERIV_MAX_HEIGHT}{literal}px; max-width: {/literal}{$DERIV_MAX_WIDTH}{literal}px; margin: 0 auto; }
</style>
{/literal}{/html_head}

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
