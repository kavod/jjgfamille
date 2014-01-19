<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'liens';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LIENS);
init_userprefs($userdata);
//
// End session management
//
/**
 * Fonction permettant de changer la valeur "ordre" dans une table.
 *
 * @param $table (string) nom de la table à modifier (ex : "disco_song")
 * @param $identifiant (string) nom du champs identifiant (ex : song_id)
 * @param $id (int) valeur de l'identifiant de l'enregistrement à modifier
 * @param $common (string) nom du champs communs à tous les éléments de la liste. Par exemple, s'il s'agit de modifier l'ordre des chansons dans un album, le champs "album_id" est l'élement commun à tous les enregistrements de la liste. Ce sera donc la valeur de ce champs
 */
include($phpbb_root_path . 'functions/functions.php');
switch($_GET['mode'])
{
	
	case "activ":
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['site_id']))
			die("Erreur dans la transmission des variables");
		$site_id = $_GET['site_id'];
		if ($site_id == "")
			die("L'indication du site est obligatoire");
		
		$sql_select = "SELECT enable FROM liens_sites WHERE site_id = ".$site_id;
		$result_select = mysql_query($sql_select) or die("Erreur Interne<br>Requète SQL : ".$sql_select);
		$val_select = mysql_fetch_array($result_select) or die("Site introuvable");
		$nenable = ($val_select['enable']=='Y') ? 'N' : 'Y';
		$errmsg = ($val_select['enable']=='Y') ? "la désactivation" : "l'activation";
			
		$sql_update = "UPDATE liens_sites SET enable = '".$nenable."' WHERE site_id = ".$site_id;
		mysql_query($sql_update) or die("Erreur Interne durant ".$errmsg." du site<br>Requète SQL : ".$sql_update);
		logger("$errmsg du site N°$site_id (liens)");
		header("Location:" . append_sid("edit_site.php?site_id=" . $site_id,true));
		break;
		
	case "edit_site":
	
		if (!isset($_GET['site_id']))
			die("Erreur dans la transmission des variables");
		$site_id = $_GET['site_id'];
		if ($site_id == "")
			die("L'indication du site est incorrect");
		$val_sites = select_element("SELECT * FROM liens_sites WHERE site_id = '$site_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens') || $userdata['user_id'] == $val_sites['user_id'])
		{
			if (!isset($_POST['site_name']) || !isset($_POST['url']) || !isset($_POST['description']))
				die("Erreur dans la transmission des variables");
			if ((!isset($_POST['plus']) || !isset($_POST['moins'])) && ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens')))
				die("Erreur dans la transmission des variables");
				
			$site_name = $_POST['site_name'];
			$url = $_POST['url'];
			$description = $_POST['description'];
			$plus = $_POST['plus'];
			$moins = $_POST['moins'];
			if ($site_name == "")
				die("Le champs 'Nom du site' est obligatoire");
			if ($url == "")
				die("Le champs 'URL' est obligatoire");
			if ($description == "")
				die("Le champs 'Description' est obligatoire");
				
			if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
			{
				if ($plus == "")
					die("Le champs 'Plus' est obligatoire");
				if ($moins == "")
					die("Le champs 'Moins' est obligatoire");
			}
			$site_name = htmlentities($site_name);
			$url = htmlentities($url);
			$description = delete_html($description); 
			$description= str_replace("\n","<br>",$description);
			$plus = delete_html($plus);
			$plus= str_replace("\n","<br>",$plus);
			$moins = delete_html($moins); 
			$moins= str_replace("\n","<br>",$moins); 
			
			$sql_update = "UPDATE liens_sites SET site_name = '".$site_name."', url = '".$url."', description = '".$description."'";
			if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
				$sql_update .= " ,plus = '".$plus."',moins = '".$moins."'";
			$sql_update .= " WHERE site_id = ".$site_id;
			mysql_query($sql_update) or die("Erreur Interne durant l'édition du site<br>Requète SQL : ".$sql_update);
			logger("Modification du site $site_name (liens)");
			header("Location:" . append_sid("edit_site.php?site_id=" . $site_id,true));
			exit();
		} else
			message_die(GENERAL_MESSAGE,$lang['not_allowed']);
		break;
		
	case "add_cate":
	
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		
		if (!isset($_POST['cate_name']))
			die("Erreur dans la transmission des variables");
		$cate_name = $_POST['cate_name'];
		if ($cate_name == "")
			die("Le champs 'Nom de la catégorie' est obligatoire");
			
		$sql_ordre = "SELECT ordre FROM liens_categories ORDER BY ordre DESC";
		$result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br>Requète SQL : ".$sql_ordre);
		if (!$val_ordre = mysql_fetch_array($result_ordre))
			$val_ordre['ordre']=0;
		
		$val_ordre['ordre']++;
		
		$cate_name = htmlentities($cate_name);
			
		$sql_add = "INSERT INTO liens_categories (cate_name,ordre,artist_id) VALUES ('".$cate_name."',".$val_ordre['ordre'].",1)";
		mysql_query($sql_add) or die("Erreur Interne durant l'ajout de la catégorie<br>Requète SQL : ".$sql_add);
		logger("Ajout de la categorie $cate_name (liens)");
		header("Location:" . append_sid("index.php"));	
		break;
		
	case "edit_cate":
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
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
			
		$sql_update = "UPDATE liens_categories SET cate_name = '" . $cate_name . "' WHERE cate_id = " . $cate_id;
		mysql_query($sql_update) or die("Erreur Interne durant l'édition de la catégorie<br>Requète SQL : ".$sql_update);
		logger("Modification de la categorie $cate_name (liens)");
		header("Location:" . append_sid("view_cate.php?cate_id=" . $cate_id,true));
		exit();
		break;
		
	case "supp_site";
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['site_id']))
			die("Erreur dans la transmission des variables");
		$site_id = $_GET['site_id'];
		if ($site_id == "")
			die("L'indication du site est obligatoire");
		
		$sql_select = "SELECT cate_id FROM liens_cate_site WHERE site_id = ".$site_id;
		$result_select = mysql_query($sql_select) or die("Erreur Interne<br>Requète SQL : ".$sql_select);
		if (!$val_select = mysql_fetch_array($result_select))
			$val_select['cate_id'] = 0;
		
		$sql_del_asso = "DELETE FROM liens_cate_site WHERE site_id = ".$site_id;
		mysql_query($sql_del_asso) or die("Erreur Interne durant la suppression du site<br>Requète SQL : ".$sql_del);
		
		$sql_del = "DELETE FROM liens_sites WHERE site_id = ".$site_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression du site<br>Requète SQL : ".$sql_del);
		logger("Suppression du site N°$site_id (liens)");
		if ($val_select['cate_id']==0)
			header("Location:" . append_sid("index.php"));
		else
			header("Location:" . append_sid("view_cate.php?cate_id=" . $val_select['cate_id'],true));
		break;
			
	case "supp_cate";
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		$sql_del = "DELETE FROM liens_categories WHERE cate_id = ".$cate_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la catégorie<br>Requète SQL : ".$sql_del);
		
		$sql_del = "DELETE FROM liens_cate_site WHERE cate_id = ".$cate_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression des associations à la catégorie<br>Requète SQL : ".$sql_del);
		logger("Suppression de la categorie N°$cate_id (liens)");
		header("Location:" . append_sid("index.php"));
		break;
	
	case "asso":
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_POST['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_POST['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
			
		if (!isset($_GET['site_id']))
			die("Erreur dans la transmission des variables");
		$site_id = $_GET['site_id'];
		if ($site_id == "")
			die("L'indication du site est obligatoire");
			
		if ($cate_id != 0)
		{
			$sql_add = "INSERT INTO liens_cate_site (cate_id,site_id) VALUES (".$cate_id.",".$site_id.")";
			mysql_query($sql_add) or die("Erreur Interne durant l'association de la catégorie<br>Requète SQL : ".$sql_add);
		}
		logger("Le site N°$site_id est associé à la categorie N°$cate_id (liens)");
		header("Location:" . append_sid("edit_site.php?site_id=" . $site_id,true));
		break;
			
	case "supp_asso";
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		if (!isset($_GET['site_id']))
			die("Erreur dans la transmission des variables");
		$site_id = $_GET['site_id'];
		if ($site_id == "")
			die("L'indication du site est obligatoire");
		$sql_del = "DELETE FROM liens_cate_site WHERE cate_id = ".$cate_id." AND site_id = ".$site_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la catégorie<br>Requète SQL : ".$sql_del);
		logger("Le site N°$site_id est déassocié");
		header("Location:" . append_sid("view_cate.php?cate_id=" . $cate_id,true));
		break;	
			
	case "upcate":
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		upasso('liens_categories','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("index.php"));
		break;
		
	case "downcate":
		$job=array('liens');
		include($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		downasso('liens_categories','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("index.php"));
		break;
		
	default:
		die("Commande " . $_GET['mode'] ." inconnue");
}
exit();
?>