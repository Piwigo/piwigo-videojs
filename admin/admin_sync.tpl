{html_head}
<style>
  {literal}
    .vjs_layout {
      text-align: left;
      border: 2px solid rgb(221, 221, 221);
      padding: 1em;
      margin: 1em;
    }
  {/literal}
</style>
{/html_head}

Synchronization of metadata information and thumbnail creation for videos.
<br/><br/>
Please read the <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blanck">plugin documentation</a> for additional information.

<div class="vjs_layout">
  <legend>Statistics</legend>
  <ul>
    <li class="update_summary_new">{$NB_VIDEOS} videos in your gallery</li>
    <li class="update_summary_new">{$NB_VIDEOS_GEOTAGGED} geotagged videos</li>
    <li class="update_summary_new">{$NB_VIDEOS_THUMB} videos with poster and thumbnail</li>
  </ul>
</div>

{if isset($update_result)}
<div class="vjs_layout">
  <legend>Synchronization results</legend>
  <ul>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_CANDIDATES} {'video(s) in your gallery'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_EXIF} {'video(s) with metadata'|@translate}</li>
    <li class="update_summary_new">{$update_result.NB_ELEMENTS_THUMB} {'thumbnail(s) created'|@translate}</li>
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

  <fieldset id="syncMeta">
    <legend>{'Synchronize metadata'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="metadata" value="1" checked="checked" /> filesize, width, height, latitude, longitude</label>
	<br/><small>Will overwrite the information in the database with the metadata from the video</small>
	<br/><small><strong>Support of latitude, longitude required <a href="http://piwigo.org/ext/extension_view.php?eid=701" target="_blanck">'OpenStreetMap'</a> or 'RV Maps & Earth' plugin.</strong></small>
      </li>
    </ul>
  </fieldset>

  <fieldset id="syncthumb">
    <legend>{'Create thumbnail'|@translate}</legend>
    <ul>
      <li>
	<label><input type="checkbox" name="thumb" value="1" checked="checked" /> Create thumbnail at position in second:</label>
	<!-- <input type="range" name="thumbsec" value="1" min="0" max="60" step="1"/> -->
	<input type="text" name="thumbsec" value="1" size="2" required/>
	<br/><small>Will create a thumbnail from the video at position</small>
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