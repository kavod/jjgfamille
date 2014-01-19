<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'rdf';
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

include($phpbb_root_path . 'includes/log_necessary.php');

$rdf_id = $_GET['rdf_id'];

//Sélection de la rdf
$val_rdf = select_element("SELECT * FROM rdf WHERE rdf_id=".$rdf_id,'',false);

//Les personnes autorisés a voir cette page sont les admins,les responsables et l'organisateur (seulement aux temps t<= date_rdf)
if ((!$userdata['user_level'] == ADMIN && !is_responsable($userdata['user_id'],'rdf')) && $userdata['user_id'] <> $val_user['user_id'] && ($userdata['user_id'] == $val_user['user_id'] || $val_rdf['date']<=time()))
{
	redirect(append_sid($phpbb_root_path . "famille/rdf.php"));
}

if ($_GET['mode'] == 'edit')
{
	$error = false;
	$error_msg = '';

	if (!isset($_POST['lieu']) || $_POST['lieu'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Lieu']));
	else $lieu = $_POST['lieu'];
	
	if (!isset($_POST['description']) || $_POST['description'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['description']));
	else $description = $_POST['description'];
	
	if (!isset($_POST['date']) || $_POST['date'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Date']));
	else $date = $_POST['date'];
	
	if (!isset($_POST['heure']) || $_POST['heure'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Heure']));
	else $heure= $_POST['heure'];
	
	if (!$error && !checkdate(substr($date,3,2),substr($date,0,2),substr($date,6,4)))
		list($error,$error_msg) = array(true,sprintf($lang['invalid_date'],$date));
	else $date_bdd = date('U',mktime(substr($heure,0,2),substr($heure,3,2),0,substr($date,3,2),substr($date,0,2),substr($date,6,4)));
				
	$bbcode_uid = make_bbcode_uid();
	$description = delete_html($description);
	$description=bbencode_first_pass($description,$bbcode_uid);
		
	if (!$error)
	{
		$sql_update = "UPDATE rdf SET lieu='".$lieu."',date='".$date_bdd."',description='".$description."',bbcode_uid='".$bbcode_uid."' WHERE rdf_id = '$rdf_id'";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
		
		
		if (!$error)
		{
			logger("Modifcication  d'une reunion de famille N°$rdf_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_rdf." . $phpEx ."?rdf_id=".$rdf_id) . '">')
			);
			$message =  sprintf($lang['Upload_rdf_ok'], '<a href="' . append_sid("edit_rdf." . $phpEx ."?rdf_id=".$rdf_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

if ($_GET['mode'] == 'sendmail')
{
	
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['message']) || $_POST['message'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Message']));
	else $message_rdf = $_POST['message'];
	
	if (!$error)
	{
		
		// Envoi du mail aux familliens inscrits
		$sql_mail = "SELECT * FROM rdf_membre WHERE rdf_id=".$rdf_id;
		$result_mail = mysql_query($sql_mail) or list($error,$error_msg) = array( true , "Erreur base de données<br />" . $sql_mail);
				
		while ($val_mail = mysql_fetch_array($result_mail))
		 {
			
			$val_user = select_element("SELECT user_id,username,user_email FROM phpbb_users WHERE user_id=".$val_mail['user_id'],'',false);
			$message = $val_rdf['username']." souhaite vous tenir informer pour la Réunion de famille (RDF) qu'il ou elle organise.\nEt voici son message:\n";
			
			$emailer = new emailer($board_config['smtp_delivery']);
			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);
			$emailer->use_template('email_rdf',"french");
			$emailer->email_address($val_user['user_email']);
			$emailer->set_subject($lang['Notification_subject']);
					
			$emailer->assign_vars(array(
				'SUBJECT' => "Réunion de famille du ".date_unix($val_rdf['date'],'jour'),
				'USERNAME' => $val_user['username'], 
				'EMAIL_SIG' => "-- \nL'équipe d'administration de JJG Famille",
				'MESSAGE_RDF' => $message_rdf,
				'MESSAGE' => $message,
			));

			$emailer->send();
			$emailer->reset();
	
		 }
		
		logger("Un mail groupé a été envoyé aux familiens inscrits à la rdf N°$rdf_id");	
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_rdf." . $phpEx ."?rdf_id=".$rdf_id) . '">')
		);
		$message =  sprintf($lang['Sendmail_rdf_ok'], '<a href="' . append_sid("edit_rdf." . $phpEx ."?rdf_id=".$rdf_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);	
	}
}



if ($_GET['mode']=='send_invit')
{
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['message']) || $_POST['message'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Message']));
	else $message_rdf = $_POST['message'];
	
	if (!isset($_POST['group_id']) || $_POST['group_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Group']));
	else $group_id = $_POST['group_id'];
	
	if (!$error)
	{
		// Envoi du mail aux familliens inscrits
		$sql_mail = "SELECT groupe.group_name, util.username, util.user_email
				FROM  `phpbb_users`  AS util,  `phpbb_user_group`  AS asso,  `phpbb_groups`  AS groupe
				WHERE groupe.group_id = asso.group_id AND util.user_id = asso.user_id AND groupe.group_id =  '$group_id'";
		$result_mail = mysql_query($sql_mail) or list($error,$error_msg) = array( true , "Erreur base de données<br />" . $sql_mail);
		
		//die("nb résultats : " . mysql_num_rows($result_mail));
		
		while ($val_mail = mysql_fetch_array($result_mail))
		 {
		 	$group_name = $val_mail['group_name'];
			$message = stripslashes(str_replace('{USERNAME}',$val_mail['username'],str_replace('{GROUPNAME}',$val_mail['group_name'],$message_rdf)));
			
			$emailer = new emailer($board_config['smtp_delivery']);
			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);
			$emailer->use_template('email_classique',"french");
			$emailer->email_address($val_mail['user_email']);
			$emailer->set_subject($lang['rdf_invitation']);
					
			$emailer->assign_vars(array(
				'SUBJECT' => $lang['rdf_invitation'],
				'EMAIL_SIG' => $board_config['board_email_sig'],
				'MESSAGE' => $message,
			));

			$emailer->send();
			$emailer->reset();
	
		 }
		
		logger("Une invitation pour la RDF du " . date_unix($val_rdf['date'],'jour') . " a été envoyée aux membres du groupe $group_name");	
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "famille/edit_rdf." . $phpEx ."?rdf_id=".$rdf_id) . '">')
		);
		$message =  sprintf($lang['Sendinvit_rdf_ok'], $group_name, '<a href="' . append_sid($phpbb_root_path . "famille/edit_rdf." . $phpEx ."?rdf_id=".$rdf_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);	
	}
}

//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");
//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');
//Séléection de tous les familliens inscrits
$tab_inscrits = select_liste("SELECT * FROM rdf_membre WHERE rdf_id=".$rdf_id." ORDER BY date DESC");

// Liste des groupes d'utilisateurs
$tab_groups = select_liste("SELECT `group_id`, `group_name` FROM `phpbb_groups` WHERE  `group_single_user` = '0' AND group_name LIKE 'Région%'");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);



$template->set_filenames(array(
	'body' => 'site/famille/edit_rdf.tpl',
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

$server_name = trim($board_config['server_name']); 
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://'; 
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/'; 
$server_url = $server_protocol . $server_name . $server_port . 'famille/view_rdf.php';

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
				'L_SUBMIT'=> $lang['Submit'],
				'U_FORM' => append_sid($phpbb_root_path . 'famille/edit_rdf.php?mode=edit&rdf_id='.$rdf_id),
				'LIEU' => $lang['Lieu'],
				'DATE' => $lang['Date'],
				'HEURE' => $lang['Heure'],
				'DESCRIPTION' => $lang['description'],
				'TITLE' => $lang['Organiser sa propre Réunion de famille (RDF)'],
				'VAL_LIEU' => $val_rdf['lieu'],
				'VAL_DATE' => date_unix($val_rdf['date'],'jour'),
				'VAL_HEURE' => date_unix($val_rdf['date'],'heure'),
				'VAL_DESC' => str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_rdf['bbcode_uid'] . '/s', '', $val_rdf['description'])),
				'TITLE' => $lang['Modifier les informations de votre Réunion de famille (RDF)'],
				'MESSAGE' => $lang['Message'],
				'SENDMAIL' => $lang['Envoyer un message par mail'],
				'I_WANT' => $lang['i_want_to_sendmail'],
				'U_FORM_MAIL' => append_sid($phpbb_root_path . 'famille/edit_rdf.php?mode=sendmail&rdf_id='.$rdf_id),
				'STATS' => $stats,
				'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['Réunion de famille'])))),
				'L_SUPP' =>  $lang['supprimer'].'&nbsp;'.sprintf($lang['la'],$lang['Réunion de famille']),
				'U_SUPP' => append_sid($phpbb_root_path . 'famille/doedit.php?mode=supp_rdf&rdf_id='.$rdf_id),
				'L_TITLE' => $lang['RDF'].' '.$lang['prévue'].' '.sprintf($lang['à'],$val_rdf['lieu']).' '.sprintf($lang['le'],date_unix($val_rdf['date'],'date1')),
				'U_TITLE' => append_sid($phpbb_root_path . 'famille/view_rdf.php?rdf_id='.$rdf_id),
				
				'L_SEND_INVIT' => $lang['send_invit'],
				'L_SEND_INVIT_EXPL' => $lang['send_invit_expl'],
				'L_CHOOSE_GROUP' => $lang['Usergroups'],
				'L_INVIT' => $lang['message_invitation'],
				'L_INVIT_EXPL' => $lang['mail_invit_expl'],
				
				'INVIT' => htmlentities(sprintf($lang['mail_invit'],'{USERNAME}',$userdata['username'],date_unix($val_rdf['date'],'jour'),$val_rdf['lieu'],$server_url . '?rdf_id=' . $rdf_id,'{GROUPNAME}')),
				
				'U_FORM_INVIT' => append_sid($phpbb_root_path . 'famille/edit_rdf.php?mode=send_invit&amp;rdf_id='.$rdf_id),
				
			)
);

for ($i=0;$i<count($tab_groups);$i++)
{
	$template->assign_block_vars('group',array(
						'GROUP_ID' => $tab_groups[$i]['group_id'],
						'GROUP_NAME' => $tab_groups[$i]['group_name'],
						));
}

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
	$val_user = select_element("SELECT user_id,username,user_email FROM phpbb_users WHERE user_id=".$tab_inscrits[$i]['user_id'],'',false);
	$template->assign_block_vars('switch_inscrits',array(
						'U_USER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_user['user_id']),
						'L_USER' => $val_user['username'],
						'DATE' => $lang['inscrit'].' '.date_unix($tab_inscrits[$i]['date'],'date'),
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

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
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