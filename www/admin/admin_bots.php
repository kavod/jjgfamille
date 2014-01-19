<?php

/***************************************************************************
 *                              admin_bots.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *	 for gendo bot mod by easythomas
 *
 *
 ***************************************************************************/


define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Admin_bots']['Manage_bots'] = "$file";
	return;
}

//
// Check if the user has cancled a confirmation message.
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'forum/extension.inc');

require('./pagestart.' . $phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else 
{
	$mode = "";
}

switch( $mode )
{
	case 'delete':

		$bot_id = $HTTP_GET_VARS['bot_id'];
		
		$file = $phpbb_root_path . 'includes/bots.' . $phpEx;

		@include($file);

		unset ($bots[$bot_id]);

		@CHMOD($file, 0666);
		@unlink($file);
		$f = @fopen ($file, 'w');
		$text  = "<?php\n";
		@fputs( $f, $text );

		if (isset($bots))
		{
			while (list($id, $value) = each ($bots))
			{
				$texte = "// Bot : ".$value['name']."\n";
				@fputs( $f, $texte );
				$text = "$" . "bots['$id']['name'] = '".$value['name']."';\n";
				@fputs( $f, $text );
				
				for ( $i = 0; $i < count($value['ips']); $i++ )
				{
					$text = "$" . "bots['$id']['ips'][] = '".$value['ips'][$i]."';\n";
					@fputs( $f, $text );
				}
			}
		}

		$text = "?>";
		@fputs( $f, $text );
		@fclose( $f );		
		
		$message = $lang['Delete_bot_done'] . "<br /><br />" . sprintf($lang['Click_return_bots'], "<a href=\"" . append_sid("admin_bots.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);


		break;

	case 'update':

		$new = $HTTP_POST_VARS['new'];
		$bot_id = md5 (uniqid (rand()));
		$bot_id_anc = htmlspecialchars($HTTP_POST_VARS['bot_id_ancien']);
		$bot_ips = htmlspecialchars($HTTP_POST_VARS['bot_ips']);
		$bot_name = htmlspecialchars($HTTP_POST_VARS['bot_name']);		
		$file = $phpbb_root_path . 'includes/bots.' . $phpEx;

		// pas de nom spécifié
		if(empty($bot_name)) 
		{
			$message = "<b>" . $lang['No_bot_name_error'] . "</b><br /><br />" . sprintf($lang['Click_return_bots'], "<a href=\"" . append_sid("admin_bots.$phpEx") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
		// pas d'ips spécifiées
		if(empty($bot_ips)) 
		{
			$message = "<b>" . $lang['No_bot_ip_error'] . "</b><br /><br />" . sprintf($lang['Click_return_bots'], "<a href=\"" . append_sid("admin_bots.$phpEx") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}

		$bot_ips_verif = explode(",", $bot_ips);

		while (list($id, $ip_value) = each ($bot_ips_verif))
		{
			if(!ereg("^(((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]{1}[0-9]|[1-9]).){1}((25[0-5]|2[0-4][0-9]|[1]{1}[0-9]{2}|[1-9]{1}[0-9]|[0-9]).){2}(((25[0-5]|2[0-4][0-9]|[1]{1}[0-9]{2}|[1-9]{1}[0-9]|[0-9]){1})|(#)))$", trim($ip_value))) 
			{
				$message = $ip_value . "<br /><b>" . $lang['Incorect_ot_ip_error'] . "</b><br /><br />" . sprintf($lang['Click_return_bots'], "<a href=\"" . append_sid("admin_bots.$phpEx") . "\">", "</a>");
				message_die(GENERAL_MESSAGE, $message);
			}
		}

		@include($file);
		 
		if (isset($bots))
		{
			while (list($id, $value) = each ($bots))
			{
				if ( $id == $bot_id_anc && !$new )
				{
					$bots_temp[$bot_id]['name'] = $bot_name;
					$bots_temp[$bot_id]['ips'] = explode(",", $bot_ips);
				}
				else
				{
					$bots_temp[$id]['name'] = $value['name'];
					$bots_temp[$id]['ips'] = $value['ips'];
				}
			}
		}
		if ( $new )
		{
			$bots_temp[$bot_id]['name'] = $bot_name;
			$bots_temp[$bot_id]['ips'] = explode(",", $bot_ips);
		}

		@CHMOD($file, 0666);
		@unlink($file);
		$f = @fopen ($file, 'w');
		$text  = "<?php\n";
		@fputs( $f, $text );
		if (isset($bots_temp))
		{
			while (list($id, $value) = each ($bots_temp))
			{
				$texte = "// Bot : ".$value['name']."\n";
				@fputs( $f, $texte );
				$text = "$" . "bots['$id']['name'] = '".$value['name']."';\n";
				@fputs( $f, $text );
				
				for ( $i = 0; $i < count($value['ips']); $i++ )
				{
					$text = "$" . "bots['$id']['ips'][] = '".trim($value['ips'][$i])."';\n";
					@fputs( $f, $text );
				}
			}
		}
		$text = "?>";

		@fputs( $f, $text );
		@fclose( $f );	
		
		$message = $lang['MAJ_bots_done'] . "<br /><br />" . sprintf($lang['Click_return_bots'], "<a href=\"" . append_sid("admin_bots.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);


		break;

	case 'edit':
		
		if (isset($HTTP_GET_VARS['bot_id']))
		{
			$bot_id = $HTTP_GET_VARS['bot_id'];
		}
		elseif (isset($HTTP_POST_VARS['bot_id']))
		{
			$bot_id = $HTTP_POST_VARS['bot_id'];
		}

		$file = $phpbb_root_path . 'includes/bots.' . $phpEx;

		if (file_exists($file))
		{
			@include($file);
		}

		$template->set_filenames(array(
			"body" => "admin/bots_edit_add.tpl")
		);

		$s_hidden_fields = '<input type="hidden" name="mode" value="update" />';


	
		if ( $bot_id == "new" )
		{
			$s_hidden_fields .= '<input type="hidden" name="new" value="1" />';
		}
		else
		{		
			$s_hidden_fields .= '<input type="hidden" name="bot_id_ancien" value='.$bot_id.' />';
			$s_hidden_fields .= '<input type="hidden" name="new" value="0" />';
		}

		$template->assign_vars(array(
			"L_BOTS_TITLE" => $lang['Bots_admin'],
			"L_BOTS_TEXT" => $lang['Bots_explain'],
			"L_BOT_NAME" => $lang['Bots_name'],
			"L_BOT_ID" => $lang['Bots_id'],
			"L_BOT_NAME" => $lang['Bots_name'],
			"L_BOT_IP" => $lang['Bots_ip'],
			"L_BOT_IP_EXPLAIN" => $lang['Bots_ip_explain'],
			"L_SUBMIT" => $lang['Submit'],
			"S_BOTS_ACTION" => append_sid("admin_bots.$phpEx"),
			"S_HIDDEN_FIELDS" => $s_hidden_fields)
		);

		if (isset($bots) && $bot_id != "new" )
		{
			while (list($id, $value) = each ($bots))
			{
				if ( $id == $bot_id && $bot_id != "new" )
				{
					for ($i = 0; $i < count($value['ips']); $i++)	
					{
						if (!isset($ips))
						{
							$ips = $value['ips'][$i];
						}
						else
						{
							$ips .= ', '.$value['ips'][$i];
						}
					}
					
					$template->assign_vars(array(
						"BOT_IP" => $ips,
						"NAME" => $value['name'],
						"BOT_NAME" => $value['name'])
					);
				}

			}
		}
		elseif ( $bot_id == "new" )
		{
			$template->assign_vars(array(
				"NAME" => $lang['New_bot'])
			);
		}
		$template->pparse("body");	

		break;

	default:
		
		$file = $phpbb_root_path . 'includes/bots.' . $phpEx;

		if (file_exists($file))
		{
			@include($file);
		}

		$template->set_filenames(array(
			"body" => "admin/bots_list.tpl")
		);

		$s_hidden_fields = '<input type="hidden" name="mode" value="edit" />';
		
		$template->assign_vars(array(
			"L_BOTS_TITLE" => $lang['Bots_admin'],
			"L_BOTS_TEXT" => $lang['Bots_explain'],
			"L_BOTS" => $lang['Bots'],
			"L_DELETE" => $lang['Delete'],
			"L_ADD_NEW_BOT" => $lang['Add_new_bot'],
			"S_BOTS_ACTION" => append_sid("admin_bots.$phpEx?mode=edit&amp;bot_id=new"),
			"L_EDIT" => $lang['Edit'])
		);

		$i = 0;	
		if (isset($bots))
		{
			while (list($id, $value) = each ($bots))
			{
				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$template->assign_block_vars("bots", array(
					"ROW_CLASS" => $row_class,
					"ROW_COLOR" => $row_color,
					"BOT_NAME" => $value['name'],
					"U_BOT_DELETE" => append_sid("admin_bots.$phpEx?mode=delete&amp;bot_id=" . $id),
					"U_BOT_EDIT" => append_sid("admin_bots.$phpEx?mode=edit&amp;bot_id=" . $id))
				);

				$i++;
			}
		}
		
		$template->pparse("body");	
		break;
}



	include('./page_footer_admin.'.$phpEx);


?>