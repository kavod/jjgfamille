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

if(isset($_GET['ordre']))
{
	$ordre = $_GET['ordre'];
}else
{
	$ordre = "alpha";
}

$artist_session = 1;
$act_artist = sql_select('disco_artists','artist_id='.$artist_session,'','','artist');

$sql_song = "SELECT 
			E.*, 
			A.band_id, 
			B.name,
			B.Open,
			B.sess_name,
			C.date,
			D.id,
			C.type,
			C.album_id,
			E.rm,
			E.gp,
			C.type,
			D.ordre 
		FROM 
			disco_bands A, 
			disco_artists B, 
			disco_albums C, 
			disco_songs_albums D, 
			disco_songs E 
		WHERE 
			E.song_id = D.song_id 
			AND D.album_id = C.album_id 
			AND C.artist_id = B.artist_id 
			AND ((B.artist_id = ".$act_artist['artist_id']." 
			AND A.band_id = 0) OR (A.artist_id = ".$act_artist['artist_id']." 
			AND A.band_id = B.artist_id)) 
		
		ORDER BY %s,%s";	

if($ordre!="date")
{
	$result_song = mysql_query(sprintf($sql_song,'title','date'));
	
	While ($val_song = mysql_fetch_array($result_song))
	{
		if ($letter != substr($val_song['title'],0,1))
		{
			$template->assign_block_vars('switch_lettre',
				array("L_LETTRE" => strtoupper(substr($val_song['title'],0,1)),
				"U_LETTRE" => '#'.strtoupper(substr($val_song['title'],0,1)),
				));
			$letter = substr($val_song['title'],0,1);
		}
		if  ($song_id != $val_song['song_id'])
		{
			
			if ($val_song['band_id'] != 0)
				$band = ' '.$lang['avec'].' '.$val_song['name'];
			else
				$band = '';
			
			if ($val_song['midi']=='Y')
				$midi = '<img src=' . $phpbb_root_path . 'images/mid.gif alt="Ce titre possède un fichier midi" title="Ce titre possède un fichier midi">';
				
			if (is_file($phpbb_root_path . "textes/disco/".$val_song['dataname']."_".$val_song['id'].".txt"))
				$part='<img src=../images/part.gif alt="Ce titre possède une tablature" title="Ce titre possède une tablature">';
				
			if ($val_song['rm']=='Y')
				$real = '<img src=../images/real.gif alt="Ce titre possède un extrait audio" title="Ce titre possède un extrait audio">';
				
			if ($val_song['gp']=='Y')
				$gp = '<img src=../images/gp.gif alt="Ce titre possède un fichier GuitarPro" title="Ce titre possède un fichier GuitarPro">';
			
			$template->assign_block_vars('switch_lettre.switch_song',
					array("L_TITLE" => $val_song['title'],
						"U_TITLE" => 'goldman_chanson_'.$val_song['song_id'].'_'.$val_song['album_id'] . '_' . url_title($val_song['title']).'.html',
						"BAND" => $band,
						"MIDI" => $midi,
						"PART" => $part,
						"REAL" => $real,
						"GP" => $gp,
					));
		}
		$song_id = $val_song['song_id'];
		$midi = "";	
		$part = "";
		$real = "";
		$gp = "";
	}
	
	$tri = $lang['Trier'].' '.$lang['par'].' <b>'.$lang['Ordre alphabétique'].'</b> | <a href="goldman_liste_chansons_date.html">'.$lang['Ordre chronologique'].'</a>';
}
else
{
	$result_song = mysql_query(sprintf($sql_song,'date','title'));
	
	While ($val_song = mysql_fetch_array($result_song))
	{
		$ok = 0;
		if ($ok == 0)
		{
			if ($date != (int)($val_song['date'] / 10000))
			{
				$template->assign_block_vars('switch_lettre',
					array("L_LETTRE" => (int)($val_song['date'] / 10000),
						"U_LETTRE" => '#'.(int)($val_song['date'] / 10000),
					));
				$date = (int)($val_song['date'] / 10000);
			}
			$liste_song[count($liste_song)] = $val_song['song_id'];
		
	
			if  ($song_id != $val_song['song_id'])
			{
				
				if ($val_song['band_id'] != 0)
					$band = ' '.$lang['avec'].' '.$val_song['name'];
				else
					$band = '';
				
				if ($val_song['midi']=='Y')
					$midi = '<img src=../images/mid.gif alt="Ce titre possède un fichier midi" title="Ce titre possède un fichier midi">';
					
				if (is_file("../textes/disco/".$val_song['dataname']."_".$val_song['id'].".txt"))
					$part='<img src=../images/part.gif alt="Ce titre possède une tablature" title="Ce titre possède une tablature">';
					
				if ($val_song['rm']=='Y')
					$real = '<img src=../images/real.gif alt="Ce titre possède un extrait audio" title="Ce titre possède un extrait audio">';
					
				if ($val_song['gp']=='Y')
					$gp = '<img src=../images/gp.gif alt="Ce titre possède un fichier GuitarPro" title="Ce titre possède un fichier GuitarPro">';
				
				$template->assign_block_vars('switch_lettre.switch_song',
						array("L_TITLE" => $val_song['title'],
							"U_TITLE" => 'goldman_chanson_'.$val_song['song_id'].'_'.$val_song['album_id'] . '_' . url_title($val_song['title']).'.html',
							"BAND" => $band,
							"MIDI" => $midi,
							"PART" => $part,
							"REAL" => $real,
							"GP" => $gp,
						));
			}
			$song_id = $val_song['song_id'];
			$midi = "";	
			$part = "";
			$real = "";
			$gp = "";
		}
	}
		
	$tri = $lang['Trier'].' '.$lang['par'].' <a href="goldman_liste_chansons_alpha.html">'.$lang['Ordre alphabétique'].'</a> | <b>'.$lang['Ordre chronologique'].'</b>';
}	
	
	
//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='sam' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');
if ($img_mascotte)
	$mascotte = $img_mascotte;


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['list_song'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/list_song.tpl',
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
				"ENTETE" => '<a href="liste_chansons.html"><b>'.ucfirst($lang['list_song']).'</b></a>',
				"L_TITLE" => $act_artist['name'].' : '.$lang['list_song'],
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'disco/'),
				"TRI" => $tri,
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),
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