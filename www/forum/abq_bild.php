<?php
/***************************************************************************
 *                          abq_bild.php
 *                          ------------
 *   Version              : Version 2.0.0 - 26.11.2006
 *   copyright            : (C) 2005-2006 M.W.
 *   URL                  : http://phpbb.mwegner.de/
 *
 ***************************************************************************/

define('IN_PHPBB', true); 
$phpbb_root_path = '../'; 
include($phpbb_root_path . 'forum/extension.inc'); 
include($phpbb_root_path . 'forum/common.'.$phpEx); 

$abq_config = array();
$sql = "SELECT *
	FROM " . ANTI_BOT_QUEST_CONFIG_TABLE;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query anti bot question mod config information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$abq_config[$row['config_name']] = $row['config_value'];
}

//Session auslesen und Benutzer-Informationen laden 
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 

$ABQ_Bild_ID = 0;
$ABQ_Schrift_ID = 0;
if ((isset($HTTP_GET_VARS['b'])) && (!is_null($HTTP_GET_VARS['b'])))
{
	if ($HTTP_GET_VARS['b'] == 'test')
	{
		$ABQ_Bild_ID = -10;
	}
	else
	{
		$ABQ_Bild_ID = preg_replace('/[^a-z0-9]/i','',$HTTP_GET_VARS['b']);
	}
}
elseif ((isset($HTTP_GET_VARS['id'])) && (!is_null($HTTP_GET_VARS['id'])))
{
	$ABQ_Schrift_ID = preg_replace('/[^0-9]/i','',$HTTP_GET_VARS['id']);
}

if (!empty($ABQ_Bild_ID))
{
	if ($ABQ_Bild_ID == -10)
	{
		include($phpbb_root_path . 'includes/functions_abq_bild1.' . $phpEx);
		BildAnzeigen($ABQ_Bild_ID);
	}
	else
	{
		$sql = 'SELECT answer, line1, line2, line3, line4, farbe  
			FROM ' . ANTI_BOT_QUEST_CONFIRM_TABLE . ' 
			WHERE confirm_id = \'' . $ABQ_Bild_ID . '\' 
				AND session_id = \'' . $userdata['session_id'] . '\'';
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain anti bot question answer', __LINE__, __FILE__, $sql);
		}
		if ($db->sql_numrows($result) > 0)
		{
			$row = $db->sql_fetchrow($result);
			if (substr($row['answer'],0,1) == '_')
			{
				include($phpbb_root_path . 'includes/functions_abq_bild1.' . $phpEx);
				BildAnzeigen(substr($row['answer'],1));
			}
			else
			{
				include($phpbb_root_path . 'includes/functions_abq.' . $phpEx);
				include($phpbb_root_path . 'includes/functions_abq_bild2.' . $phpEx);
				BildAnzeigen($row['line1'], $row['line2'], $row['line3'], $row['line4'], $row['farbe']);
			}
		}
		else
		{
			exit;
		}
	}
}
elseif (!empty($ABQ_Schrift_ID))
{
	include($phpbb_root_path . 'includes/functions_abq.' . $phpEx);
	include($phpbb_root_path . 'includes/functions_abq_bild3.' . $phpEx);
	BildAnzeigen($ABQ_Schrift_ID);
}
?>