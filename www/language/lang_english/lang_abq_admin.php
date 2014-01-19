<?php
/***************************************************************************
 *                          lang_abq_admin.php [english]
 *                          ----------------------------
 *   Version              : Version 2.0.1 - 09.12.2006
 *   copyright            : (C) 2005-2006 M.W.
 *   URL                  : http://phpbb.mwegner.de/
 *
 ***************************************************************************/

// redirect pages
$lang['ABQ_Config_updated'] = 'Anti Bot Question MOD configuration changed';
$lang['ABQ_Config2_updated'] = 'Anti Bot Question MOD color-configuration changed';
$lang['ABQ_Click_return_config'] = 'Click %sHere%s to return to Anti Bot Question Mod Configuration';
$lang['ABQ_Click_return_config2'] = 'Click %sHere%s to return to Anti Bot Question Mod Color-Configuration';
$lang['ABQ_New_Question_created'] = 'The new Individual Question was successfully created';
$lang['ABQ_Question_updated'] = 'The Individual Question was successfully updated';
$lang['ABQ_Question_deleted'] = 'The Individual Question was successfully deleted';
$lang['ABQ_Click_return_ABQ'] = 'Click %sHere%s to return to Individual Question Administration of the Anti Bot Question Mod';
$lang['ABQ_Click_return_Fonts'] = 'Click %sHere%s to return to font administration of the Anti Bot Question Mod';
$lang['ABQ_Click_return_IImages'] = 'Click %sHere%s to return to Individual Question Image Administration of the Anti Bot Question Mod';
$lang['ABQ_delete_Font_ok'] = 'The font was successfully deleted';
$lang['ABQ_upload_File_OK'] = 'The file was successfully uploaded.';
$lang['ABQ_delete_Image_ok'] = 'The image file was successfully deleted.';

// not only for redirect pages
$lang['ABQ_unknown_font'] = 'The font you are looking for was not found.';
$lang['ABQ_dont_delete_font'] = 'Do not delete the font "do-not-delete".<br />The MOD requires this font in order to work correctly.';
$lang['ABQ_unknown_image'] = 'The image file you are looking for was not found.';
$lang['ABQ_iimage_in_use'] = 'You cannot delete this image file because it is in use in at least one Individual Question.';

// general
$lang['ABQ_Version'] = '2.0.1';
$lang['ABQ_Wiki_GD'] = 'http://en.wikipedia.org/wiki/GD_Graphics_Library';
$lang['ABQ_Wiki_FT'] = 'http://en.wikipedia.org/wiki/FreeType';
$lang['ABQ_installiert'] = 'installed';
$lang['ABQ_nicht_installiert'] = 'not installed';
$lang['ABQ_Rand'] = 'randomly selected';
$lang['ABQ_Beispiel'] = 'example';
$lang['ABQ_JPG'] = 'JPG';
$lang['ABQ_PNG'] = 'PNG';
$lang['ABQ_ReadOnly1_Explain'] = 'This options requires the <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">GD Graphics Library</a>. Because this Library is not installed on your server, this option has no function on your board.';
$lang['ABQ_ReadOnly2_Explain'] = 'This options requires the <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">FreeType Library</a>. Because this Library is not installed on your server, this option has no function on your board.';
$lang['ABQ_Allgemeines'] = 'General Configuration';
$lang['ABQ_QuestAuto'] = 'Automatic Questions';
$lang['ABQ_QuestIndi'] = 'Individual Questions';
$lang['ABQ_File'] = 'file';
$lang['ABQ_Image'] = 'image';

// ACP Menu
$lang['ABQ_Admin_Index'] = 'Admin-Index';
$lang['ABQ_Admin_Index_Explain'] = 'The Anti Bot Question MOD adds a question to the registration and/or guest post forms to prevent bots from spamming the board. This question must be answered correctly to complete the registration or post successfully. If you use this MOD, you can disable the standard-captcha.<br /><br />This MOD is compatible with the <a href="http://www.phpbbhacks.com/download/235" title="Select Default Language MOD 1.3.4" target="_blank">Select Default Language MOD 1.3.4</a>. If you use the Select Default Language MOD, special changes of the code are not necessary.<br />If you use one of the following MODs, you need an Add-On or it is recommended to install an Add-On:<br />
&#8226; <a href="http://www.phpbbhacks.com/download/586" title="Advanced Quick Reply MOD 1.1.1" target="_blank">Advanced Quick Reply MOD 1.1.1</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/3096" title="Easy Contact Form MOD 1.1.0" target="_blank">Easy Contact Form MOD 1.1.0</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/522" title="Quick Reply MOD 1.0.5" target="_blank">Quick Reply MOD 1.0.5</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/540" title="Quick Reply MOD with Quote 1.1.3" target="_blank">Quick Reply MOD with Quote 1.1.3</a><br />
&#8226; <a href="http://www.phpbbhacks.com/download/4733" title="Quick Reply MOD with Quote and BBCode 1.1.3" target="_blank">Quick Reply MOD with Quote and BBCode 1.1.3</a><br />
&#8226; every other Quick Reply MOD (no further special Add-Ons available)<br />
You can download the Add-Ons <a href="http://phpbb.mwegner.de/" title="Anti Bot Question MOD Add-Ons" target="_blank">here</a>.';
$lang['ABQ_AdminI_Config'] = 'configuration';
$lang['ABQ_AdminI_AutoFragen'] = '"' . $lang['ABQ_QuestAuto'] . '" administration';
$lang['ABQ_AdminI_Fonts'] = 'font administration';
$lang['ABQ_AdminI_Config2'] = 'color-configuration';
$lang['ABQ_AdminI_IndiFragen'] = '"' . $lang['ABQ_QuestIndi'] . '" administration';
$lang['ABQ_AdminI_IndiImages'] = 'image administration';

// configuration
$lang['ABQ_Aktivate'] = 'Enable/disable Anti Bot Question MOD';
$lang['ABQ_Aktivate_explain'] = 'Here you can turn the MOD for registrations and guest postings on and off.';
$lang['ABQ_Register'] = 'Enable Anti Bot Questions for registrations';
$lang['ABQ_Register_explain'] = 'Users must answer a question correctly within the registration.';
$lang['ABQ_confirm_aktiv'] = 'The Visual Confirmation is (also) enabled! (You can disable it under: ' . $lang['General'] . ' &gt; ' . $lang['Configuration'] . ')';
$lang['ABQ_Guest'] = 'Enable Anti Bot Question for guests';
$lang['ABQ_Guest_explain'] = 'If the MOD is enabled for guests, guests must answer the Anti Bot Question correctly to complete the guest post successfully.';
 // general configuration
$lang['ABQ_GeneralConfig'] = 'General Configuration';
$lang['ABQ_VarName'] = 'Select the name of the Anti Bot Question POST-variable';
$lang['ABQ_VarName_Explain'] = 'Choose a combination. This does not have visible influence on the registration form for human visitors.';
$lang['ABQ_VerhEFAF'] = 'What percent of the questions should be Individual Questions (the remaining percent are Automatic Questions)';
$lang['ABQ_VerhEFAF_Explain'] = 'With 100% only Individual Questions are taken, with 0% only Automatic Questions. If the Individual Questions are disabled, no Individual Question exists or no kind of Automatic Question is enabled, this setting will be ignored.';
$lang['ABQ_AF_Malzeichen'] = 'Multiplication symbol';
$lang['ABQ_AF_Malzeichen_Explain'] = 'Select a multiplication symbol used within arithmetic problems<br />3*3=?; 3x3=?; 3X3=?';
$lang['ABQ_AF_Use_Select'] = 'Multiple Choice within Automatic Questions';
$lang['ABQ_AF_Use_Select_Explain'] = 'If you select the Multiple Choice option, the user does not have to type an answer. The user must select the correct answer only from several given answers. This is a substantial simplification of the procedure for the user. But the bot protection is also a little bit reduced.';
 // Individual Question Individuelle Fragen configuration
$lang['ABQ_EFConfig'] = 'Individual Question Configuration';
$lang['ABQ_EFConfig_explain'] = 'Only the Individual Questions are affected by this settings.';
$lang['ABQ_IndividulleFragenVerwenden'] = 'Enable the Individual Questions';
$lang['ABQ_IndividulleFragenVerwenden_Explain'] = 'If the Individual Questions are disabled, the MOD uses only the Automatic Questions. If no Individual Question is available, this setting will be ignored and the MOD always uses an Automatic Question. If no Automatic Question is enabled, the MOD always uses the Automatic Textquestion type 1.';
$lang['ABQ_CaseSensitive'] = 'Is the Answer to the Individual Question case sensitive?';
$lang['ABQ_CaseSensitive_Explain'] = 'Automatic Questions ignore this setting. The answer to an Automatic Question is always case sensitive!';
$lang['ABQ_BildPHP'] = 'Use the file abq_bild.php to show images';
$lang['ABQ_BildPHP_Explain'] = 'This file makes the identification of images more difficult for Bots. However this does not function on all servers (depending on the server-configuration).<br />If you can read the text (text: Test) shown in the following image, then you should activate this setting.<br />%s<br clear="all" />If no image is shown, there is no error. Your server does not support this function.';
 // Automatical Question configuration
$lang['ABQ_AFConfig'] = 'Automatical Question Configuration';
$lang['ABQ_AFConfig_explain'] = 'Only the Individual Questions are affected by this settings. These presuppose that the <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">GD Graphics Library</a> is installed on the server. An installed version of the <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">FreeType Library</a> is not necessary but recommended.<br /><a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">GD Graphics Library</a>: %s<br /><a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">FreeType Library</a>: %s<br /><br />The linked example images are static (i.e. they do not change), in order to reduce the server load.';
$lang['ABQ_AFConfig_explain2'] = 'without FreeType Library';
$lang['ABQ_AFConfig_explain3'] = 'with FreeType Library';
$lang['ABQ_ImageType'] = 'Select the format of the images';
$lang['ABQ_JPGQuality'] = 'JPG-Quality';
$lang['ABQ_JPGQuality_Explain'] = 'Values from 50 to 90 are permissible. The larger the value, the better the quality of the image is. But better quality also means longer load time.';
$lang['ABQ_Fontsize'] = 'font size';
$lang['ABQ_Fontsize_Explain'] = 'This setting is ignored if the <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">FreeType Library</a> is not installed.<br />Values from 15 to 40 are permissible. The larger the font size, the easier you can read the text in the images. However the font size also influences the image size. The larger the font size the larger the images are.<br />notice: If more than one text line exists, the font size is automatically reduced by 2 per line.';
$lang['ABQ_GrosseZahlen'] = 'Use large numbers within arithmetric problems';
$lang['ABQ_GrosseZahlen_Explain'] = 'If large numerical values are used, then the numbers used within arithmetic problems are larger than 1000. If large numerical values are not used, then the numbers, used within arithmetic problems, as well as the results have maximally a value of 350.';
$lang['ABQ_AFEFF_Max'] = 'Upper limit of the used effects';
$lang['ABQ_AFEFF_Max_explain'] = 'Here you can specify how many effects can be selected at random. This setting is relevant only for effects, whose setting is "' . $lang['ABQ_Rand'] . '".<br />If there are more effects with setting "Yes" than this value, then no "' . $lang['ABQ_Rand'] . '" effects will be used.<br />If there are fewer effects with setting "Yes" than this value, then "' . $lang['ABQ_Rand'] . '" effects will be used. Effects with setting "No" are never used.<br />This value is a maximum value for the number of used effects!<br />A value of zero means there is no limitation. The permissible maximum value is 6.';
$lang['ABQ_AFEFF_Trennlinie'] = 'Use effect: separator';
$lang['ABQ_AFEFF_Trennlinie_explain'] = 'If more than one text line exists, a separating line can be included between the text lines.';
$lang['ABQ_AFEFF_BGText'] = 'Use effect: background text';
$lang['ABQ_AFEFF_Grid'] = 'Use effect: grid';
$lang['ABQ_AFEFF_GridW'] = 'Horizontal distance of the grid network lines';
$lang['ABQ_AFEFF_GridW_explain'] = 'Permissible values: 10 - 100; 0 = a coincidental distance is selected';
$lang['ABQ_AFEFF_GridH'] = 'Vertical distance of the grid network lines';
$lang['ABQ_AFEFF_GridH_explain'] = 'Permissible values: 10 - 50; 0 = a coincidental distance is selected';
$lang['ABQ_AFEFF_GridF'] = 'Use effect: filled grid';
$lang['ABQ_AFEFF_GridF_explain'] = 'This effect can be used only in combination with the effect grid. If the effect grid is disabled, the effect filled grid is also automatically disabled.';
$lang['ABQ_AFEFF_Ellipsen'] = 'Use effect: ellipse and partial ellipse';
$lang['ABQ_AFEFF_Boegen'] = 'Use effect: arcs';
$lang['ABQ_AFEFF_Linien'] = 'Use effect: lines';

// Automatic Questions administration
$lang['ABQ_AutoQuestVerwalt'] = 'administrate Automatic Questions';
$lang['ABQ_AutoQuestVerwalt_Explain'] = 'Here you can select which Automatic Questions are enabled or disabled.<br /><br />If you want to use the image questions, the <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">GD Graphics Library</a> must be installed. The <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">GD Graphics Library</a> is %s on your server.<br /><br />If all Automatic Questions are disabled, the MOD uses only Individual Questions. If all Individual Questions are disabled, the MOD always uses the Automatic Text Question type 1.<br /><br />The line x. and the position x1 to x8 are replaced at random by adequate numbers.';
$lang['ABQ_AutoQuestVerwalt_TQ'] = 'text questions';
$lang['ABQ_AutoQuestVerwalt_IQ'] = 'image questions';
$lang['ABQ_Typ'] = 'type';
 // Automatic Text Questions
$lang['ABQ_AF05'] = '%s<br />4 lines are shown.';
$lang['ABQ_AF06'] = '%s<br />3 lines are shown.';
$lang['ABQ_AF07'] = '%s<br />2 lines are shown.';
$lang['ABQ_AF08'] = '%s';
$lang['ABQ_AF13'] = '%s<br />4 lines are shown.';
$lang['ABQ_AF14'] = '%s<br />3 lines are shown.';
$lang['ABQ_AF15'] = '%s<br />2 lines are shown.';
$lang['ABQ_AF16'] = '%s';
$lang['ABQ_AF21'] = '%s<br />4 lines are shown.';
$lang['ABQ_AF22'] = '%s<br />3 lines are shown.';
$lang['ABQ_AF23'] = '%s<br />2 lines are shown.';
$lang['ABQ_AF24'] = '%s';
$lang['ABQ_AF28'] = '%s';
$lang['ABQ_AF29'] = '%s';
$lang['ABQ_AF30'] = '%s';
 // Automatic Image Questions
$lang['ABQ_AF01'] = '%s<br />4 lines are shown.';
$lang['ABQ_AF02'] = '%s<br />3 lines are shown.';
$lang['ABQ_AF03'] = '%s<br />2 lines are shown.';
$lang['ABQ_AF04'] = '%s';
$lang['ABQ_AF09'] = '%s<br />4 lines are shown.';
$lang['ABQ_AF10'] = '%s<br />3 lines are shown.';
$lang['ABQ_AF11'] = '%s<br />2 lines are shown.';
$lang['ABQ_AF12'] = '%s';
$lang['ABQ_AF17'] = '%s<br />4 lines are shown.';
$lang['ABQ_AF18'] = '%s<br />3 lines are shown.';
$lang['ABQ_AF19'] = '%s<br />2 lines are shown.';
$lang['ABQ_AF20'] = '%s';
$lang['ABQ_AF25'] = '%s';
$lang['ABQ_AF26'] = '%s';
$lang['ABQ_AF27'] = '%s';
$lang['ABQ_AF31'] = '%s';
$lang['ABQ_AF32'] = '%s';
$lang['ABQ_AF33'] = '%s';
$lang['ABQ_AF34'] = '%s';

// Individual Questions administration
$lang['ABQ_Admin_Title'] = 'administrate Individual Questions';
$lang['ABQ_Admin_Explain'] = 'Here you can create new Individual Questions and edit or delete old questions.<br />If the Individual Questions are enabled, the MOD uses one of the following questions. The question is randomly selected.<br /><br />Example:<br />Question: Which of these four is an animal? Car, Europe, Horse, Mountain<br />Answer: Horse<br />';
$lang['ABQ_Answer'] = 'correct Answer';
$lang['ABQ_Answer_F'] = 'wrong Answer';
$lang['ABQ_Question'] = 'Question';
$lang['ABQ_ImageURL'] = 'Image-URL';
$lang['ABQ_ImageURL_DelExplain'] = 'The image is not deleted from the server!';
$lang['ABQ_Create_Question'] = 'Create a new question &amp; answer';
$lang['ABQ_Image_DNE'] = 'Does not exist any longer.';
$lang['ABQ_No_questions'] = '<br />No individual questions have been created.<br /><br />';
$lang['ABQ_Edit_Question'] = 'Edit Question';
$lang['ABQ_Answer_Explain'] = 'Case-sensitive!';
$lang['ABQ_Delete_Title'] = 'Delete Individual Question';
$lang['ABQ_Delete_Question'] = 'Delete Question';
$lang['ABQ_MCQ'] = 'Multiple Choice Question';
$lang['ABQ_IQ_MC_Info1'] = 'no Multiple Choice Question ** - The user must enter the answer into a text field.';
$lang['ABQ_IQ_MC_Info1a'] = 'Enter one or more correct answers and <b>no</b> wrong answer.';
$lang['ABQ_IQ_MC_Info2'] = 'Multiple Choice Question ** - Der Besucher muss aus den vorgegebenen Antworten die richtige Antwort raussuchen. The user must select the correct answer from all given answers.';
$lang['ABQ_IQ_MC_Info2a'] = 'Fill out only the field &quot;' . $lang['ABQ_Answer'] . ' 1&quot; and <b>all</b> wrong answer-fields.';
$lang['ABQ_IQ_MC_Info3'] = '** - If you select the Multiple Choice option, the user does not have to type an answer. This is a substantial simplification of the procedure for the user. But the bot protection is also a little bit reduced.';

// advanced configuration
$lang['ABQ_ColorConf_Titel'] = 'Color-Configuration';
$lang['ABQ_ColorConf_Explain'] = 'Here you can specify the colors used within the <b>Automatic Image Questions</b>. These values are irrelevant for the Individual Questions as well as the Automatic Text Questions.<br /><br /><img width="16" height="16" border="0" vspace="0" hspace="0" src="' . $phpbb_root_path . 'images/abq_mod/admin/achtung.gif" alt="ATTENTION" /> <b>Change these settings only if you know what you are doing. Wrong settings can cause the text within the images to be unreadable!</b><br clear="all"><br />Use the RGB schema to define the colors. The following is to be considered:<br />&#187; Valid color-values are: 0 - 255<br />&#187; Two values must be defined for each color attribute R (= red), g (= green) and B (= blue). The second value must be greater then the first.<br /><br />Normally only one value is necessary. Why are two values per color attribute necessary here?<br />Because you define not only one color. You define a set of colors. For example: If the first red-value is 10 and the second is 50, a randomly red-value greater than 9 and smaller than 51 is selected within the image.';
$lang['ABQ_RGB_red'] = 'R';
$lang['ABQ_RGB_green'] = 'G';
$lang['ABQ_RGB_blue'] = 'B';
$lang['ABQ_Mainconfig'] = 'default values';
$lang['ABQ_Color_BG'] = 'background color';
$lang['ABQ_Color_Text'] = 'text color';
$lang['ABQ_Color_Text_Explain'] = 'The text color must be clearly different from text color 1, text color 2 and background text color.';
$lang['ABQ_Color_F1'] = 'text color 1';
$lang['ABQ_Color_F1_Explain'] = 'The text color 1 is used within the Automatic Image Question type 16 (%s). If you select another color than green, you must change the language variable $lang[\'ABQ_Farbe1\'] (file: language/lang_???/lang_abq.php) from "green" to the new color. Make this change for all installed languages!<br />The text color 1 must be clearly different from text color, text color 2 and background text color.';
$lang['ABQ_Color_F2'] = 'text color 2';
$lang['ABQ_Color_F2_Explain'] = 'The text color 2 is used within the Automatic Image Question type 17 (%s). If you select another color than red, you must change the language variable $lang[\'ABQ_Farbe2\'] (file: language/lang_???/lang_abq.php) from "red" to the new color. Make this change for all installed languages!<br />The text color 2 must be clearly different from text color, text color 1 and background text color.';
$lang['ABQ_Effconfig'] = 'effect color';
$lang['ABQ_Color_SLines'] = 'Color of the separating line between the text lines';
$lang['ABQ_Color_BGText'] = 'background text color';
$lang['ABQ_Color_BGText_Explain'] = 'The background text color must be clearly different from text color, text color 1 and text color 2. The background color should be less intensive than the text color. This is important for differentiating between the relevant text and the irrelevant background text.';
$lang['ABQ_Color_Grid'] = 'grid color';
$lang['ABQ_Color_GridF'] = 'filled grid color';
$lang['ABQ_Color_Ellipsen'] = 'ellipse color';
$lang['ABQ_Color_TEllipsen'] = 'partial ellipse color';
$lang['ABQ_Color_Arcs'] = 'arc color';
$lang['ABQ_Color_Lines'] = 'line color';
$lang['ABQ_ValueReset'] = 'reset to default values';
$lang['ABQ_ValueReset_Explain'] = 'Here you can reset all color values to the original values.<br /><b>Important:</b><br />&#187; If you changed the variable $lang[\'ABQ_Farbe1\'], you must undo the change within the file language/lang_???/lang_abq.php for all installed languages. The original variable value is "green", the current value is "%s".<br />&#187; If you changed the variable $lang[\'ABQ_Farbe2\'], you must undo the change within the file language/lang_???/lang_abq.php for all installed languages. The original variable value is "red", the current value is "%s".';

// font administration
$lang['ABQ_FontAdmin_Title'] = 'font administration';
$lang['ABQ_FontAdmin_Explain'] = 'Here you can upload new fonts, which will be used within the Automatic Image Questions. Fonts, which you do not want to use any longer, can be deleted here.<br /><br />It is necessary that the <a href="' . $lang['ABQ_Wiki_GD'] . '" title="GD Graphics Library" target="_blank">GD Graphics Library</a> and the <a href="' . $lang['ABQ_Wiki_FT'] . '" title="FreeType Library" target="_blank">FreeType Library</a> are installed on the server, if you want to use one of these fonts.<br />GD Graphics Library: %s<br />FreeType Library: %s<br /><br />Before uploading a new font please check the copyright. Do not breach any copyrights.';
$lang['ABQ_Font'] = 'font';
$lang['ABQ_Upload_New_Font'] = 'upload a new font';
$lang['ABQ_gd_ft_fehlt'] = 'The GD Graphics Library and the FreeType Library must be installed. Without one of these libraries, the fonts cannot be used.<br />At least one library is not installed.';
$lang['ABQ_FontAdmin_Example'] = 'show font';
$lang['ABQ_FontAdmin_Example_Explain'] = 'Here the font can be tested. Is the font suitable for the MOD? Are all used characters identifiable and does the font include all used characters?';
$lang['ABQ_Font_Anforderungen'] = 'Following characters must be included and identifiable within the image:';
$lang['ABQ_FontAdmin_Delete'] = 'delete font';
$lang['ABQ_FontAdmin_Delete_Explain'] = 'Here you can delete a font, if you do not want to use it any longer within the MOD. %s If you want to use this font in the future, you must upload this font again.';
$lang['ABQ_FontAdmin_Delete_Explain2'] = 'The font will be completely deleted from the font-order!';
$lang['ABQ_FontAdmin_Upload'] = 'font upload';
$lang['ABQ_FontAdmin_Upload_Explain'] = 'Here you can upload new fonts. The following is to be considered:<br />The maximum allowed size of the font file is %d KB.<br />Before uploading a new font please check the copyright. Do not breach any copyrights.';
$lang['ABQ_FontAdmin_Upload_FontFile'] = 'Upload font from your machine';
$lang['ABQ_FontAdmin_Upload_FontFile_Explain'] = '<br />Only TTF font files can be uploaded. Other file formats are not valid.<br />Only alphabetic characters, numbers, hyphens (-) and underlines (_) are allowed within the file name.<br />You can not overwrite an existing font file. You must first delete the font file and then you can upload the new font (with the same file name).';

// Image Administration for the Individual Questions
$lang['ABQ_IImageAdmin_Title'] = 'Image Administration for the Individual Questions';
$lang['ABQ_IImageAdmin_Explain'] = 'Here you can upload new images for use within the Individual Questions. If you do not use an image any longer, you can delete it here.<br /><br />Before uploading a new image please check the copyright. Do not breach any copyrights.';
$lang['ABQ_Upload_New_Image'] = 'upload a new image';
$lang['ABQ_ShowImage'] = 'show image';
$lang['ABQ_No_IIMages'] = 'There is no image, which can be used within the Individual Questions.';
$lang['ABQ_IImageAdmin_Delete'] = 'delete image';
$lang['ABQ_IImageAdmin_Delete_Explain'] = 'If you do not need an image any longer, you can delete it here. %s If you want to use the deleted image in the future, you must upload the image again.';
$lang['ABQ_IImageAdmin_Delete_Explain2'] = 'The image will be completely deleted from the image-order!';
$lang['ABQ_IImageAdmin_Upload'] = 'image upload';
$lang['ABQ_IImageAdmin_Upload_Explain'] = 'Here you can upload new images. The following is to be considered:<br />The maximum allowed size of the image file is %d KB.<br />Before uploading a new image please check the copyright. Do not breach any copyrights.';
$lang['ABQ_IImageAdmin_Upload_ImageFile'] = 'Upload image from your machine';
$lang['ABQ_IImageAdmin_Upload_ImageFile_Explain'] = '<br />Only following image type / file extensions are valid: jpg (jpeg), gif, png. Other image types are not valid.<br />Only alphabetic characters, numbers, hyphens (-) and underlines (_) are allowed within the file name.<br />You cannot overwrite an existing image file. You must first delete the image file and then you can upload the new image (with the same file name).';

// error messages
$lang['ABQ_not_updated'] = 'The database has not been updated.';
$lang['ABQ_ConfProzente'] = 'The percentage value must be between 0 and 100. Decimal places are not permissible.';
$lang['ABQ_ConfMaxEffekte'] = 'The value for the upper limit of the used effects must be within the value range of 0 to 6. Decimal places are not permissible.';
$lang['ABQ_ConfGridW'] = 'The value for the horizontal distance of the grid network lines must be 0 or within the value range of 10 to 100. Decimal places are not permissible.';
$lang['ABQ_ConfGridH'] = 'The value for the vertical distance of the grid network lines must be 0 or within the value range of 10 to 50. Decimal places are not permissible.';
$lang['ABQ_ConfFontsize'] = 'The font size must be greater then 14 and smaller then 40. Decimal places are not permissible.';
$lang['ABQ_ConfJPGQuality'] = 'The value for the JPG-quality must be within the value range of 50 to 90. Decimal places are not permissible.';
$lang['ABQ_Question_too_long'] = 'The question is too long (maximum length: %s characters)';
$lang['ABQ_Answer_too_long'] = 'At least one of the answers is too long (maximum length: %s characters)';
$lang['ABQ_Missed_Question'] = 'You must specify a question.';
$lang['ABQ_Missed_Answer'] = 'You must specify at least one answer.';
$lang['ABQ_No_Image'] = 'The image you selected is not available.';
$lang['ABQ_ColorRand_WrongValue'] = 'The value for the colors must be within the value range of 0 to 255. Decimal places are not permissible.';
$lang['ABQ_ColorRand_2NichtGroesser1'] = 'If two values are necessary for one color, the second value must be greater then the first. You ignored this necessity.';
$lang['ABQ_Valuereset_Not_Checked'] = 'Please confirm the reset check box. Without this confirmation the reset is not possible.';
$lang['ABQ_Error_no_fonts'] = 'No font is available. <b>The font "do-not-delete" is necessary for the successful operation of the MOD.</b> This font should be uploaded as soon as possible.';
$lang['ABQ_Error_font_missing'] = '<b>The font "do-not-delete" is necessary for the successful operation of the MOD.</b> This font is missing. Please upload this font as soon as possible.';
$lang['ABQ_upload_File_Error'] = 'The file was not uploaded.';
$lang['ABQ_upload_Font_FileSize'] = 'The font file size must be less than %d KB.';
$lang['ABQ_upload_File_exists'] = 'A file with the same name already exists.<br />Please delete the existing file or rename the file you want to upload.';
$lang['ABQ_upload_File_WrongTyp'] = 'The file has an invalid file type or an invalid file name (use only alphabetic characters, numbers, hyphens and underlines within the file name).';
$lang['ABQ_delete_Font_false'] = 'Unable to delete the font file.<br />You must have the authorization to delete files within the order abq_mod/fonts/. Please check it. The CHMOD of this order must be 777.';
$lang['ABQ_upload_no_File'] = 'No file was specified to be uploaded.';
$lang['ABQ_upload_wrong_Filename'] = 'No valid file name. Only alphabetic characters, numbers, hyphens (-) and underlines (_) are allowed within the file name. Please rename the file.';
$lang['ABQ_upload_can_not_create_File'] = 'Unable to upload the file. You must have the authorization to upload files. Please check it (chmod %s 777).';
$lang['ABQ_delete_Image_false'] = 'Unable to delete the image file.<br />You must have the authorization to delete files within the order images/abq_mod/. Please check it. The CHMOD of this order must be 777.';
$lang['ABQ_upload_Image_FileSize'] = 'The image file size must be less than %d KB.';
$lang['ABQ_upload_Image_WrongTyp'] = 'Only jpg (jpeg), gif and png images could be uploaded. Other image types are not valid. The image type of your new image is not a valid type.';
$lang['ABQ_MC_or_nMC'] = 'No Multiple Choice: one or more correct answers and no wrong answer; Multiple Choice: only one correct answer and ten wrong answers. Other options do not exist.';
$lang['ABQ_MC_AnswerMissing'] = 'If you want to use the Multiple Choice function, you must enter 10 wrong answers.';
$lang['ABQ_MC_WAngRA'] = 'A wrong answer is identical with the correct answer.';
$lang['ABQ_MC_WA_doppelt'] = 'Do not use a wrong answer twice.';

?>