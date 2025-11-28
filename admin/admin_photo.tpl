<h2>{'Edit photo'|@translate} <span class="image-id">#{$IMAGE_ID}</span></h2>

<form action="{$F_ACTION}" method="post" id="videojs">

	<input type="hidden" name="pwg_token" value="{$PWG_TOKEN}">
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
		<div style="float: left; margin: auto; padding-left:20px; vertical-align:top;" class="photoLinks">
			<ul style="margin:0;">
				<li><a class="icon-arrows-cw" href="{$SYNC_URL}">{'Synchronize metadata'|@translate}</a></li>
				<li><a class="icon-trash" href="{$DELETE_URL}" onclick="return confirm('{'SYNC_DELETE_ASK'|@translate|@escape:javascript}');">{'SYNC_DELETE'|@translate}</a></li>
			</ul>
		</div>

		{if not empty($INFOS)}
			<div style="float: left; margin-top: 5px; border-top: 2px solid rgb(221, 221, 221); width: 100%;">
				<legend>{'Information'|@translate}</legend>
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
						{elseif $name == 'thumbnailCount'}
							<li>{'SYNC_THUMB'|@translate}: {$data}</li>
						{elseif $name == 'thumbnails'}
							<ul>
							{foreach from=$data item=thumb}
								<li>{$thumb.second} s — {$thumb.source}</li>
							{/foreach}
							</ul>
						{elseif $name == 'subtitle'}
							<li>Subtitle: {$data}</li>
						{/if}
					{/foreach}
				</ul>
			</div>
		{/if}
	</fieldset>
</form>
