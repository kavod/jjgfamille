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

if ($_GET['mode'] == 'add')
{
	
	$error = false;
	$error_msg = '';

	if (!isset($_POST['question']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$question = $_POST['question'];
	if ($question=="")
		list($error,$error_msg) = array( true , "Le champs 'question' est obligatoire");
	
	if (!isset($_POST['rep_1']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$rep_1 = $_POST['rep_1'];
	if ($rep_1=="")
		list($error,$error_msg) = array( true , "Le champs 'Reponse 1' est obligatoire");
		
	if (!isset($_POST['rep_2']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$rep_2 = $_POST['rep_2'];
	if ($rep_2=="")
		list($error,$error_msg) = array( true , "Le champs 'Reponse 2' est obligatoire");
		
	if (!isset($_POST['rep_3']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$rep_3 = $_POST['rep_3'];
	if ($rep_3=="")
		list($error,$error_msg) = array( true , "Le champs 'Reponse 3' est obligatoire");
		
	if (!isset($_POST['rep_4']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$rep_4 = $_POST['rep_4'];
	if ($rep_4=="")
		list($error,$error_msg) = array( true , "Le champs 'Reponse 4' est obligatoire");
		
	if (!isset($_POST['reponse']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$reponse = $_POST['reponse'];
	if ($reponse=="")
		list($error,$error_msg) = array( true , "Le champs 'Numero de la reponse' est obligatoire");
	
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
		
	if (!$error)
	{
		$sql_add = "INSERT INTO code_question (question,rep_1,rep_2,rep_3,rep_4,reponse) VALUES ('".$question."','".$rep_1."','".$rep_2."','".$rep_3."','".$rep_4."','".$reponse."')";
		mysql_query($sql_add) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />" . $sql_add);
		logger("Ajout question ==> $question ::: pour le code goldman ");
		
		$question_id = mysql_insert_id();
		
		
		// Ajout de la banniere
		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy($error,$error_msg,$HTTP_POST_FILES['userfile'],$phpbb_root_path . 'images/permis/question_' . $question_id ,array($site_config['code_max_filesize'],$site_config['code_max_width'],$site_config['code_max_height']));
			
			if ($error)
			{
				$sql_del = "DELETE FROM code_question WHERE id = " . $question_id;
				mysql_query($sql_del) or list($error,$error_msg) = array(true,"Erreur durant la suppression de l'enregistrement après l'échec de l'upload<br />" . $sql_del);
				logger("Suppression de la question $question_id aprés echec de l'upload");
			}
		}

		if (!$error)
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("code_goldman." . $phpEx ."?cate_id=".$_GET['cate_id']) . '">')
			);
			$message =  sprintf($lang['Upload_question_code_ok'], '<a href="' . append_sid("code_goldman." . $phpEx  ."?cate_id=".$_GET['cate_id']) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}


if ($_GET['mode'] == 'del')
{
	
		$question_id = $_GET['question_id'];
		$sql_del = "DELETE FROM code_question WHERE id = " . $question_id;
		mysql_query($sql_del);
		unlink($phpbb_root_path . 'images/permis/question_' . $question_id .'.' .find_image($phpbb_root_path . 'images/permis/question_' . $question_id .'.'));
		logger("Suppression de la question $question_id");
		
		$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("code_goldman." . $phpEx ."?cate_id=".$_GET['cate_id']) . '">')
		);
		$message =  sprintf($lang['Del_question_code_ok'], '<a href="' . append_sid("code_goldman." . $phpEx  ."?cate_id=".$_GET['cate_id']) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);	

	
}

//On vide la table
$delete = Execute("DELETE FROM code_question_users WHERE user_id='".$userdata['user_id']."'");

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
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Jeux'].' :: Burger Goldman';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/code_goldman.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$explication = '<b>Règle du jeu:</b><br/><br/><span class="genmed">Sur le meme principe qu\'un passage du code de la route vous devrez repondre à 20 questions successives.';
$explication .= '<br/>Vous aurez 30 secondes pour repondre aux questions.<br/>Et il vous faudra faire un score de 16/20 minimum pour esperer avoir son "permis"';
$explication .= '<br/><br/><b>PS:</b> Un petit conseil cependant il sera plus sympa d"avoir un avatar sur le forum pour la surprise de fin du jeu .Si toutefois vous n\'en avez pas et que vous desirez en mettre a votre profil c\'est par ici <a href="'.$phpbb_root_path.'forum/profile.php?mode=editprofile"><img src="'.$phpbb_root_path.'templates/jjgfamille/images/lang_french/icon_profile.gif" border=0 alt="profil" title="profil"/></a>  ;)</span>';
$explication .= '<br/><br/>Enjoy et Bonne chance :)';

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"U_FORM" => append_sid($phpbb_root_path . 'more/code_question.php'),
				"L_LISTE" => $lang['liste_cate'],
				"L_TITLE" => 'Le Code Goldman',
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

$tab_questions = select_liste("SELECT * FROM code_question ORDER BY id DESC");

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'more'))
{

	
		$template->assign_block_vars('switch_admin',array(
						"L_TITLE" => 'Gestion des questions du Code Goldman',
						"U_FORM" => append_sid($phpbb_root_path . 'more/code_goldman.php?cate_id='.$_GET['cate_id'].'&mode=add'),
						"L_SUBMIT" => $lang['Submit'],
						)
					);
					
					

	
for ($i=0;$i<count($tab_questions);$i++)
{	

$rep_1 = $tab_questions[$i]['rep_1'];
$rep_2 = $tab_questions[$i]['rep_2'];
$rep_3 = $tab_questions[$i]['rep_3'];
$rep_4 = $tab_questions[$i]['rep_4'];
	
if($tab_questions[$i]['reponse']==1)
	$rep_1 = '<b>'.$tab_questions[$i]['rep_1'].'</b>';
elseif($tab_questions[$i]['reponse']==2)
	$rep_2 = '<b>'.$tab_questions[$i]['rep_2'].'</b>';
elseif($tab_questions[$i]['reponse']==3)
	$rep_3 = '<b>'.$tab_questions[$i]['rep_3'].'</b>';
elseif($tab_questions[$i]['reponse']==4)
	$rep_4 = '<b>'.$tab_questions[$i]['rep_4'].'</b>';

	
	
	$template->assign_block_vars('switch_admin.switch_question',array(
						"QUESTION" => $tab_questions[$i]['question'],
						"1" => $rep_1,
						"2" => $rep_2,
						"3" => $rep_3,
						"4" => $rep_4,
						"IMG" => $phpbb_root_path . 'functions/miniature.php?mode=code&question_id='.$tab_questions[$i]['id'].'&tnH=90',
						"U_SUPP" => append_sid($phpbb_root_path . 'more/code_goldman.php?cate_id='.$_GET['cate_id'].'&mode=del&question_id='.$tab_questions[$i]['id']),
						"L_SUPP" => $lang['supprimer'],
						)
					);
					
}				
				
					
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