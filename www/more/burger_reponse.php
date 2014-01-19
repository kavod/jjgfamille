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

if(!isset($_POST['ordre']))
      $ordre = 0;
elseif(isset($_POST['ordre']))
      $ordre = $_POST['ordre'];

if(isset($_POST['reponse']))
{
          $question = select_element("SELECT question_id FROM burger_question_user WHERE user_id='".$userdata['user_id']."' AND ordre='".$ordre."'");
          $reponse = select_element("SELECT * FROM burger_question WHERE question_id='".$question['question_id']."'");

          if($_POST['reponse']!=$reponse['reponse'])
          {
                
		//On vide la table
		$delete = Execute("DELETE FROM burger_question_user WHERE user_id='".$userdata['user_id']."'");
                $template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("burger." . $phpEx) . '">')
				);
				$message =  'Dommage, vous avez perdu à la question '.$ordre;
				message_die(GENERAL_MESSAGE, $message);	
          }else
          {
               if($ordre == 4)
               {
                    
		//On vide la table
		$delete = Execute("DELETE FROM burger_question_user WHERE user_id='".$userdata['user_id']."'");
                    $template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("burger." . $phpEx) . '">')
				);
				$message =  'Félicitations vous avez gagné...toute mon estime<br/>Et surtout le droit d\'aller manger un gros burger';
				message_die(GENERAL_MESSAGE, $message);	
               }
          }
}
$ordre++;

//Responsable(s) rubrique
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
	'body' => 'site/more/burger_reponse.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"U_FORM" => append_sid($phpbb_root_path . 'more/burger_reponse.php'),
				"L_LISTE" => $lang['liste_cate'],
				"ORDRE" => $ordre,
				"L_TITLE" => 'Le JJG Burger de la mort',
				"NUM_REPONSE" => 'Réponse N° <b>'.$ordre.'</b>',
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