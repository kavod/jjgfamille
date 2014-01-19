<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('medias','report','video'));
//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Medias'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/index.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ( $rubrikopif[2] )
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[2] );

if ( $rubrikopif[1] )
{
	$template->assign_block_vars('rubrikopif_element', $rubrikopif[1] );
}


$template->assign_vars($rubrikopif[0]);


if ($img_mascotte)
$mascotte = $img_mascotte;

//Chiffres clefs

$accedez_medias = rubrikopif(array('medias'));
$medias = select_element('SELECT * FROM media_illustrations ORDER BY RAND() LIMIT 0,1','',false);
$url_image = '../images/medias/illustration_'.$medias['emission_id'].'_'.$medias['illustration_id'].'.';
$ext = find_image($url_image);
$url_image .= $ext;
$img_medias = ($medias && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=medias&emission_id=' . $medias['emission_id'] .'&illu_id='. $medias['illustration_id'] . "&tnH=112" : '../templates/jjgfamille/images/site/px.png' ;

$accedez_report = rubrikopif(array('report'));
$report = select_element('SELECT * FROM report_photos ORDER BY RAND() LIMIT 0,1','',false);
$url_image = '../images/report/photo_'.$report['report_id'].'_'.$report['photo_id'].'.';
$ext = find_image($url_image);
$url_image .= $ext;
$img_report = ($report && is_file($url_image)) ? $phpbb_root_path . 'functions/miniature.php?mode=report&photo_id=' . $report['photo_id'] .'&report_id='. $report['report_id'] . "&tnH=112" : '../templates/jjgfamille/images/site/px.png' ;

$val_video = select_element("SELECT * FROM `video_video` ORDER BY RAND()",false,'');
$img_video = "http://img.youtube.com/vi/" . $val_video['code'] . "/2.jpg";
$accedez_video = rubrikopif(array('video'));
$template->assign_vars(array(
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/mediatheque.html'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'L_ACCES_VIDEO' => $lang['go_to_the_video'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.html'),
				'U_VIDEO' => append_sid($phpbb_root_path . 'medias/video.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],
				'L_VIDEO' => $lang['Videos'],
				"IMG_MASCOTTE" => $mascotte,
				'ACCEDEZ_MEDIATHEQUE' => $lang['accedez_medias'],
				'ACCEDEZ_VIDEO' => $lang['accedez_video'],
				'STATS_MEDIATHEQUE' => $accedez_medias[0]['CHIFFRES'],
				'ALT_MEDIAS' => $accedez_medias[0]['RUBRIKOPIF_TITLE'],
				'ACCEDEZ_REPORTAGES' => $lang['accedez_report'],
				'STATS_REPORTAGES' => $accedez_report[0]['CHIFFRES'],
				'STATS_VIDEO' => $accedez_video[0]['CHIFFRES'],
				'ALT_REPORT' => $accedez_report[0]['RUBRIKOPIF_TITLE'],
				'ALT_VIDEO' => $accedez_video[0]['RUBRIKOPIF_TITLE'],
				'IMG_MEDIAS' => $img_medias,
				'IMG_REPORT' => $img_report,
				'IMG_VIDEO' => $img_video,
				
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

$template->assign_var_from_handle('OPIF', 'rubrikopif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>