
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
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="catLeft" height="28"><span class="genmed"><b>{RESPONSABLES}</b>
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
	<td colspan="2" class="row2">
	<br><span class="cattitle"><u>{AJOUT_MORE}</u></span><br><br>
	<form action="{U_FORM}" method="post" enctype="multipart/form-data">
	<table width="99%" align="center" border=0>
	<tr><td><span class="genmed"><b>{L_TITLE}&nbsp;:</b></span></td><td><input type="text" name="title" class="post" size="30"/></td></tr>
	<tr><td><span class="genmed"><b>{L_DESC}</b></span></td><td><textarea class="post" name="description" cols="30" rows="5"></textarea></td></tr>
	<tr><td><span class="genmed"><b>{L_CATE}</b></span></td><td>
	<select name="cate_id">
	<option value="" selected>{SELECT_CATE}</option>
	<!-- BEGIN switch_options -->
	<option value="{switch_options.VALUE}">{switch_options.INTITULE}</option>
	<!-- END switch_options -->
	</select>
	</td></tr>
	<tr><td><span class="genmed"><b>{L_FILE}&nbsp;:</b></span></td><td><input type="file" name="userfile" class="post" size="30"/></td></tr>
	<tr><td colspan="2"><br><br><input type="submit" value="{L_SUBMIT}"/></td></tr>
	</table>
	</form>
	<br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
        </tr>
       <tr>
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="catLeft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="2" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>

    <tr>
      <td colspan="2" class="ligneBas"></td>
    </tr>
  </tbody>
</table>
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->