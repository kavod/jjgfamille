<?

define('IN_PHPBB',1);
$phpEx = 'php';
$phpbb_root_path = './';

require_once('forum/config.php');
require_once('includes/db.php');

$word_id = $_POST['word_id'];
if (isset($word_id))
{
  $sql = "DELETE FROM `phpbb_search_wordlist` WHERE `word_id`= '$word_id'";
  mysql_query($sql);

  $sql = "DELETE FROM `phpbb_search_wordmatch` WHERE `word_id` = '$word_id'";
  mysql_query($sql);
}
?>
<html>
<body>
<?
if (isset($word_id))
  echo mysql_affected_rows() . htmlentities(" lignes affectéees") . "<br>";
?>
<form method="post">
<input type="text" value="" name="word_id"><input type="submit" value="envoyer">
</form>
</html>