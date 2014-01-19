<?
function template_emission($tab_en_vedette,$large=true)
{
	global $phpbb_root_path,$lang;
	//On cherche les informations du support
	$val_support = select_element("SELECT * FROM media_supports WHERE support_id=".$tab_en_vedette['support_id']." ");
	
	switch($val_support['media_type'])
	{
		case 'TV':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/tv.png" border="0" alt="'.$lang['emission_tv'].'" title="'.$lang['emission_tv'].'"';
			if (!$large) $icon_support .= ' width="15" height="15"';
			$icon_support .= ' />';
			$type = 'emission';
			break;
		case 'Radio':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/radio.png" border="0" alt="'.$lang['emission_radio'].'" title="'.$lang['emission_radio'].'"';
			if (!$large) $icon_support .= ' width="15" height="15"';
			$icon_support .= ' />';
			$type = 'emission';
			break;
		case 'Presse':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/journal.png" border="0" alt="'.$lang['article_presse'].'" title="'.$lang['article_presse'].'"';
			if (!$large) $icon_support .= ' width="15" height="15"';
			$icon_support .= ' />';
			$type = 'article';
			break;
		case 'Internet':
			$icon_support = '<img src="' . $phpbb_root_path . 'images/internet.png" border="0" alt="'.$lang['article_internet'].'" title="'.$lang['article_internet'].'"';
			if (!$large) $icon_support .= ' width="15" height="15"';
			$icon_support .= ' />';
			$type = 'article';
			break;
		case 'Autre':
			$type = 'article';
		default:
			$icon_support = '';
	}
	
	//Si Illustrations il y a on affiche une image 
	$val_illus = select_element("SELECT COUNT(*) FROM media_illustrations WHERE emission_id = ".$tab_en_vedette['emission_id']." ");
	if ($val_illus[0] != 0 )
		$illu = '<img src="' . $phpbb_root_path . 'images/picture.gif" border="0" alt="'.$val_illus[0].' illustrations disponibles">';
	
	//Si Retranscriptions il y a on affiche une image 
	$val_retranscription = select_element("SELECT COUNT(*) FROM media_retranscriptions WHERE emission_id = ".$tab_en_vedette['emission_id']." ");
	if ($val_retranscription[0] != 0 )
		$retranscription = '<img src="' . $phpbb_root_path . 'images/texte.gif" border="0" alt="'.$val_retranscription[0].' retranscriptions / extraits disponibles">';
	
	//Si Audios il y a on affiche une image 
	$val_audio = select_element("SELECT COUNT(*) FROM media_audio WHERE emission_id = ".$tab_en_vedette['emission_id']." ");
	if ($val_audio[0] != 0 )
		$audio = '<img src="' . $phpbb_root_path . 'images/real.gif" border="0" alt="'.$val_audio[0].' extrait(s) audio disponible(s)"">';
		
	// Y a t'il une heure
		if($tab_en_vedette['heure']<>"")
			$heure = "à <b>".$tab_en_vedette['heure']."</b>";
	
	//Date americain => francais
		$date = "<b>".affiche_date($tab_en_vedette['date'])."</b>";
	
	return array(
		//'U_TITLE' =>append_sid($phpbb_root_path . "medias/view_emission.php?emission_id=".$tab_en_vedette['emission_id']),
		'U_TITLE' => append_sid($phpbb_root_path . "medias/" . $type . "-" . str_replace('&amp;url_title=','',add_title_in_url($val_support['support_name'] . '-' . $tab_en_vedette['title'])). '-' . $tab_en_vedette['emission_id'] . '.html'),
		'L_TITLE' => $tab_en_vedette['title'],
		'DESCRIPTION' => bbencode_second_pass($tab_en_vedette['description'],$tab_en_vedette['bbcode_uid']),
		'HEURE' => $heure,
		'DATE' => sprintf($lang['le'],$date),
		'L_SUPPORT' => $val_support['support_name'],
		//'U_SUPPORT' => append_sid("support.php?support_id=".$val_support['support_id'].""),
		'U_SUPPORT' => append_sid($phpbb_root_path . 'medias/goldman-dans-' . str_replace('&amp;url_title=','',add_title_in_url($val_support['support_name'])) . '-' . $val_support['support_id'] . '.html'),
		'ILLU' => $illu,
		'RETRANSCRIPTION' => $retranscription,
		'AUDIO' => $audio,
		'ICON_SUPPORT' => $icon_support
		);
}

function template_concerts($tab_concerts)
{
	global $phpbb_root_path,$lang;
	
	//Si recits il y a on affiche une image 
	$val_recits = select_element("SELECT COUNT(*) FROM tournee_recits WHERE concert_id = ".$tab_concerts['concert_id']." ");
	if ($val_recits[0] != 0 )
		$recits = '<img src="' . $phpbb_root_path . 'images/texte.gif" border="0" alt="Des récits ont été associés à ce concert">';
	
	//Si recits il y a on affiche une image 
	$val_photos = select_element("SELECT COUNT(*) FROM tournee_photos WHERE concert_id = ".$tab_concerts['concert_id']." ");
	if ($val_photos[0] != 0 )
		$photos = '<img src="' . $phpbb_root_path . 'images/photo.gif" border="0" alt="Des photographies ont été associés à ce concert">';
	
	return array(
		'L_TITRE' => affiche_date($tab_concerts['date'])."&nbsp;".sprintf($lang[à],$tab_concerts['lieu']),
		'U_TITRE' => append_sid("concerts.php?concert_id=".$tab_concerts['concert_id'].""),
		'RECIT' => $recits,
		'PHOTO' => $photos,
		);
}
?>