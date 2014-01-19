
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
					<td align="center" valign="top" colspan="2"><br />
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
      <td class="row2"><br><br><center><b><u>{L_TITLE}</u></b> {EDIT}</center><br /><br />
      <table border="0" width="90%">
      	<tr>
		<td width="30%">{IMG}</td>
		<td width="70%"><span class="genmed"><big>{L_STATE}</big> ({L_PERIOD})<br /><br />
				{DESC}<br /><br />
				<b>{L_REGLEMENT}&nbsp;:</b> {REGLEMENT}</span>
	</tr>
      </table>
      	<br />	
      	<!-- BEGIN switch_open -->
      	<!-- BEGIN submit -->
      	<form method="post" name="formulaire_concours" action="{switch_open.submit.U_ACTION}">
      	<!-- END submit -->
      	<table border="0">
      	<!-- BEGIN question -->
      	<tr>
      		<td><span class="genmed"><b>{switch_open.question.QUESTION}</b></span></td>
      	</tr>
      	<tr>
      		<td><span class="genmed">
      		<input type="radio" name="question{switch_open.question.QUESTION_ID}" value="1" CHECKED />{switch_open.question.REPONSE1}<br />
      		<input type="radio" name="question{switch_open.question.QUESTION_ID}" value="2" />{switch_open.question.REPONSE2}<br />
      		<input type="radio" name="question{switch_open.question.QUESTION_ID}" value="3" />{switch_open.question.REPONSE3}<br />
      		<input type="radio" name="question{switch_open.question.QUESTION_ID}" value="4" />{switch_open.question.REPONSE4}<br />
      		<br /></span></td>
      	</tr>
      	<!-- END question -->
      	</table>
      	<!-- BEGIN submit -->
      	<input type="button" value="{switch_open.submit.L_ACTION}" onClick="if (confirm('{switch_open.submit.L_CONFIRM_ACTION}')) this.form.submit()" />
      	<input type="submit" style="display:none" />
      	<!-- END submit -->
      	<!-- END switch_open -->
      	<!-- BEGIN switch_close -->
      	<center><span class="cattitle">{switch_close.L_CLOSE_REASON}</span></center>
      	<!-- END switch_close -->
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

					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->