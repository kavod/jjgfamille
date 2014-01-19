
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
<table style="text-align: left;" width="100%" border="0" cellspacing="0" cellpadding="0" class="forumline">
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{LIENS}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="genmed"><b>{RESPONSABLES}</b>
	<!-- BEGIN access -->
	<a href="{access.U_RESP}">{access.RESP},</a>
	<!-- END access -->
	</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2">
	<br /><b><u>{NOM_CATEGORIE}</u></b><br/><br/>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2" align="center">
			<span class="genmed">{AUCUN}</span>
			<table border="0" width="60%" align="center">
      			<!-- BEGIN site -->
      				<tr>
      					<td align="center"><a href="{site.SITE_URL}" target="_blank">{site.SITE_LOGO}</a></td>
      				</tr>
      				<tr>
      					<td>
      					<a href="{site.SITE_URL}" target="_blank"><span class="cattitle">{site.SITE_NAME}</span></a>&nbsp;&nbsp;<a href="{site.U_ADMIN}"><small>{site.L_ADMIN}</small></a>
					<br />
					<span class="genmed"><br />
					<b>{site.WEBMASTER}&nbsp;:</b>&nbsp;<a href="{site.U_WEBMASTER}">{site.L_WEBMASTER}</a><br/>
					<b>{site.DESC}</b>&nbsp;{site.SITE_DESCRIPTION}<br/>
					<b>{site.PLUS}:</b>&nbsp;{site.SITE_PLUS}<br />
					<b>{site.MOINS}:</b>&nbsp;{site.SITE_MOINS}<br /><br /><br /><br /></span>
      					</td>
      					
      				</tr>
      			<!-- END site -->
      			</table>
        </td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/><br/><span class="genmed">
	{WEBMASTER}
	</span><br/>
	<br/>
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
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td width="35%" class="row2">
	<span class="genmed">
	<br><u>{admin.LISTE_SITE} :</u><br><br>
	<!-- BEGIN site -->
	<b>{admin.site.SITE_NAME}</b>&nbsp;{admin.site.SITE_URL}<br>
	<!-- END site -->
	</span>
	</td>
      <td class="row2"><br><br>
      <span class="genmed">
	<!-- BEGIN site -->
      <a href="{admin.site.U_EDIT}">{admin.site.L_EDIT}</a>&nbsp;<a href="{admin.site.U_DEASSOCIER}">{admin.site.L_DEASSOCIER}</a><br>
      <!-- END site -->
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
</table><br/>
<!-- END admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->