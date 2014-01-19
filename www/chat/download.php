<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'webchat');
$phpbb_root_path = '../';
$actual_rub = 'soirees';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.php');
include($phpbb_root_path . 'functions/functions_disco.php');

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_CHAT);
init_userprefs($userdata);
//
// End session management
//

$theme_id = $_GET['theme_id'];

$sql = "SELECT * FROM soirees WHERE theme_id=".$theme_id." ";
$result = mysql_query($sql) or die("Erreur Interne<br />Requète SQL : ".$sql);
$val = mysql_fetch_array($result);

$file = "theme_".$val['theme_id'].".txt";
$path = "log/$file";

if (isset($path) and file_exists($path))
 {
    	header("Content-disposition: attachment; filename=".$file);
    	header("Content-Type: application/text-plain");
    	header("Content-Transfer-Encoding: binary");
    	header("Pragma: no-cache");
    	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    	header("Expires: 0");
    	readfile($path);  
 }
else
 {
            
            $template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("soirees." . $phpEx) . '">')
				);
				$message =  sprintf($lang['Download_chat_not_ok'], '<a href="' . append_sid("soirees." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
 }

?>
