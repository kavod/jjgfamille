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

include($phpbb_root_path . 'includes/reserved_access.'.$phpEx);

//Sélection des rdn
if (isset($_GET['rdn_id']) && $_GET['rdn_id'] != '')
{
	$val_rdn = select_element("SELECT * FROM famille_rdn WHERE rdn_id = " . $_GET['rdn_id'] . " ",'',false);
	$rdn_id = $_GET['rdn_id'];
	$u_form = append_sid($phpbb_root_path . 'actu/edit_rdn.php?mode=edit&rdn_id='.$rdn_id);
	
	if($val_rdn['mail']=='Y')
	{
		$mail_y = $lang['Cette revue du net a été envoyer par mail'];
		$mail_n = '';
	}
	if($val_rdn['mail']=='N')
	{
		$mail_n = $lang['Envoyer cette revue du net par mail aux abonnés'];
		$mail_y = '';
	}
	
	$template->assign_block_vars('switch_date',array(
				"DATE" => $lang['Revue du Net'].'&nbsp;'.$lang['du'].'&nbsp;'.date_unix($val_rdn['date'],'date1').'&nbsp;'.$lang['par'].'&nbsp;'.$val_rdn['username'],
				)
		);
	
	$template->assign_block_vars('switch_sawmail',array(
				"L_MAIL_Y" => $mail_y,
				"L_MAIL_N" => $mail_n,
				"U_MAIL_N" => append_sid($phpbb_root_path . 'actu/mail_html.php?mode=sendmail&rdn_id='.$rdn_id),
				"L_CONFIRM_MAIL_N" => addslashes(sprintf($lang['Confirm'],sprintf($lang['Envoyer'],sprintf($lang['la'],$lang['Revue du Net'])))),
				"L_SAWMAIL" => $lang['Voir ce que donne le mail'],
				"U_SAWMAIL" => append_sid($phpbb_root_path . 'actu/mail_html.php?rdn_id='.$rdn_id),
				)
		);
	
	$template->assign_block_vars('switch_supp',array(
				"L_SUPP" => $lang['supprimer'].'&nbsp;'.sprintf($lang['la'],$lang['Revue du Net']),
				"U_SUPP" => append_sid($phpbb_root_path . 'actu/edit_rdn.php?mode=supp&rdn_id='.$rdn_id),
				"L_CONFIRM_SUPP" => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['Revue du Net'])))),
				)
		);
	
	$image = $phpbb_root_path . 'images/rdn/rdn_'.$rdn_id.'.';
	$ext = find_image($image);
	$image .= $ext;
	if(is_file($image))
	 {
		$img = $phpbb_root_path . 'functions/miniature.php?mode=rdn&rdn_id='.$rdn_id; 
		$l_supp = $lang['supprimer'].'&nbsp;'.sprintf($lang['l'],$lang['picture_bio']);
	 }else
	 {
		$img = '../templates/jjgfamille/images/site/px.png'; 
		$l_supp = '';
	 }
	
	$template->assign_block_vars('switch_img',array(
				"AJOUT_IMG" => $lang['Ajouter une image'],
				"U_FORM" => append_sid($phpbb_root_path . 'actu/edit_rdn.php?mode=add_img&rdn_id='.$rdn_id),
				"L_SUBMIT" => $lang['Submit'],
				"L_CONFIRM_SUPP_IMG" => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['picture_bio'])))),
				"L_SUPP_IMG" => $l_supp,
				"U_SUPP_IMG" => append_sid($phpbb_root_path . 'actu/edit_rdn.php?mode=supp_img&rdn_id='.$rdn_id),
				"IMG" => $img,
				"ALT" => $val_rdn['title'],
				)
		);	
}else
{
	$u_form = append_sid($phpbb_root_path . 'actu/edit_rdn.php?mode=add&rdn_id='.$rdn_id);
}

if ($_GET['mode'] == 'add')
{
	
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['name']) || $_POST['name'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'Titre'));
	else $name = $_POST['name'];
	
	if (!isset($_POST['message']) || $_POST['message'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['description']));
	else $description = $_POST['message'];
		
	if (!$error)
	{
		$bbcode_uid = make_bbcode_uid();
		$description = bbencode_first_pass($description, $bbcode_uid);
		
		$sql = "INSERT INTO famille_rdn (title,contenu,bbcode_uid,date,user_id,username,mail) VALUES ('".$name."','".$description."','".$bbcode_uid."','".time()."','".$userdata['user_id']."','".$userdata['username']."','N')";
		logger('Ajout d\'une revue du net "' . $name . '"');
		mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		$id = mysql_insert_id();
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx . "?rdn_id=".$id) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Upload_rdn_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx . "?rdn_id=".$id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} 
}

if ($_GET['mode'] == 'edit')
{
	
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['name']) || $_POST['name'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],'Titre'));
	else $name = $_POST['name'];
	
	if (!isset($_POST['message']) || $_POST['message'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['description']));
	else $description = $_POST['message'];
		
	if (!$error)
	{
		$bbcode_uid = make_bbcode_uid();
		$description = bbencode_first_pass($description, $bbcode_uid);
		
		$sql = "UPDATE famille_rdn SET title='$name',contenu='$description',bbcode_uid='$bbcode_uid' WHERE rdn_id=".$rdn_id;
		logger('Modification d\'une revue du net "' . $name . '"');
		mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		
		
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx . "?rdn_id=".$rdn_id) . '">')
		);
		$message .=  '<br /><br />' . sprintf($lang['Upload_rdn_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx . "?rdn_id=".$rdn_id) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	} 
}

if ($_GET['mode'] == 'supp')
{

	$ext = find_image("../images/rdn/rdn_".$rdn_id.".");
	if(is_file("../images/rdn/rdn_".$rdn_id.".".$ext))
		unlink("../images/rdn/rdn_".$rdn_id.".".$ext);
	
	$sql = "DELETE FROM famille_rdn WHERE rdn_id=".$rdn_id;
	logger("Suppression de la revue du net N°$rdn_id");
	mysql_query($sql) or message_die(CRITICAL_ERROR,'Erreur d\'écriture dans la base de données');
		
	$template->assign_vars(array(
	'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/rdn." . $phpEx) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['Delete_supprdn_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/rdn." . $phpEx) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
		
}

if ($_GET['mode'] == 'supp_img')
{

	$ext = find_image("../images/rdn/rdn_".$rdn_id.".");
	if(is_file("../images/rdn/rdn_".$rdn_id.".".$ext))
		unlink("../images/rdn/rdn_".$rdn_id.".".$ext);
			
	$template->assign_vars(array(
	'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx ."?rdn_id=" . $rdn_id) . '">')
	);
	$message .=  '<br /><br />' . sprintf($lang['Delete_suppillu_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx ."?rdn_id=" . $rdn_id) . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
		
}

if ($_GET['mode'] == 'add_img')
{
	$error = false;
	$error_msg = '';
	
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload == "")
		list($error,$error_msg) = array( true , "Aucun fichier réceptionné");
	
	if (!$error)
	{

		include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
		
		
		$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
		if (!$error && $user_upload!= '')
		{
			user_upload_easy(
					$error,
					$error_msg,
					$HTTP_POST_FILES['userfile'],
					$phpbb_root_path . 'images/rdn/rdn_' . $rdn_id ,
					array(
						$site_config['photo_max_filesize'],
						$site_config['photo_max_width'],
						$site_config['photo_max_height'])
					);
		}
		if (!$error)
		{
			
			
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx ."?rdn_id=" . $rdn_id) . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Upload_illu_rdn_ok'], '<a href="' . append_sid($phpbb_root_path . "actu/edit_rdn." . $phpEx ."?rdn_id=" . $rdn_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			
				
		}
	}	
}

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdn' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_actu'],'actu');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('rdn'));

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/actu/edit_rdn.tpl',
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

//Nb abonnes
$val_abonne = select_element("SELECT COUNT(*) nb_abonne FROM phpbb_users WHERE news_mail = 'Y' ",'',false);

$tab_abonne = select_liste("SELECT * FROM phpbb_users WHERE news_mail = 'Y'");
for ($i=0;$i<count($tab_abonne);$i++)
{
	$alt_stats .= $tab_abonne[$i]['username'].'||';
}

$template->assign_vars(array(
				'NOM_RUB' => 'Administration Revue du Net',
				'RESPONSABLES' => $lang['Responsables'],
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.php'),
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.php'),
				'U_EDITO' => append_sid($phpbb_root_path . 'actu/edito.php'),
				'U_ARCHIVES' => append_sid($phpbb_root_path . 'actu/news.php'),				
				'L_EDITO' => $lang['editoriaux'],
				'L_NEWS' => $lang['actu_News'],
				'L_MAJ' => $lang['MaJ'],
				'L_NEWS' => $lang['actu_News'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'actu/rdn.php'),
				"L_RETOUR" => $lang['retour'],
				"L_LISTE" => $lang['Actualite'],
				'U_RDN' => append_sid($phpbb_root_path . 'actu/rdn.php'),
				'L_RDN' => $lang['Revues du Net'],
				'NOM' => $lang['Titre'],
				'L_CONTENU' => $lang['description'],
				'VAL_NOM' => $val_rdn['title'],
				'VAL_DESC' => str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_rdn['bbcode_uid'] . '/s', '', $val_rdn['contenu'])),
				'L_SUBMIT' => $lang['Submit'],
				'STATS' => sprintf($lang['stats_rdn'],$val_abonne['nb_abonne']),
				'IMG_STATS' => $phpbb_root_path . 'favicon.ico',
				'ALT_STATS' => $alt_stats,
				'MODIFIER'=> $lang['Modifier la Revue du Net'],
				'U_ADD' => append_sid($phpbb_root_path . 'actu/edit_rdn.php'),
				'L_ADD' => $lang['Ajouter une rdn'],
				'U_FORM' => $u_form,
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

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

//Liste des rdn
$tab_rdn = select_liste("SELECT * FROM famille_rdn ORDER BY date DESC");

for ($i=0;$i<count($tab_rdn);$i++)
{
	
	if($tab_rdn[$i]['mail']=='Y')
	{	
		$etat = $lang['Mail envoyer'];
	}else
	{
		$etat = $lang['Mail non envoyer'];
	}
	
	if(is_file($phpbb_root_path . 'images/rdn/rdn_'.$tab_rdn[$i]['rdn_id'].'.'.find_image($phpbb_root_path . 'images/rdn/rdn_'.$tab_rdn[$i]['rdn_id'].'.')))
	 {
	 	$is_img = '<img src="../images/picture.gif" alt="Cette rdn est illustrée" title="Cette rdn est illustrée" />';	
	 }else
	 {
	 	$is_img = '';
	 }
	
	$template->assign_block_vars('switch_rdn',array(
						'U_TITLE' => append_sid($phpbb_root_path . 'actu/rdn.php?rdn_id='.$tab_rdn[$i]['rdn_id']),
						'L_TITLE' => $tab_rdn[$i]['title'],
						'U_EDIT' => append_sid($phpbb_root_path . 'actu/edit_rdn.php?rdn_id='.$tab_rdn[$i]['rdn_id']),
						'L_EDIT' => $lang['Modifier'],
						'L_USER' => $tab_rdn[$i]['username'],
						'U_USER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$tab_rdn[$i]['user_id']),
						'DATE' => date_unix($tab_rdn[$i]['date'],'jour'),
						'ETAT' => $etat,
						'IS_IMG' =>$is_img,
						)
					);
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

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
