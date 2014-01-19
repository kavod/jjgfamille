 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>  
  <!-- BEGIN switch_groups_joined -->
  <tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	<th colspan="2" align="center" class="thHead" height="25">{L_GROUP_MEMBERSHIP_DETAILS}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
  </tr>
  <!-- BEGIN switch_groups_member -->
  <tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2" width="400"><span class="gen">{L_YOU_BELONG_GROUPS}</span></td>
	<td class="row2" align="right"> 
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><span class="gensmall">{GROUP_MEMBER_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
  </tr>
  <!-- END switch_groups_member -->
  <!-- BEGIN switch_groups_pending -->
  <tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2"><span class="gen">{L_PENDING_GROUPS}</span></td>
	<td class="row2" align="right"> 
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><span class="gensmall">{GROUP_PENDING_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
  </tr>
  <!-- END switch_groups_pending -->
  <!-- END switch_groups_joined -->
  <!-- BEGIN switch_groups_remaining -->
  <tr>  
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	<th colspan="2" align="center" class="thHead" height="25">{L_JOIN_A_GROUP}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
  </tr>
  <tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2"><span class="gen">{L_SELECT_A_GROUP}</span></td>
	<td class="row2" align="right"> 
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr><form method="get" action="{S_USERGROUP_ACTION}">
			<td width="40%"><span class="gensmall">{GROUP_LIST_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" value="{L_VIEW_INFORMATION}" class="liteoption" />{S_HIDDEN_FIELDS}
			</td>
		</form></tr>
	  </table>
	</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
  </tr>
  <!-- END switch_groups_remaining -->
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="2" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="2" class="ligneBas"></td>
    </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<br clear="all" />

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
