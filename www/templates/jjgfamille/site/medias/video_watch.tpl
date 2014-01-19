
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
	<span class="cattitle">
		<u>{TITLE}</u>
	</span><br /><br />
	<span class="genmed">
	<table border="0" width="99%">
		<tr>
			<td align="left" valign="top">
				<span class="genmed">
					<b>{L_DATE_ADDED}</b> {DATE_ADDED}<br />
					<b>{L_FOUND_BY}</b> <a href="{U_USER}">{USERNAME}</a><br />
					<b>{L_DESCRIPTION}</b> {DESCRIPTION}
				</span>
			</td>
			<td align="center">
				{HTML_CODE}
			</td>
		</tr>
	</table>
	</span>
	<br><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
<!-- BEGIN admin -->
     <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2">
      <form method="post" action="{admin.U_EDIT_VIDEO}" enctype="multipart/form-data"> 		
		<table border="0">
			<tr>	
				<td colspan="2"><span class="cattitle">{admin.L_EDIT_VIDEO}</span><br /></td>
			</tr>
			<tr>	
				<td width="30%"><span class="genmed">{admin.L_TITLE} :</span></td>
				<td><input type="text" name="title" size="40" class="post" value="{admin.VIDEO_TITLE}" /></td>
			</tr>
			<tr>
				<td><span class="genmed">{admin.L_CATEGORY}</span></td>
				<td><select name="cate_id">
<!-- BEGIN cate -->
					<option value="{admin.cate.CATE_ID}"{admin.cate.SELECTED}>{admin.cate.CATE_NAME}</option>
<!-- END cate -->
				</select></td>
			</tr>
			<tr>
				<td><span class="genmed">{admin.L_SOURCE}</span></td>
				<td><select name="source_id">
<!-- BEGIN sources -->
					<option value="{admin.sources.SOURCE_ID}"{admin.sources.SELECTED}>{admin.sources.SOURCE_NAME}</option>
<!-- END sources -->
				</select></td>
			</tr>
			<tr>	
				<td><span class="genmed">{admin.L_CODE} :</span><br></td>
				<td><input type="text" name="code" size="40" class="post" value="{admin.CODE}"  /></td>
			</tr>
			<tr>	
				<td><span class="genmed">{L_DESCRIPTION}</span><br></td>
				<td><textarea name="description"  cols="37" rows="5" class="post">{admin.VIDEO_DESCRIPTION}</textarea></td>
			</tr>
			<tr>	
				<td>
					<span class="genmed">
						{admin.L_ENABLED}<br />
						{admin.L_DISABLED}
					</span>
				</td>
				<td>
					<input type="radio" name="enabled" value="Y" {admin.ENABLED_CHECKED} /><br />
					<input type="radio" name="enabled" value="N" {admin.DISABLED_CHECKED} />
				</td>
			</tr>
			<tr> 
				<td colspan="2">
				<input type="submit" value="{L_SUBMIT}">
				</form>
				</td>
			</tr>
	</table>
	<br /><br />
	<span class="cattitle">{admin.L_VIDEO_TOPIC}</span><br />
	<form method="post" action="{admin.U_POST_TOPIC}">
	<input type="hidden" name="subject" value="{admin.VIDEO_TITLE}" />
	<textarea name="message" style="display:none" onFocus="blur()">[size=18][url={admin.U_VIDEO}]Nouvelle Vidéo sur la rubrique Galerie Vidéo de JJGfamille[/url][/size]
	
	[youtube]http://www.youtube.com/watch?v={admin.CODE}[/youtube]
	
	{admin.VIDEO_DESCRIPTION}</textarea>
	<input type="hidden" name="video_user_id" value="{admin.VIDEO_USER_ID}" />
	<input type="hidden" name="video_username" value="{USERNAME}" />
	<input type="hidden" name="forum_id" value="{admin.FORUM_ID}" />
	<input type="hidden" name="mode" value="newtopic" />
	<!-- BEGIN topic -->
	<a href="{admin.U_TOPIC}">{admin.L_VIEW_TOPIC}</a>
	<!-- END topic -->
	<!-- BEGIN no_topic -->
	<input type="submit" value="{admin.L_CREATE_TOPIC}" />
	<!-- END no_topic -->
	</form>
	<br /><br />
	<span class="cattitle">{admin.L_VIDEO_DELETION}</span><br />
	<a href="javascript:if(confirm('{admin.L_SUPP_CONFIRM}')) document.location='{admin.U_SUPP_VIDEO}'">{admin.L_SUPP_VIDEO}</a>
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