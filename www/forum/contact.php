<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'forum');
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'functions/functions_selections.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/emailer.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_CONTACT);
init_userprefs($userdata);
// End session management

if ($_GET['mode'] == 'contact')
{
	
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['sujet']) || $_POST['sujet'] == '')
		list($error,$error_msg) = array(true,'Le sujet de l\'email obligatoire');
	else $sujet = $_POST['sujet'];
	
	if(!$error && (!isset($_POST['contact_id']) || $_POST['contact_id'] == 0))
		list($error,$error_msg) = array(true,'Veuillez séléctionner un destinataire pour votre message');
	else $contact_id = $_POST['contact_id'];
			
	if (!$error && (!isset($_POST['message']) || $_POST['message'] == ''))
		list($error,$error_msg) = array(true,'Le message de l\'email obligatoire');
	else $message = $_POST['message'];
	
	if($userdata['username'] == 'Anonymous')
	 {
	 	if (!isset($_POST['nom']) || $_POST['nom'] == '')
		           list($error,$error_msg) = array(true,'Veuillez renseigner vos nom/prénom');
	        else $nom = $_POST['nom'];
	        
	        if (!isset($_POST['vemail']) || $_POST['vemail'] == '')
		           list($error,$error_msg) = array(true,'Veuillez renseigner votre adresse mail');
	        else $vemail = $_POST['vemail'];
	        
	        if($vemail!='' && verifemail($vemail) == 0)
		          list($error,$error_msg) = array(true,'Votre adresse email est invalide');
	 }
		
	if (!$error)
	{
		
		$val_contact = select_element("SELECT * FROM famille_contact WHERE contact_id=".$contact_id);
		
		if($userdata['username']=='Anonymous')
		{
		
		$entete = "Message de $nom suite au formulaire de contactez-nous, et voici son message :\n(a noter : cette personne n'est pas sur le forum famille ou bien n'etait pas connécté au moment du message)."; 
		
		$emailer = new emailer($board_config['smtp_delivery']);
		$emailer->from($vemail);
		$emailer->replyto($vemail);
		$emailer->use_template('email_contact',"french");
		$emailer->email_address($val_contact['email']);
		$emailer->set_subject('Contactez-nous');
					
		$emailer->assign_vars(array(
			'SUBJECT' => stripslashes($sujet),
			'ENTETE' => $entete, 
			'EMAIL_SIG' => "-- \nL'équipe d'administration de JJG Famille",
			'MESSAGE' => stripslashes($message),
			));

		$emailer->send();
		$emailer->reset();
		
		logger($nom." a envoyé un message (contactez-nous) au destinataire suivant : ".$val_contact['intitule'].". (A noter : personne non existante ou non connectée).");
			
		}else
		{
		
		$entete = 'Message de '.$userdata['username'].' suite au formulaire de contactez-nous, et voici son message :'; 
		
		$emailer = new emailer($board_config['smtp_delivery']);
		$emailer->from($userdata['user_email']);
		$emailer->replyto($userdata['user_email']);
		$emailer->use_template('email_contact',"french");
		$emailer->email_address($val_contact['email']);
		$emailer->set_subject('Contactez-nous');
					
		$emailer->assign_vars(array(
			'SUBJECT' => stripslashes($sujet),
			'ENTETE' => $entete, 
			'EMAIL_SIG' => "-- \nL'équipe d'administration de JJG Famille",
			'MESSAGE' => stripslashes($message),
			));

		$emailer->send();
		$emailer->reset();
		
		logger($userdata['username']." a envoyé un message (contactez-nous) au destinataire suivant : ".$val_contact['intitule']);
		}
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "forum/contact." . $phpEx) . '">')
		);
		$message =  '<br /><br />' . sprintf('Votre message a bien été envoyé au destinataire suivant : <b>'.$val_contact['intitule'].'</b><br />Cliquez %sici%s pour revenir à la page contact','<a href="' . append_sid($phpbb_root_path . "forum/contact." . $phpEx) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} 

}

if ($_POST['mode'] == 'add')
{
	
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['email']) || $_POST['email'] == '')
		list($error,$error_msg) = array(true,'Champ email obligatoire');
	else $email = $_POST['email'];
	
	if($email!='' && verifemail($email) == 0)
		list($error,$error_msg) = array(true,'Email invalide');
			
	if (!$error && (!isset($_POST['intitule']) || $_POST['intitule'] == ''))
		list($error,$error_msg) = array(true,'Champ intitule obligatoire');
	else $intitule = $_POST['intitule'];
	
	if(!$error)
	{
	       $tab = select_liste("SELECT * FROM famille_contact WHERE email = '".$email."' ");
	       if($tab)
	       	   list($error,$error_msg) = array(true,'Cet email est déjà renseigné');
	       
		
	if (!$error)
	{
		
		$sql = "INSERT INTO famille_contact (email,intitule) VALUES ('".$email."','".$intitule."')";
		logger("Ajout d'un email de contact $email");
		mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "forum/contact." . $phpEx) . '">')
		);
		$message .=  '<br /><br />' . sprintf('Le contact a bien été enregistrée<br />Cliquez %sici%s pour revenir à la page contact','<a href="' . append_sid($phpbb_root_path . "forum/contact." . $phpEx) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} 
}
}

if ($_GET['mode'] == 'del')
{
	
	$error = false;
	$error_msg = '';
	
	if (!isset($_GET['contact_id']) || $_GET['contact_id'] == '')
		list($error,$error_msg) = array(true,'Le numero de contact est obligatoire');
	else $contact_id = $_GET['contact_id'];
 	
	if (!$error)
	{
		
		$sql = "DELETE FROM famille_contact WHERE contact_id =".$contact_id;
		logger("Suppression d'un email de contact N°$contact_id");
		mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "forum/contact." . $phpEx) . '">')
		);
		$message .=  '<br /><br />' . sprintf('Le contact a bien été supprimé<br />Cliquez %sici%s pour revenir à la page contact','<a href="' . append_sid($phpbb_root_path . "forum/contact." . $phpEx) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} 
}

$tab_contact = select_liste("SELECT * FROM famille_contact ORDER BY contact_id");

// Start output of page
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'contact_body.tpl')
);

if($userdata['username'] == 'Anonymous')
{
	$ligne_nom = '<tr><td><span class="genmed"><b>Nom/prénom</b></span></td><td><input type="text" name="nom" value="'.$_POST['nom'].'" size="30"/></td></tr>';
	$ligne_mail = '<tr><td><span class="genmed"><b>Votre email</b></span></td><td><input type="text" name="vemail" value="'.$_POST['vemail'].'" size="30"/></td></tr>';
		
}


$template->assign_vars(array(
			"RUB" => 'Contactez-nous',
			"ACTION" => append_sid($phpbb_root_path . 'forum/contact.php?mode=contact'),
			"SUJET" => 'Sujet',
			"VAL_SUJET" => $_POST['sujet'],	
			"DESTINATAIRE" => 'Destinataire',
			"VAL_DESTINATAIRE" => $_POST['destinataire'],
			"MESSAGE" => 'Message',
			"VAL_MESSAGE" => $_POST['message'],
			"SELECT" => 'Choississez le destinataire',
			"SUBMIT" => 'Envoyer',	
			"LIGNE_NOM" => $ligne_nom ,
			"LIGNE_MAIL" => $ligne_mail,
			'L_WARNING_ABOUT_CONTACT' => $lang['warning_about_contact'],
			)
);

for ($i=0;$i<count($tab_contact);$i++)
{
	
	$template->assign_block_vars('switch_contact',array(
				"VALUE" => $tab_contact[$i]['contact_id'],
      				"INTITULE" => $tab_contact[$i]['intitule'],
      				"SELECTED" => ($tab_contact[$i]['contact_id'] == $_POST['contact_id'] ) ? " SELECTED" : ""
				)
		);

}

if ( $userdata['user_level'] == ADMIN )
{
	
	$template->assign_block_vars('switch_admin',array(
	                                        "RUB" => 'Administrer la page contact',
						"L_EMAIL" => 'Email',
						"L_INTITULE" => 'Intitulé',
						"L_ADD" => 'Ajouter',
						"VAL_EMAIL" => $_POST['email'],
						"VAL_INTITULE" => $_POST['intitule'],
				)
		);
	
	for ($i=0;$i<count($tab_contact);$i++)
	 {
		
		$template->assign_block_vars('switch_admin.switch_contact',array(
						"EMAIL" => $tab_contact[$i]['email'],
						"INTITULE" =>  $tab_contact[$i]['intitule'],
						"L_DEL" => 'Supprimer',
						"U_DEL" => append_sid($phpbb_root_path . 'forum/contact.php?mode=del&contact_id='.$tab_contact[$i]['contact_id']),
						"L_CONFIRM_DEL" => 'Êtes-vous sûr de vouloir supprimer le contact ?',
						)
					);
	 }
}

if ( $error )
{
	$template->set_filenames(array('reg_header' => 'error_body.tpl'));
	$template->assign_vars(array('ERROR_MESSAGE' => $error_msg));
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

// Generate the page
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>