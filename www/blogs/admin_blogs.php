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

// blogger_id
if ((isset($_POST['blogger_id']) && (int)($_POST['blogger_id']) > 0) || (isset($_GET['blogger_id']) && (int)($_GET['blogger_id']) > 0))
{
	$blogger_id = (isset($_POST['blogger_id']) && (int)($_POST['blogger_id']) > 0) ? $_POST['blogger_id'] : $_GET['blogger_id'];
	$val_blog = select_blog($blogger_id,false);
	if ($val_blog)
	{
		$val_blogger = select_blogger($blogger_id, $val_blog['username']);
	} else
	{
		$val_blogger = select_element("SELECT * FROM phpbb_users WHERE user_id = '" . $val_blog['user_id'] . "'",false,'User introuvable');
		if ($val_blogger)
		{
			$error = true;
			$error_msg = sprintf($lang['Has_no_blog'],$val_blogger['username']);
		} else
		{
			$error = true;
			$error_msg = sprintf($lang['Auth_Anonymous_Users'],$val_blogger['username']);
		}
		$blogger_id = -1;
	}
}
else
	$blogger_id = -1;

if ( !$userdata['session_logged_in'])
{
	include($phpbb_root_path . 'includes/log_necessary.php');
} else
{
	if ( $userdata['user_level'] != ADMIN && !is_responsable($userdata['user_id'],'blog'))
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_not_blog_admin']));
	}
	$page_title = $lang['Blogs'] . " :: " . $lang['General_settings'];
}



$tab_cate = select_liste("SELECT * FROM `blogs_cate` WHERE `user_id` = '" . $userdata['user_id'] . "'");

if ($_GET['mode'] == 'edit_properties')
{
	/*
	$val_doublon = select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '" . $userdata['user_id'] . "'",'',false);
	
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
		
		if ($_GET['mode'] == 'edit_properties')
		{*/
			$blog_enable = $_POST['blog_enable'];
			$sql = "UPDATE `famille_config` 
				SET 
					`valeur_num` = '$blog_enable'
				WHERE `param` = 'blog_enable'";
			$message = $lang['Configuration_edited'];
		/*} else
		{
			$sql = "INSERT INTO blogs_blogs (`user_id`, `username`, `title`, `subtitle`, `header`, `profile`, `bbcode_uid`)
				VALUES ('" . $userdata['user_id'] . "','" . $userdata['username'] . "','$title','$subtitle','$header','$profile','$bbcode_uid')";
			$message = $lang['Blog_created'];
		}*/
		mysql_query($sql);
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_blogs.php") . '">')
		);
		$message =  sprintf($message, '<a href="' . append_sid("admin_blogs.php") . '">', '</a>');
		
		message_die(GENERAL_MESSAGE, sprintf($message));
		exit();/*
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
		$sql = "INSERT INTO `blogs_cate` (`cate_name`, `user_id`, `auth_view` , `auth_read` , `auth_post` , `auth_reply` , `auth_edit` , `auth_delete` , `auth_sticky` , `auth_announce` , `auth_vote` , `auth_pollcreate` , `auth_attachments`) VALUES ('" . trim($_POST['new_cate']) . "','" . $userdata['user_id'] . "',0,0,3,0,3,3,5,5,5,5,5)";
		mysql_query($sql);
		
		$cate_id = mysql_insert_id();
		
		$val_group = select_element("SELECT groupe.`group_id` 
						FROM `phpbb_groups` groupe, `phpbb_user_group` asso 
						WHERE asso.`user_id` = '" . $userdata['user_id'] . "' AND asso.`group_id` = groupe.`group_id` AND groupe.`group_single_user` = '1'",'groupe introuvable',false);
		$sql = "INSERT INTO `blogs_auth` VALUES ('" . $val_group['group_id'] . "','$cate_id',0,0,1,0,1,1,0,0,0,0,0,1)";
		mysql_query($sql);
	}
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin.php") . '">')
		);
		$message =  sprintf($lang['Properties_edited'], '<a href="' . append_sid("admin.php") . '">', '</a>');
		
		message_die(GENERAL_MESSAGE, sprintf($message));
		exit();
		
} else if($_GET['mode'] == 'subscribe')
{
	$val_doublon = select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '" . $userdata['user_id'] . "'",'',false);
	
	if ($val_doublon)
	{
		$_GET['mode'] = '';
		list($error,$error_msg) = array(true,$lang['Blog_already_exists']);
	}	
	$u_action = append_sid('admin.php?mode=dosubscribe');*/
} else if($_GET['mode'] == 'del_blog')
{
	$val_blog = select_element("SELECT * FROM `blogs_blogs` WHERE `user_id` = '" . $_GET['user_id'] . "'",'blog introuvable',true);
	
	supp_blog($val_blog['user_id']);
	
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_blogs.php") . '">')
	);
	$message =  sprintf($lang['Blog_deleted'], '<a href="' . append_sid("admin_blogs.php") . '">', '</a>');
	
	message_die(GENERAL_MESSAGE, $message);
	exit();
} else
{
	$u_action = append_sid('admin_blogs.php?mode=edit_properties');
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
			'BLOG_HEADER' => $lang['Blogs'] . " :: " . $lang['General_settings'],
			
			'L_DELETE' => $lang['Delete'],
			)
			);

$tab_setup = array(
		array(
			'HEADING' => $lang['General_settings'],
			'U_ACTION' => $u_action,
			'LABEL' => $lang['Switch_activation_rub'],
			'type' => 'radio',
			'NAME' => 'blog_enable',
			'choices' => array(
					array(
						'TEXT' => $lang['Enabled'],
						'VALUE' => 1,
						'CHECKED' => ($site_config['blog_enable'] == 1) ? ' CHECKED' : '',
						),
					array(
						'TEXT' => $lang['Disabled'],
						'VALUE' => 0,
						'CHECKED' => ($site_config['blog_enable'] == 0) ? ' CHECKED' : '',
						),
					),
			),
		array(
			'LABEL' => '',
			'type' => 'submit',
			'NAME' => 'enable_blog',
			'VALUE' => $lang['Submit'],
			)
		);

$tab_blogs = select_liste("SELECT * FROM `blogs_blogs` ORDER BY `title`");
for ($i=0;$i<count($tab_blogs);$i++)
{
	$select_liste[$i] = array(
				'TEXT' => $tab_blogs[$i]['title'],
				'VALUE' => $tab_blogs[$i]['user_id'],
				'SELECTED' => ($blogger_id == $tab_blogs[$i]['user_id']) ? ' SELECTED' : '',
				);
}

$tab_setup[] = array(
			'HEADING' => $lang['Admin_a_blog'],
			'U_ACTION' => append_sid($phpbb_root_path . "blogs/admin_blogs.php"),
			'LABEL' => $lang['Blogger'],
			'type' => 'select',
			'NAME' => 'blogger_id',
			'auto' => true,
			'choices' => $select_liste,
			);
			
$tab_setup[] = array(
			'LABEL' => '',
			'type' => 'submit',
			'NAME' => 'select_blog',
			'VALUE' => $lang['Go'],
		);
		
if ($blogger_id > 0)
{
	/*$tab_setup[] = array(
			'LABEL' => $lang['Switch_readonly'],
			'type' => 'radio',
			'NAME' => 'readonly',
			'choices' => array(
					array(
						'TEXT' => $lang['Enabled'],
						'VALUE' => 1,
						'CHECKED' => ($site_config['blog_enable'] == 1) ? ' CHECKED' : '',
						),
					array(
						'TEXT' => $lang['Disabled'],
						'VALUE' => 0,
						'CHECKED' => ($site_config['blog_enable'] == 0) ? ' CHECKED' : '',
						),
					),
			);*/
	$tab_setup[] = array(
			'HEADING' => $val_blog['title'],
			'U_ACTION' => append_sid($phpbb_root_path . "blogs/admin_blogs.php"),
			'LABEL' => $lang['Admin_of_blog'],
			'VALUE' => sprintf($lang['Config_blog'],$val_blog['title']),
			'type' => 'link',
			'LINK' => $phpbb_root_path . 'blogs/admin.php?blogger_id=' . $val_blog['user_id'],
			'U_DELETE' => append_sid('admin_blogs.php?mode=del_blog&amp;user_id='.$val_blog['user_id']),
			'L_CONFIRM' => $val_blog['title'],
			);
}

/*if ($_GET['mode'] != 'subscribe')
{
	for($i=0;$i<count($tab_cate);$i++)
	{
		$tab_setup[] = array(
				'LABEL' => '',
				'type' => 'text',
				'NAME' => 'cate' . $tab_cate[$i]['cate_id'],
				'VALUE' => $tab_cate[$i]['cate_name'],
				'SIZE' => '50',
				'MAXLENGTH' => '60',
				'U_DELETE' => append_sid('admin.php?mode=del_cate&amp;cate_id='.$tab_cate[$i]['cate_id']),
					);
		if ($i < 1)
		{
			$tab_setup[count($tab_setup)-1]['HEADING'] = 'Catégories';
			$tab_setup[count($tab_setup)-1]['U_ACTION'] = append_sid('admin.php?mode=edit_cate');
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
		$tab_setup[count($tab_setup)-1]['U_ACTION'] = append_sid('admin.php?mode=edit_cate');
	}
	
	$tab_setup[] = array(
				'LABEL' => '',
				'type' => 'submit',
				'NAME' => 'submit',
				'VALUE' => $lang['Submit'],
				);

	admin_box($userdata['user_id']);
}*/

create_form($tab_setup);
/*for ($i=0;$i<count($tab_setup);$i++)
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
								'U_DELETE' => $tab_setup[$i]['U_DELETE']
								));
	}
}*/

/*for ($i=0;$i<count($tab_cate);$i++)
{
	$template->assign_block_vars('admin.cate',array(
					'CATE_ID' => $tab_cate[$i]['cate_id'],
					'CATE_NAME' => $tab_cate[$i]['cate_name'],
				)
			);
}*/

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
admin_box($blogger_id);
box_profile($blogger_id,$val_blog,$val_blogger);
box_calendrier($blogger_id,mktime());
box_last_coms($blogger_id);

$sql = "SELECT * FROM `blogs_boxes` WHERE `user_id` = '-1' AND `enable` = 'Y' ORDER BY `ordre`";
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
