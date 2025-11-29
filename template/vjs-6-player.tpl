{html_head}
<link href="{$VIDEOJS_PATH}video-js-6/video-js.min.css" rel="stylesheet">
<script src="{$VIDEOJS_PATH}video-js-6/video.min.js"></script>
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

/* Override vjs-fluid class */
.video-js.vjs-fluid {
    padding-top: {/literal}{$RATIO}{literal}% !important;
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
<video id="my_video_1" class="video-js vjs-fluid vjs-default-skin" {$OPTIONS} poster="{$VIDEOJS_POSTER_URL}" data-setup='{}' x-webkit-airplay="allow">
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
// Once the video is ready
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
