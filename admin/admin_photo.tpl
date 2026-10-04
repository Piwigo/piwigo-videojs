<h2>{'Edit photo'|@translate} <span class="image-id">#{$IMAGE_ID}</span></h2>

<fieldset>
	<legend>{'SYNC_METADATA'|@translate}</legend>
	<div style="float: left;">
		<img src="{$TN_SRC}" alt="{'POSTER'|@translate}" style="border: 2px solid rgb(221, 221, 221);">
	</div>
	{if not empty($EXIF)}
		<div style="float: left; margin: auto; padding-left:20px; vertical-align:top;">
			<ul style="margin:0;">
				{foreach from=$EXIF key=name item=value}
				<li>{$name}: {$value}</li>
				{/foreach}
			</ul>
		</div>
	{/if}
	<form action="{$F_ACTION}" method="post" id="videojs" style="float: left; margin: auto; padding-left:20px; vertical-align:top; text-align:left;">
		<input type="hidden" name="pwg_token" value="{$PWG_TOKEN}">
		{$SYNC_OPTIONS}
		<p><input class="submit" type="submit" value="{'Submit'|@translate}" name="vjs_sync"></p>
	</form>

	<div style="clear: both; padding-top: 5px; border-top: 2px solid rgb(221, 221, 221);">
		<legend>{'Information'|@translate}</legend>
		<p class="photoLinks" style="text-align:left;">
			<a class="icon-trash" href="{$DELETE_URL}" onclick="return confirm('{'SYNC_DELETE_ASK'|@translate|@escape:javascript}');">{'SYNC_DELETE'|@translate}</a>
		</p>
		{if not empty($INFOS)}
		<ul>
			{foreach from=$INFOS key=name item=data}
				{if $name == 'poster'}
					<li>{'POSTER'|@translate}: {$data}</li>
				{else if $name == 'videoCount'}
					<li>{'VIDEO_SRC'|@translate}: {$data}</li>
				{else if $name == 'videos'}
					<ul>
					{foreach from=$data item=video}
						<li>{$video}</li>
					{/foreach}
					</ul>
				{else if $name == 'thumbnailCount'}
					<li>{'SYNC_THUMB'|@translate}: {$data}</li>
				{else if $name == 'thumbnails'}
					<ul>
					{foreach from=$data item=thumb}
						<li>{$thumb.second} s — {$thumb.source}</li>
					{/foreach}
					</ul>
				{else if $name == 'subtitle'}
					<li>Subtitle: {$data}</li>
				{/if}
			{/foreach}
		</ul>
		{/if}
	</div>

	<div style="clear: both; padding-top: 5px; border-top: 2px solid rgb(221, 221, 221);">
	<legend>{'Rotate'|@translate}</legend>
	<p style="text-align:left;">{'SYNC_DELETE_DESC'|@translate}</p>
	<form action="{$F_ACTION}" method="post" id="videojs_rotate">
		<input type="hidden" name="pwg_token" value="{$PWG_TOKEN}">
		<p style="text-align:left; margin-top:0;" id="angleSelection">
			<strong>{'Angle'|@translate}</strong>
			<br/>
			{foreach from=$angles item=angle}
			<label><input type="radio" name="angle" value="{$angle.value}"{if $angle.value == $angle_selected} checked="checked"{/if}> {$angle.name}</label><br>
			{/foreach}
		</p>
		<p style="text-align:left"><input class="submit" type="submit" value="{'Rotate'|@translate}" name="videojs_rotate"></p>
	</form>
</div>
</fieldset>
