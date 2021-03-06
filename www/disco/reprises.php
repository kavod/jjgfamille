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
$entete .= '<a href="goldman_chanson_' . $song_id . '_' . $album_id.'_' . url_title($val_song['title']) . '.html"><b>'.$val_song['title'].'</b></a> <b>></b> ';
$entete .= '<a href="goldman_reprises_'.$song_id.'_'.$album_id.'_' . url_title($val_song['title']) . '.html"><b>'.sprintf($lang['Les'],$lang['reprises']).'</b></a>';	
	
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = sprintf($lang['Les'],$lang['reprises']) . ' :: ' . $val_song['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/reprises.tpl',
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
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/goldman_liste_chansons.html'),
				"L_TITLE" => $val_song['title'],
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'disco/goldman_chanson_'.$song_id.'_'.$album_id.'_'.url_title($val_song['title']).'.html'),
				"ENTETE" => $entete,
				"MID" => $lang['Reprises r�f�renc�es'],
				"L_VIDEO" => $lang['Videoth�que'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),
				"L_ENFOIRES" => $lang['Les_Enfoir�s'],
				"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
			)
);

// Boris 27/02/2006 : Gestion des medleys/reprises
$tab_reprises = select_reprises($val_song['song_id']);
/*
$sql_reprise = "SELECT * FROM disco_songs WHERE reprise_id = ".$val_song['song_id'];
$result_reprise = mysql_query($sql_reprise);
While ($val_reprise = mysql_fetch_array($result_reprise))
*/
foreach ($tab_reprises as $val_reprise)
// FIn Boris 27/02/2006
{
	$val_language = sql_select('disco_languages','lang_id='.$val_reprise['lang_id'],'','','lang');
	$sql_singer = "SELECT A.* FROM disco_artists A, disco_artists_job B WHERE A.artist_id = B.artist_id AND B.job = 'Interpr�te' AND project = ".$val_reprise['song_id'];
	$result_singer = mysql_query($sql_singer);
	$reprises = '<a href="goldman_chanson_'.$val_reprise['song_id'].'_' . url_title($val_reprise['song_id']).'.html"><b>'.$val_reprise['title'].'</b></a> <i>('.$val_language['language'].')</i><br />'.$lang['Interpr�t�'].' '.$lang['par'].' ';
	$list_singer .= "";
	While ($val_singer = mysql_fetch_array($result_singer))
	{
		/*
		// Gestion Multi-artistes obsol�te
		if ($val_singer['artist_id'] == $act_artist['artist_id'] or $val_singer['Open'] == N)
		{*/
			$list_singers .= ", ".$val_singer['name'];
		/*} else
		{
			$list_singers .= ", <b><a href=http://www.jjgfamille.com/".$val_singer['sess_name']."/ target=".$val_singer['session_name'].">".$val_singer['name']."</a></b>";
		}*/
	}
	
	$reprises .= substr($list_singers,2).'<br /><br /><br />';
	$list_singers = "";
	
	$template->assign_block_vars('switch_reprises',array(
					"REPRISES" => $reprises,
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