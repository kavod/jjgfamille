
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
	<td class="row2"><br><b>{LISTE_TOURNEE}&nbsp;:&nbsp;{CATE}</b><br><br>
	<table width="99%" align="center" border="0" >
	 <!-- BEGIN tournee_row -->
      	 <tr>
      		<!-- BEGIN tournee_column -->
      		<td width="33%" align="center" valign="bottom">
      		<br><span class="genmed"><a href="{tournee_row.tournee_column.U_TITRE}"><img src="{tournee_row.tournee_column.PHOTO}" border="0"/><br/>
      		{tournee_row.tournee_column.L_TITRE}</b><br>{tournee_row.tournee_column.DATE}<br>{tournee_row.tournee_column.ARTIST}</a></span><br>
      		</td>
      		<!-- END tournee_column  -->
        </tr>
        <!-- END tournee_row -->
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
<br>
<!-- BEGIN switch_admin -->
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
       <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <br>
      <div align="left"><span class="genmed"><b><u>{switch_admin.AJOUT_TOURNEE}</u></b></span></div><br>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="85%" align="center">
			<tr>	
				<td><span class="genmed"><b>{switch_admin.L_TITRE} :</b></span><br></td>
				<td><input type="text" name="title" size="50" class="post"><br></td>
			</tr>
			  <tr> 
				<td><span class="genmed"><b>{switch_admin.L_ARTIST} :</b></span><br></td>
				<td><select name="artist_id">
				<!-- BEGIN artist -->
      				<option value="{switch_admin.artist.VALUE}" {switch_admin.artist.SELECTED}>{switch_admin.artist.INTITULE}</option>
				<!-- END artist -->
				</select><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.DESC}</b></span><br></td>
				<td><textarea name="comment" cols="50" rows="10" class="post"></textarea><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_MUSICIANS}&nbsp;:</b></span><br></td>
				<td><textarea name="musicians" cols="50" rows="10" class="post"></textarea><br></td>
  			</tr>
  			<tr> 
				<td colspan="2"><input type="hidden" name="cate_id" value="{switch_admin.CATE_ID}"/><br>
				<center><input type="submit" value="{switch_admin.L_SUBMIT}"></center>
				</form>
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
	<span class="genmed">
	<form method="post" action="{switch_admin.U_MOD_CATE}"><u>{switch_admin.MOD_CATE}:</u>&nbsp;
		<input type="hidden" name="cate_id" value="{switch_admin.CATE_ID}" />
		<input type="text" name="cate_name" size="30" value="{switch_admin.NOM_CATEGORIE}" class="post" />&nbsp;
		<input type="submit" value="{switch_admin.L_SUBMIT}" />
	</form>
	</span>
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