<h2>{$TITLE} &#8250; {'Edit photo'|@translate} {$TABSHEET_TITLE}</h2>

<form action="{$F_ACTION}" method="post" id="openstreetmap">

	<input type="hidden" name="pwg_token" value="{$PWG_TOKEN}">
	<fieldset>
		<legend>{'Properties'|@translate}</legend>
		<div style="float: left;">
			<img src="{$TN_SRC}" alt="{'Thumbnail'|@translate}" class="Thumbnail">
		</div>
		{if not empty($EXIF)}
		<div style="float: left; margin: auto;">
			<ul>
				{foreach from=$EXIF key=name item=metadata}
				<li>{$name}: {$metadata}</li>
				{/foreach}
			</ul>
		</div>
		{/if}
		{if not empty($INFOS)}
		<div style="float: left; margin: auto;">
			<ul>
				{foreach from=$INFOS key=name item=metadata}
				<li>{$name}: {$metadata}</li>
				{/foreach}
			</ul>
		</div>
		{/if}
	</fieldset>

</form>