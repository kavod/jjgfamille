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
$page_title = $lang['editoriaux'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/actu/archives_edito.tpl',
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

$tab_archives = select_liste("SELECT * FROM famille_edito ORDER BY date_unix DESC,edito_id DESC");

// Administration de l'édito
$responsable =  ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'edito') || is_responsable($userdata['user_id'],'mascotte'));


// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));

while(list($key,$val) = each($tab_archives))
{
	$str_illu = '<img src="' . $phpbb_root_path . 'images/picture.gif" title="%s" alt="%s" border="0" />';
	//$date = mktime(12,0,0,substr($val['Date'],4,2),substr($val['Date'],6,2),substr($val['Date'],0,4));
	
	$template->assign_block_vars('archives', array(
						'DATE' => date('d/m/Y',$val['date_unix']),
						'TITLE' => $val['title'],
						'ILLU' => (find_image($phpbb_root_path . 'images/edito/edito_' . $val['edito_id'])) ? sprintf($str_illu,$lang['illustrated_edito'],$lang['illustrated_edito']) : '',
						
						'U_EDIT' => ($responsable)  ? append_sid($phpbb_root_path . 'actu/edit_edito.php?mode=edit&edito_id=' . $val['edito_id']) : '',
						'U_VIEW' => append_sid($phpbb_root_path . 'actu/e' . $val['edito_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($val['title'])).'.html'),
						
						'L_EDIT' => ($responsable) ? $lang['Modifier'] : '',
						));
						
}
				
$template->assign_vars(array(
				'NOM_RUB' => $lang['Actualite'],
				
				
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.html'),
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.html'),
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.html'),
				'U_ARCHIVES' => append_sid($phpbb_root_path . 'actu/edito_archives.html'),
				
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_EDITO_ARCHIVES' => $lang['Archives'],
				
				// Edito
				"EDITORIAL" => $lang['Editorial'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'actu/edito.html'),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['Actualite'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.html'),
				'L_RDN' => $lang['Revues du Net'],
			)
);


if ($switch_edito_admin)
	$template->assign_block_vars('switch_edito_admin', array(
				'U_EDITO_ADMIN' => $u_edito_admin,
				'L_EDITO_ADMIN' => $l_edito_admin
				));


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_ADMIN_MASCOTTE" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php'),
						"L_ADMIN_MASCOTTE" =>  $lang['Change_mascotte'],
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
