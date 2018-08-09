{html_head}
<style>
  {literal}
    .vjs_layout {
      text-align: left;
      border: 2px solid rgb(221, 221, 221);
      padding: 1em;
      margin: 1em;
    }
    .showInfo {
      position:static;
      display:inline-block;
      padding:1px 7px;
      width:4px;
      height:16px;
      line-height:16px;
      font-size:0.8em;
	  background-color: rgb(153, 153, 153);
	  color: rgb(255, 255, 255);
	  border-radius: 10px;
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

{footer_script}{literal}
jQuery(".showInfo").tipTip({
  delay: 0,
  fadeIn: 200,
  fadeOut: 200,
  maxWidth: '300px',
  defaultPosition: 'right'
});
{/literal}{/footer_script}

Synchronization of metadata information and poster creation for videos.
<br/><br/>
Refer to the <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">plugin documentation</a> for additional information. Create an <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blank">issue</a> for support, or feedback, or feature request.

<div class="vjs_layout">
  <legend>{'Statistics'|@translate}</legend>
  <ul>
    <li class="update_summary_new">{$NB_VIDEOS} {'videos in your gallery'|@translate}</li>
    <li class="update_summary_new">{$NB_VIDEOS_THUMB} {'videos with poster in your gallery'|@translate}</li>
    <li class="update_summary_new">{$NB_VIDEOS_GEOTAGGED} {'geotagged videos in your gallery'|@translate}</li>
  </ul>
</div>

{if isset($update_result)}
<div class="vjs_layout">
  <legend>Synchronization results</legend>
  <ul>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_CANDIDATES} {'video(s) selected'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_EXIF} {'video(s) with metadata added'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_POSTER} {'poster(s) created'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_THUMB} {'thumbnail(s) created'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_WARNINGS} {'warnings during synchronization'|@translate}</li>
    <li class="update_summary_err">{$update_result.NB_ERRORS} {'errors during synchronization'|@translate}</li>
  </ul>

{if not empty($sync_errors)}
  <h3>{'SYNC_ERRORS'|@translate}</h3>
  <div class="errors">
    <ul>
      {foreach from=$sync_errors item=error}
      <li>{$error}</li>
      {/foreach}
    </ul>
  </div>
{/if}

{if not empty($sync_warnings)}
  <h3>{'SYNC_WARNINGS'|@translate}</h3>
  <div class="warnings">
    <ul>
      {foreach from=$sync_warnings item=warning}
      <li>{$warning}</li>
      {/foreach}
    </ul>
  </div>
{/if}

{if not empty($sync_infos)}
  <h3>{'SYNC_INFOS'|@translate}</h3>
  <div class="infos">
		{foreach from=$sync_infos item=infos}
		<ul>
			{foreach from=$infos key=name item=detail}
				{if $name == 'thumbnail'}
					<li>{$name}:</li>
					<ul>
						{foreach from=$detail item=thumb}
							<li>{$thumb}</li>
						{/foreach}
					</ul>
				{else}
					<li>{$name}: {$detail}</li>
				{/if}
			{/foreach}
		</ul>
		{/foreach}
  </div>
{/if}

</div>
{/if}

<form action="" method="post" id="update" oninput="thumbsecValue.value=thumbsec.value">

  <fieldset id="syncmeta">
    <legend>{'Synchronize metadata'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="metadata" value="1" {if $metadata}checked="checked"{/if} /> filesize, width, height, latitude, longitude, date_creation, rotation</label>
	<br/><small>{'SYNC_METADATA_DESC'|@translate}</small>
	<small><strong>Require <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">'MediaInfo' or 'ffprobe' or 'Exiftool'</a> to be install.</strong></small>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncposter">
    <legend>{'Poster'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="poster" value="1" {if $poster}checked="checked"{/if} /> {'SYNC_POSTER'|@translate}:</label>
	<!-- <input type="range" name="postersec" value="4" min="0" max="60" step="1"/> -->
	<input type="text" name="postersec" value="{$postersec}" size="2" required/>
	<br/><small>{'SYNC_POSTER_DESC'|@translate}</small>
	<small><strong>Require <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki/How-to-add-videos#external-tools" target="_blank">'FFmpeg'</a> to be install.</strong></small>
      </li>
      <li>
	<label><input type="checkbox" name="posteroverwrite" value="1" {if $posteroverwrite}checked="checked"{/if}> {'SYNC_POSTEROVERWRITE'|@translate}</label>
	<br/><small>{'SYNC_POSTEROVERWRITE_DESC'|@translate}</small>
      </li>
      <li>
	<label><span class="property">{'SYNC_OUTPUT'|@translate}: </span></label>
	<label><input type="radio" name="output" value="jpg" {if $output=="jpg"}checked="checked"{/if}/> JPG</label>
	<label><input type="radio" name="output" value="png" {if $output=="png"}checked="checked"{/if}/> PNG</label>
	<br/><small>{'SYNC_OUTPUT_DESC'|@translate}</small>
      </li>
      <li>
	<label><input type="checkbox" name="posteroverlay" value="1" {if $posteroverlay}checked="checked"{/if}/> {'SYNC_POSTEROVERLAY'|@translate}</label>
	<a class="showInfo" title="<img src='{$VIDEOJS_PATH}admin/example-frame.jpg'>">i</a>
	<br/><small>{'SYNC_POSTEROVERLAY_DESC'|@translate}</small>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncthumb">
    <legend>{'Thumbnail'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="thumb" value="1" {if $thumb}checked="checked"{/if}/> {'SYNC_THUMBSEC'|@translate}:</label>
	<input class="range-input" type="range" id="thumbsec" name="thumbsec" value="{$thumbsec}" min="0" max="60" step="1"/>
	<output name="thumbsecValue" for="thumbsec">{$thumbsec}</output>
	<!-- <input type="text" name="thumbsec" value="5" size="2" required/> -->
	<br/><small>{'SYNC_THUMBSEC_DESC'|@translate} <strong>Use by the videoJS plugin thumbnail</strong>.</small>
      </li>
      <li>
	<label>{'SYNC_THUMBSIZE'|@translate}:</label>
	<input type="text" name="thumbsize" value="{$thumbsize}" size="5" placeholder="120x68" required/>
	<br/><small>{'SYNC_THUMBSIZE_DESC'|@translate}</small>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncOptions">
    <legend>{'Simulation'|@translate}</legend>
    <ul>
      <li><label><input type="checkbox" name="simulate" value="1" {if $simulate}checked="checked"{/if} /> {'only perform a simulation (no change in database will be made)'|@translate}</label></li>
    </ul>
  </fieldset>

  <fieldset id="catSubset">
    <legend>{'reduce to single existing albums'|@translate}</legend>
    <ul>
    <li>
    <select class="categoryList" name="cat_id" size="10">
	{html_options options=$categories selected=$categories_selected}
    </select>
    </li>

    <li><label><input type="checkbox" name="subcats_included" value="1" {$SUBCATS_INCLUDED_CHECKED} /> {'Search in sub-albums'|@translate}</label></li>
    </ul>
  </fieldset>

  <p>
    <input type="submit" value="{'Submit'|@translate}" name="submit">
  </p>
</form>
