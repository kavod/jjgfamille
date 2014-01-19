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

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='report' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//Reportages à voir
$val_report = select_element("SELECT * FROM report WHERE report_id = ".$_GET['report_id']."",'',false);

//Selection de la page
//Selection de l'episode
$page_id = $_POST['page_id'];
if ($page_id == '')
   $page_id = $_GET['page_id'];
 if ($page_id == "" )
  {
     $val_page = select_element("SELECT * FROM report_pages WHERE report_id=".$_GET['report_id']." ORDER BY ordre LIMIT 0,1",'',false);
     $page_id = $val_page['page_id'];
  } else
  {
      $val_page = select_element("SELECT * FROM report_pages WHERE page_id = ".$page_id." AND report_id=".$_GET['report_id']."  LIMIT 0,1",'',false);
  }


//Les reporters
$tab_reporter = select_liste("SELECT * FROM reporters WHERE report_id = ".$_GET['report_id']." ORDER BY user_id");

//Liste des pages
$tab_page = select_liste("SELECT * FROM report_pages WHERE report_id = ".$_GET['report_id']." ORDER BY ordre");

//On compte le nombre de photos de ce reportage
$val_photo = select_element("SELECT COUNT(photo_id) as nb FROM report_photos WHERE report_id = ".$_GET['report_id']."",'',false);

// Y a t il des photos dans cette page
$tab_photo = select_liste("SELECT * FROM report_photos WHERE report_id = ".$_GET['report_id']." AND page_id = ".$page_id." ORDER BY ordre");

// Y a t il des extraits audios
$tab_audio = select_liste("SELECT * FROM report_audio WHERE page_id = ".$page_id." ORDER BY audio_id");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['reportages'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/view_report.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

if(count($tab_photo)>0)
{
$photographie = "<img src='../images/picture.gif'></img>&nbsp;".$lang['photographie'];
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
							'PHOTO' => $img,
							"PHOTOGRAPHE" => $tab_photo[$i]['photographe'],
							"PHOTOGRAPHIE" => $lang['photographie'],
							"DESC" => $tab_photo[$i]['description'],
							"ONCLICK" => $onclick,
							)
						);
		$i++;
	}
}
}

if(count($tab_audio)>0)
{
$audio = "<img src='../images/real.gif'></img>&nbsp;".$lang['Extraits_a_v'];

for ($i=0;$i<count($tab_audio);$i++)
{
		$onclick = "window.open('../fmc/jukebox.php?mode=report&id=".$tab_audio[$i]['audio_id']."','Jukebox','noresizable,scrollbars=yes,menubar=auto,width=800,height=500,left=100,top=100')";
		$template->assign_block_vars('switch_audio',array(
							"DESC" => $tab_audio[$i]['description'],
							"U_DESC" => $onclick,
							
							)
						);

	}
}

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['reportages'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"TITRE" => $val_report['title'],
				"DATE" => $lang['reportage']."&nbsp;".$lang['de']."&nbsp;".affiche_date($val_report['date']),
				"PAR" => $lang['Par'],
				"L_VOIR_CREDITS" => $lang['voir_credits'],
				"U_VOIR_CREDITS" => append_sid($phpbb_root_path . 'medias/credits.php?report_id='.$_GET['report_id']),
				'U_GO_TO_PAGE' => append_sid("view_report.php?report_id=".$_GET['report_id']."&page_id=" .$_GET['page_id']),
				'U_VOIR_GALERIE_PHOTO' => append_sid("galerie.php?report_id=".$_GET['report_id']),
				'L_VOIR_GALERIE_PHOTO' => sprintf($lang['voir_galerie_photo'],$val_photo['nb']),
				'CONTENU' => nl2br(bbencode_second_pass($val_page['contenu'],$val_page['bbcode_uid'])),
				'PHOTOGRAPHIE' => $photographie,
				'AUDIO' => $audio,
				"L_RETOUR" => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/reportages.php'),
			)
);

for ($i=0;$i<count($tab_page);$i++)
{
	$template->assign_block_vars('go_to_page',array(
				"VALUE" => $tab_page[$i]['page_id'],
				"INTITULE" => sprintf($lang["go_to_page"],($i+1)),
				"SELECTED" => ($tab_page[$i]['page_id'] == $val_page['page_id']) ? " SELECTED" : ""
				));
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

for ($i=0;$i<count($tab_reporter);$i++)
{
	$val_user = select_element("SELECT username FROM phpbb_users WHERE user_id= ".$tab_reporter[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_reporter',array(
						'U_REPORTER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_user['user_id']),
						'L_REPORTER' => $val_user['username']
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


$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
