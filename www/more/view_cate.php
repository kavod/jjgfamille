<?php

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

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

//Liste de categories
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

//Liste des Goodies
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'more'))
 {
	$tab_more = select_liste("SELECT * FROM more WHERE cate_id=".$_GET['cate_id']." ORDER BY more_id");
 }else
 {
 	$tab_more = select_liste("SELECT * FROM more WHERE cate_id=".$_GET['cate_id']." AND enable='Y' ORDER BY more_id");
 }

$val_cate = select_element("SELECT * FROM more_cate WHERE cate_id=".$_GET['cate_id']."",'',false);

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$val_cate['cate_name'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/view_cate.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				'L_LISTE' => $lang['liste_cate'],
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/index.php'),
				'L_CATE' => $val_cate['cate_name'],
				'AJOUT_MORE' => sprintf($lang['ajout_more'],append_sid($phpbb_root_path . 'more/add.php')),
			)
);



for ($i=0;$i<count($tab_more);$i++)
{

			if($val_cate['cate_name']=="Jeux")
			{
				$alt = "alt='".$lang['start_the_game']."'";
				$title = "title='".$lang['start_the_game']."'"; 
				$u_more = append_sid($phpbb_root_path . 'more/'.$tab_more[$i]['file'].'?cate_id='.$val_cate['cate_id']);
				$l_dl = $lang['start_the_game'];
			}else
			{
				$alt = "alt='".$lang['Download']."'";
				$title = "title='".$lang['Download']."'";
				$u_more = append_sid($phpbb_root_path . 'more/download.php?more_id='.$tab_more[$i]['more_id'].'&cate_id='.$tab_more[$i]['cate_id']);
				$l_dl = $lang['Download'];
			}
			
			
			$image = $phpbb_root_path . 'images/goodies/goodies_' . $tab_more[$i]['more_id'] . '.';
			$ext = find_image($image);
			$image .= $ext; 
				
			if(is_file($image))
			{
				$img = $phpbb_root_path . 'functions/miniature.php?mode=more&more_id='.$tab_more[$i]['more_id']; 
			}else
			{
				$img = '../templates/jjgfamille/images/site/px.png'; 
			}
			
			if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'more'))
			 {
				if($tab_more[$i]['enable']=='Y')
				 {
				 	$modifier = $lang['Modifier'].'&nbsp;'.$lang['cet'].'&nbsp;'.$lang['element'].'&nbsp;'.$lang['actif'];
				 }else
				 {
				 	$modifier = $lang['Modifier'].'&nbsp;'.$lang['cet'].'&nbsp;'.$lang['element'].'&nbsp;'.$lang['inactif'];
				 }
				
				$edit = '[&nbsp;<a href="'.append_sid($phpbb_root_path . 'more/edit_more.php?more_id=' . $tab_more[$i]['more_id']).'">'.$modifier.'</a>&nbsp;]';		
			 }


		$template->assign_block_vars('switch_more',array(
							'U_TITLE' => $u_more,
							'L_TITLE' => $tab_more[$i]['title'],
							'DESC' => bbencode_second_pass(nl2br( $tab_more[$i]['description']), $tab_more[$i]['bbcode_uid']),
							'IMG' => $img,
							'USER' => sprintf($lang['source'],$tab_more[$i]['username']),
							'ALT' => $alt,
							'ALT2' => $title,
							'U_DL' => $u_more,
							'L_DL' => $l_dl,
							'EDIT' => $edit,
							)
		);

}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'more'))
{
		
		$template->assign_block_vars('admin',array(
						"L_ADMIN" =>  $lang['more_admin'],
						"NOM_CATEGORIE" => $val_cate['cate_name'],
						"MOD_CATE" => $lang['mod_cate'],
						"CATE_ID" => $_GET['cate_id'],
						'U_MOD_CATE' => append_sid($phpbb_root_path . 'more/doedit.php?mode=edit_cate'),
						"L_SUBMIT" => $lang['Submit'],
						)
					);
							
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username'],
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