
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
	<td class="catleft" height="28"><center><b>Le GoldmanikouiZ</b></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2" ><br>
	<script language="Javascript">
<!--
// les <!-- et --> permettent de ne pas causer d'erreur chez ceux qui n'ont pas de javascript sur leur brower.
var t = 30;
function compte()
{
	if (document.form.submited.value != 1)
	{
		if(t>0)
		{
			t--;
			document.form.b.value=t;
			setTimeout("compte()",1000);
		}
		else
		{
			//document.form.rep_id.value=0;
			document.form.rep_id.style.display='none';
			document.form.Submit.style.display='none';
			document.form.submit();

		}
	}
}
	
function submitQuizz()
{
	var t1;
	t1=t;
	//alert('Ouf, il ne restait plus que '+t1+'sec ! ');
	//alert('Soumission précédente détectée '+document.form.submited.value);
	if (t1 != 0 && document.form.submited.value == 0)
	{
		document.form.submited.value = 1;
		document.form.Submit.style.display='none';
		document.form.submit();
	} else
	{
		if (t1 != 0)
		{
			alert("Oui, oui, on a bien enregistré votre réponse, la suite arrive");
		} else
		{
			alert("Trop tard ! :)");
		}
	}
	
}
//-->
</script>	
	
	<table width="99%" height="379" border="0" align="center">
	<tr>
		<td width="64%" height="39"><span class="genmed"><center>{WELCOME}</center></span></td>
		<td width="36%" rowspan="4" align="center" valign="middle"><img src="{IMG}" width="250" height="350"/></td>
	</tr>
	<tr>
		<td height="48" align="left" valign="middle"><span class="genmed">{YOUR_SCORE}</span></td>
	</tr>
	<tr>
		<td height="111" align="left" valign="middle"><span class="genmed">{QUESTION}<br><br>{PHRASE}</span></td>
	</tr>
	<tr>
		<td height="164" align="left" valign="middle">
		<span class="genmed">{NB_SECONDES}</span> 
      		<form action="{U_FORM}" method="post" enctype="multipart/form-data" name="form" id="form">
		<select name="rep_id">';
          	<option value="0" SELECTED>----{CHOOSE_SONG}-----</option>
          	<!-- BEGIN switch_liste -->
          	<option value="{switch_liste.VALUE}">{switch_liste.INTITULE}</option>
          	<!-- END switch_liste -->
		</select>
        	&nbsp; 
        	<input type="button" name="Submit" value="{L_SUBMIT}" onClick="submitQuizz()">&nbsp;<span class="genmed">{TEMPS_ECOULE}</span> 
        	<input name="b" type="text" value="0" size="2" readonly>
        	<br>
        	<input type="hidden" name="submited" value="0"></font>
      		</form>
		</td>
	</tr>
	</table><br>
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

<script language="javascript">
<!--
compte();
//-->
</script>
					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->