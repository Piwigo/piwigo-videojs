{html_head}
<style>
  {literal}
    .vjs_layout {
      text-align: left;
      border: 2px solid rgb(221, 221, 221);
      padding: 1em;
      margin: 1em;
    }
    FORM.properties SPAN.property {
      width:150px;
    }
	.range-input {
	  position: relative; height: 10px; border: none; padding: 0;
	  background-color: rgb(204, 204, 204);
	  cursor: pointer;
	}
	input[type=range]:active::-moz-range-thumb {
	  cursor: pointer;
	  background:orange;
	}
	input[type=range]:active::-webkit-slider-thumb {
	  background:orange;
	  cursor: pointer;
	}
  {/literal}
</style>
{/html_head}

<fieldset>
<div style="text-align:left">
{'INTRO_CONFIG'|@translate}<br/>
  <ul>
    <li class="update_summary_new">{'INTRO_VIDEOJS'|@translate},</li>
    <li class="update_summary_new">{'INTRO_METADATA'|@translate},</li>
    <li class="update_summary_new">{'INTRO_THUMB'|@translate}.</li>
  </ul>
</div>
</fieldset>

<div class="vjs_layout">
  <legend>{'STATS'|@translate}</legend>
  <ul>
    <li class="update_summary_new">{$NB_VIDEOS} {'VIDEOS'|@translate}</li>
    <li class="update_summary_new">{$NB_VIDEOS_THUMB} {'VIDEOS_THUMB'|@translate}</li>
  </ul>
</div>

<form method="post" action="" class="properties" oninput="volumelevelValue.value=vjs_volume.value">
	<fieldset>
		<legend>{'HTML5'|@translate}</legend>
		<ul>
			<li>
				<label><span class="property">{'PRELOAD'|@translate}</span></label>
				<select name="vjs_preload">
					{html_options options=$AVAILABLE_PRELOAD selected=$preload}
				</select>
				<a class="icon-info-circled-1" title="{'PRELOAD_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'CONTROLS'|@translate}</span></label>
				<label><input type="radio" name="vjs_controls" value="true" {if $controls}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_controls" value="false" {if not $controls}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'CONTROLS_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'AUTOPLAY'|@translate} : </span></label>
				<label><input type="radio" name="vjs_autoplay" value="true" {if $autoplay}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_autoplay" value="false" {if not $autoplay}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'AUTOPLAY_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'LOOP'|@translate}</span></label>
				<label><input type="radio" name="vjs_loop" value="true" {if $loop}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_loop" value="false" {if not $loop}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'LOOP_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'VOLUME'|@translate}</span></label>
				<input class="range-input" type="range" id="vjs_volume" name="vjs_volume" value="{$volume}" min="0" max="1" step="0.1"/>
				<output name="volumelevelValue" for="vjs_volume">{$volume}</output>
				<!-- <label><input type="text" name="vjs_volume" value="1" placeholder="1"/></label> -->
				<a class="icon-info-circled-1" title="{'VOLUME_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'LANGUAGE'|@translate}</span></label>
				<select name="vjs_language">
					{html_options options=$AVAILABLE_LANGUAGES selected=$language}
				</select>
				<a class="icon-info-circled-1" title="{'LANGUAGE_DESC'|@translate}"></a>
			</li>
		</ul>
	</fieldset>

	<fieldset>
		<legend>{'METADATA'|@translate}</legend>
		<ul>
			<li>
				<label><span class="property">{'METADATA_FILE'|@translate}</span></label>
				<label><input type="radio" name="vjs_metadata" value="true" {if $metadata}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_metadata" value="false" {if not $metadata}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'METADATA_DESC'|@translate}"></a>
			</li>
		</ul>
	</fieldset>

	<fieldset>
		<legend>{'PLAYER'|@translate}</legend>
		<ul>
			<li>
				<label><span class="property">{'PLAYER_TYPE'|@translate}</span></label>
				<select name="vjs_player" id="vjs_player" onchange="player_toggle(this);">
					{html_options options=$AVAILABLE_PLAYERS selected=$player}
				</select>
				<a class="icon-info-circled-1" title="{'PLAYER_DESC'|@translate}"></a>
			</li>
		</ul>
	</fieldset>

	<div id="player">
	<fieldset>
		<legend>{'VIDEOJS_SETTINGS'|@translate}</legend>
		<ul>
			<li>
				<label><span class="property">{'SKIN'|@translate}</span></label>
				<select name="vjs_skin">
					{html_options options=$AVAILABLE_SKINS selected=$skin}
				</select>
				<small> {'SKIN_DESC'|@translate}</small>
			</li>
			<li>
				<label><span class="property">{'CUSTOMCSS'|@translate}</span></label>
				<textarea rows="5" cols="90" class="description" name="vjs_customcss" id="vjs_customcss">{$CUSTOM_CSS}</textarea>
			</li>
			<li>
				<label><span class="property">&nbsp;</span></label>
				<small>{'CUSTOMCSS_DESC'|@translate}</small>
			</li>
			<li>
				<label><span class="property">{'HEIGHT'|@translate}</span></label>
				<select name="vjs_max_height">
					{html_options options=$AVAILABLE_HEIGHT selected=$max_height}
				</select>
				<a class="icon-info-circled-1" title="{'HEIGHT_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'UPSCALE'|@translate}</span></label>
				<label><input type="radio" name="vjs_upscale" value="true" {if $upscale}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_upscale" value="false" {if not $upscale}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'UPSCALE_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'ZOOMROTATE'|@translate}</span></label>
				<label><input type="radio" name="vjs_zoomrotate" value="true" {if $plugins.zoomrotate}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_zoomrotate" value="false" {if not $plugins.zoomrotate}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'ZOOMROTATE_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'THUMBNAILS'|@translate}</span></label>
				<label><input type="radio" name="vjs_thumbnails" value="true" {if $plugins.thumbnails}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_thumbnails" value="false" {if not $plugins.thumbnails}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'THUMBNAILS_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'WATERMARK'|@translate}</span></label>
				<label><input type="radio" name="vjs_watermark" value="true" {if $plugins.watermark}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_watermark" value="false" {if not $plugins.watermark}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'WATERMARK_DESC'|@translate}"></a>
			</li>
			<li>
				<label><span class="property">{'RESOLUTION'|@translate}</span></label>
				<label><input type="radio" name="vjs_resolution" value="true" {if $plugins.resolution}checked="checked"{/if}/> {'Yes'|@translate}</label>
				&nbsp;<label><input type="radio" name="vjs_resolution" value="false" {if not $plugins.resolution}checked="checked"{/if}/> {'No'|@translate}</label>
				<a class="icon-info-circled-1" title="{'RESOLUTION_DESC'|@translate}"></a>
			</li>
		</ul>
	</fieldset>
	</div>
	
	<p>
		<input class="submit" type="submit" value="{'Save Settings'|@translate}" name="submit"/>
	</p>
</form>

{literal}
<script>
function player_toggle()
{
    var select = document.getElementById("vjs_player");
    var div = document.getElementById("player");
	if (select.selectedIndex == 3 || select.selectedIndex == 4) /* Only for VideoJS v4, v5 */
	{
			div.removeAttribute("style");
	} else {
			div.setAttribute("style","visibility:hidden; width:0px; height:0px; display:none;");
	}
}

window.onload = player_toggle();
</script>
{/literal}
