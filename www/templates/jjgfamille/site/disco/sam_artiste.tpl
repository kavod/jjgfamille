
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
		<table border="0" align="center">
		<tr><td valign="top"><form method="post" action="{U_ACTION}" enctype="multipart/form-data">
		<table border="0">
			<tr>
				<td><span class="genmed"><b>{L_NOM}</b></span></td>
				<td><input type="text" name="nom" class="post" value="{NOM}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{L_IS_BAND}</b></span></td>
				<td><span class="genmed"><input type="radio" name="band" value="N"{CHECKED_ARTIST} /> {L_ARTISTE} <br /> 
					<input type="radio" name="band" value="Y"{CHECKED_BAND} /> {L_BAND}</span></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{L_PHOTO}</b></span></td>
				<td><input type="file" name="photo" class="post" /></td>
			</tr>
			<!-- BEGIN switch_photo -->
			<tr>
				<td><span class="genmed"><b>{switch_photo.L_CURRENT_PHOTO}</b></span></td>
				<td><span class="genmed"><img src="{switch_photo.IMG_PHOTO}" border="0" title="{switch_photo.IMG_ALT}" alt="{switch_photo.IMG_ALT}" /><a href="javascript:if(confirm('{switch_photo.L_SUPP_PHOTO_CONFIRM}')) document.location='{switch_photo.U_SUPP_ILLU}'">{switch_photo.L_SUPP_ILLU}</a></span></td>
			</tr>
			<!-- END switch_photo -->
			<tr>
				<td colspan="2"><input type="submit" value="{L_SUBMIT}" /></td>
			</tr>
		</table>
<!-- BEGIN switch_stat -->
		<br />
		<span class="genmed"><a href="{switch_stat.U_SUPP_ARTIST}">{switch_stat.L_SUPP_ARTIST}</a></span>
<!-- END switch_stat -->
		</form>
		</td>
		<td valign="top">
<!-- BEGIN switch_stat -->
		<span class="genmed"><b>{switch_stat.L_BAND_ACTION}</b><br />
<!-- BEGIN band -->
&nbsp;&nbsp;<a href="{switch_stat.band.U_BAND}"><b>{switch_stat.band.L_BAND}</b></a> <a href="{switch_stat.band.U_BAND_DEASSO}">{L_DEASSO}</a><br />
<!-- END band -->
<!-- BEGIN no_band -->
&nbsp;&nbsp;<b>{switch_stat.no_band.L_BAND}</b><br />
<!-- END no_band -->
<form method="post" action="{switch_stat.U_BAND_ACTION}" name="search_band">
<br />{switch_stat.L_ASSOCIER}<br /><input type="text" name="asso" class="post" />
<input type="button" name="search_artiste" value="{switch_stat.L_SEARCH_ARTIST}"  onClick="window.open('{switch_stat.U_SEARCH_ARTIST}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
<input type="submit" name="soumettre" value="{switch_stat.L_SUBMIT}">
</form>
<!-- END switch_stat -->
</span>
		</td></tr>
		</table>
	</td>
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
	<td class="row2"><span class="genmed"><b>{switch_stat.L_ALBUMS}</b><br />
	<!-- BEGIN album -->
	&nbsp;&nbsp;&nbsp;{switch_stat.album.TITRE}<br />
	<!-- END album --><br /><br />
	<b>{switch_stat.L_SONGS}</b><br />
	<!-- BEGIN song -->
	&nbsp;&nbsp;&nbsp;{switch_stat.song.TITRE}<br />
	<!-- END song --></td>
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