<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'famille';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//

// Log Pas nécessaire pour visionner un récit
//include($phpbb_root_path . 'includes/log_necessary.php');

$recit_id = $_GET['recit_id'];

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');
//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");
//Séléction du recit
$val_recit = select_element("SELECT * FROM rdf_recits WHERE recit_id = ".$recit_id."",'',false);
//la rdf séléctionnée
$val_rdf = select_element("SELECT * FROM rdf WHERE rdf_id= ".$val_recit['rdf_id']." LIMIT 0,1",'',false);

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Réunion De Famille'].' '.$lang['Récit'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/recits.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'chat') || $userdata['user_id']==$val_recit['user_id'])
{

	$u_modifier = append_sid($phpbb_root_path . 'famille/edit_recit.php?recit_id='.$val_recit['recit_id']);
	$l_modifier = '[&nbsp;'.$lang['Modifier'].'&nbsp;]';
					
}

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Famille'],
				'RUB' => $lang['Réunion De Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'L_RDF' => $lang['Réunion De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/view_rdf.php?rdf_id='.$val_rdf['rdf_id']),
				'L_RETOUR' => $lang['retour'],	
				'RECIT' => $lang['Récit'].' '.$lang['Réunion De Famille'],
				'L_RECIT' => bbencode_second_pass(nl2br($val_recit['recit']), $val_recit['bbcode_uid']),
				'WHO' =>  $lang['Récit'].' '.$lang['de'].' <a href="'.append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_recit['user_id']).'">'.$val_recit['username'].'</a>',	
				'U_MODIFIER' => $u_modifier,
				'L_MODIFIER' => $l_modifier,		
			)
);


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'famille/edit_mascotte.php'),
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

for ($i=0;$i<count($tab_rub);$i++)
{
		
		$template->assign_block_vars('switch_rub',array(
						"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub[$i]['rub_id']),
						"L_RUB" =>  $tab_rub[$i]['name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('rdf','opif');
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