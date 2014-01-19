<?

define('IN_PHPBB',1);
$phpEx = 'php';
$phpbb_root_path = './';

require_once('forum/config.php');
require_once('includes/db.php');

function migration($table)
{
	echo "<h2>" . $table . "</h2><br />";
	$sql = "SELECT $table.user_id, users.username FROM phpbb_users users, $table WHERE users.user_id = $table.user_id";
	$result = mysql_query($sql);
	while($val = mysql_fetch_array($result))
	{
		$sql = "UPDATE $table SET username = '" . $val['username'] . "' WHERE user_id = '" . $val['user_id'] . "'";
		mysql_query($sql);
		echo $val['user_id'] . " => " . $val['username'] . "<br />";
	}
	echo "<br />";
}	

echo "<h1>Migration des usernames</h1><br /><br />";
migration('code_question_users');
migration('famille_bio');
migration('quizz_users');
echo "OK";
?>