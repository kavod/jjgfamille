{ERROR_BOX}
<table style="text-align: left; width: 100%;" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td  height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2" align="center"><br/><span class="genmed">{L_WARNING_ABOUT_CONTACT}</span>
<form method="post" action="{ACTION}">
<table border="0" align="center" >
	{LIGNE_NOM}
	{LIGNE_MAIL}
	<tr>
	    <td><span class="genmed"><b>{SUJET}</b></span></td>
	    <td><input type="text" name="sujet" value="{VAL_SUJET}" size="30"/></td>
	</tr>
	<tr>
	    <td><span class="genmed"><b>{DESTINATAIRE}</b></span></td>
	    <td>
	    <select name="contact_id">
	    <option value="0" >{SELECT}</value>
	    <!-- BEGIN switch_contact -->
	    <option value="{switch_contact.VALUE}" {switch_contact.SELECTED} >{switch_contact.INTITULE}</value>
	    <!-- END switch_contact -->
	    </select>
	    </td>
	</tr>
	<tr>
	    <td><span class="genmed"><b>{MESSAGE}</b></span></td>
	    <td><textarea type="text" name="message" rows="7" cols="30">{VAL_MESSAGE}</textarea></td>
	</tr>
	<tr>
	    <td colspan="2"><br/><center><input class="mainoption" type="submit"  value="{SUBMIT}"/></center></td>
	</tr>
</table>
</form>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td class="ligneBas"></td>
    </tr>
  </tbody>
</table>
<br/>
<!-- BEGIN switch_admin -->
<table style="text-align: left; width: 100%;" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td  height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2"><br/>
<form method="post" action="">
<table border="0" align="center" >
	<tr>
		<td  align="center"><span class="genmed"><b>{switch_admin.L_EMAIL}</b></span><br/></td>
        	<td  align="center"><span class="genmed"><b>{switch_admin.L_INTITULE}</b></span><br/></td>
        	<td  align="center">&nbsp;</td>
	</tr>
	<!-- BEGIN switch_contact -->
	<tr>
		<td  align="center"><span class="genmed">{switch_admin.switch_contact.EMAIL}</span></td>
        	<td  align="center"><span class="genmed">{switch_admin.switch_contact.INTITULE}<span></td>
		<td  align="center"><span class="genmed"><a href="javascript:if (confirm('{switch_admin.switch_contact.L_CONFIRM_DEL}')) document.location='{switch_admin.switch_contact.U_DEL}'">{switch_admin.switch_contact.L_DEL}</a></span></td>
	</tr>
	<!-- END switch_contact -->			
	<tr>
		<td><br/><input type="text" name="email" value="{switch_admin.VAL_EMAIL}"/></td>
		<td><br/><input type="text" name="intitule" value="{switch_admin.VAL_INTITULE}"/><input type="hidden" name="mode" value="add" /></td>
		<td><br/><input type="submit" value="{switch_admin.L_ADD}" /></td>
	</tr>
</table></form>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td class="ligneBas"></td>
    </tr>
  </tbody>
</table>
<!-- END switch_admin -->




