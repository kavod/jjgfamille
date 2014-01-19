<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'accueil';

if (isset($_GET['famille4']))
{
	$famille4 = true;
}
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.'.$phpEx);
include($phpbb_root_path . 'functions/functions_disco.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ACCUEIL);
init_userprefs($userdata);
//
// End session management
//


// Editorial
$val_edito = select_element('SELECT * FROM famille_edito ORDER BY date_unix DESC,edito_id DESC LIMIT 0,1','',false);
if ($val_edito)
{
	// Titre de l'édito
	$edito_title = $val_edito['title'];
	
	// Identifiant de l'édito
	$edito_id = $val_edito['edito_id'];
	
	// Auteur de l'édito
	$val_author = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = '.$val_edito['user_id'],'',false);
	if ($val_author)
	{
		$edito_author_username = $val_author['username'];
	} else $edito_author_username = ($val_edito['username'] != '') ? $val_edito['username'] : 'Annonyme';
	
	// Texte de l'édito
	$bbcode_uid = $val_edito['bbcode_uid'];
	$message = bbencode_second_pass(nl2br($val_edito['edito']), $bbcode_uid);
	
	// Illustration de l'édito
	$illu_url = $phpbb_root_path . 'images/edito/edito_' . $val_edito['edito_id'];
	
	if (find_image($illu_url))
	{
		//$illu_url = $phpbb_root_path . 'images/edito/edito_' . $val_edito['edito_id'] . '.' . $val_edito['illu_extension'];
		$edito_img = (is_file($illu_url.'.'.find_image($illu_url))) ? '<img src="' . $illu_url . '.' . find_image($illu_url)  . '" border="0">' : '';
		
		// Auteur de l'illustration
		$val_author_illu = select_element('SELECT user_id,username FROM phpbb_users WHERE user_id = '.$val_edito['illu_user_id'],'',false);
		if ($val_author_illu)
		{
			$edito_author_illu = $val_author_illu['username'];
		} else 
			$edito_author_illu = 'Annonyme';
		$edito_illu_signature = sprintf($lang['done_by'],$lang['picture'],append_sid($phpbb_root_path . 'forum/profile.' . $phpEx . '?mode=viewprofile&u=' . $val_author_illu['user_id']),$edito_author_illu);
	} else $edito_img = '';
	
	// Date de l'édito
	//$edito_time = mktime(0,0,0,substr($val_edito['Date'],4,2),substr($val_edito['Date'],6,2),substr($val_edito['Date'],0,4));
	$edito_date = create_date($board_config['default_dateformat'], $val_edito['date_unix'], $board_config['board_timezone']);
} else 
{
	$edito_id = 0;
	$edito_title = 'Pas d\'éditorial disponible';
}

// Administration de l'édito
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'edito') || is_responsable($userdata['user_id'],'mascotte'))
{
	$url = $phpbb_root_path . 'actu/edit_edito.php' . (($edito_id != 0) ? '?mode=edit&edito_id=' . $edito_id : '');
	$u_edito_admin = append_sid($url);
	$l_edito_admin =  $lang['edit_edito'];
	$switch_edito_admin = true;
} else
	$switch_edito_admin = false;


// News
$news = array();
$tab_news = select_liste('SELECT news_id,date_unix,title FROM famille_news WHERE date_hot_unix >= '.date('U') . ' ORDER BY date_hot_unix DESC,date_unix DESC');
for($i=0;$i<count($tab_news);$i++)
{
	//$date = mktime(12,0,0,substr($tab_news[$i]['Date'],4,2),substr($tab_news[$i]['Date'],6,2),substr($tab_news[$i]['Date'],0,4));
	//echo date('d/m/Y',date('U')) . '/' . date('d/m/Y',$date);
	$tab_news[$i]['date'] = date('d/m/Y',$tab_news[$i]['date_unix']);
	$tab_news[$i]['url'] = append_sid($phpbb_root_path . 'actu/n'.$tab_news[$i]['news_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($tab_news[$i]['title'])).'.html');
}
if (count($tab_news)==0)
	$tab_maj[0] = array(
				"date" => date('d/m/Y'),
				"title" => $lang['no_news'],
				"url" => $phpbb_root_path . 'actu/news.html'
			);

// Mises à jours
$maj = array();
$tab_maj = select_liste('SELECT title,maj_id,date_unix,maj FROM famille_maj WHERE date_hot_unix > \'' . date('U') . '\' ORDER BY date_unix DESC');
for($i=0;$i < count($tab_maj);$i++)
{
	//$date = mktime(substr($tab_maj[$i]['date'],4,2),substr($tab_maj[$i]['date'],6,2),substr($tab_maj[$i]['date'],0,4));
	$tab_maj[$i]['date'] = date('d/m/Y',$tab_maj[$i]['date_unix']);
	$tab_maj[$i]['url'] = append_sid($phpbb_root_path . 'actu/m'.$tab_maj[$i]['maj_id'].'-' . str_replace('&amp;url_title=','',add_title_in_url($tab_maj[$i]['title'])).'.html');
}
if (count($tab_maj)==0)
	$tab_maj[0] = array(
				"date" => date('d/m/Y'),
				"title" => $lang['no_maj'],
				"url" => $phpbb_root_path . 'actu/maj.html'
			);

// A ne pas manquer
$manquer = array();
$tab_manquer = select_liste('SELECT * FROM media_emission WHERE date_hot >= ' . date('Ymd') . ' OR finish >= ' . date('Ymd') . ' ORDER BY date DESC');
for($i=0;$i < count($tab_manquer);$i++)
{
	$date = mktime(12,0,0,substr($tab_manquer[$i]['date'],4,2),substr($tab_manquer[$i]['date'],6,2),substr($tab_manquer[$i]['date'],0,4));
	$tab_manquer[$i]['date'] = date('d/m/Y',$date);
	$val_support = select_element("SELECT * FROM media_supports WHERE support_id='".$tab_manquer[$i]['support_id']."' ");
	switch($tab_manquer[$i]['media_type'])
	{
		case 'TV':
		case 'Radio':
			$type='emission';
		default:
			$type='article';
	}
	$tab_manquer[$i]['url'] = append_sid($phpbb_root_path . 'medias/' . $type . '-' . str_replace('&amp;url_title=','',add_title_in_url($val_support['support_name'] . '-' . $tab_manquer[$i]['title'])). '-' . $tab_manquer[$i]['emission_id'] . '.html');
	$tab_manquer[$i]['title'] = '<b>' . $val_support['support_name'] . ' :</b> '. $tab_manquer[$i]['title'];
	//$tab_manquer[$i]['url'] = append_sid($phpbb_root_path . 'medias/view_emission.php?emission_id='.$tab_manquer[$i]['emission_id']);
}
if (count($tab_manquer)==0)
	$tab_manquer[0] = array(
				"date" => date('d/m/Y'),
				"title" => $lang['no_dont_miss'],
				"url" => $phpbb_root_path . 'medias/mediatheque.html'
			);

// Jean-Jacques a dit
$val_bbcode = select_element('SELECT valeur_char bbcode_uid FROM famille_config WHERE param = \'bbcode_uid\'','Impossible d\'afficher les annonces d\accueil',true);
$val_texte = select_element('SELECT valeur_char texte FROM famille_config WHERE param = \'annonces\'','Annonce d\'accueil introuvable',true);
$jjg_say_texte = bbencode_second_pass($val_texte['texte'], $val_bbcode['bbcode_uid']);
if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'news') || is_responsable($userdata['user_id'],'mascotte'))
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

// Amazon

$val_amazon = select_element('SELECT 
				album.*,MIN(jack.jack_id) jack_id 
				FROM disco_albums album, disco_jacks jack 
				WHERE jack.album_id = album.album_id AND ASIN <> 0 
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
	$u_amazon = 'http://www.fnac.com/Shelf/article.asp?PRID=' . $val_amazon['ASIN'] . '&Origin=JJGFAMILLE&OriginClick=yes';
	
}

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['site_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/accueil/index_body.tpl',
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

if ($val_texte['texte'] != '')
	$template->assign_block_vars('switch_jjg_say', array());

if ($img_mascotte)
	$template->assign_block_vars('switch_mascotte', array(
				"IMG_MASCOTTE" => $img_mascotte
				));


if ($switch_edito_admin)
	$template->assign_block_vars('switch_edito_admin', array(
				'U_EDITO_ADMIN' => $u_edito_admin,
				'L_EDITO_ADMIN' => $l_edito_admin
				));


$template->assign_vars(array(
				// Edito
				"EDITORIAL" => $lang['Editorial'],
				"EDITO_TITLE" => $edito_title,
				"U_EDITO_TITLE" => append_sid($phpbb_root_path . 'actu/e'.$edito_id.'-' . str_replace('&amp;url_title=','',add_title_in_url($edito_title)).'.html'),
				"EDITO_SIGNATURE" => sprintf($lang['the_by'],$edito_date,append_sid($phpbb_root_path . 'forum/profile.' . $phpEx . '?mode=viewprofile&u=' . $val_author['user_id']),$edito_author_username),
				"EDITO_CORPS" => $message,
				"EDITO_ILLU" => $edito_img,
				"EDITO_ILLU_SIGNATURE" => $edito_illu_signature,
				
				// JJG a dit
				"JJG_SAY" => $lang['JJG_SAY'],
				"JJG_SAY_TEXT" => nl2br($jjg_say_texte),
				"U_JJG_SAY_ADMIN" => $admin_jjg_say,
				"L_JJG_SAY_ADMIN" => $l_jjg_say_admin,
				
				
				// Mises à jour
				"MAJ" => $lang['MaJ'],
				'U_MAJ' => append_sid($phpbb_root_path . 'actu/maj.html'),
				
				// News
				"NEWS" => $lang['actu_News'],
				'U_NEWS' => append_sid($phpbb_root_path . 'actu/news.html'),
				
				// Amazon
				"AMAZON" => $lang['Amazon'],
				"AMAZON_TITLE" => $l_amazon,
				"IMG_AMAZON" => $img_amazon,
				"U_AMAZON" => $u_amazon,
				"WHY_PUB" => $lang['why_pub'],
				"U_WHY_PUB" => append_sid($phpbb_root_path . "famille/rub.php?rub_id=21"),
				
				// A ne pas manquer
				"DONT_MISS" => $lang['dont_miss'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				
				// Crédits
				"L_CREDITS" => $lang['Credits'],
				"U_CREDITS" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id=18'),
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
						'TITLE' => smilies_pass($tab_maj[$i]['title']), 

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

$list_rub = array("midi","disco","media","report");
$numopif = rand (0,count($list_rub)-1);
$rubopif = $list_rub[$numopif];

	$template->assign_block_vars('jukebox',array(
						'JUKEBOX' => 'Le Jukebox famille',
						'U_TITLE' => "window.open('../fmc/jukebox.php?mode=".$rubopif."','Jukebox','noresizable,scrollbars=yes,menubar=auto,width=800,height=500,left=100,top=100')",
						'L_TITLE' => 'Ecouter un extrait',
						'IMG' => append_sid($phpbb_root_path . 'images/jukebox.gif'),
						)
					);

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');
$template->assign_var_from_handle('COLONNE_DROITE', 'colonneDroite');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
