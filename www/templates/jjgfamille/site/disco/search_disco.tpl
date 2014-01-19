<script language="javascript" type="text/javascript">
<!--
function refresh_disco(selected_disco)
{
	opener.document.forms['{FORMULAIRE}'].{CHAMPS}.value = selected_disco.text;
	{J_ASSIGN_ID}
	opener.focus();
	window.close();
}
//-->
</script>
<form method="post" name="search" action="{S_SEARCH_ACTION}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td height="7" class="row2"></td>
    </tr>
	<tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td><table width="100%" class="forumline" cellpadding="0" cellspacing="0" border="0">
			<tr>
  		<td class="degradeGauche"></td>
				<th class="thHead" height="25">{L_SEARCH_DISCO}</th>
		<td class="degradeDroite"></td>
			</tr>
			<tr>
 		<td width="7" class="row2"></td>
				<td valign="top" class="row2"><span class="genmed"><br /><input type="text" name="search_disco" value="{VALUE}" class="post" />&nbsp; <input type="submit" name="search" value="{L_SEARCH}" class="liteoption" /></span><br /><span class="gensmall">{L_SEARCH_EXPLAIN}</span><br />
				<!-- BEGIN switch_select_name -->
				<span class="genmed">{L_UPDATE_DISCO}<br /><select name="disco_list">{S_DISCO_OPTIONS}</select>&nbsp; <input type="submit" class="liteoption" onClick="refresh_disco(this.form.disco_list.options[this.form.disco_list.selectedIndex]);return false;" name="use" value="{L_SELECT}" /><br />
				<!-- BEGIN add -->
				{switch_select_name.add.L_EXPLAIN} <input type="hidden" name="add" value="" /> <input type="text" name="new_name" class="post" /> <input type="submit" class="liteoption" value="{switch_select_name.add.L_ADD}" onClick="this.form.add.value='ok'" />
				<!-- END add -->
				</span><br />
				<!-- END switch_select_name -->
				<br /><span class="genmed"><a href="javascript:window.close();" class="genmed">{L_CLOSE_WINDOW}</a></span></td>
		<td width="7" class="row2"></td>
			</tr>
		</table></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td height="5" class="ligneBas"></td>
    </tr>
</table>
</form>
