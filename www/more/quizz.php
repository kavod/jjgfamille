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

require_once($phpbb_root_path . 'includes/log_necessary.php');

if ($_GET['mode'] == 'vider')
{
	$error = false;
	$error_msg = '';
		
	$sql_del = "DELETE FROM quizz_question";
	mysql_query($sql_del) or list($error,$error_msg) = array( true , "Erreur Interne<br>Requète SQL : ".$sql_del);
	
	$sql_del1 = "DELETE FROM quizz_users";
	mysql_query($sql_del1) or list($error,$error_msg) = array( true , "Erreur Interne<br>Requète SQL : ".$sql_del1);
				
		if (!$error)
		{
			logger("Les scores du GoldmanikouiZ sont remis à zéro");
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("quizz." . $phpEx) . '">')
				);
				$message =  sprintf($lang['Vider_ok'], '<a href="' . append_sid("quizz." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);	
		}	
}

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

//Score
$tab_score = select_liste("SELECT quizz_users.*, phpbb_users.username FROM quizz_users, phpbb_users WHERE quizz_users.user_id = phpbb_users.user_id AND nb_quest > 49 ORDER BY score/nb_quest DESC,nb_quest DESC");

//Hors classement
$tab_hors_score = select_liste("SELECT quizz_users.*, phpbb_users.username FROM quizz_users, phpbb_users WHERE quizz_users.user_id = phpbb_users.user_id AND nb_quest < 50 ORDER BY score/nb_quest DESC,nb_quest DESC");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Jeux'].' :: Goldman Quizz';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/quizz.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"L_JEUX" => $lang['Jeux'],	
				"L_GOODIES" => $lang['Goodies'],	
				"L_FONDS" => $lang['Fonds'],	
				"U_JEUX" =>append_sid($phpbb_root_path . 'more/jeux.php'),	
				"U_GOODIES" => append_sid($phpbb_root_path . 'more/goodies.php'),	
				"U_FONDS" => append_sid($phpbb_root_path . 'more/fonds.php'),
				"L_ACCES_GOLDMANQUIZZ" => $lang['go_to_the_goldmanquizz'],
				"U_ACCES_GOLDMANQUIZZ" => append_sid($phpbb_root_path . 'more/start.php'),
				"U_FORM" => append_sid($phpbb_root_path . 'more/quizz_question.php'),
				"ON_SUBMIT" => "document.getElementById('Submit').style.display='none';document.getElementById('Submit1').style.display='none'",
				"TITRE" => $lang['titre_quizz'],
				"START" => $lang['Commencer_la_partie'],
				"JOUEUR" => $lang['Joueur'],
				"SCORE" => $lang['Score'],
				"POURCENTAGE" => $lang['Pourcentage'],
				"CLASSEMENT"=>$lang['Classement_actuel'],
				"HORS" => $lang['Hors_Classement'],
				"TEXTE" => $lang['Reglement_quizz'],
				"L_LISTE" => $lang['liste_cate'],
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/view_cate.php?cate_id=1'),
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

if ( $userdata['user_level'] == ADMIN )
{

		
		$template->assign_block_vars('switch_admin',array(
						"U_VIDER" => append_sid($phpbb_root_path . 'more/quizz.php?mode=vider'),
						"L_VIDER" =>  $lang['Vider'],
						'L_CONFIRM_VIDER' => addslashes(sprintf($lang['Confirm'],$lang['Vider'])),
						)
					);
}

for ($i=0;$i<count($tab_score);$i++)
{
	$template->assign_block_vars('switch_score',array(
						'JOUEUR' => ($i+1)."&nbsp;".$tab_score[$i]['username'],
						'SCORE' => $tab_score[$i]['score']."/".$tab_score[$i]['nb_quest'],
						'POURCENTAGE' => (round(($tab_score[$i]['score']/($tab_score[$i]['nb_quest']))*10000)/100)."%",
						)
					);
}

$num = $i;

for ($i=0;$i<count($tab_hors_score);$i++)
{
	$template->assign_block_vars('switch_hors_score',array(
						'JOUEUR' => ($i+1+$num)."&nbsp;".$tab_hors_score[$i]['username'],
						'SCORE' => $tab_hors_score[$i]['score']."/".$tab_hors_score[$i]['nb_quest'],
						'POURCENTAGE' => (round(($tab_hors_score[$i]['score']/($tab_hors_score[$i]['nb_quest']))*10000)/100)."%",
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