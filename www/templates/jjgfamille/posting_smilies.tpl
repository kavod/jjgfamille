
<script language="javascript" type="text/javascript">
<!--
function emoticon(text) {
	text = ' ' + text + ' ';
	if (opener.document.forms['post'].message.createTextRange && opener.document.forms['post'].message.caretPos) {
		var caretPos = opener.document.forms['post'].message.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		opener.document.forms['post'].message.focus();
	} else {
	opener.document.forms['post'].message.value  += text;
	opener.document.forms['post'].message.focus();
	}
}
//-->
</script>

<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0">
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
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="forumline">
			<tr>
      <td width="7" class="degradeGauche"></td>
				<th class="thHead" height="25">{L_EMOTICONS}</th>
      <td width="7" class="degradeDroite"></td>
			</tr>
			<tr>
      <td width="7" class="row2"></td>
				<td class="row2"><table width="100%" align="center" border="0" cellspacing="0" cellpadding="5">
					<!-- BEGIN smilies_row -->
					<tr align="center" valign="middle"> 
						<!-- BEGIN smilies_col -->
						<td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
						<!-- END smilies_col -->
					</tr>
					<!-- END smilies_row -->
					<!-- BEGIN switch_smilies_extra -->
					<tr align="center"> 
						<td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="open_window('{U_MORE_SMILIES}', 250, 300);return false" target="_smilies" class="nav">{L_MORE_SMILIES}</a></td>
					</tr>
					<!-- END switch_smilies_extra -->
				</table></td>
      <td width="7" class="row2"></td>
			</tr>
			<tr>
	<td width="7" class="row2">
				<td class="row2" align="center"><br /><span class="genmed"><a href="javascript:window.close();" class="genmed">{L_CLOSE_WINDOW}</a></span></td>
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
