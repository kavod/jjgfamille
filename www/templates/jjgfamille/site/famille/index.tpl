
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
      <td class="row2"><br><br><br><br>
      	<table width="99%" border="0">
      		<tr align="center" valign="bottom">
      			<td width="50%"><img src="{MASCOTTE_TEAM}" border="0" alt="{L_EQUIPE}" title="{L_EQUIPE}"/><br /></img></td>
      			<td width="50%"><img src="{MASCOTTE_RDF}" border="0" alt="{L_RDF}" title="{L_RDF}" /></img><br /></td>
      		</tr>
      		<tr align="center" valign="top">
      			<td><a href="{U_EQUIPE}"><b>[&nbsp;{L_EQUIPE}&nbsp;]</b></a><br /><br />
      				<table width="90%" border="0">
      				<tr><td><span class="genmed"><i>{ACCEDEZ_EQUIPE}</i><br /><br />{STATS_EQUIPE}</span></td></tr>
      				</table><br />
      			</td>
      			<td><a href="{U_RDF}"><b>[&nbsp;{L_RDF}&nbsp;]</b></a><br /><br />
      				<table width="90%" border="0">
      				<tr><td><span class="genmed"><i>{ACCEDEZ_RDF}</i><br /><br />{STATS_RDF}</span></td></tr>
      				</table><br />
      			</td>
     		</tr>
     		<!-- BEGIN rub_row -->
      		<tr>
      		<!-- BEGIN rub_column -->
			<td><center><img src="{rub_row.rub_column.MASCOTTE}" alt="{rub_row.rub_column.L_RUB}" /><br><br>
			<b>[&nbsp;<a href="{rub_row.rub_column.U_RUB}">{rub_row.rub_column.L_RUB}</a>&nbsp;]</b>
			<br/><br/>
			<table width="90%" border="0">
      			<tr><td><span class="genmed"><i>{rub_row.rub_column.DESC}</i>
      			<br /><div style="text-align:center"><a href="{rub_row.rub_column.U_MONTER}">{L_MONTER}</a>&nbsp;<a href="{rub_row.rub_column.U_DESCENDRE}">{L_DESCENDRE}</a></div></span></td></tr>
      			</table>
			</center><br><br></td>
      		<!-- END rub_column -->
      		</tr>
      		<!-- END rub_row -->
     	</table><br />
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
      <br><span class="genmed">
      <div align="left"><span class="genmed"><b><u>{switch_admin.ADD_RUB} :</u></b></span></div><br><br>
      <form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data"> 		
		<table border="0" width="70%" align="center">	

  			<tr> 
				<td><span class="genmed"><b>{switch_admin.NOM}</b></span><br></td>
				<td><input type="text" name="title" size="60" class="post"><br></td>
  			</tr>
  			<tr> 
				<td><span class="genmed"><b>{switch_admin.DESC}</b></span><br></td>
				<td><input type="text" name="desc" size="60" class="post"><br></td>
  			</tr>
  			<tr> 
				<td valign="top"><span class="genmed"><b>{switch_admin.CONTENU}</b></span><br></td>
				<td><textarea name="comment" cols="60" rows="20" class="post"></textarea><br></td>
  			</tr>
  			<tr> 
				<td valign="top"><span class="genmed"><b>{switch_admin.MASCOTTE}</b></span><br></td>
				<td><input type="file" name="userfile" size="40" class="post"><br></td>
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



	


    
