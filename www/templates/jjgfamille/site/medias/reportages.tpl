
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
	<br />
	<span class="cattitle">
		<u>{LISTE_REPORT}&nbsp;:</u>
	</span><br /><br />
	<span class="genmed">
	<table border="0">
		<!-- BEGIN annee -->
			<tr>
				<td colspan="2">
					<span class="gen"><b><u>{annee.ANNEE}</u></b></span>
				</td>
		<!-- BEGIN switch_report -->
			<tr>
				<td><img src="{annee.switch_report.U_IMG}" alt="{annee.switch_report.DESCRIPTION_IMG}" title="{annee.switch_report.DESCRIPTION_IMG}" /></td>
				<td><span class="gen"><a href="{annee.switch_report.U_TITRE}">{annee.switch_report.DATE}&nbsp;:&nbsp;{annee.switch_report.L_TITRE}</a>&nbsp;&nbsp;&nbsp;<a href="{annee.switch_report.U_EDIT}">{annee.switch_report.L_EDIT}</a></span>
				<br />
				<span class="gensmall"><i>{annee.switch_report.L_DESC}</i></span></td>
			</tr>
		<!-- END switch_report -->
		<!-- END annee -->
	</table>
	<b>{LISTE_NO_REPORT}</b><br />
	<!-- BEGIN switch_no_report -->
	<a href="{switch_no_report.U_TITRE}">{switch_no_report.DATE}&nbsp;:&nbsp;{switch_no_report.L_TITRE}</a>&nbsp;&nbsp;&nbsp;<a href="{switch_no_report.U_EDIT}">{switch_no_report.L_EDIT}</a>
	<br />
	<i>{switch_no_report.L_DESC}</i><br /><br />
	<!-- END switch_no_report -->
	</span>
	<br><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2">
      <form method="post" action="{U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="99%" align="center">
			<tr>	
				<td colspan="2"><span class="genmed"><b>{IS_YOU_TO_PLAY}</b><br>{AJOUT_REPORTAGE}</span><br></td>
			</tr>
			<tr>	
				<td width="30%"><span class="genmed">{TITRE_REPORTAGE} :</span></td>
				<td><input type="text" name="title" size="40" class="post"><br></td>
			</tr>
			<tr>	
				<td><span class="genmed">{DESC_REPORTAGE} :</span><br></td>
				<td><input type="text" name="comment" size="40" class="post"><br></td>
			</tr>
			<tr>	
				<td><span class="genmed">{JOB_REPORTAGE} :</span><br></td>
				<td><input type="text" name="job" size="40" class="post"><br></td>
			</tr>
			<tr> 
				<td colspan="2">
				<input type="submit" value="{L_SUBMIT}">
				</form>
				</td>
			</tr>
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