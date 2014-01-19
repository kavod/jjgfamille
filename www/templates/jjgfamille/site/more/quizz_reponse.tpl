
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
	<table width="99%" height="378" border="0" align="center">
	<tr>
		<td width="66%" height="39"><span class="genmed"><center>{WELCOME}</center></span></td>
		<td width="34%"  align="center" valign="middle">&nbsp;</td>
	</tr>
	<tr>
		<td height="70" align="left"><span class="genmed">
		 <br><br><center>{GOOD_OR_BAD}<br><br>{RESULT}<br><br></center>
		</span></td>
		<td align="center" valign="middle"><img src="{JACK}" border="0"> </td>
	</tr>
	  <tr><td class="catleft" height="20" colspan="2"><marquee>{LYRICS}</marquee></td></tr>
  <tr> 
    <td height="26"><span class="genmed">{YOUR_SCORE}</span></td>
    <td rowspan="2" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr> 
    <td height="42">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input type="button" name="envoyer" size="10" value="{NEXT_QUESTION}" onClick="{ONCLICK}"> 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <a href="{U_STOP}"><b>{L_STOP}</b></a></td>
  </tr>
</table><br><bgsound src="{MIDI_SRC}" loop=infinite>
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
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">Le Classement</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2">
	<table width="99%" border="0" align="center">
        <tr valign="top">
        	<td width="50%">
        		<table width="99%" border="0" align="center">
        		<tr><td colspan="3"><span class="genmed"><center><b>{CLASSEMENT} :</b></td></tr>
        		<tr>
        			<td width="33%"><span class="genmed"><b>{JOUEUR}</b></span></td>
        			<td width="33%"><span class="genmed"><b>{SCORE}</b></span></td>
        			<td width="33%"><span class="genmed"><b>{POURCENTAGE}</b></span></td>
        		</tr>
        		<!-- BEGIN switch_score -->
        		<tr>
        			<td><span class="genmed">{switch_score.JOUEUR}</span></td>
        			<td><span class="genmed">{switch_score.SCORE}<center></center></span></td>
        			<td><span class="genmed">{switch_score.POURCENTAGE}<center></center></span></td>
        		</tr>
        		<!-- END switch_score -->
        		</table>
 
        	</td>
        	<td width="50%">
			<table width="99%" border="0" align="center">
        		<tr><td colspan="3"><span class="genmed"><center><b>{HORS} :</b></center></span></td></tr>
        		<tr>
        			<td width="33%"><span class="genmed"><b>{JOUEUR}</b></span></td>
        			<td width="33%"><span class="genmed"><b>{SCORE}</b></span></td>
        			<td width="33%"><span class="genmed"><b>{POURCENTAGE}</b></span></td>
        		</tr>
        		<!-- BEGIN switch_hors_score -->
        		<tr>
        			<td><span class="genmed">{switch_hors_score.JOUEUR}</span></td>
        			<td><span class="genmed">{switch_hors_score.SCORE}<center></center></span></td>
        			<td><span class="genmed">{switch_hors_score.POURCENTAGE}<center></center></span></td>
        		</tr>
        		<!-- END switch_hors_score -->
        		</table>
		</td>
	</tr>
	</table>
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

					</td>
				</tr>
			
<!-- FIN du document -->
