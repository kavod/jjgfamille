<?
	// Variables nécessaires aux inclusions
	define('IN_PHPBB',1);
	define('IN_ADMIN',1);
	$phpEx = 'php';
	$phpbb_root_path = './';
	$table_prefix = 'phpbb_';

	// Rappatriement des mots de passes de connexion
	require_once($phpbb_root_path.'forum/config.php');
	// Connexion à la base de données
	require_once($phpbb_root_path.'includes/db.php');
	// Rappatriement de la fonction delete_user
	require_once($phpbb_root_path.'includes/functions.php');
	// Fichier sessions
	require_once($phpbb_root_path.'includes/sessions.php');
	// Fichier des constantes (pour les noms de table)
	require_once($phpbb_root_path.'includes/constants.php');

	$sql = "SELECT util.user_id, COUNT(util.user_id) postcount FROM phpbb_users util, phpbb_posts msg WHERE util.user_id = msg.poster_id AND util.user_id <> -1 GROUP BY user_id";
	$result = mysql_query($sql);
	while($val = mysql_fetch_array($result))
	{	
		$sql = "UPDATE phpbb_users SET user_posts = '" . $val["postcount"] . "' WHERE user_id = '" . $val['user_id'] . "'";
		echo $sql."<br />";
		mysql_query($sql);
	}
?>