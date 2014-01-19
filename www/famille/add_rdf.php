<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'rdf';
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

if ($_GET['mode'] == 'add')
{
	$error = false;
	$error_msg = '';
	
	if (!isset($_POST['lieu']) || $_POST['lieu'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Lieu']));
	else $lieu = $_POST['lieu'];
	
	if (!isset($_POST['description']) || $_POST['description'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['description']));
	else $description = $_POST['description'];
	
	if (!isset($_POST['date']) || $_POST['date'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Date']));
	else $date = $_POST['date'];
	
	if (!isset($_POST['heure']) || $_POST['heure'] == '')
		list($error,$error_msg) = array(true,sprintf($lang['Champs_needed'],$lang['Heure']));
	else $heure= $_POST['heure'];
	
	if (!$error && !checkdate(substr($date,3,2),substr($date,0,2),substr($date,6,4)))
		list($error,$error_msg) = array(true,sprintf($lang['invalid_date'],$date));
	else $date_bdd = date('U',mktime(substr($heure,0,2),substr($heure,3,2),0,substr($date,3,2),substr($date,0,2),substr($date,6,4)));
				
	$bbcode_uid = make_bbcode_uid();
	$description = delete_html($description);
	$description=bbencode_first_pass($description,$bbcode_uid);
		
	if (!$error)
	{
		$sql_update = "INSERT INTO rdf (lieu,date,description,bbcode_uid,user_id,username,date_add) VALUES ('".$lieu."','".$date_bdd."','".$description."','".$bbcode_uid."','".$userdata['user_id']."' , '".$userdata['username']."','".date('Ymd')."')";
		mysql_query($sql_update) or list($error,$error_msg) = array( true , "Erreur durant l'insertion de la base de données<br />".$sql_update);
		
		if (!$error)
		{
			logger("Ajout d'une reunion de famille $lieu $date $heure");
			$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("rdf." . $phpEx) . '">')
			);
			$message =  sprintf($lang['Upload_rdf_ok'], '<a href="' . append_sid("rdf." . $phpEx) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);	
		}
	}
	
}

//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");
//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Réunion De Famille'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);



$template->set_filenames(array(
	'body' => 'site/famille/add_rdf.tpl',
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
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'L_RETOUR' => $lang['retour'],
				'L_SUBMIT'=> $lang['Submit'],
				'U_FORM' => append_sid($phpbb_root_path . 'famille/add_rdf.php?mode=add'),
				'LIEU' => $lang['Lieu'],
				'DATE' => $lang['Date'],
				'HEURE' => $lang['Heure'],
				'DESCRIPTION' => $lang['description'],
				'TITLE' => $lang['Organiser sa propre Réunion de famille (RDF)'],
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