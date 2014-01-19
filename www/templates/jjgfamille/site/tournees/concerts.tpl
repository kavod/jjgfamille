
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
	<td class="row2"><br>
		<table border="0" align="center" width="99%">
			<tr>
				<td><span class="genmed"><b>{CONCERT_TOURNEE}</b>&nbsp;<a href="{U_TOURNEE}">{L_TOURNEE}</a><br></span><br></td>
			</tr>
			<tr>
				<td><center><b><u>{L_TITRE}</u></b><br></center><br><br></td>
			</tr>
		</table>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
       <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><img src="../images/photo.gif"/><span class="genmed"><b><u>{PHOTOGRAPHIES}</u>&nbsp;:&nbsp;</b>{DISPO}</span><br>
	<span class="genmed"><a href="{U_AJOUT_PHOTO}">{L_AJOUT_PHOTO}</a></span><br><br>
	<table width="99%" align="center" border="0" >
	 <!-- BEGIN photos_row -->
      	 <tr>
      		<!-- BEGIN photos_column -->
      		<td width="33%" align="center" valign="bottom">
      		<a href="#" onclick="{photos_row.photos_column.ONCLICK}"><img src="{photos_row.photos_column.PHOTO}" border="0" alt="Agrandir l'image"/></a><br/>
      		<span class="genmed">{photos_row.photos_column.PHOTOGRAPHE}<a href="{photos_row.photos_column.U_USER}">{photos_row.photos_column.L_USER}</a></span><br>
      		<span class="genmed"><a href="{photos_row.photos_column.U_MODIFIER}">{photos_row.photos_column.L_MODIFIER}</a></span><br>
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
	<td class="row2"><br><br><img src="../images/texte.gif"/><span class="genmed"><b><u>{RECIT_CONCERT}</u>&nbsp;:&nbsp;</b>{DISPO_RECIT}</span><br>
	<span class="genmed"><a href="{U_AJOUT_RECIT}">{L_AJOUT_RECIT}</a></span><br><br>
	<table width="99%" align="center" border="0" >
	 <!-- BEGIN recits -->
      	 <tr>
      		<td>
      		<span class="genmed"><b>{recits.QUI}</b><a href="{recits.U_USER}">{recits.L_USER}</a>&nbsp;&nbsp;<a href="{recits.U_MODIFIER}">{recits.L_MODIFIER}</a><br>{recits.RECIT}</span><br><br>
      		</td>
        </tr>
        <!-- END recits -->
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
      <br><span class="genmed">
      <div align="left"><span class="genmed"><b><u>{switch_admin.MODIF_CONCERT}</u></b></span></div><br><br>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="60%" align="center">	
  			<tr>	
				<td><span class="genmed"><b>{switch_admin.LIEU} :</b></span><br></td>
				<td><input type="text" name="lieu" size="40" value="{switch_admin.L_LIEU}" class="post"><br></td>
			</tr>
  			<tr>	
				<td><span class="genmed"><b>{switch_admin.L_DATE} :</b></span><br></td>
				<td><input type="text" name="date" size="40" value="{switch_admin.DATE}" class="post"><br></td>
			</tr>
  			<tr> 
				<td colspan="2"><br>
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
		<table border="0" width="99%" align="center">	
  			<tr> 
				<td><span class="genmed"><center>[&nbsp;<a href="javascript:if (confirm('{switch_admin.L_CONFIRM_SUPP}')) document.location='{switch_admin.U_SUPP}'">{switch_admin.L_SUPP}</a>&nbsp;]</center></span><br></td>
  			</tr>
		</table>
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