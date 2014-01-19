
<form method="post" action="{S_MODE_ACTION}">
  <table width="99%" align="center" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	  <td align="right" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
  </table>
  <table width="99%" align="center" cellpadding="0" cellspacing="0" border="0" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="8" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="8" height="7" class="row2"></td>
    </tr>
	<tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td> 
	  <th height="25" class="thCornerL" width="50"nowrap="nowrap">#</th>
	  <th class="thTop" nowrap="nowrap" width="80">&nbsp;</th>
	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>
	  <th class="thTop" nowrap="nowrap" width="80">{L_EMAIL}</th>
	  <th class="thTop" nowrap="nowrap">{L_FROM}</th>
	  <th class="thTop" nowrap="nowrap" width="100">{L_JOINED}</th>
	  <th class="thTop" nowrap="nowrap" width="80">{L_POSTS}</th>
	  <th class="thCornerR" nowrap="nowrap" width="80">{L_WEBSITE}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN memberrow -->
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="{memberrow.ROW_CLASS}" align="center"><span class="gen">&nbsp;{memberrow.ROW_NUMBER}&nbsp;</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center">&nbsp;{memberrow.PM_IMG}&nbsp;</td>
	  <td class="{memberrow.ROW_CLASS}" align="center"><span class="gen"><a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a></span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle">&nbsp;{memberrow.EMAIL_IMG}&nbsp;</td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.FROM}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow.JOINED}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.POSTS}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center">&nbsp;{memberrow.WWW_IMG}&nbsp;</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END memberrow -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catBottom" colspan="8" height="28">&nbsp;</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="8" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="8" width="5" class="ligneBas"></td>
    </tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"></td>
	</tr>
  </table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
	<td><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span></td>
  </tr>
</table></form>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
