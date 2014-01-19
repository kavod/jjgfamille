<?
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

function get_location($session_page)
{
	global $lang,$phpbb_root_path,$phpEx;
	switch( $session_page )
	{
		case PAGE_INDEX:
			$location = $lang['Forum_index'];
			$location_url = $phpbb_root_path . "forum/index.$phpEx";
			break;
		case PAGE_POSTING:
			$location = $lang['Posting_message'];
			$location_url = $phpbb_root_path . "forum/index.$phpEx";
			break;
		case PAGE_LOGIN:
			$location = $lang['Logging_on'];
			$location_url = $phpbb_root_path . "forum/index.$phpEx";
			break;
		case PAGE_SEARCH:
			$location = $lang['Searching_forums'];
			$location_url = $phpbb_root_path . "forum/search.$phpEx";
			break;
		case PAGE_PROFILE:
			$location = $lang['Viewing_profile'];
			$location_url = $phpbb_root_path . "forum/index.$phpEx";
			break;
		case PAGE_VIEWONLINE:
			$location = $lang['Viewing_online'];
			$location_url = $phpbb_root_path . "forum/viewonline.$phpEx";
			break;
		case PAGE_VIEWMEMBERS:
			$location = $lang['Viewing_member_list'];
			$location_url = $phpbb_root_path . "forum/memberlist.$phpEx";
			break;
		case PAGE_PRIVMSGS:
			$location = $lang['Viewing_priv_msgs'];
			$location_url = $phpbb_root_path . "forum/privmsg.$phpEx";
			break;
		case PAGE_FAQ:
			$location = $lang['Viewing_FAQ'];
			$location_url = $phpbb_root_path . "forum/faq.$phpEx";
			break;
		case PAGE_ACCUEIL:
			$location = $lang['Viewing_accueil'];
			$location_url = $phpbb_root_path . "accueil/";
			break;
		case PAGE_LIENS:
			$location = $lang['Viewing_liens'];
			$location_url = $phpbb_root_path . "liens/";
			break;
		case PAGE_ACTU:
			$location = $lang['Viewing_actu'];
			$location_url = $phpbb_root_path . "actu/";
		case PAGE_JJG:
			$location = $lang['Viewing_jjg'];
			$location_url = $phpbb_root_path . "jjg/";
			break;	
		case PAGE_MEDIAS:
			$location = $lang['Viewing_medias'];
			$location_url = $phpbb_root_path . "medias/";
			break;
		case PAGE_TOURNEES:
			$location = $lang['Viewing_tournees'];
			$location_url = $phpbb_root_path . "tournees/";
			break;
		case PAGE_MORE:
			$location = $lang['Viewing_more'];
			$location_url = $phpbb_root_path . "more/";
			break;
		case PAGE_DISCO:
			$location = $lang['Viewing_disco'];
			$location_url = $phpbb_root_path . "disco/";
			break;
		case PAGE_FAMILLE:
		   	$location = $lang['Viewing_famille'];
		   	$location_url = $phpbb_root_path ."famille/";
		   	break;
		case PAGE_CHAT:
		   	$location = $lang['Viewing_chat'];
		   	$location_url = $phpbb_root_path . "chat/";
		   	break;
		case PAGE_CONTACT:
		   	$location = $lang['Viewing_Contact'];
		   	$location_url = $phpbb_root_path . "forum/contact.$phpEx";
		   	break;
		case PAGE_FMC:
		   	$location = $lang['Viewing_fmc'];
		   	$location_url = $phpbb_root_path . "forum/index.$phpEx";
		   	break;
		case PAGE_BLOGS:
		   	$location = $lang['Viewing_blogs'];
		   	$location_url = $phpbb_root_path . "blogs/";
		   	break;
		default:
			$location = $lang['Forum_index'];
			$location_url = $phpbb_root_path . "forum/index.$phpEx";
	}
	return array($location,$location_url);
}

/**
 * Fonction permettant l'upload d'un fichier quelconque
 * @param $error référence au booléen indiquant une erreur
 * @param $error_msg référence sur le message d'erreur
 * @param $filename Chemin du fichier temporaire (obtenu avec $_FILE['user_file']['tmp_name'] voir fonction suivante)
 * @param $realname Nom réel du fichier sur le poste source (obtenu avec $FILE['user_file']['name'])
 * @param $filesize Taille du fichier en octet (obtenu avec $FILE['user_file']['size'])
 * @param $filetype Type de fichier (obtenu avec $_FILE['user_file']['type'])
 * @param $dest Destination du fichier ATTENTION : SANS L'EXTENSION
 * @param $ext Extension utilisée
 * @param $max_size Taille maximale du fichier autorisée(200ko par défault)
 *
 */
function gen_upload(&$error, &$error_msg, $filename, $realname, $filesize, $dest, $ext, $max_size = 204800)
{
	global $board_config, $site_config,$db, $lang,$phpbb_root_path;
	
	if ($filename != '')
	{
		$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
		
		if ( ( file_exists(@phpbb_realpath($filename)) ) && preg_match('/\.(' . $ext . ')$/i', $realname) )
		{
			if ( $filesize <= $max_size && $filesize > 0 )
			{
			
			}
			else
			{
				$l_size = sprintf($lang['too_weight_file'], round($max_size / 1024)).' et elle fait ' .  round($filesize / 1024) . "ko";
	
				$error = true;
				$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_size : $l_size;
				return;
			}
	
		}
			
		if ( @$ini_val('open_basedir') != '' )
		{
			if ( @phpversion() < '4.0.3' )
			{
				message_die(GENERAL_ERROR, 'open_basedir is set and your PHP version does not allow move_uploaded_file', '', __LINE__, __FILE__);
			}
	
			$move_file = 'move_uploaded_file';
		}
		else
		{
			$move_file = 'copy';
		}
		
		$file_url =  $dest . $ext;
	
		if (! ($move_file($filename, $file_url )))
		{
			$error = true;
			$error_msg = "Erreur D'&eacute;criture dans le r&eacute;pertoire<br />" . $move_file . '(' . $filename . ',' . $file_url . ')';
		}
			
		@chmod( $file_url , 0777);
	} else
	{
		$error = true;
		$error_msg .= '<br />' . $lang['no_file'];
	}

	return;
}

/**
 * Fonction permettant l'upload facile d'une image
 * @param $error référence au booléen indiquant une erreur
 * @param $error_msg référence sur le message d'erreur
 * @param $filename Chemin du fichier temporaire (obtenu avec $_FILE['user_file']['tmp_name'] voir fonction suivante)
 * @param $realname Nom réel du fichier sur le poste source (obtenu avec $FILE['user_file']['name'])
 * @param $filesize Taille du fichier en octet (obtenu avec $FILE['user_file']['size'])
 * @param $filetype Type de fichier (obtenu avec $_FILE['user_file']['type'])
 * @param $dest Destination du fichier ATTENTION : SANS L'EXTENSION
 * @param $max_size Taille maximale du fichier autorisée(200ko par défault)
 * @param $max_width Largeur maximale de l'image
 * @param $max_height Hauteur maximale de l'image
 *
 */
function user_upload(&$error, &$error_msg, $filename, $realname, $filesize, $filetype,$dest,$max_size = 204800,$max_width = 9999,$max_height = 9999 )
{
	global $board_config, $site_config,$db, $lang,$phpbb_root_path;
	
	$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
	
	if ( ( file_exists(@phpbb_realpath($filename)) ) && preg_match('/\.(jpg|jpeg|gif|png)$/i', $realname) )
	{
		if ( $filesize <= $max_size && $filesize > 0 )
		{
			preg_match('#image\/[x\-]*([a-z]+)#', $filetype, $filetype);
			$filetype = $filetype[1];
		}
		else
		{
			$l_size = sprintf($lang['too_weight_file'], round($max_size / 1024)).' et elle fait ' .  round($filesize / 1024) . "ko";

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_size : $l_size;
			return;
		}

		list($width, $height) = @getimagesize($filename);
	}

	if ( !($imgtype = check_image_type($filetype, $error, $error_msg)) )
	{
		return;
	}

	if ( $width <= $max_width && $height <= $max_height )
	{
		$ext = array('jpg','jpeg','gif','gif','png');
		for ($i=0;$i<count($ext);$i++)
		{
			$img_url =  $dest . $ext[$i];
			if ( file_exists(@phpbb_realpath($img_url)) )
			{
				@unlink($img_url);
			}
		}
			
		if ( @$ini_val('open_basedir') != '' )
		{
			if ( @phpversion() < '4.0.3' )
			{
				message_die(GENERAL_ERROR, 'open_basedir is set and your PHP version does not allow move_uploaded_file', '', __LINE__, __FILE__);
			}

			$move_file = 'move_uploaded_file';
		}
		else
		{
			$move_file = 'copy';
		}
		
		$img_url =  $dest . $imgtype;

		@unlink($dest . '.' . find_image($dest));

		if (! ($move_file($filename, $img_url )))
		{
			$error = true;
			$error_msg = "Erreur D'&eacute;riture dans le r&eacute;pertoire<br />" . $move_file . '(' . $filename . ',' . $img_url . ')';
		}
			
		@chmod( $img_url , 0777);

	}
	else
	{
		$l_size = sprintf($lang['too_large_image'], $max_width, $max_height );

		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_size : $l_size;
	}

	return;
}
/**
 * Idem que user_upload en regroupant des arguments. ATTENTION : pour utiliser cette fonction, n'oubliez pas d'avoir bien tester l'existance de l'image source
 * @param $error référence au booléen indiquant une erreur
 * @param $error_msg référence sur le message d'erreur
 * @param $myFile Tableau contenant les informations sur le fichier... normalement de la forme $FILE['user_file']
 * @param $dest Destination du fichier ATTENTION : SANS L'EXTENSION
 * @param $max_size Tableau avec pour éléments :
 				0 la taille maximale du fichier autorisée(200ko par défault)
 				1: Largeur maximale de l'image
 				2 : Hauteur maximale de l'image
 * ATTENTION : pas encore testée */
function user_upload_easy(&$error,&$error_msg,$myFile,$dest,$max_size)
{
	return user_upload($error,$error_msg,$myFile['tmp_name'],$myFile['name'],$myFile['size'],$myFile['type'],$dest,$max_size[0],$max_size[1],$max_size[2]);
}

function user_mascotte_upload(&$error, &$error_msg, $mascotte_filename, $mascotte_realname, $mascotte_filesize, $mascotte_filetype,$rubrique)
{
	global $board_config, $site_config,$db, $lang,$phpbb_root_path;
	
	user_upload(
		$error, 
		$error_msg, 
		$mascotte_filename, 
		$mascotte_realname, 
		$mascotte_filesize, 
		$mascotte_filetype, 
		$phpbb_root_path . 'images/mascotte/' . $rubrique . '/' . date('Ymd'),
		$site_config['mascotte_max_filesize'],
		$site_config['mascotte_max_width'],
		$site_config['mascotte_max_height'] );
	
	if ( ! $error )
	{
		$mascotte_sql =  "UPDATE famille_config SET valeur_char = '" . date('Ymd') . "' WHERE param = 'mascotte_" . $rubrique . "'";
	}
	
	return $mascotte_sql;
}


/**
 * Retourne l'extention d'une image.
 *
 * @param $url chemin d'une image sans son exention (exemple : "../images/liens/photo_4.")
 * @return l'extention trouvée (jpg, jpeg, gif ou png) ou false en cas d'erreur
 */

function find_image($url)
{
	$url .= ( substr($url,-1) != '.' ) ? '.' : '';
	$ext = array('jpg','jpeg','gif','gif','png');
	for ($i=0;$i<count($ext);$i++)
	{;
		if (is_file( $url . $ext[$i]))
		{
			return $ext[$i];
		}
	}
	return false;
}

/**
 * Retourne la mascotte ajouté à une date donnée
 * 
 * @param $date Date d'ajout de la mascotte
 * @param rubrique Rubrique associée (accueil, liens, actu...)
 * @return le chemin complet (avec extention) de la mascotte ou false en cas d'erreur
 */

function affiche_mascotte($date,$rubrique)
{
	global $phpbb_root_path;
	$url = $phpbb_root_path . 'images/mascotte/' . $rubrique . '/' . $date . '.';
	$ext = find_image($url);
	if ( !$ext )
		return false;
	else
		return $url . $ext;
}


/**
 * Permet de modifier la position d'un élément (ici de le monter)
 *
 * @param $table Table dans laquelle on fait le tri. Cette table doit comporter un champs "ordre"
 */
function upasso($table,$identifiant,$id,$common)
{
	$where = "WHERE `$identifiant`=".$id;
	$order = "ORDER BY `ordre` DESC";
		
	$sql_courant = "SELECT * FROM `$table` $where $order";
	$result_courant = mysql_query($sql_courant) or die($sql_courant);
	$val_courant = mysql_fetch_array($result_courant);
	
	$sql_suivant = "SELECT * FROM `$table` WHERE `ordre` < ".$val_courant['ordre']." AND `$common` = '" . $val_courant[$common] . "' ORDER BY `ordre` DESC";
	$result_suivant = mysql_query($sql_suivant) or die($sql_suivant);
	
	if ($val_suivant = mysql_fetch_array($result_suivant))
	{
		$ordre_suivant = $val_suivant['ordre'];
		$sql_up1 = "UPDATE `$table` SET `ordre` = '". $val_courant['ordre']. "' WHERE `$identifiant` = $val_suivant[$identifiant]";
		if ( !mysql_query($sql_up1) )	
		{
			message_die(GENERAL_ERROR,'ERREUR CRITIQUE<br>sup_up1'.$sql_up1,'',__LINE__,__FILE__,$sql_up1);
		}
		
		$sql_up2 = "UPDATE `$table` SET `ordre` = '". $ordre_suivant. "' WHERE `$identifiant` = $val_courant[$identifiant]";
		if ( !mysql_query($sql_up2) )	
		{
			message_die(GENERAL_ERROR,'ERREUR CRITIQUE<br>sup_up1 : '.$sql_up2,'',__LINE__,__FILE__,$sql_up2);
		}		
	}
}

function downasso($table,$identifiant,$id,$common)
{
	$where = "WHERE `$identifiant`=".$id;
	$order = "ORDER BY `ordre` DESC";
		
	$sql_courant = "SELECT * FROM `$table` $where $order";
	$result_courant = mysql_query($sql_courant) or die($sql_courant);
	$val_courant = mysql_fetch_array($result_courant);
	
	$sql_suivant = "SELECT * FROM `$table` WHERE `ordre` > '".$val_courant['ordre']."' AND `$common` = '" . $val_courant[$common] . "' ORDER BY `ordre`";
	$result_suivant = mysql_query($sql_suivant) or die($sql_suivant);

	
	if ($val_suivant = mysql_fetch_array($result_suivant))
	{
		$ordre_suivant = $val_suivant['ordre'];
		$sql_up1 = "UPDATE $table SET ordre = ". $val_courant['ordre']. " WHERE $identifiant = $val_suivant[$identifiant]";
		//echo $sql_up1;
		if ( !mysql_query($sql_up1) )	
		{
			message_die(GENERAL_ERROR,'ERREUR CRITIQUE<br>sup_up1'.$sql_up1,'',__LINE__,__FILE__,$sql_up1);
		}
		
		$sql_up2 = "UPDATE $table SET ordre = ". $ordre_suivant. " WHERE $identifiant = $val_courant[$identifiant]";
		//echo $sql_up2;
		if ( !mysql_query($sql_up2) )	
		{
			message_die(GENERAL_ERROR,'ERREUR CRITIQUE<br>sup_up1 : '.$sql_up2,'',__LINE__,__FILE__,$sql_up2);
		}		
	}
}

/**
 * Permet de changer une date americaine aaaammjj en date francaise jj/mm/aaaa
 */

function affiche_date($str_date)
{
	$str_date = (int)$str_date;
	if ($str_date > 21000000 || $str_date < 19000101)
		return false;

	$annee = substr($str_date,0,4);
	$mois = substr($str_date,4,2);
	$jour = substr($str_date,6,2);
	
	if ($mois == 0 || $jour == 0)
		return $annee;
	else
		return $jour . '/' . $mois . '/' . $annee;
}

function format_date($date)
{
	
	  ////////////// formatage du champ date ////////////
	if ($date{1} == "/")
	{
		$date = "0".$date;
	}
	if ($date{4} == "/")
	{
		$date = $date{0}.$date{1}.$date{2}."0".$date{3}."/".$date{5}.$date{6}.$date{7}.$date{8};
	}	
	
	if ($date{2} != "/" or $date{5} != "/")
	{
	
		if (strlen($date) == 4 and $date{0} > "0" and $date{0} < "3" and $date{1}>="0" and $date{1}<="9" and $date{2}>="0" and $date{3}<="9" and $date{3}>="0" and $date{3}<="9")
		{
			$date = $date{0}.$date{1}.$date{2}.$date{3}."0000";
		} else
		{
			message_die(GENERAL_ERROR, "Date $date invalide",__LINE__,__FILE__,$sql_add);
			exit();
		}
	} else 
	{
		if (!(strlen($date) == 10 and $date{0}.$date{1} > "00" and $date{0}.$date{1} < "32" and $date{3}.$date{4} > "00" and $date{3}.$date{4} < "13" and $date{6}.$date{7}.$date{8}.$date{9} > "1700" and $date{6}.$date{7}.$date{8}.$date{9} < "2100"))
		{
			message_die(GENERAL_ERROR, "Date $date invalide",__LINE__,__FILE__,$sql_add);
			exit();
		} else
		{
			$date = $date{6}.$date{7}.$date{8}.$date{9}.$date{3}.$date{4}.$date{0}.$date{1};
		}
	}
	return $date;
}

function logger($description)
{
	global $userdata,$phpbb_root_path;
	
	$filename = $phpbb_root_path . 'logs/' . date('Ymd') . '.txt';
	$fd = fopen($filename,'a');
	fwrite($fd,date('d/m/Y H:i - ').$userdata['username']." - $description\r\n");
	fclose($fd);
}

function delete_html($message)
{
	return str_replace('<','&lt;',str_replace('>','&gt;',$message));
}
function date_unix($time,$mode) 
{

	$annee_modif = "";
	$array_mois = array("January"=>"Janvier", "February"=>"F&eacute;vrier", "March"=>"Mars", "April"=>"Avril", "May"=>"Mai", "June"=>"Juin", "July"=>"Juillet", "August"=>"Ao&ucirc;t", "September"=>"Septembre", "October"=>"Octobre", "November"=>"Novembre", "December"=>"D&eacute;cembre");
	$array_mois2 = array("January"=>"01", "February"=>"02", "March"=>"03", "April"=>"04", "May"=>"05", "June"=>"06", "July"=>"07", "August"=>"08", "September"=>"09", "October"=>"10", "November"=>"11", "December"=>"12");
	$array_jour = array("Monday"=>"Lundi", "Tuesday"=>"Mardi", "Wednesday"=>"Mercredi", "Thursday"=>"Jeudi", "Friday"=>"Vendredi", "Saturday"=>"Samedi", "Sunday"=>"Dimanche");
	$date_modif = date( "l d F Y H i s", $time);
	list($jour ,$date, $mois, $annee, $heure, $min, $sec) = split( '[ ]', $date_modif);
	$mois1 = $mois;
	foreach($array_mois as $mois_eng => $mois_fr) 
	{
		if($mois_eng == $mois)
		{
			$mois = $mois_fr;
			break;
		}
	}

	foreach($array_jour as $jour_eng => $jour_fr) 
	{
		if($jour_eng == $jour)
		{
			$jour = $jour_fr;
			break;
		}
	}

	switch($mode)
	{
		case 'jour' : 
			return $date.'/'.$array_mois2[$mois1].'/'.$annee;
		break;
		case 'heure' :
			return "$heure:$min";
		break;
		case 'date' :
			return "le $jour $date $mois $annee à $heure:$min";
		break;
		case 'date1' :
			return "$jour $date $mois $annee $heure:$min";
		break;
	}
		
}

/***************************************************/
/** Fonction "sendmail" qui permet *****************/
/** d'envoyer un mail au format texte ou html ******/
/** paramtres : format => txt ou html *************/
/**		nomfrom => nom de l'expediteur *****/
/**		emailfrom => email de l'expediteur */
/**		emaildest => email du destinataire */
/**		sujet => sujet du message **********/
/**		message => message du mail *********/
/***************************************************/

function sendmail($format,$nomfrom,$emailfrom,$emaildest,$sujet,$message)
{
	if ($format = 'html') 
		{
			$entete = "From: \"$nomfrom\" <$emailfrom>\n";
			$entete .= "X-Sender: <$emailfrom>\n";
			$entete .= "X-Mailer: PHP\n";
			$entete .= "X-Priority: 3\n";
			$entete .= "Return-Path: <$emailfrom>\n";
			$entete .= "Content-Type: text/html; charset=iso-8859-1\n";
			$entete .= "Cc:\n"; 
    		$entete .= "Bcc:\n"; 
		}
		else 
		{
			$entete = "From: \"$nomfrom\"\n";
		}

	mail("$emaildest","$sujet","$message","$entete");
}

function imgopif($rep)
{
	global $phpbb_root_path;	
	$dir = opendir($phpbb_root_path.'images/'.$rep); 
	while ($entree = readdir($dir)) 
	 { 
		if ($entree != ".." && $entree != "." && $entree != "index.htm") 
		 { 
			$files[] = $entree; 
		 } 
	 } 
	closedir ($dir); 
	$numopif = rand (0,count($files)-1);

	return $files[$numopif]; 
} 

/****************************************************/
/** Fonction "verifemail" qui permet ****************/
/** de verifier la validité d'un email **************/
/** paramètre : email *******************************/
/** @return : 1 si le mail est valide ou 0 sinon ****/
/****************************************************/

function verifemail ($email)
{
		// il y a un @ ?
		$verif_1 = ereg("@",$email);
		// il y a un point après le @ ? 
		$verif_2_tableau = explode("@",$email);
		$verif_2 = ereg(".",$verif_2_tableau[1]);
		// y'a t'il un charactère avant le @ 
		$verif_3 = !empty($verif_2_tableau[0]);
		// y a t-il des caractères après le dernier point ?
		$verif_4_tableau = explode(".",$verif_2_tableau[1]);
		// comptons le nombre de separation
		$nb_verif_4 = count($verif_4_tableau);
		$i=0;
		$verif_4 = 0;
		// verifions si il y a des caracteres apres l @ et avant et apres le ou les points
			for($i;$i<=$verif_4_tableau[$nb_verif_4 - 1];$i++)
			{
				if(!empty($verif_4_tableau[$i]))
					{
					$verif_4++;
					}
			}
		//verifions le nombre de caractere et l emplacement du point et de l @
		if(empty($email) or strlen($email) < 7)
		{
			$verif_5 = 0;
		}else
		{
			$verif_5 = 1;
		}
		//verifions  le type de caractere ecrit dans l email
		if(!ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$',$email))
		{
			$verif_6 = 0;
		}else
		{
			$verif_6 = 1;
		}
						
	// concluons 
	if ($verif_1 == 1 and $verif_2 == 1 and $verif_3 == 1 and $verif_4 != 0 and $verif_5 == 1 and $verif_6 == 1)
	{
		return 1;		
	}
	else if ($check_1 == 0 or $check_2 == 0 or $check_3 == 0 or $check_4 == 0 or $check_5 == 0 or $check_6 == 0) 
	{
		return 0;				
	}
}

function get_user($user_id,$username)
{
	$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = '".$user_id . "'"." ",'',false);
	if ($val_user)
		return $val_user;
	else
	{
		$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = '-1'"." ",'',false);
		$val_user['username'] = $username;
		return $val_user;
	}
}
?>
