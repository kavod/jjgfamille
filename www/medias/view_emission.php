<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/url_rewriting.php');
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
	
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"titre\" est obligatoire");
	$title = htmlentities($title);
	
	if (!isset($_POST['date']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$date = $_POST['date'];
	if ($date=="")
		list($error,$error_msg) = array( true , "Le champs \"date\" est obligatoire");
	$date = htmlentities($date);
	if($date!="")
		$date = format_date($date);
	
	if (!isset($_POST['date_hot']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$date_hot = $_POST['date_hot'];
	if ($date_hot=="")
		list($error,$error_msg) = array( true , "Le champs \"Nouveau jusqu' à\" est obligatoire");
	$date_hot = htmlentities($date_hot);
	if($date_hot!="")
		$date_hot = format_date($date_hot);
	
	$support_id = $_POST['support_id'];
	$bbcode_uid = make_bbcode_uid();
	$comment = $_POST['comment'];
	$comment = delete_html($comment);
	$comment=bbencode_first_pass($comment,$bbcode_uid);

	$typemedia = $_POST['type_media'];
	$heure = $_POST['heure'];
	$heure = htmlentities($heure);
	$album_id = $_POST['album_id'];
		
	if (!$error)
	{
		$sql_update = "UPDATE media_emission SET support_id = '".$support_id."',title = '".$title."',description = '".$comment."',type = '".$typemedia."',refer = ".$album_id.",date= '".$date."',heure= '".$heure."',date_hot='".$date_hot."',bbcode_uid='".$bbcode_uid."' WHERE emission_id = ".$emission_id." ";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		if (!$error)
		{
			logger("Modification de l'emission $title");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("view_emission." . $phpEx."?emission_id=".$emission_id) . '">')
			);
			$message =  sprintf($lang['Upload_emission_ok'], '<a href="' . append_sid("view_emission." . $phpEx."?emission_id=".$emission_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

//l'emission selectionné
$val_emission = select_element("SELECT * FROM media_emission WHERE  emission_id= ".$_GET['emission_id']." LIMIT 0,1",'',false);

//selection de tous les supports
$tab_support = select_liste("SELECT * FROM media_supports ORDER BY support_id");

//selection de tous les albums
$tab_album = select_liste("SELECT * FROM disco_albums WHERE type IN ('l\'album','le live')  AND artist_id=1 ORDER BY title");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'].' :: '.$val_emission['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/view_emission.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

//Mascotte
if ($img_mascotte)
$mascotte = $img_mascotte;

	//On cherche les informations du support
		$val_support = select_element("SELECT * FROM media_supports WHERE support_id=".$val_emission['support_id']." ");
			
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
			
	// Y a t'il une heure
		if($val_emission['heure']<>"")
			$heure = "<b>Heure</b> : ".$val_emission['heure'];
	
	//Date americain => francais
		$date = "<b>Date</b> : ".affiche_date($val_emission['date']);

	//Emission annoncé par
		$val_annonceur = select_element("SELECT * FROM phpbb_users WHERE user_id = ".$val_emission['user_id']." ",'',false);
			if ($val_annonceur)
				{
					$u_annonceur = append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_annonceur['user_id'].'');
					$l_annonceur= $val_annonceur['username'];
				} else
				{
					$u_annonceur = '';
					$l_annonceur = $val_emission['username'];
				}
	
	//Type d'emission
	switch ($val_emission['type'])
		{
			case "Itw":
				$type="Interview";
				break;
			case "report":
				$type="Reportage";
				break;
			case "autre":
				$type="Autre";
				break;
			default :
				$type=$val_emission['autre'];
		}
		
	//Les illustrations 
				
		$tab_illu = select_liste("SELECT * FROM media_illustrations WHERE emission_id= ".$_GET['emission_id']." ORDER BY RAND() LIMIT 0,1");
		for ($i=0;$i<count($tab_illu);$i++)
			{
				$url_image = $phpbb_root_path . 'images/medias/illustration_'.$val_emission['emission_id'].'_'.$tab_illu[$i]['illustration_id'].'.';
				$url_image .= find_image($url_image);
				if (is_file($url_image))
					$image = $phpbb_root_path . 'functions/miniature.php?mode=medias&illu_id=' . $tab_illu[$i]['illustration_id'] . '&emission_id=' . $val_emission['emission_id'];
					else $image = '';
	
				$size = getimagesize($url_image);
	
				if($tab_illu[$i]['description'] == "" && $tab_illu[$i]['photographe']== "")
				{
					$height = $size[1]+30;
				}
				else
				{
					$height = $size[1]+180;		
				}
				
			$onclick = "window.open('illustration.php?illu_id=".$tab_illu[$i]['illustration_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
	
			$template->assign_block_vars('switch_illu',array(
								'ILLU' => $image,
								'ONCLICK' => $onclick,
								)
							);
			}
	
	//Cette emission refere-t-elle a un album 
	if($val_emission['refer']==0)
	{
		$refer = $lang['refer_no_album'];
	}else
	{
		$val_refer = select_element("SELECT album_id,title FROM disco_albums WHERE album_id=".$val_emission['refer']."");
		$u_album = append_sid($phpbb_root_path . "disco/goldman_album_".$val_refer['album_id']."_" . url_title($val_refer['title']) .'.html');
		$refer = $lang['refer_album']."&nbsp;<b><a href=".$u_album.">".$val_refer['title']."</a></b>";
	}
	
	//Les retranscriptions
	$img_retranscription = '<img src="' . $phpbb_root_path . 'images/texte.gif" border="0">';
	$val_retranscription = select_element("SELECT COUNT(*) FROM media_retranscriptions WHERE emission_id = ".$val_emission['emission_id']." ");
	if ($val_retranscription[0] == 0 )
	{
		$retranscription = $lang['no_retran'];
	}else
	{
		$tab_retranscription = select_liste("SELECT * FROM media_retranscriptions WHERE emission_id= ".$_GET['emission_id']."");		
		for ($i=0;$i<count($tab_retranscription);$i++)
			{
					//Retranscirption annoncé par
				$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = ".$tab_retranscription[$i]['user_id']." ",'',false);
				if ($val_user)
				{
					$l_user = $val_user['username'];
					$u_user = append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_user['user_id'].'');
					//$u_titre = append_sid($phpbb_root_path . 'medias/retranscription.php?retranscription_id='.$tab_retranscription[$i]['retranscription_id'].''); 
					$u_titre = append_sid($phpbb_root_path . "medias/retranscription-" . str_replace('&amp;url_title=','',add_title_in_url($val_support['support_name'] . '-' . $val_emission['title'])). '-' . $tab_retranscription[$i]['retranscription_id'] . '.html');
					$l_titre= '<b>'.$lang['num_retran'].($i+1).'</b>';
				} else
				{
					$u_user = '';
					$l_user = $tab_retranscription[$i]['username'];
					$u_titre = append_sid('retranscription.php?retranscription_id='.$tab_retranscription[$i]['retranscription_id'].''); 
					$l_titre= '<b>'.$lang['num_retran'].($i+1).'</b>';
				}
								
			$template->assign_block_vars('switch_retranscription',array(
								'U_TITRE' => $u_titre,
								'L_TITRE' => $l_titre,
								'U_USER' => $u_user,
								'L_USER' => $l_user,
								'PAR' => $lang['par'],
								)
							);
			}
				
	}
	
	//Les illustrations
		$img_illu = '<img src="' . $phpbb_root_path . 'images/picture.gif" border="0">';
		$val_illu = select_liste("SELECT COUNT(*) nb_illus, username FROM media_illustrations WHERE emission_id=".$val_emission['emission_id']." GROUP BY username");
			if (count($val_illu) == 0 )
			{
				$illu = $lang['no_illu'];
			}else
			{	
				for ($i=0;$i<count($val_illu);$i++)
				{
					
					$l_illus = $val_illu[$i]['nb_illus'].'&nbsp;'.$lang['illustrations'].'&nbsp;'.$lang['de'].'&nbsp;'.$val_illu[$i]['username'];
					$u_illus = append_sid('illu.php?emission_id='.$val_emission['emission_id'].'');
					$template->assign_block_vars('switch_illustration',array(
								'U_ILLUS' => $u_illus,
								'L_ILLUS' => $l_illus,
								)
							);				
				
				}
			}
	
	
	//Les extraits audios
	$img_audio = '<img src="' . $phpbb_root_path . 'images/real.gif" border="0">';
	$val_audio = select_element("SELECT COUNT(*) FROM media_audio WHERE emission_id = ".$val_emission['emission_id']." ");
	if ($val_audio[0] == 0 )
	{
		$audio = $lang['no_extrait'];
	}else
	{
		$tab_audio = select_liste("SELECT * FROM media_audio WHERE emission_id= ".$_GET['emission_id']." ORDER BY audio_id");		
		for ($i=0;$i<count($tab_audio);$i++)
		{
			//Extraits annoncé par
			$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = ".$tab_audio[$i]['user_id']." ",'',false);
			if ($val_user)
			{
				$l_user = $val_user['username'];
				$u_user = append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_user['user_id'].'');
				$l_titre= $tab_audio[$i]['description'];
				$u_titre = '';
			} else
			{
				$l_user = $tab_audio[$i]['username'];
				$u_user = '';
				$l_titre= $tab_audio[$i]['description'];
				$u_titre = '';
			}
			$onclick = "window.open('../fmc/jukebox.php?mode=media&id=".$tab_audio[$i]['audio_id']."','Jukebox','noresizable,scrollbars=yes,menubar=auto,width=800,height=500,left=100,top=100')";
			
								
			$template->assign_block_vars('switch_audio',array(
								'L_TITRE' => $l_titre,
								'U_TITRE' => $u_titre,
								'L_USER' => $l_user,
								'U_USER' => $u_user,
								'PAR' => $lang['par'],
								"ONCLICK" => $onclick,
								)
							);
			if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'media'))
			{
				$template->assign_block_vars('switch_audio.admin',array(
								'L_SUPP' => $lang['supprimer'],
								'U_SUPP' => append_sid($phpbb_root_path . "medias/doedit.php?mode=supp_audio_media&audio_id=".$tab_audio[$i]['audio_id']."&emission_id=".$_GET['emission_id']),
								));
								
			}
		}	
				
	}
								
$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['nom_rub_media'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/mediatheque.html'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.html'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				'L_TITLE' => $val_emission['title'],
				'DESCRIPTION' => nl2br(bbencode_second_pass($val_emission['description'],$val_emission['bbcode_uid'])),
				'HEURE' => $heure,
				'DATE' => $date,
				'L_SUPPORT' => $val_support['support_name'],
				'U_SUPPORT' => append_sid($phpbb_root_path . "medias/goldman-dans-".str_replace('&amp;url_title=','',add_title_in_url($val_support['support_name'])) . '-' . $val_support['support_id'].".html"),
				'L_ANNONCEUR'  => $l_annonceur,
				'U_ANNONCEUR'  => $u_annonceur,
				'TYPE' => $type,
				'REFER' => $refer,
				'IMG_RETRANSCRIPTION' => $img_retranscription,
				'RETRANSCRIPTION' => $retranscription,
				'IMG_ILLU' => $img_illu,
				'ILLU' => $illu,
				'IMG_AUDIO' => $img_audio,
				'AUDIO' => $audio,
				'ICON_SUPPORT' => $icon_support,
				'U_ARCHIVES' => append_sid($phpbb_root_path . 'medias/media_archives.php'),
				'L_ARCHIVES' => $lang['go_to_the_archives'],
				"ANNONCE_PAR" => $lang['annonce_par'],
				"TYPE_EMISSION" => $lang['type_emission'],
				'DESC' => $lang['Description'],
				'RETRAN_ECRITE' => $lang['retran_ecrite'],
				'IS_YOU_TO_PLAY' => $lang['it_is_you_to_play'],
				'PAR' => $lang['par'],
				'U_ADD_RETRANSCRIPTION' => append_sid($phpbb_root_path . 'medias/add_retranscription.php?emission_id='.$val_emission['emission_id']),
				'L_ADD_RETRANSCRIPTION' => $lang['add_retranscription'],
				'ILLUSTRATIONS' => $lang['Illustrations'],
				'U_ADD_ILLU' => append_sid($phpbb_root_path . 'medias/add_illustration.php?emission_id='.$val_emission['emission_id']),
				'L_ADD_ILLU' => $lang['add_illu'],
				'AUDIOS_VIDEOS' => $lang['Extraits_a_v'],
				'U_ADD_EXTRAIT' => append_sid($phpbb_root_path . 'medias/add_extrait.php?emission_id='.$val_emission['emission_id']),
				'L_ADD_EXTRAIT' => $lang['add_extrait_a_v'],
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/mediatheque.html'),
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
						'U_RESP' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'media'))
{
		
		
		if ($val_emission['type']=='itw')
		{ 
			$select_itw = 'SELECTED';
			
		}
		else 
		{
			$select_itw = '';
		}

		if ($val_emission['type']=='report') 
		{
			$select_report = 'SELECTED';
		}
		else 
		{
			$select_radio = '';
		}
		if ($val_emission['type']=='autre' or $val_emission['type']=='') 
		{
			$select_autre = 'SELECTED';
		}
		else
		{
		 	$select_autre = '';
		}
		
				
		$template->assign_block_vars('switch_admin',array(
						'ADMIN_MEDIAS' => $lang['medias_admin'],
						"TITRE" => stripslashes($val_emission['title']),
           					"COMMENT" => str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_emission['bbcode_uid'] . '/s', '', $val_emission['description'])),
           					"DATE" => stripslashes(affiche_date($val_emission['date'])),
           					"DATE_HOT" => stripslashes(affiche_date($val_emission['date_hot'])),
           					"L_SUBMIT" => $lang['Submit'],
           					"HEURE" => stripslashes($val_emission['heure']),
           					"U_FORM" => append_sid("view_emission.php?emission_id=".$val_emission['emission_id']."&mode=modif"),
						'DESC' => $lang['Description'],
						"RADIO" => $lang['radio'],
						"INTERNET" => $lang['internet'],
						"OTHER"=> $lang['other'],
						"SELECT_ITW" => $select_itw,
						"SELECT_REPORTAGE" => $select_report,
						"SELECT_AUTRE" => $select_autre,
						"ITW" => $lang['interview'],
						"REPORTAGE" => $lang['reportage'],
						"U_SUPP" => append_sid("doedit.php?mode=supp_emission&emission_id=".$val_emission['emission_id'].""),
						"L_SUPP" => $lang['supp_emission'],
						'L_CONFIRM_SUPP_EMISSION' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['emission'])))),
						"MODIF_EMISSION" => $lang['modif_emission'],
						"L_TITRE" => $lang['l_titre'],
						"L_TYPE" => $lang['Type'],
						"L_SUPPORT" => $lang['Support'],
						"L_DATE" => $lang['Date'],
						"L_DATE_HOT" => $lang['Date_hot'],
						"L_HEURE" => $lang['Heure'],
						"REFER_NEXT" => $lang['refer_album_next'],																		
						)
					);
					
		for ($i=0;$i<count($tab_support);$i++)
			{
	
				$template->assign_block_vars('switch_admin.support',array(
						"VALUE" => $tab_support[$i]['support_id'],
      						"INTITULE" => $tab_support[$i]['support_name'],
      						"SELECTED" => ($tab_support[$i]['support_id'] == $val_emission['support_id'] ) ? " SELECTED" : ""
						)
					);

			}
			
		for ($i=0;$i<count($tab_album);$i++)
			{
	
				$template->assign_block_vars('switch_admin.album',array(
						"VALUE" => $tab_album[$i]['album_id'],
      						"INTITULE" => $tab_album[$i]['title'],
      						"SELECTED" => ($tab_album[$i]['album_id'] == $val_emission['refer'] ) ? " SELECTED" : ""
						)
					);

			}
		
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