<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions_media.php');
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

	$support_id = $_GET['support_id'];
	
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"Nom du support\" est obligatoire");
	$title = htmlentities($title);
	
	$typemedia = $_POST['type_media'];
	$autre = $_POST['autre'];
	$autre = htmlentities($autre);
	$bbcode_uid = make_bbcode_uid();
	$comment = $_POST['comment'];
	$comment = delete_html($comment);
	$comment=bbencode_first_pass($comment,$bbcode_uid);
	
	$url = $_POST['url'];
	$url = htmlentities($url);
	$url = ( substr($url,0,7) != "http://" ) ? "http://".$url : $url ;
	
		
	if (!$error)
	{
		$sql_update = "UPDATE media_supports SET support_name = '".$title."',media_type = '".$typemedia."',autre = '".$autre."',comment = '".$comment."',url = '".$url."',bbcode_uid = '".$bbcode_uid."' WHERE support_id = ".$support_id." ";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		if (!$error)
		{
			logger("Modification du support $title dans la médiathèque");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("support." . $phpEx."?support_id=".$support_id) . '">')
			);
			$message =  sprintf($lang['Upload_support_ok'], '<a href="' . append_sid("support." . $phpEx."?support_id=".$support_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

//Les informations du support
$val_support = select_element("SELECT * FROM media_supports WHERE support_id=".$_GET['support_id']." ",'',false);

//Liste des supports
$tab_support = select_liste("SELECT * FROM media_supports");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//Liste des emissions referencées
$tab_liste = select_liste("SELECT * FROM media_emission WHERE support_id=".$_GET['support_id']." ORDER BY date,heure");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/support.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

//Type du media
$media_type = $val_support['media_type'];
if($val_support['media_type']=="Autre")
{
	$media_type = $val_support['autre'];
}


switch($val_support['media_type'])
			{
		case 'TV':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/tv.png" border="0" alt="'.$lang['emission_tv'].'"/>';
			break;
		case 'Radio':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/radio.png" border="0" alt="'.$lang['emission_radio'].'"/>';
			break;
		case 'Presse':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/journal.png" border="0" alt="'.$lang['article_presse'].'"/>';			
			break;
		case 'Internet':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/internet.png" border="0" alt="'.$lang['article_internet'].'"/>';
			break;
		case 'Autre':
		default:
			$icon_support = '';
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
				"TITRE" => $val_support['support_name'],
           			"COMMENT" => nl2br(bbencode_second_pass($val_support['comment'],$val_support['bbcode_uid'])),
           			"MEDIA_TYPE" => $media_type,
           			"URL" => $val_support['url'],
           			"TYPE_MEDIA" =>$lang['type_media'],
				"DESC" => $lang['Description'],
				"L_URL" => $lang['URL'],
				"LISTE_EMISSIONS" => $lang['liste_emissions'],
				'ICON_SUPPORT' => $icon_support,
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/medias.php'),	
			)
);

for ($i=0;$i<count($tab_liste);$i++)
{	

	$template->assign_block_vars('switch_liste',template_emission($tab_liste[$i],false));
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

		if ($val_support['media_type']=='TV')
		{ 
			$select_tv = 'SELECTED';
			
		}
		else 
		{
			$select_tv = '';
		}

		if ($val_support['media_type']=='Radio') 
		{
			$select_radio = 'SELECTED';
		}
		else 
		{
			$select_radio = '';
		}
		
		if ($val_support['media_type']=='Presse') 
		{
			$select_presse = 'SELECTED';
		}
		else 
		{
			$select_presse = '';
		}
		if ($val_support['media_type']=='Internet') 
		{
			$select_internet = 'SELECTED';
		}
		else 
		{
			$select_internet = '';
		}
		if ($val_support['media_type']=='Autre' or $val_support['media_type']=='') 
		{
			$select_autre = 'SELECTED';
		}
		else
		{
		 	$select_autre = '';
		}
				
		$template->assign_block_vars('switch_admin',array(
						'ADMIN_MEDIAS' => $lang['medias_admin'],
						"TITRE" => addslashes($val_support['support_name']),
           					"COMMENT" => preg_replace('/\:(([a-z0-9]:)?)' . $val_support['bbcode_uid'] . '/s', '', $val_support['comment']),
           					"URL" => addslashes($val_support['url']),
           					"L_SUBMIT" => $lang['Submit'],
           					"AUTRE" => addslashes($val_support['autre']),
           					"U_FORM" => append_sid("support.php?support_id=".$val_support['support_id']."&mode=modif"),
						"TYPE_MEDIA" =>$lang['type_media'],
						"DESC" => $lang['Description'],				
						"LISTE_SUPPORTS" =>$lang['liste_supports'],
						"MODIF_SUPPORTS" =>$lang['modif_supports'],
						"SITE_WEB" =>$lang['site_web'],
						"NOM_SUPPORT" =>$lang['nom_support'],
						"SI_AUTRE" =>$lang['si_autre'],
						"EMISSIONS_ARTICLES" => $lang['emissions_articles'],
						"TV" => $lang['tv'],
						"PRESSE" => $lang['presse'],
						"RADIO" => $lang['radio'],
						"INTERNET" => $lang['internet'],
						"OTHER"=> $lang['other'],
						"P_OTHER"=> $lang['p_other'],
						"SELECT_TV" => $select_tv,
						"SELECT_RADIO" => $select_radio,
						"SELECT_PRESSE" => $select_presse,
						"SELECT_INTERNET" => $select_internet,
						"SELECT_AUTRE" => $select_autre,														
						)
					);
		
		for ($i=0;$i<count($tab_support);$i++)
			{
					$val_count = select_element("SELECT COUNT(emission_id) as nb FROM media_emission WHERE support_id = ".$tab_support[$i]['support_id']." ");
					
					if($val_count['nb']==0)
						$supprimer = $lang['supprimer'];
					else $supprimer = '';
					
					$template->assign_block_vars('switch_admin.switch_support',array(
						"L_TITRE" => $tab_support[$i]['support_name'],
						"U_TITRE" => append_sid("support.php?support_id=".$tab_support[$i]['support_id'].""),
						"COUNT" => $val_count['nb'],
						"L_CONFIRM_SUPPORT" => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['support'])))),
						"U_SUPP_SUPPORT" => append_sid("doedit.php?mode=supp_support&support=".$tab_support[$i]['support_id']."&support_id=".$_GET['support_id']),
						"L_SUPP_SUPPORT" => $supprimer,
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