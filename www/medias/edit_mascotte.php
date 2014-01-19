<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//
$job=array('mascotte');
require_once($phpbb_root_path . 'includes/reserved_access.php');

// Ajout d'une mascotte
if ($_GET['mode'] == 'add_mascotte')
{
	include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
	
	$user_mascotte_upload =  ( $HTTP_POST_FILES['mascotte_file']['tmp_name'] != "none") ? $HTTP_POST_FILES['mascotte_file']['tmp_name'] : '' ;
	$user_mascotte_name = ( !empty($HTTP_POST_FILES['mascotte_file']['name']) ) ? $HTTP_POST_FILES['mascotte_file']['name'] : '';
	$user_mascotte_size = ( !empty($HTTP_POST_FILES['mascotte_file']['size']) ) ? $HTTP_POST_FILES['mascotte_file']['size'] : 0;
	$user_mascotte_filetype = ( !empty($HTTP_POST_FILES['mascotte_file']['type']) ) ? $HTTP_POST_FILES['mascotte_file']['type'] : '';
	if ($user_mascotte_upload!= '')
	{
		$error = false;
		$error_msg = '';
	
		$mascotte_sql = user_mascotte_upload($error, $error_msg, $user_mascotte_upload, $user_mascotte_name, $user_mascotte_size, $user_mascotte_filetype,'medias');
	
		if ($mascotte_sql != '' && !mysql_query($mascotte_sql))
				message_die(CRITICAL_ERROR,"Erreur durant la mise à jour de la base de données",'',__LINE__,__FILE__,$mascotte_sql);
		else
		{
			if (!$error)
			{
				logger('Modification de la mascotte Medias');
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_mascotte." . $phpEx) . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Upload_mascotte_ok'], '<a href="' . append_sid("edit_mascotte." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	}
}

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'site/medias/edit_mascotte.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);


if ($img_mascotte)
$mascotte = $img_mascotte ;

$template->assign_vars(array(
				"IMG_MASCOTTE" => $mascotte,
				'NOM_RUB_MEDIAS' => $lang['nom_rub_medias'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/index.php'),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		if ($img_mascotte)
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

// Edition de la mascotte
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
	$template->assign_block_vars('switch_edit_mascotte', array(
					
					"EDIT_MASCOTTE" => $lang['Edit_mascotte'],
					"CHANGE_MASCOTTE" => $lang['Change_mascotte'],
					"U_UPLOAD" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php?mode=add_mascotte'),
					"L_UPLOAD_MASCOTTE_EXPLAIN" => $lang['upload_mascotte_explain'],
					"L_SUBMIT" => $lang['Submit'],
					"L_MASCOTTE" => $lang['Change_mascotte'],
					"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
				)
	);
}

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

$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>