{html_head}
<link href="{$VIDEOJS_PATH}video-js-6/video-js.min.css" rel="stylesheet">
<script src="{$VIDEOJS_PATH}video-js-6/video.min.js"></script>
<style>
.video-js{ margin: 0 auto; }
/* Ensure the video container takes up available width */
.video-container {
    width: 100%;
    max-width: {$DERIV_MAX_WIDTH}px; /* Optional: if you still want a max width from config */
    max-height: 100vh;
    margin: 0 auto;
}
</style>
{/html_head}

<div class="video-container">
{literal}
<video id="my_video_1" class="video-js vjs-fluid vjs-default-skin" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} data-setup='{ "fluid": true }' x-webkit-airplay="allow">
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
<script type="text/javascript">
// Once the video is ready
videojs("my_video_1", {}, function(){
	var my_video_volume = videojs('my_video_1');
	my_video_volume.volume({/literal}{$volume}{literal});
});
</script>
{/literal}
