 
<tr>
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td> 
  <td class="row2" colspan="2"><br clear="all" />
	<table cellspacing="0" cellpadding="4" border="0" align="center">
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{POLL_QUESTION}</b></span></td>
	  </tr>
	  <tr> 
		<td align="center"> 
		  <table cellspacing="0" cellpadding="2" border="0">
			<!-- BEGIN poll_option -->
			<tr> 
			  <td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
			  <td> 
				<table cellspacing="0" cellpadding="0" border="0">
				  <tr> 
					<td><img src="../templates/jjgfamille/images/vote_lcap.gif" width="4" alt="" height="12" /></td>
					<td><img src="{poll_option.POLL_OPTION_IMG}" width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="12" alt="{poll_option.POLL_OPTION_PERCENT}" /></td>
					<td><img src="../templates/jjgfamille/images/vote_rcap.gif" width="4" alt="" height="12" /></td>
				  </tr>
				</table>
			  </td>
			  <td align="center"><b><span class="gen">&nbsp;{poll_option.POLL_OPTION_PERCENT}&nbsp;</span></b></td>
			  <td align="center"><span class="gen">[ {poll_option.POLL_OPTION_RESULT} ]</span></td>
			</tr>
			<!-- END poll_option -->
		  </table>
		</td>
	  </tr>
	  <!-- Vote Manage Mod
	  DELETION
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{L_TOTAL_VOTES} : {TOTAL_VOTES}</b></span></td>
	  </tr>
	  -->
	  <!-- BEGIN voted -->
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{voted.L_VOTED}{voted.VOTED}</b></span></td>
	  </tr>
	  <!-- END voted -->
	  <!-- BEGIN total -->
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{total.L_TOTAL_VOTES}{total.TOTAL_VOTES}</b></span></td>
	  </tr>
	  <!-- END total -->
	  <!-- BEGIN after -->
	  <tr> 
		<td colspan="4" align="center"><span class="gensmall">{after.L_RESULTS_AFTER}</span></td>
	  </tr>
	  <!-- END after -->
	  <!-- BEGIN expires -->
	  <tr> 
		<td colspan="4" align="center"><span class="gensmall">{expires.L_POLL_EXPIRES}{expires.POLL_EXPIRES}</span></td>
	  </tr>
	  <!-- END expires -->
	  <!-- BEGIN vote_manage -->
	  <tr>
	    <td colspan="4" align="center"><span class="gensmall">{vote_manage.VOTE_MANAGE}</span></td>
	  </tr>
	  <!-- END vote_manage -->
	  
	</table>
	<br clear="all" />
  </td>
      <td width="7"  class="row2"></td>
      <td class="colonneDroite"></td>
</tr>
