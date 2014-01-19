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

// Sélection de l'artiste
// Par défaut : c'est JJG
if(!isset($_GET['artist_id']))
	$_GET['artist_id'] = 1;

// Sélection des possibles groupes
$val_artist = select_element("SELECT * FROM disco_artists WHERE artist_id = '".$_GET['artist_id']."'",'',false);
$sql = "SELECT * FROM disco_artists WHERE (artist_id='".$_GET['artist_id']."'";
$result_band = mysql_query("SELECT * FROM disco_bands WHERE artist_id = '".$_GET['artist_id']."'");

While ($val_band = mysql_fetch_array($result_band))
{
	$sql .= " OR artist_id = ".$val_band['band_id'];
}
$sql .= ") ORDER BY artist_id";

$tab_artist = select_liste($sql);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

// Titre
switch($_GET['mode'])
{
	Case 'studio':
		$page_title = $val_artist['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Studio_albums']);
		break;
	Case 'live':
		$page_title = $val_artist['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Live_albums']);
		break;
	Case 'compil':
		$page_title = $val_artist['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Compil_albums']);
		break;
	Case 'video':
		$page_title = $val_artist['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Videothèque']);
		break;
	default:
		$page_title = $lang['Discographie'];
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/albums.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

define("NB_BY_COL",3);

for ($k=0;$k<count($tab_artist);$k++)
{
	
	switch($_GET['mode'])
	{
		Case 'studio':
			$tab_albums = select_liste("SELECT * FROM disco_albums WHERE artist_id= ".$tab_artist[$k]['artist_id']." AND type = 'l\'album' ORDER BY date");
			if($tab_albums)
				$title = $tab_artist[$k]['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Studio_albums']);
			else $title = '';
			break;
		Case 'live':
			$tab_albums = select_liste("SELECT * FROM disco_albums WHERE artist_id= ".$tab_artist[$k]['artist_id']." AND type = 'le live' ORDER BY date");
			if($tab_albums)
				$title = $tab_artist[$k]['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Live_albums']);
			else $title = '';
			break;
		Case 'single':
			$tab_albums = select_liste("SELECT * FROM disco_albums WHERE artist_id= ".$tab_artist[$k]['artist_id']." AND type = 'le single' ORDER BY date");
			if($tab_albums)
				$title = $tab_artist[$k]['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Single_albums']);
			else $title = '';
			break;
		Case 'compil':
			$tab_albums = select_liste("SELECT * FROM disco_albums WHERE artist_id= ".$tab_artist[$k]['artist_id']." AND type = 'la compilation' ORDER BY date");
			if($tab_albums)	
				$title = $tab_artist[$k]['name'].'&nbsp;:&nbsp;'.ucfirst($lang['Compil_albums']);
			else $title = '';
			break;
		Case 'video':
			$tab_albums = select_liste("SELECT * FROM disco_albums WHERE artist_id= ".$tab_artist[$k]['artist_id']." AND type = 'video' ORDER BY date");
			if($tab_albums) 
				$title = $tab_artist[$k]['name'].'&nbsp;:&nbsp;'.$lang['Videothèque'];
			else $title = '';
		break;
	} 
	
	$template->assign_block_vars('artists',array(
			"TITLE" => $title,
			)
		);
	
	$nb_albums = count($tab_albums);
	// Pour chaque ligne...
	$i=0;
	while($i<$nb_albums)
	{
		$template->assign_block_vars('artists.albums_row',array());
		// Pour chaque image de la ligne
		for ($j=0;$j < NB_BY_COL && $i<$nb_albums;$j++)
		{
			
			$val_jack = select_element("SELECT * FROM disco_jacks WHERE album_id = ".$tab_albums[$i]['album_id']." ORDER BY ordre LIMIT 0,1",'',false);
			
			$ext = find_image('../images/disco/jack_' . $tab_albums[$i]['album_id'].'_'.$val_jack['jack_id'].'.');
			if (is_file('../images/disco/jack_' . $tab_albums[$i]['album_id'].'_'.$val_jack['jack_id'].'.'.$ext))
			{
				$img = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $tab_albums[$i]['album_id'] . '&jack_id='. $val_jack['jack_id'];
			}else
			{
					
				$img = $phpbb_root_path . 'functions/miniature.php?mode=nojack';
			}
			
			$template->assign_block_vars('artists.albums_row.albums_column',array(
								'PHOTO' => $img,
								"TITLE" => $tab_albums[$i]['title'],
								'DATE' => substr($tab_albums[$i]['date'],0,4),
								'U_TITLE' => append_sid($phpbb_root_path . 'disco/goldman-album-'.$tab_albums[$i]['album_id'].'-'.url_title($tab_albums[$i]['title']).'.html'),
								)
							);
			$i++;
		}
	}
}

$template->assign_vars(array(
				'NOM_RUB' => $lang['Discographie'],
				"IMG_MASCOTTE" => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				"L_STUDIOS" => ucfirst($lang['Studio_albums']),
				"U_STUDIOS" => append_sid($phpbb_root_path . 'disco/goldman-albums-studio.html'),
				"L_LIVES" => ucfirst($lang['Live_albums']),
				"U_LIVES" => append_sid($phpbb_root_path . 'disco/goldman-albums-live.html'),
				"L_COMPILATIONS" => ucfirst($lang['Compil_albums']),
				"U_COMPILATIONS" => append_sid($phpbb_root_path . 'disco/goldman-albums-compil.html'),	
				"L_PARTICIPATIONS" => ucfirst($lang['Participations']),
				"U_PARTICIPATIONS" => append_sid($phpbb_root_path . 'disco/goldman-participations.html'),
				"L_SINGLES" => ucfirst($lang['Single_albums']),
				"U_SINGLES" => append_sid($phpbb_root_path . 'disco/goldman-singles.html'),
				"L_LIST_SONG" => $lang['list_song'],
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/goldman-liste-chansons.html'),
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'disco/'),
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman-albums-video.html'),
				"L_ENFOIRES" => $lang['Les_Enfoirés'],
				"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les-enfoires-albums-live-66.html'),
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