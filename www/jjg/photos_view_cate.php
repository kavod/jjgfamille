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

if ($_GET['mode'] == 'add_photo')
{
	$error = false;
	$error_msg = '';

	//Traitement php
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
	$search= $_POST['search'];
	$source=$_POST['source'];
	
	$source = htmlentities($source);
	
	if ($search)
	{
		$val_source = select_element("SELECT * FROM phpbb_users WHERE username = '".$source."'",'',false);
		if (!$val_source)
		{
			list($error,$error_msg) = array( true , "Utilisateur Introuvable");
		} else $source_id=$val_source['user_id'];
	} else 
	{ 
		if ($source=="")
		{
			list($error,$error_msg) = array( true , "Indiquez la source SVP");
		}

		$source_id=-1;
	} 

	if ($source_id==-1)
	{
		$user_name= $source;
	} else
	{
		$user_name =$val_source['username'];
	}
	
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
		$sql_add = "INSERT INTO famille_photo (title,ordre,cate_id,comment,photographe,bbcode_uid,user_id,source_id,artist_id,user_name,date_add) VALUES('".$photo_name."',".$ordre.",".$cate_id.",'".$commentaire."','".$photographe."','".$bbcode_uid."',".$user_id.",".$source_id.",".$artist_id.",'".$user_name."'," . date('Ymd') . ")";
		mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_add);
		logger("Ajout de la photo $photo_name dans la galerie photo");
		
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
				logger("Suppression de la photo précédente N°$photo_id suite à l'echec de l'upload");
			}
		}
		
		// Si l'ajout du site dans la base de données s'est passée convenablement
		if (!$error)
		{
			// Envoi du mail aux responsables
			$sql_responsable = "SELECT B.* FROM famille_access A, phpbb_users B WHERE A.user_id = B.user_id AND A.rub = 'photo'";
			$result_responsable = mysql_query($sql_responsable) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données");
			
			while ($val_responsable = mysql_fetch_array($result_responsable))
			{
				$message = "Salut ".$val_responsable['username']."\nUne photo à été ajouté par " . $userdata['username'] . " (http://" . $_SERVER['HTTP_HOST'] . "/forum/profile.php?mode=viewprofile&u=" . $userdata['user_id'] . ") dans la catégorie uploads\nIl vous faut donc aller vérifier cette rubrique afin de rendre visible cet ajout ou bien le supprimer\nCordialement, le site famille";
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
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("photos_view_cate." . $phpEx . "?cate_id=".$cate_id) . '">')
				);
				$message =  sprintf($lang['Upload_photo_ok'], '<a href="' . append_sid("photos_view_cate." . $phpEx . "?cate_id=".$cate_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
			
				
		}
	}
	//Fin traitment php
	
}

if (! isset($_GET['cate_id']))
	message_die("Catégorie inconnue");
select_element("SELECT * FROM famille_photo_cate WHERE cate_id = " . $_GET['cate_id'],"Catégorie inconnue",true);
 
// Sélection des limites d'affichage
$debut = (isset($_POST['page']) && (int)$_POST['page']>0) ? ($_POST['page']-1) * $site_config['nb_photo_by_page'] : 0;

//
//Selection des photos de la rubrique choisie
//
$tab_photos = select_liste("SELECT * FROM famille_photo WHERE cate_id= ".$_GET['cate_id']." ORDER BY ordre LIMIT ".$debut . "," . $site_config['nb_photo_by_page']);

// Calcul du nombre de page
$nb_total = select_element("SELECT COUNT(*) nb_total FROM famille_photo WHERE cate_id = " . $_GET['cate_id'],'Erreur Interne<br />Impossible de calculer le nombre de photos',true);

$nb_page = floor($nb_total['nb_total'] / $site_config['nb_photo_by_page']);
if ($nb_total['nb_total'] % $site_config['nb_photo_by_page'] != 0)
	$nb_page++;

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='photos' ORDER BY user_id");

//Liste des photos
$tab_photo = select_liste("SELECT * FROM famille_photo WHERE cate_id=".$_GET['cate_id']." ORDER BY ordre");
//
//Liste des categories
//
$val_cate = select_element("SELECT cate_name FROM famille_photo_cate WHERE cate_id=".$_GET['cate_id']." LIMIT 0,1",'',false);

//Photos disponibles
$val_count = select_element("SELECT COUNT(photo_id) as NUM FROM famille_photo WHERE cate_id=".$_GET['cate_id']." LIMIT 0,1",'',false);

if($val_cate['cate_name'] <> 'upload')
{	
	$u_supp_cate = append_sid( $phpbb_root_path . 'jjg/doedit.php?mode=supp_cate&cate_id='.$_GET['cate_id']);
	$supp_cate = $lang['supp_cate'];
	$ll_cate = $val_cate['cate_name'];
	$renomme_cate = $lang['renomme_cate']; 
	$case = '<input type="text" name="cate_name" size="30" class="post">&nbsp;&nbsp;&nbsp;<input type="submit" value="'.$lang['Submit'].'">';
	
}else
{
	$u_supp_cate = '';
	$supp_cate = '';
	$ll_cate = '';
	$renomme_cate = '';
	$case= '';
}

//Categorie upload 
$val_upload = select_element("SELECT cate_id FROM famille_photo_cate WHERE cate_name = 'upload' ",'',false);

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Galerie_photo'] . ' :: ' . $val_cate['cate_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/photos_view_cate.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);


for ($i=0;$i<$nb_page;$i++)
{
	$template->assign_block_vars('go_to_page',array(
				"L_PAGE" => sprintf($lang["go_to_page"],($i+1)),
				"PAGE" => ($i+1),
				"SELECTED" => ($i+1 == $_POST['page']) ? " SELECTED" : ""
				));
}

if ($img_mascotte)
$mascotte = $img_mascotte;


$template->assign_vars(array(

				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'AJOUT_PHOTOS' => sprintf($lang['ajout_photos'],append_sid($phpbb_root_path . 'jjg/photos_add_photos.php')),
				'U_GO_TO_PAGE' => append_sid($phpbb_root_path . "jjg/photos-" . str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name'])) ."_" . $_GET['cate_id'].'.html'),
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR'=> $lang['retour'],
				'CATE' => $lang['categorie'],
				'L_CATE' => $val_cate['cate_name'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/photos.html'),
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
						"L_ADMIN" =>  $lang['jjg_admin'],
						'CATE' => $lang['categorie'],
						'L_CATE' => $val_cate['cate_name'],
						'LL_CATE' => $ll_cate,
						'PHOTOS_DISPO' => $val_count['NUM'],
						"AJOUT_PHOTO" => $lang['Ajout_photo'],
						"NOM_PHOTO"=> $lang['Nom_photo'],
						"PHOTOGRAPHE"=> $lang['photographe?'],
						"SOURCE"=> sprintf($lang['source'],''),
						"COMMENTAIRE"=> $lang['commentaire'],
						"PHOTO"=> $lang['emplacement'],
						"U_FORM" => append_sid( $phpbb_root_path . 'jjg/photos_view_cate.php?mode=add_photo&cate_id='.$_GET['cate_id']),
						"L_SUBMIT" => $lang['Submit'],
						"USER" => $userdata['user_id'],
						"CATE_ID" => $_GET['cate_id'],
						"RENOMME_CATE" => $renomme_cate,
						"U_FORM_RENOMME" => append_sid( $phpbb_root_path . 'jjg/doedit.php?mode=edit_cate&cate_id='.$_GET['cate_id']),
						"SUPP_CATE" => $supp_cate,
						"U_SUPP_CATE" => $u_supp_cate,
						"CASE" => $case,
						'U_ACCES_UPLOAD'=> append_sid($phpbb_root_path . 'jjg/photos_view_cate?cate_id='.$val_upload['cate_id']),
						'L_ACCES_UPLOAD'=> $lang['acces_upload'], 
						'L_CONFIRM_SUPP_CATE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['categorie'])))),
						)
					);
		for ($i=0;$i<count($tab_photo);$i++)
{
	
	
		$l_monter = $lang['monter'];
	  	$u_monter = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=upphoto&photo_id='.$tab_photo[$i]['photo_id'].'&cate_id='.$tab_photo[$i]['cate_id']);
	  	$l_descendre = $lang['descendre'];
	  	$u_descendre = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=downphoto&photo_id='.$tab_photo[$i]['photo_id'].'&cate_id='.$tab_photo[$i]['cate_id']);
	  	$l_supprimer = $lang['supprimer'];
	  	$u_supprimer = append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_photo&cate_id='.$tab_photo[$i]['cate_id'].'&photo_id='.$tab_photo[$i]['photo_id']);
	
	
	$template->assign_block_vars('switch_admin.photo',array(
						'U_PHOTO' => append_sid($phpbb_root_path . 'jjg/photo-'. str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name'] . '-' . $tab_photo[$i]['title'])) .'_'.$tab_photo[$i]['photo_id'].'.html'),
						'L_PHOTO' => $tab_photo[$i]['title'],
						'L_MONTER' => $l_monter,
						'U_MONTER' => $u_monter,
						'L_DESCENDRE' => $l_descendre,
						'U_DESCENDRE' => $u_descendre,
						'L_SUPPRIMER' => $l_supprimer,
						'U_SUPPRIMER' => $u_supprimer,
						'L_CONFIRM_SUPP_PHOTO' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['photo'])))),
						)
					);
}
					
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
// On définit le nombre de photo par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_photos = count($tab_photos);
// Pour chaque ligne...
$i=0;
while($i<$nb_photos)
{
	$template->assign_block_vars('photos_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_photos;$j++)
	{
		$img_photo = $phpbb_root_path . 'functions/miniature.php?mode=photo&cate_id=' . $tab_photos[$i]['cate_id'] . '&photo_id=' . $tab_photos[$i]['photo_id'];
		$l_photo = $tab_photos[$i]['title'];
		//$u_photo = append_sid($phpbb_root_path . 'jjg/photos_view_photo.php?photo_id=' . $tab_photos[$i]['photo_id']);
		$u_photo = append_sid($phpbb_root_path . 'jjg/photo-'. str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name'] . '-' . $tab_photos[$i]['title'])) .'_'.$tab_photos[$i]['photo_id'].'.html');
				
		$template->assign_block_vars('photos_row.photos_column',array(
							'U_PHOTO' => $u_photo,
							'L_PHOTO' => $l_photo,
							'PHOTO' => $img_photo,
							)
						);
		$i++;
	}
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('photo','opif');
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
