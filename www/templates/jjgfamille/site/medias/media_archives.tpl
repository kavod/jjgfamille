
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
      <td  height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB_MEDIAS}</th>
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
      <td class="row2">
      	<table border="0" width="99%" align="center">
      		<tr align="center">
      			<td colspan="4">
      				<br>
				<form method="post" action="{U_ARCHIVES}">
     				<span class="genmed">
     				<select name="annee" onChange="this.form.submit()">
					<!-- BEGIN archives -->
						<option value="{archives.VALUE}"{archives.SELECTED}>{archives.ANNEE}</option>
					<!-- END archives -->
     				</select></form><br/>
      			</td>
      		</tr>
      		<tr>
      		<td colspan="4"><span class="genmed"><b>{NO}</b></span></td>
      		</tr>
      		<tr>
			<td width="2%"><span class="genmed">&nbsp;</span></td>
			<td width="15%"><span class="genmed"><b>{L_DATE}</b></span></td>
			<td width="55%"><span class="genmed"><b>{L_TITRE}</b></span></td>
			<td><span class="genmed"><b>{L_SUPPORT}</b></span></td>
		</tr>
      	<!-- BEGIN switch_media -->
		<tr>
			<td><span class="genmed">{switch_media.ICON_SUPPORT}</span></td>
			<td><span class="genmed"><b>{switch_media.DATE}</b></span></td>
			<td><span class="genmed"><a href="{switch_media.U_TITLE}">{switch_media.L_TITLE}</a>&nbsp;{switch_media.ILLU}&nbsp;{switch_media.RETRANSCRIPTION}&nbsp;{switch_media.AUDIO}</span></td>
			<td><span class="genmed"><a href="{switch_media.U_SUPPORT}">{switch_media.L_SUPPORT}</a></span></td>
		</tr>
	<!-- END switch_media -->
	
      	</table> 
      	<br>
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