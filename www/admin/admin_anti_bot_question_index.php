<?php
/***************************************************************************
 *                          admin_anti_bot_question_index.php
 *                          ---------------------------------
 *   Version              : Version 2.0.0 - 26.11.2006
 *   copyright            : (C) 2005-2006 M.W.
 *   URL                  : http://phpbb.mwegner.de/
 *
 ***************************************************************************/

define('IN_PHPBB', true);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ABQ_MOD']['ABQ_MOD'] = $filename;
	return;
}

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

$template->set_filenames(array(
	'body' => 'admin/abq_index_body.tpl')
);

$template->assign_vars(array(
	'L_ABQ_ACP' => $lang['ABQ_MOD'] . ' - ' . $lang['ABQ_Admin_Index'], 
	'L_ABQ_ACP_EXPLAIN' => $lang['ABQ_Admin_Index_Explain'], 
	'L_GENERAL' => $lang['ABQ_Allgemeines'], 
	'L_AUTOQUESTS' => $lang['ABQ_QuestAuto'], 
	'L_INDIQUESTS' => $lang['ABQ_QuestIndi'],

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