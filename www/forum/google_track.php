<?php
/***************************************************************************
 *                              admin_google_track.php
 *                            -------------------
 *   begin                : mardi 01 avril 2003
 *   copyright            : (C)Mojy - Mojytech
 *   email                : webmaster@mypsychedelicsite.com
 *
 *	 script original      : Editeur javascript 
 *
 ***************************************************************************/
 
 /***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// Récupérer les infos et les écrire
$tmp_list = explode(".", $_SERVER['REMOTE_ADDR']);
if (($tmp_list[0] == "66" && $tmp_list[1] == "249") || ($tmp_list[0] == "216" && $tmp_list[1] == "239" && $tmp_list[2] == "46"))
{
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '" . ($google_visit_counter + 1) . "'
			WHERE config_name = 'google_visit_counter'";
	if( !($result = $db->sql_query($sql)) )
	{
		logger('Could not update google counter information');
		//message_die(GENERAL_ERROR, 'Could not update google counter information', '', __LINE__, __FILE__, $sql);
	}

	$google_visit_counter++;
	
	$url_google = $_SERVER["SCRIPT_NAME"];
	if ($_SERVER["QUERY_STRING"] != "")
		$url_google .= "?".$_SERVER["QUERY_STRING"];
		
	$f = fopen($phpbb_root_path . "forum/google_track.txt","a");
	fputs($f, "[ ".date("j-m-Y H:i")." | " . $_SERVER['REMOTE_ADDR'] . " ] : [ http://".$_SERVER['HTTP_HOST']."$url_google ]\r\n");
	fclose($f);
}
?>
