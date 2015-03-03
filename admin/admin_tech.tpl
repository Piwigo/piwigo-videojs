{html_head}
<style>
  {literal}
FORM.properties SPAN.property {
  width:100px;
}
  {/literal}
</style>
{/html_head}

Play YouTube video inside the open source HTML5 video player <a href="http://www.videojs.com/" target="_blank">VideoJS</a>.
<br/><br/>
Please read the <a href="https://github.com/xbgmsharp/piwigo-videojs/wiki" target="_blank">plugin documentation</a> for additional information.

<form method="post" action="" class="properties">

	<fieldset id="addTech">
		<legend>{'YouTube'|@translate}</legend>
		<ul>
		  <li>
		    <label>
		      <span class="property">{'Album'|@translate}</span>
		      <select style="width:400px" name="category" id="albumSelect" size="1">
			{html_options options=$category_parent_options selected=$POST.category}
		      </select>
		    </label>
		    {'... or '|@translate}<a href="#" class="addAlbumOpen" title="{'create a new album'|@translate}">{'create a new album'|@translate}</a>
		  </li>
		  <li>
		    <label>
		      <span class="property">{'Video URL'|@translate}</span>
		      <input type="text" name="url" value="{$POST.url}" style="width:400px;" placeholder="http://www.youtube.com/watch?v=7IYJORmvNjY">
		    </label>
		  </li>
	</fieldset>

	<p>
		<input class="submit" type="submit" value="{'Save Settings'|@translate}" name="submit"/>
	</p>
</form>
