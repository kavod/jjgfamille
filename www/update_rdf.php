<?
// V�rification de l'IP
if ($_SERVER['REMOTE_ADDR'] == '62.212.120.90')
{
	// Variables n�cessaires aux inclusions
	define('IN_PHPBB',1);
	define('IN_ADMIN',1);
	$phpEx = 'php';
	$phpbb_root_path = './';
	$table_prefix = 'phpbb_';

	// Rappatriement des mots de passes de connexion
	require_once($phpbb_root_path.'forum/config.php');
	// Connexion � la base de donn�es
	require_once($phpbb_root_path.'includes/db.php');
	// Rappatriement de la fonction delete_user
	require_once($phpbb_root_path.'includes/functions.php');
	// Fichier sessions
	require_once($phpbb_root_path.'includes/sessions.php');
	// Fichier des constantes (pour les noms de table)
	require_once($phpbb_root_path.'includes/constants.php');
	
	// S�lection de la date de derni�re ex�cution
	$sql = "SELECT user_id FROM rdf_membre";
	$result = mysql_query($sql);
	while($val = mysql_fetch_array($result))
	{
		$sql_user = "SELECT username FROM phpbb_users WHERE user_id = ' " . $val['user_id'] . "'";
		$result_user = mysql_query($sql_user);
		$val_user = mysql_fetch_array($result_user);
		
		$sql_update = "UPDATE rdf_membre SET username = '" . $val_user['username'] . "' WHERE user_id = '" . $val['user_id'] . "'";
		mysql_query($sql_update);
	}
}
exit();
?>