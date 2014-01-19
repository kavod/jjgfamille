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
	$module['Users']['Logger'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'forum/extension.inc');
require_once($phpbb_root_path . 'functions/functions.php');
require('./pagestart.' . $phpEx);

if (isset($_POST['msg']) && $_POST['msg'] != '')
{
	logger(stripslashes($_POST['msg']));
	
	$message = $lang['Logged_action'] . "<br /><br />" . sprintf($lang['Click_return_logger'], "<a href=\"" . append_sid("admin_logger.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}

//
// Show the default page
//
$template->set_filenames(array(
	"body" => "admin/logger.tpl")
);


$template->assign_vars(array(
	"L_LOGGER_TITLE" => $lang['logger'],
	"L_LOGGER_TEXT" => $lang['logger_explain'],
	"L_ACTION" => $lang['Action'],
	"L_MESSAGE" => $lang['Message'],
	"L_SEND_MSG" => $lang['Submit'],
	
	"S_ACTION" => append_sid($phpbb_root_path . "admin/admin_logger.$phpEx"))
);


$template->pparse("body");

include('./page_footer_admin.'.$phpEx);
?>
