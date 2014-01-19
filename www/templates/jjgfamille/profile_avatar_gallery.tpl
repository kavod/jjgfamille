</table>
<form action="{S_PROFILE_ACTION}" method="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="{S_COLSPAN}" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="{S_COLSPAN}" height="7" class="row2"></td>
    </tr>
    	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th colspan="{S_COLSPAN}" class="thHead" colspan="{S_COLSPAN}" height="25" valign="middle">{L_AVATAR_GALLERY}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td colspan="{S_COLSPAN}" class="catBottom" align="center" valign="middle" height="28"><span class="genmed">{L_CATEGORY}:&nbsp;{S_CATEGORY_SELECT}&nbsp;<input type="submit" class="liteoption" value="{L_GO}" name="avatargallery" /></span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN avatar_row -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<!-- BEGIN avatar_column -->
		<td class="row1" align="center"><img src="{avatar_row.avatar_column.AVATAR_IMAGE}" alt="{avatar_row.avatar_column.AVATAR_NAME}" title="{avatar_row.avatar_column.AVATAR_NAME}" /></td>
	<!-- END avatar_column -->
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<!-- BEGIN avatar_option_column -->
		<td class="row2" align="center"><input type="radio" name="avatarselect" value="{avatar_row.avatar_option_column.S_OPTIONS_AVATAR}" /></td>
	<!-- END avatar_option_column -->
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>

	<!-- END avatar_row -->
	
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catBottom" width="98%" colspan="{S_COLSPAN}" align="center" height="28">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submitavatar" value="{L_SELECT_AVATAR}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="submit" name="cancelavatar" value="{L_RETURN_PROFILE}" class="liteoption" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="{S_COLSPAN}" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="{S_COLSPAN}" width="5" class="ligneBas"></td>
    </tr>
  </table>
</form>
