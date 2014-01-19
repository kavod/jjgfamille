<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'actu';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ACTU);
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
	
		$mascotte_sql = user_mascotte_upload($error, $error_msg, $user_mascotte_upload, $user_mascotte_name, $user_mascotte_size, $user_mascotte_filetype,'actu');
	
		if ($mascotte_sql != '' && !mysql_query($mascotte_sql))
				message_die(CRITICAL_ERROR,"Erreur durant la mise � jour de la base de donn�es",'',__LINE__,__FILE__,$mascotte_sql);
		else
		{
			if (!$error)
			{
				logger('Modification de la mascotte actualit�s');
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
$img_mascotte = affiche_mascotte($site_config['mascotte_actu'],'actu');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'site/actu/edit_mascotte.tpl',
	'colonneGauche' => 'site/actu/actu_colonne_gauche.tpl')
);


if ($img_mascotte)
$mascotte = $img_mascotte ;

// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));


$template->assign_vars(array(
				'NOM_RUB' => $lang['actu_News'],
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.php'),
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.php'),
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.php'),
								
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				
				"IMG_MASCOTTE" => $mascotte,
				"U_RETOUR" => append_sid($phpbb_root_path . 'actu/index.php'),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['Actualite'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.php'),
				'L_RDN' => $lang['Revues du Net'],
				
				));


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_ADMIN_MASCOTTE" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php'),
						"L_ADMIN_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}




// Edition de la mascotte
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
	$template->assign_block_vars('switch_edit_mascotte', array(
					
					"EDIT_MASCOTTE" => $lang['Edit_mascotte'],
					"CHANGE_MASCOTTE" => $lang['Change_mascotte'],
					"U_UPLOAD" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php?mode=add_mascotte'),
					"L_UPLOAD_MASCOTTE_EXPLAIN" => $lang['upload_mascotte_explain'],
					"L_SUBMIT" => $lang['Submit'],
					"L_MASCOTTE" => $lang['Change_mascotte'],
					"U_MASCOTTE" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php'),
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