<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
require_once($phpbb_root_path . 'functions/url_rewriting.php');

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management
//

$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])); 
$server_name = trim($board_config['server_name']); 
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://'; 
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/'; 
$server_url = $server_protocol . $server_name . $server_port . $script_name;
if(substr($server_url, -1, 1) != "/")
	{
	$server_url .= "/";
	}

$template->set_filenames(array("body" => "sitemap_body.tpl"));
$template->assign_vars(array(
		'BOARD_URL' => $server_url)
	);
	
//Get a list of publicly viewable forums
//Thanks to Kieran007 for supplying the sql for this
$sql = "SELECT forum_id FROM ". FORUMS_TABLE ." WHERE auth_read=0";
if ( !($result = $db->sql_query($sql)) )
	{
	message_die(GENERAL_ERROR, 'Error getting permissions', '', __LINE__, __FILE__, $sql);
	}
$ids = $db->sql_fetchrowset($result);
$row = 0;
while($row <= count($ids) -1)
	{
	$forumids .= $ids[$row]['forum_id'].",";
	$row ++;
	}
$forumids = substr($forumids, 0, strlen($forumids)-1);

if($board_config['sitemap_sort'] == "ASC")
	{
	$order = "DESC";
	}
else
	{
	$order = "ASC";
	}
$sql = "SELECT topic_id FROM " . TOPICS_TABLE . " WHERE forum_id IN (" . $forumids . ") ORDER BY topic_id $order LIMIT 1";
if ( !($result = $db->sql_query($sql)) )
	message_die(GENERAL_ERROR, 'Error getting topic information', '', __LINE__, __FILE__, $sql);
	
$result = $db->sql_fetchrow($result);
$lastid = $result['topic_id'];

//only get a limited number of topics per query (default 250) to keep server load down in case of large boards 
while($lasttopic != $lastid)
{
	$result = "";
	//Newest topics first
	if(is_numeric($lasttopic) && $board_config['sitemap_sort'] == "ASC")
	{
		$lasttopic++;
		$wheresql = "AND t.topic_id >= $lasttopic";
	}
	//Oldest topics first	
	elseif(is_numeric($lasttopic))
	{
		$lasttopic--;
		$wheresql = "AND t.topic_id <= $lasttopic";
	}		
	else
	{
		$wheresql = "";
	}	
	$sql = "SELECT t.topic_id, t.topic_type, t.topic_title, t.topic_status, p.post_time, t.topic_replies FROM " . TOPICS_TABLE . " AS t, " . POSTS_TABLE . " AS p WHERE t.topic_last_post_id=p.post_id AND t.forum_id IN (" . $forumids . ") $wheresql ORDER BY t.topic_id " . $board_config['sitemap_sort'] . " LIMIT " . $board_config['sitemap_topic_limit'];
	
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Error obtaining topic data', '', __LINE__, __FILE__, $sql);
		
	$topics = $db->sql_fetchrowset($result);
	$db->sql_freeresult();
	foreach ($topics as $topic)
	{
		switch ($topic['topic_type'])
		{
			case 2:
				$topic_priority = $board_config['sitemap_announce_priority'];
				break;
			case 1:
				$topic_priority = $board_config['sitemap_sticky_priority'];
				break;
			default:
				$topic_priority = $board_config['sitemap_default_priority'];
		}
		if ($topic['topic_status'] == 1)
			$topic_change = "never";
		else
			$topic_change = "always";
			
		//echo (int)(($topic['topic_replies']/$board_config['posts_per_page'])+1)."<br />";
		//exit();
		for ($i=0;$i<(int)(($topic['topic_replies']/$board_config['posts_per_page'])+1);$i++)
		{
			$template->assign_block_vars('topics', array(
				'TOPIC_URL' => $server_url.$topic['topic_id']."_" . ($i*$board_config['posts_per_page']) . "-".str_replace('&amp;url_title=','',add_title_in_url($topic['topic_title'], false)).'.html',
				'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00', $topic['post_time']),
				'TOPIC_PRIORITY' => $topic_priority,
				'TOPIC_CHANGE' => $topic_change
				)
			);
		}
		$lasttopic = $topic['topic_id'];
	}
}
//Compresss the sitemap with gzip
//this isn't as pretty as the code in page_header.php, but it's simple & it works :) 
if(function_exists(ob_gzhandler) && $board_config['gzip_compress'] == 1)
	ob_start(ob_gzhandler);
	
header("Content-type: text/xml");
$template->pparse('body');

?>
