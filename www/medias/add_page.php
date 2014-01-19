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

	if (!isset($_POST['contenu']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$contenu = $_POST['contenu'];
	if ($contenu=="")
		list($error,$error_msg) = array( true , "Le champs \"Contenu\" est obligatoire");
	
	$bbcode_uid = make_bbcode_uid();
	$contenu = delete_html($contenu);
	$contenu = bbencode_first_pass($contenu,$bbcode_uid);
	
	$sql_pages = "SELECT ordre FROM report_pages WHERE report_id = ".$report_id." ORDER BY ordre DESC LIMIT 0,1";
	$result_pages = mysql_query($sql_pages);
	if ($val_pages = mysql_fetch_array($result_pages))
	{
		$ordre = $val_pages['ordre'] + 1;
	} else
	{
		$ordre = 1;
	}
	mysql_free_result($result_pages);
	
	
	if(!$error)
	{
		
		$sql_update = "INSERT INTO report_pages (report_id,contenu,bbcode_uid,ordre) VALUES (".$report_id.",'".$contenu."','".$bbcode_uid."',".$ordre.")";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'ajout d'un enregistrement dans la bas de données".$sql_update);
			if(!$error)
			{
				logger("Ajout d'une page dans le reportage N°$report_id");
				$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_report." . $phpEx."?report_id=".$report_id) . '">')
				);
				$message =  sprintf($lang['Upload_page_ok'], '<a href="' . append_sid("edit_report." . $phpEx."?report_id=".$report_id) . '">', '</a>');
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
	'body' => 'site/medias/add_page.tpl',
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
				"U_FORM" => append_sid("add_page.php?report_id=".$_GET['report_id']."&mode=add"),													
				"AJOUT_PAGE" => $lang['add_page'], 
				"CONTENU" => $lang['contenu_periode'],	
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