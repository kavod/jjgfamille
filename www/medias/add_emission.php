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

if ($_GET['mode'] == 'add_support')
{
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	$title = htmlentities($title);
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"Nom du support\" est obligatoire");
	$type_media = $_POST['type_media'];
	$autre = $_POST['autre'];
	$autre = htmlentities($autre);	
	$comment = $_POST['comment'];

	$bbcode_uid = make_bbcode_uid();
	$comment = delete_html($comment);
	$comment=bbencode_first_pass($comment,$bbcode_uid);
	
	$url = $_POST['url'];
	$url = htmlentities($url);	
	$url = ( substr($url,0,7) != "http://" ) ? "http://".$url : $url ;
	
	if (!$error)
	{
		$sql_update = "INSERT INTO media_supports (support_name,media_type,autre,comment,url,bbcode_uid) VALUES ( '".$title."' , '".$type_media."','".$autre."','".$comment."','".$url."','".$bbcode_uid."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
				
		if (!$error)
		{
			logger("Ajout du support $title dans la médiathèque");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("add_emission." . $phpEx) . '">')
				);
				$message =  sprintf($lang['Upload_support_ok'], '<a href="' . append_sid("add_emission." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

if ($_GET['mode'] == 'add_emission')
{
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	$title = htmlentities($title);	
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"Titre\" est obligatoire");
	
	if (!isset($_POST['date']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$date = $_POST['date'];
	$date = htmlentities($date);	
	$date = format_date($date);
	if ($date=="")
		list($error,$error_msg) = array( true , "Le champs \"date\" est obligatoire");
	
	if (!isset($_POST['date_hot']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$date_hot = $_POST['date_hot'];
	$date_hot = htmlentities($date_hot);	
	$date_hot = format_date($date_hot);
	if ($date_hot=="")
		list($error,$error_msg) = array( true , "Le champs \"Nouveau jusqu' à\" est obligatoire");
	
	$support_id = $_POST['support_id'];	
	$bbcode_uid = make_bbcode_uid();
	$comment = $_POST['comment'];
	$comment = delete_html($comment);
	$comment = bbencode_first_pass($comment,$bbcode_uid);
	
	$type_media = $_POST['type_media'];
	$heure = $_POST['heure'];
	$heure = htmlentities($heure);
	
	$artist_id =1;

	if (!$error)
	{
		$sql_update = "INSERT INTO media_emission (support_id,title,description,type,date,heure,artist_id,user_id,username,date_add,date_hot,bbcode_uid) VALUES ( '".$support_id."' , '".$title."' , '".$comment."' , '".$type_media."' , '".$date."' , '".$heure."' , '".$artist_id."',".$userdata['user_id'].",'".$userdata['username']."'," . date('Ymd') . ",'". $date_hot . "','" . $bbcode_uid . "')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
		
		$emission_id = mysql_insert_id();
			
		if (!$error)
		{
			logger("Ajout de l'emission $title dans la médiathèque");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("view_emission." . $phpEx."?emission_id=".$emission_id) . '">')
			);
			$message =  sprintf($lang['Upload_emission_ok'], '<a href="' . append_sid("view_emission." . $phpEx."?emission_id=".$emission_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

//selection de tous les supports
$tab_support = select_liste("SELECT * FROM media_supports ORDER BY support_name,support_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/add_emission.tpl',
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
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("add_emission.php?mode=add_emission"),													
				"AJOUT_EMISSION" => $lang['add_emission'],
				"AJOUT_SUPPORT" => $lang['add_support'],  
				"NOM_SUPPORT" => $lang['nom_support'],
				"TYPE_MEDIA" => $lang['type_media'],
				"SI_AUTRE" => $lang['si_autre'],
				"DESC" =>  $lang['Description'],
				"SITE_WEB" => $lang['site_web'],
				"TV" =>$lang['tv'],
				"RADIO"=>$lang['radio'],
				"PRESSE"=>$lang['presse'],
				"INTERNET"=>$lang['internet'],
				"OTHER"=>$lang['other'],
				"P_OTHER"=>$lang['p_other'],
				"U_FORM_SUPPORT" => append_sid("add_emission.php?mode=add_support"),
				"L_TITRE" => $lang['l_titre'],
				"L_TYPE" => $lang['Type'],
				"L_SUPPORT" => $lang['Support'],
				"L_DATE" => $lang['Date'],
				"L_DATE_HOT" => $lang['Date_hot'],
				"L_HEURE" => $lang['Heure'],	
				"ITW" => $lang['interview'],
				"REPORTAGE" => $lang['reportage'],
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/medias.php'),			
			)
);

for ($i=0;$i<count($tab_support);$i++)
			{
	
				$template->assign_block_vars('support',array(
						"VALUE" => $tab_support[$i]['support_id'],
      						"INTITULE" => $tab_support[$i]['support_name'],
      						
						)
					);

			}

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