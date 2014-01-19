<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'tournees';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_TOURNEES);
init_userprefs($userdata);
//
// End session management
//

$sql_illu = "SELECT * FROM tournee_photos WHERE photo_id=".$_GET['photo_id']." ";
$result_illu = mysql_query($sql_illu) or die("Erreur Interne<br>Requète SQL : ".$sql_illu);
$val_illu = mysql_fetch_array($result_illu);

$sql_tournee = "SELECT * FROM tournee_concerts WHERE concert_id=".$val_illu['concert_id']." ";
$result_tournee = mysql_query($sql_tournee) or die("Erreur Interne<br>Requète SQL : ".$sql_tournee);
$val_tournee = mysql_fetch_array($result_tournee);

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Photo du concert de <? echo $val_tournee['lieu']; ?> le <? echo affiche_date($val_tournee['date']); ?></title>
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

<img src="../functions/image.php?mode=concert&concert_id=<? echo $val_illu['concert_id']; ?>&photo_id=<? echo $val_illu['photo_id']; ?>" border="0"><br><br>
<? if ($val_illu["description"] != "") { echo "<font size=2><b>Description : </b>".$val_illu["description"]."</font>"; } ?><br>
<? if ($val_illu["photographe"] != "") { echo "<font size=2><b>Photographe : </b>".$val_illu["photographe"]."</font>"; } ?>
</body>

</html>
