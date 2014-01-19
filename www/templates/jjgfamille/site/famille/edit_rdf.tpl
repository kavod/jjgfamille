
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
	<td class="catLeft" height="28"><center><span class="cattitle"><a href="{U_TITLE}">{L_TITLE}</a></span></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/><span class="cattitle"><u>{TITLE}</u></span><br/>
	<form method="post" action="{U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="80%">
			<tr valign="top">	
				<td width="30%"><span class="genmed"><b>{LIEU}:</b></span></td>
				<td><input type="text" name="lieu" size="50" class="post" value="{VAL_LIEU}"></td>
			</tr>	
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DATE}:</b></span><br/><span class="gensmall">(jj/mm/aaaa)</span></td>
				<td><input type="text" name="date" size="50" class="post" value="{VAL_DATE}"><br></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{HEURE}:</b></span><br/><span class="gensmall">(hh:mm)</span></td>
				<td><input type="text" name="heure" size="50" class="post" value="{VAL_HEURE}"></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DESCRIPTION}:</b></span></td>
				<td><textarea name="description" cols="50" rows="10" class="post">{VAL_DESC}</textarea></td>
  			</tr>
  			<tr> 
				<td>&nbsp;</td><td><br /><input type="submit" value="{L_SUBMIT}"></td>
			</tr>
			</table>
			</form>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/><span class="cattitle"><u>{SENDMAIL}</u></span><br /><span class="genmed">{I_WANT}</span><br/>
	<form method="post" action="{U_FORM_MAIL}"> 		
		<table border="0" width="80%">
  			<tr valign="top"> 
				<td width="30%"><span class="genmed"><b>{MESSAGE} :</b></span></td>
				<td><textarea name="message" cols="50" rows="10" class="post"></textarea></td>
  			</tr>
  			<tr> 
				<td>&nbsp;</td><td><br/><input type="submit" value="{L_SUBMIT}"></td>
			</tr>
			</table>
			</form>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/><span class="cattitle"><u>{L_SEND_INVIT}</u></span><br /><span class="genmed">{L_SEND_INVIT_EXPL}</span><br/>
	<form method="post" action="{U_FORM_INVIT}"> 		
		<table border="0" width="80%">
  			<tr valign="top"> 
				<td width="30%"><span class="genmed"><b>{L_CHOOSE_GROUP} :</b></span></td>
				<td>
					<select name="group_id">
					<!-- BEGIN group -->
						<option value="{group.GROUP_ID}">{group.GROUP_NAME}</option>
					<!-- END group -->
					</select>
				</td>
  			</tr>
  			<tr valign="top"> 
				<td width="30%"><span class="genmed"><b>{L_INVIT} :</b><br /><small><i>{L_INVIT_EXPL}</i></small></span></td>
				<td><textarea name="message" cols="50" rows="10" class="post">{INVIT}</textarea></td>
  			</tr>
  			<tr> 
				<td>&nbsp;</td><td><br/><input type="submit" value="{L_SUBMIT}"></td>
			</tr>
		</table>
	</form>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{STATS}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/>
	<table align="center" width="99%" border="0" cellspacing="0" cellpadding="0">
	<!-- BEGIN switch_inscrits -->
	<tr>
	<td><span class="genmed"><a href="{switch_inscrits.U_USER}"><b>{switch_inscrits.L_USER}</b></a></span></td>
	<td><span class="genmed">{switch_inscrits.DATE}</span></td>
	</tr>
	<!-- END switch_inscrits -->
	</table>
	<br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle"><center>[&nbsp;<a href="javascript:if (confirm('{L_CONFIRM_SUPP}')) document.location='{U_SUPP}'">{L_SUPP}</a>&nbsp;]</center></span></td>
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