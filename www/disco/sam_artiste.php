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

// Association d'un groupe à un artiste ou vice versa
if ($_GET['mode'] == 'asso')
{
	// Vérification de la transmission de la variable $artist_id
	if (!isset($_GET['artist_id']) || (int)$_GET['artist_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable artist_id');
	$artist_id=$_GET['artist_id'];
	
	// Passage en mode 'edit' pour réafficher le formulaire d'édition
	$_GET['mode'] = 'edit';
	
	// Sélection de l'artiste (ou du groupe) recherché
	$tab_band = select_liste("SELECT * FROM disco_artists WHERE name = '" . $_POST['asso'] . "'");
	if (count($tab_band) > 0)
	{
		// Sélection de l'artiste en cours
		$val_artist = select_element("SELECT * FROM disco_artists WHERE artist_id = '$artist_id'",true,'Artiste introuvable');
		if ($val_artist['Band']=='Y')
		{
			// L'artiste en cours est un groupe, l'artiste indiqué est donc un artiste du groupe
			$asso_band=$val_artist['artist_id'];
			$asso_artist=$tab_band[0]['artist_id'];

		} else
		{
			// L'artiste en cours est un artiste solo, l'artiste indiqué est donc un groupe de l'artiste
			$asso_artist=$val_artist['artist_id'];
			$asso_band=$tab_band[0]['artist_id'];
		}
	} else
	{
		// Artiste (ou groupe) indiqué introuvable
		list($error,$error_msg) = array(true,sprintf($lang['artist_unfound'],$_POST['asso']));
	}
	
	if (!$error)
	{
		$tab_doublon = select_liste("SELECT * FROM disco_bands WHERE band_id = '" . $asso_band . "' AND artist_id = '" . $asso_artist . "'");
		
		if (count($tab_doublon)==0)
		{
			logger("L'artiste $artist_id a été sassocié du groupe $band_id");
			$sql = "INSERT INTO disco_bands (band_id,artist_id) VALUES ('" . $asso_band . "','" . $asso_artist . "')";
			mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
			
			logger("Association artiste/groupe $artist_id/$band_id");
			
			$url=append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=$artist_id");
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $url . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['asso_artist_ok'], '<a href="' . $url . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		} else
		{
			list($error,$error_msg) = array(true,sprintf($lang['artist_already_binded'],$_POST['asso']));
		}
	}
}

if ($_GET['mode'] == 'supp')
{
	if (!isset($_GET['artist_id']) || (int)$_GET['artist_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable artist_id');
	$artist_id = (int)$_GET['artist_id'];
	
	$tab_albums = select_liste("SELECT * FROM disco_albums WHERE artist_id = " . $artist_id);
	$tab_songs = select_liste("SELECT disco_songs.*, disco_artists_job.job FROM disco_artists_job, disco_songs WHERE disco_artists_job.project = disco_songs.song_id AND artist_id = " . $artist_id . " ORDER BY title,project,job");
	
	if (count($tab_albums) + count($tab_songs) > 0)
		list($error,$error_msg) = array(true,$lang['cannot_supp_artist']);
		
	if (!$error)
	{
	
		$filename = $phpbb_root_path . 'images/disco/photo_artist_' . $artist_id;
		$u_photo = find_image($filename);
		if ($u_photo)
		{
			logger("Suppression de la photo de l'artiste N°$artist_id");
		
			if(unlink($filename . '.' . $u_photo))
			{ } else logger("BUG : Impossible de supprimer " . $filename . '.' . $u_photo);
		}
		
	}
	
	if (!$error)
	{
		$sql = "DELETE FROM disco_bands WHERE artist_id = '" . $artist_id . "'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
		
		$sql = "DELETE FROM disco_artists WHERE artist_id = '" . $artist_id . "'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
		
		logger("artiste N°$artist_id supprimé");
		
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam." . $phpEx . "?mode=artists") . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_artist_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam." . $phpEx . "?mode=artists") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		
	} else $_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'deasso')
{
	if (!isset($_GET['artist_id']) || (int)$_GET['artist_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable artist_id');
	$artist_id = (int)$_GET['artist_id'];

	if (!isset($_GET['band_id']) || (int)$_GET['band_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable band_id');
	$band_id = (int)$_GET['band_id'];
	
	$from = $_GET['from'];
	
	$sql = "DELETE FROM disco_bands WHERE artist_id = '$artist_id' AND band_id = '$band_id'";
	mysql_query($sql) or message_die(CRITICAL_ERROR,$sql . '<br />' . mysql_error());
	
	logger("L'artiste $artist_id a été désassocié du groupe $band_id");
	
	
	$val_artiste = select_element("SELECT name FROM disco_artists WHERE artist_id = '$artist_id'",true,"Artiste introuvable");
	$val_band = select_element("SELECT name FROM disco_artists WHERE artist_id = '$band_id'",true,"Artiste introuvable");
	
	$cible_id = ($from == 'artist') ? $artist_id : $band_id;
	$val_cible = select_element("SELECT name FROM disco_artists WHERE artist_id = '$cible_id'",true,"Artiste introuvable");
	
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $cible_id) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['deasso_artist_ok'], $val_artiste['name'],$val_band['name'],'<a href="' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $cible_id) . '">', '</a>',$val_cible['name']);
	message_die(GENERAL_MESSAGE, $message);

}

if ($_GET['mode'] == 'supp_photo')
{
	if (!isset($_GET['artist_id']) || (int)$_GET['artist_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable artist_id');
	$artist_id = (int)$_GET['artist_id'];
	
	$filename = $phpbb_root_path . 'images/disco/photo_artist_' . $artist_id;
	$u_photo = find_image($filename);
	
	logger("Suppression de la photo de l'artiste N°$artist_id");
	
	if (unlink($filename . '.' . $u_photo))
	{
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $artist_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_photo_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $artist_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
	} else
	{
		list($error,$error_msg) = array(true,'Erreur durant la suppression de la photographie');
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'edit')
{
	if (!isset($_GET['artist_id']) || (int)$_GET['artist_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable artist_id');
	$artist_id = (int)$_GET['artist_id'];
	
	$val_artist = select_element("SELECT * FROM disco_artists WHERE artist_id = '$artist_id'",true,'Artiste introuvable');
	
	$nom = $val_artist['name'];
	$checked_artist = ($val_artist['Band'] == 'N') ? ' CHECKED': '';
	$checked_band = ($val_artist['Band'] == 'Y') ? ' CHECKED': '';
}

if ($_GET['mode'] == 'doadd')
{	
	if (!isset($_POST['nom']) || $_POST['nom'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['nom']));
	$nom = $_POST['nom'];
	
	if (!isset($_POST['band']) || $_POST['band'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['groupe']));
	$band = $_POST['band'];
	$checked_artist = ($_POST['band'] == 'N') ? ' CHECKED': '';
	$checked_band = ($_POST['band'] == 'Y') ? ' CHECKED': '';
	
	$user_photo_upload =  ( $HTTP_POST_FILES['photo']['tmp_name'] != "none") ? $HTTP_POST_FILES['photo']['tmp_name'] : '' ;
	
	if (!$error)
	{
		$doublon = select_liste("SELECT artist_id FROM disco_artists WHERE name = '$nom'");
		if (count($doublon)>0)
			list($error,$error_msg) = array(true,sprintf($lang['artist_doublon'],$nom));
	} else $_GET['mode'] = 'add';
	
	if (!$error)
	{
		$sql = "INSERT INTO disco_artists (name, Band) VALUES('$nom','$band')";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout de l'artiste");
		$artist_id = mysql_insert_id();
		logger("Ajout de l'artiste $nom ($artist_id)");
		
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		$error_illu = false;
		$error_msg_illu = '';
		$message_illu = '';
		
		if ($user_photo_upload!= '')
		{
			$filesize = array($site_config['artist_max_filesize'],$site_config['artist_max_width'],$site_config['artist_max_height']);
		
			user_upload_easy($error_illu,$error_msg_illu,$HTTP_POST_FILES['photo'],$phpbb_root_path . 'images/disco/photo_artist_' . $artist_id,$filesize);
			if ($error_illu)
			{
				$message_illu = '<br />' . sprintf($lang['But_not_illu'],$error_msg_illu);
			}
		}
		
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $artist_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Add_artist_ok'].$message_illu, '<a href="' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $artist_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}			
	} else $_GET['mode'] = 'add';
}

if ($_GET['mode'] == 'doedit')
{
	if (!isset($_GET['artist_id']) || (int)$_GET['artist_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable artist_id');
	$artist_id = $_GET['artist_id'];
	
	if (!isset($_POST['nom']) || $_POST['nom'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['nom']));
	$nom = $_POST['nom'];
	
	if (!isset($_POST['band']) || $_POST['band'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['groupe']));
	$band = $_POST['band'];
	$checked_artist = ($_POST['band'] == 'N') ? ' CHECKED': '';
	$checked_band = ($_POST['band'] == 'Y') ? ' CHECKED': '';
	
	$user_photo_upload =  ( $HTTP_POST_FILES['photo']['tmp_name'] != "none") ? $HTTP_POST_FILES['photo']['tmp_name'] : '' ;
	
	if (!$error)
	{
		$doublon = select_liste("SELECT artist_id FROM disco_artists WHERE name = '$nom' AND artist_id <> '" . $artist_id . "'");
		if (count($doublon)>0)
			list($error,$error_msg) = array(true,sprintf($lang['artist_doublon'],$nom));
	} else $_GET['mode'] = 'edit';
	
	if (!$error)
	{
		$sql = "UPDATE disco_artists SET name = '$nom', Band = '$band' WHERE artist_id = '" . $artist_id . "'";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'artiste");
		logger("Modification de l'artiste $nom ($artist_id)");
		
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		$error_illu = false;
		$error_msg_illu = '';
		$message_illu = '';
		
		if ($user_photo_upload!= '')
		{
			$filesize = array($site_config['artist_max_filesize'],$site_config['artist_max_width'],$site_config['artist_max_height']);
		
			user_upload_easy($error_illu,$error_msg_illu,$HTTP_POST_FILES['photo'],$phpbb_root_path . 'images/disco/photo_artist_' . $artist_id,$filesize);
			if ($error_illu)
			{
				$message_illu = '<br />' . sprintf($lang['But_not_illu'],$error_msg_illu);
			}
		}
		
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $artist_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Edit_artist_ok'].$message_illu, '<a href="' . append_sid($phpbb_root_path . "disco/sam_artiste." . $phpEx . "?mode=edit&artist_id=" . $artist_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}			
	} else $_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'edit')
{
	$filename = $phpbb_root_path . 'images/disco/photo_artist_' . $artist_id;
	$u_photo = find_image($filename);
	
	$u_action = append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=doedit&artist_id=' . $artist_id);
	$l_action = $lang['edit_artist'];
	$l_submit = $lang['Modifier'];
	
	$tab_albums = select_liste("SELECT * FROM disco_albums WHERE artist_id = " . $artist_id);
	$tab_songs = select_liste("SELECT disco_songs.*, disco_artists_job.job FROM disco_artists_job, disco_songs WHERE disco_artists_job.project = disco_songs.song_id AND artist_id = " . $artist_id . " ORDER BY title,project,job");
	
	$from = ($val_artist['Band'] == 'Y') ? 'band' : 'artist';
	$sql_band = ($val_artist['Band'] == 'Y') ? 
			"SELECT disco_artists.*,band_id FROM disco_bands,disco_artists WHERE disco_bands.artist_id = disco_artists.artist_id AND band_id = '" .$artist_id . "'" : 
			"SELECT disco_artists.*,band_id FROM disco_bands,disco_artists WHERE disco_bands.band_id = disco_artists.artist_id AND disco_bands.artist_id = '" .$artist_id . "'";
	$tab_band = select_liste($sql_band);
}

if ($_GET['mode'] == 'add')
{
	$u_action = append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=doadd');
	$l_action = $lang['add_artiste'];
	$l_submit = $lang['Ajouter'];
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/sam_artiste.tpl',
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
			'U_RETOUR' => append_sid($phpbb_root_path . 'disco/sam.php?mode=artists'),
			"L_VIDEO" => $lang['Videothèque'],
			"U_VIDEO" => append_sid($phpbb_root_path . 'disco/albums.php?mode=video'),
			"L_ENFOIRES" => $lang['Les_Enfoirés'],
			"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
			)
);
if ($u_photo)
{
	$template->assign_block_vars('switch_photo',array(
							"L_CURRENT_PHOTO" => $lang['Current_Image'],
							"L_SUPP_ILLU" => $lang['supp_photo'],
							"L_SUPP_PHOTO_CONFIRM" => $lang['supp_photo_confirm'],
							
							"U_SUPP_ILLU" => append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=supp_photo&artist_id=' . $artist_id),
							
							"IMG_PHOTO" => $filename . '.' . $u_photo,
							"IMG_ALT" => $lang['Photo'] . ' ' . $val_artist['name'],
							));
}

if ($_GET['mode']=='edit')
{
	$str_supp = "javascript:if(confirm('%s')) %s;";
	$javascript_supp = 
		(count($tab_albums)+count($tab_songs)==0) 
		? sprintf(
			$str_supp,
			addslashes(sprintf(
				$lang['Confirm'],
				$lang['supp_artist']
			)),
			"document.location='" . append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=supp&artist_id=' . $artist_id) . "'" )
		: sprintf($str_supp,addslashes($lang['cannot_supp_artist']),'');

		
	$mode_search = ($from == 'artist') ? 'groupe' : 'artiste_solo';
	$l_search = ($from == 'artist') ? htmlentities($lang['search_band']) : htmlentities($lang['search_artist']);
	$template->assign_block_vars('switch_stat',array(
							"L_STAT" => $lang['statistiques'],
							"L_ALBUMS" => $lang['Albums'],
							"L_SONGS" => $lang['Songs'],
							"L_SUPP_ARTIST" => $lang['supp_artist'],
							"L_BAND_ACTION" => ($from == 'artist') ? $lang['bands_of_artist'] : $lang['artists_of_band'],
							"L_SEARCH_ARTIST"=> $l_search,
							"L_SUBMIT" => $lang['associer'],
							
							"U_SEARCH_ARTIST" => append_sid($phpbb_root_path . 'disco/search.php?mode=' . $mode_search . '&formulaire=search_band&champs=asso'),
							"U_BAND_ACTION" => append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=asso&artist_id=' . $artist_id),
							"U_SUPP_ARTIST" => $javascript_supp,
							));
	if (count($tab_band) > 0)
	{
		while(list($key,$val) = each($tab_band))
		{
			$band_id = ($from=='artist') ? $val['band_id'] : $val_artist['artist_id'];
			$band_artist_id = ($from=='artist') ? $val_artist['artist_id'] : $val['artist_id'];
			$template->assign_block_vars('switch_stat.band',array(
								"L_BAND" => $val['name'],
								
								"U_BAND" => append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=edit&artist_id=' . $val['artist_id']),
								"U_BAND_DEASSO" => append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=deasso&artist_id=' . $band_artist_id . '&band_id=' . $band_id . '&from=' . $from),
								));
		}
	} else $template->assign_block_vars('switch_stat.no_band',array("L_BAND" => $lang['Aucun']));
	
	if (count($tab_albums)>0)
	{
		while(list($key,$val) = each($tab_albums))
			$template->assign_block_vars('switch_stat.album',array(
								"TITRE" => $val['title']
								));
	} else $template->assign_block_vars('switch_stat.album',array("TITRE" => $lang['no_album']));
	
	if (count($tab_songs)>0)
	{
		$song_id = 0;
		while(list($key,$val) = each($tab_songs))
		{
			if ($song_id == $val['song_id'])
			{
				$str .= ", " . $val['job'];
			} else
			{
				if ($song_id !=0)
					$template->assign_block_vars('switch_stat.song',array(
									"TITRE" => $str
									));
				$str = '<b>' . $val['title'] . "</b> en tant que " . $val['job'];
				$song_id = $val['song_id'];
			}
		}
		$template->assign_block_vars('switch_stat.song',array(
							"TITRE" => $str
							));
	} else $template->assign_block_vars('switch_stat.song',array("TITRE" => $lang['no_song']));
}

$template->assign_vars(array(
			"L_ACTION" => $l_action,
			"L_NOM" => $lang['nom'],
			"L_IS_BAND" => sprintf($lang['interro'],$lang['groupe']),
			"L_ARTISTE" => $lang['artiste'],
			"L_BAND" => $lang['groupe'],
			"L_PHOTO" => $lang['photo'],
			"L_SUBMIT" => $l_submit,
			"L_DEASSO" => $lang['deassocier'],
			
			"U_ACTION" => $u_action,
			
			"NOM" => htmlentities($nom),
			"CHECKED_ARTIST" => ($checked_artist != 'Y' && $checked_band != 'Y') ? ' CHECKED' : $checked_artist,
			"CHECKED_BAND" => $checked_band,
			));



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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>