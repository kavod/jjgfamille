<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//

if ($_GET['mode'] == 'modif')
{
	$error = false;
	$error_msg = '';

	$retranscription_id = $_GET['retranscription_id'];
	
	if (!isset($_POST['comment']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$comment = $_POST['comment'];
	if ($comment=="")
		list($error,$error_msg) = array( true , "Le champs \"Retranscription\" est obligatoire");
	
	
	$bbcode_uid = make_bbcode_uid();
	$comment = delete_html($comment);
	$comment=bbencode_first_pass($comment,$bbcode_uid);
		
	if (!$error)
	{
		$sql_update = "UPDATE media_retranscriptions SET retranscription = '".$comment."',bbcode_uid = '".$bbcode_uid."' WHERE retranscription_id = ".$retranscription_id." ";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
		if (!$error)
		{
			logger("Modification de la retranscription N°$retranscription_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("retranscription." . $phpEx."?retranscription_id=".$retranscription_id) . '">')
			);
			$message =  sprintf($lang['Upload_retranscription_ok'], '<a href="' . append_sid("retranscription." . $phpEx."?retranscription_id=".$retranscription_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

//Les informations du support
$val_retranscription = select_element("SELECT * FROM media_retranscriptions WHERE retranscription_id=".$_GET['retranscription_id']." ",'',false);

//Retransciption de ?
$val_emission = select_element("SELECT * FROM media_emission WHERE emission_id=".$val_retranscription['emission_id']." ",'',false);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/retranscription.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

	//Retranscirption annoncé par
				$val_user = select_element("SELECT * FROM phpbb_users WHERE user_id = ".$val_retranscription['user_id']." ",'',false);
				if ($val_user)
				{
					$l_user = $val_user['username'];
					$u_user = append_sid("../forum/privmsg.php?mode=post&u=".$val_user['user_id']."");
				} else
				{
					$l_user = $val_retranscription['username'];
					$u_user = '';
				}

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['nom_rub_media'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"DESCRIPTION" => nl2br(bbencode_second_pass($val_retranscription['retranscription'],$val_retranscription['bbcode_uid'])),
				"L_TITLE" => $val_emission['title'], 
				"U_TITLE" => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$val_retranscription['emission_id']),
				"L_USER" => $l_user,
				"U_USER" => $u_user, 
				"RETRAN" => $lang['Retranscription'],
				"DE" => $lang['de'], 
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$val_retranscription['emission_id']),     				
			)
);


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'media'))
{

						
		$template->assign_block_vars('switch_admin',array(
						'ADMIN_MEDIAS' => $lang['medias_admin'],
						"COMMENT" => preg_replace('/\:(([a-z0-9]:)?)' . $val_retranscription['bbcode_uid'] . '/s', '', $val_retranscription['retranscription']),
						"U_SUPP" => append_sid("doedit.php?mode=supp_retranscription&retranscription_id=".$val_retranscription['retranscription_id'].""),
						"L_SUBMIT" => $lang['Submit'],	
						"U_FORM" => append_sid("retranscription.php?retranscription_id=".$val_retranscription['retranscription_id']."&mode=modif"),													
						"MODIF_RETRAN" => $lang['modif_retran'],
						"L_SUPP" => $lang['supp_retran'],
						"RETRAN" => $lang['Retranscription'],
						'L_CONFIRM_SUPP_RETRAN' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['la'],$lang['retranscription'])))),
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

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('medias','opif');
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