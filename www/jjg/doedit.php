<?

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'jjg';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_JJG);
init_userprefs($userdata);
//
// End session management
//
$job=array('photo','bio','biblio');
include($phpbb_root_path . 'includes/reserved_access.php');
include($phpbb_root_path . 'functions/functions.php');

switch($_GET['mode'])
{
		
	case "add_cate":
		if (!isset($_POST['cate_name']))
			die("Erreur dans la transmission des variables");
		$cate_name = $_POST['cate_name'];
		if ($cate_name == "")
			die("Le champs 'Nom de la catégorie' est obligatoire");
		
		$cate_name = htmlentities($cate_name);
			
		$sql_ordre = "SELECT ordre FROM famille_photo_cate ORDER BY ordre DESC";
		$result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br />Requète SQL : ".$sql_ordre);
		if (!$val_ordre = mysql_fetch_array($result_ordre))
			$val_ordre['ordre']=0;
		
		$val_ordre['ordre']++;
			
		$sql_add = "INSERT INTO famille_photo_cate (cate_name,ordre,artist_id) VALUES ('".$cate_name."',".$val_ordre['ordre'].",1)";
		mysql_query($sql_add) or die("Erreur Interne durant l'ajout de la catégorie<br />Requète SQL : ".$sql_add);
		logger("Ajout de la catégorie $cate_name dans la galerie photo");
		header("Location:" . append_sid("photos.php"));	
		break;
		
	case "edit_cate":
		if (!isset($_POST['cate_name']))
			die("Erreur dans la transmission des variables");
		$cate_name = $_POST['cate_name'];
		if ($cate_name == "")
			die("Le champs 'Nom de la catégorie' est obligatoire");
		
		$cate_name = htmlentities($cate_name);
		
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
				
		$sql_update = "UPDATE famille_photo_cate SET cate_name = '" . $cate_name . "' WHERE cate_id = " . $cate_id;
		mysql_query($sql_update) or die("Erreur Interne durant l'édition de la catégorie<br />Requète SQL : ".$sql_update);
		logger("Modification de la catégorie $cate_name dans la galerie photos");
		header("Location:" . append_sid("photos_view_cate.php?cate_id=" . $cate_id,true));
		break;	
			
	case "supp_cate";
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		
		$val_upload = select_element("SELECT cate_id FROM famille_photo_cate WHERE cate_name = 'upload' LIMIT 0,1",'',false);
		$tab_photo = select_liste("SELECT photo_id FROM famille_photo WHERE cate_id = ".$cate_id." ");
		
		for ($i=0;$i<count($tab_photo);$i++)
			{
				$ext = find_image("../images/photos/photo_".$cate_id."_".$tab_photo[$i]['photo_id'].".");
				$ext1 = find_image("../images/photos/photo_".$val_upload['cate_id']."_".$tab_photo[$i]['photo_id'].".");
				rename("../images/photos/photo_".$cate_id."_".$tab_photo[$i]['photo_id'].".".$ext,"../images/photos/photo_".$val_upload['cate_id']."_".$tab_photo[$i]['photo_id'].".".$ext1);
			}
			
		$sql_del = "DELETE FROM famille_photo_cate WHERE cate_id = ".$cate_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la catégorie<br />Requète SQL : ".$sql_del);
		logger("Suppression de la catégorie photo N°$cate_id");
		
		$sql_update = "UPDATE famille_photo SET cate_id = ".$val_upload['cate_id']." WHERE cate_id=".$cate_id;
		mysql_query($sql_update) or die("Erreur Interne durant la modification de la catégorie<br />Requète SQL : ".$sql_update);
		
		header("Location:" . append_sid("photos.php"));
		
		break;
						
	case "upcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		upasso('famille_photo_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("photos.php"));
		break;
		
	case "downcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		downasso('famille_photo_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("photos.php"));
		break;
		
	case "upphoto":
		if (!isset($_GET['photo_id']))
			die("Erreur dans la transmission des variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id == "")
			die("L'indication du la photo est obligatoire");
			if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
			
		upasso('famille_photo','photo_id',$photo_id,'cate_id');
		header("Location:" . append_sid("photos_view_cate.php?cate_id=".$cate_id."",true));
		break;
		
	case "downphoto":
		if (!isset($_GET['photo_id']))
			die("Erreur dans la transmission des variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id == "")
			die("L'indication de la photo est obligatoire");
		
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
			
		downasso('famille_photo','photo_id',$photo_id,'cate_id');
		header("Location:" . append_sid("photos_view_cate.php?cate_id=".$cate_id."",true));
		break;
		
	case "supp_photo";
		if (!isset($_GET['photo_id']))
			die("Erreur dans la transmission des variables");
		$photo_id = $_GET['photo_id'];
		if ($photo_id == "")
			die("L'indication du la photo est obligatoire");
			
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
			
		$sql_del = "DELETE FROM famille_photo WHERE photo_id = ".$photo_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la catégorie<br />Requète SQL : ".$sql_del);
		logger("Suppression de la photo $photo_id dans la galerie photo");
		
		$ext = find_image("../images/photos/photo_".$cate_id."_".$photo_id.".");
		unlink("../images/photos/photo_".$cate_id."_".$photo_id.".".$ext);
		
		header("Location:" . append_sid("photos_view_cate.php?cate_id=".$cate_id."",true));
		break;
		
	case "nb_photos":
		if (!isset($_POST['nb_photos']))
			die("Erreur de transmission de variables");
		$nb_photos = $_POST['nb_photos'];
		if ($nb_photos=="")
			die("Le champs 'nb_photos' est obligatoire");
		$nb_photos = htmlentities($nb_photos);
		$int_nb_photos =  (int)$nb_photos;
		if ($int_nb_photos <1)
		{	
			$msg = "Erreur : La valeur ".htmlentities($nb_photos)." est incorrecte";
			$error = 1;
		}
		else
		{	
			$sql_update = "UPDATE famille_config SET valeur_num = ".$int_nb_photos." WHERE param = 'nb_photo_by_page' ";
			mysql_query($sql_update) or die("Erreur Interne<br />Requète SQL invalide : ".$sql_update);
			logger("Modification de la variable du nombre de photo par page de la galerie");
			
			$error = 0;
			$msg="Le nombre de photos par page a été modifié à ".$int_nb_photos;
		}
		header("Location:" . append_sid("photos.php"));
		exit();

	case "add_page":
		if (!isset($_POST['title']))
			die("Erreur dans la transmission des variables");
		$title = $_POST['title'];
		if ($title == "")
			die("Le champs 'Titre' est obligatoire");
		$title = htmlentities($title);
		if (!isset($_POST['contenu']))
			die("Erreur dans la transmission des variables");
		$contenu = $_POST['contenu'];
		if ($contenu == "")
			die("Le champs 'Contenu' est obligatoire");
		
		$bbcode_uid = make_bbcode_uid();
		$contenu = delete_html($contenu);
		$contenu=bbencode_first_pass($contenu,$bbcode_uid);
  		$artist_id = 1;
  		
		$sql_archive = "SELECT * FROM famille_bio ORDER BY page DESC";
		$result_archive = mysql_query($sql_archive);
		if ($val_archive = mysql_fetch_array($result_archive))
		{
			$page=$val_archive['page']+1;
		} else {$page=1;} 
				 		
		$sql_add = "INSERT INTO famille_bio (title, contenu, page,user_id, artist_id,bbcode_uid,image) VALUES ('".$title."','".$contenu."',".$page.", ".$userdata['user_id']." ,".$artist_id.",'".$bbcode_uid."','N')";
		mysql_query($sql_add) or die("Erreur Interne durant l'ajout de la page<br />Requète SQL : ".$sql_add);
		logger("Ajout d'une page dans la biographie \"$title\"");
		header("Location:" . append_sid("bio_edit.php",true));
		exit;
		
	case "edit_page":
		if (!isset($_GET['bio_id']))
			die("Erreur dans la transmission des variables");
		$bio_id = $_GET['bio_id'];
		if ($bio_id == "")
			die("L'indication de la biographie est obligatoire");
			
		if (!isset($_POST['title']))
			die("Erreur dans la transmission des variables");
		$title = $_POST['title'];
		if ($title == "")
			die("Le champs 'Titre' est obligatoire");
		$title = htmlentities($title);
		if (!isset($_POST['contenu']))
			die("Erreur dans la transmission des variables");
		$contenu = $_POST['contenu'];
		if ($contenu == "")
			die("Le champs 'Contenu' est obligatoire");
		
		$bbcode_uid = make_bbcode_uid();
		$contenu = delete_html($contenu);
		$contenu=bbencode_first_pass($contenu,$bbcode_uid);
			
		$sql_update = "UPDATE famille_bio SET title = '" . $title . "',contenu = '" . $contenu . "',bbcode_uid = '".$bbcode_uid."'  WHERE bio_id = " . $bio_id;
		mysql_query($sql_update) or die("Erreur Interne durant l'édition de la page<br />Requète SQL : ".$sql_update);
		logger("Édition de la page \"$title\" dans la biographie");
		header("Location:" . append_sid("bio.php?bio_id=" . $bio_id,true));
		break;
		
	case "add_pic_page":
	if (!isset($_GET['bio_id']))
			die("Erreur dans la transmission des variables");
		$bio_id = $_GET['bio_id'];
		if ($bio_id == "")
			die("L'indication de la biographie est obligatoire");	
	if ($HTTP_POST_FILES['userfile']['tmp_name'] == "none")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
			
	include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
	
	
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload!= '')
	{
		$error = false;
		$error_msg = '';
		
		user_upload_easy(
				$error,
				$error_msg,
				$HTTP_POST_FILES['userfile'],
				$phpbb_root_path . 'images/bio/bio_'.$bio_id ,
				array(
					$site_config['photo_max_filesize'],
					$site_config['photo_max_width'],
					$site_config['photo_max_height'])
				);
	}
	
	$sql_update = "UPDATE famille_bio SET image = 'Y' WHERE bio_id = " . $bio_id;
	mysql_query($sql_update) or die("Erreur Interne durant l'édition de la page<br />Requète SQL : ".$sql_update);
	logger("Ajout d'une illustration dans la biographie");
	header("Location:" . append_sid("bio.php?bio_id=" . $bio_id,true));
	break;
	
	case "supp_page":
		if (!isset($_GET['bio_id']))
			die("Erreur dans la transmission des variables");
		$bio_id = $_GET['bio_id'];
		if ($bio_id == "")
			die("L'indication de la biographie est obligatoire");
			
			
		$sql_del = "DELETE FROM famille_bio WHERE bio_id = ".$bio_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la page<br />Requète SQL : ".$sql_del);
		logger("Suppression d'une page de la biographie");
		
		$ext = find_image("../images/bio/bio_".$bio_id.".");
		if (is_file("../images/bio/bio_".$bio_id.".".$ext))
		{
		   unlink("../images/bio/bio_".$bio_id.".".$ext);
		}
		
		header("Location:" . append_sid("bio_edit.php"));
		break;
			
	case "supp_pic_page":
		if (!isset($_GET['bio_id']))
			die("Erreur dans la transmission des variables");
		$bio_id = $_GET['bio_id'];
		if ($bio_id == "")
			die("L'indication de la biographie est obligatoire");
			
		$ext = find_image("../images/bio/bio_".$bio_id.".");
		unlink("../images/bio/bio_".$bio_id.".".$ext);
		
		$sql_update = "UPDATE famille_bio SET image = 'N' WHERE bio_id = " . $bio_id;
		mysql_query($sql_update) or die("Erreur Interne durant l'édition de la page<br />Requète SQL : ".$sql_update);
		logger("Suppression d'une illustration de la biographie");
		header("Location:" . append_sid("bio.php?bio_id=" . $bio_id,true));
		break;
		
	case "biblio_add_cate":
		if (!isset($_POST['cate_name']))
			die("Erreur dans la transmission des variables");
		$cate_name = $_POST['cate_name'];
		if ($cate_name == "")
			die("Le champs 'Nom de la catégorie' est obligatoire");
		$cate_name = htmlentities($cate_name);	
		$sql_ordre = "SELECT ordre FROM biblio_cate ORDER BY ordre DESC";
		$result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br />Requète SQL : ".$sql_ordre);
		if (!$val_ordre = mysql_fetch_array($result_ordre))
			$val_ordre['ordre']=0;
		
		$val_ordre['ordre']++;
			
		$sql_add = "INSERT INTO biblio_cate (cate_name,ordre,artist_id) VALUES ('".$cate_name."',".$val_ordre['ordre'].",1)";
		mysql_query($sql_add) or die("Erreur Interne durant l'ajout de la catégorie<br />Requète SQL : ".$sql_add);
		logger("Ajout de la catégorie \"$cate_name\" dans la bibliographie");
		header("Location:" . append_sid("biblio.php"));	
		break;
					
	case "biblio_supp_cate";
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		
		/////////Suppression des livres///////////
		//Selection des livres à supprimer
		$tab_livre = select_liste("SELECT livre_id FROM biblio_livre WHERE cate_id = ".$cate_id." ");
		
		for ($i=0;$i<count($tab_livre);$i++)
			{	
				//Suppression des editions
				$del_edition = "DELETE FROM biblio_editeur WHERE livre_id = ".$tab_livre[$i]['livre_id']." ";
				mysql_query($del_edition) or die("Erreur Interne durant la suppression de l'edition<br />Requète SQL : ".$del_edition);
				/////////Suppression des illustrations///////////
				//Selection des illustrations à supprimer
				$tab_illu = select_liste("SELECT illu_id,livre_id FROM biblio_illu WHERE livre_id = ".$tab_livre[$i]['livre_id']." ");
				//Suppression des illustrations dans la base
				$del_illu = "DELETE FROM biblio_illu WHERE livre_id = ".$tab_livre[$i]['livre_id']." ";
				mysql_query($del_illu) or die("Erreur Interne durant la suppression de l'edition<br />Requète SQL : ".$del_illu);
				//Suppression des illustrations sur le site 
				for ($i=0;$i<count($tab_illu);$i++)
					{
					   $ext = find_image("../images/biblio/livre_".$tab_illu[$i]['illu_id']."_".$tab_livre[$i]['livre_id'].".");
					   unlink("../images/biblio/livre_".$tab_illu[$i]['illu_id']."_".$tab_livre[$i]['livre_id'].".".$ext);		
					}
			}
		
		//Suppression des livres
		$del_livre = "DELETE FROM biblio_livre WHERE cate_id = ".$cate_id;
		mysql_query($del_livre) or die("Erreur Interne durant la suppression du livre<br />Requète SQL : ".$del_livre);
		
		/////////Suppression de la categorie///////////
		$sql_del = "DELETE FROM biblio_cate WHERE cate_id = ".$cate_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de la catégorie<br />Requète SQL : ".$sql_del);
		logger("Suppression d'une catégorie de la bibliographie");
		
		header("Location:" . append_sid("biblio.php"));
		
		break;
						
	case "biblio_upcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		upasso('biblio_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("biblio.php"));
		break;
		
	case "biblio_downcate":
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
		downasso('biblio_cate','cate_id',$cate_id,'artist_id');
		header("Location:" . append_sid("biblio.php"));
		break;
		
	case "edit_cate_book":
		if (!isset($_POST['cate_name']))
			die("Erreur dans la transmission des variables");
		$cate_name = $_POST['cate_name'];
		if ($cate_name == "")
			die("Le champs 'Nom de la catégorie' est obligatoire");
		$cate_name = htmlentities($cate_name);
		if (!isset($_GET['cate_id']))
			die("Erreur dans la transmission des variables");
		$cate_id = $_GET['cate_id'];
		if ($cate_id == "")
			die("L'indication du la catégorie est obligatoire");
				
		$sql_update = "UPDATE biblio_cate SET cate_name = '" . $cate_name . "' WHERE cate_id = " . $cate_id;
		mysql_query($sql_update) or die("Erreur Interne durant l'édition de la catégorie<br />Requète SQL : ".$sql_update);
		logger("Édition de la catégorie $cate_name dans la bibliographie");
		header("Location:" . append_sid("biblio_view_cate.php?cate_id=" . $cate_id,true));
		break;
		
	case "upedition":
		if (!isset($_GET['editeur_id']))
			die("Erreur dans la transmission des variables");
		$editeur_id = $_GET['editeur_id'];
		if ($editeur_id == "")
			die("L'indication du l' edition est obligatoire");
		if (!isset($_GET['livre_id']))
			die("Erreur dans la transmission des variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id == "")
			die("L'indication du livre est obligatoire");
			
		upasso('biblio_editeur','editeur_id',$editeur_id,'livre_id');
		header("Location:" . append_sid("biblio_view_livre.php?livre_id=" . $livre_id,true));
		break;
		
	case "downedition":
		if (!isset($_GET['editeur_id']))
			die("Erreur dans la transmission des variables");
		$editeur_id = $_GET['editeur_id'];
		if ($editeur_id == "")
			die("L'indication du l' edition est obligatoire");
		if (!isset($_GET['livre_id']))
			die("Erreur dans la transmission des variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id == "")
			die("L'indication du livre est obligatoire");
			
		downasso('biblio_editeur','editeur_id',$editeur_id,'livre_id');
		header("Location:" . append_sid("biblio_view_livre.php?livre_id=" . $livre_id,true));
		break;	
	
	case "supp_edition";
		if (!isset($_GET['editeur_id']))
			die("Erreur dans la transmission des variables");
		$editeur_id = $_GET['editeur_id'];
		if ($editeur_id == "")
			die("L'indication du l' edition est obligatoire");
		if (!isset($_GET['livre_id']))
			die("Erreur dans la transmission des variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id == "")
			die("L'indication du llivre est obligatoire");
		
		$sql_del = "DELETE FROM biblio_editeur WHERE editeur_id = ".$editeur_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de l'edition<br />Requète SQL : ".$sql_del);
		logger("Suppression d'une édition du livre N°$livre_id");
		header("Location:" . append_sid("biblio_view_livre.php?livre_id=" . $livre_id,true));
		break;
				
	case "supp_illu":
		if (!isset($_GET['illu_id']))
			die("Erreur dans la transmission des variables");
		$illu_id = $_GET['illu_id'];
		if ($illu_id == "")
			die("L'indication de l'illustration est obligatoire");
		if (!isset($_GET['livre_id']))
			die("Erreur dans la transmission des variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id == "")
			die("L'indication du livre est obligatoire");
		
		$ext = find_image("../images/biblio/livre_".$illu_id."_".$livre_id.".");		
		unlink("../images/biblio/livre_".$illu_id."_".$livre_id.".".$ext);
		
		$sql_del = "DELETE FROM biblio_illu WHERE illu_id = ".$illu_id;
		mysql_query($sql_del) or die("Erreur Interne durant la suppression de l'illustration<br />Requète SQL : ".$sql_del);
		logger("Suppression d'une illustration du livre N°$livre_id");
		header("Location:" . append_sid("biblio_view_livre.php?livre_id=" . $livre_id,true));
		break;
		
	case "upillu":
		if (!isset($_GET['illu_id']))
			die("Erreur dans la transmission des variables");
		$illu_id = $_GET['illu_id'];
		if ($illu_id == "")
			die("L'indication du l'illustration est obligatoire");
		if (!isset($_GET['livre_id']))
			die("Erreur dans la transmission des variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id == "")
			die("L'indication du livre est obligatoire");
			
		upasso('biblio_illu','illu_id',$illu_id,'livre_id');
		header("Location:" . append_sid("biblio_view_livre.php?livre_id=" . $livre_id,true));
		break;
		
	case "downillu":
		if (!isset($_GET['illu_id']))
			die("Erreur dans la transmission des variables");
		$illu_id = $_GET['illu_id'];
		if ($illu_id == "")
			die("L'indication du l'illustration est obligatoire");
		if (!isset($_GET['livre_id']))
			die("Erreur dans la transmission des variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id == "")
			die("L'indication du livre est obligatoire");
			
		downasso('biblio_illu','illu_id',$illu_id,'livre_id');
		header("Location:" . append_sid("biblio_view_livre.php?livre_id=" . $livre_id,true));
		break;	
		
	case "supp_book";
	
		if (!isset($_GET['livre_id']))
			die("Erreur dans la transmission des variables");
		$livre_id = $_GET['livre_id'];
		if ($livre_id == "")
			die("L'indication du livre est obligatoire");
		
			
		//Suppression des editions//
		$del_edition = "DELETE FROM biblio_editeur WHERE livre_id = ".$livre_id." ";
		mysql_query($del_edition) or die("Erreur Interne durant la suppression de l'edition<br />Requète SQL : ".$del_edition);	
		//Selection des illustrations à supprimer
		$tab_illu = select_liste("SELECT illu_id,livre_id FROM biblio_illu WHERE livre_id = ".$livre_id." ");
		//Suppression des illustrations dans la base
		$del_illu = "DELETE FROM biblio_illu WHERE livre_id = ".$livre_id." ";
		mysql_query($del_illu) or die("Erreur Interne durant la suppression de l'edition<br />Requète SQL : ".$del_illu);
		//Suppression des illustrations sur le site 
		for ($i=0;$i<count($tab_illu);$i++)
			{
				$ext = find_image("../images/biblio/livre_".$tab_illu[$i]['illu_id']."_".$livre_id.".");
				unlink("../images/biblio/livre_".$tab_illu[$i]['illu_id']."_".$livre_id.".".$ext);		
			}
			
		//Suppression du livre//
		$del_livre = "DELETE FROM biblio_livre WHERE livre_id = ".$livre_id;
		mysql_query($del_livre) or die("Erreur Interne durant la suppression du livre<br />Requète SQL : ".$del_livre);
		logger("Suppression du livre N°$livre_id");
		
		header("Location:" . append_sid("biblio.php"));
		
		break;	
	default:
		die("Commande " . $_GET['mode'] ." inconnue");
}
exit();
?>