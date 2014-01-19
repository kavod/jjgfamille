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

$script_name = 'actu';//preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])); 
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
	FROM famille_news
	ORDER BY date_unix DESC";
$tab_news = select_liste($sql);
$nb_news = count($tab_news);
for ($i=0;$i<$nb_news;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."n" . $tab_news[$i]['news_id'] . "-" . str_replace('&amp;url_title=','',add_title_in_url($tab_news[$i]['title'])) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00',$tab_news[$i]['date_unix']),
			'TOPIC_PRIORITY' => '0.6',
			'TOPIC_CHANGE' => 'monthly'
		));
}

// Référencement des editos
$sql = "SELECT *
	FROM famille_edito
	ORDER BY date_unix DESC";
$tab_edito = select_liste($sql);
$nb_edito = count($tab_edito);
for ($i=0;$i<$nb_edito;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."e" . $tab_edito[$i]['edito_id'] . "-" . str_replace('&amp;url_title=','',add_title_in_url($tab_edito[$i]['title'])) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00',$tab_edito[$i]['date_unix']),
			'TOPIC_PRIORITY' => '0.6',
			'TOPIC_CHANGE' => 'monthly'
		));
}

// Référencement des RDN
$sql = "SELECT *
	FROM famille_rdn
	ORDER BY date DESC";
$tab_rdn = select_liste($sql);
$nb_rdn = count($tab_rdn);
for ($i=0;$i<$nb_rdn;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."r" . $tab_rdn[$i]['rdn_id'] . "-" . str_replace('&amp;url_title=','',add_title_in_url($tab_rdn[$i]['title'])) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00',$tab_rdn[$i]['date']),
			'TOPIC_PRIORITY' => '0.6',
			'TOPIC_CHANGE' => 'monthly'
		));
}

// Référencement des maj
$sql = "SELECT *
	FROM famille_maj
	ORDER BY date_unix DESC";
$tab_maj = select_liste($sql);
$nb_maj = count($tab_maj);
for ($i=0;$i<$nb_maj;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."m" . $tab_maj[$i]['maj_id'] . "-" . str_replace('&amp;url_title=','',add_title_in_url($tab_maj[$i]['title'])) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00',$tab_maj[$i]['date_unix']),
			'TOPIC_PRIORITY' => '0.6',
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
