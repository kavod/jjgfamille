<?

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

require_once($phpbb_root_path . 'functions/functions_selections.php');


if ( $site_config['blog_enable'] != 1 && $userdata['user_level'] != ADMIN && !is_responsable($userdata['user_id'],'blog'))
{
	message_die(GENERAL_MESSAGE,sprintf($lang['Blogs_disable'],append_sid($phpbb_root_path . 'accueil/')));
}

function select_blog($user_id, $obli = true)
{
	return select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '$user_id'",'blog introuvable',$obli);
}

function select_blogger($user_id,$username='')
{
	$obli = ($username == '') ? true : false;
	$val_blogger = select_element("SELECT * FROM `phpbb_users` WHERE `user_id` = '$user_id'",$obli,'Blogger introuvable');
	$val_blogger['user_id'] = $user_id;
	$val_blogger['username'] = ($val_blogger) ? $val_blogger['username'] : $username;
	
	return $val_blogger;
}

function select_cate($cate_id)
{
	return select_element("SELECT * FROM `blogs_cate` WHERE `cate_id` = '$cate_id'",true,'Catégorie introuvable');
}

function select_article($article_id)
{
	return select_element("SELECT * FROM `blogs_articles` WHERE topic_id = '$article_id'",true,'Article introuvable');
}

function forum_avatar($val_poster,$poster_id)
{
	global $phpbb_root_path,$board_config;
	
	$poster_avatar = '';
	if ( $val_poster['user_avatar_type'] && $poster_id != ANONYMOUS && $val_poster['user_allowavatar'] )
	{
		switch( $val_poster['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_path'] . '/' . $val_poster['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $val_poster['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $phpbb_root_path . $board_config['avatar_gallery_path'] . '/' . $val_poster['user_avatar'] . '" alt="" border="0" />' : '';
				break;
		}
	}
	
	return $poster_avatar;
}

function admin_box($user_id)
{
	global $lang,$template,$phpbb_root_path;
	
	$template->assign_block_vars('admin',array(
				'L_ADMIN_BLOG' => $lang['blog_admin'],
				'L_ADMIN' => $lang['blog_admin'],
				'L_ADD' => $lang['Post_new_article'],
				'L_VIEW_MY_BLOG' => $lang['view_my_blog'],
				
				'U_ADMIN' => append_sid('admin.php'),
				'U_ADD' => append_sid('post.php'),
				'U_MY_BLOG' => append_sid($phpbb_root_path . 'blogs/?user_id=' . $user_id),
				)
			);
	$tab_cate = select_liste("SELECT * FROM `blogs_cate` WHERE `user_id` = '" . $user_id . "'");
	
	for ($i=0;$i<count($tab_cate);$i++)
	{
		$template->assign_block_vars('admin.cate',array(
						'CATE_ID' => $tab_cate[$i]['cate_id'],
						'CATE_NAME' => $tab_cate[$i]['cate_name'],
					)
				);
	}
	if ($i<1)
	{
		$template->assign_block_vars('admin.cate',array(
						'CATE_ID' => -1,
						'CATE_NAME' => $lang['Cate_mandatory'],
					)
				);
	}
}

function create_form($tab_setup)
{
	global $theme,$template,$lang;
	for ($i=0;$i<count($tab_setup);$i++)
	{
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	
		$template->assign_block_vars('postrow',array(
							'ROW_CLASS' => $row_class,
							'LABEL' => $tab_setup[$i]['LABEL'],
							'NAME' => $tab_setup[$i]['NAME'],
							'VALUE' => $tab_setup[$i]['VALUE'],
							'SIZE' => $tab_setup[$i]['SIZE'],
							'MAXLENGTH' => $tab_setup[$i]['MAXLENGTH'],
							'EXPLAIN' => $tab_setup[$i]['EXPLAIN'],
						)
					);
							
		if ($tab_setup[$i]['HEADING'] != '')
			$template->assign_block_vars('postrow.heading',array(
							'HEADING' => $tab_setup[$i]['HEADING'],
							'U_ACTION' => $tab_setup[$i]['U_ACTION'],
							)
						);
		switch($tab_setup[$i]['type'])
		{
			case 'text':
				$template->assign_block_vars('postrow.text',array(
									'SIZE' => $tab_setup[$i]['SIZE'],
									'MAXLENGTH' => $tab_setup[$i]['MAXLENGTH'],
									)
								);
				break;
			case 'textarea':
				$template->assign_block_vars('postrow.textarea',array(
									'COLS' => $tab_setup[$i]['COLS'],
									'ROWS' => $tab_setup[$i]['ROWS'],
									)
								);
				break;
			case 'radio':
				for ($j=0;$j<count($tab_setup[$i]['choices']);$j++)
				{
					$template->assign_block_vars('postrow.radio',$tab_setup[$i]['choices'][$j]);
				}
				break;
			case 'select':
				$template->assign_block_vars('postrow.select',array(
								'AUTO' => ($tab_setup[$i]['auto']) ? ' onChange="this.form.submit();"' : '',
								));
				for ($j=0;$j<count($tab_setup[$i]['choices']);$j++)
				{
					$template->assign_block_vars('postrow.select.option',$tab_setup[$i]['choices'][$j]);
				}
				break;
			case 'link':
				$template->assign_block_vars('postrow.link',array(
									'LINK' => append_sid($tab_setup[$i]['LINK']),
									)
								);
				break;
			case 'submit':
				$template->assign_block_vars('postrow.submit',array(
									)
								);
				break;
		}
		
		if ($tab_setup[$i]['U_DELETE'])
		{
			$template->assign_block_vars('postrow.delete',array(
									'U_DELETE' => addslashes($tab_setup[$i]['U_DELETE']),
									'L_CONFIRM' => addslashes(sprintf($lang['Confirm_X'],$tab_setup[$i]['L_CONFIRM'])),
									));
		}
	}
}

function box_profile($user_id,$val_blog,$val_blogger)
{
	global $lang,$template,$phpbb_root_path;
	
	if ($val_blog['enable'] == 'N' || $val_blog['enable'] == 'F')
	{
		$error = true;
		$error_msg = $lang['Caution_inactiv_blog'];
	}
	
	$blogger_avatar = forum_avatar($val_blogger,$user_id);
	
	$template->assign_block_vars('profile',array(
					'L_WHOAMI' => $lang['Who_am_I'],
					'L_MY_PROFILE' => $lang['my_famille_profile'],
					
					'U_PROFILE' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u=' . $user_id),
					
					'BLOGGER_USERNAME' => $val_blogger['username'], //$blogger_username,
					'PROFILE' => bbencode_second_pass(nl2br($val_blog['profile']), $val_blog['bbcode_uid']),
					'BLOGGER_AVATAR' => $blogger_avatar,
					'POSTER_NAME' => $val_blogger['username'],
					)
				);
				
	// Category list
	
	$template->assign_block_vars('switch_cate',array(
						'L_CATEGORIES' => $lang['Category']
						));
	$tab_cate = select_liste("SELECT * FROM `blogs_cate` WHERE `user_id` = '$user_id'");
	for ($i=0;$i<count($tab_cate);$i++)
	{
		$val_posts = select_element("SELECT COUNT(*) FROM `blogs_articles` WHERE `forum_id` = '" . $tab_cate[$i]['cate_id'] . "'",true,'Erreur SQL');
		$template->assign_block_vars('switch_cate.cate',array(
						'U_CATE' => append_sid($phpbb_root_path . 'blogs/?user_id=' . $user_id . '&amp;cate_id=' . $tab_cate[$i]['cate_id']),
						
						'L_CATE' => sprintf("%s (%s)",$tab_cate[$i]['cate_name'],$val_posts[0]),
						)
					);
	}
	
	$template->assign_vars(array(
				'L_ARTICLES' => $lang['My_articles'],
				)
			);
	
	return $tab_cate;
}

function box_calendrier($user_id,$my_timestamp)
{
	global $lang,$template,$phpbb_root_path;
	
	$txt_jour[0] = $lang['datetime']['Mon'];
	$txt_jour[1] = $lang['datetime']['Tue'];
	$txt_jour[2] = $lang['datetime']['Wed'];
	$txt_jour[3] = $lang['datetime']['Thu'];
	$txt_jour[4] = $lang['datetime']['Fri'];
	$txt_jour[5] = $lang['datetime']['Sat'];
	$txt_jour[6] = $lang['datetime']['Sun'];
	
	$str_user = ($user_id > 0) ? '&amp;user_id=' . $user_id : '';
	
	$str_fleche = '<a href="%s">%s</a>';
	
	$url_prev_year = append_sid($phpbb_root_path . 'blogs/?mois=' . date('Ym',mktime(12,0,0,date('m',$my_timestamp),date('d',$my_timestamp),date('Y',$my_timestamp)-1)) . $str_user);
	$url_prev_month = append_sid($phpbb_root_path . 'blogs/?mois=' . date('Ym',mktime(12,0,0,date('m',$my_timestamp)-1,date('d',$my_timestamp),date('Y',$my_timestamp))) . $str_user);
	$url_next_year = append_sid($phpbb_root_path . 'blogs/?mois=' . date('Ym',mktime(12,0,0,date('m',$my_timestamp),date('d',$my_timestamp),date('Y',$my_timestamp)+1)) . $str_user);
	$url_next_month = append_sid($phpbb_root_path . 'blogs/?mois=' . date('Ym',mktime(12,0,0,date('m',$my_timestamp)+1,date('d',$my_timestamp),date('Y',$my_timestamp))) . $str_user);
	
	$str_prev_year = sprintf($str_fleche,$url_prev_year,'<<');
	$str_prev_month = sprintf($str_fleche,$url_prev_month,'<');
	$str_next_year = sprintf($str_fleche,$url_next_year,'>>');
	$str_next_month = sprintf($str_fleche,$url_next_month,'>');
	
	$template->assign_block_vars('calendrier',array(
					'L_MOIS' => $lang['datetime'][date('F',$my_timestamp)] . date(' Y',$my_timestamp),
					'PREV_YEAR' => $str_prev_year,
					'PREV_MONTH' => $str_prev_month,
					'NEXT_YEAR' => $str_next_year,
					'NEXT_MONTH' => $str_next_month,
					));
	
	$template->assign_block_vars('calendrier.semaine',array());
	for ($i=0;$i<7;$i++)
		$template->assign_block_vars('calendrier.semaine.jour',array(
								'NUMBER' => $txt_jour[$i],
								));
	
	$template->assign_block_vars('calendrier.semaine',array());
	$debut = (date('w',mktime(12,0,0,date('m',$my_timestamp),1,date('Y',$my_timestamp)))+6) % 7;
	for ($i=0;$i<$debut;$i++)
		$template->assign_block_vars('calendrier.semaine.jour',array());
	
	$sql = "SELECT article.`topic_id`
		FROM `blogs_articles` article, `blogs_cate` cate, `blogs_blogs` blog 
		WHERE article.`topic_time` >= '%s' 
			AND article.`topic_time` < '%s'
			AND article.`forum_id` = cate.`cate_id`
			AND cate.`user_id` = blog.`user_id`
			AND blog.`enable` = 'Y'
			";
				
	for ($j=$i;$j<7;$j++)
	{
		
		$val_articles = select_element(sprintf($sql,
					mktime(0,0,0,date('m',$my_timestamp),$j+1-$i,date('Y',$my_timestamp)),
					mktime(0,0,0,date('m',$my_timestamp),$j+2-$i,date('Y',$my_timestamp)))
						,'',false);
		
		$template->assign_block_vars('calendrier.semaine.jour',array(
						'NUMBER' => $j+1-$i,
						'CLASS' => (date('d',$my_timestamp) == $j+1-$i) ? 'row3' : '',
						));
		if ($val_articles)
			$template->assign_block_vars('calendrier.semaine.jour.switch_link',array(
							'U_JOUR' => append_sid($phpbb_root_path . 'blogs/?jour=' . mktime(12,0,0,date('m',$my_timestamp),$j+1-$i,date('Y',$my_timestamp))) . $str_user,
							));
	}
	$sql_specific = ($user_id > 0) ? " AND `topic_poster` = '$user_id'" : '';

	while($j<date('d',mktime(12,0,0,date('m',$my_timestamp)+1,0,date('Y',$my_timestamp)))+$i)
	{
		$template->assign_block_vars('calendrier.semaine',array());
		for ($k=0;$k<7;$k++)
		{
			$val_articles = select_element(sprintf($sql,
					mktime(0,0,0,date('m',$my_timestamp),$j+1-$i,date('Y',$my_timestamp)),
					mktime(0,0,0,date('m',$my_timestamp),$j+2-$i,date('Y',$my_timestamp)))
						,'',false);
			
			$template->assign_block_vars('calendrier.semaine.jour',array(
						'NUMBER' => ($j<date('d',mktime(12,0,0,date('m',$my_timestamp)+1,0,date('Y',$my_timestamp)))+$i) ? $j+1-$i : '',
						'CLASS' => (date('d',$my_timestamp) == $j+1-$i) ? 'row3' : '',
						));
			
			if ($val_articles)
				$template->assign_block_vars('calendrier.semaine.jour.switch_link',array(
							'U_JOUR' => append_sid($phpbb_root_path . 'blogs/?jour=' . mktime(12,0,0,date('m',$my_timestamp),$j+1-$i,date('Y',$my_timestamp))) . $str_user,
							));
			
			$j++;
		}
	}
}

function box_last_coms($user_id)
{
	global $lang,$template,$phpbb_root_path;
	
	$sql = "SELECT blog.`title`, cate.`cate_name`, coms.* 
		FROM `blogs_coms` coms, `blogs_cate` cate, `blogs_blogs` blog, `blogs_articles` article
		WHERE 
			blog.`user_id` = cate.`user_id` AND 
			coms.`topic_id` = article.`topic_id` 
			AND article.`forum_id` = cate.`cate_id` 
			AND article.`topic_first_post_id` <> coms.`post_id`
			AND %s 
		ORDER BY `post_time` DESC LIMIT 0,5";
	
		
	$tab_coms = select_liste(sprintf($sql,($user_id>0) ? "blog.`user_id` = '$user_id'" : '1'));
	
	$str_user = ($user_id > 0) ? '&amp;user_id=' . $user_id : '';
	
	for ($i=0;$i<count($tab_coms);$i++)
	{
		$val_poster = get_user($tab_coms[$i]['poster_id'],$tab_coms[$i]['post_username']);
		
		$template->assign_block_vars('last_com',array(
						'L_COM' => sprintf($lang['In'],$val_poster['username'],($user_id>0) ? $tab_coms[$i]['cate_name'] : $tab_coms[$i]['title']),
						
						'U_COM' => append_sid($phpbb_root_path . 'blogs/?article_id=' . $tab_coms[$i]['topic_id'] . $str_user . '#' . $tab_coms[$i]['post_id']),
						));
	}
	
	$template->assign_vars(array(
				'L_LAST_COMS' => $lang['Last_coms'],
				));
}

//
// Delete a post/poll
//
function delete_com($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;

	if ($mode != 'poll_delete')
	{
		require_once($phpbb_root_path . 'includes/functions_search.'.$phpEx);

		$sql = "DELETE FROM `blogs_coms`  
			WHERE post_id = $post_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM `blogs_coms_text`  
			WHERE post_id = $post_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
		}
		if ($post_data['first_post'])
		{
			$forum_update_sql .= ', forum_topics = forum_topics - 1';
			$sql = "DELETE FROM `blogs_articles`  
				WHERE topic_id = $topic_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if ($mode == 'delete' && $post_data['first_post'])
	{
		$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "blogs/?cate_id=" . $forum_id) . '">';
		$message = $lang['Deleted'];
	}
	else
	{
		$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "blogs/?article_id=" . $topic_id) . '">';
		$message = (($mode == 'poll_delete') ? $lang['Poll_delete'] : $lang['Deleted']) . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid($phpbb_root_path . "blogs/?article_id=$topic_id") . '">', '</a>');
	}

	$message .=  '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid($phpbb_root_path . "blogs/?cate_id=" . $forum_id) . '">', '</a>');

	return;
}

function move_article($topic_id_list,$topic_id,$new_forum,$old_forum,$confirm,$user_id,$print=true)
{
	// move_article($HTTP_POST_VARS['topic_id_list'],$topic_id,$HTTP_POST_VARS['new_forum'],$forum_id,$confirm,$user_id)
	global $lang,$userdata,$phpbb_root_path,$template,$phpEx,$db;
	
	$page_title = $lang['Mod_CP'];
	include($phpbb_root_path . 'blogs/page_header.php');

	if ( $confirm )
	{
		if ( empty($topic_id_list) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$new_forum_id = intval($new_forum);
		$old_forum_id = $old_forum;

		// update 2.0.16
		$sql = 'SELECT cate_id "forum_id",cate_name "forum_name" FROM `blogs_cate`
			WHERE cate_id = ' . $new_forum_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select from categories table', '', __LINE__, __FILE__, $sql);
		}
		$val_to_forum = $db->sql_fetchrowset($result);
		if (!$val_to_forum)
		{
			message_die(GENERAL_MESSAGE, 'New category does not exist');
		}
		// fin de l'update

		$db->sql_freeresult($result);
		
		//require_once($phpbb_root_path . 'functions/functions_selections.php');
		$val_from_forum = select_element("SELECT cate_name \"forum_name\" FROM `blogs_cate` WHERE cate_id = '$old_forum_id'",true,'catégorie introuvable');

		if ( $new_forum_id != $old_forum_id )
		{
			$topics = ( isset($topic_id_list) ) ?  $topic_id_list : array($topic_id);

			$topic_list = '';
			for($i = 0; $i < count($topics); $i++)
			{
				$topic_list .= ( ( $topic_list != '' ) ? ', ' : '' ) . intval($topics[$i]);
			}

			$sql = "SELECT * 
				FROM `blogs_articles` 
				WHERE topic_id IN ($topic_list)
					AND forum_id = $old_forum_id
					AND topic_status <> " . TOPIC_MOVED;
			if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from articles table', '', __LINE__, __FILE__, $sql);
			}

			$row = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);

			for($i = 0; $i < count($row); $i++)
			{
				$topic_id = $row[$i]['topic_id'];
				
				/*if ( isset($HTTP_POST_VARS['move_leave_shadow']) )
				{
					// Insert topic in the old forum that indicates that the forum has moved.
					$sql = "INSERT INTO " . TOPICS_TABLE . " (forum_id, topic_title, topic_poster, topic_time, topic_status, topic_type, topic_vote, topic_views, topic_replies, topic_first_post_id, topic_last_post_id, topic_moved_id)
						VALUES ($old_forum_id, '" . addslashes(str_replace("\'", "''", $row[$i]['topic_title'])) . "', '" . str_replace("\'", "''", $row[$i]['topic_poster']) . "', " . $row[$i]['topic_time'] . ", " . TOPIC_MOVED . ", " . POST_NORMAL . ", " . $row[$i]['topic_vote'] . ", " . $row[$i]['topic_views'] . ", " . $row[$i]['topic_replies'] . ", " . $row[$i]['topic_first_post_id'] . ", " . $row[$i]['topic_last_post_id'] . ", $topic_id)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
					}
				}*/

				$sql = "UPDATE `blogs_articles` 
					SET forum_id = $new_forum_id  
					WHERE topic_id = $topic_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update old article', '', __LINE__, __FILE__, $sql);
				}

				$sql = "UPDATE `blogs_coms`  
					SET forum_id = $new_forum_id 
					WHERE topic_id = $topic_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update coms article ids', '', __LINE__, __FILE__, $sql);
				}
				
				
				
				/*
				// Pour le dernier post, on ajoute le message d'explication
				$val_last_post = select_element("SELECT post_id FROM " . POSTS_TABLE . " WHERE topic_id = $topic_id ORDER BY post_time DESC");
				$val_text = select_element("SELECT bbcode_uid FROM " . POSTS_TEXT_TABLE . " WHERE post_id = " . $val_last_post['post_id'],true,'message introuvable');
				
				$sql = "UPDATE " . POSTS_TEXT_TABLE . " SET post_text = CONCAT(post_text,'\r\n\r\n[i:" . $val_text['bbcode_uid'] . "]" . addslashes(sprintf($lang['has_been_moved'],$val_text['bbcode_uid'],$userdata['username'],$val_text['bbcode_uid'])."\r\n").$_POST['cause_of_move']."[/i:" . $val_text['bbcode_uid'] . "]') WHERE post_id = " . $val_last_post['post_id'];
				if (!mysql_query($sql))
					die(mysql_error()."<br />Fichier : " . __FILE__ . "<br />Ligne : " . __LINE__);
				
				// On sélectionne la liste des posteurs affectés
				$tab_posts = select_liste("SELECT poster_id FROM " . POSTS_TABLE . " WHERE topic_id = $topic_id GROUP BY poster_id");
				
				// On envoie un email à tous les utilisateurs affectés
				include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
				for ($j=0;$j<count($tab_posts);$j++)
				{
					$val_poster = select_element("SELECT username,user_email,user_lang FROM " . USERS_TABLE . " WHERE user_id = " . $tab_posts[$j]['poster_id'],false,'');
					if ($val_poster && $tab_posts[$j]['poster_id']!=-1)
					{
						$emailer = new emailer($board_config['smtp_delivery']);
			
						$emailer->from($board_config['board_email']);
						$emailer->replyto($board_config['board_email']);
						
						$emailer->use_template('move_notification', $val_poster['user_lang']);
						$emailer->email_address($val_poster['user_email']);
						$emailer->set_subject($lang['move_notification']);
							
						$emailer->assign_vars(array(
							'USERNAME' => $val_poster['username'],
							'SUBJECT' => $row[$i]['topic_title'],
							'FROM_FORUM' => $val_from_forum['forum_name'],
							'TO_FORUM' => $val_to_forum[0]['forum_name'],
							'REASON' => $_POST['cause_of_move'],
							'EMAIL_SIG' => $board_config['board_email_sig']
						));
						
						$emailer->send();
						$emailer->reset();
					}
				}*/
			}

			// Sync the forum indexes
			/*sync('forum', $new_forum_id);
			sync('forum', $old_forum_id);*/

			$message = $lang['Blogs_Articles_Moved'] . '<br /><br />';

		}
		else
		{
			$message = $lang['Blogs_No_Articles_Moved'] . '<br /><br />';
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = append_sid($phpbb_root_path . "blogs/?article_id=$topic_id");
			$message .= sprintf($lang['Blogs_Click_return_article'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = $phpbb_root_path . "blogs/?user_id=" . $user_id;
			$message .= sprintf($lang['Click_return_blog'], '<a href="' . $redirect_page . '">', '</a>');
		}

		//$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$old_forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		if ($print)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
			);
	
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else
	{
		if ( empty($topic_id_list) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="move" /><input type="hidden" name="forum_id" value="' . $forum_id . '" />';

		if ( isset($topic_id_list) )
		{
			$topics = $topic_id_list;

			for($i = 0; $i < count($topics); $i++)
			{
				$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
			}
		}
		else
		{
			$hidden_fields .= '<input type="hidden" name="article_id" value="' . $topic_id . '" />';
		}

		//
		// Set template files
		//
		$template->set_filenames(array(
			'movetopic' => 'blogs/modcp_move.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Confirm'],
			'MESSAGE_TEXT' => $lang['Confirm_move_blog_article'],

			'L_MOVE_TO_FORUM' => $lang['Move_to_cate'], 
			/*'CAUSE_MOVE' => $lang['cause_of_move'], */
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],

			'S_FORUM_SELECT' => make_forum_select('new_forum', $user_id, $old_forum), 
			'S_MODCP_ACTION' => append_sid($phpbb_root_path . "blogs/post.php"),
			'S_HIDDEN_FIELDS' => $hidden_fields)
		);

		$template->pparse('movetopic');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}

//
// Simple version of jumpbox, just lists authed forums
//
function make_forum_select($box_name, $user_id, $ignore_forum = false, $select_forum = '')
{
	global $db, $userdata;

	$is_auth_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata);

	$sql = 'SELECT cate_id, cate_name
		FROM `blogs_cate` 
		WHERE user_id = ' . $user_id . ' 
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
			$forum_list .= '<option value="' . $row['cate_id'] . '"' . $selected .'>' . $row['cate_name'] . '</option>';
		}
	}

	$forum_list = ( $forum_list == '' ) ? '<option value="-1">-- ! No Forums ! --</option>' : '<select name="' . $box_name . '">' . $forum_list . '</select>';

	return $forum_list;
}

function supp_blog_cate($forum_id)
{
	$forum_id = intval($forum_id);
	if ($forum_id<1)
		die("cate_id incorrect : " . $forum_id);
	
	$sql = "SELECT * FROM `blogs_coms` WHERE `forum_id` = '$forum_id'";
	$tab_coms = select_liste($sql);
	
	for ($i=0;$i<count($tab_coms);$i++)
	{
		$post_row = array('first_post' => true);
		delete_com(
			'delete', 
			$post_row, 
			$message, 
			$meta, 
			$forum_id, 
			$tab_coms[$i]['topic_id'], 
			$tab_coms[$i]['post_id'], 
			$poll_id);
	}
	
	$sql = "DELETE FROM `blogs_auth` WHERE `forum_id` = '$forum_id'";
	mysql_query($sql);
	
	$sql = "DELETE FROM `blogs_cate` WHERE `cate_id` = '$forum_id'";
	mysql_query($sql);
}

function supp_blog($user_id)
{
	$user_id = intval($user_id);
	if ($user_id<1)
		die("user_id incorrect : " . $user_id);
	
	$sql = "SELECT * FROM `blogs_cate` WHERE `user_id` = '$user_id'";
	$tab_cate = select_liste($sql);
	for ($i=0;$i<count($tab_cate);$i++)
	{
		supp_blog_cate($tab_cate[$i]['cate_id']);
	}
	
	$sql = "DELETE FROM `blogs_boxes` WHERE `user_id` = '$user_id'";
	mysql_query($sql);
	
	$sql = "DELETE FROM `blogs_blogs` WHERE `user_id` = '$user_id'";
	mysql_query($sql);
}

function create_category($new_cate,$blogger_id)
{
	// create_category($_POST['new_cate'],$blogger_id)
	$sql = "INSERT INTO `blogs_cate` (`cate_name`, `user_id`, `auth_view` , `auth_read` , `auth_post` , `auth_reply` , `auth_edit` , `auth_delete` , `auth_sticky` , `auth_announce` , `auth_vote` , `auth_pollcreate` , `auth_attachments`) VALUES ('" . trim($new_cate) . "','" . $blogger_id . "',0,0,3,0,3,3,5,5,5,5,5)";
	mysql_query($sql);
	
	$cate_id = mysql_insert_id();
	
	$val_group = select_element("SELECT groupe.`group_id` 
					FROM `phpbb_groups` groupe, `phpbb_user_group` asso 
					WHERE asso.`user_id` = '" . $blogger_id . "' AND asso.`group_id` = groupe.`group_id` AND groupe.`group_single_user` = '1'",'groupe introuvable',false);
	$sql = "INSERT INTO `blogs_auth` VALUES ('" . $val_group['group_id'] . "','$cate_id',0,0,1,0,1,1,0,0,0,0,0,1)";
	mysql_query($sql);
	
	return $cate_id;
}

function reindex_array($my_array)
{
	$sans_doublon = array_unique($my_array);
	$index_sans_doublon = array_keys($sans_doublon);
	$result = array();
	for ($i=0;$i<count($index_sans_doublon);$i++)
		$result[$i] = $sans_doublon[$index_sans_doublon[$i]];
	return $result;
}

function readDatabase($data,$mode='atom') 
{
	$keys = array(
			'atom' => 'entry',
			'rss' => 'item',
		);
			

	// lit la base de données xml des acides aminés
	//$data = implode("",file($filename));
	$parser = xml_parser_create();
	xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
	xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	xml_parse_into_struct($parser,$data,$values,$tags);
	xml_parser_free($parser);
	
	// boucle à travers les structures
	foreach ($tags as $key=>$val) 
	{
		if ($key == $keys[$mode]) 
		{
			$molranges = $val;
			// each contiguous pair of array entries are the
			// lower and upper range for each molecule definition
			for ($i=0; $i < count($molranges); $i+=2) 
			{
				$offset = $molranges[$i] + 1;
				$len = $molranges[$i + 1] - $offset;
				$tdb[] = parseMol(array_slice($values, $offset, $len));
			}
		} else {
			continue;
		}
	}
	return $tdb;
}
	
function parseMol($mvalues) 
{
	for ($i=0; $i < count($mvalues); $i++)
		$mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
	return $mol;
}


$tab_utf81 = array();
$tab_utf82 = array();

$tab_utf81[] = '&Aacute;';$tab_utf82[] = '|&#193;|';
$tab_utf81[] = '&aacute;';$tab_utf82[] = '|&#225;|';

$tab_utf81[] = '&Acirc;';$tab_utf82[] = '|&#194;|';
$tab_utf81[] = '&acirc;';$tab_utf82[] = '|&#226;|';
$tab_utf81[] = '&acute;';$tab_utf82[] = '|&#180;|';
$tab_utf81[] = '&AElig;';$tab_utf82[] = '|&#198;|';
$tab_utf81[] = '&aelig;';$tab_utf82[] = '|&#230;|';
$tab_utf81[] = '&Agrave;';$tab_utf82[] = '|&#192;|';

$tab_utf81[] = '&agrave;';$tab_utf82[] = '|&#224;|';
$tab_utf81[] = '&alefsym;';$tab_utf82[] = '|&#8501;|';
$tab_utf81[] = '&Alpha;';$tab_utf82[] = '|&#913;|';
$tab_utf81[] = '&alpha;';$tab_utf82[] = '|&#945;|';
$tab_utf81[] = '&amp;';$tab_utf82[] = '|&#38;|';
$tab_utf81[] = '&and;';$tab_utf82[] = '|&#8743;|';

$tab_utf81[] = '&ang;';$tab_utf82[] = '|&#8736;|';
$tab_utf81[] = '&Aring;';$tab_utf82[] = '|&#197;|';
$tab_utf81[] = '&aring;';$tab_utf82[] = '|&#229;|';
$tab_utf81[] = '&asymp;';$tab_utf82[] = '|&#8776;|';
$tab_utf81[] = '&Atilde;';$tab_utf82[] = '|&#195;|';
$tab_utf81[] = '&atilde;';$tab_utf82[] = '|&#227;|';

$tab_utf81[] = '&Auml;';$tab_utf82[] = '|&#196;|';
$tab_utf81[] = '&auml;';$tab_utf82[] = '|&#228;|';
$tab_utf81[] = '&bdquo;';$tab_utf82[] = '|&#8222;|';
$tab_utf81[] = '&Beta;';$tab_utf82[] = '|&#914;|';
$tab_utf81[] = '&beta;';$tab_utf82[] = '|&#946;|';
$tab_utf81[] = '&brvbar;';$tab_utf82[] = '|&#166;|';

$tab_utf81[] = '&bull;';$tab_utf82[] = '|&#8226;|';
$tab_utf81[] = '&cap;';$tab_utf82[] = '|&#8745;|';
$tab_utf81[] = '&Ccedil;';$tab_utf82[] = '|&#199;|';
$tab_utf81[] = '&ccedil;';$tab_utf82[] = '|&#231;|';
$tab_utf81[] = '&cedil;';$tab_utf82[] = '|&#184;|';
$tab_utf81[] = '&cent;';$tab_utf82[] = '|&#162;|';

$tab_utf81[] = '&Chi;';$tab_utf82[] = '|&#935;|';
$tab_utf81[] = '&chi;';$tab_utf82[] = '|&#967;|';
$tab_utf81[] = '&circ;';$tab_utf82[] = '|&#710;|';
$tab_utf81[] = '&clubs;';$tab_utf82[] = '|&#9827;|';
$tab_utf81[] = '&cong;';$tab_utf82[] = '|&#8773;|';
$tab_utf81[] = '&copy;';$tab_utf82[] = '|&#169;|';

$tab_utf81[] = '&crarr;';$tab_utf82[] = '|&#8629;|';
$tab_utf81[] = '&cup;';$tab_utf82[] = '|&#8746;|';
$tab_utf81[] = '&curren;';$tab_utf82[] = '|&#164;|';
$tab_utf81[] = '&dagger;';$tab_utf82[] = '|&#8224;|';
$tab_utf81[] = '&Dagger;';$tab_utf82[] = '|&#8225;|';
$tab_utf81[] = '&darr;';$tab_utf82[] = '|&#8595;|';

$tab_utf81[] = '&dArr;';$tab_utf82[] = '|&#8659;|';
$tab_utf81[] = '&deg;';$tab_utf82[] = '|&#176;|';
$tab_utf81[] = '&Delta;';$tab_utf82[] = '|&#916;|';
$tab_utf81[] = '&delta;';$tab_utf82[] = '|&#948;|';
$tab_utf81[] = '&diams;';$tab_utf82[] = '|&#9830;|';
$tab_utf81[] = '&divide;';$tab_utf82[] = '|&#247;|';

$tab_utf81[] = '&Eacute;';$tab_utf82[] = '|&#201;|';
$tab_utf81[] = '&eacute;';$tab_utf82[] = '|&#233;|';
$tab_utf81[] = '&Ecirc;';$tab_utf82[] = '|&#202;|';
$tab_utf81[] = '&ecirc;';$tab_utf82[] = '|&#234;|';
$tab_utf81[] = '&Egrave;';$tab_utf82[] = '|&#200;|';
$tab_utf81[] = '&egrave;';$tab_utf82[] = '|&#232;|';

$tab_utf81[] = '&empty;';$tab_utf82[] = '|&#8709;|';
$tab_utf81[] = '&emsp;';$tab_utf82[] = '|&#8195;|';
$tab_utf81[] = '&ensp;';$tab_utf82[] = '|&#8194;|';
$tab_utf81[] = '&Epsilon;';$tab_utf82[] = '|&#917;|';
$tab_utf81[] = '&epsilon;';$tab_utf82[] = '|&#949;|';
$tab_utf81[] = '&equiv;';$tab_utf82[] = '|&#8801;|';

$tab_utf81[] = '&Eta;';$tab_utf82[] = '|&#919;|';
$tab_utf81[] = '&eta;';$tab_utf82[] = '|&#951;|';
$tab_utf81[] = '&ETH;';$tab_utf82[] = '|&#208;|';
$tab_utf81[] = '&eth;';$tab_utf82[] = '|&#240;|';
$tab_utf81[] = '&Euml;';$tab_utf82[] = '|&#203;|';
$tab_utf81[] = '&euml;';$tab_utf82[] = '|&#235;|';

$tab_utf81[] = '&euro;';$tab_utf82[] = '|&#8364;|';
$tab_utf81[] = '&exist;';$tab_utf82[] = '|&#8707;|';
$tab_utf81[] = '&fnof;';$tab_utf82[] = '|&#402;|';
$tab_utf81[] = '&forall;';$tab_utf82[] = '|&#8704;|';
$tab_utf81[] = '&frac12;';$tab_utf82[] = '|&#189;|';
$tab_utf81[] = '&frac14;';$tab_utf82[] = '|&#188;|';

$tab_utf81[] = '&frac34;';$tab_utf82[] = '|&#190;|';
$tab_utf81[] = '&frasl;';$tab_utf82[] = '|&#8260;|';
$tab_utf81[] = '&Gamma;';$tab_utf82[] = '|&#915;|';
$tab_utf81[] = '&gamma;';$tab_utf82[] = '|&#947;|';
$tab_utf81[] = '&ge;';$tab_utf82[] = '|&#8805;|';
$tab_utf81[] = '&gt;';$tab_utf82[] = '|&#62;|';

$tab_utf81[] = '&harr;';$tab_utf82[] = '|&#8596;|';
$tab_utf81[] = '&hArr;';$tab_utf82[] = '|&#8660;|';
$tab_utf81[] = '&hearts;';$tab_utf82[] = '|&#9829;|';
$tab_utf81[] = '&hellip;';$tab_utf82[] = '|&#8230;|';
$tab_utf81[] = '&Iacute;';$tab_utf82[] = '|&#205;|';
$tab_utf81[] = '&iacute;';$tab_utf82[] = '|&#237;|';

$tab_utf81[] = '&Icirc;';$tab_utf82[] = '|&#206;|';
$tab_utf81[] = '&icirc;';$tab_utf82[] = '|&#238;|';
$tab_utf81[] = '&iexcl;';$tab_utf82[] = '|&#161;|';
$tab_utf81[] = '&Igrave;';$tab_utf82[] = '|&#204;|';
$tab_utf81[] = '&igrave;';$tab_utf82[] = '|&#236;|';
$tab_utf81[] = '&image;';$tab_utf82[] = '|&#8465;|';

$tab_utf81[] = '&infin;';$tab_utf82[] = '|&#8734;|';
$tab_utf81[] = '&int;';$tab_utf82[] = '|&#8747;|';
$tab_utf81[] = '&Iota;';$tab_utf82[] = '|&#921;|';
$tab_utf81[] = '&iota;';$tab_utf82[] = '|&#953;|';
$tab_utf81[] = '&iquest;';$tab_utf82[] = '|&#191;|';
$tab_utf81[] = '&isin;';$tab_utf82[] = '|&#8712;|';

$tab_utf81[] = '&Iuml;';$tab_utf82[] = '|&#207;|';
$tab_utf81[] = '&iuml;';$tab_utf82[] = '|&#239;|';
$tab_utf81[] = '&Kappa;';$tab_utf82[] = '|&#922;|';
$tab_utf81[] = '&kappa;';$tab_utf82[] = '|&#954;|';
$tab_utf81[] = '&Lambda;';$tab_utf82[] = '|&#923;|';
$tab_utf81[] = '&lambda;';$tab_utf82[] = '|&#955;|';

$tab_utf81[] = '&lang;';$tab_utf82[] = '|&#9001;|';
$tab_utf81[] = '&laquo;';$tab_utf82[] = '|&#171;|';
$tab_utf81[] = '&larr;';$tab_utf82[] = '|&#8592;|';
$tab_utf81[] = '&lArr;';$tab_utf82[] = '|&#8656;|';
$tab_utf81[] = '&lceil;';$tab_utf82[] = '|&#8968;|';
$tab_utf81[] = '&ldquo;';$tab_utf82[] = '|&#8220;|';

$tab_utf81[] = '&le;';$tab_utf82[] = '|&#8804;|';
$tab_utf81[] = '&lfloor;';$tab_utf82[] = '|&#8970;|';
$tab_utf81[] = '&lowast;';$tab_utf82[] = '|&#8727;|';
$tab_utf81[] = '&loz;';$tab_utf82[] = '|&#9674;|';
$tab_utf81[] = '&lrm;';$tab_utf82[] = '|&#8206;|';
$tab_utf81[] = '&lsaquo;';$tab_utf82[] = '|&#8249;|';

$tab_utf81[] = '&lsquo;';$tab_utf82[] = '|&#8216;|';
$tab_utf81[] = '&lt;';$tab_utf82[] = '|&#60;|';
$tab_utf81[] = '&macr;';$tab_utf82[] = '|&#175;|';
$tab_utf81[] = '&mdash;';$tab_utf82[] = '|&#8212;|';
$tab_utf81[] = '&micro;';$tab_utf82[] = '|&#181;|';
$tab_utf81[] = '&middot;';$tab_utf82[] = '|&#183;|';

$tab_utf81[] = '&minus;';$tab_utf82[] = '|&#8722;|';
$tab_utf81[] = '&Mu;';$tab_utf82[] = '|&#924;|';
$tab_utf81[] = '&mu;';$tab_utf82[] = '|&#956;|';
$tab_utf81[] = '&nabla;';$tab_utf82[] = '|&#8711;|';
$tab_utf81[] = '&nbsp;';$tab_utf82[] = '|&#160;|';
$tab_utf81[] = '&ndash;';$tab_utf82[] = '|&#8211;|';

$tab_utf81[] = '&ne;';$tab_utf82[] = '|&#8800;|';
$tab_utf81[] = '&ni;';$tab_utf82[] = '|&#8715;|';
$tab_utf81[] = '&not;';$tab_utf82[] = '|&#172;|';
$tab_utf81[] = '&notin;';$tab_utf82[] = '|&#8713;|';
$tab_utf81[] = '&nsub;';$tab_utf82[] = '|&#8836;|';
$tab_utf81[] = '&Ntilde;';$tab_utf82[] = '|&#209;|';

$tab_utf81[] = '&ntilde;';$tab_utf82[] = '|&#241;|';
$tab_utf81[] = '&Nu;';$tab_utf82[] = '|&#925;|';
$tab_utf81[] = '&nu;';$tab_utf82[] = '|&#957;|';
$tab_utf81[] = '&Oacute;';$tab_utf82[] = '|&#211;|';
$tab_utf81[] = '&oacute;';$tab_utf82[] = '|&#243;|';
$tab_utf81[] = '&Ocirc;';$tab_utf82[] = '|&#212;|';

$tab_utf81[] = '&ocirc;';$tab_utf82[] = '|&#244;|';
$tab_utf81[] = '&OElig;';$tab_utf82[] = '|&#338;|';
$tab_utf81[] = '&oelig;';$tab_utf82[] = '|&#339;|';
$tab_utf81[] = '&Ograve;';$tab_utf82[] = '|&#210;|';
$tab_utf81[] = '&ograve;';$tab_utf82[] = '|&#242;|';
$tab_utf81[] = '&oline;';$tab_utf82[] = '|&#8254;|';

$tab_utf81[] = '&Omega;';$tab_utf82[] = '|&#937;|';
$tab_utf81[] = '&omega;';$tab_utf82[] = '|&#969;|';
$tab_utf81[] = '&Omicron;';$tab_utf82[] = '|&#927;|';
$tab_utf81[] = '&omicron;';$tab_utf82[] = '|&#959;|';
$tab_utf81[] = '&oplus;';$tab_utf82[] = '|&#8853;|';
$tab_utf81[] = '&or;';$tab_utf82[] = '|&#8744;|';

$tab_utf81[] = '&ordf;';$tab_utf82[] = '|&#170;|';
$tab_utf81[] = '&ordm;';$tab_utf82[] = '|&#186;|';
$tab_utf81[] = '&Oslash;';$tab_utf82[] = '|&#216;|';
$tab_utf81[] = '&oslash;';$tab_utf82[] = '|&#248;|';
$tab_utf81[] = '&Otilde;';$tab_utf82[] = '|&#213;|';
$tab_utf81[] = '&otilde;';$tab_utf82[] = '|&#245;|';

$tab_utf81[] = '&otimes;';$tab_utf82[] = '|&#8855;|';
$tab_utf81[] = '&Ouml;';$tab_utf82[] = '|&#214;|';
$tab_utf81[] = '&ouml;';$tab_utf82[] = '|&#246;|';
$tab_utf81[] = '&para;';$tab_utf82[] = '|&#182;|';
$tab_utf81[] = '&part;';$tab_utf82[] = '|&#8706;|';
$tab_utf81[] = '&permil;';$tab_utf82[] = '|&#8240;|';

$tab_utf81[] = '&perp;';$tab_utf82[] = '|&#8869;|';
$tab_utf81[] = '&Phi;';$tab_utf82[] = '|&#934;|';
$tab_utf81[] = '&phi;';$tab_utf82[] = '|&#966;|';
$tab_utf81[] = '&Pi;';$tab_utf82[] = '|&#928;|';
$tab_utf81[] = '&pi;';$tab_utf82[] = '|&#960;|';
$tab_utf81[] = '&piv;';$tab_utf82[] = '|&#982;|';

$tab_utf81[] = '&plusmn;';$tab_utf82[] = '|&#177;|';
$tab_utf81[] = '&pound;';$tab_utf82[] = '|&#163;|';
$tab_utf81[] = '&prime;';$tab_utf82[] = '|&#8242;|';
$tab_utf81[] = '&Prime;';$tab_utf82[] = '|&#8243;|';
$tab_utf81[] = '&prod;';$tab_utf82[] = '|&#8719;|';
$tab_utf81[] = '&prop;';$tab_utf82[] = '|&#8733;|';

$tab_utf81[] = '&Psi;';$tab_utf82[] = '|&#936;|';
$tab_utf81[] = '&psi;';$tab_utf82[] = '|&#968;|';
$tab_utf81[] = '&quot;';$tab_utf82[] = '|&#34;|';
$tab_utf81[] = '&radic;';$tab_utf82[] = '|&#8730;|';
$tab_utf81[] = '&rang;';$tab_utf82[] = '|&#9002;|';
$tab_utf81[] = '&raquo;';$tab_utf82[] = '|&#187;|';

$tab_utf81[] = '&rarr;';$tab_utf82[] = '|&#8594;|';
$tab_utf81[] = '&rArr;';$tab_utf82[] = '|&#8658;|';
$tab_utf81[] = '&rceil;';$tab_utf82[] = '|&#8969;|';
$tab_utf81[] = '&rdquo;';$tab_utf82[] = '|&#8221;|';
$tab_utf81[] = '&real;';$tab_utf82[] = '|&#8476;|';
$tab_utf81[] = '&reg;';$tab_utf82[] = '|&#174;|';

$tab_utf81[] = '&rfloor;';$tab_utf82[] = '|&#8971;|';
$tab_utf81[] = '&Rho;';$tab_utf82[] = '|&#929;|';
$tab_utf81[] = '&rho;';$tab_utf82[] = '|&#961;|';
$tab_utf81[] = '&rlm;';$tab_utf82[] = '|&#8207;|';
$tab_utf81[] = '&rsaquo;';$tab_utf82[] = '|&#8250;|';
$tab_utf81[] = '&rsquo;';$tab_utf82[] = '|&#8217;|';

$tab_utf81[] = '&sbquo;';$tab_utf82[] = '|&#8218;|';
$tab_utf81[] = '&Scaron;';$tab_utf82[] = '|&#352;|';
$tab_utf81[] = '&scaron;';$tab_utf82[] = '|&#353;|';
$tab_utf81[] = '&sdot;';$tab_utf82[] = '|&#8901;|';
$tab_utf81[] = '&sect;';$tab_utf82[] = '|&#167;|';
$tab_utf81[] = '&shy;';$tab_utf82[] = '|&#173;|';

$tab_utf81[] = '&Sigma;';$tab_utf82[] = '|&#931;|';
$tab_utf81[] = '&sigma;';$tab_utf82[] = '|&#963;|';
$tab_utf81[] = '&sigmaf;';$tab_utf82[] = '|&#962;|';
$tab_utf81[] = '&sim;';$tab_utf82[] = '|&#8764;|';
$tab_utf81[] = '&spades;';$tab_utf82[] = '|&#9824;|';
$tab_utf81[] = '&sub;';$tab_utf82[] = '|&#8834;|';

$tab_utf81[] = '&sube;';$tab_utf82[] = '|&#8838;|';
$tab_utf81[] = '&sum;';$tab_utf82[] = '|&#8721;|';
$tab_utf81[] = '&sup;';$tab_utf82[] = '|&#8835;|';
$tab_utf81[] = '&sup1;';$tab_utf82[] = '|&#185;|';
$tab_utf81[] = '&sup2;';$tab_utf82[] = '|&#178;|';
$tab_utf81[] = '&sup3;';$tab_utf82[] = '|&#179;|';

$tab_utf81[] = '&supe;';$tab_utf82[] = '|&#8839;|';
$tab_utf81[] = '&szlig;';$tab_utf82[] = '|&#223;|';
$tab_utf81[] = '&Tau;';$tab_utf82[] = '|&#932;|';
$tab_utf81[] = '&tau;';$tab_utf82[] = '|&#964;|';
$tab_utf81[] = '&there4;';$tab_utf82[] = '|&#8756;|';
$tab_utf81[] = '&Theta;';$tab_utf82[] = '|&#920;|';

$tab_utf81[] = '&theta;';$tab_utf82[] = '|&#952;|';
$tab_utf81[] = '&thetasym;';$tab_utf82[] = '|&#977;|';
$tab_utf81[] = '&thinsp;';$tab_utf82[] = '|&#8201;|';
$tab_utf81[] = '&THORN;';$tab_utf82[] = '|&#222;|';
$tab_utf81[] = '&thorn;';$tab_utf82[] = '|&#254;|';
$tab_utf81[] = '&tilde;';$tab_utf82[] = '|&#732;|';

$tab_utf81[] = '&times;';$tab_utf82[] = '|&#215;|';
$tab_utf81[] = '&trade;';$tab_utf82[] = '|&#8482;|';
$tab_utf81[] = '&Uacute;';$tab_utf82[] = '|&#218;|';
$tab_utf81[] = '&uacute;';$tab_utf82[] = '|&#250;|';
$tab_utf81[] = '&uarr;';$tab_utf82[] = '|&#8593;|';
$tab_utf81[] = '&uArr;';$tab_utf82[] = '|&#8657;|';

$tab_utf81[] = '&Ucirc;';$tab_utf82[] = '|&#219;|';
$tab_utf81[] = '&ucirc;';$tab_utf82[] = '|&#251;|';
$tab_utf81[] = '&Ugrave;';$tab_utf82[] = '|&#217;|';
$tab_utf81[] = '&ugrave;';$tab_utf82[] = '|&#249;|';
$tab_utf81[] = '&uml;';$tab_utf82[] = '|&#168;|';
$tab_utf81[] = '&upsih;';$tab_utf82[] = '|&#978;|';

$tab_utf81[] = '&Upsilon;';$tab_utf82[] = '|&#933;|';
$tab_utf81[] = '&upsilon;';$tab_utf82[] = '|&#965;|';
$tab_utf81[] = '&Uuml;';$tab_utf82[] = '|&#220;|';
$tab_utf81[] = '&uuml;';$tab_utf82[] = '|&#252;|';
$tab_utf81[] = '&weierp;';$tab_utf82[] = '|&#8472;|';
$tab_utf81[] = '&Xi;';$tab_utf82[] = '|&#926;|';

$tab_utf81[] = '&xi;';$tab_utf82[] = '|&#958;|';
$tab_utf81[] = '&Yacute;';$tab_utf82[] = '|&#221;|';
$tab_utf81[] = '&yacute;';$tab_utf82[] = '|&#253;|';
$tab_utf81[] = '&yen;';$tab_utf82[] = '|&#165;|';
$tab_utf81[] = '&Yuml;';$tab_utf82[] = '|&#376;|';
$tab_utf81[] = '&yuml;';$tab_utf82[] = '|&#255;|';

$tab_utf81[] = '&Zeta;';$tab_utf82[] = '|&#918;|';
$tab_utf81[] = '&zeta;';$tab_utf82[] = '|&#950;|';
$tab_utf81[] = '&zwj;';$tab_utf82[] = '|&#8205;|';
$tab_utf81[] = '&zwnj;';$tab_utf82[] = '|&#8204;|';

define('ERR_CATE_UNEXIST',-1);

class Blog_article
{
	var $title;
	var $content;
	var $cate_id;
	var $completed;
	var $user_id;
	var $topic_id;
	var $post_id;
	
	function Blog_article($title,$content,$user_id,$cate_id = -1)
	{
		$this->title = $title;
		$this->content = $content;
		$val_user = get_user($user_id,'Anonyme');
		if ($val_user['user_id']<0)
			die('Utilisateur inexistant');
		$this->user_id = $user_id;
		$this->completed = false;
		$this->cate_id = intval($cate_id);
		$this->topic_id = -1;
		$this->post_id = -1;
	}
	
	function is_completed()
	{
		$cate_id = $this->cate_id;
		if ($cate_id>0)
		{
			if (blog_cate_exist($cate_id,$this->user_id))
			{
				// OK
			} else
			{
				return ERR_CATE_UNEXIST;
			}
		} else
		{
			$this->complete = false;
			return ERR_CATE_UNEXIST;
		}
		
		$this->completed = true;
		return 0;
	}
	
	function set_cate($cate_id)
	{
		$cate_id = intval($cate_id);
		if (blog_cate_exist($cate_id,$user_id=-1))
		{
			$this->cate_id = $cate_id;
		}
		else
			return ERR_CATE_UNEXIST;
	}
	
	function article_exist()
	{
		$sql = "SELECT `topic_id`,`forum_id`, `topic_first_post_id` FROM `blogs_articles` WHERE `topic_poster` = '" . $this->user_id . "' AND `topic_title` = '" . addslashes($this->title) . "'";
		$val_article = select_element($sql,false,'');
		if ($val_article)
		{
			$this->topic_id = $val_article['topic_id'];
			$this->post_id = $val_article['topic_first_post_id'];
			$this->cate_id = $val_article['forum_id'];
		} else
		{
			$this->topic_id = -1;
			$this->post_id = -1;
		}
	}
}

function blog_cate_exist($cate_id,$user_id=-1)
{
	$cate_id = intval($cate_id);
	$user_id = intval($user_id);
	$sql = "SELECT `cate_id` FROM `blogs_cate` WHERE `cate_id` = '$cate_id'";
	$sql .= ($user_id>0) ? " AND `user_id` = '$user_id'" : '';
	$val_cate = select_element($sql,'',false);
	
	if ($val_cate)
		return true;
	else
		return false;
}
?>