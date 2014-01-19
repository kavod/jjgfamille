
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{L_VIDEOS}</th>
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
	<td class="row2">
	<br />
	<table boder="0" width="99%">
		<tr>
			<td align="left">
				<span class="cattitle">
					<u>{L_VIDEO_CATEGORIES_LIST}&nbsp;:</u>
				</span>
			</td>
			<td>
				<span class="gen">
					<b>{L_BEST_POSTERS}</b><br />
					<ul>
<!-- BEGIN posters -->
					<li><a href="{posters.U_USER}">{posters.USERNAME}</a> : {posters.NB_VIDEOS}</li>
<!-- END posters -->
				</ul></span>
			</td>
		</tr>
	</table>
	<span class="genmed">
	<table border="0" width="99%">
		<!-- BEGIN ligne -->
			<tr>
		<!-- BEGIN colonne -->
				<td align="center" width="33%">
					<a href="{ligne.colonne.U_TITLE}">
						<span class="cattitle">{ligne.colonne.L_TITLE}</span><br />
						<span class="medgen">{ligne.colonne.DATE}</span><br />
						<img src="{ligne.colonne.IMG}" border="0" />
					</a>
				</td>
		<!-- END colonne -->
			</tr>
		<!-- END ligne -->
	</table>
	<b>{L_NO_VIDEO}</b><br />
	</span>
	<br><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2">
      <form method="post" action="{U_ADD_VIDEO}" enctype="multipart/form-data"> 		
		<table border="0">
			<tr>	
				<td colspan="2"><span class="genmed"><b>{L_IS_YOU_TO_PLAY}</b><br>{L_AJOUT_VIDEO}</span><br></td>
			</tr>
			<tr>	
				<td width="30%"><span class="genmed">{L_TITLE} :</span></td>
				<td><input type="text" name="title" size="40" class="post" value="{VIDEO_TITLE}" /></td>
			</tr>
			<tr>
				<td><span class="genmed">{L_CATEGORY}</span></td>
				<td><select name="cate_id">
<!-- BEGIN cate -->
					<option value="{cate.CATE_ID}"{cate.SELECTED}>{cate.CATE_NAME}</option>
<!-- END cate -->
				</select></td>
			</tr>
			<tr>
				<td><span class="genmed">{L_SOURCE}</span></td>
				<td><select name="source_id">
<!-- BEGIN sources -->
					<option value="{sources.SOURCE_ID}"{sources.SELECTED}>{sources.SOURCE_NAME}</option>
<!-- END sources -->
				</select></td>
			</tr>
			<tr>	
				<td><span class="genmed">{L_CODE} :</span><br></td>
				<td><input type="text" name="code" size="20" class="post" value="{CODE}"  /> <a href="#" onClick="window.open('../medias/help_video.htm','jjgfamille_help_video','directories=no,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes,width=650,height=600')">{L_NEED_HELP}</a></td>
			</tr>
			<tr>	
				<td><span class="genmed">{L_DESCRIPTION}</span><br></td>
				<td><textarea name="description"  cols="37" rows="5" class="post">{VIDEO_DESCRIPTION}</textarea></td>
			</tr>
			<tr> 
				<td colspan="2">
				<input type="submit" value="{L_SUBMIT}">
				</form>
				</td>
			</tr>
	</table>
<!-- BEGIN admin -->
	<br /><br />
	<span class="cattitle"><u>{admin.L_DISABLED_VIDEOS_LIST}</u></span><br />
	<span class="genmed">
<!-- BEGIN disabled -->
	<a href="{admin.disabled.U_VIDEO}"><b>{admin.disabled.TITLE}</b> - {admin.disabled.DATE}<br />
	<img src="{admin.disabled.IMG}" /></a><br /><br />
<!-- END disabled -->
	</span>
	<br /><br />
	<span class="cattitle">{admin.L_ADD_CATE}</span><br />
	<form method="post" action="{admin.U_ADD_CATE}" enctype="multipart/form-data">
	<table border="0">
		<tr>
			<td width="30%"><span class="genmed">{L_TITLE} :</span></td>
			<td><input type="text" name="title" size="40" class="post" value="{admin.CATE_TITLE}"></td>
		</tr>
		<tr>
			<td width="30%" valign="top"><span class="genmed">{admin.L_DESCRIPTION}</span></td>
			<td><textarea name="description" cols="37" rows="5" class="post">{admin.CATE_DESCRIPTION}</textarea></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="{L_SUBMIT}" /></td>
		</tr>
	</table>
	</form>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
<!-- END admin -->
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