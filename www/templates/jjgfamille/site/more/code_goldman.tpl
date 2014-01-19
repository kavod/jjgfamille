
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
	<td class="catleft" height="28"><center><b>{L_TITLE}</b></center></td>
	<td width="7" class="row2"></td>
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
	<td class="row2"><br/>
	<form method="post" action="{U_FORM}">
	{EXPLICATION}<br/><br/>
	<input type="hidden" name="num" value="0">
	<input type="submit" class="mainoption" value="{START}">
	</form>
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
<br/>
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
      <th colspan="2" valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{switch_admin.L_TITLE}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
      <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><br/><u><b>Ajouter une question au Code Goldman</b></u></span>
	<form method="post" action="{switch_admin.U_FORM}" enctype="multipart/form-data">
	<table width="99%" align="center" border="0">
	<tr>
		<td ><span class="genmed"><b>Question</b></span></td>
		<td ><span class="genmed"><input type="text" name="question" size="50" class="post"></span></td>
	</tr>
	<tr>
		<td ><span class="genmed"><b>Réponse 1</b></span></td>
		<td ><span class="genmed"><input type="text" name="rep_1" size="50" class="post"></span></td>
	</tr>
	<tr>
		<td ><span class="genmed"><b>Réponse 2</b></span></td>
		<td ><span class="genmed"><input type="text" name="rep_2" size="50" class="post"></span></td>
	</tr>
	<tr>
		<td ><span class="genmed"><b>Réponse 3</b></span></td>
		<td ><span class="genmed"><input type="text" name="rep_3" size="50" class="post"></span></td>
	</tr>
	<tr>
		<td ><span class="genmed"><b>Réponse 4</b></span></td>
		<td ><span class="genmed"><input type="text" name="rep_4" size="50" class="post"></span></td>
	</tr>
	<tr>
		<td ><span class="genmed"><b>Numero de la bonne réponse</b></span></td>
		<td ><span class="genmed"><input type="text" name="reponse" size="5" class="post"></span></td>
	</tr>
	<tr>
		<td ><span class="genmed"><b>Image de la question</b></span></td>
		<td ><span class="genmed"><input type="file" name="userfile" class="post"></span></td>
	</tr>
	<tr>
		<td colspan="2"><br><input type="submit" class="mainoption" value="{switch_admin.L_SUBMIT}"><br/><br/></td>
		
	</tr>
	</table>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>  
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td colspan="2" class="row2"><br/>
	<table width="99%" align="center" border="1">
	<tr>
		<td width"112"><span class="genmed"><b>Image</b></span></td>
		<td width"20%"><span class="genmed"><b>Question</b></span></td>
		<td width"60%"><span class="genmed"><b>Les 4 propositions</b></span></td>
	</tr>
	<!-- BEGIN switch_question -->
	<tr>
		<td align="center" valign="middle"><img src="{switch_admin.switch_question.IMG}" border="0"/></td>
		<td width"20%"><span class="genmed">{switch_admin.switch_question.QUESTION}&nbsp;&nbsp;<a href="{switch_admin.switch_question.U_SUPP}">{switch_admin.switch_question.L_SUPP}</a></span></td>
		<td>
		      <span class="genmed"><b>1</b>&nbsp;{switch_admin.switch_question.1}</span><br/>
		      <span class="genmed"><b>2</b>&nbsp;{switch_admin.switch_question.2}</span><br/>
		      <span class="genmed"><b>3</b>&nbsp;{switch_admin.switch_question.3}</span><br/>
		      <span class="genmed"><b>4</b>&nbsp;{switch_admin.switch_question.4}</span><br/>
		</td>
		
	</tr>
	<!-- END switch_question -->
	</table>
	</td>
	<td width="7" class="row2"></td>
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
<!-- END switch_admin --><br>
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->