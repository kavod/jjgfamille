<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'actu';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ACTU);
init_userprefs($userdata);
//
// End session management
//

$error = false;
$error_msg = '';

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_actu'],'actu');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('edito'));

// Vérification des permissions
$job = array('maj');
require_once($phpbb_root_path . 'includes/reserved_access.php');

if ($_GET['mode'] == 'supp')
{
	if (!isset($_GET['maj_id']) || $_GET['maj_id'] == '')
		message_die(GENERAL_MESSAGE,'Variable maj_id vide');
	else $maj_id = $_GET['maj_id'];
	
	$sql = "DELETE FROM famille_maj WHERE maj_id = '" . $maj_id . "'";
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur Interne<br />' . mysql_error());
	logger('Suppression de la mise à jour ' . $maj_id);
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/maj." . $phpEx) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Supp_maj_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/maj." . $phpEx) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mode'] == 'edit')
{
	if (!isset($_GET['maj_id']) || $_GET['maj_id'] == '')
		message_die(GENERAL_MESSAGE,'Variable maj_id vide');
	else $maj_id = $_GET['maj_id'];

	$val_maj = select_element("SELECT * FROM famille_maj WHERE maj_id = '" . $maj_id . "'",true,'Mise à jour introuvable');
	
	$texte = htmlentities(str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_maj['bbcode_uid'] . '/s', '', $val_maj['maj'])));
	$title = $val_maj['title'];
	//$date = mktime(12,0,0,substr($val_maj['date_hot'],4,2),substr($val_maj['date_hot'],6,2),substr($val_maj['date_hot'],0,4));
	$date_hot = date('d/m/Y',$val_maj['date_hot_unix']);
	$champs_url = $val_maj['url'];
}

if ($_GET['mode'] == 'doedit' || $_GET['mode'] == 'doadd')
{
	if ($_GET['mode'] == 'doedit' && (!isset($_GET['maj_id']) || $_GET['maj_id'] == ''))
		message_die(GENERAL_MESSAGE,'Variable maj_id vide');
	else $maj_id = $_GET['maj_id'];
	
	if (!isset($_POST['title']) || $_POST['title'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['l_titre']));
	else $title = $_POST['title'];
	
	if (!isset($_POST['maj']) || $_POST['maj'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['contenu_periode']));
	else $texte = $_POST['maj'];
	
	if (!$error && (!isset($_POST['date_hot']) || $_POST['date_hot'] == ''))
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Expiration']));
	else $date_hot = $_POST['date_hot'];
	
	if (!isset($_POST['champs_url']) || $_POST['champs_url'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['url']));
	else $champs_url = $_POST['champs_url'];
	
	if (!$error && !checkdate(substr($date_hot,3,2),substr($date_hot,0,2),substr($date_hot,6,4)))
		list($error,$error_msg) = array(true,sprintf($lang['invalid_date'],$date_hot));
	else $date_bdd = date('U',mktime(0,0,0,substr($date_hot,3,2),substr($date_hot,0,2),substr($date_hot,6,4)));
	
	if (!$error)
	{
		$bbcode_uid = make_bbcode_uid();
		$maj_bb = bbencode_first_pass($texte, $bbcode_uid);
		
		if ($_GET['mode'] == 'doedit')
		{
			$sql = "UPDATE famille_maj SET title = '$title', maj = '$maj_bb', url = '$champs_url', date_hot_unix = '$date_bdd', bbcode_uid = '$bbcode_uid' WHERE maj_id = '$maj_id'";
			$log = 'Modification de la mise à jour ' . $title . '(' . $maj_id . ')';
		} else
		{
			$sql = "INSERT INTO famille_maj (date_unix,user_id,username,title,maj,artist_id,url,bbcode_uid,date_hot_unix) 
				VALUES ('" . date('U') . "','" . $userdata['user_id'] . "','" . $userdata['username'] . "','$title','$maj_bb',1,'$champs_url','$bbcode_uid','$date_bdd')";
			$log = 'Ajout de la mise à jour ' . $title . '(' . $maj_id . ')';
		}
		mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		logger($log);
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/maj." . $phpEx . '?maj_id=' . $maj_id) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Change_maj_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/maj." . $phpEx . '?maj_id=' . $maj_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} else $_GET['mode'] = substr($_GET['mode'],2);
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/actu/edit_maj.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/actu/actu_colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}

$template->assign_vars($rubrikopif[0]);


// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'jjg/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ($_GET['mode'] == 'edit')
{
	$template->assign_vars(array(
				'TITLE_VALUE' => htmlentities($title),
				'TEXTE_VALUE' => $texte,
				'HOT_VALUE' => $date_hot,
				'URL_VALUE' => $champs_url,
				'ACTION' => $lang['Edit_maj'],
				
				'U_ACTION' => append_sid($phpbb_root_path . 'actu/edit_maj.php?mode=doedit&maj_id=' . $maj_id),
				'L_SUBMIT' => $lang['Modifier'],
				'L_SUPP' => $lang['Supprimer_maj'],
				'L_CONFIRM_SUPP' => str_replace("'","\'",$lang['confirm_supp_maj']),
				'U_SUPP' => append_sid($phpbb_root_path . 'actu/edit_maj.php?mode=supp&maj_id=' . $maj_id),
				
				));
}

if ($_GET['mode'] == 'add')
{
	$template->assign_vars(array(
				'TITLE_VALUE' => htmlentities($title),
				'TEXTE_VALUE' => $texte,
				'HOT_VALUE' => $date_hot,
				'URL_VALUE' => $champs_url,
				'ACTION' => $lang['Add_maj'],
				
				'U_ACTION' => append_sid($phpbb_root_path . 'actu/edit_maj.php?mode=doadd'),
				'L_SUBMIT' => $lang['Ajouter'],
				
				));
}


$template->assign_vars(array(
				'NOM_RUB' => $lang['MaJ'],
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.php'),
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.php'),
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.php'),
								
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_TITLE' => $lang['l_titre'],
				'L_EXPIRATION' => $lang['Expiration'],
				'L_TEXTE' => $lang['contenu_periode'],
				'L_HOT_EXPLAIN' => $lang['Hot_explain'],
				'L_URL' => $lang['champs_url'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'actu/maj.php'),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['Actualite'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.php'),
				'L_RDN' => $lang['Revues du Net'],
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_ADMIN_MASCOTTE" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php'),
						"L_ADMIN_MASCOTTE" =>  $lang['Change_mascotte'],
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