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

if ($_GET['mode'] == 'add')
{
	$comment = $_POST['comment'];
	$type = $_POST['type'];
	$sql_update = "UPDATE tournee_billets SET comment='".$comment."',type='".$type."' WHERE billet_id=".$_GET['billet_id']."";
	mysql_query($sql_update);
	logger("Modification du billet N°$billet_id dans les tournées");
	$comment = htmlentities($comment);			
}

$sql_illu = "SELECT * FROM tournee_billets WHERE billet_id=".$_GET['billet_id']." ";
$result_illu = mysql_query($sql_illu) or die("Erreur Interne<br>Requète SQL : ".$sql_illu);
$val_illu = mysql_fetch_array($result_illu);

$sql_tournee = "SELECT * FROM tournee_tournees WHERE tournee_id=".$val_illu['tournee_id']." ";
$result_tournee = mysql_query($sql_tournee) or die("Erreur Interne<br>Requète SQL : ".$sql_tournee);
$val_tournee = mysql_fetch_array($result_tournee);

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><? echo $val_illu['type'];?> de la tournée <? echo $val_tournee['title']; ?></title>
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

<img src="../functions/image.php?mode=tournee&billet_id=<? echo $val_illu['billet_id']; ?>&tournee_id=<? echo $val_illu['tournee_id']; ?>" border="0"><br>
<? if ($val_illu["comment"] != "") { echo "<font size=2><b>Commentaires :</b><br>".$val_illu["comment"]."</font>"; } ?>
<br /><br /><br /><br /><br />
<? 
// Boris 12/11/2006
// Bug 0000020
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
{ ?>
	<form method="post" action="billet.php?mode=add&billet_id=<? echo $val_illu['billet_id']; ?>">
	<font size=2><b>Commentaires :</b></font> <input type="text" size="40" name="comment" value="<? echo $val_illu['comment']; ?>"><br>
	<font size=2><b>Type :</b></font>
	<select name="type">
	<option value="Billet"<? if($val_illu['type']=="Billet"){echo "selected";}?>>Billet</option>
	<option value="Affiche"<? if($val_illu['type']=="Affiche"){echo "selected";}?>>Affiche</option>
	<option value="Pass VIP"<? if($val_illu['type']=="Pass VIP"){echo "selected";}?>>Pass VIP</option>
	<option value="Programme"<? if($val_illu['type']=="Programme"){echo "selected";}?>>Programme</option>
	</select><br>
	<input type="submit" name="submit" value="Modifier">
	</form>
<? } 
// fin bug 0000020
?>
</body>

</html>
