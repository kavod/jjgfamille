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

//Selection de l'episode
$bio_id = $_POST['bio_id'];
if ($bio_id == '')
	$bio_id = $_GET['bio_id'];
if ($bio_id == "")
{	
	$val_bio = select_element("SELECT * FROM famille_bio WHERE page = 1 LIMIT 0,1",'',false);
	$bio_id = $val_bio['bio_id'];
} else
{	
	$val_bio = select_element("SELECT * FROM famille_bio WHERE bio_id = ".$bio_id." LIMIT 0,1",'',false);
}

//NB PAGE
$tab_page = select_liste("SELECT bio_id,page FROM famille_bio ORDER BY page");

//Liste des epidsodes
$tab_bio1 = select_liste("SELECT * FROM famille_bio ORDER BY page");

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='biotexte' ORDER BY user_id");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');

// Page suivante
$val_suivante = select_element("SELECT * FROM famille_bio WHERE page = '" . ($val_bio['page'] + 1) . "'",false,'');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/bio.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
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

for ($i=0;$i<count($tab_page);$i++)
{
	$template->assign_block_vars('go_to_page',array(
				"VALUE" => $tab_page[$i]['bio_id'],
				"INTITULE" => sprintf($lang["go_to_page"],($tab_page[$i]['page'])),
				"SELECTED" => ($tab_page[$i]['page'] == $val_bio['page']) ? " SELECTED" : ""
				));
}

//la photo de l'episode

$ext = find_image($phpbb_root_path . 'images/bio/bio_'.$bio_id.'.');
$url_image = $phpbb_root_path . 'images/bio/bio_'.$bio_id.'.'.$ext;
$l_supp_image = $lang['supp_image'];
if (is_file($url_image))
{
$image = '<img src="' . $phpbb_root_path . 'functions/image.php?mode=bio&bio_id='.$bio_id.'" alt="'.$val_bio['title'].'" border="0">';
$image_admin = '<img src="../images/bio/bio_'.$bio_id.'.jpg" alt="'.$val_bio['title'].'" border="0">';
}
	 

//Qui qui c ka ecrit
$qui = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$val_bio['user_id']."  LIMIT 0,1",'',false);
$u_qui = append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$qui['user_id']);

$template->assign_vars(array(
				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'TITRE' => $val_bio['title'],
				'CONTENU' => nl2br(bbencode_second_pass($val_bio['contenu'],$val_bio['bbcode_uid'])),
				'IMAGE' => $image,
				"BIO_QUI" => sprintf($lang['bio_qui'],$u_qui,$qui['username']),
				"IMG_MASCOTTE" => $mascotte,
				'U_GO_TO_PAGE' => append_sid("biographie.html"),
				'L_RETOUR' => $lang['retour'], 
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/'),
				
			)
);

// S'il y a une page suivante
if ($val_suivante)
{
	$template->assign_block_vars('switch_suiv',array(
				"L_PAGE_SUIVANTE" => $lang['suiv'],
				
				"U_PAGE_SUIVANTE" => append_sid($phpbb_root_path . 'jjg/b' . $val_suivante['bio_id'] . '-' . str_replace('&amp;url_title=','',add_title_in_url($val_suivante['title'])).'.html'),
				));
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'biotexte'))
{
				
		$template->assign_block_vars('switch_admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'jjg/bio_edit.php'),
						"L_ADMIN" =>  $lang['bio_admin'],
						'TITRE_PAGE' => addslashes($val_bio['title']),
						'L_PAGE' => sprintf($lang['page'],$val_bio['page']),
						'CONTENU_PAGE' => preg_replace('/\:(([a-z0-9]:)?)' . $val_bio['bbcode_uid'] . '/s', '', $val_bio['contenu']),
						'L_SUBMIT' => $lang['Submit'],
						'U_AUTEUR' => $u_qui,
						'L_AUTEUR' => $qui['username'],
						'TITRE' => $lang['titre_periode'],
						'CONTENU' => $lang['contenu_periode'],
						'AUTEUR' => $lang['auteur_periode'],
						'IMAGE' => $image_admin,
						'PIC' => $lang['picture_bio'],
						'U_SUPP_IMAGE' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_pic_page&bio_id='.$val_bio['bio_id']),
						'L_SUPP_IMAGE' => $l_supp_image,
						'U_FORM' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=edit_page&bio_id='.$val_bio['bio_id']),
						'U_FORM_PIC' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=add_pic_page&bio_id='.$val_bio['bio_id']),
						'NEW' => sprintf($lang['new_page'],append_sid($phpbb_root_path . 'jjg/bio_edit.php')),
						'L_CONFIRM_SUPP_ILLU' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['picture'])))),
						)
					);
					
for ($i=0;$i<count($tab_bio1);$i++)
{

$url_image = $phpbb_root_path . 'images/bio/bio_'.$tab_bio1[$i]['bio_id'].'.'.find_image($phpbb_root_path . 'images/bio/bio_'.$tab_bio1[$i]['bio_id'].'.');
$url_picture = $phpbb_root_path . 'images/picture.gif';
if (is_file($url_image) && is_file($url_picture))
{
	$picture = '<img src="' . $phpbb_root_path . 'images/picture.gif" border="0" alt="Page illustrée">';
}

		
	
	
	//Qui qui c ka ecrit
	$qui = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_bio1[$i]['user_id']."  LIMIT 0,1",'',false);
	$u_qui = append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$qui['user_id']);
	
	//Derniere page
		$val_page = select_element("SELECT MAX(page) as max FROM famille_bio LIMIT 0,1",'',false);
	
	if($tab_bio1[$i]['page']==$val_page['max'])
	{
		$l_supp = $lang['supprimer'];
	}else
	{
		$l_supp = '';
	}
	
	$template->assign_block_vars('switch_admin.switch_bio',array(
						'U_TITRE' => append_sid($phpbb_root_path . 'jjg/b'.$tab_bio1[$i]['bio_id'] .'-'. str_replace('&amp;url_title=','',add_title_in_url($tab_bio1[$i]['title'])).'.html'),
						'L_TITRE' => $tab_bio1[$i]['title'],
						'U_PAGE' => append_sid($phpbb_root_path . 'jjg/b'.$tab_bio1[$i]['bio_id'] .'-'. str_replace('&amp;url_title=','',add_title_in_url($tab_bio1[$i]['title'])).'.html'),
						'L_PAGE' => sprintf($lang['page'],$tab_bio1[$i]['page']),
						'PICTURE' => $picture,
						'U_SUPP' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_page&bio_id='.$tab_bio1[$i]['bio_id']),
						'L_SUPP' => $l_supp,
						'U_AUTEUR' => $u_qui,
						'L_AUTEUR' => $qui['username'],
						'L_CONFIRM_SUPP_EPISODE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['episode'])))),
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

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('bio','opif');
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