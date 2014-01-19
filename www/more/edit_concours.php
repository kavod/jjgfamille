<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
define('CATE_ID_CONCOURS', 14);
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//

// Vérification des permissions
$job = array('more');
require_once($phpbb_root_path . 'includes/reserved_access.php');

include($phpbb_root_path . 'includes/log_necessary.php');

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('more'));

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

// Initialisation erreur
$error = false;
$error_msg = '';

// Vérification d'un historique de participations
if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] != 0)
{
	$concours_id = (int)$_GET['concours_id'];
	$tab_participation = select_liste("SELECT * FROM concours_participation WHERE concours_id = '" . $concours_id . "'");
	$already_played = (count($tab_participation) > 0);
	
	$tab_winner = select_liste("SELECT * FROM concours_winners WHERE concours_id = '" . $concours_id . "'");
}

// Fonctions
/**
 * reset_participation
 *
 * Supprime toutes les participations à un concours
 * @param $concours_id Identifiant du concours à reseter
 */
function reset_participation($concours_id)
{
	if (!isset($concours_id) || (int)$concours_id == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id dans reset_participation');
	
	$val_concours = select_concours($concours_id,true);
	
	$tab_question = select_liste("SELECT question_id FROM concours_questions WHERE concours_id = '$concours_id'");
	for ($i=0;$i<count($tab_question);$i++)
	{
		$sql = "DELETE FROM concours_reponses WHERE question_id = '" . $tab_question[$i]['question_id'] . "'";
		mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	}
	
	$sql = "DELETE FROM concours_winners WHERE concours_id = '" . $concours_id . "'";
	mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	
	$sql = "DELETE FROM concours_participation WHERE concours_id = '" . $concours_id . "'";
	mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	
	logger("Concours \"" . $val_concours['title'] . "\" reseté");
}

/**
 * supp_concours
 *
 * Supprime un concours
 * @param $concours_id Identifiant du concours à supprimer
 */
function supp_concours($concours_id)
{
	if (!isset($concours_id) || (int)$concours_id == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id dans reset_participation');
		
	$val_concours = select_concours($concours_id,true);
	
	reset_participation($concours_id);
	
	$sql = "DELETE FROM `concours_questions` WHERE `concours_id` = '" . $concours_id . "'";
	mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	
	supp_illu($concours_id);
	
	$sql = "DELETE FROM `concours` WHERE `concours_id` = '" . $concours_id . "'";
	mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	
	
	logger("Concours \"" . $val_concours['title'] . "\" supprimé");
}

/**
 * Sélectionne l'enregistrement bdd d'un concours
 *
 * @param $concours_id Identifiant du concours
 * @param $obli Affiche un message d'erreur si à true et que l'enregistrement n'est pas trouvé
 */
function select_concours($concours_id,$obli=true)
{
	global $lang;
	$concours = (int)$concours_id;
	return select_element("SELECT * FROM concours WHERE concours_id = '$concours_id'",true,$lang['unfound_concours']);
}

/**
 * En cas d'erreur, reformate les chaines pour affichage
 */
function concours_addslashes()
{
	global $title,$description,$chapeau,$reglement,$bbcode_uid,$date_begin,$date_end,$question,$reponse1,$reponse2,$reponse3,$reponse4,$tab_question;
	$title = stripslashes($title);
	$description = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $description));
	$chapeau = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $chapeau));
	$reglement = str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $reglement));
	$date_begin = date('d/m/Y',$date_begin);
	$date_end = date('d/m/Y',$date_end);
	
	$question = htmlentities(stripslashes($question));
	for ($i=1;$i<5;$i++)
		${'reponse' . $i} = stripslashes(${'reponse' . $i});
		
	for ($i=0;$i<count($tab_question);$i++)
	{
		$tab_question[$i]['question'] = htmlentities(stripslashes(preg_replace('/\:(([a-z0-9]:)?)' . $tab_question[$i]['bbcode_uid'] . '/s', '', $tab_question[$i]['question'])));
		for ($j=1;$j<5;$j++)
			$tab_question[$i]['reponse' . $j] = htmlentities(stripslashes(preg_replace('/\:(([a-z0-9]:)?)' . $tab_question[$i]['bbcode_uid'] . '/s', '', $tab_question[$i]['reponse' . $j])));
	}
}

/**
 * Suppression de l'illustration
 *
 * @param $concours_id Identifiant du concours
 */

function supp_illu($concours_id)
{
	global $phpbb_root_path;
	if (!isset($concours_id) || (int)$concours_id == 0)
	{
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id dans supp_illu');
	}
		
	$val_concours = select_concours($concours_id,true);
	
	$img = $phpbb_root_path . 'images/more/concours_' . $concours_id;
	$ext = find_image($img);
	
	if ($ext)
	{
		logger("Illustration du concours \"" . $val_concours['title'] . "\" supprimée");
		return unlink($img . '.' . $ext);
	}
	else
	{
		return false;
	}
}

/**
 * Suppression des participations à une question
 *
 * @param $question_id Identifiant de la question
 */
function supp_question($question_id)
{
	global $phpbb_root_path;
	if (!isset($question_id) || (int)$question_id == 0)
	{
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id dans supp_illu');
	}
	
	$val_question = select_element("SELECT question FROM concours_questions WHERE question_id = '$question_id'");
	
	$sql = "DELETE FROM concours_questions WHERE question_id = '$question_id'";
	mysql_query($sql) or message_die(CRITICAL_ERROR,"Erreur Interne<br />" . $sql . "<br />" . mysql_error());
	
	logger("Question du concours \"" . $val_question['question'] . "\" supprimée du concours " . $val_question['concours_id']);
}

if ($_GET['mode'] == 'add_winner')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	$str_exclude = '';
	for ($i=0;$i<count($tab_winner);$i++)
	{
		$str_exclude .= " AND user_id <> '" . $tab_winner[$i]['user_id'] . "'";
	}
	
	if (!isset($_POST['username']) || $_POST['username'] =='')
	{
		$val_winner = select_element("SELECT * FROM concours_participation WHERE concours_id = '$concours_id' AND win = 'Y' $str_exclude ORDER BY RAND()",false,'');
		if (!$val_winner)
		{
			list($error,$error_msg) = array(true,$lang['no_possible_winner']);
		}
	} else
	{
		$username = $_POST['username'];
		$val_doublon = select_element("SELECT * FROM concours_winners WHERE concours_id = '$concours_id' AND username = '$username'",false,'');
		if ($val_doublon)
		{
			list($error,$error_msg) = array(true,sprintf($lang['already_winner'],$username));
		} else
		{
			$val_winner = select_element("SELECT * FROM phpbb_users WHERE username = '$username'",false,'');
			if (!$val_winner)
			{
				list($error,$error_msg) = array(true,$lang['No_user_id_specified']);
			}
		}
	}
	
	if (!$error)
	{
		$sql = "INSERT INTO concours_winners (concours_id, username, user_id)
			VALUES ('$concours_id','" . $val_winner['username'] . "','" . $val_winner['user_id'] . "')";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout d'un gagnant au concours<br />$sql<br />". mysql_error());
		
		$return_url = $phpbb_root_path . "more/edit_concours.php?mode=edit&concours_id=" . $concours_id;
		
		$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
			);
		$message .=  '<br /><br />' . sprintf($lang['Add_winner_ok'], '<a href="' . append_sid($return_url) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		$_GET['mode'] = 'edit';
	}
}

if ($_GET['mode'] == 'reset')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	reset_participation($concours_id);
	
	$return_url = $phpbb_root_path . "more/edit_concours.php?mode=edit&concours_id=" . $concours_id;
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
		);
	$message .=  '<br /><br />' . sprintf($lang['Reset_concours_ok'], '<a href="' . append_sid($return_url) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mode'] == 'supp')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	supp_concours($concours_id);
	
	$return_url = $phpbb_root_path . "more/concours." . $phpEx;
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
		);
	$message .=  '<br /><br />' . sprintf($lang['supp_concours_ok'], '<a href="' . append_sid($return_url) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mode'] == 'supp_illu')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	supp_illu($concours_id);
	
	$return_url = $phpbb_root_path . "more/concours." . $phpEx;
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
		);
	$message .=  '<br /><br />' . sprintf($lang['supp_illu_concours_ok'], '<a href="' . append_sid($return_url) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mode'] == 'supp_question')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	if (!isset($_GET['question_id']) || (int)$_GET['question_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable question_id');
	$question_id = (int)$_GET['question_id'];
	
	if ($already_played)
		list($error,$error_msg) = array(true,$lang['concours_already_played']);
		
	if (!$error)
	{
		supp_question($question_id);
		
		$return_url = $phpbb_root_path . 'more/edit_concours.php?mode=edit&amp;concours_id=' . $concours_id;
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Supp_question_ok'], '<a href="' . append_sid($return_url) . '">', '</a>') . $message_img;
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		$_GET['mode'] = 'edit';
	}
}

if ($_GET['mode'] == 'add_question')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	if (!isset($_POST['correct']) || (int)$_POST['correct'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable correct');
	$correct = (int)$_POST['correct'];
	if ($correct < 1 || $correct > 4)
		message_die(GENERAL_MESSAGE,'variable correct incorrecte');
	
	if ($already_played)
		list($error,$error_msg) = array(true,$lang['concours_already_played']);
	
	if (!isset($_POST['question']) || $_POST['question'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['concours_question']));
	
	// Génération de la clef bbcode
	$bbcode_uid = make_bbcode_uid();
	
	$question = bbencode_first_pass($_POST['question'], $bbcode_uid);
		
	for ($i=1;$i<5;$i++)
	{
		if (!isset($_POST['reponse' . $i]) || $_POST['reponse' . $i] == '')
			list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],sprintf($lang['Reponse_x'],$i)));
			
		${'reponse' . $i} = bbencode_first_pass($_POST['reponse'.$i], $bbcode_uid);
	}
	
	if (!$error)
	{
		$sql = "INSERT INTO `concours_questions` (`concours_id`, `question`, 
							`reponse1`, `reponse2`, `reponse3`, `reponse4`, `correct`, `bbcode_uid`)
			VALUES ('$concours_id', '$question', '$reponse1', '$reponse2', '$reponse3', '$reponse4', '$correct', '$bbcode_uid')";
			
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout d'une question au concours<br />$sql<br />". mysql_error());
		$question_id = mysql_insert_id();
		logger("Ajout de la question \"$question\" ($question_id) dans le concours $concours_id");
		
		$return_url = $phpbb_root_path . 'more/edit_concours.php?mode=edit&amp;concours_id=' . $concours_id;
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Add_question_ok'], '<a href="' . append_sid($return_url) . '">', '</a>') . $message_img;
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		for ($i=1;$i<5;$i++)
			${'check_reponse'.$i} = ($correct == $i) ? ' CHECKED' : '';
			
		$_GET['mode'] = 'edit';
	}
}

if ($_GET['mode'] == 'edit_question')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	if (!isset($_GET['question_id']) || (int)$_GET['question_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable question_id');
	$question_id = (int)$_GET['question_id'];
	
	if (!isset($_POST['question' . $question_id]) || $_POST['question' . $question_id] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['concours_question']));
	
	// Génération de la clef bbcode
	$bbcode_uid = make_bbcode_uid();
	
	$edit_question = bbencode_first_pass($_POST['question' . $question_id], $bbcode_uid);
		
	for ($i=1;$i<5;$i++)
	{
		if (!isset($_POST['reponse' . $question_id . $i]) || $_POST['reponse' . $question_id . $i] == '')
			list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],sprintf($lang['Reponse_x'],$i)));
			
		${'edit_reponse' . $i} = bbencode_first_pass($_POST['reponse' . $question_id.$i], $bbcode_uid);
	}
	
	if (!$error)
	{
		$sql = "UPDATE `concours_questions`
			SET 
				`question` = '$edit_question',
				`reponse1` = '$edit_reponse1',
				`reponse2` = '$edit_reponse2',
				`reponse3` = '$edit_reponse3',
				`reponse4` = '$edit_reponse4',
				`bbcode_uid` = '$bbcode_uid'
			WHERE `question_id` = '$question_id'";
			
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'édition d'une question au concours<br />$sql<br />". mysql_error());
		$question_id = mysql_insert_id();
		logger("Edition de la question \"$edit_question\" ($question_id) dans le concours $concours_id");
		
		$return_url = $phpbb_root_path . 'more/edit_concours.php?mode=edit&amp;concours_id=' . $concours_id;
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Edit_question_ok'], '<a href="' . append_sid($return_url) . '">', '</a>') . $message_img;
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		$val_question = array(
					'question_id' => $question_id,
					'question' => $edit_question,
					'reponse1' => $edit_reponse1,
					'reponse2' => $edit_reponse2,
					'reponse3' => $edit_reponse3,
					'reponse4' => $edit_reponse4,
					'bbcode_uid' => $bbcode_uid,
					);
		$_GET['mode'] = 'edit';
	}
}

if ($_GET['mode'] == 'edit')
{
	if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
		message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
	$concours_id = (int)$_GET['concours_id'];
	
	// Selection de l'enregistrement
	$val_concours = select_concours($concours_id,true);
	
	// Sélection des informations
	$title = $val_concours['title'];
	$description = $val_concours['description'];
	$chapeau = $val_concours['chapeau'];
	$reglement = $val_concours['reglement'];
	$bbcode_uid = $val_concours['bbcode_uid'];
	$date_begin = $val_concours['date_begin'];
	$date_end = $val_concours['date_end'];
	
	if (strlen($check_reponse1.$check_reponse2.$check_reponse3.$check_reponse4) == 0)
		$check_reponse1 = " CHECKED";
		
	$tab_question = select_liste("SELECT * FROM `concours_questions` WHERE `concours_id` = '$concours_id'");
	if (isset($val_question))
	{
		for ($i=0;$i<count($tab_question);$i++)
		{
			if ($tab_question[$i]['question_id'] == $question_id)
			{
				$edit_correct = $tab_question[$i]['correct'];
				$tab_question[$i] = $val_question;
				$tab_question[$i]['correct'] = $edit_correct;
				break;
			}
		}
	}
}

if ($_GET['mode'] == 'add')
{
	$date_begin = mktime ( 12, 0, 0, date('m'), date('d')+1, date('Y'));
	$date_end = mktime ( 12, 0, 0, date('m')+1, date('d')+1, date('Y'));
}

if ($_GET['mode'] == 'doedit' || $_GET['mode'] == 'doadd')
{
	// Vérification des champs obligatoires
	if (!isset($_POST['title']) || $_POST['title'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['title']));
		
	if (!isset($_POST['description']) || $_POST['description'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['description']));
		
	if (!isset($_POST['chapeau']) || $_POST['chapeau'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['chapeau']));
		
	if (!isset($_POST['reglement']) || $_POST['reglement'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Reglement']));
		
	if (!isset($_POST['date_begin']) || $_POST['date_begin'] == '' ||  !checkdate(substr($_POST['date_begin'],3,2),substr($_POST['date_begin'],0,2),substr($_POST['date_begin'],6,4)))
		list($error,$error_msg) = array(true,sprintf($lang['invalid_date'],$_POST['date_begin']));
		
	if (!isset($_POST['date_end']) || $_POST['date_end'] == '' ||  !checkdate(substr($_POST['date_end'],3,2),substr($_POST['date_end'],0,2),substr($_POST['date_end'],6,4)))
		list($error,$error_msg) = array(true,sprintf($lang['invalid_date'],$_POST['date_end']));
		
	if (!$error)
	{
		// Génération de la clef bbcode
		$bbcode_uid = make_bbcode_uid();
	
		// Enregistrement des informations
		$title = $_POST['title'];
		$description = bbencode_first_pass($_POST['description'], $bbcode_uid);
		$chapeau = bbencode_first_pass($_POST['chapeau'], $bbcode_uid);
		$reglement = bbencode_first_pass($_POST['reglement'], $bbcode_uid);
		$date_begin = mktime(0,0,0,substr($_POST['date_begin'],3,2),substr($_POST['date_begin'],0,2),substr($_POST['date_begin'],6,4));
		$date_end = mktime(0,0,0,substr($_POST['date_end'],3,2),substr($_POST['date_end'],0,2),substr($_POST['date_end'],6,4));
	}
	
}

if ($_GET['mode'] == 'doadd')
{
	if (!$error)
	{
		$illu =  ( $HTTP_POST_FILES['illu']['tmp_name'] != "none") ? $HTTP_POST_FILES['illu']['tmp_name'] : '' ;
		$filesize = array($site_config['jack_max_filesize'],$site_config['jack_max_width'],$site_config['jack_max_height']);
	
		$sql = "INSERT INTO `concours` (`title`,`description`,`chapeau`,`reglement`,`bbcode_uid`,`date_begin`,`date_end`)
			VALUES ('$title','$description','$chapeau','$reglement','$bbcode_uid','$date_begin','$date_end')";
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout du concours");
		$concours_id = mysql_insert_id();
		logger("Ajout du concours \"$title\" ($concours_id)");
		
		
	}
	if (!$error)
	{
		if ($illu != '')
		{
			$img_error = false;
			$img_error_msg = '';
			
			$url_img = $phpbb_root_path . 'images/more/concours_' . $concours_id;
			
			user_upload_easy($img_error,$img_error_msg,$HTTP_POST_FILES['illu'],$url_img,$filesize);
			$message_img = ($img_error) ? '<br />' . sprintf($lang['But_not_illu'],$img_error_msg) : '';
			
			if (!$img_error)
			{
				$ext = find_image($url_img);
				$sql = "INSERT INTO `more` (`title` , `description` , `cate_id` , `user_id` , `username` , `bbcode_uid` , `enable` , `date_add`)
					VALUES ('Goodies virtuel pour $title','$description','". CATE_ID_CONCOURS . "', '" . $userdata['user_id'] . "','" . $userdata['username'] . "','$bbcode_uid','Y','" . date('Ymd') . "')";
				mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant l'ajout du concours");
				$goodies_id = mysql_insert_id();
				$url_goodies = $phpbb_root_path . 'images/goodies/goodies_' . $goodies_id;
				logger("Ajout d'un goodies virtuel pour l'illustration du concours \"$title\" ($concours_id)");
				
				copy($url_img . '.' . $ext, $url_goodies . '.' . $ext);
			}
		}
		
		$return_url = $phpbb_root_path . 'more/edit_concours.php?mode=edit&amp;concours_id=' . $concours_id;
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($return_url) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Add_concours_ok'], stripslashes($title), '<a href="' . append_sid($return_url) . '">', '</a>') . $message_img;
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		$_GET['mode'] = 'add';
	}
}

if ($_GET['mode'] == 'doedit')
{
	if (!$error)
	{
		$illu =  ( $HTTP_POST_FILES['illu']['tmp_name'] != "none") ? $HTTP_POST_FILES['illu']['tmp_name'] : '' ;
		$filesize = array($site_config['jack_max_filesize'],$site_config['jack_max_width'],$site_config['jack_max_height']);
		
		// Formatage et traitement du formulaire d'édition
		if (!isset($_GET['concours_id']) || (int)$_GET['concours_id']==0)
			message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
		$concours_id = $_GET['concours_id'];
		
		$val_concours = select_concours($concours_id);
		
		$sql = "UPDATE `concours`
			SET
				`title` = '$title',
				`description` = '$description',
				`chapeau` = '$chapeau',
				`reglement` = '$reglement',
				`bbcode_uid` = '$bbcode_uid',
				`date_begin` = '$date_begin',
				`date_end` = '$date_end'
			WHERE
				concours_id = '$concours_id'";
		
		mysql_query($sql) or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la modification du titre " . stripslashes($title) . "<br />".mysql_error()."<br />".$sql);
		logger("Modification du titre " . stripslashes($title) . " ($concours_id)");
		
		
		if ($illu != '')
		{
			supp_illu($concours_id);
			$img_error = false;
			$img_error_msg = '';
			user_upload_easy($img_error,$img_error_msg,$HTTP_POST_FILES['illu'],$phpbb_root_path . 'images/more/concours_' . $concours_id,$filesize);
			$message_img = ($img_error) ? '<br />' . sprintf($lang['But_not_illu'],$img_error_msg) : '';
		}
		
		$return_url = $phpbb_root_path . 'more/concours.php';
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($return_url) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Edit_concours_ok'], stripslashes($title), '<a href="' . append_sid($return_url) . '">', '</a>') . $message_img;
		message_die(GENERAL_MESSAGE, $message);
	} else
	{
		$_GET['mode'] = 'edit';
	}
	
}

if ($_GET['mode'] == 'edit')
{
	concours_addslashes();
	
	$u_action = append_sid($phpbb_root_path . 'more/edit_concours.php?mode=doedit&concours_id=' . $concours_id);
	$l_action = $lang['Edit_concours'];
	$l_submit = $lang['Modifier'];
	
	$u_supp = append_sid($phpbb_root_path . 'more/edit_concours.php?mode=supp&concours_id=' . $concours_id);
	$l_confirm_supp = addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],$title)));
	$l_supp = sprintf(sprintf($lang['delete'],stripslashes($title)));
}

if ($_GET['mode'] == 'add')
{
	concours_addslashes();
	
	$u_action = append_sid($phpbb_root_path . 'more/edit_concours.php?mode=doadd');
	$l_action = $lang['Add_concours'];
	$l_submit = $lang['Ajouter'];
}

//Liste des concours
$tab_concours = select_liste("SELECT * FROM concours ORDER BY date_end");

// Illustration
$img = $phpbb_root_path . 'images/more/concours_' . $concours_id;
$ext = find_image($img);
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Concours'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/edit_concours.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
			'IMG_MASCOTTE' => $mascotte,
			'NOM_RUB' => $lang['EnPlusPlus'],
			"RESPONSABLES" => $lang['Responsables'],
			'TITLE' => htmlentities($title),
			'DATE_BEGIN' => $date_begin,
			'DATE_END' => $date_end,
			'DESCRIPTION' => $description,
			'CHAPEAU' => $chapeau,
			'REGLEMENT' => $reglement,
			
			"L_TITLE" => $lang['Concours'],
			'L_DATE_BEGIN' => $lang['date_begin'],
			'L_DATE_END' => $lang['date_end'],
			'L_DESCRIPTION' => $lang['Description'],
			'L_CHAPEAU' => $lang['chapeau'],
			'L_REGLEMENT' => $lang['Reglement'],
			"L_ACTION" => $l_action,
			"L_SUBMIT" => $l_submit,
			'L_ILLU' => ucfirst($lang['picture']),
			'L_PARTICIPANTS' => $lang['Participants'],
			'L_RETOUR'=> $lang['retour'],
			'L_WINNERS' => $lang['Gagnants'],
			'L_ADD_WINNER' => sprintf($lang['Ajout_de'],$lang['Gagnants']),
			'L_FIND_USERNAME' => $lang['Find_username'],
			'L_ADD' => $lang['Ajouter'],
			'L_ADD_RANDOM_WINNER' => $lang['Random_winner'],
			
			'U_RETOUR' => append_sid($phpbb_root_path . 'more/concours.php'),
			'U_ACTION' => $u_action,
			'U_SEARCH_USER' => append_sid($phpbb_root_path . 'forum/search.php?mode=searchuser'),
			)
);

if ($ext)
{
	$template->assign_block_vars('illu',array(
			"L_CURRENT_PICTURE" => $lang['Illustration_actuelle'],
			'IMG' => $phpbb_root_path . 'functions/miniature.php?mode=concours&concours_id=' . $val_concours['concours_id'] . '&ntH=112',
			'L_SUPP_ILLU' => $lang['supp_illustration'],
			'U_SUPP_ILLU' => append_sid($phpbb_root_path . 'more/edit_concours.php?mode=supp_illu&concours_id=' . $concours_id),
			'L_CONFIRM_SUPP_ILLU' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['picture_bio'])))),
			)
		);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
	$template->assign_block_vars('switch_mascotte',array(
					"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
					"L_MASCOTTE" =>  $lang['Change_mascotte'],
					)
				);
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

if ($_GET['mode']=='edit')
{
	$template->assign_block_vars('switch_edit',array(
			"U_SUPP" => $u_supp,
			'U_ACTION_ADD_QUESTION' => append_sid($phpbb_root_path . 'more/edit_concours.php?mode=add_question&amp;concours_id=' . $concours_id),
			'U_RESET' => append_sid($phpbb_root_path . 'more/edit_concours.php?mode=reset&amp;concours_id=' . $concours_id),
			'U_ADD_WINNER' => append_sid($phpbb_root_path . 'more/edit_concours.php?mode=add_winner&amp;concours_id=' . $concours_id),
			
			"L_SUPP" => $l_supp,
			"L_CONFIRM_SUPP" => $l_confirm_supp,
			'L_QCM' => $lang['QCM'],
			'L_ADD_QUESTION' => $lang['add_question'],
			'L_QUESTION' => $lang['concours_question'],
			'L_REPONSE1' => sprintf($lang['Reponse_x'],1),
			'L_REPONSE2' => sprintf($lang['Reponse_x'],2),
			'L_REPONSE3' => sprintf($lang['Reponse_x'],3),
			'L_REPONSE4' => sprintf($lang['Reponse_x'],4),
			'L_ADD' => $lang['Ajouter'],
			'L_MODIFIER' => $lang['Modifier'],
			'L_SUPP_QUESTION' => sprintf($lang['delete'],sprintf($lang['la'],strtolower($lang['concours_question']))),
			'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],strtolower($lang['concours_question']))))),
			'L_RESET' => $lang['Reset'],
			'L_CONFIRM_RESET' => addslashes(sprintf($lang['Confirm'],$lang['Reset'])),
			
			'CHECKED_REPONSE1' => $check_reponse1,
			'CHECKED_REPONSE2' => $check_reponse2,
			'CHECKED_REPONSE3' => $check_reponse3,
			'CHECKED_REPONSE4' => $check_reponse4,
			'QUESTION' => $question,
			'REPONSE1' => $reponse1,
			'REPONSE2' => $reponse2,
			'REPONSE3' => $reponse3,
			'REPONSE4' => $reponse4,
			
			));
}

for ($i=0;$i<count($tab_question);$i++)
{
	$template->assign_block_vars('switch_edit.question',array(
						'QUESTION' => $tab_question[$i]['question'],
						'REPONSE1' => $tab_question[$i]['reponse1'],
						'REPONSE2' => $tab_question[$i]['reponse2'],
						'REPONSE3' => $tab_question[$i]['reponse3'],
						'REPONSE4' => $tab_question[$i]['reponse4'],
						'I' => $tab_question[$i]['question_id'],
						'CORRECT' . $tab_question[$i]['correct'] => $lang['good_answer'],
						
						'U_ACTION' => append_sid($phpbb_root_path . 'more/edit_concours.php?mode=edit_question&amp;question_id=' . $tab_question[$i]['question_id'] . '&amp;concours_id=' . $concours_id),
						'U_SUPP' => append_sid($phpbb_root_path . 'more/edit_concours.php?mode=supp_question&amp;question_id=' . $tab_question[$i]['question_id'] . '&amp;concours_id=' . $concours_id),
						)
					);
}

$sql = "SELECT reponse FROM concours_reponses WHERE participation_id = '%s' AND question_id = '%s' AND reponse = '%s'";
for ($i=0;$i<count($tab_participation);$i++)
{
	$val_user = select_element("SELECT username FROM phpbb_users WHERE user_id = '" . $tab_participation[$i]['user_id'] . "'",false,'');
	$username = ($val_user) ? $val_user['username'] : $tab_participation[$i]['username'];
	
	/*$win = true;
	for ($j=0;$j<count($tab_question) && $win ;$j++)
	{
		$win = (select_element(sprintf($sql,$tab_participation[$i]['participation_id'], $tab_question[$j]['question_id'], $tab_question[$j]['correct']), false,''));
	}*/
	
	$template->assign_block_vars('participant',array(
					'U_PROFIL' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&amp;u=' . $tab_participation[$i]['user_id']),
					
					'USERNAME' => $username,
					'COLOR' => ($tab_participation[$i]['win'] == 'Y') ? '#009900' : '#FF0000',
					)
				);
}

for ($i=0;$i<count($tab_winner);$i++)
{
	$val_user = select_element("SELECT username FROM phpbb_users WHERE user_id = '" . $tab_winner[$i]['user_id'] . "'",false,'');
	$username = ($val_user) ? $val_user['username'] : $tab_winner[$i]['username'];
	
	$template->assign_block_vars('switch_edit.winner',array(
					'U_PROFIL' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&amp;u=' . $tab_winner[$i]['user_id']),
					
					'USERNAME' => $username,
					)
				);
}

for ($i=0;$i<count($tab_cate);$i++)
{
	$url = $phpbb_root_path . 'more/';
	$url .= ($tab_cate[$i]['filename'] == '') ? 'view_cate.php?cate_id='.$tab_cate[$i]['cate_id'] : $tab_cate[$i]['filename'];
	$template->assign_block_vars('switch_cate',array(
						'U_CATE' => append_sid($url),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('more','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );

$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

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

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>