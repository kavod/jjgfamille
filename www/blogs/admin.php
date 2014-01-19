<?php
/**
Blogs
*/

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'weblogs');
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
require_once($phpbb_root_path . 'functions/functions_selections.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_BLOGS);
init_userprefs($userdata);
//
// End session management
//
require_once($phpbb_root_path . 'functions/functions_blog.php');

$url_and = '';
$url_quest = '';
$tab_boxes_names = array(
			'box_profile' => $lang['Who_am_I'],
			'box_calendrier' => $lang['Calendar'],
			'box_blogs' => $lang['My_articles'],
			'box_last_coms' => $lang['Last_coms'],
			);

if ( !$userdata['session_logged_in'])
{
	include($phpbb_root_path . 'includes/log_necessary.php');
} else
{
	if (isset($_GET['blogger_id']) && (int)($_GET['blogger_id']) > 0)
	{
		if ( $userdata['user_level'] != ADMIN && !is_responsable($userdata['user_id'],'blog'))
		{
			$blogger_id = $userdata['user_id'];
		} else
		{
			$blogger_id = (int)$_GET['blogger_id'];
			$url_and = "&amp;blogger_id=" . $blogger_id;
			$url_quest = "?blogger_id=" . $blogger_id;
			
		}
	} else 
	{
		$blogger_id = $userdata['user_id'];
	}
	
	$val_blog = select_blog($blogger_id,false);
	
	if ($_GET['mode'] == 'subscribe' || $_GET['mode'] == 'dosubscribe')
	{
		if ($val_blog)
		{
			$error = true;
			$error_msg = 'Vous avez déjà un blog';
		} else
		{
			$val_blog = array();
		}
	} else
	{
		if (!$val_blog)
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_no_blog']));
		
		$page_title = $val_blog['title'] . " :: " . $lang['Blogs'];
	}
	$val_blogger = select_blogger($blogger_id, $val_blog['username']);
}

$tab_cate = select_liste("SELECT * FROM `blogs_cate` WHERE `user_id` = '" . $blogger_id . "'");

if ($_GET['mode'] == 'move_box')
{
	if ($_GET['action'] == 'up')
	{
		upasso('blogs_boxes','box_id',$_GET['id'],'user_id');
	} else if ($_GET['action'] == 'down')
	{
		downasso('blogs_boxes','box_id',$_GET['id'],'user_id');
	} else
	{
		message_die(GENERAL_MESSAGE, 'Action incorrecte');
	}
} 

if ($_GET['mode'] == 'edit_properties' || $_GET['mode'] == 'dosubscribe')
{
	$val_doublon = select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '" . $blogger_id . "'",'',false);
	
	if ($val_doublon && $_GET['mode'] == 'dosubscribe')
	{
		$_GET['mode'] = '';
		list($error,$error_msg) = array(true,$lang['Blog_already_exists']);
	}	
	if (!$val_doublon && $_GET['mode'] == 'edit_properties')
		message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_no_blog']));
	
	if (!$error)
	{
		$bbcode_uid = make_bbcode_uid();
		$title = $_POST['title'];
		$subtitle = $_POST['subtitle'];
		$header = bbencode_first_pass($_POST['header'], $bbcode_uid);
		$profile = bbencode_first_pass($_POST['profile'], $bbcode_uid);
		$enable_blog = $_POST['enable_blog'];
		$readonly = $_POST['readonly'];
		$notification = $_POST['notification'];
		
		if ($_GET['mode'] == 'edit_properties')
		{
			$sql = "UPDATE blogs_blogs 
				SET 
					`title` = '$title',
					`subtitle` = '$subtitle',
					`header` = '$header',
					`profile` = '$profile',
					`bbcode_uid` = '$bbcode_uid',
					`enable` = '$enable_blog',
					`readonly` = '$readonly',
					`notification` = '$notification'
				WHERE `user_id` = '" . $blogger_id . "'";
			$message = $lang['Properties_edited'];
		} else
		{
			$sql = "INSERT INTO blogs_blogs (`user_id`, `username`, `title`, `subtitle`, `header`, `profile`, `bbcode_uid`,`enable`,`readonly`,`notification`)
				VALUES ('" . $blogger_id . "','" . $userdata['username'] . "','$title','$subtitle','$header','$profile','$bbcode_uid','$enable_blog','$readonly','$notification'); ";
			$sql .= "INSERT INTO `blogs_boxes` (`user_id`, `box`, `ordre`, `enable`) VALUES ('$blogger_id', 'box_admin', 1, 'Y');"
			. " INSERT INTO `blogs_boxes` (`user_id`, `box`, `ordre`, `enable`) VALUES ('$blogger_id', 'box_profile', 2, 'Y');"
			. " INSERT INTO `blogs_boxes` (`user_id`, `box`, `ordre`, `enable`) VALUES ('$blogger_id', 'box_calendrier', 3, \'Y\');"
			. " INSERT INTO `blogs_boxes` (`user_id`, `box`, `ordre`, `enable`) VALUES ('$blogger_id', 'box_blogs', 4, 'Y');";
			$message = $lang['Blog_created'];
		}
		mysql_query($sql);
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin.php" . $url_quest) . '">')
		);
		$message =  sprintf($message, '<a href="' . append_sid("admin.php" . $url_quest) . '">', '</a>');
		
		message_die(GENERAL_MESSAGE, sprintf($message));
		exit();
	}
} else if($_GET['mode'] == 'edit_cate')
{
	for ($i=0;$i<count($tab_cate);$i++)
	{
		$cate_name = trim($_POST['cate' . $tab_cate[$i]['cate_id']]);
		if ($cate_name != $tab_cate[$i]['cate_name'])
		{
			$sql = "UPDATE `blogs_cate` 
				SET 
					`cate_name` = '" . $_POST['cate' . $tab_cate[$i]['cate_id']] . "'
				WHERE `cate_id` = '" . $tab_cate[$i]['cate_id'] . "'";
			mysql_query($sql);
		}
	}
	
	if (trim($_POST['new_cate']) != '')
	{
		/*$sql = "INSERT INTO `blogs_cate` (`cate_name`, `user_id`, `auth_view` , `auth_read` , `auth_post` , `auth_reply` , `auth_edit` , `auth_delete` , `auth_sticky` , `auth_announce` , `auth_vote` , `auth_pollcreate` , `auth_attachments`) VALUES ('" . trim($_POST['new_cate']) . "','" . $blogger_id . "',0,0,3,0,3,3,5,5,5,5,5)";
		mysql_query($sql);
		
		$cate_id = mysql_insert_id();
		
		$val_group = select_element("SELECT groupe.`group_id` 
						FROM `phpbb_groups` groupe, `phpbb_user_group` asso 
						WHERE asso.`user_id` = '" . $blogger_id . "' AND asso.`group_id` = groupe.`group_id` AND groupe.`group_single_user` = '1'",'groupe introuvable',false);
		$sql = "INSERT INTO `blogs_auth` VALUES ('" . $val_group['group_id'] . "','$cate_id',0,0,1,0,1,1,0,0,0,0,0,1)";
		mysql_query($sql);*/
		$cate_id = create_category($_POST['new_cate'],$blogger_id);
	}
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin.php" . $url_quest) . '">')
		);
		$message =  sprintf($lang['Properties_edited'], '<a href="' . append_sid("admin.php" . $url_quest) . '">', '</a>');
		
		message_die(GENERAL_MESSAGE, sprintf($message));
		exit();
		
} else if($_GET['mode'] == 'subscribe')
{
	$val_doublon = select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '" . $blogger_id . "'",'',false);
	
	if ($val_doublon)
	{
		$_GET['mode'] = '';
		list($error,$error_msg) = array(true,$lang['Blog_already_exists']);
	}	
	$u_action = append_sid('admin.php?mode=dosubscribe' . $url_and);
} else if($_GET['mode'] == 'del_cate')
{
	$val_cate = select_element("SELECT * FROM `blogs_cate` WHERE `cate_id` = '" . $_GET['cate_id'] . "'",'catégorie introuvable',true);
	
	if ($val_cate['user_id'] == $blogger_id)
	{
		if ($_POST['confirm'] == 1)
		{
			$tab_article = select_liste("SELECT * FROM `blogs_articles` WHERE `forum_id` = '" . $val_cate['cate_id'] . "'");
			for ($i=0;$i<count($tab_article) && $_POST['to_id']>0;$i++)
			{
				move_article($plouf,$tab_article[$i]['topic_id'],$_POST['to_id'],$tab_article[$i]['forum_id'],$_POST['confirm'],$blogger_id,false);
			}
		
			supp_blog_cate($val_cate['cate_id']);
			
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin.php" . $url_quest) . '">')
			);
			$message =  sprintf($lang['Cate_deleted'], '<a href="' . append_sid("admin.php" . $url_quest) . '">', '</a>');
			
			message_die(GENERAL_MESSAGE, $message);
			exit();
		} else
		{
			
			// Show form to delete a forum
			$forum_id = intval($_GET['cate_id']);

			$select_to = '<select name="to_id">';
			$select_to .= "<option value=\"-1\"$s>" . $lang['Delete_all_posts'] . "</option>\n";
			
			//$select_to .= get_list('forum', $forum_id, 0);
			$is_auth_ary = auth(AUTH_READ, AUTH_LIST_ALL, $val_blogger);
			
			$sql = 'SELECT cate_id, cate_name
				FROM `blogs_cate` 
				WHERE user_id = ' . $blogger_id . ' 
				ORDER BY cate_name';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
			}
		
			$forum_list = '';
			while( $row = $db->sql_fetchrow($result) )
			{
				if ( $is_auth_ary[$row['cate_id']]['auth_read'] && $ignore_forum != $row['cate_id'] )
				{
					$selected = ( $select_forum == $row['cate_id'] ) ? ' selected="selected"' : '';
					$select_to .= '<option value="' . $row['cate_id'] . '"' . $selected .'>' . $row['cate_name'] . '</option>';
				}
			}
			// fin select_to
			
			$select_to .= '</select>';

			$buttonvalue = $lang['Move_and_Delete'];

			$newmode = 'movedelforum';

			//$foruminfo = get_info('forum', $forum_id);
			$foruminfo = $val_cate;
			
			$name = $foruminfo['cate_name'];

			include($phpbb_root_path . 'blogs/page_header.php');

			$template->set_filenames(array(
				"body" => "blogs/modcp_del_cate.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="confirm" value="1" />';

			$template->assign_vars(array(
				'NAME' => $name, 

				'MESSAGE_TITLE' => $lang['Blogs_cate_delete'], 
				'L_FORUM_DELETE_EXPLAIN' => $lang['Blogs_cate_delete_explain'], 
				'L_MOVE_CONTENTS' => $lang['Move_contents'], 
				'L_FORUM_NAME' => $lang['Cate_name'], 

				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin.php?mode=del_cate&amp;cate_id=" . $forum_id), 
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $lang['Submit'])
			);

			$template->pparse("body");
			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
			exit();
		}
		
	} else
	{
		message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
		exit();
	}
} else if ($_GET['mode'] == 'import_rss')
{
	require_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
	require_once($phpbb_root_path . 'rss_fetch/rss_fetch.inc');
	
	/*$fd = fopen($_POST['rss_url'],'r');
	if (!$fd)
		die("erreur");
	$rss = '';
	while($line = fgets($fd))
		$rss .= $line;
	fclose($fd);*/
	$rss = fetch_rss($_POST['rss_url']);
	/*$xml_parser = xml_parser_create();
	xml_parse_into_struct($xml_parser, $rss, $vals, $index);
	
	$tab_categories = array();
	
	for ($i=0;$i<count($index['DC:SUBJECT']);$i++)
	{
		$index_title = $index['DC:SUBJECT'][$i];
		$tab_categories[] = $vals[$index_title]['value'];
	}
	
	$tab_categories = reindex_array($tab_categories);
	print_r($tab_categories);
	
	for ($i=0;$i<count($tab_categories);$i++)
	{
		$val_cate = select_element("SELECT `cate_id` FROM `blogs_cate` WHERE `user_id` = '$blogger_id' AND `cate_name` = '" . trim($tab_categories[$i]) . "'",false,'');
		if ($val_cate)
			$tab_categories_index[$i] = $val_cate['cate_id'];
		else
			$tab_categories_index[$i] = create_category($tab_categories[$i],$blogger_id);
	}
	
	xml_parser_free ( $xml_parser );*/
	
	$syndic_var = array(
			'atom' => array(
					'regular' => '|<\?xml version=".*" encoding=".*"\?><feed |',
					'content' => 'content'
					),
			'rss' => array(
					'regular' => '|<?xml version=".*" encoding=".*"?><rss |',
					'content' => 'description'
					),
			);
	
	//$rss = utf8_decode($rss);
	//echo $rss;
	/*if (preg_match($syndic_var['atom']['regular'],$rss)>0)
		$protocol = 'atom';
	else if (preg_match($syndic_var['rss']['regular'],$rss)>0)
		$protocol = 'rss';
	else
		die("mode inconnu");
	$db_rss = readDatabase($rss,$protocol);*/
	
	$db->reconnect();
	
	for ($i=0;$i<count($rss['items']);$i++)
	{
		// Category
		$category_name = trim($rss['items'][$i]['dc:subject']['dc']['subject']);
		
		if ($category_name != '')
		{
			$val_cate = select_element("SELECT `cate_id` FROM `blogs_cate` WHERE `user_id` = '$blogger_id' AND `cate_name` = '$category_name'",false,'');
		} else
			$val_cate = select_element("SELECT `cate_id` FROM `blogs_cate` WHERE `user_id` = '$blogger_id'",false,'');
		if ($val_cate)
			$cate_id = $val_cate['cate_id'];
		else
			$cate_id = create_category($category_name,$blogger_id);
		
		// Date / time
		/*$format = '%Y-%m-%dT%H-%M-%SZ';
		preg_match ('|([0-9]+)-([0-9]+)-([0-9]+)T([0-9]+):([0-9]+):([0-9]+)Z|', $db_rss[$i]['issued'] , $matches, PREG_OFFSET_CAPTURE );
		$timestamp = mktime($matches[4][0],$matches[5][0],$matches[6][0],$matches[2][0],$matches[3][0],$matches[1][0]);
		*/
		
		// Title
		$title = preg_replace($tab_utf82, $tab_utf81, $rss['items'][$i]['title']);
	
		/*$sql = "SELECT `topic_id`,`forum_id`, `topic_first_post_id` FROM `blogs_articles` WHERE `topic_poster` = '$blogger_id' AND `topic_title` = '" . addslashes($title) . "'";
		$val_article = select_element($sql,false,'');
		if ($val_article)
		{
			$mode='editpost';
			$topic_id = $val_article['topic_id'];
			$post_id = $val_article['topic_first_post_id'];
			$cate_id = $val_article['forum_id'];
		} else
		{
			$mode = 'newtopic';
			$topic_id = '';
			$post_id = '';
		}*/
		
		echo $title;
		die();
		// Content
		$texte = $db_rss[$i][$syndic_var[$protocol]['content']];
		$texte = preg_replace($tab_utf82, $tab_utf81, $texte);
		
		
		$username = $val_blogger['username'];
		$subject = addslashes($title);
		$message = addslashes($texte);
		$bbcode_uid = '';
		$attach_sig = true;
		$post_data['poster_post'] = true;
		$post_data['first_post'] = true;
		$post_data['poster_id'] = $blogger_id;
		$post_data['edit_vote'] = 0;
		$post_data['last_post'] = 0;
		$post_data['edit_poll'] = 0;
		$post_data['has_poll'] = 0;
		$bbcode_on = 0;
		$html_on = true;
		$smilies_on = 0;
		$poll_title = '';
		$poll_options = '';
		$poll_length = '';
		$sql = "SELECT * 
			FROM `blogs_cate` 
			WHERE `cate_id` = '$cate_id'";
		$post_info = select_element($sql,false,'');
		$tmp_username = $userdata['username'];
		$userdata['username'] = $val_blogger['username'];
		prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on, $error_msg, $username, $bbcode_uid, $subject, $message, $poll_title, $poll_options, $poll_length);
		$userdata['username'] = $tmp_username;
		
		if ( $error_msg == '' )
		{
			$neg_forum_id = -$cate_id;
			submit_post($mode, $post_data, $return_message, $return_meta, $neg_forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, str_replace("\'", "''", $username), str_replace("\'", "''", $subject), str_replace("\'", "''", $message), str_replace("\'", "''", $poll_title), $poll_options, $poll_length);
		} else
			echo $error_msg; // die($error_msg);
		$error_msg = '';
		
	}
	//print_r($db_rss);
	
	exit();
} else if($_GET['mode'] == 'edit_box')
{
	$sql = "UPDATE `blogs_boxes` SET `enable` = '%s' WHERE `user_id` = '%s' AND `box` = '%s'";
	$keys = array_keys($tab_boxes_names);
	
	for ($i=0;$i<count($tab_boxes_names);$i++)
	{
		mysql_query(sprintf($sql,$_POST[$keys[$i]],$blogger_id,$keys[$i]));
	}
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin.php" . $url_quest) . '">')
		);
	$message =  sprintf($lang['Properties_edited'], '<a href="' . append_sid("admin.php" . $url_quest) . '">', '</a>');
	
	message_die(GENERAL_MESSAGE, sprintf($message));
	
	exit();
} else
{
	$u_action = append_sid('admin.php?mode=edit_properties' . $url_and);
	$sql = "SELECT * FROM `blogs_boxes` WHERE `user_id` = '$blogger_id' ORDER BY `enable` DESC, `ordre`";
	$tab_boxes = select_liste($sql);
}

//
// Start output of page
//
define('SHOW_ONLINE', true);

include($phpbb_root_path . 'blogs/page_header.php');


$template->set_filenames(array(
	'body' => 'blogs/admin.tpl',
	'colonneDroite' => 'blogs/colonne_droite.tpl',
	'box_blogs' => 'blogs/box_blogs.tpl',
	'box_calendrier' => 'blogs/box_calendrier.tpl',
	'box_profile' => 'blogs/box_profile.tpl',
	'box_admin' => 'blogs/box_admin.tpl',
	'box_last_coms' => 'blogs/box_last_coms.tpl'
)
);

$template->assign_vars(array(			
			'BLOG_HEADER' => ($userdata['user_id'] != $val_blog['user_id']) ? $lang['Admin_of_blog'] : $lang['blog_admin'],
			
			'L_DELETE' => $lang['Delete'],
			)
			);


// Archives
$template->assign_block_vars('switch_archives',array());
$tab_archives = select_liste("SELECT *, FROM_UNIXTIME(topic_time,'%Y%m') mois, COUNT(*) counter FROM `blogs_articles` GROUP BY mois ORDER BY mois DESC");
for ($i=0;$i<count($tab_archives);$i++)
{
	$url_user = ($user_id > 0) ? 'user_id=' . $user_id . '&amp;' : '';
	
	$date_unix = mktime(12,0,0,substr($tab_archives[$i]['mois'],4,2),10,substr($tab_archives[$i]['mois'],0,4));
	$date_format = create_date('M Y',$date_unix, $board_config['board_timezone']);
	
	$template->assign_block_vars('switch_archives.mois',array(
					'U_ARCHIVE' => append_sid($phpbb_root_path . 'blogs/?' . $url_user . 'mois=' . $tab_archives[$i]['mois']),
					
					'L_ARCHIVE' => sprintf("%s (%s)",$date_format,$tab_archives[$i]['counter']),
					)
				);
}

$tab_setup = array(
		array(
			'HEADING' => $lang['General_settings'],
			'U_ACTION' => $u_action,
			'LABEL' => $lang['Blog_title'],
			'type' => 'text',
			'NAME' => 'title',
			'VALUE' => htmlentities($val_blog['title']),
			'SIZE' => '50',
			'MAXLENGTH' => '50',
			),
		array(
			'LABEL' => $lang['Subtitle'],
			'type' => 'text',
			'NAME' => 'subtitle',
			'VALUE' => htmlentities($val_blog['subtitle']),
			'SIZE' => '70',
			'MAXLENGTH' => '255',
			),
		array(
			'LABEL' => $lang['Presentation'],
			'type' => 'textarea',
			'NAME' => 'header',
			'VALUE' => htmlentities(str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_blog['bbcode_uid'] . '/s', '', $val_blog['header']))),
			'ROWS' => '10',
			'COLS' => '70',
			'EXPLAIN' => $lang['Explain_presentation'],
			),
		array(
			'LABEL' => $lang['Profile'],
			'type' => 'textarea',
			'NAME' => 'profile',
			'VALUE' => htmlentities(str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_blog['bbcode_uid'] . '/s', '', $val_blog['profile']))),
			'ROWS' => '10',
			'COLS' => '70',
			'EXPLAIN' => $lang['Explain_profil'],
			)
		);

if ($val_blog['readonly'] != 'F' || $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog'))
{
	$choices = array(
			array(
				'TEXT' => $lang['Enabled'],
				'VALUE' => 'Y',
				'CHECKED' => ($val_blog['enable'] == 'Y') ? ' CHECKED' : '',
				),
			array(
				'TEXT' => $lang['Disabled'],
				'VALUE' => 'N',
				'CHECKED' => ($val_blog['enable'] == 'N') ? ' CHECKED' : '',
				),
			);
	
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog'))
		$choices[] = array(
				'TEXT' => sprintf($lang['Force'],$lang['Disabled']),
				'VALUE' => 'F',
				'CHECKED' => ($val_blog['enable'] == 'F') ? ' CHECKED' : '',
				);
	
	$tab_setup[] =	array(
				'LABEL' => $lang['Switch_enable'],
				'type' => 'radio',
				'NAME' => 'enable_blog',
				'choices' => $choices,
			);
}

if ($val_blog['readonly'] != 'F' || $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog'))
{
	$choices = array(
			array(
				'TEXT' => $lang['Enabled'],
				'VALUE' => 'Y',
				'CHECKED' => ($val_blog['readonly'] == 'Y') ? ' CHECKED' : '',
				),
			array(
				'TEXT' => $lang['Disabled'],
				'VALUE' => 'N',
				'CHECKED' => ($val_blog['readonly'] == 'N') ? ' CHECKED' : '',
				),
			);
	
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog'))
		$choices[] = array(
				'TEXT' => sprintf($lang['Force'],$lang['Enabled']),
				'VALUE' => 'F',
				'CHECKED' => ($val_blog['readonly'] == 'F') ? ' CHECKED' : '',
				);
	
	$tab_setup[] =	array(
			'LABEL' => $lang['Switch_readonly'],
			'EXPLAIN' => $lang['Explain_readonly'],
			'type' => 'radio',
			'NAME' => 'readonly',
			'choices' => $choices,
			);
}
$choices = array(
		array(
			'TEXT' => $lang['Enabled'],
			'VALUE' => 'Y',
			'CHECKED' => ($val_blog['notification'] == 'Y' || $_GET['mode'] == 'subscribe') ? ' CHECKED' : '',
			),
		array(
			'TEXT' => $lang['Disabled'],
			'VALUE' => 'N',
			'CHECKED' => ($val_blog['notification'] == 'N') ? ' CHECKED' : '',
			),
		);
		
$tab_setup[] =	array(
			'LABEL' => $lang['Switch_notification'],
			'type' => 'radio',
			'NAME' => 'notification',
			'choices' => $choices,
		);

$tab_setup[] =	array(
			'LABEL' => '',
			'type' => 'submit',
			'NAME' => 'submit',
			'VALUE' => $lang['Submit'],
			);

if ($_GET['mode'] != 'subscribe')
{
	for($i=0;$i<count($tab_cate);$i++)
	{
		$tab_setup[] = array(
				'LABEL' => '',
				'type' => 'text',
				'NAME' => 'cate' . $tab_cate[$i]['cate_id'],
				'VALUE' => htmlentities($tab_cate[$i]['cate_name']),
				'SIZE' => '50',
				'MAXLENGTH' => '60',
				'U_DELETE' => append_sid('admin.php?mode=del_cate&amp;cate_id='.$tab_cate[$i]['cate_id'] . $url_and),
				'L_CONFIRM' => $tab_cate[$i]['cate_name'],
					);
		if ($i < 1)
		{
			$tab_setup[count($tab_setup)-1]['HEADING'] = 'Catégories';
			$tab_setup[count($tab_setup)-1]['U_ACTION'] = append_sid('admin.php?mode=edit_cate' . $url_and);
		}
	}
	
	$tab_setup[] = array(
				'LABEL' => $lang['Add_category'],
				'type' => 'text',
				'NAME' => 'new_cate',
				'VALUE' => '',
				'SIZE' => '50',
				'MAXLENGTH' => '60',
				);
	
	if (count($tab_cate)<1)
	{
		$tab_setup[count($tab_setup)-1]['HEADING'] = $lang['Category'];
		$tab_setup[count($tab_setup)-1]['U_ACTION'] = append_sid('admin.php?mode=edit_cate' . $url_and);
	}
	
	$tab_setup[] = array(
				'LABEL' => '',
				'type' => 'submit',
				'NAME' => 'submit',
				'VALUE' => $lang['Submit'],
				);
	
	$str_up_down = '&nbsp; &nbsp; &nbsp; <a href="admin.php?mode=move_box&amp;id=%s&amp;action=%s' . $url_and . '">%s</a>';
	$str_up = "^ " . $lang['Up'];
	$str_down = "v " . $lang['Down'];
	
	for ($i=0;$i<count($tab_boxes);$i++)
	{
		$choices = array(
			array(
				'TEXT' => $lang['Enabled'] . sprintf($str_up_down,$tab_boxes[$i]['box_id'],'up',$str_up),
				'VALUE' => 'Y',
				'CHECKED' => ($tab_boxes[$i]['enable'] == 'Y') ? ' CHECKED' : '',
				),
			array(
				'TEXT' => $lang['Disabled'] . sprintf($str_up_down,$tab_boxes[$i]['box_id'],'down',$str_down),
				'VALUE' => 'N',
				'CHECKED' => ($tab_boxes[$i]['enable'] == 'N') ? ' CHECKED' : '',
				),
			);
			
		$tab_setup[] =	array(
				'LABEL' => $tab_boxes_names[$tab_boxes[$i]['box']],
				'EXPLAIN' => '',
				'type' => 'radio',
				'NAME' => $tab_boxes[$i]['box'],
				'choices' => $choices,
				);
		if ($i < 1)
		{
			$tab_setup[count($tab_setup)-1]['HEADING'] = $lang['Boxes'];
			$tab_setup[count($tab_setup)-1]['U_ACTION'] = append_sid('admin.php?mode=edit_box' . $url_and);
		}
	}
	$tab_setup[] = array(
				'LABEL' => '',
				'type' => 'submit',
				'NAME' => 'submit',
				'VALUE' => $lang['Submit'],
				);
				
				
	if ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog'))
	{
		$tab_setup[] = array(
					'HEADING' => $lang['Import_rss'],
					'U_ACTION' => append_sid($phpbb_root_path . 'blogs/admin.php?mode=import_rss' . $url_and),
					'LABEL' => $lang['Syndication_URL'],
					'type' => 'text',
					'NAME' => 'rss_url',
					'VALUE' => $rien_pour_linstant,
					'SIZE' => '100',
					'MAXLENGTH' => '255',
					);
		$tab_setup[] = array(
					'LABEL' => '',
					'type' => 'submit',
					'NAME' => 'submit',
					'VALUE' => $lang['Import_Synchronize'],
					);
	}
	
	admin_box($blogger_id);
}

create_form($tab_setup);

box_profile($blogger_id,$val_blog,$val_blogger);
box_calendrier($blogger_id,mktime());
box_last_coms($blogger_id);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog'))
{
	$template->assign_block_vars('administrator',array(
					'L_ADMIN' => $lang['General_settings'],
					
					'U_ADMIN' => append_sid('admin_blogs.php'),
					));
}

$sql = "SELECT * FROM `blogs_boxes` WHERE `user_id` = '$blogger_id' AND `enable` = 'Y' ORDER BY `ordre`";
$tab_boxes = select_liste($sql);
if (count($tab_boxes)>0)
	array_unshift($tab_boxes, array('box' => 'box_admin'));
else
	$tab_boxes = array(
			array('box' => 'box_admin')
			);
for ($i=0;$i<count($tab_boxes);$i++)
{
	$template->assign_var_from_handle('BOITE' . ($i+1), $tab_boxes[$i]['box']);
}

$template->assign_var_from_handle('COLONNE_DROITE', 'colonneDroite');


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
