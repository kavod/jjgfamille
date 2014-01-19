<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'webchat');
$actual_rub='chat';
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

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='chat' ORDER BY user_id");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Le chat'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array('body' => 'site/chat/index.tpl'));

if($userdata['username']=='Anonymous')
	$nickname = 'famillien';
else $nickname = $userdata['username'];

$template->assign_vars(array(
				'NOM_RUB' => $lang['Le chat'],	
				'RESPONSABLES' => $lang['Responsables'],
				'U_FORM1' => 'http://webchat.fr.worldnet.net/irc.cgi',
				'U_FORM2' => '../webchat/SimpleApplet.php',
				'NICKNAME' => $nickname,
				'IMG' => '../images/grosminet.jpg',
				'ALT' => $lang['Welcome chat'],
				'TO_CONNECT' => $lang['to connect'],
				'ENTER_PSEUDO' => $lang['enter nick'], 
				'CLICK_ON' => $lang['Cliquez sur'], 
				'NB' => $lang['NB'],
				'ENTER_IRC' => $lang['password_irc'], 
				'NON_OBLIGATOIRE' => $lang['non obligatoire'],
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

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>