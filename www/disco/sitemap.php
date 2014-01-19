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

$script_name = 'disco';//preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path'])); 
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
	
// Référencement des chansons
$sql = "SELECT song.song_id, song.title, albums.album_id
	FROM disco_songs song
	LEFT  JOIN disco_songs_albums asso ON asso.song_id = song.song_id
	LEFT  JOIN disco_albums albums ON asso.album_id = albums.album_id AND albums.type =  'l\'album' GROUP BY song_id
	ORDER BY song_id DESC
	LIMIT 0,20";
$tab_songs = select_liste($sql);
$nb_songs = count($tab_songs);
for ($i=0;$i<$nb_songs;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."goldman-chanson-" . $tab_songs[$i]['song_id'] . "-" . $tab_songs[$i]['album_id'].'-' . url_title($tab_songs[$i]['title']) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
			'TOPIC_PRIORITY' => '0.6',
			'TOPIC_CHANGE' => 'monthly'
		));
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."goldman-references-" . $tab_songs[$i]['song_id'] . "-" . $tab_songs[$i]['album_id'].'-' . url_title($tab_songs[$i]['title']) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
			'TOPIC_PRIORITY' => '0.5',
			'TOPIC_CHANGE' => 'monthly'
		));
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."goldman-paroles-" . $tab_songs[$i]['song_id'] . "-" . $tab_songs[$i]['album_id'].'-' . url_title($tab_songs[$i]['title']) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
			'TOPIC_PRIORITY' => '0.6',
			'TOPIC_CHANGE' => 'monthly'
		));
	if ($tab_songs[$i]['rm']=='Y')
	{
		$template->assign_block_vars('topics', array(
				'TOPIC_URL' => $server_url."goldman-extrait-audio-" . $tab_songs[$i]['song_id'] . "-" . $tab_songs[$i]['album_id'].'-' . url_title($tab_songs[$i]['title']) . '.html',
				'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
				'TOPIC_PRIORITY' => '0.4',
				'TOPIC_CHANGE' => 'monthly'
			));
	}
	if ($tab_songs[$i]['midi']=='Y')
	{
		$template->assign_block_vars('topics', array(
				'TOPIC_URL' => $server_url."goldman-midi-" . $tab_songs[$i]['song_id'] . "-" . $tab_songs[$i]['album_id'].'-' . url_title($tab_songs[$i]['title']) . '.html',
				'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
				'TOPIC_PRIORITY' => '0.3',
				'TOPIC_CHANGE' => 'monthly'
			));
	}
	if ($tab_songs[$i]['gp']=='Y')
	{
		$template->assign_block_vars('topics', array(
				'TOPIC_URL' => $server_url."goldman-partitions-" . $tab_songs[$i]['song_id'] . "-" . $tab_songs[$i]['album_id'].'-' . url_title($tab_songs[$i]['title']) . '.html',
				'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
				'TOPIC_PRIORITY' => '0.4',
				'TOPIC_CHANGE' => 'monthly'
			));
	}
}

// Référencement des albums
$sql = "SELECT albums.album_id, albums.title, artists.artist_id FROM disco_albums albums, disco_artists artists WHERE albums.artist_id = artists.artist_id ORDER BY album_id DESC
	LIMIT 0,20";
$tab_albums = select_liste($sql);
$nb_albums = count($tab_albums);
for ($i=0;$i<$nb_albums;$i++)
{
	$template->assign_block_vars('topics', array(
			'TOPIC_URL' => $server_url."goldman_album_" . $tab_albums[$i]['album_id'] . "_" . url_title($tab_albums[$i]['title']) . '.html',
			'TOPIC_TIME' => gmdate('Y-m-d\TH:i:s'.'+00:00'),
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
