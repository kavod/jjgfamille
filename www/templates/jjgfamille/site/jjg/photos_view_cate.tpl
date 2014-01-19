
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
      <td  class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td  height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{L_PHOTOS}</th>
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
      <td class="row2" align="center">
      <br><div align="left"><span class="cattitle"><u>{CATE}&nbsp;{L_CATE}</u></span></div></br>
      <form method="post" action="{U_GO_TO_PAGE}">
      <select name="page" onChange="this.form.submit()">
      <!-- BEGIN go_to_page -->
      		<option value="{go_to_page.PAGE}"{go_to_page.SELECTED}>{go_to_page.L_PAGE}</option>
      <!-- END go_to_page -->
      </select>
      </form>
      <table border="0" width="99%" align="center">
      <!-- BEGIN photos_row -->
      <tr align="center" valign="bottom">
      <!-- BEGIN photos_column -->
      <td width="33%">
      <a href="{photos_row.photos_column.U_PHOTO}"><img src="{photos_row.photos_column.PHOTO}" alt="{photos_row.photos_column.L_PHOTO}" border="0" /></a><br />
      <span class="genmed"><a href="{photos_row.photos_column.U_PHOTO}">{photos_row.photos_column.L_PHOTO}</a></span><br>
      </td>
      <!-- END photos_column -->
      </tr>
      <!-- END photos_row -->
      </table>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
        <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2"></br></br>
      <span class="genmed">{AJOUT_PHOTOS}</span><br>
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
      <td  height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td  class="ligneBas"></td>
    </tr>
  </tbody>
</table>
<br>
<!-- BEGIN switch_admin -->
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
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td colspan="2" class="row2"><span class="genmed"><a href="{switch_admin.U_ACCES_UPLOAD}"><b>{switch_admin.L_ACCES_UPLOAD}</b></a>
      </span></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td width="40%" class="row2"></br>
      <span class="cattitle"><u>{switch_admin.CATE}&nbsp;{switch_admin.L_CATE}</u></span></br>
      <span class="genmed">
      Photos Disponibles : {switch_admin.PHOTOS_DISPO}</br><br>
      <!-- BEGIN photo -->
      <a href="{switch_admin.photo.U_PHOTO}">{switch_admin.photo.L_PHOTO}</a><br>
      <!-- END photo -->
      </span>
      </td>
      <td class="row2">
      <span class="genmed">
      </br></br></br><br><br>
      <!-- BEGIN photo -->
      <a href="{switch_admin.photo.U_MONTER}">{switch_admin.photo.L_MONTER}</a>&nbsp;<a href="{switch_admin.photo.U_DESCENDRE}">{switch_admin.photo.L_DESCENDRE}</a>&nbsp;<a href="javascript:if (confirm('{switch_admin.photo.L_CONFIRM_SUPP_PHOTO}')) document.location='{switch_admin.photo.U_SUPPRIMER}'">{switch_admin.photo.L_SUPPRIMER}</a><br>
      <!-- END photo -->
      </span>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>  
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><br><br><span class="genmed">{switch_admin.AJOUT_PHOTO}&nbsp;<b>{switch_admin.L_CATE}</b></span><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2">
	<form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 
		<table border="0" width="90%" align="center">
			<tr>	
				<td><span class="genmed">{switch_admin.NOM_PHOTO}</span><br></td>
				<td><br><input type="text" name="photo_name" size="30" class="post"><br></td>
			</tr>	
  			<tr> 
				<td><span class="genmed">{switch_admin.PHOTO}</span><br></td>
				<td><input type=FILE NAME="userfile" size="30" class="post"><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed">{switch_admin.COMMENTAIRE}</span><br></td>
				<td><textarea name="commentaire" cols="30" rows="5" class="post"></textarea><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed">{switch_admin.PHOTOGRAPHE}</span><br></td>
				<td><input type="text" name="photographe" size="30" class="post"><br></td>	
  			</tr>
   			<tr>  	
				<td><span class="genmed">{switch_admin.SOURCE}</span><br></td>
				<td><input type="text" name="source" size="30" class="post"><br><input class="post" type="checkbox" name="search"><span class="genmed">Cette personne est membre de Famille ? <span></td>	
  			</tr>
  			<tr> 
			<td colspan="2">
			<input type="hidden" name="cate_id" value="{switch_admin.CATE_ID}">
			<input type="hidden" name="user" value="{switch_admin.USER}">
			<input type="submit" value="{switch_admin.L_SUBMIT}"><br></td>
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
	<td colspan="2" class="row2"><br><span class="genmed">{switch_admin.RENOMME_CATE}&nbsp;<b>{switch_admin.LL_CATE}</b></span><br>
	<form method="post" action="{switch_admin.U_FORM_RENOMME}" enctype="multipart/form-data"> 
	{switch_admin.CASE}
	</form></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><br><span class="genmed"><a href="javascript:if (confirm('{switch_admin.L_CONFIRM_SUPP_CATE}')) document.location='{switch_admin.U_SUPP_CATE}'">{switch_admin.SUPP_CATE} {switch_admin.LL_CATE}</a></span><br><br><br>
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
<!-- END switch_admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->