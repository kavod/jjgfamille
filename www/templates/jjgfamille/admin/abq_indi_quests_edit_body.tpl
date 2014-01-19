<p align="center" class="gensmall">
&#91;<a href="{U_MM_CONFIG}" title="{L_MM_CONFIG}">{L_MM_CONFIG}</a>&#93; - 
&#91;<a href="{U_MM_AUTOFRAGEN}" title="{L_MM_AUTOFRAGEN}">{L_MM_AUTOFRAGEN}</a>&#93; 
&#91;<a href="{U_MM_FONTS}" title="{L_MM_FONTS}">{L_MM_FONTS}</a>&#93; 
&#91;<a href="{U_MM_CONFIG2}" title="{L_MM_CONFIG2}">{L_MM_CONFIG2}</a>&#93; - 
&#91;<a href="{U_MM_INDIFRAGEN}" title="{L_MM_INDIFRAGEN}">{L_MM_INDIFRAGEN}</a>&#93; 
&#91;<a href="{U_MM_IIMAGES}" title="{L_MM_IIMAGES}">{L_MM_IIMAGES}</a>&#93;
</p>

<h1>{L_ABQ_TITLE}</h1>

<p>{L_ABQ_EXPLAIN}</p>

<script language="javascript" type="text/javascript">
<!--
function update_anti_bot_image(newimage)
{
	if (newimage == '')
	{
		document.anti_bot_img.src = "{S_ANTI_BOT_IMG_UP}/spacer.gif";
	}
	else
	{
		document.anti_bot_img.src = "{S_ANTI_BOT_IMG_BASEDIR}/" + newimage;
	}
}
//-->
</script>

<form action="{U_ABQ_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thHead" height="25" nowrap="nowrap" colspan="2">{L_PANEL_TITLE}</th>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="gensmall">{L_PFLICHTFELDER_INFO}</span></td>
	</tr>
	<tr>
		<td class="row1" width="20%" valign="top"><span class="gen">{L_QUESTION}: *</span><br /><br /><span class="gensmall">{BBCODE_STATUS}</span></td>
		<td class="row2"><textarea name="question" class="post" rows="5" cols="45" wrap="virtual">{S_QUESTION}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANTI_BOT_IMG}:</span></td>
		<td class="row2"><select name="anti_bot_img" onchange="update_anti_bot_image(this.options[selectedIndex].value);">{S_ANTI_BOT_IMG_OPTIONS}</select><br />
		<img name="anti_bot_img" src="{S_ANTI_BOT_IMG}" border="0" alt="" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_R} 1: *</span><span class="gensmall">{L_ANSWER_R_EXPLAIN}</span></td>
		<td class="row2"><input name="answer1" type="text" class="post" size="35" value="{S_ANSWER1}" /></td>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="gen">{L_ANSWER_INFO1}</span><br /><span class="gensmall">{L_ANSWER_INFO1A}</span></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_R} 2:</span><span class="gensmall">{L_ANSWER_R_EXPLAIN}</span></td>
		<td class="row2"><input name="answer2" type="text" class="post" size="35" value="{S_ANSWER2}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_R} 3:</span><span class="gensmall">{L_ANSWER_R_EXPLAIN}</span></td>
		<td class="row2"><input name="answer3" type="text" class="post" size="35" value="{S_ANSWER3}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_R} 4:</span><span class="gensmall">{L_ANSWER_R_EXPLAIN}</span></td>
		<td class="row2"><input name="answer4" type="text" class="post" size="35" value="{S_ANSWER4}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_R} 5:</span><span class="gensmall">{L_ANSWER_R_EXPLAIN}</span></td>
		<td class="row2"><input name="answer5" type="text" class="post" size="35" value="{S_ANSWER5}" /></td>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="gen">{L_ANSWER_INFO2}</span><br /><span class="gensmall">{L_ANSWER_INFO2A}</span></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 1:</span></td>
		<td class="row2"><input name="wronganswer01" type="text" class="post" size="35" value="{S_WRONGANSWER01}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 2:</span></td>
		<td class="row2"><input name="wronganswer02" type="text" class="post" size="35" value="{S_WRONGANSWER02}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 3:</span></td>
		<td class="row2"><input name="wronganswer03" type="text" class="post" size="35" value="{S_WRONGANSWER03}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 4:</span></td>
		<td class="row2"><input name="wronganswer04" type="text" class="post" size="35" value="{S_WRONGANSWER04}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 5:</span></td>
		<td class="row2"><input name="wronganswer05" type="text" class="post" size="35" value="{S_WRONGANSWER05}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 6:</span></td>
		<td class="row2"><input name="wronganswer06" type="text" class="post" size="35" value="{S_WRONGANSWER06}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 7:</span></td>
		<td class="row2"><input name="wronganswer07" type="text" class="post" size="35" value="{S_WRONGANSWER07}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 8:</span></td>
		<td class="row2"><input name="wronganswer08" type="text" class="post" size="35" value="{S_WRONGANSWER08}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 9:</span></td>
		<td class="row2"><input name="wronganswer09" type="text" class="post" size="35" value="{S_WRONGANSWER09}" /></td>
	</tr>
	<tr>
		<td class="row1" width="20%"><span class="gen">{L_ANSWER_F} 10:</span></td>
		<td class="row2"><input name="wronganswer10" type="text" class="post" size="35" value="{S_WRONGANSWER10}" /></td>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="gensmall">{L_ANSWER_INFO3}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_BOARD_LANGUAGE}: *</span></td>
		<td class="row2"><span class="gensmall">{S_LANGUAGE}</span></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" height="28" colspan="2"><input type="hidden" value="{S_MODE}" name="mode" /><input name="submit" type="submit" value="{L_PANEL_TITLE}" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />

<!--
You must keep my copyright notice visible with its original content
-->
<div align="center" class="copyright"><a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">Anti Bot Question MOD</a> {L_ABQ_VERSION} &copy; 2005-2006 <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">MagMo</a></div>
