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

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('bio','photo','biblio'));
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Galerie_photo'].', ' . $lang['biographie'] . ', ' . $lang['bibliotheque'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/index.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
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

//Chiffres clefs

$accedez_biblio = rubrikopif(array('biblio'));
$biblio = select_element('SELECT * FROM biblio_illu ORDER BY RAND() LIMIT 0,1','',false);
$url_image = '../images/biblio/livre_'.$biblio['illu_id'].'_'.$biblio['livre_id'].'.';
$ext = find_image($url_image);
$url_image .= $ext;
$img_biblio = ($biblio && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=biblio&livre_id=' . $biblio['livre_id'] . '&illu_id=' . $biblio['illu_id'] . "&tnH=112" : '../templates/jjgfamille/images/site/px.png' ;

$accedez_bio = rubrikopif(array('bio'));
$imgopif = imgopif('bio');
if(strlen($imgopif)==10)
	$bio = substr($imgopif,strpos($imgopif,'_')+1,2);
elseif(strlen($imgopif)==9)
	$bio = substr($imgopif,strpos($imgopif,'_')+1,1);
	
$img_bio = ($imgopif) ? $phpbb_root_path . 'functions/miniature.php?mode=bio&bio_id=' . $bio . "&tnH=112" : '../templates/jjgfamille/images/site/px.png' ;

$accedez_photos = rubrikopif(array('photo'));
$photo = select_element("SELECT * FROM famille_photo,famille_photo_cate WHERE famille_photo.cate_id=famille_photo_cate.cate_id AND cate_name<> 'upload' ORDER BY RAND() LIMIT 0,1",'',false);
$url_image = '../images/photos/photo_'.$photo['cate_id'].'_'.$photo['photo_id'].'.';
$ext = find_image($url_image);
$url_image .= $ext;
$img_photo = ($photo && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=photo&cate_id=' . $photo['cate_id'] . '&photo_id=' . $photo['photo_id'] . "&tnH=112" : '../templates/jjgfamille/images/site/px.png' ;
				
$template->assign_vars(array(
				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				'L_ACCES_BIBLIO' => $lang['go_to_the_bibliotheque'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'L_ACCES_BIO' => $lang['go_to_the_biography'],
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'L_ACCES_PHOTOS' => $lang['go_to_the_photo'],
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				"IMG_MASCOTTE" => $mascotte,
				'ACCEDEZ_BIBLIO' => $lang['accedez_biblio'],
				'STATS_BIBLIO' => $accedez_biblio[0]['CHIFFRES'],
				'ALT_BIBLIO' => $accedez_biblio[0]['RUBRIKOPIF_TITLE'],
				'ACCEDEZ_BIO' => $lang['accedez_bio'],
				'STATS_BIO' => $accedez_bio[0]['CHIFFRES'],
				'ALT_BIO' => $accedez_bio[0]['RUBRIKOPIF_TITLE'],
				'ACCEDEZ_PHOTOS' => $lang['accedez_photo'],
				'STATS_PHOTOS' => $accedez_photos[0]['CHIFFRES'],
				'ALT_PHOTOS' => $accedez_photos[0]['RUBRIKOPIF_TITLE'],
				'IMG_BIBLIO' => $img_biblio,
				'IMG_BIO' => $img_bio,
				'IMG_PHOTOS' => $img_photo,
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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>