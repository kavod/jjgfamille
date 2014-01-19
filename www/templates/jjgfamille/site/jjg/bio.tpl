
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
					<td align="center" valign="top" colspan="2">{ERROR_BOX}<br/>
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{L_BIO}</th>
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
      <td class="row2" align="center"><br>
     <form method="post" action="{U_GO_TO_PAGE}">
      <select name="bio_id" onChange="this.form.submit()">
      <!-- BEGIN go_to_page -->
      		<option value="{go_to_page.VALUE}"{go_to_page.SELECTED}>{go_to_page.INTITULE}</option>
      <!-- END go_to_page -->
      </select>
      </form>
      </td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
        <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2"><center><span class="cattitle"><u>{TITRE}</u></span></center>
      <br><span class="genmed">{CONTENU}<br><br>
      <!-- BEGIN switch_suiv -->
      <div style="text-align:center"><span class="cattitle"><a href="{switch_suiv.U_PAGE_SUIVANTE}">{switch_suiv.L_PAGE_SUIVANTE}</a></span></div>
      <!-- END switch_suiv -->
      <div align="right">{BIO_QUI}</div><br>
      <center>{IMAGE}</center><br>
      </span>
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
      <td colspan="3" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="3" height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th colspan="3" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="3" class="row2"><br>{switch_admin.NEW}</a><br></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" width ="30%" class="row2"><br>
	<form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 
	<span class="genmed"><b>{switch_admin.TITRE} :</b></span></td>
	<td class="row2"><br><input type="text" value="{switch_admin.TITRE_PAGE}" name="title" maxlength="100" size="70" class="post">&nbsp;<span class="genmed">{switch_admin.L_PAGE}</span><br></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><span class="genmed"><b>{switch_admin.CONTENU} :</b></span><br></td>
	<td class="row2"><textarea name="contenu" rows="15" cols="70" class="post">{switch_admin.CONTENU_PAGE}</textarea><br></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><span class="genmed"><b>{switch_admin.AUTEUR} :</b></span><br></td>
	<td class="row2"><br><a href="{switch_admin.U_AUTEUR}"><span class="genmed">{switch_admin.L_AUTEUR}</span></a><br></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="3" class="row2"><br>
	<center><input type="submit" value="{switch_admin.L_SUBMIT}"></center></form><br><br></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" width ="30%" class="row2"><br>
	<form method="post" action="{switch_admin.U_FORM_PIC}" enctype="multipart/form-data"> 
	<span class="genmed"><b>{switch_admin.PIC} :</b></span></td>
	<td class="row2">{switch_admin.IMAGE}<br><a href="javascript:if (confirm('{switch_admin.L_CONFIRM_SUPP_ILLU}')) document.location='{switch_admin.U_SUPP_IMAGE}'"><span class="genmed">{switch_admin.L_SUPP_IMAGE}</span></a>
	<br><input type=FILE NAME="userfile" class="post">
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="3" class="row2"><br>
	<center><input type="submit" value="{switch_admin.L_SUBMIT}"></center></form><br><br></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
   <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td colspan="3" class="row2">
      
      <table border="0" width="90%" align="center">
      <!-- BEGIN switch_bio -->
      	<tr>
		<td><span class="genmed"><a href="{switch_admin.switch_bio.U_PAGE}">{switch_admin.switch_bio.L_PAGE}:{switch_admin.switch_bio.PICTURE}</a></span></td>
		<td><span class="genmed"><a href="{switch_admin.switch_bio.U_TITRE}">{switch_admin.switch_bio.L_TITRE}</a></span></td>
		<td><span class="genmed"><a href="{switch_admin.switch_bio.U_AUTEUR}">{switch_admin.switch_bio.L_AUTEUR}</a></span></td>
		<td><span class="genmed"><a href="javascript:if (confirm('{switch_admin.switch_bio.L_CONFIRM_SUPP_EPISODE}')) document.location='{switch_admin.switch_bio.U_SUPP}'">{switch_admin.switch_bio.L_SUPP}</a></span></td>
	</tr>
	<!-- END switch_bio -->
      </table>
      
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="3" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="3" class="ligneBas"></td>
    </tr>
</tbody>    
</table>
<!-- END switch_admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->