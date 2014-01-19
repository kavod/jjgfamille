<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'jjg';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_JJG);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mode'] == 'add_illu')
{
	$error = false;
	$error_msg = '';
	
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
	
	$livre_id = $_GET['livre_id'];	
	$commentaire = $_POST['commentaire'];
	$bbcode_uid = make_bbcode_uid();
	$commentaire = delete_html($commentaire);
	$commentaire=bbencode_first_pass($commentaire,$bbcode_uid);
	
	$sql_ordre = "SELECT ordre FROM biblio_illu ORDER BY ordre DESC";
	$result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br />Requète SQL : ".$sql_ordre);
	if (!$val_ordre = mysql_fetch_array($result_ordre))
		$val_ordre['ordre']=0;
		
	$val_ordre['ordre']++;
	
	if (!$error)
	{
		$sql_add = "INSERT INTO biblio_illu (livre_id,comment,bbcode_uid,ordre) VALUES('".$livre_id."','".$commentaire."','".$bbcode_uid."',".$val_ordre['ordre'].")";
		mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_add);
		logger("Ajout d'une illustration pour le livre N°$livre_id");
		
		$illu_id = mysql_insert_id();
		
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy(
					$error,
					$error_msg,
					$HTTP_POST_FILES['userfile'],
					$phpbb_root_path . 'images/biblio/livre_' . $illu_id .'_'.$livre_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['photo_max_width'],
						$site_config['photo_max_height'])
					);
			if ($error)
			{
				$sql_del = "DELETE FROM biblio_illu WHERE illu_id = " . $illu_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
				logger("Suppression de l'illustration N°$illu_id pour le livre N°$livre_id après une erreur d'upload");
			}
		}
		if (!$error)
		{
			
			
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("biblio_view_livre." . $phpEx."?livre_id=".$livre_id) . '">')
				);
				$message =  sprintf($lang['Upload_illu_ok'], '<a href="' . append_sid("biblio_view_livre." . $phpEx."?livre_id=".$livre_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
			
				
		}
	}	
}		

if ($_GET['mode'] == 'update_book')
{
	$error = false;
	$error_msg = '';

	$livre_id = $_GET['livre_id'];
	
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"titre\" est obligatoire");
	$title = htmlentities($title);
	if (!isset($_POST['auteur']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$auteur = $_POST['auteur'];
	if ($auteur=="")
		list($error,$error_msg) = array( true , "Le champs \"auteur\" est obligatoire");
	$auteur = htmlentities($auteur);
	if (!isset($_POST['nb_pages']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$nb_pages = $_POST['nb_pages'];
	if ($nb_pages=="")
		list($error,$error_msg) = array( true , "Le champs \"nombre de pages\" est obligatoire");
	$nb_pages = htmlentities($nb_pages);			
	$cate_id=$_POST['cate_id'];
	$bbcode_uid = make_bbcode_uid();
	$comment = $_POST['commentaire'];
	$comment = delete_html($comment);
	$comment=bbencode_first_pass($comment,$bbcode_uid);
	
	$thanks = $_POST['thanks'];
	$thanks = delete_html($thanks);
	$thanks=bbencode_first_pass($thanks,$bbcode_uid);
	
	
	if (!$error)
	{
		$sql_update = "UPDATE biblio_livre SET cate_id='".$cate_id."',title='".$title."',auteur_name='".$auteur."',thanks='".$thanks."',comment='".$comment."',nb_pages='".$nb_pages."',bbcode_uid='".$bbcode_uid."' WHERE livre_id=".$livre_id." ";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		if (!$error)
		{
			logger("Modification du livre $title dans la bibliothéque");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("biblio_view_livre." . $phpEx."?livre_id=".$livre_id) . '">')
			);
			$message =  sprintf($lang['Upload_livre_ok'], '<a href="' . append_sid("biblio_view_livre." . $phpEx."?livre_id=".$livre_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

if ($_GET['mode'] == 'add_edition' || $_GET['mode'] == 'edit_edition')
{
	$error = false;
	$error_msg = '';
	
	$livre_id = $_GET['livre_id'];
	
	if (!isset($_POST['editeur']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$editeur = $_POST['editeur'];
	if ($editeur=="")
		list($error,$error_msg) = array( true , "Le champs \"editeur\" est obligatoire");
	$editeur = htmlentities($editeur);
	if (!isset($_POST['date']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$date = $_POST['date'];
	if ($date=="")
		list($error,$error_msg) = array( true , "Le champs \"date\" est obligatoire");
	$date = htmlentities($date);
	if (!isset($_POST['isbn']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$isbn = $_POST['isbn'];
	$isbn = htmlentities($isbn);
	$isbn = ($isbn=='') ? 'NULL' : "'" . $isbn . "'";
	$asin = $_POST['asin'];
	$asin = htmlentities($asin);
	if($asin == '')
	 {
		$asin = 0;
	 }
	$collections = $_POST['collections'];
	$collections = htmlentities($collections);
	$sql_ordre = "SELECT ordre FROM biblio_editeur ORDER BY ordre DESC";
	$result_ordre = mysql_query($sql_ordre) or die("Erreur Interne<br />Requète SQL : ".$sql_ordre);
	if (!$val_ordre = mysql_fetch_array($result_ordre))
		$val_ordre['ordre']=0;
		
	$val_ordre['ordre']++;
				
	if (!$error)
	{
		if ($_GET['mode'] == 'add_edition')
		{
			$sql_add = "INSERT INTO biblio_editeur (livre_id,date,ISBN,ASIN,editeur_name,collections,ordre) VALUES('".$livre_id."','".$date."',".$isbn.",'".$asin."','".$editeur."','".$collections."',".$val_ordre['ordre'].")";
			mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_add);
			logger("Ajout de l'edition $editeur du livre N°$livre_id dans la bibliothèque");
		}elseif($_GET['mode'] == 'edit_edition')
		{
			$sql_add = "UPDATE biblio_editeur SET date='".$date."',ISBN=$isbn, ASIN='".$asin."',editeur_name='".$editeur."',collections='".$collections."' WHERE editeur_id=".$_GET['editeur_id'];
			mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_add);
			logger("Modification de l'edition du livre N°$livre_id dans la bibliothèque");
		}
		if (!$error)
		{
			
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("biblio_view_livre." . $phpEx."?livre_id=".$livre_id) . '">')
			);
			$message =  sprintf($lang['Upload_edition_ok'], '<a href="' . append_sid("biblio_view_livre." . $phpEx."?livre_id=".$livre_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

//Selection du livre choisi
$val_livre = select_element("SELECT * FROM biblio_livre WHERE livre_id= ".$_GET['livre_id']."  LIMIT 0,1",'',false);

//Liste des categories
$tab_liste = select_liste("SELECT * FROM biblio_cate ORDER BY ordre");

//Selection des differentes editions 
$tab_edition = select_liste("SELECT * FROM biblio_editeur WHERE livre_id= ".$_GET['livre_id']." ORDER BY ordre");

//Selection des differentes illustrations 
$tab_illu = select_liste("SELECT * FROM biblio_illu WHERE livre_id= ".$_GET['livre_id']." ORDER BY ordre");

//Selection de la categorie concernée
$val_cate = select_element("SELECT cate_name FROM biblio_cate WHERE cate_id= ".$val_livre['cate_id']."  LIMIT 0,1",'',false);

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='biblio' ORDER BY user_id");

//Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');

//Selection de l'edition
if (isset($_GET['editeur_id']) && $_GET['editeur_id'] != '')
{
	$val_edition = select_element("SELECT * FROM biblio_editeur WHERE editeur_id = " . $_GET['editeur_id'] . "",'',false);
	$l_add_edition = $lang['Ajouter une edition'];
	$u_add_edition = append_sid($phpbb_root_path . 'jjg/biblio_view_livre.php?livre_id='.$_GET['livre_id']);
	$bouton = $lang['Modifier'];
	$form_edition = append_sid($phpbb_root_path . 'jjg/biblio_view_livre.php?mode=edit_edition&livre_id='.$val_livre['livre_id'].'&editeur_id='.$val_edition['editeur_id']);
}else
{
	$l_add_edition = '';
	$bouton = $lang['Ajouter'];
	$form_edition = append_sid($phpbb_root_path . 'jjg/biblio_view_livre.php?mode=add_edition&livre_id='.$val_livre['livre_id']);
}
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/biblio_view_livre.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'biblio'))
		{
		//$l_admin = $lang['modifier'];
		$u_admin = append_sid('biblio_edit_livre.php?livre_id='.$val_livre['editeur_id']);			
		}

for ($i=0;$i<count($tab_illu);$i++)
{
	//IMAGE
	$url_image = $phpbb_root_path . 'images/biblio/livre_'.$tab_illu[$i]['illu_id'].'_'.$val_livre['livre_id'].'.';
	$ext = find_image($url_image);
	$url_image .= $ext;
	if (is_file($url_image))
	$image = $phpbb_root_path . 'functions/miniature.php?mode=biblio&illu_id=' . $tab_illu[$i]['illu_id'] . '&livre_id=' . $val_livre['livre_id'];
	else $image = '';
	
	$size = getimagesize($url_image);
	
	if($tab_illu[$i]['comment'] == "")
	{
		$height = $size[1]+20;
	}else
	{
		$height = $size[1]+100;		
	}
	
	$onclick = " window.open('jaquette.php?jack_id=".$tab_illu[$i]['illu_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
	
	$template->assign_block_vars('switch_illu',array(
						'ILLU' => $image,
						'ONCLICK' => $onclick,
						)
					);
}


$template->assign_vars(array(

				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'TITRE_LIVRE' => $val_livre['title'],
				'COMMENTAIRE_LIVRE' => nl2br(bbencode_second_pass($val_livre['comment'],$val_livre['bbcode_uid'])),
				'U_CATE' => append_sid($phpbb_root_path . 'jjg/lc'. $val_livre['cate_id'] . '-' . str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name']).'.html')),
				'CATE' => $lang['categorie'],
				'L_CATE' => $val_cate['cate_name'],
				"L_ADMIN" => $l_admin,
				"U_ADMIN" => $u_admin,
				'AUTEUR_LIVRE' => $val_livre['auteur_name'],
				'THANKS' => nl2br(bbencode_second_pass($val_livre['thanks'],$val_livre['bbcode_uid'])),
				'NB_PAGES' => $val_livre['nb_pages'],
				'COLLECTIONS' => $val_livre['collections'],
				"IMG_MASCOTTE" => $mascotte,
				'L_TITRE' => $lang['l_titre'],
				'L_AUTEUR' => $lang['l_auteur'],
				'L_COLLECTIONS' => $lang['l_collections'],
				'L_NBPAGES' => $lang['l_nbpages'],
				'L_COMMENT' => $lang['l_comment'],
				'L_THANKS' => $lang['l_thanks'],
				'DIFF_EDITIONS' => $lang['diff_editions'],
				'L_EDITEUR' => $lang['l_editeur'],
				'L_DATE_EDITION' => $lang['l_date_edition'],
				'L_ISBN' => $lang['l_isbn'],
				'L_COMMANDER' => $lang['l_commander'],
				'L_EDITION' => $lang['l_edition'],
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/lc'. $val_livre['cate_id'] . '-' . str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name']).'.html')),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'jjg/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'biblio'))
{
		$template->assign_block_vars('switch_admin',array(
						"L_ADMIN" =>  $lang['biblio_admin'],
						'L_SUBMIT' => $lang['Submit'],
						'U_FORM' => append_sid($phpbb_root_path . 'jjg/biblio_view_livre.php?mode=update_book&livre_id='.$val_livre['livre_id']),
						'U_FORM2' => $form_edition,
						'U_FORM3' => append_sid($phpbb_root_path . 'jjg/biblio_view_livre.php?mode=add_illu&livre_id='.$val_livre['livre_id']),
						'U_SUPP' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_book&livre_id='.$val_livre['livre_id']),
						'CATE_NAME' => $val_cate['cate_name'],
						'TITRE' => $val_livre['title'],
						'AUTEUR' => $val_livre['auteur_name'],
						'COLLECTIONS' => addslashes($val_livre['collections']),
						'NB_PAGES' => $val_livre['nb_pages'],
						'COMMENTAIRES' =>  preg_replace('/\:(([a-z0-9]:)?)' . $val_livre['bbcode_uid'] . '/s', '', $val_livre['comment']),
						'THANKS' =>  preg_replace('/\:(([a-z0-9]:)?)' . $val_livre['bbcode_uid'] . '/s', '', $val_livre['thanks']),
						'L_TITRE' => $lang['l_titre'],
						'L_AUTEUR' => $lang['l_auteur'],
						'L_COLLECTIONS' => $lang['l_collections'],
						'L_NBPAGES' => $lang['l_nbpages'],
						'L_COMMENT' => $lang['l_comment'],
						'L_THANKS' => $lang['l_thanks'],
						'MODIF_LIVRE' => $lang['modif_livre'],
						'AJOUT_EDITION' => $lang['ajout_edition'],
						'LISTE_EDITIONS'=> $lang['liste_editions'],
						'L_EDITEUR' => $lang['l_editeur'],
						'L_DATE_EDITION' => $lang['l_date_edition'],
						'L_ISBN' => $lang['l_isbn'],
						'L_ASIN' => $lang['Code produit'],
						'L_ILLU' => $lang['l_illu'],
						'AJOUT_ILLU'=> $lang['ajout_illu'],
						'L_SUPP'=> $lang['supp_livre'],
						'TITRE_LIVRE' => $val_livre['title'],
						'L_EDITION' => $lang['l_edition'],
						'L_CONFIRM_SUPP_LIVRE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['livre'])))),
						'VAL_EDITION' => $val_edition['editeur_name'],
						'VAL_COLLECTIONS' => $val_edition['collections'],
						'VAL_DATE' => $val_edition['date'],
						'VAL_ISBN' => ($val_edition['ISBN']=='NULL') ? '' : $val_edition['ISBN'],
						'VAL_ASIN' => $val_edition['ASIN'],
						'BOUTON' => $bouton,
						'L_ADD_EDITION' => $l_add_edition,
						'U_ADD_EDITION' => $u_add_edition,
						)
					);
		
		for ($i=0;$i<count($tab_edition);$i++)
		{
	
				$template->assign_block_vars('switch_admin.switch_edition',array(
						'EDITEUR' => $tab_edition[$i]['editeur_name'],
						'DATE' => $tab_edition[$i]['date'],
						'ISBN' => $tab_edition[$i]['ISBN'],
						'COLLECTIONS' => $tab_edition[$i]['collections'],
						'U_AMAZON' => 'http://www.amazon.fr/exec/obidos/ASIN/' . $tab_edition[$i]['ASIN'] . '/famille-21',
						'L_MONTER' => $lang['monter'],
						'U_MONTER' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=upedition&editeur_id='.$tab_edition[$i]['editeur_id'].'&livre_id='.$_GET['livre_id']),
						'L_DESCENDRE' => $lang['descendre'],
						'U_DESCENDRE' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=downedition&editeur_id='.$tab_edition[$i]['editeur_id'].'&livre_id='.$_GET['livre_id']),
						'L_SUPPRIMER' => $lang['supprimer'],
						'U_SUPPRIMER' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_edition&editeur_id='.$tab_edition[$i]['editeur_id'].'&livre_id='.$_GET['livre_id']),
						'L_MODIFIER' => $lang['Modifier'],
						'U_MODIFIER' => append_sid($phpbb_root_path . 'jjg/biblio_view_livre.php?editeur_id='.$tab_edition[$i]['editeur_id'].'&livre_id='.$_GET['livre_id']),
						'L_CONFIRM_SUPP_EDITION' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['edition'])))),
						)
					);
		}
					
		for ($i=0;$i<count($tab_liste);$i++)
			{
	
				$template->assign_block_vars('switch_admin.mes_options',array(
						"VALUE" => $tab_liste[$i]['cate_id'],
      						"INTITULE" => $tab_liste[$i]['cate_name'],
      						"SELECTED" => ($tab_liste[$i]['cate_id'] == $val_livre['cate_id'] ) ? " SELECTED" : ""
						)
					);

			}
		
		for ($i=0;$i<count($tab_illu);$i++)
			{
	//IMAGE
	$url_image = $phpbb_root_path . 'images/biblio/livre_'.$tab_illu[$i]['illu_id'].'_'.$val_livre['livre_id'].'.';
	$ext = find_image($url_image);
	$url_image .= $ext;
	if (is_file($url_image))
	$image = $phpbb_root_path . 'functions/miniature.php?mode=biblio&illu_id=' . $tab_illu[$i]['illu_id'] . '&livre_id=' . $val_livre['livre_id'];
	else $image = '';
	
	$size = getimagesize($url_image);
	
	if($tab_illu[$i]['comment'] == "")
	{
		$height = $size[1]+20;
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'biblio'))
		{
			$height = $height + 180 ;
		}
	}else
	{
		$height = $size[1]+100;	
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'biblio'))
		{
			$height = $height + 100 ;
		}	
	}
	
	$onclick = " window.open('jaquette.php?jack_id=".$tab_illu[$i]['illu_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
	
	$template->assign_block_vars('switch_admin.switch_illu',array(
						'ILLU' => $image,
						'U_ILLU' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=supp_illu&illu_id='.$tab_illu[$i]['illu_id'].'&livre_id='.$_GET['livre_id']),
						'ONCLICK' => $onclick,
						'U_MONTER' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=upillu&illu_id='.$tab_illu[$i]['illu_id'].'&livre_id='.$_GET['livre_id']),						
						'U_DESCENDRE' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=downillu&illu_id='.$tab_illu[$i]['illu_id'].'&livre_id='.$_GET['livre_id']),
						'L_CONFIRM_SUPP_ILLU' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['picture'])))),
						'SUPP_ILLU' => sprintf($lang['delete'],sprintf($lang['l'],$lang['picture'])),
						)
					);
		}
					
}

for ($i=0;$i<count($tab_edition);$i++)
{
	if ($tab_edition[$i]['ASIN'] == 0)
        {
     	   $u_amazon = "http://www3.fnac.com/search/quick.do?category=book&text=".$val_livre['title']."&Origin=JJGFAMILLE&OriginClick=yes"; 
     	   //$u_amazon = "http://www3.fnac.com/advanced/book.do?isbn=".$tab_edition[$i]['ISBN']."&Origin=JJGFAMILLE&OriginClick=yes";
        
        }else
        {
     	   $u_amazon = 'http://www.fnac.com/Shelf/article.asp?PRID=' . $tab_edition[$i]['ASIN'] . '&Origin=JJGFAMILLE&OriginClick=yes';
        }
        
	$template->assign_block_vars('switch_edition',array(
						'EDITEUR' => $tab_edition[$i]['editeur_name'],
						'DATE' => $tab_edition[$i]['date'],
						'ISBN' => ($tab_edition[$i]['ISBN']=='NULL') ? '' : $tab_edition[$i]['ISBN'],
						'U_AMAZON' => $u_amazon,
						'COLLECTIONS' => $tab_edition[$i]['collections'],
						'IMG_COMMANDER' => "../images/commander_100x30_03.gif",
						'COMMAND' => $lang['Amazon_buy'],
						)
					);
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('biblio','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );

if ( $error )
{
	$template->set_filenames(array(
		'reg_header' => 'error_body.tpl')
	);
	$template->assign_vars(array(
		'ERROR_MESSAGE' => $error_msg)
	);
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}


$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>