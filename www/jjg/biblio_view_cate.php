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

if ($_GET['mode'] == 'add_book')
{
	$error = false;
	$error_msg = '';

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
		$sql_add = "INSERT INTO biblio_livre (cate_id,title,auteur_name,thanks,comment,nb_pages,bbcode_uid,date_add) VALUES(".$cate_id.",'".$title."','".$auteur."','".$thanks."','".$comment."',".$nb_pages.",'".$bbcode_uid."'," . date('Ymd') . ")";
		mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_add);
		if (!$error)
		{
			logger("Ajout du livre $title dans la bibliotèque");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("biblio_view_cate." . $phpEx."?cate_id=".$cate_id) . '">')
			);
			$message =  sprintf($lang['Upload_livre_ok'], '<a href="' . append_sid("biblio_view_cate." . $phpEx."?cate_id=".$cate_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

//
//Selection des livres de la rubrique choisie
//
$tab_livres = select_liste("SELECT * FROM biblio_livre WHERE cate_id= ".$_GET['cate_id']." ORDER BY livre_id");

$val_cate = select_element("SELECT * FROM biblio_cate WHERE cate_id= ".$_GET['cate_id']." ",'',false);

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='biblio' ORDER BY user_id");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_jjg'],'jjg');


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['bibliotheque'] . ' :: ' . $val_cate['cate_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/jjg/biblio_view_cate.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/jjg/colonne_gauche.tpl')
);


if ($img_mascotte)
$mascotte = $img_mascotte;
	
$template->assign_vars(array(

				'NOM_RUB_JJG' => $lang['nom_rub_jjg'],
				"RESPONSABLES" => $lang['Responsables'],
				'U_BIBLIO' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
				'U_BIO' => append_sid($phpbb_root_path . 'jjg/biographie.html'),
				'U_PHOTOS' => append_sid($phpbb_root_path . 'jjg/photos.html'),
				'L_BIBLIO' => $lang['bibliotheque'],
				'L_BIO' => $lang['biographie'],
				'L_PHOTOS' => $lang['Galerie_photo'],
				'CATE' => $val_cate['cate_name'],
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'jjg/bibliographie.html'),
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
						"U_ADMIN" => append_sid($phpbb_root_path . 'jjg/biblio_edit.php'),
						"L_ADMIN" =>  $lang['biblio_admin'],
						'CATE_ID' => $val_cate['cate_id'],
						'L_SUBMIT' => $lang['Submit'],
						'U_FORM' => append_sid($phpbb_root_path . 'jjg/biblio_view_cate.php?mode=add_book&cate_id='.$val_cate['cate_id']),
						'U_FORM2' => append_sid($phpbb_root_path . 'jjg/doedit.php?mode=edit_cate_book&cate_id='.$val_cate['cate_id']),
						'CATE_NAME' => $val_cate['cate_name'],
						'AJOUT_LIVRE'=> $lang['ajout_livre'],
						'L_TITRE' => $lang['l_titre'],
						'L_AUTEUR' => $lang['l_auteur'],
						'L_NBPAGES' => $lang['l_nbpages'],
						'L_COMMENT' => $lang['l_comment'],
						'L_THANKS' => $lang['l_thanks'],
						'RENAME_CATE'=> $lang['renomme_cate'],
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
// On définit le nombre de livre par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de livres totale (pour optimiser les calculs)
$nb_livres = count($tab_livres);
// Pour chaque ligne...
$i=0;
while($i<$nb_livres)
{
	$template->assign_block_vars('livres_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_livres;$j++)
	{
		$val_illu = select_element('SELECT * FROM biblio_illu WHERE livre_id = '.$tab_livres[$i]['livre_id'].' ORDER BY ordre LIMIT 0,1','',false);
		$ext = find_image('../images/biblio/livre_' . $val_illu['illu_id'] . '_' . $tab_livres[$i]['livre_id'].'.');
		if (is_file('../images/biblio/livre_' . $val_illu['illu_id'] . '_' . $tab_livres[$i]['livre_id'].'.'.$ext))
		{
			$img_livre = $phpbb_root_path . 'functions/miniature.php?mode=biblio&illu_id=' . $val_illu['illu_id'] . '&livre_id=' . $tab_livres[$i]['livre_id'];
		}else
		{
			$img_livre = '../templates/jjgfamille/images/site/px.png';	
		}
		$l_livre = $tab_livres[$i]['title'];
		$u_livre = append_sid($phpbb_root_path . 'jjg/ll' . $tab_livres[$i]['livre_id'] . '-' . str_replace('&amp;url_title=','',add_title_in_url($val_cate['cate_name'] . '-' . $tab_livres[$i]['title'])).'.html');
				
		$template->assign_block_vars('livres_row.livres_column',array(
							'U_LIVRE' => $u_livre,
							'L_LIVRE' => $l_livre,
							'LIVRE' => $img_livre,
							)
						);
		$i++;
	}
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