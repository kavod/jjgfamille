<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'liens';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LIENS);
init_userprefs($userdata);
//
// End session management
//

//
//Nom de la categorie
//
$val_cate = select_element("SELECT cate_name FROM liens_categories WHERE cate_id= ".$_GET['cate_id']." LIMIT 0,1",'',false);

//
//Sites de la Categorie 
//
$tab_site = select_liste("SELECT * FROM liens_cate_site,liens_sites  WHERE liens_cate_site.site_id=liens_sites.site_id AND liens_cate_site.cate_id= ".$_GET['cate_id']." ORDER BY liens_sites.score DESC ");

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='liens' ORDER BY user_id");

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM liens_categories ORDER BY ordre");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_liens'],'liens');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Links'] . ' :: ' . $val_cate['cate_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'liens/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

$template->set_filenames(array(
	'body' => 'site/liens/view_cate.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/liens/colonne_gauche.tpl')
);


if(!$tab_site)
	$aucun = 'Aucun site présent dans cette catégorie';
else
	$aucun = '';

if ($img_mascotte)
	$mascotte = $img_mascotte ;
	
$template->assign_vars(array(
				// Liens
				"LIENS" => $lang['Links'],
				"L_LISTE" => $lang['liste_cate'],
				"RESPONSABLES" => $lang['Responsables'],
				"CATEGORIES" => $lang['categories'] ,
				"NOM_CATEGORIE" => $val_cate['cate_name'],
				"WEBMASTER" => sprintf($lang['Webmaster'],append_sid("add_site.php")),
				"AUCUN" => $aucun,
				"IMG_MASCOTTE" => $mascotte, 
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'liens/index.php'),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
{
		
		$template->assign_block_vars('admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'liens/edit.php'),
						"L_ADMIN" =>  $lang['liens_admin'],
						"NOM_CATEGORIE" => addslashes($val_cate['cate_name']),
						"MOD_CATE" => $lang['mod_cate'],
						"CATE_ID" => $_GET['cate_id'],
						'U_MOD_CATE' => append_sid($phpbb_root_path . 'liens/doedit.php?mode=edit_cate'),
						'LISTE_SITE' => $lang['liste_site'],
						"L_SUBMIT" => $lang['Submit']
						)
					);
		
		for ($i=0;$i<count($tab_site);$i++)
			{
				$val_sites = select_element("SELECT * FROM liens_sites WHERE site_id= ".$tab_site[$i]['site_id']."  LIMIT 0,1",'',false);
				$template->assign_block_vars('admin.site',array(
						'SITE_NAME' => $val_sites['site_name'],
						"SITE_URL" => $val_sites['url'],
						'U_EDIT' => append_sid($phpbb_root_path . 'liens/edit_site.php?site_id='.$val_sites['site_id']),
						'L_EDIT' => $lang['edit'],
						'U_DEASSOCIER' => append_sid($phpbb_root_path . 'liens/doedit.php?mode=supp_asso&cate_id='.$_GET['cate_id'].'&site_id='.$val_sites['site_id']),
						'L_DEASSOCIER' => $lang['deassocier'],	
						
						)
					);
}
					
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}

for ($i=0;$i<count($tab_site);$i++)
{
	$val_sites = select_element("SELECT * FROM liens_sites WHERE enable = 'Y' AND site_id= ".$tab_site[$i]['site_id']." LIMIT 0,1",'',false);
	if ($val_sites)
	{
		$ext = find_image($phpbb_root_path . 'images/liens/logo_'. $val_sites['site_id'] . '.');	
		$url_image = $phpbb_root_path . 'images/liens/logo_'. $val_sites['site_id'] . '.'.$ext;
		if (is_file($url_image))
			$image = '<img src="'.$url_image.'" border="0">';
		else $image = '<img src="../templates/jjgfamille/images/site/px.png" border="0">'; 
		
		$have_right = ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens') || $val_sites['user_id'] == $userdata['user_id']);
		
		$webmaster = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_site[$i]['user_id']."  LIMIT 0,1",'',false);
		
		$template->assign_block_vars('site',array(
						'SITE_NAME' => $val_sites['site_name'],
						'SITE_DESCRIPTION' => $val_sites['description'],
						"SITE_URL" => $val_sites['url'], // $phpbb_root_path . 'phpmyvisites/phpmyvisites.php?url=' . $val_sites['url'] . '&id=' . $val_sites['site_id'] . '&pagename=FILE:' . $val_sites['site_name'], // $val_sites['url'],
						"SITE_LOGO" => $image,
						"SITE_PLUS" => $val_sites['plus'],
						"SITE_MOINS" => $val_sites['moins'],
						"PLUS" => $lang['plus'],
						"MOINS" => $lang['moins'],
						"DESC" => $lang['Description'],
						"NUM" => $val_sites['site_id'],
						"U_ADMIN" => (($have_right) ? append_sid($phpbb_root_path . 'liens/edit_site.php?site_id='.$val_sites['site_id']) : ''),
						'L_ADMIN' => (($have_right) ? ' [ ' . $lang['Modifier'] . ' ] ' : ''),
						'WEBMASTER' => $lang['proposer'],
						'L_WEBMASTER' => $webmaster['username'],
						'U_WEBMASTER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$webmaster['user_id']),
						)
					);
	}
}


for ($i=0;$i<count($tab_cate);$i++)
{
	$template->assign_block_vars('categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
						'L_CATE' => $tab_cate[$i]['cate_name']
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

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('liens','opif');
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