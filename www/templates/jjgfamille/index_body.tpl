<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom">
	<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	<td align="right" valign="bottom" class="gensmall">
		<!-- BEGIN switch_user_logged_in -->
		<a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
		<!-- END switch_user_logged_in -->
		<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a></td>
  </tr>
</table>

<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0" class="forumline">
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
	<th colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	<td class="degradeDroite"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- BEGIN catrow -->
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" colspan="2" height="28"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td>
	<td class="rowpic" colspan="3" align="right" width="280">&nbsp;</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- BEGIN forumrow -->
  <tr> 
	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row1" align="center" valign="middle" width="50" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="33" height="25" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row1" height="50"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a><br />
	  </span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
	  </span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td>
	<td class="row3" align="center" valign="middle" width="70" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
	<td class="row3" align="center" valign="middle" width="70" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
	<td class="row1" align="center" valign="middle" width="140" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
	
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <!-- END forumrow -->
  <!-- END catrow -->
  <tr>
  	<td colspan="2" rowspan="2" class="coinBG"></td>
  	<td colspan="5" height="7" class="row2"></td>
  	<td colspan="2" rowspan="2" class="coinBD"></td>
  </tr>
  <tr>
  	<td colspan="5" class="ligneBas"></td>
  </tr>
</table>

<table width="100%" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
<!--	<td align="left"><span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span></td> -->
 	<td align="left">
 	<!-- BEGIN switch_user_logged_in -->
 		<span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span>
 	<!-- END switch_user_logged_in -->
 	</td>
	<td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>
  <tr> 
	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catHead" colspan="2" height="28"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_WHO_IS_ONLINE}</a></span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row1" align="center" valign="middle" rowspan="2"><img src="../templates/jjgfamille/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
	<td class="row1" align="left"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ] &nbsp; {L_WHOSONLINE_BOT}<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}{BOT_INFO}</span></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr>
  	<td colspan="2" rowspan="2" class="coinBG"></td>
  	<td colspan="2" height="7" class="row2"></td>
  	<td colspan="2" rowspan="2" class="coinBD"></td>
  </tr>
  <tr>
  	<td colspan="2" class="ligneBas"></td>
  </tr>
</table>

<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
	<td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
</tr>
</table>

<br clear="all" />

<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td width="20" align="center"><img src="../templates/jjgfamille/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="../templates/jjgfamille/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="../templates/jjgfamille/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>
