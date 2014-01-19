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

<form action="{U_ABQ_ACTION}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr>
		<td class="catBottom" align="center" height="28" colspan="7"><input type="hidden" value="new" name="mode" /><input name="submit" type="submit" value="{L_CREATE_QUESTION}" class="mainoption" /></td>
	</tr>
	<tr>
		<th class="thCornerL">{L_ABQ_QUESTION}</th>
		<th class="thTop">{L_ABQ_IMAGE}</th>
		<th class="thTop">{L_ABQ_MCQ}</th>
		<th class="thTop">{L_ABQ_ANSWER}</th>
		<th class="thTop">{L_BOARD_LANGUAGE}</th>
		<th class="thCornerR" colspan="2">{L_ACTION}</th>
	</tr>
	<!-- BEGIN switch_no_questions -->
	<tr>
	<td class="row1" colspan="7" align="center">{L_ABQ_NO_QUESTION}</td>
	</tr>
	<!-- END switch_no_questions -->
	<!-- BEGIN abqrow -->
	<tr>
		<td class="{abqrow.COLOR}" width="30%"><span class="gen">{abqrow.QUESTION}</span></td>
		<td class="{abqrow.COLOR}" width="10%"><span class="gen">{abqrow.ANTI_BOT_IMG}{abqrow.IMG_NOTI}</span></td>
		<td class="{abqrow.COLOR}" width="10%"><span class="gen">{abqrow.MCQ}</span></td>
		<td class="{abqrow.COLOR}" width="20%"><span class="gen">{abqrow.ANSWER}</span></td>
		<td class="{abqrow.COLOR}" width="10%"><span class="gen">{abqrow.LANGUAGE}</span></td>
		<td class="{abqrow.COLOR}" width="10%" align="center"><span class="genmed"><a href="{abqrow.U_EDIT_ACTION}">{L_EDIT}</a></span></td>
		<td class="{abqrow.COLOR}" width="10%" align="center"><span class="genmed"><a href="{abqrow.U_DELETE_ACTION}">{L_DELETE}</a></span></td>
	</tr>
	<!-- END abqrow -->
	<tr>
		<td class="catBottom" align="center" height="28" colspan="7"><input type="hidden" value="new" name="mode" /><input name="submit" type="submit" value="{L_CREATE_QUESTION}" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />

<!--
You must keep my copyright notice visible with its original content
-->
<div align="center" class="copyright"><a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">Anti Bot Question MOD</a> {L_ABQ_VERSION} &copy; 2005-2006 <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">MagMo</a></div>
