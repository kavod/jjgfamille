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

/////////////////////////////
$artist_session = 1;
$act_artist = sql_select('disco_artists','artist_id='.$artist_session,'','','artist');
$bands_ids = "";
$sql_band = "SELECT band_id FROM disco_bands WHERE artist_id = ".$artist_session;
$result_band = mysql_query($sql_band);
while ($val_band = mysql_fetch_array($result_band))
{
	$bands_ids_and .= " AND Album.artist_id <> ".$val_band['band_id'];
	$bands_ids_or .= " OR Album.artist_id = ".$val_band['band_id'];
}

// Sélection de tous les titres "participés"
$sql_song ="SELECT 
		Song.reprise_id, 
		Song.title, 
		Job.job, 
		MIN(Album.date) date, 
		Artist.name, 
		Artist.Open, 
		Artist.artist_id, 
		Song.song_id,
		Song.reprise_id
	FROM 
		disco_songs Song, 
		disco_artists_job Job, 
		disco_albums Album, 
		disco_songs_albums Asso, 
		disco_artists Artist
	WHERE 
		Job.artist_id = 1 
		AND Job.project=Song.song_id 
		AND Song.song_id=Asso.song_id 
		AND Asso.album_id=Album.album_id 
		AND Artist.artist_id = Album.artist_id 
		AND Album.artist_id <> ".$artist_session.$bands_ids_and."
	GROUP BY 
		Song.reprise_id, 
		Song.title, 
		Job.job, 
		Artist.name, 
		Artist.Open, 
		Artist.artist_id, 
		Song.song_id
	ORDER BY 
		artist_id,
		reprise_id,
		name, 
		title, 
		Album.album_id, 
		song_id, 
		job";
$result_song = mysql_query($sql_song);
$song_id=0;
$artist_id =0;
$bool=false;
// Tant qu'on trouve des titres participés
While ($val_song = mysql_fetch_array($result_song))
{

	$sql_reprise = "SELECT artist_id FROM disco_songs A, disco_songs_albums B, disco_albums C WHERE B.song_id=A.song_id AND B.album_id = C.album_id AND A.song_id = ".$val_song['song_id'];
	$result_reprise = mysql_query($sql_reprise);
	$bool = true;
	if ($val_reprise = mysql_fetch_array($result_reprise))
	{
		if ($val_reprise['artist_id'] == $artist_session)
		{
			$bool = false;
		} else
		{
			$sql_band = "SELECT * FROM disco_bands WHERE band_id = ".$val_reprise['artist_id']." AND artist_id = ".$artist_session;
			$result_band = mysql_query($sql_band);
			if (mysql_fetch_array($result_band))
			{
				$bool = false;
			}
		}
	}
	if ($bool)
	{
		// Si la chanson ne correspond pas à la précédente
		if ($val_song['song_id'] != $song_id)
		{
			// Sélection du titre original dans la disco de JJG en cas de reprise
			$tab_select = select_liste("SELECT 
							A.song_id 
						FROM 
							disco_songs A, 
							disco_songs_albums B, 
							disco_albums Album 
						WHERE 
							A.song_id = '" . $val_song['reprise_id'] . "' AND 
							A.song_id=B.song_id AND 
							B.album_id = Album.album_id AND 
							(Album.artist_id = 1 ".$bands_ids_or . " )");
			
							
			// Si on en trouve, ce n'est pas une participation mais une reprise
			if (count($tab_select)==0)
			{
				// Et si c'est un artiste différent au précédent
				if ($val_song['artist_id'] != $artist_id)
				{
					
					if ($val_song['artist_id'] == $artist_session or $val_song['Open'] == N)
					{
					$aqui = "<b><u>".$val_song['name']."</u></b> (Voir ses albums <a href=\"albums.php?mode=studio&artist_id=".$val_song['artist_id']."&sid=".$_GET['sid']."\">studios</a> ou <a href=\"albums.php?mode=live&artist_id=".$val_song['artist_id']."&sid=".$_GET['sid']."\">lives</a>)";
					} else
					{
					$aqui = '<a href=' . $_SERVER['HTTP_HOST'] . '/'.$val_album['sess_name'].'/ target='.$val_album['sess_name'].'>'.$val_album['name'].'</a>';
					} 
					$artist_id = $val_song['artist_id'];
					
					$filename = $phpbb_root_path . 'images/disco/photo_artist_' . $val_song['artist_id'];
					$u_photo = find_image($filename);
					
					$template->assign_block_vars('switch_artiste',array(
											"AQUI" => $aqui,
											));
					// Photo
					if ($u_photo)
					{
						$template->assign_block_vars('switch_artiste.photo',array(
										"PHOTO" => $phpbb_root_path . 'functions/miniature.php?mode=artist&artist_id='.$val_song['artist_id'].'&tnH=112',
										"ALT" => htmlentities($val_song['name']),
										));
					}
				
				}
	
				$song = '<b><a href=view_song.php?song_id='.$val_song['song_id'].'&sid='.$_GET['sid'].'>'.$val_song['title'].'</a></b> en tant qu';
				if ($val_song['job']=='Compositeur') 
				{ $song.="e Compositeur"; } 
				else 
				{ $song.="'".$val_song['job']; }
				
				
				
				$song_id = $val_song['song_id'];
				$job['Auteur']=0;$job['Compositeur']=0;$job['Interprète']=0;
				$job1=$val_song['job'];
				$job[$job1]=1;
				
				$template->assign_block_vars('switch_artiste.song',array("SONG" => $song,"JOB" => $jobs,));
			}
			 
		} else 
		{
			$job1=$val_song['job'];
			if ($job[$job1]==0)
			{
				$jobs= ', '.$val_song['job'];
				$job[$job1]=1;
			}
		} 
			
	}
		
}
mysql_free_result($result_song);

/////////////////////////////////

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/participations.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'NOM_RUB' => $lang['Discographie'],
				"IMG_MASCOTTE" => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				"L_STUDIOS" => ucfirst($lang['Studio_albums']),
				"U_STUDIOS" => append_sid($phpbb_root_path . 'disco/albums.php?mode=studio'),
				"L_LIVES" => ucfirst($lang['Live_albums']),
				"U_LIVES" => append_sid($phpbb_root_path . 'disco/albums.php?mode=live'),
				"L_COMPILATIONS" => ucfirst($lang['Compil_albums']),
				"U_COMPILATIONS" => append_sid($phpbb_root_path . 'disco/albums.php?mode=compil'),	
				"L_PARTICIPATIONS" => ucfirst($lang['Participations']),
				"U_PARTICIPATIONS" => append_sid($phpbb_root_path . 'disco/participations.php'),
				"L_SINGLES" => ucfirst($lang['Single_albums']),
				"U_SINGLES" => append_sid($phpbb_root_path . 'disco/singles.php'),
				"ENTETE" => '<a href=participations.php?sid='.$_GET['sid'].'><b>'.ucfirst($lang['Participations']).'</b></a>',
				"L_LIST_SONG" => $lang['list_song'],
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/list_song.php'),
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'disco/index.php'),
				"L_TITLE" => $act_artist['name'].' : '.$lang['Participations'],
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/albums.php?mode=video'),
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

for ($i=0;$i<count($tab_songs);$i++)
{
	$template->assign_block_vars('switch_song',array(
						'L_TITLE' => $tab_songs[$i]['title'],
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
