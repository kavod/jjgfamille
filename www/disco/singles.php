<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'disco';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require_once($phpbb_root_path . 'functions/functions_disco.php');
require_once($phpbb_root_path . 'functions/url_rewriting.php');
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_DISCO);
init_userprefs($userdata);
//
// End session management
//

if(isset($_GET['annee']))
{
	$annee = $_GET['annee'];
}else
{
	$annee = $_POST['annee'];
}

//Liste deroulante des années

$sql_annee = "SELECT date FROM disco_albums WHERE type='le single' AND (artist_id = 1";
		$result_band = mysql_query("SELECT * FROM disco_bands WHERE artist_id = 1");
		While ($val_band = mysql_fetch_array($result_band))
		{
			$sql_annee .= " OR artist_id = ".$val_band['band_id'];
		}
$sql_annee .= ") ORDER BY date";
$tab_annee = select_liste($sql_annee);

//Selection des singles
if(isset($annee) && $annee!= "")
{
	$sql_albums = "SELECT * FROM disco_albums WHERE type='le single' AND (artist_id = 1";
		$result_band = mysql_query("SELECT * FROM disco_bands WHERE artist_id = 1");
		While ($val_band = mysql_fetch_array($result_band))
		{
			$sql_albums .= " OR artist_id = ".$val_band['band_id'];
		}
$sql_albums .= ") AND date LIKE '".$annee."%' ORDER BY title,date,HC";
$tab_albums = select_liste($sql_albums);
}


//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='sam' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_disco'],'disco');

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = ucfirst($lang['Single_albums']);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/disco/singles.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/disco/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'NOM_RUB' => $lang['Discographie'],
				"IMG_MASCOTTE" => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				"L_STUDIOS" => ucfirst($lang['Studio_albums']),
				"U_STUDIOS" => append_sid($phpbb_root_path . 'disco/goldman_albums_studio.html'),
				"L_LIVES" => ucfirst($lang['Live_albums']),
				"U_LIVES" => append_sid($phpbb_root_path . 'disco/goldman_albums_live.html'),
				"L_COMPILATIONS" => ucfirst($lang['Compil_albums']),
				"U_COMPILATIONS" => append_sid($phpbb_root_path . 'disco/goldman_albums_compil.html'),	
				"L_PARTICIPATIONS" => ucfirst($lang['Participations']),
				"U_PARTICIPATIONS" => append_sid($phpbb_root_path . 'disco/goldman_participations.html'),
				"L_SINGLES" => ucfirst($lang['Single_albums']),
				"U_SINGLES" => append_sid($phpbb_root_path . 'disco/goldman_singles.html'),
				"L_LIST_SONG" => $lang['list_song'],
				"U_LIST_SONG" => append_sid($phpbb_root_path . 'disco/goldman_liste_chansons.html'),
				"U_ANNEES" => append_sid($phpbb_root_path . 'disco/goldman_singles.html'),
				"TITLE" => "Jean-Jacques Goldman : ".ucfirst($lang['Single_albums']),
				"L_RETOUR" => $lang['retour'],
				"U_RETOUR" => append_sid($phpbb_root_path . 'disco/'),
				"L_VIDEO" => $lang['Videothèque'],
				"U_VIDEO" => append_sid($phpbb_root_path . 'disco/goldman_albums_video.html'),
			"L_ENFOIRES" => $lang['Les_Enfoirés'],
			"U_ENFOIRES" => append_sid($phpbb_root_path . 'disco/les_enfoires_albums_live_66.html'),
			)
);

for ($i=0;$i<count($tab_albums);$i++)
{	
	$template->assign_block_vars('switch_singles',template_singles($tab_albums[$i],false));
	$tab_titres = select_liste("SELECT * FROM disco_songs,disco_songs_albums WHERE disco_songs.song_id = disco_songs_albums.song_id AND album_id = ".$tab_albums[$i]['album_id']." ORDER BY ordre");
	for ($j=0;$j<count($tab_titres);$j++)
		{	
			$template->assign_block_vars('switch_singles.switch_titres',template_titres($tab_titres[$j],false));
		}	
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'disco/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'sam'))
{
		$template->assign_block_vars('switch_admin_disco',array(
						"U_ADMIN_DISCO" => append_sid($phpbb_root_path . 'disco/sam.php'),
						"L_ADMIN_DISCO" =>  $lang['admin_disco'],
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
$anne = "1111";
for ($i=0;$i<count($tab_annee);$i++)
{
	if (substr($tab_annee[$i]['date'],0,4) != $anne)
		{
			$annees = substr($tab_annee[$i]['date'],0,4);
			$value = substr($tab_annee[$i]['date'],0,4);
			$select = (substr($tab_annee[$i]['date'],0,4) == $annee) ? " SELECTED" : "";
		
		$anne = substr($tab_annee[$i]['date'],0,4);
	$template->assign_block_vars('annees',array(
		'ANNEE' => $annees,
		'VALUE' => $value,
		'SELECTED' => $select,
		)
	);
	}
	
}
		
require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('disco','opif');
if ($sitopif)
	$template->assign_block_vars('switch_opif', $sitopif );

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

$template->assign_var_from_handle('OPIF', 'opif');
$template->assign_var_from_handle('COLONNE_GAUCHE', 'colonneGauche');

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>