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

<!-- BEGIN switch_delete -->
<form action="{U_DELETE_ACTION}" method="post">
<!-- END switch_delete -->
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thCornerL" width="50%">{L_ABQ_IMAGE}</th>
		<th class="thTop" width="50%" align="center">{L_ACTION}</th>
	</tr>
	<!-- BEGIN switch_unknown_image -->
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gen">{L_ABQ_UNKNOWN_IMAGE}</span></td>
	</tr>
	<!-- END switch_unknown_image -->
	<!-- BEGIN switch_dont_delete_image -->
	<tr>
		<td class="row1"><span class="gen">{BILD}</span></td>
		<td class="row1"><span class="gen">{L_DELETE} *</span></td>
	</tr>
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gen">* {L_ABQ_IMAGE_IN_USE}</span></td>
	</tr>
	<!-- END switch_dont_delete_image -->
	<!-- BEGIN switch_delete -->
	<tr>
		<td class="row1"><span class="gen">{BILD}<input type="hidden" name="name" value="{BILD}" /></span></td>
		<td class="row1"><input type="hidden" value="delete" name="mode" /><input type="hidden" name="id" value="{S_BILDTID}" /><input name="submit" type="submit" value="{L_DELETE}" class="mainoption" /></td>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center"><span class="gen">{L_ABQ_EXPLAIN2}</span></td>
	</tr>
	<!-- END switch_delete -->
	<tr>
		<td class="catBottom" align="center" height="28" colspan="2">&#160;</td>
	</tr>
</table>
<!-- BEGIN switch_delete -->
</form>
<!-- END switch_delete -->
<br clear="all" />

<!--
You must keep my copyright notice visible with its original content
-->
<div align="center" class="copyright"><a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">Anti Bot Question MOD</a> {L_ABQ_VERSION} &copy; 2005-2006 <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">MagMo</a></div>
