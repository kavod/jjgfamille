<?php
/***************************************************************************
 *                              page_tail.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: page_tail.php,v 1.27.2.3 2004/12/22 02:04:00 psotfx Exp $
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// Notification des mises à jours
$filename = $phpbb_root_path . 'logs/' . date('Ymd',mktime(12,0,0,date('m'),date('d')-1)) . '.txt';

if (is_file($filename))
{
	@rename($filename,$filename . '_done');
	$filename .= '_done';
	$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
	$script_name = ( $script_name != '' ) ? $script_name . '/privmsg.'.$phpEx : 'privmsg.'.$phpEx;
	$server_name = trim($board_config['server_name']);
	$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
	$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
	
	include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);

	$fd = fopen($filename,"r");
	$contents = fread($fd,filesize($filename));
	
	$sql = "SELECT DISTINCT user. *
		FROM phpbb_users user
		LEFT JOIN famille_access access ON user.user_id = access.user_id
		WHERE access.rub = 'maj' OR user.user_level = '1'";
	$result = mysql_query($sql);
	while ($val = mysql_fetch_array($result))
	{
		$emailer = new emailer($board_config['smtp_delivery']);
			
		$emailer->from($board_config['board_email']);
		$emailer->replyto($board_config['board_email']);
		
		$emailer->use_template('maj_notification', $to_userdata['user_lang']);
		$emailer->email_address($val['user_email']);
		$emailer->set_subject('Mises à jour de la veille');
			
		$emailer->assign_vars(array(
			'LOGS' => "Bonjour à tous ;)\r\n" .$contents
		));
		
		$emailer->send();
		$emailer->reset();
	}
	fclose($fd);
}

global $do_gzip_compress;
//
// Show the overall footer.
//

//$admin_url = append_sid($phpbb_root_path . 'admin/index.' . $phpEx);

//$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<a href="' . $admin_url . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';

$template->set_filenames(array(
	'overall_footer' => ( empty($gen_simple_header) ) ? 'overall_footer.tpl' : 'simple_footer.tpl')
);

$template->assign_vars(array(
	//'TRANSLATION_INFO' => ( isset($lang['TRANSLATION_INFO']) ) ? $lang['TRANSLATION_INFO'] : '',
	'TRANSLATION_INFO' => (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] : ((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : ''),
	'ADMIN_LINK' => $admin_link)
);

$template->pparse('overall_footer');
$DOCUMENT_ROOT = '../';

//
// Close our DB connection.
//
$db->sql_close();
// Start Search Engine Friendly URLs with title mod
if ( !$userdata['session_logged_in'] )
{
	$contents = ob_get_contents(); 
	ob_end_clean(); 
	echo rewrite_urls($contents); 
	global $dbg_starttime;
}
// End Search Engine Friendly URLs with title mod
/*$contents = ob_get_contents();
ob_end_clean();
echo replace_mod_rewrite($contents);
global $dbg_starttime;
*/
//
// Compress buffered output if required and send to browser
//
if ( $do_gzip_compress )
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();
 	// Start Search Engine Friendly URLs with Title mod
	if ( !$userdata['session_logged_in'] )
	{
		echo rewrite_urls($contents); 
		global $dbg_starttime;
	}
	// End Search Engine Friendly URLs with Title mod
   /*echo replace_mod_rewrite($contents);
   global $dbg_starttime;*/

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}

exit;

?>