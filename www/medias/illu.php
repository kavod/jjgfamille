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

if ($_GET['mode'] == 'modif')
{
	$error = false;
	$error_msg = '';
	$emission_id = $_GET['emission_id'];
	$illustration_id = $_POST['illustration_id'];
	
	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$comment = $_POST['comment'];
	
	if (!isset($_POST['photographe']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$photographe = $_POST['photographe'];
	
	$comment = htmlentities($comment);
	$photographe = htmlentities($photographe);
		
	if (!$error)
	{
		$sql_update = "UPDATE media_illustrations SET description  = '".$comment."',photographe='".$photographe."' WHERE illustration_id = ".$illustration_id." ";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		if (!$error)
		{
			logger("Modification de l'illustration N°$illustration_id de l'emission N°$emission_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("illu." . $phpEx."?emission_id=".$emission_id) . '">')
			);
			$message =  sprintf($lang['Upload_illustration_ok'], '<a href="' . append_sid("illu." . $phpEx."?emission_id=".$emission_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

//Les informations du support
$tab_illustration = select_liste("SELECT * FROM media_illustrations WHERE emission_id=".$_GET['emission_id']." ");

//illustration de ?
$val_emission = select_element("SELECT * FROM media_emission WHERE emission_id=".$_GET['emission_id']." ",'',false);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/illu.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

	//illustration par
				$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = ".$val_emission['user_id']." ",'',false);
				if ($val_user)
				{
					$l_user = $val_user['username'];
					$u_user = append_sid("../forum/privmsg.php?mode=post&u=".$val_user['user_id']."");
				} else
				{
					$l_user = $val_emission['username'];
					$u_user = '';
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
				"DESCRIPTION" => nl2br(bbencode_second_pass($val_illustration['description'],$val_illustration['bbcode_uid'])),
				"L_TITLE" => $val_emission['title'], 
				"U_TITLE" => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$_GET['emission_id']),
				"L_USER" => $l_user,
				"U_USER" => $u_user, 
				"RETRAN" => $lang['Illustrations'],
				"DE" => $lang['de'], 
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$_GET['emission_id']),      				
			)
);


// On définit le nombre de photo par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_illus = count($tab_illustration);
// Pour chaque ligne...
$i=0;
while($i<$nb_illus)
{
	$template->assign_block_vars('illus_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_illus;$j++)
	{
		$url_image = $phpbb_root_path . 'images/medias/illustration_'.$val_emission['emission_id'].'_'.$tab_illustration[$i]['illustration_id'].'.';
		$url_image .= find_image($url_image);
				if (is_file($url_image))
					$image = $phpbb_root_path . 'functions/miniature.php?mode=medias&illu_id=' . $tab_illustration[$i]['illustration_id'] . '&emission_id=' . $val_emission['emission_id'];
					else $image = '';
	
				$size = getimagesize($url_image);
	
				if($tab_illustration[$i]['description'] == "" && $tab_illustration[$i]['photographe']== "")
				{
					$height = $size[1]+30;
				}
				else
				{
					$height = $size[1]+180;		
				}
				
			$onclick = "window.open('illustration.php?illu_id=".$tab_illustration[$i]['illustration_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
				
		$template->assign_block_vars('illus_row.illus_column',array(
							'ILLU' => $image,
							'ONCLICK' => $onclick,
							'PHOTOGRAPHE'=> sprintf($lang['photographe'],$tab_illustration[$i]['photographe']),
							)
						);
		$i++;
	}
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'media'))
{

						
		$template->assign_block_vars('switch_admin',array(
						'ADMIN_MEDIAS' => $lang['medias_admin'],
						"MODIF_ILLU" => $lang['modif_illustration'],
						"L_SUPP" => $lang['supp_illustration'],	
						"L_SUBMIT" => $lang['Submit'],													
						)
					);
					
		for ($i=0;$i<count($tab_illustration);$i++)
			{
				$url_image = $phpbb_root_path . 'images/medias/illustration_'.$val_emission['emission_id'].'_'.$tab_illustration[$i]['illustration_id'].'.';
				$url_image .= find_image($url_image);
				if (is_file($url_image))
					$image = $url_image;
					else $image = '';
		
	
			$template->assign_block_vars('switch_admin.switch_illu',array(
								'ILLU' => $image,
								'L_PHOTOGRAPHE'=> sprintf($lang['photographe'],''),
								'L_DESC' => $lang['Description'],
								"COMMENT" => $tab_illustration[$i]['description'],
								"U_SUPP" => append_sid("doedit.php?mode=supp_illu&illu_id=".$tab_illustration[$i]['illustration_id']."&emission_id=".$_GET['emission_id']),
								"PHOTOGRAPHE" => $tab_illustration[$i]['photographe'],
								"U_FORM" => append_sid("illu.php?emission_id=".$_GET['emission_id']."&mode=modif"),
								"ILLU_ID" => $tab_illustration[$i]['illustration_id'],
								'L_CONFIRM_SUPP_PHOTO' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['picture_bio'])))),
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