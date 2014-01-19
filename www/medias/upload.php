<?
$phpbb_root_path = '../';
require_once($phpbb_root_path . 'forum/config.php');

$username = $_GET['username'];
$sid = $_GET['sid'];
$multimedia_id = $_GET['multimedia_id'];

$link = mysql_connect($dbhost,$dbuser,$dbpasswd) or die("connect error");

mysql_select_db($dbname) or die("table error");

$sql = "SELECT user_id FROM phpbb_users WHERE username = '$username' LIMIT 0,1";
$result = mysql_query($sql) or die("select error");
$val = mysql_fetch_array($result) or die("mysql error");

$sql = "SELECT * FROM phpbb_sessions WHERE session_user_id = '" . $val['user_id'] . "' AND session_id = '" . $sid . "'";
$result = mysql_query($sql) or die("select error");
if (mysql_num_rows($result) == 0)
	die("user error");

$sql = "SELECT * FROM media_multimedia WHERE multimedia_id = '$multimedia_id' LIMIT 0,1";
$result = mysql_query($sql) or die("select error");
$val = mysql_fetch_array($result) or die("mysql error\nImpossible de chopper le média");

if ($val['state'] == 'available')
	die("already available");

$sql = "UPDATE media_multimedia SET state = 'progress' WHERE multimedia_id = '$multimedia_id'";
mysql_query($sql) or die('update failed');
echo "ok\n" . $val['emission_id'] . "\n";
?>

