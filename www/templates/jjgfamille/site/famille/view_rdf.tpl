
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="genmed"><b>{RESPONSABLES}</b>
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
	<td class="catLeft" height="28"><center><span class="cattitle">{L_TITLE}&nbsp;<a href="{U_MODIF}">{MODIF}</a></span></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/><span class="cattitle"><u>{TITLE}</u></span><br/>
	<table border="0" width="99%" align="center">
	<tr><td width="50%">
	<table border="0" width="100%">
			<tr valign="top">	
				<td width="20%"><span class="genmed"><b>{LIEU}:</b></span></td>
				<td><span class="genmed">{VAL_LIEU}</span></td>
			</tr>	
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DATE}:</b></span></td>
				<td><span class="genmed">{VAL_DATE}</span></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{HEURE}:</b></span></td>
				<td><span class="genmed">{VAL_HEURE}</span></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DESCRIPTION}:</b></span></td>
				<td><span class="genmed">{VAL_DESC}</span></td>
  			</tr>
 
			</table>
	</td>
	<td align="center" valign="middle"><img src="{IMG}" alt="{ALT}" title="{ALT}"/></td></tr>
	</table>
			<br/>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- BEGIN switch -->
   <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      		<table width="99%" border="0" align="center">
      			
      			<tr valign="top">
      				<td width="50%">
      					<span class="cattitle">
      					{switch.IMG_RECIT}&nbsp;<b><u>{switch.RECITS}</u></b></span><br>
      					<span class="genmed">
      					{switch.NO_RECIT}
      					<!-- BEGIN recits -->
      					<a href="{switch.recits.U_TITRE}">{switch.recits.L_TITRE}</a>&nbsp;{switch.recits.PAR}&nbsp;<a href="{switch.recits.U_USER}">{switch.recits.L_USER}</a><br>  					
      					<!-- END recits -->
      					<br>
      					<b>{switch.IS_YOU_TO_PLAY}</b><br><a href="{switch.U_ADD_RECITS}">{switch.L_ADD_RECITS}</a>
      					<br><br>
      					</span>				
      				</td>
      				<td width="50%">
      					<span class="cattitle">
      					{switch.IMG_PHOTO}&nbsp;<b><u>{switch.PHOTOS}</u></b></span><br>
      					<span class="genmed">
      					{switch.NO_PHOTO}
      					<!-- BEGIN photos -->
      					<a href="{switch.photos.U_PHOTO}">{switch.photos.L_PHOTO}</a><br>  					
      					<!-- END photos -->
      					<br>
      					<b>{switch.IS_YOU_TO_PLAY}</b><br><a href="{switch.U_ADD_PHOTOS}">{switch.L_ADD_PHOTOS}</a>
      					<br><br>
      					</span>				
      				</td>
      			</tr>
      		</table>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr> 
    <!-- END switch -->
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{STATS}&nbsp;&nbsp;&nbsp;&nbsp;{INSCRIRE}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2">
	<table align="center" width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td><span class="genmed">{ORG_BY}&nbsp;<a href="{U_ORG}"><b>{L_ORG}</b></a></span></td>
	<td><span class="genmed">{switch_inscrits.DATE}</span></td>
	</tr>
	<!-- BEGIN switch_inscrits -->
	<tr>
	<td><span class="genmed">
	<!-- BEGIN registered -->
	<a href="{switch_inscrits.registered.U_USER}">
	<!-- END registered -->
	<b>{switch_inscrits.L_USER}</b>
	<!-- BEGIN registered -->
	</a>
	<!-- END registered -->
	</span></td>
	<td><span class="genmed">{switch_inscrits.DATE}&nbsp;&nbsp;{switch_inscrits.DESINSCRIT}</span></td>
	</tr>
	<!-- END switch_inscrits -->
	</table>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr> 
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/><br/></td>
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
      <td  height="7" class="row2"></td>
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