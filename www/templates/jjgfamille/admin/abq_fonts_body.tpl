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
		<td class="catBottom" align="center" height="28" colspan="3"><input type="hidden" value="new" name="mode" /><input name="submit" type="submit" value="{L_UPLOAD_NEW_FONT}" class="liteoption" /></td>
	</tr>
	<tr>
		<th class="thCornerL">{L_ABQ_FONT}</th>
		<th class="thTop">{L_EXAMPLE}</th>
		<th class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN switch_font_missing -->
	<tr>
		<td class="row1" colspan="3" align="center">{L_ABQ_FONT_MISSING}</td>
	</tr>
	<!-- END switch_font_missing -->
	<!-- BEGIN switch_no_fonts -->
	<tr>
		<td class="row1" colspan="3" align="center">{L_ABQ_NO_FONTS}</td>
	</tr>
	<!-- END switch_no_fonts -->
	<!-- BEGIN schriften -->
	<tr>
		<td class="{schriften.COLOR}" width="80%"><span class="gen">{schriften.FONT}</span></td>
		<td class="{schriften.COLOR}" width="10%" align="center"><span class="genmed"><a href="{schriften.U_EXAMPLE_ACTION}" title="{L_EXAMPLE}">{L_EXAMPLE}</a></span></td>
		<td class="{schriften.COLOR}" width="10%" align="center"><span class="genmed">{schriften.U_DELETE_ACTION}</span></td>
	</tr>
	<!-- END schriften -->
	<tr>
		<td class="catBottom" align="center" height="28" colspan="3"><input name="submit" type="submit" value="{L_UPLOAD_NEW_FONT}" class="liteoption" /></td>
	</tr>
</table>
</form>
<br clear="all" />

<!--
You must keep my copyright notice visible with its original content
-->
<div align="center" class="copyright"><a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">Anti Bot Question MOD</a> {L_ABQ_VERSION} &copy; 2005-2006 <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">MagMo</a></div>
