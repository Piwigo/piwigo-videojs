{html_head}
<style>
  {literal}
    .vjs_layout {
      text-align: left;
      border: 2px solid rgb(221, 221, 221);
      padding: 1em;
      margin: 1em;
    }
	.vjs_infos, .vjs_errors, .vjs_warnings {
	  text-align: left;
	  margin: 20px;
	  padding: 5px;
	  font-weight:bold;
	  min-height: 54px;
	  flex-direction: row;
	  display: flex;
      flex-wrap: wrap;
	  align-items: center;
	  justify-content: start;
	}
	.vjs_infos {
	  color: #0a0;
	  background-color:#c2f5c2;
	  border-left: 4px solid #0a0;
	}
	.vjs_errors {
	  color: #f22;
	  background-color: #ffd5dc;
	  border-left: 4px solid #f22;
	}
	.vjs_warnings {
	  color: #ee8800;
	  background-color:#ffdd99;
	  border-left:4px solid #ee8800;
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

<fieldset>
<div style="text-align:left">
{'SYNC_INTRO'|@translate}<br/>
<ul>
  <li class="update_summary_new">{'INTRO_METADATA'|@translate},</li>
  <li class="update_summary_new">{'INTRO_THUMB'|@translate}</li>
</ul>
{'INTRO_SUPPORT'|@translate}
</div>
</fieldset>

<div class="vjs_layout">
  <legend>{'STATS'|@translate}</legend>
  <ul>
    <li class="update_summary_new">{$NB_VIDEOS} {'VIDEOS'|@translate}</li>
    <li class="update_summary_new">{$NB_VIDEOS_THUMB} {'VIDEOS_THUMB'|@translate}</li>
    <li class="update_summary_new">{$NB_VIDEOS_GEOTAGGED} {'VIDEOS_GEOTAGGED'|@translate}</li>
  </ul>
</div>

{if isset($update_result)}
<div class="vjs_layout">
  <legend>{'SYNC_RESULTS'|@translate}</legend>
  <ul>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_CANDIDATES} {'SYNC_DETECTED'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_EXIF} {'SYNC_METADATA_ADDED'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_POSTER} {'SYNC_POSTERS_NEW'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_THUMB} {'SYNC_THUMBS_NEW'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_WARNINGS} {'SYNC_WARNINGS_COUNT'|@translate}</li>
    <li class="update_summary_err">{$update_result.NB_ERRORS} {'SYNC_ERROR_COUNT'|@translate}</li>
  </ul>

{if not empty($sync_errors)}
  <h3>{'SYNC_ERRORS'|@translate}</h3>
  <div class="vjs_errors">
    <ul>
      {foreach from=$sync_errors item=error}
      <li>{$error}</li>
      {/foreach}
    </ul>
  </div>
{/if}

{if not empty($sync_warnings)}
  <h3>{'SYNC_WARNINGS'|@translate}</h3>
  <div class="vjs_warnings">
    <ul>
      {foreach from=$sync_warnings item=warning}
      <li>{$warning}</li>
      {/foreach}
    </ul>
  </div>
{/if}

{if not empty($sync_infos)}
  <h3>{'SYNC_INFOS'|@translate}</h3>
  <div class="vjs_infos">
		{foreach from=$sync_infos item=infos}
		<ul>
			{foreach from=$infos key=name item=detail}
			    {if $name == 'file'}
			    	<li>Movie {$detail}</li>
			    {else}
			    	<ul style="list-style-type:none;">
					{if $name == 'thumbnail'}
						<li>{$name}:</li>
						<ul style="list-style-type:none;">
							{foreach from=$detail item=thumb}
								<li>{$thumb}</li>
							{/foreach}
						</ul>
					{else}
						<li>{$name}: {$detail}</li>
					{/if}
			    	</ul>
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
    <legend>{'SYNC_METADATA'|@translate}</legend>
    <ul>
      <li>
        <small>({'SYNC_REQUIRE'|@translate})</small>
	  </li>
      <li>
		<label><input type="checkbox" name="metadata" value="1" {if $metadata}checked="checked"{/if} /> {'Synchronize metadata'|@translate}</label>
		<a class="icon-info-circled-1" title="{'SYNC_METADATA_DESC'|@translate}"></a>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncposter">
    <legend>{'SYNC_POSTER_TITLE'|@translate}</legend>
    <ul>
      <li>
        <small>({'SYNC_POSTER_REQUIRE'|@translate})</small>
	  </li>
      <li>
		<label><input type="checkbox" name="poster" value="1" {if $poster}checked="checked"{/if} /> {'SYNC_POSTER'|@translate}</label>
		<!-- <input type="range" name="postersec" value="4" min="0" max="60" step="1"/> -->
		<input type="text" name="postersec" value="{$postersec}" size="2" required/>
		<a class="icon-info-circled-1" title="{'SYNC_POSTER_DESC'|@translate}"></a>
      </li>
      <li>
		<label><input type="checkbox" name="posteroverwrite" value="1" {if $posteroverwrite}checked="checked"{/if}> {'SYNC_POSTEROVERWRITE'|@translate}</label>
		<a class="icon-info-circled-1" title="{'SYNC_POSTEROVERWRITE_DESC'|@translate}"></a>
      </li>
      <li>
		<label><span class="property">{'SYNC_OUTPUT'|@translate} </span></label>
		<label><input type="radio" name="output" value="jpg" {if $output=="jpg"}checked="checked"{/if}/> JPG</label>
		<label><input type="radio" name="output" value="png" {if $output=="png"}checked="checked"{/if}/> PNG</label>
		<a class="icon-info-circled-1" title="{'SYNC_OUTPUT_DESC'|@translate}"></a>
      </li>
      <li>
		<label><input type="checkbox" name="posteroverlay" value="1" {if $posteroverlay}checked="checked"{/if}/> {'SYNC_POSTEROVERLAY'|@translate}</label>
		<a class="icon-info-circled-1" title="{'SYNC_POSTEROVERLAY_DESC'|@translate}"></a>
		<a class="showInfo" title="<img src='{$VIDEOJS_PATH}admin/example-frame.jpg'>">i</a>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncthumb">
    <legend>{'SYNC_THUMB'|@translate}</legend>
    <ul>
      <li>
        <small>({'SYNC_POSTER_REQUIRE'|@translate})</small>
	  </li>
      <li>
		<label><input type="checkbox" name="thumb" value="1" {if $thumb}checked="checked"{/if}/> {'SYNC_THUMBSEC'|@translate}</label>
		<input class="range-input" type="range" id="thumbsec" name="thumbsec" value="{$thumbsec}" min="1" max="60" step="1"/>
		<output name="thumbsecValue" for="thumbsec">{$thumbsec}</output>
		<!-- <input type="text" name="thumbsec" value="5" size="2" required/> -->
		<a class="icon-info-circled-1" title="{'SYNC_THUMBSEC_DESC'|@translate}"></a>
      </li>
      <li>
		<label>{'SYNC_THUMBSIZE'|@translate}</label>
		<input type="text" name="thumbsize" value="{$thumbsize}" size="6" placeholder="120x68" required/>
		<a class="icon-info-circled-1" title="{'SYNC_THUMBSIZE_DESC'|@translate}"></a>
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
      <li>
        <label><input type="checkbox" name="subcats_included" value="1" {$SUBCATS_INCLUDED_CHECKED} /> {'Search in sub-albums'|@translate}</label></li>
      </ul>
  </fieldset>

  <p>
    <input type="submit" value="{'Submit'|@translate}" name="submit">
  </p>
</form>
