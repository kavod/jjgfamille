<?php
/***************************************************************************
 *                            function_selects.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: functions_selects.php,v 1.3.2.5 2005/05/06 20:50:11 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/
//
// Pick a birthday, any birthday
// Sélection de la date d'anniversaire
//
function birthday_select($default,$select_name="birth")
{
	global $lang;
	if ( !isset($default[0]) )
	{
		$default[0] = 0;
	}
	$day_select = '<select name="' . $select_name . '_day">';
	$selected = ($default[0] == 0) ? ' selected="selected"' : '';
	$day_select .= '<option value="0"' . $selected . '>--</option>';
	for ($i=1;$i<32;$i++)
	{
		$selected = ($i == $default[0]) ? ' selected="selected"' : '';
		$day_select .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
	}
	$day_select .= '</select>';
	
	$months = array(
			'--',
			$lang['datetime']['Jan'],
			$lang['datetime']['Feb'],
			$lang['datetime']['Mar'],
			$lang['datetime']['Apr'],
			$lang['datetime']['May'],
			$lang['datetime']['Jun'],
			$lang['datetime']['Jul'],
			$lang['datetime']['Aug'],
			$lang['datetime']['Sep'],
			$lang['datetime']['Oct'],
			$lang['datetime']['Nov'],
			$lang['datetime']['Dec']);
	if ( !isset($default[1]) )
	{
		$default[1] = 0;
	}
	$month_select = '<select name="' . $select_name . '_month">';
	for ($i=0;$i<13;$i++)
	{
		$selected = ($i == $default[1]) ? ' selected="selected"' : '';
		$month_select .= '<option value="' . $i . '"' . $selected . '>' . $months[$i] . '</option>';
	}
	$month_select .= '</select>';
	
	if ( !isset($default[2]) )
	{
		$default[2] = 1000;
	}
	$year_select = '<select name="' . $select_name . '_year">';
	$selected = ($default[2] == 1000) ? ' selected="selected"' : '';
	$year_select .= '<option value="1000"' . $selected . '>--</option>';
	for ($i=1900;$i<date('Y');$i++)
	{
		$selected = ($i == $default[2]) ? ' SELECTED' : '';
		$year_select .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
	}
	$year_select .= '</select>';
	return $day_select . "\n" . $month_select . "\n" . $year_select;
}

//
// Pick a language, any language ...
//
function language_select($default, $select_name = "language", $dirname="language")
{
	global $phpEx, $phpbb_root_path;

	$dir = opendir($phpbb_root_path . $dirname);

	$lang = array();
	while ( $file = readdir($dir) )
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@phpbb_realpath($phpbb_root_path . $dirname . '/' . $file)) && !is_link(@phpbb_realpath($phpbb_root_path . $dirname . '/' . $file)))
		{
			$filename = trim(str_replace("lang_", "", $file));
			$displayname = preg_replace("/^(.*?)_(.*)$/", "\\1 [ \\2 ]", $filename);
			$displayname = preg_replace("/\[(.*?)_(.*)\]/", "[ \\1 - \\2 ]", $displayname);
			$lang[$displayname] = $filename;
		}
	}

	closedir($dir);

	@asort($lang);
	@reset($lang);

	$lang_select = '<select name="' . $select_name . '">';
	while ( list($displayname, $filename) = @each($lang) )
	{
		$selected = ( strtolower($default) == strtolower($filename) ) ? ' selected="selected"' : '';
		$lang_select .= '<option value="' . $filename . '"' . $selected . '>' . ucwords($displayname) . '</option>';
	}
	$lang_select .= '</select>';

	return $lang_select;
}

//
// Pick a template/theme combo, 
//
function style_select($default_style, $select_name = "style", $dirname = "templates")
{
	global $db;

	$sql = "SELECT themes_id, style_name
		FROM " . THEMES_TABLE . "
		ORDER BY template_name, themes_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
	}

	$style_select = '<select name="' . $select_name . '">';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row['themes_id'] == $default_style ) ? ' selected="selected"' : '';

		$style_select .= '<option value="' . $row['themes_id'] . '"' . $selected . '>' . $row['style_name'] . '</option>';
	}
	$style_select .= "</select>";

	return $style_select;
}

//
// Pick a timezone
//
function tz_select($default, $select_name = 'timezone')
{
	global $sys_timezone, $lang;

	if ( !isset($default) )
	{
		$default == $sys_timezone;
	}
	$tz_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['tz']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$tz_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$tz_select .= '</select>';

	return $tz_select;
}

?>