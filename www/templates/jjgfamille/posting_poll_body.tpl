
			<tr>
		<td class="colonneGauche"></td>
		<td class="degradeGauche"></td>
				<th class="thHead" colspan="2">{L_ADD_A_POLL}</th>
		<td class="degradeDroite"></td>
		<td class="colonneDroite"></td>
	        </tr>
			<tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
				<td class="row1" colspan="2"><span class="gensmall">{L_ADD_POLL_EXPLAIN}</span></td>
	        </tr>
            <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
				<td class="row1"><span class="gen"><b>{L_POLL_QUESTION}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="poll_title" size="50" maxlength="255" class="post" value="{POLL_TITLE}" /></span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
			</tr>
			<!-- BEGIN poll_option_rows -->
            <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
				<td class="row1"><span class="gen"><b>{L_POLL_OPTION}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="poll_option_text[{poll_option_rows.S_POLL_OPTION_NUM}]" size="50" class="post" maxlength="255" value="{poll_option_rows.POLL_OPTION}" /></span> &nbsp;<input type="submit" name="edit_poll_option" value="{L_UPDATE_OPTION}" class="liteoption" /> <input type="submit" name="del_poll_option[{poll_option_rows.S_POLL_OPTION_NUM}]" value="{L_DELETE_OPTION}" class="liteoption" /></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
			</tr>
			<!-- END poll_option_rows -->
            <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
				<td class="row1"><span class="gen"><b>{L_POLL_OPTION}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="add_poll_option_text" size="50" maxlength="255" class="post" value="{ADD_POLL_OPTION}" /></span> &nbsp;<input type="submit" name="add_poll_option" value="{L_ADD_OPTION}" class="liteoption" /></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
	   </tr><!--
	    <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
			<td class="row1"><span class="gen"><b>{L_MAX_VOTE}</b></span></td>
			<td class="row2"><span class="genmed"><input type="text" name="max_vote" size="3" maxlength="3" class="post" value="{MAX_VOTE}" /></span>&nbsp;<span class="gen"><b>{L_OPTIONS}</b></span> &nbsp; <span class="gensmall">{L_MAX_VOTE_EXPLAIN}</span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
	    </tr>-->
            <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
				<td class="row1"><span class="gen"><b>{L_POLL_LENGTH}</b></span></td>
		<!-- Boris 12/02/2007 Vote Manage Mod 
		DELETION
				<td class="row2"><span class="genmed"><input type="text" name="poll_length" size="3" maxlength="3" class="post" value="{POLL_LENGTH}" /></span>&nbsp;<span class="gen"><b>{L_DAYS}</b></span> &nbsp; <span class="gensmall">{L_POLL_LENGTH_EXPLAIN}</span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
			</tr>
			-->
		<td class="row2"><span class="genmed"><input type="text" name="poll_length" size="3" maxlength="3" class="post" value="{POLL_LENGTH}" /></span>&nbsp;<span class="gen"><b>{L_DAYS}</b></span>
				<span class="genmed"><input type="text" name="poll_length_h" size="3" maxlength="3" class="post" value="{POLL_LENGTH_H}" /></span>&nbsp;<span class="gen"><b>{L_HOURS}</b></span>&nbsp; <span class="gensmall">{L_POLL_LENGTH_EXPLAIN}</span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
		</tr>
            <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td class="row1"><span class="gen"><b>{L_VHIDE}</b></span></td>
		<td class="row2" class="gen"><span class="gensmall">
		<!--
			<input type="checkbox" name="hide_dr" {HIDE_DR}/> {L_HIDE_DR} 
			( <input type="checkbox" name="hide_exp" {HIDE_DR_EXP}/> {L_HIDE_DR_EXP} )</span><br />
			<span style="background: url('{IMG_LIST_BRANCH0}') top left no-repeat; padding-left: 19px;" class="gensmall">-->
			<input type="checkbox" name="hide_sr" {HIDE_SR}/> {L_HIDE_SR}</span><br />
			<span style="background: url('{IMG_LIST_BRANCH0}') top left no-repeat; padding-left: 19px;" class="gensmall">
			<input type="checkbox" name="hide_voters" {HIDE_VOTERS}/> {L_HIDE_VOTERS}</span>
			
			<input type="hidden" name="undo_vote" value="" />
			<input type="hidden" name="hide_dr" value="checked" />
			<input type="hidden" name="hide_exp" value="" />
			<input type="hidden" name="max_vote" value="1" />
			
			</td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
	</tr>
	<!--
	<tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
		<td class="row1"><span class="gen"><b>{L_UNDO}</b></span></td>
		<td class="row2"><input type="checkbox" name="undo_vote" {UNDO_VOTE} /> <span class="gensmall">{L_UNDO_VOTE}</span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
	</tr>
	-->
	<!-- BEGIN switch_poll_delete_toggle -->
            <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
				<td class="row1"><span class="gen"><b>{L_POLL_DELETE}</b></span></td>
				<td class="row2"><input type="checkbox" name="poll_delete" /></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
			</tr>
			<!-- END switch_poll_delete_toggle -->
