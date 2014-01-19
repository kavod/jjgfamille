<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//
$job=array('more');
include($phpbb_root_path . 'includes/reserved_access.php');
include($phpbb_root_path . 'functions/functions.php');


/**
 * Permet de supprimer un goodies sur le FTP anonyme
 *
 * @param $error Booléen indiquant une erreur
 * @param $error_msg Message descriptif de l'erreur
 * @param $file chemin vers le fichier *AVEC* EXTENSION
 */
function supp_ftp_anon(&$error,&$error_msg,$file)
{
	global $phpbb_root_path,$ftp_anon_server,$ftp_anon_login,$ftp_anon_password;
	
	$conn_id = ftp_connect($ftp_anon_server); 
	$login_result = ftp_login($conn_id, $ftp_anon_login, $ftp_anon_password); 
	// Vérification de la connexion
	if ((!$conn_id) || (!$login_result)) 
	{
		$error = true;
		$error_msg .= "<br />La connexion FTP a échoué !";
	}
	
	// Chargement d'un fichier
	$upload = ftp_delete($conn_id, $file);
	
	// Vérification du status du chargement
	if (!$upload) 
	{
		$error = true;
		$error_msg .= "<br />Le chargement FTP a échoué!";
	}
	
	// Fermeture du flux FTP
	ftp_close($conn_id); 
}
// Fin de la fonction

switch($_GET['mode'])
{
	
	case "activ":
		if (!isset($_GET['more_id']))
			die("Erreur dans la transmission des variables");
		$more_id = $_GET['more_id'];
		if ($more_id == "")
			die("L'indication du site est obligatoire");
		
		$sql_select = "SELECT enable FROM more WHERE more_id = ".$more_id;
		$result_select = mysql_query($sql_select) or die("Erreur Interne<br>Requète SQL : ".$sql_select);
		$val_select = mysql_fetch_array($result_select) or die("Goodies introuvable");
		$nenable = ($val_select['enable']=='Y') ? 'N' : 'Y';
		$errmsg = ($val_select['enable']=='Y') ? "la désactivation" : "l'activation";
			
		$sql_update = "UPDATE more SET enable = '".$nenable."' WHERE more_id = ".$more_id;
		mysql_query($sql_update) or die("Erreur Interne durant ".$errmsg." du goodies<br>Requète SQL : ".$sql_update);
		logger("$errmsg du goodies N°$more_id (En ++)");
		header("Location:" . append_sid("edit_more.php?more_id=" . $more_id,true));
		break;
		
	case "add_cate":
		if (!isset($_POST['cate_name']))
			die("Erreur dans la transmission des variables");
		$cate_name = $_POST['cate_name'];
		if ($cate_name == "")
			die("Le champs 'Nom de la catégorie' est obligatoire");
			
		$sql_ordre = "SELECT ordre FROM more_cate ORDER BY ordre DESC";
		$result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br>Requète SQL : ".$sql_ordre);
		if (!$val_ordre = mysql_fetch_array($result_ordre))
			$val_ordre['ordre']=0;
		
		$val_ordre['ordre']++;
		
		$cate_name = htmlentities($cate_name);
			
		$sql_add = "INSERT INTO more_cate (cate_name,ordre,artist_id) VALUES ('".$cate_name."',".$val_ordre['ordre'].",1)";
		mysql_query($sql_add) or die("Erreur Interne durant l'ajout de la catégorie<br>Requète SQL : ".$sql_add);
		logger("Ajout de la categorie $cate_name (En ++)");
		header("Location:" . append_sid("index.php"));	
		break;
		
	case "edit_cate":
		if (!isset($_POST['cate_name']))
			die("Erreur dans la transmission des variables");
		$cate_name = $_POST['cate_name'];
		if ($cate_name == "")
			die("Le champs 'Nom de la catégorie' est obligatoire");
		
		if (!isset($_POST['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_POST['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		
		$cate_name = htmlentities($cate_name);
			
		$sql_update = "UPDATE more_cate SET cate_name = '" . $cate_name . "' WHERE cate_id = " . $cate_id;
		mysql_query($sql_update) or die("Erreur Interne durant l'édition de la catégorie<br>Requète SQL : ".$sql_update);
		logger("Modification de la categorie $cate_name (En ++)");
		header("Location:" . append_sid("view_cate.php?cate_id=" . $cate_id,true));
		break;
	
	case "supp_more";
		if (!isset($_GET['more_id']))
			die("Erreur dans la transmission des variables");
		$more_id = $_GET['more_id'];
		if ($more_id == "")
			die("L'indication du goodies est obligatoire");
		
		$sql = "SELECT file FROM more WHERE more_id = ".$more_id;
		$result = mysql_query($sql) or die("Erreur Interne<br>Requète SQL : ".$sql);
		$val = mysql_fetch_array($result);
		
		$sql_count = "SELECT COUNT(more_id) as NUM FROM more WHERE file = '".$val['file']."'";
		$result_count = mysql_query($sql_count) or die("Erreur Interne<br>Requète SQL : ".$sql_count);
		$val_count = mysql_fetch_array($result_count);
				
		@unlink($phpbb_root_path . 'images/goodies/goodies_' . $more_id.".".find_image($phpbb_root_path . 'images/goodies/goodies_' . $more_id));
		if($val_count['NUM'] == 1)
		 {
		 	supp_ftp_anon($error,$error_msg,'goodies/'.$val['file']);
			//@unlink($phpbb_root_path . 'goodies/'. $val['file']);
		 }
		 
		$sql_del = "DELETE FROM more WHERE more_id = ".$more_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression du goodies<br>Requète SQL : ".$sql_del);
		logger("Suppression du goodies N°$more_id (En ++)");

		header("Location:" . append_sid("index.php"));
		break;
			
	case "supp_cate";
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		$sql_del = "DELETE FROM more_cate WHERE cate_id = ".$cate_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la catégorie<br>Requète SQL : ".$sql_del);
		
		logger("Suppression de la categorie N°$cate_id (En ++)");
		header("Location:" . append_sid("index.php"));
		break;
	
	case "upcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		upasso('more_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("index.php"));
		break;
		
	case "downcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		downasso('more_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("index.php"));
		break;
		
	default:
		die("Commande " . $_GET['mode'] ." inconnue");
}
exit();
?>