
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
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td height="7" class="row2"></td>
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
      <td class="row2"><br>
        <span class="cattitle"><u>{CATE}:</u>&nbsp;<a href="{U_CATE}"><b>{L_CATE}</a></span><br><br>
	<center><span class="cattitle"><u>{TITRE_LIVRE}</u></span></center>
      <br><br>
      </td>
      	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
      </tr>
      <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
			<table border="0" width="90%" align="center">
      				<tr>
      					<td>
      						<!-- BEGIN switch_illu -->
      					<a href="#" onclick="{switch_illu.ONCLICK}"><img src="{switch_illu.ILLU}" alt="Agrandir l'image" border="0"></img></a>
      						<!-- END switch_illu -->
      					</td>
      				</tr>
      				<tr>
      					<td>
      						<span class="genmed"><i>{THANKS}</i></span>
      					</td>
      				</tr>
      				<tr>
      					<td>
      						<br><span class="genmed"><b>{L_AUTEUR}:</b> {AUTEUR_LIVRE}</span><br>
      						<b><span class="genmed">{L_NBPAGES}: </b> {NB_PAGES}</span><br>
      						<b><span class="smallmed">{L_COMMENT}:</b></span><br/><span class="genmed">{COMMENTAIRE_LIVRE}</span><br>
      					</td>
      					
      				</tr>
      			</table>
      		<br>
       </td>
     
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
           <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
	 	<table border="0" width="80%" align="center">
	 		<tr>
	 			<td><span class="cattitle"><u>{DIFF_EDITIONS}</b></span><br><br></td>
	 		</tr>
	 	</table>
	 	</span>
      </td>
      	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
      </tr>
       <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2" >
	 	<table border="1" width="80%" align="center">
	 		<tr align="center">
	 			<td><span class="genmed"><b>{L_EDITION}</b></span></td>
	 			<td><span class="genmed"><b>{L_COLLECTIONS}</b></span></td>
	 			<td width="20%"><span class="genmed"><b>{L_DATE_EDITION}</b></span></td>
	 			<td><span class="genmed"><b>{L_ISBN}</b></span></td>
	 			<td width="25%"><span class="genmed"><b>{L_COMMANDER}</b></span></td>
	 		</tr>
	 		<!-- BEGIN switch_edition -->
	 		<tr align="center">
	 			<td><span class="genmed">&nbsp;{switch_edition.EDITEUR}&nbsp;</span></td>
	 			<td><span class="genmed">&nbsp;{switch_edition.COLLECTIONS}&nbsp;</span></td>
	 			<td><span class="genmed">&nbsp;{switch_edition.DATE}&nbsp;</span></td>
	 			<td><span class="genmed">&nbsp;{switch_edition.ISBN}&nbsp;</span></td>
	 			<td ><a href="{switch_edition.U_AMAZON}" target="blank" ><img src="{switch_edition.IMG_COMMANDER}" border="0" alt="{switch_edition.COMMAND}" title="{switch_edition.COMMAND}"/></a></td>
	 		</tr>
	 		<!-- END switch_edition -->
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
      <td height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td class="ligneBas"></td>
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
      <span class="cattitle"><u>{switch_admin.MODIF_LIVRE}</u></span>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="99%" align="center">
			<tr>	
				<td width="20%"><span class="genmed"><b>{switch_admin.L_TITRE}</b></span><br></td>
				<td><br><input type="text" name="title" size="30" value="{switch_admin.TITRE}" class="post"><br></td>
			</tr>	
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_AUTEUR}</b></span><br></td>
				<td><input type="text" name="auteur" size="30" value="{switch_admin.AUTEUR}" class="post"><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_NBPAGES}</b></span><br></td>
				<td><input type="text" name="nb_pages" size="30" value="{switch_admin.NB_PAGES}" class="post"><br></td>
  			</tr>
  			<tr> 
				<td valign=top ><span class="genmed"><b>{switch_admin.L_COMMENT}</b></span><br></td>
				<td><textarea name="commentaire" cols="30" rows="5" class="post">{switch_admin.COMMENTAIRES}</textarea><br></td>
  			</tr>
  			<tr> 
				<td valign=top><span class="genmed"><b>{switch_admin.L_THANKS}</b></span><br></td>
				<td><textarea name="thanks" cols="30" rows="5" class="post">{switch_admin.THANKS}</textarea><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>Catégorie</b></span><br></td>
				<td><select name="cate_id">
				<!-- BEGIN mes_options -->
      				<option value="{switch_admin.mes_options.VALUE}"{switch_admin.mes_options.SELECTED}>{switch_admin.mes_options.INTITULE}</option>
				<!-- END mes_options -->
				</select><br></td>
  			</tr>
  			<tr> 
				<td colspan="2"><br>
				<input type="submit" value="{switch_admin.L_SUBMIT}">
				</form>
				</td>
			</tr>
			</table>
			<br>
			<span class="cattitle"><u>{switch_admin.LISTE_EDITIONS}</u></span>
			<br>
			<table border="0" width="99%" align="center">
			<tr>	
				<td width="40%">
				<!-- BEGIN switch_edition -->
      				<span class="genmed">{switch_admin.switch_edition.EDITEUR}_{switch_admin.switch_edition.DATE}___{switch_admin.switch_edition.ISBN}</span><br>
				<!-- END switch_edition -->
				</td>
				<td>
				<!-- BEGIN switch_edition -->
      				<span class="genmed"><a href="{switch_admin.switch_edition.U_MODIFIER}">{switch_admin.switch_edition.L_MODIFIER}</a>&nbsp;<a href="{switch_admin.switch_edition.U_MONTER}">{switch_admin.switch_edition.L_MONTER}</a>&nbsp;<a href="{switch_admin.switch_edition.U_DESCENDRE}">{switch_admin.switch_edition.L_DESCENDRE}</a>&nbsp;<a href="javascript:if (confirm('{switch_admin.switch_edition.L_CONFIRM_SUPP_EDITION}')) document.location='{switch_admin.switch_edition.U_SUPPRIMER}'">{switch_admin.switch_edition.L_SUPPRIMER}</a></span><br>      				      				
				<!-- END switch_edition -->
				</td>
			</tr>	
			</table>
			<br>
			<span class="cattitle"><u>{switch_admin.AJOUT_EDITION}</u></span>&nbsp;<span class="genmed"><a href="{switch_admin.U_ADD_EDITION}">{switch_admin.L_ADD_EDITION}</a></span></div>
			<br>
			<table border="0" width="99%" align="center">
			<form method="post" action="{switch_admin.U_FORM2}" enctype="multipart/form-data"> 
			<tr>	
				<td width="20%"><span class="genmed"><b>{switch_admin.L_EDITION}</b></span><br></td>
				<td><br><input type="text" name="editeur" size="30" class="post" value="{switch_admin.VAL_EDITION}"><br></td>
			</tr>
			<tr>	
				<td><span class="genmed"><b>{switch_admin.L_COLLECTIONS}</b></span><br></td>
				<td><input type="text" name="collections" size="30" class="post" value="{switch_admin.VAL_COLLECTIONS}"></td>
			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_DATE_EDITION}</b></span><br></td>
				<td><input type="text" name="date" size="30" class="post" value="{switch_admin.VAL_DATE}"><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_ISBN}</b></span><br></td>
				<td><input type="text" name="isbn" size="30" class="post" value="{switch_admin.VAL_ISBN}"><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_ASIN}</b></span><br></td>
				<td><input type="text" name="asin" size="30" class="post" value="{switch_admin.VAL_ASIN}"><br></td>
  			</tr>
  			<tr> 
				<td colspan="2"><br>
				<input type="submit" value="{switch_admin.BOUTON}">
				</form>
				</td>
			</tr>
			</table>
			<br>			
			<span class="cattitle"><u>{switch_admin.AJOUT_ILLU}</u></span>
			<br>
			<table border="0" width="99%" align="center">
			<!-- BEGIN switch_illu -->
			<tr>
					<td>					
      					<a href="#" onclick="{switch_admin.switch_illu.ONCLICK}"><img src="{switch_admin.switch_illu.ILLU}"  alt="Editer l'illustration" border="0"/></a>		     						
      					</td>      				
			</tr>
			<tr>
					<td>					
      				 <span class="genmed"><a href="{switch_admin.switch_illu.U_MONTER}"><--</a>&nbsp;<a href="{switch_admin.switch_illu.U_DESCENDRE}">--></a><br>
      				 <a href="javascript:if (confirm('{switch_admin.switch_illu.L_CONFIRM_SUPP_ILLU}')) document.location='{switch_admin.switch_illu.U_ILLU}'">{switch_admin.switch_illu.SUPP_ILLU}</a></span> 		     						
      					</td> 
			</tr>
			<!-- END switch_illu -->
			<tr>				
				<td>						
      						<br><form method="post" action="{switch_admin.U_FORM3}" enctype="multipart/form-data"> 
      						<span class="genmed"><b>{switch_admin.L_ILLU}</b><input type=FILE NAME="userfile" size="30" class="post"></span><br>
      						<span class="genmed"><b>{switch_admin.L_COMMENT}</b><textarea name="commentaire" cols="30" rows="5" class="post"></textarea></span><br><br>
      						<input type="submit" value="{switch_admin.L_SUBMIT}">
      						</form>
      						
      				</td>
      			</tr>
      			</table>
      			<br><br>		
	</span>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><span class="cattitle"><a href="javascript:if (confirm('{switch_admin.L_CONFIRM_SUPP_LIVRE}')) document.location='{switch_admin.U_SUPP}'">{switch_admin.L_SUPP}&nbsp;{switch_admin.TITRE_LIVRE}</a></span></center></td>
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


