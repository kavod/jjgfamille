
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
	<td class="catleft" height="28"><b>{L_RUB}</b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="genmed"><a href="javascript:if (confirm('{L_CONFIRM_SUPP}')) document.location='{U_SUPP}'">{L_SUPP}</a></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2"><br><center><img src="{IMG}" border="0" alt="{L_RUB}" title="{L_RUB}"/><br />
      <table border="0" width="100%">
      	<tr>
<!-- BEGIN submenu -->
      		<td align="center">
      			<span class="cattitle">
<!-- BEGIN switch_link -->
      			<a href="{submenu.U_SUBRUB}">
<!-- END switch_link -->
<!-- BEGIN switch_no_link -->
      			<b>
<!-- END switch_no_link -->
      			{submenu.L_SUBRUB}
<!-- BEGIN switch_link -->
      			</a>
<!-- END switch_link -->
<!-- BEGIN switch_no_link -->
      			</b>
<!-- END switch_no_link -->
			</span>
      		</td>
<!-- END submenu -->
      	</tr>
      </table></center><br /><span class="genmed">{CONTENU}</span><br /><br />
      <br />
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.NOM_RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
         <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2">
      <br>
      <div align="left"><span class="genmed"><b><u>{switch_admin.ADD_RUB} :</u></b></span></div><br><br>
      		<form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data">
      			<table border="0" width="70%" align="center">	
				<tr> 
					<td><span class="genmed"><b>{switch_admin.NOM}</b></span><br></td>
					<td><input type="text" name="title" size="60" class="post" value="{switch_admin.L_NOM}"><br></td>
				</tr>
				<tr> 
					<td><span class="genmed"><b>{switch_admin.DESC}</b></span><br></td>
					<td><input type="text" name="desc" size="60" class="post" value="{switch_admin.L_DESC}"><br></td>
				</tr>
				<tr> 
					<td valign="top"><span class="genmed"><b>{switch_admin.CONTENU}</b></span><br></td>
					<td><textarea name="comment" cols="60" rows="20" class="post">{switch_admin.L_CONTENU}</textarea><br></td>
				</tr>
				<tr> 
	
					<td colspan="2"><br>
					<center><input type="submit" value="{switch_admin.L_SUBMIT}"></center>
					</td>
				</tr>
			</table>
		</form>
		<table border="0" width="70%" align="center">
			<tr> 
 				<td valign="top"><span class="genmed"><b>{switch_admin.MASCOTTE}</b></span><br></td>
				<td >
				<form method="post" action="{switch_admin.U_FORM_PIC}" enctype="multipart/form-data"> 
				{switch_admin.PICTURE}<br><a href="javascript:if (confirm('{switch_admin.L_CONFIRM_SUPP_ILLU}')) document.location='{switch_admin.U_SUPP_IMAGE}'"><span class="genmed">{switch_admin.L_SUPP_IMAGE}</span></a>
				<br><input type=FILE NAME="userfile" size="30" class="post">
				<br><input type="submit" value="{switch_admin.L_SUBMIT}">
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