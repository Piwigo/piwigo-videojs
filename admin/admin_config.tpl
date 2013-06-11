{html_head}
<style>
  {literal}
FORM.properties SPAN.property {
  width:100px;
}
  {/literal}
</style>
{/html_head}

This plugin add the open source HTML5 video player <a href="http://www.videojs.com/" target="_blank">VideoJS</a>.
<br/><br/>
Please read the <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blanck">plugin documentation</a> for additional information.

<form method="post" action="" class="properties">
	<fieldset>
		<legend>{'HTML5'|@translate}</legend>
		<ul>
			<li>
				<label><span class="property">{'PRELOAD'|@translate} : </span></label>
				<select name="vjs_preload">
					{html_options options=$AVAILABLE_PRELOAD selected=$preload}
				</select>
				<br/><small>{'PRELOAD_DESC'|@translate}</small>
			</li>
			<li>
				<label><span class="property">{'CONTROLS'|@translate} : </span></label>
				<label><input type="radio" name="vjs_controls" value="true" {if $controls}checked="checked"{/if}/> {'Yes'|@translate}</label>
				<label><input type="radio" name="vjs_controls" value="false" {if not $controls}checked="checked"{/if}/> {'No'|@translate}</label>
				<br/><small>{'CONTROLS_DESC'|@translate}</small>
			</li>
			<li>
				<label><span class="property">{'AUTOPLAY'|@translate} : </span></label>
				<label><input type="radio" name="vjs_autoplay" value="true" {if $autoplay}checked="checked"{/if}/> {'Yes'|@translate}</label>
				<label><input type="radio" name="vjs_autoplay" value="false" {if not $autoplay}checked="checked"{/if}/> {'No'|@translate}</label>
				<br/><small>{'AUTOPLAY_DESC'|@translate}</small>
			</li>
			<li>
				<label><span class="property">{'LOOP'|@translate} : </span></label>
				<label><input type="radio" name="vjs_loop" value="true" {if $loop}checked="checked"{/if}/> {'Yes'|@translate}</label>
				<label><input type="radio" name="vjs_loop" value="false" {if not $loop}checked="checked"{/if}/> {'No'|@translate}</label>
				<br/><small>{'LOOP_DESC'|@translate}</small>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<legend>{'PLUGIN'|@translate}</legend>
		<ul>
			<li>
				<label><span class="property">{'SKIN'|@translate} : </span></label>
				<select name="vjs_skin">
					{html_options options=$AVAILABLE_SKINS selected=$skin}
				</select>
				<br/><small>{'SKIN_DESC'|@translate}</small>
			</li>
			<li>
				<label><span class="property">{'CUSTOMCSS'|@translate} : </span></label>
				<textarea rows="5" cols="90" class="description" name="vjs_customcss" id="vjs_customcss">{$CUSTOM_CSS}</textarea>
				<br/><small>{'CUSTOMCSS_DESC'|@translate}</small>
			</li>
			<li>
				<label><span class="property">{'WIDTH'|@translate} : </span></label>
				<select name="vjs_max_width">
					{html_options options=$AVAILABLE_WIDTH selected=$max_width}
				</select>
				<br/><small>{'WIDTH_DESC'|@translate}</small>
			</li>
		<ul>
	</fieldset>
	<p>
		<input class="submit" type="submit" value="{'Save Settings'|@translate}" name="submit"/>
	</p>
</form>
