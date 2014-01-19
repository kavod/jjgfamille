<?
require_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions.'.$phpEx);
require_once($phpbb_root_path . 'functions/url_rewriting.php');

/**
 * Retourne les élément d'un Xopif ou dernier ajout
 * 
 * @param $rubrique : code rubrique (disco, photo)
 * @param $type : type désiré (opif ou last)
 * @return array(
 *		"TITLE" => titre de l'élément
 *		"TITLE_DESC" => "Dernier ajout" ou nom du opif (photopif...)
 *		"IMG" => illustration
 *		"TEXTE" => 50 premiers caractères du texte
 *		"URL" => URL redirectrice
 *		) ou false si aucun
 */
function short_desc($rubrique='',$type)
{
	global $lang,$phpbb_root_path;
	
	define("MAX_CHAR",60);
	
	

	if ($rubrique == '')
		die("Erreur : une rubrique est requise");
	switch($rubrique)
	{
		case 'biblio':
			// Sélection
			$sql = "SELECT * FROM biblio_livre ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC,livre_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val_livre = select_element($sql,'Erreur durant la sélection du disque',false);
			if (!$val_livre)
			{
				return false;
			} else
			{
				$val_illu = select_element('SELECT * FROM biblio_illu WHERE livre_id = '.$val_livre['livre_id'].' ORDER BY ordre LIMIT 0,1','',false);
				$url_image = '../images/biblio/livre_'.$val_illu['illu_id'].'_'.$val_illu['livre_id'].'.';
				$ext = find_image($url_image);
				$url_image .= $ext;
				$img_illu = ($val_illu && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=biblio&livre_id=' . $val_illu['livre_id'] . '&illu_id=' . $val_illu['illu_id'] . "&tnH=90" : '../templates/jjgfamille/images/site/px.png' ;
				
				$texte = strip_tags(bbencode_second_pass($val_livre['comment'],$val_livre['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
				
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['livropif'];
					
				return array(
					"TITLE" => $val_livre['title'],
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_illu,
					"TEXTE" => $texte,
					"URL" => append_sid($phpbb_root_path . 'jjg/ll' . $val_livre['livre_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($val_livre['title'])).'.html')
					);
			}
			break;
		case 'disco':
			// Sélection
			$sql = "SELECT * FROM disco_albums ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC,album_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val_disk = select_element($sql,'Erreur durant la sélection du disque',false);
			if (!$val_disk)
			{
				// Aucun disque dans la discographie
				return false;
			} else
			{
				$val_jack = select_element('SELECT * FROM disco_jacks WHERE album_id = '.$val_disk['album_id'].' ORDER BY ordre LIMIT 0,1','',false);
				$url_image = '../images/disco/jack_'.$val_jack['album_id'].'_'.$val_jack['jack_id'].'.';
				$ext = find_image($url_image);
				$url_image .= $ext;
				$img_jack = ($val_jack && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $val_jack['album_id'] . '&jack_id=' . $val_jack['jack_id'] . "&ntH=90" : '../templates/jjgfamille/images/site/px.png' ;
				
				$texte = strip_tags(bbencode_second_pass($val_disk['comment'],$val_disk['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
				
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['Diskopif'];
				
				if($val_disk['type']=="le single"){
					$url = append_sid($phpbb_root_path . 'disco/goldman_singles_' . substr($val_disk['date'],0,4).'.html'); }else{
					$url = append_sid($phpbb_root_path . 'disco/goldman_album_' . $val_disk['album_id'] . '_' . url_title($val_disk['title']) . '.html');}
				
				return array(
					"TITLE" => $val_disk['title'],
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_jack,
					"TEXTE" => $texte,
					"URL" => $url,
					);
			}
			break;
		case 'medias':
			// Sélection
			$sql = "SELECT * FROM media_emission ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC,emission_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val_media = select_element($sql,'Erreur durant la sélection du media',false);
			if (!$val_media )
			{
				return false;
			} else
			{
				$val_support = select_element("SELECT * FROM media_supports WHERE support_id='".$val_media['support_id']."' ");
				switch($val_media['media_type'])
				{
					case 'TV':
					case 'Radio':
						$type='emission';
					default:
						$type='article';
				}
				$val_illu = select_element('SELECT * FROM media_illustrations WHERE emission_id = '.$val_media['emission_id'].' ORDER BY illustration_id LIMIT 0,1','',false);
				$url_image = '../images/medias/illustration_'.$val_illu['emission_id'].'_'.$val_illu['illustration_id'].'.';
				$ext = find_image($url_image);
				$url_image .= $ext;
				$img_illu = ($val_illu && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=medias&emission_id=' . $val_illu['emission_id'] . '&illu_id=' . $val_illu['illustration_id'] . "&tnH=90" : '../templates/jjgfamille/images/site/px.png' ;
				
				$texte = strip_tags(bbencode_second_pass($val_media['description'],$val_media['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
				
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['mediaopif'];
				
				return array(
					"TITLE" => $val_media['title'],
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_illu,
					"TEXTE" => $texte,
					//"URL" => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id=' . $val_media['emission_id'])
					"URL" => append_sid($phpbb_root_path . 'medias/' . $type . '-' . str_replace('&amp;url_title=','',add_title_in_url($val_support['support_name'] . '-' . $val_media['title'])). '-' . $val_media['emission_id'] . '.html'),
					);
			}
			break;
		case 'photo':
			$sql = "SELECT * FROM famille_photo,famille_photo_cate WHERE famille_photo.cate_id=famille_photo_cate.cate_id AND cate_name<> 'upload' ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC,photo_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$photopif = select_element($sql,'Erreur durant la sélection d\'une photo',false);
			if (!$photopif)
			{
				return false;
			} else
			{
				$url_image = '../images/photos/photo_'.$photopif['cate_id'].'_'.$photopif['photo_id'].'.';
				$ext = find_image($url_image);
				$url_image .= $ext;
				$img_photopif = ($photopif && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=photo&cate_id=' . $photopif['cate_id'] . '&photo_id=' . $photopif['photo_id'] . "&tnH=90" : '../templates/jjgfamille/images/site/px.png' ;
				
				$l_photopif = $photopif['title'];
				$u_photopif = append_sid($phpbb_root_path . 'jjg/photo-' . str_replace('&amp;url_title=','',add_title_in_url($photopif['cate_name'] . '-' . $photopif['title'])) . '_' . $photopif['photo_id'].'.html');
				
				$texte = strip_tags(bbencode_second_pass($photopif['comment'],$photopif['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['Photopif'];
				
				return array(
					"TITLE" => $l_photopif,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_photopif,
					"TEXTE" => $texte,
					"URL" => $u_photopif
					);
			}
			break;
		
		case 'video':
			$sql = "SELECT * FROM `video_video` ORDER BY ";
			if ($type == 'last')
				$sql .= " date ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$videopif = select_element($sql,'Erreur durant la sélection d\'une video',false);
			if (!$videopif)
			{
				return false;
			} else
			{
				$sql = "SELECT * FROM `video_sources` WHERE `source_id` = '" . $videopif['source_id'] . "'";
				$val_source = select_element($sql,false,'');
				$img_videopif = sprintf($val_source['miniature'],$videopif['code']);
				
				$l_videopif = $videopif['title'];
				$u_videopif = append_sid($phpbb_root_path . 'medias/video_watch.php?video_id=' . $videopif['video_id']);
				
				$texte = strip_tags(bbencode_second_pass($videopif['description'],$videopif['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['Videopif'];
				
				return array(
					"TITLE" => $l_videopif,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_videopif,
					"TEXTE" => $texte,
					"URL" => $u_videopif
					);
			}
			break;
		case 'edito':
			$sql = "SELECT * FROM famille_edito ORDER BY ";
			if ($type == 'last')
				$sql .= " Date DESC,edito_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val = select_element($sql,'Erreur durant la sélection d\'un éditorial',false);
			if (!$val)
			{
				return false;
			} else
			{
				$url = '../images/edito/edito_' . $val['edito_id'] . '.';
				$url .= find_image($url);
				if (is_file($url))
					$img_editopif = $phpbb_root_path . 'functions/miniature.php?mode=edito&edito_id=' . $val['edito_id'] . "&ntH=90";
				else
					$img_editopif = '../templates/jjgfamille/images/site/px.png';
					
				$l_editopif = $val['title'];
				$u_editopif = append_sid($phpbb_root_path . 'actu/e' . $val['edito_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($val['title'])).'.html');
				
				$texte = strip_tags(preg_replace("|\[(.*)\]|",'',$val['edito']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['editopif'];
				
				return array(
					"TITLE" => $l_editopif,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_editopif,
					"TEXTE" => $texte,
					"URL" => $u_editopif
					);
			}
			break;
		case 'liens':
			$sql = "SELECT * FROM liens_sites WHERE enable = 'Y' ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC,site_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val = select_element($sql,'Erreur durant la sélection d\'un site',false);
			if (!$val)
			{
				return false;
			} else
			{
				$ext = find_image('../images/liens/logo_' . $val['site_id'] . '.');
				if (is_file('../images/liens/logo_' . $val['site_id'] . '.'.$ext))
					$img_photopif = $phpbb_root_path . 'functions/miniature.php?mode=liens&site_id=' . $val['site_id'] . "&ntH=90";
				else
					$img_photopif = '../templates/jjgfamille/images/site/px.png';
				$l_photopif = $val['site_name'];
				$tab = select_liste("SELECT * FROM liens_cate_site WHERE site_id = " . $val['site_id']);
				if (count($tab) > 0)
					$u_photopif = append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id=' . $tab[0]['cate_id']) . '#' . $val['site_name'];
				else return false;
				
				$texte = strip_tags($val['description']);
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['sitopif'];
				
				return array(
					"TITLE" => $l_photopif,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_photopif,
					"TEXTE" => $texte,
					"URL" => $u_photopif
					);
			}
			break;
		case 'bio':
			$sql = "SELECT * FROM famille_bio ORDER BY ";
			if ($type == 'last')
				$sql .= " page DESC,bio_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val = select_element($sql,'Erreur durant la sélection d\'un site',false);
			if (!$val)
			{
				return false;
			} else
			{
				if ($val['image']=='Y')
					$img_bio = $phpbb_root_path . 'functions/miniature.php?mode=bio&bio_id=' . $val['bio_id'] . "&ntH=90";
				else
					$img_bio = '../templates/jjgfamille/images/site/px.png';
				$l_bio = $val['title'];
				$u_bio = append_sid($phpbb_root_path . 'jjg/b' . $val['bio_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($val['title'])).'.html');
				
				$texte = strip_tags($val['contenu']);
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_episode'] : $lang['episopif'];
				
				return array(
					"TITLE" => $l_bio,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_bio,
					"TEXTE" => $texte,
					"URL" => $u_bio
					);
			}
			break;
		case 'report':
			$sql = "SELECT * FROM report WHERE achieved='Y' ORDER BY ";
			if ($type == 'last')
				$sql .= " date DESC";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val = select_element($sql,'Erreur durant la sélection d\'un site',false);
			if (!$val)
			{
				return false;
			} else
			{
				$val_image = select_element("SELECT * FROM report_photos WHERE report_id=".$val['report_id']." ORDER BY RAND()",'',false);
				$ext = find_image('../images/report/photo_' . $val['report_id'] . '_'. $val_image['photo_id'].'.');
				if (is_file('../images/report/photo_' . $val['report_id'] . '_'. $val_image['photo_id'].'.'.$ext))
					$img_reportopif = $phpbb_root_path . 'functions/miniature.php?mode=report&photo_id=' . $val_image['photo_id'] .'&report_id=' . $val['report_id'] . "&ntH=90";
				else
					$img_reportopif = '../templates/jjgfamille/images/site/px.png';
				$l_report = $val['title'];
				$u_report = append_sid($phpbb_root_path . 'medias/view_report.php?report_id=' . $val['report_id']);

				$texte = strip_tags($val['description']);
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['Reportagopif'];
				
				return array(
					"TITLE" => $l_report,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_reportopif,
					"TEXTE" => $texte,
					"URL" => $u_report,
					);
			}
			break;
		case 'tournees':
			$sql = "SELECT * FROM tournee_tournees ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val = select_element($sql,'Erreur durant la sélection d\'un site',false);
			if (!$val)
			{
				return false;
			} else
			{
				$val_image = select_element("SELECT * FROM tournee_billets WHERE tournee_id=".$val['tournee_id']."",'',false);
				$ext = find_image('../images/tournees/billet_' . $val['tournee_id'] . '_'. $val_image['billet_id'].'.');
				if (is_file('../images/tournees/billet_' . $val['tournee_id'] . '_'. $val_image['billet_id'].'.'.$ext))
					$img_tournee = $phpbb_root_path . 'functions/miniature.php?mode=tournees_billets&billet_id=' . $val_image['billet_id'] .'&tournee_id=' . $val['tournee_id'] . "&ntH=90";
				else
					$img_tournee = '../templates/jjgfamille/images/site/px.png';
				$l_tournee = $val['title'];
				$u_tournee = append_sid($phpbb_root_path . 'tournees/tournees.php?tournee_id=' . $val['tournee_id']);
				$texte = strip_tags($val['comment']);
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['Tourneesopif'];
				
				return array(
					"TITLE" => $l_tournee,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_tournee,
					"TEXTE" => $texte,
					"URL" => $u_tournee
					);
			}
			break;
		case 'more':
			// Sélection
			$sql = "SELECT more.* 
				FROM more, more_cate cate 
				WHERE cate.filename = '' AND cate.cate_id = more.cate_id AND more.enable = 'Y' 
				ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC,more_id DESC ";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val_more = select_element($sql,'Erreur durant la sélection du goodies',false);
			if (!$val_more)
			{
				return false;
			} else
			{
				$ext_more = find_image('../images/goodies/goodies_' . $val_more['more_id'] . '.');
				$img_illu = ($val_more && is_file("../images/goodies/goodies_".$val_more['more_id'].".".$ext_more)) ? $phpbb_root_path . 'functions/miniature.php?mode=more&more_id=' . $val_more['more_id'] . "&tnH=90" : '../templates/jjgfamille/images/site/px.png' ;
				
				$texte = strip_tags(bbencode_second_pass($val_more['description'],$val_more['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
				
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['moreopif'];
					
				return array(
					"TITLE" => $val_more['title'],
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_illu,
					"TEXTE" => $texte,
					"URL" => append_sid($phpbb_root_path . 'more/view_cate.php?cate_id=' . $val_more['cate_id'])
					);
			}
			break;
		case 'rdn':
			// On prend le dernier numero que l'on affiche pas 
			$val_count = select_element("SELECT COUNT(*) as nb FROM famille_rdn",'',false);
			if($val_count['nb']>0)
			{
				$val_last = select_element("SELECT rdn_id FROM famille_rdn ORDER BY date DESC LIMIT 0,1",'',false);
				// Sélection
				$sql = "SELECT * FROM famille_rdn WHERE rdn_id <> ".$val_last['rdn_id']." ORDER BY ";
				if ($type == 'last')
					$sql .= " date DESC,rdn_id DESC ";
				else
					$sql .= " RAND() ";
				$sql .= " LIMIT 0,1";
			}else
			{
				$sql = "SELECT * FROM famille_rdn";
			}
			$val_rdn = select_element($sql,'Erreur durant la sélection de la revue du net',false);
			if (!$val_rdn)
			{
				return false;
			} else
			{
				$ext_rdn = find_image('../images/rdn/rdn_'.$val_rdn['rdn_id'].'.');
				$img_illu = ($val_rdn && is_file("../images/rdn/rdn_".$val_rdn['rdn_id'].".".$ext_rdn)) ? $phpbb_root_path . 'functions/miniature.php?mode=rdn&rdn_id=' . $val_rdn['rdn_id'] . "&tnH=90" : '../templates/jjgfamille/images/site/px.png' ;
				
				$texte = strip_tags(bbencode_second_pass($val_rdn['contenu'],$val_rdn['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
				
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['rdnopif'];
					
				return array(
					"TITLE" => $val_rdn['title'],
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_illu,
					"TEXTE" => $texte,
					"URL" => append_sid($phpbb_root_path . 'actu/r' . $val_rdn['rdn_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($val_rdn['title'])).'.html')
					);
			}
			break;
		case 'rdf':
			$sql = "SELECT * FROM rdf ORDER BY ";
			if ($type == 'last')
				$sql .= " date_add DESC,rdf_id DESC";
			else
				$sql .= " RAND()";
			$sql .= " LIMIT 0,1";
			
			$val = select_element($sql,'Erreur durant la sélection d\'un site',false);
			if (!$val)
			{
				return false;
			} else
			{
				$val_image = select_element("SELECT * FROM rdf_photos WHERE rdf_id=".$val['rdf_id']." ORDER BY RAND()",'',false);
				$ext = find_image('../images/rdf/photo_' . $val['rdf_id'] . '_'. $val_image['photo_id'].'.');
				if (is_file('../images/rdf/photo_' . $val['rdf_id'] . '_'. $val_image['photo_id'].'.'.$ext))
					$img_rdf = $phpbb_root_path . 'functions/miniature.php?mode=rdf&photo_id=' . $val_image['photo_id'] .'&rdf_id=' . $val['rdf_id'] . "&ntH=90";
				else
					$img_rdf = '../templates/jjgfamille/images/site/px.png';
				$l_rdf = $val['lieu'].' '.date_unix($val['date'],'jour');
				$u_rdf = append_sid($phpbb_root_path . 'famille/view_rdf.php?rdf_id=' . $val['rdf_id']);

				$texte = strip_tags(bbencode_second_pass($val['description'],$val['bbcode_uid']));
				if (strlen($texte) > MAX_CHAR )
					$texte = substr($texte,0,MAX_CHAR) . "...";
					
				$title_desc = ($type == 'last') ? $lang['last_add'] : $lang['RdfOpif'];
				
				return array(
					"TITLE" => $l_rdf,
					"TITLE_DESC" => $title_desc,
					"IMG" => $img_rdf,
					"TEXTE" => $texte,
					"URL" => $u_rdf,
					);
			}
			break;
		default:
			die("Rubrique $rubrique inconnue");
	}
	return false;
}

function rubrikopif($tab_rub = array())
{
	global $lang,$phpbb_root_path;
	$list_rub = array(
			array('Discographie','disco'),
			array('Galerie_photo','photo'),
			array('Liens','liens'),
			array('Biographie','bio'),
			array('Bibliothèque','biblio'),
			array('Editorial','edito'),
			array('Médiathèque','medias'),
			array('Reportages','report'),
			array('Tournées','tournees'),
			array('En ++','more'),
			array('Revue du Net','rdn'),
			array('Réunion de famille','rdf'),
			array('Gallerie vidéo','video'),
			);
	if (! is_array($tab_rub) || count($tab_rub) == 0)
	{
		$tab_rub = $list_rub;
	} else
	{
		for ($i=0;$i<count($tab_rub);$i++)
		{
			for ($j=0;$j<count($list_rub);$j++)
			{
				if ($tab_rub[$i] == $list_rub[$j][1])
				{
					$tab_rub[$i]=$list_rub[$j];
					break;
				}
			}
		}
	}
	
	srand((double) microtime() * 10000000);
	$indice = array_rand($tab_rub);
	
	switch($tab_rub[$indice][1])
	{
		case 'biblio':
			// Chiffres clefs
			$val_biblio = select_element('SELECT COUNT(*) nb FROM biblio_livre','Erreur durant la comptabilisation des sites',true);
			$nb_livres = $val_biblio['nb'];
			if ($nb_livres==1)
				$l_pages = $lang['livre'];
			else if ($nb_livres > 1)
				$l_pages = $lang['livres'];
			else $nb_livres = '';
			
			$count_cate = select_element('SELECT COUNT(*) nb_cate FROM biblio_cate ','Erreur durant la comptabilisation des titres',true);
			$nb_cates = $count_cate['nb_cate'];
			if ($nb_cates==1)
				$l_cate = sprintf($lang['nb_cate'],$nb_cates);
			else if ($nb_cates > 1)
				$l_cate = sprintf($lang['nb_cates'],$nb_cates);
			else $nb_cates = '';
			
			$return_title = $lang['bibliotheque'];
			$return_chiffres = sprintf("<b>%s</b> %s<br />%s",$nb_livres,$l_pages,$l_cate);
			$return_go_to = $lang['go_to_the_bibliotheque'];
			$return_url = append_sid( $phpbb_root_path . 'jjg/bibliographie.html');
			break;
		case 'disco':
			$return_title = $lang['Discographie'];
			$return_chiffres = '';
			$return_go_to = $lang['go_to_the_disco'];
			$return_url = append_sid( $phpbb_root_path . 'disco/');
			// Chiffres clefs
			$tab_albums = select_liste('SELECT `type`, COUNT(*) nb_disque FROM disco_albums GROUP BY `type` ORDER BY `type`');
			for ($i=0;$i<count($tab_albums);$i++)
			{
				switch($tab_albums[$i]['type'])
				{
					case 'l\'album':
						$nb_studio = $tab_albums[$i]['nb_disque'];
						if ($nb_studio==1)
							$l_studio_album = $lang['Studio_album'];
						else if ($nb_studio > 1)
							$l_studio_album = $lang['Studio_albums'];
						else $nb_studio = '';
						break;
					case 'le live':
						$nb_live = $tab_albums[$i]['nb_disque'];
						if ($nb_live==1)
							$l_live_album = $lang['Live_album'];
						else if ($nb_live > 1)
							$l_live_album = $lang['Live_albums'];
						else $nb_live = '';
						break;
					case 'la compilation':
						$nb_compil = $tab_albums[$i]['nb_disque'];
						if ($nb_compil==1)
							$l_compil_album = $lang['Compil_album'];
						else if ($nb_compil > 1)
							$l_compil_album = $lang['Compil_albums'];
						else $nb_compil = '';
						break;
					case 'le single':
						$nb_single = $tab_albums[$i]['nb_disque'];
						if ($nb_single==1)
							$l_single_album = $lang['Single_album'];
						else if ($nb_single > 1)
							$l_single_album = $lang['Single_albums'];
						else $nb_single = '';
						break;
					case 'video':
						$nb_video = $tab_albums[$i]['nb_disque'];
						if ($nb_video==1)
							$l_video = $lang['Vidéo'];
						else if ($nb_video > 1)
							$l_video = $lang['Vidéos'];
						else $nb_video = '';
						break;
					default:
						message_die(CRITICAL_ERROR,'Type d\'album non reconnu','',__LINE__,__FILE__,$sql);
				}
			}
			
			$count_titres = select_element('SELECT COUNT(*) nb_titres FROM disco_songs','Erreur durant la comptabilisation des titres',false);
			if (!$count_titres)
				$l_nb_songs = $lang['no_song'];
			else
				$l_nb_songs = ($count_titres['nb_titres']>1) ? sprintf($lang['nb_titres'],$count_titres['nb_titres']) : $lang['nb_titre'];
			
			$val_audio = select_element('SELECT COUNT(*) nb_audios FROM disco_songs WHERE rm="Y"','',false);
			$nb_audios = $val_audio['nb_audios'];
			$onclick = "window.open('../fmc/jukebox.php?mode=disco','Jukebox','noresizable,scrollbars=yes,menubar=auto,width=800,height=500,left=100,top=100')";
			
			if ($nb_audios==1)
				$l_audio = '<b>1</b> extrait à <a href="#" onclick="'.$onclick.'">ECOUTER</a>';
			else if ($nb_audios > 1)
				$l_audio = sprintf('<b>%s</b> %s',$nb_audios,'extraits à <a href="#" onclick="'.$onclick.'"><b>ECOUTER</b></a>');
			else $nb_audios = '';
				
			$return_chiffres = "<b>" . $nb_studio ."</b> " . $l_studio_album ."<br />\n
					<b>" . $nb_live . "</b> " . $l_live_album ."<br />\n
					<b>" . $nb_single . "</b> " . $l_single_album . "<br />\n
					<b>" . $nb_compil . "</b> " . $l_compil_album ."<br />\n
					<b>" . $nb_video . "</b> " . $l_video ."<br />\n
					<b>" . $nb_audio . "</b> " . $l_audio ."<br />\n
					" . $l_nb_songs;
			break;
		case 'photo':
			// Chiffres clefs
			$val_photo = select_element('SELECT COUNT(*) nb_photo FROM famille_photo,famille_photo_cate WHERE famille_photo.cate_id=famille_photo_cate.cate_id AND cate_name<> "upload" ','Erreur durant la comptabilisation des photos',true);
			$nb_photos = $val_photo['nb_photo'];
			if ($nb_photos==1)
				$l_photo = $lang['photo'];
			else if ($nb_photos > 1)
				$l_photo = $lang['photos'];
			else $nb_photos = '';
			
			$count_cate = select_element('SELECT COUNT(*) nb_cate FROM famille_photo_cate WHERE cate_name <> "upload" ','Erreur durant la comptabilisation des titres',true);
			if (!$count_cate)
				$l_cate = '';
			else
				$l_cate = ($count_cate['nb_cate']>1) ? sprintf($lang['nb_cates'],$count_cate['nb_cate']) : '';
				
			$return_title = $lang['Galerie_photo'];
			$return_chiffres = sprintf("<b>%s</b> %s<br />%s",$nb_photos,$l_photo,$l_cate);
			$return_go_to = $lang['go_to_the_photo'];
			$return_url = append_sid( $phpbb_root_path . 'jjg/photos.html');
			break;
		case 'video':
			// Chiffres clefs
			$val_video = select_element('SELECT COUNT(*) nb_video FROM `video_video` WHERE `enabled` = \'Y\' ','Erreur durant la comptabilisation des vidéos',true);
			$nb_videos = $val_video['nb_video'];
			if ($nb_videos==1)
				$l_video = $lang['video'];
			else if ($nb_videos > 1)
				$l_video = $lang['videos'];
			else $nb_videos = '';
			
			$count_cate = select_element('SELECT COUNT(*) nb_cate FROM `video_cate`','Erreur durant la comptabilisation des catégories',true);
			if (!$count_cate)
				$l_cate = '';
			else
				$l_cate = ($count_cate['nb_cate']>1) ? sprintf($lang['nb_cates'],$count_cate['nb_cate']) : '';
				
			$return_title = $lang['Videos'];
			$return_chiffres = sprintf("<b>%s</b> %s<br />%s",$nb_videos,$l_video,$l_cate);
			$return_go_to = $lang['go_to_the_video'];
			$return_url = append_sid( $phpbb_root_path . 'medias/video.php');
			break;
		case 'liens':
			// Chiffres clefs
			$val_site = select_element('SELECT COUNT(*) nb_sites FROM liens_sites WHERE enable = \'Y\'','Erreur durant la comptabilisation des sites',true);
			$nb_sites = $val_site['nb_sites'];
			if ($nb_sites==1)
				$l_site = $lang['site_reference'];
			else if ($nb_sites > 1)
				$l_site = $lang['site_references'];
			else $nb_site = '';
			
			$count_cate = select_element('SELECT COUNT(*) nb_cate FROM liens_categories','Erreur durant la comptabilisation des catégories',true);
			if (!$count_cate)
				$l_cate = '';
			else
				$l_cate = ($count_cate['nb_cate']>1) ? sprintf($lang['nb_cate'],$count_cate['nb_cate']) : '';
				
			$return_title = $lang['Links'];
			$return_chiffres = sprintf("<b>%s</b> %s<br />%s",$nb_sites,$l_site,$l_cate);
			$return_go_to = $lang['go_to_the_link'];
			$return_url = append_sid( $phpbb_root_path . 'liens/');
			break;
		case 'edito':
			// Chiffres clefs
			$val_edito = select_element('SELECT COUNT(*) nb_editos FROM famille_edito','Erreur durant la comptabilisation des éditoriaux',true);
			$nb_editos = $val_edito['nb_editos'];
			if ($nb_editos==1)
				$l_editos = sprintf($lang['present'],$lang['editorial']);
			else if ($nb_editos > 1)
			{
				$l_editos = sprintf($lang['presents'],$lang['editoriaux']);
			}
			else $nb_editos = '';
			
			$count_illu = select_element('SELECT COUNT(*) nb_illu FROM famille_edito WHERE illu_user_id <> 0','Erreur durant la comptabilisation des éditoriaux illustrés',true);
			if (!$count_illu)
				$l_illu = '';
			else
				$l_illu = ($count_illu['nb_illu']>1) ? sprintf($lang['dont_X_illustres'],$count_illu['nb_illu']) : sprintf($lang['dont_X_illustre'],$count_illu['nb_illu']);
				
			$return_title = $lang['Editorial'];
			$return_chiffres = sprintf("<b>%s</b> %s<br />%s",$nb_editos,$l_editos,$l_illu);
			$return_go_to = $lang['go_to_the_edito'];
			$return_url = append_sid( $phpbb_root_path . 'actu/edito.html');
			break;
		case 'bio':
			// Chiffres clefs
			$val_bio = select_element('SELECT COUNT(*) nb_pages FROM famille_bio','Erreur durant la comptabilisation des sites',true);
			$nb_pages = $val_bio['nb_pages'];
			if ($nb_pages==1)
				$l_pages = $lang['episode'];
			else if ($nb_pages > 1)
				$l_pages = $lang['episodes'];
			else $nb_pages = '';
				
			$return_title = $lang['biographie'];
			$return_chiffres = sprintf("<b>%s</b> %s",$nb_pages,$l_pages);
			$return_go_to = $lang['go_to_the_biography'];
			$return_url = append_sid( $phpbb_root_path . 'jjg/biographie.html');
			break;
		case 'medias':
			// Chiffres clefs
			$tab_media = select_liste('SELECT COUNT( * ) nb_medias, support.media_type
							FROM media_emission emission, media_supports support
							WHERE emission.support_id = support.support_id
							GROUP BY support.media_type ',
							'Erreur durant la comptabilisation des sites',true);
			$nb_medias = 0;
			for ($i=0;$i<count($tab_media);$i++)
			{
				switch($tab_media[$i]['media_type'])
				{
					case 'TV':
						$nb_tv = $tab_media[$i]['nb_medias'];
						break;
					case 'Radio':
						$nb_radio = $tab_media[$i]['nb_medias'];
						break;
					case 'Presse':
						$nb_presse = $tab_media[$i]['nb_medias'];
						break;
					case 'Internet':
						$nb_tv = $tab_media[$i]['nb_medias'];
						break;
					default:
				}
				$nb_medias += $tab_media[$i]['nb_medias'];
			}
			if ($nb_medias==1)
				$l_media = $lang['Media'] . ' ' . sprintf($lang['dont'],'');
			else if ($nb_medias > 1)
				$l_media = $lang['Medias'] . ' ' . sprintf($lang['dont'],'');
			else $nb_medias = '';
			
			if ($nb_tv==1)
				$l_tv = '<br />' . '<b>1</b> ' . $lang['emission_tv'];
			else if ($nb_tv > 1)
				$l_tv = '<br />' . sprintf('<b>%s</b> %s',$nb_tv,$lang['emissions_tv']);
			else $nb_tv = '';
			
			if ($nb_radio==1)
				$l_radio = '<br />' . '<b>1</b> ' . $lang['emission_radio'];
			else if ($nb_radio > 1)
				$l_radio = '<br />' . sprintf('<b>%s</b> %s',$nb_radio,$lang['emissions_radio']);
			else $nb_radio = '';
			
			if ($nb_presse==1)
				$l_presse = '<br />' . '<b>1</b> ' . $lang['article_presse'];
			else if ($nb_presse > 1)
				$l_presse = '<br />' . sprintf('<b>%s</b> %s',$nb_presse,$lang['articles_presse']);
			else $nb_presse = '';
				
			if ($nb_internet==1)
				$l_internet = '<br />' . '<b>1</b> ' . $lang['article_internet'];
			else if ($nb_internet > 1)
				$l_internet = '<br />' . sprintf('<b>%s</b> %s',$nb_internet,$lang['articles_internet']);
			else $nb_internet = '';
			
			$val_audio = select_element('SELECT COUNT(*) nb_audios FROM media_audio','',false);
			
			$nb_audios = $val_audio['nb_audios'];
			$onclick = "window.open('../fmc/jukebox.php?mode=media','Jukebox','noresizable,scrollbars=yes,menubar=auto,width=800,height=500,left=100,top=100')";
			
			if ($nb_audios==1)
				$l_audio = '<br/><b>1</b> extrait à <a href="#" onclick="'.$onclick.'">ECOUTER</a>';
			else if ($nb_audios > 1)
				$l_audio = '<br/>'.sprintf('<b>%s</b> %s',$nb_audios,'extraits à <a href="#" onclick="'.$onclick.'"><b>ECOUTER</b></a>');
			else $nb_audios = '';
			
			$return_title = $lang['nom_rub_media'];
			$return_chiffres = sprintf("<b>%s</b> %s",$nb_medias,$l_media . $l_tv . $l_radio . $l_presse . $l_internet . $l_audio . '<br/>');
			$return_go_to = $lang['go_to_the_medias'];
			$return_url = append_sid( $phpbb_root_path . 'medias/mediatheque.html');
			break;
		case 'report':
			// Chiffres clefs
			$val_report = select_element('SELECT COUNT(*) nb_report FROM report WHERE achieved="Y" ','Erreur durant la comptabilisation des sites',true);
			$nb_pages = $val_report['nb_report'];
			if ($nb_pages==1)
				$l_pages = $lang['reportage'];
			else if ($nb_pages > 1)
				$l_pages = $lang['reportages'];
			else $nb_pages = '';
			
			$val_audio = select_element('SELECT COUNT(*) nb_audios FROM report_audio','',false);
			
			$nb_audios = $val_audio['nb_audios'];
			$onclick = "window.open('../fmc/jukebox.php?mode=report','Jukebox','noresizable,scrollbars=yes,menubar=auto,width=800,height=500,left=100,top=100')";
			
			if ($nb_audios==1)
				$l_audio = '<br/><b>1</b> extrait à <a href="#" onclick="'.$onclick.'">ECOUTER</a>';
			else if ($nb_audios > 1)
				$l_audio = '<br/>'.sprintf('<b>%s</b> %s',$nb_audios,'extraits à <a href="#" onclick="'.$onclick.'"><b>ECOUTER</b></a>');
			else $nb_audios = '';
				
			$return_title = $lang['reportages'];
			$return_chiffres = sprintf("<b>%s</b> %s",$nb_pages,$l_pages.$l_audio.'<br/>');
			$return_go_to = $lang['go_to_the_reportages'];
			$return_url = append_sid( $phpbb_root_path . 'medias/reportages.html');
			break;
		case 'tournees':
			// Chiffres clefs
			$val_tournee = select_element('SELECT COUNT(*) nb_tournee FROM tournee_tournees','Erreur durant la comptabilisation des sites',true);
			$nb_pages = $val_tournee['nb_tournee'];
			if ($nb_pages==1)
				$l_pages = $lang['tournee'];
			else if ($nb_pages > 1)
				$l_pages = $lang['tournees'];
			else $nb_pages = '';
				
			$return_title = $lang['Tournees'];
			$return_chiffres = sprintf("<b>%s</b> %s",$nb_pages,$l_pages);
			$return_go_to = $lang['go_to_the_tournees'];
			$return_url = append_sid( $phpbb_root_path . 'tournees/');
			break;
		case 'more':
			// Chiffres clefs
			$val_game = select_element('SELECT COUNT(*) nb_game FROM more,more_cate WHERE more.cate_id = more_cate.cate_id AND enable="Y"AND cate_name = "Jeux" ','Erreur durant la comptabilisation des goodies',true);
			$val_more = select_element('SELECT COUNT(*) nb_more FROM more,more_cate WHERE more.cate_id = more_cate.cate_id AND enable="Y"AND cate_name <> "Jeux" ','Erreur durant la comptabilisation des goodies',true);
			
			$nb_game = $val_game['nb_game'];
			
			if ($nb_game==1)
				$game = $lang['jeu'];
			else if ($nb_game > 1)
				$game = $lang['jeux'];
			else $nb_game = '';
			
			$nb_more = $val_more['nb_more'];
			
			if ($nb_more > 1)
				$more = $lang['goodies'].'&nbsp;'.sprintf($lang['à'],$lang['Download']);
			else $nb_more = '';
			
			//1er au GoldmanikouiZ
			$val_first = select_element("SELECT quizz_users.*,phpbb_users.user_id,phpbb_users.username FROM quizz_users, phpbb_users WHERE quizz_users.user_id = phpbb_users.user_id AND nb_quest > 49 ORDER BY score/nb_quest DESC,nb_quest DESC",'',false);
			
			if($val_first)
				$first = '<br/><a href="' . $phpbb_root_path . 'forum/profile.php?mode=viewprofile&amp;u='.$val_first['user_id'].'"><b>'.$val_first['username'].'</b></a> est 1er au <a href="../more/quizz.php?cate_id=1">GoldmanikouiZ</a>';
			else $first = '';
				
			$return_title = $lang['EnPlusPlus'];
			$return_chiffres = sprintf("<b>%s</b> %s<br><b>%s</b> %s%s",$nb_game,$game,$nb_more,$more,$first);
			$return_go_to = $lang['go_to_the_More'];
			$return_url = append_sid( $phpbb_root_path . 'more/index.php');
			break;
		case 'rdn':
			// Chiffres clefs
			$val_rdn = select_element('SELECT COUNT(*) nb_rdn FROM famille_rdn','Erreur durant la comptabilisation des sites',true);
			$nb_rdn = $val_rdn['nb_rdn'];
			if ($nb_rdn==1)
				$l_rdn = $lang['Revue du Net'];
			else if ($nb_rdn > 1)
				$l_rdn = $lang['Revues du Net'];
			else $nb_rdn = '';
				
			$return_title = $lang['Revue du Net'];
			$return_chiffres = sprintf("<b>%s</b> %s",$nb_rdn,$l_rdn);
			$return_go_to = $lang['go_to_the_rdn'];
			$return_url = append_sid( $phpbb_root_path . 'actu/rdn.html');
			break;
		case 'rdf':
			// Chiffres clefs
			$val_rdf = select_element('SELECT COUNT(*) nb_rdf,COUNT(DISTINCT(lieu)) nb_lieu FROM rdf','',true);
			$val_photos = select_element('SELECT COUNT(*) nb_photos FROM rdf_photos','',true);
			$val_recits = select_element('SELECT COUNT(*) nb_recits FROM rdf_recits','',true);
		
			$nb_rdf = $val_rdf['nb_rdf'];
			$nb_lieu = $val_rdf['nb_lieu'];
			$nb_photos = $val_photos['nb_photos'];
			$nb_recits = $val_recits['nb_recits'];
			
			if ($nb_rdf==1)
				$l_rdf = $lang['Réunion de famille'].'&nbsp;'.$lang['dans'];
			else if ($nb_rdf > 1)
				$l_rdf = $lang['Réunions de famille'].'&nbsp;'.$lang['dans'];
			else $nb_rdf = '';
			
			if ($nb_lieu==1)
				$l_lieu = $lang['Lieu'];
			else if ($nb_lieu > 1)
				$l_lieu = $lang['Lieux différents'];
			else $nb_lieu = '';
			
			if ($nb_photos==1)
				$l_photos = ucfirst($lang['photo']);
			else if ($nb_photos > 1)
				$l_photos = ucfirst($lang['photos']);
			else $nb_photos = '';
			
			if ($nb_recits==1)
				$l_recits = $lang['Récit'];
			else if ($nb_recits > 1)
				$l_recits = $lang['Récits'];
			else $nb_recits = '';
			
			
			$return_title = $lang['Réunion De Famille'];
			$return_chiffres = "<b>" . $nb_rdf ."</b> " . $l_rdf ."<br />\n
					<b>" . $nb_lieu . "</b> " . $l_lieu ."<br />\n
					<b>" . $nb_photos . "</b> " . $l_photos . "<br />\n
					<b>" . $nb_recits . "</b> " . $l_recits ."<br />";
			$return_go_to = $lang['go_to_the_rdf'];
			$return_url = append_sid( $phpbb_root_path . 'famille/rdf.php');
			break;
		default:
			return false;
	}
	

	$return_opif = short_desc($tab_rub[$indice][1],'opif');
	$return_last = short_desc($tab_rub[$indice][1],'last');
	return array(
			array(
				"RUBRIKOPIF" => $lang['Rubrikopif'],
				"RUBRIKOPIF_TITLE" => $return_title,
				"CHIFFRES" => $return_chiffres,
				"L_GO_TO" => $return_go_to,
				"URL" => $return_url
				),
			$return_opif,
			$return_last);
}
?>