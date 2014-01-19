<?
function supp_asso($id,&$error,&$error_msg)
{
	global $phpbb_root_path,$ftp_server,$ftp_user_name,$ftp_user_pass;
	$val_asso = select_element("SELECT B.title \"song\",B.dataname, C.title \"album\" FROM disco_songs_albums A, disco_songs B,disco_albums C WHERE A.id = '$id' AND A.song_id = B.song_id AND A.album_id = C.album_id",true,"association introuvable");
	
	// Suppression des partitions
	$file = $phpbb_root_path . 'textes/disco/' . $val_asso['dataname'] . '_' . $id . '.txt';
	if (is_file($file))
		unlink($file);
	
	// Suppression des GuitarPro
	$file = $phpbb_root_path . 'audio/disco/' . $val_asso['dataname'] . '_' . $id . '.gp3';
	if (is_file($file))
		unlink($file);
		
	// Suppression des Midis
	$file = $phpbb_root_path . 'audio/disco/midi_' . $id . '.mid';
	if (is_file($file))
		unlink($file);
	
	$conn_id = ftp_connect($ftp_server); 
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	$file = "disco/extrait_".$id.".rm";
	$delete = @ftp_delete($conn_id, $file);
	ftp_close($conn_id);
	$file = $phpbb_root_path . 'audio/disco/extrait_' . $id . '.ram';
	if (is_file($file))
		unlink($file);
	
	if (!$error)
		mysql_query("DELETE FROM disco_songs_albums WHERE id = '$id'") or list($error,$error_msg) = array(true,"association introuvable");
	
	if (!$error)
	{
		logger("Suppression de l'association " . $val_asso['album'] . " / " . $val_asso['song']);
	}
}

function supp_jack($id,$album_id,&$error,&$error_msg)
{
	global $phpbb_root_path;
	$filename = $phpbb_root_path . "images/disco/jack_" . $album_id . "_" . $id . ".";
	$extension = find_image($filename);
	$filename .= $extension;
	
	mysql_query("DELETE FROM disco_jacks WHERE jack_id = '$id'") or list($error,$error_msg) = array(true,"Illustration introuvable");
	
	if (unlink($filename))
	{
		logger("Suppression de la jaquette N°$jack_id de l'album N°$album_id");
	} else
	{
		$error=true;
		$error_msg .= 'Erreur durant la suppression de la jaquette';
		logger("BUG : Impossible de supprimer $filename");
	}
}
?>