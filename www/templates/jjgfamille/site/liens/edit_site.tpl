
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
					<td align="center" valign="top" colspan="2">{ERROR_BOX}</br>
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
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{LIENS}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td  colspan="3" class="row2">
      <b><center>{SITE_NAME}</center></b><br><br>
      <span class="genmed">
      <b>{PROPOSER}:</b>&nbsp;<a href="{U_USER}">{USER}</a><br>
      <b>{SCORE_ACTU}:</b>&nbsp;{SCORE}<br>
      <!--
      <b>{url}:</b>&nbsp;{SITE_URL}<br>
      <b>{CODE_HTML}:</b>&nbsp;<input type="text" value="{SITE_CODE_HTML}" size="100" class="post" onChange="this.value='{SITE_CODE_HTML}'" /><br>
      -->
      <b>{ACTIVITE}:</b>&nbsp;{ACTIF_INACTIF}<br>
<!-- BEGIN admin_only -->
      <input type="button" value="{admin_only.INACTIF_ACTIF}" onClick="document.location='{admin_only.RENDRE}'"><br>
<!-- END admin_only -->
<br>
      <br><u>{MODIF_SITE}</u></span></td>
      <td class="colonneDroite"></td>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td width="300" class="row2">
      <form method="post" action="{U_FORM}" enctype="multipart/form-data">
      <br><span class="genmed"><b>{NOM_SITE}</b></span></td>
      <td colspan="2" class="row2"><br><input type="text" name="site_name" value="{SITE_NAME}" size="30" maxlength="100" class="post"></td>
      <td class="colonneDroite"></td>
    </tr>
          <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td  class="row2"><span class="genmed"><b>{URL}</b></span></td>
	<td class="row2"><input type="text" name="url" value="{site_URL}" size="30" maxlength="255" class="post"></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="genmed"><b>{DESCRIPTION}</b></span></td>
	<td class="row2"><textarea name="description"  cols="30" rows="5" maxlength="100" class="post">{DESC}</textarea>
	
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
<!-- BEGIN admin_only -->
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="genmed"><b>{admin_only.PLUS}:</b></span></td>
	<td class="row2"><textarea name="plus"  cols="30" rows="5" maxlength="100" class="post">{admin_only.PLUSS}</textarea>
	
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="genmed"><b>{admin_only.MOINS}:</b></span></td>
	<td class="row2"><textarea name="moins"  cols="30" rows="5" maxlength="100" class="post">{admin_only.MOINSS}</textarea>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
<!-- END admin_only -->
          <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><br><input type="submit" value="{L_SUBMIT}"></form>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2">
	<span class="genmed">
	<br /><u>{BANNIERE}:</u><br /><br />
	{SITE_LOGO}
	<br /><a href="javascript:if (confirm('{L_CONFIRM_SUPP_IMAGE}')) document.location='{U_SUPP_IMAGE}'">{L_SUPP_IMAGE}</a></span><br />
	      	<form method="post" action="{U_UPLOAD_BANNIERE}" enctype="multipart/form-data">
      		<input type="file" name="banniere_file" size="30" class="post" /><br />
		<input type="submit" value="{L_SUBMIT}" />
		</form><br />
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
<!-- BEGIN admin_only -->
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><span class="genmed"><br><br><u>{admin_only.CATE_ASSO}:</u>
	</span>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>

    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td width="300" class="row2">
	<span class="genmed">
      <!-- BEGIN cate -->
	<b>{admin_only.cate.L_CATE}</b><br>
	<!-- END cate -->
	</span>
	</td>
	<td  class="row2">
	<span class="genmed">
	<!-- BEGIN cate -->
	<a href="{admin_only.cate.U_EDIT}">{admin_only.cate.L_EDIT}<a>&nbsp;<a href="{admin_only.cate.U_DEASSOCIER}">{admin_only.cate.L_DEASSOCIER}<a><br>
	<!-- END cate -->
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
	<br><br><u>{NEW_CATE}:</u><br><br>
	<form method="post" action="{U_ASSO}"  enctype="multipart/form-data">
<select name="cate_id">
	<option value="0">--</option>
	<!-- BEGIN mes_options -->
      <option value="{admin_only.mes_options.VALUE}">{admin_only.mes_options.INTITULE}</option>
	<!-- END mes_options -->
</select>
<input type="submit" value="{L_ASSO}">
</form><br><br>
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
	<u>{SUPP}:</u>&nbsp;<a href="javascript:if (confirm('{L_CONFIRM_SUPP_SITE}')) document.location='{U_SUPP}'">{L_SUPP}</a>&nbsp;<b>{CHOIX}</b><br><br>
	</span>
	<br><span class="genmed"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></span>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
<!-- END admin_only -->
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="2" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="2" class="ligneBas"></td>
    </tr>
  </tbody>
</table><br />
<br>
				</td>
				</tr>
				
				
				
				
<!-- FIN du document -->