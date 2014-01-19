<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'jjg';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
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
	
	$photo_id = $_GET['photo_id']; 		
	$commentaire = $_POST['commentaire'];
	$photographe = $_POST['photographe'];
	$cate_id=$_POST['cate_id'];
	$cate_idp = $_POST['cate_idp'];
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
		
		$ext = find_image("../images/photos/photo_".$cate_idp."_".$photo_id.".");
		@rename("../images/photos/photo_".$cate_idp."_".$photo_id.".".$ext,"../images/photos/photo_".$cate_id."_".$photo_id.".".$ext);
		
		$sql_update = "UPDATE famille_photo SET title='" .$photo_name. "' ,cate_id=".$cate_id.", comment='".$commentaire."' , photographe='".$photographe."' , bbcode_uid='".$bbcode_uid."' , source_id=".$source_id.",user_name='".$user_name."' WHERE photo_id = ".$photo_id." ";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		logger("Modification de la photo $photo_name de la galerie photos");
		
		$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("photos_view_photo." . $phpEx."?photo_id=".$photo_id) . '">')
		);
		$message =  sprintf($lang['Upload_photo_ok'], '<a href="' . append_sid("photos_view_photo." . $phpEx."?photo_id=".$photo_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);	
			
				
		
	}
	
}

//
//Selection de la photo choisie
//
$val_photo = select_element("SELECT * FROM famille_photo WHERE photo_id= ".$_GET['photo_id']."  LIMIT 0,1",'',false);

//
//Selection de la photo choisie
//
$val_cate = select_element("SELECT cate_name FROM famille_photo_cate WHERE cate_id= ".$val_photo['cate_id']."  LIMIT 0,1",'',false);

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='photos' ORDER BY user_id");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');

//
//Selection de la categorie choisie
//
$tab_liste = select_liste("SELECT * FROM famille_photo_cate ORDER BY ordre");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Galerie_photo'] . ' :: ' . $val_photo['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/photos_view_photo.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

//Selection de la source
if($val_photo['source_id']== -1)
{$source=$val_photo['user_name'];}
else{
$val_source = select_element("SELECT username FROM phpbb_users WHERE user_id= ".$val_photo['source_id']."  LIMIT 0,1",'',false);
$source=$val_source['username'];}

$template->assign_vars(array(

				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'TITRE_PHOTO' => $val_photo['title'],
				'COMMENTAIRE_PHOTO' => nl2br(bbencode_second_pass(sprintf($lang['comment'],$val_photo['comment']),$val_photo['bbcode_uid'])),
				'U_CATE' => append_sid($phpbb_root_path . 'jjg/photos-' . str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name'])) . '_'. $val_photo['cate_id'].'.html'),
				'CATE' => $lang['categorie'],
				'L_CATE' => $val_cate['cate_name'],
				'PHOTO' => $phpbb_root_path . 'functions/image.php?mode=photos&cate_id=' . $val_photo['cate_id'] . '&photo_id=' . $val_photo['photo_id'],
				'SOURCE_PHOTO' => sprintf($lang['source'],$source),
				'PHOTOGRAPHE' => sprintf($lang['photographe'],$val_photo['photographe']),
				"IMG_MASCOTTE" => $mascotte,
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/photos-' . str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name'])) . '_'. $val_photo['cate_id'].'.html'),
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

//Selection de la source
if($val_photo['source_id']== -1)
{$source=$val_photo['user_name'];}
else{
$val_source = select_element("SELECT username FROM phpbb_users WHERE user_id= ".$val_photo['source_id']."  LIMIT 0,1",'',false);
$source=$val_source['username'];}

//Categorie upload 
$val_upload = select_element("SELECT cate_id FROM famille_photo_cate WHERE cate_name = 'upload' ",'',false);

if($val_photo['source_id']== -1)
	{
		$check = '';
	}
else
	{
		$check = 'checked';
	}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'photos'))
{
		$template->assign_block_vars('switch_admin',array(
				"L_ADMIN" =>  $lang['jjg_admin'],
				'TITRE_PHOTO' => $val_photo['title'],
				'TITRE_PHOTO_FORM' => $val_photo['title'],
				'COMMENTAIRE_PHOTO' => bbencode_second_pass(sprintf($lang['comment'],$val_photo['comment']),$val_photo['bbcode']),
				'U_CATE' => append_sid($phpbb_root_path . 'jjg/photos-' . str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name'])) . '_'. $val_photo['cate_id'].'.html'),
				'CATE' => $lang['categorie'],
				'CATE_IDP' => $val_photo['cate_id'],
				'L_CATE' => $val_cate['cate_name'],
				'PHOTO' => $phpbb_root_path . 'functions/image.php?mode=photos&cate_id=' . $val_photo['cate_id'] . '&photo_id=' . $val_photo['photo_id'],
				'SOURCE_PHOTO' => sprintf($lang['source'],$source),
				'PHOTOGRAPHE' => sprintf($lang['photographe'],''),
				"MODIF_PHOTO" => $lang['modif_photo'],
				"NOM_PHOTO"=> $lang['Nom_photo'],
				"PHOTOGRAPHES"=> $lang['photographe?'],
				"SOURCE"=> sprintf($lang['source'],''),
				"COMMENTAIRE"=> $lang['commentaire'],
				'L_COMMENTAIRE_PHOTO' => preg_replace('/\:(([a-z0-9]:)?)' . $val_photo['bbcode_uid'] . '/s', '', $val_photo['comment']),
				'L_PHOTOGRAPHE_PHOTO' => $val_photo['photographe'],
				'L_SOURCE_PHOTO' => $source,
				"L_SUBMIT" => $lang['Submit'],
				"CATE" => $lang['categorie'],
				"U_SUPP_PHOTO" => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_photo&cate_id='. $val_photo['cate_id'].'&photo_id='.$val_photo['photo_id']),
				"SUPP_PHOTO" => $lang['supp_photo'],
				'U_ACCES_UPLOAD'=> append_sid($phpbb_root_path . 'jjg/photos_view_cate?cate_id='.$val_upload['cate_id']),
				'L_ACCES_UPLOAD'=> $lang['acces_upload'],
				'U_FORM' => append_sid($phpbb_root_path . 'jjg/photos_view_photo.php?mode=add_photo&photo_id='.$_GET['photo_id']),
				'CHECK' => $check,
				'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['photo'])))),
						)
					);
					
		for ($i=0;$i<count($tab_liste);$i++)
		{
	
				$template->assign_block_vars('switch_admin.mes_options',array(
						"VALUE" => $tab_liste[$i]['cate_id'],
      						"INTITULE" => $tab_liste[$i]['cate_name'],
      						"SELECTED" => ($tab_liste[$i]['cate_id'] == $val_photo['cate_id'] ) ? " SELECTED" : ""
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