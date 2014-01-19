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

$album_id = $_GET['album_id'];
$song_id = $_GET['song_id'];

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='sam' ORDER BY user_id");

//Selection de la chanson
	$val_song = sql_select('disco_songs','song_id='.$song_id,'','','song');
	
	$sql_asso = "SELECT * FROM disco_songs_albums WHERE song_id = ".$val_song['song_id'];
	$result_asso = mysql_query($sql_asso);
	for ($i=0;$val_asso = mysql_fetch_array($result_asso);$i++)
	{
		$asso[$i] = $val_asso['id'];
	}
	
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

While ($val_artist = mysql_fetch_array($result_artist))
{
	if ($val_artist['artist_id'] == $act_artist['artist_id'] or $val_artist['Open'] == N)
	{
		$artiste = $val_artist['name'];
	} else
	{
		$artiste = "<b><a href=http://" . $_SERVER['HTTP_HOST'] . "/".$val_artist['sess_name']."/ target=".$val_artist['session_name'].">".$val_artist['name']."</a></b>";
	}
}

$date = "99999999";
for ($i=0;$asso[$i]!="";$i++)
{
	$val_asso = sql_select('disco_songs_albums','id='.$asso[$i],'','','asso');
	$val_date = sql_select('disco_albums','album_id='.$val_asso['album_id'],'','','album');
	$date = min($val_date['date'],$date);
}

if ($date != "99999999")
{
	$ladate="<i>(".substr($date,0,4).")</i>";
} 

$tab_job = select_liste("SELECT * FROM disco_artists_job WHERE project=".$val_song['song_id']." ORDER BY job");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

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
			$entete = '<a href="goldman_singles_' . substr($val_album['date'],0,4).'.html"><b>'.ucfirst($lang['Single_albums']).'</b></a> <b>></b> ';
			break;
		Case 'la compilation':
			$entete = '<a href="goldman_albums_compil"><b>'.ucfirst($lang['Compil_albums']).'</b></a> <b>></b> ';
			break;
	}
	$entete .= '<a href="goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$val_album['title'].'</b></a> <b>></b> ';
} 
$entete .= '<a href="goldman_chanson_' . $song_id . '_' . $album_id.'_' . url_title($val_song['title']) . '.html"><b>'.$val_song['title'].'</b></a> <b>></b> ';
$entete .= '<a href="goldman_references_'.$song_id.'_'.$album_id.'_' . url_title($val_song['title']).'.html"><b>'.$lang['Les références'].'</b></a>';

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Les références'] . ' :: ' . $val_song['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/ref.tpl',
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
				"L_TITLE" => $val_song['title'],
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'disco/goldman_chanson_'.$song_id.'_'.$album_id.'_' . url_title($val_song['title']).'.html'),
				"QUOI" => $lang['Titre']."&nbsp;".$lang['de']."&nbsp;".$artiste."&nbsp;".$ladate,
				"MUSCIEN" => str_replace("<br>","<br>&nbsp;&nbsp;",bbencode_second_pass("[b:".$val_song['bbcode_uid']."]".str_replace("\n","<br />[b:".$val_song['bbcode_uid']."]",str_replace(" : "," :[/b:".$val_song['bbcode_uid']."] ",$val_song['musicians'])),$val_song['bbcode_uid'])),
				"ENTETE" => $entete,
				'ARTISTES_AYANT' => $lang['Artistes ayant participés à l\'élaboration de ce titre'],
				'MUSICIENS'=> $lang['Musiciens'],
				'WHERE'	=> $lang['Où trouver ce titre'],
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),	
				"L_ENFOIRES" => $lang['Les_Enfoirés'],
				"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),	
			)
);


for ($i=0;$i<count($tab_job);$i++)
{
		$val_artist1 = sql_select('disco_artists','artist_id = '.$tab_job[$i]['artist_id'],'','','artist');
		if ($tab_song[$i]['reprise_id'] != 0)
		{
			$deladap=" de l'adaptation";
		}
		
		$template->assign_block_vars('switch_job',array(
						'JOB' => "&nbsp;&nbsp;<b>".$tab_job[$i]['job'].$deladap." :</b> ",
						'AUTEUR' => $val_artist1['name'],
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

/////////////////////////////////// Ou trouve t'on ce titre
if ($asso[0]!=0)
{
		$tab_album1 = select_liste("SELECT A.type,A.album_id,A.title,A.date,A.CD,A.K7,A.33T,A.CD2T,A.K72T,A.45T,A.M45T,A.HC,A.artist_id,B.comment,B.bbcode_uid FROM disco_albums A,disco_songs_albums B WHERE A.album_id = B.album_id AND B.song_id = ".$val_song['song_id']." ORDER BY date");
		for ($i=0;$i<count($tab_album1);$i++)
		{
			if ($val_jack = sql_select('disco_jacks','album_id='.$tab_album1[$i]['album_id'],'ordre','','jack'))
			{
				$ext =find_image('../images/disco/jack_'.$tab_album1[$i]['album_id'].'_'.$val_jack['jack_id'].'.');
				$size = getimagesize('../images/disco/jack_'.$tab_album1[$i]['album_id'].'_'.$val_jack['jack_id'].'.'.$ext);
			} else{ $size = ""; }
			
			if ($size != "")
			{
				if($val_jack['comment'] == "")
				{
					$height = $size[1]+20;
				}
				else
				{
					$height = $size[1]+100;		
				}
				
				$img = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $tab_album1[$i]['album_id'] . '&jack_id='. $val_jack['jack_id'];
				$onclick = "window.open('jaquette.php?jack_id=".$val_jack['jack_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
				$img = '<a href="#" onclick="'.$onclick.'"><img src="'.$img.'" alt="Agrandir la jaquette" border="0"></a>';
			}else
			{	
				$img = '<img src="../functions/miniature.php?mode=nojack" alt="Pas de jaquette disonible" border="0">';
			}

			if ($tab_album1[$i]['type'] == "le single") 
			{
				$u_title = append_sid($phpbb_root_path . 'disco/goldman_singles_'.substr($tab_album1[$i]['date'],0,4).'.html'); 
			} else 
			{
				$u_title = append_sid($phpbb_root_path . 'disco/goldman_album_'.$tab_album1[$i]['album_id'].'_'.url_title($tab_album1[$i]['title']).'.html'); 
			} 
			$l_title = $tab_album1[$i]['title'];
			
			$val_artist2 = sql_select('disco_artists','artist_id = '.$tab_album1[$i]['artist_id'],'','','artist2');
			$artiste = "<i>(".$val_artist2['name'].") ".substr($tab_album1[$i]['date'],0,4)."</i>";
			
				$dispo = "Disponible en ";
			  if ($tab_album1[$i]['CD']==Y) { $dispo.= "CD, "; }
			  if ($tab_album1[$i]['K7']==Y) { $dispo.= "Cassette audio, "; }
			  if ($tab_album1[$i]['33T']==Y) { $dispo.= "Vinyle 33 Tours, "; }
			  if ($tab_album1[$i]['CD2T']==Y) { $dispo.= "CD single, "; }
			  if ($tab_album1[$i]['K72T']==Y) { $dispo.= "K7 2 titres, "; }
			  if ($tab_album1[$i]['45T']==Y) { $dispo.= "45 tours, "; }
			  if ($tab_album1[$i]['M45T']==Y) { $dispo.= "Maxi 45 tours, "; }
			  if ($tab_album1[$i]['HC']==Y) { $dispo.= "<b>Hors Commerce</b>"; }
   			  
   			  if ($tab_album1[$i]['comment'] != "")
			  {
				$comment = "<b>A savoir à propos de ".$val_song['title']." :</b><br>".str_replace("\'","'",bbencode_second_pass($tab_album1[$i]["comment"],$tab_album1[$i]['bbcode_uid']));
			  }
			  
			  $template->assign_block_vars('switch_asso',array(
						'L_TITLE' => $l_title,
						'U_TITLE' => $u_title,
						'IMG' => $img,		
						'QUI' => $artiste,
						'DISPO' => $dispo,
						'COMMENT' => $comment,				
						)
					);
}
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
