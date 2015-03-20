<h2>{$TITLE} &#8250; {'Edit photo'|@translate} {$TABSHEET_TITLE}</h2>

<fieldset>
  <legend>{'Rotate'|@translate} <a class="icon-help-circled" href="https://github.com/xbgmsharp/piwigo-videojs/wiki#photo-edit" target="_blank">{'Help'|@translate}</a> </legend>
  <table>
    <tr>
      <td id="albumThumbnail">
        <img src="{$TN_SRC}" alt="{'Thumbnail'|@translate}" class="Thumbnail">
      </td>
      <td style="vertical-align:top">

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

      </td>
    </tr>
  </table>
</fieldset>
