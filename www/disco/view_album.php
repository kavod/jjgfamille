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

//Selection des chansons
$tab_songs = select_liste("SELECT * FROM disco_albums,disco_songs,disco_songs_albums WHERE disco_songs.song_id=disco_songs_albums.song_id AND disco_albums.album_id=disco_songs_albums.album_id AND disco_albums.album_id = ".$val_album['album_id']." ORDER BY ordre");

//Selection des avis 
	$sql_avis = "SELECT 
				phpbb_posts.post_id	     	 
		     FROM 
		     		phpbb_posts,phpbb_posts_text,phpbb_topics,phpbb_users,phpbb_forums 
		     WHERE 
		     		phpbb_posts.post_id = phpbb_posts_text.post_id 
		     AND 
		     		phpbb_topics.topic_id = phpbb_posts.topic_id
		     AND
		     		phpbb_posts.poster_id = phpbb_users.user_id
		     AND
		     		phpbb_forums.forum_id = phpbb_posts.forum_id
		     AND
		     		phpbb_forums.forum_name = '".addslashes($val_album['title'])."'
		     AND 
		     		phpbb_topics.topic_title LIKE 'L\'album %".addslashes($val_album['title'])."% en général'
		     AND 
		     		phpbb_users.username <> 'Admins'
		     	";
	$tab_avis=select_liste($sql_avis);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

//Selection des medias associés
//l'emission selectionné
$tab_medias = select_liste("SELECT * FROM media_emission WHERE  refer= ".$_GET['album_id']."");

if ($img_mascotte)
$mascotte = $img_mascotte;

//Type de l'album
switch($val_album['type'])
{
	Case 'l\'album':
		$quoi = ucfirst($lang['Studio_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$titres_album = $lang['Titres_album'];
		$entete = '<a href="' . url_title($val_artist['name']) . '_albums_studio_' . $val_artist['artist_id'] . '.html"><b>' . ucfirst($lang['Studio_albums']) . '</b></a> <b>></b> ';
		$l_avis = $lang['votre_avis'];
		$mode = 'studio';
		$u_avis = append_sid($phpbb_root_path . 'disco/goldman_avis_album_'.$val_album['album_id'].'_'.url_title($val_album['title']) . '.html');
		break;
	Case 'le live':
		$quoi = ucfirst($lang['Live_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$titres_album = $lang['Titres_live'];
		$entete = '<a href="' . url_title($val_artist['name']) . '_albums_live_' . $val_artist['artist_id'] . '.html"><b>'.ucfirst($lang['Live_albums']).'</b></a> <b>></b> ';
		$l_avis = $lang['votre_avis'];
		$mode = 'live';
		$u_avis = append_sid($phpbb_root_path . 'disco/goldman_avis_album_'.$val_album['album_id'].'_'.url_title($val_album['title']) . '.html');
		break;
	Case 'la compilation':
		$quoi = ucfirst($lang['Compil_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$titres_album = $lang['Titres_compil'];
		$entete = '<a href="' . url_title($val_artist['name']) . '_albums_compil_' . $val_artist['artist_id'] . '.html"><b>'.ucfirst($lang['Compil_albums']).'</b></a> <b>></b> ';
		$l_avis = $lang['votre_avis'];
		$mode = 'compil';
		$u_avis = append_sid($phpbb_root_path . 'disco/goldman_avis_album_'.$val_album['album_id'].'_'.url_title($val_album['title']) . '.html');
		break;
	Case 'le single':
		$quoi = ucfirst($lang['Single_album'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$titres_album = $lang['Titres_single'];
		$entete = '<a href="goldman_singles.html"><b>'.ucfirst($lang['Single_albums']).'</b></a> <b>></b> ';
		$l_avis = $lang['votre_avis'];
		$mode = 'studio';
		$u_avis = append_sid($phpbb_root_path . 'disco/goldman_avis_album_'.$val_album['album_id'].'_'.url_title($val_album['title']) . '.html');
		break;
	Case 'video':
		$quoi = ucfirst($lang['Vidéo'])."&nbsp;".$lang['de']."&nbsp;".$val_artist['name']."&nbsp;".$lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($val_album['date'],0,4);
		$titres_album = $lang['Titres_video'];
		$entete = '<a href="' . url_title($val_artist['name']) . '_albums_video_' . $val_artist['artist_id'] . '.html"><b>'.$lang['Videothèque'].'</b></a> <b>></b> ';
		$l_avis = $lang['votre_avis_video'];
		$mode = 'video';
		$u_avis = append_sid($phpbb_root_path . 'disco/goldman_avis_album_'.$val_album['album_id'].'_'.url_title($val_album['title']) . '.html');
		break;
} 
$entete .= '<a href="goldman_album_'.$val_album['album_id'].'_'.url_title($val_album['title']).'.html"><b>'.$val_album['title'].'</b></a>';
	
//Disponibilité en cd ,k7 ect....
$dispo = $lang['Disponible']."&nbsp;".$lang['en']."&nbsp;";

if ($val_album['CD']==Y) { $dispo .= "CD, "; }
if ($val_album['DVD']==Y) { $dispo .= "DVD, "; } 
if ($val_album['VHS']==Y) { $dispo .= "VHS, "; } 
if ($val_album['K7']==Y) { $dispo .= "Cassette audio, "; }
if ($val_album['33T']==Y) { $dispo .= "Vinyle 33 Tours, "; }
if ($val_album['CD2T']==Y) { $dispo .= "CD single, "; }
if ($val_album['K72T']==Y) { $dispo .= "K7 2 titres, "; }
if ($val_album['45T']==Y) { $dispo .= "45 tours, "; }
if ($val_album['M45T']==Y) { $dispo .= "Maxi 45 tours, "; }
if ($val_album['HC']==Y) { $dispo .= "<b>Hors Commerce</b>"; } 

//commentaires sur le disque
if($val_album['comment'] != "")
{
	$anoter = $lang['a_savoir']."&nbsp;:";
	$l_anoter = bbencode_second_pass($val_album["comment"],$val_album["bbcode_uid"]);
}

//Boutique amazon
if ($val_album['ASIN'] == 0)
{
	if($val_album['type']=='video')
		$u_amazon = "http://www3.fnac.com/search/quick.do?category=video&text=".$val_album['title']."&Origin=JJGFAMILLE&OriginClick=yes";
	else 
		$u_amazon = "http://www3.fnac.com/search/quick.do?category=audio&text=".$val_album['title']."&Origin=JJGFAMILLE&OriginClick=yes";  
}
else
{
	$u_amazon = "http://www.fnac.com/Shelf/article.asp?PRID=".$val_album['ASIN']."&Origin=JJGFAMILLE&OriginClick=yes"; 
}

if(count($tab_medias)>0)
	$medias = $lang['Liste des émissions associées à cet album'];


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $val_artist['name'] . ' :: ' . $val_album['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/view_album.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);


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
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" =>  append_sid($phpbb_root_path . 'disco/goldman_albums_'.$mode.'.html'),
				"L_TITLE" => $val_album['title'],
				"MSG" => bbencode_second_pass($val_album['thanks'],$val_album['bbcode_uid']),
				"QUOI" => $quoi,
				"ALBUM_TITLE" => $titres_album,
				"DISPO" => $dispo,
				"ANOTER" => $anoter,
				"L_ANOTER" => $l_anoter,
				"L_AMAZON" => $lang['Amazon_buy'],
				"U_AMAZON" => $u_amazon,
				"IMG_AMAZON" => "../images/crea1_100_70.gif",
				"L_JACK" => $lang['jacks_livret'],
				"U_JACK" => append_sid($phpbb_root_path . 'disco/goldman_jaquettes_'.$val_album['album_id'].'_'.url_title($val_album['title']) . '.html'),
				"COUNT_JACK" => sprintf($lang['img_dispo'],count($tab_jacks)),
				"L_AVIS" => $l_avis,
				"U_AVIS" => $u_avis,
				"COUNT_AVIS" => sprintf($lang['msg_dispo'],count($tab_avis)),
				'ENTETE' =>$entete,
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),
			"L_ENFOIRES" => $lang['Les_Enfoirés'],
			"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
				"MEDIAS" => $medias,
			)
);

for ($i=0;$i<1;$i++)
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
	}
	else
	{	
		$img = '<img src="' .$phpbb_root_path . 'functions/miniature.php?mode=nojack" alt="Pas de jaquette disonible" border="0" >';
	}

	$template->assign_block_vars('switch_jacks',array(
						'IMG' => $img,
						)
					);
}

for ($i=0;$i<count($tab_songs);$i++)
{

	$template->assign_block_vars('switch_songs',array(
						'U_SONG' => append_sid($phpbb_root_path . 'disco/goldman_chanson_'.$tab_songs[$i]['song_id'].'_'.$val_album['album_id'].'_' . url_title($tab_songs[$i]['title']) . '.html'),
						'L_SONG' => $tab_songs[$i]['title'],
						)
					);
}

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

for ($i=0;$i<count($tab_medias);$i++)
{

	$template->assign_block_vars('switch_medias',array(
						'U_TITLE' => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$tab_medias[$i]['emission_id']),
						'L_TITLE' => $tab_medias[$i]['title'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('disco','opif');
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