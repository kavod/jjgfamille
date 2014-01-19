<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('more'));

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/index.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}


$template->assign_vars($rubrikopif[0]);

if ($img_mascotte)
$mascotte = $img_mascotte;

$accedez_more = rubrikopif(array('more'));

$template->assign_vars(array(

				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"L_LISTE" => $lang['liste_cate'],
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/index.php'),
				'AJOUT_MORE' => sprintf($lang['ajout_more'],append_sid($phpbb_root_path . 'more/add.php')),
				'ACCEDEZ_MORE' => $lang['accedez_more'],
				'STATS_MORE' => $accedez_more[0]['CHIFFRES'],
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
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

// On définit le nombre de photo par ligne
define("NB_BY_COL",3);
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
		$jack = select_element("SELECT * FROM more WHERE cate_id = ".$tab_cate[$i]['cate_id']." AND enable='Y' ORDER BY RAND() LIMIT 0,1",'',false);
		$ext = find_image('../images/goodies/goodies_' . $jack['more_id'] . '.');
		$img_photo = ($jack && is_file("../images/goodies/goodies_".$jack['more_id'].".".$ext)) ? $phpbb_root_path . 'functions/miniature.php?mode=more&more_id=' . $jack['more_id'] . "&tnH=112" : '../templates/jjgfamille/images/site/px.png' ;
		$val_count = select_element("SELECT COUNT(more_id) as NUM FROM more WHERE cate_id = ".$tab_cate[$i]['cate_id']." AND enable='Y'",'',false);
			
		$url = ($tab_cate[$i]['filename'] == '') ? append_sid($phpbb_root_path . 'more/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']) : $tab_cate[$i]['filename'];
			
		$template->assign_block_vars('categorie_row.categorie_column',array(
							'PHOTO' => $img_photo,
							'U_CATE' => $url,
							'L_CATE' => $tab_cate[$i]['cate_name'],
							'COUNT' => $val_count['NUM'].'&nbsp;'.$lang['elements'],
							)
						);
		$i++;
	}
}

for ($i=0;$i<count($tab_cate);$i++)
{
	$url = $phpbb_root_path . 'more/';
	$url .= ($tab_cate[$i]['filename'] == '') ? 'view_cate.php?cate_id='.$tab_cate[$i]['cate_id'] : $tab_cate[$i]['filename'];
	$template->assign_block_vars('switch_cate',array(
						'U_CATE' => append_sid($url),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'more'))
{

	
		$template->assign_block_vars('admin',array(
						"L_LISTE" => $lang['liste_cate'],
						'COUNT' => sprintf($lang['asso'],$tab_count['NUM']),
						'ADD_CATE' => $lang['add_cate'],
						'NOM_CATE' => $lang['nom_cate'],
						'U_ADD_CATE' => append_sid($phpbb_root_path . 'more/doedit.php?mode=add_cate'),
						'L_ADMIN' => $lang['more_admin'],
						"L_SUBMIT" => $lang['Submit'],
						)
					);
	for ($i=0;$i<count($tab_cate);$i++)
	{
	
	
		$val_count = select_element("SELECT COUNT(more_id) as NUM FROM more WHERE cate_id = ".$tab_cate[$i]['cate_id'],'',false);
	
		
		$template->assign_block_vars('admin.categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'more/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						'U_EDIT' => append_sid($phpbb_root_path . 'more/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_EDIT' => $lang['edit'],
						'L_MONTER' => $lang['monter'],
						'U_MONTER' => append_sid($phpbb_root_path . 'more/doedit.php?mode=upcate&cate_id='.$tab_cate[$i]['cate_id']),
						'L_DESCENDRE' => $lang['descendre'],
						'U_DESCENDRE' => append_sid($phpbb_root_path . 'more/doedit.php?mode=downcate&cate_id='.$tab_cate[$i]['cate_id']),
						'L_SUPPRIMER' => $lang['supprimer'],
						'U_SUPPRIMER' => append_sid($phpbb_root_path . 'more/doedit.php?mode=supp_cate&cate_id='.$tab_cate[$i]['cate_id']),
						'COUNT' => $val_count['NUM'].'&nbsp;'.$lang['elements'],
						'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['categorie'])))),
						)
					);
	}	
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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>