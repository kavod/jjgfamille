<?php
define("WEBMASTER_EMAIL","webmaster@domain.com");

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

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('more'));

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

// Selection du concours
if (!isset($_GET['concours_id']) || (int)$_GET['concours_id'] == 0)
	message_die(GENERAL_MESSAGE,'erreur de transmission de la variable concours_id');
$concours_id = (int)$_GET['concours_id'];
$val_concours = select_element("SELECT * FROM concours WHERE concours_id = '$concours_id'",true,'Erreur de transmission de la variable concours_id');

$tab_question = select_liste("SELECT * FROM concours_questions WHERE concours_id = '$concours_id'");

$allowed = ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'more'));

$open = false;
if (date('U') <= $val_concours['date_end'] && date('U') >= $val_concours['date_begin'])
{
	$state = '<font color="#009900">' . $lang['En_cours'] . '</font>';
	$open = true;
} elseif(date('U') > $val_concours['date_end'])
{
	$state = '<font color="#FF0000">' . $lang['Termine'] . '</font>';
} else
{
	$state = '<font color="#0000FF">' . $lang['Bientot'] . '</font>';
}

if ($_GET['mode']=='play')
{
	if (!$open)
	{
		message_die(GENERAL_MESSAGE,'Concours terminé');
	}
	
	$tab_doublons = select_liste("SELECT user_id, username FROM concours_participation WHERE concours_id = '$concours_id' AND user_id = '" . $userdata['user_id'] . "'");
	if (count($tab_doublons)>0)
		message_die(GENERAL_MESSAGE,'Vous avez déjà participé');
	
	$tab_doublons = select_liste("SELECT user_id, username FROM concours_participation WHERE concours_id = '$concours_id' AND ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
	
	if (count($tab_doublon)>0)
	{
		$message = '';
		for ($i=0;$i<count($tab_doublon);$i++)
			$message .= $tab_doublon['username'] . '(' . $tab_doublon['user_id'] . ')';
		mail(WEBMASTER_EMAIL,'Doublon dans concours ' . $concours_id, $message);
	}
	
	$win = 'Y';
	for ($i=0;$i<count($tab_question);$i++)
	{
		if (!isset($_POST['question' . $tab_question[$i]['question_id']]) || (int)$_POST['question' . $tab_question[$i]['question_id']] == 0)
			message_die(GENERAL_MESSAGE,'erreur de transmission de la variable question' . $tab_question[$i]['question_id']);
		$reponse_user = (int)$_POST['question' . $tab_question[$i]['question_id']];
		if ($reponse_user < 1 || $reponse_user > 4)
			message_die(GENERAL_MESSAGE,'question' . $tab_question[$i]['question_id'] . ' incohérent');
		$tab_question[$i]['reponse_user'] = $reponse_user;
		if ($reponse_user != $tab_question[$i]['correct'])
		{
			echo $reponse_user . '/' . $tab_question[$i]['correct'];
			$win = 'N';
		}
	}
	
	$sql = "INSERT INTO concours_participation (concours_id, user_id, username, ip, win)
		VALUES ('$concours_id','" . $userdata['user_id'] . "','" . $userdata['username'] . "','" . $_SERVER['REMOTE_ADDR'] . "', '$win')";
	mysql_query($sql)  or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la participation au concours.<br />Veillez réessayer dans quelques minutes ou bien contacter le support technique.<br />".mysql_error()."<br />".$sql);
	
	$participation_id = mysql_insert_id();
	
	for ($i=0;$i<count($tab_question);$i++)
	{
		$sql = "INSERT INTO concours_reponses (participation_id, question_id, reponse)
		VALUES ('$participation_id', '" . $tab_question[$i]['question_id'] . "','" . $tab_question[$i]['reponse_user'] . "')";
		mysql_query($sql)  or message_die(GRITICAL_ERROR,"Erreur de la base de données durant la participation au concours.<br />Veillez contacter le support technique.<br />".mysql_error()."<br />".$sql);
	}
	
	$return_url = $phpbb_root_path . 'more/concours_goldman' . $concours_id .'-' . str_replace('&amp;url_title=','',add_title_in_url($tab_concours[$i]['title'])) . '.html';
		
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="10;url=' . append_sid($return_url) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['Play_concours_ok'], '<a href="' . append_sid($return_url) . '">', '</a>') . $message_img;
	message_die(GENERAL_MESSAGE, $message);
}



$period = sprintf($lang['period'],date('d/m/Y',$val_concours['date_begin']),date('d/m/Y',$val_concours['date_end']));

$img = $phpbb_root_path . 'images/more/concours_' . $val_concours['concours_id'];
$ext = find_image($img);

$str_modify = '[ <a href="%s">%s</a> ]';
$u_modify = append_sid($phpbb_root_path . 'more/edit_concours.php?mode=edit&amp;concours_id=' . $val_concours['concours_id']);
$edit = ($allowed) ? sprintf($str_modify,$u_modify,$lang['Modifier']) : '';

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Concours'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/view_concours.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				'DESC' => bbencode_second_pass(nl2br( $val_concours['description']), $val_concours['bbcode_uid']),
				'IMG' => ($ext) ? sprintf('<img src="%s" alt="%s" title="%s" />',$phpbb_root_path . 'functions/image.php?mode=concours&amp;concours_id=' . $val_concours['concours_id'], htmlentities($val_concours['title']), htmlentities($val_concours['title'])) : '',
				'EDIT' => $edit,
				'REGLEMENT' => bbencode_second_pass(nl2br( $val_concours['reglement']), $val_concours['bbcode_uid']),
				
				"L_TITLE" => $val_concours['title'],
				'L_RETOUR'=> $lang['retour'],
				'L_REGLEMENT' => $lang['Reglement'],
				'L_STATE' => $state,
				'L_PERIOD' => $period,
				
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/concours.php'),
			)
);

if ($open)
{
	$tab_participation = select_liste("SELECT ip FROM concours_participation WHERE concours_id = '$concours_id' AND user_id = '" . $userdata['user_id'] . "'");
	
	if (count($tab_participation)>0)
	{
		$template->assign_block_vars('switch_close',array(
					'L_CLOSE_REASON' => $lang['already_played']
					));
	} else
	{
		$template->assign_block_vars('switch_open',array());
		
		if (count($tab_question)>0)
		{
			for ($i=0;$i<count($tab_question);$i++)
			{
				$template->assign_block_vars('switch_open.question',array(
					'QUESTION_ID' => $tab_question[$i]['question_id'],
					'QUESTION' => bbencode_second_pass(nl2br($tab_question[$i]['question']),$tab_question[$i]['bbcode_uid']),
					'REPONSE1' => bbencode_second_pass(nl2br($tab_question[$i]['reponse1']),$tab_question[$i]['bbcode_uid']),
					'REPONSE2' => bbencode_second_pass(nl2br($tab_question[$i]['reponse2']),$tab_question[$i]['bbcode_uid']),
					'REPONSE3' => bbencode_second_pass(nl2br($tab_question[$i]['reponse3']),$tab_question[$i]['bbcode_uid']),
					'REPONSE4' => bbencode_second_pass(nl2br($tab_question[$i]['reponse4']),$tab_question[$i]['bbcode_uid']),
								)
							);
			}
			
			$template->assign_block_vars('switch_open.submit',array(
								'U_ACTION' => append_sid($phpbb_root_path . 'more/view_concours.php?mode=play&amp;concours_id=' . $concours_id),
								
								'L_ACTION' => $lang['Submit'],
								'L_CONFIRM_ACTION' => sprintf($lang['Confirm'],strtolower($lang['Submit'])),
								)
							);
		}
	}
} else
{
	$template->assign_block_vars('switch_close',array(
					'L_CLOSE_REASON' => (date('U') > $val_concours['date_end']) ? $lang['concours_finished'] : sprintf($lang['concours_not_began'],create_date($board_config['default_dateformat'], $val_concours['date_begin'], $board_config['board_timezone']))
					));
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
	$template->assign_block_vars('switch_mascotte',array(
					"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
					"L_MASCOTTE" =>  $lang['Change_mascotte'],
					)
				);
}
	
if ($allowed)
	$allowed = true;
else
	$allowed = false;

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_access['user_id']),
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
