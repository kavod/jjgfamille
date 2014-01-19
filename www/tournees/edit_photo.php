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

include($phpbb_root_path . 'includes/log_necessary.php');

if ($_GET['mode'] == 'add')
{
	$error = false;
	$error_msg = '';
	
	
	$photo_id = $_GET['photo_id'];
	$comment = $_POST['comment'];
	$photographe = $_POST['photographe'];

	$comment = htmlentities($comment);
	$photographe = htmlentities($photographe);
	
	if (!$error)
	{	
		$sql_update = "UPDATE  tournee_photos SET description='".$comment."',photographe='".$photographe."' WHERE photo_id='".$photo_id."'";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		
		if (!$error)
		{	
			$concert_id = $_GET['concert_id'];
			logger("Modification de la photo N°$photo_id de tournées");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("concerts." . $phpEx."?concert_id=".$concert_id) . '">')
			);
				$message =  sprintf($lang['Upload_photo_tournee_ok'], '<a href="' . append_sid("concerts." . $phpEx."?concert_id=".$concert_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='tournee' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_tournees'],'tournees');

$val_photo = select_element("SELECT * FROM tournee_photos WHERE photo_id = ".$_GET['photo_id']."",'',false);
$val_report = select_element("SELECT * FROM tournee_concerts WHERE concert_id = ".$val_photo['concert_id']."",'',false);
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/tournees/edit_photo.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/tournees/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;
$ext = find_image('../images/tournees/concert_' . $val_report['concert_id'] . '_' . $val_photo['photo_id'].'.');
if (is_file('../images/tournees/concert_' . $val_report['concert_id'] . '_' . $val_photo['photo_id'].'.'.$ext))
{
	$img = '../images/tournees/concert_' . $val_report['concert_id'] . '_' . $val_photo['photo_id'].'.'.$ext;
			
}else
{
	$img = '../templates/jjgfamille/images/site/px.png';	
}

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['Tournees'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Tournees'],				
				"IMG_MASCOTTE" => $mascotte,
				"L_TITLE" => $val_report['lieu']."&nbsp;".affiche_date($val_report['date']), 
				"U_TITLE" => append_sid($phpbb_root_path . 'tournees/concerts.php?concert_id='.$_GET['concert_id']), 
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("edit_photo.php?photo_id=".$_GET['photo_id']."&concert_id=".$_GET['concert_id']."&mode=add"),													
				"EDITER_ILLU" => $lang['modif_photo'], 
				"L_DESC" => $lang['Description'], 
				"L_PHOTOGRAPHE" => sprintf($lang['photographe'],''), 
				"L_ILLU" =>  $lang['chemin_photo'],  
				"L_SUPPRIMER" => $lang['supprimer']."&nbsp;".sprintf($lang['la'],$lang['photo']),
				"U_SUPPRIMER" => append_sid($phpbb_root_path . 'tournees/doedit.php?mode=supp_photo&photo_id='.$val_photo['photo_id'].'&concert_id='.$val_photo['concert_id']),	
				"ILLU" =>  $img, 
				"PHOTOGRAPHE" => $val_photo['photographe'],
				"DESC" => $val_photo['description'],	
				'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['photo'])))),
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'tournees/concerts.php?concert_id='.$_GET['concert_id']),
				"L_LISTE" => $lang['liste_cate'],
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

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
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