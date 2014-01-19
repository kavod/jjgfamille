
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
					<td align="center" valign="top" colspan="2"><br />
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
	<td class="row2"><center><span class="cattitle"><a href="{U_ADD}">{L_ADD}</a></span></center><br /> </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{L_SEARCH_ELEMENT}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <form method="post">
	<td class="row2"><br /><center><span class="genmed"><b>{L_SEARCH_BY_NAME}</b><input type="text" class="post" name="name" /><input type="submit" value="{L_SEARCH}" /></form>
	<form method="post"><center><span class="genmed"><b>{L_SEE_LISTE}</b>
				<select name="lettre">
					<option value="0">Tous</option>
					<!-- BEGIN lettres -->
					<option value="{lettres.LETTRE}">{lettres.LETTRE}</option>
					<!-- END lettres -->
				</select><input type="submit" value="{L_AFFICHER}" /><br />
	<br /></span></center></form></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- BEGIN switch_liste -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{switch_liste.L_RESULTAT}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2"><br /><center>
	<table border="0" align="center">
	<tr>
		<td><spam class="genmed"><b>{switch_liste.L_CHAMP1}</b></span></td>
		<td><spam class="genmed"><b>{switch_liste.L_CHAMP2}</b></span></td>
		<td><spam class="genmed"><b>{switch_liste.L_CHAMP3}</b></span></td>
		<td><spam class="genmed"><b>{switch_liste.L_CHAMP4}</b></span></td>
		<td></td>
	</tr>
	<!-- BEGIN liste -->
	<tr>
		<td><spam class="genmed"><b>{switch_liste.liste.CHAMP1}</b></span></td>
		<td><center><spam class="genmed">{switch_liste.liste.CHAMP2}</span></center></td>
		<td><center><spam class="genmed">{switch_liste.liste.CHAMP3}</span></center></td>
		<td><spam class="genmed">{switch_liste.liste.CHAMP4}</span></td>
		<td><spam class="genmed"><a href="{switch_liste.liste.U_EDIT}">{switch_liste.liste.L_EDIT}</a></span></td>
	</tr>
	<!-- END liste -->
	</table></center></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- END switch_liste -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}" class="cattitle">{L_RETOUR}</a></span></center></td>
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
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->