	<tr>
		<td colspan="4" valign="top">
		<p align="center"><span class="genmed">{BLOG_HEADER}</span></p>
		{ERROR_BOX}
		<table style="width: 99%;" border="0" cellspacing="0" cellpadding="0">
		<tbody>
<!-- BEGIN boite -->
			<tr>
				<td width="5" height="0"></td>
				<td width="7" height="0"></td>
				<td height="10"></td>
				<td width="7" height="0"></td>
				<td width="5" height="0"></td>
			</tr>
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
				<td width="7" class="row2"></td>
				<td class="row2" style="vertical-align: top;">
				<table width="100%">
<!-- BEGIN postrow -->
<!-- BEGIN switch_principal -->
			<tr> 
				<td class="catLeft" height="28" colspan="2">
				<table border="0" width="100%" margin="0" padding="0">
					<tr>
						<td align="left"><span class="cattitle"><b><a href="{boite.postrow.U_ARTICLE}">{boite.postrow.POST_SUBJECT}</a></b></span> <span class="gen"><small><a href="{boite.postrow.U_COMS}">{boite.postrow.NB_COMMENTS}</a></small></span></td>
						<td align="right">{boite.postrow.MOVE} {boite.postrow.EDIT_IMG} {boite.postrow.DELETE_IMG} {boite.postrow.IP_IMG}</td>
					</tr>
				</table></td>
			</tr>
<!-- END switch_principal -->
	<tr> 
<!-- BEGIN switch_detail -->
		<td width="150" align="left" valign="top" class="{boite.postrow.ROW_CLASS}"><span class="name"><a name="{boite.postrow.U_POST_ID}"></a><b>{boite.postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{boite.postrow.POSTER_RANK}<br />{boite.postrow.RANK_IMAGE}{boite.postrow.POSTER_AVATAR}<br /><br />{boite.postrow.POSTER_JOINED}<br />{boite.postrow.POSTER_POSTS}<br />{boite.postrow.POSTER_FROM}</span><br /></td>
		<td class="{boite.postrow.ROW_CLASS}" height="28" valign="top"><table border="0" cellspacing="0" cellpadding="3" width="100%">
			<tr>
				<td width="100%"><a href="{boite.postrow.U_MINI_POST}"><img src="{boite.postrow.MINI_POST_IMG}" width="12" height="9" alt="{boite.postrow.L_MINI_POST_ALT}" title="{boite.postrow.L_MINI_POST_ALT}" border="0" /></a><span class="postdetails">{L_POSTED}: {boite.postrow.POST_DATE}<span class="gen">&nbsp;</span>&nbsp; &nbsp;{L_POST_SUBJECT}: {boite.postrow.POST_SUBJECT}</span></td>
				<td valign="top" nowrap="nowrap"> {boite.postrow.EDIT_IMG} {boite.postrow.DELETE_IMG} {boite.postrow.IP_IMG}</td>
			</tr>
			<tr> 
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
<!-- END switch_detail -->
				<td colspan="2" class="contenuMessage">
<!-- BEGIN date -->
				<span class="postdetails">{L_POSTED}: {boite.postrow.POST_DATE}</span><br />
<!-- END date -->
				<span class="postbody">{boite.postrow.MESSAGE}
<!-- BEGIN switch_detail -->
				{boite.postrow.SIGNATURE}
<!-- END switch_detail -->
				</span><span class="gensmall">{boite.postrow.EDITED_MESSAGE}</span></td>
<!-- BEGIN switch_detail -->
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="{boite.postrow.ROW_CLASS}" width="150" align="left" valign="middle"><span class="nav"><a href="#top" class="nav">{L_BACK_TO_TOP}</a></span></td>
		<td class="{boite.postrow.ROW_CLASS}" height="28" valign="bottom" nowrap="nowrap"><table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
			<tr> 
				<td valign="middle" nowrap="nowrap">{boite.postrow.PROFILE_IMG} {boite.postrow.PM_IMG} {boite.postrow.BLOG_IMG} {boite.postrow.EMAIL_IMG} {boite.postrow.WWW_IMG} {boite.postrow.AIM_IMG} {boite.postrow.YIM_IMG} {boite.postrow.MSN_IMG}<script language="JavaScript" type="text/javascript"><!-- 

	if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
		document.write(' {boite.postrow.ICQ_IMG}');
	else
		document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{boite.postrow.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{boite.postrow.ICQ_STATUS_IMG}</div></div>');
				
				//--></script><noscript>{boite.postrow.ICQ_IMG}</noscript></td>
			</tr>
		</table></td>
<!-- END switch_detail -->
	</tr>
	<tr>
		<td class="spaceRow" colspan="2" height="1"><img src="../images/forum/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
<!-- BEGIN switch_principal -->
			<tr> 
				<td class="catLeft" height="28" colspan="2"><a name="coms"></a><span class="cattitle"><b><a href="{boite.postrow.U_COMS}">{L_COMMENTS}</a></b></span> <span class="gen"><small>{boite.postrow.NB_COMMENTS}</small></span></td>
			</tr>
<!-- END switch_principal -->
<!-- END postrow -->
<!-- BEGIN reply -->
	<form method="post" action="{boite.reply.U_ACTION}">
	<tr>
		<td class="catLeft" height="28" colspan="2"><span class="cattitle"><b>{boite.reply.L_LEAVE_YOUR_COMMENT}</b></span></td>
	</tr>
	<tr>
		<td class="row1" valign="top"><span class="gen"><b>{boite.reply.L_SUBJECT}</b></span></td>
		<td class="row2" valign="top"><input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="" /></td>
	</tr>
<!-- BEGIN switch_username_select -->
	<tr>
		<td class="row1"><span class="gen"><b>{boite.reply.L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" /> {boite.reply.L_IDENTIFY}</span></td>
	</tr>
<!-- END switch_username_select -->
	<tr>
		<td class="row1" valign="top"><span class="gen"><b>{boite.reply.L_MESSAGE}</b></span></td>
		<td class="row2" valign="top"><textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post">{boite.reply.MESSAGE}</textarea></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center" height="28"> {boite.reply.S_HIDDEN_FORM_FIELDS}<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{boite.reply.L_SUBMIT}" /></td>
	</tr>
	</form>
<!-- END reply -->
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
<!-- END boite -->
		</tbody>
		</table>
		
		
		
		
		</td>
		<td colspan="3" valign="top">{COLONNE_DROITE}</td>
	</tr>
</table>