<?
function birthday_users()
{
	global $db;
	$sql = 'SELECT user_id,username FROM '. USERS_TABLE .' WHERE birth_day = '.date('d').' AND birth_month = '.date('m');
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query users who celebrate their birthday', '', __LINE__, __FILE__, $sql);
	}
	$tab_users = array();
	for ($i=0;$val_user = mysql_fetch_array($result);$i++)
	{
		$tab_users[$i] = $val_user;
	}
	$db->sql_freeresult($result);
	return $tab_users;
}
?>