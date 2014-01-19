<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'functions/functions_disco.php');
require_once($phpbb_root_path . 'functions/url_rewriting.php');
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_DISCO);
init_userprefs($userdata);
//
// End session management
//


$song_id = $_GET['song_id'];
$album_id = $_GET['album_id'];

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='sam' ORDER BY user_id");

//////////// Selection de la chanson //////////////
$val_song = sql_select('disco_songs','song_id='.$song_id,'','','song');
	
//////////// Si l'album est spécifié : sélection de l'album et de l'artiste //////////////
if ($album_id != "") 
{ 
	$val_album = sql_select('disco_albums','album_id='.$album_id,'','','album');
	$sql_artist = "SELECT * FROM disco_artists WHERE artist_id = ".$val_album['artist_id'];
	$result_artist = mysql_query($sql_artist);
} else
{
	if ($asso[0]!= "")
	{
		$sql_artist = "SELECT C.* FROM disco_songs_albums A, disco_albums B, disco_artists C WHERE A.id = ".$asso[0]." AND B.album_id = A.album_id AND C.artist_id = B.artist_id ORDER BY B.date";
		$result_artist = mysql_query($sql_artist);
	} else
	{
		$sql_artist = "SELECT C.* FROM disco_artists_job B, disco_artists C WHERE B.project = ".$val_song['song_id']." AND B.job = 'Interprète' AND C.artist_id = B.artist_id";
		$result_artist = mysql_query($sql_artist);
	}
}

//La jaquette
	$val_jack = select_element("SELECT C.* FROM disco_songs_albums A, disco_albums B, disco_jacks C WHERE C.album_id = B.album_id AND A.album_id = B.album_id AND B.type = 'le single' AND A.song_id = ".$val_song['song_id']." ORDER BY B.date,C.ordre",'',false);
	if (!$val_jack)
	{
		$val_jack = select_element("SELECT C.* FROM disco_songs_albums A, disco_albums B, disco_jacks C WHERE C.album_id = B.album_id AND A.album_id = B.album_id AND B.type = 'l\'album' AND A.song_id = ".$val_song['song_id']." ORDER BY B.date,C.ordre LIMIT 0,1",'',false);
	}
	$filename = '../images/disco/jack_'.$val_jack['album_id'].'_'.$val_jack['jack_id'].'.';
	$ext = find_image($filename);
	if($ext)
	{
		$size = getimagesize($filename.$ext);
		$img = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $val_jack['album_id'] . '&jack_id='. $val_jack['jack_id'] . '"';
		if($val_jacks['comment'] == "")
			{
				$height = $size[1]+20;
			}
			else
			{
				$height = $size[1]+100;		
			}
				
		$onclick = "window.open('jaquette.php?jack_id=".$val_jack['jack_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";	
		$img = '<a href="#" onclick="'.$onclick.'"><img src="'.$img.'" alt="Agrandir la jaquette" border="0"></a>';
	}else
		{	
			$img = '<img src="../templates/jjgfamille/images/site/px.png" border="0">';
		}


$sql_asso = "SELECT * FROM disco_songs_albums WHERE song_id = ".$val_song['song_id'];
$result_asso = mysql_query($sql_asso);
for ($i=0;$val_asso = mysql_fetch_array($result_asso);$i++)
{
	$asso[$i] = $val_asso['id'];
}
mysql_free_result($result_asso);

//Titre de ?
While ($val_artist = mysql_fetch_array($result_artist))
{
  	$artiste .= $val_artist['name'].", ";
}

//Date
    $date = "99999999";
  for ($i=0;$asso[$i]!="";$i++)
  {
  	$val_asso = sql_select('disco_songs_albums','id='.$asso[$i],'','','asso');
  	$val_date = sql_select('disco_albums','album_id='.$val_asso['album_id'],'','','album');
  	$date = min($val_date['date'],$date);
  }
  if ($date != "99999999")
  {
  	$ladate = $lang['sorti']."&nbsp;".$lang['en']."&nbsp;".substr($date,0,4);
  }  

//Reprise

  	if ($val_song['reprise_id'] != 0)
  	{
  		$val_lang = sql_select('disco_languages','lang_id = '.$val_song['lang_id'],'','','lang');
  		$val_original = sql_select('disco_songs','song_id='.$val_song['reprise_id'],'','','original');
  		$sql_ori_singer = "SELECT A.* FROM disco_artists A, disco_artists_job B WHERE B.project = ".$val_original['song_id']." AND B.job = 'Interprète' AND A.artist_id = B.artist_id";
  		$result_ori_singer = mysql_query($sql_ori_singer);
  		$reprise = $lang['Reprise']."&nbsp;".$lang['en']."&nbsp;".$val_lang['language']."&nbsp;".$lang['de']."&nbsp;";
  		$l_reprise = $val_original['title'];
  		$u_reprise = append_sid($phpbb_root_path . 'disco/goldman_chanson_'.$val_song['reprise_id'].'_'.url_title($val_song['title']).'.html');
  		
  		 $rep_art="&nbsp;".$lang['par']."&nbsp;";
  		 While ($val_ori_singer = mysql_fetch_array($result_ori_singer))
  		 {
  		 	  /*
			  On ne gère pas encore le multiartiste
			  if ($val_ori_singer['artist_id'] == $act_artist['artist_id'] or $val_ori_singer['Open'] == N)
			  {*/
			  	$rep_art.=$val_ori_singer['name'];
			  /*} else
			  {
			  	$rep_art.= "<b><a href=http://www.jjgfamille.com/".$val_ori_singer['sess_name']."/ target=".$val_ori_singer['session_name'].">".$val_ori_singer['name']."</a></b>"; 
			  }*/
		}
	} 

//Les fichiers midi
$count = 0;
for ($i=0;$asso[$i] != "";$i++)
{
	if (is_file("../audio/disco/midi_".$asso[$i].".mid"))
	{
		$count++;
	}
}

if ($count != 0) 
{ 
	$midi='<a href="goldman_midi_'.$val_song['song_id'].'_'.$album_id.'_' . url_title($val_song['title']) . '.html"><b>'.$lang['Fichiers midi'].'</b></a><br><i>'.$count.' '.$lang['disponible(s)'].'</i>';
} 
else 
{ 
	$midi = $lang['Fichier midi'].'<br><i>'.$lang['indisponible'].'</i>';
}

//Les extraits
$count = 0;
for ($i=0;$asso[$i] != "";$i++)
{
	if (is_file($phpbb_root_path . "audio/disco/extrait_".$asso[$i].".ram"))
	{
		$count++;
	}
}
if ($count != 0) 
{ 
	$extrait='<a href="goldman_extrait_audio_'.$val_song['song_id'].'_'.$album_id.'_' . url_title($val_song['title']) . '.html"><b>'.$lang['Extrait audio'].'</b></a><br><i>'.$count.' '.$lang['disponible(s)'].'</i>';
} 
else 
{ 
	$extrait = $lang['Extrait audio'].'<br><i>'.$lang['indisponible'].'</i>';
}

//Les partitions
$count = 0;
for ($i=0;$asso[$i] != "";$i++)
{
	if (is_file("../audio/disco/".$val_song['dataname']."_".$asso[$i].".gp3"))
	{
		$count++;
	}
}
$count1 = 0;

for ($i=0;$asso[$i] != "";$i++)
{
	if (is_file("../textes/disco/".$val_song['dataname']."_".$asso[$i].".txt"))
	{
		$count1++;
	}
}
if ($count != 0 || $count1!=0) 
{ 
	$partition='<a href="' . append_sid($phpbb_root_path . 'disco/goldman_partitions_'.$val_song['song_id'].'_'.$album_id.'_' . url_title($val_song['title']).'.html').'"><b>'.$lang['Partitions'].'</b></a><br><i>'.$count1.' '.$lang['tablature(s)'].' '.$lang['et'].' '.$count.' '.$lang['fichier(s)'].' '.$lang['GuitarPro'].' '.$lang['disponible(s)'].'</i>';
} 
else 
{ 
	$partition = $lang['Partition'].'<br><i>'.$lang['indisponible'].'</i>';
}	

//Avis

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
		     		phpbb_topics.topic_title = '".addslashes($val_song['title'])."'
		     AND 
		     		phpbb_users.username <> 'Admins'
		     	";
	$tab_avis=select_liste($sql_avis);

$avis='<a href="goldman_avis_chanson_'.$val_song['song_id'].'_'.$album_id.'_'.url_title($val_song['title']).'.html"><b>'.$lang['Votre avis sur ce titre'].'</b></a><br><i>'.sprintf($lang['msg_dispo'],count($tab_avis)).'</i>';	

//Reprise
// Boris 27/02/2006 : Gestion des medleys/reprises
$tab_reprises = select_reprises($val_song['song_id']);
/*
$sql_reprise = "SELECT COUNT(*) FROM disco_songs WHERE reprise_id = ".$val_song['song_id'];
$result_reprise = mysql_query($sql_reprise);
$val_reprise = mysql_fetch_array($result_reprise);

if ($val_reprise[0] != 0) 
*/
if (count($tab_reprises)>0)
// Fin Boris 27/02/2006
{
	$rep='<a href="goldman_reprises_'.$val_song['song_id'].'_'.$album_id.'_'.url_title($val_song['title']).'.html"><b>'.$lang['Les reprises'].'</b></a><br /><i> '.count($tab_reprises).' '.$lang['référencée(s)'].'</i>';
} else 
{
	$rep = $lang['Reprises'].'<br /><i>'.$lang['aucune'].' '.$lang['référencée'].'</i>';
}

//COmmentaire
if($val_song['comment'] != "")
{
	$comment = '<b>'.$lang['A savoir'].' : </b>'.nl2br(bbencode_second_pass($val_song["comment"],$val_song['bbcode_uid']));
} 	

// Boris 25/02/2006 : Gestion des medleys
if ($val_song['medley'] == 'Y')
{
	$sql =  "SELECT song.title, song.song_id 
		FROM disco_medley medley, disco_songs song 
		WHERE medley.medley_id = '$song_id' AND song.song_id = medley.song_id
		ORDER BY `ordre`";
	$tab_medley = select_liste($sql);
}
// fin boris 25/02/2006

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $artiste . ' :: ' . $val_song['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/view_song.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

if ($album_id != "")
{
	switch($val_album['type'])
	{
		Case 'l\'album':
			$entete = '<a href="goldman_albums_studio.html"><b>'.ucfirst($lang['Studio_albums']).'</b></a> <b>></b> ';
			break;
		Case 'le live':
			$entete = '<a href="goldman_albums_live.html"><b>'.ucfirst($lang['Live_albums']).'</b></a> <b>></b> ';
			break;
		Case 'le single':
			$entete = '<a href="goldman_albums_single.html"><b>'.ucfirst($lang['Single_albums']).'</b></a> <b>></b> ';
			break;
		Case 'la compilation':
			$entete = '<a href="goldman_album_compil.html"><b>'.ucfirst($lang['Compil_albums']).'</b></a> <b>></b> ';
			break;
	} $entete .= '<a href="goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$val_album['title'].'</b></a> <b>></b> ';
}
$entete .= '<a href="goldman_chanson_' . $song_id . '_'.$album_id.'_' . url_title($val_song['title']) . '.html"><b>'.$val_song['title'].'</b></a> ';
	

if ($album_id != "")
{
	// recherche du titre de l'album pour l'URL Rewriting
	$val_album1 = select_element("SELECT title FROM disco_albums WHERE album_id='$album_id'",true,"album introuvable");
	$u_retour = append_sid($phpbb_root_path . 'disco/goldman_album_'.$album_id.'_' . url_title($val_album1['title']).'.html');
	unset($val_album1);
} else
{
	$u_retour = append_sid($phpbb_root_path . 'disco/goldman_albums_studio.html');
}

$template->assign_vars(array(
				'NOM_RUB' => $lang['Discographie'],
				"IMG_MASCOTTE" => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'IMG' => $img,
				'ONCLICK' => $onclick,
				"QUOI" => $lang['Titre']."&nbsp;".$lang['de']."&nbsp;".$artiste."&nbsp;".$ladate,
				"MIDI" => $midi,
				'REPRISE' => $reprise,
  		 		'REP_ART' => $rep_art,
  		 		"EXTRAIT" => $extrait,
  		 		"PARTITION" => $partition,
  		 		"REP" => $rep,
  		 		"AVIS" => $avis,
  		 		"COMMENT" => $comment,
  		 		"ENTETE" => $entete,
				
				"U_STUDIOS" => append_sid($phpbb_root_path . 'disco/goldman_albums_studio.html'),
				"U_LIVES" => append_sid($phpbb_root_path . 'disco/goldman_albums_live.html'),
				"U_COMPILATIONS" => append_sid($phpbb_root_path . 'disco/goldman_albums_compil.html'),	
				"U_PARTICIPATIONS" => append_sid($phpbb_root_path . 'disco/goldman_participations.html'),
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/goldman_liste_chansons.html'),
				"U_SINGLES" => append_sid($phpbb_root_path . 'disco/goldman_singles.html'),
				"U_REF" => append_sid($phpbb_root_path . 'disco/goldman_references_'.$val_song['song_id'].'_'.$album_id.'_' . url_title($val_song['title']).'.html'),
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),
  		 		'U_REPRISE' => $u_reprise,
  		 		'U_PAROLES' => append_sid($phpbb_root_path . 'disco/goldman_paroles_' . $val_song['song_id'].'_'.$album_id.'_' . url_title($val_song['title']).'.html'),
  		 		"U_RETOUR" => $u_retour,
				
				'L_SONGS_OF_MEDLEY' => $lang['Songs_of_medley'],
				"L_STUDIOS" => ucfirst($lang['Studio_albums']),
				"L_LIVES" => ucfirst($lang['Live_albums']),
				"L_COMPILATIONS" => ucfirst($lang['Compil_albums']),
				"L_PARTICIPATIONS" => ucfirst($lang['Participations']),
				"L_SINGLES" => ucfirst($lang['Single_albums']),
				"L_LIST_SONG" => $lang['list_song'],
				"L_TITLE" => $val_song['title'],
				"L_REF" => $lang['Les références'],
				"L_PAROLES" => $lang['Les paroles'],
  		 		"L_RETOUR" => $lang['retour'],
  		 		"L_VIDEO" => $lang['Videothèque'],
				'L_REPRISE' => $l_reprise,
			"L_ENFOIRES" => $lang['Les_Enfoirés'],
			"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
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

// Boris 25/02/2006 : Gestion des medleys
if (count($tab_medley) > 0)
{
	$template->assign_block_vars('is_medley',array());
}
for ($i = 0 ; $i < count($tab_medley) ; $i++)
{
	$template->assign_block_vars('is_medley.medley',array(
						'SONG_TITLE' => $tab_medley[$i]['title'],
						
						'U_SONG' => append_sid($phpbb_root_path . 'disco/goldman_chanson_'.$tab_medley[$i]['song_id'].'_' . url_title($tab_medley[$i]['title']).'.html'),
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