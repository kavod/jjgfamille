<?php
/***************************************************************************
 *                          functions_abq_bild2
 *                          -------------------
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

function BildAnzeigen($Zeile1, $Zeile2, $Zeile3, $Zeile4, $Farbe)
{
	global $abq_config, $FTL_JN, $GDL_JN, $phpbb_root_path;

	mt_srand((double)microtime()*2123435);

	if (($Farbe != 'G') && ($Farbe != 'R'))
	{
		$Farbe = '';
	}

	$ABQConf_BildJPG = intval($abq_config['imagetype']);
	$ABQConf_BildQualitaet = intval($abq_config['jpgquality']);
	$ABQConf_MaxEffekte = intval($abq_config['afeff_max']);
	$ABQConf_GridW = intval($abq_config['afeff_gridw']);
	$ABQConf_GridH = intval($abq_config['afeff_gridh']);
	$ABQConf_Trennlinien = intval($abq_config['afeff_trennlinie']);
	$ABQConf_BGText = intval($abq_config['afeff_bgtext']);
	$ABQConf_Grid = intval($abq_config['afeff_grid']);
	$ABQConf_GridF = intval($abq_config['afeff_gridf']);
	$ABQConf_Ellipsen = intval($abq_config['afeff_ellipsen']);
	$ABQConf_Boegen = intval($abq_config['afeff_boegen']);
	$ABQConf_Linien = intval($abq_config['afeff_linien']);
	$ABQConf_SchriftGroesse = intval($abq_config['fontsize']);
	$Color_BG_R1 = intval($abq_config['Color_BG_R1']);
	$Color_BG_R2 = intval($abq_config['Color_BG_R2']);
	$Color_BG_G1 = intval($abq_config['Color_BG_G1']);
	$Color_BG_G2 = intval($abq_config['Color_BG_G2']);
	$Color_BG_B1 = intval($abq_config['Color_BG_B1']);
	$Color_BG_B2 = intval($abq_config['Color_BG_B2']);
	$Color_F1_R = intval($abq_config['Color_F1_R']);
	$Color_F1_G = intval($abq_config['Color_F1_G']);
	$Color_F1_B = intval($abq_config['Color_F1_B']);
	$Color_F2_R = intval($abq_config['Color_F2_R']);
	$Color_F2_G = intval($abq_config['Color_F2_G']);
	$Color_F2_B = intval($abq_config['Color_F2_B']);
	$Color_Grid1_R1 = intval($abq_config['Color_Grid1_R1']);
	$Color_Grid1_R2 = intval($abq_config['Color_Grid1_R2']);
	$Color_Grid1_G1 = intval($abq_config['Color_Grid1_G1']);
	$Color_Grid1_G2 = intval($abq_config['Color_Grid1_G2']);
	$Color_Grid1_B1 = intval($abq_config['Color_Grid1_B1']);
	$Color_Grid1_B2 = intval($abq_config['Color_Grid1_B2']);
	$Color_Grid2_R1 = intval($abq_config['Color_Grid2_R1']);
	$Color_Grid2_R2 = intval($abq_config['Color_Grid2_R2']);
	$Color_Grid2_G1 = intval($abq_config['Color_Grid2_G1']);
	$Color_Grid2_G2 = intval($abq_config['Color_Grid2_G2']);
	$Color_Grid2_B1 = intval($abq_config['Color_Grid2_B1']);
	$Color_Grid2_B2 = intval($abq_config['Color_Grid2_B2']);
	$Color_Grid3_R1 = intval($abq_config['Color_Grid3_R1']);
	$Color_Grid3_R2 = intval($abq_config['Color_Grid3_R2']);
	$Color_Grid3_G1 = intval($abq_config['Color_Grid3_G1']);
	$Color_Grid3_G2 = intval($abq_config['Color_Grid3_G2']);
	$Color_Grid3_B1 = intval($abq_config['Color_Grid3_B1']);
	$Color_Grid3_B2 = intval($abq_config['Color_Grid3_B2']);
	$Color_Grid4_R1 = intval($abq_config['Color_Grid4_R1']);
	$Color_Grid4_R2 = intval($abq_config['Color_Grid4_R2']);
	$Color_Grid4_G1 = intval($abq_config['Color_Grid4_G1']);
	$Color_Grid4_G2 = intval($abq_config['Color_Grid4_G2']);
	$Color_Grid4_B1 = intval($abq_config['Color_Grid4_B1']);
	$Color_Grid4_B2 = intval($abq_config['Color_Grid4_B2']);
	$Color_GridF_R1 = intval($abq_config['Color_GridF_R1']);
	$Color_GridF_R2 = intval($abq_config['Color_GridF_R2']);
	$Color_GridF_G1 = intval($abq_config['Color_GridF_G1']);
	$Color_GridF_G2 = intval($abq_config['Color_GridF_G2']);
	$Color_GridF_B1 = intval($abq_config['Color_GridF_B1']);
	$Color_GridF_B2 = intval($abq_config['Color_GridF_B2']);
	$Color_Ellipsen_R1 = intval($abq_config['Color_Ellipsen_R1']);
	$Color_Ellipsen_R2 = intval($abq_config['Color_Ellipsen_R2']);
	$Color_Ellipsen_G1 = intval($abq_config['Color_Ellipsen_G1']);
	$Color_Ellipsen_G2 = intval($abq_config['Color_Ellipsen_G2']);
	$Color_Ellipsen_B1 = intval($abq_config['Color_Ellipsen_B1']);
	$Color_Ellipsen_B2 = intval($abq_config['Color_Ellipsen_B2']);
	$Color_TEllipsen_R1 = intval($abq_config['Color_TEllipsen_R1']);
	$Color_TEllipsen_R2 = intval($abq_config['Color_TEllipsen_R2']);
	$Color_TEllipsen_G1 = intval($abq_config['Color_TEllipsen_G1']);
	$Color_TEllipsen_G2 = intval($abq_config['Color_TEllipsen_G2']);
	$Color_TEllipsen_B1 = intval($abq_config['Color_TEllipsen_B1']);
	$Color_TEllipsen_B2 = intval($abq_config['Color_TEllipsen_B2']);
	$Color_Lines_R1 = intval($abq_config['Color_Lines_R1']);
	$Color_Lines_R2 = intval($abq_config['Color_Lines_R2']);
	$Color_Lines_G1 = intval($abq_config['Color_Lines_G1']);
	$Color_Lines_G2 = intval($abq_config['Color_Lines_G2']);
	$Color_Lines_B1 = intval($abq_config['Color_Lines_B1']);
	$Color_Lines_B2 = intval($abq_config['Color_Lines_B2']);
	$Color_Arcs_R1 = intval($abq_config['Color_Arcs_R1']);
	$Color_Arcs_R2 = intval($abq_config['Color_Arcs_R2']);
	$Color_Arcs_G1 = intval($abq_config['Color_Arcs_G1']);
	$Color_Arcs_G2 = intval($abq_config['Color_Arcs_G2']);
	$Color_Arcs_B1 = intval($abq_config['Color_Arcs_B1']);
	$Color_Arcs_B2 = intval($abq_config['Color_Arcs_B2']);
	$Color_BGText_R1 = intval($abq_config['Color_BGText_R1']);
	$Color_BGText_R2 = intval($abq_config['Color_BGText_R2']);
	$Color_BGText_G1 = intval($abq_config['Color_BGText_G1']);
	$Color_BGText_G2 = intval($abq_config['Color_BGText_G2']);
	$Color_BGText_B1 = intval($abq_config['Color_BGText_B1']);
	$Color_BGText_B2 = intval($abq_config['Color_BGText_B2']);
	$Color_Text_R1 = intval($abq_config['Color_Text_R1']);
	$Color_Text_R2 = intval($abq_config['Color_Text_R2']);
	$Color_Text_G1 = intval($abq_config['Color_Text_G1']);
	$Color_Text_G2 = intval($abq_config['Color_Text_G2']);
	$Color_Text_B1 = intval($abq_config['Color_Text_B1']);
	$Color_Text_B2 = intval($abq_config['Color_Text_B2']);
	$Color_SLines_R1 = intval($abq_config['Color_SLines_R1']);
	$Color_SLines_R2 = intval($abq_config['Color_SLines_R2']);
	$Color_SLines_G1 = intval($abq_config['Color_SLines_G1']);
	$Color_SLines_G2 = intval($abq_config['Color_SLines_G2']);
	$Color_SLines_B1 = intval($abq_config['Color_SLines_B1']);
	$Color_SLines_B2 = intval($abq_config['Color_SLines_B2']);

	$aktiveEffekte = 0;
	if ($ABQConf_BGText == 1)
	{
		$aktiveEffekte++;
	}
	if ($ABQConf_Grid == 1)
	{
		$aktiveEffekte++;
	}
	if ($ABQConf_Ellipsen == 1)
	{
		$aktiveEffekte++;
	}
	if ($ABQConf_Boegen == 1)
	{
		$aktiveEffekte++;
	}
	if ($ABQConf_Linien == 1)
	{
		$aktiveEffekte++;
	}

	if ($ABQConf_BGText == 2)
	{
		if (($ABQConf_MaxEffekte == 0) || ($ABQConf_MaxEffekte > $aktiveEffekte))
		{
			$ABQConf_BGText = mt_rand(0, 1);
			if ($ABQConf_MaxEffekte != 0)
			{
				$aktiveEffekte += $ABQConf_BGText;
			}
		}
		else
		{
			$ABQConf_BGText = 0;
		}
	}
	if ($ABQConf_Grid == 2)
	{
		if (($ABQConf_MaxEffekte == 0) || ($ABQConf_MaxEffekte > $aktiveEffekte))
		{
			$ABQConf_Grid = mt_rand(0, 1);
			if ($ABQConf_MaxEffekte != 0)
			{
				$aktiveEffekte += $ABQConf_Grid;
			}
		}
		else
		{
			$ABQConf_Grid = 0;
		}
	}
	if ($ABQConf_GridF == 2)
	{
		$ABQConf_GridF = mt_rand(0, 1);
	}
	if ($ABQConf_Ellipsen == 2)
	{
		if (($ABQConf_MaxEffekte == 0) || ($ABQConf_MaxEffekte > $aktiveEffekte))
		{
			$ABQConf_Ellipsen = mt_rand(0, 1);
			if ($ABQConf_MaxEffekte != 0)
			{
				$aktiveEffekte += $ABQConf_Ellipsen;
			}
		}
		else
		{
			$ABQConf_Ellipsen = 0;
		}
	}
	if ($ABQConf_Boegen == 2)
	{
		if (($ABQConf_MaxEffekte == 0) || ($ABQConf_MaxEffekte > $aktiveEffekte))
		{
			$ABQConf_Boegen = mt_rand(0, 1);
			if ($ABQConf_MaxEffekte != 0)
			{
				$aktiveEffekte += $ABQConf_Boegen;
			}
		}
		else
		{
			$ABQConf_Boegen = 0;
		}
	}
	if ($ABQConf_Linien == 2)
	{
		if (($ABQConf_MaxEffekte == 0) || ($ABQConf_MaxEffekte > $aktiveEffekte))
		{
			$ABQConf_Linien = mt_rand(0, 1);
			if ($ABQConf_MaxEffekte != 0)
			{
				$aktiveEffekte += $ABQConf_Linien;
			}
		}
		else
		{
			$ABQConf_Linien = 0;
		}
	}

	if ($ABQConf_GridW == 0)
	{
		$ABQConf_GridW = mt_rand(10, 90);
	}
	if ($ABQConf_GridH == 0)
	{
		$ABQConf_GridH = mt_rand(10, 40);
	}

	if ($ABQConf_BildJPG)
	{
		$mimeTyp = 'image/jpeg';
		if (($ABQConf_BildQualitaet < 50) || ($ABQConf_BildQualitaet > 90))
		{
			$ABQConf_BildQualitaet = 80;
		}
	}
	else
	{
		$mimeTyp = 'image/png';
	}

	$phpbb_root_path = str_replace('index.'.$phpEx, '', realpath($phpbb_root_path.'index.'.$phpEx));

	$Zeilenabstand = 10;
	$BildMinBreite = 25;
	$BildMinHoehe = 10;

	if (($ABQConf_SchriftGroesse < 15) || ($ABQConf_SchriftGroesse > 40))
	{
		$ABQConf_SchriftGroesse = 20;
	}

	$AnzahlDerZeilen = 0;
	for ($i=1; $i<5; $i++)
	{
		if (${'Zeile'.$i} != '')
		{
			$AnzahlDerZeilen++;
			unset($j);
			unset($k);
			$k = strlen(${'Zeile'.$i});
			for ($j=0; $j<$k; $j++)
			{
				${'ZeileZ'.$i}[$j]['Zeichen'] = ${'Zeile'.$i}{$j};
			}
		}
		else
		{
			break;
		}
	}

	if ($AnzahlDerZeilen < 1)
	{
		exit;
	}
	elseif ($AnzahlDerZeilen == 1)
	{
		$Zeile2 = '';
		$Zeile3 = '';
		$Zeile4 = '';
	}
	elseif ($AnzahlDerZeilen == 2)
	{
		$Zeile3 = '';
		$Zeile4 = '';
	}
	elseif ($AnzahlDerZeilen == 3)
	{
		$Zeile4 = '';
	}

	$Schriften = array();
	$Schriften_AAnzahl = 0;
	if ($Schriftverzeichnis = @opendir($phpbb_root_path.'abq_mod/fonts/'))
	{
		while (true == ($Dateien = @readdir($Schriftverzeichnis)))
		{
			if ((substr(strtolower($Dateien), -4) == '.ttf'))
			{
				$Schriften[] = $phpbb_root_path . 'abq_mod/fonts/' . $Dateien;
			}
		}
		closedir($Schriftverzeichnis);
		$Schriften_AAnzahl = count($Schriften) - 1;
	}

	$FTL_JN = 0;
	$GDL_JN = 0;
	ABQ_gdVersion();

	if ($FTL_JN)
	{
		if ($Zeile4 != '')
		{
			$ABQConf_SchriftGroesse -= 6;
		}
		elseif ($Zeile3 != '')
		{
			$ABQConf_SchriftGroesse -= 4;
		}
		elseif ($Zeile2 != '')
		{
			$ABQConf_SchriftGroesse -= 2;
		}
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			if ((!empty(${'ZeileZ'.$i})) && (is_array(${'ZeileZ'.$i})))
			{
				unset($j);
				unset($k);
				unset($l);
				$k = count(${'ZeileZ'.$i});
				$l = 0;
				for ($j=0; $j<$k; $j++)
				{
					if (($Farbe != '') && (${'ZeileZ'.$i}[$j]['Zeichen'] == '+'))
					{
						$j++;
						if ($j >= $k)
						{
							break;
						}
						${'ZeileA'.$i}[$l]['Farbe'] = $Farbe;
					}
					else
					{
						${'ZeileA'.$i}[$l]['Farbe'] = '';
					}
					${'ZeileA'.$i}[$l]['Zeichen'] = ${'ZeileZ'.$i}[$j]['Zeichen'];
					${'ZeileA'.$i}[$l]['Schrift'] = $Schriften[rand(0, $Schriften_AAnzahl)];
					${'ZeileA'.$i}[$l]['Groesse'] = $ABQConf_SchriftGroesse + mt_rand(-1, 1);
					${'ZeileA'.$i}[$l]['Winkel'] = mt_rand(-20, 20);
					${'ZeileA'.$i}[$l]['AbweichungX'] = 0;
					if (abs(${'ZeileA'.$i}[$l]['Winkel']) > 5)
					{
						${'ZeileA'.$i}[$l]['AbweichungX'] += 3;
					}
					elseif (abs(${'ZeileA'.$i}[$l]['Winkel']) > 15)
					{
						${'ZeileA'.$i}[$l]['AbweichungX'] += 6;
					}
					${'ZeileA'.$i}[$l]['AbweichungX'] += 5 + mt_rand(-2, 7);
					${'ZeileA'.$i}[$l]['AbweichungY'] = mt_rand(-9, 10);
					$l++;
				}
				unset(${'ZeileZ'.$i});
			}
		}
	}
	else
	{
		$ABQConf_SchriftGroesse = 5;
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			${'BildbreiteZeile'.$i} = 0;
			unset($j);
			unset($k);
			unset($l);
			$k = count(${'ZeileZ'.$i});
			$l = 0;
			for ($j=0; $j<$k; $j++)
			{
				if (($Farbe != '') && (${'ZeileZ'.$i}[$j]['Zeichen'] == '+'))
				{
					$j++;
					if ($j >= $k)
					{
						break;
					}
					${'ZeileA'.$i}[$l]['Farbe'] = $Farbe;
				}
				else
				{
					${'ZeileA'.$i}[$l]['Farbe'] = '';
				}
				${'ZeileA'.$i}[$l]['Zeichen'] = ${'ZeileZ'.$i}[$j]['Zeichen'];
				${'ZeileA'.$i}[$l]['ExtraabstandX'] = mt_rand(1, 3);
				${'ZeileA'.$i}[$l]['ExtraabstandY'] = mt_rand(-5, 5);
				${'BildbreiteZeile'.$i} += ${'ZeileA'.$i}[$l]['ExtraabstandX'];
				$l++;
			}
			unset(${'ZeileZ'.$i});
		}
	}

	if ($FTL_JN)
	{
		unset ($i);
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			${'BildhoeheZeile'.$i} = 0;
			${'BildbreiteZeile'.$i} = 0;
			${'BildZeileBasis'.$i} = 0;
			if ((!empty(${'ZeileA'.$i})) && (is_array(${'ZeileA'.$i})))
			{
				unset($j);
				unset($k);
				$k = count(${'ZeileA'.$i});
				for ($j=0; $j<$k; $j++)
				{
					unset($ZeichenGroesse);
					$ZeichenGroesse = imagettfbbox(${'ZeileA'.$i}[$j]['Groesse'], ${'ZeileA'.$i}[$j]['Winkel'], ${'ZeileA'.$i}[$j]['Schrift'], ${'ZeileA'.$i}[$j]['Zeichen']);
					$ZeichenHoehe = abs($ZeichenGroesse[5]);
					if (${'BildhoeheZeile'.$i} < $ZeichenHoehe)
					{
						${'BildhoeheZeile'.$i} = $ZeichenHoehe;
					}
					${'BildbreiteZeile'.$i} += ${'ZeileA'.$i}[$j]['AbweichungX'] + $ZeichenGroesse[2];
					${'ZeileA'.$i}[$j]['Zeichenbreite'] = $ZeichenGroesse[2];
				}
				${'BildZeileBasis'.$i} = ${'BildhoeheZeile'.$i} + 9;
				${'BildhoeheZeile'.$i} += 20;
			}
		}
		$Bild_Breite = 0;
		$Bild_Hoehe = 0;
		unset ($i);
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			if (${'BildhoeheZeile'.$i} > 0)
			{
				if (${'BildbreiteZeile'.$i} > $Bild_Breite)
				{
					$Bild_Breite = ${'BildbreiteZeile'.$i};
				}
				if ($Bild_Hoehe > 0)
				{
					$Bild_Hoehe += $Zeilenabstand;
				}
				$Bild_Hoehe += ${'BildhoeheZeile'.$i};
			}
		}
	}
	else
	{
		$Schrift_Breite = imagefontwidth($ABQConf_SchriftGroesse);
		$Schrift_Hoehe = imagefontheight($ABQConf_SchriftGroesse);
		$Bild_Breite = 0;
		$Bild_Hoehe = 0;
		unset ($i);
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			if (((strlen(${'Zeile'.$i}) * $Schrift_Breite) + ${'BildbreiteZeile'.$i}) > $Bild_Breite)
			{
				$Bild_Breite = (strlen(${'Zeile'.$i}) * $Schrift_Breite) + ${'BildbreiteZeile'.$i};
			}
			if ($Bild_Hoehe > 0)
			{
				$Bild_Hoehe += $Zeilenabstand;
			}
			${'BildZeileBasis'.$i} = $Bild_Hoehe + 5;
			$Bild_Hoehe += $Schrift_Hoehe + 10;
		}
	}
 	$Bild_Hoehe += (2 * $Zeilenabstand);
	$Bild_Breite += 20;

	if ($Bild_Breite < $BildMinBreite)
	{
		$Bild_Breite = $BildMinBreite;
	}
	if ($Bild_Hoehe < $BildMinHoehe)
	{
		$Bild_Hoehe = $BildMinHoehe;
	}

	$Bild = ($GDL_JN >= 2) ? imagecreatetruecolor($Bild_Breite, $Bild_Hoehe) : imagecreate($Bild_Breite, $Bild_Hoehe);
	$Bild_Backgroundcolor = imagecolorallocate($Bild, mt_rand($Color_BG_R1, $Color_BG_R2), mt_rand($Color_BG_G1, $Color_BG_G2), mt_rand($Color_BG_B1, $Color_BG_B2));
	imagefill($Bild, 0, 0, $Bild_Backgroundcolor);
	$F_Farbe1 = imagecolorallocate($Bild, $Color_F1_R, $Color_F1_G, $Color_F1_B);
	$F_Farbe2 = imagecolorallocate($Bild, $Color_F2_R, $Color_F2_G, $Color_F2_B);

	if ($ABQConf_Grid)
	{
		if ($ABQConf_GridW < 10)
		{
			$ABQConf_GridW = 10;
		}
		elseif ($ABQConf_GridW > 100)
		{
			$ABQConf_GridW = 100;
		}
		if ($ABQConf_GridH < 10)
		{
			$ABQConf_GridH = 10;
		}
		elseif ($ABQConf_GridH > 50)
		{
			$ABQConf_GridH = 50;
		}
		unset($i);
		unset($j);
		$GridWert = 0;
		$j = ceil($Bild_Breite / $ABQConf_GridW);
		for ($i=0; $i<$j; $i++)
		{
			$k = mt_rand(1, 4);
			if ($k == 1)
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid1_R1, $Color_Grid1_R2), mt_rand($Color_Grid1_G1, $Color_Grid1_G2), mt_rand($Color_Grid1_B1, $Color_Grid1_B2));
			}
			elseif ($k == 2)
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid2_R1, $Color_Grid2_R2), mt_rand($Color_Grid2_G1, $Color_Grid2_G2), mt_rand($Color_Grid2_B1, $Color_Grid2_B2));
			}
			elseif ($k == 3)
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid3_R1, $Color_Grid3_R2), mt_rand($Color_Grid3_G1, $Color_Grid3_G2), mt_rand($Color_Grid3_B1, $Color_Grid3_B2));
			}
			else
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid4_R1, $Color_Grid4_R2), mt_rand($Color_Grid4_G1, $Color_Grid4_G2), mt_rand($Color_Grid4_B1, $Color_Grid4_B2));
			}
			imageline($Bild, $GridWert, 0, $GridWert, $Bild_Hoehe, $F_Gridfarbe);
			$GridWert += $ABQConf_GridW;
		}
		unset($i);
		unset($j);
		$GridWert = 0;
		$j = ceil($Bild_Hoehe / $ABQConf_GridH);
		for ($i=0; $i<$j; $i++)
		{
			$WelcheFarbe = mt_rand(1, 4);
			if ($WelcheFarbe == 1)
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid1_R1, $Color_Grid1_R2), mt_rand($Color_Grid1_G1, $Color_Grid1_G2), mt_rand($Color_Grid1_B1, $Color_Grid1_B2));
			}
			elseif ($WelcheFarbe == 2)
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid2_R1, $Color_Grid2_R2), mt_rand($Color_Grid2_G1, $Color_Grid2_G2), mt_rand($Color_Grid2_B1, $Color_Grid2_B2));
			}
			elseif ($WelcheFarbe == 3)
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid3_R1, $Color_Grid3_R2), mt_rand($Color_Grid3_G1, $Color_Grid3_G2), mt_rand($Color_Grid3_B1, $Color_Grid3_B2));
			}
			else
			{
				$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_Grid4_R1, $Color_Grid4_R2), mt_rand($Color_Grid4_G1, $Color_Grid4_G2), mt_rand($Color_Grid4_B1, $Color_Grid4_B2));
			}
			imageline($Bild, 0, $GridWert, $Bild_Breite, $GridWert, $F_Gridfarbe);
			$GridWert += $ABQConf_GridH;
		}
		if ($ABQConf_GridF)
		{
			unset($i);
			unset($j);
			unset($k);
			unset($l);
			$l = ceil($Bild_Breite / $ABQConf_GridW);
			$j = ceil($Bild_Hoehe / $ABQConf_GridH);
			$GridWertY = 1;
			for ($i=0; $i<$j; $i++)
			{
				$GridWertX = 1;
				for ($k=0; $k<$l; $k++)
				{
					$F_Gridfarbe = imagecolorallocate($Bild, mt_rand($Color_GridF_R1, $Color_GridF_R2), mt_rand($Color_GridF_G1, $Color_GridF_G2), mt_rand($Color_GridF_B1, $Color_GridF_B2));
					imagefill($Bild, $GridWertX, $GridWertY, $F_Gridfarbe);
					$GridWertX += $ABQConf_GridW;
				}
				$GridWertY += $ABQConf_GridH;
			}
		}
	}

	if ($ABQConf_Ellipsen)
	{
		$EllipsenAnzahl = mt_rand(15, 25);
		$TEllipsenAnzahl = mt_rand(15, 25);
		$Ellipsen_MaxX = $Bild_Breite - 3;
		$Ellipsen_MinX = 3;
		$Ellipsen_MaxY = $Bild_Hoehe - 3;
		$Ellipsen_MinY = 3;
		$Ellipsen_MaxBreite = ceil($Bild_Breite / 6);
		$Ellipsen_MinBreite = 3;
		if ($Ellipsen_MinBreite > $Ellipsen_MaxBreite)
		{
			$Ellipsen_MinBreite = 0;
		}
		$Ellipsen_MaxHoehe = ceil($Bild_Hoehe / 6);
		$Ellipsen_MinHoehe = 3;
		if ($Ellipsen_MinHoehe > $Ellipsen_MaxHoehe)
		{
			$Ellipsen_MinHoehe = 0;
		}
		unset($i);
		for ($i=0; $i<$EllipsenAnzahl; $i++)
		{
			$F_Ellipsenfarbe = imagecolorallocate($Bild, mt_rand($Color_Ellipsen_R1, $Color_Ellipsen_R2), mt_rand($Color_Ellipsen_G1, $Color_Ellipsen_G2), mt_rand($Color_Ellipsen_B1, $Color_Ellipsen_B2));
			imagefilledellipse($Bild, mt_rand($Ellipsen_MinX, $Ellipsen_MaxX), mt_rand($Ellipsen_MinY, $Ellipsen_MaxY), mt_rand($Ellipsen_MinBreite, $Ellipsen_MaxBreite), mt_rand($Ellipsen_MinHoehe, $Ellipsen_MaxHoehe), $F_Ellipsenfarbe);	
		}
		unset($i);
		for ($i=0; $i<$TEllipsenAnzahl; $i++)
		{
			$Ellipse_OefS = mt_rand(0, 350);
			$Ellipse_OefG = mt_rand(45, 315);
			$Ellipse_OefE = $Ellipse_OefS + $Ellipse_OefG;
			if ($Ellipse_OefE > 360)
			{
				$Ellipse_OefE -= 360;
			}
			$F_Ellipsenfarbe = imagecolorallocate($Bild, mt_rand($Color_TEllipsen_R1, $Color_TEllipsen_R2), mt_rand($Color_TEllipsen_G1, $Color_TEllipsen_G2), mt_rand($Color_TEllipsen_B1, $Color_TEllipsen_B2));
			imagefilledarc ($Bild, mt_rand($Ellipsen_MinX, $Ellipsen_MaxX), mt_rand($Ellipsen_MinY, $Ellipsen_MaxY), mt_rand($Ellipsen_MinBreite, $Ellipsen_MaxBreite), mt_rand($Ellipsen_MinHoehe, $Ellipsen_MaxHoehe), $Ellipse_OefS, $Ellipse_OefE, $F_Ellipsenfarbe, IMG_ARC_EDGED);
		}
	}

	if ($ABQConf_Linien)
	{
		$LinienAnzahl = mt_rand(20, 60);
		$Linien_X1Min = 0;
		$Linien_X1Max = ceil($Bild_Breite * 0.45);
		$Linien_Y1Min = 0;
		$Linien_Y1Max = $Bild_Hoehe - 1;
		$Linien_X2Min = ceil($Bild_Breite * 0.55);
		$Linien_X2Max = $Bild_Breite;
		$Linien_Y2Min = 1;
		$Linien_Y2Max = $Bild_Hoehe;
		unset($i);
		for ($i=0; $i<$LinienAnzahl; $i++)
		{
			$F_Linie = imagecolorallocate($Bild, mt_rand($Color_Lines_R1, $Color_Lines_R2), mt_rand($Color_Lines_G1, $Color_Lines_G2), mt_rand($Color_Lines_B1, $Color_Lines_B2));
			imageline($Bild, mt_rand($Linien_X1Min, $Linien_X1Max), mt_rand($Linien_Y1Min, $Linien_Y1Max), mt_rand($Linien_X2Min, $Linien_X2Max), mt_rand($Linien_Y2Min, $Linien_Y2Max), $F_Linie);
		}
	}

	if ($ABQConf_Boegen)
	{
		$LEllipsenAnzahl = mt_rand(25, 35);
		$Ellipsen_MaxX = $Bild_Breite - 3;
		$Ellipsen_MinX = 3;
		$Ellipsen_MaxY = $Bild_Hoehe - 3;
		$Ellipsen_MinY = 3;
		$Ellipsen_MaxBreite = ceil($Bild_Breite / 2);
		$Ellipsen_MinBreite = 3;
		if ($Ellipsen_MinBreite > $Ellipsen_MaxBreite)
		{
			$Ellipsen_MinBreite = 0;
		}
		$Ellipsen_MaxHoehe = ceil($Bild_Hoehe / 1.5);
		$Ellipsen_MinHoehe = 3;
		if ($Ellipsen_MinHoehe > $Ellipsen_MaxHoehe)
		{
			$Ellipsen_MinHoehe = 0;
		}
		unset($i);
		for ($i=0; $i<$LEllipsenAnzahl; $i++)
		{
			$F_Ellipsenfarbe = imagecolorallocate($Bild, mt_rand($Color_Arcs_R1, $Color_Arcs_R2), mt_rand($Color_Arcs_G1, $Color_Arcs_G2), mt_rand($Color_Arcs_B1, $Color_Arcs_B2));
			$Ellipse_X = mt_rand(0, $Ellipsen_MaxX);
			$Ellipse_Y = mt_rand(0, $Ellipsen_MaxY);
			$Ellipse_B = mt_rand($Ellipsen_MinBreite, $Ellipsen_MaxBreite);
			$Ellipse_H = mt_rand($Ellipsen_MinHoehe, $Ellipsen_MaxHoehe);
			$Ellipse_D = mt_rand(0, 5);
			imagearc($Bild, $Ellipse_X, $Ellipse_Y, $Ellipse_B, $Ellipse_H, mt_rand(0, 190), mt_rand(191, 360), $F_Ellipsenfarbe);
			if ($Ellipse_D > 0)
			{
				unset($j);
				for ($j=1; $j<=$Ellipse_D; $j++)
				{
					imagearc($Bild, ($Ellipse_X + $j), ($Ellipse_Y + $j), ($Ellipse_B - $j), ($Ellipse_H - $j), mt_rand(0, 190), mt_rand(191, 360), $F_Ellipsenfarbe);
				}
			}
		}
	}

	if ($ABQConf_BGText)
	{
		unset($i);
		$BGZeichenanzahl = 0;
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			if (count(${'ZeileA'.$i}) > $BGZeichenanzahl)
			{
				$BGZeichenanzahl = count(${'ZeileA'.$i});
			}
		}
		if ($BGZeichenanzahl > 0)
		{
			if ($FTL_JN)
			{
				$Textzeile = $BildZeileBasis1 / 2;
				unset($i);
				for ($i=0; $i<=$AnzahlDerZeilen; $i++)
				{
					$PositionLetztesX = 0;
					if ($i > 0)
					{
						$Textzeile += ${'BildZeileBasis'.$i} + $Zeilenabstand;
					}
					unset($j);
					for ($j=0; $j<$BGZeichenanzahl; $j++)
					{
						$BGT_Schrift = $Schriften[rand(0, $Schriften_AAnzahl)];
						$BGT_Groesse = $ABQConf_SchriftGroesse + mt_rand(-1, 1);
						$BGT_Winkel = mt_rand(-20, 20);
						$PositionX = 0;
						if ($BGT_Winkel > 5)
						{
							$PositionX += 3;
						}
						elseif ($BGT_Winkel > 15)
						{
							$PositionX += 6;
						}
						$PositionX += $PositionLetztesX + 5 + mt_rand(-2, 7);
						$PositionY = $Textzeile + mt_rand(-9, 10);
						$F_BGSchriftfarbe = imagecolorallocate($Bild, mt_rand($Color_BGText_R1, $Color_BGText_R2), mt_rand($Color_BGText_G1, $Color_BGText_G2), mt_rand($Color_BGText_B1, $Color_BGText_B2));
						$ZeichenFarbe = $F_BGSchriftfarbe;
						$BGT_Zeichen = mt_rand(0, 61);
						if ($BGT_Zeichen < 10)
						{}
						elseif ($BGT_Zeichen > 35)
						{
							$BGT_Zeichen = chr($BGT_Zeichen+61);
						}
						else
						{
							$BGT_Zeichen = chr($BGT_Zeichen+55);
						}


						$BGT_ZeichenGroesse = imagettfbbox($BGT_Groesse, $BGT_Winkel, $BGT_Schrift, $BGT_Zeichen);
						$BGT_Zeichenbreite = $BGT_ZeichenGroesse[2];

						imagettftext($Bild, $BGT_Groesse, $BGT_Winkel, $PositionX, $PositionY, $ZeichenFarbe, $BGT_Schrift, $BGT_Zeichen);
						$PositionLetztesX = $PositionX + $BGT_Zeichenbreite;
					}
					$Textzeile += 11;
				}
			}
			else
			{
				$Textzeile = -($Zeilenabstand / 2);
				unset($i);
				for ($i=0; $i<=$AnzahlDerZeilen; $i++)
				{
					$PositionLetztesX = 0;
					if ($i > 0)
					{
						$Textzeile += $Schrift_Hoehe + 10 + $Zeilenabstand;
					}
					unset($j);
					for ($j=0; $j<$BGZeichenanzahl; $j++)
					{
						$PositionX = $PositionLetztesX + mt_rand(1, 3);
						$PositionY = $Textzeile + mt_rand(-5, 5);
						$F_BGSchriftfarbe = imagecolorallocate($Bild, mt_rand($Color_BGText_R1, $Color_BGText_R2), mt_rand($Color_BGText_G1, $Color_BGText_G2), mt_rand($Color_BGText_B1, $Color_BGText_B2));
						$ZeichenFarbe = $F_BGSchriftfarbe;
						$BGT_Zeichen = mt_rand(0, 61);
						if ($BGT_Zeichen < 10)
						{}
						elseif ($BGT_Zeichen > 35)
						{
							$BGT_Zeichen = chr($BGT_Zeichen+61);
						}
						else
						{
							$BGT_Zeichen = chr($BGT_Zeichen+55);
						}

						imagestring($Bild, $ABQConf_SchriftGroesse, $PositionX, $PositionY, $BGT_Zeichen, $ZeichenFarbe);

						$PositionLetztesX = $PositionX + $Schrift_Breite;
					}
				}

			}
		}
	}

	$Textzeile = $Zeilenabstand;
	if ($FTL_JN)
	{
		unset($i);
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			$PositionLetztesX = 10;
			unset($k);
			$k = count(${'ZeileA'.$i});
			if ($k > 0)
			{
				if ($Textzeile != $Zeilenabstand)
				{
					$Textzeile += $Zeilenabstand;
				}
				$Textzeile += ${'BildZeileBasis'.$i};
				unset($j);
				for ($j=0; $j<$k; $j++)
				{
					$PositionX = $PositionLetztesX + ${'ZeileA'.$i}[$j]['AbweichungX'];
					$PositionY = $Textzeile + ${'ZeileA'.$i}[$j]['AbweichungY'];
					if (${'ZeileA'.$i}[$j]['Farbe'] == 'R')
					{
						$ZeichenFarbe = $F_Farbe1;
					}
					elseif (${'ZeileA'.$i}[$j]['Farbe'] == 'G')
					{
						$ZeichenFarbe = $F_Farbe2;
					}
					else
					{
						$ZeichenFarbe = imagecolorallocate($Bild, mt_rand($Color_Text_R1, $Color_Text_R2), mt_rand($Color_Text_G1, $Color_Text_G2), mt_rand($Color_Text_B1, $Color_Text_B2));
					}
					imagettftext($Bild, ${'ZeileA'.$i}[$j]['Groesse'], ${'ZeileA'.$i}[$j]['Winkel'], $PositionX, $PositionY, $ZeichenFarbe, ${'ZeileA'.$i}[$j]['Schrift'], ${'ZeileA'.$i}[$j]['Zeichen']);
					$PositionLetztesX = $PositionX + ${'ZeileA'.$i}[$j]['Zeichenbreite'];
				}
				$Textzeile += 11;
				${'ZeileY'.$i} = $Textzeile + floor($Zeilenabstand/2);
			}
		}
	}
	else
	{
		$Textzeile += 2;
		unset($i);
		for ($i=1; $i<=$AnzahlDerZeilen; $i++)
		{
			unset($k);
			$k = count(${'ZeileA'.$i});
			if ($k > 0)
			{
				$PositionX = 10;
				unset($j);
				for ($j=0; $j<$k; $j++)
				{
					if (${'ZeileA'.$i}[$j]['Farbe'] == 'R')
					{
						$ZeichenFarbe = $F_Farbe1;
					}
					elseif (${'ZeileA'.$i}[$j]['Farbe'] == 'G')
					{
						$ZeichenFarbe = $F_Farbe2;
					}
					else
					{
						$ZeichenFarbe = imagecolorallocate($Bild, mt_rand($Color_Text_R1, $Color_Text_R2), mt_rand($Color_Text_G1, $Color_Text_G2), mt_rand($Color_Text_B1, $Color_Text_B2));
					}
					$PositionY = $Textzeile + ${'ZeileA'.$i}[$j]['ExtraabstandY'];
					imagestring($Bild, $ABQConf_SchriftGroesse, $PositionX, $PositionY, ${'ZeileA'.$i}[$j]['Zeichen'], $ZeichenFarbe);
					$PositionX += $Schrift_Breite + ${'ZeileA'.$i}[$j]['ExtraabstandX'];
				}
				$Textzeile += $Schrift_Hoehe + 10 + $Zeilenabstand;
				${'ZeileY'.$i} = $Textzeile - floor($Zeilenabstand/2);
			}
		}
	}

	if (($ABQConf_Trennlinien) && ($AnzahlDerZeilen > 1))
	{
		$LinienGrundwert = floor($Bild_Breite/8);
		unset($i);
		for ($i=1; $i<$AnzahlDerZeilen; $i++)
		{
			if ((${'ZeileY'.$i} > 0) && (${'ZeileY'.$i} < $Bild_Hoehe))
			{
				$LinienStartX1 = floor(($LinienGrundwert * mt_rand(5, 15)) / 10);
				$LinienStartX2 = floor(($LinienGrundwert * mt_rand(25, 35)) / 10);
				$LinienStartX3 = floor(($LinienGrundwert * mt_rand(45, 55)) / 10);
				$LinienStartX4 = floor(($LinienGrundwert * mt_rand(65, 75)) / 10);
				$F_Trennungslinie = imagecolorallocate($Bild, mt_rand($Color_SLines_R1, $Color_SLines_R2), mt_rand($Color_SLines_G1, $Color_SLines_G2), mt_rand($Color_SLines_B1, $Color_SLines_B2));
				imageline($Bild, $LinienStartX1, ${'ZeileY'.$i}, $LinienStartX2, ${'ZeileY'.$i}, $F_Trennungslinie);
				$F_Trennungslinie = imagecolorallocate($Bild, mt_rand($Color_SLines_R1, $Color_SLines_R2), mt_rand($Color_SLines_G1, $Color_SLines_G2), mt_rand($Color_SLines_B1, $Color_SLines_B2));
				imageline($Bild, $LinienStartX3, ${'ZeileY'.$i}, $LinienStartX4, ${'ZeileY'.$i}, $F_Trennungslinie);
			}
		}
	}

	header("Content-Type: $mimeTyp");
	header("Expires: Mon, 20 Jul 1995 05:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");

	($mimeTyp == 'image/png') ? imagepng($Bild) : imagejpeg($Bild, '', $ABQConf_BildQualitaet);
	imagedestroy($Bild);
}
?>