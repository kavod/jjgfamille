
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
<!-- BEGIN switch_prochainement -->
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <br><span class="genmed"><b><u>{L_PROCHAINEMENT}</u></b></span><br /><br />
      	<table width="90%" border="0" align="center">
      	<tr>
      	    <td>	 
<!-- BEGIN emission -->
		<center>{switch_prochainement.emission.ICON_SUPPORT}<b><u><a href="{switch_prochainement.emission.U_TITLE}">{switch_prochainement.emission.L_TITLE}</a></u></b><span class="genmed">&nbsp;&nbsp;<a href="{switch_prochainement.emission.U_SUPPORT}">{switch_prochainement.emission.L_SUPPORT}</a></span>{switch_prochainement.emission.ILLU}&nbsp;{switch_prochainement.emission.RETRANSCRIPTION}&nbsp;{switch_prochainement.emission.AUDIO}</center>
		<center><span class="genmed">{switch_prochainement.emission.DATE}&nbsp;{switch_prochainement.emission.HEURE}</span></center>
		<span class="genmed">
		<b>{L_DESCRIPTION}</b>
		<br>{switch_prochainement.emission.DESCRIPTION}
		</span><br /><br />
<!-- END emission -->
	    </td>
	</tr>
	</table>
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
    <tr>
    	<td colspan="5" height="10"></td>
    </td>
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td  height="7" class="row2"></td>
    </tr>
<!-- END switch_prochainement -->
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <br><span class="genmed"><b><u>{L_DERNIEREMENT}</u></b></span><br><br>
      	<table width="90%" border="0" align="center">
      	<tr>
      	    <td>	 
<!-- BEGIN en_vedette -->
		<center>{en_vedette.ICON_SUPPORT}<b><u><a href="{en_vedette.U_TITLE}">{en_vedette.L_TITLE}</a></u></b><span class="genmed">&nbsp;&nbsp;<a href="{en_vedette.U_SUPPORT}">{en_vedette.L_SUPPORT}</a></span>{en_vedette.ILLU}&nbsp;{en_vedette.RETRANSCRIPTION}&nbsp;{en_vedette.AUDIO}</center>
		<center><span class="genmed">{en_vedette.DATE}&nbsp;{en_vedette.HEURE}</span></center>
		<span class="genmed">
		<b>{L_DESCRIPTION}</b>
		<br>{en_vedette.DESCRIPTION}
		</span><br><br><br>
<!-- END en_vedette -->
	    </td>
	</tr>
	</table><br />
<!-- BEGIN en_liste -->
	<span class="genmed">{en_liste.ICON_SUPPORT}<u><a href="{en_liste.U_TITLE}"><b>{en_liste.DATE}{en_liste.HEURE} :</b> {en_liste.L_TITLE}</a></u>{en_liste.ILLU}&nbsp;{en_liste.RETRANSCRIPTION}&nbsp;{en_liste.AUDIO}</span><br />
<!-- END en_liste -->
<br />
<form method="post" action="{U_ARCHIVES}">
     <span class="genmed"><b>...{L_GO_TO_ARCHIVES}</b> 
     		<select name="annee" onChange="this.form.submit()">
			<!-- BEGIN archives -->
			<option value="{archives.VALUE}">{archives.ANNEE}</option>
			<!-- END archives -->
     		</select><input type="submit" value="{L_GO}"></form><br /><br /><br />
     <b>{L_YOU_TO_PLAY}</b><br><a href="{U_ANNOUNCE_YOURSELF}">{ANNOUNCE_YOURSELF}</a>
     </span><br><br>
     
	</td>
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