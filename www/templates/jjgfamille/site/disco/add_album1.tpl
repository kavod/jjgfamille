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
				<td colspan="2"><input type="submit" value="{L_SUBMIT}" /></td>
			</tr>
		</table>
		</form><br />
	</td>
</tr>
		</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
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