<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions_selections.php');
require_once($phpbb_root_path . 'functions/url_rewriting.php');

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management
//

$script_name = 'more';//preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])); 
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

// Référencement des news
$sql = "SELECT *
	FROM concours
	ORDER BY date_end DESC";
$tab_concours = select_liste($sql);
$nb_concours = count($tab_concours);
for ($i=0;$i<$nb_concours;$i++)
{
	$date = (date('U') < $tab_concours[$i]['date_end']) ? date('U') : $tab_concours[$i]['date_end'];
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."concours_goldman" . $tab_concours[$i]['concours_id'] . "-" . str_replace('&amp;url_title=','',add_title_in_url($tab_concours[$i]['title'])) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00',$date),
			'TOPIC_PRIORITY' => '0.5',
			'TOPIC_CHANGE' => 'monthly'
		));
}

//Compresss the sitemap with gzip
//this isn't as pretty as the code in page_header.php, but it's simple & it works :) 
if(function_exists(ob_gzhandler) && $board_config['gzip_compress'] == 1)
{
	ob_start(ob_gzhandler);
}
header("Content-type: text/xml");
$template->pparse('body');
?>
