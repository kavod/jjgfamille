
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
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="cattitle"><b>{ACTION}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
	<span class="genmed">
	<form method="post" action="{U_ACTION}" name="formulaire">
	<table border="0">
		<tr>
			<td><span class="genmed"><b>{L_TITLE}</b></span></td>
			<td><input type="text" name="title" value="{TITLE_VALUE}" class="post" size="50" /></td>
		</tr>
		<tr>
			<td><span class="genmed"><b>{L_EXPIRATION}</b><br /><small>{L_HOT_EXPLAIN}</small></span></td>
			<td><input type="text" name="date_hot" value="{HOT_VALUE}" size="15" maxlength="10" class="post" />&nbsp;<a href="javascript:show_calendar('document.formulaire.date_hot','document.formulaire.date_hot.value');"><img src="../images/puce_petit_calendrier.gif" border="0" width="16" height="16" border="0"/></a></td>
		</tr>
		<tr>
			<td><span class="genmed"><b>{L_URL}</b></span></td>
			<td><input type="text" name="champs_url" value="{URL_VALUE}" size="50" maxlength="255" class="post" /></td>
		</tr>
		<tr>
			<td><span class="genmed"><b>{L_TEXTE}</b></span></td>
			<td><textarea name="maj" cols="50" rows="8" class="post">{TEXTE_VALUE}</textarea></td>
		</tr>
	</table>
	<input type="submit" value="{L_SUBMIT}" />
	</form><br />
	<center><a href="javascript:if (confirm('{L_CONFIRM_SUPP}')) document.location='{U_SUPP}'">{L_SUPP}</a></span>
	<br><br><span class="genmed"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></span>
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
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->