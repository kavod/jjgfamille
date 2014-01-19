<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.php');
include($phpbb_root_path . 'functions/functions_disco.php');

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//

$cate_id = $_GET['cate_id'];
$more_id = $_GET['more_id'];

$sql = "SELECT * FROM more WHERE more_id=".$more_id." ";
$result = mysql_query($sql) or die("Erreur Interne<br />Requète SQL : ".$sql);
$val = mysql_fetch_array($result);

$file = $val['file'];
//$path = "../goodies/$file";
$path = 'jjgfamillep/goodies/' . $file;

// Connexion FTP
$tmpfname = tempnam ("/tmp", "FOO");
$handle = fopen($tmpfname, "w");

$conn_id = ftp_connect($ftp_anon_server);
$ok = ftp_login($conn_id, "anonymous", "anonymous");
if (!$ok)
	// Impossible de se connecter avec $ftp_anon_server anonymous
$ok = ftp_get($conn_id, $tmpfname, $path, FTP_BINARY);
ftp_close($conn_id);
//if (isset($path) and file_exists($path))
 if($ok)
 {
    	header("Content-disposition: attachment; filename=".$file);
    	header("Content-Type: application/octet-stream");
    	header("Content-Transfer-Encoding: binary");
    	header("Pragma: no-cache");
    	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    	header("Expires: 0");
    	readfile($tmpfname);
    	fclose($tmpfname);
    	exit();
 }
else
 {
            
            $template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("view_cate." . $phpEx . "?cate_id=" . $cate_id) . '">')
				);
				$message =  sprintf($lang['Download_more_not_ok'], '<a href="' . append_sid("view_cate." . $phpEx . "?cate_id=" . $cate_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
 }

?>
