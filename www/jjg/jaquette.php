<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'jjg';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_JJG);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mode'] == 'add')
{
	$comment = $_POST['comment'];
	$comment = htmlentities($comment);	
	$sql_update = "UPDATE biblio_illu SET comment='".$comment."' WHERE illu_id=".$_GET['jack_id']."";
	mysql_query($sql_update);
	logger("Modification de la jaquette N°$jack_id de livre dans la bilbliotheque");
				
}

$sql_illu = "SELECT * FROM biblio_illu WHERE illu_id=".$_GET['jack_id']." ";
$result_illu = mysql_query($sql_illu) or die("Erreur Interne<br />Requète SQL : ".$sql_illu);
$val_illu = mysql_fetch_array($result_illu);

$sql_livre = "SELECT * FROM biblio_livre WHERE livre_id=".$val_illu['livre_id']." ";
$result_livre = mysql_query($sql_livre) or die("Erreur Interne<br />Requète SQL : ".$sql_livre);
$val_livre = mysql_fetch_array($result_livre);

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Jaquette de <? echo $val_livre['title']; ?></title>
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
<img src="../functions/image.php?mode=biblio&livre_id=<? echo $val_illu['livre_id']; ?>&illu_id=<? echo $val_illu['illu_id']; ?>" border="0"><br />
<? if ($val_illu["comment"] != "") { echo "<font size=2><b>Commentaires :</b><br />".nl2br(bbencode_second_pass($val_illu["comment"],$val_illu['bbcode_uid']))."</font>"; } ?>
<br><br><br><br><br>
<form method="post" action="jaquette.php?mode=add&jack_id=<? echo $val_illu['illu_id']; ?>">
<input type="text" size="40" name="comment" value="<? echo preg_replace('/\:(([a-z0-9]:)?)' . $val_illu['bbcode_uid'] . '/s', '', $val_illu['comment']) ?>"><br>
<input type="submit" name="submit" value="Modifier">
</form>
</body>

</html>
