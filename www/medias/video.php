<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mode'] == 'add_cate')
{
	include($phpbb_root_path . 'includes/log_necessary.php');
	if ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
	{
		$error = false;
		$error_msg = '';
		
		if (!isset($_POST['title']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$cate_title = $_POST['title'];
		$cate_title = htmlentities($cate_title);
		if ($cate_title=="")
			list($error,$error_msg) = array( true , "Le champs \"Titre de la catégorie\" est obligatoire");
		
		if (!isset($_POST['description']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$cate_description = $_POST['description'];
		$cate_description = htmlentities($cate_description);
		if ($cate_description=="")
			list($error,$error_msg) = array( true , "Le champs \"Description de la catégorie\" est obligatoire");
		
		
		if (!$error)
		{
			$sql = "INSERT INTO `video_cate` (`cate_name`,`description`) VALUES ('$cate_title','$cate_description')";
			if(!mysql_query($sql))
				list($error,$error_msg) = array(true,mysql_error());
			
			if (!$error)
			{
				logger("Catégorie $cate_title ajoutée dans la rubrique vidéos");
				$url = append_sid($phpbb_root_path . "medias/video_cate.php?cate_id=" . mysql_insert_id());
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="10;url=' . $url . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Edit_cate_ok'], '<a href="' . $url . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
			
	}
}

if ($_GET['mode'] == 'add_video')
{
	include($phpbb_root_path . 'includes/log_necessary.php');
	/*
	 * Boris 11/11/2007
	 * REMOVE: Pas besoin d'être admin pour ajouter des photos
	if ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
	{
	*/
		$error = false;
		$error_msg = '';
		
		if (!isset($_POST['title']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$video_title = $_POST['title'];
		$video_title = htmlentities($video_title);
		if ($video_title=="")
			list($error,$error_msg) = array( true , "Le champs \"Titre de la vidéo\" est obligatoire");
		
		if (!isset($_POST['description']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$video_description = $_POST['description'];
		$video_description = htmlentities($video_description);
		
		
		$bbcode_uid = make_bbcode_uid();
		$video_description = bbencode_first_pass($video_description, $bbcode_uid);
		
		if (!isset($_POST['cate_id']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$cate_id = $_POST['cate_id'];
		
		if (!isset($_POST['source_id']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$source_id = $_POST['source_id'];
		
		if (!isset($_POST['code']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$code = $_POST['code'];
		if (strpos($code,'&') === false)
		{
		
		} else
		{
			$code = substr($code,0,strpos($code,'&'));
		}
		$code = htmlentities($code);
		
		if ($code=="")
			list($error,$error_msg) = array( true , "Le champs \"Code de la vidéo\" est obligatoire");
		
		
		if (!$error)
		{
			$sql = "INSERT INTO `video_video` (`title`,`code`,`cate_id`,`source_id`,`description`,`enabled`,`date`,`user_id`,`username`,`bbcode_uid`) VALUES (
					'$video_title',
					'$code',
					'$cate_id',
					'$source_id',
					'$video_description',
					'N',
					'" . date('U') . "',
					'" . $userdata['user_id'] . "',
					'" . $userdata['username'] . "',
					'$bbcode_uid'
					)";
			if(!mysql_query($sql))
				list($error,$error_msg) = array(true,mysql_error());
			else 
				$video_id = mysql_insert_id();
			if (!$error)
			{
				logger("Vidéo $video_title ajoutée dans la rubrique vidéos (à valider)");
				$sql = "UPDATE `video_cate` SET `last_add` = '" . date('U') . "' WHERE `cate_id` = '$cate_id'";
				$result = mysql_query($sql);
				if(!$result)
					list($error,$error_msg) = array(true,mysql_error());
			}
			
			if (!$error)
			{
				$url = append_sid($phpbb_root_path . "medias/video_watch.php?video_id=" . $video_id);
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="10;url=' . $url . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Add_video_ok'], '<a href="' . $url . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	//}
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='video' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//Liste des catégories
$tab_cate = select_liste("SELECT * FROM video_cate ORDER BY `cate_name`");

if ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
{
	$tab_disabled_videos = select_liste("SELECT * FROM video_video WHERE enabled = 'N'");
	if(count($tab_disabled_videos)>0)
		$liste_no_disabled_video = $lang['No_disabled_video'];
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Videos'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/video.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
	$mascotte = $img_mascotte;

$video_title = stripslashes($video_title);
$cate_description = stripslashes($cate_description);
$video_description = stripslashes(str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $video_description)));

require_once($phpbb_root_path . 'medias/menu.php');

$template->assign_vars(array(
				'L_VIDEOS' => $lang['Videos'],
				"L_VIDEO_CATEGORIES_LIST" => $lang['Video_categories_list'],
				"L_IS_YOU_TO_PLAY" => $lang['it_is_you_to_play'],
				"L_AJOUT_VIDEO" => $lang['Add_video'],
				"L_CODE" => $lang['Video_code'],
				"L_NO_VIDEO" => (count($tab_cate)>0) ? '' : $lang['No_cate'],
				"L_NO_DISABLED_VIDEO" => $liste_no_disabled_video,
				"L_RETOUR" => $lang['retour'],
				"L_SOURCE" => $lang['Source'],
				"L_CATEGORY" => $lang['categorie'],
				"L_SUBMIT" => $lang['Submit'],
				"L_TITLE" => $lang['l_titre'],
				"L_BEST_POSTERS" => $lang['Best_video_posters'],
				'L_NEED_HELP' => $lang['Need_help'],
				
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/'),
				"U_ADD_VIDEO" => append_sid($phpbb_root_path . 'medias/video.php?mode=add_video'),
				
				"VIDEO_TITLE" => $video_title,
				"VIDEO_DESCRIPTION" => $video_description,
				"CODE" => $code,
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
{
	$template->assign_block_vars('admin',array(
			"L_ADD_CATE" => $lang['add_cate'],
			"L_DESCRIPTION" => $lang['Description'],
			"L_DISABLED_VIDEOS_LIST" => $lang['Disabled_videos_list'],
			
			"U_ADD_CATE" => append_sid($phpbb_root_path . 'medias/video.php?mode=add_cate'),
			
			"CATE_TITLE" => $cate_title,
			"CATE_DESCRIPTION" => $cate_description,
						
					)
				);
}

$sql = "SELECT *,COUNT(*) nb_videos FROM `video_video` WHERE `enabled` = 'Y' GROUP BY `user_id`,`username` ORDER BY nb_videos DESC LIMIT 0,5";
$tab_posters = select_liste($sql);
for ($i=0;$i<count($tab_posters);$i++)
{
	$val_poster = get_user($tab_posters[$i]['user_id'],$tab_posters[$i]['username']);
	$template->assign_block_vars('posters',array(
					"U_USER" => append_sid($phpbb_root_path . "forum/profile.php?mode=viewprofile&u=" . $val_poster['user_id']),
					
					"USERNAME" => $val_poster['username'],
					"NB_VIDEOS" => sprintf($lang['n_videos'],$tab_posters[$i]['nb_videos']),
					)
				);
}

for ($i=0;$i<count($tab_cate);$i++)
{
	if ($i%3==0)
		$template->assign_block_vars('ligne',array());
		
	//Format date 
	if ($tab_cate[$i]['last_add']>0)
		$date = sprintf($lang['deux_points'],$lang['last_add']) . date('H:i:s d/m/Y',$tab_cate[$i]['last_add']);
	else
		$date = '';
	
	$sql = "SELECT * FROM video_video WHERE cate_id = '".$tab_cate[$i]['cate_id']."' AND `enabled` = 'Y' ORDER BY RAND() LIMIT 0,1";
	$val_video = select_element($sql,false,'');
	if ($val_video)
	{
		$sql = "SELECT * FROM `video_sources` WHERE `source_id` = '" . $val_video['source_id'] . "'";
		$val_source = select_element($sql,false,'');
		$miniature = sprintf($val_source['miniature'],$val_video['code']);
	} else
	{
		$miniature = $phpbb_root_path . 'templates/jjgfamille/images/site/px.png';
	}
	
	$template->assign_block_vars('ligne.colonne',array(
						'U_TITLE' => append_sid($phpbb_root_path . 'medias/video_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						
						'DATE' => $date,
						'IMG' => $miniature,
						
						'L_TITLE' => $tab_cate[$i]['cate_name'],
						"L_DESC" => $tab_cate[$i]['description'],
						)
					);
}

$sql = "SELECT  * FROM `video_sources` ORDER BY `source_name`";
$tab_sources = select_liste($sql);
for ($i=0;$i<count($tab_sources);$i++)
{
	$template->assign_block_vars('sources',array(
							"SOURCE_ID" => $tab_sources[$i]['source_id'],
							"SOURCE_NAME" => $tab_sources[$i]['source_name'],
							"SELECTED" => ($source_id == $tab_sources[$i]['source_id']) ? ' SELECTED' : '',
							)
				);
							
}

for ($i=0;$i<count($tab_cate);$i++)
{
	$template->assign_block_vars('cate',array(
							"CATE_ID" => $tab_cate[$i]['cate_id'],
							"CATE_NAME" => $tab_cate[$i]['cate_name'],
							"SELECTED" => ($cate_id == $tab_cate[$i]['cate_id']) ? ' SELECTED' : '',
							)
				);
							
}

for ($i=0;$i<count($tab_disabled_videos);$i++)
{
	$date = date('H:i:s d/m/Y',$tab_disabled_videos[$i]['date']);
	
	$sql = "SELECT * FROM `video_sources` WHERE `source_id` = '" . $tab_disabled_videos[$i]['source_id'] . "'";
	$val_source = select_element($sql,false,'');
	$miniature = sprintf($val_source['miniature'],$tab_disabled_videos[$i]['code']);
	
	$template->assign_block_vars('admin.disabled',array(
						'U_VIDEO' => append_sid($phpbb_root_path . 'medias/video_watch.php?video_id='.$tab_disabled_videos[$i]['video_id']),
						
						'DATE' => $date,
						'IMG' => $miniature,
						
						'TITLE' => $tab_disabled_videos[$i]['title'],
						)
					);
					
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('video','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );


$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');


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

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>