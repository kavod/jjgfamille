<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'functions/functions_fmc.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

if ($_GET['mode'] == 'add')
{

	$error = false;
	$error_msg = '';
	
	$emission_id = $_GET['emission_id'];

	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$description = strip_tags($_POST['comment']);
	if ($description=="")
		list($error,$error_msg) = array( true , "Le champs \"Description\" est obligatoire");

	
	$auteur = strip_tags($_POST['auteur']);


	
	// ajout de l'extrait dans la base de données
	if (!$error)
	{
		$sql_update = "INSERT INTO media_audio (emission_id,user_id,username,description,auteur) VALUES ( $emission_id , ".$userdata['user_id']." , '".$userdata['username']."', '".$description."','".$auteur."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'ajout d'un enregistrement dans la base de données".$sql_update);
		
		$audio_id = mysql_insert_id();
		
			$audio_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
			if (!$error && $audio_upload!= '')
			{
				$sql_last = "SELECT emission_id,audio_id FROM media_audio ORDER BY audio_id DESC";
				$result_last = mysql_query($sql_last);
				$val_audio = mysql_fetch_array($result_last);
			
				upload_fmc(
						$error,
						$error_msg,
						$HTTP_POST_FILES['userfile']['tmp_name'],
						$_FILES['userfile']['name'],
						$_FILES['userfile']['size'],
						dernier_point($_FILES['userfile']['name']),
						'media/audio_'.$val_audio['emission_id'].'_'.$val_audio['audio_id']						
						);
				
				if (!$error)
					finish_fmc('media/audio_'.$val_audio['emission_id'].'_'.$val_audio['audio_id'],dernier_point($_FILES['userfile']['name']));
				
				if ($error)
				{
					$sql_delete = "DELETE FROM media_audio WHERE audio_id = ".$audio_id."";
					mysql_query($sql_delete) or list($error,$error_msg) = array( true , "Erreur durant la suppression dans la base de données apres echec de l'upload".$sql_delete);
				}
			
		}
	}
	
	if(!$error)
			{
				logger("Ajout d'un extrait audio/video '$description' de l'emission N°$emission_id");
				$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("view_emission." . $phpEx."?emission_id=".$emission_id) . '">')
				);
				$message =  sprintf($lang['Upload_audio_ok'], '<a href="' . append_sid("view_emission." . $phpEx."?emission_id=".$emission_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);			
			}

}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

//l'emission selectionné
$val_emission = select_element("SELECT * FROM media_emission WHERE  emission_id= ".$_GET['emission_id']." LIMIT 0,1",'',false);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/add_extrait.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['nom_rub_media'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"L_TITLE" => $val_emission['title'], 
				"U_TITLE" => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$val_emission['emission_id']),
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("add_extrait.php?emission_id=".$_GET['emission_id']."&mode=add"),													
				"AJOUT_ILLU" => $lang['add_extrait_a_v'], 
				"L_DESC" => $lang['Description'], 
				"L_PHOTOGRAPHE" => sprintf($lang['photographe'],''), 
				"L_ILLU" =>  $lang['Chemin_extrait'], 
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$val_emission['emission_id']),
				'COPYRIGHT' => $lang['copyright_auteur'],
				'EXTENSIONS' =>$lang['extensions'],			
			)
);


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
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
$sitopif = short_desc('medias','opif');
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