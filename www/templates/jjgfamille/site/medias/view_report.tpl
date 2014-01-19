
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
					<td align="center" valign="top" colspan="2"><br />
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
	<table width="99%" align="center" border="0" >
	<tr>
		<td>
			<center><b>{TITRE}</b><br>
			<span class="genmed">
			{DATE}<br>{PAR}
			<!-- BEGIN switch_reporter -->
				<a href="{switch_reporter.U_REPORTER}">{switch_reporter.L_REPORTER}</a>,
			<!-- END switch_reporter -->
			<br><a href="{U_VOIR_CREDITS}"><b>{L_VOIR_CREDITS}</b></a><br><br>
			<form method="post" action="{U_GO_TO_PAGE}">
      			<select name="page_id" onChange="this.form.submit()">
      			<!-- BEGIN go_to_page -->
      				<option value="{go_to_page.VALUE}"{go_to_page.SELECTED}>{go_to_page.INTITULE}</option>
      			<!-- END go_to_page -->
      			</select>
      			</form>
			</span>
			</center>
		</td>
	</tr>
	<tr>
		<td>
			<img src="../images/picture.gif"></img>&nbsp;<span class="genmed"><a href="{U_VOIR_GALERIE_PHOTO}">{L_VOIR_GALERIE_PHOTO}</a></span>
		</td>	
	</tr>
	<tr>
		<td>
			<br><span class="genmed">{CONTENU}</span>
		</td>	
	</tr>
	<tr>
		<td>
			<br><span class="genmed"><b><u>{PHOTOGRAPHIE}</u></b></span>
		</td>	
	</tr>
	</table>
	<table width="99%" align="center" border="0" >
	 <!-- BEGIN photos_row -->
      	 <tr>
      		<!-- BEGIN photos_column -->
      		<td width="33%" align="center" valign="bottom">
      		<a href="#" onclick="{photos_row.photos_column.ONCLICK}"><img src="{photos_row.photos_column.PHOTO}" border="0" alt="Agrandir l'image"/></a><br/>
      		<span class="genmed"><i>{photos_row.photos_column.DESC}</i></span><br>
      		<span class="genmed"><u>{photos_row.photos_column.PHOTOGRAPHIE}&nbsp;:</u>&nbsp;{photos_row.photos_column.PHOTOGRAPHE}</span><br>
      		</td>
      		<!-- END photos_column -->
        </tr>
        <!-- END photos_row -->
	</table>
	<table width="99%" align="center" border="0" >
      	 <tr>
      		<td>
      		<br><br><span class="genmed"><b>{AUDIO}</b></span>
      		</td>
        </tr>
      	 <!-- BEGIN switch_audio -->
      	 <tr>
      		<td>
      		<span class="genmed"><a href="#" onclick="{switch_audio.U_DESC}">{switch_audio.DESC}</a></span><br>
      		</td>
        </tr>
        <!-- END switch_audio -->
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