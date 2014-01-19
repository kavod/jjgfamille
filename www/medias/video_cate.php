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

if (!isset($_GET['cate_id']) || $_GET['cate_id'] == '')
	header("Location:" . $phpbb_root_path . "medias/video.php");
$cate_id = $_GET['cate_id'];
$val_cate = select_element("SELECT * FROM `video_cate` WHERE `cate_id` = '$cate_id'",'rubrique inconnue',true);

$array_order = array(
			array('date','adding_date','DESC'),
			array('title','titre','ASC')
		);

$val_order == '';
for ($i=0;$i<count($array_order);$i++)
{
	if ($_GET['order'] == $array_order[$i][0])
	{
		$val_order = $array_order[$i];
		break;
	}
}
if ($val_order == '')
	$val_order = $array_order[0];

if ($_GET['mode'] == 'supp_cate')
{
	include($phpbb_root_path . 'includes/log_necessary.php');
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
	{
		$val_cate = select_element("SELECT * FROM `video_cate` WHERE `cate_id` = '$cate_id'",'Catégorie inexistante',true);
	
		
		$sql = "DELETE FROM `video_video` WHERE `cate_id` = '$cate_id'";
		if(!mysql_query($sql))
			message_die(CRITICAL_MESSAGE, mysql_error());
		else
		{
			$sql = "DELETE FROM `video_cate` WHERE `cate_id` = '$cate_id'";
			if(!mysql_query($sql))
				message_die(CRITICAL_MESSAGE, mysql_error());
			else
				logger("Suppression de la catégorie vidéo " . $val_cate['cate_name']);
			
			$url = append_sid($phpbb_root_path . "medias/video.php");
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . $url . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Delete_video_cate_ok'], '<a href="' . $url . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	} else
	{
		$message .=  '<br /><br />' . $lang['Sorry_auth_delete_cate'];
		message_die(GENERAL_MESSAGE, $message);
	}
}

if ($_GET['mode'] == 'edit_cate')
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
			$sql = "UPDATE `video_cate` 
				SET 	`cate_name` = '$cate_title',
					`description`='$cate_description' 
				WHERE `cate_id` = '$cate_id'";
			logger("Catégorie $cate_title modifiée dans la rubrique vidéos");
			if(!mysql_query($sql))
				list($error,$error_msg) = array(true,mysql_error());
			
			if (!$error)
			{
				$url = append_sid($phpbb_root_path . "medias/video_cate.php?cate_id=" . $cate_id);
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="10;url=' . $url . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Add_cate_ok'], '<a href="' . $url . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
			
	}
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='video' ORDER BY `user_id`");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//Liste des vidéos
$tab_videos = select_liste("SELECT * FROM `video_video` WHERE `cate_id` = '$cate_id' AND `enabled` = 'Y' ORDER BY `" . $val_order[0] . "` ". $val_order[2]);
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Videos'] . ' :: ' . $val_cate['cate_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/video_cate.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
	$mascotte = $img_mascotte;

if ($_GET['mode'] == 'edit_cate')
{
	$cate_title = stripslashes($cate_title);
	$cate_description = stripslashes($cate_description);
} else
{
	$cate_title = $val_cate['cate_name'];
	$cate_description = $val_cate['description'];
}
require_once($phpbb_root_path . 'medias/menu.php');

for ($i=0;$i<count($array_order);$i++)
{
	${'order_' . $array_order[$i][0]} = ($val_order[0] == $array_order[$i][0]) ? 
		sprintf('<b>%s</b>',$lang[$array_order[$i][1]]) : 
		sprintf('<a href="%s">%s</a>', append_sid($phpbb_root_path . 'medias/video_cate.php?cate_id=' . $cate_id . '&amp;order=' . $array_order[$i][0]), $lang[$array_order[$i][1]]);
}
/*$order_date = ($val_order[0] == 'date') ? 
	sprintf('<b>%s</b>',$lang['adding_date']) : 
	sprintf('<a href="%s">%s</a>', append_sid($phpbb_root_path . 'medias/video_cate.php?cate_id=' . $cate_id . '&amp;order=' . 'date'), $lang['adding_date']);

$order_title = ($val_order[0] == 'title') ? 
	sprintf('<b>%s</b>',$lang['titre']) : 
	sprintf('<a href="%s">%s</a>', append_sid($phpbb_root_path . 'medias/video_cate.php?cate_id=' . $cate_id . '&amp;order=' . 'title'), $lang['titre']);*/

$template->assign_vars(array(
				'L_VIDEOS' => $lang['Videos'],
				"L_VIDEO_LIST" => sprintf($lang['Video_list'],$val_cate['cate_name']),
				"L_IS_YOU_TO_PLAY" => $lang['it_is_you_to_play'],
				"L_AJOUT_VIDEO" => $lang['Add_video'],
				"L_SUBMIT" => $lang['Submit'],
				"L_TITLE" => $lang['l_titre'],
				"L_DESCRIPTION" => $lang['Description'],
				"L_CODE" => $lang['Video_code'],
				"L_NO_VIDEO" => (count($tab_cate)>0) ? '' : $lang['No_cate'],
				"L_NO_DISABLED_VIDEO" => $liste_no_disabled_video,
				"L_RETOUR" => $lang['retour'],
				"L_SOURCE" => $lang['Source'],
				"L_CATEGORY" => $lang['categorie'],
				"L_ADD_CATE" => $lang['add_cate'],
				'L_ORDER_BY' => sprintf($lang['deux_points'],$lang['Order_by']),
				'L_ADD_DATE' => $order_date,
				'L_TITLE' => $order_title,
				'L_NEED_HELP' => $lang['Need_help'],
				
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/video.php'),
				"U_ADD_VIDEO" => append_sid($phpbb_root_path . 'medias/video.php?mode=add_video'),
				
				"VIDEO_TITLE" => $video_title,
				"VIDEO_DESCRIPTION" => $video_description,
				"CODE" => $code,
			)
);


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'video'))
{

		
		$template->assign_block_vars('admin',array(
						"L_EDIT_CATE" => $lang['Edit_cate'],
						"L_TITLE" => $lang['l_titre'],
						"L_DESCRIPTION" => $lang['Description'],
						"L_SUBMIT" => $lang['Submit'],
						"L_CATE_DELETION" => $lang['Cate_deletion'],
						"L_SUPP_CONFIRM" => addslashes(sprintf($lang['Confirm'],$lang['Delete_cate'] . ' ' . $lang['and_all_videos'])),
						"L_CATE_VIDEO" => $lang['Delete_cate'],
						
						"U_EDIT_CATE" => append_sid($phpbb_root_path . 'medias/video_cate.php?mode=edit_cate&cate_id=' . $cate_id),
						"U_SUPP_CATE" => append_sid($phpbb_root_path . 'medias/video_cate.php?mode=supp_cate&cate_id=' . $cate_id),
						
						"CATE_TITLE" => $cate_title,
						"CATE_DESCRIPTION" => $cate_description,
						)
					);
}

for ($i=0;$i<count($tab_videos);$i++)
{
	if ($i%3==0)
		$template->assign_block_vars('ligne',array());
		
	//Format date 
	if ($tab_videos[$i]['date']>0)
		$date = date('H:i:s d/m/Y',$tab_videos[$i]['date']);
	else
		$date = '';
	
	$sql = "SELECT * FROM `video_sources` WHERE `source_id` = '" . $tab_videos[$i]['source_id'] . "'";
	$val_source = select_element($sql,false,'');
	$miniature = sprintf($val_source['miniature'],$tab_videos[$i]['code']);
	
	$template->assign_block_vars('ligne.colonne',array(
						'U_TITLE' => append_sid($phpbb_root_path . 'medias/video_watch.php?video_id='.$tab_videos[$i]['video_id']),
						
						'DATE' => $date,
						'IMG' => $miniature,
						
						'L_TITLE' => $tab_videos[$i]['title'],
						"L_DESC" => $tab_videos[$i]['description'],
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

//Liste des catégories
$tab_cate = select_liste("SELECT * FROM video_cate ORDER BY `cate_name`");
for ($i=0;$i<count($tab_cate);$i++)
{
	$template->assign_block_vars('cate',array(
							"CATE_ID" => $tab_cate[$i]['cate_id'],
							"CATE_NAME" => $tab_cate[$i]['cate_name'],
							"SELECTED" => ($cate_id == $tab_cate[$i]['cate_id']) ? ' SELECTED' : '',
							)
				);
							
}

/*for ($i=0;$i<count($tab_disabled_videos);$i++)
{

	$template->assign_block_vars('ligne.colonne',array(
						'U_TITLE' => append_sid($phpbb_root_path . 'medias/video_cate.php?cate_id='.$tab_disabled_videos[$i]['cate_id']),
						
						'DATE' => $date,
						
						'L_TITLE' => $tab_disabled_videos[$i]['title'],
						"L_DESC" => $tab_disabled_videos[$i]['description'],
						)
					);
					
}*/

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