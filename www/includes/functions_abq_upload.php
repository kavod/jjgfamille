<?php
/***************************************************************************
 *                          functions_abq_upload.php
 *                          ------------------------
 *   Version              : Version 2.0.1 - 09.12.2006
 *   copyright            : (C) 2005-2006 M.W.
 *   URL                  : http://phpbb.mwegner.de/
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

function abq_upload($UF_Modus, $UF_TmpName, $UF_Name, $UF_Size, $UF_Filetype)
{
	global $lang, $phpbb_root_path, $phpEx;

	$UploadOK = 0;
	$UploadFolder = '';

	$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';

	if (!preg_match('/^[a-z0-9_-]+\.[a-z]{3,4}$/i', $UF_Name))
	{}
	elseif (($UF_Modus == 'Font') && (file_exists(@phpbb_realpath($UF_TmpName))) && (preg_match('/\.(ttf)$/i', $UF_Name)))
	{
		if ($UF_Filetype == 'application/octet-stream')
		{
			$UploadOK = 1;
		}
	}
	elseif (($UF_Modus == 'IFImage') && (file_exists(@phpbb_realpath($UF_TmpName))) && (preg_match('/\.(jpg|jpeg|gif|png)$/i', $UF_Name)))
	{
		$DateiEndung = '';
		preg_match('#image\/[x\-]*([a-z]+)#', $UF_Filetype, $UF_Filetype);
		$UF_Filetype = $UF_Filetype[1];
		if (($UF_Filetype == 'jpeg') || ($UF_Filetype == 'pjpeg') || ($UF_Filetype == 'jpg'))
		{
			$DateiEndung = '.jpg';
		}
		elseif ($UF_Filetype == 'gif')
		{
			$DateiEndung = '.gif';
		}
		elseif ($UF_Filetype == 'png')
		{
			$DateiEndung = '.png';
		}
		if ($DateiEndung == '')
		{
			$message = $lang['ABQ_upload_File_Error'] . '<br /><br />' . $lang['ABQ_upload_Image_WrongTyp'];
			message_die(GENERAL_MESSAGE, $message);
		}

		// Prüfung, ob getimagesize() auf dem Server existiert
		if (function_exists(getimagesize))
		{
			$UploadImageInfo =  @getimagesize($UF_TmpName);
			if ((isset($UploadImageInfo)) && (is_array($UploadImageInfo)) && (count($UploadImageInfo) > 2))
			{
				list($BildBreite, $BildHoehe, $BildTyp) = $UploadImageInfo;

				if ($BildTyp == 1)
				{
					if ($DateiEndung != '.gif')
					{
						message_die(GENERAL_ERROR, 'Unable to upload file', '', __LINE__, __FILE__);
					}
				}
				elseif (($BildTyp == 2) || ($BildTyp == 9) || ($BildTyp == 10) || ($BildTyp == 11) || ($BildTyp == 12))
				{
					if (($DateiEndung != '.jpg') && ($DateiEndung != '.jpeg'))
					{
						message_die(GENERAL_ERROR, 'Unable to upload file', '', __LINE__, __FILE__);
					}
				}
				elseif ($BildTyp == 3)
				{
					if ($DateiEndung != '.png')
					{
						message_die(GENERAL_ERROR, 'Unable to upload file', '', __LINE__, __FILE__);
					}
				}
				else
				{
					message_die(GENERAL_ERROR, 'Unable to upload file', '', __LINE__, __FILE__);
				}
				$UploadOK = 1;
			}
			else
			{
				$UploadOK = 1;
			}
		}
		else
		{
			$UploadOK = 1;
		}
	}

	if (!$UploadOK)
	{
		$message = $lang['ABQ_upload_File_Error'] . '<br /><br />' . $lang['ABQ_upload_File_WrongTyp'];
		message_die(GENERAL_MESSAGE, $message);
	}

	if (@$ini_val('open_basedir') != '')
	{
		if (@phpversion() < '4.0.3')
		{
			message_die(GENERAL_ERROR, 'open_basedir is set and your PHP version does not allow move_uploaded_file', '', __LINE__, __FILE__);
		}
		$move_file = 'move_uploaded_file';
	}
	else
	{
		$move_file = 'copy';
	}

	if (!is_uploaded_file($UF_TmpName))
	{
		message_die(GENERAL_ERROR, 'Unable to upload file', '', __LINE__, __FILE__);
	}

	if ($UF_Modus == 'Font')
	{
		$UploadFolder = 'abq_mod/fonts/';
	}
	elseif ($UF_Modus == 'IFImage')
	{
		$UploadFolder = 'images/abq_mod/';
	}

	if (file_exists(@phpbb_realpath($phpbb_root_path.$UploadFolder.$UF_Name)))
	{
		$message = $lang['ABQ_upload_File_Error'] . '<br /><br />' . $lang['ABQ_upload_File_exists'];
		message_die(GENERAL_MESSAGE, $message);
	}

	if (@$move_file($UF_TmpName, $phpbb_root_path . $UploadFolder . '/' . $UF_Name))
	{
	}
	else
	{
		$message = $lang['ABQ_upload_File_Error'] . '<br /><br />' . sprintf($lang['ABQ_upload_can_not_create_File'], $UploadFolder);
		message_die(GENERAL_MESSAGE, $message);
	}

	@chmod($phpbb_root_path . $UploadFolder . $UF_Name, 0777);

	$message = $lang['ABQ_upload_File_OK'] . '<br /><br />';
	if ($UF_Modus == 'Font')
	{
		$message .= sprintf($lang['ABQ_Click_return_Fonts'], '<a href="' . append_sid($phpbb_root_path.'admin/abq_fonts.'.$phpEx) . '">', '</a>');
	}
	elseif ($UF_Modus == 'IFImage')
	{
		$message .= sprintf($lang['ABQ_Click_return_IImages'], '<a href="' . append_sid($phpbb_root_path.'admin/abq_indi_images.'.$phpEx) . '">', '</a>');
	}
	$message .= '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid($phpbb_root_path.'admin/index.'.$phpEx.'?pane=right') . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}
?>