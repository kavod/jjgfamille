<?
define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'forum');
$phpbb_root_path = './';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//
require_once('functions/link.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>Jean-Jacques Goldman</title>
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
		</script>
		<script type="text/javascript" src="js/scriptaculous/prototype.js"></script>
		<script type="text/javascript" src="js/scriptaculous/scriptaculous.js?load=effects"></script>
		<script type="text/javascript">
		_uacct = "UA-105887-1";
		urchinTracker();
		</script>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="Content-Language" content="fr" />
		<meta name="description" content="Site consacré à l'oeuvre de Jean-Jacques Goldman" />
		<meta name="author" content="Boris Kavod - Goldmanikou" lang="fr" />
		<meta name="copyright" content="famille Musik © 2001-2005" />
		<meta name="classification" content="Music" />
		<meta name="distribution" content="Global" />
		<meta name="keywords" content="jean-jacques goldman, jean jacques goldman,jean, jacques, goldman, jean-jacques, jjg, site" />
		<meta name="rating" content="General" />
		<meta name="resource-type" content="document" />
		<meta name="revisit-after" content="30 days" />
		<meta name="robots" content="index,follow" />
		<meta name="identifier-url" content="<? echo $_SERVER['HTTP_HOST']; ?>" />
		<meta name="publisher" content="famille Musik - association ayant pour but de promouvoir l'oeuvre de Jean-Jacques Goldman" />
		<link rel="shortcut icon" href="favicon.ico" />
		<link href="http://<? echo $_SERVER['HTTP_HOST']; ?>/rss/news.xml" rel="alternate" type="application/rss+xml" title="News : Flux RSS de jjgfamille.com" />
		<script type="text/javascript" src="js/accueil.js"></script>
		<link rel="stylesheet" type="text/css" href="style/jjgfamille.css" />
	</head>

	<body onload="new Effect.Opacity('accueil', { from: 0, to: 1 });">
		<table style="margin-left: auto; margin-right:auto;">
			<tr>
				<td style="text-align:center"><h1><b>Jean-Jacques Goldman</b></h1><h2>JJG famille :: Croisons nos vies de temps en temps</h2>
				<a href="accueil/"><img src="images/home800.jpg" style="border:0;width:800px;height:600px;opacity:0" alt="Cliquez pour entrer dans Jean-Jacques Goldman famille" title="Cliquez pour entrer dans Jean-Jacques Goldman famille" id="accueil" /></a>
				</td>
			</tr>
		</table>
		<p>
      		<a href="http://validator.w3.org/check?uri=referer" target="_blank" rel="nofollow">
			<img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0!" />
		</a>
		<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank" rel="nofollow">
			<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" />
		</a>
		</p>
<!-- phpmyvisites -->
<script type="text/javascript">
<!--
var a_vars = Array();
var pagename='';

var phpmyvisitesSite = 1;
var phpmyvisitesURL = "http://www.kavod.net/phpmv2/phpmyvisites.php";
//-->
</script>
<script type="text/javascript" src="http://www.kavod.net/phpmv2/phpmyvisites.js"></script>
<!-- /phpmyvisites --> 
	</body>
</html>
