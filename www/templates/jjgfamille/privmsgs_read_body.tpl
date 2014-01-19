
<table cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td valign="middle">{INBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{INBOX} &nbsp;</span></td>
	<td valign="middle">{SENTBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{SENTBOX} &nbsp;</span></td>
	<td valign="middle">{OUTBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{OUTBOX} &nbsp;</span></td>
	<td valign="middle">{SAVEBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{SAVEBOX}</span></td>
  </tr>
</table>

<br clear="all" />

<form method="post" action="{S_PRIVMSGS_ACTION}">
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
	  <td valign="middle">{REPLY_PM_IMG}</td>
	  <td width="100%"><span class="nav">&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="3" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="3" height="7" class="row2"></td>
    </tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th colspan="3" class="thHead" nowrap="nowrap">{BOX_NAME} :: {L_MESSAGE}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td width="70" class="row2"><span class="genmed">{L_FROM}:</span></td>
	  <td class="row2" colspan="2"><span class="genmed">{MESSAGE_FROM}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td width="70" class="row2"><span class="genmed">{L_TO}:</span></td>
	  <td class="row2" colspan="2"><span class="genmed">{MESSAGE_TO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td width="70" class="row2"><span class="genmed">{L_POSTED}:</span></td>
	  <td class="row2" colspan="2"><span class="genmed">{POST_DATE}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td width="70" class="row2"><span class="genmed">{L_SUBJECT}:</span></td>
	  <td class="row2"><span class="genmed">{POST_SUBJECT}</span></td>
	  <td nowrap="nowrap" class="row2" align="right"> {QUOTE_PM_IMG} {EDIT_PM_IMG}</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td valign="top" colspan="3" class="row1"><span class="postbody">{MESSAGE}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td height="28" valign="bottom" colspan="3" class="row1"> 
		<table cellspacing="0" cellpadding="0" border="0" height="18">
		  <tr> 
			<td valign="middle" nowrap="nowrap">{PROFILE_IMG} {PM_IMG} {EMAIL_IMG} 
			  {WWW_IMG} {AIM_IMG} {YIM_IMG} {MSN_IMG}</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><script language="JavaScript" type="text/javascript"><!-- 

		if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
			document.write('{ICQ_IMG}');
		else
			document.write('<div style="position:relative"><div style="position:absolute">{ICQ_IMG}</div><div style="position:absolute;left:3px">{ICQ_STATUS_IMG}</div></div>');
		  
		  //--></script><noscript>{ICQ_IMG}</noscript></td>
		  </tr>
		</table>
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catBottom" colspan="3" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="save" value="{L_SAVE_MSG}" class="liteoption" />
		&nbsp; 
		<input type="submit" name="delete" value="{L_DELETE_MSG}" class="liteoption" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="3" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="3" width="5" class="ligneBas"></td>
    </tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td>{REPLY_PM_IMG}</td>
	  <td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
  </table>
</form>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td valign="top" align="right"><span class="gensmall">{JUMPBOX}</span></td>
  </tr>
</table>
