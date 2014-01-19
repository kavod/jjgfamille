

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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{RUB}</th>
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
<script language="javascript">
<!--
function description(message, champ)
{
	if(document.getElementById)
		document.getElementById(champ).innerHTML = message;
}

function bbfontstyle(bbopen, bbclose) 
{
	var txtarea = document.form.message;
	theSelection = document.selection.createRange().text;
	if (!theSelection) 
	 {
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
		return;
	 }
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
}

//-->
</script>
<br><span class="cattitle"><u>{AJOUT_RECIT} :</u></span><br>
<form action="{U_FORM}" method="post" name="form" enctype="multipart/form-data">    
<table align="center" width="99%" border="0" cellspacing="0" cellpadding="0">
   <tr align="center" valign="middle"> 
	<td>&nbsp;</td>
	<td>
       <input type="button" class="post" name="boldthis" value=" B " style="font-weight:bold; width: 25px" onClick="bbfontstyle('[b]', '[/b]')" onMouseOver="description('[B] Mettre votre texte en Gras ! [/B]', 'texte'); return true" onMouseOut="description('Aide pour l\'utilisation du BBCode !','texte'); return true"/>&nbsp;
       <input type="button" class="post" name="italicthis" value=" i " style="font-style:italic; width: 25px" onClick="bbfontstyle('[i]', '[/i]')" onMouseOver="description('[I] Mettre votre texte en Italique ! [/I]', 'texte'); return true" onMouseOut="description('Aide pour l\'utilisation du BBCode !','texte'); return true"/>&nbsp;
       <input type="button" class="post" name="underlinethis" value=" u " style="text-decoration: underline; width: 25px" onClick="bbfontstyle('[u]', '[/u]')" onMouseOver="description('[U] Mettre votre texte en Soulign ! [/U]', 'texte'); return true" onMouseOut="description('Aide pour l\'utilisation du BBCode !','texte'); return true"/>&nbsp;
       <input type="button" class="post" name="urlthis" value=" URL " style="text-decoration: underline; width: 40px" onClick="bbfontstyle('[url]', '[/url]')" onMouseOver="description('[URL=Une URL] Titre de l\'URL [/URL]', 'texte'); return true" onMouseOut="description('Aide pour l\'utilisation du BBCode !','texte'); return true"/>&nbsp;
       <span class="genmed">Taille:&nbsp;</span><select name="sizethis" onChange="bbfontstyle('[size=' + this.form.sizethis.options[this.form.sizethis.selectedIndex].value + ']', '[/size]')" onMouseOver="description('Taille du texte: [size=small]texte en petit[/size]', 'texte'); return true" onMouseOut="description('Aide pour l\'utilisation du BBCode !','texte'); return true">
	<option value="7" class="genmed">Très petit</option>
	<option value="9" class="genmed">Petit</option>
	<option value="12" selected class="genmed">Normal</option>
	<option value="18" class="genmed">Grand</option>
	<option  value="24" class="genmed">Très grand</option>
       </select>&nbsp;
       <span class="genmed">Couleur:&nbsp;<select name="colorthis" onChange="bbfontstyle('[color=' + this.form.colorthis.options[this.form.colorthis.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="description('Couleur du texte: [color=blue]texte en bleu[/color]', 'texte'); return true" onMouseOut="description('Aide pour l\'utilisation du BBCode !','texte'); return true">
	<option style="color:black; " value="black" class="genmed">Defaut</option>
	<option style="color:darkred; " value="darkred" class="genmed">Rouge foncé</option>
	<option style="color:red; " value="red" class="genmed">Rouge</option>
	<option style="color:orange; " value="orange" class="genmed">Orange</option>
	<option style="color:brown; " value="brown" class="genmed">Marron</option>
	<option style="color:yellow; " value="yellow" class="genmed">Jaune</option>
	<option style="color:green; " value="green" class="genmed">Vert</option>
	<option style="color:olive; " value="olive" class="genmed">Olive</option>
	<option style="color:cyan; " value="cyan" class="genmed">Cyan</option>
	<option style="color:blue; " value="blue" class="genmed">Bleu</option>
	<option style="color:darkblue; " value="darkblue" class="genmed">Bleu foncé</option>
	<option style="color:indigo; " value="indigo" class="genmed">Indigo</option>
	<option style="color:violet; " value="violet" class="genmed">Violet</option>
	<option style="color:white; " value="white" class="genmed">Blanc</option>
	<option style="color:black; " value="black" class="genmed">Noir</option>
	</select>
        </td>
   </tr>
   <tr><td>&nbsp;</td><td align="center"><table border="0" width="40%"><tr><td align="center"><span class="genmed"><b><DIV ID=texte>Aide pour l'utilisation du BBCode !</DIV></b></span></td></tr></table></td></tr>
   <tr><td valign="top" align="right"><span class="genmed"><b>{L_RECIT}</b></span></td><td align="center"><textarea name="message" rows=30 cols=120 class="post"></textarea></td></tr>
   <tr><td>&nbsp;</td><td align="center"><br><input type="submit" name="submit" value="{L_SUBMIT}"></td></tr>
</table>
<br>
</form>
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



