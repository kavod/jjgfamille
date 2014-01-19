
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
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{L_PHOTOS}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="catleft" height="28"><span class="genmed"><b>{RESPONSABLES}</b>
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
      <td colspan="2" class="row2"><br />
      <span class="cattitle"><u>{CATE}</u>&nbsp;<a href="{U_CATE}">{L_CATE}</a><br /><br /><br />
	<center><u>{TITRE_PHOTO}</u></center>
	</span>
      </td>
      	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td width="60%" class="row2"><br />
      <img src="{PHOTO}" title="{PHOTOGRAPHE}" alt="{PHOTOGRAPHE}" border="0" /><br />
      <span class="genmed"><i>{SOURCE_PHOTO}</i><span><br /><br /><br />
      </td>
      <td class="row2" valign="top"><br /><br />
	 <span class="genmed">{COMMENTAIRE_PHOTO}</span><br/>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="catleft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}">{L_RETOUR}</a></span></center></td>
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
<br/>
<!-- BEGIN switch_admin -->
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
   <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2"><br /><span class="genmed"><a href="{switch_admin.U_ACCES_UPLOAD}">{switch_admin.L_ACCES_UPLOAD}</a>
      </span></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="genmed">{switch_admin.MODIF_PHOTO}&nbsp;<b>{switch_admin.TITRE_PHOTO}</b></span><br /></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td  class="row2">
	<form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 
		<table border="0" width="90%" align="center">
			<tr>	
				<td><span class="genmed">{switch_admin.NOM_PHOTO}</span><br /></td>
				<td><br /><input type="text" name="photo_name" size="30" value="{switch_admin.TITRE_PHOTO_FORM}" class="post" /><br /></td>
			</tr>	
  			<tr> 
				<td><span class="genmed">{switch_admin.COMMENTAIRE}</span><br /></td>
				<td><textarea name="commentaire" cols="30" rows="5" class="post">{switch_admin.L_COMMENTAIRE_PHOTO}</textarea><br /></td>
  			</tr>
  			<tr> 
				<td><span class="genmed">{switch_admin.PHOTOGRAPHE}</span><br /></td>
				<td><input type="text" name="photographe" size="30" value="{switch_admin.L_PHOTOGRAPHE_PHOTO}" class="post" /><br /></td>	
  			</tr>
   			<tr>  	
				<td><span class="genmed">{switch_admin.SOURCE}</span><br /></td>
				<td><input type="text" name="source" size="30" value="{switch_admin.L_SOURCE_PHOTO}" class="post" /><br /><input type="checkbox" name="search" {switch_admin.CHECK} class="post"><span class="genmed" />Cette personne est membre de Famille ? </span></td>	
  			</tr>
  			<tr>  	
				<td><span class="genmed">{switch_admin.CATE}:</span><br /></td>
				<td><select name="cate_id">
					<!-- BEGIN mes_options -->
      					<option value="{switch_admin.mes_options.VALUE}"{switch_admin.mes_options.SELECTED}>{switch_admin.mes_options.INTITULE}</option>
					<!-- END mes_options -->
					</select>
				</td>	
  			</tr>
  			<tr> 
			<td colspan="2">
			<input type="hidden" name="user" value="{switch_admin.USER}" />
			<input type="hidden" name="cate_idp" value="{switch_admin.CATE_IDP}" />
			<input type="submit" value="{switch_admin.L_SUBMIT}" /><br /></td>
			</tr>
		</table>
	</form>
	</td>	
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
     </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br /><span class="genmed"><a href="javascript:if (confirm('{switch_admin.L_CONFIRM_SUPP}')) document.location='{switch_admin.U_SUPP_PHOTO}'">{switch_admin.SUPP_PHOTO} {switch_admin.TITRE_PHOTO}</a></span><br /><br /><br />
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
<!-- END switch_admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->