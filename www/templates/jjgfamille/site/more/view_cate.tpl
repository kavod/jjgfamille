
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
      <td class="row2"><br><br><center><b><u>{L_CATE}</u></b></center><br><br>
            		<!-- BEGIN switch_more -->
      				<table bgcolor="#FFEFC3" border="1" width="50%" align="center">
				<tr valign="top"><td><span class="genmed"><a href="{switch_more.U_TITLE}"><b>{switch_more.L_TITLE}</b></a>&nbsp;{switch_more.EDIT}<br><br>{switch_more.DESC}<br><br><br><i>{switch_more.USER}</i><br><br><center><a href="{switch_more.U_DL}"><b>{switch_more.L_DL}</b></a></center></span></td>
				<td width="150" valign="middle" align="center"><a href="{switch_more.U_TITLE}"><img src="{switch_more.IMG}" {switch_more.ALT} {switch_more.ALT2} border="0" /></a></td></tr>
      				</table><br><br>
      			<!-- END switch_more -->


      	<span class="genmed">{AJOUT_MORE}</span>
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
<br>
<!-- BEGIN admin -->
<table style="text-align: left; width: 100%;" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>

       <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td></br>
      <td colspan="2" class="row2"></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><span class="genmed">
	<br><b><u>{admin.NOM_CATEGORIE}</u></b><br><br>
	</span>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2">
	<span class="genmed">
	<form method="post" action="{admin.U_MOD_CATE}"><u>{admin.MOD_CATE}:</u>&nbsp;
		<input type="hidden" name="cate_id" value="{admin.CATE_ID}" />
		<input type="text" name="cate_name" size="30" value="{admin.NOM_CATEGORIE}" class="post" />&nbsp;
		<input type="submit" value="{admin.L_SUBMIT}" />
	</form>
	</span>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="2" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="2" class="ligneBas"></td>
    </tr>
  </tbody>
</table>
<!-- END admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->