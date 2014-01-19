
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
	<td class="catleft" height="28"><span class="cattitle">{L_ACTION}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2">
		<table border="0" align="left">
		<tr><td valign="top"><form method="post" action="{U_ACTION}" name="formulaire" enctype="multipart/form-data">
		<table border="0">
			<tr>
				<td><span class="genmed"><b>{L_DUREE}</b></span></td>
				<td><input type="text" name="duree" class="post" value="{DUREE}" size="7" maxlength="5" /></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_COMMENTS}</b></span></td>
				<td><textarea name="comment" class="post" cols="50" rows="5" />{COMMENTS}</textarea></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="{L_SUBMIT}" /></td>
			</tr>
		</table>
		</form><br />
		<span class="genmed"><a href="javascript:if(confirm('{L_CONFIRM_SUPP}')) document.location='{U_SUPP}'">{L_SUPP}</a></span>
	</td>
</tr>
		</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- Real -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{L_EXTRAIT}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2">
		<table border="0" align="left">
		<tr><td valign="top"><form method="post" action="{U_ADD_REAL}" name="formulaire_rm" enctype="multipart/form-data">
		<table border="0">
			<tr>
				<td><span class="genmed"><b>{L_FICHIER_REAL}</b></span></td>
				<td><span class="genmed"><input type="file" name="real" class="post" size="50" />
				<input type="submit" value="{L_SUBMIT}" /><br />
				<a href="{U_REAL}" target="_blank">{L_REAL}</a> &nbsp; <a href="javascript:if (confirm('{L_CONFIRM_SUPP_REAL}')) document.location='{U_SUPP_REAL}'">{L_SUPP_REAL}</a></span></td>
			</tr>
    		</table>
		</form>
	  </td>
	 </tr>
	</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- Guitar Pro -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{L_GUITARPRO}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2">
		<table border="0" align="left">
		<tr><td valign="top"><form method="post" action="{U_ADD_GP}" name="formulaire_gp" enctype="multipart/form-data">
		<table border="0">
			<tr>
				<td><span class="genmed"><b>{L_FICHIER_GP}</b></span></td>
				<td><span class="genmed"><input type="file" name="gp" class="post" size="50" />
				<input type="submit" value="{L_SUBMIT}" /><br />
				<a href="{U_GP}" target="_blank">{L_GP}</a> &nbsp; <a href="javascript:if (confirm('{L_CONFIRM_SUPP_GP}')) document.location='{U_SUPP_GP}'">{L_SUPP_GP}</a></span></td>
			</tr>
    		</table>
		</form>
	  </td>
	 </tr>
	</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- Midi -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{L_MIDI}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2">
		<table border="0" align="left">
		<tr><td valign="top"><form method="post" action="{U_ADD_MIDI}" name="formulaire_midi" enctype="multipart/form-data">
		<table border="0">
			<tr>
				<td><span class="genmed"><b>{L_FICHIER_MIDI}</b></span></td>
				<td><span class="genmed"><input type="file" name="midi" class="post" size="50" />
				<input type="submit" value="{L_SUBMIT}" /><br />
				<a href="{U_MIDI}" target="_blank">{L_LISTEN_MIDI}</a> &nbsp; <a href="javascript:if (confirm('{L_CONFIRM_SUPP_MIDI}')) document.location='{U_SUPP_MIDI}'">{L_SUPP_MIDI}</a></span></td>
			</tr>
    		</table>
		</form>
	  </td>
	 </tr>
	</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- Partitions -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{L_TAB}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2">
		<table border="0" align="left">
		<tr><td valign="top"><form method="post" action="{U_ADD_TAB}" name="formulaire_part" enctype="multipart/form-data">
		<table border="0">
			<tr>
				<td width="30%">
					<span class="genmed"><b>{L_TYPE_TAB}</b></span>
				</td>
				<td width="70%">
					<select name="part_type" class="post">
<!-- BEGIN tab -->
						<option value="{tab.VALUE}"{tab.CHECKED}>{tab.INTITULE}</option>
<!-- END tab -->
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<span class="genmed"><b>{L_PART_AUTHOR}</b></span>
				</td>
				<td>
					<input type="text" name="part_author" class="post" value="{PART_AUTHOR}" />
				</td>
			</tr>
			<tr>
				<td>
					<span class="genmed"><b>{L_PART_ADRESS}</b></span>
				</td>
				<td>
					<input type="text" name="part_adress" class="post" value="{PART_ADRESS}" />
				</td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{L_FICHIER_TAB}</b></span></td>
				<td><span class="genmed"><input type="file" name="tab" class="post" size="50" />
				<input type="submit" value="{L_SUBMIT}" /><br />
				<a href="{U_TAB}" target="_blank">{L_VIEW_TAB}</a> &nbsp; <a href="javascript:if (confirm('{L_CONFIRM_SUPP_TAB}')) document.location='{U_SUPP_TAB}'">{L_SUPP_TAB}</a></span></td>
			</tr>
    		</table>
		</form>
	  </td>
	 </tr>
	</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><span class="cattitle"><a href="{U_RETOUR_ALBUM}" class="cattitle">{L_RETOUR_ALBUM}</a> &nbsp; <a href="{U_RETOUR_SONG}" class="cattitle">{L_RETOUR_SONG}</a></span></center></td>
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