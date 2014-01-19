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
$rubrikopif = rubrikopif(array('edito','rdn'));


// Sélection des maj à afficher
$page_title = $lang['MaJ'];
if (isset($_GET['maj_id']) && $_GET['maj_id'] != '')
{
	$tab_maj = select_liste("SELECT * FROM famille_maj WHERE maj_id = '" . $_GET['maj_id'] . "' ORDER BY date_unix DESC,maj_id DESC");
	$page_title .= ' :: ' . $tab_maj[0]['title'];
} else
{
	if (isset($_GET['mois']) && $_GET['mois'] != '')
	{
		$annee = substr($_GET['mois'],0,4);
		$mois = substr($_GET['mois'],4,2);
		$tab_maj = select_liste("SELECT * FROM famille_maj WHERE date_unix BETWEEN '" . mktime(0,0,0,$mois,1,$annee) . "' AND '" . mktime(23,59,59,$mois+1,0,$annee) . "' ORDER BY date_unix DESC,maj_id DESC");
		$page_title .= ' :: ' . $lang['datetime'][date('F',mktime(0,0,0,$mois,1,$annee))] . ' ' . date('Y',mktime(0,0,0,$mois,1,$annee));
	} else
	{
		$tab_maj = select_liste("SELECT * FROM famille_maj ORDER BY date_unix DESC,maj_id DESC LIMIT 0,10");
	}
}

// Sélection des mois pour les archives
$tab_archives = select_liste("SELECT DATE_FORMAT(FROM_UNIXTIME(date_unix),'%Y%m') mois FROM famille_maj GROUP BY mois ORDER BY mois DESC");


//
// Start output of page
//
define('SHOW_ONLINE', true);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/actu/maj.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/actu/actu_colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}

$responsable = ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'maj'));
$str_modifier = ' <b>[<a href="%s">%s</a>]</b>';

$template->assign_vars($rubrikopif[0]);

// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));

$str_signature = "Posté par %s le %s";
$str_poster = '<a href="' . append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u=%s') . '">%s</a>';

if ($tab_maj)
{
	while(list($key,$val) = each($tab_maj))
	{
		$texte = bbencode_second_pass(nl2br($val['maj']), $val['bbcode_uid']) . '<br />';
		if ($val['user_id'] > 0)
			$val_user = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = ' . $val['user_id'],false,''); 
	
		if ($val['user_id'] > 0 && $val_user)
			$poster = sprintf($str_poster,$val_user['user_id'],$val_user['username']);
		else
			$poster = $lang['Guest'];
			
		//$maj_time = mktime(0,0,0,substr($val['Date'],4,2),substr($val['Date'],6,2),substr($val['Date'],0,4));
		$maj_date = create_date($board_config['default_dateformat'], $val['date_unix'], $board_config['board_timezone']);
		
		$template->assign_block_vars('maj', array(
								'L_SIGNATURE' => sprintf($str_signature,$poster,$maj_date),
								'TITLE' => smilies_pass($val['title']),
								"U_TITLE" => append_sid($phpbb_root_path . 'actu/maj.html'),
								'TEXTE' => $texte,
								'MODIFIER' => ($responsable) ? ' ' . sprintf($str_modifier,append_sid($phpbb_root_path . 'actu/edit_maj.php?mode=edit&maj_id=' . $val['maj_id']),$lang['Modifier']) : '',
								'U_GO_MAJ' => append_sid($phpbb_root_path . $val['url']),
								'L_GO_MAJ' => $lang['go_to_maj'],
								));
	}
} else
		$template->assign_block_vars('switch_no_maj', array(
								'NO_MAJ' => $lang['no_maj']
								));
if ($tab_archives)
{
	while (list($key,$val) = each($tab_archives))
	{
		$date = mktime(12,0,0,substr($val['mois'],4,2),10,substr($val['mois'],0,4));
		$template->assign_block_vars('archive', array(
							'VALUE' => $val['mois'],
							'TEXTE' => $lang['datetime'][date('F',$date)] . ' ' . substr($val['mois'],0,4),
							'SELECTED' => ($val['mois']==$_GET['mois']) ? ' SELECTED' : '',
							));
	}
} else
	$template->assign_block_vars('archive', array(
							'VALUE' => 0,
							'TEXTE' => $lang['10_last_maj'],
							'SELECTED' => ' SELECTED',
							));

$u_archives = append_sid($phpbb_root_path . 'actu/maj.html');
if (strpos($u_archives,'?')===false)
	$u_archives .= '?';
else
	$u_archives .= '&amp;';

$template->assign_vars(array(
				'NOM_RUB' => $lang['MaJ'],
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.html'),
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.html'),
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.html'),
				'U_ARCHIVES' => $u_archives,
				
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_NEWS' => $lang['actu_News'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'actu/'),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['Actualite'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.html'),
				'L_RDN' => $lang['Revues du Net'],
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_ADMIN_MASCOTTE" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php'),
						"L_ADMIN_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'maj'))
{

		$template->assign_vars(array(
					'L_ADD_MAJ' => $lang['Add_maj'],
					'U_ADD_MAJ' => append_sid($phpbb_root_path . 'actu/edit_maj.php?mode=add')
					));
}

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>