<?php
/***************************************************************************
 *                                search.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: search.php,v 1.72.2.14 2004/07/17 13:48:32 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
define('WEBSITE_POSITION','website');
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');


//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_SEARCH);
init_userprefs($userdata);
//
// End session management
//

switch($_GET['mode'])
{
	case 'artiste':
		$l_search=$lang['search_artist_solo'];
		$l_update=$lang['select_artist'];
		$where = ' ';
		$l_add=$lang['add_artiste'];
		break;
	case 'artiste_solo':
		$l_search=$lang['search_artist_solo'];
		$l_update=$lang['select_artist'];
		$where = ' AND band=\'N\'';
		$l_add=$lang['add_artiste'];
		break;
	case 'groupe':
		$l_search=$lang['search_band'];
		$l_update=$lang['select_band'];
		$where = ' AND band=\'Y\'';
		$l_add=$lang['add_artiste'];
		break;
	case 'song':
		$l_search = $lang['search_song'];
		$l_update = $lang['select_song'];
		$where = '';
		break;
	default:
		message_die(GENERAL_ERROR, 'Recherche inconnue', '', __LINE__, __FILE__, $sql);
}

if (isset($_POST['add']) && $_POST['add']=='ok')
{
	$new_name =	$_POST['new_name'];
	if ( $new_name != '')
	{
		$HTTP_POST_VARS['search_disco'] = "*".$new_name."*";
		$tab_artist = select_liste("SELECT * FROM disco_artists WHERE name = '" . $new_name . "'");
		if (count($tab_artist)>0)
		{
			$l_add .= "<br /><big><b>" . $lang['already_presented_artist'] . "</b></big>";
		} else
		{
			// mise à jour
			$sess_name = $new_name;
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
                "ý" => "y", "ÿ" => "y");
    
			$sess_name  = strtr($sess_name, $Caracs);
			
			$sess_name = strtolower($sess_name);
			
			preg_replace("/[^a-z]+/i","",$sess_name);
			
			$sql = "INSERT INTO disco_artists (name,Band,Open,sess_name) VALUES ('" . $new_name . "','N','Y','" . $sess_name . "')";
			if (!mysql_query($sql))
			{
				message_die(GENERAL_ERROR,'Impossible d\'ajouter l\'artiste<br />' . $sql . '<br />' . mysql_error(),__FILE__,__FILE__,$sql);
				logger("BUG : impossible d'ajouter l'artiste $new_name");
			} else
			{
				logger("Ajout de l'artiste $new_name");
			}
		}
	}
}

//
// Artist search
//
function artist_search($search_match,$l_search,$l_update,$mode,$formulaire,$champs,$where,$l_add)
{
	
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $starttime, $gen_simple_header;
	
	$gen_simple_header = TRUE;

	$username_list = '';
	if ( !empty($search_match) )
	{
		$disco_search = preg_replace('/\*/', '%', trim(strip_tags($search_match)));

		$sql = "SELECT name 
			FROM disco_artists  
			WHERE name LIKE '" . str_replace("\'", "''", $disco_search) . "' " . $where . "
			ORDER BY name";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			do
			{
				$disco_list .= '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
			}
			while ( $row = $db->sql_fetchrow($result) );
		}
		else
		{
			$disco_list .= '<option>' . $lang['No_match']. '</option>';
		}
		$db->sql_freeresult($result);
	}

	$page_title = $lang['Search'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'search_user_body' => 'site/disco/search_disco.tpl')
	);
	$template->assign_vars(array(
		'VALUE' => ( !empty($search_match) ) ? strip_tags($search_match) : '', 

		'L_CLOSE_WINDOW' => $lang['Close_window'], 
		'L_SEARCH_DISCO' => $l_search, 
		'L_UPDATE_DISCO' => $l_update, 
		'L_SELECT' => $lang['Select'], 
		'L_SEARCH' => $lang['Search'], 
		'L_SEARCH_EXPLAIN' => $lang['Search_author_explain'], 
		'L_CLOSE_WINDOW' => $lang['Close_window'], 
		
		'FORMULAIRE' => $formulaire,
		'CHAMPS' => $champs,

		'S_DISCO_OPTIONS' => $disco_list, 
		'S_SEARCH_ACTION' => append_sid($phpbb_root_path . "disco/search.$phpEx?mode=" . $mode . "&formulaire=" . $formulaire . "&champs=" . $champs ))
	);

	if ( $disco_list != '' )
	{
		$template->assign_block_vars('switch_select_name', array());
		if ($mode == 'artiste')
		{
			$template->assign_block_vars('switch_select_name.add', array(
											'L_EXPLAIN' => $l_add,
											'L_ADD' => $lang['Ajouter'],
											));
		}
	}

	$template->pparse('search_user_body');
	
	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

	return;
}

//
// Song search
//
function song_search($search_match,$l_search,$l_update,$mode,$formulaire,$champs,$where,$l_add,$champ_id)
{
	
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $starttime, $gen_simple_header;
	
	$gen_simple_header = TRUE;

	$username_list = '';
	if ( !empty($search_match) )
	{
		$disco_search = preg_replace('/\*/', '%', trim(strip_tags($search_match)));

		$sql = "SELECT A.song_id, A.title, MIN(C.date) date, E.name
			FROM disco_songs A, disco_artists_job D, disco_artists E 
			LEFT JOIN disco_songs_albums B
			ON A.song_id = B.song_id
			LEFT JOIN disco_albums C
			ON B.album_id = C.album_id
			WHERE 
				A.song_id = D.project AND 
				D.artist_id = E.artist_id AND 
				D.job='Interprète' AND 
				A.title LIKE '" . str_replace("\'", "''", $disco_search) . "' " . $where . "
			GROUP BY song_id, title,name
			ORDER BY title,song_id,name";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$str_singers1="";
			$str_singers2="";
			$song_id=0;
			$date=0;
			$title="";
			do
			{
				if ($row['song_id']==$song_id)
				{
					if ($str_singers1=="")
						$str_singers1=$str_singers2;
					else
						$str_singers1=sprintf($lang['virgule'],$str_singers1,$str_singers2);
					$str_singers2=$row['name'];
				} else
				{
					if ($song_id>0)
					{
						if($str_singers1=="")
							$str_singers1=$str_singers2;
						else
							$str_singers1=sprintf($lang['x_and_x'],$str_singers1,$str_singers2);
							
						$disco_list .= '<option value="' . $song_id . '">' . sprintf($lang['song_by'],$title,$str_singers1,affiche_date($date)) . '</option>';
					}
					$str_singers1="";
					$str_singers2=$row['name'];
					$song_id=$row['song_id'];
					$title=$row['title'];
					$date=$row['date'];
				}
					$tab_result[]=$row;
					
			} while ( $row = $db->sql_fetchrow($result) );
			
			if ($song_id>0)
			{
				if($str_singers1=="")
					$str_singers1=$str_singers2;
				else
					$str_singers1=sprintf($lang['x_and_x'],$str_singers1,$str_singers2);
					
				$disco_list .= '<option value="' . $song_id . '">' . sprintf($lang['song_by'],$title,$str_singers1,affiche_date($date)) . '</option>';
			}
		}
		else
		{
			$disco_list .= '<option>' . $lang['No_match']. '</option>';
		}
		$db->sql_freeresult($result);
	}

	$page_title = $lang['Search'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'search_user_body' => 'site/disco/search_disco.tpl')
	);
	$template->assign_vars(array(
		'VALUE' => ( !empty($search_match) ) ? strip_tags($search_match) : '', 

		'L_CLOSE_WINDOW' => $lang['Close_window'], 
		'L_SEARCH_DISCO' => $l_search, 
		'L_UPDATE_DISCO' => $l_update, 
		'L_SELECT' => $lang['Select'], 
		'L_SEARCH' => $lang['Search'], 
		'L_SEARCH_EXPLAIN' => $lang['Search_author_explain'], 
		'L_CLOSE_WINDOW' => $lang['Close_window'], 
		
		'J_ASSIGN_ID' => 'opener.document.forms[\''. $formulaire . '\'].' . $champ_id . '.value = selected_disco.value;',
		
		'FORMULAIRE' => $formulaire,
		'CHAMPS' => $champs,

		'S_DISCO_OPTIONS' => $disco_list, 
		'S_SEARCH_ACTION' => append_sid($phpbb_root_path . "disco/search.$phpEx?mode=" . $mode . "&formulaire=" . $formulaire . "&champs=" . $champs . "&champ_id=" . $champ_id))
	);

	if ( $disco_list != '' )
	{
		$template->assign_block_vars('switch_select_name', array());
	}

	$template->pparse('search_user_body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

	return;
}
switch($_GET['mode'])
{
	case 'artiste':
	case 'artiste_solo':
	case 'groupe':
		artist_search($HTTP_POST_VARS['search_disco'],$l_search,$l_update,$_GET['mode'],$_GET['formulaire'],$_GET['champs'],$where,$l_add);
		break;
	case 'song':
		song_search($HTTP_POST_VARS['search_disco'],$l_search,$l_update,$_GET['mode'],$_GET['formulaire'],$_GET['champs'],$where,$l_add,$_GET['champ_id']);
		break;
}