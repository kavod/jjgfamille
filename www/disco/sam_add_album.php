<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION','website');
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_DISCO);
init_userprefs($userdata);
//
// End session management
//
// Vérification des permissions
$job = array('sam');
require_once($phpbb_root_path . 'includes/reserved_access.php');

$doublon_album=false;

$options_type[0] = array($lang['Studio_album'],"l'album");
$options_type[1] = array($lang['Live_album'],"le live");
$options_type[2] = array($lang['Compil_album'],"la compilation");
$options_type[3] = array($lang['Single_album'],"le single");

?>