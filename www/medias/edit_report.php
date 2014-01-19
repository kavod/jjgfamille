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

if (!isset($_GET['report_id']) || ((int)$_GET['report_id'])==0)
	message_die('Reportage introuvable');
	
if ($_GET['mode'] == 'edit_gen')
{
	if (!isset($_POST['title']))
	{
		$error = true;
		$error_msg = sprintf($lang['Champs_needed'],$lang['Titre']);
	}
	
	$sql = "UPDATE report SET title = '" . htmlentities(delete_html($_POST['title'])) . "', description = '" . htmlentities(delete_html($_POST['description'])) . "' WHERE report_id = '" . $_GET['report_id'] . "'";
	if (!mysql_query($sql))
	{
		message_die(CRITICAL_ERROR,"Erreur durant l'édition de la requète<br />$sql<br />" . mysql_error());
	}
	
			
	if (!$error)
	{
		logger("Edition du reportage $title dans les reportages");
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_report." . $phpEx . "?report_id=" . $_GET['report_id']) . '">')
			);
			$message =  sprintf($lang['edit_report_ok'], '<a href="' . append_sid("edit_report." . $phpEx . "?report_id=" . $_GET['report_id']) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
	}
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='report' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//Reportages à editer
$val_report = select_element("SELECT * FROM report WHERE report_id = ".$_GET['report_id']."",'',false);

//Liste des pages
$tab_pages = select_liste("SELECT * FROM report_pages WHERE report_id = ".$_GET['report_id']." ORDER BY ordre");

//Liste des reporter
$tab_reporter = select_liste("SELECT * FROM reporters WHERE report_id = ".$_GET['report_id']." ORDER BY user_id");

//NOmbre de photos
$val_photo = select_element("SELECT COUNT(photo_id) as nb FROM report_photos WHERE report_id = ".$_GET['report_id']."",'',false);
//NOmbre de photos associé
$val_photo_asso = select_element("SELECT COUNT(photo_id) as nb FROM report_photos WHERE report_id = ".$_GET['report_id']." AND page_id<>0 ",'',false);

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/edit_report.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$u_titre = append_sid($phpbb_root_path . 'medias/view_report.php?report_id='.$_GET['report_id']);
if(!$tab_pages)
{
	$no_page = $lang['no_page'];
	$u_titre = append_sid($phpbb_root_path . 'medias/edit_report.php?report_id='.$_GET['report_id']);
}

if($val_report['achieved']=='Y')
{
	$l_etat_report = $lang['rendre_invisible'];
	$u_etat_report = append_sid($phpbb_root_path . 'medias/doedit.php?mode=invisible&report_id='.$_GET['report_id']);
	$etat =  $lang['accessible'];	
}else
{
	$l_etat_report = $lang['rendre_visible'];
	$u_etat_report = append_sid($phpbb_root_path . 'medias/doedit.php?mode=visible&report_id='.$_GET['report_id']);
	$etat = $lang['en_cours'];
}


$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['reportages'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'GESTION_REPORT_INFO' => $lang['report_edit_info'],
				
				'L_TITLE' => $lang['Titre'],
				'L_DESCRIPTION' => $lang['Description'],
				'L_ENVOYER' => $lang['Submit'],
				
				'U_EDIT_GEN' => append_sid($phpbb_root_path . "medias/edit_report.php?report_id=" . $_GET['report_id'] . "&amp;mode=edit_gen"),
				
				'VALUE_TITLE' => $val_report['title'],
				'VALUE_DESCRIPTION' => $val_report['description'],
				
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"U_TITRE" => $u_titre,
				"TITRE" => $val_report['title'],
				"GESTION_REPORT" => $lang['gestion_report'],
				"NO_PAGE" => $no_page,
				"L_ADD_PAGE" => $lang['add_page'],
				"U_ADD_PAGE" => append_sid($phpbb_root_path . 'medias/add_page.php?report_id='.$_GET['report_id']),
				"GESTION_ACCES" => $lang['gestion_acces'],
				"L_ADD_REPORTER" => $lang['add_reporter'],
				"U_ADD_REPORTER" => append_sid($phpbb_root_path . 'medias/add_reporter.php?report_id='.$_GET['report_id']),
				"GESTION_GALERIE" => $lang['gestion_galerie'],
				"L_ADD_PHOTO" => $lang['add_photo'],
				"U_ADD_PHOTO" => append_sid($phpbb_root_path . 'medias/add_photo.php?report_id='.$_GET['report_id']),
				"U_EDITER_GALERIE" => append_sid($phpbb_root_path . 'medias/add_photo.php?report_id='.$_GET['report_id']),
				"L_EDITER_GALERIE" => $lang['editer_galerie'],
				"NB_PHOTOS" => sprintf($lang['nombre_photos_report'],$val_photo['nb'],$val_photo_asso['nb']),
				"ETAT_REPORT" => $lang['etat_report'],
				"L_SUPP_REPORT" => $lang['supp_report'],
				"U_SUPP_REPORT" => append_sid($phpbb_root_path . 'medias/doedit.php?mode=suppreport&report_id='.$_GET['report_id']),
				"L_ETAT" => $l_etat_report,
				"U_ETAT" => $u_etat_report,
				"ETAT" => $etat,
				'L_CONFIRM_SUPP_REPORT' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],strtolower($lang['reportage']))))),
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/reportages.php'),
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

for ($i=0;$i<count($tab_pages);$i++)
{

	$template->assign_block_vars('switch_pages',array(
						'L_TITRE' => sprintf($lang['page'],$i+1),
						'U_EDITER' => append_sid($phpbb_root_path . 'medias/edit_page.php?page_id='.$tab_pages[$i]['page_id'].'&report_id='.$_GET['report_id']),
						'L_EDITER' => $lang['edit'],
						'U_MONTER' => append_sid($phpbb_root_path . 'medias/doedit.php?mode=uppage&page_id='.$tab_pages[$i]['page_id'].'&report_id='.$_GET['report_id']),
						'L_MONTER' => $lang['monter'],
						'U_DESCENDRE' => append_sid($phpbb_root_path . 'medias/doedit.php?mode=downpage&page_id='.$tab_pages[$i]['page_id'].'&report_id='.$_GET['report_id']),
						'L_DESCENDRE' => $lang['descendre'],
						'U_SUPPRIMER' => append_sid($phpbb_root_path . 'medias/doedit.php?mode=supppage&page_id='.$tab_pages[$i]['page_id'].'&report_id='.$_GET['report_id']),
						'L_SUPPRIMER' => $lang['supprimer'],
						'L_CONFIRM_SUPP_PAGE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['Page'])))),
						)
					);
}

for ($i=0;$i<count($tab_reporter);$i++)
{
	$val_user = select_element("SELECT username FROM phpbb_users WHERE user_id = ".$tab_reporter[$i]['user_id']."",'',false);
	$template->assign_block_vars('switch_reporter',array(
						'L_USER' => $val_user['username'],
						'U_USER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$tab_reporter[$i]['user_id']),
						'JOB' => $tab_reporter[$i]['job'],
						'U_SUPPRIMER' => append_sid($phpbb_root_path . 'medias/doedit.php?mode=suppreporter&user_id='.$tab_reporter[$i]['user_id'].'&report_id='.$_GET['report_id']),
						'L_SUPPRIMER' => $lang['supprimer'],
						'L_CONFIRM_SUPP_REPORTER' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['reporter'])))),
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
