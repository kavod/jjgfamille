<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'liens';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LIENS);
init_userprefs($userdata);
//
// End session management
//
/*$job=array('liens');
require_once($phpbb_root_path . 'includes/reserved_access.php');
*/


//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM liens_categories ORDER BY ordre");
$val_cate = select_element("SELECT cate_id FROM liens_cate_site WHERE site_id = ".$_GET['site_id'],'',false);
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_liens'],'liens');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$val_sites = select_element("SELECT * FROM liens_sites WHERE site_id = ".$_GET['site_id'],'',false);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens') || $userdata['user_id'] == $val_sites['user_id'])
{

	// Ajout d'une banniere
	if ($_GET['mode'] == 'edit_banniere')
	{
		// Ajout de la banniere
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['banniere_file']['tmp_name'] != "none") ? $HTTP_POST_FILES['banniere_file']['tmp_name'] : '' ;
		if ($user_upload!= '')
		{
			$error = false;
			$error_msg = '';
			
			$url_img = $phpbb_root_path . 'images/liens/logo_' . $_GET['site_id'];
			if (find_image($url_img))
			unlink($url_img.".".find_image($url_img));
			user_upload_easy($error,$error_msg,$HTTP_POST_FILES['banniere_file'],$phpbb_root_path . 'images/liens/logo_' . $_GET['site_id'] ,array($site_config['banniere_max_filesize'],$site_config['banniere_max_width'],$site_config['banniere_max_height']));
			
			if (!$error)
				{
					$site_id=$_GET['site_id'];
					logger("Changement de banniere pour le site N°$site_id (liens)");
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_site." . $phpEx."?site_id=" . $_GET['site_id']) . '">')
					);
					$message .=  '<br /><br />' . sprintf($lang['Upload_banniere_ok'], '<a href="' . append_sid("edit_site." . $phpEx."?site_id=" . $_GET['site_id']) . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
			
		}
	}
	
	// Supprimer d'une banniere
	if ($_GET['mode'] == 'supp_banniere')
	{
		@unlink($phpbb_root_path . 'images/liens/logo_' . $_GET['site_id'].".".find_image($phpbb_root_path . 'images/liens/logo_' . $_GET['site_id']));
		$site_id=$_GET['site_id'];
		logger("Suppression de la banniere pour le site N°$site_id (liens)");
	}

	$template->set_filenames(array(
		'body' => 'site/liens/edit_site.tpl',
		'colonneGauche' => 'site/liens/colonne_gauche.tpl')
	);
	
	
	if ($img_mascotte)
		$mascotte = $img_mascotte;
	
	if ($val_cate)
		$u_retour = append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$val_cate['cate_id']);
	else
		$u_retour = append_sid($phpbb_root_path . 'liens/edit_cate_orphelin.php');
		
	$template->assign_vars(array(
					// Liens
					"LIENS" => $lang['liens_admin'],
					"L_LISTE" => $lang['liste_cate'],
					"NEW_CATE" => $lang['new_cate'],
					"L_ASSO" => $lang['associer'],
					"U_ASSO" => append_sid($phpbb_root_path . "liens/doedit.php?mode=asso&site_id=".$_GET['site_id']),
					"IMG_MASCOTTE" => $mascotte,
					'L_RETOUR' => $lang['retour'],
					'U_RETOUR' => $u_retour,
				)
	);



	
		$template->assign_block_vars('admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'liens/edit.php'),
						"L_ADMIN" =>  $lang['liens_admin'],
						"L_LISTE" => $lang['liste_cate'],
						"LIENS" => $lang['Links'],
						"LIENS" => $lang['liens_admin'],
						"L_LISTE" => $lang['liste_cate'],
						"NEW_CATE" => $lang['new_cate'],
						"L_ASSO" => $lang['associer'],
						"U_ASSO" => append_sid($phpbb_root_path . "liens/doedit.php?mode=asso&site_id=".$_GET['site_id']),
						)
					);
	
	$val_sites = select_element("SELECT * FROM liens_sites WHERE site_id = ".$_GET['site_id'],'',false);
	
	// Boris 27/11/2005 : inutile car changement de système
	//$url_pointer = "http://" . $board_config['server_name'] . "/liens/link.php?site_id=".$val_sites['site_id']."";
	//$code_html = htmlentities("<a href=\"http://" . $board_config['server_name'] . "/liens/link.php?site_id=".$val_sites['site_id']."\" target=\"blank\">Le site famille</a>");
	$rendre = append_sid("doedit.php?mode=activ&site_id=".$val_sites['site_id']."");
	$edit_sites = append_sid("doedit.php?mode=edit_site&site_id=".$val_sites['site_id']."");
	
	$ext = find_image($phpbb_root_path . 'images/liens/logo_'. $val_sites['site_id'] . '.');
	$url_image = $phpbb_root_path . 'images/liens/logo_'. $val_sites['site_id'] . '.'.$ext;
	if (is_file($url_image)){
		$image = '<img src="'.$url_image.'" border="0">';
		$supp_image=$lang['supp_image'];}
	else {$image = '';}
	
	if($val_sites['enable']== 'Y')
	{
		$actif_inactif = $lang['actif'];
		$inactif_actif = $lang['inactif'];
		
	}else
	{
		$actif_inactif = $lang['inactif'];
		$inactif_actif = $lang['actif'];
	}
	
	// Recherche du nom de l'utilisateur qui a proposé le lien
	$val_author = select_element("SELECT username FROM phpbb_users WHERE user_id = '" . $val_sites['user_id']."'",false,'');
	$user = ($val_author) ? $val_author['username'] : $val_sites['username'];
	
	$template->assign_vars(array(
						
				"SITE_NAME" => $val_sites['site_name'],
				"URL" => $lang['URL'],
				"site_URL" => $val_sites['url'],
				"DESCRIPTION" => $lang['Description'],
				"DESC" => $val_sites['description'],
				"PROPOSER" => $lang['proposer'],
				"USER" => $user,
				"U_USER" => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_sites['user_id']),
				"SCORE_ACTU" => $lang['score_actu'],
				"SCORE" => $val_sites['score'],
				//"url" => $lang['url_pointer'],
				//"SITE_URL" => $url_pointer,
				//"CODE_HTML" => $lang['code_html'],
				//"SITE_CODE_HTML" => $code_html,
				"ACTIVITE" => $lang['activiter'],
				"ACTIF_INACTIF" => $actif_inactif,
				"MODIF_SITE" => $lang['modif_site'],
				"NOM_SITE" => $lang['Nom_site'],
				"U_FORM" => $edit_sites,
				"L_SUBMIT" => $lang['modifier'],
				"SUPP" => $lang['supp_site'],
				"U_SUPP" => append_sid("doedit.php?mode=supp_site&site_id=".$val_sites['site_id'].""),
				"L_SUPP" => $lang['supp_sites'],
				"CHOIX" => $lang['choix'],
				"SITE_LOGO" => $image,
				"U_SUPP_IMAGE" => append_sid($phpbb_root_path . 'liens/edit_site.php?mode=supp_banniere&site_id='.$val_sites['site_id']),
				"L_SUPP_IMAGE" => $supp_image,
				"BANNIERE" => $lang['banniere'],
				"U_UPLOAD_BANNIERE" => append_sid($phpbb_root_path . 'liens/edit_site.php?mode=edit_banniere&site_id='.$val_sites['site_id']),
				'L_CONFIRM_SUPP_SITE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['site'])))),
				'L_CONFIRM_SUPP_IMAGE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['Banniere'])))),
				)
			);
					
	
	
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
	{
		$template->assign_block_vars('admin_only',array(
						"RENDRE" => $rendre,
						"INACTIF_ACTIF" => sprintf($lang['rendre'],$inactif_actif),
						"PLUS" => $lang['plus'],
						"PLUSS" => $val_sites['plus'],
						"MOINS" => $lang['moins'],
						"MOINSS" => $val_sites['moins'],
						"CATE_ASSO" => $lang['cate_asso'],
						
		));
		
		/*for ($i=0;$i<count($tab_cate);$i++)
		{
			
			
			$val_count = select_element("SELECT COUNT(site_id) as NUM FROM liens_cate_site WHERE cate_id = ".$tab_cate[$i]['cate_id'],'',false);
			
			$template->assign_block_vars('admin_only.cate',array(
								'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
								'L_CATE' => $tab_cate[$i]['cate_name'],
								)
							);
		}*/
		
		$tab_liste = select_liste("SELECT * FROM liens_categories ORDER BY ordre");
		
		for ($i=0;$i<count($tab_liste);$i++)
		{
			$find = false;
			for ($j=0;!$find && $j<count($val_cate);$j++)
			{
				if ($val_cate[$j]['cate_id'] == $tab_liste[$i]['cate_id'])
					$find = true;
			}
			if (!$find)
				$template->assign_block_vars('admin_only.mes_options',array(
								"VALUE" => $tab_liste[$i]['cate_id'],
								"INTITULE" => $tab_liste[$i]['cate_name'],
								)
							);
		
		}
		
		$val_cate = array();
		$sql = "SELECT cate.* FROM liens_categories cate, liens_cate_site asso WHERE cate.cate_id = asso.cate_id AND site_id = '".$_GET['site_id']."' ";
		$val_cate = select_liste($sql);
		for ($i=0;$i<count($val_cate);$i++)
		{
			$mon_array = array(
					'L_CATE' => $val_cate[$i]['cate_name'],
					'L_DEASSOCIER' => $lang['deassocier'],
					'L_EDIT' => $lang['edit'],
					'U_DEASSOCIER' => append_sid("doedit.php?mode=supp_asso&cate_id=".$val_cate[$i]['cate_id']."&site_id=".$val_sites['site_id']),
					'U_EDIT'=> append_sid("view_cate.php?cate_id=".$val_cate[$i]['cate_id'])
					);
			$template->assign_block_vars('admin_only.cate',$mon_array
							);
		
		}
	}

	
					
} else
	message_die(GENERAL_MESSAGE,$lang['not_allowed']);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'liens/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}				


for ($i=0;$i<count($tab_cate);$i++)
{
	$template->assign_block_vars('categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name']
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