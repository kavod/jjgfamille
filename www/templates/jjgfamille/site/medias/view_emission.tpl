
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
      <td class="row2"><br><span class="genmed"><a href="{U_ARCHIVES}"><b>...{L_ARCHIVES}</b></a></span>
      		<table width="99%" border="0" align="center">
      			<tr>
      				<td colspan="3">
      					<center>{ICON_SUPPORT}&nbsp;<b><u>{L_TITLE}</u></b>&nbsp;<span class="genmed"><a href="{U_SUPPORT}">{L_SUPPORT}</a><br> 
      					<span class="genmed">{DATE}&nbsp;{HEURE}<br>
      					<b>{TYPE_EMISSION} : </b>{TYPE}<br>
      					<b>{ANNONCE_PAR} </b><a href="{U_ANNONCEUR}">{L_ANNONCEUR}</a><br><br>
      					<!-- BEGIN switch_illu -->
      					<a href="#" onclick="{switch_illu.ONCLICK}"><img src="{switch_illu.ILLU}" alt="Agrandir l'image" border="0"/></a>   					
      					<!-- END switch_illu -->
      					</center>      					    					    		      					       				
      					<br><br>
      					<b>{DESC}</b><br>{DESCRIPTION}<br><br>
      					<br><br>
      					</span>				
      				</td>
      		
      			</tr>
      			<tr>
      				<td colspan="3">
      					<span class="genmed">
      					{REFER}
      					</span>
      					<br><br><br>				
      				</td>
      		
      			</tr>
      			<tr valign="top">
      				<td width="35%">
      					<span class="genmed">
      					<center>{IMG_RETRANSCRIPTION}&nbsp;<b><u>{RETRAN_ECRITE}</u></b></center><br><br>
      					{RETRANSCRIPTION}
      					<!-- BEGIN switch_retranscription -->
      					<a href="{switch_retranscription.U_TITRE}">{switch_retranscription.L_TITRE}</a>&nbsp;{switch_retranscription.PAR}&nbsp;<a href="{switch_retranscription.U_USER}">{switch_retranscription.L_USER}</a><br>  					
      					<!-- END switch_retranscription -->
      					<br><br>
      					<b>{IS_YOU_TO_PLAY}</b><br><a href="{U_ADD_RETRANSCRIPTION}">{L_ADD_RETRANSCRIPTION}</a>
      					<br><br>
      					</span>				
      				</td>
      				<td width="30%">
      					
      					<span class="genmed">
      					<center>{IMG_ILLU}&nbsp;<b><u>{ILLUSTRATIONS}</u></b></center><br><br>
      					{ILLU}
      					<!-- BEGIN switch_illustration -->
      					<a href="{switch_illustration.U_ILLUS}">{switch_illustration.L_ILLUS}</a><br>  					
      					<!-- END switch_illu -->
      					<br><br>
      					<b>{IS_YOU_TO_PLAY}</b><br><a href="{U_ADD_ILLU}">{L_ADD_ILLU}</a>
      					<br><br>
      					</span>				
      				</td>
      				<td width="35%">
      					
      					<span class="genmed">
      					<center>{IMG_AUDIO}&nbsp;<b><u>{AUDIOS_VIDEOS}</u></b></center><br><br>
      					{AUDIO}
      					<!-- BEGIN switch_audio -->
      					<a href="#" onclick="{switch_audio.ONCLICK}"><b>{switch_audio.L_TITRE}</b></a>&nbsp;{switch_audio.PAR}&nbsp;<a href="{switch_audio.U_USER}">{switch_audio.L_USER}</a>
      					<!-- BEGIN admin -->
      					&nbsp;&nbsp;<a href="{switch_audio.admin.U_SUPP}">{switch_audio.admin.L_SUPP}</a>
      					<!-- END admin -->
      					<br />
      					<!-- END switch_audio -->
      					<br><br>
      					<b>{IS_YOU_TO_PLAY}</b><br><a href="{U_ADD_EXTRAIT}">{L_ADD_EXTRAIT}</a>
      					
      					</span>				
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
      <div align="left"><span class="genmed"><b><u>{switch_admin.MODIF_EMISSION} :</u></b></span></div><br><br>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="60%" align="center">
			<tr>	
				<td width="35%"><span class="genmed"><b>{switch_admin.L_TITRE} :</b></span><br></td>
				<td><input type="text" size="40" name="title" value="{switch_admin.TITRE}" class="post"><br></td>
			</tr>
			  <tr> 
				<td><span class="genmed"><b>{switch_admin.L_SUPPORT}</b></span><br></td>
				<td><select name="support_id">
				<!-- BEGIN support -->
      				<option value="{switch_admin.support.VALUE}"{switch_admin.support.SELECTED}>{switch_admin.support.INTITULE}</option>
				<!-- END support -->
				</select><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.DESC}</b></span><br></td>
				<td><textarea name="comment" cols="40" rows="10" class="post">{switch_admin.COMMENT}</textarea><br></td>
  			</tr>
  			 <tr> 
				<td><span class="genmed"><b>{switch_admin.L_TYPE} :</b></span><br></td>
				<td><select name="type_media">
      				<option value="itw"{switch_admin.SELECT_ITW}>{switch_admin.ITW}</option>
      				<option value="report"{switch_admin.SELECT_REPORTAGE}>{switch_admin.REPORTAGE}</option>
      				<option value="autre"{switch_admin.SELECT_AUTRE}>{switch_admin.OTHER}</option>
				</select><br>
				</td>
  			</tr>
  			<tr>	
				<td width="35%"><span class="genmed"><b>{switch_admin.L_DATE} :</b></span><br></td>
				<td><input type="text" name="date" size="40" value="{switch_admin.DATE}" class="post"><br></td>
			</tr>
  			<tr>	
				<td width="35%"><span class="genmed"><b>{switch_admin.L_HEURE} :</b></span><br></td>
				<td><input type="text" name="heure" size="40" value="{switch_admin.HEURE}" class="post"><br></td>
			</tr>
			<tr>	
				<td width="35%"><span class="genmed"><b>{switch_admin.L_DATE_HOT} :</b></span><br></td>
				<td><input type="text" name="date_hot" size="40" value="{switch_admin.DATE_HOT}" class="post"><br></td>
			</tr>
			<tr> 
				<td><span class="genmed"><b>{switch_admin.REFER_NEXT}</b></span><br></td>
				<td><select name="album_id">
				<option value="0">Aucun</option>
				<!-- BEGIN album -->
      				<option value="{switch_admin.album.VALUE}" {switch_admin.album.SELECTED}>{switch_admin.album.INTITULE}</option>
				<!-- END album -->
				</select><br></td>
  			</tr>
  			<tr> 
				<td colspan="2"><br>
				<center><input type="submit" value="{switch_admin.L_SUBMIT}"></center>
				</form>
				</td>
			</tr>
			</table>
			<br>
			<div align="left"><span class="genmed"><a href="javascript:if (confirm('{switch_admin.L_CONFIRM_SUPP_EMISSION}')) document.location='{switch_admin.U_SUPP}'">{switch_admin.L_SUPP}</a></span></div><br>
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