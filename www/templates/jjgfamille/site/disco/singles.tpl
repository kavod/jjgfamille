
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
      <td class="row2"><br>
      <table border="0" width="99%" align="center">
      		<tr align="center">
      			<td >
      				<br>
      				<b>{TITLE}</b>
      				<br>
				<form method="post" action="{U_ANNEES}">
     				<span class="genmed">
     				<select name="annee" onChange="this.form.submit()">
     				<option value="">-</option>
					<!-- BEGIN annees -->
						<option value="{annees.VALUE}"{annees.SELECTED}>{annees.ANNEE}</option>
					<!-- END annees -->
     				</select></form><br/>
      			</td>
      		</tr>
      	</table>
      	<!-- BEGIN switch_singles -->
      	<table border="1" width="600" cellspacing="10" cellpadding="10" align="center">
      		<tr>
      		<td td valign="top" width="112">{switch_singles.PHOTO}<br><span class="genmed"><a href="{switch_singles.U_OTHER}">{switch_singles.L_OTHER}</a></span><br>{switch_singles.COUNT}</td>
      		<td td valign="top" width="100%">
      		<span class="genmed"><center><b><u>{switch_singles.TITLE}</u></b>&nbsp;{switch_singles.QUI}&nbsp;({switch_singles.QUAND})<br>{switch_singles.DISPO}<br><b>{switch_singles.ANOTER}</b>{switch_singles.L_ANOTER}</center>
      		<br><br>
      		<!-- BEGIN switch_titres -->
      		<b><a href="{switch_singles.switch_titres.U_TITLE}">{switch_singles.switch_titres.L_TITLE}</a></b>&nbsp;{switch_singles.switch_titres.DUREE}{switch_singles.switch_titres.ANOTER}&nbsp;{switch_singles.switch_titres.L_ANOTER}<br>
      		<!-- END switch_titres -->
      		</span>
      		</td>
      		</tr>
      	</table>
      	<!-- END switch_singles -->
      	<br>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
      <tr>
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}">{L_RETOUR}</a></span></center></td>
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