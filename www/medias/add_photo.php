<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
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
	
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
			
	$comment = $_POST['comment'];
	$photographe = $_POST['photographe'];
	$comment = htmlentities($comment);
	$photographe = htmlentities($photographe);
	
	$sql_photos = "SELECT ordre FROM report_photos WHERE report_id = ".$report_id." ORDER BY ordre DESC LIMIT 0,1";
		$result_photos = mysql_query($sql_photos);
		if ($val_photos = mysql_fetch_array($result_photos))
		{
			$ordre = $val_photos['ordre'] + 1;
		} else
		{
			$ordre = 1;
		}
		mysql_free_result($result_photos);
		
	if (!$error)
	{
			
		$sql_update = "INSERT INTO report_photos (description,photographe,report_id,ordre,page_id) VALUES ('".$comment."','".$photographe."','".$report_id."','".$ordre."',0)";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);

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
					$phpbb_root_path . 'images/report/photo_' . $report_id .'_'.$photo_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['photo_max_width'],
						$site_config['photo_max_height'])
					);
			if ($error)
			{
				$sql_del = "DELETE FROM  report_photos WHERE photo_id = " . $photo_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
			}
		}
		
		if (!$error)
		{
			logger("Ajout d'une photo dans le reportage N°$report_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("add_photo." . $phpEx."?report_id=".$report_id) . '">')
			);
			$message =  sprintf($lang['Upload_photo_report_ok'], '<a href="' . append_sid("add_photo." . $phpEx."?report_id=".$report_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='report' ORDER BY user_id");

//l'emission selectionné
$val_report = select_element("SELECT * FROM report WHERE  report_id= ".$_GET['report_id']." LIMIT 0,1",'',false);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

$tab_photo = select_liste("SELECT * FROM report_photos WHERE report_id = ".$_GET['report_id']." ORDER BY ordre");

$tab_pages = select_liste("SELECT page_id FROM report_pages WHERE report_id = '".$_GET['report_id']."' ORDER BY ordre");
for ($i=0;$i<count($tab_pages);$i++)
	$ordre_page[$tab_pages[$i]['page_id']] = $i+1;
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/add_photo.tpl',
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
		
			$page =  sprintf($lang['page'],$ordre_page[$tab_photo[$i]['page_id']])."&nbsp;:&nbsp;";
		
		$template->assign_block_vars('photos_row.photos_column',array(
							'PAGE' => $page,
							'PHOTO' => $img,
							"DESC" => $tab_photo[$i]['description'],
							"ONCLICK" => $onclick,
							"L_MODIFIER" => $lang['modifier'],
							"U_MODIFIER" => append_sid("edit_photo.php?photo_id=".$tab_photo[$i]['photo_id']),
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
				"U_FORM" => append_sid("add_photo.php?report_id=".$_GET['report_id']."&mode=add"),													
				"AJOUT_ILLU" => $lang['add_photo'], 
				"L_DESC" => $lang['Description'], 
				"L_PHOTOGRAPHE" => sprintf($lang['photographe'],''), 
				"L_ILLU" =>  $lang['chemin_photo'],  
				"GALERIE_ACTUELLE" => $lang['galerie_actuelle'], 
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/edit_report.php?report_id='.$val_report['report_id']),			
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