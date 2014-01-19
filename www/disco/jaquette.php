<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_DISCO);
init_userprefs($userdata);
//
// End session management
//

$sql_jack = "SELECT * FROM disco_jacks WHERE jack_id=".$_GET['jack_id']." ";
$result_jack = mysql_query($sql_jack) or die("Erreur Interne<br />Requète SQL : ".$sql_jack);
$val_jack = mysql_fetch_array($result_jack);

$sql_album = "SELECT * FROM disco_albums WHERE album_id=".$val_jack['album_id']." ";
$result_album = mysql_query($sql_album) or die("Erreur Interne<br />Requète SQL : ".$sql_album);
$val_album = mysql_fetch_array($result_album);

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Jaquette de <? echo $val_album['title']; ?></title>
</head>

<body>
<script language="JavaScript1.1" type="text/javascript"> 
<!--

function right(e) {

var msg = "Respectez les droits d'auteurs SVP !!!";

if (navigator.appName == 'Netscape' && e.which == 3) {

alert(msg); // Delete this line to disable but not alert user

return false;

}

else

if (navigator.appName == 'Microsoft Internet Explorer' && event.button==2) {

alert(msg); // Delete this line to disable but not alert user

return false;

}

return true;

}

document.onmousedown = right;

//-->
</script>

<img src="../functions/image.php?mode=disco&album_id=<? echo $val_jack['album_id']; ?>&jack_id=<? echo $val_jack['jack_id']; ?>" border="0"><br /><br>
<? if ($val_jack["comment"] != "") { echo "<font size=2><b>Commentaires : </b>".bbencode_second_pass($val_jack["comment"],$val_jack["bbcode_uid"])."</font>"; } ?><br />
</body>
</html>
