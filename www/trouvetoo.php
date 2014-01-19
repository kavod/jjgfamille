<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = './';
$actual_rub = 'liens';
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

if ($img_mascotte)
$mascotte = $img_mascotte ;

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Actualite'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/aquadesign.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/actu/actu_colonne_gauche.tpl'
)
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}


$template->assign_vars($rubrikopif[0]);


// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));



$accedez_edito = rubrikopif(array('edito'));
$imgopif = imgopif('edito');
if(strlen($imgopif)==12)
	$edito = substr($imgopif,strpos($imgopif,'_')+1,2);
elseif(strlen($imgopif)==11)
	$edito = substr($imgopif,strpos($imgopif,'_')+1,1);

$img_edito = ($imgopif) ? $phpbb_root_path . 'functions/miniature.php?mode=edito&edito_id=' . $edito . '&tnH=112' : '../templates/jjgfamille/images/site/px.png' ;
	
// Chiffres clefs news
$val_news = select_element('SELECT COUNT(*) nb_news FROM famille_news','Erreur durant la comptabilisation des news',true);
$nb_news = $val_news['nb_news'];
if ($nb_news > 1)
	$l_news = $lang['actu_News'];
else $nb_news = '';

// Chiffres clefs majs
$val_maj = select_element('SELECT COUNT(*) nb_maj FROM famille_maj','Erreur durant la comptabilisation des majs',true);
$nb_maj = $val_maj['nb_maj'];
if ($nb_maj > 1)
	$l_maj = $lang['MaJ'];
else $nb_maj = '';

// Chiffres clefs rdn
$val_rdn = select_element('SELECT COUNT(*) nb_rdn FROM famille_rdn','Erreur durant la comptabilisation des rdns',true);
$nb_rdn = $val_rdn['nb_rdn'];
if ($nb_rdn > 1)
	$l_rdn = $lang['Revues du Net'];
else $nb_rdn = '';

$imgopif = imgopif('rdn');
if(strlen($imgopif)==10)
	$rdn = substr($imgopif,strpos($imgopif,'_')+1,2);
elseif(strlen($imgopif)==9)
	$rdn = substr($imgopif,strpos($imgopif,'_')+1,1);
$img_rdn = ($imgopif) ? $phpbb_root_path . 'functions/miniature.php?mode=rdn&rdn_id=' . $rdn . "&tnH=112" : '../templates/jjgfamille/images/site/px.png' ;
			
$template->assign_vars(array(
				'NOM_RUB' => 'Lien coup de coeur',
				'L_ACCES_EDITO' => $lang['go_to_the_edito'],
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.html'),
				'L_ACCES_NEWS' => $lang['go_to_the_news'],
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.html'),
				'L_ACCES_MAJ' => $lang['go_to_the_maj'],
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.html'),
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_LISTE' => $lang['Actualite'],
				'ACCEDEZ_ACTU' => $lang['accedez_edito'],
				'STATS_ACTU' => $accedez_edito[0]['CHIFFRES'],
				'ACCEDEZ_NEWS' => $lang['accedez_news'],
				'STATS_NEWS' => sprintf("<b>%s</b> %s",$nb_news,$l_news),
				'ACCEDEZ_MAJ' => $lang['accedez_maj'],
				'STATS_MAJ' => sprintf("<b>%s</b> %s",$nb_maj,$l_maj),
				'ALT_ACTU' => $accedez_edito[0]['RUBRIKOPIF_TITLE'],
				'ALT_NEWS' => $lang['actu_News'],
				'ALT_MAJ' => $lang['MaJ'],
				'L_ACCES_RDN' => $lang['go_to_the_rdn'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.html'),
				'L_RDN' => $lang['Revues du Net'],
				'ACCEDEZ_RDN' => $lang['accedez_rdn'],
				'STATS_RDN' => sprintf("<b>%s</b> %s",$nb_rdn,$l_rdn),
				'ALT_RDN' => $lang['Revues du Net'],
				'IMG_EDITO' => $img_edito,
				'IMG_RDN' => $img_rdn,
				'IMG_NEWS' => '../images/new.gif',
				'IMG_MAJ' => '../images/construction.gif',
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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
