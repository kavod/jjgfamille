<?php

if( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.'.$phpEx)) )
{
	$board_config['default_lang'] = 'english';
}

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);

$reponsable = false;
for ($i=0;!$responsable && $i<count($job);$i++)
{
	if (is_responsable($userdata['user_id'],$job[$i]))
		$responsable = true;
}

if (!$userdata['session_logged_in'])
{
	//echo $_SERVER['SCRIPT_FILENAME'];
	$url = append_sid(substr($phpbb_root_path,0,-1) . $_SERVER['REQUEST_URI']);
	//$url = $phpbb_root_path . substr($_SERVER['SCRIPT_FILENAME'],strpos($_SERVER['SCRIPT_FILENAME'],'htdocs')+7).'&'.$_SERVER['QUERY_STRING'];
	redirect(append_sid("forum/login.$phpEx?redirect=". $url , true));
}
else if ($userdata['user_level'] != ADMIN && !$responsable)
{
	message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

?>
