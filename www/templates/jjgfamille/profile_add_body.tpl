
<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post">

{ERROR_BOX}

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" class="forumline">
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>
<!-- BEGIN confirm_assoc -->
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
		<th class="thHead" colspan="2" height="25" valign="middle"></th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1" width="38%"><span class="gen">{confirm_assoc.L_CONFIRM_ASSOC}</span></td>
		<td class="row3"><span class="gensmall"><input type="checkbox" name="confirm_assoc" value="ok" />{confirm_assoc.YES_CONFIRM_ASSOC}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
<!-- END confirm_assoc -->
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
		<th class="thHead" colspan="2" height="25" valign="middle">{L_REGISTRATION_INFO}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row3" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN switch_namechange_disallowed -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row3"><input type="hidden" name="username" value="{USERNAME}" /><span class="gen"><b>{USERNAME}</b></span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_namechange_disallowed -->
	<!-- BEGIN switch_namechange_allowed -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row3"><input type="text" class="post" style="width:200px" name="username" size="25" maxlength="25" value="{USERNAME}" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_namechange_allowed -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
		<td class="row3"><input type="text" class="post" style="width:200px" name="email" size="25" maxlength="255" value="{EMAIL}" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN switch_edit_profile -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_CURRENT_PASSWORD}: *</span><br />
		<span class="gensmall">{L_CONFIRM_PASSWORD_EXPLAIN}</span></td>
	  <td class="row3"> 
		<input type="password" class="post" style="width: 200px" name="cur_password" size="25" maxlength="32" value="{CUR_PASSWORD}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_edit_profile -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_NEW_PASSWORD}: *</span><br />
		<span class="gensmall">{L_PASSWORD_IF_CHANGED}</span></td>
	  <td class="row3"> 
		<input type="password" class="post" style="width: 200px" name="new_password" size="25" maxlength="32" value="{NEW_PASSWORD}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_CONFIRM_PASSWORD}: * </span><br />
		<span class="gensmall">{L_PASSWORD_CONFIRM_IF_CHANGED}</span></td>
	  <td class="row3"> 
		<input type="password" class="post" style="width: 200px" name="password_confirm" size="25" maxlength="32" value="{PASSWORD_CONFIRM}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- Visual Confirmation -->
	<!-- BEGIN switch_confirm -->
	<tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1" colspan="2" align="center"><span class="gensmall">{L_CONFIRM_CODE_IMPAIRED}</span><br /><br />{CONFIRM_IMG}<br /><br /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_CONFIRM_CODE}: * </span><br /><span class="gensmall">{L_CONFIRM_CODE_EXPLAIN}</span></td>
	  <td class="row3"><input type="text" class="post" style="width: 200px" name="confirm_code" size="6" maxlength="6" value="" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_confirm -->
	<!-- BEGIN switch_anti_bot_question -->
	<tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td class="row1" valign="top"><span class="gen">{L_ABQ_QUESTION}:</span><br />
			<span class="gensmall">{L_ABQ_EXPLAIN}</span></td>
		<td class="row2"><span class="gen">{L_ABQ_QUEST}</span>
		</td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
	</tr>
	<tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td class="row1" colspan="2" align="center"><span class="gensmall">{L_ABQ_HINWEIS}</span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
	</tr>
	<tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td class="row1"><span class="gen">{L_ABQ_ANSWER}: *</span><span class="gensmall">{L_ABQ_ANSWER_EXPLAIN}</span></td>
		<td class="row2">{S_ABQ}</td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
	
	</tr>
	<!-- END switch_anti_bot_question -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catHead" colspan="2" height="28">&nbsp;</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th class="thHead" colspan="2" height="25" valign="middle">{L_PROFILE_INFO}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row3" colspan="2"><span class="gensmall">{L_PROFILE_INFO_NOTICE}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_ICQ_NUMBER}:</span></td>
	  <td class="row3"> 
		<input type="text" name="icq" class="post" style="width: 100px"  size="10" maxlength="15" value="{ICQ}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_AIM}:</span></td>
	  <td class="row3"> 
		<input type="text" class="post" style="width: 150px"  name="aim" size="20" maxlength="255" value="{AIM}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>
	  <td class="row3"> 
		<input type="text" class="post" style="width: 150px"  name="msn" size="20" maxlength="255" value="{MSN}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row3"> 
		<input type="text" class="post" style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
<!-- BEGIN only_show_notbot -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
	  <td class="row3"> 
		<input type="text" class="post" style="width: 200px"  name="website" size="25" maxlength="255" value="{WEBSITE}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
<!-- END only_show_notbot -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_LOCATION}:</span></td>
	  <td class="row3"> 
		<input type="text" class="post" style="width: 200px"  name="location" size="25" maxlength="100" value="{LOCATION}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td class="row3"> 
		<input type="text" class="post" style="width: 200px"  name="occupation" size="25" maxlength="100" value="{OCCUPATION}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row3"> 
		<input type="text" class="post" style="width: 200px"  name="interests" size="35" maxlength="150" value="{INTERESTS}" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_BIRTHDAY}:<br /><small>{L_BIRTHDAY_EXPLAIN}</small></span></td>
	  <td class="row3"><span class="gensmall">{BIRTHDAY_SELECT}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row3"> 
		<textarea name="signature" style="width: 300px"  rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catHead" colspan="2" height="28">&nbsp;</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th class="thHead" colspan="2" height="25" valign="middle">{L_PREFERENCES}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_PUBLIC_VIEW_EMAIL}:</span></td>
	  <td class="row3"> 
		<input type="radio" name="viewemail" value="1" {VIEW_EMAIL_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="viewemail" value="0" {VIEW_EMAIL_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_HIDE_USER}:</span></td>
	  <td class="row3"> 
		<input type="radio" name="hideonline" value="1" {HIDE_USER_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="hideonline" value="0" {HIDE_USER_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_REPLY}:</span><br />
		<span class="gensmall">{L_NOTIFY_ON_REPLY_EXPLAIN}</span></td>
	  <td class="row3"> 
		<input type="radio" name="notifyreply" value="1" {NOTIFY_REPLY_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifyreply" value="0" {NOTIFY_REPLY_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_PRIVMSG}:</span></td>
	  <td class="row3"> 
		<input type="radio" name="notifypm" value="1" {NOTIFY_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifypm" value="0" {NOTIFY_PM_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_POPUP_ON_PRIVMSG}:</span><br /><span class="gensmall">{L_POPUP_ON_PRIVMSG_EXPLAIN}</span></td>
	  <td class="row3"> 
		<input type="radio" name="popup_pm" value="1" {POPUP_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="popup_pm" value="0" {POPUP_PM_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_ALWAYS_ADD_SIGNATURE}:</span></td>
	  <td class="row3"> 
		<input type="radio" name="attachsig" value="1" {ALWAYS_ADD_SIGNATURE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="attachsig" value="0" {ALWAYS_ADD_SIGNATURE_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_BBCODE}:</span></td>
	  <td class="row3"> 
		<input type="radio" name="allowbbcode" value="1" {ALWAYS_ALLOW_BBCODE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowbbcode" value="0" {ALWAYS_ALLOW_BBCODE_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_HTML}:</span></td>
	  <td class="row3"> 
		<input type="radio" name="allowhtml" value="1" {ALWAYS_ALLOW_HTML_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowhtml" value="0" {ALWAYS_ALLOW_HTML_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}:</span></td>
	  <td class="row3"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_BOARD_LANGUAGE}:</span></td>
	  <td class="row3"><span class="gensmall">{LANGUAGE_SELECT}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_BOARD_STYLE}:</span></td>
	  <td class="row3"><span class="gensmall">{STYLE_SELECT}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_TIMEZONE}:</span></td>
	  <td class="row3"><span class="gensmall">{TIMEZONE_SELECT}</span></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}:</span><br />
		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
	  <td class="row3"> 
		<input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" class="post" />
	  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN switch_avatar_block -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catHead" colspan="2" height="28">&nbsp;</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th class="thHead" colspan="2" height="12" valign="middle">{L_AVATAR_PANEL}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1" colspan="2"><table width="70%" cellspacing="2" cellpadding="0" border="0" align="center">
			<tr> 
				<td width="65%"><span class="gensmall">{L_AVATAR_EXPLAIN}</span></td>
				<td align="center"><span class="gensmall">{L_CURRENT_IMAGE}</span><br />{AVATAR}<br /><input type="checkbox" name="avatardel" />&nbsp;<span class="gensmall">{L_DELETE_AVATAR}</span></td>
			</tr>
		</table></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN switch_avatar_local_upload -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_FILE}:</span></td>
		<td class="row3"><input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}" /><input type="file" name="avatar" class="post" style="width:200px" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_avatar_local_upload -->
	<!-- BEGIN switch_avatar_remote_upload -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_URL}:</span><br /><span class="gensmall">{L_UPLOAD_AVATAR_URL_EXPLAIN}</span></td>
		<td class="row3"><input type="text" name="avatarurl" size="40" class="post" style="width:200px" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_avatar_remote_upload -->
	<!-- BEGIN switch_avatar_remote_link -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1"><span class="gen">{L_LINK_REMOTE_AVATAR}:</span><br /><span class="gensmall">{L_LINK_REMOTE_AVATAR_EXPLAIN}</span></td>
		<td class="row3"><input type="text" name="avatarremoteurl" size="40" class="post" style="width:200px" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_avatar_remote_link -->
	<!-- BEGIN switch_avatar_local_gallery -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1"><span class="gen">{L_AVATAR_GALLERY}:</span></td>
		<td class="row3"><input type="submit" name="avatargallery" value="{L_SHOW_GALLERY}" class="liteoption" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_avatar_local_gallery -->
	<!-- END switch_avatar_block -->
	
	
	
	<!-- BEGIN switch_photo_block -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
	  <td class="catHead" colspan="2" height="28">&nbsp;</td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
	  <th class="thHead" colspan="2" height="12" valign="middle">{L_PHOTO_PANEL}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
	</tr>
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1" colspan="2"><table width="70%" cellspacing="2" cellpadding="0" border="0" align="center">
			<tr> 
				<td width="65%"><span class="gensmall">{L_PHOTO_EXPLAIN}</span></td>
				<td align="center"><span class="gensmall">{L_CURRENT_IMAGE}</span><br />{PHOTO}<br /><input type="checkbox" name="photodel" />&nbsp;<span class="gensmall">{L_DELETE_AVATAR}</span></td>
			</tr>
		</table></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- BEGIN switch_photo_local_upload -->
	<tr> 
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="row1"><span class="gen">{L_UPLOAD_PHOTO_FILE}:</span></td>
		<td class="row3"><input type="hidden" name="MAX_FILE_SIZE" value="{PHOTO_SIZE}" /><input type="file" name="photo" class="post" style="width:200px" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
	<!-- END switch_photo_local_upload -->
	<!-- END switch_photo_block -->
	
	
	<tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
		<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
	</tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="2" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="2" width="5" class="ligneBas"></td>
    </tr>
</table>

</form>
