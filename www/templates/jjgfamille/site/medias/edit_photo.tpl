
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
      <span class="genmed">
      <div align="left"><span class="genmed"><u>{EDITER_ILLU} :</u>&nbsp;&nbsp;<a href="{U_GALERIE}">{L_GALERIE}&nbsp;{L_TITLE}</a></span></div><br><br>
      <form method="post" action="{U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="80%" align="center">	
  			<tr> 
				<td><center><img src="{ILLU}"></img></center></td>
  			</tr>
  		</table>
  		<br>
  		<table border="0" width="80%" align="center">
  			<tr> 
				<td><span class="genmed"><b>{L_DESC}</b></span><br></td>
				<td><input type="text" name="comment" size="60" value="{DESC}" class="post"></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{L_PHOTOGRAPHE}</b></span><br></td>
				<td><input type="text" name="photographe" size="60" value="{PHOTOGRAPHE}" class="post"></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{L_ASSO}</b></span><br></td>
				<td><select name="page_id">
				<option value="0">Ne pas associer</option>
				<!-- BEGIN switch_page -->
      				<option value="{switch_page.VALUE}"{switch_page.SELECTED}>{switch_page.INTITULE}</option>
				<!-- END switch_page -->
				</select><br></td>
  			</tr>
  			<tr> 
				<td colspan="2"><br>
				<center><input type="submit" value="{L_SUBMIT}"></center>
				</form>
				</td>
			</tr>
			<tr> 
				<td colspan="2">
				<span class="genmed"><center>[&nbsp;<a href="{U_SUPPRIMER}">{L_SUPPRIMER}</a>&nbsp;]</center></span>
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