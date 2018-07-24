<h2>{$TITLE} &#8250; {'Edit photo'|@translate} {$TABSHEET_TITLE}</h2>

<form action="{$F_ACTION}" method="post" id="videojs">

	<input type="hidden" name="pwg_token" value="{$PWG_TOKEN}">
	<fieldset>
		<legend>{'Information'|@translate}</legend>
		<div style="float: left;">
			<img src="{$TN_SRC}" alt="{'Thumbnail'|@translate}" style="border: 2px solid rgb(221, 221, 221);">
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
		<div style="float: left; margin: auto; padding-left:20px; vertical-align:top;" class="photoLinks">
			<ul style="margin:0;">
				<li><a class="icon-arrows-cw" href="{$SYNC_URL}">{'Synchronize metadata'|@translate}</a></li>
				<li><a class="icon-trash" href="{$DELETE_URL}" onclick="return confirm('{'Are you sure?
Extra videos source and Thumbnails and Subtitle will be delete.'|@translate|@escape:javascript}');">{'Delete extra'|@translate}</a></li>
			</ul>
		</div>

		{if not empty($INFOS)}
		<div style="float: left; margin-top: 5px; border-top: 2px solid rgb(221, 221, 221); width: 100%;">
			<ul>
				{foreach from=$INFOS key=name item=data}
					{if $name == 'videos'}
						<ul>
						{foreach from=$data item=video}
							<li>source src="{$video.src}" type="{$video.ext}"</li>
						{/foreach}
						</ul>
					{elseif $name == 'thumbnails'}
						<ul>
						{foreach from=$data item=thumb}
							<li>thumbnail at second="{$thumb.second}" source="{$thumb.source}"</li>
						{/foreach}
						</ul>
					{else}
						<li>{$name}: {$data}</li>
					{/if}
				{/foreach}
			</ul>
		</div>
		{/if}
	</fieldset>
</form>
