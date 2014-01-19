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

if ($_GET['mode'] == 'add')
{
	$error = false;
	$error_msg = '';
		
	if (!isset($_POST['title']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$title = $_POST['title'];
	if ($title=="")
		list($error,$error_msg) = array( true , "Le champs \"Nom\" est obligatoire");
	$title = htmlentities($title);
	
	if (!isset($_POST['desc']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$desc = $_POST['desc'];
	if ($desc=="")
		list($error,$error_msg) = array( true , "Le champs \"Description\" est obligatoire");
	$title = htmlentities($title);
	
	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$comment = $_POST['comment'];
		
	$bbcode_uid = make_bbcode_uid();
	$comment = delete_html($comment);
	$comment=bbencode_first_pass($comment,$bbcode_uid);
	
	if (!$error)
	{
		$sql_update = "INSERT INTO famille_rub (name,description,contenu,bbcode_uid) VALUES('".$title."','".$desc."','".$comment."','".$bbcode_uid."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
	
		$rub_id = mysql_insert_id();
		
		// Ajout de la mascotte
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy(
					$error,
					$error_msg,
					$HTTP_POST_FILES['userfile'],
					$phpbb_root_path . 'images/famille/rub_' . $rub_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['mascotte_max_width'],
						$site_config['mascotte_max_height'])
					);
			if ($error)
			{
				$sql_del = "DELETE FROM famille_rub WHERE rub_id = " . $rub_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
				logger("Suppression de la rubrique N°$rub_id suite à l'echec de l'upload");
			}
			
		}
	
		if (!$error)
		{
			logger("Ajout de la rubrique $title dans famille");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index." . $phpEx) . '">')
				);
				$message =  sprintf($lang['Upload_rub_ok'], '<a href="' . append_sid("index." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

$tab_rub1 = select_liste("SELECT * FROM `famille_rub` ORDER BY `ordre`");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array());

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Famille'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'site/famille/index.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}

$template->assign_vars($rubrikopif[0]);


if ($img_mascotte)
$mascotte = $img_mascotte;

//Chiffres equipes
$tab_equipe = select_liste("SELECT A.user_id,A.username FROM phpbb_users A,phpbb_user_group B WHERE A.user_id = B.user_id AND B.group_id = 10 AND user_rank <> 1");
$tab_equipe_admin = select_liste("SELECT user_id,username FROM phpbb_users WHERE user_rank = 1 AND user_id <> 2");
$val_equipe = select_element("SELECT A.user_id,A.username,user_avatar FROM phpbb_users A,phpbb_user_group B WHERE A.user_id = B.user_id AND B.group_id = 10 ORDER BY RAND() LIMIT 0,1",'',false);
if (is_file('../images/forum/avatars/' . $val_equipe['user_avatar']))
	$avatar = '../images/forum/avatars/' . $val_equipe['user_avatar'];
else
	$avatar = '../templates/jjgfamille/images/site/px.png';	


//Chiffres rdf
$accedez_rdf = rubrikopif(array('rdf'));
$val_image = select_element("SELECT * FROM rdf_photos ORDER BY RAND() LIMIT 0,1",'',false);
$ext = find_image('../images/rdf/photo_' . $val_image['rdf_id'] . '_'. $val_image['photo_id'].'.');
if (is_file('../images/rdf/photo_' . $val_image['rdf_id'] . '_'. $val_image['photo_id'].'.'.$ext))
	$img_rdf = $phpbb_root_path . 'functions/miniature.php?mode=rdf&photo_id=' . $val_image['photo_id'] .'&rdf_id=' . $val_image['rdf_id'] . "&tnH=112";
else
	$img_rdf = '../templates/jjgfamille/images/site/px.png';


// Flèches monter/descendre
if ( $userdata['user_level'] == ADMIN )
{
	$l_monter = '<-';
	$l_descendre = '->';
}	
$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'MASCOTTE_TEAM' => $avatar,
				'NOM_RUB' => $lang['Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'L_RDF' => $lang['Réunion De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'MASCOTTE_RDF' => $img_rdf,
				'ACCEDEZ_EQUIPE'=> $lang['accedez_equipe'],
				'STATS_EQUIPE'=> '<b>'.(count($tab_equipe)+count($tab_equipe_admin)).'</b> membres de l\'equipe famille<br/>'.sprintf($lang['dont'],'<b>'.count($tab_equipe_admin).'</b> administrateurs '),
				'ACCEDEZ_RDF'=> $lang['accedez_rdf'],
				'STATS_RDF' => $accedez_rdf[0]['CHIFFRES'],
				'L_MONTER' => $l_monter,
				'L_DESCENDRE' => $l_descendre,
			)
);

// On définit le nombre de rubriques par colonne
define("NB_BY_COL",2);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_rub = count($tab_rub1);
// Pour chaque ligne...
$i=0;
while($i<$nb_rub)
{
	$template->assign_block_vars('rub_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_rub;$j++)
	{
				
		$ext = find_image('../images/famille/rub_' . $tab_rub1[$i]['rub_id'] .'.');
		if (is_file('../images/famille/rub_' . $tab_rub1[$i]['rub_id'] .'.'.$ext))
		{
			$mascotte = $phpbb_root_path . 'functions/miniature.php?mode=famille&rub_id=' . $tab_rub1[$i]['rub_id'];
		}
		else
		{
			$mascotte = '../templates/jjgfamille/images/site/px.png';	
		}
		// Flèches monter/descendre
		if ( $userdata['user_level'] == ADMIN )
		{
			$u_monter = append_sid($phpbb_root_path . 'famille/doedit.php?mode=up_rub&rub_id=' . $tab_rub1[$i]['rub_id']);
			$u_descendre = append_sid($phpbb_root_path . 'famille/doedit.php?mode=down_rub&rub_id=' . $tab_rub1[$i]['rub_id']);
		}
		
		$template->assign_block_vars('rub_row.rub_column',array(
							"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub1[$i]['rub_id']),
							"L_RUB" =>  $tab_rub1[$i]['name'],
							"MASCOTTE" => $mascotte,
							'DESC'=> $tab_rub1[$i]['description'],
							'U_MONTER' => $u_monter,
							'U_DESCENDRE' => $u_descendre,
							)
						);
		$i++;
	}
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'famille/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN )
{
		$template->assign_block_vars('switch_admin',array(
						"NOM_RUB" => $lang['admin_famille'],
						"ADD_RUB" => $lang['add_rub'],
						"NOM" => $lang['nom'],
						"DESC" => $lang['description'],
						"CONTENU" => $lang['contenu_periode'],
						"U_FORM" => append_sid($phpbb_root_path . 'famille/index.php?mode=add'),
						"L_SUBMIT" => $lang['Submit'],
						'MASCOTTE' => $lang['Mascotte'],
						)
					);
}

for($i=0;$i<count($tab_rub);$i++)
{
$template->assign_block_vars('switch_rub',array(
							"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub[$i]['rub_id']),
							"L_RUB" =>  $tab_rub[$i]['name'],
							)
						);
}

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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>