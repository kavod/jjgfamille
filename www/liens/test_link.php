<?php

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

// On trouve le referer
preg_match("|(http://[^/]*).*|",$_SERVER['HTTP_REFERER'],$matches);
if (count($matches)>1)
{
	// On vide les clicks de la veille
	$sql_del = "DELETE FROM liens_visitors WHERE day <> ".date('d');
	mysql_query($sql_del) or die("Erreur Interne<br>Requète SQL : ".$sql_del);
	
	// On cherche si l'utilisateur a déjà fait un click
	$sql_select_ip = "SELECT * FROM liens_visitors WHERE ip = '".$_SERVER['REMOTE_ADDR']."' AND day = ".date('d');
	$result_select_ip = mysql_query($sql_select_ip) or die("Erreur Interne<br>Requète SQL invalide : ".$sql_select_ip);
	if (mysql_num_rows($result_select_ip)==0)
	{
		// Non, son click est pris en compte
		// On cherche le site en question dans la rubrique liens
		$tab_sites = select_liste("SELECT site_id FROM liens_sites WHERE url LIKE '" . $matches[1] . "%'");
		if (count($tab_sites)>0)
		{
			// On a détecté le site référent
			$site_id = $tab_sites[0]['site_id'];
			
			$sql_add = "INSERT INTO liens_visitors (day,ip,site_id) VALUES (".date('d').",'".$_SERVER['REMOTE_ADDR']."',".$site_id.")";
			mysql_query($sql_add) or die("Erreur Interne<br>Requète SQL : ".$sql_add);
			//logger("Ajout d'un lien visiteur pour le site ". $tab_sites['site_name']);
			
			$sql_update = "UPDATE liens_sites SET score = score+1 WHERE site_id = ".$site_id;
			mysql_query($sql_update) or die("Erreur Interne<br>Requète SQL : ".$sql_update);
			//logger("Modification du score pour le site ". $tab_sites['site_name']);
		} else
		{
			// Le site référent n'est pas dans les liens
		}
	} else
	{
		// Oui, son click a déjà été pris en compte
	}
	
} else
{
	// Pas de référents
}
?>