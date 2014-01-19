<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'actu';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ACTU);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mail'] == 'yes')
{

	include($phpbb_root_path . 'includes/log_necessary.'.$phpEx);
	$format = $_GET['format'];
	$sql = "UPDATE phpbb_users SET news_mail = 'Y',format_mail= '".$format."' WHERE user_id=".$userdata['user_id'];
	logger($userdata['username']." désire recevoir la revue du net en format $format");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
	
	//selection de la rdn 
	$val_rdn = select_element("SELECT * FROM famille_rdn ORDER BY date DESC LIMIT 0,1",'',false);
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/mail_html.php?rdn_id=".$val_rdn['rdn_id']."&user_id=".$userdata['user_id']."&format=".$format."&mode=sendmail") . '">')
	);
	$message .=  '<br />' . $lang['rdn_mail_yes_ok'];
	message_die(GENERAL_MESSAGE, $message);
}

if ($_GET['mail'] == 'no')
{

	include($phpbb_root_path . 'includes/log_necessary.'.$phpEx);
	
	$sql = "UPDATE phpbb_users SET news_mail = 'N' WHERE user_id=".$userdata['user_id'];
	logger($userdata['username']." ne désire plus recevoir la revue du net");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
	
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="6;url=' . append_sid($phpbb_root_path . "actu/rdn." . $phpEx) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['rdn_mail_no_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/rdn." . $phpEx) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdn' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_actu'],'actu');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('rdn'));

//Sélection des rdn
$page_title = $lang['Revues du Net'];
if (isset($_GET['rdn_id']) && $_GET['rdn_id'] != '')
{
	$tab_rdn = select_liste("SELECT * FROM famille_rdn WHERE rdn_id = '" . $_GET['rdn_id'] . "'");
	$page_title .= ' :: ' . $tab_rdn[0]['title'];
} else
{
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'rdn'))
	{
		$tab_rdn = select_liste("SELECT * FROM famille_rdn ORDER BY date DESC");
	}else
	{
		$val_count = select_element("SELECT COUNT(*) num FROM famille_rdn",'',false);
		$tab_rdn = select_liste("SELECT * FROM famille_rdn ORDER BY date DESC LIMIT 1,".$val_count['num']);
	}
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/actu/rdn.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/actu/actu_colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}

$template->assign_vars($rubrikopif[0]);

// Affichage de la mascotte
if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte));
if($userdata['username']=='Anonymous')
{
	$mail = sprintf($lang['to_get_rdn'],append_sid($phpbb_root_path . 'forum/profile.php?mode=register'),append_sid($phpbb_root_path . 'forum/login.php?redirect=../actu/rdn.html'));
}else
{
	if($userdata['news_mail']=='Y')
	{
		$mail = sprintf($lang['to_unsubscribe'],append_sid($phpbb_root_path . 'actu/rdn.php?mail=no'));
	}
	if($userdata['news_mail']=='N')
	{
		$mail = sprintf($lang['to_subscribe'],append_sid($phpbb_root_path . 'actu/rdn.php?mail=yes&format=html'),append_sid($phpbb_root_path . 'actu/rdn.php?mail=yes&format=txt'));
	}
	
}

for ($i=0;$i<count($tab_rdn);$i++)
{
		
	if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'rdn'))
	 {
		$modifier = '[&nbsp;'.$lang['Modifier'].'&nbsp;]';
		$u_modifier =  append_sid($phpbb_root_path . 'actu/edit_rdn.php?rdn_id='.$tab_rdn[$i]['rdn_id']);
		
	 }
	
	$image = $phpbb_root_path . 'images/rdn/rdn_'.$tab_rdn[$i]['rdn_id'].'.';
	$ext = find_image($image);
	$image .= $ext;
	if(is_file($image))
	 {
		$img = $phpbb_root_path . 'functions/miniature.php?mode=rdn&rdn_id='.$tab_rdn[$i]['rdn_id']; 
	 }else
	 {
		$img = '../templates/jjgfamille/images/site/px.png'; 
	 }
	 
	$template->assign_block_vars('switch_rdn',array(
						'DATE' => $lang['par'].'&nbsp;<a href="'.append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$tab_rdn[$i]['user_id']).'">'.$tab_rdn[$i]['username'].'</a>&nbsp;&nbsp;'.date_unix($tab_rdn[$i]['date'],'date1'),
						'L_RDN' => $tab_rdn[$i]['title'],
						'U_RDN' => append_sid($phpbb_root_path . 'actu/r'.$tab_rdn[$i]['rdn_id'].'-'.str_replace('&amp;url_title=','',add_title_in_url($tab_rdn[$i]['title'])).'.html'),
						'TEXTE' => nl2br(bbencode_second_pass($tab_rdn[$i]['contenu'],$tab_rdn[$i]['bbcode_uid'])),
						'MODIF' => $modifier,
						'U_MODIF' => $u_modifier,
						'IMG' => $img
						)
					);
	
}

if(count($tab_rdn)==0)
	$no_rdn = '<br>&nbsp;&nbsp;'.$lang['Il n\'y aucune revues du Net archivées'];


$template->assign_vars(array(
				'NOM_RUB' => $lang['Revues du Net'],
				'RESPONSABLES' => $lang['Responsables'],
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.html'),
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.html'),
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.html'),
				'U_ARCHIVES' => append_sid($phpbb_root_path . 'actu/news.html'),				
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_NEWS' => $lang['actu_News'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'actu/'),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['Actualite'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.html'),
				'L_RDN' => $lang['Revues du Net'],
				'MAIL' => $mail,
				'L_ARCHIVES' => $lang['Les Revues du Net Archivées'], 
				'U_ARCHIVES' => append_sid($phpbb_root_path . 'actu/rdn.html'),
				'VOIR_ARCHIVES' => 'Voir les revues du net archivées',
				'NO_RDN' => $no_rdn,
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		$template->assign_block_vars('switch_admin_mascotte',array(
						"U_ADMIN_MASCOTTE" => append_sid($phpbb_root_path . 'actu/edit_mascotte.php'),
						"L_ADMIN_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( ($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'rdn')))
 {
 	$tab_subscribtion = select_liste("SELECT * FROM `phpbb_users` WHERE news_mail = 'Y'");
	$template->assign_block_vars('switch_admin',array(
				'L_ADD' => 'Ajouter une rdn',
				'U_ADD' => append_sid($phpbb_root_path . 'actu/edit_rdn.php'),
				'L_NB_SUBSCRIBTION' => $lang['nb_subscribtion'],
				'NB_SUBSCRIBTION' => count($tab_subscribtion),
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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
