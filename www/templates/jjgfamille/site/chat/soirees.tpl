
<!-- Début du document -->

				<tr>
					<td>&nbsp;</td>
					<td  align="center">
					<span class="forumlink">
		                {LIEN_WEBCHAT} | {LIEN_HELP} | {LIEN_SOIREES}</span>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					
					<td align="center" valign="top" colspan="3">{ERROR_BOX}<br />
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="genmed"><b>{RESPONSABLES}</b>
	<!-- BEGIN switch_access -->
	<a href="{switch_access.U_RESP}">{switch_access.RESP},</a>
	<!-- END switch_access -->
	</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td  height="28" class="row2"><span class="cattitle"><br><u>{L_PROCHAINEMENT}</u></span><br><span class="genmed">{NO_THEME}</span><br></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
<!-- BEGIN switch_theme -->
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="cattitle"><b>{switch_theme.THEME}</b></span>&nbsp;<span class="genmed">{switch_theme.DATE}</span>&nbsp;<span class="gensmall"><a href="{switch_theme.U_LOG}">{switch_theme.L_LOG}</a></span>&nbsp;&nbsp;<span class="genmed"><a href="{switch_theme.U_MODIF}">{switch_theme.MODIF}</a></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
	<span class="genmed"><br />{switch_theme.TEXTE}<br /><br /></span>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- END switch_theme -->
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2"><br><span class="cattitle"><a href="{U_ARCHIVES}">{L_ARCHIVES}</a><br />&nbsp;</span></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2"><br><br><span class="genmed">{MAIL}</a></span></td>
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
<br />
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.NOM_RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br><span class="cattittle"><b><u>{switch_admin.AJOUT}</u></b></span><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br><br>
	<form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 
		<table border="0" width="99%" >
			<tr valign="top">	
				<td width="20%"><span class="genmed"><b>{switch_admin.NOM}</b></span><br></td>
				<td><input type="text" name="name" size="30" class="post"><br></td>
			</tr>	
  			<tr valign="top"> 
				<td><span class="genmed"><b>{switch_admin.DESC}</b></span><br></td>
				<td><textarea name="description" cols="30" rows="7" class="post"></textarea><br></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{switch_admin.DAY}</b><br><small>format obligatoire(jj/mm/aaaa)</small></span><br></td>
				<td><input type="text" name="date" size="30" class="post" maxlength=10 ><br></td>	
  			</tr>
   			<tr valign="top"> 
				<td><span class="genmed"><b>{switch_admin.HOUR}</b><br><small>format obligatoire(hh:mm)</small></span><br></td>
				<td><input type="text" name="heure" size="30" class="post" maxlength=5 ><br></td>	
  			</tr>
  			<tr valign="top"> 
  				<td>&nbsp;</td><td><input type="submit" value="{switch_admin.L_SUBMIT}"><br></td>
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
<!-- END switch_admin -->

					</td>
				</tr>
								
<!-- FIN du document -->



