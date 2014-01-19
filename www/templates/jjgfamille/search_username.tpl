
<script language="javascript" type="text/javascript">
<!--
function refresh_username(selected_username)
{
	opener.document.forms['post'].username.value = selected_username;
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
				<th class="thHead" height="25">{L_SEARCH_USERNAME}</th>
		<td class="degradeDroite"></td>
			</tr>
			<tr> 
		<td width="7" class="row2"></td>
				<td valign="top" class="row2"><span class="genmed"><br /><input type="text" name="search_username" value="{USERNAME}" class="post" />&nbsp; <input type="submit" name="search" value="{L_SEARCH}" class="liteoption" /></span><br /><span class="gensmall">{L_SEARCH_EXPLAIN}</span><br />
				<!-- BEGIN switch_select_name -->
				<span class="genmed">{L_UPDATE_USERNAME}<br /><select name="username_list">{S_USERNAME_OPTIONS}</select>&nbsp; <input type="submit" class="liteoption" onClick="refresh_username(this.form.username_list.options[this.form.username_list.selectedIndex].value);return false;" name="use" value="{L_SELECT}" /></span><br />
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
