
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
	<td class="catleft" height="28"><center><b>{L_TITLE}</b></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28">{NUM_QUESTION}</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
   <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2">
		<script language="Javascript">
<!--
// les <!-- et --> permettent de ne pas causer d'erreur chez ceux qui n'ont pas de javascript sur leur brower.
var t = 30;
function compte()
{
		if(t>0)
		{
			t--;
			document.form.b.value=t;
			setTimeout("compte()",1000);
		}
		else
		{
			document.form.submit();

		}
}

//-->
</script>
	<br/>
        <form  name="form" method="post" action="{U_FORM}">
<table width="100%" border="0">
  <tr> 
    <td colspan="4"><input type="text" name="b" value="0" size="2" readonly />&nbsp;<span class="genmed">{TEMPS_ECOULE}</span></td>
  </tr>
  <tr> 
    <td colspan="4" align="center" valign="middle"><img src="{IMG}" border="0"></td>
  </tr>
  <tr> 
    <td colspan="4" align="center" valign="middle"><br/><b>{QUESTION}</b><br/><br/></td>
  </tr>
  <tr> 
    <td width="15%">&nbsp;</td>
    <td width="35%">1<input type="radio" name="reponse" value="1">{1}</td>
    <td width="35%">2<input type="radio" name="reponse" value="2">{2}</td>
    <td width="15%">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="35%">3<input type="radio" name="reponse" value="3">{3}</td>
    <td width="35%">4<input type="radio" name="reponse" value="4">{4}</td>
    <td width="15%">&nbsp;</td>
  </tr>
  <tr> 
      <td colspan="4" align="center"><br/><input type="submit" class="mainoption" value="{SUBMIT}" ></td>
  </tr>
</table>
<input type="hidden" name="num" value="{NUM}">
<input type="hidden" name="num_quest" value="{NUM_QUEST}">
<input type="hidden" name="score" value="{SCORE}">
</form><br/>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28">&nbsp;</td>
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
<script language="javascript">
<!--
compte();
//-->
</script>
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->