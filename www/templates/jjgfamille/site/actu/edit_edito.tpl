
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{EDIT_EDITO}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="cattitle"><a class="cattitle"><b>{CHANGE_EDITO}</b></a></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2" style="vertical-align: top;">
      		<form method="post" action="{U_ACTION}" enctype="multipart/form-data">
		<span class="genmed">
		{L_EDITO_EXPLAIN} <input type="text" name="title" value="{L_EDITO_TITLE}" size="30" class="post" /><br />
      		<textarea name="edito" cols="50" rows="10" class="post">{L_EDITO_ACTUAL}</textarea><br />
		<!-- BEGIN illu -->
		<b>{illu.L_ACTUAL_ILLU}</b><br />
		<img src="{illu.U_ILLU}" border="0" />{illu.L_ILLUSTRATEUR}<br />
		<small><a href="javascript:if(confirm('{illu.L_CONFIRM_SUPP_ILLU}')) document.location='{illu.U_SUPP_ILLU}'" />{illu.L_SUPP_ILLU}</a><br />
		<!-- END illu -->
		{L_CHANGE_ILLU}<br />
		<input type="file" name="illustration" class="post" /><br />
		<input type="submit" value="{L_SUBMIT}" /><br />
		<a href="javascript:if(confirm('{L_CONFIRM_SUPP_EDITO}')) document.location='{U_SUPP_EDITO}'" />{L_SUPP_EDITO}</a>
		</span>
		</form>
		<br><span class="genmed"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></span>
      		</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- BEGIN switch_archives -->
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><span class="cattitle"><a class="cattitle"><b>{switch_archives.L_EDIT_ANOTHER_EDITO}</b></a></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2" style="vertical-align: top;">
      <table border="0">
	<!-- BEGIN archives -->
	<tr>
		<td>{switch_archives.archives.ILLU}</td>
		<td><span class="genmed"><a href="{switch_archives.archives.U_EDIT}"><b>{switch_archives.archives.DATE} :</b></a></span></td>
		<td><span class="genmed"><a href="{switch_archives.archives.U_EDIT}">{switch_archives.archives.TITLE}</a></span></td>
	</tr>
	<!-- END archives -->
	</table>
	<br><span class="genmed"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></span>
      		</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
<!-- END switch_archives -->    
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td class="ligneBas"></td>
    </tr>
  </tbody>
</table><br />
					</td>
					
				</tr>
				
				
				
				
<!-- FIN du document -->