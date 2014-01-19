<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/url_rewriting.php');
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_DISCO);
init_userprefs($userdata);
//
// End session management
//

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='sam' ORDER BY user_id");

//Selection de l'album
$val_album = select_element("SELECT * FROM disco_albums WHERE album_id=".$_GET['album_id']."",'',false);

//Selection des jaquettes
$tab_jacks = select_liste("SELECT * FROM disco_jacks WHERE album_id = ".$val_album['album_id']." ORDER BY ordre");

//Selection de l'artiste
$val_artist = select_element("SELECT * FROM disco_artists WHERE artist_id = ".$val_album['artist_id']."",'',false);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

//Type de l'album
switch($val_album['type'])
{
	Case 'l\'album':
		$quoi = ucfirst($lang['Studio_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$entete = '<a href="goldman_albums_studio.html"><b>'.ucfirst($lang['Studio_albums']).'</b></a> <b>></b> <a href="goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$val_album['title'].'</b></a>';
		break;
	Case 'le live':
		$quoi = ucfirst($lang['Live_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$entete = '<a href="goldman_albums_live.html"><b>'.ucfirst($lang['Live_albums']).'</b></a> <b>></b> <a href="goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$val_album['title'].'</b></a>';
		break;
	Case 'la compilation':
		$quoi = ucfirst($lang['Compil_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$entete = '<a href="goldman_albums_compil.html"><b>'.ucfirst($lang['Compil_albums']).'</b></a> <b>></b> <a href="goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$val_album['title'].'</b></a>';
		break;
	Case 'le single':
		$quoi = ucfirst($lang['Single_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$entete = '<a href="goldman_singles.html"><b>'.ucfirst($lang['Single_albums']).'</b></a> <b>></b> <a href="goldman_singles_'.substr($val_album['date'],0,4).'.html"><b>'.$val_album['title'].'</b></a>';
		break;
	Case 'video':
		$quoi = $lang['Vidéo']."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$entete = '<a href="goldman_albums_video.html"><b>'.$lang['Videothèque'].'</b></a> <b>></b> <a href="goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$val_album['title'].'</b></a>';
		break;
} 

$entete .= ' <b>></b> <a href="goldman_jaquettes_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$lang['Jaquettes'].'</b></a>';
	

if ($val_album['type'] != 'le single')
{

	$u_retour = append_sid($phpbb_root_path . 'disco/goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html');
} else
{ 
	$u_retour = append_sid($phpbb_root_path . 'disco/goldman_singles_'.substr($val_album['date'],0,4).'.html');
}

if ($img_mascotte)
$mascotte = $img_mascotte;

// On définit le nombre de photos par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_photos = count($tab_jacks);

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Jaquettes']."&nbsp;".$lang['de']."&nbsp;" . $val_album['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/jaquettes.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);


// Pour chaque ligne...
$i=0;
while($i<$nb_photos)
{
	$template->assign_block_vars('photos_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_photos;$j++)
	{
		$ext = find_image('../images/disco/jack_' . $val_album['album_id'].'_'.$tab_jacks[$i]['jack_id'].'.');
		if (is_file('../images/disco/jack_' . $val_album['album_id'].'_'.$tab_jacks[$i]['jack_id'].'.'.$ext))
		{
			$img = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $val_album['album_id'] . '&jack_id='. $tab_jacks[$i]['jack_id'];
			$size = getimagesize('../images/disco/jack_' . $val_album['album_id'].'_'.$tab_jacks[$i]['jack_id'].'.'.$ext);
	
			if($tab_jacks[$i]['comment'] == "")
			{
				$height = $size[1]+20;
			}
			else
			{
				$height = $size[1]+100;		
			} 
				
		$onclick = "window.open('jaquette.php?jack_id=".$tab_jacks[$i]['jack_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
		$img = '<a href="#" onclick="'.$onclick.'"><img src="'.$img.'" alt="Agrandir la jaquette" border="0"></a>';
		}else
		{	
			$img = '<img src="' .$phpbb_root_path . 'functions/miniature.php?mode=nojack" alt="Pas de jaquette disonible" border="0" >';
		}
		
		$template->assign_block_vars('photos_row.photos_column',array(
							'PHOTO' => $img,
							)
						);
		$i++;
	}
}


$template->assign_vars(array(
				'NOM_RUB' => $lang['Discographie'],
				"IMG_MASCOTTE" => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				"L_STUDIOS" => ucfirst($lang['Studio_albums']),
				"U_STUDIOS" => append_sid($phpbb_root_path . 'disco/goldman_albums_studio.html'),
				"L_LIVES" => ucfirst($lang['Live_albums']),
				"U_LIVES" => append_sid($phpbb_root_path . 'disco/goldman_albums_live.html'),
				"L_COMPILATIONS" => ucfirst($lang['Compil_albums']),
				"U_COMPILATIONS" => append_sid($phpbb_root_path . 'disco/goldman_albums_compil.html'),	
				"L_PARTICIPATIONS" => ucfirst($lang['Participations']),
				"U_PARTICIPATIONS" => append_sid($phpbb_root_path . 'disco/goldman_participations.html'),
				"L_SINGLES" => ucfirst($lang['Single_albums']),
				"U_SINGLES" => append_sid($phpbb_root_path . 'disco/goldman_singles.html'),
				"L_LIST_SONG" => $lang['list_song'],
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/goldman_liste_chansons.html'),
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),
				"L_ENFOIRES" => $lang['Les_Enfoirés'],
				"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
				"TITLE" => $lang['Jaquettes']."&nbsp;".$lang['de']."&nbsp;",
				"L_TITLE" => $val_album['title'],
				"QUOI" => $quoi,
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => $u_retour,
				"ENTETE" => $entete,
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'disco/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'sam'))
{
		$template->assign_block_vars('switch_admin_disco',array(
						"U_ADMIN_DISCO" => append_sid($phpbb_root_path . 'disco/sam.php'),
						"L_ADMIN_DISCO" =>  $lang['admin_disco'],
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
$sitopif = short_desc('disco','opif');
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