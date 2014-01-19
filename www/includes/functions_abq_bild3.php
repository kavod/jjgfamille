<?php
/***************************************************************************
 *                          functions_abq_bild3
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

function BildAnzeigen($SchriftID)
{
	global $abq_config, $FTL_JN, $GDL_JN, $phpbb_root_path;

	$SchriftID--;

	$ABQConf_BildJPG = intval($abq_config['imagetype']);
	$ABQConf_BildQualitaet = intval($abq_config['jpgquality']);
	$ABQConf_BGText = intval($abq_config['afeff_bgtext']);
	$ABQConf_SchriftGroesse = intval($abq_config['fontsize']);
	$Color_BG_R1 = intval($abq_config['Color_BG_R1']);
	$Color_BG_R2 = intval($abq_config['Color_BG_R2']);
	$Color_BG_G1 = intval($abq_config['Color_BG_G1']);
	$Color_BG_G2 = intval($abq_config['Color_BG_G2']);
	$Color_BG_B1 = intval($abq_config['Color_BG_B1']);
	$Color_BG_B2 = intval($abq_config['Color_BG_B2']);

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
	$ABQConf_SchriftGroesse -= 6;

	$Schriften = array();
	$Schriften_AAnzahl = 0;
	if ($Schriftverzeichnis = @opendir($phpbb_root_path.'abq_mod/fonts/'))
	{
		while (true == ($Dateien = @readdir($Schriftverzeichnis)))
		{
			if ((substr(strtolower($Dateien), -4) == '.ttf'))
			{
				$Schriften[] = $Dateien;
			}
		}
		closedir($Schriftverzeichnis);
		sort($Schriften);
		$Schriften_AAnzahl = count($Schriften);
	}

	$FTL_JN = 0;
	$GDL_JN = 0;
	ABQ_gdVersion();

	if ((count($Schriften_AAnzahl) > 0) && ($SchriftID >= 0) && ($SchriftID < $Schriften_AAnzahl))
	{
		if (!$FTL_JN)
		{
			exit;
		}
	}
	else
	{
		exit;
	}

	if ($GDL_JN >= 1)
	{
	}
	else
	{
		exit;
	}

	$Schrift = $phpbb_root_path . 'abq_mod/fonts/' . $Schriften[$SchriftID];
	$Zeile1 = 'a b d e f g h j m n p q r t y';
	$Zeile2 = 'A B D E F G H J M N P Q R T U V W X Y Z';
	$Zeile3 = '1 2 3 4 5 6 7 8 9 0';
	$Zeile4 = '% = + * ( ) / : ; . , ! ?';
	unset ($i);
	for ($i=1; $i<=4; $i++)
	{
		${'BildhoeheZeile'.$i} = 0;
		${'BildbreiteZeile'.$i} = 0;
		unset($ZeilenGroesse);
		$ZeilenGroesse = imagettfbbox($ABQConf_SchriftGroesse, 0, $Schrift, ${'Zeile'.$i});
		${'BildbreiteZeile'.$i} = abs($ZeilenGroesse[2]);
		${'BildhoeheZeile'.$i} = abs($ZeilenGroesse[5]);

		${'BildZeileBasis'.$i} = ${'BildhoeheZeile'.$i} + $Zeilenabstand;

		if ($i > 1)
		{
			${'BildZeileBasis'.$i} += ${'BildZeileBasis'.($i-1)};
		}
	}
	$Bild_Breite = 0;
	$Bild_Hoehe = 0;
	unset ($i);
	for ($i=1; $i<=4; $i++)
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
	$F_BGSchriftfarbe = imagecolorallocate($Bild, mt_rand($Color_BGText_R1, $Color_BGText_R2), mt_rand($Color_BGText_G1, $Color_BGText_G2), mt_rand($Color_BGText_B1, $Color_BGText_B2));
	$ZeichenFarbe = $F_BGSchriftfarbe;

	unset($i);
	for ($i=1; $i<=4; $i++)
	{
		imagettftext($Bild, $ABQConf_SchriftGroesse, 0, 10, ${'BildZeileBasis'.$i}, $ZeichenFarbe, $Schrift, ${'Zeile'.$i});
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