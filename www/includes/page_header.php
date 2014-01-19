<?php
/***************************************************************************
 *                              page_header.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
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

if (!defined('IN_PHPBB') ) ////// ICI j'ai enlever le "!" devant define
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

//
// Parse and show the overall header.
//
$template->set_filenames(array(
	'overall_header' => ( empty($gen_simple_header) ) ? 'overall_header.tpl' : 'simple_header.tpl'));
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
// End Search Engine Friendly URLs with title mod
/*ob_start();
function replace_mod_rewrite($s)
{
   $urlin = array(
      "'(?<!/)viewforum.php\?f=([0-9]*)&amp;topicdays=([0-9]*)&amp;start=([0-9]*)'", 	//1
      "'(?<!/)viewforum.php\?f=([0-9]*)&amp;mark=topics'",				//2
      "'viewforum.php\?f=([0-9]*)'",						//3

      "'viewtopic.php\?t=([0-9]*)&amp;view=previous'",				//4
      "'viewtopic.php\?t=([0-9]*)&amp;view=next'",				//5
      "'(?<!/)viewtopic.php\?t=([0-9]*)&amp;view=newest'",				//6
"'(?<!/)viewtopic.php\?t=([0-9]*)&(?:amp;)watch=topic&(?:amp;)start=([0-9]*)'",		//7
"'(?<!/)viewtopic.php\?t=([0-9]*)&(?:amp;)unwatch=topic&(?:amp;)start=([0-9]*)'",	//8
      "'(?<!/)viewtopic.php\?t=([0-9]*)&amp;postdays=([0-9]*)&amp;postorder=([a-zA-Z]*)&amp;start=([0-9]*)'",     //9
      "'(?<!/)viewtopic.php\?t=([0-9]*)&amp;start=([0-9]*)&amp;postdays=([0-9]*)&amp;postorder=([a-zA-Z]*)&amp;highlight=([a-zA-Z0-9]*)'", //10
      "'viewtopic.php\?t=([0-9]*)&amp;start=([0-9]*)'",				//11
      "'(?<!/)viewtopic.php\?t=([0-9]*)&amp;highlight=([a-zA-Z0-9]*)'",			//12
      "'viewtopic\.php\?t=([0-9]*)&amp;postdays=([0-9]*)&amp;postorder=([a-zA-Z]*)&amp;&amp;start=([0-9]*)'", // 12bis
      "'viewtopic.php\?t=([0-9]*)&amp;title=([^\"]*)'",						//13bis
      "'(?<!/)viewtopic.php\?t=([0-9]*)'",						//13
      "'(?<!/)viewtopic.php\?p=([0-9]*)'",						//14
      "'admin/index\.php'",									//15bis
      "'forum/index\.php'");									//15

   $urlout = array(
      "viewforum\\1-\\2-\\3.html",							//1
      "mforum\\1.html",									//2
      "forum\\1.html",									//3

      "ptopic\\1.html",									//4
      "ntopic\\1.html",									//5
      "newtopic\\1.html",								//6
      "stopic\\1-\\2.html",								//7
      "utopic\\1-\\2.html",								//8
      "ftopic\\1-\\2-\\3-\\4.html",							//9
      "ftopic\\1-\\2-\\3-\\4-\\5.html",							//10
      "ftopic\\1-\\2.html",								//11
      "setopic_\\1-\\2.html",								//12
      "ftopic\\1-\\4-\\2-\\3.html",							// 12bis
      "ftopic\\1-\\2.html",								//13bis
      "ftopic\\1.html",									//13
      "sutra\\1.html",									//14
      "admin/index.php",									//15bis
      "forum/index.html");									//15

   $s = preg_replace($urlin, $urlout, $s);

   return $s;
}*/
//$url = append_sid($phpbb_root_path . substr($_SERVER['SCRIPT_FILENAME'],strpos($_SERVER['SCRIPT_FILENAME'],'htdocs')+7).'?'.$_SERVER['QUERY_STRING']);
$url = substr($phpbb_root_path,0,-1) . str_replace('&','&amp;',$_SERVER['REQUEST_URI']);$url_without_sid = preg_replace("/[&|&amp;]sid=[^&]*/","",$url);
$url_without_sid = preg_replace("/[?]sid=[^&]*&/","&",$url_without_sid);
$url_without_sid = preg_replace("/[?]sid=[^&]*/","",$url_without_sid);
$url = append_sid($url);

//
// Generate logged in/logged out status
//

if ( $userdata['session_logged_in'] )
{
	$u_login_logout = append_sid($phpbb_root_path . 'forum/login.'.$phpEx.'?redirect=' . $url_without_sid . '&amp;logout=true&amp;sid=' . $userdata['session_id']);
	//'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
	$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
}
else
{
	$u_login_logout = 'login.'.$phpEx;
	$l_login_logout = $lang['Login'];
}

$s_last_visit = ( $userdata['session_logged_in'] ) ? create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : '';

//
// Get basic (usernames + totals) online
// situation
//
$logged_visible_online = 0;
$logged_hidden_online = 0;
$guests_online = 0;
$online_userlist = '';
$l_online_users = '';
define('SHOW_ONLINE',true);
if (defined('SHOW_ONLINE'))
{
	$user_forum_sql = ( !empty($forum_id) ) ? "AND s.session_page = " . intval($forum_id) : '';
	$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_ip
		FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
		WHERE u.user_id = s.session_user_id
			AND s.session_time >= ".( time() - 300 ) . "
			$user_forum_sql
		ORDER BY u.username ASC, s.session_ip ASC";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);
	}

	$userlist_ary = array();
	$userlist_visible = array();

	$prev_user_id = 0;
	$prev_user_ip = $prev_session_ip = '';

//
// bot mod
//
$bots = array();
// inclusion du fichier contenant les infos sur les bots
$file = $phpbb_root_path . 'includes/bots.' . $phpEx;
@include($file);
// varaables nécessaires pour la prochaine boucle
// $REMOTE_ADDR = ip du visiteur (non encodée volontairement)
$usersessionid = $userdata['session_id'];

// Terrible boucle pour créer la liste de ips de tous les bots (associé à leur nom).
if (isset($bots))
{
	while (list($id, $bots_infos) = each ($bots))
	{
		if(is_array($bots_infos['ips'])) 
		{			
			while (list($key, $ip) = each ($bots_infos['ips']))
			{	
				if (eregi("#", $ip))
				{
					$point = strrpos($ip, ".");
					$ip = substr($ip, 0, $point);
				}
				$ips[ $ip ] = $bots_infos['name'];
			}
		}			
	}
}

$row_first = array();
// on prends les résultats de la requête.
while( $row = $db->sql_fetchrow($result) )
{
	$row_first[] = $row;
}

// La fonction qui va être utilisée pour reclasser le nouveau tableau des connectés.
function user_bots_sort($a, $b) 
{
	if (strtolower($a['username']) == strtolower($b['username'])) 
		return 0;
	return (strtolower($a['username']) > strtolower($b['username'])) ? 1 : -1;
}

// On modifie les username des sessions considérées comme des bots.
while(list($key, $val) = each ($row_first)) 
{		
		$this_session_ip = $val['session_ip'];
		$point_ip_session = strrpos(decode_ip($val['session_ip']), ".");
		$ip_tronquee_session = substr(decode_ip($val['session_ip']), 0, $point_ip_session);			
		if(isset($ips[ decode_ip($val['session_ip']) ]) && $this_session_ip != $prev_session_ip)
		{
			$row_first[$key]['username'] = $ips[ decode_ip($val['session_ip']) ];
			$row_first[$key]['session_bot'] = TRUE;			
		}
		elseif(isset($ips[ $ip_tronquee_session ]) && $this_session_ip != $prev_session_ip) 
		{
			$row_first[$key]['username'] = $ips[ $ip_tronquee_session ];
			$row_first[$key]['session_bot'] = TRUE;			
		}
		$prev_session_ip = $val['session_ip'];
}
// on reclasse tout ça par ordre alphabétique.
reset($row_first);
usort($row_first,"user_bots_sort");
reset($row_first);
// on initialise $i pour la prochaine boucle.
$i = 0; 

//
// Bot mod
//
	while( $row = $row_first[ $i ] )		
	{			
		// User is guest, but his ip is a bot one
		if ( $row['session_bot'] )
		{
			if ($board_config['bot_index_type'])
			{
				$bot_color_index = $board_config['bot_color'];
				$botname = "<span style=\"color: ". $bot_color_index ."\">" .$row['username'] ."</span>";
				$online_bots .= ( $online_bots != '' ) ? ', ' . $botname : "<br />".$lang['Registered_bot']. " " .$botname;
				$guests_online++;
			}
			else
			{
				$bot_color_index = $board_config['bot_color'];
				$botname = "<span style=\"color: ". $bot_color_index ."\">" .$row['username'] ."</span>";	
				$online_userlist .= ( $online_userlist != '' ) ? ', ' . $botname : $botname;			 
				$guests_online++;
			}
		}

      // User is logged in and therefor not a guest
		else if ( $row['session_logged_in'] )
		{
			// Skip multiple sessions for one user
			if ( $row['user_id'] != $prev_user_id )
			{
				$style_color = '';
				if ( $row['user_level'] == ADMIN )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
				}
				else if ( $row['user_level'] == MOD )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
				}

				if ( $row['user_allow_viewonline'] )
				{
					$user_online_link = '<a href="' . append_sid($phpbb_root_path . "forum/profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'>' . $row['username'] . '</a>';
					$logged_visible_online++;
				}
				else
				{
					$user_online_link = '<a href="' . append_sid($phpbb_root_path . "forum/profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $style_color .'><i>' . $row['username'] . '</i></a>';
					$logged_hidden_online++;
				}

				if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
				{
					$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
				}
			}

			$prev_user_id = $row['user_id'];
		}
		else
		{
			// Skip multiple sessions for one user
			if ( $row['session_ip'] != $prev_session_ip )
			{
				$guests_online++;
			}
		}

		$prev_session_ip = $row['session_ip'];
		$i ++;
	}
	$db->sql_freeresult($result);

	if ($board_config['bot_index_type'])
	{
		if ( empty($online_userlist) )
		{
			$online_userlist = $lang['None'];
		}
		if ( empty($online_bots) )
		{
			$online_bots = "<br />".$lang['Registered_bot']. " " .$lang['None'];
		}
	}
	else
	{
		if ( empty($online_userlist))
		{
			$online_userlist = $lang['None'];
		}
	}	
	$legend_bot = (!$board_config['bot_index_type']) ? sprintf($lang['Bot_online_color'], '[ <span style="color:' . $board_config['bot_color'] . '">', '</span> ]') : '';
	$online_userlist = ( ( isset($forum_id) ) ? $lang['Browsing_forum'] : $lang['Registered_users'] ) . ' ' . $online_userlist;

	$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

	if ( $total_online_users > $board_config['record_online_users'])
	{
		$board_config['record_online_users'] = $total_online_users;
		$board_config['record_online_date'] = time();

		$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$total_online_users'
			WHERE config_name = 'record_online_users'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update online user record (nr of users)', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '" . $board_config['record_online_date'] . "'
			WHERE config_name = 'record_online_date'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update online user record (date)', '', __LINE__, __FILE__, $sql);
		}
	}

	if ( $total_online_users == 0 )
	{
		$l_t_user_s = $lang['Online_users_zero_total'];
	}
	else if ( $total_online_users == 1 )
	{
		$l_t_user_s = $lang['Online_user_total'];
	}
	else
	{
		$l_t_user_s = $lang['Online_users_total'];
	}

	if ( $logged_visible_online == 0 )
	{
		$l_r_user_s = $lang['Reg_users_zero_total'];
	}
	else if ( $logged_visible_online == 1 )
	{
		$l_r_user_s = $lang['Reg_user_total'];
	}
	else
	{
		$l_r_user_s = $lang['Reg_users_total'];
	}

	if ( $logged_hidden_online == 0 )
	{
		$l_h_user_s = $lang['Hidden_users_zero_total'];
	}
	else if ( $logged_hidden_online == 1 )
	{
		$l_h_user_s = $lang['Hidden_user_total'];
	}
	else
	{
		$l_h_user_s = $lang['Hidden_users_total'];
	}

	if ( $guests_online == 0 )
	{
		$l_g_user_s = $lang['Guest_users_zero_total'];
	}
	else if ( $guests_online == 1 )
	{
		$l_g_user_s = $lang['Guest_user_total'];
	}
	else
	{
		$l_g_user_s = $lang['Guest_users_total'];
	}

	$l_online_users = sprintf($l_t_user_s, $total_online_users);
	$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
	$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
	$l_online_users .= sprintf($l_g_user_s, $guests_online);
}

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

// Happy Birthday part
require_once($phpbb_root_path . 'functions/users.'.$phpEx);
$tab_users = birthday_users();

if (date('md')=='1011')
	$tab_users[] = array(
				'user_id' => -1,
				'username' => 'Jean-Jacques Goldman',
				);
if (date('md')=='0826')
	$tab_users[] = array(
				'user_id' => -1,
				'username' => 'JJG famille',
				);
if (count($tab_users)>0)
{
	if (count($tab_users)==1)
		$birth_sentence = $lang['Single_Happy_birthday'].'<b><a href="../forum/profile.'.$phpEx.'?mode=viewprofile&u='.$tab_users[0]['user_id'].'">'.$tab_users[0]['username'].'</a></b>';	else
	{
		$birth_sentence = $lang['Several_Happy_birthday'].'<b><a href="../forum/profile.'.$phpEx.'?mode=viewprofile&u='.$tab_users[0]['user_id'].'">'.$tab_users[0]['username'].'</a></b>';
		for ($i=1;$i<count($tab_users)-1;$i++)
		{
			$birth_sentence .= ', <b><a href="../forum/profile.'.$phpEx.'?mode=viewprofile&u='.$tab_users[$i]['user_id'].'">'.$tab_users[$i]['username'].'</a></b>';
		}
		$birth_sentence .= $lang['And'].'<b><a href="../forum/profile.'.$phpEx.'?mode=viewprofile&u='.$tab_users[count($tab_users)-1]['user_id'].'">'.$tab_users[count($tab_users)-1]['username'].'</a></b>';
	}
	$birth_sentence.= '<br />';
}

// Admin link
$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<span class="copyright"><a href="' . $phpbb_root_path . 'admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a></span>' : '';

// Number of visitors
$number_of_visitors = get_compteur();
$centaines = $number_of_visitors%1000;
if ($centaines==0)
	$centaines = "000";
else if ($centaines<10)
	$centaines = "00" . $centaines;
else if ($centaines<100)
	$centaines = "0" . $centaines;
	
$number_of_visitors = floor($number_of_visitors/1000). '&nbsp;' . $centaines;

// Number of users
$total_users = get_db_stat('usercount');

if( $total_users == 0 )
{
	$l_total_user_s = $lang['Registered_users_zero_total'];
}
else if( $total_users == 1 )
{
	$l_total_user_s = $lang['Registered_user_total'];
}
else
{
	$l_total_user_s = $lang['Registered_users_total'];
}

// Position 
$the_website =  (WEBSITE_POSITION == 'website') ? ' class="nav"><big>' . $lang['the_website'] . '</big>' : '>'. $lang['the_website'] ;
$the_website = '<a href="' . append_sid($phpbb_root_path . 'accueil/') . '"' . $the_website . '</a>';
$the_forum =  (WEBSITE_POSITION == 'forum') ? ' class="nav"><big>' . $lang['the_forum'] . '</big>' : '>' . $lang['the_forum'];$the_forum = '<a href="' . append_sid($phpbb_root_path . 'forum/') . '"' . $the_forum . '</a>';
$the_webchat =  (WEBSITE_POSITION == 'webchat') ? ' class="nav"><big>' . $lang['the_webchat'] . '</big>' : '>'. $lang['the_webchat'] ;
$the_webchat = '<a href="' . append_sid($phpbb_root_path .'jean-jacques-goldman-jjg-famille/chat.htm') . '"' . $the_webchat . '</a>';

// Account box
if ($userdata['session_logged_in'])
{
	$sql = "SELECT post_id
 		FROM " . POSTS_TABLE . " 
		WHERE post_time >= " . $userdata['user_lastvisit'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain matched posts list', '', __LINE__, __FILE__, $sql);
	}
	$search_ids = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$search_ids[] = $row['post_id'];
	}
	$db->sql_freeresult($result);
	$total_match_count = count($search_ids);

	if($total_match_count == 0)
		$l_unread_msg = sprintf($lang['Unread_msg'],$total_match_count);
	elseif($total_match_count == 1)
		$l_unread_msg = sprintf('<b>'.$lang['Unread_msg'].'</b>',$total_match_count);
	else $l_unread_msg = sprintf('<b>'.$lang['Unread_msgs'].'</b>',$total_match_count);

	
	$str_account = $lang['Welcome'] . ' <b>' . $userdata['username'] . '</b><br />';
	$str_account .= sprintf($lang['You_last_visit'], $s_last_visit) . '<br />';
	$str_account .= '<a href="' . append_sid($u_login_logout) . '"><img src="' . $phpbb_root_path . 'templates/jjgfamille/images/icon_mini_login.gif" width="12" height="13" border="0" alt="' . $l_login_logout . '" hspace="3" />' . $l_login_logout . '</a><br />';
	$str_account .= '<a href="' . append_sid($phpbb_root_path . 'forum/profile.'.$phpEx.'?mode=editprofile') . '"><img src="' . $phpbb_root_path . 'templates/jjgfamille/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="' . $lang['Profile'] . '" hspace="3" />' . $lang['Profile'] . '</a><br />';
	$str_account .= '<a href="' . append_sid($phpbb_root_path . 'forum/privmsg.'.$phpEx.'?folder=inbox') . '"><img src="' . $phpbb_root_path . 'templates/jjgfamille/images/icon_mini_message.gif" width="12" height="13" border="0" alt="' . $l_privmsgs_text . '" hspace="3" />' . $l_privmsgs_text . '</a><br />';
	$str_account .= '<a href="' . append_sid($phpbb_root_path . 'forum/search.'.$phpEx.'?search_id=newposts') . '"><img src="' . $phpbb_root_path . 'templates/jjgfamille/images/icon_mini_new.gif" width="12" height="13" border="0" alt="' . $lang['Search_new'] . '">'.$l_unread_msg.'</a><br />';
}
else
{
	$str_account = '<form method="post" action="' . append_sid($phpbb_root_path . 'forum/login.'.$phpEx) . '">';
	$str_account .= '<input type="hidden" name="redirect" value="' . $url . '">';
	$str_account .= '<img src="' . $phpbb_root_path . 'templates/jjgfamille/images/icon_mini_login.gif" width="12" height="13" border="0" alt="' . $l_login_logout . '" hspace="3" /><b>' . $l_login_logout . '</b><br />';
	$str_account .= $lang['Username'] . ' : <input class="post" type="text" name="username" size="11" /><br />';
	$str_account .= $lang['Password'] . ' : <input class="post" type="password" name="password" size="8" maxlength="32" /><br />';
	$str_account .= '<center>' . $lang['Log_me_in'] . '<!-- BEGIN switch_allow_autologin --><input class="post" type="checkbox" name="autologin" /><br /><!-- END switch_allow_autologin -->';
	$str_account .= '<input type="submit" class="mainoption" name="login" value="'.$l_login_logout.'" /></center>';
	$str_account .= '</form>';
	$str_account .= '<a href="' . append_sid($phpbb_root_path . 'forum/profile.'.$phpEx.'?mode=register') . '"><img src="'. $phpbb_root_path . 'templates/jjgfamille/images/icon_mini_register.gif" width="12" height="13" border="0" alt="' . $lang['Register'] . '" hspace="3" /><b>' . $lang['Register'] . '</b></a>';
}

//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
//Bon la moi (flo) est passé par la pour la dynamique de la rubrique famille
// J'ai viré le select_liste qui n'est pas encore défini à cet état de l'exécution (boris)
$sql_rub="SELECT * FROM famille_rub ORDER BY rub_id";
$result=mysql_query($sql_rub) or die("rubriques introuvable");
for($i=0;$val_rub=mysql_fetch_array($result);$i++)
	$tab_rub[$i]=$val_rub;mysql_free_result($result);
// fin de ma modif (boris)
$desc_famille = $lang['equipe'].'<br />'.$lang['Réunion De Famille'].'('.$lang['RDF'].')';
for ($i=0;$i<count($tab_rub);$i++)
{
		$desc_famille .= "<br />".$tab_rub[$i]['name'];
}
	$str_actif = '<a href="%s"  class="nav" onMouseOver="poplink(\'%s\');" onmouseout="killlink()"><big>%s</big></a>';
	$str_inactif = '<a href="%s" onMouseOver="poplink(\'%s\');" onmouseout="killlink()">%s</a>';

//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//

$template->assign_vars(array(
	'SITENAME' => $board_config['sitename'],
	'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
	'SITE_DESCRIPTION' => $board_config['site_desc'],
	'META_DESC' => '<META NAME="Keywords" content="' . $board_config['meta_keywords'] .'"><META NAME="Description" content="' . $board_config['meta_description'] .'">',
	'PAGE_TITLE' => $page_title,
	'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
	'CURRENT_TIME' => sprintf($lang['Current_time'],create_date($board_config['default_dateformat'],time(), $board_config['board_timezone'])),
	'HAPPY_BIRTHDAY' => $birth_sentence,
	'TOTAL_USERS_ONLINE' => $l_online_users,
	'LOGGED_IN_USER_LIST' => $online_userlist,
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
	'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
	'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
	'BOT_INFO' => $online_bots,
	'NUMBER_OF_VISITORS' => sprintf($lang['Number_of_visitor'],'<strong>'.$number_of_visitors.'</strong>'),	'WELCOME' => $lang['Welcome_Here'],	'YOUR_ACCOUNT' => $lang['Your_account'],	'ACCOUNT_BOX' => $str_account,
	'ADMIN_LINK' => $admin_link,
	'THE_WEBSITE' => $the_website,
	'THE_WEBCHAT' => $the_webchat,
	'THE_FORUM' => $the_forum,
	
	'PRIVMSG_IMG' => $icon_pm,
	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN_LOGOUT' => $l_login_logout,
	'L_LOGIN' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'L_REGISTER' => $lang['Register'],
	'L_PROFILE' => $lang['Profile'],
	'L_CONTACT' => $lang['Contact'],
	'L_SEARCH' => $lang['Search'],
	'L_PRIVATEMSGS' => $lang['Private_Messages'],
	'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
	'L_MEMBERLIST' => $lang['Memberlist'],
	'L_FAQ' => $lang['FAQ'],
	'L_USERGROUPS' => $lang['Usergroups'],
	'L_SEARCH_NEW' => $lang['Search_new'],
	'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
	'L_SEARCH_SELF' => $lang['Search_your_posts'],
	'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>'),
	'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),
	'L_WHOSONLINE_BOT' => $legend_bot,
	"L_ACCUEIL" => $lang['Accueil'],
	"L_MEDIAS" => $lang['Medias'],
	"L_ACTUALITE" => $lang['Actualite'],
	"L_JJG" => $lang['JJG'],
	"L_DISCO" => $lang['Discographie'],
	"L_TOURNEES" => $lang['Tournees'],
	"L_LINKS" => $lang['Links'],
	"L_FAMILLE" => $lang['Famille'],
	"L_PLUSPLUS" => $lang['EnPlusPlus'],
	'L_WATCHED_TOPICS' => $lang['Watched_Topics'],
	
	'U_SEARCH_UNANSWERED' => append_sid($phpbb_root_path . 'forum/search.'.$phpEx.'?search_id=unanswered'),
	'U_SEARCH_SELF' => append_sid($phpbb_root_path . 'forum/search.'.$phpEx.'?search_id=egosearch'),
	'U_SEARCH_NEW' => append_sid($phpbb_root_path . 'forum/search.'.$phpEx.'?search_id=newposts'),
	'U_INDEX' => append_sid($phpbb_root_path . 'forum/'),
	'U_REGISTER' => append_sid($phpbb_root_path . 'forum/profile.'.$phpEx.'?mode=register'),
	'U_PROFILE' => append_sid($phpbb_root_path . 'forum/profile.'.$phpEx.'?mode=editprofile'),
	'U_PRIVATEMSGS' => append_sid($phpbb_root_path . 'forum/privmsg.'.$phpEx.'?folder=inbox'),
	'U_PRIVATEMSGS_POPUP' => append_sid($phpbb_root_path . 'forum/privmsg.'.$phpEx.'?mode=newpm'),
	'U_SEARCH' => append_sid($phpbb_root_path . 'forum/search.'.$phpEx),
	'U_MEMBERLIST' => append_sid($phpbb_root_path . 'forum/memberlist.'.$phpEx),
	'U_MODCP' => append_sid($phpbb_root_path . 'forum/modcp.'.$phpEx),
	'U_FAQ' => append_sid($phpbb_root_path . 'forum/faq.'.$phpEx),
	'U_VIEWONLINE' => append_sid($phpbb_root_path . 'forum/viewonline.'.$phpEx),
	'U_LOGIN_LOGOUT' => append_sid($phpbb_root_path . 'forum/' . $u_login_logout),
	'U_GROUP_CP' => append_sid($phpbb_root_path . 'forum/groupcp.'.$phpEx),
	'U_CONTACT' => append_sid($phpbb_root_path . 'forum/contact.'.$phpEx),
	'U_ACCUEIL' => append_sid($phpbb_root_path . 'accueil/'),
	'U_ACTUALITE' => append_sid($phpbb_root_path . 'actu/'),
	"U_MEDIAS" => append_sid($phpbb_root_path . 'medias/'),
	"U_JJG" => append_sid($phpbb_root_path . 'jjg/'),
	"U_DISCO" => append_sid($phpbb_root_path . 'disco/'),
	"U_TOURNEES" => append_sid($phpbb_root_path . 'tournees/'),
	"U_LINKS" => append_sid($phpbb_root_path . 'liens/'),
	"U_FAMILLE" => append_sid($phpbb_root_path . 'famille/'),
	"U_PLUSPLUS" => append_sid($phpbb_root_path . 'more/'),
	'U_WATCHED_TOPICS' => append_sid($phpbb_root_path . 'forum/watched_topics.' . $phpEx),

	"LIEN_ACCUEIL" => sprintf(($actual_rub == 'accueil') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'accueil/'),addslashes($lang['desc_accueil']),$lang['Accueil']),
	"LIEN_MEDIAS" => sprintf(($actual_rub == 'medias') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'medias/'),addslashes($lang['desc_medias']),$lang['Medias']),
	"LIEN_ACTUALITE" => sprintf(($actual_rub == 'actu') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'actu/'),addslashes($lang['desc_actu']),$lang['Actualite']),
	"LIEN_JJG" => sprintf(($actual_rub == 'jjg') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'jjg/'),addslashes($lang['desc_jjg']),$lang['JJG']),
	"LIEN_DISCO" => sprintf(($actual_rub == 'disco') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'disco/'),addslashes($lang['desc_disco']),$lang['Discographie']),
	"LIEN_TOURNEES" => sprintf(($actual_rub == 'tournees') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'tournees/'),addslashes($lang['desc_tournees']),$lang['Tournees']),
	"LIEN_LINKS" => sprintf(($actual_rub == 'liens') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'liens/'),addslashes($lang['desc_liens']),$lang['Links']),
	"LIEN_FAMILLE" => sprintf(($actual_rub == 'famille') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'famille/'),addslashes($desc_famille),$lang['Famille']),
	"LIEN_PLUSPLUS" => sprintf(($actual_rub == 'more') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'more/'),addslashes($lang['desc_plusplus']),$lang['EnPlusPlus']),
	"LIEN_WEBCHAT" => sprintf(($actual_rub == 'chat') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'jean-jacques-goldman-jjg-famille/chat.htm'),addslashes($lang['desc_chat']),$lang['the_webchat']),
	"LIEN_HELP" => sprintf(($actual_rub == 'help') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'jean-jacques-goldman-jjg-famille/aide-chat.htm'),addslashes($lang['desc_help']),$lang['Help']),	
	"LIEN_SOIREES" => sprintf(($actual_rub == 'soirees') ? $str_actif : $str_inactif,append_sid($phpbb_root_path . 'jean-jacques-goldman-jjg-famille/soirees-a-themes-chat.htm'),addslashes($lang['desc_soirees']),$lang['Soirees à themes']),
	// mantis
	'MANTIS_CSS' => $mantis_css,
	// end mantis
	
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