			<tr>
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
				<td class="row2" colspan="2"><br clear="all" /><form method="POST" action="{S_POLL_ACTION}"><table cellspacing="0" cellpadding="4" border="0" align="center">
		<tr>
			<td align="center"><span class="gen"><b>{MAX_VOTING_1_EXPLAIN}{MAX_VOTE}{MAX_VOTING_2_EXPLAIN}{POLL_VOTE_BR}</b> {POLL_VOTE_BR}{POLL_VOTE_BR}</span></td>
		</tr>
					<tr>
						<td align="center"><span class="gen"><b>{POLL_QUESTION}</b></span></td>
					</tr>
					<tr>
						<td align="center"><table cellspacing="0" cellpadding="2" border="0">
							<!-- BEGIN poll_option -->
							<tr>
								<!-- Boris 12/02/2007 Vote Manage Mod
								DELETION
								<td><input type="radio" name="vote_id" value="{poll_option.POLL_OPTION_ID}" />&nbsp;</td>
								-->
								<td><input type="{poll_option.POLL_VOTE_BOX}" name="vote_id[]" value="{poll_option.POLL_OPTION_ID}" {poll_option.POLL_OPTION_DISABLED}/>&nbsp;</td>
								<td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
							</tr>
							<!-- END poll_option -->
						</table></td>
					</tr>
					<tr>
						<td align="center">
			<input type="submit" name="submit" value="{L_SUBMIT_VOTE}" class="liteoption" />
		  </td>
					</tr>
					<tr>	
		  <td align="center"><span class="gensmall"><b><a href="{U_VIEW_RESULTS}" class="gensmall">{L_VIEW_RESULTS}</a></b></span></td>
					</tr>
				</table>{S_HIDDEN_FIELDS}</form></td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
			</tr>