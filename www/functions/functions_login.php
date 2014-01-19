<?
if (!defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function phpbb_login($username, $password, $redirect='', $autologin=false, $admin=false)
{
	global $db, $phpEx, $phpbb_root_path, $board_config, $lang, $userdata, $user_ip, $session_id;
	
	if (!$userdata['session_logged_in'] || $admin!==false)
	{
		$username = phpbb_clean_username($username);
		
		// update 2.0.19
		//$sql = "SELECT user_id, username, user_password, user_active, user_level
		$sql = "SELECT user_id, username, user_password, user_active, user_level, user_login_tries, user_last_login_try
			FROM " . USERS_TABLE . "
			WHERE username = '" . str_replace("\\'", "''", $username) . "'";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		}
		
		if( $row = $db->sql_fetchrow($result) )
		{
			if( $row['user_level'] != ADMIN && $board_config['board_disable'] )
			{
				return append_sid($phpbb_root_path . "forum/index.$phpEx", true);
			}
			else
			{
				// update 2.0.19
				// If the last login is more than x minutes ago, then reset the login tries/time
				if ($row['user_last_login_try'] && $board_config['login_reset_time'] && $row['user_last_login_try'] < (time() - ($board_config['login_reset_time'] * 60)))
				{
					$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_tries = 0, user_last_login_try = 0 WHERE user_id = ' . $row['user_id']);
					$row['user_last_login_try'] = $row['user_login_tries'] = 0;
				}
				
				// Check to see if user is allowed to login again... if his tries are exceeded
				if ($row['user_last_login_try'] && $board_config['login_reset_time'] && $board_config['max_login_attempts'] && 
					$row['user_last_login_try'] >= (time() - ($board_config['login_reset_time'] * 60)) && $row['user_login_tries'] >= $board_config['max_login_attempts'])
				{
					message_die(GENERAL_MESSAGE, sprintf($lang['Login_attempts_exceeded'], $board_config['max_login_attempts'], $board_config['login_reset_time']));
				}
				// fin update
				if( md5($password) == $row['user_password'] && $row['user_active'] )
				{
					$autologin = ( isset($autologin) ) ? TRUE : 0;
		
					$admin = ($admin !== false) ? 1 : 0;
					$session_id = session_begin($row['user_id'], $user_ip, PAGE_INDEX, FALSE, $autologin, $admin);
					
					// update 2.0.19
					// Reset login tries
					$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_tries = 0, user_last_login_try = 0 WHERE user_id = ' . $row['user_id']);
					// fin update
		
					if( $session_id )
					{
						$url = ( !empty($redirect) ) ? str_replace('&amp;', '&', htmlspecialchars($redirect)) : $phpbb_root_path . "forum/index.$phpEx";
						return append_sid($url, true);
					}
					else
					{
						message_die(CRITICAL_ERROR, "Couldn't start session : login", "", __LINE__, __FILE__);
					}
				}
				else
				{
					// update 2.0.19
					// Save login tries and last login
					if ($row['user_id'] != ANONYMOUS)
					{
						$sql = 'UPDATE ' . USERS_TABLE . '
							SET user_login_tries = user_login_tries + 1, user_last_login_try = ' . time() . '
							WHERE user_id = ' . $row['user_id'];
						$db->sql_query($sql);
					}
					// fin update
					$redirect = ( !empty($redirect) ) ? str_replace('&amp;', '&', htmlspecialchars($redirect)) : '';
					$redirect = str_replace('?', '&', $redirect);
		
					if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
					{
						message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
					}
		
					$template->assign_vars(array(
						'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
					);
		
					$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
		
					message_die(GENERAL_MESSAGE, $message);
				}
			}
		}
		else
		{
			$redirect = ( !empty($redirect) ) ? str_replace('&amp;', '&', htmlspecialchars($redirect)) : "";
			$redirect = str_replace("?", "&", $redirect);
		
			if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
			{
				message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
			}
		
			$template->assign_vars(array(
				'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
			);
		
			$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
		
			message_die(GENERAL_MESSAGE, $message);
		}
	} else
	{
		$url = ( !empty($redirect) ) ? str_replace('&amp;', '&', htmlspecialchars($redirect)) : $phpbb_root_path . "forum/index.$phpEx";
		return append_sid($url, true);
	}
}

//redirect(phpbb_login('Boris', '40315', 'more/concours_goldman.html'));

?>