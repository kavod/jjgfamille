<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'accueil';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ACCUEIL);
init_userprefs($userdata);
//
// End session management
//


$job = array('news','mascotte');
require_once($phpbb_root_path . 'includes/reserved_access.php');

// Ajout d'une mascotte
if ($_GET['mode'] == 'add_mascotte')
{
	include($phpbb_root_path . 'includes/usercp_avatar.' . $phpEx);

	//print_r($site_config);
	
	$user_mascotte_upload =  ( $HTTP_POST_FILES['mascotte_file']['tmp_name'] != "") ? $HTTP_POST_FILES['mascotte_file']['tmp_name'] : '' ;
	$user_mascotte_name = ( !empty($HTTP_POST_FILES['mascotte_file']['name']) ) ? $HTTP_POST_FILES['mascotte_file']['name'] : '';
	$user_mascotte_size = ( !empty($HTTP_POST_FILES['mascotte_file']['size']) ) ? $HTTP_POST_FILES['mascotte_file']['size'] : 0;
	$user_mascotte_filetype = ( !empty($HTTP_POST_FILES['mascotte_file']['type']) ) ? $HTTP_POST_FILES['mascotte_file']['type'] : '';
	if ($user_mascotte_upload!= '')
	{
		$error = false;
		$error_msg = '';
	
		$mascotte_sql = user_mascotte_upload($error, $error_msg, $user_mascotte_upload, $user_mascotte_name, $user_mascotte_size, $user_mascotte_filetype,'accueil');
	
		if ($mascotte_sql != '' && !mysql_query($mascotte_sql))
				message_die(CRITICAL_ERROR,"Erreur durant la mise à jour de la base de données",'',__LINE__,__FILE__,$mascotte_sql);
		else
		{
			if (!$error)
			{
				logger('Modification de la mascotte de l\'accueil');
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_mascotte." . $phpEx) . '">')
				);
				$message .=  '<br /><br />' . sprintf($lang['Upload_mascotte_ok'], '<a href="' . append_sid("edit_mascotte." . $phpEx) . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	}
} else 
{
	if ($_GET['mode'] == 'edit_annonce')
	{
		$bbcode_uid = make_bbcode_uid();
		$annonce = bbencode_first_pass(delete_html($_POST['annonce']), $bbcode_uid);
		
		$sql_update = "UPDATE famille_config SET valeur_char = '". $annonce . "' WHERE param = 'annonces'";
		mysql_query($sql_update) or message_die(CRITICAL_ERROR,"Erreur durant la mise à jour de la base de données",'',__LINE__,__FILE__,$sql_update);
		
		$sql_update = "UPDATE famille_config SET valeur_char = '". $bbcode_uid . "' WHERE param = 'bbcode_uid'";
		mysql_query($sql_update) or message_die(CRITICAL_ERROR,"Erreur durant la mise à jour de la base de données",'',__LINE__,__FILE__,$sql_update);
		
		if (!$error)
		{
			logger('Modification du message d\'accueil');
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("edit_mascotte." . $phpEx) . '">')
			);
			$message .=  '<br /><br />' . sprintf($lang['Change_annonce_ok'], '<a href="' . append_sid("edit_mascotte." . $phpEx) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		
	}
}
// News
$news = array();
$tab_news = select_liste('SELECT news_id,Date,title FROM famille_news WHERE date_hot >= '.date('Ymd') . ' ORDER BY date_hot,Date DESC');
for($i=0;$i<count($tab_news);$i++)
{
	$date = mktime(12,0,0,substr($tab_news[$i]['Date'],4,2),substr($tab_news[$i]['Date'],6,2),substr($tab_news[$i]['Date'],0,4));
	//echo date('d/m/Y',date('U')) . '/' . date('d/m/Y',$date);
	$tab_news[$i]['date'] = date('d/m/Y',$date);
	$tab_news[$i]['url'] = append_sid('news/viewnews.php?news_id='.$tab_news[$i]['news_id']);
}
if (count($tab_news)==0)
	$tab_maj[0] = array(
				"date" => date('d/m/Y'),
				"title" => $lang['no_news'],
				"url" => $phpbb_root_path . 'news/'
			);

// Mises à jours
$maj = array();
$tab_maj = select_liste('SELECT maj_id,date,maj FROM famille_maj ORDER BY date DESC');
for($i=0;$i < count($tab_maj);$i++)
{
	$date = mktime(substr($tab_maj[$i]['date'],4,2),substr($tab_maj[$i]['date'],6,2),substr($tab_maj[$i]['date'],0,4));
	$tab_maj[$i]['date'] = date('d/m/Y',$date);
	$tab_maj[$i]['url'] = append_sid('maj/viewmaj.php?maj_id='.$tab_maj[$i]['maj_id']);
}
if (count($tab_maj)==0)
	$tab_maj[0] = array(
				"date" => date('d/m/Y'),
				"title" => $lang['no_maj'],
				"url" => 'maj/'
			);

// A ne pas manquer
$manquer = array();
$tab_manquer = select_liste('SELECT * FROM media_emission WHERE date >= ' . date('Ymd') . ' OR finish >= ' . date('Ymd') . ' ORDER BY date DESC');
for($i=0;$i < count($tab_manquer);$i++)
{
	$date = mktime(substr($tab_maj[$i]['date'],4,2),substr($tab_maj[$i]['date'],6,2),substr($tab_maj[$i]['date'],0,4));
	$tab_manquer[$i]['date'] = date('d/m/Y',$date);
	$tab_manquer[$i]['url'] = append_sid('media/view_emission.php?emission_id='.$tab_maj[$i]['emission_id']);
}
if (count($tab_manquer)==0)
	$tab_manquer[0] = array(
				"date" => date('d/m/Y'),
				"title" => $lang['no_dont_miss'],
				"url" => 'media/'
			);

// Jean-Jacques a dit
$jjg_say_texte = bbencode_second_pass($site_config['annonces'], $site_config['bbcode_uid']);
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'news'))
{
	$admin_jjg_say = append_sid($phpbb_root_path . 'accueil/edit_mascotte.php');
	$l_jjg_say_admin =  $lang['make_speak'];
} else
{
	$admin_jjg_say = '';
	$l_jjg_say_admin =  '';
}

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_accueil'],'accueil');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif();

	
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);



$template->set_filenames(array(
	'body' => 'site/accueil/edit_mascotte.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/accueil/accueil_colonne_gauche.tpl',
	'colonneDroite' => 'site/accueil/accueil_colonne_droite.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}

$template->assign_vars($rubrikopif[0]);

// Amazon
$val_amazon = select_element('SELECT 
				album.*,MIN(jack.jack_id) jack_id 
				FROM disco_albums album, disco_jacks jack 
				WHERE jack.album_id = album.album_id AND ASIN <> \'0000000000\' 
				GROUP BY album_id
				ORDER BY RAND() LIMIT 0,1','Erreur durant la sélection d\'un album',false);
if (!$val_amazon)
{
	$img_amazon = '../templates/jjgfamille/images/site/px.png';
	$l_amazon = '';
	$u_amazon = append_sid($phpbb_root_path . 'disco/');
} else
{
	$img_amazon = $phpbb_root_path . 'functions/miniature.php?mode=disco&album_id=' . $val_amazon['album_id'] . '&jack_id=' . $val_amazon['jack_id'];
	$l_amazon = $val_amazon['title'];
	$u_amazon = 'http://www.amazon.fr/exec/obidos/ASIN/' . $val_amazon['ASIN'] . '/famille-21';
}


// Edition de la mascotte

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{
	$template->assign_block_vars('switch_edit_mascotte', array());
	$template->assign_vars(array(
					
					"EDIT_MASCOTTE" => $lang['Edit_mascotte'],
					"CHANGE_MASCOTTE" => $lang['Change_mascotte'],
					"U_UPLOAD" => append_sid($phpbb_root_path . 'accueil/edit_mascotte.php?mode=add_mascotte'),
					"L_UPLOAD_MASCOTTE_EXPLAIN" => $lang['upload_mascotte_explain'],
					"L_SUBMIT" => $lang['Submit'],
					"MAX_FILE_SIZE" => ''
				)
	);
}

// Edition de l'annonce d'accueil
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'news'))
{
	$template->assign_block_vars('switch_edit_annonce', array());
	$template->assign_vars(array(
					
					"EDIT_ANNONCE" => $lang['Edit_annonce'],
					"CHANGE_ANNONCE" => $lang['Change_annonce'],
					"U_ACTION" => append_sid($phpbb_root_path . 'accueil/edit_mascotte.php?mode=edit_annonce'),
					"L_ANNONCE_EXPLAIN" => $lang['annonce_explain'],
					"L_ANNONCE_ACTUAL" => preg_replace('/\:(([a-z0-9]:)?)' . $site_config['bbcode_uid'] . '/s', '', $site_config['annonces']),
					"L_SUBMIT" => $lang['Submit']
				)
	);
}

// Edition du texte d'accueil
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
	$template->assign_block_vars('switch_annonce', array());



if ($site_config['annonces'] != '')
	$template->assign_block_vars('switch_jjg_say', array());

if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte
				));


$template->assign_vars(array(
				// JJG a dit
				"JJG_SAY" => $lang['JJG_SAY'],
				"JJG_SAY_TEXT" => nl2br($jjg_say_texte),
				"U_JJG_SAY_ADMIN" => $admin_jjg_say,
				"L_JJG_SAY_ADMIN" => $l_jjg_say_admin,
				
				// Mises à jour
				"MAJ" => $lang['MaJ'],
				
				// News
				"NEWS" => $lang['actu_News'],
				
				// Amazon
				"AMAZON" => $lang['Amazon'],
				"AMAZON_TITLE" => $l_amazon,
				"IMG_AMAZON" => $img_amazon,
				"U_AMAZON" => $u_amazon,
				
				// A ne pas manquer
				"DONT_MISS" => $lang['dont_miss'],
				
				// Crédits
				"L_CREDITS" => $lang['Credits'],
				"U_CREDITS" => append_sid($phpbb_root_path . 'accueil/credits.php'),
				
				"U_RETOUR" => append_sid($phpbb_root_path . 'accueil/index.php'),
				"L_RETOUR" => $lang['retour'],
			)
);

for ($i=0;$i<count($tab_news);$i++)
{
	$template->assign_block_vars('news',array(
						'DATE' => $tab_news[$i]['date'],
						'TITLE' => $tab_news[$i]['title'], 

						'U_VIEWNEWS' => append_sid($tab_news[$i]['url'])
						)
					);
}

for ($i=0;$i<count($tab_maj);$i++)
{
	$template->assign_block_vars('maj',array(
						'DATE' => $tab_maj[$i]['date'],
						'TITLE' => $tab_maj[$i]['title'], 

						'U_VIEWMAJ' => append_sid($tab_maj[$i]['url'])
						)
					);
}

for ($i=0;$i<count($tab_manquer);$i++)
{
	$template->assign_block_vars('media',array(
						'DATE' => $tab_manquer[$i]['date'],
						'TITLE' => $tab_manquer[$i]['title'], 

						'U_VIEWMEDIA' => append_sid($tab_manquer[$i]['url'])
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
$template->assign_var_from_handle('COLONNE_DROITE', 'colonneDroite');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>