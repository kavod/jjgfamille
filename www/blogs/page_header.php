<?php
/***************************************************************************
 *                              page_header.php
 *                            -------------------
 *   begin                : Sunday, Sept 3, 2006
 *   copyright            : (C) 2006 Kavod
 *   email                : 
 *
 *   $Id: page_header.php,v 1.106.2.24 2005/03/26 14:15:59 acydburn Exp $
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

if (!defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

define('HEADER_INC', TRUE);

require_once($phpbb_root_path . 'functions/link.php');

//
// gzip_compression
//
$do_gzip_compress = FALSE;
if ( $board_config['gzip_compress'] )
{
	$phpver = phpversion();

	$useragent = (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			ob_start('ob_gzhandler');
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);

				header('Content-Encoding: gzip');
			}
		}
	}
}

// Start Search Engine Friendly URLs with title mod
if ( !$userdata['session_logged_in'] )
{
	ob_start(); 
	function rewrite_urls($content) 
	{ 
	    $urlin = array(
		// 0 : index
		"'forum/index.php'",
		// 1 : forum + day + start
		"'viewforum.php\?f=([0-9]*)&amp;topicdays=([0-9]*)&amp;start=([0-9]*)&amp;url_title=([a-z0-9_\-]*)'",
		// 1-1 : forum + start
		"'viewforum.php\?f=([0-9]*)&amp;start=([0-6]*)&amp;url_title=([a-z0-9_\-]*)'",
		// 2 : forum
		"'viewforum.php\?f=([0-9]*)&amp;url_title=([a-z0-9_\-]*)'",
		// 3 : topic + day + order + start
		"'viewtopic.php\?t=([0-9]*)&amp;postdays=([0-9]*)&amp;postorder=([a-zA-Z]*)&amp;start=([0-9]*)&amp;url_title=([a-z0-9_\-]*)'",
		// 4 : topic + start
		"'viewtopic.php\?t=([0-9]*)&amp;start=([0-9]*)&amp;url_title=([a-z0-9_\-]*)'",
		// 5 : topic
		"'viewtopic.php\?t=([0-9]*)&amp;url_title=([a-z0-9_\-]*)'");
		
		$urlout = array(
		// 0 : index
		"forum/",
		// 1 : forum + day + start
		"f\\1_\\2_\\3-\\4.html",
		// 1-1 : forum + start
		"f\\1_\\2-\\3.html",
		// 2 : forum
		"f\\1_0_0-\\2.html",   
		// 3 : topic + day + order + start
		"\\1_\\2_\\3_\\4-\\5.html",
		// 4 : topic + start
		"\\1_\\2-\\3.html",
		// 5 : topic
		"\\1_0-\\2.html");
	
	   $content = preg_replace($urlin, $urlout, $content); 
	   return $content; 
	}
}

//
// Parse and show the overall header.
//
$template->set_filenames(array(
	'overall_header' => 'blogs/header_css.tpl'
	));
	
//
// Obtain number of new private messages
// if user is logged in
//
if ( ($userdata['session_logged_in']) && (empty($gen_simple_header)) )
{
	if ( $userdata['user_new_privmsg'] )
	{
		$l_message_new = ( $userdata['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
		$l_privmsgs_text = sprintf($l_message_new, $userdata['user_new_privmsg']);
		
		if ( $userdata['user_last_privmsg'] > $userdata['user_lastvisit'] )
		{
			$sql = "UPDATE " . USERS_TABLE . "
				SET user_last_privmsg = " . $userdata['user_lastvisit'] . "
				WHERE user_id = " . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
			}

			$s_privmsg_new = 1;
			$icon_pm = $images['pm_new_msg'];
		}
		else
		{
			$s_privmsg_new = 0;
			$icon_pm = $images['pm_new_msg'];
		}
	}
	else
	{
		$l_privmsgs_text = $lang['No_new_pm'];

		$s_privmsg_new = 0;
		$icon_pm = $images['pm_no_new_msg'];
	}

	if ( $userdata['user_unread_privmsg'] )
	{
		$l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
		$l_privmsgs_text_unread = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
	}
	else
	{
		$l_privmsgs_text_unread = $lang['No_unread_pm'];
	}
}
else
{
	$icon_pm = $images['pm_no_new_msg'];
	$l_privmsgs_text = $lang['Login_check_pm'];
	$l_privmsgs_text_unread = '';
	$s_privmsg_new = 0;
}

//
// Generate HTML required for Mozilla Navigation bar
//
if (!isset($nav_links))
{
	$nav_links = array();
}

$nav_links_html = '';
$nav_link_proto = '<link rel="%s" href="%s" title="%s" />' . "\n";
while( list($nav_item, $nav_array) = @each($nav_links) )
{
	if ( !empty($nav_array['url']) )
	{
		$nav_links_html .= sprintf($nav_link_proto, $nav_item, append_sid($nav_array['url']), $nav_array['title']);
	}
	else
	{
		// We have a nested array, used for items like <link rel='chapter'> that can occur more than once.
		while( list(,$nested_array) = each($nav_array) )
		{
			$nav_links_html .= sprintf($nav_link_proto, $nav_item, $nested_array['url'], $nested_array['title']);
		}
	}
}

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $board_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($board_config['board_timezone'])];

// Admin link
$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<span class="copyright"><a href="' . $phpbb_root_path . 'admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a></span>' : '';

// Position 
$the_website =  (WEBSITE_POSITION == 'website') ? ' class="nav"><big>' . $lang['the_website'] . '</big>' : '>'. $lang['the_website'] ;
$the_website = '<a href="' . append_sid($phpbb_root_path . 'accueil/') . '"' . $the_website . '</a>';
$the_forum =  (WEBSITE_POSITION == 'forum') ? ' class="nav"><big>' . $lang['the_forum'] . '</big>' : '>' . $lang['the_forum'];$the_forum = '<a href="' . append_sid($phpbb_root_path . 'forum/') . '"' . $the_forum . '</a>';
$the_webchat =  (WEBSITE_POSITION == 'webchat') ? ' class="nav"><big>' . $lang['the_webchat'] . '</big>' : '>'. $lang['the_webchat'] ;
$the_webchat = '<a href="' . append_sid($phpbb_root_path .'chat/') . '"' . $the_webchat . '</a>';
$the_weblogs = (WEBSITE_POSITION == 'weblogs') ? ' class="nav"><big>' . $lang['the_weblogs'] . '</big>' : '>'. $lang['the_weblogs'] ;
$the_weblogs = '<a href="' . append_sid($phpbb_root_path .'blogs/') . '"' . $the_weblogs . '</a>';

// Blogs's title
if ($user_id > 0)
{
	$blog_title = $val_blog['title'];
	$blog_subtitle = $val_blog['subtitle'];
} else
{
	$blog_title = $lang['Blogs'];
	$blog_subtitle = $lang['Blogs_subtitle'];
}

//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//

$template->assign_vars(array(
	'META_DESC' => '<meta name="Keywords" content="' . $board_config['meta_keywords'] .'" /><meta name="Description" content="' . $board_config['meta_description'] .'" />',
	'PAGE_TITLE' => $page_title,
	'ADMIN_LINK' => $admin_link,
	'THE_WEBSITE' => $the_website,
	'THE_WEBCHAT' => $the_webchat,
	'THE_FORUM' => $the_forum,
	'THE_WEBLOGS' => $the_weblogs,
	'BLOG_TITLE' => $blog_title,
	'BLOG_SUBTITLE' => $blog_subtitle,
	'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
	'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
	'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
	
	'L_INDEX' => sprintf($lang['Blog_Index'], $board_config['sitename']),
	
	'U_PRIVATEMSGS' => append_sid($phpbb_root_path . 'forum/privmsg.'.$phpEx.'?folder=inbox'),
	'U_PRIVATEMSGS_POPUP' => append_sid($phpbb_root_path . 'forum/privmsg.'.$phpEx.'?mode=newpm'),
	'U_INDEX' => append_sid($phpbb_root_path . 'blogs/'),

	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => append_sid('login.'.$phpEx),
	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
	'T_BODY_BACKGROUND' => $theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$theme['body_text'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_VLINK' => '#'.$theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$theme['body_alink'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],
	'T_TR_COLOR1' => '#'.$theme['tr_color1'],
	'T_TR_COLOR2' => '#'.$theme['tr_color2'],
	'T_TR_COLOR3' => '#'.$theme['tr_color3'],
	'T_TR_CLASS1' => $theme['tr_class1'],
	'T_TR_CLASS2' => $theme['tr_class2'],
	'T_TR_CLASS3' => $theme['tr_class3'],
	'T_TH_COLOR1' => '#'.$theme['th_color1'],
	'T_TH_COLOR2' => '#'.$theme['th_color2'],
	'T_TH_COLOR3' => '#'.$theme['th_color3'],
	'T_TH_CLASS1' => $theme['th_class1'],
	'T_TH_CLASS2' => $theme['th_class2'],
	'T_TH_CLASS3' => $theme['th_class3'],
	'T_TD_COLOR1' => '#'.$theme['td_color1'],
	'T_TD_COLOR2' => '#'.$theme['td_color2'],
	'T_TD_COLOR3' => '#'.$theme['td_color3'],
	'T_TD_CLASS1' => $theme['td_class1'],
	'T_TD_CLASS2' => $theme['td_class2'],
	'T_TD_CLASS3' => $theme['td_class3'],
	'T_FONTFACE1' => $theme['fontface1'],
	'T_FONTFACE2' => $theme['fontface2'],
	'T_FONTFACE3' => $theme['fontface3'],
	'T_FONTSIZE1' => $theme['fontsize1'],
	'T_FONTSIZE2' => $theme['fontsize2'],
	'T_FONTSIZE3' => $theme['fontsize3'],
	'T_FONTCOLOR1' => '#'.$theme['fontcolor1'],
	'T_FONTCOLOR2' => '#'.$theme['fontcolor2'],
	'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],
	'T_SPAN_CLASS1' => $theme['span_class1'],
	'T_SPAN_CLASS2' => $theme['span_class2'],
	'T_SPAN_CLASS3' => $theme['span_class3'],
	'NAV_LINKS' => $nav_links_html));

//
// Login box?
//

if ( !$userdata['session_logged_in'] )
{
	//$template->assign_block_vars('switch_user_logged_out', array());
	//
	// Allow autologin?
	//
	if (!isset($board_config['allow_autologin']) || $board_config['allow_autologin'] )
	{
		$template->assign_block_vars('switch_allow_autologin', array());
		$template->assign_block_vars('switch_user_logged_out.switch_allow_autologin', array());
	}
}
else
{
	$template->assign_block_vars('switch_user_logged_in', array());
	if ( !empty($userdata['user_popup_pm']) )
	{
		$template->assign_block_vars('switch_enable_pm_popup', array());
	}
}

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';
// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting

if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');

$template->pparse('overall_header');

?>