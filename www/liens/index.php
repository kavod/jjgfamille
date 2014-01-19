<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'liens';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LIENS);
init_userprefs($userdata);
//
// End session management
//

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='liens' ORDER BY user_id");
//
//Sites orphelins
//
$tab_count = select_element("SELECT COUNT( * ) AS NUM FROM liens_sites sites LEFT JOIN liens_cate_site asso ON asso.site_id = sites.site_id WHERE asso.cate_id IS NULL",'',false);
//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM liens_categories ORDER BY ordre");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_liens'],'liens');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Links'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'site/liens/index.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/liens/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;
		
$template->assign_vars(array(
				// Liens
				"LIENS" => $lang['Links'],
				"L_LISTE" => $lang['liste_cate'],
				"RESPONSABLES" => $lang['Responsables'],
				"IMG_LIENS" => $phpbb_root_path . 'images/jjg/liens.gif',
				"WEBMASTER" => sprintf($lang['Webmaster'],append_sid("add_site.php")),
				"IMG_MASCOTTE" => $mascotte,
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'liens/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
{

	
		$template->assign_block_vars('admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'liens/edit.php'),
						"L_ADMIN" =>  $lang['liens_admin'],
						"L_LISTE" => $lang['liste_cate'],
						'ORPHELIN'=> $lang['orphelins'],
						'COUNT' => sprintf($lang['asso'],$tab_count['NUM']),
						'ADD_CATE' => $lang['add_cate'],
						'NOM_CATE' => $lang['nom_cate'],
						'L_EDIT' => $lang['edit'],
						'U_EDIT' => append_sid($phpbb_root_path . 'liens/edit_cate_orphelin.php'),
						'U_ADD_CATE' => append_sid($phpbb_root_path . 'liens/doedit.php?mode=add_cate'),
						"L_SUBMIT" => $lang['Submit']
						)
					);
	for ($i=0;$i<count($tab_cate);$i++)
	{
	
	
		$val_count = select_element("SELECT COUNT(site_id) as NUM FROM liens_cate_site WHERE cate_id = ".$tab_cate[$i]['cate_id'],'',false);
	
		
		$template->assign_block_vars('admin.categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						'U_EDIT' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_EDIT' => $lang['edit'],
						'L_MONTER' => $lang['monter'],
						'U_MONTER' => append_sid($phpbb_root_path . 'liens/doedit.php?mode=upcate&cate_id='.$tab_cate[$i]['cate_id']),
						'L_DESCENDRE' => $lang['descendre'],
						'U_DESCENDRE' => append_sid($phpbb_root_path . 'liens/doedit.php?mode=downcate&cate_id='.$tab_cate[$i]['cate_id']),
						'L_SUPPRIMER' => $lang['supprimer'],
						'U_SUPPRIMER' => append_sid($phpbb_root_path . 'liens/doedit.php?mode=supp_cate&cate_id='.$tab_cate[$i]['cate_id']),
						'COUNT' => sprintf($lang['asso'],$val_count['NUM']),
						'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['categorie'])))),
						)
					);
	}	
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}


// On définit le nombre de photo par ligne
define("NB_BY_COL",2);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_cate = count($tab_cate);
// Pour chaque ligne...
$i=0;
while($i<$nb_cate)
{
	$template->assign_block_vars('categorie_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_cate;$j++)
	{
		$jack = select_element("SELECT * FROM liens_sites,liens_cate_site WHERE liens_sites.site_id = liens_cate_site.site_id AND liens_cate_site.cate_id = ".$tab_cate[$i]['cate_id']." ORDER BY RAND() LIMIT 0,1",'',false);
		$img_photo = ($jack) ? $phpbb_root_path . 'functions/miniature.php?mode=liens&site_id=' . $jack['site_id'] . '&cate_id=' . $jack['cate_id'] . "&tnH=300" : '../templates/jjgfamille/images/site/px.png' ;
		
		$val_count = select_element("SELECT COUNT(site_id) as NUM FROM liens_categories,liens_cate_site WHERE liens_categories.cate_id = liens_cate_site.cate_id AND  liens_categories.cate_id = ".$tab_cate[$i]['cate_id'],'',false);
			
		$template->assign_block_vars('categorie_row.categorie_column',array(
							'PHOTO' => $img_photo,
							'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
							'L_CATE' => $tab_cate[$i]['cate_name'],
							'COUNT' => sprintf($lang['nb_sites'],$val_count['NUM']),
							)
						);
		$i++;
	}
}

for ($i=0;$i<count($tab_cate);$i++)
{
	
	$template->assign_block_vars('categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name'],
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

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('liens','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );


$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
