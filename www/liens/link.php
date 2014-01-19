<?php

// Redirection obsolète. Toujours demander un lien vers la page d'accueil.
// Utilisation de la réponse apache 301 Moved Permanently pour optimiser le référencement.
header("Status: 301 Moved Permanently", false, 301);
header("Location: http://" . $_SERVER['HTTP_HOST']);
exit();

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'liens';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LIENS);
init_userprefs($userdata);
//
// End session management
//

if (!isset($_GET['site_id']))
	die("Erreur dans la transmission des variables");
$site_id = $_GET['site_id'];
if ($site_id == "")
	die("Le champs 'site_id' est obligatoire");

$sql_del = "DELETE FROM liens_visitors WHERE day <> ".date('d');
mysql_query($sql_del) or die("Erreur Interne<br>Requète SQL : ".$sql_del);

$sql_select_ip = "SELECT * FROM liens_visitors WHERE ip = '".$_SERVER['REMOTE_ADDR']."' AND day = ".date('d');
$result_select_ip = mysql_query($sql_select_ip) or die("Erreur Interne<br>Requète SQL invalide : ".$sql_select_ip);
if (mysql_num_rows($result_select_ip)==0)
{
	$sql_add = "INSERT INTO liens_visitors (day,ip,site_id) VALUES (".date('d').",'".$_SERVER['REMOTE_ADDR']."',".$site_id.")";
	mysql_query($sql_add) or die("Erreur Interne<br>Requète SQL : ".$sql_add);
	logger("Ajout d'un lien visiteur pour le site N°$site_id");
	
	$sql_select = "SELECT score FROM liens_sites WHERE site_id = ".$site_id;
	$result_select = mysql_query($sql_select)or die("Erreur Interne<br>Requète SQL invalide : ".$sql_select);
	$val_select = mysql_fetch_array($result_select) or die("Erreur Interne<br>Site inconnu<br>Requète SQL : ".$sql_select);
	
	$sql_update = "UPDATE liens_sites SET score = ".($val_select['score']+1)." WHERE site_id = ".$site_id;
	mysql_query($sql_update) or die("Erreur Interne<br>Requète SQL : ".$sql_update);
	logger("Modification du score pour le site N°$site_id");
}
header("Location:" . append_sid($phpbb_root_path));
exit();
?>
