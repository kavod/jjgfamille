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

include($phpbb_root_path . 'includes/log_necessary.php');

$rdf_id = $_GET['rdf_id'];

if ($_GET['mode'] == 'add')
{
	$error = false;
	$error_msg = '';
		
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
			
	$comment = $_POST['comment'];
	$photographe = $_POST['photographe'];
	$comment = htmlentities($comment);
	$photographe = htmlentities($photographe);
	
	$sql_ordre = "SELECT ordre FROM rdf_photos ORDER BY ordre DESC";
		        $result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br />Requète SQL : ".$sql_ordre);
                        if (!$val_ordre = mysql_fetch_array($result_ordre))
			   $val_ordre['ordre']=0;
		
		           $val_ordre['ordre']++;
	
	if (!$error)
	{
		$sql_update = "INSERT INTO rdf_photos (rdf_id,user_id,username,description,photographe,ordre) VALUES ( '".$rdf_id."' , '".$userdata['user_id']."' , '".$userdata['username']."', '".$comment."' , '".$photographe."','".$val_ordre['ordre']."')";
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
					$phpbb_root_path . 'images/rdf/photo_' . $rdf_id .'_'.$photo_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['photo_max_width'],
						$site_config['photo_max_height'])
					);
			if ($error)
			{
				$sql_del = "DELETE FROM  rdf_photos WHERE photo_id = " . $photo_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
			}
		}
		
		if (!$error)
		{
			logger("Ajout de la photo de la rdf $rdf_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("view_rdf." . $phpEx."?rdf_id=".$rdf_id) . '">')
			);
			$message =  sprintf($lang['Upload_photo_rdf_ok'], '<a href="' . append_sid("view_rdf." . $phpEx."?rdf_id=".$rdf_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
//la rdf séléctionnée
$val_rdf = select_element("SELECT * FROM rdf WHERE rdf_id= ".$rdf_id." LIMIT 0,1",'',false);
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');
//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Réunion De Famille'].' '.$lang['add_photo'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/add_photo.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

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
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/view_rdf.php?rdf_id='.$rdf_id),
				'L_RETOUR' => $lang['retour'],
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("add_photo.php?rdf_id=".$rdf_id."&mode=add"),													
				"AJOUT_PHOTO" => $lang['add_photo'], 
				"L_DESC" => $lang['Description'], 
				"L_PHOTOGRAPHE" => sprintf($lang['photographe'],''), 
				"L_ILLU" =>  $lang['chemin_photo'], 				
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

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
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