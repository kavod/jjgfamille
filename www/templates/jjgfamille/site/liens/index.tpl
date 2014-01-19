
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{LIENS}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="genmed"><b>{RESPONSABLES}</b>
	<!-- BEGIN access -->
	<a href="{access.U_RESP}">{access.RESP},</a>
	<!-- END access -->
	</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
       <table border="0" width="99%" align="center">
       <tr><td valign="top"><br><br><b><u>{L_LISTE}:</u></b></td><td align="right"><img src="{IMG_LIENS}"/></td></tr>
       </table>
       <br><br>
       <table border="0" width="99%" align="center">
       <!-- BEGIN categorie_row -->
      <tr>
      <!-- BEGIN categorie_column -->
      <td width="33%" valign="bottom">
       <center><span class="genmed"><a href="{categorie_row.categorie_column.U_CATE}"><b>{categorie_row.categorie_column.L_CATE}:</b><br>{categorie_row.categorie_column.COUNT}</a></span></center><br>
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
      {WEBMASTER}<br>
      </span>
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
<br>
<!-- BEGIN admin -->
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
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{admin.L_ADMIN}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td width="400" class="row2"><br />
      <span class="genmed"><u>{L_LISTE}:</u></span><br /><br />
      <!-- BEGIN categorie -->
      <span class="genmed"><b>{admin.categorie.L_CATE}</b>({admin.categorie.COUNT})</span><br />
      <!-- END categorie -->
      </td>
      <td class="row2"><br /><br /><br />
      <!-- BEGIN categorie -->
      <span class="genmed"><a href="{admin.categorie.U_EDIT}">{admin.categorie.L_EDIT}</a>&nbsp;<a href="{admin.categorie.U_MONTER}">{admin.categorie.L_MONTER}</a>&nbsp;<a href="{admin.categorie.U_DESCENDRE}">{admin.categorie.L_DESCENDRE}</a>&nbsp;<a href="javascript:if (confirm('{admin.categorie.L_CONFIRM_SUPP}')) document.location='{admin.categorie.U_SUPPRIMER}'">{admin.categorie.L_SUPPRIMER}</a></span><br>
      <!-- END categorie -->
      </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
       <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td></br>
      <td class="row2"><br/><span class="genmed"><b>{admin.ORPHELIN}</b>({admin.COUNT})</span><br>
      </td>
      <td class="row2"><br/><span class="genmed"><a href="{admin.U_EDIT}">{admin.L_EDIT}</span></a>
      </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
           <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td colspan="2" class="row2"><br><span class="genmed">
      <form method="post" action="{admin.U_ADD_CATE}"> <u>{admin.ADD_CATE}:</u></br></br></br>{admin.NOM_CATE}:&nbsp;<input type="text" name="cate_name" size="30" class="post">&nbsp;<input type="submit" value="{admin.L_SUBMIT}">
	</span></form></td>
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
</table><br />
<!-- END admin -->
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->