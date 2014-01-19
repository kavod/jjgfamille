
<h1>{L_ACCESS_TITLE}</h1>

<p>{L_ACCESS_TEXT}</p>

<form method="post" action="{S_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_USERNAME}</th>
        <th class="thTop">{L_PERMISSION}</th>
		<th class="thCornerR">{L_DELETE}</th>
	</tr>
	<!-- BEGIN permission -->
	<tr>
		<td class="{permission.ROW_CLASS}" align="center">{permission.USERNAME}</td>
        	<td class="{permission.ROW_CLASS}" align="center">{permission.PERMISSION}</td>
		<td class="{permission.ROW_CLASS}" align="center"><a href="{permission.U_PERMISSION_DEL}">{L_DELETE}</a></td>
	</tr>
	<!-- END permission -->			
	<tr>
		<td class="catBottom" align="center" colspan="3">
		<select name="user_id">
		<!-- BEGIN users -->
			<option value="{users.USER_ID}">{users.USERNAME}</option>
		<!-- END users -->
		</select> <input type="text" name="droit" />
		<input type="hidden" name="mode" value="add" />
		<input type="submit" class="mainoption" name="add" value="{L_ADD_PERMISSION}" /></td>
	</tr>
</table></form>
