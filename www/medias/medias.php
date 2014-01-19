<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'medias';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions_media.php');
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_MEDIAS);
init_userprefs($userdata);
//
// End session management
//


//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

$tab_prochainement = select_liste("SELECT * FROM media_emission WHERE date >= ".date('Ymd')." ORDER BY date,heure");

$tab_en_vedette = select_liste("SELECT * FROM media_emission WHERE date_hot >= " . date('Ymd') . " AND date_hot <> 0 AND date < " . date('Ymd') . " ORDER BY date,heure");
if (count($tab_en_vedette)==0)
{	
	$tab_en_vedette = select_liste("SELECT * FROM media_emission WHERE date < " . date('Ymd') . " ORDER BY date DESC,heure DESC LIMIT 0,1");
	$tab_en_liste = select_liste("SELECT * FROM media_emission WHERE date < " . date('Ymd') . " ORDER BY date DESC,heure DESC LIMIT 1,5");
} else
{
	$tab_en_liste = select_liste("SELECT * FROM media_emission WHERE  date < ".date('Ymd')." AND (date_hot < " . date('Ymd') . " OR date_hot = 0) ORDER BY date DESC,heure DESC LIMIT 0,5");
}

// Archives
$tab_annee = select_liste("SELECT DISTINCT SUBSTRING(date,1,4) annee FROM media_emission ORDER BY annee");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['nom_rub_media'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/medias.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['nom_rub_media'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/mediatheque.html'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.html'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"U_ARCHIVES" => append_sid('media_archives.php'),
				"L_GO" => $lang['go'],
				"L_PROCHAINEMENT" => sprintf($lang['deux_points'],$lang['prochainement']),
				"L_DESCRIPTION" => $lang['description'],
				"L_DERNIEREMENT" => sprintf($lang['deux_points'],$lang['dernierement']),
				"L_GO_TO_ARCHIVES" => $lang['go_to_the_archives'],
				"L_YOU_TO_PLAY" => $lang['it_is_you_to_play'],
				"ANNOUNCE_YOURSELF" => sprintf($lang['announes_yours'],$lang['emissions'].', '.$lang['articles'].'...'),
				"U_ANNOUNCE_YOURSELF" => append_sid($phpbb_root_path . 'medias/add_emission.php'),
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/'),
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

for ($i=0;$i<count($tab_access);$i++)
{
	$val_access = select_element("SELECT user_id,username FROM phpbb_users WHERE user_id= ".$tab_access[$i]['user_id']."  LIMIT 0,1",'',false);
	$template->assign_block_vars('switch_access',array(
						'U_RESP' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$val_access['user_id']),
						'RESP' => $val_access['username']
						)
					);
}
if (count($tab_prochainement)>0)
	$template->assign_block_vars('switch_prochainement',array());
for ($i=0;$i<count($tab_prochainement);$i++)
	$template->assign_block_vars('switch_prochainement.emission',template_emission($tab_prochainement[$i]));


for ($i=0;$i<count($tab_en_vedette);$i++)
	$template->assign_block_vars('en_vedette',template_emission($tab_en_vedette[$i]));

for ($i=0;$i<count($tab_en_liste);$i++)
	$template->assign_block_vars('en_liste',template_emission($tab_en_liste[$i],false));
	
$template->assign_block_vars('archives',array(
									'ANNEE' => $lang['two_last_months'],
									'VALUE' => 0
									)
								);
for ($i=0;$i<count($tab_annee);$i++)
	$template->assign_block_vars('archives',array(
									'ANNEE' => $tab_annee[$i]['annee'],
									'VALUE' => $tab_annee[$i]['annee']
									)
									);

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('medias','opif');
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