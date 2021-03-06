<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'functions/functions_disco.'.$phpEx);
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
	if ($album_id != "") 
	{ 
		$val_album = sql_select('disco_albums','album_id='.$album_id,'','','album');
		$val_artist = sql_select('disco_artists','artist_id = '.$val_album['artist_id'],'','','artist');
	}
	
$sql_asso = "SELECT * FROM disco_songs_albums WHERE song_id = ".$val_song['song_id'];
	$result_asso = mysql_query($sql_asso);
	for ($i=0;$val_asso = mysql_fetch_array($result_asso);$i++)
	{
		$asso[$i] = $val_asso['id'];
	}

//Selection de l'auteur
$sql_job = "SELECT * FROM disco_artists_job WHERE project = ".$val_song['song_id']." AND job = 'Auteur'";
$result_job = mysql_query($sql_job);
	While ($val_job = mysql_fetch_array($result_job))
	{
		  $val_author = sql_select('disco_artists','artist_id = '.$val_job['artist_id'],'','','artist');
		  if ($val_author['artist_id'] == $act_author['artist_id'] or $val_author['Open'] == N)
		  {
		  	$auteur.=$val_author['name'].", ";
		  } else
		  {
		  	$auteur.= "<b><a href=http://" . $_SERVER['HTTP_HOST'] . "/".$val_author['sess_name']."/ target=".$val_author['session_name'].">".$val_author['name']."</a></b>, "; 
		  }

	}
	

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
	} $entete .= '<a href="goldman_album_'.$val_album['album_id'].'_' . url_title($val_album['title']) . '.html"><b>'.$val_album['title'].'</b></a> <b>></b> ';
} 
$entete .= '<a href="goldman_chanson_' . $song_id . '_' . $album_id.'_' . url_title($val_song['title']) . '.html"><b>' . $val_song['title'] . '</b></a> <b>></b> ';
$entete .= '<a href="goldman_paroles_' . $song_id . '_'.$album_id.'_' . url_title($val_song['title']) . '.html"><b>'.$lang['Les paroles'].'</b></a>';	
		 

	
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $val_song['title'] . ' :: ' . $lang['Les paroles'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/lyrics.tpl',
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
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/goldman_liste_chansons.php'),
				"L_TITLE" => $val_song['title'],
				"LYRICS" => nl2br(bbencode_second_pass($val_song['lyrics'],$val_song['bbcode_uid'])),
				"AUTEUR" => $auteur,
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'disco/goldman_chanson_' . $song_id . '_' . $album_id . '_' . url_title($val_song['title']) . '.html'),
				"ENTETE" => $entete,
				"AUT" => $lang['auteur_periode'],
				"L_VIDEO" => $lang['Videoth�que'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),
				"L_ENFOIRES" => $lang['Les_Enfoir�s'],
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
