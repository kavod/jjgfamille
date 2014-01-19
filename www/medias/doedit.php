<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//
include($phpbb_root_path . 'functions/functions.php');

include($phpbb_root_path . 'includes/log_necessary.php');

//global $ftp_server,$ftp_user_name,$ftp_user_pass;

switch($_GET['mode'])
{
	case "supp_emission";
		$job = array('media');
		require_once($phpbb_root_path . 'includes/reserved_access.php');

		if (!isset($_GET['emission_id']))
			die("Erreur dans la transmission des variables");
		$emission_id = $_GET['emission_id'];
		if ($emission_id == "")
			die("L'indication du l' émission est obligatoire");
		
		//On supprime les illustrations sur le serveur
		$sql_illus = "SELECT emission_id, illustration_id FROM media_illustrations WHERE emission_id = ".$emission_id;
		$result_illus = mysql_query($sql_illus);
			while ($val_illus = mysql_fetch_array($result_illus))
			{
				$ext = find_image("../images/medias/illustration_".$val_illus['emission_id']."_".$val_illus['illustration_id'].".");
				@unlink("../images/medias/illustration_".$val_illus['emission_id']."_".$val_illus['illustration_id'].".".$ext);
			}
		
		//On supprime l'emission	
		$sql_supp1 = "DELETE FROM media_emission WHERE emission_id = ". $emission_id;
		@mysql_query($sql_supp1);
		//On supprime les illustrations ds la bdd
		$sql_supp2 = "DELETE FROM media_illustrations WHERE emission_id = ". $emission_id;
		@mysql_query($sql_supp2);
		//On supprime les retranscriptions
		$sql_supp3 = "DELETE FROM media_retranscriptions WHERE emission_id = ". $emission_id;
		@mysql_query($sql_supp3);
		logger("Suppression de l'emission N°$emission_id");
		header("Location:" . append_sid("medias.php"));
		
		break;	
	case "supp_retranscription";
		$job = array('media');
		require_once($phpbb_root_path . 'includes/reserved_access.php');
	
		if (!isset($_GET['retranscription_id']))
			die("Erreur dans la transmission des variables");
		$retranscription_id = $_GET['retranscription_id'];
		if ($retranscription_id == "")
			die("L'indication du l' émission est obligatoire");
		
		//On supprime les illustrations sur le serveur
		$sql = "SELECT emission_id FROM media_retranscriptions WHERE retranscription_id = ".$retranscription_id;
		$result = mysql_query($sql);
		$val = mysql_fetch_array($result);
	
		$sql_supp = "DELETE FROM media_retranscriptions WHERE retranscription_id = ".$retranscription_id;
		@mysql_query($sql_supp);
		logger("Suppression de la retranscription N°$retranscription_id de l'emission N°$emission_id");
		header("Location:" . append_sid("view_emission.php?emission_id=".$val['emission_id']."",true));
		
		break;	
		
	case "supp_illu";
		$job = array('media');
		require_once($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['emission_id']))
			die("Erreur dans la transmission des variables");
		$emission_id = $_GET['emission_id'];
		if ($emission_id == "")
			die("L'indication du l' émission est obligatoire");
			
		if (!isset($_GET['illu_id']))
			die("Erreur dans la transmission des variables");
		$illu_id = $_GET['illu_id'];
		if ($illu_id == "")
			die("L'indication du l'illustration est obligatoire");
		
		$ext = find_image("../images/medias/illustration_".$emission_id."_".$illu_id.".");
		@unlink("../images/medias/illustration_".$emission_id."_".$illu_id.".".$ext);
			
		$sql_supp = "DELETE FROM media_illustrations WHERE illustration_id = ". $illu_id ."";
		@mysql_query($sql_supp);
		logger("Suppression de l'illustration N°$illu_id de l'emission N°$emission_id");		
		header("Location:" . append_sid("illu.php?emission_id=".$emission_id."",true));	
		break;	
		
	case "uppage":
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("L'indication du reportage est obligatoire");
			if (!isset($_GET['page_id']))
				die("Erreur dans la transmission des variables");
			$page_id = $_GET['page_id'];
			if ($page_id == "")
				die("L'indication du la page du reportage est obligatoire");
			upasso('report_pages','page_id',$page_id,'report_id');
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("edit_report.php?report_id=".$report_id."",true));
		break;
	case "downpage":
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("L'indication du reportage est obligatoire");
			if (!isset($_GET['page_id']))
				die("Erreur dans la transmission des variables");
			$page_id = $_GET['page_id'];
			if ($page_id == "")
				die("L'indication du la page du reportage est obligatoire");
			downasso('report_pages','page_id',$page_id,'report_id');
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("edit_report.php?report_id=".$report_id."",true));
		break;
	case "supppage";	
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("L'indication du reportage est obligatoire");
			if (!isset($_GET['page_id']))
				die("Erreur dans la transmission des variables");
			$page_id = $_GET['page_id'];
			if ($page_id == "")
				die("L'indication du la page du reportage est obligatoire");
			
			@mysql_query("UPDATE report_photos SET page_id = 0 WHERE page_id = ".$page_id);
			@mysql_query("DELETE FROM report_pages WHERE page_id = ".$page_id);
			logger("Suppression de page N°$page_id du reportage N°$report_id");
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("edit_report.php?report_id=".$report_id."",true));		
		break;
	case "suppreporter";	
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("L'indication du reportage est obligatoire");
			if (!isset($_GET['user_id']))
				die("Erreur dans la transmission des variables");
			$user_id = $_GET['user_id'];
			if ($user_id == "")
				die("L'indication du la page du reportage est obligatoire");
			
			@mysql_query("DELETE FROM reporters WHERE report_id = ".$report_id." AND user_id = ".$user_id);
			logger("Suppression du reporter N° $user_id du reportage N°$report_id");
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("reportages.php",true));		
		break;	
	case "invisible";	
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("L'indication du reportage est obligatoire");
			
			@mysql_query("UPDATE report SET achieved = 'N' WHERE report_id = ".$report_id);
			logger("Le reportage $report_id devient invisible");
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("edit_report.php?report_id=".$report_id."",true));		
		break;	
	case "visible";	
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("L'indication du reportage est obligatoire");
			
			@mysql_query("UPDATE report SET achieved = 'Y' WHERE report_id = ".$report_id);
			logger("Le reportage $report_id devient visible");
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("edit_report.php?report_id=".$report_id."",true));		
		break;	
	case "suppreport";
		$job = array('report');
		require_once($phpbb_root_path . 'includes/reserved_access.php');	
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		if ($report_id == "")
			die("L'indication du reportage est obligatoire");
		
		//On supprime les photos
		$sql_photo = "SELECT photo_id FROM report_photos WHERE report_id = ".$report_id;
		$result_photo = mysql_query($sql_photo);
			while ($val_photo = mysql_fetch_array($result_photo))
				{
					$ext = find_image("../images/report/photo_".$report_id."_".$val_photo['photo_id'].".");
					@unlink("../images/report/photo_".$report_id."_".$val_photo['photo_id'].".".$ext);
				}
		$sql_del = "DELETE FROM report_photos WHERE report_id = ".$report_id;
		mysql_query($sql_del);
	
		//On supprime les pages
		$sql_page = "DELETE FROM report_pages WHERE report_id = ".$report_id;
		mysql_query($sql_page);
		
		//On supprime le reportage
		$sql_report = "DELETE FROM report WHERE report_id = ".$report_id;
		mysql_query($sql_report);

		//On supprime les reporters
		$sql_report = "DELETE FROM reporters WHERE report_id = ".$report_id;
		mysql_query($sql_report);	
		
		//On supprime le asso reporter-report
		$sql_report = "DELETE FROM report_asso_artists WHERE report_id = ".$report_id;
		mysql_query($sql_report);	
		logger("Suppression du reportage N°$report_id");
		header("Location:" . append_sid("reportages.php"));
		break;	
	case "supp_photo";
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("L'indication du l' émission est obligatoire");
				
			if (!isset($_GET['photo_id']))
				die("Erreur dans la transmission des variables");
			$photo_id = $_GET['photo_id'];
			if ($photo_id == "")
				die("L'indication du l'illustration est obligatoire");
			
			$ext = find_image("../images/medias/illustration_".$report_id."_".$photo_id.".");
			@unlink("../images/medias/illustration_".$report_id."_".$photo_id.".".$ext);
				
			$sql_supp = "DELETE FROM report_photos WHERE photo_id = ". $photo_id ."";
			@mysql_query($sql_supp);
		} else die("Vous n'avez pas les autorisations nécessaires");
		logger("Suppression de la photo N°$photo_id du reportage N°$report_id");		
		header("Location:" . append_sid("add_photo.php?report_id=".$report_id."",true));	
		break;	
	case "upphoto":
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		if ($report_id == "")
			die("L'indication du reportage est obligatoire");
			
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if (!isset($_GET['photo_id']))
				die("Erreur dans la transmission des variables");
			$photo_id = $_GET['photo_id'];
			if ($photo_id == "")
				die("L'indication du la photo du reportage est obligatoire");
			upasso('report_photos','photo_id',$photo_id,'report_id');
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("add_photo.php?report_id=".$report_id."",true));
		break;
	case "downphoto":
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		if ($report_id == "")
			die("L'indication du reportage est obligatoire");
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if (!isset($_GET['photo_id']))
				die("Erreur dans la transmission des variables");
			$photo_id = $_GET['photo_id'];
			if ($photo_id == "")
				die("L'indication du la photo du reportage est obligatoire");
			downasso('report_photos','photo_id',$photo_id,'report_id');
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("add_photo.php?report_id=".$report_id."",true));
		break;	
	case "edit_audio":
		if (!isset($_GET['audio_id']))
			die("Erreur dans la transmission des variables");
		$audio_id = $_GET['audio_id'];
		if ($audio_id == "")
			die("Le champs 'audio_id' est obligatoire");
		
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		if ($report_id == "")
			die("Le champs 'report_id' est obligatoire");
		
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if (!isset($_GET['page_id']))
				die("Erreur dans la transmission des variables");
			$page_id = $_GET['page_id'];
			if ($page_id == "")
				die("Le champs 'page_id' est obligatoire");
			
			if (!isset($_POST['desc']))
				die("Erreur dans la transmission des variables");
			$desc = $_POST['desc'];
			if ($desc == "")
				die("Le champs 'desc' est obligatoire");
					
			$sql_update = "UPDATE report_audio SET description  = '" . $desc . "' WHERE audio_id = " . $audio_id;
			mysql_query($sql_update) or die("Erreur Interne durant l'édition de la catégorie<br />Requète SQL : ".$sql_update);
			logger("Modification de la description $desc d'un audio d'un reportage");
		} else die("Vous n'avez pas les autorisations nécessaires");
		header("Location:" . append_sid("edit_page.php?page_id=" . $page_id . "&report_id=".$report_id,true));
		break;	
	 case "supp_audio":
		if (!isset($_GET['audio_id']))
			die("Erreur dans la transmission des variables");
		$audio_id = $_GET['audio_id'];
		if ($audio_id == "")
			die("Le champs 'audio_id' est obligatoire");
		
		if (!isset($_GET['report_id']))
			die("Erreur dans la transmission des variables");
		$report_id = $_GET['report_id'];
		
		$val_report = select_element("SELECT user_id FROM reporters WHERE report_id = '$report_id'");
		
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report') || $val_report['user_id'] == $userdata['user_id'])
		{
			if ($report_id == "")
				die("Le champs 'report_id' est obligatoire");
			
			if (!isset($_GET['page_id']))
				die("Erreur dans la transmission des variables");
			$page_id = $_GET['page_id'];
			if ($page_id == "")
				die("Le champs 'page_id' est obligatoire");
			
			@unlink("../audio/report/audio_".$page_id."_".$audio_id.".ram");
			
			$conn_id = ftp_connect($ftp_server); 
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
			$file = "report/audio_".$page_id."_".$audio_id.".rm";
			$delete = ftp_delete($conn_id, $file);
			ftp_close($conn_id);
				
			$sql_supp = "DELETE FROM report_audio WHERE audio_id = ". $audio_id ."";
			@mysql_query($sql_supp);
			logger("Suppression de l'extrait audio/video N°$audio_id du reportage N°$report_id");
		} else die("Vous n'avez pas les autorisations nécessaires");	
		header("Location:" . append_sid("edit_page.php?page_id=" . $page_id . "&report_id=".$report_id,true));		
		break;
	case "supp_support";
		$job = array('media');
		require_once($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['support_id']))
			die("Erreur dans la transmission des variables");
		$support_id = $_GET['support_id'];
		if ($support_id == "")
			die("L'indication du support est obligatoire");
			
		if (!isset($_GET['support']))
			die("Erreur dans la transmission des variables");
		$support = $_GET['support'];
		if ($support == "")
			die("L'indication du support est obligatoire");
			
		$sql_supp = "DELETE FROM media_supports WHERE support_id = ". $support ."";
		@mysql_query($sql_supp);
		logger("Suppression du support N°$support");		
		header("Location:" . append_sid("support.php?support_id=".$support_id."",true));	
		break;
	case "supp_audio_media":
		$job = array('media');
		require_once($phpbb_root_path . 'includes/reserved_access.php');
		if (!isset($_GET['audio_id']))
			die("Erreur dans la transmission des variables");
		$audio_id = $_GET['audio_id'];
		if ($audio_id == "")
			die("Le champs 'audio_id' est obligatoire");
		
		if (!isset($_GET['emission_id']))
			die("Erreur dans la transmission des variables");
		$emission_id = $_GET['emission_id'];
		if ($emission_id == "")
			die("Le champs 'emission_id' est obligatoire");
		
		@unlink("../audio/media/audio_".$emission_id."_".$audio_id.".ram");
		
		$conn_id = ftp_connect($ftp_server); 
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
		$file = "media/audio_".$emission_id."_".$audio_id.".rm";
		$delete = ftp_delete($conn_id, $file);
		ftp_close($conn_id);
			
		$sql_supp = "DELETE FROM media_audio WHERE audio_id = ". $audio_id ."";
		@mysql_query($sql_supp);
		logger("Suppression de l'extrait audio/video N°$audio_id du media N°$emission_id");		
		header("Location:" . append_sid("view_emission.php?emission_id=".$emission_id."",true));		
		break;			
	default:
		die("Commande " . $_GET['mode'] ." inconnue");
}
exit();
?>