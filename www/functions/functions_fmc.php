<?php

/**
 * Retourne l'extention d'un fichier . apres le dernier point de la chaine
 *
 * @param $url chemin d'un fichier avec son exention (exemple : "image.jpg")
 * @return l'extention trouvée 
 */
 
function dernier_point($chaine)
{
	$i = 0;
	$chaine1 = $chaine;
	$pos = 0;
	while ( ! ($pos === false) && $i<10)
	{
		$i++;
		$chaine1 = substr($chaine1,$pos+1);
		$pos = strpos($chaine1,'.');
	}
	return $chaine1;
}

function check_multimedia_type(&$type, &$error, &$error_msg)
{
	global $lang;

	switch( $type )
	{
		case 'ra':
			return '.ra';
			break;
		case 'rm':
			return '.rm';
			break;
		default:
			$error = true;
			$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Multimedia_filetype'] : $lang['Multimedia_filetype'];
			break;
	}

	return false;
}

/**
 * Fonction permettant l'upload facile d'un fichier multimedia
 * @param $error référence au booléen indiquant une erreur
 * @param $error_msg référence sur le message d'erreur
 * @param $filename Chemin du fichier temporaire (obtenu avec $_FILE['user_file']['tmp_name'] voir fonction suivante)
 * @param $realname Nom réel du fichier sur le poste source (obtenu avec $FILE['user_file']['name'])
 * @param $filesize Taille du fichier en octet (obtenu avec $FILE['user_file']['size'])
 * @param $filetype Type de fichier (obtenu avec $_FILE['user_file']['type'])
 * @param $dest Destination du fichier ATTENTION : SANS L'EXTENSION
 * @param $max_size Taille maximale du fichier autorisée(200ko par défault)
 *
 */
 
function upload_fmc(&$error, &$error_msg, $filename, $realname, $filesize, $filetype,$dest,$max_size = 204800)
{
	global $board_config, $site_config,$db, $lang,$phpbb_root_path,$ftp_server,$ftp_user_name,$ftp_user_pass;
	
	$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
	
	if ( ( file_exists(@phpbb_realpath($filename)) ) && preg_match('/\.(ra|rm)$/i', $realname) )
	{
		if ( $filesize <= $max_size && $filesize > 0 )
		{
			//preg_match('#.*\.(r[a|m])$/',$filename,$filetype);
			//$filetype = $filetype[1];	
		}
		else
		{
			$l_size = sprintf($lang['too_weight_file'], round($max_size / 1024)).' et il fait ' .  round($filesize / 1024) . "ko";

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_size : $l_size;
			return;
		}
	}

	if ( !($multimedia_type = check_multimedia_type($filetype, $error, $error_msg)) )
	{
		return;
	}

	$ext = array('rm','ra');
	for ($i=0;$i<count($ext);$i++)
	{
		$multimedia_url =  $dest . $ext[$i];
		if ( file_exists(@phpbb_realpath($multimedia_url)) )
		{
			@unlink($multimedia_url);
		}
	}
	
	$multimedia_url =  $dest . $multimedia_type;
		
	$conn_id = ftp_connect($ftp_server); 
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	// Vérification de la connexion
	if ((!$conn_id) || (!$login_result)) 
	{
		$error = true;
		$error_msg = "La connexion FTP a échoué !";
	}
	
	// Chargement d'un fichier
	$upload = ftp_put($conn_id, $multimedia_url, $filename, FTP_BINARY);
	
	// Vérification du status du chargement
	if (!$upload) 
	{
		$error = true;
		$error_msg = "Le chargement FTP a échoué!";
	}
	
	// Fermeture du flux FTP
	ftp_close($conn_id); 
		
	@chmod( $multimedia_url , 0777);


	return;
}

function finish_fmc($file,$ext)
{
	global $phpbb_root_path;
	
	$filename = $phpbb_root_path . 'audio/'.$file.'.ram';
	$fd = fopen($filename,'w');
	fwrite($fd,"pnm://audio.ovh.net/jjgfamille/".$file.".".$ext);
	fclose($fd);
} 

function supp_fmc(&$error,&$error_msg,$file,$ext)
{
	global $phpbb_root_path,$ftp_server,$ftp_user_name,$ftp_user_pass;
	
	$filename = $phpbb_root_path . 'audio/' . $file . '.ram';
	if (!unlink($filename))
	{
		$error = true;
		$error_msg .= "<br />Le fichier ram n'existait pas";
	}
	
	$conn_id = ftp_connect($ftp_server); 
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	// Vérification de la connexion
	if ((!$conn_id) || (!$login_result)) 
	{
		$error = true;
		$error_msg = "<br />La connexion FTP a échoué !";
	}
	
	// Chargement d'un fichier
	$upload = ftp_delete($conn_id, $file . '.rm');
	
	// Vérification du status du chargement
	if (!$upload) 
	{
		$error = true;
		$error_msg = "<br />Le chargement FTP a échoué!";
	}
	
	// Fermeture du flux FTP
	ftp_close($conn_id); 
}

?>