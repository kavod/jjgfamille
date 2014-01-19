
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
				<td colspan="2"><center><b><u>{L_TITRE}</u></b><br><span class="genmed"></span></center><br><br></td>
			</tr>
			<tr valign="top">
				<td width="50%"><span class="genmed"><b><u>{PASS_BILLET} :</u></b><br>
					<!-- BEGIN switch_billets -->
						<a href="#" onclick="{switch_billets.ONCLICK}"><img src="{switch_billets.BILLET}" name="{switch_billets.ALT}" alt="{switch_billets.ALT}" border="0"/></a><br><a href="javascript:if (confirm('{switch_billets.L_CONFIRM_SUPP_BILLET}')) document.location='{switch_billets.U_SUPPRIMER}'">{switch_billets.L_SUPPRIMER}</a><br>
					<!-- END switch_billets -->
					</span>
				</td>
				<td> 
					<span class="genmed"><b><u>{L_TRACKLIST}</u></b></span><br>
				<table border="0" align="center" width="99%">
					<!-- BEGIN switch_songs -->
					<tr>
						<td><span class="genmed"><a href="{switch_songs.U_TITRE}">{switch_songs.L_TITRE}</a><br></span></td>
						<td><span class="genmed"><a href="{switch_songs.U_MONTER}">{switch_songs.L_MONTER}</a>&nbsp;<a href="{switch_songs.U_DESCENDRE}">{switch_songs.L_DESCENDRE}</a>&nbsp;<a href="javascript:if (confirm('{switch_songs.L_CONFIRM_SUPP_CHANSON}')) document.location='{switch_songs.U_SUPPRIMER}'">{switch_songs.L_SUPPRIMER}</a></span></td>
					</tr>
					<!-- END switch_songs -->
				</table>
				</td>
			</tr>
			<tr>
			<td colspan="2"><span class="genmed"><b><u>{MUSICIENS} :</u></b><br>{MUSICIANS}</span></td>
			</tr>
		</table>
		<table border="0" align="center" width="99%">
			<tr valign="top">
				<td><span class="genmed"><b><u>{L_DATE_CONCERTS} :</u></b><br>
					<!-- BEGIN switch_concerts -->
						<a href="{switch_concerts.U_TITRE}">{switch_concerts.L_TITRE}</a>{switch_concerts.PHOTO}{switch_concerts.RECIT}<br>
					<!-- END switch_concerts -->
					<br>
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
         <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <br><span class="genmed">
      <div align="left"><span class="genmed"><b><u>{switch_admin.MODIF_TOURNEE}</u></b></span></div><br><br>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="60%" align="center">	
  			<tr>	
				<td><span class="genmed"><b>{switch_admin.L_TITRE} :</b></span><br></td>
				<td><input type="text" name="title" size="40" value="{switch_admin.TITRE}" class="post"><br></td>
			</tr>
			  <tr> 
				<td><span class="genmed"><b>{switch_admin.L_ARTIST} :</b></span><br></td>
				<td><select name="artist_id">
				<!-- BEGIN artist -->
      				<option value="{switch_admin.artist.VALUE}" {switch_admin.artist.SELECTED}>{switch_admin.artist.INTITULE}</option>
				<!-- END artist -->
				</select><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.DESC}</b></span><br></td>
				<td><textarea name="comment" cols="40" rows="10" class="post">{switch_admin.COMMENT}</textarea><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_MUSICIANS}&nbsp;:</b></span><br></td>
				<td><textarea name="musicians" cols="40" rows="10" class="post">{switch_admin.MUSICIANS}</textarea><br></td>
  			</tr>
  			  <tr> 
				<td><span class="genmed"><b>{switch_admin.L_CATE}&nbsp;:</b></span></td>
				<td ><select name="cate_id" class="post">
				<!-- BEGIN options -->
					<option value="{switch_admin.options.VALUE}" {switch_admin.options.SELECTED}>{switch_admin.options.INTITULE}</option>
				<!-- END options -->
				</select></td>

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
		<div align="left"><span class="genmed"><b><u>{switch_admin.AJOUT_TRACK}</u></b></span></div><br /><br />
		<a name="add_song"></a>
		<form method="post" action="{switch_admin.U_FORM_TRACK}" enctype="multipart/form-data" name="form_add_song"> 		
			<table border="0" width="60%" align="center">	
				<tr> 
					<td><span class="genmed"><b>{switch_admin.L_TITRE} :</b></span><br></td>
					<!-- 22/12/2005 Boris : Ajout du popup de recherche de chansons -->
					<!-- <td><select name="song_id"> -->
					<!-- BEGIN song -->
					<!-- <option value="{switch_admin.song.VALUE}" {switch_admin.song.SELECTED}>{switch_admin.song.INTITULE}</option> -->
					<!-- END song -->
					<!-- </select><br></td> -->
					<td class="td2" align="center">
						<input type="text" name="song_name" class="post" value=" " size="50" onFocus="this.blur()" />
						<input type="button" name="search_song" value="{switch_admin.L_SEARCH_SONG}"  onClick="window.open('{switch_admin.U_SEARCH_SONG}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
						<input type="hidden" name="song_id" value="0" />
					</td>
				</tr>
				<tr> 
					<td colspan="2"><br>
					<center><input type="submit" value="{switch_admin.L_SUBMIT}"></center>
					</td>
				</tr>
			</table>
		</form>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- DEBUT importation -->
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
	<div align="left"><span class="genmed"><b><u>{switch_admin.L_IMPORT_TRACKLIST}</u></b></span></div><br />
	<form method="post" action="{switch_admin.U_IMPORT_TRACKLIST}">
		<center>
			<select name="album_id">
				<option value="0" SELECTED>--</option>
<!-- BEGIN album -->
				<option value="{switch_admin.album.ALBUM_ID}">{switch_admin.album.ALBUM_TITLE}</option>
<!-- END album -->
			</select>
			<input type="button" value="{switch_admin.L_IMPORT}" onClick="javascript:if(confirm('{switch_admin.L_CONFIRM_IMPORT}')) this.form.submit();" />
		</center>
	</form>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- FIN importation -->
         <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <br><span class="genmed">
      <div align="left"><span class="genmed"><b><u>{switch_admin.AJOUT_CONCERT}</u></b></span></div><br><br>
      <form method="post" action="{switch_admin.U_FORM1}" enctype="multipart/form-data"> 		
		<table border="0" width="60%" align="center">	
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.LIEU} :</b></span><br></td>
				<td><input type="text" name="lieu" size="40" class="post"></td>
  			</tr>
  			<tr> 
				<td valign="top" width="35%"><span class="genmed"><b>{switch_admin.L_DATE} :</b> (jj/mm/aaaa)</span><br></td>
				<td><input type="text" name="date" size="40" class="post"></td>
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
      <br><span class="genmed">
      <div align="left"><span class="genmed"><b><u>{switch_admin.AJOUT_BILLET}</u></b></span></div><br><br>
      <form method="post" action="{switch_admin.U_FORM2}" enctype="multipart/form-data"> 		
		<table border="0" width="60%" align="center">	
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_ILLU} :</b></span><br></td>
				<td><input type="FILE" name="userfile" size="30" class="post"></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_COMMENT}</b></span><br></td>
				<td><input type="text" name="comment" size="40" class="post"></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.L_TYPE} :</b></span><br></td>
				<td><select name="type">
      				<option value="Billet">Billet</option>
      				<option value="Affiche">Affiche</option>
      				<option value="Pass VIP">Pass VIP</option>
      				<option value="Programme">Programme</option>
				</select></td>
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