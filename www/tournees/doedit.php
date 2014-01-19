<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'tournees';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_TOURNEES);
init_userprefs($userdata);
//
// End session management
//
include($phpbb_root_path . 'functions/functions.php');

// Boris 12/11/2006
// Bug 0000020
include($phpbb_root_path . 'includes/log_necessary.php');
if ( $userdata['user_level'] != ADMIN && !is_responsable($userdata['user_id'],'tournee'))
	message_die(GENERAL_MESSAGE, $lang['tournee_No_allowed']);
// fin bug 0000020
	
switch($_GET['mode'])
{
	
	case "supp_song";
		if (!isset($_GET['tournee_id']))
			die("Erreur dans la transmission des variables");
		$tournee_id = $_GET['tournee_id'];
		if ($tournee_id == "")
			die("L'indication de la tournee est obligatoire");
		if (!isset($_GET['track_id']))
			die("Erreur dans la transmission des variables");
		$track_id = $_GET['track_id'];
		if ($track_id == "")
			die("L'indication de la chanson est obligatoire");
		
		$sql_supp = "DELETE FROM tournee_tracklist WHERE track_id = ". $track_id ."";
		@mysql_query($sql_supp);
		logger("Suppression de la chanson N°$track_id de la tournée N°$tournee_id");		
		header("Location:" . append_sid("tournees.php?tournee_id=".$tournee_id."",true));
		break;	
	case "supp_photo";
		if (!isset($_GET['concert_id']))
			die("Erreur dans la transmission des variables");
		$concert_id = $_GET['concert_id'];
		if ($concert_id == "")
			die("L'indication du l' émission est obligatoire");
			
		if (!isset($_GET['photo_id']))
			die("Erreur dans la transmission des variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id == "")
			die("L'indication du l'illustration est obligatoire");
		
		$ext = find_image("../images/tourness/concert_".$concert_id."_".$photo_id.".");
		@unlink("../images/tourness/concert_".$concert_id."_".$photo_id.".".$ext);
			
		$sql_supp = "DELETE FROM tournee_photos WHERE photo_id = ". $photo_id ."";
		@mysql_query($sql_supp);
		logger("Suppression de la photo N°$photo_id du concert N°$concert_id");	
		header("Location:" . append_sid("concerts.php?concert_id=".$concert_id."",true));	
		break;
	case "supp_recit";
		if (!isset($_GET['concert_id']))
			die("Erreur dans la transmission des variables");
		$concert_id = $_GET['concert_id'];
		if ($concert_id == "")
			die("L'indication du l' émission est obligatoire");
			
		if (!isset($_GET['recit_id']))
			die("Erreur dans la transmission des variables");
		$recit_id = $_GET['recit_id'];
		if ($recit_id == "")
			die("L'indication du recit est obligatoire");
			
		$sql_supp = "DELETE FROM tournee_recits WHERE recit_id = ". $recit_id ."";
		@mysql_query($sql_supp);
		logger("Suppression du recit N°$recit_id du concert N°$concert_id");	
		header("Location:" . append_sid("concerts.php?concert_id=".$concert_id."",true));	
		break;			
	case "supp_billet";
		if (!isset($_GET['tournee_id']))
			die("Erreur dans la transmission des variables");
		$tournee_id = $_GET['tournee_id'];
		if ($tournee_id == "")
			die("L'indication de la tournee est obligatoire");
			
		if (!isset($_GET['billet_id']))
			die("Erreur dans la transmission des variables");
		$billet_id = $_GET['billet_id'];
		if ($billet_id == "")
			die("L'indication du billet est obligatoire");
		
		$ext = find_image("../images/tournees/billet_".$tournee_id."_".$illet_id.".");
		@unlink("../images/tournees/billet_".$tournee_id."_".$illet_id.".".$ext);
			
		$sql_supp = "DELETE FROM tournee_billets WHERE billet_id = ". $billet_id ."";
		@mysql_query($sql_supp);
		logger("Suppression du billet N°$billet_id de la tournée N°$tournee_id");	
		header("Location:" . append_sid("tournees.php?tournee_id=".$tournee_id."",true));	
		break;	
	case "upsong":
		if (!isset($_GET['tournee_id']))
			die("Erreur dans la transmission des variables");
		$tournee_id = $_GET['tournee_id'];
		if ($tournee_id == "")
			die("L'indication de la tournee est obligatoire");
		if (!isset($_GET['track_id']))
			die("Erreur dans la transmission des variables");
		$track_id = $_GET['track_id'];
		if ($track_id == "")
			die("L'indication de la chanson est obligatoire");
		upasso('tournee_tracklist','track_id',$track_id,'tournee_id');
		header("Location:" . append_sid("tournees.php?tournee_id=".$tournee_id."",true));
		break;
	case "downsong":
		if (!isset($_GET['tournee_id']))
			die("Erreur dans la transmission des variables");
		$tournee_id = $_GET['tournee_id'];
		if ($tournee_id == "")
			die("L'indication de la tournee est obligatoire");
		if (!isset($_GET['track_id']))
			die("Erreur dans la transmission des variables");
		$track_id = $_GET['track_id'];
		if ($track_id == "")
			die("L'indication de la chanson est obligatoire");
		downasso('tournee_tracklist','track_id',$track_id,'tournee_id');
		header("Location:" . append_sid("tournees.php?tournee_id=".$tournee_id."",true));
		break;	
	case "supp_tournee";	
		if (!isset($_GET['tournee_id']))
			die("Erreur dans la transmission des variables");
		$tournee_id = $_GET['tournee_id'];
		if ($tournee_id == "")
			die("L'indication de la tournée est obligatoire");
		
		// Sélection de chaque concert
		$sql_concert = "SELECT concert_id FROM tournee_concerts WHERE tournee_id = ".$tournee_id;
		$result_concert = mysql_query($sql_concert);
			while ($val_concert = mysql_fetch_array($result_concert))
			{
				// suppression des récits
				$sql_del = "DELETE FROM tournee_recits WHERE concert_id = ".$val_concert['concert_id'];
				mysql_query($sql_del);

		//Sélection de chaque photo
		$sql_photo = "SELECT photo_id FROM tournee_photos WHERE concert_id = ".$val_concert['concert_id'];
		$result_photo = mysql_query($sql_photo);
		while ($val_photo = mysql_fetch_array($result_photo))
		{
			// Suppression des photos et de leur référencement
			$ext = find_image("../images/tournees/concert_".$val_concert['concert_id']."_".$val_photo['photo_id'].".");
			unlink("../images/tournees/concert_".$val_concert['concert_id']."_".$val_photo['photo_id'].".".$ext);
			$sql_del = "DELETE FROM tournee_photos WHERE photo_id = ".$val_photo['photo_id'];
			mysql_query($sql_del);
		}
		
		// Suppression des concerts
		$sql_del = "DELETE FROM tournee_concerts WHERE concert_id = ".$val_concert['concert_id'];
		mysql_query($sql_del);
		}
	
		// Sélection de chaque billet
		$sql_billet = "SELECT billet_id FROM tournee_billets WHERE tournee_id = ".$tournee_id;
		$result_billet = mysql_query($sql_billet);
		while ($val_billet = mysql_fetch_array($result_billet))
			{
			// Suppression des billets et de leur référencements
			$ext = find_image("../images/tournees/billet_".$tournee_id."_".$val_billet['billet_id'].".");
			unlink("../images/tournees/billet_".$tournee_id."_".$val_billet['billet_id'].".".$ext);
			$sql_del = "DELETE FROM tournee_billet WHERE billet_id = ".$val_billet['billet_id'];
			mysql_query($sql_del);
			}
	
		// Suppression de la tournée.
		$sql_del = "DELETE FROM tournee_tournees WHERE tournee_id = ".$tournee_id;
		mysql_query($sql_del);	
		logger("Suppression de la tournée N°$tournee_id");
		header("Location:" . append_sid("index.php"));
		break;	
	case "supp_concert";
		
		if (!isset($_GET['concert_id']))
			die("Erreur dans la transmission des variables");
		$concert_id = $_GET['concert_id'];
		if ($concert_id == "")
			die("L'indication du concert est obligatoire");
		if (!isset($_GET['tournee_id']))
			die("Erreur dans la transmission des variables");
		$tournee_id = $_GET['tournee_id'];
		if ($tournee_id == "")
			die("L'indication de la tournée est obligatoire");
			
// suppression des récits
	$sql_del = "DELETE FROM tournee_recits WHERE concert_id = ".$concert_id;
	mysql_query($sql_del);
	
	
	//Sélection de chaque photo
	$sql_photo = "SELECT photo_id FROM tournee_photos WHERE concert_id = ".$concert_id;
	$result_photo = mysql_query($sql_photo);
	while ($val_photo = mysql_fetch_array($result_photo))
	{
		// Suppression des photos et de leur référencement
		$ext = find_image("../images/tournees/concert_".$concert_id."_".$val_photo['photo_id'].".");
		unlink("../images/tournees/concert_".$concert_id."_".$val_photo['photo_id'].".".$ext);
		$sql_del = "DELETE FROM tournee_photos WHERE photo_id = ".$val_photo['photo_id'];
		mysql_query($sql_del);
	}
	
	// Suppression du concert
	$sql_del = "DELETE FROM tournee_concerts WHERE concert_id = ".$concert_id;
	mysql_query($sql_del);
	logger("Suppression du concert N°$concert_id");
		header("Location:" . append_sid("tournees.php?tournee_id=".$tournee_id,true));
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
			
		$sql_add = "INSERT INTO tournee_cate (cate_name,ordre,artist_id) VALUES ('".$cate_name."',".$val_ordre['ordre'].",1)";
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
			
		$sql_update = "UPDATE tournee_cate SET cate_name = '" . $cate_name . "' WHERE cate_id = " . $cate_id;
		mysql_query($sql_update) or die("Erreur Interne durant l'édition de la catégorie<br>Requète SQL : ".$sql_update);
		logger("Modification de la categorie $cate_name (Tournées)");
		header("Location:" . append_sid("view_cate.php?cate_id=" . $cate_id,true));
		break;
	
	case "supp_cate";
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		$sql_del = "DELETE FROM tournee_cate WHERE cate_id = ".$cate_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la catégorie<br>Requète SQL : ".$sql_del);
		
		logger("Suppression de la categorie N°$cate_id (Tournees)");
		header("Location:" . append_sid($phpbb_root_path . "tournees/"));
		break;
	
	case "upcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		upasso('tournee_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid($phpbb_root_path . "tournees/"));
		break;
		
	case "downcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		downasso('tournee_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid($phpbb_root_path . "tournees/"));
		break;
	
	default:
		die("Commande " . $_GET['mode'] ." inconnue");
}
exit();
?>