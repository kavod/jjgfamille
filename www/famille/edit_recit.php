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

$recit_id = $_GET['recit_id'];

if ($_GET['mode'] == 'modif')
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
		$sql_update = "UPDATE rdf_recits SET  recit='".$message."',bbcode_uid='".$bbcode_uid."' WHERE recit_id=".$recit_id;
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant la modification de la base de données<br />".$sql_update);
	
		if (!$error)
		{
			logger("Modification du  recit N°$recit_id");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("recits." . $phpEx."?recit_id=".$recit_id) . '">')
			);
			$message =  sprintf($lang['Upload_recit_rdf_ok'], '<a href="' . append_sid("recits." . $phpEx."?recit_id=".$recit_id) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}	
}

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
//Sélection du recit
$val_recit = select_element("SELECT * FROM rdf_recits WHERE recit_id= ".$recit_id." LIMIT 0,1",'',false);
//la rdf séléctionnée
$val_rdf = select_element("SELECT * FROM rdf WHERE rdf_id= ".$val_recit['rdf_id']." LIMIT 0,1",'',false);
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');
//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");

if ((!$userdata['user_level'] == ADMIN && !is_responsable($userdata['user_id'],'rdf')) && $userdata['user_id'] <> $val_recit['user_id'])
{
	redirect(append_sid($phpbb_root_path . "famille/recits.php?recit_id=".$recit_id,true));
}


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/edit_recit.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Famille'],
				'RUB' => $lang['Réunion De Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'L_RDF' => $lang['Réunion De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/recits.php?recit_id='.$recit_id),
				'L_RETOUR' => $lang['retour'],
				"L_SUBMIT" => $lang['Submit'],	
				"U_FORM" => append_sid("edit_recit.php?recit_id=".$recit_id."&mode=modif"),													
				"AJOUT_RECIT" => $lang['modif_recit'], 
				"L_RECIT" => $lang['Récit'], 
				"VAL_RECIT" => str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_recit['bbcode_uid'] . '/s', '', $val_recit['recit'])),
				'L_CONFIRM_SUPP' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['recit'])))),
				'L_SUPP' =>  $lang['supprimer'].'&nbsp;'.sprintf($lang['le'],$lang['recit']),
				'U_SUPP' => append_sid($phpbb_root_path . 'famille/doedit.php?mode=supp_recit&rdf_id='.$val_recit['rdf_id'].'&recit_id='.$recit_id),
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