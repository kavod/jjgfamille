<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

if ($_GET['mode'] == 'add')
{
	$error = false;
	$error_msg = '';

	$report_id = $_GET['report_id'];

	if (!isset($_POST['user']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$user = $_POST['user'];
	if ($user=="")
		list($error,$error_msg) = array( true , "Le champs \"Nom d'utilisateur\" est obligatoire");
	$user = htmlentities($user);	
	if (!isset($_POST['job']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$job = $_POST['job'];
	$job = htmlentities($job);
	if ($job=="")
		list($error,$error_msg) = array( true , "Le champs \"Job\" est obligatoire");
	if(!$error)
	{
		$sql_user = "SELECT * FROM phpbb_users WHERE username = '".$user."'";
		$result_user = mysql_query($sql_user);
		if ($val_user = mysql_fetch_array($result_user))
		{
			$sql_add = "INSERT INTO reporters (report_id,user_id,job) VALUES (".$report_id.",".$val_user['user_id'].",'".$job."')";
			mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_add);

		} else
		{
			$sql_user = "SELECT * FROM phpbb_users WHERE username LIKE '%".$user."%'";
			$result_user = mysql_query($sql_user);
			$nb_result = mysql_num_rows($result_user);
			switch($nb_result)
			{
				case 1:
					$val_user = mysql_fetch_array($result_user);
					$sql_add = "INSERT INTO reporters (report_id,user_id,job) VALUES (".$report_id.",".$val_user['user_id'].",'".$job."')";
					mysql_query($sql_add);	
					break;
				case 0:
					list($error,$error_msg) = array( true , "Aucun utilisateur trouvé à ce nom<br />");
					break;	
				default:
					list($error,$error_msg) = array( true , $nb_result." utilisateur correspondant approximativement à votre demande :<br />");
					while ($val_user = mysql_fetch_array($result_user))
					{
						$error_msg .= $val_user['username']."<br />";
					}
			}	
		}
			if (!$error)
			{
				logger("Ajout d'un reporter N°$user_id dans le reportage N°$report_id");
				$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_report." . $phpEx."?report_id=".$report_id) . '">')
				);
				$message =  sprintf($lang['Upload_reporter_ok'], '<a href="' . append_sid("edit_report." . $phpEx."?report_id=".$report_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
			}
		
	}	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='report' ORDER BY user_id");

//le reportage selectionné
$val_report = select_element("SELECT * FROM report WHERE  report_id = ".$_GET['report_id']." LIMIT 0,1",'',false);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['reportages'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/add_reporter.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['nom_rub_media'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"L_TITLE" => $val_report['title'], 
				"U_TITLE" => append_sid($phpbb_root_path . 'medias/edit_report.php?report_id='.$val_report['report_id']),
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("add_reporter.php?report_id=".$_GET['report_id']."&mode=add"),													
				"AJOUT_REPORTER" => $lang['add_reporter'], 
				"L_JOB" => $lang['job'],  
				"NOM_USER" => $lang['nom_user'],
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/edit_report.php?report_id='.$val_report['report_id']),				
			)
);


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('report','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );

if ( $error )
{
	$template->set_filenames(array(
		'reg_header' => 'error_body.tpl')
	);
	$template->assign_vars(array(
		'ERROR_MESSAGE' => $error_msg)
	);
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>