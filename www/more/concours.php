<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'more';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/url_rewriting.php');

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

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('more'));

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

//Liste des concours
$tab_concours = select_liste("SELECT * FROM concours ORDER BY date_end DESC");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Concours'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/concours.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				
				"L_LISTE" => $lang['liste_cate'],
				"L_TITLE" => $lang['Concours'],
				'L_RETOUR'=> $lang['retour'],
				'L_WINNERS' => $lang['Gagnants'],
				
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/'),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
	$template->assign_block_vars('switch_mascotte',array(
					"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
					"L_MASCOTTE" =>  $lang['Change_mascotte'],
					)
				);
}
	
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'more'))
{
	$allowed = true;
	$template->assign_block_vars('admin',array(
					"U_AJOUT" => append_sid($phpbb_root_path . 'more/edit_concours.php?mode=add'),
					"L_AJOUT" =>  $lang['Add_concours'],
					)
				);
}
else
	$allowed = false;

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
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

for ($i=0;$i<count($tab_concours);$i++)
{
	$img = $phpbb_root_path . 'images/more/concours_' . $tab_concours[$i]['concours_id'];
	$ext = find_image($img);
	
	$str_modify = '[ <a href="%s">%s</a> ]';
	$u_modify = append_sid($phpbb_root_path . 'more/edit_concours.php?mode=edit&amp;concours_id=' . $tab_concours[$i]['concours_id']);
	$edit = ($allowed) ? sprintf($str_modify,$u_modify,$lang['Modifier']) : '';
	
	if (date('U') <= $tab_concours[$i]['date_end'] && date('U') >= $tab_concours[$i]['date_begin'])
	{
		$state = '<font color="#009900">' . $lang['En_cours'] . '</font>';
	} elseif(date('U') > $tab_concours[$i]['date_end'])
	{
		$state = '<font color="#FF0000">' . $lang['Termine'] . '</font>';
	} else
	{
		$state = '<font color="#0000FF">' . $lang['Bientot'] . '</font>';
	}
	
	$period = sprintf($lang['period'],date('d/m/Y',$tab_concours[$i]['date_begin']),date('d/m/Y',$tab_concours[$i]['date_end']));
	
	$template->assign_block_vars('concours',array(
						'U_CONCOURS' => append_sid($phpbb_root_path . 'more/concours_goldman'.$tab_concours[$i]['concours_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($tab_concours[$i]['title'])) . '.html'),
						
						'L_CONCOURS' => $tab_concours[$i]['title'],
						'L_STATE' => $state,
						'L_PERIOD' => $period,
						
						'IMG_CONCOURS' => ($ext) ? $phpbb_root_path . 'functions/miniature.php?mode=concours&concours_id=' . $tab_concours[$i]['concours_id'] . '&ntH=112' : $phpbb_root_path . 'images/forum/spacer.gif',
						'EDIT' => $edit,
						'DESC' => bbencode_second_pass(nl2br( $tab_concours[$i]['chapeau']), $tab_concours[$i]['bbcode_uid']),
						)
					);
					
	if (date('U') > $tab_concours[$i]['date_end'])
	{
		$template->assign_block_vars('concours.switch_close',array());
		$tab_winner = select_liste("SELECT * FROM concours_winners WHERE concours_id = '" . $tab_concours[$i]['concours_id'] . "'");
		for ($j=0;$j<count($tab_winner);$j++)
		{
			$val_user = select_element("SELECT username FROM phpbb_users WHERE user_id = '" . $tab_winner[$j]['user_id'] . "'",false,'');
			$username = ($val_user) ? $val_user['username'] : $tab_winner[$j]['username'];
			
			$template->assign_block_vars('concours.switch_close.winner',array(
							'U_PROFIL' => append_sid($phpbb_root_path . 'forum/profile.php?mode=viewprofile&amp;u=' . $tab_winner[$j]['user_id']),
							
							'USERNAME' => $username,
							)
						);
		}
	}
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