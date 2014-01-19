
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB_MEDIAS}</th>
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
	<td class="row2"><span class="cattitle"><br><center><a href="{U_TITRE}">{TITRE}</a></center></span><br><br>
	<table width="99%" align="center" border="0" >
	<form method="post" action="{U_EDIT_GEN}">
	<tr>
		<td>
			<span class="genmed"><b><u>{GESTION_REPORT_INFO}</u></span><br />
			<table border="0">
				<tr>
					<td><span class="genmed"><b>{L_TITLE}</b></span></td>
					<td><input type="text" name="title" value="{VALUE_TITLE}" size="50" /></td>
				</tr>
				<tr>
					<td valign="top"><span class="genmed"><b>{L_DESCRIPTION}</b></span></td>
					<td><textarea name="description" cols="45" rows="5" >{VALUE_DESCRIPTION}</textarea></td>
				</tr>
				<tr>
					<td valign="top"></td>
					<td><input type="submit" value="{L_ENVOYER}" /></td>
				</tr>
			</table>
		</td>
	</tr>
	</form>
	<tr>
		<td>
			<span class="genmed"><b><u>{GESTION_REPORT}</u></span><br><br>
			<table width="80%" align="center" border="0" >
			<tr>
				<td colspan="2"><span class="genmed">{NO_PAGE}</span></td>
			</tr>
			<!-- BEGIN switch_pages -->
			<tr>
				<td width="15%">
					<span class="genmed">{switch_pages.L_TITRE}</span>
				</td>
				<td>
					<span class="genmed"><a href="{switch_pages.U_EDITER}">{switch_pages.L_EDITER}</a>&nbsp;&nbsp;<a href="{switch_pages.U_MONTER}">{switch_pages.L_MONTER}</a>&nbsp;&nbsp;<a href="{switch_pages.U_DESCENDRE}">{switch_pages.L_DESCENDRE}</a>&nbsp;&nbsp;<a href="javascript:if (confirm('{switch_pages.L_CONFIRM_SUPP_PAGE}')) document.location='{switch_pages.U_SUPPRIMER}'">{switch_pages.L_SUPPRIMER}</a></span>
				</td>
			</tr>
			<!-- END switch_pages -->
			<tr>
				<td width="15%"></td>
				<td><br><span class="genmed"><a href="{U_ADD_PAGE}"><b>{L_ADD_PAGE}</b></span></td>
			</tr>
			</table>
			<br>
		</td>
	</tr>
	<tr>
		<td>
			<span class="genmed"><b><u>{GESTION_ACCES}</u></span><br><br>
			<table width="80%" align="center" border="0" >
			<!-- BEGIN switch_reporter -->
			<tr>
				<td width="15%">
					<span class="genmed"><a href="{switch_reporter.U_USER}">{switch_reporter.L_USER}</a></span>
				</td>
				<td width="35%">
					<span class="genmed">{switch_reporter.JOB}</span>
				</td>
				<td>
					<span class="genmed"><a href="javascript:if (confirm('{switch_reporter.L_CONFIRM_SUPP_REPORTER}')) document.location='{switch_reporter.U_SUPPRIMER}'">{switch_reporter.L_SUPPRIMER}</a></span>
				</td>
			</tr>
			<!-- END switch_reporter -->
			<tr>
				<td width="15%"></td>
				<td colspan="2" width="15%"><br><span class="genmed"><a href="{U_ADD_REPORTER}"><b>{L_ADD_REPORTER}</b></a></span></td>
			</tr>
			</table>
			<br>
		</td>
	</tr>
		<tr>
		<td>
			<span class="genmed"><b><u>{GESTION_GALERIE}</u></b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{U_EDITER_GALERIE}">{L_EDITER_GALERIE}</a></span><br><br>
			<table width="80%" align="center" border="0" >
			<tr>		
				<td colspan="2"><span class="genmed">{NB_PHOTOS}</span></td>
			</tr>
			<tr>		
				<td width="15%"></td>
				<td><br><span class="genmed"><a href="{U_ADD_PHOTO}"><b>{L_ADD_PHOTO}</b></a></span></td>
			</tr>
			</table>
			<br>
		</td>
	</tr>
	<tr>
		<td>
			<span class="genmed"><b><u>{ETAT_REPORT}</u>&nbsp;:</b>&nbsp;&nbsp;{ETAT}&nbsp;&nbsp;[&nbsp;<a href="{U_ETAT}">{L_ETAT}</a>&nbsp;]</span>
			
		</td>
	</tr>
	<tr>
		<td>
			<br><center><span class="genmed">[&nbsp;<a href="javascript:if (confirm('{L_CONFIRM_SUPP_REPORT}')) document.location='{U_SUPP_REPORT}'">{L_SUPP_REPORT}</a>&nbsp;]</span></center><br>
			
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
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->