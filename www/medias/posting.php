<?php
/***************************************************************************
 *                                posting.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: posting.php,v 1.159.2.23 2005/05/06 20:50:10 acydburn Exp $
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
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//

//
// Check and set various parameters
//
$params = array('submit' => 'post', 'preview' => 'preview', 'delete' => 'delete', 'poll_delete' => 'poll_delete', 'poll_add' => 'add_poll_option', 'poll_edit' => 'edit_poll_option', 'mode' => 'mode');
while( list($var, $param) = @each($params) )
{
	if ( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )
	{
		$$var = ( !empty($HTTP_POST_VARS[$param]) ) ? htmlspecialchars($HTTP_POST_VARS[$param]) : htmlspecialchars($HTTP_GET_VARS[$param]);
	}
	else
	{
		$$var = '';
	}
}

$confirm = isset($HTTP_POST_VARS['confirm']) ? true : false;

$params = array('forum_id' => POST_FORUM_URL, 'topic_id' => POST_TOPIC_URL, 'post_id' => POST_POST_URL);
while( list($var, $param) = @each($params) )
{
	if ( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )
	{
		$$var = ( !empty($HTTP_POST_VARS[$param]) ) ? intval($HTTP_POST_VARS[$param]) : intval($HTTP_GET_VARS[$param]);
	}
	else
	{
		$$var = '';
	}
}
$video_id = $_GET['video_id'];
$mode = 'newtopic';
$forum_id = $_POST['forum_id'];
$video_user_id = $_POST['video_user_id'];
$video_username = $_POST['video_username'];
//$HTTP_POST_VARS['subject']
//$HTTP_POST_VARS['message']

/**
 * Faire check auth admin
 */

include($phpbb_root_path . 'includes/log_necessary.php');
if ( $userdata['user_level'] != ADMIN && !is_responsable($userdata['user_id'],'video'))
{
	message_die(GENERAL_MESSAGE,'You are not authorized to create topic in the video category');
}
$userdata = get_user($video_user_id,$video_username);
$userdata['username'] = '';
$orig_word = $replacement_word = array();

//
// Set topic type
//
$topic_type = POST_NORMAL;



//
// What auth type do we need to check?
//
$is_auth = array();
$is_auth_type = 'auth_post';

//
// Here we do various lookups to find topic_id, forum_id, post_id etc.
// Doing it here prevents spoofing (eg. faking forum_id, topic_id or post_id
//
$error_msg = '';
$post_data = array();

if ( empty($forum_id) )
{
	message_die(GENERAL_MESSAGE, $lang['Forum_not_exist']);
}

$sql = "SELECT * 
	FROM " . FORUMS_TABLE . " 
	WHERE forum_id = $forum_id";

if ( $result = $db->sql_query($sql) )
{
	$post_info = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	$forum_id = $post_info['forum_id'];
	$forum_name = $post_info['forum_name'];

	$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $post_info);

	/**
	 * Locked forum. In the video process, the forum is always locked. We bypass the check.
	if ( $post_info['forum_status'] == FORUM_LOCKED && !$is_auth['auth_mod']) 
	{ 
	   message_die(GENERAL_MESSAGE, $lang['Forum_locked']); 
	} 
	*/

	$post_data['topic_type'] = POST_NORMAL;
		
	$post_data['first_post'] = true;
	$post_data['last_post'] = false;
	$post_data['has_poll'] = false;
	$post_data['edit_poll'] = false;
}
else
{
	message_die(GENERAL_MESSAGE, $lang['No_such_post']);
}

//
// Set toggles for various options
//
if ( !$board_config['allow_html'] )
{
	$html_on = 0;
}
else
{
	$html_on = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['disable_html']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_html'] : $userdata['user_allowhtml'] );
}

if ( !$board_config['allow_bbcode'] )
{
	$bbcode_on = 0;
}
else
{
	$bbcode_on = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['disable_bbcode']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_bbcode'] : $userdata['user_allowbbcode'] );
}

if ( !$board_config['allow_smilies'] )
{
	$smilies_on = 0;
}
else
{
	$smilies_on = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['disable_smilies']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_smilies'] : $userdata['user_allowsmile'] );
}

$notify_user = ( !empty($userdata['user_notify']) ) ? TRUE : 0;

$attach_sig = $userdata['user_attachsig'];

// --------------------
//  What shall we do?
//

//
// Submit post/vote (newtopic, edit, reply, etc.)
//
$return_message = '';
$return_meta = '';


$username = $userdata['username'];
$subject = ( !empty($HTTP_POST_VARS['subject']) ) ? trim($HTTP_POST_VARS['subject']) : '';
$message = ( !empty($HTTP_POST_VARS['message']) ) ? $HTTP_POST_VARS['message'] : '';
$poll_title = '';
$poll_options = '';
$bbcode_uid = '';

// Boris 12/02/2007 Vote Manage Mod : add $poll_length_h, $max_vote, $undo_vote arguments
prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on, $error_msg, $username, $bbcode_uid, $subject, $message, $poll_title, $poll_options, $poll_length, $poll_length_h, $max_vote, $undo_vote);

if ( $error_msg == '' )
{
	$topic_type = ( $topic_type != $post_data['topic_type'] && !$is_auth['auth_sticky'] && !$is_auth['auth_announce'] ) ? $post_data['topic_type'] : $topic_type;

	submit_post($mode, $post_data, $return_message, $return_meta, $forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, str_replace("\'", "''", $username), str_replace("\'", "''", $subject), str_replace("\'", "''", $message), str_replace("\'", "''", $poll_title), $poll_options, $poll_length, $max_vote, $hide_vote, $undo_vote);
}

if ( $error_msg == '' )
{
	if ( $mode != 'editpost' )
	{
		$user_id = $video_user_id;
		update_post_stats($mode, $post_data, $forum_id, $topic_id, $post_id, $user_id);
	}

	if ($error_msg == '' && $mode != 'poll_delete')
	{
		user_notification($mode, $post_data, $post_info['topic_title'], $forum_id, $topic_id, $post_id, $notify_user);
	}

	if ( $mode == 'newtopic' || $mode == 'reply' )
	{
		$tracking_topics = ( !empty($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : array();
		$tracking_forums = ( !empty($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : array();

		if ( count($tracking_topics) + count($tracking_forums) == 100 && empty($tracking_topics[$topic_id]) )
		{
			asort($tracking_topics);
			unset($tracking_topics[key($tracking_topics)]);
		}

		$tracking_topics[$topic_id] = time();

		setcookie($board_config['cookie_name'] . '_t', serialize($tracking_topics), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	}
	
	$sql = "UPDATE `video_video` SET `topic_id` = '$topic_id' WHERE `video_id` ='$video_id'";
	mysql_query($sql);

	$url_video = append_sid($phpbb_root_path . 'medias/video.php');

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . $url_video . '">')
	);
	
	$return_message .= '<br /><br />' . sprintf($lang['Comeback_to_video'],'<a href="' . $url_video . '">','</a>');
	message_die(GENERAL_MESSAGE, $return_message);
}
die($error_msg);

?>