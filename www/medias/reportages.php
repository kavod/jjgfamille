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

if ($_GET['mode'] == 'add_report')
{
	include($phpbb_root_path . 'includes/log_necessary.php');
	
	$error = false;
	$error_msg = '';
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	$title = htmlentities($title);
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"Titre du reportage\" est obligatoire");
	
	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$comment = $_POST['comment'];
	$comment = htmlentities($comment);
	if ($comment=="")
		list($error,$error_msg) = array( true , "Le champs \"Description du reportage\" est obligatoire");
	
	if (!isset($_POST['job']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$job = $_POST['job'];
	$job = htmlentities($job);
	if ($job=="")
		list($error,$error_msg) = array( true , "Le champs \" Le rôle que vous avez joué dans ce reportage\" est obligatoire");
		
	if (!$error)
	{
		$sql_update = "INSERT INTO report (title,description,date) VALUES ( '".$title."','".$comment."',".date(Ymd).")";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
		
		$report_id = mysql_insert_id();
		
		if (!$error)
		{
		$sql_update1 = "INSERT INTO reporters (report_id,user_id,job) VALUES (".$report_id.",".$userdata['user_id'].",'".$job."')";
		mysql_query($sql_update1) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update1);
		
		if (!$error)
		{
			logger("Ajout du reportage $title");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_report." . $phpEx."?report_id=".$report_id) . '">')
			);
			$message =  sprintf($lang['Upload_report_ok'], '<a href="' . append_sid("edit_report." . $phpEx."?report_id=".$report_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	
		}
	}	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='report' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//Liste des reportages
$tab_report = select_liste("SELECT *,SUBSTRING(date,1,4) annee FROM report WHERE achieved = 'Y' ORDER BY date DESC");

if ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report'))
{
	$tab_no_report_visible = select_liste("SELECT * FROM report WHERE achieved = 'N' ORDER BY date DESC");
	$tab_no_report_not_visible = array();
	if(count($tab_no_report_visible)>0)
		$liste_no_report = $lang['liste_no_reportage'];
} else
{
	$sql = "SELECT 
			report.*
		FROM 
			reporters 
		LEFT JOIN
			report
		ON 
			report.report_id = reporters.report_id
		WHERE 
			report.achieved = 'N' AND 
			reporters.user_id = " . $userdata['user_id'] . "
		ORDER BY date DESC";
	$tab_no_report_visible = select_liste($sql);
}
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['reportages'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/reportages.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['reportages'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"LISTE_REPORT" => $lang['liste_reportage'],
				"IS_YOU_TO_PLAY" => $lang['it_is_you_to_play'],
				"AJOUT_REPORTAGE" => $lang['add_report'],
				"L_SUBMIT" => $lang['Submit'],
				"TITRE_REPORTAGE" => $lang['titre_reportage'],
				"DESC_REPORTAGE" => $lang['desc_reportage'],
				"JOB_REPORTAGE" => $lang['job_reportage'],
				"U_FORM" => append_sid($phpbb_root_path . 'medias/reportages.php?mode=add_report'),
				"LISTE_NO_REPORT" => $liste_no_report,
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/index.php'),
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

$annee = 0;
for ($i=0;$i<count($tab_report);$i++)
{
	if ($tab_report[$i]['annee'] != $annee)
	{
		$template->assign_block_vars('annee',array(
							'ANNEE' => $tab_report[$i]['annee']
							));
		$annee = $tab_report[$i]['annee'];
	}
	//Format date 
	$date = affiche_date($tab_report[$i]['date']);
	
	//ANNEE
	$annee=substr($tab_report[$i]['date'],0,4);
	
	//EDITER
	$val_reporter = select_liste("SELECT * FROM reporters WHERE report_id = ".$tab_report[$i]['report_id']." AND user_id = ".$userdata['user_id']."");
	
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'report')  || $val_reporter)
		{
			
			$l_editer =  $lang['edit'];
			$u_editer =  append_sid($phpbb_root_path . 'medias/edit_report?report_id='.$tab_report[$i]['report_id']);
			
		}
		
	$sql = "SELECT * FROM report_photos WHERE report_id = '".$tab_report[$i]['report_id']."' ORDER BY RAND()";
	$val_img = select_element($sql,false,'');
	if ($val_img)
	{
		$ext = find_image($phpbb_root_path . 'images/report/photo_' . $tab_report[$i]['report_id'] . '_' . $val_img['photo_id'].'.');
		if (is_file($phpbb_root_path . 'images/report/photo_' . $tab_report[$i]['report_id'] . '_' . $val_img['photo_id'].'.'.$ext))
		{
			$img = $phpbb_root_path . 'functions/miniature.php?mode=report&report_id=' . $tab_report[$i]['report_id'] . '&photo_id=' . $val_img['photo_id'];
			$photographe = sprintf($lang['photographe'],$val_img['photographe']);
		} else
		{
			$img = $phpbb_root_path . 'templates/jjgfamille/images/site/px.png';
			$photographe = '';
		}
	} else
	{
		$img = $phpbb_root_path . 'templates/jjgfamille/images/site/px.png';
		$photographe = '';
	}
	
	$template->assign_block_vars('annee.switch_report',array(
						'U_TITRE' => append_sid($phpbb_root_path . 'medias/view_report?report_id='.$tab_report[$i]['report_id']),
						'U_IMG' => $img,
						'U_EDIT' => $u_editer,
						
						'DESCRIPTION_IMG' => $photographe,
						'DATE' => $date,
						
						'L_TITRE' => $tab_report[$i]['title'],
						"L_DESC" => $tab_report[$i]['description'],
						'L_EDIT' => $l_editer,
						)
					);
}

for ($i=0;$i<count($tab_no_report_visible);$i++)
{

	$template->assign_block_vars('switch_no_report',array(
						'U_TITRE' => append_sid($phpbb_root_path . 'medias/view_report?report_id='.$tab_no_report_visible[$i]['report_id']),
						'L_TITRE' => $tab_no_report_visible[$i]['title'],
						"L_DESC" => $tab_no_report_visible[$i]['description'],
						'DATE' => affiche_date($tab_no_report_visible[$i]['date']),
						'L_EDIT' => $lang['edit'],
						'U_EDIT' => append_sid($phpbb_root_path . 'medias/edit_report?report_id='.$tab_no_report_visible[$i]['report_id']),
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


$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');


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

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>