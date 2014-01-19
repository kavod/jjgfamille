
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
	<td class="catleft" height="28"><span class="cattitle">{L_ACTION}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	<td class="row2">
		<table border="0" align="left">
			<tr><td valign="top">
			<table border="0">
			<tr>
			<td>
			<form method="post" action="{U_ACTION}" name="formulaire" id="formulaire" enctype="multipart/form-data">
			<table border="0">
				<tr>
					<td><span class="genmed"><b>{L_TITLE}</b></span></td>
					<td><input type="text" name="title" class="post" value="{TITLE}" size="50" /></td>
				</tr>
				<tr>
					<td><span class="genmed"><b>{L_DATE_BEGIN}</b></span></td>
					<td><input type="text" name="date_begin" value="{DATE_BEGIN}" size="15" maxlength="10" class="post" />&nbsp;<a href="javascript:show_calendar('document.formulaire.date_begin','document.formulaire.date_begin.value');"><img src="../images/puce_petit_calendrier.gif" border="0" width="16" height="16" border="0"/></a></td>
				</tr>
				<tr>
					<td><span class="genmed"><b>{L_DATE_END}</b></span></td>
					<td><input type="text" name="date_end" value="{DATE_END}" size="15" maxlength="10" class="post" />&nbsp;<a href="javascript:show_calendar('document.formulaire.date_end','document.formulaire.date_end.value');"><img src="../images/puce_petit_calendrier.gif" border="0" width="16" height="16" border="0"/></a></td>
				</tr>
				<tr>
					<td valign="top"><span class="genmed"><b>{L_CHAPEAU}</b></span></td>
					<td><textarea name="chapeau" class="post" cols="50" rows="5" />{CHAPEAU}</textarea></td>
				</tr>
				<tr>
					<td valign="top"><span class="genmed"><b>{L_REGLEMENT}</b></span></td>
					<td><textarea name="reglement" class="post" cols="50" rows="5" />{REGLEMENT}</textarea></td>
				</tr>
				<tr>
					<td valign="top"><span class="genmed"><b>{L_DESCRIPTION}</b></span></td>
					<td><textarea name="description" class="post" cols="50" rows="5" />{DESCRIPTION}</textarea></td>
				</tr>
				<tr>
					<td valign="top"><span class="genmed"><b>{L_ILLU}</b>
					<!-- BEGIN illu -->
					<br />{illu.L_CURRENT_PICTURE}<br /><img src="{illu.IMG}" alt="{TITLE}" title="{TITLE}" /><br /><a href="javascript:if(confirm('{illu.L_CONFIRM_SUPP_ILLU}')) document.location='{illu.U_SUPP_ILLU}'">{illu.L_SUPP_ILLU}</a>
					<!-- END illu --></span></td>
					<td valign="top"><input type="file" class="post" name="illu" /></td>
				<tr>
					<td colspan="2"><input type="submit" value="{L_SUBMIT}" /></td>
				</tr>
			</table>
			</form>
			</td>
			<td valign="top">
			<span class="cattitle">{L_PARTICIPANTS}</span><br />
			<span class="genmed">
			<ul>
			<!-- BEGIN participant -->
			<li><a href="{participant.U_PROFIL}"><font color="{participant.COLOR}">{participant.USERNAME}</font></a></li>
			<!-- END participant -->
			</ul></span>
			<!-- BEGIN switch_edit -->
			<br />
			<span class="cattitle">{L_WINNERS}</span><br />
			<span class="genmed">
			<!-- BEGIN winner -->
			<li><a href="{switch_edit.winner.U_PROFIL}">{switch_edit.winner.USERNAME}</a></li>
			<!-- END winner -->
			</span>
			<br />
			<form method="post" action="{switch_edit.U_ADD_WINNER}" name="post">
			<span class="cattitle">{L_ADD_WINNER}</span><br />
			<input type="text"  class="post" name="username" maxlength="25" size="25" tabindex="1" value="{switch_edit.WINNER}" />&nbsp;<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
			<input type="submit" value="{L_ADD}" /></form>
			ou<br />
			<input type="button" value="{L_ADD_RANDOM_WINNER}" onClick="document.location='{switch_edit.U_ADD_WINNER}'" />
			<!-- END switch_edit -->
			</td>
			</tr>
			</table><br />
<!-- BEGIN switch_edit -->
		<span class="genmed"><a href="javascript:if (confirm('{switch_edit.L_CONFIRM_SUPP}')) document.location='{switch_edit.U_SUPP}'">{switch_edit.L_SUPP}</a></span><br /><br />
		<input type="button" value="{switch_edit.L_RESET}" onClick="if(confirm('{switch_edit.L_CONFIRM_RESET}')) document.location='{switch_edit.U_RESET}'" /><br /><br />
		<span class="cattitle">{switch_edit.L_QCM}</span><br />
		<!-- BEGIN question -->
		<form method="post" action="{switch_edit.question.U_ACTION}" name="form_question_{switch_edit.question.I}" id="form_question_{I}">
		<table border="0" align="center">
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_QUESTION}</b></span></td>
				<td><input type="text" name="question{switch_edit.question.I}" class="post" size="100" maxlenght="200" value="{switch_edit.question.QUESTION}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE1}</b>{switch_edit.question.CORRECT1}</span></td>
				<td><input type="text" name="reponse{switch_edit.question.I}1" class="post" size="100" maxlenght="200" value="{switch_edit.question.REPONSE1}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE2}</b>{switch_edit.question.CORRECT2}</span></td>
				<td><input type="text" name="reponse{switch_edit.question.I}2" class="post" size="100" maxlenght="200" value="{switch_edit.question.REPONSE2}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE3}</b>{switch_edit.question.CORRECT3}</span></td>
				<td><input type="text" name="reponse{switch_edit.question.I}3" class="post" size="100" maxlenght="200" value="{switch_edit.question.REPONSE3}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE4}</b>{switch_edit.question.CORRECT4}</span></td>
				<td><input type="text" name="reponse{switch_edit.question.I}4" class="post" size="100" maxlenght="200" value="{switch_edit.question.REPONSE4}" /></td>
			</tr>
		</table><br />
		<input type="submit" va	lue="{switch_edit.L_MODIFIER}" />&nbsp; &nbsp; <input type="button" value="{switch_edit.L_SUPP_QUESTION}" onClick="if (confirm('{switch_edit.L_CONFIRM_SUPP}')) document.location='{switch_edit.question.U_SUPP}'" />
		</form><br />
		<!-- END question -->
		<br />
		<form method="post" action="{switch_edit.U_ACTION_ADD_QUESTION}" name="form_questions" id="form_questions">
		<big><b>{switch_edit.L_ADD_QUESTION}</b></big><br />
		<table border="0" align="center">
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_QUESTION}</b></span></td>
				<td><input type="text" name="question" class="post" size="105" maxlenght="200" value="{switch_edit.QUESTION}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE1}</b></span></td>
				<td><input type="radio" name="correct" value="1"{switch_edit.CHECKED_REPONSE1} />
				<input type="text" name="reponse1" class="post" size="100" maxlenght="200" value="{switch_edit.REPONSE1}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE2}</b></span></td>
				<td><input type="radio" name="correct" value="2"{switch_edit.CHECKED_REPONSE2} />
				<input type="text" name="reponse2" class="post" size="100" maxlenght="200" value="{switch_edit.REPONSE2}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE3}</b></span></td>
				<td><input type="radio" name="correct" value="3"{switch_edit.CHECKED_REPONSE3} />
				<input type="text" name="reponse3" class="post" size="100" maxlenght="200" value="{switch_edit.REPONSE3}" /></td>
			</tr>
			<tr>
				<td><span class="genmed"><b>{switch_edit.L_REPONSE4}</b></span></td>
				<td><input type="radio" name="correct" value="4"{switch_edit.CHECKED_REPONSE4} />
				<input type="text" name="reponse4" class="post" size="100" maxlenght="200" value="{switch_edit.REPONSE4}" /></td>
			</tr>
		</table><br />
		<input type="submit" value="{switch_edit.L_ADD}" />
		</form>
<!-- END switch_edit -->
	</td>
</tr>
		</table></td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>

    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}" class="cattitle">{L_RETOUR}</a></span></center></td>
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