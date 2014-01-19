<?php
/***************************************************************************
 *                          abq_indi_images.php
 *                          -------------------
 *   Version              : Version 2.0.0 - 26.11.2006
 *   copyright            : (C) 2005-2006 M.W.
 *   URL                  : http://phpbb.mwegner.de/
 *
 ***************************************************************************/

define('IN_PHPBB', true);

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
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

include($phpbb_root_path . 'includes/functions_abq.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_abq_admin.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_abq.' . $phpEx);

$IndImagesList = array();
$IndImagesListAnzahl = 0;
if ($IndImageVerzeichnis = @opendir($phpbb_root_path . 'images/abq_mod/'))
{
	while (true == ($Dateien = @readdir($IndImageVerzeichnis)))
	{
		if (!@is_dir(@phpbb_realpath($phpbb_root_path . 'images/abq_mod/' . $Dateien)))
		{
			unset($IMGDateiendung);
			$IMGDateiendung = strtolower(preg_replace('/.*(\.[a-z]{3,4})$/i','\1',$Dateien));
			if (($IMGDateiendung == '.gif') || ($IMGDateiendung == '.jpg') || ($IMGDateiendung == '.jpeg') || ($IMGDateiendung == '.png'))
			{
				$IndImagesList[] = $Dateien;
			}
		}
	}
	closedir($IndImageVerzeichnis);
	sort($IndImagesList);
	$IndImagesListAnzahl = count($IndImagesList);
}

$MaxImageFileSize = 51200;

if (!isset($HTTP_POST_VARS['mode']))
{
	if (!isset($HTTP_GET_VARS['mode']))
	{
		$template->set_filenames(array(
			'body' => 'admin/abq_indi_images_body.tpl')
		);

		$template->assign_vars(array(
			'L_ABQ_TITLE' => $lang['ABQ_MOD'] . ' - ' . $lang['ABQ_IImageAdmin_Title'], 
			'L_ABQ_EXPLAIN' => $lang['ABQ_IImageAdmin_Explain'], 
			'L_ABQ_IMAGE' => $lang['ABQ_Image'], 
			'L_UPLOAD_NEW_IMAGE' => $lang['ABQ_Upload_New_Image'], 
			'L_ACTION' => $lang['Action'], 
			'L_SHOWIMAGE' => $lang['ABQ_ShowImage'], 
			'L_DELETE' => $lang['Delete'], 

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
			'L_ABQ_VERSION' => $lang['ABQ_Version'], 
			'U_ABQ_ACTION' => append_sid('abq_indi_images.'.$phpEx))
		);

		if ($IndImagesListAnzahl > 0)
		{
			unset($i);
			for ($i=0; $i<$IndImagesListAnzahl; $i++)
			{
				$template->assign_block_vars('schriften', array(
					'COLOR' => ($i % 2) ? 'row1' : 'row2', 
					'BILD' => $IndImagesList[$i], 
					'U_SHOWIMAGE_ACTION' => $phpbb_root_path . 'images/abq_mod/' . $IndImagesList[$i], 
					'U_DELETE_ACTION' => append_sid('abq_indi_images.'.$phpEx.'?mode=delete&amp;id='.($i+1))
					)
				);
			}
		}
		else
		{
			$template->assign_block_vars('switch_no_images', array()); 
			$template->assign_vars(array(
				'L_ABQ_NO_IIMAGES' => $lang['ABQ_No_IIMages'])
			);
		}

		$template->pparse('body');

		include('./page_footer_admin.'.$phpEx);
	}
	elseif ($HTTP_GET_VARS['mode'] == 'delete')
	{
		$bild_id = intval($HTTP_GET_VARS['id']);

		$template->set_filenames(array(
			'body' => 'admin/abq_indi_images_delete_body.tpl')
		);

		$abqrow = array();
		$sql = 'SELECT id 
			FROM ' . ANTI_BOT_QUEST_TABLE . ' 
			WHERE anti_bot_img = \'' . $IndImagesList[($bild_id - 1)] . '\'';
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query anti-bot-question information', '', __LINE__, __FILE__, $sql);
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$abqrow[] = $row;
		}
		$abq_count = count($abqrow);

		$template->assign_vars(array(
			'L_ABQ_TITLE' => $lang['ABQ_MOD'] . ' - ' . $lang['ABQ_IImageAdmin_Delete'], 
			'L_ABQ_EXPLAIN' => sprintf($lang['ABQ_IImageAdmin_Delete_Explain'], $lang['ABQ_IImageAdmin_Delete_Explain2']), 
			'L_ABQ_EXPLAIN2' => $lang['ABQ_IImageAdmin_Delete_Explain2'], 
			'L_ABQ_IMAGE' => $lang['ABQ_Image'], 
			'L_ACTION' => $lang['Action'], 
			'L_DELETE' => $lang['Delete'], 
			'S_BILDTID' =>  $bild_id, 

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

		if (($bild_id < 1) || ($bild_id > $IndImagesListAnzahl))
		{
			$template->assign_block_vars('switch_unknown_image', array()); 
			$template->assign_vars(array(
				'L_ABQ_UNKNOWN_IMAGE' => $lang['ABQ_unknown_image'])
			);
		}
		elseif ($abq_count > 0)
		{
			$template->assign_block_vars('switch_dont_delete_image', array()); 
			$template->assign_vars(array(
				'L_ABQ_IMAGE_IN_USE' => $lang['ABQ_iimage_in_use'],
				'BILD' => $IndImagesList[($bild_id - 1)])
			);
		}
		else
		{
			$template->assign_block_vars('switch_delete', array()); 
			$template->assign_vars(array(
				'U_DELETE_ACTION' => append_sid('abq_indi_images.'.$phpEx),
				'BILD' => $IndImagesList[($bild_id - 1)])
			);
		}

		$template->pparse('body');

		include('./page_footer_admin.'.$phpEx);
	}
}
elseif ($HTTP_POST_VARS['mode'] == 'delete')
{
	$bild_id = intval($HTTP_POST_VARS['id']);
	$bild_name = preg_replace('/[^a-zA-Z0-9_-]/', '', $HTTP_POST_VARS['name']);
	if (($bild_name != $HTTP_POST_VARS['name']) || ($IndImagesList[($bild_id - 1)] != $bild_name))
	{
		$bild_name == '';
	}

	if (($bild_id < 1) || ($bild_id > $IndImagesListAnzahl) || ($bild_name == ''))
	{
		$message = $lang['ABQ_unknown_image'] . '<br /><br />' . sprintf($lang['ABQ_Click_return_IImages'], '<a href="' . append_sid('abq_indi_images.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx.'?pane=right') . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}

	$abqrow = array();
	$sql = 'SELECT id 
		FROM ' . ANTI_BOT_QUEST_TABLE . ' 
		WHERE anti_bot_img = \'' . $IndImagesList[($bild_id - 1)] . '\'';
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query anti-bot-question information', '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$abqrow[] = $row;
	}
	$abq_count = count($abqrow);

	if ($abq_count > 0)
	{
		$message = $lang['ABQ_iimage_in_use'];
		message_die(GENERAL_MESSAGE, $message);
	}

	if (@file_exists(@phpbb_realpath($phpbb_root_path . 'images/abq_mod/' . $IndImagesList[($bild_id - 1)])))
	{
		if (@unlink($phpbb_root_path . 'images/abq_mod/' . $IndImagesList[($bild_id - 1)]))
		{
			$message = $lang['ABQ_delete_Image_ok'] . '<br /><br />' . sprintf($lang['ABQ_Click_return_IImages'], '<a href="' . append_sid('abq_indi_images.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx.'?pane=right') . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$message = $lang['ABQ_delete_Image_false'];
			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else
	{
		$message = $lang['ABQ_unknown_image'];
		message_die(GENERAL_MESSAGE, $message);
	}
}
elseif ($HTTP_POST_VARS['mode'] == 'new')
{
	$template->set_filenames(array(
		'body' => 'admin/abq_indi_images_upload_body.tpl')
	);

	$template->assign_vars(array(
		'L_ABQ_TITLE' => $lang['ABQ_MOD'] . ' - ' . $lang['ABQ_IImageAdmin_Upload'], 
		'L_ABQ_EXPLAIN' => sprintf($lang['ABQ_IImageAdmin_Upload_Explain'], round($MaxImageFileSize / 1024)) . $lang['ABQ_IImageAdmin_Upload_ImageFile_Explain'], 
		'L_ABQ_IMAGE' => $lang['ABQ_Font'], 
		'L_IMAGELOCATION' => $lang['ABQ_File'], 
		'L_UPLOAD_IMAGE_FILE' => $lang['ABQ_IImageAdmin_Upload_ImageFile'], 
		'L_UPLOAD_IMAGE_FILE_EXPLAIN' => $lang['ABQ_IImageAdmin_Upload_ImageFile_Explain'], 
		'S_IMAGE_SIZE' => $MaxImageFileSize, 
		'L_UPLOAD' => $lang['ABQ_Upload_New_Image'], 
		'U_UPLOAD_ACTION' => append_sid('abq_indi_images.'.$phpEx),

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
}
elseif ($HTTP_POST_VARS['mode'] == 'upload')
{
	include($phpbb_root_path . 'includes/functions_abq_upload.'.$phpEx);

	$ImageFile_TmpName = ($HTTP_POST_FILES['imagefile']['tmp_name'] != 'none') ? $HTTP_POST_FILES['imagefile']['tmp_name'] : '';
	$ImageFile_Name = (!empty($HTTP_POST_FILES['imagefile']['name']) ) ? $HTTP_POST_FILES['imagefile']['name'] : '';
	$ImageFile_Size = (!empty($HTTP_POST_FILES['imagefile']['size']) ) ? (($HTTP_POST_FILES['imagefile']['size'] > $MaxImageFileSize) ? 0 : $HTTP_POST_FILES['imagefile']['size']) : 0;
	$ImageFile_Filetype = (!empty($HTTP_POST_FILES['imagefile']['type']) ) ? $HTTP_POST_FILES['imagefile']['type'] : '';

	if ((!empty($ImageFile_TmpName)) && (!empty($ImageFile_Size)) && (!empty($ImageFile_Name)))
	{
		if (!preg_match('/^[a-z0-9_-]+\.[a-z]{3,4}$/i', $ImageFile_Name))
		{
			$ImageFile_Name = preg_replace('#^.*/([a-z0-9_-]+\.[a-z]{3,4})$#i', '\1', $ImageFile_Name);
		}
		if (!preg_match('/^[a-z0-9_-]+\.[a-z]{3,4}$/i', $ImageFile_Name))
		{
			$message = $lang['ABQ_upload_File_Error'] . '<br /><br />' . $lang['ABQ_upload_wrong_Filename'];
			message_die(GENERAL_MESSAGE, $message);
		}
		$ImageFile_Name = strtolower($ImageFile_Name);
		abq_upload('IFImage', $ImageFile_TmpName, $ImageFile_Name, $ImageFile_Size, $ImageFile_Filetype);
	}
	elseif (!empty($ImageFile_Name))
	{
		$message = $lang['ABQ_upload_File_Error'] . '<br /><br />' . sprintf($lang['ABQ_upload_Image_FileSize'], round($MaxImageFileSize / 1024));
		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{
		$message = $lang['ABQ_upload_File_Error'] . '<br /><br />' . $lang['ABQ_upload_no_File'];
		message_die(GENERAL_MESSAGE, $message);
	}
}
?>