
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
					<td align="center" valign="top">{ERROR_BOX}<br />
<!-- BEGIN switch_edit_mascotte -->
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{EDIT_MASCOTTE}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="cattitle"><b>{CHANGE_MASCOTTE}</b></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2" style="vertical-align: top;">
      		<form method="post" action="{U_UPLOAD}" enctype="multipart/form-data">
		<span class="genmed">
		{L_UPLOAD_MASCOTTE_EXPLAIN}<br />
      		<input type="file" name="mascotte_file" class="post" size="30" /><br />
		<input type="submit" value="{L_SUBMIT}">
		</span>
		</form>
		<br><span class="genmed"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></span>
      		</td>
      <td width="7"  class="row2"></td>
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
</table><br />
<!-- END switch_edit_mascotte -->
<!-- BEGIN switch_edit_annonce -->
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{EDIT_ANNONCE}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="cattitle"><b>{CHANGE_ANNONCE}</b></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2" style="vertical-align: top;">
      		<form method="post" action="{U_ACTION}">
		<span class="genmed">
		{L_ANNONCE_EXPLAIN}<br />
      		<textarea name="annonce" cols="50" rows="10" class="post">{L_ANNONCE_ACTUAL}</textarea><br />
		<input type="submit" value="{L_SUBMIT}">
		</span>
		</form>
		<br><span class="genmed"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></span>
      		</td>
      <td width="7"  class="row2"></td>
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
</table><br />
<!-- END switch_edit_annonce -->
					</td>
					<td width="205" valign="top"><br /><br />
					{COLONNE_DROITE}

  				</td>
				</tr>
				
				
				
				
<!-- FIN du document -->