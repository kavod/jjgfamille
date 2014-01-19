<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'webchat');
$actual_rub = 'help';
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

if ($_GET['mode'] == 'modif')
{
	$error = false;
	$error_msg = '';
			
	if (!isset($_POST['message']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$help = $_POST['message'];
	
	$bbcode_uid = make_bbcode_uid();
	$help = bbencode_first_pass($help,$bbcode_uid);
	
	if (!$error)
	{
		$select_help = select_liste("SELECT id FROM help_chat");
		if (count($select_help)>0)
			$sql_update = "UPDATE help_chat SET help ='".$help."',bbcode_uid='".$bbcode_uid."'";
		else
			$sql_update = "INSERT INTO help_chat (help,bbcode_uid) VALUES ('$help','$bbcode_uid')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
	
		if (!$error)
		{
			logger("Modification de l'aide du chat famille");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("help." . $phpEx) . '">')
				);
				$message =  sprintf($lang['Upload_help_chat_ok'], '<a href="' . append_sid("help." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='chat' ORDER BY user_id");

//Help
$val_help = select_element("SELECT * FROM help_chat",false,'');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array('body' => 'site/chat/help.tpl'));

$template->assign_vars(array(
				
				'NOM_RUB' => $lang['aide_chat'],
				'RESPONSABLES' =>$lang['Responsables'],	
				"HELP" => nl2br(bbencode_second_pass($val_help['help'],$val_help['bbcode_uid'])),
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'chat/'),
			)
);
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'chat'))
{
	
		$template->assign_block_vars('switch_admin',array(
						"NOM_RUB" => $lang['admin_chat'],
						"L_CONTENU" => $lang['Description'],
						"HELP" => preg_replace('/\:(([a-z0-9]:)?)' . $val_help['bbcode_uid'] . '/s', '', $val_help['help']),
						"U_FORM" => append_sid($phpbb_root_path . 'chat/help.php?mode=modif'),
						"L_SUBMIT" => $lang['Submit'],
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