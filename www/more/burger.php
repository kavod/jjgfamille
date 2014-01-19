<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

//On vide la table
$delete = Execute("DELETE FROM burger_question_user WHERE user_id='".$userdata['user_id']."'");

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('more'));

//Liste des categories
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Jeux'].' :: Le Burger Goldman';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/burger.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$explication = '<b>Explication:</b><br/><br/><span class="genmed">Dés lors que vous aurez commencer la partie, vous verrez afficher toutes les 10 secondes une question puis il faudra y répondre';
$explication .= '<br/>Pour répondre aux questions , écrivez les réponses en miniuscule et evitez les chiffres et les caracteres bizarres et spéciaux ainsi que les "," ponctuations ect.... ';
$explication .= '<br/><br/><b>PS:</b> Ce jeu est fait pour que vous vous amusiez pendant qq minutes et tester votre mémoire donc comme il n\'y a pas de score ca ne sert à rien de noter les réponses sur un calepin ;)</span>';
$explication .= '<br/><br/>Enjoy :)';

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"U_FORM" => append_sid($phpbb_root_path . 'more/burger_question.php'),
				"L_LISTE" => $lang['liste_cate'],
				"L_TITLE" => 'Le JJG Burger de la mort',
				"EXPLICATION" => $explication,
				"START" => $lang['Commencer_la_partie'],
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/view_cate.php?cate_id='.$_GET['cate_id']),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
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

for ($i=0;$i<count($tab_cate);$i++)
{
	$url = $phpbb_root_path . 'more/';
	$url .= ($tab_cate[$i]['filename'] == '') ? 'view_cate.php?cate_id='.$tab_cate[$i]['cate_id'] : $tab_cate[$i]['filename'];
	$template->assign_block_vars('switch_cate',array(
						'U_CATE' => append_sid($url),
						'L_CATE' => $tab_cate[$i]['cate_name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('more','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );

$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>