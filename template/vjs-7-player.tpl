{html_head}
<link href="{$VIDEOJS_PATH}video-js-7/video-js.min.css" rel="stylesheet">
<script src="{$VIDEOJS_PATH}video-js-7/video.min.js"></script>
<style>
.video-js{ margin: 0 auto; }
/* Ensure the video container takes up available width */
.video-container {
    width: 100%;
    max-width: {$DERIV_MAX_WIDTH}px; /* Optional: if you still want a max width from config */
    margin: 0 auto;
}
</style>
{/html_head}

<div class="video-container">
{literal}
<video id="my_video_1" class="video-js vjs-fluid" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} data-setup='{ "fluid": true }' x-webkit-airplay="allow">
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

{footer_script}
{literal}
// const player = videojs("my_video_1"); // Video.js will auto-initialize with data-setup

// player.ready(function(){
    // Custom dimension logic removed to allow vjs-fluid to work.
    // If specific max dimensions are still strictly needed,
    // they should ideally be handled by the container's CSS.
    // let max_height = {/literal}{$DERIV_MAX_HEIGHT}{literal};
    // let max_width = {/literal}{$DERIV_MAX_WIDTH}{literal};
    // console.log("Video.js player ready. Max dimensions (config): " + max_width + "x" + max_height);
// });
{/literal}
{/footer_script}
