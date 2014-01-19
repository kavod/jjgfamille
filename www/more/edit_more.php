<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MORE);
init_userprefs($userdata);
//
// End session management
//
$job=array('more');
require_once($phpbb_root_path . 'includes/reserved_access.php');

if ($_GET['mode'] == 'edit_more')
{
	$more_id = $_GET['more_id'];
	$error = false;
	$error_msg = '';

	if(!isset($_POST['title']))
		list($error,$error_msg) = array (true,'Erreur de transmission des variables');
	$title = $_POST['title'];
	if($title == '')
    		list($error,$error_msg) = array (true,"Le champ 'Titre' est obligatoire");

        if(!isset($_POST['description']))
		list($error,$error_msg) = array (true,"Erreur de transmission des variables");
	$description = $_POST['description'];
	if($description == '')
    		list($error,$error_msg) = array (true,"Le champ 'Description' est obligatoire");        
         
        $bbcode_uid = make_bbcode_uid();
        $description = bbencode_first_pass($description,$bbcode_uid);
                 
	if(!isset($_POST['cate_id']))
		list($error,$error_msg) = array (true,"Erreur de transmission des variables");
	$cate_id = $_POST['cate_id']; 
	if(!$error)
	{
		$sql_update = "UPDATE more SET title = '". $title ."', description = '". $description ."',cate_id = '". $cate_id ."',bbcode_uid='".$bbcode_uid."' WHERE more_id = ".$more_id." ";
		mysql_query($sql_update) or list($error,$error_msg) = array (true,"Erreur durant la requete<br>Requete sql ".$sql_update);
			
		if (!$error)
			{

				logger("Modification des informations pour le goodies N°$more_id (En ++)");
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_more." . $phpEx."?more_id=" . $more_id) . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Upload_goodies_ok'], '<a href="' . append_sid("edit_more." . $phpEx."?more_id=" . $more_id) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		
	}
}

if ($_GET['mode'] == 'edit_illu')
{
	include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);
	
	$user_upload =  ( $HTTP_POST_FILES['userfile']['tmp_name'] != "none") ? $HTTP_POST_FILES['userfile']['tmp_name'] : '' ;
	if ($user_upload!= '')
	{
		$error = false;
		$error_msg = '';
		@unlink($phpbb_root_path . 'images/goodies/goodies_' . $_GET['more_id'].".".find_image($phpbb_root_path . 'images/goodies/goodies_' . $_GET['more_id']));
		user_upload_easy($error,$error_msg,$HTTP_POST_FILES['userfile'],$phpbb_root_path . 'images/goodies/goodies_' . $_GET['more_id'] ,array($site_config['photo_max_filesize'],$site_config['photo_max_width'],$site_config['photo_max_height']));
		
		if (!$error)
			{
				$more_id=$_GET['more_id'];
				logger("Changement de illustration pour le goodies N°$more_id (En ++)");
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_more." . $phpEx."?more_id=" . $_GET['more_id']) . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Upload_illu_more_ok'], '<a href="' . append_sid("edit_more." . $phpEx."?more_id=" . $_GET['more_id']) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		
	}
}

if ($_GET['mode'] == 'supp_illu')
{
$more_id=$_GET['more_id'];
unlink($phpbb_root_path . 'images/goodies/goodies_' . $more_id.".".find_image($phpbb_root_path . 'images/goodies/goodies_' . $more_id));
logger("Suppression de la'illustration pour le goodies N°$more_id (En ++)");
}

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");
$val_cate = select_element("SELECT cate_id FROM more WHERE more_id = ".$_GET['more_id'],'',false);
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/edit_more.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);


if ($img_mascotte)
$mascotte = $img_mascotte;		
$template->assign_vars(array(
				"L_LISTE" => $lang['liste_cate'],
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/view_cate.php?cate_id='.$val_cate['cate_id']),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
{

	
		$template->assign_block_vars('admin',array(
						"L_LISTE" => $lang['liste_cate'],
						"MORE" => $lang['more_admin'],
						"L_LISTE" => $lang['liste_cate'],
						)
					);
	
	$val_more = select_element("SELECT * FROM more WHERE more_id = ".$_GET['more_id'],'',false);
	
	$rendre = append_sid("doedit.php?mode=activ&more_id=".$val_more['more_id']."");
	$edit_more = append_sid("edit_more.php?mode=edit_more&more_id=".$val_more['more_id']."");

	$url_image = $phpbb_root_path . 'images/goodies/goodies_'. $val_more['more_id'] .'.'.find_image($phpbb_root_path . 'images/goodies/goodies_'. $val_more['more_id']);
	if (is_file($url_image))
	{
		$image = '<img src="../functions/miniature.php?mode=more&more_id='. $val_more['more_id'].'" border="0">';
		$supp_image = $lang['supp_image'];
	}
	else 
	{
		$image = '';
	}
	
	if($val_more['enable']== 'Y')
	{
		$actif_inactif = $lang['actif'];
		$inactif_actif = $lang['inactif'];
		
	}else
	{
		$actif_inactif = $lang['inactif'];
		$inactif_actif = $lang['actif'];
	}
	
	$template->assign_block_vars('admin.more',array(
						
						"MORE_NAME" => addslashes($val_more['title']),
						"DESCRIPTION" => $lang['Description'],
						"DESC" => str_replace("<br />","",preg_replace('/\:(([a-z0-9]:)?)' . $val_more['bbcode_uid'] . '/s', '', $val_more['description'])),
						"PROPOSER" => $lang['proposer'],
						"USER" => $val_more['username'],
						"U_USER" => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_more['user_id']),
						"ACTIVITE" => $lang['activiter'],
						"ACTIF_INACTIF" => $actif_inactif,
						"INACTIF_ACTIF" => sprintf($lang['rendre'],$inactif_actif),
						"RENDRE" => $rendre,
						"NOM_MORE" => $lang['Titre'],
						"MODIF_MORE" => $lang['modif_more'],
						"U_FORM" => $edit_more,
						"L_CATE" => $lang['categorie'],
						"L_SUBMIT" => $lang['Submit'],
						"SUPP" => $lang['supprimer'].'&nbsp;'.sprintf($lang['le'],$lang['goodies']),
						"U_SUPP" => append_sid("doedit.php?mode=supp_more&more_id=".$val_more['more_id'].""),
						"L_SUPP" => $lang['supp_sites'],
						"CHOIX" => $lang['choix'],
						"SITE_LOGO" => $image,
						"U_SUPP_IMAGE" => append_sid($phpbb_root_path . 'more/edit_more.php?mode=supp_illu&more_id='.$val_more['more_id']),
						"L_SUPP_IMAGE" => $supp_image,
						"BANNIERE" => $lang['ajout_illu'],
						"U_UPLOAD_BANNIERE" => append_sid($phpbb_root_path . 'more/edit_more.php?mode=edit_illu&more_id='.$val_more['more_id']),
						'L_CONFIRM_SUPP_SITE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['le'],$lang['goodies'])))),
						'L_CONFIRM_SUPP_IMAGE' => addslashes(sprintf($lang['Confirm'],sprintf($lang['delete'],sprintf($lang['l'],$lang['picture'])))),
						)
					);
					
for ($i=0;$i<count($tab_cate);$i++)
{
	
	$template->assign_block_vars('admin.more.options',array(
						'VALUE' => $tab_cate[$i]['cate_id'],
						'INTITULE' => $tab_cate[$i]['cate_name'],
						"SELECTED" => ($tab_cate[$i]['cate_id'] == $val_more['cate_id'] ) ? " SELECTED" : ""
						)
	);
}				
				
					
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'liens/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
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

$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>