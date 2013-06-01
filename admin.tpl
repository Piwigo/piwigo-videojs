<div class="titrePage">
  <h2>VideoJS plugin</h2>
</div>

This plugin add the open source HTML5 video player <a href="http://www.videojs.com/" target="_blank">VideoJS</a>.
<br/><br/>
Please read the <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blanck">plugin documentation</a> for additional information.

<form method="post" action="" class="properties">
	<fieldset>
		<legend>{'pref'|@translate}</legend>
		<ul>
			<li>
				<label>{'preload'|@translate} : </label>
				<select name="vjs_preload">
					{html_options options=$AVAILABLE_PRELOAD selected=$SELECTED_PRELOAD}
				</select>
			</li>
			<li>
				<label>{'controls'|@translate} : </label>
				{html_radios name='vjs_controls' values='true,false'|@explode output='Yes,No'|@explode|translate selected=$CONTROLS}
			</li>
			<li>
				<label>{'autoplay'|@translate} : </label>
				{html_radios name='vjs_autoplay' values='true,false'|@explode output='Yes,No'|@explode|translate selected=$AUTOPLAY}
			</li>
			<li>
				<label>{'loop'|@translate} : </label>
				{html_radios name='vjs_loop' values='true,false'|@explode output='Yes,No'|@explode|translate selected=$LOOP}
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<legend>{'pref2'|@translate}</legend>
		<ul>
			<li>
				<label>{'skin'|@translate} : </label>
				<select name="vjs_skin">
					{html_options options=$AVAILABLE_SKINS selected=$SELECTED_SKIN}
				</select>
			</li>
			<li>
				<label>{'customcss'|@translate} : </label>
				<textarea rows="5" cols="90" class="description" name="vjs_customcss" id="vjs_customcss">{$CUSTOM_CSS}</textarea>
			</li>
			<li>
				<label>{'width'|@translate} : </label>
				<select name="vjs_max_width">
					{html_options options=$AVAILABLE_WIDTH selected=$SELECTED_WIDTH}
				</select>
			</li>
		<ul>
	</fieldset>
	<p>
		<input class="submit" type="submit" value="{'Submit'|@translate}" name="submit"/>
	</p>
</form>
