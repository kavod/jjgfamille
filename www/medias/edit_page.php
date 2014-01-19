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

	$report_id = $_GET['report_id'];
	$page_id = $_GET['page_id'];
	
	if (!isset($_POST['contenu']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$contenu = $_POST['contenu'];
	if ($contenu=="")
		list($error,$error_msg) = array( true , "Le champs \"Contenu\" est obligatoire");
	
	$bbcode_uid = make_bbcode_uid();
	$contenu = delete_html($contenu);
	$contenu = bbencode_first_pass($contenu,$bbcode_uid);
	

	if(!$error)
	{
		
		$sql_update = "UPDATE report_pages SET contenu='".$contenu."',bbcode_uid='".$bbcode_uid."' WHERE page_id='".$page_id."'";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'ajout d'un enregistrement dans la bas de données".$sql_update);
			if(!$error)
			{
				logger("Modification de la page N°$page_id du reportage N°$report_id");
				$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_page." . $phpEx."?report_id=".$report_id."&page_id=".$page_id) . '">')
				);
				$message =  sprintf($lang['Upload_page_ok'], '<a href="' . append_sid("edit_page." . $phpEx."?report_id=".$report_id."&page_id=".$page_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);			
			}
	}	
}

if ($_GET['mode'] == 'add_audio')
{

	$error = false;
	$error_msg = '';
	
	$page_id = $_GET['page_id'];
	$report_id = $_GET['report_id'];
	
         // vérification des informations
	if (!isset($_POST['desc']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$description = $_POST['desc'];
	if ($description=="")
		list($error,$error_msg) = array( true , "Le champs \"Description\" est obligatoire");
if(!$error)
{
	
	$description = htmlentities($description,ENT_QUOTES);
	
	// ajout de l'extrait dans la base de données
	
	$sql_update = "INSERT INTO report_audio (page_id,description,report_id) VALUES ( $page_id , '$description',$report_id)";
	mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'ajout d'un enregistrement dans la base de données".$sql_update);
	
	$audio_id = mysql_insert_id();
	
	$audio_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if (!$error && $audio_upload!= '')
	{
			
		$sql_last = "SELECT * FROM report_audio ORDER BY audio_id DESC";
		$result_last = mysql_query($sql_last);
		$val_audio = mysql_fetch_array($result_last);
			
			upload_fmc(
					$error,
					$error_msg,
					$HTTP_POST_FILES['userfile']['tmp_name'],
					$_FILES['userfile']['name'],
					$_FILES['userfile']['size'],
					dernier_point($_FILES['userfile']['name']),
					'report/audio_'.$val_audio['page_id'].'_'.$val_audio['audio_id']						
					);
			
			if (!$error)
				finish_fmc('report/audio_'.$val_audio['page_id'].'_'.$val_audio['audio_id'],dernier_point($_FILES['userfile']['name']));
			
			if ($error)
			{
				//list($error,$error_msg) = array( true , "Erreur d\'enregistrement");
				$sql_delete = "DELETE FROM report_audio WHERE audio_id = ".$audio_id."";
				mysql_query($sql_delete) or list($error,$error_msg) = array( true , "Erreur durant la suppression dans la base de données apres echec de l'upload".$sql_delete);
			}
	}
}
	if(!$error)
			{
				logger("Ajout d'un extrait audio/video '$description' de la page N°$page_id du reportage N°$report_id");
				$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_page." . $phpEx."?report_id=".$report_id."&page_id=".$page_id) . '">')
				);
				$message =  sprintf($lang['Upload_audio_ok'], '<a href="' . append_sid("edit_page." . $phpEx."?report_id=".$report_id."&page_id=".$page_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);			
			}
	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='report' ORDER BY user_id");

//le reportage selectionné
$val_page = select_element("SELECT * FROM report_pages WHERE  page_id = ".$_GET['page_id']." LIMIT 0,1",'',false);
//le reportage selectionné
$val_report = select_element("SELECT * FROM report WHERE  report_id = ".$_GET['report_id']." LIMIT 0,1",'',false);
$tab_photo = select_liste("SELECT * FROM report_photos WHERE report_id = ".$_GET['report_id']." AND page_id= ".$_GET['page_id']." ORDER BY ordre");
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

// Y a t il des extraits audios
$tab_audio = select_liste("SELECT * FROM report_audio WHERE page_id = ".$_GET['page_id']." ORDER BY audio_id");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/edit_page.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

// On définit le nombre de photos par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_photos = count($tab_photo);
// Pour chaque ligne...
$i=0;
while($i<$nb_photos)
{
	$template->assign_block_vars('photos_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_photos;$j++)
	{
		$ext = find_image('../images/report/photo_' . $_GET['report_id'] . '_' . $tab_photo[$i]['photo_id'].'.');
		if (is_file('../images/report/photo_' . $_GET['report_id'] . '_' . $tab_photo[$i]['photo_id'].'.'.$ext))
		{
			$img = $phpbb_root_path . 'functions/miniature.php?mode=report&report_id=' . $_GET['report_id'] . '&photo_id=' . $tab_photo[$i]['photo_id'];
			$size = getimagesize('../images/report/photo_' . $_GET['report_id'] . '_' . $tab_photo[$i]['photo_id'].'.'.$ext);
	
				if($tab_photo[$i]['description'] == "" && $tab_photo[$i]['photographe']== "")
				{
					$height = $size[1]+30;
				}
				else
				{
					$height = $size[1]+100;		
				}
				
			$onclick = "window.open('photo.php?illu_id=".$tab_photo[$i]['photo_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
		}else
		{
			$img = '../templates/jjgfamille/images/site/px.png';	
		}
		

		$template->assign_block_vars('photos_row.photos_column',array(
							'PAGE' => $page,
							'PHOTO' => $img,
							"DESC" => $tab_photo[$i]['description'],
							"ONCLICK" => $onclick,
							"L_MONTER" => $lang['monter'],
							"U_MONTER" => append_sid($phpbb_root_path . "medias/doedit.php?mode=upphoto&photo_id=".$tab_photo[$i]['photo_id']."&report_id=".$_GET['report_id']),
							"L_DESCENDRE" => $lang['descendre'],
							"U_DESCENDRE" => append_sid($phpbb_root_path . "medias/doedit.php?mode=downphoto&photo_id=".$tab_photo[$i]['photo_id']."&report_id=".$_GET['report_id']),
							"L_SUPPRIMER" => $lang['supprimer'],
							"U_SUPPRIMER" => append_sid($phpbb_root_path . "medias/doedit.php?mode=supp_photo&photo_id=".$tab_photo[$i]['photo_id']."&report_id=".$_GET['report_id']),
							'L_CONFIRM_SUPP_PHOTO' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['photo'])))),
							)
						);
		$i++;
	}
}

if(count($tab_audio)>0)
{
	for ($i=0;$i<count($tab_audio);$i++)
	{
		
		$template->assign_block_vars('switch_audio',array(
							"DESC" => $tab_audio[$i]['description'],
							"L_SUPPRIMER" => $lang['supprimer'],
							"U_DESC" => '../audio/report/audio_'.$_GET['page_id'].'_'.$tab_audio[$i]['audio_id'].'.ram',
							"L_SUBMIT" => $lang['Submit'],	
							"U_FORM" => append_sid("doedit.php?mode=edit_audio&audio_id=".$tab_audio[$i]['audio_id']."&report_id=".$_GET['report_id']."&page_id=".$_GET['page_id']),
							"L_CONFIRM_SUPP_AUDIO" => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['extrait'])))),
							"U_SUPP_AUDIO" => append_sid("doedit.php?mode=supp_audio&audio_id=".$tab_audio[$i]['audio_id']."&report_id=".$_GET['report_id']."&page_id=".$_GET['page_id']),	
							)
						);

	}
}

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
				"L_TITLE" => $val_report['title'], 
				"U_TITLE" => append_sid($phpbb_root_path . 'medias/edit_report.php?report_id='.$val_report['report_id']),
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("edit_page.php?mode=add&report_id=".$_GET['report_id']."&page_id=".$_GET['page_id'].""),													
				"AJOUT_PAGE" => $lang['add_page'], 
				"CONTENU" => $lang['contenu_periode'],
				"L_CONTENU" => preg_replace('/\:(([a-z0-9]:)?)' . $val_page['bbcode_uid'] . '/s', '', $val_page['contenu']),
				"IMAGES_ASSO" => $lang['images_asso'],
				"L_GALERIE_ASSO"=>$lang['galerie_asso'],
				"U_GALERIE_ASSO"=>append_sid("add_photo.php?report_id=".$_GET['report_id']),
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/edit_report.php?report_id='.$val_report['report_id']),
				"EXTRAITS_AV" => $lang['Extraits_a_v'],
				"NOM_EXTRAIT" => $lang['nom_extrait'],
				"MODIFIER_NOM" => $lang['modifier_nom'], 
				'U_SUPP_PAGE' => append_sid($phpbb_root_path . 'medias/doedit.php?mode=supppage&page_id='.$_GET['page_id'].'&report_id='.$_GET['report_id']),
				'L_CONFIRM_SUPP_PAGE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['Page'])))),
				'L_SUPPRIMER_PAGE' => sprintf($lang['delete'],sprintf($lang['la'],$lang['Page'])),
				"ADD_EXTRAITS_AV" => $lang['add_extrait_a_v'],
				"L_DESC" => $lang['Description'],
				"CHEMIN_FILE" => $lang['Chemin du fichier'],
				"RM_ONLY" => $lang['rm_only'],
				"LITTLE" => $lang['très succinte'],
				"U_FORM_AUDIO" => append_sid("edit_page.php?mode=add_audio&report_id=".$_GET['report_id']."&page_id=".$_GET['page_id'].""),				
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
$sitopif = short_desc('report','opif');
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