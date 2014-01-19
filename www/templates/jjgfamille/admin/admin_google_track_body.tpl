<H1>{L_GOOGLE_TRACK_RAPPORT}</H1>
<br />
<p align="left" class="gen">{GOOGLE_VISIT_COUNTER}</p><br />
<p align="left" class="gen"> Attention l'effacement du rapport est définitif.</p>

<table width="100%" cellpadding="4" cellspacing="2" border="0" class="forumline">
	<tr>
		<th class="thHead" width="100%" align="center">{L_GOOGLE_LAST_VISIT}</th>
<br />
	</tr>
<br />
	<tr>
	<td>
<br />
	<form action="{S_PGM}" method="POST">
		<input type="hidden" name="effacer" value="1">
	<table cellspacing="3" cellpadding="10" border="0" align="center" class="forumline">
		<tr>
			<td valign="top" nowrap class="row2"><textarea cols="90" rows="20" name="google">{CONTENU}</textarea>
			</td>
		</tr>
	</table>
<br />
	</td>
	</tr>

	<tr>

	<td class="catBottom" align="center" colspan="2">
	{S_HIDDEN_FIELDS}
		<input type="submit" class="liteoption" name="submit" value="{L_ERASE}">
	</td>
</tr>
</table>

</form>
</td>
</tr>
</table>

<br />
<br />