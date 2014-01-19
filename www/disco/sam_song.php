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

$doublon_song=false;

$tab_job = array(
		array('Auteur','author'),
		array('Compositeur','composer'),
		array('Interprète','singer')
);

/**
 * affichage_artist
 * 
 * Utilise les variables $list_... pour remplir $tab_artists. Ce dernier table servira à formater le template pour indiquer la liste des artistes déjà associés.
 * Ceci ne sert que pour l'ajout : car nous ne pouvons enregistrer dans la table l'association des artistes au titre que nous sommes en train de créer.
 */
function affichage_artistes()
{
	global $tab_job,$list_singer,$list_composer,$list_author,$tab_artists;
	$tab_artists = array();
	// Pour chaque job (interprète/auteur/compositeur)
	for ($i=0;$i<count($tab_job);$i++)
	{
		// On prend la liste des ID
		$tab_jobber = explode('|',${'list_' . $tab_job[$i][1]});
		// Pour chaque ID
		for ($j=0;$j<count($tab_jobber);$j++)
		{
			// SI ce n'est pas un enreistrement vide
			if ($tab_jobber[$j]!='')
				// On rajouter l'enregisrement de l'ID
				$tab_artists[$i][] = select_element("SELECT * FROM disco_artists WHERE artist_id = '" . $tab_jobber[$j] . "'",true,"artiste " . $tab_jobber[$j] . " introuvable");
		}
		
		// Boris 4/12/2005 Correction  bug dans le cas de job incomplets
		if (count($tab_jobber)<3)
			$tab_artists[$i] = array();
	}
}

if ($_GET['mode'] == 'supp_asso')
{
	if (!isset($_GET['id']) || (int)$_GET['id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable id');
	$id = (int)$_GET['id'];
	
	$val_asso = select_element("SELECT A.id, B.title \"song\",C.title \"album\",C.album_id FROM disco_songs_albums A, disco_songs B,disco_albums C WHERE A.id = '$id' AND A.song_id = B.song_id AND A.album_id = C.album_id",true,"association introuvable");
	
	supp_asso($val_asso['id'],$error,$error_msg);
	
	$song_id = $val_asso['song_id'];
	
	if (!$error)
	{
		
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=$song_id") . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['deasso_song_ok'],$val_asso['song'],$val_asso['album'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=$song_id") . '">', '</a>',$val_asso['song']);
			message_die(GENERAL_MESSAGE, $message);
	}
	
	$_GET['mode']='edit';
}

// Boris 25/02/2006 : Gestion des medleys
// Déassociation chanson / medley
if ($_GET['mode'] == 'supp_medley')
{
	if (!isset($_GET['song_id']) || (int)$_GET['song_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = (int)$_GET['song_id'];
	
	if (!isset($_GET['medley_id']) || (int)$_GET['medley_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable medley_id');
	$medley_id = (int)$_GET['medley_id'];
	
	$val_asso = select_element("SELECT * FROM disco_medley WHERE song_id = '$medley_id' AND medley_id = '$song_id'",true,"association introuvable");
	
	$val_song = select_element("SELECT * FROM disco_songs WHERE song_id = '$song_id'",true,"titre introuvable");
	$val_medley = select_element("SELECT * FROM disco_songs WHERE song_id = '$medley_id'",true,"titre introuvable");

	$sql = "DELETE FROM disco_medley  WHERE medley_id = '$song_id' AND song_id='$medley_id'";
	mysql_query($sql) or list($error,$error_msg) = array(true,mysql_error());
	logger("Le titre " . $val_medley['title'] . " a été désassocié au medley " . $val_song['title']);
	
	if (!$error)
	{
		$url = append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=$song_id") . '#medley';
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $url . '">')
			);
		$message .=  '<br /><br />' . sprintf($lang['add_song_medley_ok'],stripslashes($medley_name),$val_song['title'], '<a href="' . $url . '">', '</a>',$val_song['title']);
		message_die(GENERAL_MESSAGE, $message);	
	}
	
	$_GET['mode']='edit';
}

// Ajout d'une composante de medley
if ($_GET['mode'] == 'add_medley')
{
	if (!isset($_GET['song_id']) || (int)$_GET['song_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = (int)$_GET['song_id'];
	
	$val_song = select_element("SELECT * FROM disco_songs WHERE song_id = '$song_id'",true,'titre introuvable');
	
	if (!isset($_POST['medley_id']) || $_POST['medley_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Medley']));
	$medley_id = $_POST['medley_id'];
	
	if (!isset($_POST['medley_name']) || $_POST['medley_name'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Medley']));
	$medley_name = $_POST['medley_name'];
	
	// Note: l'inversion medley_id et song_id est normale.
	// dans la base : medley_id est l'identifiant de la chanson medley et song_id celui de la chanson composante
	// dans les variables de formulaire, c'est le contraire
	
	// Le titre existe ?
	if (!$error)
	{
		$sql = "SELECT song_id FROM disco_songs WHERE song_id = '$medley_id'";
		$val_medley = select_element($sql,false,'');
		if (!$val_medley)
			list($error,$error_msg) = array(true,sprintf($lang['unfound'],stripslashes($medley_name)));
		unset($val_medley);
	}
	
	// recherche doublon
	if (!$error)
	{
		$sql = "SELECT song_id FROM disco_medley WHERE medley_id = '$song_id' AND song_id = '$medley_id'";
		$val_medley = select_element($sql,false,'');
		if ($val_medley)
			list($error,$error_msg) = array(true,sprintf($lang['already_exist'],stripslashes($medley_name)));
	}
	
	if (!$error)
	{
	
		$sql = "SELECT ordre FROM disco_medley WHERE medley_id = '$song_id' ORDER BY ordre DESC";
		$val_ordre = select_element($sql,false,'');
		$ordre = ($val_ordre) ? $val_ordre['ordre'] + 1 : 1;
		
		$sql = "INSERT INTO disco_medley (medley_id, song_id, ordre) VALUES ('$song_id', '$medley_id', '$ordre')";
		mysql_query($sql) or list($error,$error_msg) = array(true,mysql_error());
		logger("Le titre " . stripslashes($medley_name) . " a été associé au medley " . $val_song['title']);
		
		$url = append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=$song_id") . '#medley';
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $url . '">')
			);
		$message .=  '<br /><br />' . sprintf($lang['add_song_medley_ok'],stripslashes($medley_name),$val_song['title'], '<a href="' . $url . '">', '</a>',$val_song['title']);
		message_die(GENERAL_MESSAGE, $message);
	}
	$_GET['mode'] = 'edit';
}

if ($_GET['mode'] == 'up_medley')
{
	if (!isset($_GET['song_id']) || (int)$_GET['song_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = (int)$_GET['song_id'];
	
	if (!isset($_GET['id']) || (int)$_GET['id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable id');
	$id = (int)$_GET['id'];
	
	upasso('disco_medley','id',$id,'medley_id');
	header('Location:' . append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit&song_id=' . $song_id . '#medley'));
}

if ($_GET['mode'] == 'down_medley')
{
	if (!isset($_GET['song_id']) || (int)$_GET['song_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = (int)$_GET['song_id'];
	
	if (!isset($_GET['id']) || (int)$_GET['id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable id');
	$id = (int)$_GET['id'];
	
	downasso('disco_medley','id',$id,'medley_id');
	
	$_GET['mode'] = 'edit';
}
// fin Boris 25/02/2006

if ($_GET['mode'] == 'add_asso')
{
	if (!isset($_GET['song_id']) || (int)$_GET['song_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = (int)$_GET['song_id'];
	
	if (!isset($_POST['album_id']) || $_POST['album_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['album']));
	$album_id = $_POST['album_id'];
	
	if (!isset($_POST['album']) || $_POST['album'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['album']));
	$album = $_POST['album'];
	
	$comment = delete_html($_POST['comment']);
	$duree = delete_html($_POST['duree']);
	
	if (!$error)
	{
	
		
	
		$bbcode_uid = make_bbcode_uid();
		
		$comment = bbencode_first_pass($comment, $bbcode_uid);
	
		$val_ordre = select_element("SELECT IFNULL(MAX(ordre),0) ordre FROM disco_jacks WHERE album_id = '$album_id'",true,'erreur Interne<br />'.mysql_error());
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
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=$song_id") . '">')
			);
		$message .=  '<br /><br />' . sprintf($lang['add_song_ok'],$song,$val_album['title'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=$song_id") . '">', '</a>',$song);
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



if ($_GET['mode'] == 'supp')
{
	if (!isset($_GET['song_id']) || (int)$_GET['song_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = (int)$_GET['song_id'];
	
	$tab_assos = select_liste("SELECT * FROM disco_songs_albums WHERE song_id = " . $song_id);
	
	for ($i=0;!$error && $i<count($tab_assos);$i++)
	{
		supp_asso($tab_assos[$i]['id'],$error,$error_msg);
	}
	
	// Boris 25/02/2006 : Gestion des Medley
	// Supprimer toutes les associations Medley / chansons
	if (!$error)
	{
		$sql = "DELETE FROM disco_medley WHERE medley_id = '$song_id' OR song_id = '$song_id'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	}
	// fin Boris 25/02/2006
	
	// Boris 26/02/2006 : Suppression de la chanson dans tracklist tournée
	if (!$error)
	{
		$sql = "DELETE FROM `tournee_tracklist` WHERE `song_id` = '$song_id'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	}
	// fin Boris 26/02/2006
	
	if (!$error)
	{
	
		$sql = "DELETE FROM disco_songs WHERE song_id = '" . $song_id . "'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
		
		logger("Chanson N°$song_id supprimé");
		
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam." . $phpEx . "?mode=songs") . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['supp_song_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam." . $phpEx . "?mode=songs") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		
	} else $_GET['mode'] = 'edit';
}

// Mode édition
if ($_GET['mode'] == 'edit')
{
	if (!isset($_GET['song_id']) || (int)$_GET['song_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = (int)$_GET['song_id'];
	
	$val_song = select_element("SELECT * FROM disco_songs WHERE song_id = '$song_id'",true,'Titre introuvable');
	$title = $val_song['title'];
	$bbcode_uid = $val_song['bbcode_uid'];
	
	if ($val_song['reprise_id']>0)
	{
		$checked_reprise = ' CHECKED';
		$checked_original = '';
		$hidden_reprise = '';
		$val_reprise = select_element("SELECT title FROM disco_songs WHERE song_id = ".$val_song['reprise_id'],true,'Reprise introuvable');
		$reprise_id = $val_song['reprise_id'];
		$reprise_name = $val_reprise['title'];
		$lang_id = $val_song['lang_id'];
	} else
	{
		$checked_reprise = '';
		$checked_original = ' CHECKED';
		$hidden_reprise = 'none';
		$reprise_id = 0;
		$reprise_name = '';
		$lang_id = 0;
	}
	
	// Boris 25/02/2006 : Gestion des medleys
	// Affichage du bouton radio "medley"
	$is_medley = ($val_song['medley'] == 'Y') ? true : false;
	$checked_medley = ($is_medley) ? ' CHECKED' : '';
	$checked_no_medley = (!$is_medley) ? ' CHECKED' : '';
	// fin Boris 25/02/2006
	
	$hidden_another_lang = 'none';
	$another_lang = '';
	$lyrics = $val_song['lyrics'];
	$musicians = $val_song['musicians'];
	$comment = $val_song['comment'];
	
	$list_singer = '|';
	$list_author = '|';
	$list_composer = '|';
}

if ($_GET['mode'] == 'add')
{

	$list_singer = '|';
	$list_author = '|';
	$list_composer = '|';
}
if ($_GET['mode'] == 'doedit' || $_GET['mode'] == 'doadd')
{
	// Vérification des champs obligatoires
	if (!isset($_POST['title']) || $_POST['title'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['title']));
		
	if (!isset($_POST['is_reprise']) || $_POST['is_reprise'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['reprise']));
	
	// Boris 25/02/2006 : Gestion des medleys
	// rapatriement variable medley
	if (!isset($_POST['medley']) || $_POST['medley'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Medley']));
	// fin Boris 25/02/2006
	
	if (!isset($_POST['reprise_id']) || $_POST['reprise_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'reprise_id'));
		
	if (!isset($_POST['list_singer']))
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['singer(s)']));
	
	if (!isset($_POST['list_author']))
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['auteur(s)']));
	
	if (!isset($_POST['list_composer']))
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['compositeur(s)']));
	
	if (!isset($_POST['lyrics']) || $_POST['lyrics'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['lyrics']));
	
	if ($is_reprise && $lang_id == 0)
	{
		if (!isset($_POST['another_lang']) || $_POST['another_lang'] == '')
			list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['langue']));
	}
}

if ($_GET['mode'] == 'doedit' || $_GET['mode'] == 'doadd' || $_GET['mode'] == 'edit_singer' || $_GET['mode'] == 'edit_composer' || $_GET['mode'] == 'edit_author' || $_GET['mode'] == 'supp_singer' || $_GET['mode'] == 'supp_composer' || $_GET['mode'] == 'supp_author')
{
	$title = $_POST['title'];
	
	$is_reprise = ($_POST['is_reprise']=='Y') ? true : false;
	
	// Boris 25/02/2006 : Gestion des medleys
	$is_medley = ($_POST['medley'] == 'Y') ? true : false;
	$medley = $_POST['medley'];
	// fin Boris 25/02/2006
	
	$reprise_id = ($is_reprise) ? $_POST['reprise_id'] : 0;
	$reprise_name = ($is_reprise) ? $_POST['reprise_name'] : 0;
	$lang_id = ($is_reprise) ? $_POST['lang_id'] : 0;
	
	$list_singer = $_POST['list_singer'];
	$list_author = $_POST['list_author'];
	$list_composer = $_POST['list_composer'];
		
	if ($reprise_id>0)
	{
		$checked_reprise = ' CHECKED';
		$checked_original = '';
		$hidden_reprise = '';
		/*
		Boris 05/03/2007
		Correction bug reprise
		if ($_GET['song_id']==0)
		{*/
			$reprise_id = $_POST['reprise_id'];
			$lang_id = $_POST['lang_id'];
		/*} else
		{
			$val_song = select_element("SELECT * FROM disco_songs WHERE song_id = '" . $_GET['song_id'] . "'",true,'titre introuvable');
			$reprise_id = $val_song['reprise_id'];
			$lang_id = $val_song['lang_id'];
		}*/
		$val_reprise = select_element("SELECT title FROM disco_songs WHERE song_id = '$reprise_id'",true,'Reprise introuvable');
		$reprise_name = $val_reprise['title'];
	} else
	{
		$checked_reprise = '';
		$checked_original = ' CHECKED';
		$hidden_reprise = 'none';
		$reprise_id = 0;
		$reprise_name = '';
		$lang_id = 0;
	}
	
	// Boris 25/02/2006 : Gestion des medleys
	// Affichage du bouton radio "medley"
	$checked_medley = ($medley == 'Y') ? ' CHECKED' : '';
	$checked_no_medley = ($medley == 'N') ? ' CHECKED' : '';
	// fin Boris 25/02/2006
	
	if ($is_reprise && $lang_id == 0)
	{
		$another_lang = $_POST['another_lang'];
	} else
		$another_lang = '';
	$lyrics = $_POST['lyrics'];
	
	$musicians = $_POST['musicians'];
	$comments = $_POST['comments'];
	
	$bbcode_uid = make_bbcode_uid();
	$lyrics = bbencode_first_pass($lyrics, $bbcode_uid);
	$comments = bbencode_first_pass($comments, $bbcode_uid);
	$musicians = bbencode_first_pass($musicians, $bbcode_uid);
	
	if (isset($_POST['confirm_doublon']))
		$confirm_doublon= ($_POST['confirm_doublon'] == 'ok') ? true : false;
	else
		$confirm_doublon = false;
	
	if ($is_reprise)
	{
		$val_reprise = select_element("SELECT * FROM disco_songs WHERE song_id = '$reprise_id'",false,'');
		
		if (!$val_reprise)
		{
			list($error,$error_msg) = array(true,sprintf($lang['song_unfound'],$reprise));
		}
	}
	if ($error)
	{
		// A priori inutile car la gestion des erreurs se fait dans le "if" spécifique à l'action : il y a déjà un test sur $error
		// Cette ligne ne permettait pas de retrouver la liste des artistes en cas d'ajout
		//$_GET['mode'] = ($_GET['mode'] == 'doedit') ? 'edit' : 'add';
	}
}



if ($_GET['mode'] == 'doadd')
{
	if (!$error && !$confirm_doublon)
	{
		$tab_doublon = select_liste("SELECT 
						A.*,
						C.name
					FROM 
						disco_songs A
					LEFT JOIN
						disco_artists_job B
					ON
						A.song_id = B.project
					LEFT JOIN
						disco_artists C 
					ON
						B.artist_id = C.artist_id
					WHERE 
						A.title = '$title' AND 
						(B.job = 'Interprète' OR B.job IS NULL)
						");
		if (count($tab_doublon)>0)
		{
			$doublon_song=true;
			$error=true;
			affichage_artistes();
			$error_msg = $lang['confirm_song_doublon'];
		}
	}
	else 
	{
		affichage_artistes();
		$_GET['mode'] = 'add';
	}
	
	if (!$error)
	{
		// Fabrication du dataname
		// mise à jour
		$sess_name = stripslashes($title);
		$sess_name = str_replace(" ","_",$sess_name);
		
		$Caracs = array("¥" => "Y", "µ" => "u", "À" => "A", "Á" => "A",
                "Â" => "A", "Ã" => "A", "Ä" => "A", "Å" => "A",
                "Æ" => "A", "Ç" => "C", "È" => "E", "É" => "E",
                "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I",
                "Î" => "I", "Ï" => "I", "Ð" => "D", "Ñ" => "N",
                "Ò" => "O", "Ó" => "O", "Ô" => "O", "Õ" => "O",
                "Ö" => "O", "Ø" => "O", "Ù" => "U", "Ú" => "U",
                "Û" => "U", "Ü" => "U", "Ý" => "Y", "ß" => "s",
                "à" => "a", "á" => "a", "â" => "a", "ã" => "a",
                "ä" => "a", "å" => "a", "æ" => "a", "ç" => "c",
                "è" => "e", "é" => "e", "ê" => "e", "ë" => "e",
                "ì" => "i", "í" => "i", "î" => "i", "ï" => "i",
                "ð" => "o", "ñ" => "n", "ò" => "o", "ó" => "o",
                "ô" => "o", "õ" => "o", "ö" => "o", "ø" => "o",
                "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u",
                "ý" => "y", "ÿ" => "y", '"' => "" , "'" => "" );
    
		$sess_name  = strtr($sess_name, $Caracs);
		
		$sess_name = strtolower($sess_name);
		
		preg_replace("/[^a-z]+/i","",$sess_name);
		
		$tab_doublon = select_liste("SELECT song_id FROM disco_songs WHERE dataname = '$sess_name'");
		while(count($tab_doublon)>0)
		{
			$sess_name .= rand(0,9);
			$tab_doublon = select_liste("SELECT song_id FROM disco_songs WHERE dataname = '$sess_name'");
		}
		
		$sql = "INSERT INTO disco_songs (title,dataname,medley,reprise_id,lang_id,lyrics,comment,bbcode_uid,musicians) 
					VALUES ('$title',
						'$sess_name',
						'$medley',
						'$reprise_id',
						'$lang_id',
						'$lyrics',
						'$comments',
						'$bbcode_uid',
						'$musicians'
						)";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout du titre");
		$song_id = mysql_insert_id();
		logger("Ajout du titre $title ($song_id)");
		
		if (!$error)
		{
			affichage_artistes();
			// Pour chaque job
			for ($i=0;$i<count($tab_artists);$i++)
			{
				for ($j=0;$j<count($tab_artists[$i]);$j++)
				{
					$sql = "INSERT INTO disco_artists_job (artist_id,job,project) VALUES 
						(
						'" . $tab_artists[$i][$j]['artist_id'] . "',
						'" . $tab_job[$i][0] . "',
						'" . $song_id . "')";
					mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'association de " . $tab_artists[$i][$j]['name'] . " en tant que " . $tab_job[$i][0]);
					logger("Association de ". $tab_artists[$i][$j]['name'] . " à $title en tant que " . $tab_job[$i][0]);
				}
			}
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=" . $song_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Add_song_ok'], stripslashes($title), '<a href="' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=" . $song_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message.$str);
		}
	} 
	else $_GET['mode'] = 'add';
}


if ($_GET['mode'] == 'supp_singer')
{
	if (!isset($_GET['artist_id']) || $_GET['artist_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['artist']));
	$artist_id = $_GET['artist_id'];
	
	if (!isset($_GET['song_id']) || $_GET['song_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'song_id'));
	$song_id = $_GET['song_id'];
	
	if ($song_id == 0)
	{
		// prévoir dans le cas de l'ajout
		$list_singer=str_replace($artist_id . '|','',$list_singer);
		
		affichage_artistes();
		$_GET['mode'] = 'add';
	} else
	{
		$sql = "DELETE FROM disco_artists_job WHERE artist_id = '$artist_id' AND job='Interprète' AND project='$song_id'";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la déassociation de l'artiste");
		logger("Déassociation de l'artiste \"$singer\" du titre $title en tant qu'interprète");
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'edit_singer')
{
	if (!isset($_POST['singer']) || $_POST['singer'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['singer(s)']));
	$singer = $_POST['singer'];
	
	$val_singer = select_element("SELECT * FROM disco_artists WHERE name = '$singer'",true,"Artiste inconnu");
	
	if (!isset($_GET['song_id']) || $_GET['song_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'song_id'));
	$song_id = $_GET['song_id'];
	if ($song_id == 0)
	{
		// prévoir dans le cas de l'ajout
		if (strpos($list_singer,'|' . $val_singer['artist_id'] . '|')===false)
		{
			$list_singer .= $val_singer['artist_id'] . '|';
		} else
		{
			list($error,$error_msg) = array(true,stripslashes(sprintf($lang['artist_already_asso'],$singer,$title,'chanteur')));
		}
		
		affichage_artistes();
		$_GET['mode'] = 'add';
		
	} else
	{
		$tab_doublon = select_liste("SELECT * FROM disco_artists_job WHERE artist_id = '" . $val_author['artist_id'] . "' AND job = 'Interprète' AND project = '$song_id'");
		if (count($tab_doublon)>0)
			list($error,$error_msg) = array(true,sprintf($lang['artist_already_asso'],$singer,$title,'chanteur'));
		else
		{
			$sql = "INSERT INTO disco_artists_job (artist_id,job,project) VALUES ('" . $val_singer['artist_id'] . "','Interprète','$song_id')";
			mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'association de l'artiste");
			logger("Association de l'artiste \"$singer\" au titre $title en tant qu'interprète");
		}
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'supp_author')
{
	if (!isset($_GET['artist_id']) || $_GET['artist_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Artiste']));
	$artist_id = $_GET['artist_id'];
	
	if (!isset($_GET['song_id']) || $_GET['song_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'song_id'));
	$song_id = $_GET['song_id'];
	
	if ($song_id == 0)
	{
		// prévoir dans le cas de l'ajout
		$list_author=str_replace($artist_id . '|','',$list_author);
		
		affichage_artistes();
		$_GET['mode'] = 'add';
	} else
	{
		$sql = "DELETE FROM disco_artists_job WHERE artist_id = '$artist_id' AND job='Auteur' AND project='$song_id'";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la déassociation de l'artiste");
		logger("Déassociation de l'artiste \"$singer\" du titre $title en tant qu'auteur");
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'edit_author')
{
	if (!isset($_POST['author']) || $_POST['author'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['author(s)']));
	$author = $_POST['author'];
	
	$val_author = select_element("SELECT * FROM disco_artists WHERE name = '$author'",true,"Artiste inconnu");
	
	if (!isset($_GET['song_id']) || $_GET['song_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'song_id'));
	$song_id = $_GET['song_id'];
	if ($song_id == 0)
	{
		// prévoir dans le cas de l'ajout
		if (strpos($list_author,'|' . $val_author['artist_id'] . '|')===false)
		{
			$list_author .= $val_author['artist_id'] . '|';
		} else
		{
			list($error,$error_msg) = array(true,stripslashes(sprintf($lang['artist_already_asso'],$author,$title,'auteur')));
		}
		
		affichage_artistes();
		$_GET['mode'] = 'add';
	} else
	{
		$tab_doublon = select_liste("SELECT * FROM disco_artists_job WHERE artist_id = '" . $val_author['artist_id'] . "' AND job = 'Auteur' AND project = '$song_id'");
		if (count($tab_doublon)>0)
			list($error,$error_msg) = array(true,sprintf($lang['artist_already_asso'],$author,$title,'auteur'));
		else
		{
			$sql = "INSERT INTO disco_artists_job (artist_id,job,project) VALUES ('" . $val_author['artist_id'] . "','Auteur','$song_id')";
			mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'association de l'artiste");
			logger("Association de l'artiste \"$author\" au titre $title en tant qu'auteur");
		}
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'supp_composer')
{
	if (!isset($_GET['artist_id']) || $_GET['artist_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['artist']));
	$artist_id = $_GET['artist_id'];
	
	if (!isset($_GET['song_id']) || $_GET['song_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'song_id'));
	$song_id = $_GET['song_id'];
	
	if ($song_id == 0)
	{
		// prévoir dans le cas de l'ajout
		$list_composer=str_replace($artist_id . '|','',$list_composer);
		
		affichage_artistes();
		$_GET['mode'] = 'add';
	} else
	{
		$sql = "DELETE FROM disco_artists_job WHERE artist_id = '$artist_id' AND job='Compositeur' AND project='$song_id'";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la déassociation de l'artiste");
		logger("Déassociation de l'artiste \"$singer\" du titre $title en tant que compositeur");
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'edit_composer')
{
	if (!isset($_POST['composer']) || $_POST['composer'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['composer(s)']));
	$composer = $_POST['composer'];
	
	$val_composer = select_element("SELECT * FROM disco_artists WHERE name = '$composer'",true,"Artiste inconnu");
	
	if (!isset($_GET['song_id']) || $_GET['song_id'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'song_id'));
	$song_id = $_GET['song_id'];
	if ($song_id == 0)
	{
		// prévoir dans le cas de l'ajout
		if (strpos($list_composer,'|' . $val_composer['artist_id'] . '|')===false)
		{
			$list_composer .= $val_composer['artist_id'] . '|';
		} else
		{
			list($error,$error_msg) = array(true,stripslashes(sprintf($lang['artist_already_asso'],$composer,$title,'compositeur')));
		}
		
		affichage_artistes();
		$_GET['mode'] = 'add';
	} else
	{
		$tab_doublon = select_liste("SELECT * FROM disco_artists_job WHERE artist_id = '" . $val_composer['artist_id'] . "' AND job = 'Compositeur' AND project = '$song_id'");
		if (count($tab_doublon)>0)
			list($error,$error_msg) = array(true,sprintf($lang['artist_already_asso'],$composer,$title,'compositeur'));
		else
		{
			$sql = "INSERT INTO disco_artists_job (artist_id,job,project) VALUES ('" . $val_composer['artist_id'] . "','Compositeur','$song_id')";
			mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'association de l'artiste");
			logger("Association de l'artiste \"$composer\" au titre $title en tant que compositeur");
		}
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'doedit')
{
	// Formatage et traitement du formulaire d'édition
	if (!isset($_GET['song_id']) || (int)$_GET['song_id']==0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable song_id');
	$song_id = $_GET['song_id'];
	
	// Gestion des doublons
	if (!$error && !$confirm_doublon)
	{
		$tab_doublon = select_liste("SELECT 
						A.*,
						C.name
					FROM 
						disco_songs A, 
						disco_artists_job B,
						disco_artists C 
					WHERE 
						A.title = '$title' AND 
						A.song_id <> '$song_id' AND 
						A.song_id = B.project AND
						B.job = 'Interprète' AND 
						B.artist_id = C.artist_id");
		if (count($tab_doublon)>0)
		{
			$doublon_song=true;
			$error=true;
			$error_msg = $lang['confirm_song_doublon'];
		}
	} else $_GET['mode'] = 'add';
	
	// Gestion des langues
	if ($is_reprise && $lang_id == 0)
	{
		$tab_lang = select_liste("SELECT lang_id FROM disco_languages WHERE language = '$another_lang'");
		if (count($tab_lang)>0)
		{
			$another_lang = '';
			$lang_id = $tab_lang[0]['lang_id'];
		} else
		{
			$sql = "INSERT INTO disco_languages (language) VALUES ('$another_lang')";
			mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout d'une langue");
			logger("Ajout de la langue \"$another_lang\" dans la discographie");
			$lang_id = mysql_insert_id();
		}
	}
	
	$val_song = select_element("SELECT * FROM disco_songs WHERE song_id = '" . $song_id . "'",true,"Titre introuvable");
	$changed_title = ($val_song['title'] != $title);
	
	
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
	
	// Boris 25/02/2006 : Gestion des medleys
	// Si le status passe de "medley" à "pas de medley" ==> supprimer les medleys associés
	if (!$error)
	{
		if ($val_song['medley'] == 'Y' && $_POST['medley'] == 'N')
		{
			$sql = "DELETE FROM disco_medley WHERE medley_id = '$song_id'";
			mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur durant la suppression des chansons associé au medley " . $val_song['title']);
			logger("Suppression des chansons associé au medley " . $val_song['title']);
		}
	}
	// fin Boris 25/02/2006
	
	if (!$error)
	{
		
	
		$sql = "UPDATE disco_songs 
			SET title = '$title',
			medley = '$medley',
			reprise_id = '$reprise_id',
			lang_id = '" . $lang_id .= "',
			lyrics='" . $lyrics . "',
			musicians='$musicians',
			comment='$comments',
			bbcode_uid = '$bbcode_uid' 
			WHERE song_id = '" . $song_id . "'";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification du titre $title<br />".mysql_error()."<br />".$sql);
		$final = select_element("SELECT * FROM disco_songs WHERE song_id = '" . $song_id . "'",true,"Modification introuvable");
		logger("Modification du titre $title ($song_id)",$val_song,$final);
		
		
		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=" . $song_id) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Edit_song_ok'], '<a href="' . append_sid($phpbb_root_path . "disco/sam_song." . $phpEx . "?mode=edit&song_id=" . $song_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}			
	} else 
	{
		stripslashes($title);
		$_GET['mode'] = 'edit';
	}
}

// Formulaire d'ajout ou d'édition : variables inchangeables
if ($_GET['mode'] == 'edit')
{
	$title = stripslashes($title);
	$lyrics = stripslashes($lyrics);
	$musicians = stripslashes($musicians);
	$comments = stripslashes($comments);
	$lyrics = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $lyrics));
	$musicians = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $musicians));
	$comments = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $comment));

	
	$u_action = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=doedit&song_id=' . $song_id);
	$l_action = $lang['edit_song'];
	$l_submit = $lang['Modifier'];
		
	$u_add_singer = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit_singer&song_id=' . $song_id);
	$u_add_author = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit_author&song_id=' . $song_id);
	$u_add_composer = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit_composer&song_id=' . $song_id);
	
	$u_supp = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=supp&song_id=' . $song_id);
	$l_confirm_supp = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$title)));
	$l_supp = sprintf(sprintf($lang['delete'],stripslashes($title)));
	
	// Boris 25/02/2006 : Gestion des medley
	// Affichage du contrôle des Medleys
	if ($is_medley)
	{
		$sql = "SELECT medley.id, song.song_id, song.title 
			FROM `disco_medley` medley, `disco_songs` song 
			WHERE medley.song_id = song.song_id AND `medley_id` = '$song_id'
			ORDER BY `ordre`";
		$tab_medley = select_liste($sql);

	}
	// Fin Boris 25/02/2006
}

if ($_GET['mode'] == 'add')
{
	$title = stripslashes($title);
	$lyrics = stripslashes($lyrics);
	$musicians = stripslashes($musicians);
	$comments = stripslashes($comments);
	$u_action = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=doadd');
	$l_action = $lang['add_song'];
	$l_submit = $lang['Ajouter'];
	if (!isset($_POST['is_reprise']))
	{
		$checked_reprise = '';
		$checked_original = ' CHECKED';
		$hidden_reprise = 'none';
		$reprise_id = 0;
		$reprise_name = '';
		$lang_id = 0;
	}
	if (!isset($is_medley))
		$checked_no_medley = ' CHECKED';
	$u_add_singer = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit_singer&song_id=0');
	$u_add_author = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit_author&song_id=0');
	$u_add_composer = append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit_composer&song_id=0');
}

// Liste des langues !
$tab_lang = select_liste("SELECT * FROM disco_languages ORDER BY language");

// Liste des artistes
if (!isset($tab_artists))
{
	for ($i=0;$i<count($tab_job);$i++)
	{
		$sql = "SELECT artist.* FROM disco_artists artist,  disco_artists_job job WHERE artist.artist_id = job.artist_id AND job.project = '$song_id' AND job.job='" .$tab_job[$i][0] ."'";
		$tab_artists[$i] = select_liste($sql);
	}
}
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/sam_song.tpl',
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
			'U_RETOUR' => append_sid($phpbb_root_path . 'disco/sam.php?mode=songs'),
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
					$lang['supp_song']
				)),
				"document.location='" . append_sid($phpbb_root_path . 'disco/sam_song.php?mode=supp&song_id=' . $song_id) . "'" );

}
// Construire le SELECT pour le choix de la langue
for ($i=0;$i<count($tab_lang);$i++)
	$template->assign_block_vars('lang',array(
						"LANG_ID" => $tab_lang[$i]['lang_id'],
						"LANGUAGE" =>  $tab_lang[$i]['language'],
						"SELECTED" =>  ($tab_lang[$i]['lang_id']==$lang_id) ? ' SELECTED' : '',
						)
					);
					
// Dans tous les cas : rajouter "Autre langue"
$template->assign_block_vars('lang',array(
					"LANG_ID" => 0,
					"LANGUAGE" =>  $lang['another_lang'],
					"SELECTED" =>  '',
					)
				);
// Liste des artistes
for($j=0;$j<count($tab_job);$j++)
{
	for ($i=0;$i<count($tab_artists[$j]);$i++)
	{
		$template->assign_block_vars($tab_job[$j][1],array(
				"ARTIST" => $tab_artists[$j][$i]['name'],
				"U_ARTIST" =>  append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=edit&artist_id=' . $tab_artists[$j][$i]['artist_id']),
				"JOB" => $tab_job[$j][1],
				"ARTIST_ID" => $tab_artists[$j][$i]['artist_id'],
				//"U_DEASSO" =>  append_sid($phpbb_root_path . 'disco/sam_song.php?mode=supp_' . $tab_job[$j][1] . '&artist_id=' . $tab_artists[$j][$i]['artist_id'] . '&song_id=' . $song_id),
				
				)
			);
	}
}

$template->assign_vars(array(
			"L_ACTION" => $l_action,
			"L_TITLE" => $lang['Titre'],
			"L_SUBMIT" => $l_submit,
			"L_SEARCH_ARTIST" => $lang['search_artist'],
			"L_COMMENTS" => $lang['l_comment'],
			"L_LYRICS" => $lang['Les paroles'],
			"L_MUSICIANS" => $lang['Musiciens'],
			"L_REPRISE" => $lang['is_a_reprise'],
			"L_OUI" => $lang['oui'],
			"L_NON" => $lang['non'],
			"L_ORIGINAL" => $lang['original_song'],
			"L_SEARCH_SONG" => $lang['search_song'],
			"L_LANG_REPRISE" => $lang['reprise_lang'],
			"L_AUTHORS" => $lang['auteur(s)'],
			"L_COMPOSERS" => $lang['compositeur(s)'],
			"L_SINGERS" => $lang['singer(s)'],
			"L_DEASSO" => $lang['deassocier'],
			"L_ADD_SINGER" => $lang['add_singer'],
			"L_ADD_AUTHOR" => $lang['add_author'],
			"L_ADD_COMPOSER" => $lang['add_composer'],
			"L_ADD" => $lang['Ajouter'],
			"L_SUPP" => $l_supp,
			"L_CONFIRM_SUPP" => $l_confirm_supp,
			'L_MEDLEY' => sprintf($lang['interro'],$lang['Medley']),
			'L_MEDLEY_EXPLAIN' => $lang['medley_explain'],
			'L_UP' => $lang['monter'],
			'L_DOWN' => $lang['descendre'],
			
			"U_ACTION" => $u_action,
			"U_SEARCH_SONG" => append_sid($phpbb_root_path . 'disco/search.php?mode=song&formulaire=formulaire&champs=reprise_name&champ_id=reprise_id'),
			"U_SEARCH_SINGER" => append_sid($phpbb_root_path . 'disco/search.php?mode=artiste&formulaire=formulaire&champs=singer'),
			"U_ADD_SINGER" => $u_add_singer,
			"U_SEARCH_AUTHOR" => append_sid($phpbb_root_path . 'disco/search.php?mode=artiste&formulaire=formulaire&champs=author'),
			"U_ADD_AUTHOR" => $u_add_author,
			"U_SEARCH_COMPOSER" => append_sid($phpbb_root_path . 'disco/search.php?mode=artiste&formulaire=formulaire&champs=composer'),
			"U_ADD_COMPOSER" => $u_add_composer,
			"U_DEASSO" => append_sid($phpbb_root_path . 'disco/sam_song.php?song_id=' . $song_id),
			"U_SUPP" => $u_supp,
			
			"CHECKED_ORIGINAL" => $checked_original,
			"CHECKED_REPRISE" => $checked_reprise,
			"CHECKED_MEDLEY" => $checked_medley,
			"CHECKED_NO_MEDLEY" => $checked_no_medley,
			"HIDDEN_REPRISE" => $hidden_reprise,
			"REPRISE_ID" => $reprise_id,
			"REPRISE_NAME" => $reprise_name,
			"HIDDEN_ANOTHER_LANG" => $hidden_another_lang,
			
			"LIST_SINGER" => $list_singer,
			"LIST_AUTHOR" => $list_author,
			"LIST_COMPOSER" => $list_composer,
			
			"TITLE" => htmlentities($title),
			"MUSICIANS" => htmlentities($musicians),
			"LYRICS" => htmlentities($lyrics),
			"COMMENTS" => htmlentities($comments),
			"ANOTHER_LANG" => $another_lang,
			
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

if ($doublon_song)
{
	$template->assign_block_vars('switch_doublon',array(
						'L_CONFIRM' => $lang['confirm_doublon_album'],
						'L_VERIF' => $lang['verif_doublon_song'],
						'L_PAR' => $lang['par'],
						));
											
	while(list($key,$val) = each($tab_doublon))
	{
		$template->assign_block_vars('switch_doublon.doublon',array(
						'SONG_ID' => $val['song_id'],
						'TITLE' => $val['title'],
						//'DATE' => ($val['date']-($val['date']/10000)*10000==0) ? $val['date']/10000 : affiche_date($val['date']),
						'ARTIST' => $val['name'],
						
						'U_SONG' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit&song_id=' . $val['song_id']),
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

	// Boris 04/03/2007 : Affichage des albums contenant le titre
	
	if (count($tab_artists[2])>0)
	{
		$sql = "SELECT * FROM `disco_albums` WHERE `artist_id` = '" . $tab_artists[2][0]['artist_id'] ."'";
		for ($i=1;$i<count($tab_artists[2]);$i++)
		{
			$sql .= " OR `artist_id` = '" . $tab_artists[2][$i]['artist_id'] ."'";
		}
		$sql .= " ORDER BY `title`";
		$tab_albums = select_liste($sql);
	} else
		$tab_albums = array();
	
	$template->assign_block_vars('switch_stat',array(
							"L_STAT" => $lang['statistiques'],
							"L_ALBUMS" => $lang['Albums'],
							
							'L_CREATE_ALBUM' => $lang['Create_album_from_song'],
							'L_ASSO_ALBUM' => $lang['Link_album_from_song'],
							'L_OR' => sprintf($lang['x_or_x'],'',''),
							
							'U_CREATE_ALBUM' => append_sid($phpbb_root_path .  'disco/sam_album.php?mode=add&default_song=' . $song_id),
							'U_ASSO_ALBUM' => append_sid($phpbb_root_path .  'disco/sam_album.php?mode=add_song'),
							
							'SONG_ID' => $song_id,
							/*"L_SONGS" => $lang['Songs'],
							"L_SUPP_ARTIST" => $lang['supp_artist'],
							"L_BAND_ACTION" => ($from == 'artist') ? $lang['bands_of_artist'] : $lang['artists_of_band'],
							"L_SEARCH_ARTIST"=> $l_search,
							"L_SUBMIT" => $lang['associer'],
							
							"U_SEARCH_ARTIST" => append_sid($phpbb_root_path . 'disco/search.php?mode=' . $mode_search . '&formulaire=search_band&champs=asso'),
							"U_BAND_ACTION" => append_sid($phpbb_root_path . 'disco/sam_artiste.php?mode=asso&artist_id=' . $artist_id),
							"U_SUPP_ARTIST" => $javascript_supp,*/
							));
	for ($i=0;$i<count($tab_albums);$i++)
	{
		$template->assign_block_vars('switch_stat.albums',array(
								"NAME" => $tab_albums[$i]['title'],
								"VALUE" => $tab_albums[$i]['album_id'],
								)
							);
	}
	
	$tab_albums = select_liste("SELECT album.*,asso.ordre FROM `disco_songs_albums` asso, `disco_albums` album WHERE asso.`song_id`='$song_id' AND album.`album_id` = asso.`album_id` ORDER BY album.`album_id`, asso.`ordre`");
	if (count($tab_albums)>0)
	{
		while(list($key,$val) = each($tab_albums))
			$template->assign_block_vars('switch_stat.album',array(
								"TITRE" => $val['title'],
								'U_ALBUM' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=edit&album_id=' . $val['album_id']),
								));
	} else $template->assign_block_vars('switch_stat.album',array(
								"TITRE" => $lang['no_album'],
								'U_ALBUM' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=add&default_song=' . $song_id)
								));
	
	// fin Boris 04/03/2007

	$template->assign_block_vars('switch_edit',array(
				
				/*'L_SONGS' => $lang['list_song'],
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
				'U_ADD_SONG' => append_sid($phpbb_root_path . 'disco/sam_album.php?mode=add_song&album_id=' . $album_id),*/
				));
}

// Boris 25/02/2006 : Gestion des medleys
if ($is_medley && $_GET['mode'] == 'edit')
{
	$template->assign_block_vars('switch_edit.is_medley',array(
						'L_SONGS_OF_MEDLEY' => $lang['Songs_of_medley'],
						'L_ADD_SONG_MEDLEY' => $lang['Add_song_medley'],
						
						'U_SEARCH_MEDLEY' => append_sid($phpbb_root_path . 'disco/search.php?mode=song&formulaire=formulaire_medley&champs=medley_name&champ_id=medley_id'),
						'U_ACTION' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=add_medley&amp;song_id=' . $song_id),
						)
					);
							
	for ($i = 0 ; $i < count($tab_medley) ; $i++)
	{
		$template->assign_block_vars('switch_edit.is_medley.medley',array(
						'SONG_TITLE' => $tab_medley[$i]['title'],
						
						'U_SONG' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=edit&amp;song_id='. $tab_medley[$i]['song_id']),
						'U_SUPP_SONG' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=supp_medley&amp;song_id='. $song_id . '&amp;medley_id=' . $tab_medley[$i]['song_id']),
						'U_UP' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=up_medley&amp;song_id='. $song_id . '&amp;id=' . $tab_medley[$i]['id']),
						'U_DOWN' => append_sid($phpbb_root_path . 'disco/sam_song.php?mode=down_medley&amp;song_id='. $song_id . '&amp;id=' . $tab_medley[$i]['id']) . '#medley',
						)
					);
	}
}
// fin Boris 25/02/2006


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