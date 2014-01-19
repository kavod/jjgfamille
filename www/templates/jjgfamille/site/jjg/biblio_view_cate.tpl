
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{L_BIBLIO}</th>
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
      <br>
      <span class="cattitle"><u>{CATE}</u></span>
      <br><br>
      <table border="0" width="99%" align="center">
      <!-- BEGIN livres_row -->
      <tr>
      <!-- BEGIN livres_column -->
      <td width="33%" align="center" valign="bottom">
      <a href="{livres_row.livres_column.U_LIVRE}"><img src="{livres_row.livres_column.LIVRE}" alt="{livres_row.livres_column.L_LIVRE}" border="0" /></a><br />
      <span class="genmed"><a href="{livres_row.livres_column.U_LIVRE}"><b>{livres_row.livres_column.L_LIVRE}</b></a></span><br/><br/>
      </td>
      <!-- END livres_column -->
      </tr>
      <!-- END livres_row -->
      </table>
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
      <td  class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td  height="7" class="row2"></td>
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
      <td class="row2">
      <br>
      <span class="cattitle"><u>{switch_admin.AJOUT_LIVRE}</u></span>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 
		<table border="0" width="50%" align="left">
			<tr>	
				<td><span class="genmed"><b>{switch_admin.L_TITRE}</b></span><br></td>
				<td><br><input type="text" name="title" size="30" class="post"><br></td>
			</tr>	
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_AUTEUR}</b></span><br></td>
				<td><input type="text" name="auteur"  size="30" class="post"><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_NBPAGES}</b></span><br></td>
				<td><input type="text" name="nb_pages" size="30" class="post"><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_COMMENT}</b></span><br></td>
				<td><textarea name="commentaire" cols="30" rows="5" class="post"></textarea><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_THANKS}</b></span><br></td>
				<td><textarea name="thanks" cols="30" rows="5" class="post"></textarea><br></td>
  			</tr>
  			<tr> 
				<td colspan="2">
				<input type="hidden" name="cate_id" value="{switch_admin.CATE_ID}">
				<input type="submit" value="{switch_admin.L_SUBMIT}">
				</form>
				</td>
			</tr>
			<form method="post" action="{switch_admin.U_FORM2}" enctype="multipart/form-data"> 
			<tr>
				<td><span class="cattitle"><u>{switch_admin.RENAME_CATE}</u></span><br/><br></td>
			</tr>
			<tr>
				<td><input type="text" name="cate_name" size="30 value="{switch_admin.CATE_NAME}" class="post">&nbsp;<input type="submit" value="{switch_admin.L_SUBMIT}">
				</form></td>
			</tr>
		</table>
	
      </td>
      <br><br>
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
<!-- END switch_admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->