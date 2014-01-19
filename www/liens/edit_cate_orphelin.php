<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'liens';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LIENS);
init_userprefs($userdata);
//
// End session management
//

$job=array('liens');
require_once($phpbb_root_path . 'includes/reserved_access.php');

//
//Sites de la Categorie 
//
$tab_site = select_liste("SELECT liens_sites.site_id FROM liens_sites LEFT JOIN liens_cate_site ON liens_sites.site_id=liens_cate_site.site_id WHERE liens_cate_site.cate_id IS NULL");

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
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);



$template->set_filenames(array(
	'body' => 'site/liens/edit_cate_orphelin.tpl',
	'colonneGauche' => 'site/liens/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte ; 
		
$template->assign_vars(array(
				// Liens				
				"IMG_MASCOTTE" => $mascotte,
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'liens/index.php'),
			)
);	

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'liens'))
{

	
		$template->assign_block_vars('admin',array(
						"U_ADMIN" => append_sid($phpbb_root_path . 'liens/edit.php'),
						"L_ADMIN" =>  $lang['liens_admin'],
						"L_LISTE" => $lang['liste_cate'],
						"LIENS" => $lang['Links'],
						'U_EDIT' => append_sid($phpbb_root_path . 'liens/edit_cate.php?cate_id=0'),
						'L_EDIT' => $lang['edit'],
						"ORPHELIN" => $lang['orphelins'],
						'U_MOD_CATE' => append_sid($phpbb_root_path . 'liens/doedit.php?mode=edit_cate'),
						'LISTE_SITE' => $lang['liste_site'],
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
	
	$template->assign_block_vars('categorie',array(
						'U_CATE' => append_sid($phpbb_root_path . 'liens/view_cate.php?cate_id='.$tab_cate[$i]['cate_id']),
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