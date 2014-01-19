<?php
/***************************************************************************
 *                          abq_config.php
 *                          --------------
 *   Version              : Version 2.0.1 - 09.12.2006
 *   copyright            : (C) 2005-2006 M.W.
 *   URL                  : http://phpbb.mwegner.de/
 *
 ***************************************************************************/

define('IN_PHPBB', true);

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'forum/extension.inc');
require('./pagestart.' . $phpEx);

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

include($phpbb_root_path . 'includes/functions_abq.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_abq_admin.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_abq.' . $phpEx);

if(isset($HTTP_POST_VARS['submit']))
{
	$DatenPost = array();
	$ABQ_Error = '';

	$DatenPost[] = 'abq_register';
	if (($HTTP_POST_VARS['abq_register'] === '1') || ($HTTP_POST_VARS['abq_register'] === '0'))
	{
		$new_abq_register = $HTTP_POST_VARS['abq_register'];
	}
	else
	{
		$new_abq_register = '0';
	}

	$DatenPost[] = 'abq_guest';
	if (($HTTP_POST_VARS['abq_guest'] === '1') || ($HTTP_POST_VARS['abq_guest'] === '0'))
	{
		$new_abq_guest = $HTTP_POST_VARS['abq_guest'];
	}
	else
	{
		$new_abq_guest = '0';
	}

	$DatenPost[] = 'postvariablename';
	$new_postvariablename = '';
	if (isset($HTTP_POST_VARS['abq_get_s1']))
	{
		$new_postvariablename .= $HTTP_POST_VARS['abq_get_s1'];
	}
	if (isset($HTTP_POST_VARS['abq_get_s2']))
	{
		$new_postvariablename .= $HTTP_POST_VARS['abq_get_s2'];
	}
	if (isset($HTTP_POST_VARS['abq_get_s3']))
	{
		$new_postvariablename .= $HTTP_POST_VARS['abq_get_s3'];
	}
	if (isset($HTTP_POST_VARS['abq_get_s4']))
	{
		$new_postvariablename .= $HTTP_POST_VARS['abq_get_s4'];
	}
	if (isset($HTTP_POST_VARS['abq_get_s5']))
	{
		$new_postvariablename .= $HTTP_POST_VARS['abq_get_s5'];
	}
	if (isset($HTTP_POST_VARS['abq_get_s6']))
	{
		$new_postvariablename .= $HTTP_POST_VARS['abq_get_s6'];
	}
	if ((trim($new_postvariablename) == '') || (!preg_match('/^[a-z_]{2,5}[0-9]{4}[0-9a-z]{0,5}$/', $new_postvariablename)))
	{
		$new_postvariablename == 'abq_0001';
	}

	$DatenPost[] = 'verhaeltnis_eigene_auto';
	if (($HTTP_POST_VARS['verhaeltnis_eigene_auto'] < 0) || ($HTTP_POST_VARS['verhaeltnis_eigene_auto'] > 100) || (!preg_match('/^[0-9]{1,3}$/',$HTTP_POST_VARS['verhaeltnis_eigene_auto'])))
	{
		$ABQ_Error .= $lang['ABQ_ConfProzente'] . '<br />';
	}
	else
	{
		$new_verhaeltnis_eigene_auto = $HTTP_POST_VARS['verhaeltnis_eigene_auto'];
	}

	$DatenPost[] = 'fontsize';
	if (($HTTP_POST_VARS['fontsize'] < 15) || ($HTTP_POST_VARS['fontsize'] > 40) || (!preg_match('/^[0-9]{1,2}$/',$HTTP_POST_VARS['fontsize'])))
	{
		$ABQ_Error .= $lang['ABQ_ConfFontsize'] . '<br />';
	}
	else
	{
		$new_fontsize = $HTTP_POST_VARS['fontsize'];
	}

	$DatenPost[] = 'imagetype';
	if (($HTTP_POST_VARS['imagetype'] === '1') || ($HTTP_POST_VARS['imagetype'] === '0'))
	{
		$new_imagetype = $HTTP_POST_VARS['imagetype'];
	}
	else
	{
		$new_imagetype = '1';
	}

	$DatenPost[] = 'jpgquality';
	if (($HTTP_POST_VARS['jpgquality'] < 50) || ($HTTP_POST_VARS['jpgquality'] > 90) || (!preg_match('/^[0-9]{1,2}$/',$HTTP_POST_VARS['jpgquality'])))
	{
		$ABQ_Error .= $lang['ABQ_ConfJPGQuality'] . '<br />';
	}
	else
	{
		$new_jpgquality = $HTTP_POST_VARS['jpgquality'];
	}

	$DatenPost[] = 'afeff_max';
	if (($HTTP_POST_VARS['afeff_max'] < 0) || ($HTTP_POST_VARS['afeff_max'] > 6) || (!preg_match('/^[0-9]$/',$HTTP_POST_VARS['afeff_max'])))
	{
		$ABQ_Error .= $lang['ABQ_ConfMaxEffekte'] . '<br />';
	}
	else
	{
		$new_afeff_max = $HTTP_POST_VARS['afeff_max'];
	}

	$DatenPost[] = 'afeff_gridw';
	if ((($HTTP_POST_VARS['afeff_gridw'] < 10) && ($HTTP_POST_VARS['afeff_gridw'] != 0)) || ($HTTP_POST_VARS['afeff_gridw'] > 100) || (!preg_match('/^[0-9]{1,3}$/',$HTTP_POST_VARS['afeff_gridw'])))
	{
		$ABQ_Error .= $lang['ABQ_ConfGridW'] . '<br />';
	}
	else
	{
		$new_afeff_gridw = $HTTP_POST_VARS['afeff_gridw'];
	}

	$DatenPost[] = 'afeff_gridh';
	if ((($HTTP_POST_VARS['afeff_gridh'] < 10) && ($HTTP_POST_VARS['afeff_gridh'] != 0)) || ($HTTP_POST_VARS['afeff_gridh'] > 50) || (!preg_match('/^[0-9]{1,2}$/',$HTTP_POST_VARS['afeff_gridh'])))
	{
		$ABQ_Error .= $lang['ABQ_ConfGridH'] . '<br />';
	}
	else
	{
		$new_afeff_gridh = $HTTP_POST_VARS['afeff_gridh'];
	}

	$DatenPost[] = 'af_malzeichen';
	if (($HTTP_POST_VARS['af_malzeichen'] == '*') || ($HTTP_POST_VARS['af_malzeichen'] == 'x') || ($HTTP_POST_VARS['af_malzeichen'] == 'X'))
	{
		$new_af_malzeichen = $HTTP_POST_VARS['af_malzeichen'];
	}
	else
	{
		$new_af_malzeichen = '*';
	}

	unset($ABQ_POSTVaris);
	unset($i);
	unset($j);
	$ABQ_POSTVaris = array();
	$ABQ_POSTVaris[] = 'eigene_fragen';
	$ABQ_POSTVaris[] = 'ef_casesensitive';
	$ABQ_POSTVaris[] = 'ef_bild';
	$ABQ_POSTVaris[] = 'afeff_trennlinie';
	$ABQ_POSTVaris[] = 'af_use_select';
	$j = count($ABQ_POSTVaris);
	for ($i=0; $i<$j; $i++)
	{
		$DatenPost[] = $ABQ_POSTVaris[$i];
		if (($HTTP_POST_VARS[$ABQ_POSTVaris[$i]] === '1') || ($HTTP_POST_VARS[$ABQ_POSTVaris[$i]] === '0'))
		{
			${'new_'.$ABQ_POSTVaris[$i]} = $HTTP_POST_VARS[$ABQ_POSTVaris[$i]];
		}
		else
		{
			${'new_'.$ABQ_POSTVaris[$i]} = '0';
		}
	}

	unset($ABQ_POSTVaris);
	unset($i);
	unset($j);
	$ABQ_POSTVaris = array();
	$ABQ_POSTVaris[] = 'af_grossezahlen';
	$ABQ_POSTVaris[] = 'afeff_bgtext';
	$ABQ_POSTVaris[] = 'afeff_grid';
	$ABQ_POSTVaris[] = 'afeff_gridf';
	$ABQ_POSTVaris[] = 'afeff_ellipsen';
	$ABQ_POSTVaris[] = 'afeff_boegen';
	$ABQ_POSTVaris[] = 'afeff_linien';
	$j = count($ABQ_POSTVaris);
	for ($i=0; $i<$j; $i++)
	{
		$DatenPost[] = $ABQ_POSTVaris[$i];
		if (($HTTP_POST_VARS[$ABQ_POSTVaris[$i]] === '2') || ($HTTP_POST_VARS[$ABQ_POSTVaris[$i]] === '1') || ($HTTP_POST_VARS[$ABQ_POSTVaris[$i]] === '0'))
		{
			${'new_'.$ABQ_POSTVaris[$i]} = $HTTP_POST_VARS[$ABQ_POSTVaris[$i]];
		}
		else
		{
			${'new_'.$ABQ_POSTVaris[$i]} = '0';
		}
	}

	if (trim($ABQ_Error) != '')
	{
		message_die(GENERAL_ERROR, $lang['ABQ_not_updated'] . '<br /><br />' . $ABQ_Error);
	}

	unset($i);
	unset($j);
	$j = count($DatenPost);
	for ($i=0; $i<$j; $i++)
	{
		$sql = 'UPDATE ' . ANTI_BOT_QUEST_CONFIG_TABLE . ' SET 
			config_value = \'' . str_replace("\'", "''", ${'new_'.$DatenPost[$i]}) . '\' 
			WHERE config_name = \'' . $DatenPost[$i] . '\'';
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to update anti bot question mod configuration for $config_name", "", __LINE__, __FILE__, $sql);
		}
	}

	$message = $lang['ABQ_Config_updated'] . "<br /><br />" . sprintf($lang['ABQ_Click_return_config'], "<a href=\"" . append_sid("abq_config.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}

/*
$Schrift = str_replace('index.'.$phpEx, '', realpath($phpbb_root_path.'index.'.$phpEx));
$Schrift = $Schrift . 'abq_mod/fonts/do-not-delete.ttf';
$FTL_JN = @imagettfbbox(10, 0, $Schrift, 'AAA');
*/
$FTL_JN = 0;
$GDL_JN = 0;
ABQ_gdVersion();

$sql = 'SELECT * 
	FROM ' . ANTI_BOT_QUEST_CONFIG_TABLE . '
	WHERE config_name NOT LIKE \'autofrage_%\' AND config_name NOT LIKE \'Color_%\'';
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in abq_config", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = $config_value;
		
		$new[$config_name] = $default_config[$config_name];
	}
}

$abq_register_yes = ($new['abq_register']) ? 'checked="checked"' : '';
$abq_register_no = (!$new['abq_register']) ? 'checked="checked"' : '';

$abq_guest_yes = ($new['abq_guest']) ? 'checked="checked"' : '';
$abq_guest_no = (!$new['abq_guest']) ? 'checked="checked"' : '';

$ef_yes = ($new['eigene_fragen']) ? 'checked="checked"' : '';
$ef_no = (!$new['eigene_fragen']) ? 'checked="checked"' : '';

$efcasesen_yes = ($new['ef_casesensitive']) ? 'checked="checked"' : '';
$efcasesen_no = (!$new['ef_casesensitive']) ? 'checked="checked"' : '';

$bildphp_yes = ($new['ef_bild']) ? 'checked="checked"' : '';
$bildphp_no = (!$new['ef_bild']) ? 'checked="checked"' : '';

$af_imagetype_JPG = ($new['imagetype']) ? 'checked="checked"' : '';
$af_imagetype_PNG = (!$new['imagetype']) ? 'checked="checked"' : '';

$af_grossezahlen_yes = ($new['af_grossezahlen'] == 1) ? 'checked="checked"' : '';
$af_grossezahlen_no = ($new['af_grossezahlen'] == 0) ? 'checked="checked"' : '';
$af_grossezahlen_rand = ($new['af_grossezahlen'] == 2) ? 'checked="checked"' : '';

$afeff_trennlinie_yes = ($new['afeff_trennlinie']) ? 'checked="checked"' : '';
$afeff_trennlinie_no = (!$new['afeff_trennlinie']) ? 'checked="checked"' : '';

$afeff_bgtext_yes = ($new['afeff_bgtext'] == 1) ? 'checked="checked"' : '';
$afeff_bgtext_no = ($new['afeff_bgtext'] == 0) ? 'checked="checked"' : '';
$afeff_bgtext_rand = ($new['afeff_bgtext'] == 2) ? 'checked="checked"' : '';

$afeff_grid_yes = ($new['afeff_grid'] == 1) ? 'checked="checked"' : '';
$afeff_grid_no = ($new['afeff_grid'] == 0) ? 'checked="checked"' : '';
$afeff_grid_rand = ($new['afeff_grid'] == 2) ? 'checked="checked"' : '';

$afeff_gridf_yes = ($new['afeff_gridf'] == 1) ? 'checked="checked"' : '';
$afeff_gridf_no = ($new['afeff_gridf'] == 0) ? 'checked="checked"' : '';
$afeff_gridf_rand = ($new['afeff_gridf'] == 2) ? 'checked="checked"' : '';

$afeff_ellipsen_yes = ($new['afeff_ellipsen'] == 1) ? 'checked="checked"' : '';
$afeff_ellipsen_no = ($new['afeff_ellipsen'] == 0) ? 'checked="checked"' : '';
$afeff_ellipsen_rand = ($new['afeff_ellipsen'] == 2) ? 'checked="checked"' : '';

$afeff_boegen_yes = ($new['afeff_boegen'] == 1) ? 'checked="checked"' : '';
$afeff_boegen_no = ($new['afeff_boegen'] == 0) ? 'checked="checked"' : '';
$afeff_boegen_rand = ($new['afeff_boegen'] == 2) ? 'checked="checked"' : '';

$afeff_linien_yes = ($new['afeff_linien'] == 1) ? 'checked="checked"' : '';
$afeff_linien_no = ($new['afeff_linien'] == 0) ? 'checked="checked"' : '';
$afeff_linien_rand = ($new['afeff_linien'] == 2) ? 'checked="checked"' : '';

$af_malzeichen_1 = ($new['af_malzeichen'] == '*') ? 'checked="checked"' : '';
$af_malzeichen_2 = ($new['af_malzeichen'] == 'x') ? 'checked="checked"' : '';
$af_malzeichen_3 = ($new['af_malzeichen'] == 'X') ? 'checked="checked"' : '';

$af_use_select_yes = ($new['af_use_select'] == 1) ? 'checked="checked"' : '';
$af_use_select_no = ($new['af_use_select'] == 0) ? 'checked="checked"' : '';

if ($new['postvariablename'] != '')
{
	$abq_get_t2 = '';
	if (preg_match('/\A(fg|ih|zg)[0-9]{4}[0-9a-z]{0,5}\z/',$new['postvariablename']))
	{
		$abq_get_t1 = strval(substr($new['postvariablename'],0,2));
		$abq_get_z1 = strval(substr($new['postvariablename'],2,1));
		$abq_get_z2 = strval(substr($new['postvariablename'],3,1));
		$abq_get_z3 = strval(substr($new['postvariablename'],4,1));
		$abq_get_z4 = strval(substr($new['postvariablename'],5,1));
		if (strlen($new['postvariablename']) > 6)
		{
			$abq_get_t2 = strval(substr($new['postvariablename'],6));
		}
	}
	elseif (preg_match('/\A(bfj|g_e|www|xwe|xxx)[0-9]{4}[0-9a-z]{0,5}\z/',$new['postvariablename']))
	{
		$abq_get_t1 = strval(substr($new['postvariablename'],0,3));
		$abq_get_z1 = strval(substr($new['postvariablename'],3,1));
		$abq_get_z2 = strval(substr($new['postvariablename'],4,1));
		$abq_get_z3 = strval(substr($new['postvariablename'],5,1));
		$abq_get_z4 = strval(substr($new['postvariablename'],6,1));
		if (strlen($new['postvariablename']) > 7)
		{
			$abq_get_t2 = strval(substr($new['postvariablename'],7));
		}
	}
	elseif (preg_match('/\A(abq_|home|name|sfhf|www_)[0-9]{4}[0-9a-z]{0,5}\z/',$new['postvariablename']))
	{
		$abq_get_t1 = strval(substr($new['postvariablename'],0,4));
		$abq_get_z1 = strval(substr($new['postvariablename'],4,1));
		$abq_get_z2 = strval(substr($new['postvariablename'],5,1));
		$abq_get_z3 = strval(substr($new['postvariablename'],6,1));
		$abq_get_z4 = strval(substr($new['postvariablename'],7,1));
		if (strlen($new['postvariablename']) > 8)
		{
			$abq_get_t2 = strval(substr($new['postvariablename'],8));
		}
	}
	elseif (preg_match('/\A(email|ldknf|name_|rgwsf)[0-9]{4}[0-9a-z]{0,5}\z/',$new['postvariablename']))
	{
		$abq_get_t1 = strval(substr($new['postvariablename'],0,5));
		$abq_get_z1 = strval(substr($new['postvariablename'],5,1));
		$abq_get_z2 = strval(substr($new['postvariablename'],6,1));
		$abq_get_z3 = strval(substr($new['postvariablename'],7,1));
		$abq_get_z4 = strval(substr($new['postvariablename'],8,1));
		if (strlen($new['postvariablename']) > 9)
		{
			$abq_get_t2 = strval(substr($new['postvariablename'],9));
		}
	}
	else
	{
		$new['postvariablename'] = '';
	}
}
if ($new['postvariablename'] == '')
{
	$new['postvariablename'] = 'abq_0001';
	$abq_get_t1 = 'abq_';
	$abq_get_t2 = '';
	$abq_get_z1 = '0';
	$abq_get_z2 = '0';
	$abq_get_z3 = '0';
	$abq_get_z4 = '1';
}

$abq_get_A1 = array();
$abq_get_A1[] = 'abq_';
$abq_get_A1[] = 'bfj';
$abq_get_A1[] = 'email';
$abq_get_A1[] = 'fg';
$abq_get_A1[] = 'g_e';
$abq_get_A1[] = 'home';
$abq_get_A1[] = 'ih';
$abq_get_A1[] = 'ldknf';
$abq_get_A1[] = 'name';
$abq_get_A1[] = 'name_';
$abq_get_A1[] = 'rgwsf';
$abq_get_A1[] = 'sfhf';
$abq_get_A1[] = 'www';
$abq_get_A1[] = 'www_';
$abq_get_A1[] = 'xwe';
$abq_get_A1[] = 'xxx';
$abq_get_A1[] = 'zg';
$abq_get_A2 = array();
$abq_get_A2[] = '';
$abq_get_A2[] = '001';
$abq_get_A2[] = '3567';
$abq_get_A2[] = '94859';
$abq_get_A2[] = 'abf';
$abq_get_A2[] = 'f';
$abq_get_A2[] = 'sfgr';
$abq_get_A2[] = 'uc';
$abq_get_A2[] = 'dsdvg';
$abq_get_s1 = '';
for ($i=0; $i<count($abq_get_A1); $i++)
{
	if ($abq_get_A1[$i] == $abq_get_t1)
	{
		$abq_get_selected = ' selected="selected"';
	}
	else
	{
		$abq_get_selected = "";
	}
	$abq_get_s1 .= '<option value="' . $abq_get_A1[$i] . '"' . $abq_get_selected . '>' . $abq_get_A1[$i] . '</option>';
}
$abq_get_s2 = '';
for ($i=0; $i<10; $i++)
{
	if (strval($i) == $abq_get_z1)
	{
		$abq_get_selected = ' selected="selected"';
	}
	else
	{
		$abq_get_selected = "";
	}
	$abq_get_s2 .= '<option value="' . $i . '"' . $abq_get_selected . '>' . $i . '</option>';
}
$abq_get_s3 = '';
for ($i=0; $i<10; $i++)
{
	if (strval($i) == $abq_get_z2)
	{
		$abq_get_selected = ' selected="selected"';
	}
	else
	{
		$abq_get_selected = "";
	}
	$abq_get_s3 .= '<option value="' . $i . '"' . $abq_get_selected . '>' . $i . '</option>';
}
$abq_get_s4 = '';
for ($i=0; $i<10; $i++)
{
	if (strval($i) == $abq_get_z3)
	{
		$abq_get_selected = ' selected="selected"';
	}
	else
	{
		$abq_get_selected = "";
	}
	$abq_get_s4 .= '<option value="' . $i . '"' . $abq_get_selected . '>' . $i . '</option>';
}
$abq_get_s5 = '';
for ($i=0; $i<10; $i++)
{
	if (strval($i) == $abq_get_z4)
	{
		$abq_get_selected = ' selected="selected"';
	}
	else
	{
		$abq_get_selected = "";
	}
	$abq_get_s5 .= '<option value="' . $i . '"' . $abq_get_selected . '>' . $i . '</option>';
}
$abq_get_s6 = '';
for ($i=0; $i<count($abq_get_A2); $i++)
{
	if ($abq_get_A2[$i] == $abq_get_t2)
	{
		$abq_get_selected = ' selected="selected"';
	}
	else
	{
		$abq_get_selected = "";
	}
	$abq_get_s6 .= '<option value="' . $abq_get_A2[$i] . '"' . $abq_get_selected . '>' . $abq_get_A2[$i] . '</option>';
}

$template->set_filenames(array(
	'body' => 'admin/abq_config_body.tpl')
);

if ($GDL_JN < 1)
{
	$template->assign_block_vars('switch_readonly1', array());
}
if (!$FTL_JN)
{
	$template->assign_block_vars('switch_readonly2', array());
}

$template->assign_vars(array(
	'U_CONFIG_ACTION' => append_sid("abq_config.$phpEx"), 
	'L_YES' => $lang['Yes'], 
	'L_NO' => $lang['No'], 
	'L_RAND' => $lang['ABQ_Rand'], 
	'L_SUBMIT' => $lang['Submit'], 
	'L_RESET' => $lang['Reset'], 
	'L_CONFIGURATION_TITLE' => $lang['ABQ_MOD'] . ' - ' . $lang['Configuration'], 
	'L_READONLY1' => (($GDL_JN < 1) ? ' *' : ''), 
	'L_READONLY1_EXPLAIN' => '* - ' . $lang['ABQ_ReadOnly1_Explain'], 
	'L_READONLY2' => ((!$FTL_JN) ? ' **' : ''), 
	'L_READONLY2_EXPLAIN' => '** - ' . $lang['ABQ_ReadOnly2_Explain'], 
	'L_AKTIVATE' => $lang['ABQ_Aktivate'], 
	'L_AKTIVATE_EXPLAIN' => $lang['ABQ_Aktivate_explain'], 
	'L_ANTI_BOT_QUEST_REGISTER' => $lang['ABQ_Register'], 
	'L_ANTI_BOT_QUEST_REGISTER_EXPLAIN' => $lang['ABQ_Register_explain'], 
	'L_ANTI_BOT_QUEST_CONFIRM' => ($board_config['enable_confirm']) ? '<br />'.$lang['ABQ_confirm_aktiv'] : '', 
	'L_ANTI_BOT_QUEST_GUEST' => $lang['ABQ_Guest'], 
	'L_ANTI_BOT_QUEST_GUEST_EXPLAIN' => $lang['ABQ_Guest_explain'], 
	'S_ANTI_BOT_QUEST_REGISTER_ENABLE' => $abq_register_yes, 
	'S_ANTI_BOT_QUEST_REGISTER_DISABLE' => $abq_register_no, 
	'S_ANTI_BOT_QUEST_GUEST_ENABLE' => $abq_guest_yes, 
	'S_ANTI_BOT_QUEST_GUEST_DISABLE' => $abq_guest_no, 
	'L_GENERAL_SETTINGS' => $lang['ABQ_GeneralConfig'], 
	'L_VARNAME' => $lang['ABQ_VarName'], 
	'L_VARNAME_EXPLAIN' => $lang['ABQ_VarName_Explain'],
	'L_VERHEFAF' => $lang['ABQ_VerhEFAF'], 
	'L_VERHEFAF_EXPLAIN' => $lang['ABQ_VerhEFAF_Explain'], 
	'S_VARNAME1' => $abq_get_s1, 
	'S_VARNAME2' => $abq_get_s2, 
	'S_VARNAME3' => $abq_get_s3, 
	'S_VARNAME4' => $abq_get_s4, 
	'S_VARNAME5' => $abq_get_s5, 
	'S_VARNAME6' => $abq_get_s6,
	'S_VERHEFAF_VALUE' => $new['verhaeltnis_eigene_auto'], 
	'L_EF_SETTINGS' => $lang['ABQ_EFConfig'], 
	'L_EF_SETTINGS_EXPLAIN' => $lang['ABQ_EFConfig_explain'], 
	'L_INDIVIDUELQUESTS' => $lang['ABQ_IndividulleFragenVerwenden'],
	'L_INDIVIDUELQUESTS_EXPLAIN' => $lang['ABQ_IndividulleFragenVerwenden_Explain'],
	'L_CASESEN' => $lang['ABQ_CaseSensitive'],
	'L_CASESEN_EXPLAIN' => $lang['ABQ_CaseSensitive_Explain'],
	'L_BILDPHP' => $lang['ABQ_BildPHP'], 
	'L_BILDPHP_EXPLAIN' => sprintf($lang['ABQ_BildPHP_Explain'], '<img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=test" width="60" height="30" alt="" />'), 
	'S_EF_ENABLE' => $ef_yes, 
	'S_EF_DISABLE' => $ef_no, 
	'S_CASESEN_ENABLE' => $efcasesen_yes, 
	'S_CASESEN_DISABLE' => $efcasesen_no, 
	'S_BILDPHP_ENABLE' => $bildphp_yes, 
	'S_BILDPHP_DISABLE' => $bildphp_no, 

	'L_AF_SETTINGS' => $lang['ABQ_AFConfig'], 
	'L_AF_SETTINGS_EXPLAIN' => sprintf($lang['ABQ_AFConfig_explain'], (($GDL_JN > 0) ? $lang['ABQ_installiert'] : '<b>' . $lang['ABQ_nicht_installiert'] . '</b>'), (($FTL_JN) ? $lang['ABQ_installiert'] : '<b>' . $lang['ABQ_nicht_installiert'] . '</b>')) . (($FTL_JN) ? '' : '<br />' . ($lang['ABQ_AFConfig_explain2'] . '<br /><img src="' . $phpbb_root_path . 'images/abq_mod/admin/001a.jpg" alt="' . $lang['ABQ_AFConfig_explain2'] . '" /><br clear="all" />' . $lang['ABQ_AFConfig_explain3'] . ':<br /><img src="' . $phpbb_root_path . 'images/abq_mod/admin/001.jpg" alt="' . $lang['ABQ_AFConfig_explain3'] . '" />')), 
	'L_IMAGETYPE' => $lang['ABQ_ImageType'], 
	'L_JPG' => $lang['ABQ_JPG'], 
	'L_PNG' => $lang['ABQ_PNG'], 
	'L_AF_JPGQUALITY' => $lang['ABQ_JPGQuality'], 
	'L_AF_JPGQUALITY_EXPLAIN' => $lang['ABQ_JPGQuality_Explain'], 
	'L_AF_FONTSIZE' => $lang['ABQ_Fontsize'], 
	'L_AF_FONTSIZE_EXPLAIN' => $lang['ABQ_Fontsize_Explain'], 
	'L_AF_GROSSEZAHLEN' => $lang['ABQ_GrosseZahlen'], 
	'L_AF_GROSSEZAHLEN_EXPLAIN' => $lang['ABQ_GrosseZahlen_Explain'], 
	'L_AFEFF_MAX' => $lang['ABQ_AFEFF_Max'], 
	'L_AFEFF_MAX_EXPLAIN' => $lang['ABQ_AFEFF_Max_explain'], 
	'L_AFEFF_TRENNLINIE' => $lang['ABQ_AFEFF_Trennlinie'], 
	'L_AFEFF_TRENNLINIE_EXPLAIN' => $lang['ABQ_AFEFF_Trennlinie_explain'] . '<br /><a href="' . $phpbb_root_path . 'images/abq_mod/admin/001' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'L_AFEFF_BGTEXT' => $lang['ABQ_AFEFF_BGText'], 
	'L_AFEFF_BGTEXT_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/002' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'L_AFEFF_GRID' => $lang['ABQ_AFEFF_Grid'], 
	'L_AFEFF_GRID_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/003' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'L_AFEFF_GRIDW' => $lang['ABQ_AFEFF_GridW'], 
	'L_AFEFF_GRIDW_EXPLAIN' => $lang['ABQ_AFEFF_GridW_explain'], 
	'L_AFEFF_GRIDH' => $lang['ABQ_AFEFF_GridH'], 
	'L_AFEFF_GRIDH_EXPLAIN' => $lang['ABQ_AFEFF_GridH_explain'], 
	'L_AFEFF_GRIDF' => $lang['ABQ_AFEFF_GridF'], 
	'L_AFEFF_GRIDF_EXPLAIN' => $lang['ABQ_AFEFF_GridF_explain'] . '<br /><a href="' . $phpbb_root_path . 'images/abq_mod/admin/004' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'L_AFEFF_ELLIPSEN' => $lang['ABQ_AFEFF_Ellipsen'], 
	'L_AFEFF_ELLIPSEN_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/005' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'L_AFEFF_BOEGEN' => $lang['ABQ_AFEFF_Boegen'], 
	'L_AFEFF_BOEGEN_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/006' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'L_AFEFF_LINIEN' => $lang['ABQ_AFEFF_Linien'], 
	'L_AFEFF_LINIEN_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/007' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'L_AF_MALZEICHEN' => $lang['ABQ_AF_Malzeichen'], 
	'L_AF_MALZEICHEN_EXPLAIN' => $lang['ABQ_AF_Malzeichen_Explain'], 
	'L_AF_USE_SELECT' => $lang['ABQ_AF_Use_Select'], 
	'L_AF_USE_SELECT_EXPLAIN' => $lang['ABQ_AF_Use_Select_Explain'], 

	'S_IMAGETYPE_JPG' => $af_imagetype_JPG, 
	'S_IMAGETYPE_PNG' => $af_imagetype_PNG, 
	'S_AF_JPGQUALITY_VALUE' => $new['jpgquality'], 
	'S_AF_FONTSIZE_VALUE' => $new['fontsize'], 
	'S_AFEFF_MAX_VALUE' => $new['afeff_max'], 
	'S_AFEFF_TRENNLINIE_ENABLE' => $afeff_trennlinie_yes, 
	'S_AFEFF_TRENNLINIE_DISABLE' => $afeff_trennlinie_no, 
	'S_AF_GROSSEZAHLEN_ENABLE' => $af_grossezahlen_yes, 
	'S_AF_GROSSEZAHLEN_DISABLE' => $af_grossezahlen_no, 
	'S_AF_GROSSEZAHLEN_RAND' => $af_grossezahlen_rand, 
	'S_AFEFF_BGTEXT_ENABLE' => $afeff_bgtext_yes, 
	'S_AFEFF_BGTEXT_DISABLE' => $afeff_bgtext_no, 
	'S_AFEFF_BGTEXT_RAND' => $afeff_bgtext_rand, 
	'S_AFEFF_GRID_ENABLE' => $afeff_grid_yes, 
	'S_AFEFF_GRID_DISABLE' => $afeff_grid_no, 
	'S_AFEFF_GRID_RAND' => $afeff_grid_rand, 
	'S_AFEFF_GRIDW_VALUE' => $new['afeff_gridw'], 
	'S_AFEFF_GRIDH_VALUE' => $new['afeff_gridh'], 
	'S_AFEFF_GRIDF_ENABLE' => $afeff_gridf_yes, 
	'S_AFEFF_GRIDF_DISABLE' => $afeff_gridf_no, 
	'S_AFEFF_GRIDF_RAND' => $afeff_gridf_rand, 
	'S_AFEFF_ELLIPSEN_ENABLE' => $afeff_ellipsen_yes, 
	'S_AFEFF_ELLIPSEN_DISABLE' => $afeff_ellipsen_no, 
	'S_AFEFF_ELLIPSEN_RAND' => $afeff_ellipsen_rand, 
	'S_AFEFF_BOEGEN_ENABLE' => $afeff_boegen_yes, 
	'S_AFEFF_BOEGEN_DISABLE' => $afeff_boegen_no, 
	'S_AFEFF_BOEGEN_RAND' => $afeff_boegen_rand, 
	'S_AFEFF_LINIEN_ENABLE' => $afeff_linien_yes, 
	'S_AFEFF_LINIEN_DISABLE' => $afeff_linien_no, 
	'S_AFEFF_LINIEN_RAND' => $afeff_linien_rand, 
	'S_AF_MALZEICHEN_1' => $af_malzeichen_1, 
	'S_AF_MALZEICHEN_2' => $af_malzeichen_2, 
	'S_AF_MALZEICHEN_3' => $af_malzeichen_3, 
	'S_AF_USE_SELECT_ENABLE' => $af_use_select_yes, 
	'S_AF_USE_SELECT_DISABLE' => $af_use_select_no, 

	'L_MM_CONFIG' => $lang['ABQ_AdminI_Config'], 
	'U_MM_CONFIG' => append_sid("abq_config.$phpEx"), 
	'L_MM_AUTOFRAGEN' => $lang['ABQ_AdminI_AutoFragen'], 
	'U_MM_AUTOFRAGEN' => append_sid("abq_auto_quests.$phpEx"), 
	'L_MM_FONTS' => $lang['ABQ_AdminI_Fonts'], 
	'U_MM_FONTS' => append_sid("abq_fonts.$phpEx"), 
	'L_MM_CONFIG2' => $lang['ABQ_AdminI_Config2'], 
	'U_MM_CONFIG2' => append_sid("abq_config2.$phpEx"), 
	'L_MM_INDIFRAGEN' => $lang['ABQ_AdminI_IndiFragen'], 
	'U_MM_INDIFRAGEN' => append_sid("abq_indi_quests.$phpEx"), 
	'L_MM_IIMAGES' => $lang['ABQ_AdminI_IndiImages'], 
	'U_MM_IIMAGES' => append_sid("abq_indi_images.$phpEx"), 
	'L_ABQ_VERSION' => $lang['ABQ_Version'])
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);
?>