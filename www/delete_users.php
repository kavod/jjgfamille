<?
define("WEBMASTER_EMAIL","webmaster@domain.com");

// V�rification de l'IP
if ($_SERVER['REMOTE_ADDR'] == '88.162.168.86' or $_SERVER['REMOTE_ADDR'] == '82.227.123.248')
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
	
	// Initialisation de la variable de log
	$logs = "";
	// D�finition de la death line
	define('DEATH_LINE',mktime(10,0,0,11,1,2005));
	// Sauvegarde de l'heure pr�cise d'ex�cution
	define('MA_DATE',mktime());
	$logs .= "Nous sommes le " . date('d/m/Y',MA_DATE)."<br />";
	// D�finition du message de relance
	define('MESSAGE',"Bonjour %s\r\n\r\nVotre compte sur JJG famille ( http://" . $_SERVER['HTTP_HOST'] . " ) arrive � �ch�ance dans un mois. En effet, il semblerait que vous ne nous ayez pas rendu visite depuis plus de 5 mois et nous en concluons donc que vous ne souhaitez plus faire parti de notre liste d'utilisateurs.\r\n\r\nSi vous souhaitez tout de m�me conserver votre compte, rendez-vous simplement sur http://" . $_SERVER['HTTP_HOST'] . " et identifiez-vous � l'aide de la boite \"votre compte\" en haut � droit du site.\r\n\r\nNous vous rappelons qu'il est n�cessaire de vous identifier au moins 1 fois tous les 6 mois pour ne pas voir son compte expirer. Nous vous conseillons donc de cocher la case \"Identification auto.\" afin de ne pas avoir � s'identifier � chaque passage sur le site.\r\n\r\nPour tout probl�me, n'h�sitez pas � nous contacter.\r\n\r\nCordialement, l'�quipe sur site famille\r\n" . WEBMASTER_EMAIL);
	
	// S�lection de la date de derni�re ex�cution
	$sql = "SELECT valeur_num FROM famille_config WHERE param = 'last_expiration'";
	$result = mysql_query($sql);
	$val = mysql_fetch_array($result);
	$last_expiration = $val['valeur_num'];
	
	// Si la derni�re �x�cution a d�j� eu lieu aujourd'hui : annulation
	if (date('Ymd',MA_DATE)>date('Ymd',$last_expiration))
	{
		// S�lection du mode :
		// Si avant la death line : simulation seulement
		if (date('Ymd',MA_DATE)<date('Ymd',DEATH_LINE))
		{
			$mode = 1; // On enregistre le mode
			$logs .= "Ceci est une simulation\r\n"; // sa description
			// la requ�te de s�lection est : pas user Admins, pas confirm� et pas le user Anonyme
			$sql_del = "SELECT username, user_id FROM phpbb_users WHERE username <> 'Admins' AND confirm_assoc = 'N' AND user_id>0";
		}
		// Si c'est le jour de death line : suppression de tous les comptes non confirm�s
		if (date('Ymd',MA_DATE)==date('Ymd',DEATH_LINE))
		{
			$mode = 2;
			$logs .= "Suppression de tous les comptes non confirm�s\r\n";
			// La requ�te de s�lection est : pas user admins, pas confirm� et pas le user Anonyme
			$sql_del = "SELECT username, user_id FROM phpbb_users WHERE username <> 'Admins' AND confirm_assoc = 'N' AND user_id>0";
		}
		// Si apr�s la death line : suppression de tous les utilisateurs ne s'�tant pas identifi� depuis plus de 6 mois
		if (date('Ymd',MA_DATE)>date('Ymd',DEATH_LINE))
		{
			$mode = 3;
			$logs .= "Suppression de tous les comptes expir�s\r\n";
			// La requ�te de s�lection est : pas le user admin, pas de user anonyme, r�ception du mail de relance (utilisation de confirm_assoc), visite plus ancienne de 6 mois
			$sql_del = "SELECT username, user_id FROM phpbb_users 
			WHERE
					user_id <> -1 AND
					user_id <> 2 AND
					confirm_assoc = 'N' AND
					(
						(
							user_session_time = 0 AND
							user_active = 1 AND
							user_regdate < UNIX_TIMESTAMP(SUBDATE(NOW(), INTERVAL 6 MONTH))
						) 
						OR
						(
							user_session_time > 0 AND
							user_session_time < UNIX_TIMESTAMP(SUBDATE(NOW(), INTERVAL 6 MONTH))
						)
					)";
			
			// Mail de relance
			// On envoie un mail de relance � tous les utilisateurs autres que admins et anonyme, qui n'en ont pas d�j� recu (utilisation de confirm_assoc) et dont la derni�re visite est entre 5 mois et 6 mois.
			// N.B. La mise � jour de confirm_assoc se fait dans le fichier includes/sessions.php ligne 192 environ
			$sql = "SELECT
					username, user_id, user_email, FROM_UNIXTIME(user_lastvisit), FROM_UNIXTIME(user_session_time)
				FROM 
					phpbb_users
				WHERE
					user_id <> -1 AND
					user_id <> 2 AND
					confirm_assoc = 'Y' AND
					(
						(
							user_session_time = 0 AND
							user_active = 1 AND
							user_regdate < UNIX_TIMESTAMP(SUBDATE(NOW(), INTERVAL 5 MONTH))
						) 
						OR
						(
							user_session_time > 0 AND
							user_session_time < UNIX_TIMESTAMP(SUBDATE(NOW(), INTERVAL 5 MONTH))
						)
					)";

			$result = mysql_query($sql);
			// Pour chaque utilisateur � relancer :
			while($val = mysql_fetch_array($result))
			{
				// On enregistre son adresse email
				$adresse_email = $val['user_email'];
				// On lui envoi un mail de relance
				mail ($adresse_email,"Expiration de votre compte sur JJG famille",sprintf(MESSAGE,$val['username']));
				// On met la variable confirm_assoc afin d'indiquer que le mail a �t� envoy�
				$sql = "UPDATE phpbb_users SET confirm_assoc = 'N' WHERE user_id = '" . $val['user_id']."'";
				// On ex�cute la MaJ
				mysql_query($sql);
				// On enregistre dans le log
				$logs .= "Mail de relance � " . $val['username'] . "\r\n";
			}
		}
		
		// On s�lectionne chaque utilisateur � supprimer
		$result = mysql_query($sql_del);
		while($val = mysql_fetch_array($result))
		{
			switch($mode)
			{
				case 1:
					// Si c'est une simulation, on se contente de l'enregistrer dans le log
					$logs .= 'Utilisateur ' . $val['username'] . ' (' . $val['user_id'] . ") serait supprim�\r\n";
					break;
				case 2:
				case 3:
					// Sinon, on le supprime et on enregistre dans le log
					if (!($this_userdata = get_userdata($val['user_id'])))
					{
						message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
					}
					/*print_r($this_userdata);
					exit();*/
					delete_user($val['user_id']);
					$logs .= 'Utilisateur ' . $val['username'] . ' (' . $val['user_id'] . ") supprim�\r\n";
					break;
				default:
					$logs .= "Mode inconnu";
			}
		}
		// A la fin du traitement, on enregistre la date de la derni�re ex�cution afin d'�viter 2 ex�cutions par jour
		$sql = "UPDATE famille_config SET valeur_num = '" . MA_DATE . "' WHERE param = 'last_expiration'";
		mysql_query($sql);
	} else
	{
		$logs = "L'expiration a d�j� eu lieu aujourd'hui";
	}
} else
{
	$logs = "Vous n'�tes pas autoris� � utiliser cette fonction";
}
// On affiche le r�sultat
echo nl2br($logs);
// et on l'envoi � Boris
mail (WEBMASTER_EMAIL,"suppression des users non confirm�s",$logs);
exit();
?>
