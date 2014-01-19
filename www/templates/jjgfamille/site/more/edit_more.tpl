
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
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{admin.MORE}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td  colspan="3" class="row2">
      <!-- BEGIN more -->
      <br><b><center>{admin.more.MORE_NAME}</center></b><br><br>
      <span class="genmed">
      <b>{admin.more.PROPOSER}:</b>&nbsp;<a href="{admin.more.U_USER}">{admin.more.USER}</a><br>
      <b>{admin.more.ACTIVITE}:</b>&nbsp;{admin.more.ACTIF_INACTIF}<br>
      <input type="button" value="{admin.more.INACTIF_ACTIF}" onClick="document.location='{admin.more.RENDRE}'"><br><br>
      <br><u>{admin.more.MODIF_MORE}</u></span></td>
      <td class="colonneDroite"></td>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td width="300" class="row2">
      <form method="post" action="{admin.more.U_FORM}" enctype="multipart/form-data">
      <br><span class="genmed"><b>{admin.more.NOM_MORE}&nbsp;:</b></span></td>
      <td colspan="2" class="row2"><br><input type="text" name="title" value="{admin.more.MORE_NAME}" size="30" maxlength="100" class="post"></td>
      <td class="colonneDroite"></td>
    </tr>
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="genmed"><b>{admin.more.DESCRIPTION}</b></span></td>
	<td class="row2"><textarea name="description"  cols="30" rows="10" maxlength="100" class="post">{admin.more.DESC}</textarea></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="genmed"><b>{admin.more.L_CATE}</b></span></td>
	<td class="row2"><select name="cate_id" class="post">
	<!-- BEGIN options -->
	<option value="{admin.more.options.VALUE}" {admin.more.options.SELECTED}>{admin.more.options.INTITULE}</option>
	<!-- END options -->
	</select></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><br><input type="submit" value="{admin.more.L_SUBMIT}"></form>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2">
	<span class="genmed">
	<br><u>{admin.more.BANNIERE}:</u></br></br>
	{admin.more.SITE_LOGO}
	<br><a href="javascript:if (confirm('{admin.more.L_CONFIRM_SUPP_IMAGE}')) document.location='{admin.more.U_SUPP_IMAGE}'">{admin.more.L_SUPP_IMAGE}</a></span><br>
	      	<form method="post" action="{admin.more.U_UPLOAD_BANNIERE}" enctype="multipart/form-data">
      		<input type="file" name="userfile" size="30" class="post"><br />
		<input type="submit" value="{admin.more.L_SUBMIT}">
		</form><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- END more -->
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2">
	<span class="genmed">
	<!-- BEGIN more -->
	<u>{admin.more.SUPP}:</u>&nbsp;<a href="javascript:if (confirm('{admin.more.L_CONFIRM_SUPP_SITE}')) document.location='{admin.more.U_SUPP}'">{admin.more.L_SUPP}</a>&nbsp;<b>{admin.more.CHOIX}</b><br><br>
	</span>
	<!-- END more -->
	<br><span class="genmed"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></span>
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
</table><br />
<!-- END admin --><br>
				</td>
				</tr>
				
				
				
				
<!-- FIN du document -->