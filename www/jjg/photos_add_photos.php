<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'jjg';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/emailer.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_JJG);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

if ($_GET['mode'] == 'add_photo')
{
	$error = false;
	$error_msg = '';

	if (!isset($_POST['photo_name']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$photo_name = $_POST['photo_name'];
	if ($photo_name=="")
		list($error,$error_msg) = array( true , "Le champs \"nom de l'image\" est obligatoire");
			
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
			
	$commentaire = $_POST['commentaire'];
	$photographe = $_POST['photographe'];
	$user_id=$_POST['user'];
	$cate_id=$_POST['cate_id'];
	
	$val_photo = select_liste("SELECT * FROM famille_photo ORDER BY ordre DESC");
	if (!$val_photo) 
		{ $ordre=1; } else { $ordre=$val_photo['ordre']+1; }
	
	$artist_id=1;
	$bbcode_uid = make_bbcode_uid();
	$commentaire = delete_html($commentaire);
	$commentaire=bbencode_first_pass($commentaire,$bbcode_uid);
	
	$photo_name = htmlentities($photo_name);
	$photographe = htmlentities($photographe);
	
	if (!$error)
	{
		$sql_add = "INSERT INTO famille_photo (title,ordre,cate_id,comment,photographe,bbcode_uid,user_id,source_id,artist_id,user_name,date_add) VALUES('".$photo_name."',".$ordre.",".$cate_id.",'".$commentaire."','".$photographe."','".$bbcode_uid."',".$userdata['user_id'].",".$user_id.",".$artist_id.",'".$userdata['username']."'," . date('Ymd') . ")";
		mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_add);
		logger("Ajout de la photo \"$title\"");
		
		$photo_id = mysql_insert_id();
		
		
		// Ajout de la photo
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy(
					$error,
					$error_msg,
					$HTTP_POST_FILES['userfile'],
					$phpbb_root_path . 'images/photos/photo_' . $cate_id .'_'.$photo_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['photo_max_width'],
						$site_config['photo_max_height'])
					);
			if ($error)
			{
				$sql_del = "DELETE FROM famille_photo WHERE photo_id = " . $photo_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
				logger("Suppression de la photo $photo_id aprés echec de l'upload");
			}
		}
		
		// Si l'ajout du site dans la base de données s'est passée convenablement
		if (!$error)
		{
			// Envoi du mail aux responsables
			$sql_responsable = "SELECT B.* FROM famille_access A, phpbb_users B WHERE A.user_id = B.user_id AND A.rub = 'photos'";
			$result_responsable = mysql_query($sql_responsable) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données");
			
			$message = "La photo ". $photo_name ." à été ajouté par ".$userdata['username']." (http://" . $_SERVER['HTTP_HOST'] . "/forum/profile.php?mode=viewprofile&u=".$userdata['user_id'].") dans la catégorie uploads\nIl vous faut donc aller vérifier cette rubrique afin de rendre visible cet ajout ou bien le supprimer\nCordialement, le site famille";
			
			while ($val_responsable = mysql_fetch_array($result_responsable))
			{
				$emailer = new emailer($board_config['smtp_delivery']);
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
				$emailer->use_template('email_notify',"french");
				$emailer->email_address($val_responsable['user_email']);
				$emailer->set_subject($lang['Notification_subject']);
					
				$emailer->assign_vars(array(
					'SUBJECT' => "Notification d'activité de la rubrique 'galerie photos' de JJG Famille",
					'USERNAME' => $val_responsable['username'], 
					'EMAIL_SIG' => "-- \nL'équipe d'administration de JJG Famille",
					'MESSAGE' => $message,
				));

				$emailer->send();
				$emailer->reset();
				
			}
			
			
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("photos." . $phpEx) . '">')
				);
				$message =  sprintf($lang['Upload_photo_ok'], '<a href="' . append_sid("photos." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
			
				
		}
	}
	//Fin traitment php
	
}

//
//Categorie upload
//
$val_upload = select_element("SELECT cate_id FROM famille_photo_cate WHERE cate_name='upload' ",'',false);

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='photos' ORDER BY user_id");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/photos_add_photos.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;
				


$template->assign_vars(array(

				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/biblio.php'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/bio.php'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.php'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'CATE' => $lang['categorie'],
				"AJOUT_PHOTO" => $lang['Ajout_photo'],
				"NOM_PHOTO"=> $lang['Nom_photo'],
				"PHOTOGRAPHE"=> $lang['photographe?'],
				"SOURCE"=> sprintf($lang['source'],''),
				"COMMENTAIRE"=> $lang['commentaire'],
				"PHOTO"=> $lang['emplacement'],
				"U_FORM" => append_sid( $phpbb_root_path . 'jjg/photos_add_photos.php?mode=add_photo'),
				"L_SUBMIT" => $lang['Submit'],
				"USER" => $userdata['user_id'],
				"CATE_ID" => $val_upload['cate_id'],
				"RESPONSABLES" => $lang['Responsables'],
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/photos.php'),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'jjg/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'photos'))
{
		$template->assign_block_vars('switch_admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'jjg/photos_edit.php'),
						"L_ADMIN" =>  $lang['jjg_admin']
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


require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('photo','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );


$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
