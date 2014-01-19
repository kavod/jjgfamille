
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{RUB}</th>
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
      <td class="row2"><br><span class="cattitle"><u>{GALERIE} :</u></span><br/><br/>
      <!-- BEGIN switch_count -->
      <span class="genmed">{switch_count.L_PHOTO} <a href="{switch_count.U_USER}">{switch_count.L_USER}</a></span><br/>
      <!-- END switch_count -->
      <br/>  					    					    		      					       				
	<table border="0" width="99%" align="center">
      		<!-- BEGIN photos_row -->
      		<tr align="center" valign="bottom">
      			<!-- BEGIN photos_column -->
      			<td width="33%">
     				 <a href="#" onclick="{photos_row.photos_column.ONCLICK}"><img src="{photos_row.photos_column.ILLU}" alt="agrandir l'image" title="agrandir l'image" border="0" /></a>
     				 <br/><span class="genmed">{photos_row.photos_column.PHOTOGRAPHE}</span><br/>
				<span class="genmed">
				<a href="{photos_row.photos_column.U_MONTER}">{photos_row.photos_column.L_MONTER}</a>
				&nbsp;<a href="{photos_row.photos_column.U_DESCENDRE}">{photos_row.photos_column.L_DESCENDRE}</a><br/>
				<a href="{photos_row.photos_column.U_MODIFIER}">{photos_row.photos_column.L_MODIFIER}</a>
				</span><br/>
     			</td>
     			<!-- END photos_column -->
      		</tr>
      		<!-- END photos_row -->
      	</table><br>
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
      <div align="left"><span class="genmed"><b><u>{switch_admin.MODIF_ILLU}</u></b></span></div><br><br>		
		<!-- BEGIN switch_illu -->
		<table border="0" width="80%" align="center">
		<form method="post" action="{switch_admin.switch_illu.U_FORM}" enctype="multipart/form-data"> 	
  			<tr> 
				<td colspan="2" align="center"><img src="{switch_admin.switch_illu.ILLU}"></img></td>				
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.switch_illu.L_DESC}</b></span><br></td>
				<td><input type="text" name="comment" size="60" value="{switch_admin.switch_illu.COMMENT}" class="post"></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.switch_illu.L_PHOTOGRAPHE}</b></span><br></td>
				<td><input type="text" name="photographe" size="60" value="{switch_admin.switch_illu.PHOTOGRAPHE}" class="post"></td>
  			</tr>
  			<tr> 
  				<td>&nbsp;</td>
				<td align="center">
				<input type="hidden" name="illustration_id" value="{switch_admin.switch_illu.ILLU_ID}">
				<input type="submit" value="{switch_admin.L_SUBMIT}">
				</form>
				</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td align="center"><span class="genmed"><a href="javascript:if (confirm('{switch_admin.switch_illu.L_CONFIRM_SUPP_PHOTO}')) document.location='{switch_admin.switch_illu.U_SUPP}'">{switch_admin.L_SUPP}</a></span><br></td>
			</tr>
		</table>
		<br>
		<!-- END switch_illu -->
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