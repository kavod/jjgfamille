<?php
/***************************************************************************
 *                          abq_config2.php
 *                          ---------------
 *   Version              : Version 2.0.0 - 26.11.2006
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

if (isset($HTTP_POST_VARS['submit']))
{
	$DatenPost = array();
	$ABQ_Error = '';
	$ABQ_Error1 = 0;
	$ABQ_Error2 = 0;

	$ABQ_POSTVaris = array();
	$ABQ_POSTVaris[0][1] = 'Color_BG_R1';
	$ABQ_POSTVaris[0][2] = 'Color_BG_R2';
	$ABQ_POSTVaris[1][1] = 'Color_BG_G1';
	$ABQ_POSTVaris[1][2] = 'Color_BG_G2';
	$ABQ_POSTVaris[2][1] = 'Color_BG_B1';
	$ABQ_POSTVaris[2][2] = 'Color_BG_B2';
	$ABQ_POSTVaris[3][1] = 'Color_Grid1_R1';
	$ABQ_POSTVaris[3][2] = 'Color_Grid1_R2';
	$ABQ_POSTVaris[4][1] = 'Color_Grid1_G1';
	$ABQ_POSTVaris[4][2] = 'Color_Grid1_G2';
	$ABQ_POSTVaris[5][1] = 'Color_Grid1_B1';
	$ABQ_POSTVaris[5][2] = 'Color_Grid1_B2';
	$ABQ_POSTVaris[6][1] = 'Color_Grid2_R1';
	$ABQ_POSTVaris[6][2] = 'Color_Grid2_R2';
	$ABQ_POSTVaris[7][1] = 'Color_Grid2_G1';
	$ABQ_POSTVaris[7][2] = 'Color_Grid2_G2';
	$ABQ_POSTVaris[8][1] = 'Color_Grid2_B1';
	$ABQ_POSTVaris[8][2] = 'Color_Grid2_B2';
	$ABQ_POSTVaris[9][1] = 'Color_Grid3_R1';
	$ABQ_POSTVaris[9][2] = 'Color_Grid3_R2';
	$ABQ_POSTVaris[10][1] = 'Color_Grid3_G1';
	$ABQ_POSTVaris[10][2] = 'Color_Grid3_G2';
	$ABQ_POSTVaris[11][1] = 'Color_Grid3_B1';
	$ABQ_POSTVaris[11][2] = 'Color_Grid3_B2';
	$ABQ_POSTVaris[12][1] = 'Color_Grid4_R1';
	$ABQ_POSTVaris[12][2] = 'Color_Grid4_R2';
	$ABQ_POSTVaris[13][1] = 'Color_Grid4_G1';
	$ABQ_POSTVaris[13][2] = 'Color_Grid4_G2';
	$ABQ_POSTVaris[14][1] = 'Color_Grid4_B1';
	$ABQ_POSTVaris[14][2] = 'Color_Grid4_B2';
	$ABQ_POSTVaris[15][1] = 'Color_GridF_R1';
	$ABQ_POSTVaris[15][2] = 'Color_GridF_R2';
	$ABQ_POSTVaris[16][1] = 'Color_GridF_G1';
	$ABQ_POSTVaris[16][2] = 'Color_GridF_G2';
	$ABQ_POSTVaris[17][1] = 'Color_GridF_B1';
	$ABQ_POSTVaris[17][2] = 'Color_GridF_B2';
	$ABQ_POSTVaris[18][1] = 'Color_Ellipsen_R1';
	$ABQ_POSTVaris[18][2] = 'Color_Ellipsen_R2';
	$ABQ_POSTVaris[19][1] = 'Color_Ellipsen_G1';
	$ABQ_POSTVaris[19][2] = 'Color_Ellipsen_G2';
	$ABQ_POSTVaris[20][1] = 'Color_Ellipsen_B1';
	$ABQ_POSTVaris[20][2] = 'Color_Ellipsen_B2';
	$ABQ_POSTVaris[21][1] = 'Color_TEllipsen_R1';
	$ABQ_POSTVaris[21][2] = 'Color_TEllipsen_R2';
	$ABQ_POSTVaris[22][1] = 'Color_TEllipsen_G1';
	$ABQ_POSTVaris[22][2] = 'Color_TEllipsen_G2';
	$ABQ_POSTVaris[23][1] = 'Color_TEllipsen_B1';
	$ABQ_POSTVaris[23][2] = 'Color_TEllipsen_B2';
	$ABQ_POSTVaris[24][1] = 'Color_Lines_R1';
	$ABQ_POSTVaris[24][2] = 'Color_Lines_R2';
	$ABQ_POSTVaris[25][1] = 'Color_Lines_G1';
	$ABQ_POSTVaris[25][2] = 'Color_Lines_G2';
	$ABQ_POSTVaris[26][1] = 'Color_Lines_B1';
	$ABQ_POSTVaris[26][2] = 'Color_Lines_B2';
	$ABQ_POSTVaris[27][1] = 'Color_Arcs_R1';
	$ABQ_POSTVaris[27][2] = 'Color_Arcs_R2';
	$ABQ_POSTVaris[28][1] = 'Color_Arcs_G1';
	$ABQ_POSTVaris[28][2] = 'Color_Arcs_G2';
	$ABQ_POSTVaris[29][1] = 'Color_Arcs_B1';
	$ABQ_POSTVaris[29][2] = 'Color_Arcs_B2';
	$ABQ_POSTVaris[30][1] = 'Color_BGText_R1';
	$ABQ_POSTVaris[30][2] = 'Color_BGText_R2';
	$ABQ_POSTVaris[31][1] = 'Color_BGText_G1';
	$ABQ_POSTVaris[31][2] = 'Color_BGText_G2';
	$ABQ_POSTVaris[32][1] = 'Color_BGText_B1';
	$ABQ_POSTVaris[32][2] = 'Color_BGText_B2';
	$ABQ_POSTVaris[33][1] = 'Color_Text_R1';
	$ABQ_POSTVaris[33][2] = 'Color_Text_R2';
	$ABQ_POSTVaris[34][1] = 'Color_Text_G1';
	$ABQ_POSTVaris[34][2] = 'Color_Text_G2';
	$ABQ_POSTVaris[35][1] = 'Color_Text_B1';
	$ABQ_POSTVaris[35][2] = 'Color_Text_B2';
	$ABQ_POSTVaris[36][1] = 'Color_SLines_R1';
	$ABQ_POSTVaris[36][2] = 'Color_SLines_R2';
	$ABQ_POSTVaris[37][1] = 'Color_SLines_G1';
	$ABQ_POSTVaris[37][2] = 'Color_SLines_G2';
	$ABQ_POSTVaris[38][1] = 'Color_SLines_B1';
	$ABQ_POSTVaris[38][2] = 'Color_SLines_B2';

	unset($i);
	unset($j);
	$j = count($ABQ_POSTVaris);
	for ($i=0; $i<$j; $i++)
	{
		$DatenPost[] = $ABQ_POSTVaris[$i][1];
		if (($HTTP_POST_VARS[$ABQ_POSTVaris[$i][1]] < 0) || ($HTTP_POST_VARS[$ABQ_POSTVaris[$i][1]] > 255) || (!preg_match('/^[0-9]{1,3}$/',$HTTP_POST_VARS[$ABQ_POSTVaris[$i][1]])))
		{
			$ABQ_Error1 = 1;
			break;
		}
		else
		{
			${'new_'.$ABQ_POSTVaris[$i][1]} = $HTTP_POST_VARS[$ABQ_POSTVaris[$i][1]];
		}
		$DatenPost[] = $ABQ_POSTVaris[$i][2];
		if (($HTTP_POST_VARS[$ABQ_POSTVaris[$i][2]] < 0) || ($HTTP_POST_VARS[$ABQ_POSTVaris[$i][2]] > 255) || (!preg_match('/^[0-9]{1,3}$/',$HTTP_POST_VARS[$ABQ_POSTVaris[$i][1]])))
		{
			$ABQ_Error1 = 1;
			break;
		}
		else
		{
			${'new_'.$ABQ_POSTVaris[$i][2]} = $HTTP_POST_VARS[$ABQ_POSTVaris[$i][2]];
		}
		if ((isset(${'new_'.$ABQ_POSTVaris[$i][1]})) && (isset(${'new_'.$ABQ_POSTVaris[$i][2]})) && (${'new_'.$ABQ_POSTVaris[$i][2]} <= ${'new_'.$ABQ_POSTVaris[$i][1]}))
		{
			$ABQ_Error2 = 1;
			break;
		}
	}

	unset($ABQ_POSTVaris);
	$ABQ_POSTVaris = array();
	$ABQ_POSTVaris[] = 'Color_F1_R';
	$ABQ_POSTVaris[] = 'Color_F1_G';
	$ABQ_POSTVaris[] = 'Color_F1_B';
	$ABQ_POSTVaris[] = 'Color_F2_R';
	$ABQ_POSTVaris[] = 'Color_F2_G';
	$ABQ_POSTVaris[] = 'Color_F2_B';

	unset($i);
	unset($j);
	$j = count($ABQ_POSTVaris);
	for ($i=0; $i<$j; $i++)
	{
		$DatenPost[] = $ABQ_POSTVaris[$i];
		if (($HTTP_POST_VARS[$ABQ_POSTVaris[$i]] < 0) || ($HTTP_POST_VARS[$ABQ_POSTVaris[$i]] > 255) || (!preg_match('/^[0-9]{1,3}$/',$HTTP_POST_VARS[$ABQ_POSTVaris[$i]])))
		{
			$ABQ_Error1 = 1;
			break;
		}
		else
		{
			${'new_'.$ABQ_POSTVaris[$i]} = $HTTP_POST_VARS[$ABQ_POSTVaris[$i]];
		}
	}

	if ($ABQ_Error1)
	{
		$ABQ_Error .= $lang['ABQ_ColorRand_WrongValue'] . '<br />';
	}
	if ($ABQ_Error2)
	{
		$ABQ_Error .= $lang['ABQ_ColorRand_2NichtGroesser1'] . '<br />';
	}
}
elseif (isset($HTTP_POST_VARS['valuereset']))
{
	$DatenPost = array();
	$ABQ_Error = '';

	if ((!isset($HTTP_POST_VARS['valueresetcheck'])) || ($HTTP_POST_VARS['valueresetcheck'] != 'OK'))
	{
		$ABQ_Error .= $lang['ABQ_Valuereset_Not_Checked'] . '<br />';
	}

	$DatenPost[] = 'Color_BG_R1';
	$DatenPost[] = 'Color_BG_R2';
	$DatenPost[] = 'Color_BG_G1';
	$DatenPost[] = 'Color_BG_G2';
	$DatenPost[] = 'Color_BG_B1';
	$DatenPost[] = 'Color_BG_B2';
	$DatenPost[] = 'Color_F1_R';
	$DatenPost[] = 'Color_F1_G';
	$DatenPost[] = 'Color_F1_B';
	$DatenPost[] = 'Color_F2_R';
	$DatenPost[] = 'Color_F2_G';
	$DatenPost[] = 'Color_F2_B';
	$DatenPost[] = 'Color_Grid1_R1';
	$DatenPost[] = 'Color_Grid1_R2';
	$DatenPost[] = 'Color_Grid1_G1';
	$DatenPost[] = 'Color_Grid1_G2';
	$DatenPost[] = 'Color_Grid1_B1';
	$DatenPost[] = 'Color_Grid1_B2';
	$DatenPost[] = 'Color_Grid2_R1';
	$DatenPost[] = 'Color_Grid2_R2';
	$DatenPost[] = 'Color_Grid2_G1';
	$DatenPost[] = 'Color_Grid2_G2';
	$DatenPost[] = 'Color_Grid2_B1';
	$DatenPost[] = 'Color_Grid2_B2';
	$DatenPost[] = 'Color_Grid3_R1';
	$DatenPost[] = 'Color_Grid3_R2';
	$DatenPost[] = 'Color_Grid3_G1';
	$DatenPost[] = 'Color_Grid3_G2';
	$DatenPost[] = 'Color_Grid3_B1';
	$DatenPost[] = 'Color_Grid3_B2';
	$DatenPost[] = 'Color_Grid4_R1';
	$DatenPost[] = 'Color_Grid4_R2';
	$DatenPost[] = 'Color_Grid4_G1';
	$DatenPost[] = 'Color_Grid4_G2';
	$DatenPost[] = 'Color_Grid4_B1';
	$DatenPost[] = 'Color_Grid4_B2';
	$DatenPost[] = 'Color_GridF_R1';
	$DatenPost[] = 'Color_GridF_R2';
	$DatenPost[] = 'Color_GridF_G1';
	$DatenPost[] = 'Color_GridF_G2';
	$DatenPost[] = 'Color_GridF_B1';
	$DatenPost[] = 'Color_GridF_B2';
	$DatenPost[] = 'Color_Ellipsen_R1';
	$DatenPost[] = 'Color_Ellipsen_R2';
	$DatenPost[] = 'Color_Ellipsen_G1';
	$DatenPost[] = 'Color_Ellipsen_G2';
	$DatenPost[] = 'Color_Ellipsen_B1';
	$DatenPost[] = 'Color_Ellipsen_B2';
	$DatenPost[] = 'Color_TEllipsen_R1';
	$DatenPost[] = 'Color_TEllipsen_R2';
	$DatenPost[] = 'Color_TEllipsen_G1';
	$DatenPost[] = 'Color_TEllipsen_G2';
	$DatenPost[] = 'Color_TEllipsen_B1';
	$DatenPost[] = 'Color_TEllipsen_B2';
	$DatenPost[] = 'Color_Lines_R1';
	$DatenPost[] = 'Color_Lines_R2';
	$DatenPost[] = 'Color_Lines_G1';
	$DatenPost[] = 'Color_Lines_G2';
	$DatenPost[] = 'Color_Lines_B1';
	$DatenPost[] = 'Color_Lines_B2';
	$DatenPost[] = 'Color_Arcs_R1';
	$DatenPost[] = 'Color_Arcs_R2';
	$DatenPost[] = 'Color_Arcs_G1';
	$DatenPost[] = 'Color_Arcs_G2';
	$DatenPost[] = 'Color_Arcs_B1';
	$DatenPost[] = 'Color_Arcs_B2';
	$DatenPost[] = 'Color_BGText_R1';
	$DatenPost[] = 'Color_BGText_R2';
	$DatenPost[] = 'Color_BGText_G1';
	$DatenPost[] = 'Color_BGText_G2';
	$DatenPost[] = 'Color_BGText_B1';
	$DatenPost[] = 'Color_BGText_B2';
	$DatenPost[] = 'Color_Text_R1';
	$DatenPost[] = 'Color_Text_R2';
	$DatenPost[] = 'Color_Text_G1';
	$DatenPost[] = 'Color_Text_G2';
	$DatenPost[] = 'Color_Text_B1';
	$DatenPost[] = 'Color_Text_B2';
	$DatenPost[] = 'Color_SLines_R1';
	$DatenPost[] = 'Color_SLines_R2';
	$DatenPost[] = 'Color_SLines_G1';
	$DatenPost[] = 'Color_SLines_G2';
	$DatenPost[] = 'Color_SLines_B1';
	$DatenPost[] = 'Color_SLines_B2';
	$new_Color_BG_R1 = 210;
	$new_Color_BG_R2 = 230;
	$new_Color_BG_G1 = 210;
	$new_Color_BG_G2 = 230;
	$new_Color_BG_B1 = 210;
	$new_Color_BG_B2 = 230;
	$new_Color_F1_R = 255;
	$new_Color_F1_G = 50;
	$new_Color_F1_B = 50;
	$new_Color_F2_R = 0;
	$new_Color_F2_G = 255;
	$new_Color_F2_B = 0;
	$new_Color_Grid1_R1 = 225;
	$new_Color_Grid1_R2 = 255;
	$new_Color_Grid1_G1 = 90;
	$new_Color_Grid1_G2 = 110;
	$new_Color_Grid1_B1 = 90;
	$new_Color_Grid1_B2 = 110;
	$new_Color_Grid2_R1 = 90;
	$new_Color_Grid2_R2 = 110;
	$new_Color_Grid2_G1 = 225;
	$new_Color_Grid2_G2 = 255;
	$new_Color_Grid2_B1 = 90;
	$new_Color_Grid2_B2 = 110;
	$new_Color_Grid3_R1 = 90;
	$new_Color_Grid3_R2 = 110;
	$new_Color_Grid3_G1 = 90;
	$new_Color_Grid3_G2 = 110;
	$new_Color_Grid3_B1 = 225;
	$new_Color_Grid3_B2 = 255;
	$new_Color_Grid4_R1 = 130;
	$new_Color_Grid4_R2 = 170;
	$new_Color_Grid4_G1 = 130;
	$new_Color_Grid4_G2 = 170;
	$new_Color_Grid4_B1 = 130;
	$new_Color_Grid4_B2 = 170;
	$new_Color_GridF_R1 = 200;
	$new_Color_GridF_R2 = 255;
	$new_Color_GridF_G1 = 200;
	$new_Color_GridF_G2 = 255;
	$new_Color_GridF_B1 = 200;
	$new_Color_GridF_B2 = 255;
	$new_Color_Ellipsen_R1 = 120;
	$new_Color_Ellipsen_R2 = 255;
	$new_Color_Ellipsen_G1 = 120;
	$new_Color_Ellipsen_G2 = 255;
	$new_Color_Ellipsen_B1 = 120;
	$new_Color_Ellipsen_B2 = 255;
	$new_Color_TEllipsen_R1 = 120;
	$new_Color_TEllipsen_R2 = 255;
	$new_Color_TEllipsen_G1 = 120;
	$new_Color_TEllipsen_G2 = 255;
	$new_Color_TEllipsen_B1 = 120;
	$new_Color_TEllipsen_B2 = 255;
	$new_Color_Lines_R1 = 120;
	$new_Color_Lines_R2 = 255;
	$new_Color_Lines_G1 = 120;
	$new_Color_Lines_G2 = 255;
	$new_Color_Lines_B1 = 120;
	$new_Color_Lines_B2 = 255;
	$new_Color_Arcs_R1 = 120;
	$new_Color_Arcs_R2 = 255;
	$new_Color_Arcs_G1 = 120;
	$new_Color_Arcs_G2 = 255;
	$new_Color_Arcs_B1 = 120;
	$new_Color_Arcs_B2 = 255;
	$new_Color_BGText_R1 = 180;
	$new_Color_BGText_R2 = 220;
	$new_Color_BGText_G1 = 180;
	$new_Color_BGText_G2 = 220;
	$new_Color_BGText_B1 = 180;
	$new_Color_BGText_B2 = 220;
	$new_Color_Text_R1 = 0;
	$new_Color_Text_R2 = 100;
	$new_Color_Text_G1 = 0;
	$new_Color_Text_G2 = 100;
	$new_Color_Text_B1 = 0;
	$new_Color_Text_B2 = 255;
	$new_Color_SLines_R1 = 0;
	$new_Color_SLines_R2 = 50;
	$new_Color_SLines_G1 = 0;
	$new_Color_SLines_G2 = 50;
	$new_Color_SLines_B1 = 0;
	$new_Color_SLines_B2 = 50;
}

if ((isset($HTTP_POST_VARS['submit'])) || (isset($HTTP_POST_VARS['valuereset'])))
{
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

	$message = $lang['ABQ_Config2_updated'] . "<br /><br />" . sprintf($lang['ABQ_Click_return_config2'], "<a href=\"" . append_sid("abq_config2.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}

$sql = 'SELECT * 
	FROM ' . ANTI_BOT_QUEST_CONFIG_TABLE . '
	WHERE config_name LIKE \'Color_%\'';
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in abq_config2", "", __LINE__, __FILE__, $sql);
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

$template->set_filenames(array(
	'body' => 'admin/abq_config2_body.tpl')
);

$template->assign_vars(array(
	'U_CONFIG_ACTION' => append_sid("abq_config2.$phpEx"), 
	'L_SUBMIT' => $lang['Submit'], 
	'L_RESET' => $lang['Reset'], 
	'L_CONFIGURATION_TITLE' => $lang['ABQ_MOD'] . ' - ' . $lang['ABQ_ColorConf_Titel'], 
	'L_CONFIGURATION_EXPLAIN' => $lang['ABQ_ColorConf_Explain'], 
	'L_RGB_R' => $lang['ABQ_RGB_red'], 
	'L_RGB_G' => $lang['ABQ_RGB_green'], 
	'L_RGB_B' => $lang['ABQ_RGB_blue'], 
	'L_MAINCONFIG' => $lang['ABQ_Mainconfig'], 
	'L_BG' => $lang['ABQ_Color_BG'], 
	'L_TEXT' => $lang['ABQ_Color_Text'], 
	'L_TEXT_EXPLAIN' => $lang['ABQ_Color_Text_Explain'], 
	'L_TEXTF1' => $lang['ABQ_Color_F1'], 
	'L_TEXTF1_EXPLAIN' => sprintf($lang['ABQ_Color_F1_Explain'], sprintf($lang['ABQ_AFrageTyp08'], $lang['ABQ_Farbe1'])), 
	'L_TEXTF2' => $lang['ABQ_Color_F2'], 
	'L_TEXTF2_EXPLAIN' => sprintf($lang['ABQ_Color_F2_Explain'], sprintf($lang['ABQ_AFrageTyp08'], $lang['ABQ_Farbe1'])), 
	'S_BG_R1' => $new['Color_BG_R1'], 
	'S_BG_R2' => $new['Color_BG_R2'], 
	'S_BG_G1' => $new['Color_BG_G1'], 
	'S_BG_G2' => $new['Color_BG_G2'], 
	'S_BG_B1' => $new['Color_BG_B1'], 
	'S_BG_B2' => $new['Color_BG_B2'], 
	'S_TEXT_R1' => $new['Color_Text_R1'], 
	'S_TEXT_R2' => $new['Color_Text_R2'], 
	'S_TEXT_G1' => $new['Color_Text_G1'], 
	'S_TEXT_G2' => $new['Color_Text_G2'], 
	'S_TEXT_B1' => $new['Color_Text_B1'], 
	'S_TEXT_B2' => $new['Color_Text_B2'], 
	'S_F1_R' => $new['Color_F1_R'], 
	'S_F1_G' => $new['Color_F1_G'], 
	'S_F1_B' => $new['Color_F1_B'], 
	'S_F2_R' => $new['Color_F2_R'], 
	'S_F2_G' => $new['Color_F2_G'], 
	'S_F2_B' => $new['Color_F2_B'], 
	'L_EFFCONFIG' => $lang['ABQ_Effconfig'],
	'L_SLINES' => $lang['ABQ_Color_SLines'], 
	'L_BGTEXT' => $lang['ABQ_Color_BGText'], 
	'L_BGTEXT_EXPLAIN' => $lang['ABQ_Color_BGText_Explain'], 
	'L_GRID1' => $lang['ABQ_Color_Grid'] . ' 1', 
	'L_GRID2' => $lang['ABQ_Color_Grid'] . ' 2', 
	'L_GRID3' => $lang['ABQ_Color_Grid'] . ' 3', 
	'L_GRID4' => $lang['ABQ_Color_Grid'] . ' 4', 
	'L_GRIDF' => $lang['ABQ_Color_GridF'], 
	'L_ELLIPSEN' => $lang['ABQ_Color_Ellipsen'], 
	'L_TELLIPSEN' => $lang['ABQ_Color_TEllipsen'], 
	'L_ARCS' => $lang['ABQ_Color_Arcs'], 
	'L_LINES' => $lang['ABQ_Color_Lines'], 
	'S_SLINES_R1' => $new['Color_SLines_R1'], 
	'S_SLINES_R2' => $new['Color_SLines_R2'], 
	'S_SLINES_G1' => $new['Color_SLines_G1'], 
	'S_SLINES_G2' => $new['Color_SLines_G2'], 
	'S_SLINES_B1' => $new['Color_SLines_B1'], 
	'S_SLINES_B2' => $new['Color_SLines_B2'], 
	'S_BGTEXT_R1' => $new['Color_BGText_R1'], 
	'S_BGTEXT_R2' => $new['Color_BGText_R2'], 
	'S_BGTEXT_G1' => $new['Color_BGText_G1'], 
	'S_BGTEXT_G2' => $new['Color_BGText_G2'], 
	'S_BGTEXT_B1' => $new['Color_BGText_B1'], 
	'S_BGTEXT_B2' => $new['Color_BGText_B2'], 
	'S_GRID1_R1' => $new['Color_Grid1_R1'], 
	'S_GRID1_R2' => $new['Color_Grid1_R2'], 
	'S_GRID1_G1' => $new['Color_Grid1_G1'], 
	'S_GRID1_G2' => $new['Color_Grid1_G2'], 
	'S_GRID1_B1' => $new['Color_Grid1_B1'], 
	'S_GRID1_B2' => $new['Color_Grid1_B2'], 
	'S_GRID2_R1' => $new['Color_Grid2_R1'], 
	'S_GRID2_R2' => $new['Color_Grid2_R2'], 
	'S_GRID2_G1' => $new['Color_Grid2_G1'], 
	'S_GRID2_G2' => $new['Color_Grid2_G2'], 
	'S_GRID2_B1' => $new['Color_Grid2_B1'], 
	'S_GRID2_B2' => $new['Color_Grid2_B2'], 
	'S_GRID3_R1' => $new['Color_Grid3_R1'], 
	'S_GRID3_R2' => $new['Color_Grid3_R2'], 
	'S_GRID3_G1' => $new['Color_Grid3_G1'], 
	'S_GRID3_G2' => $new['Color_Grid3_G2'], 
	'S_GRID3_B1' => $new['Color_Grid3_B1'], 
	'S_GRID3_B2' => $new['Color_Grid3_B2'], 
	'S_GRID4_R1' => $new['Color_Grid4_R1'], 
	'S_GRID4_R2' => $new['Color_Grid4_R2'], 
	'S_GRID4_G1' => $new['Color_Grid4_G1'], 
	'S_GRID4_G2' => $new['Color_Grid4_G2'], 
	'S_GRID4_B1' => $new['Color_Grid4_B1'], 
	'S_GRID4_B2' => $new['Color_Grid4_B2'], 
	'S_GRIDF_R1' => $new['Color_GridF_R1'], 
	'S_GRIDF_R2' => $new['Color_GridF_R2'], 
	'S_GRIDF_G1' => $new['Color_GridF_G1'], 
	'S_GRIDF_G2' => $new['Color_GridF_G2'], 
	'S_GRIDF_B1' => $new['Color_GridF_B1'], 
	'S_GRIDF_B2' => $new['Color_GridF_B2'], 
	'S_ELLIPSEN_R1' => $new['Color_Ellipsen_R1'], 
	'S_ELLIPSEN_R2' => $new['Color_Ellipsen_R2'], 
	'S_ELLIPSEN_G1' => $new['Color_Ellipsen_G1'], 
	'S_ELLIPSEN_G2' => $new['Color_Ellipsen_G2'], 
	'S_ELLIPSEN_B1' => $new['Color_Ellipsen_B1'], 
	'S_ELLIPSEN_B2' => $new['Color_Ellipsen_B2'], 
	'S_TELLIPSEN_R1' => $new['Color_TEllipsen_R1'], 
	'S_TELLIPSEN_R2' => $new['Color_TEllipsen_R2'], 
	'S_TELLIPSEN_G1' => $new['Color_TEllipsen_G1'], 
	'S_TELLIPSEN_G2' => $new['Color_TEllipsen_G2'], 
	'S_TELLIPSEN_B1' => $new['Color_TEllipsen_B1'], 
	'S_TELLIPSEN_B2' => $new['Color_TEllipsen_B2'], 
	'S_ARCS_R1' => $new['Color_Arcs_R1'], 
	'S_ARCS_R2' => $new['Color_Arcs_R2'], 
	'S_ARCS_G1' => $new['Color_Arcs_G1'], 
	'S_ARCS_G2' => $new['Color_Arcs_G2'], 
	'S_ARCS_B1' => $new['Color_Arcs_B1'], 
	'S_ARCS_B2' => $new['Color_Arcs_B2'], 
	'S_LINES_R1' => $new['Color_Lines_R1'], 
	'S_LINES_R2' => $new['Color_Lines_R2'], 
	'S_LINES_G1' => $new['Color_Lines_G1'], 
	'S_LINES_G2' => $new['Color_Lines_G2'], 
	'S_LINES_B1' => $new['Color_Lines_B1'], 
	'S_LINES_B2' => $new['Color_Lines_B2'], 
	'L_VALUERESET' => $lang['ABQ_ValueReset'], 
	'L_VALUERESET_EXPLAIN' => $lang['ABQ_ValueReset_Explain'], 

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
	'U_ABQ_VERSION' => $lang['ABQ_Version'])
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);
?>