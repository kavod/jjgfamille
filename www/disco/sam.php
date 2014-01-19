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
// Vérification des permissions
$job = array('sam');
require_once($phpbb_root_path . 'includes/reserved_access.php');

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='sam' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('disco'));

// Variables de gestion
if(isset($_GET['mode']))
{
	switch($_GET['mode'])
	{
		case 'artists':
			$add = $lang['add_artiste'];
			$u_add = $phpbb_root_path . 'disco/sam_artiste.php?mode=add';
			$search = $lang['search_artiste'];
			$search_by_name = $lang['search_artiste_by_name'];
			
			// Recherche des premières lettres
			$sql = "SELECT DISTINCT UPPER(SUBSTRING(name,1,1)) lettre FROM disco_artists ORDER BY lettre";
			$lettres = select_liste($sql);
			break;
		case 'albums':
			$add = $lang['add_album'];
			$u_add = $phpbb_root_path . 'disco/sam_album.php?mode=add';
			$search = $lang['search_album'];
			$search_by_name = $lang['search_album_by_name'];
			
			// Recherche des premières lettres
			$sql = "SELECT DISTINCT UPPER(SUBSTRING(title,1,1)) lettre FROM disco_albums ORDER BY lettre";
			$lettres = select_liste($sql);
			break;
		case 'songs':
			$add = $lang['add_song'];
			$u_add = $phpbb_root_path . 'disco/sam_song.php?mode=add';
			$search = $lang['search_song'];
			$search_by_name = $lang['search_song_by_name'];
			
			// Recherche des premières lettres
			$sql = "SELECT DISTINCT UPPER(SUBSTRING(title,1,1)) lettre FROM disco_songs ORDER BY lettre";
			$lettres = select_liste($sql);
			break;
		default:
			message_die(GENERAL_MESSAGE,"mode " . $_GET['mode'] . " non reconnu");
	}
}

if (isset($_POST['name']))
{
	$_POST['name'] = trim($_POST['name']);
	switch($_GET['mode'])
	{
		case 'artists':
			// Recherche à partir du nom
			$sql = "SELECT 
					artiste.artist_id id,
					artiste.name champ1,
					IF(STRCMP(artiste.Band,'Y'),'" . $lang['non'] . "','" . $lang['oui'] . "') champ4, 
					COUNT(album.album_id) champ2 
				FROM 
					disco_artists artiste 
				LEFT JOIN 
					disco_albums album
				ON 
					artiste.artist_id = album.artist_id
				WHERE 
					name LIKE '%" . $_POST['name'] . "%' 
				GROUP BY 
					artiste.artist_id 
				ORDER BY 
					name";
			$resultat1 = select_liste($sql);
			
			// Recherche à partir du nom
			$sql = "SELECT 
					COUNT(song.project) champ3 
				FROM 
					disco_artists artiste 
				LEFT JOIN 
					disco_artists_job song
				ON 
					artiste.artist_id = song.artist_id
				WHERE 
					name LIKE '%" . $_POST['name'] . "%' 
				GROUP BY 
					artiste.artist_id 
				ORDER BY 
					name";
			$resultat2 = select_liste($sql);
			
			for ($i=0;$i<count($resultat2);$i++)
				$resultat[$i] = array_merge($resultat1[$i],$resultat2[$i]);
				
			$u_edit = 'disco/sam_artiste.php?mode=edit&artist_id=';
			$champ1 = $lang['artiste'];
			$champ2 = $lang['nb_albums'];
			$champ3 = $lang['nb_songs'];
			$champ4 = sprintf($lang['interro'],$lang['groupe']);
			break;
		case 'albums':
			// Recherche à partir du nom
			$sql = "SELECT 
					album.album_id id,
					album.title champ1,
					album.type champ2,
					album.date champ3,
					artiste.name champ4
				FROM 
					disco_albums album, 
					disco_artists artiste 
				WHERE 
					artiste.artist_id = album.artist_id AND 
					title LIKE '%" . $_POST['name'] . "%' 
				ORDER BY 
					title";
			$resultat = select_liste($sql);
			
			for ($i=0;$i<count($resultat);$i++)
				$resultat[$i]['champ3'] = ((int)substr($resultat[$i]['champ3'],4)==0) ? substr($resultat[$i]['champ3'],0,4) : substr($resultat[$i]['champ3'],6,2) . '/' . substr($resultat[$i]['champ3'],4,2) . '/' . substr($resultat[$i]['champ3'],0,4);
			
			$u_edit = 'disco/sam_album.php?mode=edit&album_id=';
			
			$champ1 = $lang['l_titre'];
			$champ2 = $lang['Type'];
			$champ3 = $lang['Date'];
			$champ4 = $lang['artiste'];
			
			break;
		case 'songs':
			// Recherche à partir du nom
			$sql = "SELECT 
					song.song_id id,
					song.title champ1,
					COUNT(album.album_id) champ2,
					MIN(album.date) champ3,
					IF(song.reprise_id,'" . $lang['oui'] . "','" . $lang['non'] . "') champ4
				FROM
					disco_songs song
				LEFT JOIN
					disco_songs_albums asso
				ON
					asso.song_id = song.song_id
				LEFT JOIN
					disco_albums album
				ON 
					album.album_id = asso.album_id 
				WHERE 
					song.title LIKE '%" . $_POST['name'] . "%'
				GROUP BY
					song.song_id
				ORDER BY 
					song.title";
			
			$resultat = select_liste($sql);
			
			for ($i=0;$i<count($resultat);$i++)
				$resultat[$i]['champ3'] = ((int)substr($resultat[$i]['champ3'],4)==0) ? substr($resultat[$i]['champ3'],0,4) : substr($resultat[$i]['champ3'],6,2) . '/' . substr($resultat[$i]['champ3'],4,2) . '/' . substr($resultat[$i]['champ3'],0,4);
			
			$u_edit = 'disco/sam_song.php?mode=edit&song_id=';
			
			$champ1 = $lang['l_titre'];
			$champ2 = $lang['nb_albums'];
			$champ3 = $lang['Date'];
			$champ4 = sprintf($lang['interro'],$lang['reprise']);
			break;
		default:
			message_die(GENERAL_MESSAGE,"mode " . $_GET['mode'] . " non reconnu");
	}
}

if (isset($_POST['lettre']))
{
	if ($_POST['lettre']=='0')
		$_POST['lettre'] = '';
	switch($_GET['mode'])
	{
		case 'artists':			
			// Recherche à partir du nom
			$sql = "SELECT 
					artiste.artist_id id,
					artiste.name champ1,
					IF(STRCMP(artiste.Band,'Y'),'" . $lang['non'] . "','" . $lang['oui'] . "') champ4, 
					COUNT(album.album_id) champ2 
				FROM 
					disco_artists artiste 
				LEFT JOIN 
					disco_albums album
				ON 
					artiste.artist_id = album.artist_id
				WHERE 
					name LIKE '" . $_POST['lettre'] . "%' 
				GROUP BY 
					artiste.artist_id 
				ORDER BY 
					name";
			$resultat1 = select_liste($sql);
			
			// Recherche à partir du nom
			$sql = "SELECT 
					COUNT(song.project) champ3 
				FROM 
					disco_artists artiste 
				LEFT JOIN 
					disco_artists_job song
				ON 
					artiste.artist_id = song.artist_id
				WHERE 
					name LIKE '" . $_POST['lettre'] . "%' 
				GROUP BY 
					artiste.artist_id 
				ORDER BY 
					name";
			$resultat2 = select_liste($sql);
			$u_edit = 'disco/sam_artiste.php?mode=edit&artist_id=';
			
			for ($i=0;$i<count($resultat2);$i++)
				$resultat[$i] = array_merge($resultat1[$i],$resultat2[$i]);
			
			$champ1 = $lang['artiste'];
			$champ2 = $lang['nb_albums'];
			$champ3 = $lang['nb_songs'];
			$champ4 = sprintf($lang['interro'],$lang['groupe']);
			break;
		case 'albums':
			// Recherche à partir du nom
			$sql = "SELECT 
					album.album_id id,
					album.title champ1,
					album.type champ2,
					album.date champ3,
					artiste.name champ4
				FROM 
					disco_albums album, 
					disco_artists artiste 
				WHERE 
					artiste.artist_id = album.artist_id AND 
					title LIKE '" . $_POST['lettre'] . "%' 
				ORDER BY 
					title";
			$resultat = select_liste($sql);
			
			for ($i=0;$i<count($resultat);$i++)
				$resultat[$i]['champ3'] = ((int)substr($resultat[$i]['champ3'],4)==0) ? substr($resultat[$i]['champ3'],0,4) : substr($resultat[$i]['champ3'],6,2) . '/' . substr($resultat[$i]['champ3'],4,2) . '/' . substr($resultat[$i]['champ3'],0,4);
			
			$u_edit = 'disco/sam_album.php?mode=edit&album_id=';
			
			$champ1 = $lang['l_titre'];
			$champ2 = $lang['Type'];
			$champ3 = $lang['Date'];
			$champ4 = $lang['artiste'];
			break;
		case 'songs':
			// Recherche à partir du nom
			$sql = "SELECT 
					song.song_id id,
					song.title champ1,
					COUNT(album.album_id) champ2,
					MIN(album.date) champ3,
					IF(song.reprise_id,'" . $lang['oui'] . "','" . $lang['non'] . "') champ4
				FROM
					disco_songs song
				LEFT JOIN
					disco_songs_albums asso
				ON 
					asso.song_id = song.song_id
				LEFT JOIN 
					disco_albums album
				ON 
					album.album_id = asso.album_id
				WHERE 
					song.title LIKE '" . $_POST['lettre'] . "%'
				GROUP BY
					song.song_id
				ORDER BY 
					song.title";
			
			$resultat = select_liste($sql);
			
			for ($i=0;$i<count($resultat);$i++)
				$resultat[$i]['champ3'] = ((int)substr($resultat[$i]['champ3'],4)==0) ? substr($resultat[$i]['champ3'],0,4) : substr($resultat[$i]['champ3'],6,2) . '/' . substr($resultat[$i]['champ3'],4,2) . '/' . substr($resultat[$i]['champ3'],0,4);
			
			$u_edit = 'disco/sam_song.php?mode=edit&song_id=';
			
			$champ1 = $lang['l_titre'];
			$champ2 = $lang['nb_albums'];
			$champ3 = $lang['Date'];
			$champ4 = sprintf($lang['interro'],$lang['reprise']);
			break;
		default:
			message_die(GENERAL_MESSAGE,"mode " . $_GET['mode'] . " non reconnu");
	}
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);

if (!isset($_GET['mode']))
{
	$template->set_filenames(array(
			'body' => 'site/disco/sam.tpl',
			));
}

if (isset($_GET['mode']))
{
	$template->set_filenames(array(
			'body' => 'site/disco/sam_gestion.tpl',
			));
}

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}


$template->assign_vars($rubrikopif[0]);


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
				"L_LIST_SONG" => $lang['list_song'],
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/list_song.php'),
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'disco/sam.php'),
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/albums.php?mode=video'),
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

if (!isset($_GET['mode']))
	$template->assign_vars(array(
				'L_ADMIN_ARTISTS' => $lang['gestion_artistes'],
				'L_ADMIN_ALBUMS' => $lang['gestion_albums'],
				'L_ADMIN_SONGS' => $lang['gestion_songs'],
				
				'U_ADMIN_ARTISTS' => append_sid($phpbb_root_path . 'disco/sam.php?mode=artists'),
				'U_ADMIN_ALBUMS' => append_sid($phpbb_root_path . 'disco/sam.php?mode=albums'),
				'U_ADMIN_SONGS' => append_sid($phpbb_root_path . 'disco/sam.php?mode=songs'),
				));
else
{
	while(list($key,$val) = each($lettres))
		$template->assign_block_vars('lettres',array(
							'LETTRE' => $val['lettre']
							));
	if (isset($resultat))
	{
		$template->assign_block_vars('switch_liste',array(
								'L_RESULTAT' => $lang['search_result'],
								'L_CHAMP1' => $champ1,
								'L_CHAMP2' => $champ2,
								'L_CHAMP3' => $champ3,
								'L_CHAMP4' => $champ4,
								));
		while(list($key,$val) = each($resultat))
			$template->assign_block_vars('switch_liste.liste',array(
								'CHAMP1' => $val['champ1'],
								'CHAMP2' => $val['champ2'],
								'CHAMP3' => $val['champ3'],
								'CHAMP4' => $val['champ4'],
								
								'L_EDIT' => $lang['Editer'],
								
								'U_EDIT' => append_sid($phpbb_root_path . $u_edit . $val['id'])
								));
	}
	$template->assign_vars(array(
				'L_ADD' => $add,
				'L_SEARCH_ELEMENT' => $search,
				'L_SEARCH_BY_NAME' => sprintf($lang['deux_points'],$search_by_name),
				'L_SEARCH' => $lang['Search'],
				'L_SEE_LISTE' => sprintf($lang['deux_points'],$lang['see_liste']),
				'L_AFFICHER' => $lang['Afficher'],
				
				'U_ADD' => append_sid($u_add),
				));
}
$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>