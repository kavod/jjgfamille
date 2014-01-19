<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'famille';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//

if ($_POST['g2_controller'] != 'remote:GalleryRemote')
	die();
	

if ($_POST['g2_form']['cmd'] == 'login')
{
	$redirect = phpbb_login($_POST['g2_form']['uname'], $_POST['g2_form']['password'], '', true);
	if ($redirect != '')
	{
		echo "#__GR2PROTO__\n";
		echo "status=0\n";
		echo "status_text=Login successful.\n";
		echo "server_version=2.3\n";
	}
	die();
}

if ($_POST['g2_form']['cmd'] == 'fetch-albums-prune')
{
	if ($userdata['session_logged_in'] == 1)
	{
		$tab_rdf = select_liste("SELECT * FROM `rdf`");
	
		echo "#__GR2PROTO__\n";
		for ($i=0;$i <count($tab_rdf) ;$i++)
		{
			echo "album.name." . ($i + 1 ) . "=" . $tab_rdf[$i]['rdf_id'] . "\n";
			echo "album.title." . ($i + 1) . "=" . $tab_rdf[$i]['lieu'] . " " . date('d/m/Y',$tab_rdf[$i]['date']) . "\n";
			echo "album.summary." . ($i + 1) . "=" . "" . "\n";
			echo "album.parent." . ($i + 1) . "=" . "0" . "\n";
			echo "album.perms.add." . ($i + 1) . "=" . "true" . "\n";
			echo "album.perms.write." . ($i + 1) . "=" . "true" . "\n";
			echo "album.perms.del_alb." . ($i + 1) . "=" . "false" . "\n";
			echo "album.perms.create_sub." . ($i + 1) . "=" . "false" . "\n";
			echo "album.perms.extrafields." . ($i + 1) . "=" . "Summary,Description" . "\n";
		}
		echo "can_create_root=true\n";
		echo "album_count=" . (count($tab_rdf) + 1 ) . "\n";
		echo "status=0\n";
		echo "status_text=Fetch-albums successful.\n";
		echo "debug_user=" . $userdata['username'] . "\n";
	} else
	{
		die("pas bon");
	}
	die();
}

if ($_POST['g2_form']['cmd'] == 'album-properties')
{
	if ($userdata['session_logged_in'] == 1)
	{
		echo "#__GR2PROTO__\n";
		echo "status=0\n";
		echo "status_text=Fetch-album-images successful.\n";
		echo "auto_resize=800x600\n";
		echo "max_size=800x600\n";
		echo "add_to_beginning=no\n";
	} else
	{
		die("pas bon");
	}
	die();
}

if ($_POST['g2_form']['cmd'] == 'fetch-album-images')
{
	if ($userdata['session_logged_in'] == 1)
	{
		header("Content-Type: text/plain");
		
		$tab_photos = select_liste("SELECT * FROM rdf_photos WHERE rdf_id = '" . $_POST['g2_form']['set_albumName'] . "'");
		$val_rdf = select_element("SELECT * FROM rdf WHERE rdf_id = '" . $tab_photos[0]['rdf_id'] . "'",false,'');
		
		echo "#__GR2PROTO__\n";
		echo "status=0\n";
		echo "status_text=Fetch-album-images successful.";
		echo "\n";
		
		for ($i=0;$i<count($tab_photos);$i++)
		{
			$photo_url = $phpbb_root_path . 'images/rdf/photo_' . $_POST['g2_form']['set_albumName'] .'_'.$tab_photos[$i]['photo_id'];
			$photo_url = $photo_url . '.' . find_image($photo_url);
			$size = getimagesize($photo_url);
			if (!$size)
				echo $photo_url;
			$filesize = filesize($photo_url);
		
			$img = "images/rdf/photo_" . $val_rdf['rdf_id'] . "_" . $tab_photos[$i]['photo_id'] . ".";
			$ext = find_image($phpbb_root_path . $img);
			$img .= $ext;
			
			$mini = "functions/miniature.php?mode=rdf&photo_id=" . $tab_photos[$i]['photo_id'] . "&rdf_id="  . $val_rdf['rdf_id'] . "&ntH=90";
		
			//echo "image.name." . ($i + 1) . "=" . $tab_photos[$i]['photo_id'] . "\n";
			echo "image.name." . ($i + 1) . "=" . $img . "\n";
			echo "image.raw_width." . ($i + 1) . "=" . $size[0] . "\n";
			echo "image.raw_height." . ($i + 1) . "=" . $size[1] . "\n";
			echo "image.resizedName." . ($i + 1) . "=" . "" . "\n";
			echo "image.resized_width." . ($i + 1) . "=" . "" . "\n";
			echo "image.resized_height." . ($i + 1) . "=" . "" . "\n";
			echo "image.thumbName." . ($i + 1) . "=" . $mini . "\n";
			echo "image.thumb_width." . ($i + 1) . "=\n";
			echo "image.thumb_height." . ($i + 1) . "=\n";
			echo "image.raw_filesize." . ($i + 1) . "=" . $filesize . "\n";
			echo "image.caption." . ($i + 1) . "=" . $tab_photos[$i]['description'] . "\n";
			echo "image.extrafield.fieldname." . ($i + 1) . "=\n";
			echo "image.clicks." . ($i + 1) . "=0\n";
			echo "image.capturedate.year." . ($i + 1) . "=" . date('Y', $val_rdf['date']). "\n";
			echo "image.capturedate.mon." . ($i + 1) . "=" . date('m', $val_rdf['date']). "\n";
			echo "image.capturedate.mday." . ($i + 1) . "=" . date('d', $val_rdf['date']). "\n";
			echo "image.capturedate.hours." . ($i + 1) . "=" . date('H', $val_rdf['date']). "\n";
			echo "image.capturedate.minutes." . ($i + 1) . "=" . date('i', $val_rdf['date']). "\n";
			echo "image.capturedate.seconds." . ($i + 1) . "=" . date('s', $val_rdf['date']). "\n";
			echo "image.hidden." . ($i + 1) . "=no\n";
		}
		echo "baseurl=http://" . $_SERVER['HTTP_HOST'] . "/\n";
	} else
	{
		die("pas bon" . $userdata['session_logged_in']);
	}
	die();
}

if ($_POST['g2_form']['cmd'] == 'add-item')
{
	$error = false;
	$error_msg = '';
	
	$rdf_id = $_POST['g2_form']['set_albumName'];
		
	$user_upload =  ( $HTTP_POST_FILES['g2_userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['g2_userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
			
	$comment = $_POST['g2_form']['caption'];
	$photographe = $userdata['username'];
	$comment = htmlentities($comment);
	$photographe = htmlentities($photographe);
	
	$sql_ordre = "SELECT ordre FROM rdf_photos ORDER BY ordre DESC";
		        $result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br />Requète SQL : ".$sql_ordre);
                        if (!$val_ordre = mysql_fetch_array($result_ordre))
			   $val_ordre['ordre']=0;
		
		           $val_ordre['ordre']++;
	
	if (!$error)
	{
		$sql_update = "INSERT INTO rdf_photos (rdf_id,user_id,username,description,photographe,ordre) VALUES ( '".$rdf_id."' , '".$userdata['user_id']."' , '".$userdata['username']."', '".$comment."' , '".$photographe."','".$val_ordre['ordre']."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
		
		$photo_id = mysql_insert_id();
		
		// Ajout de la photo
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		$user_upload =  ( $HTTP_POST_FILES['g2_userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['g2_userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy(
					$error,
					$error_msg,
					$HTTP_POST_FILES['g2_userfile'],
					$phpbb_root_path . 'images/rdf/photo_' . $rdf_id .'_'.$photo_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['photo_max_width'],
						$site_config['photo_max_height'])
					);
			if ($error)
			{
				$sql_del = "DELETE FROM  rdf_photos WHERE photo_id = " . $photo_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
			}
		}
		
		if (!$error)
		{
			logger("Ajout de la photo de la rdf $rdf_id");
			echo "#__GR2PROTO__\n";
			echo "status=0\n";
			echo "status_text=Image Upload Succesfull\n";
		}
	}	
}

?>
