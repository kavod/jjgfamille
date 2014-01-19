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
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='photos' ORDER BY user_id");

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM famille_photo_cate WHERE cate_name <> 'upload' ORDER BY ordre");

//
//NB photos
//
$nb_photos = select_element("SELECT valeur_num FROM famille_config WHERE param = 'nb_photo_by_page' ",'',false);

//Categorie upload 
$val_upload = select_element("SELECT cate_id FROM famille_photo_cate WHERE cate_name = 'upload' ",'',false);

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');

//
// Boris 16/05/2006
// Meilleurs contributeurs
//
$tab_contributors = select_liste("SELECT user_id, user_name, COUNT(*) nb_photos FROM famille_photo GROUP BY user_id, user_name ORDER BY nb_photos DESC LIMIT 0,5");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Galerie_photo'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/photos.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/'),
				
				"L_LISTE" => $lang['liste_cate'],
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'L_BEST_CONTRIBUTORS' => sprintf($lang['deux_points'],$lang['Best_contributors']),
				'L_RETOUR'=> $lang['retour'],
				
				"IMG_MASCOTTE" => $mascotte,
				'AJOUT_PHOTOS' => sprintf($lang['ajout_photos'],append_sid($phpbb_root_path . 'jjg/photos_add_photos.php')),
				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				"IMAGE" => $phpbb_root_path . 'images/jjg/jjggalleriephoto.gif',
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

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'photos'))
{
		$template->assign_block_vars('switch_admin',array(
						"L_ADMIN" =>  $lang['jjg_admin'],
						'ADD_CATE' => $lang['add_cate'],
						'U_ADD_CATE' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=add_cate'),
						'NOM_CATE' => $lang['nom_cate'],
						'L_LISTE' => $lang['liste_cate'],
						'MODIFIER' => $lang['modifier'],
						'NB_PHOTOS' => sprintf($lang['parametres'],$nb_photos['valeur_num']),
						'U_NB_PHOTOS' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=nb_photos'),
						'U_ACCES_UPLOAD'=> append_sid($phpbb_root_path . 'jjg/photos_view_cate?cate_id='.$val_upload['cate_id']),
						'L_ACCES_UPLOAD'=> $lang['acces_upload'],
						"L_SUBMIT" => $lang['Submit']
						)
					);
		for ($i=0;$i<count($tab_cate);$i++)
			{
				$val_count = select_element("SELECT COUNT(photo_id) as NUM FROM famille_photo WHERE cate_id = ".$tab_cate[$i]['cate_id'],'',false);
	
	if($tab_cate[$i]['cate_name']<> 'upload')
	{ 
		$l_monter = $lang['monter'];
	  	$u_monter = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=upcate&cate_id='.$tab_cate[$i]['cate_id']);
	  	$l_descendre = $lang['descendre'];
	  	$u_descendre = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=downcate&cate_id='.$tab_cate[$i]['cate_id']);
	  	$l_supprimer = $lang['supprimer'];
	  	$u_supprimer = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_cate&cate_id='.$tab_cate[$i]['cate_id']);
	}else
	{
		$l_monter = '';
	  	$u_monter = '';
	  	$l_descendre = '';
	  	$u_descendre = '';
	  	$l_supprimer = '';
	  	$u_supprimer = '';
	}
	
	$template->assign_block_vars('switch_admin.categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'jjg/photos-' . str_replace('&amp;url_title=','',add_title_in_url($tab_cate[$i]['cate_name'])) .'_'.$tab_cate[$i]['cate_id'].'.html'),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						'COUNT' => sprintf($lang['nb_photos'],$val_count['NUM']),
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
		$jack = select_element("SELECT * FROM famille_photo WHERE cate_id = ".$tab_cate[$i]['cate_id']." ORDER BY RAND() LIMIT 0,1",'',false);
		$img_photo = ($jack) ? $phpbb_root_path . 'functions/miniature.php?mode=photo&photo_id=' . $jack['photo_id'] . '&cate_id=' . $jack['cate_id'] . "&tnH=100" : '../templates/jjgfamille/images/site/px.png' ;
		
		$val_count = select_element("SELECT COUNT(photo_id) as NUM FROM famille_photo WHERE cate_id = ".$tab_cate[$i]['cate_id'],'',false);
			
		$template->assign_block_vars('categorie_row.categorie_column',array(
							'PHOTO' => $img_photo,
							'U_CATE' => append_sid($phpbb_root_path . 'jjg/photos-' . str_replace('&amp;url_title=','',add_title_in_url($tab_cate[$i]['cate_name'])) .'_'.$tab_cate[$i]['cate_id'].'.html'),
							'L_CATE' => $tab_cate[$i]['cate_name'],
							'COUNT' => sprintf($lang['nb_photos'],$val_count['NUM']),
							)
						);
		$i++;
	}
}

//
// Boris 16/05/2006
// Meilleurs contributeurs
//
for ($i=0;$i<count($tab_contributors);$i++)
{
	$val_user = get_user($tab_contributors[$i]['user_id'],$tab_contributors[$i]['user_name']);
	$template->assign_block_vars('contributors',array(
					'U_USER' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&amp;u=' . $val_user['user_id']),
					'USERNAME' => $val_user['username'],
					'NB_PHOTOS' => sprintf($lang['nb_photos'],$tab_contributors[$i]['nb_photos']),
					)
				);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('photo','opif');
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