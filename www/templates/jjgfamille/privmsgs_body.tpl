 
<script language="Javascript" type="text/javascript">
	//
	// Should really check the browser to stop this whining ...
	//
	function select_switch(status)
	{
		for (i = 0; i < document.privmsg_list.length; i++)
		{
			document.privmsg_list.elements[i].checked = status;
		}
	}
</script>

<table border="0" cellspacing="0" cellpadding="0" align="center" width="98%">
  <tr> 
	<td valign="top" align="center" width="100%"> 
	  <table height="40" cellspacing="2" cellpadding="2" border="0">
		<tr valign="middle"> 
		  <td>{INBOX_IMG}</td>
		  <td><span class="cattitle">{INBOX} &nbsp;</span></td>
		  <td>{SENTBOX_IMG}</td>
		  <td><span class="cattitle">{SENTBOX} &nbsp;</span></td>
		  <td>{OUTBOX_IMG}</td>
		  <td><span class="cattitle">{OUTBOX} &nbsp;</span></td>
		  <td>{SAVEBOX_IMG}</td>
		  <td><span class="cattitle">{SAVEBOX} &nbsp;</span></td>
		</tr>
	  </table>
	</td>
	<td align="right"> 
	  <!-- BEGIN switch_box_size_notice -->
	  <table width="175" cellspacing="1" cellpadding="2" border="0" class="bodyline">
		<tr> 
		  <td colspan="3" width="175" class="row1" nowrap="nowrap"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
		</tr>
		<tr> 
		  <td colspan="3" width="175" class="row2">
			<table cellspacing="0" cellpadding="1" border="0">
			  <tr> 
				<td bgcolor="{T_TD_COLOR2}"><img src="../templates/jjgfamille/images/site/px_barre.png" width="{INBOX_LIMIT_IMG_WIDTH}" height="8" alt="{INBOX_LIMIT_PERCENT}" /></td>
			  </tr>
			</table>
		  </td>
		</tr>
		<tr> 
		  <td width="33%" class="row1"><span class="gensmall">0%</span></td>
		  <td width="34%" align="center" class="row1"><span class="gensmall">50%</span></td>
		  <td width="33%" align="right" class="row1"><span class="gensmall">100%</span></td>
		</tr>
	  </table>
	  <!-- END switch_box_size_notice -->
	</td>
  </tr>
</table>

<br clear="all" />

<form method="post" name="privmsg_list" action="{S_PRIVMSGS_ACTION}">
  <table width="98%" cellspacing="3" cellpadding="3" border="0" align="center">
	<tr> 
	  <td align="left" valign="middle">{POST_PM_IMG}</td>
	  <td align="left" width="100%">&nbsp;<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	  <td align="right" nowrap="nowrap"><span class="gensmall">{L_DISPLAY_MESSAGES}: 
		<select name="msgdays">{S_SELECT_MSG_DAYS}
		</select>
		<input type="submit" value="{L_GO}" name="submit_msgdays" class="liteoption" />
		</span></td>
	</tr>
  </table>

  <table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="5" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="5" height="7" class="row2"></td>
    </tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th width="40" height="25" class="thCornerL" nowrap="nowrap">&nbsp;{L_FLAG}&nbsp;</th>
	  <th class="thTop" nowrap="nowrap">&nbsp;{L_SUBJECT}&nbsp;</th>
	  <th width="130" class="thTop" nowrap="nowrap">&nbsp;{L_FROM_OR_TO}&nbsp;</th>
	  <th width="180" class="thTop" nowrap="nowrap">&nbsp;{L_DATE}&nbsp;</th>
	  <th width="70" class="thCornerR" nowrap="nowrap">&nbsp;{L_MARK}&nbsp;</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN listrow -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="{listrow.ROW_CLASS}" align="center" valign="middle"><img src="{listrow.PRIVMSG_FOLDER_IMG}" width="33" height="25" alt="{listrow.L_PRIVMSG_FOLDER_ALT}" title="{listrow.L_PRIVMSG_FOLDER_ALT}" /></td>
	  <td valign="middle" class="{listrow.ROW_CLASS}"><span class="topictitle">&nbsp;<a href="{listrow.U_READ}" class="topictitle">{listrow.SUBJECT}</a></span></td>
	  <td valign="middle" align="center" class="{listrow.ROW_CLASS}"><span class="name">&nbsp;<a href="{listrow.U_FROM_USER_PROFILE}" class="name">{listrow.FROM}</a></span></td>
	  <td align="center" valign="middle" class="{listrow.ROW_CLASS}"><span class="postdetails">{listrow.DATE}</span></td>
	  <td align="center" valign="middle" class="{listrow.ROW_CLASS}"><span class="postdetails"> 
		<input type="checkbox" name="mark[]2" value="{listrow.S_MARK_ID}" />
		</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END listrow -->
	<!-- BEGIN switch_no_messages -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1" colspan="5" align="center" valign="middle"><span class="gen">{L_NO_MESSAGES}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_no_messages -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catBottom" colspan="5" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="save" value="{L_SAVE_MARKED}" class="mainoption" />
		&nbsp; 
		<input type="submit" name="delete" value="{L_DELETE_MARKED}" class="liteoption" />
		&nbsp; 
		<input type="submit" name="deleteall" value="{L_DELETE_ALL}" class="liteoption" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="5" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="5" class="ligneBas"></td>
    </tr>
  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="left" valign="middle"><span class="nav">{POST_PM_IMG}</span></td>
	  <td align="left" valign="middle" width="100%"><span class="nav">{PAGE_NUMBER}</span></td>
	  <td align="right" valign="top" nowrap="nowrap"><b><span class="gensmall"><a href="javascript:select_switch(true);" class="gensmall">{L_MARK_ALL}</a> :: <a href="javascript:select_switch(false);" class="gensmall">{L_UNMARK_ALL}</a></span></b><br /><span class="nav">{PAGINATION}<br /></span><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
  </table>
</form>

<table width="100%" border="0">
  <tr> 
	<td align="right" valign="top">{JUMPBOX}</td>
  </tr>
</table>
