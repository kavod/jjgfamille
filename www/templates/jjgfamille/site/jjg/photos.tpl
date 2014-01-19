
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
      <td  class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td  height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{L_PHOTOS}</th>
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
       <table border="0" width="99%" align="center">
       <tr><td valign="top"><p align="left"><br /><span class="cattitle"><u>{L_LISTE}:</u></span></p>
       		<p align="left"><span class="genmed"><b>{L_BEST_CONTRIBUTORS}</b>
       		<ul>
<!-- BEGIN contributors -->
		<li><a href="{contributors.U_USER}">{contributors.USERNAME}</a> {contributors.NB_PHOTOS}</li>
<!-- END contributors -->
		</ul></span></p>
	</td><td align="right"><img src="{IMAGE}"/></td></tr>
       </table>
       <br>
       <table border="0" width="99%" align="center">
       <!-- BEGIN categorie_row -->
      <tr>
      <!-- BEGIN categorie_column -->
      <td width="33%" valign="bottom">
       <center><span class="genmed"><a href="{categorie_row.categorie_column.U_CATE}"><img src="{categorie_row.categorie_column.PHOTO}" border="0" /><br><b>{categorie_row.categorie_column.L_CATE}:</b><br>{categorie_row.categorie_column.COUNT}</a></span></center><br>
      </td>
      <!-- END categorie_column -->
      </tr>
      <!-- END categorie_row -->
      </table>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
        <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <span class="genmed">
      </br></br>
      {AJOUT_PHOTOS}<br>
      </span>
      <br>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}">{L_RETOUR}</a></span></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td  height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td  class="ligneBas"></td>
    </tr>
  </tbody>
</table>
<br>
<!-- BEGIN switch_admin -->
<table style="text-align: left; width: 100%;" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td colspan="2" class="row2"><span class="genmed"><b><a href="{switch_admin.U_ACCES_UPLOAD}">{switch_admin.L_ACCES_UPLOAD}</a></b></span></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td width="40%" class="row2"></br>
      <span class="cattitle"><u>{switch_admin.L_LISTE}:</u></span></br><br/>
      <span class="genmed">
      <!-- BEGIN categorie -->
      <a href="{switch_admin.categorie.U_CATE}"><b>{switch_admin.categorie.L_CATE}:</b></a><span class="genmed">&nbsp;{switch_admin.categorie.COUNT}</span><br>
      <!-- END categorie -->
      </span>
      </td>
      <td class="row2">
      <span class="genmed">
      </br></br></br>
      <!-- BEGIN categorie -->
      <a href="{switch_admin.categorie.U_MONTER}">{switch_admin.categorie.L_MONTER}</a>&nbsp;<a href="{switch_admin.categorie.U_DESCENDRE}">{switch_admin.categorie.L_DESCENDRE}</a>&nbsp;<a href="javascript:if (confirm('{switch_admin.categorie.L_CONFIRM_SUPP}')) document.location='{switch_admin.categorie.U_SUPPRIMER}'">{switch_admin.categorie.L_SUPPRIMER}</a><br>
      <!-- END categorie -->
      </span>
      </td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td colspan="2" class="row2"><br><form method="post" action="{switch_admin.U_ADD_CATE}"><span class="cattitle"><u>{switch_admin.ADD_CATE}:</u></span></br></br><span class="genmed"><b>{switch_admin.NOM_CATE}:</b></span>&nbsp;<input type="text" name="cate_name" size="30" class="post">&nbsp;<input type="submit" value="{switch_admin.L_SUBMIT}">
	</span></form></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td colspan="2" class="row2"><br><span class="genmed"><form method="post" action="{switch_admin.U_NB_PHOTOS}">{switch_admin.NB_PHOTOS}</br>{switch_admin.MODIFIER}:&nbsp;<input type="text" name="nb_photos" size="10" class="post">&nbsp;<input type="submit" value="{switch_admin.L_SUBMIT}"></span></form></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="2" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="2" class="ligneBas"></td>
    </tr>
  </tbody>
</table>
<!-- END switch_admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->