<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'functions/functions_fmc.php');
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

$type_tab = array( 'Tablatures', 'Scores', 'Relevé d\'accords');

if ($_GET['mode'] == 'supp_real')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	$val_asso = select_element("SELECT * FROM disco_songs_albums WHERE id = '" . $asso_id . "'");
	
	if (!$error)
	{
		supp_fmc($error,$error_msg,'disco/extrait_' . $val_asso['id'],'.rm');
		
		$tab_song = select_liste("SELECT 
						asso.id
					FROM 
						disco_songs_albums asso, 
						disco_songs song 
					WHERE 
						song.song_id = '" . $val_asso['song_id'] . "' AND 
						song.song_id = asso.song_id");
		$ya_file = false;
		for ($i=0;!$ya_file && $i<count($tab_song);$i++)
		{
			if (is_file($phpbb_root_path . 'audio/disco/extrait_' . $tab_song[$i]['id'] . '.ram'))
				$ya_file = true;
		}
		logger("Suppression de l'extrait audio de la discographie N°$asso_id sur le titre " . $tab_song[0]['title']);
		if ($ya_file)
			mysql_query("UPDATE disco_songs SET rm = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		else
			mysql_query("UPDATE disco_songs SET rm = 'N' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_real_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'supp_gp')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	$val_asso = select_element("SELECT asso.*,song.dataname FROM disco_songs_albums asso,disco_songs song WHERE song.song_id = asso.song_id AND id = '" . $asso_id . "'",true,'association introuvable');
	
	if (!$error)
	{
		if(!unlink($phpbb_root_path . 'audio/disco/' . $val_asso['dataname'] . '_' . $val_asso['id'] . '.gp3'))
		{
			$error = true;
			$error_msg = "<br />Le fichier n'existait pas";
		}
		
		$tab_song = select_liste("SELECT 
						asso.id
					FROM 
						disco_songs_albums asso, 
						disco_songs song 
					WHERE 
						song.song_id = '" . $val_asso['song_id'] . "' AND 
						song.song_id = asso.song_id");
		$ya_file = false;
		for ($i=0;!$ya_file && $i<count($tab_song);$i++)
		{
			if (is_file($phpbb_root_path . 'audio/disco/' . $val_asso['dataname'] . '_' . $tab_song[$i]['id'] . '.gp3'))
				$ya_file = true;
		}
		logger("Suppression du fichier GuitarPro de la discographie N°$asso_id sur le titre " . $tab_song[0]['title']);
		if ($ya_file)
			mysql_query("UPDATE disco_songs SET gp = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		else
			mysql_query("UPDATE disco_songs SET gp = 'N' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_gp_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'supp_part')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	$val_asso = select_element("SELECT asso.*,song.dataname FROM disco_songs_albums asso,disco_songs song WHERE song.song_id = asso.song_id AND id = '" . $asso_id . "'",true,'association introuvable');
	
	if (!$error)
	{
		if(!unlink($phpbb_root_path . 'textes/disco/' . $val_asso['dataname'] . '_' . $val_asso['id'] . '.txt'))
		{
			$error = true;
			$error_msg = "<br />Le fichier n'existait pas";
		}
		
		logger("Suppression de la partition de l'association N°$asso_id");
		
		mysql_query("UPDATE disco_songs_albums SET part_author = '',part_type = '',part_adress='' WHERE id = '" . $asso_id . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_part_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'supp_midi')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	$val_asso = select_element("SELECT asso.*,song.dataname FROM disco_songs_albums asso,disco_songs song WHERE song.song_id = asso.song_id AND id = '" . $asso_id . "'",true,'association introuvable');
	
	if (!$error)
	{
		if(!unlink($phpbb_root_path . 'audio/disco/midi_' . $val_asso['id'] . '.mid'))
		{
			$error = true;
			$error_msg = "<br />Le fichier n'existait pas";
		}
		
		$tab_song = select_liste("SELECT 
						asso.id
					FROM 
						disco_songs_albums asso, 
						disco_songs song 
					WHERE 
						song.song_id = '" . $val_asso['song_id'] . "' AND 
						song.song_id = asso.song_id");
		$ya_file = false;
		for ($i=0;!$ya_file && $i<count($tab_song);$i++)
		{
			if (is_file($phpbb_root_path . 'audio/disco/midi_' . $tab_song[$i]['id'] . '.mid'))
				$ya_file = true;
		}
		logger("Suppression du fichier Midi de la discographie N°$asso_id sur le titre " . $tab_song[0]['title']);
		if ($ya_file)
			mysql_query("UPDATE disco_songs SET midi = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		else
			mysql_query("UPDATE disco_songs SET midi = 'N' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_midi_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'add_real')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	$val_asso = select_element("SELECT * FROM disco_songs_albums WHERE id = '" . $asso_id . "'");
	
	if (!$error)
	{
		upload_fmc(
			$error,
			$error_msg,
			$HTTP_POST_FILES['real']['tmp_name'],
			$_FILES['real']['name'],
			$_FILES['real']['size'],
			dernier_point($_FILES['real']['name']),
			'disco/extrait_'.$asso_id
			);
		logger("Ajout d'un extrait audio pour l'association N°" . $asso_id);
		if (!$error)
			finish_fmc('disco/extrait_'.$asso_id,dernier_point($_FILES['real']['name']));
		if (!$error)
			mysql_query("UPDATE disco_songs SET rm = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['add_real_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'add_part')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	
	if (!isset($_POST['part_type']) || $_POST['part_type']=='')
		message_die(GENERAL_MESSAGE,sprintf($lang['Champs_needed'],$lang['Type']));
	$part_type = $_POST['part_type'];
	
	if (!isset($_POST['part_author']) || $_POST['part_author']=='')
		message_die(GENERAL_MESSAGE,sprintf($lang['Champs_needed'],$lang['part_author']));
	$part_author = $_POST['part_author'];
	
	if (!isset($_POST['part_adress']) || $_POST['part_adress']=='')
		message_die(GENERAL_MESSAGE,sprintf($lang['Champs_needed'],$lang['part_adress']));
	$part_adress = $_POST['part_adress'];
	
	if (strpos($part_adress,"@")===false && strpos($part_adress,"http://")===false)
		$part_adress = "http://" . $part_adress;
		
	$val_asso = select_element("SELECT asso.*,song.title,song.dataname FROM disco_songs_albums asso,disco_songs song WHERE song.song_id = asso.song_id AND id = '" . $asso_id . "'",true,'association introuvable');
	
	if (!$error)
	{
		gen_upload(
			$error,
			$error_msg,
			$HTTP_POST_FILES['tab']['tmp_name'],
			$_FILES['tab']['name'],
			$_FILES['tab']['size'],
			$phpbb_root_path . 'textes/disco/' . $val_asso['dataname'] . '_'.$asso_id,
			'.txt'
			);
		
		if(!$error)
		{
			$entete = $val_asso['title'] . ' : ' . stripslashes($part_type) . "\r\n\r\n";
			$entete .= "Auteur : " . $part_author . "(" . $part_adress . ")\r\n";
			$entete .= "Téléchargé sur le site famille http://" . $_SERVER['HTTP_HOST'] . "\r\n\r\n";
			
			$filename = $phpbb_root_path . 'textes/disco/' . $val_asso['dataname'] . '_'.$asso_id . '.txt';
			
			$fd = fopen($filename,'r');
			$contenu = fread($fd,filesize($filename));
			fclose($fd);
			
			$fd = fopen($filename,'w');
			fwrite($fd,$entete . $contenu);
			fclose($fd);
			
			
			logger("Ajout de $part_type pour l'association N°$asso_id de " . $val_asso['title']);
			if (!$error)
				mysql_query("UPDATE disco_songs_albums SET part_type = '$part_type', part_author = '$part_author', part_adress = '$part_adress' WHERE id = '" . $asso_id . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
			if (!$error)
			{
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['add_part_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'add_gp')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	$val_asso = select_element("SELECT asso.*,song.dataname FROM disco_songs_albums asso,disco_songs song WHERE song.song_id = asso.song_id AND id = '" . $asso_id . "'",true,'association introuvable');
	
	if (!$error)
	{
		gen_upload(
			$error,
			$error_msg,
			$HTTP_POST_FILES['gp']['tmp_name'],
			$_FILES['gp']['name'],
			$_FILES['gp']['size'],
			$phpbb_root_path . 'audio/disco/' . $val_asso['dataname'] . '_'.$asso_id,
			'.gp3'
			);
		logger("Ajout d'un Guitar Pro pour l'association N°" . $asso_id);
		if (!$error)
			mysql_query("UPDATE disco_songs SET gp = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['add_gp_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'add_midi')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	$val_asso = select_element("SELECT asso.*,song.dataname FROM disco_songs_albums asso,disco_songs song WHERE song.song_id = asso.song_id AND id = '" . $asso_id . "'",true,'association introuvable');
	
	if (!$error)
	{
		gen_upload(
			$error,
			$error_msg,
			$HTTP_POST_FILES['midi']['tmp_name'],
			$_FILES['midi']['name'],
			$_FILES['midi']['size'],
			$phpbb_root_path . 'audio/disco/midi_'.$asso_id,
			'.mid'
			);
		logger("Ajout d'un fichier midi pour l'association N°" . $asso_id);
		if (!$error)
			mysql_query("UPDATE disco_songs SET midi = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'") or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['add_midi_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_asso." . $phpEx . "?mode=edit&asso_id=" . $asso_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	$_GET['mode'] = 'edit';
}

// Mode édition
if ($_GET['mode'] == 'edit')
{
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = (int)$_GET['asso_id'];
	
	$val_asso = select_element("SELECT 
					asso.*,
					album.title album_title,
					album.date,
					song.title song_title,
					song.dataname,
					song.rm,
					song.gp,
					artist.name
				FROM 
					disco_albums album, 
					disco_artists artist,
					disco_songs song,
					disco_songs_albums asso 
				WHERE 
					asso.id = '$asso_id' AND
					asso.album_id = album.album_id AND
					asso.song_id = song.song_id AND
					album.artist_id = artist.artist_id"
				,true,'Association introuvable');
	$duree = $val_asso['duree'];
	$comment = $val_asso['comment'];
	$bbcode_uid = $val_asso['bbcode_uid'];
	$comment = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $comment));
	
}

if ($_GET['mode'] == 'doedit')
{
	// Vérification des champs obligatoires

	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['asso_id']) || (int)$_GET['asso_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable asso_id');
	$asso_id = $_GET['asso_id'];
	
	if (strpos($_POST['duree'],"'")===false)
		list($error,$error_msg) = array(true,$lang['format_duree_false']);
	$duree = $_POST['duree'];
	$comment = $_POST['comment'];
	
	$bbcode_uid = make_bbcode_uid();
	$thanks = bbencode_first_pass($thanks, $bbcode_uid);
	$comment = bbencode_first_pass($comment, $bbcode_uid);
	
	if ($error)
	{
		$_GET['mode'] = 'edit';
		$duree = stripslashes($duree);
		$comment = stripslashes($comment);
	}
}

if ($_GET['mode'] == 'doedit')
{

	
	if (!$error)
	{
		$sql = "UPDATE disco_songs_albums 
			SET duree = '$duree',
			comment = '$comment',
			bbcode_uid = '$bbcode_uid' 
			WHERE id = '$asso_id'";
		$original = select_element("SELECT * FROM disco_songs_albums WHERE id = '$asso_id'",true,"Modification introuvable");
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'association<br />".mysql_error()."<br />".$sql);
		$final = select_element("SELECT * FROM disco_songs_albums WHERE id = '$asso_id'",true,"Modification introuvable");
		$val_album = select_element("SELECT * FROM disco_albums WHERE album_id = '" . $original['album_id'] . "'",true,"Album introuvable");
		$val_song = select_element("SELECT * FROM disco_songs WHERE song_id = '" . $original['song_id'] . "'",true,"Titre introuvable");
		logger("Modification de l'association " . $val_album['title'] . " / " . $val_song['song_id'],$original,$final);
		
		
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=" . $val_album['album_id']) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Edit_asso_ok'].$message_illu, '<a href="' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=" . $val_album['album_id']) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}			
	} else 
	{
		$_GET['mode'] = 'edit';
		$duree = stripslashes($duree);
		$comment = stripslashes($comment);
	}
}

// Formulaire d'ajout ou d'édition : variables inchangeables
if ($_GET['mode'] == 'edit')
{
	if(!isset($val_asso))
		$val_asso = select_element("SELECT 
					asso.*,
					album.title album_title,
					album.date,
					song.title song_title,
					song.dataname,
					song.rm,
					song.gp,
					sond.midi,
					artist.name
				FROM 
					disco_albums album, 
					disco_artists artist,
					disco_songs song,
					disco_songs_albums asso 
				WHERE 
					asso.id = '$asso_id' AND
					asso.album_id = album.album_id AND
					asso.song_id = song.song_id AND
					album.artist_id = artist.artist_id"
				,true,'Association introuvable');
	$album_title = $val_asso['album_title'];
	$song_title = $val_asso['song_title'];
	$artist_name = $val_asso['name'];
	$album_date = (floor($val_asso['date']/10000)==substr($val_asso['date'],0,4)) ? substr($val_asso['date'],0,4) : format_date($val_asso['date']);

	$u_action = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=doedit&asso_id=' . $asso_id);
	$l_action = sprintf($lang['Edition_de'],$lang['the_asso'].' "'. sprintf($lang['song_by'],$album_title,$artist_name,$album_date) . '" / "' . $song_title . '"');
	$l_submit = $lang['Modifier'];
	$l_confirm_supp = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$lang['the_asso'])));
	
	$u_supp = append_sid($phpbb_root_path . 'disco/sam_album.php?mode=supp_asso&id=' . $asso_id);
	
	// Extrait audio/video
	$filename = $phpbb_root_path . 'audio/disco/extrait_' . $asso_id . '.ram';
	if (is_file($filename))
	{
		/*if ($val_asso['rm'] == 'N')
		{
			mysql_query("UPDATE disco_songs SET rm = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title possède un extrait audio");
		}*/
		$u_real = $filename;
		$l_real = $lang['Ecouter_extrait'];
		$u_supp_real = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=supp_real&asso_id=' . $asso_id);
		$l_supp_real = sprintf($lang['delete'],$lang['the_extrait']);
		$l_confirm_supp_real = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$lang['the_extrait'])));
	} else
	{
		/*if ($val_asso['rm'] == 'Y')
		{
			mysql_query("UPDATE disco_songs SET rm = 'N' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title n'avait pas d'extrait audio");
		}*/
		$u_real = '';
		$l_real = '';
		$u_supp_real = '';
		$l_supp_real = '';
		$l_confirm_supp_real = '';
	}
	$u_add_real = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=add_real&asso_id=' . $asso_id);
	
	// Guitar Pro
	$filename = $phpbb_root_path . 'audio/disco/' . $val_asso['dataname'] . '_' . $asso_id . '.gp3';
	if (is_file($filename))
	{
		/*if ($val_asso['gp'] == 'N')
		{
			mysql_query("UPDATE disco_songs SET gp = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title possède un guitar pro");
		}*/
		$u_gp = $filename;
		$l_gp = $lang['dl_guitarpro'];
		$u_supp_gp = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=supp_gp&asso_id=' . $asso_id);
		$l_supp_gp = sprintf($lang['delete'],$lang['the_gp']);
		$l_confirm_supp_gp = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$lang['the_gp'])));
	} else
	{
		/*if ($val_asso['gp'] == 'Y')
		{
			mysql_query("UPDATE disco_songs SET gp = 'N' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title n'avait pas de guitar pro");
		}*/
		$u_gp = '';
		$l_gp = '';
		$u_supp_gp = '';
		$l_supp_gp = '';
		$l_confirm_supp_gp = '';
	}
	$u_add_gp = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=add_gp&asso_id=' . $asso_id);
	
	// Midi
	$filename = $phpbb_root_path . 'audio/disco/midi_' . $asso_id . '.mid';
	if (is_file($filename))
	{
		/*if ($val_asso['gp'] == 'N')
		{
			mysql_query("UPDATE disco_songs SET gp = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title possède un guitar pro");
		}*/
		$u_midi = $filename;
		$l_midi = $lang['dl_midi'];
		$u_supp_midi = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=supp_midi&asso_id=' . $asso_id);
		$l_supp_midi = sprintf($lang['delete'],$lang['the_midi']);
		$l_confirm_supp_midi = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$lang['the_midi'])));
	} else
	{
		/*if ($val_asso['gp'] == 'Y')
		{
			mysql_query("UPDATE disco_songs SET gp = 'N' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title n'avait pas de guitar pro");
		}*/
		$u_midi = '';
		$l_midi = '';
		$u_supp_midi = '';
		$l_supp_midi = '';
		$l_confirm_supp_midi = '';
	}
	$u_add_midi = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=add_midi&asso_id=' . $asso_id);
	
	// Partitions
	$filename = $phpbb_root_path . 'textes/disco/' . $val_asso['dataname'] . '_' . $asso_id . '.txt';
	if (is_file($filename))
	{
		/*if ($val_asso['gp'] == 'N')
		{
			mysql_query("UPDATE disco_songs SET gp = 'Y' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title possède un guitar pro");
		}*/
		$u_part = $filename;
		$l_part = $lang['dl_partition'];
		$u_supp_part = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=supp_part&asso_id=' . $asso_id);
		$l_supp_part = sprintf($lang['delete'],$lang['the_partition']);
		$l_confirm_supp_part = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$lang['the_partition'])));
		
		$part_adress = $val_asso['part_adress'];
		$part_author = $val_asso['part_author'];
	} else
	{
		/*if ($val_asso['gp'] == 'Y')
		{
			mysql_query("UPDATE disco_songs SET gp = 'N' WHERE song_id = '" . $val_asso['song_id'] . "'");
			logger("Correction automatique de la base : $song_title n'avait pas de guitar pro");
		}*/
		$u_part = '';
		$l_part = '';
		$u_supp_part = '';
		$l_supp_part = '';
		$l_confirm_supp_part = '';
		$part_adress = '';
		$part_author = '';
	}
	$u_add_tab = append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=add_part&asso_id=' . $asso_id);
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/sam_asso.tpl',
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
			'L_RETOUR_ALBUM' => $lang['retour_album'],
			'U_RETOUR_ALBUM' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=edit&album_id=' . $val_asso['album_id']),
			'L_RETOUR_SONG' => $lang['retour_song'],
			'U_RETOUR_SONG' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit&song_id=' . $val_asso['song_id']),
			"L_VIDEO" => $lang['Videothèque'],
			"U_VIDEO" => append_sid($phpbb_root_path . 'disco/albums.php?mode=video'),
			"L_ENFOIRES" => $lang['Les_Enfoirés'],
			"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
			)
);


$template->assign_vars(array(
			"L_ACTION" => $l_action,
			"L_SUBMIT" => $l_submit,
			"L_COMMENTS" => $lang['l_comment'],
			"L_DUREE" => $lang['Duree'],
			"L_EXTRAIT" => $lang['Extraits_a_v'],
			"L_SUPP" => $lang['Delete'],
			"L_CONFIRM_SUPP" => $l_confirm_supp,
			"L_FICHIER_REAL" => $lang['real_file'],
			'L_REAL' => $l_real,
			"L_SUPP_REAL" => $l_supp_real,
			"L_CONFIRM_SUPP_REAL" => $l_confirm_supp_real,
			"L_GUITARPRO" => $lang['GuitarPro'],
			"L_FICHIER_GP" => $lang['gp_file'],
			'L_GP' => $l_gp,
			"L_SUPP_GP" => $l_supp_gp,
			"L_CONFIRM_SUPP_GP" => $l_confirm_supp_gp,
			"L_MIDI" => $lang['Midi'],
			"L_FICHIER_MIDI" => $lang['midi_file'],
			'L_LISTEN_MIDI' => $l_midi,
			"L_SUPP_MIDI" => $l_supp_midi,
			"L_CONFIRM_SUPP_MIDI" => $l_confirm_supp_midi,
			"L_TAB" => $lang['Partition'],
			"L_FICHIER_TAB" => $lang['part_file'],
			'L_VIEW_TAB' => $l_part,
			"L_SUPP_TAB" => $l_supp_part,
			"L_CONFIRM_SUPP_TAB" => $l_confirm_supp_part,
			"L_TYPE_TAB" => $lang['Type'],
			"L_PART_AUTHOR" => $lang['part_author'],
			"L_PART_ADRESS" => $lang['part_adress'],
			
			"U_ACTION" => $u_action,
			"U_SUPP" => $u_supp,
			"U_REAL" => $u_real,
			"U_SUPP_REAL" => $u_supp_real,
			"U_ADD_REAL" => $u_add_real,
			"U_GP" => $u_gp,
			"U_SUPP_GP" => $u_supp_gp,
			"U_ADD_GP" => $u_add_gp,
			"U_ADD_MIDI" => $u_add_midi,
			"U_MIDI" => $u_midi,
			"U_SUPP_MIDI" => $u_supp_midi,
			"U_ADD_TAB" => $u_add_tab,
			"U_TAB" => $u_part,
			"U_SUPP_TAB" => $u_supp_part,
			
			"COMMENTS" => htmlentities($comment),
			"DUREE" => htmlentities($duree),
			"PART_AUTHOR" => htmlentities($part_author),
			"PART_ADRESS" => htmlentities($part_adress),
			));

for($i=0;$i<count($type_tab);$i++)
{
	$template->assign_block_vars('tab',array(
					"VALUE" => $type_tab[$i],
					"INTITULE" =>$type_tab[$i],
					"CHECKED" =>($type_tab[$i] == $val_asso['part_type']) ? ' SELECTED' : '',
					));
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
