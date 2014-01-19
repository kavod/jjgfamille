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
	
	$photo_id = $_GET['photo_id'];
	$comment = $_POST['comment'];
	$photographe = $_POST['photographe'];
	$page_id = $_POST['page_id'];

	$comment = htmlentities($comment);
	$photographe = htmlentities($photographe);

	if (!$error)
	{	
		$sql_update = "UPDATE  report_photos SET page_id='".$page_id."',description='".$comment."',photographe='".$photographe."' WHERE photo_id='".$photo_id."'";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		
		if (!$error)
		{	
			$val_report = select_element("SELECT report_id FROM report_photos WHERE  photo_id= ".$photo_id." LIMIT 0,1",'',false);
			$report_id = $val_report['report_id'];
			logger("Modification de la photo N°$photo_id du reportage N°$report_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("add_photo." . $phpEx."?report_id=".$report_id) . '">')
			);
				$message =  sprintf($lang['Upload_photo_report_ok'], '<a href="' . append_sid("add_photo." . $phpEx."?report_id=".$report_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='report' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

$val_photo = select_element("SELECT * FROM report_photos WHERE photo_id = ".$_GET['photo_id']."",'',false);
$val_report = select_element("SELECT * FROM report WHERE report_id = ".$val_photo['report_id']."",'',false);
$tab_page = select_liste("SELECT * FROM report_pages WHERE report_id = ".$val_photo['report_id']." ORDER BY ordre");
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/edit_photo.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$ext = find_image('../images/report/photo_' . $val_report['report_id'] . '_' . $val_photo['photo_id'].'.');
if (is_file('../images/report/photo_' . $val_report['report_id'] . '_' . $val_photo['photo_id'].'.'.$ext))
{
	$img = '../images/report/photo_' . $val_report['report_id'] . '_' . $val_photo['photo_id'].'.'.$ext;
			
}else
{
	$img = '../templates/jjgfamille/images/site/px.png';	
}

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
				"L_GALERIE" => $lang['Galerie_photo'],
				"L_TITLE" => $val_report['title'],  
				"U_GALERIE" => append_sid($phpbb_root_path . 'medias/add_photo.php?report_id='.$val_photo['report_id']),
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("edit_photo.php?photo_id=".$_GET['photo_id']."&mode=add"),													
				"EDITER_ILLU" => $lang['modif_photo'], 
				"L_DESC" => $lang['Description'], 
				"L_PHOTOGRAPHE" => sprintf($lang['photographe'],''), 
				"L_ILLU" =>  $lang['chemin_photo'],  
				"L_SUPPRIMER" => $lang['supprimer']."&nbsp;".sprintf($lang['la'],$lang['photo']),
				"U_SUPPRIMER" => append_sid($phpbb_root_path . 'medias/doedit.php?mode=supp_photo&photo_id='.$val_photo['photo_id'].'&report_id='.$val_photo['report_id']),	
				"ILLU" =>  $img, 
				"PHOTOGRAPHE" => $val_photo['photographe'],
				"DESC" => $val_photo['description'],	
				'L_CONFIRM_SUPP_PHOTO' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['photo'])))),
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/add_photo.php?report_id='.$val_photo['report_id']),
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

for ($i=0;$i<count($tab_page);$i++)
			{
	
				$template->assign_block_vars('switch_page',array(
						"VALUE" => $tab_page[$i]['page_id'],
      						"INTITULE" => sprintf($lang["asso_page"],($i+1)),
      						"SELECTED" => ($tab_page[$i]['page_id'] == $val_photo['page_id'] ) ? " SELECTED" : ""
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