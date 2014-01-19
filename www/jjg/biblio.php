<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'jjg';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_JJG);
init_userprefs($userdata);
//
// End session management
//

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='biblio' ORDER BY user_id");

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM biblio_cate ORDER BY ordre");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['bibliotheque'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/biblio.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;


$template->assign_vars(array(

				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				"L_LISTE" => $lang['liste_cate'],
				"IMAGE" => $phpbb_root_path . 'images/jjg/biblio1.gif',
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/'),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'jjg/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'biblio'))
{
		$template->assign_block_vars('switch_admin',array(
						"L_ADMIN" =>  $lang['biblio_admin'],
						"L_LISTE" => $lang['liste_cate'],
						'ADD_CATE' => $lang['add_cate'],
						'U_ADD_CATE' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=biblio_add_cate'),
						'NOM_CATE' => $lang['nom_cate'],
						"L_SUBMIT" => $lang['Submit'],
						
						)
					);
		for ($i=0;$i<count($tab_cate);$i++)
			{
	
		$l_monter = $lang['monter'];
	  	$u_monter = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=biblio_upcate&cate_id='.$tab_cate[$i]['cate_id']);
	  	$l_descendre = $lang['descendre'];
	  	$u_descendre = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=biblio_downcate&cate_id='.$tab_cate[$i]['cate_id']);
	  	$l_supprimer = $lang['supprimer'];
	  	$u_supprimer = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=biblio_supp_cate&cate_id='.$tab_cate[$i]['cate_id']);
	
	
	
	$val_count = select_element("SELECT COUNT(livre_id) as NUM FROM biblio_livre WHERE cate_id = ".$tab_cate[$i]['cate_id'],'',false);
	
	$template->assign_block_vars('switch_admin.categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'jjg/lc'.$tab_cate[$i]['cate_id'] . '-' . str_replace('&amp;url_title=','',add_title_in_url($tab_cate[$i]['cate_name'])).'.html'),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						'COUNT' => sprintf($lang['nb_livres'],$val_count['NUM']),
						'L_MONTER' => $l_monter,
						'U_MONTER' => $u_monter,
						'L_DESCENDRE' => $l_descendre,
						'U_DESCENDRE' => $u_descendre,
						'L_SUPPRIMER' => $l_supprimer,
						'U_SUPPRIMER' => $u_supprimer,
						'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['categorie'])))),
						)
					);
}
					
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
		$jack = select_element("SELECT * FROM biblio_illu,biblio_livre WHERE biblio_illu.livre_id = biblio_livre.livre_id AND cate_id = ".$tab_cate[$i]['cate_id']." ORDER BY RAND() LIMIT 0,1",'',false);
		$img_photo = ($jack) ? $phpbb_root_path . 'functions/miniature.php?mode=biblio&livre_id=' . $jack['livre_id'] . '&illu_id=' . $jack['illu_id'] . "&tnH=100" : '../templates/jjgfamille/images/site/px.png' ;
		
		$val_count = select_element("SELECT COUNT(livre_id) as NUM FROM biblio_livre WHERE cate_id = ".$tab_cate[$i]['cate_id'],'',false);
			
		$template->assign_block_vars('categorie_row.categorie_column',array(
							'PHOTO' => $img_photo,
							'U_CATE' => append_sid($phpbb_root_path . 'jjg/lc'.$tab_cate[$i]['cate_id'] . '-' .  str_replace('&amp;url_title=','',add_title_in_url($tab_cate[$i]['cate_name'])).'.html'),
							'L_CATE' => $tab_cate[$i]['cate_name'],
							'COUNT' => sprintf($lang['nb_livres'],$val_count['NUM']),
							)
						);
		$i++;
	}
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('biblio','opif');
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