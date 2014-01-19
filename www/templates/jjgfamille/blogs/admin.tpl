	<tr>
		<td colspan="4" valign="top">
		<p align="center"><span class="cattitle">{BLOG_HEADER}</span></p>
		{ERROR_BOX}
		<table style="width: 99%;" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="5" height="0"></td>
				<td width="7" height="0"></td>
				<td height="0"></td>
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
<!-- BEGIN heading -->
		<form method="post" action="{postrow.heading.U_ACTION}">
			<tr> 
				<td class="catLeft" height="28" colspan="2"><span class="cattitle"><b>{postrow.heading.HEADING}</b></span></td>
			</tr>
<!-- END heading -->
	<tr> 
		<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="med"><b>{postrow.LABEL}</b></span><br /><span class="postdetails">{postrow.EXPLAIN}</td>
		<td class="{postrow.ROW_CLASS}" height="28" valign="top"><span class="gen">
<!-- BEGIN text -->
		<input type="text" name="{postrow.NAME}" size="{postrow.text.SIZE}" VALUE="{postrow.VALUE}" class="post" maxlength="{postrow.text.MAXLENGTH}" />
<!-- END text -->
<!-- BEGIN link -->
		<a href="{postrow.link.LINK}">{postrow.VALUE}</a>
<!-- END link -->
<!-- BEGIN radio -->
		<input type="radio" name="{postrow.NAME}" value="{postrow.radio.VALUE}"{postrow.radio.CHECKED} /> {postrow.radio.TEXT}<br />
<!-- END radio -->
<!-- BEGIN select -->
	<select name="{postrow.NAME}"{postrow.select.AUTO}>
<!-- BEGIN option -->
		<option value="{postrow.select.option.VALUE}"{postrow.select.option.SELECTED} /> {postrow.select.option.TEXT}</option>
<!-- END option -->
	</select>
<!-- END select -->
<!-- BEGIN textarea -->
		<textarea name="{postrow.NAME}" cols="{postrow.textarea.COLS}" rows="{postrow.textarea.ROWS}" class="post">{postrow.VALUE}</textarea>
<!-- END textarea -->
<!-- BEGIN submit -->
		<center><input type="submit" name="{postrow.NAME}" class="liteoption" value="{postrow.VALUE}" /></center>
	</form>
<!-- END submit -->
<!-- BEGIN delete -->
		<a href="javascript:if(confirm('{postrow.delete.L_CONFIRM}')) document.location='{postrow.delete.U_DELETE}'">{L_DELETE}</a>
<!-- END delete -->
		</span></td>
	</tr>
	<tr>
		<td class="spaceRow" colspan="2" height="1"><img src="../images/forum/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
<!-- END postrow -->
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
		</tbody>
		</table>
		
		
		
		
		</td>
		<td colspan="3" valign="top">{COLONNE_DROITE}</td>
	</tr>
</table>
</body>
</html>