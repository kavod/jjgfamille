<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'tournees';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions_media.php');
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_TOURNEES);
init_userprefs($userdata);
//
// End session management
//
if ($_GET['mode'] == 'import')
{
	if (!isset($_GET['tournee_id']) || ((int)$_GET['tournee_id']) == 0)
		message_die(CRITICAL_ERROR,"Erreur dans la transmission de la variable tournee_id");
	$tournee_id = $_GET['tournee_id'];
	
	if (!isset($_POST['album_id']) || ((int)$_POST['album_id']) == 0)
		list($error,$error_msg) = array( true , sprintf($lang['Champs_needed'],$lang['Album']));
	$album_id = $_POST['album_id'];
	
	if (!$error)
	{
		$val_tournee = select_element("SELECT * FROM `tournee_tournees` WHERE `tournee_id` = '$tournee_id'",true,'Tournée inconnue');
		$val_album = select_element("SELECT * FROM `disco_albums` WHERE `album_id` = '$album_id'",true,'Album inconnue');
		
		$tab_tracklist = select_liste("SELECT * FROM `disco_songs_albums` WHERE `album_id` = '$album_id'");
		
		$sql = "DELETE FROM `tournee_tracklist` WHERE `tournee_id` = '$tournee_id'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
		
		for ($i=0; $i<count($tab_tracklist);$i++)
		{
			$sql = "INSERT INTO `tournee_tracklist` (`tournee_id`, `song_id`, `ordre`, `description`)
				VALUES ('$tournee_id', '" . $tab_tracklist[$i]['song_id'] . "', '" . $tab_tracklist[$i]['ordre'] . "', '" . $tab_tracklist['comment'] . "')";
			mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
		}
		logger("Importation de la tracklist de l'album " . $val_album['title'] . " vers la tournée " . $val_tournee['title']);
		
		$url = append_sid($phpbb_root_path . "tournees/tournees.php?tournee_id=" . $tournee_id . "&cate_id=" . $val_tournee['cate_id']);
		
		$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . $url . '">')
				);
		$message =  sprintf(sprintf($lang['La_X_ok'],$lang['tracklist'],$lang['imported'],$lang['tournee_edit_page']), '<a href="' . $url . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);	
	} else
	{
		$_GET['mode'] = 'modif';
	}
}

if ($_GET['mode'] == 'modif')
{
	$error = false;
	$error_msg = '';
	
	$tournee_id = $_GET['tournee_id'];
	
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"Titre\" est obligatoire");
	$title = htmlentities($title);
	if (!isset($_POST['artist_id']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$artist_id = $_POST['artist_id'];
	if ($artist_id == 0 || $artist_id == "")
		list($error,$error_msg) = array( true , "Veuillez préciser l'artiste");
	
	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$comment = $_POST['comment'];
	
	if (!isset($_POST['musicians']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$musicians = $_POST['musicians'];
	
	$cate_id = $_POST['cate_id'];
	
	$bbcode_uid = make_bbcode_uid();
	$comment = delete_html($comment);
	
	// Aucun traitement sauf le bbencode...
	$comment=bbencode_first_pass($comment,$bbcode_uid);
	$musicians=bbencode_first_pass($musicians,$bbcode_uid);
	
	if (!$error)
	{
		$sql_update = "UPDATE tournee_tournees SET  title='".$title."',artist_id='".$artist_id."',comment='".$comment."',bbcode_uid='".$bbcode_uid."',musicians='".$musicians."',cate_id = ".$cate_id." WHERE tournee_id=".$tournee_id."";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
	
		if (!$error)
		{
			logger("Modification de la tournée $title");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("tournees." . $phpEx ."?tournee_id=".$tournee_id) . '">')
				);
				$message =  sprintf($lang['Upload_tournee_ok'], '<a href="' . append_sid("tournees." . $phpEx."?tournee_id=".$tournee_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}
if ($_GET['mode'] == 'add_song')
{
	$error = false;
	$error_msg = '';
	
	$tournee_id = $_GET['tournee_id'];
	
	if (!isset($_POST['song_id']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$song_id = $_POST['song_id'];
	if (((int)$song_id) == 0)
		list($error,$error_msg) = array( true , "Veuillez préciser la chanson");
	
	$sql_track = "SELECT ordre FROM tournee_tracklist WHERE tournee_id = ".$tournee_id." ORDER BY ordre DESC LIMIT 0,1";
	$result_track = mysql_query($sql_track);
	if ($val_track = mysql_fetch_array($result_track))
	{
		$ordre = $val_track['ordre'] + 1;
	} else
	{
		$ordre = 1;
	}
	mysql_free_result($result_track);
	
	if (!$error)
	{
		$sql_update = "INSERT INTO tournee_tracklist (tournee_id,song_id,ordre) VALUES('".$tournee_id."','".$song_id."','".$ordre."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
	
		if (!$error)
		{
			logger("Ajout de la chanson N°$song_id dans la tracklist de la tournée N°$tournee_id");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("tournees." . $phpEx ."?tournee_id=".$tournee_id) . '#add_song">')
				);
				$message =  sprintf($lang['Upload_song_tournee_ok'], '<a href="' . append_sid("tournees." . $phpEx."?tournee_id=".$tournee_id) . '#add_song">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}
if ($_GET['mode'] == 'add_concert')
{
	$error = false;
	$error_msg = '';
	
	$tournee_id = $_GET['tournee_id'];
	
	if (!isset($_POST['lieu']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$lieu = $_POST['lieu'];
	if ($lieu == "")
		list($error,$error_msg) = array( true , "Le champ lieu est obligatoire");
	$lieu = htmlentities($lieu);
	if (!isset($_POST['date']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$date = $_POST['date'];
	if ($date == "")
		list($error,$error_msg) = array( true , "Le champ date est obligatoire");
	$date = htmlentities($date);
	$date = format_date($date);
	
	if (!$error)
	{
		$sql_update = "INSERT INTO tournee_concerts (tournee_id,date,lieu,user_id,username) VALUES('".$tournee_id."','".$date."','".$lieu."','".$userdata['user_id']."','".$userdata['username']."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
	
		if (!$error)
		{
			logger("Ajout du concert du $date à $lieu de la tournée N°$tournee_id");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("tournees." . $phpEx ."?tournee_id=".$tournee_id) . '">')
				);
				$message =  sprintf($lang['Upload_concert_ok'], '<a href="' . append_sid("tournees." . $phpEx."?tournee_id=".$tournee_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}
if ($_GET['mode'] == 'add_billet')
{
	$error = false;
	$error_msg = '';

	$tournee_id = $_GET['tournee_id'];
			
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
			
	$comment = $_POST['comment'];
	$comment = htmlentities($comment);
	$type = $_POST['type'];
	
	if (!$error)
	{
		$sql_update = "INSERT INTO tournee_billets (tournee_id,comment,user_id,username,type) VALUES ( '".$tournee_id."' ,'".$comment."' , '".$userdata['user_id']."' , '".$userdata['username']."','".$type."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
		logger("Ajout du billet de la tournée N°$tournee_id");
		
		$billet_id = mysql_insert_id();
		
		
		// Ajout de la photo
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy(
					$error,
					$error_msg,
					$HTTP_POST_FILES['userfile'],
					$phpbb_root_path . 'images/tournees/billet_' . $tournee_id .'_'.$billet_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['photo_max_width'],
						$site_config['photo_max_height'])
					);
			if ($error)
			{
				$sql_del = "DELETE FROM  tournee_billets WHERE billet_id = " . $billet_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
				logger("Suppression du billet $billet_id apres echec de l'upload");
			}
		}
		
		if (!$error)
		{
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("tournees." . $phpEx."?tournee_id=".$tournee_id) . '">')
			);
			$message =  sprintf($lang['Upload_billet_ok'], '<a href="' . append_sid("tournees." . $phpEx."?tournee_id=".$tournee_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}
//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='tournee' ORDER BY user_id");

//La tournee
$val_tournee = select_element("SELECT * FROM tournee_tournees WHERE tournee_id = ".$_GET['tournee_id']."",'',false);
//Liste des chansons
$tab_songs = select_liste("SELECT * FROM tournee_tracklist WHERE tournee_id = ".$_GET['tournee_id']." ORDER BY ordre");
//Liste des concerts
$tab_concerts = select_liste("SELECT * FROM tournee_concerts WHERE tournee_id = ".$_GET['tournee_id']." ORDER BY date");
//Liste des billets
$tab_billets = select_liste("SELECT * FROM tournee_billets WHERE tournee_id = ".$_GET['tournee_id']."");
//Liste des artistes
$tab_artist = select_liste("SELECT * FROM disco_artists");
//Liste des chansons
$tab_song = select_liste("SELECT * FROM disco_songs ORDER BY title");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_tournees'],'tournees');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Tournees'].' :: '.$val_tournee['title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/tournees/tournees.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/tournees/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['Tournees'],
				"RESPONSABLES" => $lang['Responsables'],
				"L_TITRE" => $val_tournee['title'],
				"MUSICIENS" => $lang['Musiciens'],
				"MUSICIANS" => bbencode_second_pass(nl2br($val_tournee['musicians']),$val_tournee['bbcode_uid']),
				"PASS_BILLET" => $lang['pass_billets'],
				"L_DATE_CONCERTS" => $lang['liste_date_concerts'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'tournees/view_cate.php?cate_id='.$val_tournee['cate_id']),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['liste_cate'],
				'L_TRACKLIST' => sprintf($lang['deux_points'],$lang['Tracklist']),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'tournees/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

for ($i=0;$i<count($tab_billets);$i++)
{	
	$ext = find_image('../images/tournees/billet_' . $val_tournee['tournee_id'] . '_'. $tab_billets[$i]['billet_id'].'.');
	if (is_file('../images/tournees/billet_' . $val_tournee['tournee_id'] . '_'. $tab_billets[$i]['billet_id'].'.'.$ext))
	{
		$billet = $phpbb_root_path . 'functions/miniature.php?mode=tournees_billets&billet_id=' . $tab_billets[$i]['billet_id'] .'&tournee_id=' . $val_tournee['tournee_id'] . "&tnH=100";
	}else
	{
		$billet = '../templates/jjgfamille/images/site/px.png';
	}
		
	$size = getimagesize('../images/tournees/billet_' . $val_tournee['tournee_id'] . '_'. $tab_billets[$i]['billet_id'].'.'.$ext);
	
	if($tab_billets[$i]['comment'] == "")
	{
		$height = $size[1]+20;
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
		{
			$height = $height + 180 ;
		}
	}else
	{
		$height = $size[1]+100;	
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
		{
			$height = $height + 100 ;
		}	
	}

	$onclick = " window.open('billet.php?billet_id=".$tab_billets[$i]['billet_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+40).",height=".$height.",left=100,top=100')";
	
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
		{
			$l_supprimer = $lang['supprimer'];
			$u_supprimer = append_sid($phpbb_root_path . 'tournees/doedit.php?mode=supp_billet&billet_id='.$tab_billets[$i]['billet_id'].'&tournee_id='.$val_tournee['tournee_id']);
		}
	

		
	$template->assign_block_vars('switch_billets',array(
						'BILLET' => $billet,
						'ONCLICK' => $onclick,
						'L_SUPPRIMER' => $l_supprimer,
						'U_SUPPRIMER' => $u_supprimer,
						'L_CONFIRM_SUPP_BILLET' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['billet'])))),
						'ALT' => $tab_billets[$i]['type']." de la tournée ".$val_tournee['title'],
						)
					);
}

for ($i=0;$i<count($tab_concerts);$i++)
	$template->assign_block_vars('switch_concerts',template_concerts($tab_concerts[$i]));
	
for ($i=0;$i<count($tab_songs);$i++)
{
	$val_song = select_element("SELECT * FROM disco_songs WHERE song_id= ".$tab_songs[$i]['song_id']."  LIMIT 0,1",'',false);
	
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
		{
			$l_supprimer = $lang['supprimer'];
			$u_supprimer = append_sid($phpbb_root_path . 'tournees/doedit.php?mode=supp_song&track_id='.$tab_songs[$i]['track_id'].'&tournee_id='.$val_tournee['tournee_id']);
			$l_monter = $lang['monter'];
			$u_monter = append_sid($phpbb_root_path . 'tournees/doedit.php?mode=upsong&track_id='.$tab_songs[$i]['track_id'].'&tournee_id='.$val_tournee['tournee_id']);
			$l_descendre = $lang['descendre'];
			$u_descendre = append_sid($phpbb_root_path . 'tournees/doedit.php?mode=downsong&track_id='.$tab_songs[$i]['track_id'].'&tournee_id='.$val_tournee['tournee_id']);
		}
	
	$template->assign_block_vars('switch_songs',array(
						'U_TITRE' => append_sid($phpbb_root_path . 'disco/view_song.php?song_id='.$tab_songs[$i]['song_id']),
						'L_TITRE' => $val_song['title'],
						'L_SUPPRIMER' => $l_supprimer,
						'U_SUPPRIMER' => $u_supprimer,
						'L_CONFIRM_SUPP_CHANSON' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['chanson'])))),
						'L_MONTER' => $l_monter,
						'U_MONTER' => $u_monter,
						'L_DESCENDRE' => $l_descendre,
						'U_DESCENDRE' => $u_descendre,
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

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
{
		$template->assign_block_vars('switch_admin',array(
						"L_ADMIN" =>  $lang['tournee_admin'],
						"L_SUBMIT" => $lang['Submit'],
						"L_TITRE" => $lang['l_titre'],
						"L_ARTIST" => $lang['Artiste'],	
						"L_DATE" => $lang['Date'],
						"L_ILLU" =>  $lang['chemin_illu'], 
						"L_COMMENT" => $lang['commentaire'],
						'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['tournee'])))),
						"L_MUSICIANS" => $lang['Musiciens'],
						"L_TYPE" => $lang['Type'],
						"L_CATE" => $lang['categorie'],
						"L_SUPP" => $lang['supprimer']."&nbsp;".$lang['cette']."&nbsp;".$lang['tournee'],
						// 22/12/2005 Boris : ajout du popup de sélection des chansons
						"L_SEARCH_SONG" => $lang['search_song'],
						// fin boris 22/12/2005
						// Boris 26/02/2006 : Importation de tracklist
						'L_IMPORT_TRACKLIST' => $lang['Import_tracklist_from_album'],
						'L_CONFIRM_IMPORT' => addslashes(sprintf($lang['Confirm'],$lang['supp_then_import_tracklist'])),
						'L_IMPORT' => $lang['Import'],
						// Fin Boris 26/02/2006
						
						"AJOUT_TOURNEE"  => $lang['add_tournee'],
						"DESC" => $lang['Description'],	
						"TITRE" => $val_tournee['title'],
						"COMMENT" => preg_replace('/\:(([a-z0-9]:)?)' . $val_tournee['bbcode_uid'] . '/s', '', $val_tournee['comment']),
						"MODIF_TOURNEE"	=> $lang['modif_tournee'],
						"AJOUT_TRACK" => $lang['add_track'],
						"AJOUT_CONCERT" => $lang['add_concert'],
						"LIEU" =>$lang['Lieu'],	
						"MUSICIANS" => htmlentities(preg_replace('/\:(([a-z0-9]:)?)' . $val_tournee['bbcode_uid'] . '/s', '', $val_tournee['musicians'])),
						
						"U_FORM" => append_sid("tournees.php?mode=modif&tournee_id=".$val_tournee['tournee_id']),
						"U_FORM_TRACK" => append_sid("tournees.php?mode=add_song&tournee_id=".$val_tournee['tournee_id']),
						"U_FORM1" => append_sid("tournees.php?mode=add_concert&tournee_id=".$val_tournee['tournee_id']),
						"AJOUT_BILLET" => $lang['Ajouter'].' '.$lang['pass_billets'],
						"U_FORM2" => append_sid("tournees.php?mode=add_billet&tournee_id=".$val_tournee['tournee_id']),
						"U_SUPP" => append_sid("doedit.php?mode=supp_tournee&tournee_id=".$val_tournee['tournee_id']),
						// 22/12/2005 Boris : ajout du popup de sélection des chansons	
						"U_SEARCH_SONG" => append_sid($phpbb_root_path . 'disco/search.php?mode=song&formulaire=form_add_song&champs=song_name&champ_id=song_id'),
						// fin boris 22/12/2005
						// Boris 26/02/2006 : Importation de tracklist
						'U_IMPORT_TRACKLIST' => append_sid($phpbb_root_path . 'tournees/tournees.php?mode=import&amp;tournee_id=' . $val_tournee['tournee_id']),
						// Fin Boris 26/02/2006
						)
					);
					
		for ($i=0;$i<count($tab_artist);$i++)
		{
			$template->assign_block_vars('switch_admin.artist',array(
					'VALUE' => $tab_artist[$i]['artist_id'],
					'INTITULE' => $tab_artist[$i]['name'],
					"SELECTED" => ($tab_artist[$i]['artist_id'] == $val_tournee['artist_id'] ) ? " SELECTED" : ""
					)
				);
		}
			
		for ($i=0;$i<count($tab_song);$i++)
		{
			$template->assign_block_vars('switch_admin.song',array(
					'VALUE' => $tab_song[$i]['song_id'],
					'INTITULE' => $tab_song[$i]['title'],
					//"SELECTED" => ($tab_artist[$i]['artist_id'] == $val_tournee['artist_id'] ) ? " SELECTED" : ""
					)
				);
		}
		$tab_cate = select_liste("SELECT * FROM tournee_cate ORDER BY ordre");	
		for ($i=0;$i<count($tab_cate);$i++)
		{
	
			$template->assign_block_vars('switch_admin.options',array(
						'VALUE' => $tab_cate[$i]['cate_id'],
						'INTITULE' => $tab_cate[$i]['cate_name'],
						"SELECTED" => ($tab_cate[$i]['cate_id'] == $val_tournee['cate_id'] ) ? " SELECTED" : ""
						)
			);
		}
		
		// Boris 26/02/2006 : Importation de tracklist
		$sql = "SELECT * FROM `disco_albums` WHERE `artist_id` = '" . $val_tournee['artist_id'] . "'";
		$tab_album = select_liste($sql);
		for ($i=0;$i<count($tab_album);$i++)
		{
			$template->assign_block_vars('switch_admin.album',array(
							'ALBUM_ID' => $tab_album[$i]['album_id'],
							'ALBUM_TITLE' => $tab_album[$i]['title'],
						)
			);
		}
		// fin Boris 26/02/2006
}
//Liste des categories
$tab_cate = select_liste("SELECT * FROM tournee_cate ORDER BY ordre");
for ($i=0;$i<count($tab_cate);$i++)
{
	
	$template->assign_block_vars('switch_cate',array(
						'U_CATE' => append_sid($phpbb_root_path . 'tournees/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('tournees','opif');
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