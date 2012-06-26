<div class="infos" style="text-align:left;padding-left:45px;font-size:14px;font-weight:bold;">{$VJS_INFO|@translate}</div>
 <h2> {'Title'|@translate} <br> {$VJS_VERSION}</h2>
<p>{'Howto'|@translate}</p>
<p>{'Howto1'|@translate}</p>
<p>{'Howto2'|@translate}</p>

<form method="post" action="" class="properties">
	<fieldset>
		<legend>{pref|@translate}</legend>
		<ul style="font-size:1em;font-weight:normal;margin-right:30%;text-align:right">
			<li>
				<label>{skin|@translate} : </label>
				<select name="vjs_skin">
					{html_options options=$AVAILABLE_SKINS selected=$SELECTED_SKIN}
				</select>
			</li>
			<li>
				<label>{preload|@translate} : </label>
				<select name="vjs_preload">
					{html_options options=$AVAILABLE_PRELOAD selected=$SELECTED_PRELOAD}
				</select>
			</li>
			<li>
				<label>{controls|@translate} : </label>
				{html_radios name='vjs_controls' values='true,false'|@explode output='Yes,No'|@explode|translate selected=$CONTROLS}
			</li>
			<li>
				<label>{autoplay|@translate} : </label>
				{html_radios name='vjs_autoplay' values='true,false'|@explode output='Yes,No'|@explode|translate selected=$AUTOPLAY}
			</li>
			<li>
				<label>{loop|@translate} : </label>
				{html_radios name='vjs_loop' values='true,false'|@explode output='Yes,No'|@explode|translate selected=$LOOP}
			</li>
		</ul>
		<legend>{pref2|@translate}</legend>
		<ul style="font-size:1em;font-weight:normal;margin-right:30%;text-align:right">
			<li>
				<label>{width|@translate} : </label>
				<select name="max_width">
					{html_options options=$AVAILABLE_WIDTH selected=$SELECTED_WIDTH}
				</select>
			</li>
		<ul>
		<input class="submit" type="submit" value="{'Submit'|@translate}" name="submit"/>
	</fieldset>
</form>
