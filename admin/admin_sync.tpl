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
Refer to the <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blanck">plugin documentation</a> for additional information. Create an <a href="https://github.com/xbgmsharp/piwigo-videojs/issues" target="_blanck">issue</a> for support, or feedback, or feature request.

<div class="vjs_layout">
  <legend>{'Statistics'|@translate}</legend>
  <ul>
    <li class="update_summary_new">{$NB_VIDEOS} {'videos in your gallery'|@translate}</li>
    <li class="update_summary_new">{$NB_VIDEOS_GEOTAGGED} {'geotagged videos'|@translate}</li>
    <li class="update_summary_new">{$NB_VIDEOS_THUMB} {'videos with poster'|@translate}</li>
  </ul>
</div>

{if isset($update_result)}
<div class="vjs_layout">
  <legend>Synchronization results</legend>
  <ul>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_CANDIDATES} {'video(s) in your gallery'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_EXIF} {'video(s) with metadata added'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_THUMB} {'poster(s) created'|@translate}</li>
    <li class="update_summary_err">{$update_result.NB_ERRORS} {'errors during synchronization'|@translate}</li>
  </ul>

{if not empty($sync_errors)}
  <h3>{'Error list'|@translate}</h3>
  <div class="errors">
    <ul>
      {foreach from=$sync_errors item=error}
      <li>{$error}</li>
      {/foreach}
    </ul>
  </div>
{/if}

{if not empty($sync_warnings)}
  <h3>{'Warning list'|@translate}</h3>
  <div class="warnings">
    <ul>
      {foreach from=$sync_warnings item=warning}
      <li>{$warning}</li>
      {/foreach}
    </ul>
  </div>
{/if}

{if not empty($sync_infos)}
  <h3>{'Detailed informations'|@translate}</h3>
  <div class="infos">
    <ul>
      {foreach from=$sync_infos item=info}
      <li>{$info}</li>
      {/foreach}
    </ul>
  </div>
{/if}

</div>
{/if}

<form action="" method="post" id="update">

  <fieldset id="syncmeta">
    <legend>{'Synchronize metadata'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="metadata" value="1" checked="checked" /> filesize, width, height, latitude, longitude, date_creation, rotation</label>
	<br/><small>Will overwrite the information in the database with the metadata from the video.</small>
	<br/><small><strong>Support of latitude, longitude required <a href="http://piwigo.org/ext/extension_view.php?eid=701" target="_blanck">'OpenStreetMap'</a> or 'RV Maps & Earth' plugin.</strong></small>
	<small><strong>Require <a href="http://mediaarea.net/en/MediaInfo" target="_blanck">'MediaInfo'</a> to be install.</strong></small>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncposter">
    <legend>{'Poster'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="poster" value="1" checked="checked" /> Create a poster at position in second:</label>
	<!-- <input type="range" name="postersec" value="4" min="0" max="60" step="1"/> -->
	<input type="text" name="postersec" value="4" size="2" required/>
	<br/><small>Create a poster from the video at specify position.</small>
	<small><strong>Require <a href="http://www.ffmpeg.org/" target="_blanck">'FFmpeg'</a> to be install.</strong></small>
      </li>
      <li>
	<label><input type="checkbox" name="posteroverwrite" value="1" checked="checked"> Overwrite existing posters</label>
	<br/><small>Overwrite existing thumbnails with new ones. If uncheck it should only run for newly added video.</small>
      </li>
      <li>
	<label><span class="property">Output format : </span></label>
	<label><input type="radio" name="output" value="jpg" checked="checked"/> JPG</label>
	<label><input type="radio" name="output" value="png" /> PNG</label>
	<br/><small>Select the output format for the poster and thumbnail.</small>
      </li>
      <li>
	<label><input type="checkbox" name="posteroverlay" value="1" /> Add film effect</label>
	<a class="showInfo" title="<img src='{$VIDEOJS_PATH}admin/example-frame.jpg'>">i</a>
	<br/><small>Apply an overlay on the poster creation.</small>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncthumb">
    <legend>{'Thumbnail'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="thumb" value="1" /> Create a thumbnail at every seconds:</label>
	<!-- <input type="range" name="thumbsec" value="5" min="0" max="60" step="1"/> -->
	<input type="text" name="thumbsec" value="5" size="2" required/>
	<br/><small>Create a thumbnail every x seconds. <strong>Use by the videoJS plugin thumbnail</strong>.</small>
      </li>
      <li>
	<label>Size of the thumbnail:</label>
	<input type="text" name="thumbsize" value="120x68" size="3" placeholder="120x68" required/>
	<br/><small>Size in pixel, keep it small, default is fine, Youtube use 190x68.</small>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncOptions">
    <legend>{'Simulation'|@translate}</legend>
    <ul>
      <li><label><input type="checkbox" name="simulate" value="1" checked="checked" /> {'only perform a simulation (no change in database will be made)'|@translate}</label></li>
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
