<?php
define('IN_PHPBB', true);
define('DOMAIN','www.jjgfamille.com');
$phpbb_root_path = './';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions_selections.php');

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
	$server_url .= "/";

$template->set_filenames(array("body" => "index_sitemap_body.tpl"));
$template->assign_vars(array(
		'BOARD_URL' => $server_url)
	);


/////////////////////////////////
// Récupère la dernière MaJ
/////////////////////////////////
$val_maj = select_element("SELECT * FROM famille_maj ORDER BY date_unix DESC",true,"MaJ introuvable");

$template->assign_block_vars('sitemap', array(
			'URL' => "http://" . DOMAIN . "/sitemap.xml",
			'DATE' => gmdate('Y-m-d\TH:i:s'.'+00:00', $val_maj['date_unix'])
			)
		);
		
/////////////////////////////////
// Actu
/////////////////////////////////
$val_news = select_element("SELECT * FROM famille_news ORDER BY date_unix DESC",true,"News introuvable");
$val_edito = select_element("SELECT * FROM famille_edito ORDER BY date_unix DESC",true,"Edito introuvable");
$max = max($val_news['date_unix'],$val_edito['date_unix'],$val_maj['date_unix']);
$template->assign_block_vars('sitemap', array(
			'URL' => "http://" . DOMAIN . "/actu/sitemap.xml",
			'DATE' => gmdate('Y-m-d\TH:i:s'.'+00:00', $max)
			)
		);
/////////////////////////////////
// Récupère le dernier post pour le forum
/////////////////////////////////
$sql = "SELECT forum_id FROM ". FORUMS_TABLE ." WHERE auth_read=0";
if ( !($result = $db->sql_query($sql)) )
	message_die(GENERAL_ERROR, 'Error getting permissions', '', __LINE__, __FILE__, $sql);
	
$ids = $db->sql_fetchrowset($result);
$row = 0;
while($row <= count($ids) -1)
{
	$forumids .= $ids[$row]['forum_id'].",";
	$row ++;
}

$forumids = substr($forumids, 0, strlen($forumids)-1);
	
$sql = "SELECT t.topic_id, t.topic_type, t.topic_title, t.topic_status, p.post_time, t.topic_replies FROM " . TOPICS_TABLE . " AS t, " . POSTS_TABLE . " AS p WHERE t.topic_last_post_id=p.post_id AND t.forum_id IN (" . $forumids . ") ORDER BY t.topic_id " . $board_config['sitemap_sort'] . " LIMIT 0,1";

if ( !($result = $db->sql_query($sql)) )
	message_die(GENERAL_ERROR, 'Error obtaining topic data', '', __LINE__, __FILE__, $sql);
	
$topics = $db->sql_fetchrowset($result);
$db->sql_freeresult();
foreach ($topics as $topic)
{
	for ($i=0;$i<(int)(($topic['topic_replies']/$board_config['posts_per_page'])+1);$i++)
	{
		$template->assign_block_vars('sitemap', array(
			'URL' => "http://" . DOMAIN . "/forum/sitemap.xml",
			'DATE' => gmdate('Y-m-d\TH:i:s'.'+00:00', $topic['post_time'])
			)
		);
	}
}

/////////////////////////////////
// Disco
/////////////////////////////////
$template->assign_block_vars('sitemap', array(
			'URL' => "http://" . DOMAIN . "/disco/sitemap.xml",
			'DATE' => gmdate('Y-m-d\TH:i:s'.'+00:00', $val_maj['date_unix'])
			)
		);

/////////////////////////////////
// JJG
/////////////////////////////////
$template->assign_block_vars('sitemap', array(
			'URL' => "http://" . DOMAIN . "/jjg/sitemap.xml",
			'DATE' => gmdate('Y-m-d\TH:i:s'.'+00:00', $val_maj['date_unix'])
			)
		);
		
/////////////////////////////////
// More
/////////////////////////////////
$template->assign_block_vars('sitemap', array(
			'URL' => "http://" . DOMAIN . "/more/sitemap.xml",
			'DATE' => gmdate('Y-m-d\TH:i:s'.'+00:00', $val_maj['date_unix'])
			)
		);

//Compresss the sitemap with gzip
//this isn't as pretty as the code in page_header.php, but it's simple & it works :) 
if(function_exists(ob_gzhandler) && $board_config['gzip_compress'] == 1)
	ob_start(ob_gzhandler);
	
header("Content-type: text/xml");
$template->pparse('body');

?>
