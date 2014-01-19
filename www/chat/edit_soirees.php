<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'webchat');
$actual_rub = 'soirees';
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_CHAT);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/reserved_access.'.$phpEx);

$theme_id = $_GET['theme_id'];

if ($_GET['mode'] == 'edit')
{
	
	if (!isset($_POST['name']) || $_POST['name'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Thème de la soirée']));
	else $name = $_POST['name'];
	
	if (!isset($_POST['description']) || $_POST['description'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['description']));
	else $description = $_POST['description'];
	
	if (!isset($_POST['date']) || $_POST['date'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Jour de la soirée']));
	else $date = $_POST['date'];
	
	if (!isset($_POST['heure']) || $_POST['heure'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Heure de la soirée']));
	else $heure= $_POST['heure'];
	
	if (!$error && !checkdate(substr($date,3,2),substr($date,0,2),substr($date,6,4)))
		list($error,$error_msg) = array(true,sprintf($lang['invalid_date'],$date));
	else $date_bdd = date('U',mktime(substr($heure,0,2),substr($heure,3,2),0,substr($date,3,2),substr($date,0,2),substr($date,6,4)));
		
	if (!$error)
	{
		$bbcode_uid = make_bbcode_uid();
		$description = bbencode_first_pass($description, $bbcode_uid);
		
		$sql = "UPDATE soirees SET theme='$name',description='$description',bbcode_uid='$bbcode_uid',date='$date_bdd' WHERE theme_id=".$theme_id;
		logger('Modification d\'un theme de soirée "' . $name . '"');
		mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "chat/edit_soirees." . $phpEx . "?theme_id=".$theme_id) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Upload_soirees_ok'], '<a href="' . append_sid($phpbb_root_path . "chat/edit_soirees." . $phpEx . "?theme_id=".$theme_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} 
}

if ($_GET['mode'] == 'upload')
{

	$error = false;
	$error_msg = '';
			
	$savefile= "log/theme_".$theme_id.".txt";
		
	if(is_file($savefile))
		unlink($savefile);
		
	if (!move_uploaded_file($_FILES['userfile']['tmp_name'],$savefile)) 
		list($error,$error_msg) = array( true , "Erreur d\'enregistrement");
	
	if(!$error)
	{
		logger("Ajout d'un fichier log pour le theme N°$theme_id pour le chat");
		$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "chat/edit_soirees." . $phpEx . "?theme_id=".$theme_id) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Upload_logfile_ok'], '<a href="' . append_sid($phpbb_root_path . "chat/edit_soirees." . $phpEx . "?theme_id=".$theme_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);		
	}

}

if ($_GET['mode'] == 'supp_log')
{
	unlink("log/theme_".$theme_id.".txt");
	logger("Suppression d'un fichier log pour le theme N°$theme_id pour le chat");
	$template->assign_vars(array(
	'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "chat/edit_soirees." . $phpEx . "?theme_id=".$theme_id) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['Delete_supplog_ok'], '<a href="' . append_sid($phpbb_root_path . "chat/edit_soirees." . $phpEx . "?theme_id=".$theme_id) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);			
}

if ($_GET['mode'] == 'supp_theme')
{

	if(is_file("log/theme_".$theme_id.".txt"))
		unlink("log/theme_".$theme_id.".txt");
	
	$sql = "DELETE FROM soirees WHERE theme_id=".$theme_id;
	logger("Suppression du theme de soirée N°$theme_id");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		
	$template->assign_vars(array(
	'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['Delete_supptheme_ok'], '<a href="' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
		
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='chat' ORDER BY user_id");

$val_soiree = select_element("SELECT * FROM soirees WHERE theme_id = ".$theme_id."",'',false);

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array('body' => 'site/chat/edit_soirees.tpl'));

if(is_file('log/theme_'.$theme_id.'.txt'))
{
	$is_log = $lang['Il existe un fichier log pour cette soirée'];

	$l_confirm_supp_log = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['log_file']))));
	$l_supp_log = sprintf($lang['delete'],sprintf($lang['le'],$lang['log_file']));
	$u_supp_log = append_sid($phpbb_root_path . 'chat/edit_soirees.php?mode=supp_log&theme_id='.$theme_id);
}



$template->assign_vars(array(
				'NOM_RUB' => $lang['admin_chat'],
				'RESPONSABLES' => $lang['Responsables'],
				'MODIF' => $lang['Modifier une soirée'],
				'NOM' => $lang['Thème de la soirée'],
				'DESC' => $lang['description'],
				'DAY' => $lang['Jour de la soirée'],
				'HOUR' => $lang['Heure de la soirée'],
				'VAL_NOM' => $val_soiree['theme'],
				'VAL_DESC' => str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_soiree['bbcode_uid'] . '/s', '', $val_soiree['description'])),
				'VAL_DAY' => date_unix($val_soiree['date'],'jour'),
				'VAL_HOUR' => date_unix($val_soiree['date'],'heure'),
				'L_SUBMIT' => $lang['Submit'],
				'U_FORM' => append_sid($phpbb_root_path . 'chat/edit_soirees.php?mode=edit&theme_id='.$theme_id),
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'chat/soirees.php'),
				'L_CONFIRM_SUPP_THEME' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['soirée'])))),
				'L_SUPP_THEME' => sprintf($lang['delete'],sprintf($lang['la'],$lang['soirée'])),
				'U_SUPP_THEME' => append_sid($phpbb_root_path . 'chat/edit_soirees.php?mode=supp_theme&theme_id='.$theme_id),
				'L_CONFIRM_SUPP_LOG' => $l_confirm_supp_log,
				'L_SUPP_LOG' => $l_supp_log,
				'U_SUPP_LOG' => $u_supp_log,
				'GESTION_LOG' => $lang['Ajout/Suppression de fichier log'],
				'LOG'=> $lang['log_file'],	
				'U_FORM1' => append_sid($phpbb_root_path . 'chat/edit_soirees.php?mode=upload&theme_id='.$theme_id),
				'IS_LOG' => $is_log,
			)
);

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

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>