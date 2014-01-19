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

$job=array('bio');
require_once($phpbb_root_path . 'includes/reserved_access.php');

//Liste des epidsodes
$tab_bio = select_liste("SELECT * FROM famille_bio ORDER BY page");

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='biotexte' ORDER BY user_id");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/bio_edit.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'jjg/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

//Prochaine page
$val_page = select_element("SELECT MAX(page) as max FROM famille_bio LIMIT 0,1",'',false);
$num_page = $val_page['max']+1;

$template->assign_vars(array(
				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/biblio.php'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/bio.php'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.php'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'TITRE' => $lang['titre_periode'],
				'CONTENU' => $lang['contenu_periode'],
				'L_PAGE' => sprintf($lang['page'],$num_page),
				'U_FORM' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=add_page'),
				'NEW' => sprintf($lang['new_page'],append_sid($phpbb_root_path . 'jjg/bio_edit.php')),
				"IMG_MASCOTTE" => $mascotte,
				"L_SUBMIT" => $lang['Submit'],
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/bio.php'),
			)
);

for ($i=0;$i<count($tab_bio);$i++)
{
	//Y a t il une photo
	$url_image = $phpbb_root_path . 'images/bio/bio_'.$tab_bio[$i]['bio_id'].'.'.find_image($phpbb_root_path . 'images/bio/bio_'.$tab_bio[$i]['bio_id'].'.');
	$url_picture = $phpbb_root_path . 'images/picture.gif';
	if (is_file($url_image) && is_file($url_picture))
	{
		$picture = '<img src="' . $phpbb_root_path . 'images/picture.gif" border="0" alt="Page illustrée">';
	}

	
	//Qui qui c ka ecrit
	$qui = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_bio[$i]['user_id']."  LIMIT 0,1",'',false);
	$u_qui = append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$qui['user_id']);
	
	if($tab_bio[$i]['page']==$val_page['max'])
	{
		$l_supp = $lang['supprimer'];
	}else
	{
		$l_supp = '';
	}
	
	$template->assign_block_vars('switch_bio',array(
						'U_TITRE' => append_sid($phpbb_root_path . 'jjg/bio.php?bio_id='.$tab_bio[$i]['bio_id']),
						'L_TITRE' => $tab_bio[$i]['title'],
						'U_PAGE' => append_sid($phpbb_root_path . 'jjg/bio.php?bio_id='.$tab_bio[$i]['bio_id']),
						'L_PAGE' => sprintf($lang['page'],$tab_bio[$i]['page']),
						'PICTURE' => $picture,
						'U_SUPP' => append_sid($phpbb_root_path . 'jjg/bio_edit.php?mode=suppbio_id='.$tab_bio[$i]['bio_id']),
						'U_AUTEUR' => $u_qui,
						'L_AUTEUR' => $qui['username'],
						'U_SUPP' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_page&bio_id='.$tab_bio[$i]['bio_id']),
						'L_SUPP' => $l_supp,
						'L_CONFIRM_SUPP_EPISODE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['episode'])))),
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'biotexte'))
{
		$template->assign_block_vars('switch_admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'jjg/bio_edit.php'),
						"L_ADMIN" =>  $lang['bio_admin']
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