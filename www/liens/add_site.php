<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'liens';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/emailer.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LIENS);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

if ($_GET['mode'] == 'add_site')
{
	$error = false;
	$error_msg = '';

	//Traitement php
	if (!isset($_POST['site_name']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$site_name = $_POST['site_name'];
	if ($site_name=="")
		list($error,$error_msg) = array( true , "Le champs 'nom du site' est obligatoire");
		
	if (!isset($_POST['url']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$url = strtolower($_POST['url']);
	if ($url=="")
		list($error,$error_msg) = array( true , "Le champs 'URL' est obligatoire");
	if (substr($url,0,7)!='http://')
		$url = 'http://'.$url;
	
	if (!isset($_POST['description']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$description = $_POST['description'];
	if ($description=="")
		list($error,$error_msg) = array( true , "Le champs 'Description' est obligatoire");
	
	if (strlen($description)>200)
		list($error,$error_msg) = array( true , "Le champs doit 'Description' ne doit pas dépasser 200 caractères");
		
	$site_name = htmlentities($site_name);
	$url = htmlentities($url);
	$description = delete_html($description); 
	$description= str_replace("\n","<br>",$description);
	
	if (!$error)
	{
		$sql_add = "INSERT INTO liens_sites (site_name,score,user_id,username,url,description,enable,date_add) VALUES ('".$site_name."',0,".$userdata['user_id'].",'".$userdata['username']."','".$url."','".$description."','N'," . date('Ymd') . ")";
		mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />" . $sql_add);
		logger("Ajout du site $site_name par un webmaster (liens)");
		
		$site_id = mysql_insert_id();
		
		
		// Ajout de la banniere
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if ($user_upload!= '')
		{
			$ban_error = false;
			$ban_error_msg = '';
			
			user_upload_easy($ban_error,$ban_error_msg,$HTTP_POST_FILES['userfile'],$phpbb_root_path . 'images/liens/logo_' . $site_id ,array($site_config['banniere_max_filesize'],$site_config['banniere_max_width'],$site_config['banniere_max_height']));
		}
		
		// Si l'ajout du site dans la base de données s'est passée convenablement
		if (!$error)
		{
			// Envoi du mail aux responsables
			$sql_responsable = "SELECT B.* FROM famille_access A, phpbb_users B WHERE A.user_id = B.user_id AND A.rub = 'liens'";
			$result_responsable = mysql_query($sql_responsable) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />" . $sql_responsable);
			
			$message = "Le site ".$site_name." a été rajouté par ".$userdata['username']." dans la rubrique liens\r\nL'URL de ce site est ".$url." et la description saisie est la suivante :\r\n\t".$description;
			
			while ($val_responsable = mysql_fetch_array($result_responsable))
			{

				$emailer = new emailer($board_config['smtp_delivery']);
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
				$emailer->use_template('email_notify',"french");
				$emailer->email_address($val_responsable['user_email']);
				$emailer->set_subject($lang['Notification_subject']);
					
				$emailer->assign_vars(array(
					'SUBJECT' => "Notification d'activité de la rubrique 'Liens'",
					'USERNAME' => $val_responsable['username'], 
					'EMAIL_SIG' => "-- \nL'équipe d'administration de JJG Famille",
					'MESSAGE' => $message,
				));

				$emailer->send();
				$emailer->reset();
	
			}
			$url_liens = "http://" . $board_config['server_name'];
			$str_lien1 = sprintf('<a href="%s"><img src="http://'. $_SERVER['HTTP_HOST'] .'/images/banniere.png" border="0" /></a>',$url_liens);
			$str_lien2 = sprintf('<a href="%s"><img src="http://'. $_SERVER['HTTP_HOST'] .'/images/logo.png" border="0" /></a>',$url_liens);
			
			// Envoi du mail à l'auteur du lien
			$message = "Votre site ".stripslashes($site_name)." a bien été enregistré sur la page 'liens' de famille\r\nUn responsable de la rubrique liens va très bientôt confirmer son ajout et vous pourrez le voir dans la liste des sites très prochainement.\r\n\tPour augmenter votre position dans cette liste, faites un lien vers famille sur votre site ".$site_name." en utilisant, par exemple, les codes HTML indiqués à la fin de ce mail.\t\r\nEn effet, pour chaque visiteur venant de votre site : vous gagnerez un point. Votre position dans la liste des liens de famille sera ensuite définie par votre total de points (à raison d'un point par IP et par jour, les scores seront remis à 0 tous les 3 mois).\r\n\tVous pourrez consulter votre nombre de points et éditer les informations concernant votre site en vous rendant sur la page 'liens' dès que votre site aura été approuvé.\r\n\n\tA très bientôt sur famille\r\n\nhttp://'. $_SERVER['HTTP_HOST'] .'\r\n\r\n\r\n*Codes HTML pour les liens*\r\n/bannière :/\r\n" . $str_lien1 . "\r\n\r\n/logo/\r\n" . $str_lien2;
			
				$emailer = new emailer($board_config['smtp_delivery']);
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
				$emailer->use_template('email_notify',"french");
				$emailer->email_address($userdata['user_email']);
				$emailer->set_subject($lang['Notification_subject']);
					
				$emailer->assign_vars(array(
					'SUBJECT' => "Votre site a bien été ajouté à la rubrique 'Liens' de JJG Famille",
					'USERNAME' => $userdata['username'], 
					'EMAIL_SIG' => "-- \r\nL'équipe d'administration de JJG Famille",
					'MESSAGE' => $message,
				));

				$emailer->send();
				$emailer->reset();
						
			
			$felicitation_webmaster = sprintf($lang['Felicitations_webmaster'],stripslashes($site_name),stripslashes($site_name),$url_liens);
			

			$str = '<table width="100%" border="0"><tr><td><span class="genmed"><b>Code</b></span></td><td><span class="genmed"><b>Résultat</b></span></td></tr>
				<tr><td><span class="gensmall"><code>' . htmlentities($str_lien1) . '</code></span></td>
					<td><span class="gensmall">' . $str_lien1 . '</span></td></tr>
				<tr><td><span class="gensmall"><code>' . htmlentities($str_lien2) . '</code></span></td>
					<td><span class="gensmall">' . $str_lien2 . '</span></td></tr></table>';

			$felicitation_webmaster.=$str;
			if ($ban_error)
			{
				$felicitation_webmaster .= sprintf('<br /><font color="red"><b>%s</b> : %s<br />%s</font>',$lang['a_noter'],$lang['banner_upload_fail'] , $ban_error_msg );
			}
			
			$felicitation_webmaster .= "<br /><br />" . sprintf($lang['add_site_ok'] , '<a href="' . append_sid( $phpbb_root_path . "liens/index." . $phpEx) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $felicitation_webmaster);
		}
	}
	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='liens' ORDER BY user_id");

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM liens_categories ORDER BY ordre");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_liens'],'liens');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Links'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);



$template->set_filenames(array(
	'body' => 'site/liens/add_site.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/liens/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;	
					
$template->assign_vars(array(
				// Liens
				"LIENS" => $lang['Links'],
				"L_LISTE" => $lang['liste_cate'],
				"RESPONSABLES" => $lang['Responsables'],
				"AJOUT_SITE" => $lang['Ajout_site'],
				"NOM_SITE"=> $lang['Nom_site'],
				"URL"=> $lang['URL'],
				"DESCRIPTION"=> $lang['Description'],
				"MAX_CHARACTERS" => sprintf($lang['x_char_maxi'],'200'),
				"BANNIERE"=> $lang['Banniere'],
				"U_FORM" => append_sid( $phpbb_root_path . 'liens/add_site.php?mode=add_site'),
				"L_SUBMIT" => $lang['Submit'],
				"IMG_MASCOTTE" => $mascotte,
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => $phpbb_root_path . 'liens/index.php',
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
{
		$template->assign_block_vars('admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'liens/edit.php'),
						"L_ADMIN" =>  $lang['liens_admin']
						)
					);
					
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'liens/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

for ($i=0;$i<count($tab_cate);$i++)
{
	$template->assign_block_vars('categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name']
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('liens','opif');
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
