
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
  <script type="text/javascript">
  <!--
  function select_lang(element)
  {
  	if (element.options[element.selectedIndex].value==0)
	{
		document.getElementById("another_lang").style.display = '';
	} else
	{
		document.getElementById("another_lang").style.display = 'none';
	}
	return true;
  }
  
  function deasso_artist(job,artist_id)
  {
  	formulaire = document.getElementById("formulaire");
  	formulaire.action='{U_DEASSO}&mode=supp_' + job + '&artist_id=' + artist_id;
	formulaire.submit();
  }
  -->
  </script>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2">
		<table border="0" align="left">
		<tr><td valign="top"><form method="post" action="{U_ACTION}" name="formulaire" id="formulaire" enctype="multipart/form-data">
		<table border="0">
			<tr>
				<td><span class="genmed"><b>{L_TITLE}</b></span></td>
				<td><input type="text" name="title" class="post" value="{TITLE}" size="50" />
				<input type="hidden" name="confirm_doublon" value="" /></td>
			</tr>
<!-- DEBUT REPRISES -->
			<tr>
				<td valign="top"><span class="genmed"><b>{L_REPRISE}</b></span></td>
				<td valign="top"><span class="genmed"><input type="radio" name="is_reprise" class="post" value="Y" onClick="document.getElementById('champ_reprise').style.display='';" {CHECKED_REPRISE} > {L_OUI}<br />
				<input type="radio" name="is_reprise" class="post" value="N" onClick="document.getElementById('champ_reprise').style.display='none';" {CHECKED_ORIGINAL} > {L_NON}
				<input type="hidden" name="reprise_id" value="{REPRISE_ID}" />
				</span></td>
			</tr>
			<tr id="champ_reprise" style="display:{HIDDEN_REPRISE}">
				<td valign="top"><span class="genmed"><b>{L_ORIGINAL}<br />{L_LANG_REPRISE}</b></span></td>
				<td valign="top"><span class="genmed">
				<input type="text" name="reprise_name" class="post" value="{REPRISE_NAME}" size="50" onFocus="this.blur()" />
				<input type="button" name="search_song" value="{L_SEARCH_SONG}"  onClick="window.open('{U_SEARCH_SONG}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /><br />
				
				<select name="lang_id" class="post" onChange="select_lang(this)">
<!-- BEGIN lang -->
					<option value="{lang.LANG_ID}" {lang.SELECTED}>{lang.LANGUAGE}</option>
<!-- END lang -->
				</select><input type="text" name="another_lang" id="another_lang" class="post" style="display:{HIDDEN_ANOTHER_LANG}" value="{ANOTHER_LANG}" /></span></td>
			</tr>
<!-- FIN REPRISES -->
<!-- BEBUT MEDLEY -->
			<tr>
				<td valign="top" colspan="2"><span class="genmed"><b>{L_MEDLEY}</b><br /><small>{L_MEDLEY_EXPLAIN}</small></span></td>
			</tr>
			<tr>
				<td valign="top"></td>
				<td valign="top"><span class="genmed">
					<input type="radio" name="medley" class="post" value="Y" {CHECKED_MEDLEY} > {L_OUI}<br />
					<input type="radio" name="medley" class="post" value="N" {CHECKED_NO_MEDLEY} > {L_NON}
				</span></td>
			</tr>
<!-- FIN MEDLEY -->
<!-- DEBUT ARTISTES -->
			<tr>
				<td valign="top"><span class="genmed"><b>{L_SINGERS}</b></span></td>
				<td><span class="genmed">
				<input type="hidden" name="list_singer" value="{LIST_SINGER}" />
<!-- BEGIN singer -->
					<a href="{singer.U_ARTIST}">{singer.ARTIST}</a> <a href="javascript:deasso_artist('{singer.JOB}','{singer.ARTIST_ID}')">{L_DEASSO}</a><br />
<!-- END singer -->
					<b>{L_ADD_SINGER}</b><br /><input type="text" name="singer" class="post" value="{SINGER}" size="25" onFocus="this.blur()" /><input type="button" name="search_singer" value="{L_SEARCH_ARTIST}"  onClick="window.open('{U_SEARCH_SINGER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /><br />
					<input type="button" value="{L_ADD}" onClick="this.form.action='{U_ADD_SINGER}';this.form.submit()" />
				</span></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_AUTHORS}</b></span></td>
				<td><span class="genmed">
				<input type="hidden" name="list_author" value="{LIST_AUTHOR}" />
<!-- BEGIN author -->
					<a href="{author.U_ARTIST}">{author.ARTIST}</a> <a href="javascript:deasso_artist('{author.JOB}','{author.ARTIST_ID}')">{L_DEASSO}</a><br />
<!-- END author -->
					<b>{L_ADD_AUTHOR}</b><br /><input type="text" name="author" class="post" value="{AUTHOR}" size="25" onFocus="this.blur()" /><input type="button" name="search_author" value="{L_SEARCH_ARTIST}"  onClick="window.open('{U_SEARCH_AUTHOR}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /><br />
					<input type="button" value="{L_ADD}" onClick="this.form.action='{U_ADD_AUTHOR}';this.form.submit()" />
				</span></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_COMPOSERS}</b></span></td>
				<td><span class="genmed">
				<input type="hidden" name="list_composer" value="{LIST_COMPOSER}" />
<!-- BEGIN composer -->
					<a href="{composer.U_ARTIST}">{composer.ARTIST}</a> <a href="javascript:deasso_artist('{composer.JOB}','{composer.ARTIST_ID}')">{L_DEASSO}</a><br />
<!-- END composer -->
					<b>{L_ADD_COMPOSER}</b><br /><input type="text" name="composer" class="post" value="{COMPOSER}" size="25" onFocus="this.blur()" /><input type="button" name="search_composer" value="{L_SEARCH_ARTIST}"  onClick="window.open('{U_SEARCH_COMPOSER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /><br />
					<input type="button" value="{L_ADD}" onClick="this.form.action='{U_ADD_COMPOSER}';this.form.submit()" />
				</span></td>
			</tr>
<!-- FIN ARTISTES -->
			<tr>
				<td valign="top"><span class="genmed"><b>{L_LYRICS}</b></span></td>
				<td><textarea name="lyrics" class="post" cols="50" rows="5" />{LYRICS}</textarea></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_MUSICIANS}</b></span></td>
				<td><textarea name="musicians" class="post" cols="50" rows="5" />{MUSICIANS}</textarea></td>
			</tr>
			<tr>
				<td valign="top"><span class="genmed"><b>{L_COMMENTS}</b></span></td>
				<td><textarea name="comments" class="post" cols="50" rows="5" />{COMMENTS}</textarea></td>
			</tr>
<!-- BEGIN switch_doublon -->
			<tr>
				<td width="100%" colspan="2"><span class="genmed"><b>{switch_doublon.L_VERIF}</b></span></td>
			</tr>
<!-- BEGIN doublon -->
			<tr>
				<td width="100%" colspan="2"><span class="genmed"><b><a href="{switch_doublon.doublon.U_SONG}" target="_blank">{switch_doublon.doublon.TITLE}</a></b> {switch_doublon.L_PAR} {switch_doublon.doublon.ARTIST}</span></td>
			</tr>
<!-- END doublon -->
			<tr>
				<td width="100%" colspan="2"><input type="button" value="{switch_doublon.L_CONFIRM}" onClick="this.form.confirm_doublon.value='ok';this.form.submit();" /></td>
			</tr>
<!-- END switch_doublon -->
			<tr>
				<td colspan="2"><input type="submit" value="{L_SUBMIT}" /></td>
			</tr>
		</table>
		</form><br />
<!-- BEGIN switch_edit -->
<!-- BEGIN is_medley -->
		<a name="medley"></a>
		<form method="post" action="{switch_edit.is_medley.U_ACTION}" name="formulaire_medley">
		<span class="cattitle">{switch_edit.is_medley.L_SONGS_OF_MEDLEY}</span><br />
		<span class="genmed"><ul>
<!-- BEGIN medley -->
			<li><a href="{switch_edit.is_medley.medley.U_SONG}">{switch_edit.is_medley.medley.SONG_TITLE}</a> [ <a href="{switch_edit.is_medley.medley.U_SUPP_SONG}">{L_DEASSO}</a> ] 
			<a href="{switch_edit.is_medley.medley.U_UP}">{L_UP}</a>
			<a href="{switch_edit.is_medley.medley.U_DOWN}">{L_DOWN}</a></li>
<!-- END medley -->
		</ul><br />
		<b>{switch_edit.is_medley.L_ADD_SONG_MEDLEY}</b><br />
		<input type="hidden" name="medley_id" />
		<input type="text" name="medley_name" class="post" size="50" onFocus="this.blur()" />
		<input type="button" name="search_medley" value="{L_SEARCH_SONG}"  onClick="window.open('{switch_edit.is_medley.U_SEARCH_MEDLEY}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
		<input type="submit" value="{L_ADD}" /><br /><br />
		</form>
<!-- END is_medley -->
		<span class="genmed"><a href="javascript:if (confirm('{L_CONFIRM_SUPP}')) document.location='{U_SUPP}'">{L_SUPP}</a></span>
<!-- END switch_edit -->
	</td>
</tr>
		</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- BEGIN switch_stat -->
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{switch_stat.L_STAT}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2"><p><span class="genmed"><b>{switch_stat.L_ALBUMS}</b><br />
	<!-- BEGIN album -->
	&nbsp;&nbsp;&nbsp;<a href="{switch_stat.album.U_ALBUM}">{switch_stat.album.TITRE}</a><br />
	<!-- END album --><br /><br /><br /></span></p>
	<p><span class="genmed">
	<b><a href="{switch_stat.U_CREATE_ALBUM}">{switch_stat.L_CREATE_ALBUM}</a><br />
	{switch_stat.L_OR}<br />
	{switch_stat.L_ASSO_ALBUM}<br />
	<form method="POST" action="{switch_stat.U_ASSO_ALBUM}">
		<select name="album_id">
<!-- BEGIN albums -->
			<option value="{switch_stat.albums.VALUE}">{switch_stat.albums.NAME}</option>
<!-- END albums -->
		</select>
		<input type="submit" value="{L_SUBMIT}" />
		<input type="hidden" name="song_id" value="{switch_stat.SONG_ID}" />
	</form>
	</span></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- END switch_stat -->
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