<?
require_once('forum/config.php');
@mysql_connect($dbhost,$dbuser,$dbpasswd)
   or die("Impossible de se connecter à $host");
@mysql_select_db("$dbname")
   or die("Impossible de se connecter à la base");

$sql = "SELECT COUNT(user_id) AS nb FROM phpbb_users WHERE confirm_assoc = 'Y'";
$result = mysql_query($sql);
$val_nb_confirm = mysql_fetch_array($result);

$sql = "SELECT COUNT(user_id) AS nb FROM phpbb_users WHERE user_active = '1'";
$result = mysql_query($sql);
$val_nb_total = mysql_fetch_array($result);

$sql_age = "SELECT COUNT(*) \"nb_util\", SUM(".date('Y')."+(".date('m')."-1)/12-birth_year+(birth_month-1)/13)/COUNT(*) \"age_moyen\" FROM `phpbb_users` WHERE birth_year <> 1899 AND birth_year <> 1000";
$result_age = mysql_query($sql_age);
$val_age = mysql_fetch_array($result_age);

echo "Nombre d'utilisateurs confirmés : " . $val_nb_confirm['nb']."<br />";
echo "Nombre d'utilisateurs restants : " . ($val_nb_total['nb'] - $val_nb_confirm['nb'])."<br /><br />";
echo "Nombre d'utilisateurs indiquant leur age : " . $val_age['nb_util'] ."<br />";
echo "Age moyen : " . $val_age['age_moyen'] ."<br />";
?>