<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'famille';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mode'] == 'add_mascotte')
{
	$error = false;
	$error_msg = '';
	$rub_id = $_GET['rub_id'];
	
	include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy(
					$error,
					$error_msg,
					$HTTP_POST_FILES['userfile'],
					$phpbb_root_path . 'images/famille/rub_' . $rub_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['mascotte_max_width'],
						$site_config['mascotte_max_height'])
					);
			
		}
			
		if (!$error)
		{
			logger("Ajout de la mascotte de la rubrique N°$rub_id dans famille");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "famille/rub." . $phpEx . "?rub_id=".$rub_id) . '">')
				);
				$message =  sprintf($lang['Upload_rub_ok'], '<a href="' . append_sid($phpbb_root_path . "famille/rub." . $phpEx . "?rub_id=".$rub_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}	
}

if ($_GET['mode'] == 'modif')
{
	$error = false;
	$error_msg = '';
		
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"Nom\" est obligatoire");
	$title = htmlentities($title);
	
	if (!isset($_POST['desc']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$desc = $_POST['desc'];
	if ($desc=="")
		list($error,$error_msg) = array( true , "Le champs \"Descrption\" est obligatoire");
	$desc = htmlentities($desc);
	
	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$comment = $_POST['comment'];
		
	$bbcode_uid = make_bbcode_uid();
	$comment = delete_html($comment);
	$comment=bbencode_first_pass($comment,$bbcode_uid);
	
	if (!$error)
	{
		$sql_update = "UPDATE famille_rub SET name='".$title."',description='".$desc."',contenu='".$comment."',bbcode_uid='".$bbcode_uid."' WHERE rub_id=".$_GET['rub_id']." ";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
	
		if (!$error)
		{
			logger("Modification de la rubrique $title dans famille");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("rub." . $phpEx . "?rub_id=".$_GET['rub_id']) . '">')
				);
				$message =  sprintf($lang['Upload_rub_ok'], '<a href="' . append_sid("rub." . $phpEx . "?rub_id=".$_GET['rub_id']) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}



$val_rubrique = select_element("SELECT * FROM famille_rub WHERE rub_id=".$_GET['rub_id']."",'',false);
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array());

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $val_rubrique['name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/rub.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}


$template->assign_vars($rubrikopif[0]);


if ($img_mascotte)
$mascotte = $img_mascotte;

if ( $userdata['user_level'] == ADMIN )
{
	$l_supp = $lang['supprimer'];
	$u_supp = append_sid($phpbb_root_path . 'famille/doedit.php?mode=supp_rub&rub_id='.$_GET['rub_id']);
}

$ext = find_image('../images/famille/rub_'.$val_rubrique['rub_id'].'.');
if(is_file('../images/famille/rub_'.$val_rubrique['rub_id'].'.'.$ext))
{
	$picture = '../images/famille/rub_'.$val_rubrique['rub_id'].'.'.$ext;

}
else 
{
	$picture = '../templates/jjgfamille/images/site/px.png';
}


$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),	
				"CONTENU" => nl2br(bbencode_second_pass($val_rubrique['contenu'],$val_rubrique['bbcode_uid'])),
				"L_RUB" => $val_rubrique['name'],
				"L_SUPP" => $l_supp,
				"U_SUPP" => $u_supp,
				'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['rubrique'])))),
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/'),
				'L_RDF' => $lang['Réunion De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'IMG' => $picture,
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'famille/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
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

if ( $userdata['user_level'] == ADMIN )
{
	
	$ext = find_image('../images/famille/rub_'.$val_rubrique['rub_id'].'.');
	if(is_file('../images/famille/rub_'.$val_rubrique['rub_id'].'.'.$ext))
	{
		$picture = '<img src="../images/famille/rub_'.$val_rubrique['rub_id'].'.'.$ext.'" border="0">';
		$l_supp_image = $lang['supp_image'];
	}
	else 
	{
		$picture = '';	
	}

		$template->assign_block_vars('switch_admin',array(
						"NOM_RUB" => $lang['admin_famille'],
						"ADD_RUB" => $lang['Modifier']."&nbsp;".sprintf($lang['la'],$lang['rubrique']),
						"NOM" => $lang['nom'],
						"DESC" => $lang['description'],
						"CONTENU" => $lang['contenu_periode'],
						"L_NOM" => $val_rubrique['name'],
						"L_DESC" => $val_rubrique['description'],
						"L_CONTENU" => str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_rubrique['bbcode_uid'] . '/s', '', $val_rubrique['contenu'])),
						"U_FORM" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$_GET['rub_id'].'&mode=modif'),
						"L_SUBMIT" => $lang['Submit'],
						'PICTURE' => $picture,
						'MASCOTTE' => $lang['Mascotte'],
						'U_SUPP_IMAGE' => append_sid($phpbb_root_path . 'famille/doedit.php?mode=supp_mascotte&rub_id='.$val_rubrique['rub_id']),
						'L_SUPP_IMAGE' => $l_supp_image,
						'L_CONFIRM_SUPP_ILLU' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['mascotte'])))),
						'U_FORM_PIC' => append_sid($phpbb_root_path . 'famille/rub.php?mode=add_mascotte&rub_id='.$val_rubrique['rub_id']),
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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>