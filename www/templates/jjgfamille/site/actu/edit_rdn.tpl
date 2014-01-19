
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
	<td class="row2"><br><span class="cattitle"><u><b>{MODIFIER}</b></u>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{U_ADD}">{L_ADD}</a></span><br/></td>
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
<br/>
<!-- BEGIN switch_date -->
<span class="genmed"><b>{switch_date.DATE}</b></span>
<!-- END switch_date -->
<br>
<form action="{U_FORM}" method="post" name="form" enctype="multipart/form-data">    
<table align="center" width="99%" border="0" cellspacing="0" cellpadding="0">
   <tr align="center" valign="middle"> 
	<tr><td valign="top" align="center" width="20%"><span class="genmed"><b>{NOM}</b></span></td><td><input type="text" size=75 name="name" value="{VAL_NOM}" class="post"/><br/><br/></td></tr>
   </tr>
   <tr align="center" valign="right"> 
	<td>&nbsp;</td>
	<td align="left">
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
   <tr><td>&nbsp;</td><td align="left"><table border="0" width="60%"><tr><td align="center"><span class="genmed"><b><DIV ID=texte>Aide pour l'utilisation du BBCode !</DIV></b></span></td></tr></table></td></tr>
   <tr><td valign="top" align="center"><span class="genmed"><b>{L_CONTENU}</b></span></td><td align="left"><textarea name="message" rows=20 cols=75 class="post">{VAL_DESC}</textarea></td></tr>
   <tr><td colspan="2" align="center"><br><input type="submit" name="submit" value="{L_SUBMIT}"></td></tr>
</table>
</form>
</td>
      <td width="7" class="row2"></td>
      <td class="colonneDroite"></td>
    </tr>
    <!-- BEGIN switch_img -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><span class="cattitle"><u>{switch_img.AJOUT_IMG}</u></span><br/>
	<img src="{switch_img.IMG}" border=0 alt="{switch_img.ALT}" title="{switch_img.ALT}"/><br/>
	<span class="genmed"><a href="javascript:if (confirm('{switch_img.L_CONFIRM_SUPP_IMG}')) document.location='{switch_img.U_SUPP_IMG}'">{switch_img.L_SUPP_IMG}</a></span><br/>
	<form action="{switch_img.U_FORM}" method="post" enctype="multipart/form-data"> 
	<input type="file" name="userfile" class="post" size="30" />
	<input type="submit" value="{switch_img.L_SUBMIT}"> 
	</form>
	<br/>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- END switch_img -->
    <!-- BEGIN switch_sawmail -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle">{switch_sawmail.L_MAIL_Y}<a href="javascript:if (confirm('{switch_sawmail.L_CONFIRM_MAIL_N}')) document.location='{switch_sawmail.U_MAIL_N}'" >{switch_sawmail.L_MAIL_N}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{switch_sawmail.U_SAWMAIL}" target="_blank">{switch_sawmail.L_SAWMAIL}</a></span><br/></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- END switch_sawmail -->
  <!-- BEGIN switch_supp -->
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle"><center>[&nbsp;<a href="javascript:if (confirm('{switch_supp.L_CONFIRM_SUPP}')) document.location='{switch_supp.U_SUPP}'">{switch_supp.L_SUPP}</a>&nbsp;]</center></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- END switch_supp -->
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><span class="cattitle"><b>{STATS}</b></span>&nbsp;&nbsp;<img src="{IMG_STATS}" alt="{ALT_STATS}" title="{ALT_STATS}"/></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2"><br/>
	<table align="center" width="99%" border="0" cellspacing="0" cellpadding="0">
	<!-- BEGIN switch_rdn -->
	<tr>
	<td>{switch_rdn.IS_IMG}</td>
	<td><span class="genmed"><a href="{switch_rdn.U_TITLE}"><b>{switch_rdn.L_TITLE}</b></a></span></td>
	<td><span class="genmed"><a href="{switch_rdn.U_EDIT}">{switch_rdn.L_EDIT}</a></span></td>
	<td><span class="genmed">{switch_rdn.DATE}</span></td>
	<td><span class="genmed"><a href="{switch_rdn.U_USER}">{switch_rdn.L_USER}</a></span></td>
	<td><span class="genmed">{switch_rdn.ETAT}</span></td>
	</tr>
	<!-- END switch_rdn -->
	</table>
	<br>
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