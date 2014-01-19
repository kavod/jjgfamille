<?php
/***************************************************************************
 *                          abq_auto_quests.php
 *                          -------------------
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

/*
$Schrift = str_replace('index.'.$phpEx, '', realpath($phpbb_root_path.'index.'.$phpEx));
$Schrift = $Schrift . 'abq_mod/fonts/do-not-delete.ttf';
$FTL_JN = @imagettfbbox(10, 0, $Schrift, 'AAA');
*/
$FTL_JN = 0;
$GDL_JN = 0;
ABQ_gdVersion();

if( isset($HTTP_POST_VARS['submit']) )
{
	$ABQ_Error = '';

	unset($i);
	for ($i=1; $i<35; $i++)
	{
		unset($j);
		$j = $i;
		if ($i < 10)
		{
			$j = '0' . $j;
		}
		if (($GDL_JN < 1) && (($i == 1) || ($i == 2) || ($i == 3) || ($i == 4) || ($i == 9) || ($i == 10) || ($i == 11) || ($i == 12) || ($i == 17) || ($i == 18) || ($i == 19) || ($i == 20) || ($i == 25) || ($i == 26) || ($i == 27) || ($i == 31) || ($i == 32) || ($i == 34)))
		{
			${'new_autofrage_'.$j} = '0';
		}
		elseif (($HTTP_POST_VARS['autofrage_'.$j] == '1') || ($HTTP_POST_VARS['autofrage_'.$j] == '0'))
		{
			${'new_autofrage_'.$j} = $HTTP_POST_VARS['autofrage_'.$j];
		}
		else
		{
			${'new_autofrage_'.$j} = '0';
		}

		$sql = 'UPDATE ' . ANTI_BOT_QUEST_CONFIG_TABLE . ' SET 
			config_value = \'' . ${'new_autofrage_'.$j} . '\' 
			WHERE config_name = \'autofrage_' . $j . '\'';
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to update anti bot question mod configuration for $config_name", "", __LINE__, __FILE__, $sql);
		}
	}

	$message = $lang['ABQ_Config_updated'] . "<br /><br />" . sprintf($lang['ABQ_Click_return_config'], "<a href=\"" . append_sid("abq_auto_quests.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}

$sql = 'SELECT * 
	FROM ' . ANTI_BOT_QUEST_CONFIG_TABLE . '
	WHERE config_name LIKE \'autofrage_%\'';
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in abq_auto_quests", "", __LINE__, __FILE__, $sql);
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

unset($i);
for ($i=1; $i<35; $i++)
{
	$j = $i;
	if ($i < 10)
	{
		$j = '0' . $i;
	}
	if (($GDL_JN < 1) && (($i == 1) || ($i == 2) || ($i == 3) || ($i == 4) || ($i == 9) || ($i == 10) || ($i == 11) || ($i == 12) || ($i == 17) || ($i == 18) || ($i == 19) || ($i == 20) || ($i == 25) || ($i == 26) || ($i == 27) || ($i == 31) || ($i == 32) || ($i == 34)))
	{
		${'abq_autofrage_'.$j.'_yes'} = '';
		${'abq_autofrage_'.$j.'_no'} = 'checked="checked"';
	}
	else
	{
		${'abq_autofrage_'.$j.'_yes'} = ($new['autofrage_'.$j]) ? 'checked="checked"' : '';
		${'abq_autofrage_'.$j.'_no'} = (!$new['autofrage_'.$j]) ? 'checked="checked"' : '';
	}
}

$template->set_filenames(array(
	'body' => 'admin/abq_auto_quests_body.tpl')
);

if ($GDL_JN < 1)
{
	$template->assign_block_vars('switch_readonly1', array());
}

$template->assign_vars(array(
	'U_CONFIG_ACTION' => append_sid("abq_auto_quests.$phpEx"), 
	'L_YES' => $lang['Yes'], 
	'L_NO' => $lang['No'], 
	'L_SUBMIT' => $lang['Submit'], 
	'L_RESET' => $lang['Reset'], 
	'L_READONLY1' => (($GDL_JN < 1) ? ' *' : ''), 
	'L_READONLY1_EXPLAIN' => '* - ' . $lang['ABQ_ReadOnly1_Explain'], 
	'L_AUTO_QUESTS_CONFIGURATION_TITLE' => $lang['ABQ_MOD'] . ' - ' . $lang['ABQ_AutoQuestVerwalt'], 
	'L_AUTO_QUESTS_CONFIGURATION_EXPLAIN' => sprintf($lang['ABQ_AutoQuestVerwalt_Explain'], (($GDL_JN > 0) ? $lang['ABQ_installiert'] : '<b>' . $lang['ABQ_nicht_installiert'] . '</b>')), 
	'L_AUTO_QUESTS_TEXTQUESTIONS_TITLE' => $lang['ABQ_AutoQuestVerwalt_TQ'], 
	'L_AUTO_QUESTS_IMAGEQUESTIONS_TITLE' => $lang['ABQ_AutoQuestVerwalt_IQ'], 
	'L_TYP1' => $lang['ABQ_Typ'] . ' 1', 
	'L_TYP2' => $lang['ABQ_Typ'] . ' 2', 
	'L_TYP3' => $lang['ABQ_Typ'] . ' 3', 
	'L_TYP4' => $lang['ABQ_Typ'] . ' 4', 
	'L_TYP5' => $lang['ABQ_Typ'] . ' 5', 
	'L_TYP6' => $lang['ABQ_Typ'] . ' 6', 
	'L_AQUEST01' => sprintf($lang['ABQ_AF01'], sprintf($lang['ABQ_AFrageTyp01'], 'x')), 
	'L_AQUEST01_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/101' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST01_ENABLE' => $abq_autofrage_01_yes, 
	'S_AQUEST01_DISABLE' => $abq_autofrage_01_no, 
	'L_AQUEST02' => sprintf($lang['ABQ_AF02'], sprintf($lang['ABQ_AFrageTyp01'], 'x')), 
	'L_AQUEST02_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/102' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST02_ENABLE' => $abq_autofrage_02_yes, 
	'S_AQUEST02_DISABLE' => $abq_autofrage_02_no, 
	'L_AQUEST03' => sprintf($lang['ABQ_AF03'], sprintf($lang['ABQ_AFrageTyp01'], 'x')), 
	'L_AQUEST03_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/103' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST03_ENABLE' => $abq_autofrage_03_yes, 
	'S_AQUEST03_DISABLE' => $abq_autofrage_03_no, 
	'L_AQUEST04' => sprintf($lang['ABQ_AF04'], $lang['ABQ_AFrageTyp02']), 
	'L_AQUEST04_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/104' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST04_ENABLE' => $abq_autofrage_04_yes, 
	'S_AQUEST04_DISABLE' => $abq_autofrage_04_no, 
	'L_AQUEST05' => sprintf($lang['ABQ_AF05'], sprintf($lang['ABQ_AFrageTyp01'], 'x')), 
	'L_AQUEST05_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/105.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST05_ENABLE' => $abq_autofrage_05_yes, 
	'S_AQUEST05_DISABLE' => $abq_autofrage_05_no, 
	'L_AQUEST06' => sprintf($lang['ABQ_AF06'], sprintf($lang['ABQ_AFrageTyp01'], 'x')), 
	'L_AQUEST06_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/106.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST06_ENABLE' => $abq_autofrage_06_yes, 
	'S_AQUEST06_DISABLE' => $abq_autofrage_06_no, 
	'L_AQUEST07' => sprintf($lang['ABQ_AF07'], sprintf($lang['ABQ_AFrageTyp01'], 'x')), 
	'L_AQUEST07_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/107.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST07_ENABLE' => $abq_autofrage_07_yes, 
	'S_AQUEST07_DISABLE' => $abq_autofrage_07_no, 
	'L_AQUEST08' => sprintf($lang['ABQ_AF08'], $lang['ABQ_AFrageTyp02']), 
	'L_AQUEST08_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/108.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST08_ENABLE' => $abq_autofrage_08_yes, 
	'S_AQUEST08_DISABLE' => $abq_autofrage_08_no, 
	'L_AQUEST09' => sprintf($lang['ABQ_AF09'], sprintf($lang['ABQ_AFrageTyp03'], 'x')), 
	'L_AQUEST09_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/109' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST09_ENABLE' => $abq_autofrage_09_yes, 
	'S_AQUEST09_DISABLE' => $abq_autofrage_09_no, 
	'L_AQUEST10' => sprintf($lang['ABQ_AF10'], sprintf($lang['ABQ_AFrageTyp03'], 'x')), 
	'L_AQUEST10_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/110' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST10_ENABLE' => $abq_autofrage_10_yes, 
	'S_AQUEST10_DISABLE' => $abq_autofrage_10_no, 
	'L_AQUEST11' => sprintf($lang['ABQ_AF11'], sprintf($lang['ABQ_AFrageTyp03'], 'x')), 
	'L_AQUEST11_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/111' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST11_ENABLE' => $abq_autofrage_11_yes, 
	'S_AQUEST11_DISABLE' => $abq_autofrage_11_no, 
	'L_AQUEST12' => sprintf($lang['ABQ_AF12'], $lang['ABQ_AFrageTyp04']), 
	'L_AQUEST12_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/112' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST12_ENABLE' => $abq_autofrage_12_yes, 
	'S_AQUEST12_DISABLE' => $abq_autofrage_12_no, 
	'L_AQUEST13' => sprintf($lang['ABQ_AF13'], sprintf($lang['ABQ_AFrageTyp03'], 'x')), 
	'L_AQUEST13_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/113.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST13_ENABLE' => $abq_autofrage_13_yes, 
	'S_AQUEST13_DISABLE' => $abq_autofrage_13_no, 
	'L_AQUEST14' => sprintf($lang['ABQ_AF14'], sprintf($lang['ABQ_AFrageTyp03'], 'x')), 
	'L_AQUEST14_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/114.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST14_ENABLE' => $abq_autofrage_14_yes, 
	'S_AQUEST14_DISABLE' => $abq_autofrage_14_no, 
	'L_AQUEST15' => sprintf($lang['ABQ_AF15'], sprintf($lang['ABQ_AFrageTyp03'], 'x')), 
	'L_AQUEST15_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/115.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST15_ENABLE' => $abq_autofrage_15_yes, 
	'S_AQUEST15_DISABLE' => $abq_autofrage_15_no, 
	'L_AQUEST16' => sprintf($lang['ABQ_AF16'], $lang['ABQ_AFrageTyp04']), 
	'L_AQUEST16_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/116.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST16_ENABLE' => $abq_autofrage_16_yes, 
	'S_AQUEST16_DISABLE' => $abq_autofrage_16_no, 
	'L_AQUEST17' => sprintf($lang['ABQ_AF17'], sprintf($lang['ABQ_AFrageTyp05'], 'x')), 
	'L_AQUEST17_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/117' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST17_ENABLE' => $abq_autofrage_17_yes, 
	'S_AQUEST17_DISABLE' => $abq_autofrage_17_no, 
	'L_AQUEST18' => sprintf($lang['ABQ_AF18'], sprintf($lang['ABQ_AFrageTyp05'], 'x')), 
	'L_AQUEST18_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/118' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST18_ENABLE' => $abq_autofrage_18_yes, 
	'S_AQUEST18_DISABLE' => $abq_autofrage_18_no, 
	'L_AQUEST19' => sprintf($lang['ABQ_AF19'], sprintf($lang['ABQ_AFrageTyp05'], 'x')), 
	'L_AQUEST19_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/119' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST19_ENABLE' => $abq_autofrage_19_yes, 
	'S_AQUEST19_DISABLE' => $abq_autofrage_19_no, 
	'L_AQUEST20' => sprintf($lang['ABQ_AF20'], $lang['ABQ_AFrageTyp06']), 
	'L_AQUEST20_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/120' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST20_ENABLE' => $abq_autofrage_20_yes, 
	'S_AQUEST20_DISABLE' => $abq_autofrage_20_no, 
	'L_AQUEST21' => sprintf($lang['ABQ_AF21'], sprintf($lang['ABQ_AFrageTyp05'], 'x')), 
	'L_AQUEST21_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/121.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST21_ENABLE' => $abq_autofrage_21_yes, 
	'S_AQUEST21_DISABLE' => $abq_autofrage_21_no, 
	'L_AQUEST22' => sprintf($lang['ABQ_AF22'], sprintf($lang['ABQ_AFrageTyp05'], 'x')), 
	'L_AQUEST22_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/122.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST22_ENABLE' => $abq_autofrage_22_yes, 
	'S_AQUEST22_DISABLE' => $abq_autofrage_22_no, 
	'L_AQUEST23' => sprintf($lang['ABQ_AF23'], sprintf($lang['ABQ_AFrageTyp05'], 'x')), 
	'L_AQUEST23_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/123.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST23_ENABLE' => $abq_autofrage_23_yes, 
	'S_AQUEST23_DISABLE' => $abq_autofrage_23_no, 
	'L_AQUEST24' => sprintf($lang['ABQ_AF24'], $lang['ABQ_AFrageTyp06']), 
	'L_AQUEST24_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/124.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST24_ENABLE' => $abq_autofrage_24_yes, 
	'S_AQUEST24_DISABLE' => $abq_autofrage_24_no, 
	'L_AQUEST25' => sprintf($lang['ABQ_AF25'], sprintf($lang['ABQ_AFrageTyp07'], 'x1, x2, x3, x4, x5, x6, x7 ' . $lang['ABQ_and'] . ' x8')), 
	'L_AQUEST25_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/125' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST25_ENABLE' => $abq_autofrage_25_yes, 
	'S_AQUEST25_DISABLE' => $abq_autofrage_25_no, 
	'L_AQUEST26' => sprintf($lang['ABQ_AF26'], sprintf($lang['ABQ_AFrageTyp07'], 'x1, x2, x3, x4, x5, x6 ' . $lang['ABQ_and'] . ' x7')), 
	'L_AQUEST26_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/126' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST26_ENABLE' => $abq_autofrage_26_yes, 
	'S_AQUEST26_DISABLE' => $abq_autofrage_26_no, 
	'L_AQUEST27' => sprintf($lang['ABQ_AF27'], sprintf($lang['ABQ_AFrageTyp07'], 'x1, x2, x3, x4, x5 ' . $lang['ABQ_and'] . ' x6')), 
	'L_AQUEST27_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/127' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST27_ENABLE' => $abq_autofrage_27_yes, 
	'S_AQUEST27_DISABLE' => $abq_autofrage_27_no, 
	'L_AQUEST28' => sprintf($lang['ABQ_AF28'], sprintf($lang['ABQ_AFrageTyp07'], 'x1, x2, x3, x4, x5, x6, x7 ' . $lang['ABQ_and'] . ' x8')), 
	'L_AQUEST28_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/128.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST28_ENABLE' => $abq_autofrage_28_yes, 
	'S_AQUEST28_DISABLE' => $abq_autofrage_28_no, 
	'L_AQUEST29' => sprintf($lang['ABQ_AF29'], sprintf($lang['ABQ_AFrageTyp07'], 'x1, x2, x3, x4, x5, x6 ' . $lang['ABQ_and'] . ' x7')), 
	'L_AQUEST29_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/129.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST29_ENABLE' => $abq_autofrage_29_yes, 
	'S_AQUEST29_DISABLE' => $abq_autofrage_29_no, 
	'L_AQUEST30' => sprintf($lang['ABQ_AF30'], sprintf($lang['ABQ_AFrageTyp07'], 'x1, x2, x3, x4, x5 ' . $lang['ABQ_and'] . ' x6')), 
	'L_AQUEST30_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/130.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST30_ENABLE' => $abq_autofrage_30_yes, 
	'S_AQUEST30_DISABLE' => $abq_autofrage_30_no, 
	'L_AQUEST31' => sprintf($lang['ABQ_AF31'], sprintf($lang['ABQ_AFrageTyp08'], $lang['ABQ_Farbe1'])), 
	'L_AQUEST31_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/131' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST31_ENABLE' => $abq_autofrage_31_yes, 
	'S_AQUEST31_DISABLE' => $abq_autofrage_31_no, 
	'L_AQUEST32' => sprintf($lang['ABQ_AF32'], sprintf($lang['ABQ_AFrageTyp08'], $lang['ABQ_Farbe2'])), 
	'L_AQUEST32_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/132' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST32_ENABLE' => $abq_autofrage_32_yes, 
	'S_AQUEST32_DISABLE' => $abq_autofrage_32_no, 
	'L_AQUEST33' => sprintf($lang['ABQ_AF33'], $lang['ABQ_AFrageTyp09']), 
	'L_AQUEST33_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/133' . (($FTL_JN) ? '' : 'a') . '.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST33_ENABLE' => $abq_autofrage_33_yes, 
	'S_AQUEST33_DISABLE' => $abq_autofrage_33_no, 
	'L_AQUEST34' => sprintf($lang['ABQ_AF34'], $lang['ABQ_AFrageTyp09']), 
	'L_AQUEST34_EXPLAIN' => '<a href="' . $phpbb_root_path . 'images/abq_mod/admin/134.jpg" title="' . $lang['ABQ_Beispiel'] . '" target="_blank">' . $lang['ABQ_Beispiel'] . '</a>', 
	'S_AQUEST34_ENABLE' => $abq_autofrage_34_yes, 
	'S_AQUEST34_DISABLE' => $abq_autofrage_34_no, 

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