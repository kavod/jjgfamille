
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
      <td class="row2"><br>     
      <center>{ICON_SUPPORT}<b>{TITRE}</b></center><br><br>
      <span class="genmed">
      <b>{TYPE_MEDIA} :</b> {MEDIA_TYPE}<br>
      <b>{DESC} </b> {COMMENT}<br>
      <b>{L_URL} </b> {URL}<br>
      <br><b>{LISTE_EMISSIONS} :</b><br>
      <!-- BEGIN switch_liste -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{switch_liste.DATE}&nbsp;:</b>&nbsp;<a href="{switch_liste.U_TITLE}">{switch_liste.L_TITLE}</a>&nbsp;{switch_liste.ILLU}&nbsp;{switch_liste.RETRANSCRIPTION}&nbsp;{switch_liste.AUDIO}<br>
	<!-- END switch_liste -->
      </span>
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.ADMIN_MEDIAS}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <br><span class="genmed">
      <div align="left"><span class="genmed"><b><u>{switch_admin.MODIF_SUPPORTS} :</u></b></span></div><br><br>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="60%" align="center">
			<tr>	
				<td width="35%"><span class="genmed"><b>{switch_admin.NOM_SUPPORT} :</b></span><br></td>
				<td><input type="text" size="40" name="title" value="{switch_admin.TITRE}" class="post"><br></td>
			</tr>	
  			 <tr> 
				<td><span class="genmed"><b>{switch_admin.TYPE_MEDIA} :</b></span><br></td>
				<td><select name="type_media">
      				<option value="{switch_admin.TV}"{switch_admin.SELECT_TV}>{switch_admin.TV}</option>
      				<option value="{switch_admin.RADIO}"{switch_admin.SELECT_RADIO}>{switch_admin.RADIO}</option>
      				<option value="{switch_admin.PRESSE}"{switch_admin.SELECT_PRESSE}>{switch_admin.PRESSE}</option>
      				<option value="{switch_admin.INTERNET}"{switch_admin.SELECT_INTERNET}>{switch_admin.INTERNET}</option>
      				<option value="{switch_admin.OTHER}"{switch_admin.SELECT_AUTRE}>{switch_admin.P_OTHER}</option>
				</select><br>
				<span class="genmed">{switch_admin.SI_AUTRE} : </span><input type="text" name="autre" value="{switch_admin.AUTRE}" class="post">
				</td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.DESC} </b></span><br></td>
				<td><textarea name="comment" cols="40" rows="10" class="post">{switch_admin.COMMENT}</textarea><br></td>
  			</tr>
  			<tr>	
				<td width="20%"><span class="genmed"><b>{switch_admin.SITE_WEB} :</b></span><br></td>
				<td><input type="text" name="url" size="40" value="{switch_admin.URL}" class="post"><br></td>
			</tr>
  			<tr> 
				<td colspan="2"><br>
				<center><input type="submit" value="{switch_admin.L_SUBMIT}"></center>
				</form>
				</td>
			</tr>
			</table>
			<br>
			<div align="left"><span class="genmed"><b><u>{switch_admin.LISTE_SUPPORTS} :</u></b></span></div><br>
			<table border="0" width="60%" align="center">
			<!-- BEGIN switch_support -->
			<tr>	
				<td>
				<span class="genmed"><a href="{switch_admin.switch_support.U_TITRE}">{switch_admin.switch_support.L_TITRE}</a></span>
				</td>
				<td>
				<span class="genmed">{switch_admin.switch_support.COUNT}&nbsp;{switch_admin.EMISSIONS_ARTICLES}</a></span>
				</td>
				<td>
				 <span class="genmed"><a href="javascript:if (confirm('{switch_admin.switch_support.L_CONFIRM_SUPPORT}')) document.location='{switch_admin.switch_support.U_SUPP_SUPPORT}'">{switch_admin.switch_support.L_SUPP_SUPPORT}</a></span>
				</td>
			</tr>
			<!-- END switch_support -->	  	
			</table>
	<br><br>
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
<!-- END switch_admin -->		</td>
				</tr>
				
				
				
				
<!-- FIN du document -->