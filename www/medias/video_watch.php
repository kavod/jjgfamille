<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
define('FORUM_ID','35');
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

if (!isset($_GET['video_id']) || $_GET['video_id'] == '')
	header("Location:" . $phpbb_root_path . "medias/video.php");
$video_id = $_GET['video_id'];
$val_video = select_element("SELECT * FROM `video_video` WHERE `video_id` = '$video_id'",'Vidéo inconnue',true);

if ($_GET['mode'] == 'supp_video')
{
	include($phpbb_root_path . 'includes/log_necessary.php');
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
	{
		$val_video = select_element("SELECT * FROM `video_video` WHERE `video_id` = '$video_id'",'Vidéo inexistante',true);
	
		$sql = "DELETE FROM `video_video` WHERE `video_id` = '$video_id'";
		if(!mysql_query($sql))
			message_die(CRITICAL_MESSAGE, mysql_error());
		else
			logger("Suppression de la vidéo " . $val_video['title']);
		
		$url = append_sid($phpbb_root_path . "medias/video_cate.php?cate_id=" . $val_video['cate_id']);
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="10;url=' . $url . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Delete_video_ok'], '<a href="' . $url . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		$message .=  '<br /><br />' . $lang['Sorry_auth_delete_video'];
		message_die(GENERAL_MESSAGE, $message);
	}
}

if ($_GET['mode'] == 'edit_video')
{
	include($phpbb_root_path . 'includes/log_necessary.php');
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
	{
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
		$code = htmlentities($code);
		if ($code=="")
			list($error,$error_msg) = array( true , "Le champs \"Code de la vidéo\" est obligatoire");
		
		if (!isset($_POST['enabled']))
			list($error,$error_msg) = array( true , "Erreur de transmission de variables");
		$enabled = $_POST['enabled'];
		
		if (!$error)
		{
			$sql = "UPDATE `video_video`
				SET
					`title`='$video_title',
					`code`='$code',
					`cate_id`='$cate_id',
					`source_id`='$source_id',
					`description`='$video_description',
					`enabled`='$enabled',
					`bbcode_uid`='$bbcode_uid'
				WHERE
					`video_id` = '$video_id'";
					
			if(!mysql_query($sql))
				list($error,$error_msg) = array(true,mysql_error());
			
			if (!$error)
			{
				logger("Vidéo $video_title modifiée dans la rubrique vidéos");
				$url = append_sid($phpbb_root_path . "medias/video_watch.php?video_id=" . $video_id);
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="10;url=' . $url . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Edit_video_ok'], '<a href="' . $url . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	} else
	{
		$message .=  '<br /><br />' . $lang['Sorry_auth_edit_video'];
		message_die(GENERAL_MESSAGE, $message);
	}
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='video' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Videos'] . ' :: ' . $val_video['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/video_watch.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
	$mascotte = $img_mascotte;

if ($_GET['mode'] == 'edit_video')
{
	$video_title = stripslashes($video_title);
	$video_description = stripslashes(str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_video['bbcode_uid'] . '/s', '', $video_description)));
	$code = stripslashes($code);
} else
{
	$video_title = $val_video['title'];
	$video_description = stripslashes(str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_video['bbcode_uid'] . '/s', '', $val_video['description'])));
	$code = $val_video['code'];
	$cate_id = $val_video['cate_id'];
	$source_id = $val_video['source_id'];
}
require_once($phpbb_root_path . 'medias/menu.php');

$val_source = select_element("SELECT * FROM `video_sources` WHERE `source_id` = '" . $val_video['source_id'] . "'",'Source introuvable',true);
$html_code = sprintf($val_source['code'],$val_video['code'],$val_video['code']);

$val_author = get_user($val_video['user_id'],$val_video['username']);

$template->assign_vars(array(
				'L_VIDEOS' => $lang['Videos'],
				"L_AJOUT_VIDEO" => $lang['Add_video'],
				"L_SUBMIT" => $lang['Submit'],
				"L_TITLE" => $lang['l_titre'],
				"L_DESCRIPTION" => $lang['Description'],
				"L_NO_VIDEO" => (count($tab_cate)>0) ? '' : $lang['No_cate'],
				"L_NO_DISABLED_VIDEO" => $liste_no_disabled_video,
				"L_RETOUR" => $lang['retour'],
				"L_DATE_ADDED" => $lang['Added_the'],
				"L_FOUND_BY" => $lang['Found_by'],
				
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/video_cate.php?cate_id=' . $val_video['cate_id']),
				"U_USER" => append_sid($phpbb_root_path . "forum/profile.php?mode=viewprofile&u=" . $val_author['user_id']),
				
				"TITLE" => $val_video['title'],
				"HTML_CODE" => $html_code,
				"VIDEO_TITLE" => $val_video['title'],
				"DATE_ADDED" => date('H:i:s d/m/Y',$val_video['date']),
				"USERNAME" => $val_author['username'],
				"DESCRIPTION" => nl2br(bbencode_second_pass($val_video['description'],$val_video['bbcode_uid'])),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
{
		$template->assign_block_vars('admin',array(
						"L_TITLE" => $lang['l_titre'],
						"L_DESCRIPTION" => $lang['Description'],
						"L_SUBMIT" => $lang['Submit'],
						"L_EDIT_VIDEO" => $lang['Edit_video'],
						"L_CATEGORY" => $lang['categorie'],
						"L_SOURCE" => $lang['Source'],
						"L_CODE" => $lang['Video_code'],
						"L_ENABLED" => $lang['Enabled'],
						"L_DISABLED" => $lang['Disabled'],
						"L_VIDEO_DELETION" => $lang['Video_deletion'],
						"L_SUPP_CONFIRM" => addslashes(sprintf($lang['Confirm'],$lang['Delete_video'])),
						"L_SUPP_VIDEO" => $lang['Delete_video'],
						'L_VIDEO_TOPIC' => $lang['Video_topic'],
						'L_VIEW_TOPIC' => ($val_video['topic_id'] > 0) ? $lang['View_topic'] : '',
						'L_CREATE_TOPIC' => $lang['Create_topic'],
						
						"U_EDIT_VIDEO" => append_sid($phpbb_root_path . 'medias/video_watch.php?mode=edit_video&video_id=' . $video_id),
						"U_SUPP_VIDEO" => append_sid($phpbb_root_path . 'medias/video_watch.php?mode=supp_video&video_id=' . $video_id),
						'U_POST_TOPIC' => append_sid($phpbb_root_path . 'medias/posting.php?video_id=' . $video_id),
						'U_TOPIC' => ($val_video['topic_id'] > 0) ? append_sid($phpbb_root_path . 'forum/viewtopic.php?t=' . $val_video['topic_id']) : '',
						'U_VIDEO' => append_sid('http://' . $_SERVER['HTTP_HOST'] . '/medias/video_watch.php?video_id=' . $video_id),
						
						"VIDEO_TITLE" => $video_title,
						"CODE" => $code,
						"VIDEO_DESCRIPTION" => $video_description,
						"ENABLED_CHECKED" => ($val_video['enabled']=='Y') ? " CHECKED" : '',
						"DISABLED_CHECKED" => ($val_video['enabled']=='Y') ? '' : " CHECKED",
						'VIDEO_USER_ID' => $val_video['user_id'],
						'FORUM_ID' => FORUM_ID,
						)
					);
		$template->assign_block_vars(($val_video['topic_id'] > 0) ? 'admin.topic' : 'admin.no_topic',array());


		$sql = "SELECT  * FROM `video_sources` ORDER BY `source_name`";
		$tab_sources = select_liste($sql);
		for ($i=0;$i<count($tab_sources);$i++)
		{
			$template->assign_block_vars('admin.sources',array(
					"SOURCE_ID" => $tab_sources[$i]['source_id'],
					"SOURCE_NAME" => $tab_sources[$i]['source_name'],
					"SELECTED" => ($source_id == $tab_sources[$i]['source_id']) ? ' SELECTED' : '',
					)
				);
									
		}
		
		//Liste des catégories
		$tab_cate = select_liste("SELECT * FROM video_cate ORDER BY `cate_name`");
		for ($i=0;$i<count($tab_cate);$i++)
		{
			$template->assign_block_vars('admin.cate',array(
					"CATE_ID" => $tab_cate[$i]['cate_id'],
					"CATE_NAME" => $tab_cate[$i]['cate_name'],
					"SELECTED" => ($cate_id == $tab_cate[$i]['cate_id']) ? ' SELECTED' : '',
					)
				);
									
		}
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
