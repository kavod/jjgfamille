
<form action="{S_MODCP_ACTION}" method="post">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
	</tr>
  </table>
  <table class="boite" cellpadding="0" align="center">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th height="25" class="thHead"><b>{MESSAGE_TITLE}</b></th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row2"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center"><span class="gen">{L_MOVE_TO_FORUM} &nbsp; {S_FORUM_SELECT}<br /><br />
			  {CAUSE_MOVE} : <input type="text" name="cause_of_move" size="50" /><br />
			  <br />
			  {MESSAGE_TEXT}</span><br />
			  <br />
			  {S_HIDDEN_FIELDS} 
			  <input class="mainoption" type="submit" name="confirm" value="{L_YES}" />
			  &nbsp;&nbsp; 
			  <input class="liteoption" type="submit" name="cancel" value="{L_NO}" />
			</td>
		  </tr>
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
      <td width="7"  class="row2"></td>
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
  </table>
</form>
