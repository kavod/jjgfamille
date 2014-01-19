
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
				<td><span class="genmed"><b>{L_TITLE}</b></span></td>
				<td><input type="text" name="title" class="post" value="{TITLE}" size="50" />
				<input type="hidden" name="confirm_doublon" value="" /></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_ARTIST}</b></span></td>
				<td><input type="text" name="artist" class="post" value="{ARTIST}" size="50" onFocus="this.blur()" /><input type="button" name="search_album" value="{L_SEARCH_ARTIST}"  onClick="window.open('{U_SEARCH_ARTIST}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
<!-- BEGIN switch_link_artist -->
				<br />
				<span class="gensmall">{switch_link_artist.L_SEE_ARTIST}</span>
<!-- END switch_link_artist -->
				</td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_TYPE}</b></span></td>
				<td><select name="type" class="post">
				<!-- BEGIN options_type -->
					<option value="{options_type.VALUE}"{options_type.SELECTED}>{options_type.INTITULE}</option>
				<!-- END options_type -->
				</select></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_DATE}</b></span></td>
				<td><input type="text" name="date" class="post" value="{DATE}" size="10" maxlength="10" /><br /><span class="gensmall">{L_EXPLAIN_DATE}</span></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_ASIN}</b></span></td>
				<td><input type="text" name="asin" class="post" value="{ASIN}" size="10" maxlength="10" /><br /><span class="gensmall">{L_EXPLAIN_ASIN}</span></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_THANKS}</b></span></td>
				<td><textarea name="thanks" class="post" cols="50" rows="5" />{THANKS}</textarea></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_COMMENTS}</b></span></td>
				<td><textarea name="comments" class="post" cols="50" rows="5" />{COMMENTS}</textarea></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_SUPPORTS}</b></span></td>
				<td>
					<table width="100%" border="0">
						<tr>
							<td width="50%"><input type="checkbox" class="post" name="cd" value="ok" {CHECKED_CD} /><span class="gensmall">{L_CD}</span></td>
							<td width="50%"><input type="checkbox" class="post" name="cd2t" value="ok" {CHECKED_CD_SINGLE} /><span class="gensmall">{L_CD_SINGLE}</span></td>
						</tr>
						<tr>
							<td width="50%"><input type="checkbox" class="post" name="k7" value="ok" {CHECKED_K7} /><span class="gensmall">{L_K7}</span></td>
							<td width="50%"><input type="checkbox" class="post" name="k72t" value="ok" {CHECKED_K7_SINGLE} /><span class="gensmall">{L_K7_SINGLE}</span></td>
						</tr>
						<tr>
							<td width="50%"><input type="checkbox" class="post" name="d33t" value="ok" {CHECKED_33T} /><span class="gensmall">{L_33T}</span></td>
							<td width="50%"><input type="checkbox" class="post" name="d45t" value="ok" {CHECKED_45T} /><span class="gensmall">{L_45T}</span></td>
						</tr>
						<tr>
							<td width="50%"><input type="checkbox" class="post" name="m45t" value="ok" {CHECKED_M45T} /><span class="gensmall">{L_M45T}</span></td>
							<td width="50%"><input type="checkbox" class="post" name="hc" value="ok" {CHECKED_HC} /><span class="gensmall">{L_HC}</span></td>
						</tr>
						<tr>
							<td width="50%"><input type="checkbox" class="post" name="vhs" value="ok" {CHECKED_VHS} /><span class="gensmall">{L_VHS}</span></td>
							<td width="50%"><input type="checkbox" class="post" name="dvd" value="ok" {CHECKED_DVD} /><span class="gensmall">{L_DVD}</span></td>
						</tr>
<!-- BEGIN switch_doublon -->
						<tr>
							<td width="100%" colspan="2"><span class="genmed"><b>{switch_doublon.L_VERIF}</b></span></td>
						</tr>
<!-- BEGIN doublon -->
						<tr>
							<td width="100%" colspan="2"><span class="genmed"><b><a href="{switch_doublon.doublon.U_ALBUM}" target="_blank">{switch_doublon.doublon.TITLE}</a></b> {switch_doublon.L_PAR} {switch_doublon.doublon.ARTIST} ({switch_doublon.doublon.DATE})</span></td>
						</tr>
<!-- END doublon -->
						<tr>
							<td width="100%" colspan="2"><input type="button" value="{switch_doublon.L_CONFIRM}" onClick="this.form.confirm_doublon.value='ok';this.form.submit();" /></td>
						</tr>
<!-- END switch_doublon -->
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">{DEFAULT_SONG}<input type="submit" value="{L_SUBMIT}" /></td>
			</tr>
		</table>
		</form><br />
<!-- BEGIN switch_edit -->
		<span class="genmed"><a href="{switch_edit.U_SUPP}">{switch_edit.L_SUPP_ALBUM}</a></span>
<!-- END switch_edit -->
	</td>
</tr>
		</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    
    
<!-- BEGIN switch_edit -->
<!-- liste des titres -->
  	<tr> 
	  	<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td class="catleft" height="28"><a name="songs"></a><span class="cattitle">{switch_edit.L_SONGS}</span></td>
		<td width="7" class="row2"></td>
		<td class="colonneDroite"></td>
	</tr>

	<tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row2">
			<table border="0" align="center">
<!-- BEGIN song -->
				<tr>
					<td><span class="genmed"><b><a href="{switch_edit.song.U_SONG}">{switch_edit.song.SONG}</a></b></span></td>
					<td><span class="genmed"><a href="{switch_edit.song.U_UP}">{switch_edit.L_UP}</a></span></td>
					<td><span class="genmed"><a href="{switch_edit.song.U_DOWN}">{switch_edit.L_DOWN}</a></span></td>
					<td><span class="genmed"><a href="{switch_edit.song.U_EDIT}">{switch_edit.L_EDIT}</a></span></td>
					<td><span class="genmed"><a href="{switch_edit.song.U_SUPP}">{switch_edit.L_SUPP}</a></span></td>
				</tr>
<!-- END song -->
			</table><br />
			<a name="add_song" />
			<form method="post" action="{switch_edit.U_ADD_SONG}" name="add_song">
				<span class="genmed"><b>{switch_edit.L_ADD_SONG}</b></span><br />
				<table border="0">
					<tr>
						<td valign="top" width="20%"><span class="genmed">{switch_edit.L_SONG}</span></td>
						<td valign="top" width="80%"><input type="text" name="song" class="post" value="{switch_edit.ASSO_SONG}" onFocus="this.blur()" /><input type="button" name="search_song" value="{switch_edit.L_SEARCH_SONG}"  onClick="window.open('{switch_edit.U_SEARCH_SONG}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
						<input type="hidden" name="song_id" value="{switch_edit.ASSO_SONG_ID}" /></td>
					</tr>
					<tr>
						<td valign="top" width="20%"><span class="genmed">{switch_edit.L_DUREE}</span></td>
						<td valign="top" width="80%"><input type="text" name="duree" class="post" maxlength="5" value="{switch_edit.ASSO_DUREE}"/></td>
					</tr>
					<tr>
						<td valign="top" width="20%"><span class="genmed">{switch_edit.L_EXPLAIN_COMMENT_SONG}</span></td>
						<td valign="top" width="80%"><textarea name="comment" class="post" cols="30" rows="5">{switch_edit.ASSO_COMMENT}</textarea></td>
					</tr>
					<tr>
						<td valign="top" colspan="2"><input type="submit" value="{switch_edit.L_ADD}" /></td>
					</tr>
				</table>
			</form>
	  	</td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
   </tr>
<!-- Jackettes -->
  	<tr> 
	  	<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td class="catleft" height="28"><span class="cattitle">{switch_edit.L_JACK}</span></td>
		<td width="7" class="row2"></td>
		<td class="colonneDroite"></td>
	</tr>	
	<tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row2">
			<table border="0" align="center">
				<tr>
<!-- BEGIN jack -->

					<td align="center"><span class="genmed"><a href="{switch_edit.jack.IMG}" target="_blank"><img 
					src="{switch_edit.jack.MINI}" title="{switch_edit.jack.COMMENT}" alt="{switch_edit.jack.COMMENT}" border="0" 
					/></a><br />
					<a href="{switch_edit.jack.U_UP}">&lt;-</a>
					<a href="{switch_edit.jack.U_SUPP}">{switch_edit.jack.L_SUPP}</a>
					<a href="{switch_edit.jack.U_DOWN}">-&gt;</a>
					</span></td>
<!-- END jack -->
				</tr>
			</table><br />
			<form method="post" action="{switch_edit.U_ADD_JACK}" enctype="multipart/form-data">
				<span class="genmed"><b>{switch_edit.L_ADD_JACK}</b></span><br />
				<table border="0">
					<tr>
						<td valign="top"><span class="genmed">{switch_edit.L_EMPLACEMENT}</span></td>
						<td valign="top"><input type="file" name="jack" class="post" /></td>
					</tr>
					<tr>
						<td valign="top"><span class="genmed">{switch_edit.L_DESCRIPTION}</span></td>
						<td valign="top"><textarea name="comment" class="post"></textarea></td>
					</tr>
					<tr>
						<td valign="top" colspan="2"><input type="submit" value="{switch_edit.L_ADD}" /></td>
					</tr>
				</table>
			</form>
	  	</td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
   </tr>
<!-- END switch_edit -->

    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}" class="cattitle">{L_RETOUR}</a></span></center></td>
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