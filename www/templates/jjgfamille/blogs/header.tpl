<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml/DTD/xhtml1-transitional.dtd">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
{META_DESC}
{META}
{NAV_LINKS}
<title>{PAGE_TITLE}</title>
<!-- link rel="stylesheet" href="jjgfamille.css" type="text/css" -->
<link href="http://www.jjgfamille.com/rss/news.xml" rel="alternate" type="application/rss+xml" title="Flux RSS de jjgfamille.com" />
<script type="text/javascript" src="../js/calendar.js"></script>
<style type="text/css">
<!--
/*
  The original jjgfamille Theme for phpBB version 2+
  Created by subBlue design
  http://www.subBlue.com

  NOTE: These CSS definitions are stored within the main page body so that you can use the phpBB2
  theme administration centre. When you have finalised your style you could cut the final CSS code
  and place it in an external file, deleting this section to save bandwidth.
*/
 
 
 /* General page style. The scroll bar colours only visible in IE5.5+ */
 
body {
	background-color: #FFEFC3;
	scrollbar-face-color: #F7DB92;
	scrollbar-highlight-color: #FFEFC3;
	scrollbar-shadow-color: #F7DB92;
	scrollbar-3dlight-color: #E7CD82;
	scrollbar-arrow-color:  #000000;
	scrollbar-track-color: #FFEBA2;
	scrollbar-darkshadow-color: #B79B52;
	margin: 0px;
}

th, td {padding: 0px; margin: 0px}

/* General font families for common tags */
font,th,td,p { font-family: Verdana, Arial, Helvetica, sans-serif }
a:link,a:active,a:visited { color : #000000; }
a:hover		{ text-decoration: underline; color : #DD6900; }
hr	{ height: 0px; border: solid #D7BB72 0px; border-top-width: 1px;}


/* This is the border line & background colour round the entire page */
.bodyline	{ background-color: #FFEFC3; border: 1px #B79B52 solid; }

/* This is the outline round the main forum tables */
.forumline	{ background-color: #FFEFC3; border: 0px #D7BB72 solid; }


/* Main table cell colours and backgrounds */
td.row1	{ background-color: #F7DB92;
		border:#FFEBA2;
		border-style: solid;
		border-width: 1px 1px 0px 1px; }
td.row2	{ background-color: #F7DB92 ; }
td.row3	{ 	background-color: #E7CB82; 
		border:#FFEBA2;
		border-style: solid;
		border-width: 1px 1px 0px 1px;}


/*
  This is for the table cell above the Topics, Post & Last posts on the index.php page
  By default this is the fading out gradiated silver background.
  However, you could replace this with a bitmap specific for each forum
*/
td.rowpic {
		background-color: #F7DB92;
		background-image: url(../templates/jjgfamille/images/cellpic_famille2.png);
		background-repeat: repeat-y;
		border:#E7CB82;
		border-style: solid;
		border-width: 1px 0px 0px 1px;
}

/* Header cells - the blue and silver gradient backgrounds */
th	{
	color: #FFFFFF; font-size: 12px; font-weight : bold;
	background-color: #FFEFC3; height: 28px;
	background-image: url(../templates/jjgfamille/images/site/degrade.png);
}

td.cat,td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom {
			background-color:#E7CB82; border: #000000; border-style: solid; height: 28px;
}


/*
  Setting additional nice inner borders for the main table cells.
  The names indicate which sides the border will be on.
  Don't worry if you don't understand this, just i
gnore it :-)
*/
td.cat,td.catHead,td.catBottom {
	height: 29px;
	border-width: 0px 0px 0px 0px;
}
th.thHead,th.thSides,th.thTop,th.thLeft,th.thRight,th.thBottom,th.thCornerL,th.thCornerR {
	font-weight: bold; border: #FFEFC3; border-style: solid; height: 28px; }
td.row3Right,td.spaceRow {
	background-color: #E7CB82; border: #FFFFFF; border-style: solid; }

td.catHead { font-size: 12px; border-width: 0px 1px 1px 0px; }
th.thHead { font-size: 12px; border-width: 0px 0px 0px 0px; }
th.thSides,td.catSides,td.spaceRow	 { border-width: 0px 1px 0px 1px; }
th.thRight,td.catRight,td.row3Right	 { border-width: 0px 0px 0px 0px; }
td.catLeft	  { border-width: 0px 1px 1px 0px; }
th.thBottom,td.catBottom  { border-width: 1px 1px 1px 1px; }
th.thTop	 { border-width: 0px 0px 0px 0px; }
th.thCornerL { border-width: 0px 0px 0px 0px; }
th.thCornerR { border-width: 0px 0px 0px 0px; }
th.thLeft    { border-width: 0px 0px 0px 0px; }


/* The largest text used in the index page title and toptic title etc. */
.maintitle,h1,h2	{
			font-weight: bold; font-size: 22px; font-family: "Trebuchet MS",Verdana, Arial, Helvetica, sans-serif;
			text-decoration: none; line-height : 120%; color : #000000;
}


/* General text */
.gen { font-size : 13px; }
.genmed { font-size : 11px; }
.gensmall { font-size : 10px; }
.gen,.genmed,.gensmall { color : #000000; }
a.gen,a.genmed,a.gensmall { color: #000000; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: #FF8000; text-decoration: underline; }


/* The register, login, search etc links at the top of the page */
.mainmenu		{ font-size : 11px; color : #000000 }
a.mainmenu		{ text-decoration: none; color : #000000;  }
a.mainmenu:hover{ text-decoration: underline; color : #FF8000; }


/* Forum category titles */
.cattitle		{ font-weight: bold; font-size: 14px ; letter-spacing: 1px; color : #000000}
a.cattitle		{ text-decoration: none; color : #000000; }
a.cattitle:hover{ text-decoration: underline; }


/* Forum title: Text and link to the forums used in: index.php */
.forumlink		{ font-weight: bold; font-size: 13px; color : #000000; }
a.forumlink 	{ text-decoration: none; color : #000000; }
a.forumlink:hover{ text-decoration: underline; color : #FF8000; }


/* Used for the navigation text, (Page 1,2,3 etc) and the navigation bar when in a forum */
.nav			{ font-weight: bold; font-size: 11px; color : #000000;}
a.nav			{ text-decoration: none; color : #000000; }
a.nav:hover		{ text-decoration: underline; }


/* titles for the topics: could specify viewed link colour too */
.topictitle			{ font-weight: bold; font-size: 11px; color : #000000; }
a.topictitle:link   { text-decoration: none; color : #000000; }
a.topictitle:visited { text-decoration: none; color : #000000; }
a.topictitle:hover	{ text-decoration: underline; color : #FF8000; }


/* Name of poster in viewmsg.php and viewtopic.php and other places */
.name			{ font-size : 11px; color : #000000;}

/* Location, number of posts, post date etc */
.postdetails		{ font-size : 10px; color : #000000; }


/* The content of the posts (body of text) */
.postbody { font-size : 12px }
a.postlink:link	{ text-decoration: none; color : #000000 }
a.postlink:visited { text-decoration: none; color : #000000; }
a.postlink:hover { text-decoration: underline; color : #FF8000}


/* Quote & Code blocks */
.code {
	font-family: Courier, 'Courier New', sans-serif; font-size: 11px; color: #006600;
	background-color: #FAFAFA; border: #E7CB82; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

.quote {
	font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #444444; line-height: 125%;
	background-color: #FAFAFA; border: #E7CB82; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}


/* Copyright and bottom info */
.copyright		{ font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #444444; letter-spacing: -1px;}
a.copyright		{ color: #444444; text-decoration: none;}
a.copyright:hover { color: #000000; text-decoration: underline;}


.coinHG		{ width:12px; height:12px; background-image:url(../templates/jjgfamille/images/site/coin_hg.gif); }
.coinHD		{ width:12px; height:12px; background-image:url(../templates/jjgfamille/images/site/coin_hd.gif); }
.coinBG		{ width:12px; height:12px; background-image:url(../templates/jjgfamille/images/site/coin_bg.gif); }
.coinBD		{ width:12px; height:12px; background-position: right; overflow: hidden; background-image:url(../templates/jjgfamille/images/site/coin_bd.gif); }

.ligneHaut	{ height:5px; background-image:url(../templates/jjgfamille/images/site/lig_h2.gif); }
.ligneBas	{ height:5px; background-image:url(../templates/jjgfamille/images/site/lig_b2.gif); }
.colonneGauche	{ width:5px; background-image:url(../templates/jjgfamille/images/site/col_g2.gif); }
.colonneDroite	{ width:5px; background-image:url(../templates/jjgfamille/images/site/col_d2.gif); }

.degradeGauche	{ width:7px; height:28px; background-image:url(../templates/jjgfamille/images/site/degrade_g.png) ; 
overflow: hidden;  }
.degradeDroite	{ width:7px; height:28px; background-image:url(../templates/jjgfamille/images/site/degrade_d.png) ; 
overflow: hidden;  }

.boite		{ width:99%; border-spacing:0px;border-width:0px 0px 0px 0px; padding:0px}

/* Form elements */
input,textarea, select {
	color : #000000;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	border-color : #000000;
}

/* The text input fields background colour */
input.post, textarea.post, select {
	background-color : #FFEFC3;
}

input { text-indent : 2px; }

/* The buttons used for bbCode styling in message post */
input.button {
	background-color : #FFEBA2;
	color : #000000;
	font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif;
}

/* The main submit button option */
input.mainoption {
	background-color : #FAFAFA;
	font-weight : bold;
}

/* None-bold submit button */
input.liteoption {
	background-color : #FAFAFA;
	font-weight : normal;
}

/* This is the line in the posting page which shows the rollover
  help line. This is actually a text box, but if set to be the same
  colour as the background no one will know ;)
*/
.helpline { background-color: #F7DB92; border-style: none; }

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("../templates/jjgfamille/formIE.css");

#monlogo {
vertical-align: middle;
text-align: left;
width:150px;
height:1%;
}

.contenuMessage {
overflow: hidden
}

-->
</style>

<!-- BEGIN switch_enable_pm_popup -->
<script type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-105887-1";
urchinTracker();
</script>
</head>
<body>
<table border="0" cellspacing="0" cellpadding="0" style="table-layout: auto; width: 100%; empty-cells: show;">
	<tr>
		<td height="1" width="143" class="row2"></td>
		<td height="1" width="7" class="row2"></td>
		<td height="1" width="5" class="colonneDroite"><img src="../templates/jjgfamille/images/site/col_d2.gif" border="0" /></td>
		<td height="1" class="row1"></td>
		<td width="15" rowspan="6"></td>
		<td height="1" width="5" class="colonneGauche"><img src="../templates/jjgfamille/images/site/col_g2.gif" border="0" /></td>
		<td height="1" width="7" class="row2"></td>
		<td height="1" width="293" class="row2"></td>
	</tr>
	<tr>
		<td colspan="2" valign="middle" align="left" width="150" height="41">
			<a href="../accueil/"><img src="../images/logo.png" title="Jean-Jacques Goldman :: famille" alt="Jean-Jacques Goldman :: famille" border="0" /></a>
		</td>
		<td height="41" class="colonneDroite"><font size="1">&nbsp;</font></td>
		<td width="99%" align="center" valign="middle" rowspan="3">
			<span class="cattitle">{BLOG_TITLE}<br />
			<small>{BLOG_SUBTITLE}</small></span>
		</td>
		<td height="41" class="colonneGauche"></td>
		<td valign="middle" align="center" width="300" height="41" class="row2" colspan="2">
			<span class="cattitle">Un blog JJGfamille</span><br />
			<span class="genmed">{THE_WEBSITE} | {THE_FORUM} | {THE_WEBCHAT} | {THE_WEBLOGS}</span>
		</td>
	</tr>
	<tr>
		<td height="7" width="143" class="row2"></td>
		<td colspan="2" rowspan="2" class="coinBD"></td>
		<td colspan="2" rowspan="2" class="coinBG"></td>
		<td height="7" width="293" class="row2"></td>
	</tr>
	<tr>
		<td width="143" class="ligneBas"></td>
		<td width="293" class="ligneBas"></td>
	</tr>
	<tr>
		<td height="10" width="143"></td>
		<td height="10" width="7"></td>
		<td height="10" width="5"></td>
		<td height="10"></td>
		<td height="10" width="5"></td>
		<td height="10" width="7"></td>
		<td height="10" width="293"></td>
	</tr>