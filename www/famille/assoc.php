<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'famille';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM phpbb_users WHERE user_level='" . ADMIN . "' AND user_id <> '2' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');

// Liste des sous rubriques
$tab_subrub = array('presentation','adherez');

$lang['presentation'] = 'présentation';
$lang['adherez'] = 'Adhérez !';
if (array_search($_GET['mode'],$tab_subrub)===false)
{
	$_GET['mode'] = $tab_subrub[0];
}

//: variables globales
$title = $site_config['assoc_title'];

//Liste des rdf
if(!isset($_GET['mode']) || $_GET['mode'] == 'presentation')
{
	$chapeau = nl2br(bbencode_second_pass($site_config['assoc_chapeau'],$site_config['assoc_bbcode_uid']));
	$presentation = nl2br(bbencode_second_pass($site_config['assoc_pres'],$site_config['assoc_bbcode_uid']));
}else
{
	if($_GET['mode'] == 'archives')
	{
		$tab_rdf = select_liste("SELECT * FROM rdf WHERE date < ".time()." ORDER BY date DESC");	
		if(count($tab_rdf)==0)
			$no_rdf = '<br>&nbsp;&nbsp;'.$lang['Il n\'y a aucune réunion de famille archivée'];
		$prochainement = $lang['Archives'];
		$archives = $lang['Voir les prochaines réunion de famille'];
		$u_archives = append_sid($phpbb_root_path . 'famille/rdf.php?mode=next');
	}
	else
	{
		$tab_rdf = select_liste("SELECT * FROM rdf WHERE date >= ".time()." ORDER BY date");
		if(count($tab_rdf)==0)
			$no_rdf = '<br>&nbsp;&nbsp;'.$lang['Il n\'y aucune réunion de famille prévue prochainement'];
		$prochainement = $lang['prochainement'];
		$archives = $lang['go_to_the_archives'];
		$u_archives = append_sid($phpbb_root_path . 'famille/rdf.php?mode=archives');
	}
}

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('rdf'));

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $title;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/rub.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

//sous rubriques
for ($i=0;$i<count($tab_subrub);$i++)
{
	if ($_GET['mode'] == $tab_subrub[$i])
	{
		$str = '<b>%s</b>';
	} else
	{
		$str = '<a href="' . append_sid($phpbb_root_path . 'famille/assoc.php?mode=' . $tab_subrub[$i]) .'">%s</a>';
	}
	$template->assign_block_vars('submenu',array(
						'L_SUBRUB' => sprintf($str,$lang[$tab_subrub[$i]])
						));
}

if ($img_mascotte)
$mascotte = $img_mascotte;

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}

// Logo de l'assoc
$url_logo_assoc = '../images/famille/assoc.';
$ext = find_image($url_logo_assoc);
if(is_file($url_logo_assoc.$ext))
{
	$picture = $url_logo_assoc.$ext;
}
else 
{
	$picture = '../templates/jjgfamille/images/site/px.png';
}


$template->assign_vars($rubrikopif[0]);

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Famille'],
				'RUB' => $title,
				'EQUIPE' => $lang['equipe'],
				'NOM_RUB' => $lang['Famille'],
				'IMG' => $picture,
				"CONTENU" => $presentation,
				
				'L_EQUIPE' => $lang['equipe'],
				'L_RDF' => $lang['Réunion De Famille'],
				'L_RETOUR' => $lang['retour'],
				'L_RUB' => $title,
				
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/'),
			)
);



if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'famille/edit_mascotte.php'),
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

for ($i=0;$i<count($tab_rub);$i++)
{
		
		$template->assign_block_vars('switch_rub',array(
						"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub[$i]['rub_id']),
						"L_RUB" =>  $tab_rub[$i]['name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('rdf','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );


$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>