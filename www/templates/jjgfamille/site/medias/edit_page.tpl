
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
      <td  height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB_MEDIAS}</th>
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
      <td class="row2">
      <br><span class="genmed">
      <div align="left"><span class="genmed"><b><u>{AJOUT_PAGE} :</u></b>&nbsp;&nbsp;<a href="{U_TITLE}">{L_TITLE}</a></span></div><br><br>
      <form method="post" action="{U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="60%" align="center">	
  			<tr> 
				<td valign="top" width="35%"><span class="genmed"><b>{CONTENU}&nbsp;:</b></span><br></td>
				<td><textarea name="contenu" rows="20" cols="70" class="post">{L_CONTENU}</textarea></td>
  			</tr>
  			<tr> 
				<td colspan="2"><br>
				<center><input type="submit" value="{L_SUBMIT}"></center>
				</form>
				</td>
			</tr>
			</table>
			<br>
			<table width="99%" align="center" border="0" >
	 <tr>
      		
      		<td>
      		<span class="genmed"><b>{IMAGES_ASSO}</b><center><a href="{U_GALERIE_ASSO}"><b>{L_GALERIE_ASSO}</b></a></center></span>
      		<br>
      		</td>

        </tr>
        </table>
        <table width="99%" align="center" border="0" >
	 <!-- BEGIN photos_row -->
      	 <tr>
      		<!-- BEGIN photos_column -->
      		<td width="33%" align="center" valign="bottom">
      		<a href="#" onclick="{photos_row.photos_column.ONCLICK}"><img src="{photos_row.photos_column.PHOTO}" border="0" alt="Agrandir l'image"/></a><br/>
      		<span class="genmed"><b>{photos_row.photos_column.PAGE}</b><i>{photos_row.photos_column.DESC}</i></span><br>
      		<span class="genmed"><a href="{photos_row.photos_column.U_MONTER}">{photos_row.photos_column.L_MONTER}</a>&nbsp;|&nbsp;<a href="{photos_row.photos_column.U_DESCENDRE}">{photos_row.photos_column.L_DESCENDRE}</a></span><br>
      		<span class="genmed"><a href="javascript:if (confirm('{photos_row.photos_column.L_CONFIRM_SUPP_PHOTO}')) document.location='{photos_row.photos_column.U_SUPPRIMER}'">{photos_row.photos_column.L_SUPPRIMER}</a></span><br>
      		</td>
      		<!-- END photos_column -->
        </tr>
        <!-- END photos_row -->
	</table>
	<br>
        <table width="99%" align="center" border="0" >
      	 <tr>
      		<td >
      		<table border="0" width="60%" align="center">	
  			<tr> 
				<td colspan="3"><span class="genmed"><center><b>{EXTRAITS_AV}</b></center></span><br></td>
  			</tr>
  			<tr> 
				<td ><span class="genmed"><b>{NOM_EXTRAIT}</b></span></td>
				<td ><span class="genmed"><b>{MODIFIER_NOM}</b></span></td>
				<td ><span class="genmed"><b>{L_SUPPRIMER}</b></span></td>
			</tr>
			<!-- BEGIN switch_audio -->
			<form method="post" action="{switch_audio.U_FORM}" enctype="multipart/form-data">
			<tr> 
				<td valign="top"><span class="genmed"><a href="{switch_audio.U_DESC}">{switch_audio.DESC}</a></span></td>
				<td ><span class="genmed"><input type="text" name="desc" size="30" class="post">&nbsp;<input type="submit" value="{switch_audio.L_SUBMIT}"></span></td>
				<td valign="top"><span class="genmed"><a href="javascript:if (confirm('{switch_audio.L_CONFIRM_SUPP_AUDIO}')) document.location='{switch_audio.U_SUPP_AUDIO}'">{switch_audio.L_SUPPRIMER}</a></span></td>
			</tr>
			</form>
			<!-- END switch_audio -->
		</table>
		<br>
		<table border="0" width="60%" align="center">	
  			<tr> 
				<td colspan="2"><span class="genmed"><center><b>{ADD_EXTRAITS_AV}</b></center></span><br></td>
  			</tr>
  			<form method="post" action="{U_FORM_AUDIO}" enctype="multipart/form-data">
  			<tr> 
				<td><span class="genmed">{CHEMIN_FILE}<br><small>({RM_ONLY})</small></span></td><td><input type="file" name="userfile" size="30" class="post"></td>
			</tr>
			<tr> 
				<td><span class="genmed">{L_DESC}<br><small>({LITTLE})</small></span></td><td><input type="text" name="desc" size="30" class="post"></td>
			</tr>
			<tr> 
				<td colspan="2"><center><input type="submit" value="{L_SUBMIT}"></center><br></td>
			</tr>
			</form>
			<tr> 
				<td colspan="2"><span class="genmed"><center>[&nbsp;<a href="javascript:if (confirm('{L_CONFIRM_SUPP_PAGE}')) document.location='{U_SUPP_PAGE}'">{L_SUPPRIMER_PAGE}</a>&nbsp;]</center></span></td>
			</tr>
		</table>
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
		</td>
				</tr>
				
				
				
				
<!-- FIN du document -->