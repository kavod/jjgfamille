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

$board_config['allow_html'] = true;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_BLOGS);
init_userprefs($userdata);
//
// End session management
//

require_once($phpbb_root_path . 'functions/functions_blog.php');
//
// Start output of page
//
define('SHOW_ONLINE', true);

// Article_id
if (isset($_GET['article_id']) && (int)($_GET['article_id']) > 0)
{
	$article_id = $_GET['article_id'];
	$val_article = select_article($article_id);
}
else
	$article_id = -1;

// Category
if ($article_id > 0 || (isset($_GET['cate_id']) && (int)($_GET['cate_id']) > 0))
{
	$cate_id = ($article_id > 0) ? $val_article['forum_id'] : $_GET['cate_id'];
	$val_cate = select_cate($cate_id);
}
else
	$cate_id = -1;

// User_id
if ($cate_id > 0 || (isset($_GET['user_id']) && (int)($_GET['user_id']) > 0))
{
	$user_id =  ($cate_id > 0) ? $val_cate['user_id'] : $_GET['user_id'];
	$val_blog = select_blog($user_id);
	$val_blogger = select_blogger($user_id, $val_blog['username']);
}
else
	$user_id = -1;

// mois
if (isset($_GET['mois']) && (int)($_GET['mois']) > 0)
{
	$mois = $_GET['mois'];
	$my_timestamp = mktime(12,0,0,substr($mois,4,2),1,substr($mois,0,4));
} else
{
	$mois = -1;
}

// jour
if (isset($_GET['jour']) && (int)($_GET['jour']) > 0)
{
	$jour = $_GET['jour'];
	$my_timestamp = $_GET['jour'];
} else
{
	$jour = -1;
	if ($mois < 0)
		$my_timestamp = mktime();
}

if ($user_id > 0)
{
	// We are in a particular blog
	// Loading of the blog data
	$page_title = $val_blog['title'] . " :: " . $lang['Blogs'];
	
	$blog_header = bbencode_second_pass(nl2br($val_blog['header']), $val_blog['bbcode_uid']);
	
} else
{
	$user_id = -1;
	$page_title = $board_config['sitename'] . " :: " . $lang['Blogs'];
	$blog_header = $lang['Blogs_presentation'];
}

include($phpbb_root_path . 'blogs/page_header.php');

$template->set_filenames(array(
	'body' => 'blogs/index_body.tpl',
	'colonneDroite' => 'blogs/colonne_droite.tpl',
	'box_blogs' => 'blogs/box_blogs.tpl',
	'box_calendrier' => 'blogs/box_calendrier.tpl',
	'box_profile' => 'blogs/box_profile.tpl',
	'box_admin' => 'blogs/box_admin.tpl',
	'box_last_coms' => 'blogs/box_last_coms.tpl'
)
);

$template->assign_vars(array(
			'L_POSTED' => $lang['Posted'],
			'L_POST_SUBJECT' => $lang['Post_subject'],
			'L_COMMENTS' => $lang['Comments'],
			
			'BLOG_HEADER' => $blog_header,
			
			)
			);

// Archives
$template->assign_block_vars('switch_archives',array(
					'L_ARCHIVES' => $lang['Archives']
					));
$tab_archives = select_liste("SELECT article.*, FROM_UNIXTIME(article.topic_time,'%Y%m') mois, COUNT(*) counter 
				FROM `blogs_articles` article, `blogs_cate` cate, `blogs_blogs` blog
				WHERE article.`forum_id` = cate.`cate_id`
					AND cate.`user_id` = blog.`user_id`
					AND blog.`enable` = 'Y'
				GROUP BY mois 
				ORDER BY mois DESC");
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

// Admin
$has_blog = false;
if ( $userdata['session_logged_in'] )
{
	$val_my_blog = select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '" . $userdata['user_id'] . "'",'',false);
	if ($val_my_blog)
	{
		$has_blog = true;
		
		admin_box($userdata['user_id']);
	}
}

if (!$has_blog && $user_id < 0)
{
	$template->assign_block_vars('subscribe',array(
					'L_SUBSCRIBE' => $lang['Your_blog_on_famille'],
					
					'U_SUBSCRIBE' => append_sid('admin.php?mode=subscribe'),
					));
}

$sql = "SELECT a.*, c.auth_view, c.auth_read FROM `blogs_articles` a, `blogs_cate` c, `blogs_blogs` blog WHERE blog.`user_id` = c.`user_id` AND c.`cate_id` = a.`forum_id` AND (`blog`.`enable` = 'Y' OR %s) AND %s ORDER BY topic_time DESC LIMIT 0,10";

if ($user_id > 0)
{
	$sql_own_blog = ($userdata['user_id'] == $user_id || $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog')) ? "`blog`.`user_id` = '$user_id'" : "0";
	
	$tab_cate = box_profile($user_id,$val_blog,$val_blogger);
	
	if ($cate_id > 0)
	{
		
		if ($article_id > 0)
		{
			// 1 article only must be displayed
			// Show coms too
			$sql_specific = "`topic_id` = '$article_id'";
			$tab_articles = select_liste(sprintf($sql,$sql_own_blog,$sql_specific));
			$show_coms = true;
		} else
		{
			// Category must be display
			// All posts (without coms) should be shown
			$sql_specific = "`forum_id` = '$cate_id'";
			$tab_articles = select_liste(sprintf($sql,$sql_own_blog,$sql_specific));
			$show_coms = false;
		}
	} else
	{
		if ($mois > 0)
		{
			// articles of the month (without coms)
			$sql_specific = "`topic_time` >= " . $my_timestamp . " AND `topic_time` < " .  mktime(0,0,0,substr($mois,4,2)+1,1,substr($mois,0,4)) . " AND `topic_poster` = '$user_id'";
			$tab_articles= select_liste(sprintf($sql,$sql_own_blog,$sql_specific));
			$show_coms = false;
		} else
		{
			if ($jour > 0)
			{
				// articles of the day (without coms)
				$sql_specific = "`topic_time` >= " . mktime(0,0,0,date('m',$my_timestamp),date('d',$my_timestamp),date('Y',$my_timestamp)) . " AND `topic_time` < " .  mktime(0,0,0,date('m',$my_timestamp),date('d',$my_timestamp)+1,date('Y',$my_timestamp)) . " AND `topic_poster` = '$user_id'";
				$tab_articles= select_liste(sprintf($sql,$sql_own_blog,$sql_specific));
				$show_coms = false;
			} else
			{
				// 10 last articles (without coms)
				$sql_specific = "`topic_poster` = '$user_id'";
				$tab_articles = select_liste(sprintf($sql,$sql_own_blog,$sql_specific));
				$show_coms = false;
			}
		}
	}
	/*
	// Déplacé dans la fonction box_profile
	$template->assign_vars(array(
				'L_ARTICLES' => $lang['My_articles'],
				)
			);*/
} else
{
	if ($article_id > 0)
	{
		// 1 article only must be displayed
		// Show coms too
		$sql_specific = "`topic_id` = '$article_id'";
		$tab_articles = select_liste(sprintf($sql,0,$sql_specific));
		$show_coms = true;
	} else
	{
		if ($mois > 0)
		{
			// articles of the month (without coms)
			$sql_specific = "`topic_time` >= " . $my_timestamp . " AND `topic_time` < " . mktime(0,0,0,substr($mois,4,2)+1,1,substr($mois,0,4));
			$tab_articles= select_liste(sprintf($sql,0,$sql_specific));
			$show_coms = false;
		} else
		{
			if ($jour > 0)
			{
				// articles of the day (without coms)
				$sql_specific = "`topic_time` >= " . mktime(0,0,0,date('m',$my_timestamp),date('d',$my_timestamp),date('Y',$my_timestamp)) . " AND `topic_time` < " . mktime(0,0,0,date('m',$my_timestamp),date('d',$my_timestamp)+1,date('Y',$my_timestamp));
				$tab_articles= select_liste(sprintf($sql,0,$sql_specific));
				$show_coms = false;
			} else
			{
				$sql_specific = "1";
				$tab_articles = select_liste(sprintf($sql,0,$sql_specific));
				$show_coms = false;
			}
		}
	}
	$template->assign_vars(array(
				'L_ARTICLES' => $lang['Blogs'],
				)
			);
}

if (count($tab_articles)<1)
	list($error,$error_msg) = array(true,$lang['Blogs_no_article']);

for ($k=0;$k<count($tab_articles);$k++)
{
	//
	// Start auth check
	//
	$is_auth = array();
	$is_auth = auth(AUTH_ALL, -$tab_articles[$k]['forum_id'], $userdata, '');
	
	$template->assign_block_vars('boite', array());

	if( !$is_auth['auth_view'] || !$is_auth['auth_read'] )
	{
		if ( !$userdata['session_logged_in'] )
		{
			$redirect = ($post_id) ? POST_POST_URL . "=$post_id" : POST_TOPIC_URL . "=$topic_id";
			$redirect .= ($start) ? "&start=$start" : '';
			redirect(append_sid("forum/login.$phpEx?redirect=forum/viewtopic.$phpEx&$redirect", true));
		}
	
		$message = ( !$is_auth['auth_view'] ) ? $lang['Topic_post_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);
	
		message_die(GENERAL_MESSAGE, $message);
	}
	//
	// End auth check
	//

	$str_limit = ($show_coms) ? '' : ' LIMIT 0,1';
	
	$sql = "SELECT * 
			FROM `blogs_coms` p, `phpbb_users` u, `blogs_coms_text` pt 
			WHERE p.poster_id = u.user_id AND p.post_id = pt.post_id AND `topic_id` = '" . $tab_articles[$k]['topic_id'] . "'
			ORDER BY post_time 
			$str_limit";
	
	$postrow = select_liste($sql);
	
	for ($i=0;$i<count($postrow);$i++)
	{
		$poster_id = $postrow[$i]['user_id'];
		$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];
	
		$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);
	
		$poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $postrow[$i]['user_posts'] : '';
	
		$poster_from = ( $postrow[$i]['user_from'] && $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $postrow[$i]['user_from'] : '';
	
		$poster_joined = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Joined'] . ': ' . create_date($lang['DATE_FORMAT'], $postrow[$i]['user_regdate'], $board_config['board_timezone']) : '';
	
		/*$poster_avatar = '';
		if ( $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] )
		{
			switch( $postrow[$i]['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_REMOTE:
					$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_GALLERY:
					$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;
			}
		}*/
		$poster_avatar = forum_avatar($postrow[$i],$poster_id);
	
		//
		// Define the little post icon
		//
		if ( $userdata['session_logged_in'] && $postrow[$i]['post_time'] > $userdata['user_lastvisit'] && $postrow[$i]['post_time'] > $topic_last_read )
		{
			$mini_post_img = $images['icon_minipost_new'];
			$mini_post_alt = $lang['New_post'];
		}
		else
		{
			$mini_post_img = $images['icon_minipost'];
			$mini_post_alt = $lang['Post'];
		}
		
		if ($user_id > 0)
			$mini_post_url = append_sid('?user_id=' . $user_id . '&amp;article_id=' . $postrow[$i]['topic_id']) . '#' . $postrow[$i]['post_id'];
		else
			$mini_post_url = append_sid('?article_id=' . $postrow[$i]['topic_id']) . '#' . $postrow[$i]['post_id'];
	
		//
		// Generate ranks, set them to empty string initially.
		//
		$poster_rank = '';
		$rank_image = '';
		if ( $postrow[$i]['user_id'] == ANONYMOUS )
		{
		}
		else if ( $postrow[$i]['user_rank'] )
		{
			for($j = 0; $j < count($ranksrow); $j++)
			{
				if ( $postrow[$i]['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
				{
					$poster_rank = $ranksrow[$j]['rank_title'];
					$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
				}
			}
		}
		else
		{
			for($j = 0; $j < count($ranksrow); $j++)
			{
				if ( $postrow[$i]['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
				{
					$poster_rank = $ranksrow[$j]['rank_title'];
					$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
				}
			}
		}
	
		//
		// Handle anon users posting with usernames
		//
		if ( $poster_id == ANONYMOUS && $postrow[$i]['post_username'] != '' )
		{
			$poster = $postrow[$i]['post_username'];
			$poster_rank = $lang['Guest'];
		}
	
		$temp_url = '';
	
		if ( $poster_id != ANONYMOUS )
		{
			$temp_url = append_sid($phpbb_root_path . "forum/profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
			$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
			$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';
	
			$temp_url = append_sid($phpbb_root_path . "forum/privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
			$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
			$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';
	
			if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )
			{
				$email_uri = ( $board_config['board_email_form'] ) ? append_sid($phpbb_root_path . "forum/profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];
	
				$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
				$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
			}
			else
			{
				$email_img = '';
				$email = '';
			}
	
			$nofollow = (strpos($postrow[$i]['user_website'],$_SERVER['HTTP_HOST'])===false) ? ' rel="nofollow"' : '';
			$www_img = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww"' . $nofollow . '><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
			$www = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';
	
			if ( !empty($postrow[$i]['user_icq']) )
			{
				$icq_status_img = '<a href="http://wwp.icq.com/' . $postrow[$i]['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $postrow[$i]['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
				$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
				$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '">' . $lang['ICQ'] . '</a>';
			}
			else
			{
				$icq_status_img = '';
				$icq_img = '';
				$icq = '';
			}
			
			// blog button
			
			$val_his_blog = select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '" . $postrow[$i]['user_id'] . "'",'',false);
			if ($val_his_blog)
			{
				$blog_img = '<a href="' . $phpbb_root_path . 'blogs/?user_id=' . $postrow[$i]['user_id'] . '"><img src="' . $images['icon_blog'] . '" alt="' . $lang['User_blog'] . '" title="' . $lang['User_blog'] . '" border="0"></a>';
			} else
			{
				$blog_img = '';
			}
	
			$aim_img = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
			$aim = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';
	
			$temp_url = append_sid($phpbb_root_path . "forum/profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
			$msn_img = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
			$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
	
			$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
			$yim = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
		}
		else
		{
			$profile_img = '';
			$profile = '';
			$pm_img = '';
			$pm = '';
			$email_img = '';
			$email = '';
			$www_img = '';
			$www = '';
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
			$aim_img = '';
			$aim = '';
			$msn_img = '';
			$msn = '';
			$yim_img = '';
			$yim = '';
			$blog_img = '';
		}
	
		$temp_url = append_sid($phpbb_root_path . "forum/search.$phpEx?search_author=" . urlencode($postrow[$i]['username']) . "&amp;showresults=posts");
		$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" title="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" border="0" /></a>';
		$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '</a>';
	
		if ( ( $userdata['user_id'] == $poster_id && $is_auth['auth_edit'] ) || $is_auth['auth_mod'] )
		{
			$temp_url = append_sid($phpbb_root_path . "blogs/post.php?mode=editpost&amp;p=" . $postrow[$i]['post_id']);
			$edit_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['Edit_delete_post'] . '" title="' . $lang['Edit_delete_post'] . '" border="0" /></a>';
			$edit = '<a href="' . $temp_url . '">' . $lang['Edit_delete_post'] . '</a>';
		}
		else
		{
			$edit_img = '';
			$edit = '';
		}
	
		if ( $is_auth['auth_mod'] )
		{
			$temp_url = $phpbb_root_path . "blogs/modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'];
			$ip_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_ip'] . '" alt="' . $lang['View_IP'] . '" title="' . $lang['View_IP'] . '" border="0" /></a>';
			$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';
	
			$temp_url = $phpbb_root_path . "blogs/post.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
			$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
			$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
			
			$topic_mod = "<a href=\"" . $phpbb_root_path . "blogs/post.php?article_id=" . $postrow[$i]['topic_id'] . "&amp;mode=move&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';

		}
		else
		{
			$ip_img = '';
			$ip = '';
	
			if ( $userdata['user_id'] == $poster_id && $is_auth['auth_delete'] && $forum_topic_data['topic_last_post_id'] == $postrow[$i]['post_id'] )
			{
				$temp_url = $phpbb_root_path . "blogs/post.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
				$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
				$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
			}
			else
			{
				$delpost_img = '';
				$delpost = '';
			}
		}
	
		$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';
	
		$message = $postrow[$i]['post_text'];
		$bbcode_uid = $postrow[$i]['bbcode_uid'];
	
		$user_sig = ( $postrow[$i]['enable_sig'] && $postrow[$i]['user_sig'] != '' && $board_config['allow_sig'] ) ? $postrow[$i]['user_sig'] : '';
		//$user_sig = str_replace('[img','&#91;img',$user_sig);
		$user_sig = preg_replace('|\[img:[0-9a-f]+\]([^\[]*)\[/img:[0-9a-f]+\]|i','&#91;img]$1[/img]',$user_sig);
		$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];
	
		//
		// Note! The order used for parsing the message _is_ important, moving things around could break any
		// output
		//
	
		//
		// If the board has HTML off but the post has HTML
		// on then we process it, else leave it alone
		//
		/*if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'])
		{
			if ( $user_sig != '' )
			{
				$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
			}
	
			if ( $postrow[$i]['enable_html'] )
			{
				$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
			}
		}*/
	
		//
		// Parse message and/or sig for BBCode if reqd
		//
		if ($user_sig != '' && $user_sig_bbcode_uid != '')
		{
				$user_sig = ($board_config['allow_bbcode']) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
		}
	
		if ($bbcode_uid != '')
		{
			$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
		}
	
		if ( $user_sig != '' )
		{
			$user_sig = make_clickable($user_sig);
		}
		$message = make_clickable($message);
	
		//
		// Parse smilies
		//
		if ( $board_config['allow_smilies'] )
		{
			if ( $postrow[$i]['user_allowsmile'] && $user_sig != '' )
			{
				$user_sig = smilies_pass($user_sig);
			}
	
			if ( $postrow[$i]['enable_smilies'] )
			{
				$message = smilies_pass($message);
			}
		}
	
		//
		// Highlight active words (primarily for search)
		//
		if ($highlight_match)
		{
			// This was shamelessly 'borrowed' from volker at multiartstudio dot de
			// via php.net's annotated manual
			/* update 2.0.16
			$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace('#\b(" . str_replace('\\', '\\\\', $highlight_match) . ")\b#i', '<span style=\"color:#" . $theme['fontcolor3'] . "\"><b>\\\\1</b></span>', '\\0')", '>' . $message . '<'), 1, -1)); */
			// Boris 11/06/2006
			// Update 2.0.21
			/*
			$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace('#\b(" . str_replace('\\', '\\\\', addslashes($highlight_match)) . ")\b#i', '<span style=\"color:#" . $theme['fontcolor3'] . "\"><b>\\\\1</b></span>', '\\0')", '>' . $message . '<'), 1, -1));
			*/
			// This has been back-ported from 3.0 CVS
			$message = preg_replace('#(?!<.*)(?<!\w)(' . $highlight_match . ')(?!\w|[^<>]*>)#i', '<b style="color:#'.$theme['fontcolor3'].'">\1</b>', $message);
			// fin update 2.0.21
			// fin update 2.0.16
		}
	
		//
		// Replace naughty words
		//
		if (count($orig_word))
		{
			$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
	
			if ($user_sig != '')
			{
				$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
			}
	
			$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
		}
	
		//
		// Replace newlines (we use this rather than nl2br because
		// till recently it wasn't XHTML compliant)
		//
		if ( $user_sig != '' )
		{
			$user_sig = '<br />_________________<br />' . str_replace("\n", "\n<br />\n", $user_sig);
		}
	
		$message = str_replace("\n", "\n<br />\n", $message);
	
		//
		// Editing information
		//
		if ( $postrow[$i]['post_edit_count'] )
		{
			$l_edit_time_total = ( $postrow[$i]['post_edit_count'] == 1 ) ? $lang['Edited_time_total'] : $lang['Edited_times_total'];
	
			$l_edited_by = '<br /><br />' . sprintf($l_edit_time_total, $poster, create_date($board_config['default_dateformat'], $postrow[$i]['post_edit_time'], $board_config['board_timezone']), $postrow[$i]['post_edit_count']);
		}
		else
		{
			$l_edited_by = '';
		}
		
		if ($i<1)
		{
			$val_nb_coms = select_element("SELECT COUNT(*) FROM `blogs_coms` WHERE `topic_id` = '" . $postrow[$i]['topic_id'] . "'");
			$nb_coms = $val_nb_coms[0];
			// NB comments
			if ($nb_coms<2)
				$nb_comments = $lang['blog_no_comment'];
			else
				$nb_comments = ($nb_coms>2) ? sprintf($lang['blog_x_comments'],$nb_coms-1) : $lang['blog_1_comment'];
			
		}
			// article link
			$u_article = append_sid("?user_id=" . $poster_id . "&amp;article_id=" . $postrow[$i]['topic_id']);
		
		//
		// Again this will be handled by the templating
		// code at some point
		//
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	
		$template->assign_block_vars('boite.postrow', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'POSTER_NAME' => $poster,
			'POSTER_RANK' => $poster_rank,
			'RANK_IMAGE' => $rank_image,
			'POSTER_JOINED' => $poster_joined,
			'POSTER_POSTS' => $poster_posts,
			'POSTER_FROM' => $poster_from,
			'POSTER_AVATAR' => $poster_avatar,
			'POST_NUMBER' => ($i + $start + 1),
			'POST_DATE' => $post_date,
			'POST_SUBJECT' => $post_subject,
			'MESSAGE' => $message,
			'SIGNATURE' => $user_sig,
			'EDITED_MESSAGE' => $l_edited_by,
	
			'MINI_POST_IMG' => $mini_post_img,
			'PROFILE_IMG' => $profile_img,
			'PROFILE' => $profile,
			'SEARCH_IMG' => $search_img,
			'SEARCH' => $search,
			'PM_IMG' => $pm_img,
			'PM' => $pm,
			'EMAIL_IMG' => $email_img,
			'EMAIL' => $email,
			'WWW_IMG' => $www_img,
			'WWW' => $www,
			'ICQ_STATUS_IMG' => $icq_status_img,
			'ICQ_IMG' => $icq_img,
			'ICQ' => $icq,
			'AIM_IMG' => $aim_img,
			'AIM' => $aim,
			'MSN_IMG' => $msn_img,
			'MSN' => $msn,
			'YIM_IMG' => $yim_img,
			'YIM' => $yim,
			'EDIT_IMG' => $edit_img,
			'EDIT' => $edit,
			/*'IP_IMG' => $ip_img,
			'IP' => $ip,*/
			'DELETE_IMG' => $delpost_img,
			'DELETE' => $delpost,
			'NB_COMMENTS' => $nb_comments,
			'BLOG_IMG' => $blog_img,
			'MOVE' => $topic_mod,
	
			'L_MINI_POST_ALT' => $mini_post_alt,
	
			'U_MINI_POST' => $mini_post_url,
			'U_POST_ID' => $postrow[$i]['post_id'],
			'U_ARTICLE' => $u_article,
			'U_COMS' => ($show_coms) ? '#coms' : $u_article . '#coms',
			)
		);
		
		if ($i<1)
			$template->assign_block_vars('boite.postrow.switch_principal', array());
		 else
			$template->assign_block_vars('boite.postrow.switch_detail', array());
		
		if ($user_id < 0)
			$template->assign_block_vars('boite.postrow.switch_detail', array());
			
		if ($i>0 || $user_id > -1)
			$template->assign_block_vars('boite.postrow.date', array());
	}
}

if ($show_coms && $val_blog['readonly'] == 'N')
{
	$s_hidden_form_fields = '';
	$str = '<input type="hidden" name="%s" value="%s" />';
	$s_hidden_form_fields .= sprintf($str,'article_id',$article_id);
	$s_hidden_form_fields .= sprintf($str,'mode','reply');
	$s_hidden_form_fields .= sprintf($str,'disable_html','1');
	$s_hidden_form_fields .= sprintf($str,'disable_bbcode','1');
	$s_hidden_form_fields .= sprintf($str,'attach_sig','');
	$s_hidden_form_fields .= sprintf($str,'forum_id',$tab_articles[0]['forum_id']);
	
	$u_action = append_sid('post.php');
	
	$template->assign_block_vars('boite.reply',array(
					'L_LEAVE_YOUR_COMMENT' => $lang['Leave_your_comment'],
					'L_POST_SUBJECT' => $lang['Post_subject'],
					'L_USERNAME' => $lang['Username'],
					'L_IDENTIFY' => sprintf($lang['famille_user_identify'],'<a href="' . append_sid($phpbb_root_path . 'forum/login.php?redirect=blogs/&amp;user_id=' . $user_id . '&amp;article_id=' . $article_id.'">'),'</a>'),
					'L_SUBJECT' => $lang['Subject'],
					'L_MESSAGE' => $lang['Message_body'],
					'L_SUBMIT' => $lang['Submit'],
					
					'U_ACTION' => $u_action,
					
					'S_HIDDEN_FORM_FIELDS' => $s_hidden_form_fields,
					));
	if ( !$userdata['session_logged_in'] )
		$template->assign_block_vars('boite.reply.switch_username_select',array());
}

if ($user_id < 0)
{
	$template->assign_block_vars('bloggers',array(
				'L_TITLE' => $lang['The_bloggers'],
				'L_BY' => $lang['by'],
	));
	
	$tab_blogs = select_liste("SELECT blog.*, COUNT(article.topic_id) nb_articles 
					FROM `blogs_blogs` blog, `blogs_cate` cate, `blogs_articles` article 
					WHERE blog.user_id = cate.user_id AND cate.cate_id = article.forum_id AND blog.`enable` = 'Y'
					GROUP BY user_id, username, title
					ORDER BY nb_articles DESC");
	
	for ($i=0;$i<count($tab_blogs);$i++)
	{
		$val_user = get_user($tab_blogs[$i]['user_id'],$tab_blogs[$i]['username']);
		
		$template->assign_block_vars('bloggers.blogger',array(
								'L_USER' => $val_user['username'],
								'L_BLOG' => $tab_blogs[$i]['title'],
								
								'U_USER' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&amp;u=' . $val_user['user_id']),
								'U_BLOG' => append_sid('?user_id=' . $val_user['user_id']),
								
								'NB_ARTICLES' => $tab_blogs[$i]['nb_articles'],
								
						));
	}
}

box_calendrier($user_id,$my_timestamp);
box_last_coms($user_id);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'blog'))
{
	$template->assign_block_vars('administrator',array(
					'L_ADMIN' => $lang['General_settings'],
					
					'U_ADMIN' => append_sid('admin_blogs.php'),
					));
}

$sql = "SELECT * FROM `blogs_boxes` WHERE `user_id` = '$user_id' AND `enable` = 'Y' ORDER BY `ordre`";
$tab_boxes = select_liste($sql);
if ($has_blog)
	array_unshift ($tab_boxes, array('box' => 'box_admin'));

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
