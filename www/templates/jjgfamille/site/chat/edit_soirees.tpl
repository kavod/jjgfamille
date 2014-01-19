
<!-- Début du document -->

				<tr>
					<td>&nbsp;</td>
					<td  align="center">
					<span class="forumlink">
		                {LIEN_WEBCHAT} | {LIEN_HELP} | {LIEN_SOIREES}</span>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					
					<td align="center" valign="top" colspan="3">{ERROR_BOX}<br />
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
	<td class="row2"><br><span class="cattittle"><b><u>{MODIF}</u></b></span><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br><br>
	<form method="post" action="{U_FORM}" enctype="multipart/form-data"> 
		<table border="0" width="99%" >
			<tr valign="top">	
				<td width="20%"><span class="genmed"><b>{NOM}</b></span><br></td>
				<td><input type="text" name="name" size="30" value="{VAL_NOM}" class="post"><br></td>
			</tr>	
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DESC}</b></span><br></td>
				<td><textarea name="description" cols="30" rows="7" class="post">{VAL_DESC}</textarea><br></td>
  			</tr>
  			<tr valign="top"> 
				<td><span class="genmed"><b>{DAY}</b><br><small>format obligatoire(jj/mm/aaaa)</small></span><br></td>
				<td><input type="text" name="date" size="30" value="{VAL_DAY}" class="post" maxlength=10 ><br></td>	
  			</tr>
   			<tr valign="top"> 
				<td><span class="genmed"><b>{HOUR}</b><br><small>format obligatoire(hh:mm)</small></span><br></td>
				<td><input type="text" name="heure" size="30" value="{VAL_HOUR}" class="post" maxlength=5 ><br></td>	
  			</tr>
  			<tr valign="top"> 
  				<td>&nbsp;</td><td><input type="submit" value="{L_SUBMIT}"><br></td>
			</tr>
		</table>
	</form>
	</td>	
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br><span class="cattittle"><b><u>{GESTION_LOG}</u></b></span><br>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br>
	<form method="post" action="{U_FORM1}" enctype="multipart/form-data">
	<span class="genmed">{IS_LOG}&nbsp;<a href="javascript:if (confirm('{L_CONFIRM_SUPP_LOG}')) document.location='{U_SUPP_LOG}'">{L_SUPP_LOG}</a></span> 
		<br><br><table border="0" width="99%" >
			<tr valign="top">	
				<td width="20%"><span class="genmed"><b>{LOG}</b></span><br></td>
				<td><input type="file" name="userfile" size="30" class="post"><br></td>
			</tr>
			<tr valign="top"> 
  				<td>&nbsp;</td><td><input type="submit" value="{L_SUBMIT}"><br></td>
			</tr>	
		</table>
	</form>
	</td>	
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="genmed"><center>[&nbsp;<a href="javascript:if (confirm('{L_CONFIRM_SUPP_THEME}')) document.location='{U_SUPP_THEME}'">{L_SUPP_THEME}</a>&nbsp;]</center></span><br/><br/><br/></td>	
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
     <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft"><center><a href="{U_RETOUR}"><b>{L_RETOUR}</b></center></td>	
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



