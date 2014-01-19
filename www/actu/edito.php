<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'actu';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ACTU);
init_userprefs($userdata);
//
// End session management
//

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_actu'],'actu');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('edito'));
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Editorial'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/actu/edito.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/actu/actu_colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_ADMIN_MASCOTTE" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php'),
						"L_ADMIN_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}


$template->assign_vars($rubrikopif[0]);

// Editorial
if(!isset($_GET['edito_id']) || $_GET['edito_id']=='')
	$val_edito = select_element('SELECT * FROM famille_edito ORDER BY date_unix DESC,edito_id DESC LIMIT 0,1','',false);
else
	$val_edito = select_element('SELECT * FROM famille_edito WHERE edito_id = ' . $_GET['edito_id'] . ' LIMIT 0,1','',false);
	
if ($val_edito)
{
	// Titre de l'édito
	$edito_title = $val_edito['title'];
	
	// Identifiant de l'édito
	$edito_id = $val_edito['edito_id'];
	
	// Auteur de l'édito
	$val_author = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = '.$val_edito['user_id'],'',false);
	if ($val_author)
	{
		$edito_author_username = $val_author['username'];
	} else $edito_author_username = ($val_edito['username'] != '') ? $val_edito['username'] : 'Annonyme';
	
	// Texte de l'édito
	$bbcode_uid = $val_edito['bbcode_uid'];
	$message = bbencode_second_pass(nl2br($val_edito['edito']), $bbcode_uid);
	
	// Illustration de l'édito
	if ($val_edito['illu_extension'] != '')
	{
		
		$illu_url = $phpbb_root_path . 'images/edito/edito_' . $val_edito['edito_id'];
		$illu_exists = find_image($illu_url);
		
		$edito_img = ($illu_exists) ? '<img src="' . $illu_url . '" border="0">' : '';
		
		// Auteur de l'illustration
		$val_author_illu = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = '.$val_edito['illu_user_id'],'',false);
		if ($val_author_illu && $illu_exists)
		{
			$edito_illu_signature = sprintf($lang['done_by'],$lang['picture'],append_sid($phpbb_root_path . 'forum/profile.' . $phpEx . '?mode=viewprofile&u=' . $val_author_illu['user_id']),$val_author_illu['username']);
		} 
	} else $edito_img = '';
	
	// Date de l'édito
	//$edito_time = mktime(0,0,0,substr($val_edito['Date'],4,2),substr($val_edito['Date'],6,2),substr($val_edito['Date'],0,4));
	$edito_date = create_date($board_config['default_dateformat'], $val_edito['date_unix'], $board_config['board_timezone']);

} else 
{
	$edito_id = 0;
	$edito_title = 'Pas d\'éditorial disponible';
}

// Administration de l'édito
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'edito') || is_responsable($userdata['user_id'],'mascotte'))
{
	$url = $phpbb_root_path . 'actu/edit_edito.php' . (($edito_id != 0) ? '?mode=edit&edito_id=' . $edito_id : '');
	$u_edito_admin = append_sid($url);
	$l_edito_admin =  $lang['edit_edito'];
	$switch_edito_admin = true;
	
	$u_add_edito = append_sid($phpbb_root_path . 'actu/edit_edito?mode=add');
	$l_add_edito = $lang['add_edito'];
} else
	$switch_edito_admin = false;


// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));

$template->assign_vars(array(
				'NOM_RUB' => $lang['Actualite'],
				
				
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.html'),
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.html'),
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.html'),
				'U_ARCHIVES' => append_sid($phpbb_root_path . 'actu/edito_archives.html'),
				
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_ARCHIVES' => $lang['go_to_the_archives'],
				
				// Edito
				"EDITORIAL" => $lang['Editorial'],
				"EDITO_TITLE" => $edito_title,
				"U_EDITO_TITLE" => $phpbb_root_path . 'actu/e'.$edito_id.'-' . str_replace('&amp;url_title=','',add_title_in_url($edito_title)).'.html',
				"EDITO_SIGNATURE" => ($edito_date) ? sprintf($lang['the_by'],$edito_date,append_sid($phpbb_root_path . 'forum/profile.' . $phpEx . '?mode=viewprofile&u=' . $val_author['user_id']),$edito_author_username) : '',
				"EDITO_CORPS" => $message,
				"EDITO_ILLU" => $edito_img,
				"EDITO_ILLU_SIGNATURE" => $edito_illu_signature,
				"U_RETOUR" => append_sid($phpbb_root_path . 'actu/'),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['Actualite'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.html'),
				'L_RDN' => $lang['Revues du Net'],
			)
);


if ($switch_edito_admin)
	$template->assign_block_vars('switch_edito_admin', array(
				'U_EDITO_ADMIN' => $u_edito_admin,
				'U_ADD_EDITO' => $u_add_edito,
				
				'L_EDITO_ADMIN' => $l_edito_admin,
				'L_ADD_EDITO' => $l_add_edito,
				));


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'jjg/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
