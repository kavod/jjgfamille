<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'functions/functions_permis.php');
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

if(!isset($_POST['score']))
	$score = 0;

//Gestion score Reponse
//On ne passe dans cette condition seulement si num n'est pas 1 ...
if(($_POST['num']+1)!=1)
{
	//On cherche les informations de la question a poser
		$sql_rep="SELECT * FROM code_question WHERE id= ".$_POST['num_quest']; 
		$result_rep = mysql_query($sql_rep) or die("Execution de la requete impossible".$sql_rep);
		$val_rep = mysql_fetch_array($result_rep);
	
	//Si la reponse est bonne
		
	if($val_rep['reponse']==$_POST['reponse'])
	{
		$score = $_POST['score']+1;
	}else
	{
		$score = $_POST['score'];
	}	
}

//On gere le numero de la question
$num=$_POST['num']+1;

//Bon la c'est statique ya que 5 questions donc apres on lance la page de resultat/recompense
if($num==21)
{
//On vide la table
$delete = Execute("DELETE FROM code_question_users WHERE user_id='".$userdata['user_id']."'");
		
		if($score >=16)
		{
			$message .= "<br/><img src=".permis()." border=0 /><br /><br />" . sprintf($lang['permis_ok'],$score,20, '<a href="' . append_sid( $phpbb_root_path . "more/index." . $phpEx) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="4;url=' . append_sid("code_goldman." . $phpEx) . '">')
				);
			$message =  sprintf($lang['permis_not_ok'],$score,20,'<a href="' . append_sid("code_goldman." . $phpEx) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}	
}

//On cherche les informations de la question a poser
$sql_question="SELECT * FROM code_question LEFT JOIN code_question_users ON code_question.id=code_question_users.question_id WHERE code_question_users.question_id is NULL ORDER BY RAND() LIMIT 0,1";
$result_question = mysql_query($sql_question) or die("Execution de la requete impossible<br />".$sql_question);
$val_question = mysql_fetch_array($result_question);

//On enregistre la question de la base
$sql_question1="INSERT INTO code_question_users (user_id,question_id) VALUES (".$userdata['user_id'].",".$val_question['id'].")";
$result_question1 = mysql_query($sql_question1) or die("Execution de la requete impossible<br />" . $sql_question1);

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
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Jeux'].' :: Code Goldman';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/code_question.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$image = $phpbb_root_path . 'images/permis/question_'.$val_question['id'].'.';
$ext = find_image($image);
$image .= $ext;

$num_quest = $val_question['id'];

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"U_FORM" => append_sid($phpbb_root_path . 'more/code_question.php'),
				"TEMPS_ECOULE"	=> $lang['temps_ecoules'],
				"L_LISTE" => $lang['liste_cate'],
				"L_TITLE" => 'Le Code Goldman',
				"QUESTION" => $val_question['question'],
				"NUM_QUESTION" => 'Question N° <b>'.$num.'</b>',
				"IMG" => $image,
				"1" => $val_question['rep_1'],
				"2" => $val_question['rep_2'],
				"3" => $val_question['rep_3'],
				"4" => $val_question['rep_4'],
				"SUBMIT" => $lang['Submit'],
				"NUM" => $num,
				"NUM_QUEST" => $num_quest,
				"SCORE" => $score,
				
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