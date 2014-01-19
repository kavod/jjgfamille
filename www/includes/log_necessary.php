<?
if (!$userdata['session_logged_in'])
{
	$url = substr($phpbb_root_path,0,-1) . $_SERVER['REQUEST_URI'];
	redirect("forum/login.$phpEx?redirect=". str_replace('?','&',$url) , true);
}
?>