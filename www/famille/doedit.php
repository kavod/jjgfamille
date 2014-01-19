<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'famille';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//

//include($phpbb_root_path . 'includes/reserved_access.php');
include($phpbb_root_path . 'functions/functions.php');

switch($_GET['mode'])
{
			
	case "supp_rub":
		if (!isset($_GET['rub_id']))
			die("Erreur dans la transmission des variables");
		$rub_id = $_GET['rub_id'];
		if ($rub_id == "")
			die("L'indication du la rubrique est obligatoire");
		
		$ext = find_image('../images/famille/rub_' . $rub_id .'.');
		if (is_file('../images/famille/rub_' . $rub_id .'.'.$ext))
		{
			
			unlink('../images/famille/rub_' . $rub_id . '.'.$ext);
		}
					
		$sql_del = "DELETE FROM famille_rub WHERE rub_id = ".$rub_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la rubrique<br>Requète SQL : ".$sql_del);
		logger("Suppression de la rubrique N°$rub_id de la rubrique famille");		
		header("Location:" . append_sid("index.php"));		
		break;

	case 'up_rub':
		upasso('famille_rub','rub_id',$_GET['rub_id'],"''");
		logger("Modification de l'ordre des rubriques dans 'famille'");
		header('Location:' . append_sid($phpbb_root_path . 'famille/index.php'));
		break;
	case 'down_rub':
		downasso('famille_rub','rub_id',$_GET['rub_id'],"''");
		logger("Modification de l'ordre des rubriques dans 'famille'");
		header('Location:' . append_sid($phpbb_root_path . 'famille/index.php'));
		break;
	case "supp_mascotte":
		if (!isset($_GET['rub_id']))
			die("Erreur dans la transmission des variables");
		$rub_id = $_GET['rub_id'];
		if ($rub_id == "")
			die("L'indication du la rubrique est obligatoire");
		
		$ext = find_image('../images/famille/rub_' . $rub_id .'.');
		if (is_file('../images/famille/rub_' . $rub_id .'.'.$ext))
		{
			
			unlink('../images/famille/rub_' . $rub_id . '.'.$ext);
		}
					
		logger("Suppression de la mascotte de la rubrique N°$rub_id de famille");
		header("Location:" . append_sid("rub.php?rub_id=".$rub_id,true));
		break;	
	case "supp_rdf":
		if (!isset($_GET['rdf_id']))
			die("Erreur dans la transmission des variables");
		$rdf_id = $_GET['rdf_id'];
		if ($rdf_id == "")
			die("L'indication du la rdf est obligatoire");
		
		mysql_query("DELETE FROM rdf_membre WHERE rdf_id = ".$rdf_id) or die("Erreur Interne durant la suppression de la rdf");
		mysql_query("DELETE FROM rdf WHERE rdf_id = ".$rdf_id) or die("Erreur Interne durant la suppression de la rdf");
					
		logger("Suppression de la rdf N°$rdf_id");		
		header("Location:" . append_sid("rdf.php"));		
		break;	
	case "supp_recit":
		if (!isset($_GET['rdf_id']))
			die("Erreur dans la transmission des variables");
		$rdf_id = $_GET['rdf_id'];
		if ($rdf_id == "")
			die("L'indication de la rdf est obligatoire");
		
		if (!isset($_GET['recit_id']))
			die("Erreur dans la transmission des variables");
		$recit_id = $_GET['recit_id'];
		if ($recit_id == "")
			die("L'indication du récit est obligatoire");
		
		mysql_query("DELETE FROM rdf_recits WHERE recit_id = ".$recit_id) or die("Erreur Interne durant la suppression de la rdf");
					
		logger("Suppression du recit N°$recit_id de la rdf N°$rdf_id");		
		header("Location:" . append_sid("view_rdf.php?rdf_id=".$rdf_id,true));		
		break;	
	case "supp_photo":
		if (!isset($_GET['rdf_id']))
			die("Erreur de tranmission de variables");
		$rdf_id = $_GET['rdf_id'];
		if ($rdf_id == "")
			die("Le champ rdf_id est obligatoire");
		
		if (!isset($_GET['photo_id']))
			die("Erreur de tranmission de variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id == "")
			die("Le champ photo_id est obligatoire");
		
		$ext = find_image("../images/rdf/photo_".$rdf_id."_".$photo_id.".");
		unlink("../images/rdf/photo_".$rdf_id."_".$photo_id.".".$ext);	
		
		$sql_delete = "DELETE FROM rdf_photos WHERE photo_id = ".$photo_id;
		mysql_query($sql_delete) or die("Erreur Interne durant la suppression de la photo<br>Requète SQL : ".$sql_delete);
		
		header("Location:" . append_sid("view_rdf.php?rdf_id=".$rdf_id,true));
		break;
	
	case "up_photo":
		if (!isset($_GET['rdf_id']))
			die("Erreur de tranmission de variables");
		$rdf_id = $_GET['rdf_id'];
		if ($rdf_id == "")
			die("Le champ rdf_id est obligatoire");
		
		if (!isset($_GET['photo_id']))
			die("Erreur de tranmission de variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id == "")
			die("Le champ photo_id est obligatoire");
			
		upasso('rdf_photos','photo_id',$photo_id,'rdf_id');
		header("Location:" . append_sid("photos.php?rdf_id=".$rdf_id,true));
		break;
	
	case "down_photo":
		if (!isset($_GET['rdf_id']))
			die("Erreur de tranmission de variables");
		$rdf_id = $_GET['rdf_id'];
		if ($rdf_id == "")
			die("Le champ rdf_id est obligatoire");
		
		if (!isset($_GET['photo_id']))
			die("Erreur de tranmission de variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id == "")
			die("Le champ photo_id est obligatoire");
			
		downasso('rdf_photos','photo_id',$photo_id,'rdf_id');
		header("Location:" . append_sid("photos.php?rdf_id=".$rdf_id,true));
		break;		
	default:
		die("Commande " . $_GET['mode'] ." inconnue");
}
exit();
?>