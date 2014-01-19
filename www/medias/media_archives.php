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

//Selection de l'année 
$annee = $_POST['annee']; 

if (!isset($annee) || $annee==0)
{	
	$datemin = date('Ymd',mktime(12,0,0,date('m')-2,date('d'),date('Y')));
   	$datemax = date('Ymd');
	$tab_media = select_liste("SELECT * FROM media_emission WHERE date >= ".$datemin." AND date < ".$datemax." ORDER BY date DESC");
} else
{	
	$datemin = $annee . '0101';
   	$datemax = $annee . '1231';
	$tab_media = select_liste("SELECT * FROM media_emission WHERE date >= ".$datemin." AND date < ".$datemax." ORDER BY date DESC");
}

// Archives
$tab_annee = select_liste("SELECT DISTINCT SUBSTRING(date,1,4) annee FROM media_emission ORDER BY annee");

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='media' ORDER BY user_id");

//
//Mascotte
//
$img_mascotte = affiche_mascotte($site_config['mascotte_medias'],'medias');


//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['nom_rub_media'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/medias/media_archives.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/medias/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'medias/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if(!$tab_media)
{
	$date = '';
	$titre = '';
	$support = '';
	$no = $lang['no_archives'];
}else
{
	$date = $lang['Date'];
	$titre = $lang['l_titre'];
	$support = $lang['Support'];
	$no = '';
}

$template->assign_vars(array(
				'NOM_RUB_MEDIAS' => $lang['nom_rub_media'],
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Medias'],
				'L_ACCES_MEDIATHEQUE' => $lang['go_to_the_medias'],
				'U_MEDIATHEQUE' => append_sid($phpbb_root_path . 'medias/medias.php'),
				'L_ACCES_REPORTAGES' => $lang['go_to_the_reportages'],
				'U_REPORTAGES' => append_sid($phpbb_root_path . 'medias/reportages.php'),
				'L_MEDIATHEQUE' => $lang['nom_rub_media'],
				'L_REPORTAGES' => $lang['reportages'],				
				"IMG_MASCOTTE" => $mascotte,
				"U_ARCHIVES" => append_sid('media_archives.php'),
				"L_DATE" => $date,
				"L_TITRE" => $titre,
				"L_SUPPORT" => $support,
				"NO" => $no,
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'medias/medias.php'),			
			)
);

$template->assign_block_vars('archives',array(
									'ANNEE' => $lang['two_last_months'],
									'VALUE' => 0,
									'SELECTED' => ($annee==0) ? " SELECTED" : ""
									)
								);
for ($i=0;$i<count($tab_annee);$i++)
	$template->assign_block_vars('archives',array(
									'ANNEE' => $tab_annee[$i]['annee'],
									'VALUE' => $tab_annee[$i]['annee'],
									'SELECTED' => ($tab_annee[$i]['annee'] == $annee) ? " SELECTED" : ""
									)
									);

for ($i=0;$i<count($tab_media);$i++)
{	

	$template->assign_block_vars('switch_media',template_emission($tab_media[$i],false));
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