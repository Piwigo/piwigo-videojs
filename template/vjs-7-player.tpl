{html_head}
<link href="{$VIDEOJS_PATH}video-js-7/video-js.min.css" rel="stylesheet">
<script src="{$VIDEOJS_PATH}video-js-7/video.min.js"></script>
<style>
.video-js{ margin: 0 auto; }
</style>
{/html_head}

{literal}
<video id="my_video_1" class="video-js" {/literal}{$OPTIONS}{literal} poster={/literal}"{$VIDEOJS_POSTER_URL}"{literal} datasetup='{}' x-webkit-airplay="allow">
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

{footer_script}
{literal}
function setVideoDimensions(player, i) {
    let dim = player.currentDimensions();
    if (dim.height == 150 && dim.width == 300 && i > 0) {   /* default dimensions => retry in 50 milliseconds */
        setTimeout(setVideoDimensions, 50, player, i - 1);
    } else {
        let max_height = {/literal}{$DERIV_MAX_HEIGHT}{literal};
        let max_width = {/literal}{$DERIV_MAX_WIDTH}{literal};
        if ( dim.height > max_height || dim.width > max_width ) {
            if ( dim.height > 0 && dim.width > 0 ) {
                let scale = Math.min( max_height / dim.height, max_width / dim.width );
                player.width(Math.floor( scale * dim.width ));
            };
        };
    };
};

const player = videojs("my_video_1");

player.ready(function(){
    setVideoDimensions(player, 20);
});
{/literal}
{/footer_script}
