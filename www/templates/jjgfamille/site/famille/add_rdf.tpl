
<!-- Début du document -->
				<tr>
					<td colspan="3" align="center">
					<span class="forumlink">
		{LIEN_ACCUEIL} | {LIEN_ACTUALITE} | {LIEN_JJG} | {LIEN_DISCO} | {LIEN_MEDIAS} | {LIEN_TOURNEES} | {LIEN_LINKS} | {LIEN_FAMILLE} | {LIEN_PLUSPLUS}</span>
					</td>
				</tr>
				<tr>
					<td width="205" valign="top"><br /><br />
						{COLONNE_GAUCHE}
					</td>
					<td align="center" valign="top" colspan="2">{ERROR_BOX}<br />
<table style="text-align: left; width: 100%;" border="0" cellspacing="0" cellpadding="0">
  <tbody>
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
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="genmed"><b>{RESPONSABLES}</b>
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
	<td class="row2"><br/><span class="cattitle"><u>{TITLE}</u></span><br/>
	<form method="post" action="{U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="80%">
			<tr valign="top">	
				<td width="30%"><span class="genmed"><b>{LIEU}:</b></span></td>
				<td><input type="text" name="lieu" size="50" class="post"></td>
			</tr>	
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DATE}:</b></span><br/><span class="gensmall">(jj/mm/aaaa)</span></td>
				<td><input type="text" name="date" size="50" class="post"><br></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{HEURE}:</b></span><br/><span class="gensmall">(hh:mm)</span></td>
				<td><input type="text" name="heure" size="50" class="post"></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DESCRIPTION}:</b></span></td>
				<td><textarea name="description" cols="50" rows="10" class="post"></textarea></td>
  			</tr>
  			<tr> 
				<td>&nbsp;</td><td><br/><input type="submit" value="{L_SUBMIT}"></td>
			</tr>
			</table>
			</form>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr>
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td  height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td class="ligneBas"></td>
    </tr>
  </tbody>
</table>
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->