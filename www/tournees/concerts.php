<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'tournees';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions_media.php');
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_TOURNEES);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mode'] == 'modif')
{
	$error = false;
	$error_msg = '';
	
	$concert_id = $_GET['concert_id'];
	
	if (!isset($_POST['lieu']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$lieu = $_POST['lieu'];
	if ($lieu=="")
		list($error,$error_msg) = array( true , "Le champs \"Lieu\" est obligatoire");
	$lieu = htmlentities($lieu);
	if (!isset($_POST['date']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$date = $_POST['date'];
	if ($date=="")
		list($error,$error_msg) = array( true , "Le champs \"Date\" est obligatoire");
	$date = htmlentities($date);
	$date = format_date($date);
	
	if (!$error)
	{
		$sql_update = "UPDATE tournee_concerts SET  lieu='".$lieu."',date='".$date."' WHERE concert_id=".$concert_id."";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
	
		if (!$error)
		{
			logger("Modification du concert N°$concert_id dans les tournées");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("concerts." . $phpEx ."?concert_id=".$concert_id) . '">')
				);
				$message =  sprintf($lang['Upload_concert_ok'], '<a href="' . append_sid("concerts." . $phpEx."?concert_id=".$concert_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}
//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='tournee' ORDER BY user_id");
//Le concert
$val_concert = select_element("SELECT * FROM tournee_concerts WHERE concert_id = ".$_GET['concert_id']."",'',false);
//La tournee
$val_tournee = select_element("SELECT * FROM tournee_tournees WHERE tournee_id = ".$val_concert['tournee_id']."",'',false);
//Les photos
$tab_photo = select_liste("SELECT * FROM tournee_photos WHERE concert_id = ".$val_concert['concert_id']."");
//Les recits
$tab_recit = select_liste("SELECT * FROM tournee_recits WHERE concert_id = ".$val_concert['concert_id']."");
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_tournees'],'tournees');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Tournees'].' :: '.$val_tournee['title'].' :: '.$val_concert['lieu'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/tournees/concerts.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/tournees/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['Tournees'],
				"RESPONSABLES" => $lang['Responsables'],
				"L_TITRE" => $lang['Concert']."&nbsp;".$lang['du']."&nbsp;".affiche_date($val_concert['date'])."&nbsp;".sprintf($lang['à'],$val_concert['lieu']),
				"L_TOURNEE" => $val_tournee['title'],
				"U_TOURNEE" => append_sid($phpbb_root_path . 'tournees/tournees.php?tournee_id='.$val_tournee['tournee_id']),
				"DISPO" => sprintf($lang['disponible'],count($tab_photo)),
				"DISPO_RECIT" => sprintf($lang['disponible'],count($tab_recit)),
				"PHOTOGRAPHIES"	=> $lang['Photographies'],
				"IT_IS_YOU_TO_PLAY" => $lang['it_is_you_to_play'],
				"L_AJOUT_PHOTO" => $lang['add_photo'],
				"U_AJOUT_PHOTO" => append_sid($phpbb_root_path . 'tournees/add_photo.php?concert_id='.$val_concert['concert_id']),
				"L_AJOUT_RECIT" => $lang['add_recit'],
				"U_AJOUT_RECIT" => append_sid($phpbb_root_path . 'tournees/add_recit.php?concert_id='.$val_concert['concert_id']),
				"RECIT_CONCERT" => $lang['recit_concert'],
				"CONCERT_TOURNEE" =>  $lang['concert_tournee'],	
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'tournees/tournees.php?tournee_id='.$val_concert['tournee_id']),
				"L_LISTE" => $lang['liste_cate'],
			)
);

// On définit le nombre de photos par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_photos = count($tab_photo);
// Pour chaque ligne...
$i=0;
while($i<$nb_photos)
{
	$template->assign_block_vars('photos_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_photos;$j++)
	{
		$ext = find_image('../images/tournees/concert_' . $val_concert['concert_id'] . '_' . $tab_photo[$i]['photo_id'].'.');
		if (is_file('../images/tournees/concert_' . $val_concert['concert_id'] . '_' . $tab_photo[$i]['photo_id'].'.'.$ext))
		{
			$img = $phpbb_root_path . 'functions/miniature.php?mode=tournees&concert_id=' . $val_concert['concert_id'] . '&photo_id=' . $tab_photo[$i]['photo_id'];
			$size = getimagesize('../images/tournees/concert_' . $val_concert['concert_id'] . '_' . $tab_photo[$i]['photo_id'].'.'.$ext);
	
				if($tab_photo[$i]['description'] == "" && $tab_photo[$i]['photographe']== "")
				{
					$height = $size[1]+30;
				}
				else
				{
					$height = $size[1]+100;		
				}
				
			$onclick = "window.open('photo.php?photo_id=".$tab_photo[$i]['photo_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
		}else
		{
			$img = '../templates/jjgfamille/images/site/px.png';	
		}
		
		$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = ".$tab_photo[$i]['user_id']." ",'',false);
				if ($val_user)
				{
					$l_user = $val_user['username'];
					$u_user = append_sid('../forum/privmsg.php?mode=post&u='.$val_user['user_id'].'');
				} else
				{
					$u_user = '';
					$l_user = $tab_photo[$i]['username'];
				}
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee') || $tab_photo[$i]['user_id']==$userdata['user_id'])
		{
			$l_modifier = $lang['modifier'];
			$u_modifier = append_sid('../tournees/edit_photo.php?photo_id='.$tab_photo[$i]['photo_id'].'&concert_id='.$val_concert['concert_id']);	
		}
		
		$template->assign_block_vars('photos_row.photos_column',array(
							'PHOTO' => $img,
							"PHOTOGRAPHE" => $lang['photo']."&nbsp;".$lang['de']."&nbsp;",
							"ONCLICK" => $onclick,
							"U_USER" => $u_user,
							"L_USER" => $l_user,
							"U_MODIFIER" => $u_modifier,
							"L_MODIFIER" => $l_modifier,
							)
						);
		$i++;
	}
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'tournees/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

for ($i=0;$i<count($tab_recit);$i++)
{
	$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = ".$tab_recit[$i]['user_id']." ",'',false);
				if ($val_user)
				{
					$l_user = $val_user['username'];
					$u_user = append_sid('../forum/privmsg.php?mode=post&u='.$val_user['user_id'].'');
				} else
				{
					$u_user = '';
					$l_user = $tab_recit[$i]['username'];
				}
				
		if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee') || $tab_recit[$i]['user_id']==$userdata['user_id'])
		{
			$l_modifier = $lang['modifier'];
			$u_modifier = append_sid('../tournees/edit_recit.php?recit_id='.$tab_recit[$i]['recit_id'].'&concert_id='.$val_concert['concert_id']);	
		}
	
	

	$template->assign_block_vars('recits',array(
						"QUI" => "Récits de ",
						"RECIT" => bbencode_second_pass(nl2br($tab_recit[$i]['recit']),$tab_recit[$i]['bbcode_uid']),
						"U_USER" => $u_user,
						"L_USER" => $l_user,
						"U_MODIFIER" => $u_modifier,
						"L_MODIFIER" => $l_modifier,
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

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'tournee'))
{
		$template->assign_block_vars('switch_admin',array(
						"L_ADMIN" =>  $lang['tournee_admin'],
						"L_SUBMIT" => $lang['Submit'],	
						"U_FORM" => append_sid("concerts.php?mode=modif&concert_id=".$val_concert['concert_id']),
						"DESC" => $lang['Description'],	
						"TITRE" => $val_tournee['title'],
						"MODIF_CONCERT"	=> $lang['modif_tournee'],
						"L_DATE" => $lang['Date'],
						"LIEU" =>$lang['Lieu'],
						"DATE" => affiche_date($val_concert['date']),
						"L_LIEU" =>$val_concert['lieu'],
						"L_SUPP" => $lang['supprimer']."&nbsp;".$lang['ce']."&nbsp;".$lang['concert'],
						"U_SUPP" => append_sid("doedit.php?mode=supp_concert&concert_id=".$val_concert['concert_id']."&tournee_id=".$val_concert['tournee_id']),
						'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['concert'])))),
						)
					);
}

//Liste des categories
$tab_cate = select_liste("SELECT * FROM tournee_cate ORDER BY ordre");
for ($i=0;$i<count($tab_cate);$i++)
{
	
	$template->assign_block_vars('switch_cate',array(
						'U_CATE' => append_sid($phpbb_root_path . 'tournees/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						)
					);
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