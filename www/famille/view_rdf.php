<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'famille';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/emailer.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//

$rdf_id = $_GET['rdf_id'];
//Sélection de la rdf
$val_rdf = select_element("SELECT * FROM rdf WHERE rdf_id=".$rdf_id,'',false);

if ($_GET['mode'] == 'subcribe')
{

	include($phpbb_root_path . 'includes/log_necessary.'.$phpEx);
	
	$sql = "INSERT INTO rdf_membre (rdf_id,user_id,username,date) VALUES (".$rdf_id.",".$userdata['user_id'].",'".$userdata['username']."','" . date('U') . "') ";
	logger($userdata['username']." s'est inscrit à la RDF N°$rdf_id");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "famille/view_rdf." . $phpEx ."?rdf_id=" . $rdf_id) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['rdf_subcribe_ok'], '<a href="' . append_sid($phpbb_root_path . "famille/view_rdf." . $phpEx ."?rdf_id=" . $rdf_id) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mode'] == 'unsubcribe')
{

	include($phpbb_root_path . 'includes/log_necessary.'.$phpEx);
	
	$sql = "DELETE FROM rdf_membre WHERE rdf_id=".$rdf_id." AND user_id=".$userdata['user_id'];
	logger($userdata['username']." s'est désinscrit à la RDF N°$rdf_id");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "famille/view_rdf." . $phpEx ."?rdf_id=" . $rdf_id) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['rdf_unsubcribe_ok'], '<a href="' . append_sid($phpbb_root_path . "famille/view_rdf." . $phpEx ."?rdf_id=" . $rdf_id) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");
//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');
//Séléection de tous les familliens inscrits
$tab_inscrits = select_liste("SELECT * FROM rdf_membre WHERE rdf_id=".$rdf_id." ORDER BY date,username DESC");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Réunion De Famille'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/view_rdf.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ($img_mascotte)
	$mascotte = $img_mascotte;	

if (count($tab_inscrits)==1)
	$stats = sprintf($lang['stat_rdf'],count($tab_inscrits));
else if (count($tab_inscrits) > 1)
	$stats = sprintf($lang['stats_rdf'],count($tab_inscrits));
else $stats = $lang['stats_rdf_zero'];


if ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'chat') || ($userdata['user_id'] == $val_rdf['user_id'] && $val_rdf['date']>time()))
{
	$modifier = '[&nbsp;'.$lang['Gérer ma RDF'].'&nbsp;]';
	$u_modifier =  append_sid($phpbb_root_path . 'famille/edit_rdf.php?rdf_id='.$val_rdf['rdf_id']);
}
	 
//Inscription possible jusqu'au jour j 
if($val_rdf['date']>=time())
 {
	$val_is_user = select_element("SELECT * FROM rdf_membre WHERE rdf_id = '" . $val_rdf['rdf_id'] . "' AND user_id=".$userdata['user_id'],'',false);
	if($val_is_user)
		$inscrire = 'Je suis inscrit à cette RDF';
	else $inscrire = '<a href="'.append_sid($phpbb_root_path . 'famille/view_rdf.php?mode=subcribe&rdf_id='.$rdf_id).'">Je souhaite m\'inscrire à cette RDF';
 }
else
 {
 	$inscrire = '';
 }

//Une image au pif 
$photo = select_element("SELECT * FROM rdf_photos WHERE rdf_id=".$val_rdf['rdf_id']." ORDER BY rand() LIMIT 0,1",'',false);
$image = $phpbb_root_path . 'images/rdf/photo_'.$photo['rdf_id'].'_' . $photo['photo_id'] . '.';
$ext = find_image($phpbb_root_path . 'images/rdf/photo_'.$photo['rdf_id'].'_' . $photo['photo_id'] . '.');
$image .= $ext;
$img_photo = ($photo && is_file($image)) ? $phpbb_root_path . 'functions/miniature.php?mode=rdf&rdf_id=' . $photo['rdf_id'] . '&photo_id=' . $photo['photo_id'] . "&tnH=100" : '../templates/jjgfamille/images/site/px.png' ;
					
$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Famille'],
				'RUB' => $lang['Réunion De Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'L_RDF' => $lang['Réunion De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'L_RETOUR' => $lang['retour'],
				'LIEU' => $lang['Lieu'],
				'DATE' => $lang['Date'],
				'HEURE' => $lang['Heure'],
				'DESCRIPTION' => $lang['description'],
				'VAL_LIEU' => $val_rdf['lieu'],
				'VAL_DATE' => date_unix($val_rdf['date'],'jour'),
				'VAL_HEURE' => date_unix($val_rdf['date'],'heure'),
				'VAL_DESC' => nl2br(smilies_pass(bbencode_second_pass($val_rdf['description'],$val_rdf['bbcode_uid']))),
				'STATS' => $stats,
				'L_TITLE' => $lang['RDF'].' '.$lang['prévue'].' '.sprintf($lang['à'],$val_rdf['lieu']).' '.sprintf($lang['le'],date_unix($val_rdf['date'],'date1')),
				'MODIF' => $modifier,
				'U_MODIF' => $u_modifier,
				'TITLE' => $lang['Les informations relatives à cette RDF'],
				'INSCRIRE' => $inscrire,
				'U_ORG' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_rdf['user_id']),
				'L_ORG' => $val_rdf['username'],
				'ORG_BY' => $lang['RDF organisée par'],
				'IMG' => $img_photo,
				'ALT' => sprintf($lang['photographe'],$photo['photographe']),
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

for ($i=0;$i<count($tab_inscrits);$i++)
{

	$val_user = get_user($tab_inscrits[$i]['user_id'],$tab_inscrits[$i]['username']);
	//select_element("SELECT user_id,username,user_email FROM phpbb_users WHERE user_id=".$tab_inscrits[$i]['user_id'],'',false);

	//Desinscription possible jusqu'au jour j 
	if($userdata['user_id'] == $tab_inscrits[$i]['user_id'] && $val_rdf['date']>=time() && $val_user)
 		$desinscrire = '<a href="'.append_sid($phpbb_root_path . 'famille/view_rdf.php?mode=unsubcribe&rdf_id='.$rdf_id).'">Se desincrire';
	else $desinscrire = '';

	//$username = ($val_user) ? $val_user['username'] : $tab_inscrits[$i]['username'];
	
	$template->assign_block_vars('switch_inscrits',array(
						'L_USER' => $val_user['username'],
						'DATE' => $lang['inscrit'].' '.date_unix($tab_inscrits[$i]['date'],'date'),
						'DESINSCRIT' => $desinscrire,
						)
					);
	if ($val_user)
		$template->assign_block_vars('switch_inscrits.registered',array(
						'U_USER' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_user['user_id']),
						));
}

for ($i=0;$i<count($tab_rub);$i++)
{
		
		$template->assign_block_vars('switch_rub',array(
						"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub[$i]['rub_id']),
						"L_RUB" =>  $tab_rub[$i]['name'],
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

//Gestion des recits et photos
if($val_rdf['date']< time())
{
	
	$tab_recits = select_liste("SELECT * FROM rdf_recits WHERE rdf_id= ".$val_rdf['rdf_id']."");
		if(!$tab_recits)
			$no_recit = $lang['Pas de récit disponible'];
	
	$tab_photos = select_liste("SELECT COUNT(*) nb_photos, username FROM rdf_photos WHERE rdf_id=".$val_rdf['rdf_id']." GROUP BY username");
		if(!$tab_photos)
			$no_photo = $lang['Pas de photo disponible'];
	
	$template->assign_block_vars('switch',array(
						'IMG_RECIT' => '<img src="' . $phpbb_root_path . 'images/texte.gif" border="0">',
						'RECITS' => $lang['Récits'],
						'NO_RECIT' => $no_recit,
						'IS_YOU_TO_PLAY' => $lang['it_is_you_to_play'],
						'U_ADD_RECITS' => append_sid($phpbb_root_path . 'famille/add_recit.php?rdf_id='.$val_rdf['rdf_id']),
						'L_ADD_RECITS' => $lang['add_recit'],
						'IMG_PHOTO' => '<img src="' . $phpbb_root_path . 'images/picture.gif" border="0">',
						'PHOTOS' => $lang['Photos'],
						'NO_PHOTO' => $no_photo,
						'U_ADD_PHOTOS' =>  append_sid($phpbb_root_path . 'famille/add_photo.php?rdf_id='.$val_rdf['rdf_id']),
						'L_ADD_PHOTOS' => $lang['add_photo'],
		)
	);
	
	for ($i=0;$i<count($tab_recits);$i++)
	{
		$val_user = get_user($tab_recits[$i]['user_id'],$tab_recits[$i]['username']);
		$template->assign_block_vars('switch.recits',array(
						'U_TITRE'=> append_sid('../famille/recits.php?recit_id='.$tab_recits[$i]['recit_id'].''),
						'L_TITRE'=> '<b>'.$lang['num_recit'].($i+1).'</b>',
						'PAR'=> $lang['par'],
						'U_USER'=> $u_user = append_sid('../forum/privmsg.php?mode=post&u='.$val_user['user_id'].''),
						'L_USER'=> $val_user['username'],
			)
		);
	}


	for ($i=0;$i<count($tab_photos);$i++)
	{
		$val_user = get_user($tab_photos[$i]['user_id'],$tab_photos[$i]['username']);
		$template->assign_block_vars('switch.photos',array(
						'U_PHOTO' => append_sid('../famille/photos.php?rdf_id='.$val_rdf['rdf_id'].''),
						'L_PHOTO' => $tab_photos[$i]['nb_photos'].'&nbsp;'.$lang['photos'].'&nbsp;'.$lang['de'].'&nbsp;'.$val_user['username'],
			)
		);
	}

					
}


require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('rdf','opif');
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