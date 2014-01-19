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

$script_name = 'jjg';//preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])); 
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

// Référencement de la bibliothèque
$sql = "SELECT *
	FROM biblio_livre
	ORDER BY date_add DESC";
$tab_livre = select_liste($sql);
$nb_livre = count($tab_livre);
for ($i=0;$i<$nb_livre;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."ll" . $tab_livre[$i]['livre_id'] . "-" . str_replace('&amp;url_title=','',add_title_in_url($tab_livre[$i]['title'])) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00',mktime(0,0,0,substr($tab_livre[$i]['date_add'],2,2),substr($tab_livre[$i]['date_add'],4,2),substr($tab_livre[$i]['date_add'],0,4))),
			'TOPIC_PRIORITY' => '0.5',
			'TOPIC_CHANGE' => 'monthly'
		));
}

// Référencement de la biographie
$sql = "SELECT *
	FROM famille_bio
	ORDER BY page";
$tab_bio = select_liste($sql);
$nb_bio = count($tab_bio);
for ($i=0;$i<$nb_bio;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."b" . $tab_bio[$i]['bio_id'] . "-" . str_replace('&amp;url_title=','',add_title_in_url($tab_bio[$i]['title'])) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
			'TOPIC_PRIORITY' => '0.6',
			'TOPIC_CHANGE' => 'monthly'
		));
}

// Référencement de la galerie photos
$sql = "SELECT photo.photo_id, photo.title, cate.cate_name, photo.date_add
	FROM famille_photo photo, famille_photo_cate cate
	WHERE photo.cate_id = cate.cate_id
	ORDER BY date_add DESC";
$tab_photo = select_liste($sql);
$nb_photo = count($tab_photo);
for ($i=0;$i<$nb_photo;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."photo-" . str_replace('&amp;url_title=','',add_title_in_url($tab_photo[$i]['cate_name'] . '-' . $tab_photo[$i]['title'])) . '_' . $tab_photo[$i]['photo_id'] . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00',mktime(0,0,0,substr($tab_photo[$i]['date_add'],2,2),substr($tab_photo[$i]['date_add'],4,2),substr($tab_photo[$i]['date_add'],0,4))),
			'TOPIC_PRIORITY' => '0.7',
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
