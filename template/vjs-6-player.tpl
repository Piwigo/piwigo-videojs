{html_head}
<link href="{$VIDEOJS_PATH}video-js-6/video-js.min.css" rel="stylesheet">
<script src="{$VIDEOJS_PATH}video-js-6/video.min.js"></script>
{if not empty($vr)}
<script src="{$VIDEOJS_PATH}video-js-vr/videojs-vr.min.js"></script>
{/if}
{literal}
<style type="text/css">
#my_video_1 canvas {
	left: 0px;
}
</style>
{/literal}
{/html_head}

{literal}
<video id="my_video_1" class="video-js vjs-fluid vjs-default-skin" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} datasetup='{}' x-webkit-airplay="allow">
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

{literal}
<script type="text/javascript">
// Once the video is ready
var player = videojs("my_video_1", {}, function(){
	var my_video_volume = videojs('my_video_1');
	my_video_volume.volume({/literal}{$volume}{literal});
});
{/literal}
{if not empty($vr)}
	{literal}player.vr({projection: '{/literal}{$vr.projection}{literal}'});{/literal}
{/if}
{literal}
</script>
{/literal}
