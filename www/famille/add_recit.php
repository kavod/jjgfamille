<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$actual_rub = 'famille';
$phpbb_root_path = '../';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path . 'includes/log_necessary.php');

$rdf_id = $_GET['rdf_id'];

if ($_GET['mode'] == 'add')
{
	$error = false;
	$error_msg = '';
			
	if (!isset($_POST['message']))
		list($error,$error_msg) = array( true , "Erreur de transmission de variables");
	$message = $_POST['message'];
	
	$bbcode_uid = make_bbcode_uid();
	$message = delete_html($message);
	$message = bbencode_first_pass($message,$bbcode_uid);
	
	if (!$error)
	{
		$sql_update = "INSERT INTO rdf_recits (rdf_id,user_id,username,recit,bbcode_uid) VALUES ( '".$rdf_id."' , '".$userdata['user_id']."' , '".$userdata['username']."', '".$message."' , '".$bbcode_uid."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de donn�es<br />".$sql_update);
	
		if (!$error)
		{
			logger("Ajout d'un recit de la rdf N�$rdf_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("view_rdf." . $phpEx."?rdf_id=".$rdf_id) . '">')
			);
			$message =  sprintf($lang['Upload_recit_rdf_ok'], '<a href="' . append_sid("view_rdf." . $phpEx."?rdf_id=".$rdf_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
//la rdf s�l�ctionn�e
$val_rdf = select_element("SELECT * FROM rdf WHERE�rdf_id= ".$rdf_id." LIMIT 0,1",'',false);
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');
//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['R�union De Famille'].' '.$lang['add_recit'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/add_recit.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Famille'],
				'RUB' => $lang['R�union De Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'L_RDF' => $lang['R�union De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/view_rdf.php?rdf_id='.$rdf_id),
				'L_RETOUR' => $lang['retour'],
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("add_recit.php?rdf_id=".$rdf_id."&mode=add"),													
				"AJOUT_RECIT" => $lang['add_recit'], 
				"L_RECIT" => $lang['R�cit'], 
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'famille/edit_mascotte.php'),
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

for ($i=0;$i<count($tab_rub);$i++)
{
		
		$template->assign_block_vars('switch_rub',array(
						"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub[$i]['rub_id']),
						"L_RUB" =>  $tab_rub[$i]['name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('rdf','opif');
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