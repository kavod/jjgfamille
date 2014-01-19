<p align="center" class="gensmall">
&#91;<a href="{U_MM_CONFIG}" title="{L_MM_CONFIG}">{L_MM_CONFIG}</a>&#93; - 
&#91;<a href="{U_MM_AUTOFRAGEN}" title="{L_MM_AUTOFRAGEN}">{L_MM_AUTOFRAGEN}</a>&#93; 
&#91;<a href="{U_MM_FONTS}" title="{L_MM_FONTS}">{L_MM_FONTS}</a>&#93; 
&#91;<a href="{U_MM_CONFIG2}" title="{L_MM_CONFIG2}">{L_MM_CONFIG2}</a>&#93; - 
&#91;<a href="{U_MM_INDIFRAGEN}" title="{L_MM_INDIFRAGEN}">{L_MM_INDIFRAGEN}</a>&#93; 
&#91;<a href="{U_MM_IIMAGES}" title="{L_MM_IIMAGES}">{L_MM_IIMAGES}</a>&#93;
</p>

<h1>{L_CONFIGURATION_TITLE}</h1>

<form action="{U_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_AKTIVATE}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_AKTIVATE_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ANTI_BOT_QUEST_REGISTER}<br /><span class="gensmall">{L_ANTI_BOT_QUEST_REGISTER_EXPLAIN}</span><b>{L_ANTI_BOT_QUEST_CONFIRM}</b></td>
		<td class="row2"><input type="radio" name="abq_register" value="1" {S_ANTI_BOT_QUEST_REGISTER_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="abq_register" value="0" {S_ANTI_BOT_QUEST_REGISTER_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ANTI_BOT_QUEST_GUEST}<br /><span class="gensmall">{L_ANTI_BOT_QUEST_GUEST_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="abq_guest" value="1" {S_ANTI_BOT_QUEST_GUEST_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="abq_guest" value="0" {S_ANTI_BOT_QUEST_GUEST_DISABLE} />{L_NO}</td>
	</tr>

	<tr>
	  <th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_VARNAME}<br /><span class="gensmall">{L_VARNAME_EXPLAIN}</span></td>
		<td class="row2"><select name="abq_get_s1">{S_VARNAME1}</select><select name="abq_get_s2">{S_VARNAME2}</select><select name="abq_get_s3">{S_VARNAME3}</select><select name="abq_get_s4">{S_VARNAME4}</select><select name="abq_get_s5">{S_VARNAME5}</select><select name="abq_get_s6">{S_VARNAME6}</select></td>
	</tr>
	<tr>
		<td class="row1">{L_VERHEFAF}<br /><span class="gensmall">{L_VERHEFAF_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="3" size="5" name="verhaeltnis_eigene_auto" value="{S_VERHEFAF_VALUE}" /> %</td>
	</tr>

	<tr>
	  <th class="thHead" colspan="2">{L_EF_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_EF_SETTINGS_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_INDIVIDUELQUESTS}<br /><span class="gensmall">{L_INDIVIDUELQUESTS_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="eigene_fragen" value="1" {S_EF_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="eigene_fragen" value="0" {S_EF_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_CASESEN}<br /><span class="gensmall">{L_CASESEN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="ef_casesensitive" value="1" {S_CASESEN_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="ef_casesensitive" value="0" {S_CASESEN_DISABLE} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_BILDPHP}<br /><span class="gensmall">{L_BILDPHP_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="ef_bild" value="1" {S_BILDPHP_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="ef_bild" value="0" {S_BILDPHP_DISABLE} />{L_NO}</td>
	</tr>

	<tr>
	  <th class="thHead" colspan="2">{L_AF_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_AF_SETTINGS_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_IMAGETYPE}<br /></td>
		<td class="row2"><input type="radio" name="imagetype" value="1" {S_IMAGETYPE_JPG} />{L_JPG}&nbsp; &nbsp;<input type="radio" name="imagetype" value="0" {S_IMAGETYPE_PNG} />{L_PNG}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AF_JPGQUALITY}<br /><span class="gensmall">{L_AF_JPGQUALITY_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="2" size="5" name="jpgquality" value="{S_AF_JPGQUALITY_VALUE}" />{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AF_FONTSIZE}<br /><span class="gensmall">{L_AF_FONTSIZE_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="2" size="5" name="fontsize" value="{S_AF_FONTSIZE_VALUE}" />{L_READONLY1}{L_READONLY2}</td>
	</tr>
	<tr>
		<td class="row1">{L_AF_GROSSEZAHLEN}<br /><span class="gensmall">{L_AF_GROSSEZAHLEN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="af_grossezahlen" value="1" {S_AF_GROSSEZAHLEN_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="af_grossezahlen" value="0" {S_AF_GROSSEZAHLEN_DISABLE} />{L_NO}&nbsp; &nbsp;<input type="radio" name="af_grossezahlen" value="2" {S_AF_GROSSEZAHLEN_RAND} />{L_RAND}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_MAX}<br /><span class="gensmall">{L_AFEFF_MAX_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="1" size="5" name="afeff_max" value="{S_AFEFF_MAX_VALUE}" />{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_TRENNLINIE}<br /><span class="gensmall">{L_AFEFF_TRENNLINIE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="afeff_trennlinie" value="1" {S_AFEFF_TRENNLINIE_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="afeff_trennlinie" value="0" {S_AFEFF_TRENNLINIE_DISABLE} />{L_NO}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_BGTEXT}<br /><span class="gensmall">{L_AFEFF_BGTEXT_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="afeff_bgtext" value="1" {S_AFEFF_BGTEXT_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="afeff_bgtext" value="0" {S_AFEFF_BGTEXT_DISABLE} />{L_NO}&nbsp; &nbsp;<input type="radio" name="afeff_bgtext" value="2" {S_AFEFF_BGTEXT_RAND} />{L_RAND}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_GRID}<br /><span class="gensmall">{L_AFEFF_GRID_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="afeff_grid" value="1" {S_AFEFF_GRID_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="afeff_grid" value="0" {S_AFEFF_GRID_DISABLE} />{L_NO}&nbsp; &nbsp;<input type="radio" name="afeff_grid" value="2" {S_AFEFF_GRID_RAND} />{L_RAND}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_GRIDW}<br /><span class="gensmall">{L_AFEFF_GRIDW_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="3" size="5" name="afeff_gridw" value="{S_AFEFF_GRIDW_VALUE}" />{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_GRIDH}<br /><span class="gensmall">{L_AFEFF_GRIDH_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="2" size="5" name="afeff_gridh" value="{S_AFEFF_GRIDH_VALUE}" />{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_GRIDF}<br /><span class="gensmall">{L_AFEFF_GRIDF_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="afeff_gridf" value="1" {S_AFEFF_GRIDF_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="afeff_gridf" value="0" {S_AFEFF_GRIDF_DISABLE} />{L_NO}&nbsp; &nbsp;<input type="radio" name="afeff_gridf" value="2" {S_AFEFF_GRIDF_RAND} />{L_RAND}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_ELLIPSEN}<br /><span class="gensmall">{L_AFEFF_ELLIPSEN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="afeff_ellipsen" value="1" {S_AFEFF_ELLIPSEN_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="afeff_ellipsen" value="0" {S_AFEFF_ELLIPSEN_DISABLE} />{L_NO}&nbsp; &nbsp;<input type="radio" name="afeff_ellipsen" value="2" {S_AFEFF_ELLIPSEN_RAND} />{L_RAND}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_BOEGEN}<br /><span class="gensmall">{L_AFEFF_BOEGEN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="afeff_boegen" value="1" {S_AFEFF_BOEGEN_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="afeff_boegen" value="0" {S_AFEFF_BOEGEN_DISABLE} />{L_NO}&nbsp; &nbsp;<input type="radio" name="afeff_boegen" value="2" {S_AFEFF_BOEGEN_RAND} />{L_RAND}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AFEFF_LINIEN}<br /><span class="gensmall">{L_AFEFF_LINIEN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="afeff_linien" value="1" {S_AFEFF_LINIEN_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="afeff_linien" value="0" {S_AFEFF_LINIEN_DISABLE} />{L_NO}&nbsp; &nbsp;<input type="radio" name="afeff_linien" value="2" {S_AFEFF_LINIEN_RAND} />{L_RAND}{L_READONLY1}</td>
	</tr>
	<tr>
		<td class="row1">{L_AF_MALZEICHEN}<br /><span class="gensmall">{L_AF_MALZEICHEN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="af_malzeichen" value="*" {S_AF_MALZEICHEN_1} />*&nbsp; &nbsp;<input type="radio" name="af_malzeichen" value="x" {S_AF_MALZEICHEN_2} />x&nbsp; &nbsp;<input type="radio" name="af_malzeichen" value="X" {S_AF_MALZEICHEN_3} />X</td>
	</tr>
	<tr>
		<td class="row1">{L_AF_USE_SELECT}<br /><span class="gensmall">{L_AF_USE_SELECT_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="af_use_select" value="1" {S_AF_USE_SELECT_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="af_use_select" value="0" {S_AF_USE_SELECT_DISABLE} />{L_NO}</td>
	</tr>

	<!-- BEGIN switch_readonly1 -->
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_READONLY1_EXPLAIN}</span></td>
	</tr>
	<!-- END switch_readonly1 -->
	<!-- BEGIN switch_readonly2 -->
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_READONLY2_EXPLAIN}</span></td>
	</tr>
	<!-- END switch_readonly2 -->

	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table></form>
<br clear="all" />

<!--
You must keep my copyright notice visible with its original content
-->
<div align="center" class="copyright"><a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">Anti Bot Question MOD</a> {L_ABQ_VERSION} &copy; 2005-2006 <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD" target="_blank">MagMo</a></div>
