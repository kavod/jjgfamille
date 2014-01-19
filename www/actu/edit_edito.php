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

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('edito'));

$job = array('edito','mascotte');
require_once($phpbb_root_path . 'includes/reserved_access.php');

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_actu'],'actu');


if ($_GET['mode'] == 'doedit')
{
	list($error,$error_msg) = array(false,'');
	$illustration_upload =  ( $HTTP_POST_FILES['illustration']['tmp_name'] != "") ? $HTTP_POST_FILES['illustration']['tmp_name'] : '' ;
	$illustration_name = ( !empty($HTTP_POST_FILES['illustration']['name']) ) ? $HTTP_POST_FILES['illustration']['name'] : '';
	$illustration_size = ( !empty($HTTP_POST_FILES['illustration']['size']) ) ? $HTTP_POST_FILES['illustration']['size'] : 0;
	$illustration_filetype = ( !empty($HTTP_POST_FILES['illustration']['type']) ) ? $HTTP_POST_FILES['illustration']['type'] : '';

	if(!isset($_GET['edito_id']) || $_GET['edito_id']=='')
		message_die(GENERAL_MESSAGE,'Variable edito_id vide');
	if(!isset($_POST['edito']) || $_POST['edito']=='')
		message_die(GENERAL_MESSAGE,'Variable edito vide');
	if(!isset($_POST['title']) || $_POST['title']=='')
		message_die(GENERAL_MESSAGE,'Un titre doit être spécifié');
	$edito_id = $_GET['edito_id'];
	$edito = $_POST['edito'];
	//$edito = addslashes($_POST['edito']);
	$title = $_POST['title'];
	
	if (is_responsable($userdata['user_id'],'edito') || $userdata['user_level'] == ADMIN)
	{
		$bbcode_uid = make_bbcode_uid();
		$edito = bbencode_first_pass($edito, $bbcode_uid);
		
		$sql_update = "UPDATE famille_edito SET bbcode_uid = '". $bbcode_uid . "', edito = '" . $edito . "', title = '" . $title . "' WHERE edito_id = '" . $edito_id . "'";
		mysql_query($sql_update) or message_die(CRITICAL_ERROR,"Erreur durant la mise à jour de la base de données",'',__LINE__,__FILE__,$sql_update);
		logger("Modification de l'édito \"$title\" ($edit_id)");
	}
	
	if (!$error)
	{
		// Gestion de l'illustration
		if ($illustration_upload!= '' && (is_responsable($userdata['user_id'],'mascotte') || $userdata['user_level'] == ADMIN))
		{
			include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
			user_upload_easy(
						$error,
						$error_msg,
						$HTTP_POST_FILES['illustration'],
						$phpbb_root_path . 'images/edito/edito_' . $edito_id,
						array(
							$site_config['illu_edito_max_filesize'],
							$site_config['illu_edito_max_width'],
							$site_config['illu_edito_max_height'])
						);
			if (! $error)
			{
				$sql_update = 'UPDATE 
							famille_edito 
						SET 
							illu_user_id = \'' . $userdata['user_id'] . '\',
							illu_extension = \'' . find_image($phpbb_root_path . 'images/edito/edito_' . $edito_id) . '\' 
						WHERE 
							edito_id = \'' . $edito_id . '\'';
				mysql_query($sql_update) or list($error,$error_msg) = array(true,'Mise à jour de l\'illustration dans la base de données à échouée');
				
				if ($error)
				{
					@unlink($phpbb_root_path . 'images/edito/edito_' . $edito_id . '.' . find_image($phpbb_root_path . 'images/edito/edito_' . $edito_id . '.'));
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">')
					);
					$message .=  '<br /><br />' . sprintf($lang['Change_edito_not_illu_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito__id=' . $edito_id) . '">', '</a>',$error_msg);
					message_die(GENERAL_MESSAGE, $message);
				} else
				{
					logger("Modification de l'illustration de l'édito $edit_id");
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">')
					);
					$message .=  '<br /><br />' . sprintf($lang['Change_edito_and_illu_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito__id=' . $edito_id) . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
			} else
			{
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Change_edito_not_illu_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito__id=' . $edito_id) . '">', '</a>',$error_msg);
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Change_edito_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}

if ($_GET['mode'] == 'doadd')
{
	if (!is_responsable($userdata['user_id'],'edito') && $userdata['user_level'] != ADMIN)
		message_die(GENERAL_MESSAGE,'Vous n\'êtes pas autorisé à ajouter un éditorial');

	list($error,$error_msg) = array(false,'');
	$illustration_upload =  ( $HTTP_POST_FILES['illustration']['tmp_name'] != "") ? $HTTP_POST_FILES['illustration']['tmp_name'] : '' ;
	$illustration_name = ( !empty($HTTP_POST_FILES['illustration']['name']) ) ? $HTTP_POST_FILES['illustration']['name'] : '';
	$illustration_size = ( !empty($HTTP_POST_FILES['illustration']['size']) ) ? $HTTP_POST_FILES['illustration']['size'] : 0;
	$illustration_filetype = ( !empty($HTTP_POST_FILES['illustration']['type']) ) ? $HTTP_POST_FILES['illustration']['type'] : '';

	if(!isset($_POST['edito']) || $_POST['edito']=='')
		list($error,$error_msg) = array(true,'Variable edito vide');
	if(!isset($_POST['title']) || $_POST['title']=='')
		list($error,$error_msg) = array(true,'Un titre doit être spécifié');
	$edito_format = $_POST['edito'];
	//$edito_format = addslashes($edito);
	
	$title = $_POST['title'];
	
	$_GET['mode'] = 'add';
	
	if (!$error)
	{
		$bbcode_uid = make_bbcode_uid();
		$edito_format = bbencode_first_pass($edito_format, $bbcode_uid);
		
		$sql = "INSERT INTO famille_edito (date_unix,user_id,username,title,edito,artist_id,bbcode_uid,illu_user_id,illu_extension)
			VALUES ('" . date('U') . "','" . $userdata['user_id'] . "','" . $userdata['username'] . "','" . $title . "','" . $edito_format . "','1','" . $bbcode_uid . "','0','')";
		mysql_query($sql) or list($error,$error_msg) = array(true,'Une erreur critique est survenue lors de l\'ajout de l\'éditorial');
		
		$edito_id = mysql_insert_id();
		logger("Ajout de l'édito \"$title\" ($edito_id)");
		
		$message .=  '<br /><br />' . $lang['add_edito_ok'];
	}
	
	if (!$error)
	{
		// Gestion de l'illustration
		if ($illustration_upload!= '' && (is_responsable($userdata['user_id'],'mascotte') || $userdata['user_level'] == ADMIN))
		{
			include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
			user_upload_easy(
						$error,
						$error_msg,
						$HTTP_POST_FILES['illustration'],
						$phpbb_root_path . 'images/edito/edito_' . $edito_id,
						array(
							$site_config['illu_edito_max_filesize'],
							$site_config['illu_edito_max_width'],
							$site_config['illu_edito_max_height'])
						);
			if (! $error)
			{
				$sql_update = 'UPDATE 
							famille_edito 
						SET 
							illu_user_id = \'' . $userdata['user_id'] . '\',
							illu_extension = \'' . find_image($phpbb_root_path . 'images/edito/edito_' . $edito_id) . '\' 
						WHERE 
							edito_id = \'' . $edito_id . '\'';
				mysql_query($sql_update) or list($error,$error_msg) = array(true,'Mise à jour de l\'illustration dans la base de données à échouée');
				logger("Modification de l'illustration de l'édito $edito_id");
				if ($error)
				{
					@unlink($phpbb_root_path . 'images/edito/edito_' . $edito_id . '.' . find_image($phpbb_root_path . 'images/edito/edito_' . $edito_id . '.'));
				} else $message .=  '<br /><br />' . $lang['add_illu_ok'];
			} else list($error,$error_msg) = array(true,'Erreur durant l\'enregistrement de l\'image');
			
			if ($error)
			{
				$error_msg = $lang['add_edito_ok'] . '<br />' . $lang['Cependant'] . '<br />' . $error_msg;
				$_GET['mode'] = 'edit';
				$_GET['edito_id'] = $edito_id;
			}
		}
	
	}
	
	if (!$error)
	{
		$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">')
					);
					$message .=  '<br /><br />' . sprintf($lang['click_visu_edito'], '<a href="' . append_sid("edito." . $phpEx . '?edito__id=' . $edito_id) . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
	}
	
}

if ($_GET['mode'] == 'supp_illu')
{
	if(!isset($_GET['edito_id']) || $_GET['edito_id']=='')
		message_die(GENERAL_MESSAGE,'Variable edito_id vide');
	$edito_id = $_GET['edito_id'];
	$error = false;
	$error_msg = '';
	
	$val_edito = select_element("SELECT * FROM famille_edito WHERE edito_id = '" . $edito_id . "'",true,'Edito introuvable');

	$illu_url = $phpbb_root_path . 'images/edito/edito_' . $edito_id;

	unlink($illu_url . '.' . find_image($illu_url));
	
	$sql = "UPDATE famille_edito SET illu_extension = '', illu_user_id = 0 WHERE edito_id = '" . $edito_id ."'";
	mysql_query($sql) or list($error,$error_msg) = array(true,'Erreur durant la suppression de l\'illustration');
	logger("Suppression de l'illustration de l'édito $edito_id");
	
	if (!$error)
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Supp_illu_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edito." . $phpEx . '?edito_id=' . $edito_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}

if ($_GET['mode'] == 'supp')
{
	if(!isset($_GET['edito_id']) || $_GET['edito_id']=='')
		message_die(GENERAL_MESSAGE,'Variable edito_id vide');
	$edito_id = $_GET['edito_id'];
	$error = false;
	$error_msg = '';
	$_GET['mode'] = 'edit';
	
	@unlink($phpbb_root_path . 'images/edito/edito_' . $edito_id . '.' . find_image($phpbb_root_path . 'images/edito/edito_' . $edito_id . '.'));
	
	$sql = "DELETE FROM famille_edito WHERE edito_id = '" . $edito_id ."'";
	mysql_query($sql) or list($error,$error_msg) = array(true,'Erreur durant la suppression de l\'éditorial');
	logger("Suppression de l'édito $edito_id");
	
	if (!$error)
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edito." . $phpEx) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Supp_edito_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edito." . $phpEx) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/actu/edit_edito.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/actu/actu_colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}


$template->assign_vars($rubrikopif[0]);

// Edition de la mascotte

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
	$template->assign_block_vars('switch_admin_mascotte', array(
					"U_ADMIN_MASCOTTE" => append_sid( $phpbb_root_path . 'actu/edit_mascotte.php'),
					"L_ADMIN_MASCOTTE" => $lang['Edit_mascotte']
				)
	);
}

// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));

// Variables valable partout et pour n'importe qui sur actu
$template->assign_vars(array(
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_EDITO' => $lang['Editorial']
				));
if ($_GET['mode'] == 'add')
{
	$template->assign_vars(array(
					'EDIT_EDITO' => sprintf($lang['Edition_de'],$lang['editorial']),
					'CHANGE_EDITO' => $lang['add_edito'],
					'L_EDITO_EXPLAIN' => $lang['add_edito_explain'],
					'L_EDITO_ACTUAL' => $edito,
					'L_EDITO_TITLE' => $title,
					'L_SUBMIT' => $lang['Submit'],
					'L_CHANGE_ILLU' => sprintf($lang['Changer'],sprintf($lang['l'],$lang['picture_bio'])),
					'U_ACTION' => append_sid($phpbb_root_path . 'actu/edit_edito.php?mode=doadd'),
					'L_CONFIRM_SUPP_EDITO' => '',
					'U_SUPP_EDITO' => '',
					)
					);
}

if ($_GET['mode'] == 'edit')
{
	if(!isset($_GET['edito_id']) || $_GET['edito_id']=='')
		message_die(GENERAL_MESSAGE,'Variable edito_id vide');
	
	$tab_archives = select_liste('SELECT * FROM famille_edito ORDER BY date_unix DESC,edito_id DESC');
		
	$edito_id = $_GET['edito_id'];
	$val_edito = select_element('SELECT * FROM famille_edito WHERE edito_id = ' . $edito_id,'Editorial introuvable',true);
	
	if (find_image($phpbb_root_path . 'images/edito/edito_' . $val_edito['edito_id']))
	{
		$illu_user = select_element('SELECT * FROM phpbb_users WHERE user_id = ' . $val_edito['illu_user_id'],'',false);
		$illu_username = ($illu_user) ? '<a href="' . append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u=' . $illu_user['user_id']) . '">' . $illu_user['username'] . '</a>' : $lang['Guest'] ;
		$template->assign_block_vars('illu',array(
							'U_ILLU' => $phpbb_root_path . 'images/edito/edito_' . $edito_id . '.' .find_image($phpbb_root_path . 'images/edito/edito_' . $edito_id . '.'),
							'U_SUPP_ILLU' => append_sid($phpbb_root_path . 'actu/edit_edito.php?mode=supp_illu&edito_id=' . $edito_id),
		
							'L_CONFIRM_SUPP_ILLU' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['picture_bio'])))),
							'L_ILLUSTRATEUR' => sprintf($lang['deux_points'],ucfirst($lang['illustrateur'])) . $illu_username,
							'L_ACTUAL_ILLU' => $lang['Illustration_actuelle'],
							'L_SUPP_ILLU' => sprintf($lang['delete'],sprintf($lang['l'],$lang['picture_bio'])),
							));
	}
	
	$template->assign_block_vars('switch_archives',array('L_EDIT_ANOTHER_EDITO' => $lang['edit_another_edito']));
	
	$str_illu = '<img src="' . $phpbb_root_path . 'images/picture.gif" title="%s" alt="%s" border="0" />';
	
	while(list($key,$val) = each($tab_archives))
	{
		//$date = mktime(12,0,0,substr($val['Date'],4,2),substr($val['Date'],6,2),substr($val['Date'],0,4));
		
		$template->assign_block_vars('switch_archives.archives',array(
								'U_EDIT' => append_sid($phpbb_root_path . 'actu/edit_edito.php?mode=edit&edito_id=' . $val['edito_id']),
								'DATE' => date('d/m/Y',$val['date_unix']),
								'TITLE' => $val['title'],
								'ILLU' => (find_image($phpbb_root_path . 'images/edito/edito_' . $val['edito_id'])) ? sprintf($str_illu,$lang['illustrated_edito'],$lang['illustrated_edito']) : '',
								));
	}
	
	
	$template->assign_vars(array(
					'EDIT_EDITO' => sprintf($lang['Edition_de'],$lang['editorial']),
					'CHANGE_EDITO' => $lang['edit_edito'],
					'L_EDITO_EXPLAIN' => $lang['edit_edito_explain'],
					'L_EDITO_ACTUAL' => str_replace("<br>","",preg_replace('/\:(([a-z0-9]:)?)' . $val_edito['bbcode_uid'] . '/s', '', $val_edito['edito'])),
					'L_EDITO_TITLE' => $val_edito['title'],
					'L_SUBMIT' => $lang['Submit'],
					'L_CHANGE_ILLU' => sprintf($lang['Changer'],sprintf($lang['l'],$lang['picture_bio'])),
					'U_ACTION' => append_sid($phpbb_root_path . 'actu/edit_edito.php?mode=doedit&edito_id=' . $edito_id),
					'L_CONFIRM_SUPP_EDITO' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['editorial'])))),
					'U_SUPP_EDITO' => append_sid($phpbb_root_path . 'actu/edit_edito.php?mode=supp&edito_id=' . $edito_id),
					'L_SUPP_EDITO' => sprintf($lang['delete'],sprintf($lang['l'],$lang['editorial'])),
					"U_RETOUR" => append_sid($phpbb_root_path . 'actu/edito.php'),
					"L_RETOUR" => $lang['retour'],
					"L_LISTE" => $lang['Actualite'],
					)
					);

}
$template->assign_vars(array(
			'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.php'),
			'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.php'),
			'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.php'),
			"U_RETOUR" => append_sid($phpbb_root_path . 'actu/edito.php'),
			"L_RETOUR" => $lang['retour'],
			"L_LISTE" => $lang['Actualite'],
			'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.php'),
			'L_RDN' => $lang['Revues du Net'],
			));

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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);


?>
