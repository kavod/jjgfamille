
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
      <td class="row2"><br><br><center><b><u>{L_TITLE}</u></b></center><br /><br />
	<!-- BEGIN concours -->
		<table bgcolor="#FFEFC3" border="1" width="50%" align="center">
		<tr valign="top">
			<td><span class="genmed"><a href="{concours.U_CONCOURS}"><b>{concours.L_CONCOURS}</b></a>&nbsp;{concours.EDIT}<br />
				<big>{concours.L_STATE}</big> ({concours.L_PERIOD})<br />
				<!-- BEGIN switch_close -->
				<br /><b>{L_WINNERS}</b><br />
				<ul>
				<!-- BEGIN winner -->
				<li><a href="{concours.switch_close.winner.U_PROFIL}">{concours.switch_close.winner.USERNAME}</a></li>
				<!-- END winner -->
				</ul>
				<!-- END switch_close -->
				<br />{concours.DESC}</span></td>
			<td width="150" valign="middle" align="center"><a href="{concours.U_CONCOURS}"><img src="{concours.IMG_CONCOURS}" alt="{concours.L_CONCOURS}" title="{concours.L_CONCOURS}" border="0" /></a></td></tr>
		</table><br /><br />
	<!-- END concours -->
	<!-- BEGIN admin -->
      	<span class="cattitle"><a href="{admin.U_AJOUT}">{admin.L_AJOUT}</a></span>
      	<!-- END admin -->
      	<br />	
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
<br>

					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->