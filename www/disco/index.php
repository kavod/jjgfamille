<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
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

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('disco'));


if ($img_mascotte)
$mascotte = $img_mascotte;

$studio = select_element("SELECT * FROM disco_albums,disco_jacks WHERE disco_albums.album_id = disco_jacks.album_id AND type = 'l\'album' AND artist_id=1 AND disco_jacks.ordre=1 ORDER BY rand() LIMIT 0,1",'',false);
$img_studio = ($studio) ? $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $studio['album_id'] . '&jack_id=' . $studio['jack_id'] . "&tnH=112" : '../templates/subSilver/images/site/px.png' ;
$live = select_element("SELECT * FROM disco_albums,disco_jacks WHERE disco_albums.album_id = disco_jacks.album_id AND type = 'le live' AND artist_id=1 AND disco_jacks.ordre=1 ORDER BY rand() LIMIT 0,1",'',false);
$img_live = ($live) ? $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $live['album_id'] . '&jack_id=' . $live['jack_id'] . "&tnH=112" : '../templates/subSilver/images/site/px.png' ;
$compil = select_element("SELECT * FROM disco_albums,disco_jacks WHERE disco_albums.album_id = disco_jacks.album_id AND type = 'la compilation' AND artist_id=1 ORDER BY rand() LIMIT 0,1",'',false);
$img_compil = ($compil) ? $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $compil['album_id'] . '&jack_id=' . $compil['jack_id'] . "&tnH=112" : '../templates/subSilver/images/site/px.png' ;
$single = select_element("SELECT * FROM disco_albums,disco_jacks WHERE disco_albums.album_id = disco_jacks.album_id AND type = 'le single' AND artist_id=1 AND disco_jacks.ordre=1 ORDER BY rand() LIMIT 0,1",'',false);
$img_single = ($single) ? $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $single['album_id'] . '&jack_id=' . $single['jack_id'] . "&tnH=112" : '../templates/subSilver/images/site/px.png' ;
$video = select_element("SELECT * FROM disco_albums,disco_jacks WHERE disco_albums.album_id = disco_jacks.album_id AND type = 'video' AND artist_id=1 AND disco_jacks.ordre=1 ORDER BY rand() LIMIT 0,1",'',false);
$img_video = ($video) ? $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $video['album_id'] . '&jack_id=' . $video['jack_id'] . "&tnH=112" : '../templates/subSilver/images/site/px.png' ;

// Ajout des enfoirés Boris le 26/11/05
$enfoires = select_element("SELECT * FROM disco_albums,disco_jacks WHERE disco_albums.album_id = disco_jacks.album_id AND type = 'le live' AND artist_id=66 AND disco_jacks.ordre=1 ORDER BY rand() LIMIT 0,1",'',false);
$img_enfoires = ($enfoires) ? $phpbb_root_path . 'functions/miniature.php?mode=artist&artist_id=66&tnH=112' : '../templates/subSilver/images/site/px.png' ;

////////////////////////// Chiffres clefs
$tab_albums = select_liste('SELECT `type`, COUNT(*) nb_disque FROM disco_albums GROUP BY `type` ORDER BY `type`');
for ($i=0;$i<count($tab_albums);$i++)
{
	switch($tab_albums[$i]['type'])
	{
		case 'l\'album':
			$nb_studio = $tab_albums[$i]['nb_disque'];
			if ($nb_studio==1)
				$l_studio_album = $lang['Studio_album'];
			else if ($nb_studio > 1)
				$l_studio_album = $lang['Studio_albums'];
			else $nb_studio = '';
			break;
		case 'le live':
			$nb_live = $tab_albums[$i]['nb_disque'];
			if ($nb_live==1)
				$l_live_album = $lang['Live_album'];
			else if ($nb_live > 1)
				$l_live_album = $lang['Live_albums'];
			else $nb_live = '';
			break;
		case 'la compilation':
			$nb_compil = $tab_albums[$i]['nb_disque'];
			if ($nb_compil==1)
				$l_compil_album = $lang['Compil_album'];
			else if ($nb_compil > 1)
				$l_compil_album = $lang['Compil_albums'];
			else $nb_compil = '';
			break;
		case 'le single':
			$nb_single = $tab_albums[$i]['nb_disque'];
			if ($nb_single==1)
				$l_single_album = $lang['Single_album'];
			else if ($nb_single > 1)
				$l_single_album = $lang['Single_albums'];
			else $nb_single = '';
			break;
		case 'video':
			$nb_video = $tab_albums[$i]['nb_disque'];
			if ($nb_video==1)
				$l_video = $lang['Vidéo'];
			else if ($nb_video > 1)
				$l_video = $lang['Vidéos'];
			else $nb_video = '';
			break;
		default:
			message_die(CRITICAL_ERROR,'Type d\'album non reconnu','',__LINE__,__FILE__,$sql);
	}
}

$count_titres = select_element('SELECT COUNT(*) nb_titres FROM disco_songs','Erreur durant la comptabilisation des titres',false);
if (!$count_titres)
	$l_nb_songs = $lang['no_song'];
else
	$l_nb_songs = ($count_titres['nb_titres']>1) ? sprintf($lang['nb_titres'],$count_titres['nb_titres']) : $lang['nb_titre'];


$accedez_disco = rubrikopif(array('disco'));

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Discographie'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/index.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}


$template->assign_vars($rubrikopif[0]);

						
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
				// Ajout des enfoirés Boris le 26/11/05
				"L_ENFOIRES" => $lang['Les_Enfoirés'],
				"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
				
				"STUDIOS" => $img_studio,
				"LIVES" => $img_live,
				"COMPILS" => $img_compil,
				"SINGLES" => $img_single,
				// Ajout des enfoirés Boris le 26/11/05
				"ENFOIRES" => $img_enfoires,
				"LISTE" => '../functions/miniature.php?mode=disco&album_id=366&jack_id=73&tnH=112',
				"PARTICIP" => '../functions/miniature.php?mode=disco&album_id=397&jack_id=58&tnH=112',
				"ACCEDEZ_DISCO" => $lang['accedez_disco'],
				"STATS_DISCO" => $accedez_disco[0]['CHIFFRES'],
				"VIDEO" => $img_video,
				
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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>
