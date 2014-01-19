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
		<td class="catBottom" align="center" height="28" colspan="3"><input type="hidden" value="new" name="mode" /><input name="submit" type="submit" value="{L_UPLOAD_NEW_IMAGE}" class="liteoption" /></td>
	</tr>
	<tr>
		<th class="thCornerL" width="70%">{L_ABQ_IMAGE}</th>
		<th class="thTop" colspan="2" width="30%">{L_ACTION}</th>
	</tr>
	<!-- BEGIN switch_no_images -->
	<tr>
		<td class="row1" colspan="3" align="center">{L_ABQ_NO_IIMAGES}</td>
	</tr>
	<!-- END switch_no_images -->
	<!-- BEGIN schriften -->
	<tr>
		<td class="{schriften.COLOR}" width="70%"><span class="gen">{schriften.BILD}</span></td>
		<td class="{schriften.COLOR}" width="20%" align="center"><span class="genmed"><a href="{schriften.U_SHOWIMAGE_ACTION}" title="{L_SHOWIMAGE}" target="_blank">{L_SHOWIMAGE}</a></span></td>
		<td class="{schriften.COLOR}" width="10%" align="center"><span class="genmed"><a href="{schriften.U_DELETE_ACTION}" title="{L_DELETE}">{L_DELETE}</a></span></td>
	</tr>
	<!-- END schriften -->
	<tr>
		<td class="catBottom" align="center" height="28" colspan="3"><input name="submit" type="submit" value="{L_UPLOAD_NEW_IMAGE}" class="liteoption" /></td>
	</tr>
</table>
</form>
<br clear="all" />

<!--
You must keep my copyright notice visible with its original content
-->
<div align="center" class="copyright"><a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">Anti Bot Question MOD</a> {L_ABQ_VERSION} &copy; 2005-2006 <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">MagMo</a></div>
