<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'functions/functions_sam.php');
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

$doublon_album=false;

$options_type[0] = array($lang['Studio_album'],"l'album");
$options_type[1] = array($lang['Live_album'],"le live");
$options_type[2] = array($lang['Compil_album'],"la compilation");
$options_type[3] = array($lang['Single_album'],"le single");
$options_type[4] = array($lang['Vidéo'],"video");


// Modes qui, lorsqu'ils plantent, repassent en mode édition
if ($_GET['mode'] == 'up_jack')
{
	if (!isset($_GET['album_id']) || (int)$_GET['album_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id');
	$album_id = (int)$_GET['album_id'];
	
	if (!isset($_GET['jack_id']) || (int)$_GET['jack_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable jack_id');
	$jack_id = (int)$_GET['jack_id'];
	
	upasso('disco_jacks','jack_id',$jack_id,'album_id');
	
	$_GET['mode']='edit';
}

if ($_GET['mode'] == 'up_song')
{
	if (!isset($_GET['id']) || (int)$_GET['id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable id');
	$id = (int)$_GET['id'];
	
	$val_asso = select_element("SELECT A.id, B.title \"song\",C.title \"album\",C.album_id FROM disco_songs_albums A, disco_songs B,disco_albums C WHERE A.id = '$id' AND A.song_id = B.song_id AND A.album_id = C.album_id",true,"association introuvable");
	$_GET['album_id'] = $val_asso['album_id'];
	upasso('disco_songs_albums','id',$id,'album_id');
	
	// Boris 26/02/2006 : Ajout de signet
	header('Location:' . $phpbb_root_path . 'disco/sam_album.php?mode=edit&album_id=' . $_GET['album_id'] . '#songs');
	exit();
	//$_GET['mode']='edit';
	// fin boris 26/02/2006
}

if ($_GET['mode'] == 'down_jack')
{
	if (!isset($_GET['album_id']) || (int)$_GET['album_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id');
	$album_id = (int)$_GET['album_id'];
	
	if (!isset($_GET['jack_id']) || (int)$_GET['jack_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable jack_id');
	$jack_id = (int)$_GET['jack_id'];
	
	downasso('disco_jacks','jack_id',$jack_id,'album_id');
	
	$_GET['mode']='edit';
}

if ($_GET['mode'] == 'down_song')
{
	if (!isset($_GET['id']) || (int)$_GET['id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable id');
	$id = (int)$_GET['id'];
	
	$val_asso = select_element("SELECT A.id, B.title \"song\",C.title \"album\",C.album_id FROM disco_songs_albums A, disco_songs B,disco_albums C WHERE A.id = '$id' AND A.song_id = B.song_id AND A.album_id = C.album_id",true,"association introuvable");
	$_GET['album_id'] = $val_asso['album_id'];
	downasso('disco_songs_albums','id',$id,'album_id');
	
	// Boris 26/02/2006 : Ajout de signet
	header('Location:' . $phpbb_root_path . 'disco/sam_album.php?mode=edit&album_id=' . $_GET['album_id'] . '#songs');
	exit();
	//$_GET['mode']='edit';
	// fin boris 26/02/2006
}

if ($_GET['mode'] == 'supp_jack')
{
	if (!isset($_GET['album_id']) || (int)$_GET['album_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id');
	$album_id = (int)$_GET['album_id'];
	
	if (!isset($_GET['jack_id']) || (int)$_GET['jack_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable jack_id');
	$jack_id = (int)$_GET['jack_id'];
	
	supp_jack($jack_id,$album_id,$error,$error_msg);
	
	if (!$error)
	{
		
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_jack_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
	}
	
	$_GET['mode']='edit';
}

if ($_GET['mode'] == 'supp_asso')
{
	if (!isset($_GET['id']) || (int)$_GET['id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable id');
	$id = (int)$_GET['id'];
	
	$val_asso = select_element("SELECT A.id, B.title \"song\",C.title \"album\",C.album_id FROM disco_songs_albums A, disco_songs B,disco_albums C WHERE A.id = '$id' AND A.song_id = B.song_id AND A.album_id = C.album_id",true,"association introuvable");
	
	supp_asso($val_asso['id'],$error,$error_msg);
	
	$album_id = $val_asso['album_id'];
	
	if (!$error)
	{
		
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['deasso_song_ok'],$val_asso['song'],$val_asso['album'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '">', '</a>',$val_asso['album']);
			message_die(GENERAL_MESSAGE, $message);
	}
	
	$_GET['mode']='edit';
}

if ($_GET['mode'] == 'add_jack')
{
	if (!isset($_GET['album_id']) || (int)$_GET['album_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id');
	$album_id = (int)$_GET['album_id'];
	
	$jack =  ( $HTTP_POST_FILES['jack']['tmp_name'] != "none") ? $HTTP_POST_FILES['jack']['tmp_name'] : '' ;
	
	$comment = $_POST['comment'];
	
	$bbcode_uid = make_bbcode_uid();
	
	$comment = bbencode_first_pass($comment, $bbcode_uid);
	
	include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);

	
	if (!$error)
	{
		$val_ordre = select_element("SELECT IFNULL(MAX(ordre),0) ordre FROM disco_jacks WHERE album_id = '$album_id'",true,'erreur Interne<br />'.mysql_error());
		$ordre = $val_ordre['ordre']+1;
		$sql = "INSERT INTO disco_jacks (album_id,comment,bbcode_uid,ordre) VALUES ('$album_id','$comment','$bbcode_uid',$ordre)";
		mysql_query($sql) or list($error,$error_msg) = array(true,mysql_error());
		$jack_id = mysql_insert_id();
	}

	if (!$error)
	{
		if ($jack!= '')
		{
			$filesize = array($site_config['jack_max_filesize'],$site_config['jack_max_width'],$site_config['jack_max_height']);
		
			user_upload_easy($error,$error_msg,$HTTP_POST_FILES['jack'],$phpbb_root_path . 'images/disco/jack_' . $album_id . '_' . $jack_id,$filesize);
			
		} else
		{
			list($error,$error_msg) = array(true,$lang['no_file']);
			supp_jack($jack_id,$album_id,$error,$error_msg);
		}
	}
	
	
		
	if (!$error)
	{
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '">')
			);
		$message .=  '<br /><br />' . sprintf($lang['add_jack_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		@unlink($phpbb_root_path . 'images/disco/jack_' . $album_id . '_' . $jack_id . find_image($phpbb_root_path . 'images/disco/jack_' . $album_id . '_' . $jack_id));
		$_GET['mode'] = 'edit';
	}
}

if ($_GET['mode'] == 'add_song')
{
	if ((!isset($_GET['album_id']) || (int)$_GET['album_id']==0) && (!isset($_POST['album_id']) || (int)$_POST['album_id']==0))
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id ' . $_GET['album_id'] . ' ' . $_POST['album_id'] . print_r($_POST,true));
	$album_id = ($_GET['album_id']!=0) ? (int)$_GET['album_id'] : (int)$_POST['album_id'];
	
	if (!isset($_POST['song_id']) || $_POST['song_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Song']));
	$song_id = $_POST['song_id'];
	
	if (!isset($_POST['song']) || $_POST['song'] == '')
	{
		// Boris 12/03/2007
		//list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Song']));
		$val_my_song = select_element("SELECT `title` FROM `disco_songs` WHERE `song_id` = '$song_id'",'Titre inconnu',true);
		$song = $val_my_song['title'];
	} else
	{
		$song = $_POST['song'];
	}
	// fin Boris 12/03/2007
	
	$comment = delete_html($_POST['comment']);
	$duree = delete_html($_POST['duree']);
	
	if (!$error)
	{
	
		
	
		$bbcode_uid = make_bbcode_uid();
		
		$comment = bbencode_first_pass($comment, $bbcode_uid);
	
		$val_ordre = select_element("SELECT IFNULL(MAX(ordre),0) ordre FROM disco_songs_albums WHERE album_id = '$album_id'",true,'erreur Interne<br />'.mysql_error());
		$ordre = $val_ordre['ordre']+1;
		$sql = "INSERT INTO disco_songs_albums (
						song_id,
						album_id,
						comment,
						duree,
						bbcode_uid,
						ordre)
				 VALUES ('$song_id','$album_id','$comment','$duree','$bbcode_uid',$ordre)";
		mysql_query($sql) or list($error,$error_msg) = array(true,mysql_error());
		$asso_id = mysql_insert_id();
		$val_album = select_element("SELECT A.*,B.name FROM disco_albums A, disco_artists B WHERE A.album_id = '$album_id' AND A.artist_id=B.artist_id",true,'Album introuvable');
	
		logger("Le titre " . $song . " a été associé à l'album " . $val_album['title'] . " de " . $val_album['name']);
	}
	
	
		
	if (!$error)
	{
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '#add_song">')
			);
		$message .=  '<br /><br />' . sprintf($lang['add_song_ok'],$song,$val_album['title'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=$album_id") . '#add_song">', '</a>',$val_album['title']);
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		$asso_comment = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $comment));
		$asso_song = $song;
		$asso_song_id = $song_id;
		$asso_duree = $duree;
		$_GET['mode'] = 'edit';
	}
}

// Mode édition
if ($_GET['mode'] == 'edit')
{
	if ((!isset($_GET['album_id']) || (int)$_GET['album_id']==0) && (!isset($_POST['album_id']) || (int)$_POST['album_id']==0))
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id');
	$album_id = ($_GET['album_id']!=0) ? (int)$_GET['album_id'] : (int)$_POST['album_id'];
	
	$val_album = select_element("SELECT A.*,B.name FROM disco_albums A, disco_artists B WHERE A.album_id = '$album_id' AND A.artist_id=B.artist_id",true,'Album introuvable');
	$artist_id =	$val_album['artist_id'];
	$title = $val_album['title'];
	$bbcode_uid = $val_album['bbcode_uid'];
	$name_artist = $val_album['name'];
	$thanks=$val_album['thanks'];
	$comment=$val_album['comment'];
	$date = ($val_album['date']-floor($val_album['date']/10000)*10000==0) ? floor($val_album['date']/10000) : affiche_date($val_album['date']);
	$asin = $val_album['ASIN'];
	
	$checked_cd = ($val_album['CD'] == 'Y') ? ' CHECKED' : '';
	$checked_cd_single = ($val_album['CD2T'] == 'Y') ? ' CHECKED' : '';
	$checked_k7 = ($val_album['K7'] == 'Y') ? ' CHECKED' : '';
	$checked_k7_single = ($val_album['K72T'] == 'Y') ? ' CHECKED' : '';
	$checked_33t = ($val_album['33T'] == 'Y') ? ' CHECKED' : '';
	$checked_45t = ($val_album['45T'] == 'Y') ? ' CHECKED' : '';
	$checked_m45t = ($val_album['M45T'] == 'Y') ? ' CHECKED' : '';
	$checked_hc = ($val_album['HC'] == 'Y') ? ' CHECKED' : '';
	$checked_vhs = ($val_album['VHS'] == 'Y') ? ' CHECKED' : '';
	$checked_dvd = ($val_album['DVD'] == 'Y') ? ' CHECKED' : '';
	
}



if ($_GET['mode'] == 'supp')
{
	if (!isset($_GET['album_id']) || (int)$_GET['album_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id');
	$album_id = (int)$_GET['album_id'];
	
	$tab_assos = select_liste("SELECT * FROM disco_songs_albums WHERE album_id = " . $album_id);
	
	for ($i=0;!$error && $i<count($tab_assos);$i++)
	{
		supp_asso($tab_assos[$i]['id'],$error,$error_msg);
	}
	
	$tab_jacks = select_liste("SELECT * FROM disco_jacks WHERE album_id = " . $album_id);
	
	for ($i=0;!$error && $i<count($tab_jacks);$i++)
	{
		supp_jack($tab_jacks[$i]['jack_id'],$album_id,$error,$error_msg);
	}
	
	if (!$error)
	{
	
		$sql = "DELETE FROM disco_albums WHERE album_id = '" . $album_id . "'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
		
		logger("album N°$album_id supprimé");
		
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam." . $phpEx . "?mode=albums") . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_album_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam." . $phpEx . "?mode=albums") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		
	} else $_GET['mode'] = 'edit';
}


if ($_GET['mode'] == 'doedit' || $_GET['mode'] == 'doadd')
{
	// Vérification des champs obligatoires
	
	if (!isset($_POST['title']) || $_POST['title'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['title']));
	$title = $_POST['title'];
	
	if (!isset($_POST['artist']) || $_POST['artist'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['artist']));
	$artist = $_POST['artist'];
	$name_artist = $artist;
	
	if (!isset($_POST['type']) || $_POST['type'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['type']));
	$type = $_POST['type'];
	
	if (!isset($_POST['date']) || $_POST['date'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['date']));
	$date = $_POST['date'];
	
	// Boris 05/03/2007
	// Chanson part défaut : permet de créer l'album d'un titre nouvellement créé d'un click
	$default_song = $_POST['default_song'];
	// Fin BOris 05/03/2007

	$asin = $_POST['asin'];
	
	/*if (!isset($_POST['thanks']) || $_POST['thanks'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['thanks']));*/
	$thanks = $_POST['thanks'];
	
	/*if (!isset($_POST['comments']) || $_POST['comments'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['comments']));*/
	$comment = $_POST['comments'];
	
	$bbcode_uid = make_bbcode_uid();
	$thanks = bbencode_first_pass($thanks, $bbcode_uid);
	$comment = bbencode_first_pass($comment, $bbcode_uid);
	
	$checked_cd = ($_POST['cd'] == 'ok') ? ' CHECKED': '';
	$cd=$_POST['cd'];
	$checked_cd2t = ($_POST['cd2t'] == 'ok') ? ' CHECKED': '';
	$cd2t=$_POST['cd2t'];
	$checked_k7 = ($_POST['k7'] == 'ok') ? ' CHECKED': '';
	$k7=$_POST['k7'];
	$checked_k72t = ($_POST['k72t'] == 'ok') ? ' CHECKED': '';
	$k72t=$_POST['k72t'];
	$checked_m45t = ($_POST['m45t'] == 'ok') ? ' CHECKED': '';
	$m45t=$_POST['m45t'];
	$checked_hc = ($_POST['hc'] == 'ok') ? ' CHECKED': '';
	$hc=$_POST['hc'];
	$checked_m45t = ($_POST['d45t'] == 'ok') ? ' CHECKED': '';
	$d45t=$_POST['d45t'];
	$checked_m45t = ($_POST['d33t'] == 'ok') ? ' CHECKED': '';
	$d33t=$_POST['d33t'];
	$checked_vhs = ($_POST['vhs'] == 'ok') ? ' CHECKED': '';
	$vhs=$_POST['vhs'];
	$checked_dvd = ($_POST['dvd'] == 'ok') ? ' CHECKED': '';
	$dvd=$_POST['dvd'];
	
	if (isset($_POST['confirm_doublon']))
		$confirm_doublon= ($_POST['confirm_doublon'] == 'ok') ? true : false;
	else
		$confirm_doublon = false;
	
	$val_artist = select_element("SELECT artist_id,name FROM disco_artists WHERE name = '$artist'",false,'');
	
	if (!$val_artist)
	{
		list($error,$error_msg) = array(true,sprintf($lang['artist_unfound'],$artist));
	} else
	{
		$artist_id = $val_artist['artist_id'];
		$link_artist = append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=edit&artist_id=' . $artist_id);
	}
	
	if ($error)
	{
		$_GET['mode'] = ($_GET['mode'] == 'doedit') ? 'edit' : 'add';
	}
}

if ($_GET['mode'] == 'doadd')
{		
	if (!$error && !$confirm_doublon)
	{
		$tab_doublon = select_liste("SELECT A.*,B.name FROM disco_albums A, disco_artists B WHERE A.title = '$title' AND A.album_id <> '$album_id' AND A.artist_id = B.artist_id");
		if (count($tab_doublon)>0)
		{
			$doublon_album=true;
			$error=true;
			$error_msg = $lang['confirm_album_doublon'];
		}
	} else $_GET['mode'] = 'add';
	
	if (!$error)
	{
		$sql = "INSERT INTO disco_albums (title,artist_id,type,date,ASIN,thanks,comment,bbcode_uid,CD,CD2T,K7,K72T,33T,45T,M45T,HC,VHS,DVD,Allowed,date_add) 
					VALUES (
						'$title',
						'$artist_id',
						'$type',
						'" . format_date($date) . "',
						'$asin',
						'$thanks',
						'$comment',
						'$bbcode_uid',
						'" . (($cd=='ok') ? 'Y' : 'N') . "',
						'" . (($cd2t=='ok') ? 'Y' : 'N' ). "',
						'" . (($k7=='ok') ? 'Y' : 'N') . "',
						'" . (($k72t=='ok') ? 'Y' : 'N') . "',
						'" . (($d33t=='ok') ? 'Y' : 'N') . "',
						'" . (($d45t=='ok') ? 'Y' : 'N') . "',
						'" . (($m45t=='ok') ? 'Y' : 'N') . "',
						'" . (($hc=='ok') ? 'Y' : 'N') . "',
						'" . (($vhs=='ok') ? 'Y' : 'N') . "',
						'" . (($dvd=='ok') ? 'Y' : 'N') . "',
						'Y',
						'" . date('Ymd') . "')";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout de l'album<br />".$sql."<br />" . mysql_error());
		$album_id = mysql_insert_id();
		logger("Ajout de l'album $title ($album_id)");
		
		if (!$error)
		{
			if ($default_song>0)
			{
				$sql = "INSERT INTO `disco_songs_albums` (`song_id`, `album_id`,`ordre`) VALUES ('$default_song','$album_id','1')";
				mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la première association de l'album<br />".$sql."<br />" . mysql_error());
				logger("Association de l'album $title ($album_id) avec le titre ($default_song)");
			}
		}
		
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=" . $album_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Add_album_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=" . $album_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
	} else $_GET['mode'] = 'add';
}



if ($_GET['mode'] == 'doedit')
{	
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['album_id']) || (int)$_GET['album_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable album_id');
	$album_id = $_GET['album_id'];
	
	$val_album = select_element("SELECT * FROM disco_albums WHERE album_id = '" . $album_id . "'",true,"Album introuvable");
	$changed_title = ($val_album['title'] != $title);
	//$artist_name = $val_artist['name'];
	
	
	if (!$error && !$confirm_doublon)
	{
		if ($changed_title)
		{
			$tab_doublon = select_liste("SELECT A.*,B.name FROM disco_albums A, disco_artists B WHERE A.title = '$title' AND A.album_id <> '$album_id' AND A.artist_id = B.artist_id");
			if (count($tab_doublon)>0)
			{
				$doublon_album=true;
				$error=true;
				$error_msg = $lang['confirm_album_doublon'];
			}
		}
	}  else 
	{
		$_GET['mode'] = 'edit';
	}
	
	
	if (!$error)
	{
		
	
		$sql = "UPDATE disco_albums 
			SET title = '$title',
			artist_id = '$artist_id',
			type = '" . $type .= "',
			date='" . format_date($date) . "',
			ASIN='$asin',
			thanks='$thanks',
			comment='$comment',
			CD='" . (($cd=='ok') ? 'Y' : 'N') . "',
			CD2T='" . (($cd2t=='ok') ? 'Y' : 'N' ). "',
			K7='" . (($k7=='ok') ? 'Y' : 'N') . "',
			K72T='" . (($k72t=='ok') ? 'Y' : 'N') . "',
			33T='" . (($d33t=='ok') ? 'Y' : 'N') . "',
			45T='" . (($d45t=='ok') ? 'Y' : 'N') . "',
			M45T='" . (($m45t=='ok') ? 'Y' : 'N') . "',
			HC='" . (($hc=='ok') ? 'Y' : 'N') . "',
			VHS='" . (($vhs=='ok') ? 'Y' : 'N') . "',
			DVD='" . (($dvd=='ok') ? 'Y' : 'N') . "',
			bbcode_uid = '$bbcode_uid' 
			WHERE album_id = '" . $album_id . "'";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification de l'album<br />".mysql_error()."<br />".$sql);
		$final = select_element("SELECT * FROM disco_albums WHERE album_id = '" . $album_id . "'",true,"Modification introuvable");
		logger("Modification de l'album $title ($album_id)",$val_album,$final);
		
		
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=" . $album_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Edit_album_ok'].$message_illu, '<a href="' . append_sid($phpbb_root_path . "disco/sam_album." . $phpEx . "?mode=edit&album_id=" . $album_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}			
	} else 
	{
		$_GET['mode'] = 'edit';
		$thanks = stripslashes($thanks);
		$comment = stripslashes($comment);
	}
}

// Formulaire d'ajout ou d'édition : variables inchangeables
if ($_GET['mode'] == 'edit')
{
	// Gestion des jaquettes
	$tab_jack = select_liste("SELECT * FROM disco_jacks WHERE album_id = '$album_id' ORDER BY ordre");
	for ($i=0;$i<count($tab_jack);$i++)
	{
		$filename = $phpbb_root_path . "images/disco/jack_" . $album_id . "_" . $tab_jack[$i]['jack_id'];
		$filename .= "." . find_image($filename);
		
		$comments = bbencode_second_pass(nl2br($tab_jack[$i]['comment']),$tab_jack[$i]['bbcode_uid']);

		$tab_jack_display[] = array(
					'IMG' => $filename,
					'MINI' => $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $album_id . '&jack_id=' . $tab_jack[$i]['jack_id'] . '&tnH=100',
					'COMMENT' => $comments,
					
					'L_SUPP' => $lang['Delete'],
					
					'U_UP' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=up_jack&album_id=' . $album_id . '&jack_id=' . $tab_jack[$i]['jack_id']),
					'U_DOWN' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=down_jack&album_id=' . $album_id . '&jack_id=' . $tab_jack[$i]['jack_id']),
					'U_SUPP' => "javascript:if (confirm('" . str_replace("'","\'",sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['jack'])))) . "')) document.location='" . append_sid($phpbb_root_path . 'disco/sam_album.php?mode=supp_jack&album_id=' . $album_id . '&jack_id=' . $tab_jack[$i]['jack_id']) . "'",
					);
	}
	
	// Gestion des chansons
	$tab_song = select_liste("SELECT A.id,B.* FROM disco_songs_albums A, disco_songs B WHERE A.album_id = '$album_id' AND A.song_id = B.song_id ORDER BY A.ordre");
	for ($i=0;$i<count($tab_song);$i++)
	{
		$tab_song_display[] = array(
				'SONG' => $tab_song[$i]['title'],
				
				'U_SONG' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit&song_id=' . $tab_song[$i]['song_id']),
				'U_SUPP' => "javascript:if(confirm('" . str_replace("'","\'",sprintf($lang['Confirm'],sprintf($lang['p_deassocier'],$tab_song[$i]['title']))) . "')) document.location='" . append_sid($phpbb_root_path . 'disco/sam_album.php?mode=supp_asso&amp;id=' . $tab_song[$i]['id']) . "'",
				'U_EDIT' => append_sid($phpbb_root_path . 'disco/sam_asso.php?mode=edit&amp;asso_id=' . $tab_song[$i]['id']),
				'U_UP' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=up_song&amp;id=' . $tab_song[$i]['id']),
				'U_DOWN' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=down_song&amp;id=' . $tab_song[$i]['id']),
								);
	}

	$link_artist = append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=edit&artist_id=' . $artist_id);
	$thanks = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $thanks));
	$comments = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $comment));

	
	$u_action = append_sid($phpbb_root_path . 'disco/sam_album.php?mode=doedit&album_id=' . $album_id);
	$l_action = $lang['edit_album'];
	$l_submit = $lang['Modifier'];
	
	$u_supp = append_sid($phpbb_root_path . 'disco/sam_album.php?mode=supp&album_id=' . $album_id);
}

if ($_GET['mode'] == 'add')
{
	$u_action = append_sid($phpbb_root_path . 'disco/sam_album.php?mode=doadd');
	$l_action = $lang['add_album'];
	$l_submit = $lang['Ajouter'];
	
	$default_song = $_GET['default_song'];
} else
{
	$default_song = 0;
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/sam_album.tpl',
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
			'U_RETOUR' => append_sid($phpbb_root_path . 'disco/sam.php?mode=albums'),
			"L_VIDEO" => $lang['Videothèque'],
			"U_VIDEO" => append_sid($phpbb_root_path . 'disco/albums.php?mode=video'),
			"L_ENFOIRES" => $lang['Les_Enfoirés'],
			"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
			)
);

if ($_GET['mode']=='edit')
{
	$str_supp = "javascript:if(confirm('%s')) %s;";
	$javascript_supp =  sprintf(
				$str_supp,
				addslashes(sprintf(
					$lang['Confirm'],
					$lang['supp_album']
				)),
				"document.location='" . append_sid($phpbb_root_path . 'disco/sam_album.php?mode=supp&album_id=' . $album_id) . "'" );

}

$template->assign_vars(array(
			"L_ACTION" => $l_action,
			"L_TITLE" => $lang['Titre'],
			"L_ARTIST" => $lang['Artist'],
			"L_SUBMIT" => $l_submit,
			"L_SEARCH_ARTIST" => $lang['search_artist'],
			"L_TYPE" => $lang['Type'],
			"L_DATE" => $lang['Date'],
			"L_ASIN" => $lang['ASIN'],
			"L_EXPLAIN_ASIN" => $lang['explain_asin'],
			"L_THANKS" => $lang['l_thanks'],
			"L_COMMENTS" => $lang['l_comment'],
			"L_SUPPORTS" => $lang['Supports'],
			"L_CD" => $lang['CD'],
			"L_CD_SINGLE" => $lang['CD_single'],
			"L_K7" => $lang['K7'],
			"L_K7_SINGLE" => $lang['K72T'],
			"L_33T" => $lang['33T'],
			"L_45T" => $lang['45T'],
			"L_HC" => $lang['HC'],
			"L_VHS" => $lang['VHS'],
			"L_DVD" => $lang['DVD'],
			"L_M45T" => $lang['M45T'],
			
			"U_ACTION" => $u_action,
			"U_SEARCH_ARTIST" => append_sid($phpbb_root_path . 'disco/search.php?mode=artiste&formulaire=formulaire&champs=artist'),
			
			"DATE" => $date,
			"ASIN" => $asin,
			"TITLE" => htmlentities($title),
			"ARTIST" => htmlentities($name_artist),
			"THANKS" => htmlentities($thanks),
			"COMMENTS" => htmlentities($comments),
			"CHECKED_CD" => $checked_cd,
			"CHECKED_CD_SINGLE" => $checked_cd_single,
			"CHECKED_K7" => $checked_k7,
			"CHECKED_K7_SINGLE" => $checked_k7_single,
			"CHECKED_33T" => $checked_33t,
			"CHECKED_45T" => $checked_45t,
			"CHECKED_M45T" => $checked_m45t,
			"CHECKED_HC" => $checked_hc,
			"CHECKED_VHS" => $checked_vhs,
			"CHECKED_DVD" => $checked_dvd,
			"DEFAULT_SONG" => ($default_song > 0) ? '<input type="hidden" name="default_song" value="' . $default_song . '" />' : '',
			
			));
			
if (isset($link_artist))
{
	$template->assign_block_vars('switch_link_artist',array(
								"L_SEE_ARTIST" => sprintf($lang['See_artist'],'<a href="' . $link_artist . '" target="_blank">','</a>',$name_artist),
										));
}

while (list($key,$val) = each($options_type))
	$template->assign_block_vars('options_type',array(
							"VALUE" => $val[1],
							"INTITULE" => $val[0],
							"SELECTED" => ($val[1]==$val_album['type']) ? ' SELECTED' : '',
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

if ($doublon_album)
{
	$template->assign_block_vars('switch_doublon',array(
											'L_CONFIRM' => $lang['confirm_doublon_album'],
											'L_VERIF' => $lang['verif_doublon_album'],
											'L_PAR' => $lang['par'],
											));
											
	while(list($key,$val) = each($tab_doublon))
	{
		$template->assign_block_vars('switch_doublon.doublon',array(
						'ALBUM_ID' => $val['album_id'],
						'TITLE' => $val['title'],
						'DATE' => ($val['date']-($val['date']/10000)*10000==0) ? $val['date']/10000 : affiche_date($val['date']),
						'ARTIST' => $val['name'],
						
						'U_ALBUM' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=edit&album_id=' . $val['album_id']),
						)
					);
	}
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

if ($_GET['mode']=='edit')
{
	$template->assign_block_vars('switch_edit',array(
			'L_SONGS' => $lang['list_song'],
			'L_SUPP_ALBUM' => $lang['supp_album'],
			'L_JACK' => $lang['jack_management'],
			'L_ADD_JACK' => $lang['Add_jack'],
			'L_EMPLACEMENT' => $lang['Jack_path'],
			'L_DESCRIPTION' => $lang['Description'],
			'L_EXPLAIN_COMMENT_SONG' => $lang['explain_comment_song'],
			'L_EDIT' => $lang['edit'],
			'L_ADD' => $lang['Ajouter'],
			'L_SUPP' => $lang['Delete'],
			'L_UP' => $lang['monter'],
			'L_DOWN' => $lang['descendre'],
			'L_ADD_SONG' => $lang['add_song'],
			'L_SONG' => $lang['Titre'],
			'L_SEARCH_SONG' => $lang['Search_song'],
			'L_DUREE' => $lang['Duree'],
			
			'ASSO_SONG' => $asso_song,
			'ASSO_SONG_ID' => $asso_song_id,
			'ASSO_COMMENT' => $asso_comment,
			'ASSO_DUREE' => $asso_duree,
			

			'U_SEARCH_SONG' => append_sid($phpbb_root_path . 'disco/search.php?mode=song&formulaire=add_song&champs=song&champ_id=song_id'),
			'U_SUPP' => "javascript:if (confirm('" . addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$val_album['title']))) . "')) document.location='" . $u_supp . "'",
			'U_ADD_JACK' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=add_jack&album_id=' . $album_id),
			'U_ADD_SONG' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=add_song&album_id=' . $album_id),
			));
	if (count($tab_jack_display)>0)
	{
		while(list($key,$val) = each($tab_jack_display))
		{
			
			$template->assign_block_vars('switch_edit.jack',$val);
		}
	}
	
	if (count($tab_song_display)>0)
	{
		while(list($key,$val) = each($tab_song_display))
		{
			
			$template->assign_block_vars('switch_edit.song',$val);
		}
	}
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