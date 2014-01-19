 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom"><span class="maintitle">{L_SEARCH_MATCHES}</span><br /></td>
  </tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="99%" class="forumline" align="center">
   <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td colspan="2" class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td colspan="2" height="7" class="row2"></td>
    </tr>
   <tr> 
		<td class="colonneGauche"></td>
		<td class="degradeGauche"></td>
	<th width="150" height="25" class="thCornerL" nowrap="nowrap">{L_AUTHOR}</th>
	<th class="thCornerR" nowrap="nowrap">{L_MESSAGE}</th>
		<td class="degradeDroite"></td>
		<td class="colonneDroite"></td>
  </tr>
  <!-- BEGIN searchresults -->
  <tr> 
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
	<td class="catHead" colspan="2" height="28"><span class="topictitle"><img src="../templates/jjgfamille/images/folder.gif" align="absmiddle" />&nbsp; {L_TOPIC}:&nbsp;<a href="{searchresults.U_TOPIC}" class="topictitle">{searchresults.TOPIC_TITLE}</a></span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
  </tr>
  <tr> 
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
	<td width="150" align="left" valign="top" class="row1" rowspan="2"><span class="name"><b>{searchresults.POSTER_NAME}</b></span><br />
	  <br />
	  <span class="postdetails">{L_REPLIES}: <b>{searchresults.TOPIC_REPLIES}</b><br />
	  {L_VIEWS}: <b>{searchresults.TOPIC_VIEWS}</b></span><br />
	</td>
	<td valign="top" class="row1"><img src="{searchresults.MINI_POST_IMG}" width="12" height="9" alt="{searchresults.L_MINI_POST_ALT}" title="{searchresults.L_MINI_POST_ALT}" border="0" /><span class="postdetails">{L_FORUM}:&nbsp;<b><a href="{searchresults.U_FORUM}" class="postdetails">{searchresults.FORUM_NAME}</a></b>&nbsp; &nbsp;{L_POSTED}: {searchresults.POST_DATE}&nbsp; &nbsp;{L_SUBJECT}: <b><a href="{searchresults.U_POST}">{searchresults.POST_SUBJECT}</a></b></span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
  </tr>
  <tr>
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
	<td valign="top" class="row1"><span class="postbody">{searchresults.MESSAGE}</span></td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
  </tr>
  <!-- END searchresults -->
  <tr> 
		<td class="colonneGauche"></td>
		<td width="7" class="row2"></td>
	<td class="catBottom" colspan="2" height="28" align="center">&nbsp; </td>
		<td width="7"  class="row2"></td>
		<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td colspan="2" height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td colspan="2" width="5" class="ligneBas"></td>
    </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="nav">{PAGINATION}</span><br /><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
