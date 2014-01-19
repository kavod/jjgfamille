
<br clear="all" />

<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="7" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="7" height="7" class="row2"></td>
    </tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th class="thCornerL" width="120" height="25">{L_PM}</th>
	  <th class="thTop">{L_USERNAME}</th>
	  <th class="thTop" width="120">{L_POSTS}</th>
	  <th class="thTop">{L_FROM}</th>
	  <th class="thTop" width="120">{L_EMAIL}</th>
	  <th class="thTop" width="120">{L_WEBSITE}</th>
	  <th class="thCornerR" width="100">{L_SELECT}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catHead" colspan="7" height="28"><span class="cattitle">{L_PENDING_MEMBERS}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN pending_members_row -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="{pending_members_row.ROW_CLASS}" align="center"> {pending_members_row.PM_IMG} 
	  </td>
	  <td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen"><a href="{pending_members_row.U_VIEWPROFILE}" class="gen">{pending_members_row.USERNAME}</a></span></td>
	  <td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.POSTS}</span></td>
	  <td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.FROM}</span></td>
	  <td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.EMAIL_IMG}</span></td>
	  <td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gen">{pending_members_row.WWW_IMG}</span></td>
	  <td class="{pending_members_row.ROW_CLASS}" align="center"><span class="gensmall"> <input type="checkbox" name="pending_members[]" value="{pending_members_row.USER_ID}" checked="checked" /></span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END pending_members_row -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catBottom" colspan="7" align="right"><span class="cattitle"> 
		<input type="submit" name="approve" value="{L_APPROVE_SELECTED}" class="mainoption" />
		&nbsp; 
		<input type="submit" name="deny" value="{L_DENY_SELECTED}" class="liteoption" />
		</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="7" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="7" width="5" class="ligneBas"></td>
    </tr>
</table>
