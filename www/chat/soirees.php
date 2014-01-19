<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'webchat');
$actual_rub = 'soirees';
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/emailer.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_CHAT);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mail'] == 'yes')
{

	include($phpbb_root_path . 'includes/log_necessary.'.$phpEx);
	
	$sql = "UPDATE phpbb_users SET chat_mail = 'Y' WHERE user_id=".$userdata['user_id'];
	logger($userdata['username']." désire recevoir un mail afin d' etre prevenu des prochaines soirées chat");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="6;url=' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['chat_mail_yes_ok'], '<a href="' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mail'] == 'no')
{

	include($phpbb_root_path . 'includes/log_necessary.'.$phpEx);
	
	$sql = "UPDATE phpbb_users SET chat_mail = 'N' WHERE user_id=".$userdata['user_id'];
	logger($userdata['username']." ne désire plus recevoir un mail pour les prochaines soirées chat");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="6;url=' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['chat_mail_no_ok'], '<a href="' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}
	

if ($_GET['mode'] == 'add')
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
		
		$sql = "INSERT INTO soirees (theme,description,bbcode_uid,date) 
				VALUES ('$name','$description','$bbcode_uid','$date_bdd')";
		logger('Ajout d\'un theme de soirée "' . $name . '"');
		mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		
		// Envoi du mail aux familliens qui veulent recevoir le mail
		$sql_responsable = "SELECT * FROM  phpbb_users  WHERE chat_mail = 'Y'";
		$result_responsable = mysql_query($sql_responsable) or list($error,$error_msg) = array( true , "Erreur de la base de données<br />" . $sql_responsable);
			
		$msg = "Une nouvelle soirée à thème est prevue sur le chat famille.\nLa soirée aura comme thème : ".$name." et aura lieu le ".$date." à ".$heure.".\n\nPour nous rejoindre cliquez sur le lien suivant\nhttp://" . $board_config['server_name'] . "/chat/index.php \n\nSi vous manquer la soirée, vous aurez la possibilité d'en télécharger les conversations disponibles dans les prochains jours suivants la soirée en cliquant sur le lien suivant\nhttp://" . $board_config['server_name'] . "/chat/soirees.php?mode=archives\n\nPour ne plus recevoir cet email cliquez su le lien suivant\nhttp://" . $board_config['server_name'] . "/chat/soirees.php?mail=no\n";
			
		while ($val_responsable = mysql_fetch_array($result_responsable))
		 {

			$emailer = new emailer($board_config['smtp_delivery']);
			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);
			$emailer->use_template('email_notify',"french");
			$emailer->email_address($val_responsable['user_email']);
			$emailer->set_subject($lang['Notification_subject']);
					
			$emailer->assign_vars(array(
				'SUBJECT' => "Nouvelle soirée sur le chat famille",
				'USERNAME' => $val_responsable['username'], 
				'EMAIL_SIG' => "-- \nL'équipe d'administration de JJG Famille",
				'MESSAGE' => $msg,
			));

			$emailer->send();
			$emailer->reset();
	
		}
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Upload_soirees_ok'], '<a href="' . append_sid($phpbb_root_path . "chat/soirees." . $phpEx) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} 
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='chat' ORDER BY user_id");

if(!isset($_GET['mode']))
{
	$tab_theme = select_liste("SELECT * FROM soirees WHERE date >= ".time()." ORDER BY date");
	if(count($tab_theme)==0)
		$no_theme = '<br>&nbsp;&nbsp;'.$lang['Il n\'y a aucune soirée de prévue prochainement'];
	
	$prochainement = $lang['prochainement'];
	$archives = $lang['go_to_the_archives'];
	$u_archives = append_sid($phpbb_root_path . 'chat/soirees.php?mode=archives');
}else
{
	if($_GET['mode'] == 'archives')
	{
		$tab_theme = select_liste("SELECT * FROM soirees WHERE date < ".time()." ORDER BY date DESC");	
		if(count($tab_theme)==0)
			$no_theme = '<br>&nbsp;&nbsp;'.$lang['Il n\'y a aucune soirée archivée'];
		$prochainement = $lang['Archives'];
		$archives = $lang['Voir les prochaines soirées'];
		$u_archives = append_sid($phpbb_root_path . 'chat/soirees.php?mode=next');
	}
	else
	{
		$tab_theme = select_liste("SELECT * FROM soirees WHERE date >= ".time()." ORDER BY date");
		if(count($tab_theme)==0)
			$no_theme = '<br>&nbsp;&nbsp;'.$lang['Il n\'y aucune soirée de prévue prochainement'];
		$prochainement = $lang['prochainement'];
		$archives = $lang['go_to_the_archives'];
		$u_archives = append_sid($phpbb_root_path . 'chat/soirees.php?mode=archives');
	}
}

if(!isset($_GET['mode']) || $_GET['mode']=='next')
	$next = true;

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array('body' => 'site/chat/soirees.tpl'));

if($userdata['username']=='Anonymous')
{
	$mail = sprintf($lang['chat_mail_log'],append_sid($phpbb_root_path . 'forum/profile.php?mode=register'),append_sid($phpbb_root_path . 'forum/login.php?redirect=../chat/soirees.php'));
}else
{
	if($userdata['chat_mail']=='Y')
	{
		$mail = sprintf($lang['chat_mail_no'],append_sid($phpbb_root_path . 'chat/soirees.php?mail=no'));
	}
	if($userdata['chat_mail']=='N')
	{
		$mail = sprintf($lang['chat_mail_yes'],append_sid($phpbb_root_path . 'chat/soirees.php?mail=yes'));
	}
	
}

$template->assign_vars(array(
				
				'NOM_RUB' => $lang['Soirees à themes'],
				'RESPONSABLES' => $lang['Responsables'],	
				'L_PROCHAINEMENT' => $prochainement,
				'L_ARCHIVES' => $archives, 
				'U_ARCHIVES' => $u_archives,
				'NO_THEME' => $no_theme,
				'MAIL' => $mail,
			)
);

for ($i=0;$i<count($tab_theme);$i++)
{
	
	if($_GET['mode'] == 'archives' && is_file('log/theme_' . $tab_theme[$i]['theme_id'] . '.txt'))
	{	
		$l_log = $lang['Télécharger les logs de cette soirée'];
		$u_log = append_sid($phpbb_root_path . 'chat/download.php?theme_id='.$tab_theme[$i]['theme_id']);
	}else
	{
		$l_log = '';
		$u_log = '';
	}
	
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'chat'))
	 {
		$modifier = '[&nbsp;'.$lang['Modifier'].'&nbsp;]';
		$u_modifier =  append_sid($phpbb_root_path . 'chat/edit_soirees.php?theme_id='.$tab_theme[$i]['theme_id']);
		
	 }
	
	$template->assign_block_vars('switch_theme',array(
						
						'DATE' => date_unix($tab_theme[$i]['date'],'date1'),
						'THEME' => $tab_theme[$i]['theme'],
						'TEXTE' => bbencode_second_pass($tab_theme[$i]['description'],$tab_theme[$i]['bbcode_uid']),
						'L_LOG' => $l_log,
						'U_LOG' => $u_log,
						'MODIF' => $modifier,
						'U_MODIF' => $u_modifier,
						)
					);
	
}

if ( ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'chat')) && $next )
 {
			$template->assign_block_vars('switch_admin',array(
						'NOM_RUB' => $lang['admin_chat'],
						'AJOUT' => $lang['Ajouter une prochaine soirée'],
						'NOM' => $lang['Thème de la soirée'],
						'DESC' => $lang['description'],
						'DAY' => $lang['Jour de la soirée'],
						'HOUR' => $lang['Heure de la soirée'],
						'L_SUBMIT' => $lang['Submit'],
						'U_FORM' => append_sid($phpbb_root_path . 'chat/soirees.php?mode=add'),
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