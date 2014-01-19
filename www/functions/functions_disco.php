<?
function template_singles($tab_albums)
{
	global $phpbb_root_path,$lang;
	
	//On compte le nombre de jaquettes par single pour pouvoir mettre un lien "autres jaquettes" s'il y en a plusieurs
	$val_count = select_element("SELECT COUNT(*)  FROM disco_jacks WHERE album_id = ".$tab_albums['album_id']." ORDER BY ordre",'',false);
		if($val_count[0]>1)
		{
			$l_other = "d'autres jaquettes";
		}
	
	//Selection d'une jaquette	
	$val_jack = select_element("SELECT * FROM disco_jacks WHERE album_id = ".$tab_albums['album_id']." ORDER BY ordre LIMIT 0,1",'',false);
		
		$ext = find_image('../images/disco/jack_' . $tab_albums['album_id'].'_'.$val_jack['jack_id'].'.');
		if (is_file('../images/disco/jack_' . $tab_albums['album_id'].'_'.$val_jack['jack_id'].'.'.$ext))
		{
			$img = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $tab_albums['album_id'] . '&jack_id='. $val_jack['jack_id'];
			$size = getimagesize('../images/disco/jack_' . $tab_albums['album_id'].'_'.$val_jack['jack_id'].'.'.$ext);
	
				if($val_jacks['comment'] == "")
				{
					$height = $size[1]+20;
				}
				else
				{
					$height = $size[1]+100;		
				}
			
			$onclick = "window.open('jaquette.php?jack_id=".$val_jack['jack_id']."','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";

			$img = '<a href="#" onclick="'.$onclick.'"><img src="'.$img.'" alt="Agrandir la jaquette" border="0"></a>';
		}else
		{	
			$img = '<img src="' .$phpbb_root_path . 'functions/miniature.php?mode=nojack" alt="Pas de jaquette disonible" border="0" >';
		}
	
	//Selection de l'artiste
	$val_artist = select_element("SELECT * FROM disco_artists WHERE artist_id = ".$tab_albums['artist_id']."",'',false);

		if($val_artist['artist_id']!=1)
		{
			$artist = $val_artist['name'];
		}

	//Disponibilité en cd ,k7 ect....
	$dispo = $lang['Disponible']."&nbsp;".$lang['en']."&nbsp;";

  		if ($tab_albums['CD']==Y) { $dispo .= "CD, "; }
  		if ($tab_albums['K7']==Y) { $dispo .= "Cassette audio, "; }
  		if ($tab_albums['33T']==Y) { $dispo .= "Vinyle 33 Tours, "; }
  		if ($tab_albums['CD2T']==Y) { $dispo .= "CD single, "; }
  		if ($tab_albums['K72T']==Y) { $dispo .= "K7 2 titres, "; }
  		if ($tab_albums['45T']==Y) { $dispo .= "45 tours, "; }
  		if ($tab_albums['M45T']==Y) { $dispo .= "Maxi 45 tours, "; }
  		if ($tab_albums['HC']==Y) { $dispo .= "<b>Hors Commerce</b>"; } 

	//commentaires sur le disque
	if($tab_albums['comment'] != "")
		{
			$anoter = $lang['a_noter']."&nbsp;:";
			$l_anoter = bbencode_second_pass($tab_albums["comment"],$tab_albums["bbcode_uid"]);
		}
	
	return array(
		'PHOTO' => $img,
		"TITLE" => $tab_albums['title'],
		"QUI" => $artist,
		"QUAND" => substr($tab_albums['date'],0,4),
		"L_OTHER" => $l_other,
		"U_OTHER" => append_sid($phpbb_root_path . 'disco/jaquettes.php?album_id='.$tab_albums['album_id']),
		"DISPO" => $dispo,
		"ANOTER" => $anoter,
		"L_ANOTER" => $l_anoter,
		);
}

function template_titres($tab_titres)
{
	global $phpbb_root_path,$lang;
	
	//commentaires sur le disque
	if($tab_titres['comment'] != "")
		{
			$anoter = "<br><u>".$lang['a_noter'].":</u>";
			$l_anoter = bbencode_second_pass($tab_titres["comment"],$tab_titres["bbcode_uid"]);
		}
	//Durée
	if ($tab_titres['duree'] != "") 
		{
			$duree="<i>(".str_replace("\\'","'",$tab_titres['duree']).")</i>";
		}
	
	return array(
		"L_TITLE" => $tab_titres['title'],
		"U_TITLE" => append_sid($phpbb_root_path . 'disco/view_song.php?song_id='.$tab_titres['song_id']),
		"ANOTER" => $anoter,
		"L_ANOTER" => $l_anoter,
		"DUREE" => $duree,
		);
}

function sql_select($table='famille', $where="",$order="",$desc="",$nom)
{
	global $$val,$val;
	if ($where != "")
	{$where = "WHERE ".$where; }
	if ($order != "")
	{$order = "ORDER BY ".$order; }
	
	$sql = "sql_".$nom;
	$result = "result_".$nom;
	$val = "val_".$nom;	
	$$sql = "SELECT * FROM $table $where $order";
	if ($desc != "")
	{ $$sql .= " DESC"; }
	$$result = mysql_query($$sql);
	return (mysql_fetch_array($$result));
}

//Reprise
// Boris 27/02/2006 : Gestion des medleys/reprises
function select_reprises($song_id)
{
	//echo (int)$song_id;
	if (((int)$song_id)>0)
	{
		$sql = "SELECT song. *
			FROM `disco_songs` song
			LEFT JOIN `disco_medley` medley 
			ON medley.`medley_id` = song.`song_id`
			WHERE (
				song.`reprise_id` = '$song_id'
				) OR (
				medley.`song_id` = '$song_id'
				)";
		//echo $sql;
		return select_liste($sql);
	}
	return array();
}
// Fin Boris 27/02/2006
?>