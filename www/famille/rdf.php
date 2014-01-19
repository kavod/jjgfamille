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
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');

//
// Boris 16/05/2006
// Meilleurs rdfeurs
//
$tab_contributors = select_liste("SELECT user_id, username, COUNT(*) nb_rdf FROM rdf_membre GROUP BY user_id, username ORDER BY nb_rdf DESC LIMIT 0,5");

//Liste des rdf
if(!isset($_GET['mode']))
{
	$tab_rdf = select_liste("SELECT * FROM rdf WHERE date >= ".time()." ORDER BY date");
	if(count($tab_rdf)==0)
		$no_rdf = '<br>&nbsp;&nbsp;'.$lang['Il n\'y a aucune réunion de famille prévue prochainement'];
	
	$prochainement = $lang['prochainement'];
	$archives = $lang['go_to_the_archives'];
	$u_archives = append_sid($phpbb_root_path . 'famille/rdf.php?mode=archives');
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
$page_title = $lang['Réunion De Famille'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/rdf.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}

$template->assign_vars($rubrikopif[0]);

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Famille'],
				'RUB' => $lang['Réunion De Famille'],
				'EQUIPE' => $lang['equipe'],
				'NO_RDF' => $no_rdf,
				'IS_YOU_TO_PLAY' => sprintf($lang['is_you_to_add_rdf'],append_sid($phpbb_root_path . 'famille/add_rdf.php')),
				
				'L_EQUIPE' => $lang['equipe'],
				'L_RDF' => $lang['Réunion De Famille'],
				'L_PROCHAINEMENT' => $prochainement,
				'L_ARCHIVES' => $archives, 
				'L_RETOUR' => $lang['retour'],
				'L_BEST_RDFEURS' => $lang['Best_rdfeurs'],
				
				
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'U_ARCHIVES' => $u_archives,
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/index.php'),
			)
);

for ($i=0;$i<count($tab_rdf);$i++)
{
	
	
	if ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'chat') || ($userdata['user_id'] == $tab_rdf[$i]['user_id'] && $tab_rdf[$i]['date']>time()))
	 {
		$modifier = '[&nbsp;'.$lang['Gérer ma RDF'].'&nbsp;]';
		$u_modifier =  append_sid($phpbb_root_path . 'famille/edit_rdf.php?rdf_id='.$tab_rdf[$i]['rdf_id']);
		
	 }
	 else
	 {
	 	$modifier = '';
	 }

	//Une image au pif 
	$photo = select_element("SELECT * FROM rdf_photos WHERE rdf_id=".$tab_rdf[$i]['rdf_id']." ORDER BY rand() LIMIT 0,1",'',false);
	$image = $phpbb_root_path . 'images/rdf/photo_'.$photo['rdf_id'].'_' . $photo['photo_id'] . '.';
	$ext = find_image($phpbb_root_path . 'images/rdf/photo_'.$photo['rdf_id'].'_' . $photo['photo_id'] . '.');
	$image .= $ext;
	$img_photo = ($photo && is_file($image)) ? $phpbb_root_path . 'functions/miniature.php?mode=rdf&rdf_id=' . $photo['rdf_id'] . '&photo_id=' . $photo['photo_id'] . "&tnH=100" : '../templates/jjgfamille/images/site/px.png' ;
	
	$template->assign_block_vars('switch_rdf',array(
						
						'DATE' => date_unix($tab_rdf[$i]['date'],'date1'),
						'LIEU' => $tab_rdf[$i]['lieu'],
						'U_TITLE' => append_sid($phpbb_root_path . 'famille/view_rdf.php?rdf_id='.$tab_rdf[$i]['rdf_id']),
						'MODIF' => $modifier,
						'U_MODIF' => $u_modifier,
						'IMG_PHOTO' => $img_photo,
						'DESC_PHOTO' => bbencode_second_pass(nl2br($photo['description']), $photo['bbcode_uid']),
						'DESCRIPTION' => smilies_pass(bbencode_second_pass(nl2br($tab_rdf[$i]['description']), $tab_rdf[$i]['bbcode_uid'])),
						)
					);
	
}

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

//
// Boris 16/05/2006
// Meilleurs rdfeurs
//
for ($i=0;$i<count($tab_contributors);$i++)
{
	$val_user = get_user($tab_contributors[$i]['user_id'],$tab_contributors[$i]['user_name']);
	$x_rdf = ($tab_contributors[$i]['nb_rdf']>1) ? 'x_rdfs' : 'x_rdf';
	$template->assign_block_vars('rdfeur',array(
					'U_USER' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&amp;u=' . $val_user['user_id']),
					'USERNAME' => $val_user['username'],
					'NB_RDF' => sprintf($lang[$x_rdf],$tab_contributors[$i]['nb_rdf']),
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