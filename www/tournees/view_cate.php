<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'tournees';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_TOURNEES);
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
		list($error,$error_msg) = array( true , "Le champs \"Titre\" est obligatoire");
	$title = htmlentities($title);
	if (!isset($_POST['artist_id']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$artist_id = $_POST['artist_id'];
	if ($artist_id == 0 || $artist_id == "")
		list($error,$error_msg) = array( true , "Veuillez préciser l'artiste");
	
	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$comment = $_POST['comment'];
	
	if (!isset($_POST['musicians']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$musicians = $_POST['musicians'];
	
	$cate_id = $_POST['cate_id'];
	
	$bbcode_uid = make_bbcode_uid();
	$comment = delete_html($comment);
	$comment=bbencode_first_pass(str_replace("\n","<br>",$comment),$bbcode_uid);
	$musicians = delete_html($musicians);
	$musicians=bbencode_first_pass(str_replace("\n","<br>",$musicians),$bbcode_uid);
	
	if (!$error)
	{
		$sql_update = "INSERT INTO tournee_tournees (title,artist_id,comment,bbcode_uid,user_id,username,musicians,date_add,cate_id) VALUES ( '".$title."' , ".$artist_id.",'".$comment."','".$bbcode_uid."',".$userdata['user_id'].",'".$userdata['username']."','".$musicians."','" . date('Ymd') . "',". $cate_id .")";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
		
		$tournee_id = mysql_insert_id();
			
		if (!$error)
		{
			logger("Ajout de la tournée $title");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("tournees." . $phpEx ."?tournee_id=".$tournee_id) . '">')
				);
				$message =  sprintf($lang['Upload_tournee_ok'], '<a href="' . append_sid("tournees." . $phpEx."?tournee_id=".$tournee_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='tournee' ORDER BY user_id");

//Liste des tournees
$tab_tournee = select_liste("SELECT tournee_tournees.*,MIN(tournee_concerts.date) first_date FROM tournee_tournees,tournee_concerts WHERE tournee_tournees.tournee_id = tournee_concerts.tournee_id AND cate_id=".$_GET['cate_id']." GROUP BY tournee_tournees.tournee_id ORDER BY first_date ");

//Cate
$val_cate = select_element("SELECT * FROM tournee_cate WHERE cate_id=".$_GET['cate_id']."",'',false);

//Liste des artistes
$tab_artist = select_liste("SELECT * FROM disco_artists");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_tournees'],'tournees');

//Liste des categories
$tab_cate = select_liste("SELECT * FROM tournee_cate ORDER BY ordre");

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('tournees'));

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Tournees'].' :: '.$val_cate['cate_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/tournees/view_cate.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/tournees/colonne_gauche.tpl')
);



if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['Tournees'],
				"RESPONSABLES" => $lang['Responsables'],
				"LISTE_TOURNEE" => $lang['liste_tournee'],
				"IS_YOU_TO_PLAY" => $lang['it_is_you_to_play'],
				"AJOUT_TOURNEE"  => $lang['add_tournee'],
				"U_AJOUT_TOURNEE"  => append_sid($phpbb_root_path . 'tournees/add_tournee.php'),
				"L_LISTE" => $lang['liste_cate'],
				"CATE" => $val_cate['cate_name'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'tournees/index.php'),
				"L_RETOUR" => $lang['retour'],
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'tournees/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

// On définit le nombre de tournees par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_tournees = count($tab_tournee);
// Pour chaque ligne...
$i=0;
while($i<$nb_tournees)
{
	$template->assign_block_vars('tournee_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_tournees;$j++)
	{
		$tab_billets = select_element("SELECT * FROM tournee_billets WHERE tournee_id = ".$tab_tournee[$i]['tournee_id']." ORDER BY RAND()",'',false);
		$ext = find_image('../images/tournees/billet_' . $tab_tournee[$i]['tournee_id'] . '_'. $tab_billets['billet_id'].'.');
		if (is_file('../images/tournees/billet_' . $tab_tournee[$i]['tournee_id'] . '_'. $tab_billets['billet_id'].'.'.$ext))
		{
			$img = $phpbb_root_path . 'functions/miniature.php?mode=tournees_billets&billet_id=' . $tab_billets['billet_id'] .'&tournee_id=' . $tab_tournee[$i]['tournee_id'] . "&tnH=112";
		}else
		{
			$img = '../templates/jjgfamille/images/site/px.png';
		}

	//on affiche que les tournées qui ont ou moins un concert enregistré
	$val_concert = select_element("SELECT COUNT(*) AS nb FROM tournee_concerts WHERE tournee_id=".$tab_tournee[$i]['tournee_id']."",'',false);
		if($val_concert['nb']>0)
			{
			$val_date = select_element("SELECT MIN(date) AS first_date FROM tournee_concerts WHERE tournee_id=".$tab_tournee[$i]['tournee_id']."",'',false);
			$val_artist = select_element("SELECT * FROM disco_artists WHERE artist_id=".$tab_tournee[$i]['artist_id']."",'',false);
			$template->assign_block_vars('tournee_row.tournee_column',array(
						'U_TITRE' => append_sid($phpbb_root_path . 'tournees/tournees.php?tournee_id='.$tab_tournee[$i]['tournee_id'].'&cate_id='.$_GET['cate_id']),
						'L_TITRE' => $tab_tournee[$i]['title'],
						'DATE' => $lang['apartir']."&nbsp;".$lang['du']."&nbsp;".affiche_date($val_date['first_date']),
						'ARTIST' => $lang['avec']."&nbsp;<b>".$val_artist['name']."</b>",
						'PHOTO' => $img,
						)
					);
			}
		$i++;
	}
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

for ($i=0;$i<count($tab_cate);$i++)
{
	
	$template->assign_block_vars('switch_cate',array(
						'U_CATE' => append_sid($phpbb_root_path . 'tournees/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						)
					);
}
					
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
{
		$template->assign_block_vars('switch_admin',array(
						"L_ADMIN" =>  $lang['tournee_admin'],
						"L_SUBMIT" => $lang['Submit'],
						"AJOUT_TOURNEE"  => $lang['add_tournee'],	
						"U_FORM" => append_sid("view_cate.php?mode=add&cate_id=".$val_cate['cate_id']),	
						"L_TITRE" => $lang['l_titre'],
						"L_ARTIST" => $lang['Artiste'],	
						"DESC" => $lang['Description'],	
						"L_MUSICIANS" => $lang['Musiciens'],
						"NOM_CATEGORIE" => addslashes($val_cate['cate_name']),
						"MOD_CATE" => $lang['mod_cate'],
						"CATE_ID" => $_GET['cate_id'],
						'U_MOD_CATE' => append_sid($phpbb_root_path . 'tournees/doedit.php?mode=edit_cate'),
						)
					);
					
		for ($i=0;$i<count($tab_artist);$i++)
			{
				$template->assign_block_vars('switch_admin.artist',array(
						'VALUE' => $tab_artist[$i]['artist_id'],
						'INTITULE' => $tab_artist[$i]['name'],
						"SELECTED" => ($tab_artist[$i]['artist_id'] == 1 ) ? " SELECTED" : ""
						)
					);
			}
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('tournees','opif');
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