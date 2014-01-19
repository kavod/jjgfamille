<h1>{L_BOTS_TITLE}</h1>

<p>{L_BOTS_TEXT}</p>

<form name="color" action="{S_BOTS_ACTION}" method="POST">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">

	<tr>
		<th class="catBottom" colspan="2">{BOT_NAME}</th>
	</tr>

	<tr>
		<td class="row2" width="45%"><b>{L_BOT_NAME}:</b></td>
		<td class="row2" width="55%"><input class="post" type="text" size="25" maxlength="100" name="bot_name" value="{BOT_NAME}">		</td>
	
	</tr>

	<tr>
		<td class="row1" width="45%"><b>{L_BOT_IP}:</b><br />{L_BOT_IP_EXPLAIN}</td>
		<td class="row1" width="55%"><textarea name="bot_ips" cols=50 rows=6>{BOT_IP}</textarea></td>	
	</tr>
	<tr>
		<td class="catBottom" colspan="4" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
		</td>
	</tr>
</table></form>

<br clear="all">