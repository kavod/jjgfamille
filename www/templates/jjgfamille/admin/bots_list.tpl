<h1>{L_BOTS_TITLE}</h1>
<P>{L_BOTS_TEXT}</p>
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_BOTS}</th>
		<th class="thTop">{L_EDIT}</th>
		<th class="thCornerR">{L_DELETE}</th>
	</tr>
	<!-- BEGIN bots -->
	<tr>
		<td class="{bots.ROW_CLASS}">{bots.BOT_NAME}</td>
		<td class="{bots.ROW_CLASS}"><a href="{bots.U_BOT_EDIT}">{L_EDIT}</a></td>
		<td class="{bots.ROW_CLASS}"><a href="{bots.U_BOT_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END bots -->
	<tr>
		<td class="catBottom" colspan="4" align="center">{S_HIDDEN_FIELDS}
		<form method=post action="{S_BOTS_ACTION}">
		<input type="submit" value="{L_ADD_NEW_BOT}" class="mainoption"></td></form>
	</tr>
</table><br />