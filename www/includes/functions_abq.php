<?php
/***************************************************************************
 *                          functions_abq.php
 *                          -----------------
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

function ABQ_FrageStellen($AufrufWoher)
{
	global $abq_answerfield, $abq_config, $abq_id, $abq_quest, $board_config, $db, $dbms, $FTL_JN, $GDL_JN, $lang, $phpbb_root_path, $phpEx, $template, $user_ip, $userdata;

	mt_srand((double)microtime()*1231230);

	$WertReturn = 0;
	$FrageStellen = 0;
	$abq_quest = '';
	$abq_image = '';

	if ($AufrufWoher == 'P')
	{
		global $hidden_form_fields;

		if ($abq_config['abq_guest'] && !$userdata['session_logged_in'])
		{
			if (!isset($abq_id))
			{
				$abq_id = 0;
			}
			$FrageStellen = 1;
		}
	}
	elseif ($AufrufWoher == 'R')
	{
		global $idabq, $s_hidden_fields;

		if (isset($idabq))
		{
			$abq_id = htmlspecialchars($idabq);
		}
		else
		{
			$abq_id = 0;
		}
		$FrageStellen = 1;
	}

	$sql = 'SELECT session_id 
		FROM ' . SESSIONS_TABLE; 
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not select session data', '', __LINE__, __FILE__, $sql);
	}
	if ($row = $db->sql_fetchrow($result))
	{
		$abq_confirm_sql = '';
		do
		{
			$abq_confirm_sql .= (($abq_confirm_sql != '') ? ', ' : '') . "'" . $row['session_id'] . "'";
		}
		while ($row = $db->sql_fetchrow($result));
	
		$sql = 'DELETE FROM ' .  ANTI_BOT_QUEST_CONFIRM_TABLE . " 
			WHERE session_id NOT IN ($abq_confirm_sql)";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete stale anti bot question data', '', __LINE__, __FILE__, $sql);
		}
	}
	$db->sql_freeresult($result);

	if ($FrageStellen)
	{
		if ($AufrufWoher == 'R')
		{
			$sql = 'SELECT COUNT(session_id) AS attempts 
				FROM ' . ANTI_BOT_QUEST_CONFIRM_TABLE . " 
				WHERE session_id = '" . $userdata['session_id'] . "'";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain anti bot question answers count', '', __LINE__, __FILE__, $sql);
			}
			if ($row = $db->sql_fetchrow($result))
			{
				if ($row['attempts'] > 3)
				{
					message_die(GENERAL_MESSAGE, $lang['Too_many_registers']);
				}
			}
			$db->sql_freeresult($result);
		}

		$FTL_JN = 0;
		$GDL_JN = 0;
		ABQ_gdVersion();

		$confirm_id = md5(uniqid($user_ip));

		$quest_line1 = '';
		$quest_line2 = '';
		$quest_line3 = '';
		$quest_line4 = '';
		$quest_farbe = '';

		$FragenTyp = 1;
		$maximumrand = 0;
		for ($i=1; $i<=34; $i++)
		{
			unset($j);
			$j = ($i < 10) ? '0' . $i : $i;
			if (($GDL_JN < 1) && (($i == 1) || ($i == 2) || ($i == 3) || ($i == 4) || ($i == 9) || ($i == 10) || ($i == 11) || ($i == 12) || ($i == 17) || ($i == 18) || ($i == 19) || ($i == 20) || ($i == 25) || ($i == 26) || ($i == 27) || ($i == 31) || ($i == 32) || ($i == 34)))
			{}
			else
			{
				$maximumrand += $abq_config["autofrage_$j"];
			}
		}

		if (($abq_config['eigene_fragen'] == 1) || ($maximumrand < 1))
		{
			if (($abq_config['verhaeltnis_eigene_auto'] == 100) || ($maximumrand < 1))
			{
				$FragenTyp = 'E';
			}
			elseif ($abq_config['verhaeltnis_eigene_auto'] == 0)
			{}
			else
			{
				$prozent = mt_rand(1, 100);
				if ($prozent <= $abq_config['verhaeltnis_eigene_auto'])
				{
					$FragenTyp = 'E';
				}
			}
		}

		if ($FragenTyp == 'E')
		{
			if (preg_match('/[^a-z0-9]/i', $abq_id))
			{
				$abq_id = 0;
			}
			if (!empty($abq_id))
			{
				$sql = 'SELECT answer 
					FROM ' . ANTI_BOT_QUEST_CONFIRM_TABLE . ' 
					WHERE confirm_id = \'' . $confirm_id . '\' 
						AND session_id = \'' . $userdata['session_id'] . '\'';
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Could not obtain anti bot question answer', __LINE__, __FILE__, $sql);
				}
				$sql = 'SELECT ' . (($dbms == 'mssql') ? 'TOP 1 ' : '') . '* 
					FROM ' . ANTI_BOT_QUEST_TABLE . '
					WHERE lang = \'' . $board_config['default_lang'] . '\' ';
				if ($row = $db->sql_fetchrow($result))
				{
					if (substr($row['answer'],0,1) == '_')
					{
						$sql .= 'AND id != ' . substr($row['answer'],1) . ' ';
					}
				}
				$sql .= 'ORDER BY ' . (($dbms == 'mssql') ? 'NEWID()' : 'RAND() LIMIT 1');
				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not obtain anti bot question information', '', __LINE__, __FILE__, $sql);
				}
				if ($db->sql_numrows($result) < 1)
				{
					$abq_id = 0;
				}
			}
			if (empty($abq_id))
			{
				$sql = 'SELECT ' . (($dbms == 'mssql') ? 'TOP 1 ' : '') . '*
					FROM ' . ANTI_BOT_QUEST_TABLE . '
					WHERE lang = \'' . $board_config['default_lang'] . '\' 
					ORDER BY ' . (($dbms == 'mssql') ? 'NEWID()' : 'RAND() LIMIT 1');
				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not obtain anti bot question information', '', __LINE__, __FILE__, $sql);
				}
			}
			if ($db->sql_numrows($result) > 0)
			{
				$abqrow = $db->sql_fetchrow($result);

				$abq_quest = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $abqrow['question']);
				if ($abqrow['bbcodeuid'] != '')
				{
					$abq_quest = bbencode_second_pass($abq_quest, $abqrow['bbcodeuid']);
				}
				$abq_quest = str_replace("\n", "\n<br />\n", $abq_quest);

				$abq_image = $abqrow['anti_bot_img'];
				if ($abq_image != '')
				{
					if ($abq_config['ef_bild'])
					{
						$abq_image = '<br /><img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=' . $confirm_id . '" />';
					}
					else
					{
						$abq_image = '<br /><img src="' . $phpbb_root_path . 'images/abq_mod/' . $abq_image . '" />';
					}
					$abq_quest .= $abq_image;
				}
				$confirm_answer = '_' . $abqrow['id'];
			}
			else
			{
				$FragenTyp = 1;
			}
		}
		if ($FragenTyp == 'E')
		{
			$WertReturn = $abq_config['ef_casesensitive'];
		}
		else
		{
			if ($maximumrand < 1)
			{
				$autofragetyp = 5;
			}
			else
			{
				$autofragetyp = mt_rand(1, $maximumrand);
				unset($i);
				unset($j);
				$j = 0;
				for ($i=1; $i<=34; $i++)
				{
					unset($k);
					$k = ($i < 10) ? '0' . $i : $i;
					if (($GDL_JN < 1) && (($i == 1) || ($i == 2) || ($i == 3) || ($i == 4) || ($i == 9) || ($i == 10) || ($i == 11) || ($i == 12) || ($i == 17) || ($i == 18) || ($i == 19) || ($i == 20) || ($i == 25) || ($i == 26) || ($i == 27) || ($i == 31) || ($i == 32) || ($i == 34)))
					{}
					elseif ($abq_config['autofrage_'.$k] == 1)
					{
						$j++;
						if ($j == $autofragetyp)
						{
							$autofragetyp = $i;
							break;
						}
					}
				}
			}
			if (($autofragetyp >= 9) && ($autofragetyp <= 16))
			{
				if (($autofragetyp == 10) || ($autofragetyp == 14))
				{
					$maxZeilen = 3;
				}
				elseif (($autofragetyp == 11) || ($autofragetyp == 15))
				{
					$maxZeilen = 2;
				}
				elseif (($autofragetyp == 12) || ($autofragetyp == 16))
				{
					$maxZeilen = 1;
				}
				else
				{
					$maxZeilen = 4;
				}
				$Zeile = mt_rand(1, $maxZeilen);
				if ($maxZeilen > 1)
				{
					$abq_quest = sprintf($lang['ABQ_AFrageTyp03'], $Zeile) . '<br />';
				}
				else
				{
					$abq_quest = $lang['ABQ_AFrageTyp04'] . '<br />';
				}
				for ($i=1; $i<=$maxZeilen; $i++)
				{
					$ArtDerZeichenfolge = mt_rand(1, 2);
					if ($ArtDerZeichenfolge == 1)
					{
						$Zahlen = ZeichenfolgeErstellen('1');
						$Buchstaben = ZeichenfolgeErstellen('a');
						$Zeichen = ZeichenfolgeErstellen('#');
						$ZahlenAnzahl = mt_rand(5, 7);
						$BuchstabenAnzahl = mt_rand((10 - $ZahlenAnzahl), (12 - $ZahlenAnzahl));
						$ZeichenAnzahl = mt_rand(0, 2);
						if (strlen($Zahlen) > $ZahlenAnzahl)
						{
							$Zahlen = substr($Zahlen, 0, $ZahlenAnzahl);
						}
						elseif (strlen($Zahlen) < $ZahlenAnzahl)
						{
							for ($j=strlen($Zahlen); $j<$ZahlenAnzahl; $j++)
							{
								$Zahlen .= ($j+1);
							}
						}
						if (strlen($Buchstaben) > $BuchstabenAnzahl)
						{
							$Buchstaben = substr($Buchstaben, 0, $BuchstabenAnzahl);
						}
						elseif (strlen($Buchstaben) < $BuchstabenAnzahl)
						{
							for ($j=strlen($Buchstaben); $j<$BuchstabenAnzahl; $j++)
							{
								$Buchstaben .= 'A';
							}
						}
						if ($ZeichenAnzahl == 0)
						{
							$Zeichen = '';
						}
						else
						{
							$Zeichen = substr($Zeichen, 0, $ZeichenAnzahl);
						}
						$code1 = $Zahlen . $Buchstaben . $Zeichen;
						$code2 = '';
						$code1len1 = strlen($code1);
						for ($j=0; $j<$code1len1; $j++)
						{
							$code1len2 = strlen($code1);
							$ZeichenPosition = mt_rand(0, ($code1len2-1));
							$code2 .= substr($code1, $ZeichenPosition, 1);
							if ($code1len2 > 1)
							{
								if ($ZeichenPosition > 0)
								{
									$code1 = substr($code1, 0, $ZeichenPosition) . substr($code1, ($ZeichenPosition+1));
								}
								else
								{
									$code1 = substr($code1, 1);
								}
							}
						}
					}
					else
					{
						$code2 = ZeichenfolgeRechenaufgabeErstellen();
					}
					if  ($Zeile == $i)
					{
						$confirm_answer = preg_replace('/[^0-9]/i', '', $code2);
					}
					${'quest_line'.$i} = $code2;
					if ($autofragetyp > 12)
					{
						$abq_quest .= $code2 . '<br />';
					}
				}
				if ($autofragetyp < 13)
				{
					$abq_quest .= '<img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=' . $confirm_id . '" /><br clear="all" />';
				}
				$abq_quest .= $lang['ABQ_AFrageTyp03Hinweis'];
			}
			elseif (($autofragetyp >= 17) && ($autofragetyp <= 24))
			{
				if (($autofragetyp == 18) || ($autofragetyp == 22))
				{
					$maxZeilen = 3;
				}
				elseif (($autofragetyp == 19) || ($autofragetyp == 23))
				{
					$maxZeilen = 2;
				}
				elseif (($autofragetyp == 20) || ($autofragetyp == 24))
				{
					$maxZeilen = 1;
				}
				else
				{
					$maxZeilen = 4;
				}
				$Zeile = mt_rand(1, $maxZeilen);
				if ($maxZeilen > 1)
				{
					$abq_quest = sprintf($lang['ABQ_AFrageTyp05'], $Zeile) . '<br />';
				}
				else
				{
					$abq_quest = $lang['ABQ_AFrageTyp06'] . '<br />';
				}
				for ($i=1; $i<=$maxZeilen; $i++)
				{
					$Zahlen = ZeichenfolgeErstellen('1');
					$Buchstaben = ZeichenfolgeErstellen('a');
					$Zeichen = ZeichenfolgeErstellen('#');
					$BuchstabenAnzahl = mt_rand(5, 7);
					$ZahlenAnzahl = mt_rand((10 - $BuchstabenAnzahl), (12 - $BuchstabenAnzahl));
					$ZeichenAnzahl = mt_rand(0, 2);
					if (strlen($Zahlen) > $ZahlenAnzahl)
					{
						$Zahlen = substr($Zahlen, 0, $ZahlenAnzahl);
					}
					elseif (strlen($Zahlen) < $ZahlenAnzahl)
					{
						for ($j=strlen($Zahlen); $j<$ZahlenAnzahl; $j++)
						{
							$Zahlen .= ($j+1);
						}
					}
					if (strlen($Buchstaben) > $BuchstabenAnzahl)
					{
						$Buchstaben = substr($Buchstaben, 0, $BuchstabenAnzahl);
					}
					elseif (strlen($Buchstaben) < $BuchstabenAnzahl)
					{
						for ($j=strlen($Buchstaben); $j<$BuchstabenAnzahl; $j++)
						{
							$Buchstaben .= 'A';
						}
					}
					if ($ZeichenAnzahl == 0)
					{
						$Zeichen = '';
					}
					else
					{
						$Zeichen = substr($Zeichen, 0, $ZeichenAnzahl);
					}
					$code1 = $Zahlen . $Buchstaben . $Zeichen;
					$code2 = '';
					$code1len1 = strlen($code1);
					for ($j=0; $j<$code1len1; $j++)
					{
						$code1len2 = strlen($code1);
						$ZeichenPosition = mt_rand(0, ($code1len2-1));
						$code2 .= substr($code1, $ZeichenPosition, 1);
						if ($code1len2 > 1)
						{
							if ($ZeichenPosition > 0)
							{
								$code1 = substr($code1, 0, $ZeichenPosition) . substr($code1, ($ZeichenPosition+1));
							}
							else
							{
								$code1 = substr($code1, 1);
							}
						}
					}
					if  ($Zeile == $i)
					{
						$confirm_answer = preg_replace('/[^a-z]/i', '', $code2);
					}
					${'quest_line'.$i} = $code2;
					if ($autofragetyp > 20)
					{
						$abq_quest .= $code2 . '<br />';
					}
				}
				if ($autofragetyp < 21)
				{
					$abq_quest .= '<img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=' . $confirm_id . '" /><br clear="all" />';
				}
				$abq_quest .= $lang['ABQ_AFrageTyp05Hinweis'];
			}
			elseif (($autofragetyp >= 25) && ($autofragetyp <= 30))
			{
				$abq_quest = '';
				$GesamtZeichenfolge = '';
				for ($i=1; $i<=4; $i++)
				{
					$Zahlen = ZeichenfolgeErstellen('1');
					$Buchstaben = ZeichenfolgeErstellen('a');
					$ZahlenAnzahl = mt_rand(4, 7);
					$BuchstabenAnzahl = mt_rand((10 - $ZahlenAnzahl), (12 - $ZahlenAnzahl));
					if (strlen($Zahlen) > $ZahlenAnzahl)
					{
						$Zahlen = substr($Zahlen, 0, $ZahlenAnzahl);
					}
					elseif (strlen($Zahlen) < $ZahlenAnzahl)
					{
						for ($j=strlen($Zahlen); $j<$ZahlenAnzahl; $j++)
						{
							$Zahlen .= ($j+1);
						}
					}
					if (strlen($Buchstaben) > $BuchstabenAnzahl)
					{
						$Buchstaben = substr($Buchstaben, 0, $BuchstabenAnzahl);
					}
					elseif (strlen($Buchstaben) < $BuchstabenAnzahl)
					{
						for ($j=strlen($Buchstaben); $j<$BuchstabenAnzahl; $j++)
						{
							$Buchstaben .= 'A';
						}
					}
					$code1 = $Zahlen . $Buchstaben;
					$code2 = '';
					$code1len1 = strlen($code1);
					for ($j=0; $j<$code1len1; $j++)
					{
						$code1len2 = strlen($code1);
						$ZeichenPosition = mt_rand(0, ($code1len2-1));
						$code2 .= substr($code1, $ZeichenPosition, 1);
						if ($code1len2 > 1)
						{
							if ($ZeichenPosition > 0)
							{
								$code1 = substr($code1, 0, $ZeichenPosition) . substr($code1, ($ZeichenPosition+1));
							}
							else
							{
								$code1 = substr($code1, 1);
							}
						}
					}
					${'quest_line'.$i} = $code2;
					$GesamtZeichenfolge .= $code2;
					if ($autofragetyp > 27)
					{
						$abq_quest .= $code2 . '<br />';
					}
				}
				if (($autofragetyp == 26) || ($autofragetyp == 29))
				{
					$BenZeichen = 7;
				}
				elseif (($autofragetyp == 27) || ($autofragetyp == 30))
				{
					$BenZeichen = 6;
				}
				else
				{
					$BenZeichen = 8;
				}
				$Positionen = '';
				$Position = -1;
				$GesamtLen = strlen($GesamtZeichenfolge);
				for ($i=0; $i<$BenZeichen; $i++)
				{
					$Position = mt_rand(($Position+1), ($GesamtLen-((2*($BenZeichen-($i+1)))+1)));
					$confirm_answer .= substr($GesamtZeichenfolge, $Position, 1);
					$Positionen .= (($Positionen != '') ? ((($i+1) == $BenZeichen) ? ' ' . $lang['ABQ_and'] . ' ' : ', ') : '' ) . ($Position+1) . '.';
				}
				$abq_quest = sprintf($lang['ABQ_AFrageTyp07'], $Positionen) . '<br />' . $abq_quest;
				if ($autofragetyp < 28)
				{
					$abq_quest .= '<img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=' . $confirm_id . '" /><br clear="all" />';
				}
				$abq_quest .= $lang['ABQ_AFrageTyp07Hinweis'];
			}
			elseif (($autofragetyp >= 31) && ($autofragetyp <= 32))
			{
				if ($autofragetyp == 31)
				{
					$abq_quest = $lang['ABQ_Farbe1'];
					$quest_farbe = 'G';
				}
				else
				{
					$abq_quest = $lang['ABQ_Farbe2'];
					$quest_farbe = 'R';
				}
				$GesamtZeichenfolge = '';
				for ($i=1; $i<=4; $i++)
				{
					$Zahlen = ZeichenfolgeErstellen('1');
					$Buchstaben = ZeichenfolgeErstellen('a');
					$ZahlenAnzahl = mt_rand(4, 7);
					$BuchstabenAnzahl = mt_rand((10 - $ZahlenAnzahl), (12 - $ZahlenAnzahl));
					if (strlen($Zahlen) > $ZahlenAnzahl)
					{
						$Zahlen = substr($Zahlen, 0, $ZahlenAnzahl);
					}
					elseif (strlen($Zahlen) < $ZahlenAnzahl)
					{
						for ($j=strlen($Zahlen); $j<$ZahlenAnzahl; $j++)
						{
							$Zahlen .= ($j+1);
						}
					}
					if (strlen($Buchstaben) > $BuchstabenAnzahl)
					{
						$Buchstaben = substr($Buchstaben, 0, $BuchstabenAnzahl);
					}
					elseif (strlen($Buchstaben) < $BuchstabenAnzahl)
					{
						for ($j=strlen($Buchstaben); $j<$BuchstabenAnzahl; $j++)
						{
							$Buchstaben .= 'A';
						}
					}
					$code1 = $Zahlen . $Buchstaben;
					$code2 = '';
					$code1len1 = strlen($code1);
					for ($j=0; $j<$code1len1; $j++)
					{
						$code1len2 = strlen($code1);
						$ZeichenPosition = mt_rand(0, ($code1len2-1));
						$code2 .= substr($code1, $ZeichenPosition, 1);
						if ($code1len2 > 1)
						{
							if ($ZeichenPosition > 0)
							{
								$code1 = substr($code1, 0, $ZeichenPosition) . substr($code1, ($ZeichenPosition+1));
							}
							else
							{
								$code1 = substr($code1, 1);
							}
						}
					}
					${'quest_line'.$i} = $code2;
				}
				$BenZeichen = mt_rand(6, 8);
				$ZeichZeile1 = mt_rand(0, ($BenZeichen-3));
				$ZeichZeile2 = mt_rand(0, ($BenZeichen-(2+$ZeichZeile1)));
				$ZeichZeile3 = mt_rand(0, ($BenZeichen-(1+$ZeichZeile1+$ZeichZeile2)));
				$ZeichZeile4 = $BenZeichen - ($ZeichZeile1 + $ZeichZeile2 + $ZeichZeile3);
				for ($i=1; $i<=4; $i++)
				{
					if (${'ZeichZeile'.$i} > 0)
					{
						$GesamtLen = strlen(${'quest_line'.$i});
						$letztePosition = -1;
						$newLine = '';
						for ($j=0; $j<${'ZeichZeile'.$i}; $j++)
						{
							$Position = mt_rand(($letztePosition+1), ($GesamtLen-((2*(${'ZeichZeile'.$i}-($j+1)))+1)));
							$confirm_answer .= substr(${'quest_line'.$i}, $Position, 1);
							if ($Position != 0)
							{
								$newLine .= substr(${'quest_line'.$i}, ($letztePosition + 1), ($Position - ($letztePosition + 1))) . '+' . substr(${'quest_line'.$i}, $Position, 1);
							}
							else
							{
								$newLine .= '+' . substr(${'quest_line'.$i}, $Position, 1);
							}
							$letztePosition = $Position;
						}
						if ($letztePosition != ($GesamtLen - 1))
						{
							$newLine .= substr(${'quest_line'.$i}, ($letztePosition+1));
						}
						${'quest_line'.$i} = $newLine;
					}
				}
				$abq_quest = sprintf($lang['ABQ_AFrageTyp08'], $abq_quest) . '<br />';
				$abq_quest .= '<img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=' . $confirm_id . '" /><br clear="all" />';
				$abq_quest .= $lang['ABQ_AFrageTyp08Hinweis'];
			}
			elseif (($autofragetyp >= 33) && ($autofragetyp <= 34))
			{
				$abq_quest = $lang['ABQ_AFrageTyp09'] . '<br />';
				$confirm_answer = '';
				$quest_line1 = '';
				$quest_line2 = '';
				ChaosZeichenfolge($quest_line1, $quest_line2, $confirm_answer);
				if ($autofragetyp == 33)
				{
					$abq_quest .= '<img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=' . $confirm_id . '" /><br clear="all" />';
				}
				else
				{
					$abq_quest .= $quest_line1 . '<br />' . $quest_line2;
				}
			}
			else
			{
				if (($autofragetyp == 2) || ($autofragetyp == 6))
				{
					$maxZeilen = 3;
				}
				elseif (($autofragetyp == 3) || ($autofragetyp == 7))
				{
					$maxZeilen = 2;
				}
				elseif (($autofragetyp == 4) || ($autofragetyp == 8))
				{
					$maxZeilen = 1;
				}
				else
				{
					$maxZeilen = 4;
				}
				$Zeile = mt_rand(1, $maxZeilen);
				if ($maxZeilen > 1)
				{
					$abq_quest = sprintf($lang['ABQ_AFrageTyp01'], $Zeile) . '<br />';
				}
				else
				{
					$abq_quest = $lang['ABQ_AFrageTyp02'] . '<br />';
				}
				$RA_AstronomischeZahlen = $abq_config['af_grossezahlen'];
				for ($i=1; $i<=$maxZeilen; $i++)
				{
					$Rechenaufgabe = '';
					$Loesung = '';
					if ($abq_config['af_grossezahlen'] == 2)
					{
						$RA_AstronomischeZahlen = mt_rand(0, 1);
					}
					RechenaufgabeErstellen($Rechenaufgabe, $Loesung, $RA_AstronomischeZahlen);
					if  ($Zeile == $i)
					{
						$confirm_answer = $Loesung;
					}
					${'quest_line'.$i} = $Rechenaufgabe;
					if ($autofragetyp > 4)
					{
						$abq_quest .= $Rechenaufgabe . '<br />';
					}
				}
				if ($autofragetyp < 5)
				{
					$abq_quest .= '<img src="' . $phpbb_root_path . 'forum/abq_bild.'.$phpEx.'?b=' . $confirm_id . '" /><br clear="all" />';
				}
				$abq_quest .= $lang['ABQ_AFrageTyp01Hinweis'];
			}
		$WertReturn = 1;
		}

		if (!empty($confirm_answer))
		{
			if (substr($confirm_answer,0,1) == '_')
			{
				if ((isset($abqrow['wronganswer01'])) && ($abqrow['wronganswer01'] != '') && ($abqrow['wronganswer02'] != '') && ($abqrow['wronganswer03'] != '') && ($abqrow['wronganswer04'] != '') && ($abqrow['wronganswer05'] != '') && ($abqrow['wronganswer06'] != '') && ($abqrow['wronganswer07'] != '') && ($abqrow['wronganswer08'] != '') && ($abqrow['wronganswer09'] != '') && ($abqrow['wronganswer10'] != ''))
				{
					$abq_answerfield = '<select name="' . $abq_config['postvariablename'] . '">';
					$abq_answerfield .= '<option value="_" selected="selected">---- ' . $lang['ABQ_S_Select1'] . ' ----</option>';
					unset($AntwortSelectArray);
					$AntwortSelectArray = array($abqrow['answer1'], $abqrow['wronganswer01'], $abqrow['wronganswer02'], $abqrow['wronganswer03'], $abqrow['wronganswer04'], $abqrow['wronganswer05'], $abqrow['wronganswer06'], $abqrow['wronganswer07'], $abqrow['wronganswer08'], $abqrow['wronganswer09'], $abqrow['wronganswer10']);
					shuffle($AntwortSelectArray);
					unset($i);
					for ($i=0; $i<11; $i++)
					{
						$abq_answerfield .= '<option value="' . $AntwortSelectArray[$i] . '">&#160;&#160;' . $AntwortSelectArray[$i] . '</option>';
					}
					$abq_answerfield .= '</select>';
				}
				else
				{
					$abq_answerfield = '<input type="text" class="post" style="width: 200px"  name="' . $abq_config['postvariablename'] . '" size="35" maxlength="250" value="" />';
				}
			}
			elseif ($abq_config['af_use_select'])
			{
				$abq_answerfield = '<select name="' . $abq_config['postvariablename'] . '">';
				$abq_answerfield .= '<option value="_" selected="selected">---- ' . $lang['ABQ_S_Select1'] . ' ----</option>';
				unset($AntwortSelectArray);
				$AntwortSelectArray[0] = $confirm_answer;
				if (($autofragetyp >= 17) && ($autofragetyp <= 24))
				// nur Buchstaben
				{
					ABQAutoAntworten(1,$AntwortSelectArray);
				}
				elseif (($autofragetyp >= 25) && ($autofragetyp <= 34))
				// Mix
				{
					ABQAutoAntworten(2,$AntwortSelectArray);
				}
				elseif (($autofragetyp >= 9) && ($autofragetyp <= 16))
				// nur Zahlen
				{
					ABQAutoAntworten(3,$AntwortSelectArray, strlen($confirm_answer));
				}
				else
				// nur Zahlen
				{
					ABQAutoAntworten(4,$AntwortSelectArray);
				}
				shuffle($AntwortSelectArray);
				unset($i);
				for ($i=0; $i<11; $i++)
				{
					$abq_answerfield .= '<option value="' . $AntwortSelectArray[$i] . '">&#160;&#160;' . $AntwortSelectArray[$i] . '</option>';
				}
				$abq_answerfield .= '</select>';
			}
			else
			{
				$abq_answerfield = '<input type="text" class="post" style="width: 200px"  name="' . $abq_config['postvariablename'] . '" size="35" maxlength="250" value="" />';
			}

			$sql = 'INSERT INTO ' . ANTI_BOT_QUEST_CONFIRM_TABLE . ' (confirm_id, session_id, answer, line1, line2, line3, line4, farbe) 
				VALUES (\'' . $confirm_id . '\', \'' . $userdata['session_id'] . '\', \'' . $confirm_answer . '\', \'' . $quest_line1 . '\', \'' . $quest_line2 . '\', \'' . $quest_line3 . '\', \'' . $quest_line4 . '\', \'' . $quest_farbe . '\')';
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not insert new anti bot question answer information', '', __LINE__, __FILE__, $sql);
			}

			unset($confirm_answer);

			if ($AufrufWoher == 'P')
			{
				$hidden_form_fields .= '<input type="hidden" name="idabq" value="' . $confirm_id . '" />';
			}
			elseif ($AufrufWoher == 'R')
			{
				$s_hidden_fields .= '<input type="hidden" name="idabq" value="' . $confirm_id . '" />';
			}
			$template->assign_block_vars('switch_anti_bot_question', array());
		}
	}
	return $WertReturn;
}

function ABQ_AntwortPruefen($AufrufWoher)
{
	global $abq_aw, $abq_config, $abq_id, $board_config, $db, $error, $error_msg, $lang, $userdata,$phpbb_root_path;

	$AntwortPruefenJN = 0;
	if ($AufrufWoher == 'P')
	{
		global $userdata, $HTTP_POST_VARS;

		if ($abq_config['abq_guest'] && !$userdata['session_logged_in'])
		{
			$abq_aw = htmlspecialchars(stripslashes($HTTP_POST_VARS[$abq_config['postvariablename']]));
			$abq_id = htmlspecialchars($HTTP_POST_VARS['idabq']);
			$AntwortPruefenJN = 1;
		}
	}
	elseif ($AufrufWoher == 'R')
	{
		global $idabq, $mode, $phpEx, $user_lang;

		if (($user_lang == '') || ((preg_match('/^[a-z_]+$/i', $user_lang)) && (!file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . htmlspecialchars($user_lang) . '/lang_main.'.$phpEx)))))
		{
			message_die(CRITICAL_ERROR, 'Could not locate valid language pack<br />' . $phpbb_root_path . 'language/lang_' . htmlspecialchars($user_lang) . '/lang_main.'.$phpEx . '<br />'. __FILE__ . __LINE__);
		}

		if (($mode == 'register') && ($abq_config['abq_register']))
		{
			$abq_aw = htmlspecialchars(stripslashes($abq_aw));
			$abq_id = htmlspecialchars($idabq);
			$AntwortPruefenJN = 1;
		}
	}

	if ($AntwortPruefenJN == 1)
	{
		if (empty($abq_aw))
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['ABQ_F_Incorrect'];
		}
		elseif (preg_match('/[^a-z0-9]/i', $abq_id))
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['ABQ_F_Incorrect'];
		}
		else
		{
			$sql = 'SELECT answer 
				FROM ' . ANTI_BOT_QUEST_CONFIRM_TABLE . ' 
				WHERE confirm_id = \'' . $abq_id . '\' 
					AND session_id = \'' . $userdata['session_id'] . '\'';
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain anti bot question answer', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				if (substr($row['answer'],0,1) == '_')
				{
					$sql = 'SELECT answer1, answer2, answer3, answer4, answer5
						FROM ' . ANTI_BOT_QUEST_TABLE . '
						WHERE id = ' . substr($row['answer'],1);
					if(!$result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not obtain anti bot question answer', '', __LINE__, __FILE__, $sql);
					}
					if( $db->sql_numrows($result) == 0 )
					{
						$sql = 'SELECT answer1, answer2, answer3, answer4, answer5 
							FROM ' . ANTI_BOT_QUEST_TABLE . '
							WHERE lang = \'' . $board_config['default_lang'] . '\' 
							LIMIT 1';
						if(!$result = $db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not obtain anti bot question answer', '', __LINE__, __FILE__, $sql);
						}
						if( $db->sql_numrows($result) == 0 )
						{
							// Keine Frage vorhanden > Anti-Bot-Question übergehen
						}
						else
						{
							$error = TRUE;
							$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['ABQ_F_Incorrect'];
						}
					}
					else
					{
						$abqrow = $db->sql_fetchrow($result);
						if ($abq_config['ef_casesensitive'])
						{
							if (($abq_aw == $abqrow['answer1']) || (($abqrow['answer2'] != '') && ($abq_aw == $abqrow['answer2'])) || (($abqrow['answer3'] != '') && ($abq_aw == $abqrow['answer3'])) || (($abqrow['answer4'] != '') && ($abq_aw == $abqrow['answer4'])) || (($abqrow['answer5'] != '') && ($abq_aw == $abqrow['answer5'])))
							{}
							else
							{
								$error = TRUE;
								$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['ABQ_F_Incorrect'];
							}
						}
						else
						{
							$abq_aw = strtolower($abq_aw);
							if (($abq_aw == strtolower($abqrow['answer1'])) || (($abqrow['answer2'] != '') && ($abq_aw == strtolower($abqrow['answer2']))) || (($abqrow['answer3'] != '') && ($abq_aw == strtolower($abqrow['answer3']))) || (($abqrow['answer4'] != '') && ($abq_aw == strtolower($abqrow['answer4']))) || (($abqrow['answer5'] != '') && ($abq_aw == strtolower($abqrow['answer5']))))
							{}
							else
							{
								$error = TRUE;
								$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['ABQ_F_Incorrect'];
							}
						}
					}
				}
				elseif ($row['answer'] != $abq_aw)
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['ABQ_F_Incorrect'];
				}
				else
				{
					$sql = 'DELETE FROM ' . ANTI_BOT_QUEST_CONFIRM_TABLE . ' 
						WHERE confirm_id = \'' . $abq_id . '\' 
							AND session_id = \'' . $userdata['session_id'] . '\'';
					if (!$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not delete anti bot question answer', __LINE__, __FILE__, $sql);
					}
				}
			}
			else
			{		
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['ABQ_F_Incorrect'];
			}
			$db->sql_freeresult($result);
		}
	}
}

function RechenaufgabeErstellen(&$Rechenaufgabe, &$Loesung, &$RA_AstronomischeZahlen)
{
	global $abq_config;

	mt_srand((double)microtime()*1411410);
	$RTyp = mt_rand(1, 10);
	if ($RTyp == 1)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(500, 75000);
			$Obergrenze = 99999 - $Zahl1;
			$Zahl2 = mt_rand(500, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(10, 50);
			$Untergrenze = 100 - $Zahl1;
			$Zahl2 = mt_rand($Untergrenze, 150);
		}
		$Rechenaufgabe = $Zahl1 . '+' . $Zahl2;
		$Loesung = $Zahl1 + $Zahl2;
	}
	elseif ($RTyp == 2)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(500, 50000);
			$Obergrenze = 99000 - $Zahl1;
			$Zahl2 = mt_rand(150, $Obergrenze);
			$Obergrenze = 99999 - ($Zahl1 + $Zahl2);
			$Zahl3 = mt_rand(350, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(10, 50);
			$Zahl2 = mt_rand(25, 75);
			$Untergrenze = 100 - ($Zahl1 + $Zahl2);
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Zahl3 = mt_rand($Untergrenze, 100);
		}
		$Rechenaufgabe = $Zahl1 . '+' . $Zahl2 . '+' . $Zahl3;
		$Loesung = $Zahl1 + $Zahl2 + $Zahl3;
	}
	elseif ($RTyp == 3)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(1100, 1600000);
			$Untergrenze = $Zahl1 - 999999;
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = $Zahl1 - 4000;
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(111, 250);
			$Obergrenze = $Zahl1 - 100;
			$Zahl2 = mt_rand(5, $Obergrenze);
		}
		$Rechenaufgabe = $Zahl1 . '-' . $Zahl2;
		$Loesung = $Zahl1 - $Zahl2;
	}
	elseif ($RTyp == 4)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(12000, 2000000);
			$Untergrenze = $Zahl1 - 1400000;
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = $Zahl1 - 5000;
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
			$Untergrenze = ($Zahl1 - $Zahl2) - 999999;
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = ($Zahl1 - $Zahl2) - 1500;
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(250, 300);
			$Zahl2 = mt_rand(25, 100);
			$Obergrenze = ($Zahl1 - $Zahl2) - 100;
			$Zahl3 = mt_rand(1, $Obergrenze);
		}
		$Rechenaufgabe = $Zahl1 . '-' . $Zahl2 . '-' . $Zahl3;
		$Loesung = $Zahl1 - $Zahl2 - $Zahl3;
	}
	elseif ($RTyp == 5)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(5000, 999995);
			$Zahl2 = mt_rand(1500, 900300);
			$Untergrenze = ($Zahl1 + $Zahl2) - 999999;
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = ($Zahl1 + $Zahl2) - 1490;
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(75, 150);
			$Zahl2 = mt_rand(50, 100);
			$Obergrenze = ($Zahl1 + $Zahl2) - 100;
			$Zahl3 = mt_rand(5, $Obergrenze);
		}
		$Rechenaufgabe = $Zahl1 . '+' . $Zahl2 . '-' . $Zahl3;
		$Loesung = $Zahl1 + $Zahl2 - $Zahl3;
	}
	elseif ($RTyp == 6)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(1, 250);
			$Untergrenze = ceil(2000/$Zahl1);
			$Obergrenze = floor(999999/$Zahl1);
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(2, 50);
			$Untergrenze = ceil(100/$Zahl1);
			$Obergrenze = floor(300/$Zahl1);
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
		}
		$Rechenaufgabe = $Zahl1 . $abq_config['af_malzeichen'] . $Zahl2;
		$Loesung = $Zahl1 * $Zahl2;
	}
	elseif ($RTyp == 7)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(1, 250);
			$Untergrenze = ceil(2000/$Zahl1);
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = floor(999000/$Zahl1);
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
			$Obergrenze = 999999 - ($Zahl1 * $Zahl2);
			if ($Obergrenze < 2)
			{
				$Obergrenze = 2;
			}
			$Zahl3 = mt_rand(1, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(2, 50);
			$Untergrenze = ceil(100/$Zahl1);
			$Obergrenze = floor(300/$Zahl1);
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
			$Obergrenze = 350 - ($Zahl1 * $Zahl2);
			$Zahl3 = mt_rand(1, $Obergrenze);
		}
		$Rechenaufgabe = '(' . $Zahl1 . $abq_config['af_malzeichen'] . $Zahl2 . ')+' . $Zahl3;
		$Loesung = ($Zahl1 * $Zahl2) + $Zahl3;
	}
	elseif ($RTyp == 8)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(1, 500);
			$Untergrenze = ceil(10000/$Zahl1);
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = floor(1500000/$Zahl1);
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
			$Untergrenze = ($Zahl1 * $Zahl2) - 999999;
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = ($Zahl1 * $Zahl2) - 9000;
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(2, 50);
			$Untergrenze = ceil(200/$Zahl1);
			$Obergrenze = floor(350/$Zahl1);
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
			$Obergrenze = ($Zahl1 * $Zahl2) - 100;
			$Zahl3 = mt_rand(1, $Obergrenze);
		}
		$Rechenaufgabe = '(' . $Zahl1 . $abq_config['af_malzeichen'] . $Zahl2 . ')-' . $Zahl3;
		$Loesung = ($Zahl1 * $Zahl2) - $Zahl3;
	}
	elseif ($RTyp == 9)
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(1, 250);
			$Obergrenze = 500 - $Zahl1;
			$Zahl2 = mt_rand(1, $Obergrenze);
			$Untergrenze = ceil(3450/($Zahl1+$Zahl2));
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = floor(999990/($Zahl1+$Zahl2));
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(2, 25);
			$Zahl2 = mt_rand(1, 25);
			$Untergrenze = ceil(100/($Zahl1+$Zahl2));
			$Obergrenze = floor(350/($Zahl1+$Zahl2));
			$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		}
		$Rechenaufgabe = '(' . $Zahl1 . '+' . $Zahl2 . ') ' . $abq_config['af_malzeichen'] . ' ' . $Zahl3;
		$Loesung = ($Zahl1 + $Zahl2) * $Zahl3;
	}
	else
	{
		if ($RA_AstronomischeZahlen)
		{
			$Zahl1 = mt_rand(25000, 450000);
			$Untergrenze = $Zahl1 - 449905;
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = $Zahl1 - 20000;
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
			$Untergrenze = ceil(4500/($Zahl1-$Zahl2));
			if ($Untergrenze < 1)
			{
				$Untergrenze = 1;
			}
			$Obergrenze = floor(999990/($Zahl1-$Zahl2));
			if ($Obergrenze <= $Untergrenze)
			{
				$Obergrenze = $Untergrenze + 1;
			}
			$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		}
		else
		{
			$Zahl1 = mt_rand(100, 250);
			$Untergrenze = $Zahl1 - 50;
			$Obergrenze = $Zahl1 - 2;
			$Zahl2 = mt_rand($Untergrenze, $Obergrenze);
			$Untergrenze = ceil(100/($Zahl1-$Zahl2));
			$Obergrenze = floor(350/($Zahl1-$Zahl2));
			$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		}
		$Rechenaufgabe = '(' . $Zahl1 . '-' . $Zahl2 . ') ' . $abq_config['af_malzeichen'] . ' ' . $Zahl3;
		$Loesung = ($Zahl1 - $Zahl2) * $Zahl3;
	}
	$Rechenaufgabe .= '=?';
}

function ZeichenfolgeErstellen($WelcherIndex)
{
	$input = dss_rand();
	$input = base_convert($input, 16, 10);
	if ($WelcherIndex == 'a')
	{
		// eigentlich müsste noch geprüft werden, ob das kleine x vorhanden ist, da es sich aber vom großen X nicht unterscheiden muss, ist es egal, unter der Annahme, dass das kleine x im Zeichensatz vorhanden ist, wenn das große X sowie die anderen Kleinbuchstaben vorhanden sind
		$index = 'abdefghjmnpqrtyABDEFGHJMNPQRTUVWXYZ';
	}
	elseif ($WelcherIndex == '#')
	{
		$index = '%=+*()/:;.,!?';
	}
	else
	{
		$index = '123456789';
	}
	$base = strlen($index);
	$output = '';
	for ($i=floor(log10($input)/log10($base)); $i >= 0; $i--)
	{
		$j = floor($input / pow($base, $i));
		$output .= substr($index, $j, 1);
		$input = $input - ($j * pow($base, $i));
	}
	return $output;
}

function ChaosZeichenfolge(&$quest_line1, &$quest_line2, &$confirm_answer)
{
	mt_srand((double)microtime()*1241240);
	$input = dss_rand();
	$input = base_convert($input, 16, 10);
	$index = 'abdefghjmnpqrtyABDEFGHJMNPQRTUVWXYZ123456789';
	$base = strlen($index);
	$output = '';
	for ($i=floor(log10($input)/log10($base)); $i>=0; $i--)
	{
		$j = floor($input / pow($base, $i));
		$output .= substr($index, $j, 1);
		$input = $input - ($j * pow($base, $i));
	}
	$SLaenge = mt_rand(6, 8);
	$output = substr($output, 0, $SLaenge);
	for ($j=strlen($output); $j<$SLaenge; $j++)
	{
		$output .= 'A';
	}
	$confirm_answer = $output;
	$outputarr = array();
	for ($i=0; $i<$SLaenge; $i++)
	{
		$outputarr[$i] = ($i+1) . substr($output, $i, 1);
	}
	shuffle($outputarr);
	for ($i=0; $i<$SLaenge; $i++)
	{
		$quest_line1 .= substr($outputarr[$i], 1, 1) . ' ';
		$quest_line2 .= substr($outputarr[$i], 0, 1) . ' ';
	}
	$quest_line1 = trim($quest_line1);
	$quest_line2 = trim($quest_line2);
}

function ZeichenfolgeRechenaufgabeErstellen()
{
	global $abq_config;

	mt_srand((double)microtime()*1411410);
	$RTyp = mt_rand(1, 6);
	if ($RTyp == 1)
	{
		$Zahl1 = mt_rand(111, 9999);
		$Zahl2 = mt_rand(111, 9999);
		$output = $Zahl1 . '+' . $Zahl2;
	}
	elseif ($RTyp == 2)
	{
		$Zahl1 = mt_rand(1, 999);
		$Zahl2 = mt_rand(1, 999);
		$ZahlLen = strlen($Zahl1.$Zahl2);
		$ZahlLen = 7 - $ZahlLen;
		$Untergrenze = 1;
		$Obergrenze = 99;
		if ($ZahlLen > 1)
		{
			for ($i=0; $i<$ZahlLen; $i++)
			{
				$Untergrenze = $Untergrenze * 10;
				$Obergrenze = ($Obergrenze * 10) + 9;
			}
		}
		$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		$output = $Zahl1 . '+' . $Zahl2 . '+' . $Zahl3;
	}
	elseif ($RTyp == 3)
	{
		$Zahl1 = mt_rand(111, 9999);
		$Zahl2 = mt_rand(111, 9999);
		if ($Zahl1 > $Zahl2)
		{
			$output = $Zahl1 . '-' . $Zahl2;
		}
		else
		{
			$output = $Zahl2 . '-' . $Zahl1;
		}
	}
	elseif ($RTyp == 4)
	{
		$Zahl1 = mt_rand(1000, 9999);
		$Zahl2 = mt_rand(1, 99);
		$ZahlLen = strlen($Zahl1.$Zahl2);
		$ZahlLen = 7 - $ZahlLen;
		$Untergrenze = 1;
		$Obergrenze = 99;
		if ($ZahlLen > 1)
		{
			for ($i=0; $i<$ZahlLen; $i++)
			{
				$Untergrenze = $Untergrenze * 10;
				$Obergrenze = ($Obergrenze * 10) + 9;
			}
		}
		$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		$output = $Zahl1 . '-' . $Zahl2 . '-' . $Zahl3;
	}
	elseif ($RTyp == 5)
	{
		$Zahl1 = mt_rand(10, 999);
		$Zahl2 = mt_rand(100, 999);
		$ZahlLen = strlen($Zahl1.$Zahl2);
		$ZahlLen = 7 - $ZahlLen;
		$Untergrenze = 1;
		$Obergrenze = 99;
		if ($ZahlLen > 1)
		{
			for ($i=0; $i<$ZahlLen; $i++)
			{
				$Untergrenze = $Untergrenze * 10;
				$Obergrenze = ($Obergrenze * 10) + 9;
			}
		}
		$Zahl3 = mt_rand($Untergrenze, $Obergrenze);
		if ($Zahl1 > $Zahl3)
		{
			$output = $Zahl1 . '+' . $Zahl2 . '-' . $Zahl3;
		}
		else
		{
			$output = $Zahl3 . '+' . $Zahl2 . '-' . $Zahl1;
		}
	}
	else
	{
		$Zahl1 = mt_rand(111, 9999);
		$Zahl2 = mt_rand(111, 9999);
		$output = $Zahl1 . $abq_config['af_malzeichen'] . $Zahl2;
	}
	$output = preg_replace('/0/i', '1', $output);
	$output .= '=?';
	return $output;
}

function ABQAutoAntworten($AArt=1, &$AntwortSelectArray, $AVarLen=0)
{
	global $abq_config;

	unset($i);
	if (($AArt == 1) || ($AArt == 2))
	{
		if ($AArt == 2)
		{
			$index = 'abdefghjmnpqrtyABDEFGHJMNPQRTUVWXYZ123456789';
		}
		else
		{
			$index = 'abdefghjmnpqrtyABDEFGHJMNPQRTUVWXYZ';
		}
		for ($i=1; $i<11; $i++)
		{
			unset($input);
			$input = dss_rand();
			$input = base_convert($input, 16, 10);
			$base = strlen($index);
			$output = '';
			for ($j=floor(log10($input)/log10($base)); $j>=0; $j--)
			{
				$k = floor($input / pow($base, $j));
				$output .= substr($index, $k, 1);
				$input = $input - ($k * pow($base, $j));
			}
			$SLaenge = mt_rand(6, 8);
			$AntwortSelectArray[$i] = substr($output, 0, $SLaenge);
			if ($AntwortSelectArray[0] == $AntwortSelectArray[$i])
			{
				$AntwortSelectArray[$i] .= 'a';
			}
		}
	}
	else
	{
		if ($AArt == 4)
		{
			$Untergrenze = 101;
			if ($abq_config['af_grossezahlen'] == 0)
			{
				$Obergrenze = 350;
			}
			else
			{
				$Obergrenze = 999999;
			}
		}
		else
		{
			if (($AVarLen >= 4) && ($AVarLen <= 9))
			{
				$Untergrenze = pow(10,($AVarLen-1));
				$Obergrenze = preg_replace('/[0-9]/is', '9', $Untergrenze);
			}
			else
			{
				$Untergrenze = 12121;
				$Obergrenze = 99999999;
			}
		}
		for ($i=1; $i<11; $i++)
		{
			$AntwortSelectArray[$i] = mt_rand($Untergrenze, $Obergrenze);
			unset($j);
			for ($j=0; $j<$i; $j++)
			{
				if ($AntwortSelectArray[$j] == $AntwortSelectArray[$i])
				{
					$AntwortSelectArray[$i]++;
					$j = 0;
				}
			}
		}
	}

	return;
}

// ABQ_gdVersion(): Gibt die Version der GD-Bibliothek wieder und ob Freetype unterstützt wird.
// basiert auf: http://de3.php.net/manual/en/function.gd-info.php#52481 von Hagan Fox
function ABQ_gdVersion()
{
	global $FTL_JN, $GDL_JN;
	$FTL_JN = 0;
	$GDL_JN = 0;

	if (!extension_loaded('gd'))
	{
		return;
	}

	if (function_exists('imagettftext'))
	{
		$FTL_JN = 1;
	}

	// If phpinfo() is enabled use it
	if (!preg_match('/phpinfo/', ini_get('disable_functions')))
	{
		ob_start();
		phpinfo();
		$ABQ_phpinfo = ob_get_contents();
		ob_end_clean();
		if ((preg_match('/--with-freetype-dir=yes/is', $ABQ_phpinfo)) && ($FTL_JN == 1))
		{}
		else
		{
			$FTL_JN = 0;
		}
		$info = stristr($ABQ_phpinfo, 'gd version');
		preg_match('/\d/', $info, $match);
		$GDL_JN = $match[0];

		return;
	}

	// Use the gd_info() function if possible.
	if (function_exists('gd_info'))
	{
		$ver_info = gd_info();
		preg_match('/\d/', $ver_info['GD Version'], $match);
		$GDL_JN = $match[0];
		if (($ver_info['FreeType Support']) && (strtolower($ver_info['FreeType Linkage']) == 'with freetype') && ($FTL_JN == 1))
		{}
		else
		{
			$FTL_JN = 0;
		}
		return;
	}

	return;
}
// End gdVersion()
?>