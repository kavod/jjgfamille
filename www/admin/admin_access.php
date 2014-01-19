<?php
/***************************************************************************
 *                              admin_ranks.php
 *                            -------------------
 *   begin                : Friday, Jan 7, 2005
 *   copyright            : (C) 2005 Boris Kavod
 *
 *   $Id$
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

define('IN_PHPBB', 1);
define('WEBSITE_POSITION','website');

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Users']['Access'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'forum/extension.inc');
require_once($phpbb_root_path . 'functions/functions.php');
require('./pagestart.' . $phpEx);

if ($_POST['mode'] == 'add')
{
	if (!isset($_POST['user_id']) || (int)$_POST['user_id'] == 0)
		message_die(GENERAL_MESSAGE, 'erreur de transmission de user_id');
	$user_id = $_POST['user_id'];
	
	if (!isset($_POST['droit']) || $_POST['droit'] == '')
		message_die(GENERAL_MESSAGE, 'erreur de transmission de droit');
	$droit = $_POST['droit'];
	
	$sql = "INSERT INTO famille_access (user_id,rub) VALUES ('" . $user_id . "','" . $droit . "')";
	mysql_query($sql) or message_die(CRITICAL_ERROR, 'Erreur Interne<br />' . mysql_error());
	
	$message = $lang['Droit_ajoute'] . "<br /><br />" . sprintf($lang['Click_return_access'], "<a href=\"" . append_sid("admin_access.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mode'] == 'supp')
{
	if (!isset($_GET['user_id']) || (int)$_GET['user_id'] == 0)
		message_die(GENERAL_MESSAGE, 'erreur de transmission de user_id');
	$user_id = $_GET['user_id'];
	
	if (!isset($_GET['droit']) || $_GET['droit'] == '')
		message_die(GENERAL_MESSAGE, 'erreur de transmission de droit');
	$droit = $_GET['droit'];
	
	$sql = "DELETE FROM famille_access WHERE user_id='" . $user_id . "' AND rub = '" . $droit . "'";
	mysql_query($sql) or message_die(CRITICAL_ERROR, 'Erreur Interne<br />' . mysql_error());
	
	$message = $lang['Droit_supp'] . "<br /><br />" . sprintf($lang['Click_return_access'], "<a href=\"" . append_sid("admin_access.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}
//
// Show the default page
//
$template->set_filenames(array(
	"body" => "admin/access.tpl")
);

$sql = "SELECT acces.*, utilisateur.username FROM famille_access acces, " . USERS_TABLE . " utilisateur
	WHERE acces.user_id = utilisateur.user_id 
	ORDER BY username ASC";
if( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Couldn't obtain ranks data", "", __LINE__, __FILE__, $sql);
}
$access_count = $db->sql_numrows($result);

$access_rows = $db->sql_fetchrowset($result);

$sql = "SELECT users.username, users.user_id FROM " . USER_GROUP_TABLE . " groups, " . USERS_TABLE . " users 
	WHERE groups.user_id = users.user_id AND groups.group_id = 10
	ORDER BY username";
if( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Couldn't obtain ranks data", "", __LINE__, __FILE__, $sql);
}

$tab_users = $db->sql_fetchrowset($result);

while(list($key,$val) = each($tab_users))
{
	$template->assign_block_vars("users", array(
		"USERNAME" => $val['username'],
		"USER_ID" => $val['user_id']
		)
	);
}

$template->assign_vars(array(
	"L_ACCESS_TITLE" => $lang['Access'],
	"L_ACCESS_TEXT" => $lang['Access_explain'],
	"L_USERNAME" => $lang['Username'],
	"L_PERMISSION" => $lang['Permission'],
	"L_DELETE" => $lang['Delete'],
	"L_ADD_PERMISSION" => $lang['Add_permission'],
	"L_ACTION" => $lang['Action'],
	
	"S_ACTION" => append_sid($phpbb_root_path . "admin/admin_access.$phpEx?mode=add"))
);

for($i = 0; $i < $access_count; $i++)
{

	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	
	$template->assign_block_vars("permission", array(
		"ROW_COLOR" => "#" . $row_color,
		"ROW_CLASS" => $row_class,
		"USERNAME" => $access_rows[$i]['username'],
		"PERMISSION" => $access_rows[$i]['rub'],

		"U_PERMISSION_DEL" => append_sid("admin_access.$phpEx?mode=supp&amp;user_id=" . $access_rows[$i]['user_id'] . "&amp;droit=" . $access_rows[$i]['rub']))
	);
}


$template->pparse("body");

include('./page_footer_admin.'.$phpEx);
?>
