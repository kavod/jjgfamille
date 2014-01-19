<?php

define('IN_PHPBB', true);
define('WEBSITE_POSITION', 'website');
$phpbb_root_path = '../';
$actual_rub = 'famille';
include($phpbb_root_path . 'forum/extension.inc');
include($phpbb_root_path . 'forum/common.'.$phpEx);
include($phpbb_root_path . 'functions/functions.php');
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_FAMILLE);
init_userprefs($userdata);
//
// End session management
//

$rdf_id = $_GET['rdf_id'];

//Responsable(s) rubrique
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='rdf' ORDER BY user_id");
//la rdf séléctionnée
$val_rdf = select_element("SELECT * FROM rdf WHERE rdf_id= ".$rdf_id." LIMIT 0,1",'',false);
// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');
//Liste Rubriques
$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id ");
//Séléction des photos
$tab_photos = select_liste("SELECT * FROM rdf_photos WHERE rdf_id = ".$rdf_id." ORDER BY ordre");
$tab_photos_count = select_liste("SELECT COUNT(*) nb_photos, username FROM rdf_photos WHERE rdf_id=".$val_rdf['rdf_id']." GROUP BY username");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['Réunion De Famille'].' '.$lang['Galerie_photo'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/photos.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				"RESPONSABLES" => $lang['Responsables'],
				'NOM_RUB' => $lang['Famille'],
				'RUB' => $lang['Réunion De Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'L_RDF' => $lang['Réunion De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/view_rdf.php?rdf_id='.$rdf_id),
				'L_RETOUR' => $lang['retour'],	
				'GALERIE' => $lang['Galerie_photo'].' '.$lang['Réunion De Famille'],			
			)
);


// On définit le nombre de photo par ligne
define("NB_BY_COL",3);
// On enregistre le nombre de photos totale (pour optimiser les calculs)
$nb_photos = count($tab_photos);
// Pour chaque ligne...
$i=0;
while($i<$nb_photos)
{
	$template->assign_block_vars('photos_row',array());
	// Pour chaque image de la ligne
	for ($j=0;$j < NB_BY_COL && $i<$nb_photos;$j++)
	{
		
		if($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'rdf'))
		 {
			$l_monter = '<--';
			$u_monter = append_sid('../famille/doedit.php?mode=up_photo&rdf_id='.$rdf_id.'&photo_id='.$tab_photos[$i]['photo_id']);
			$l_descendre = '-->';
			$u_descendre = append_sid('../famille/doedit.php?mode=down_photo&rdf_id='.$rdf_id.'&photo_id='.$tab_photos[$i]['photo_id']);
		}

		if($userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'rdf') || $userdata['user_id']==$tab_photos[$i]['user_id'])
		{
			$l_modifier = '[&nbsp;'.$lang['Modifier'].'&nbsp;]';
			$u_modifier = append_sid('../famille/edit_photo.php?photo_id='.$tab_photos[$i]['photo_id']);
		}
		
		$url_image = $phpbb_root_path . 'images/rdf/photo_'.$tab_photos[$i]['rdf_id'].'_'.$tab_photos[$i]['photo_id'].'.';
		$url_image .= find_image($url_image);
				if (is_file($url_image))
					$image = $phpbb_root_path . 'functions/miniature.php?mode=rdf&photo_id=' . $tab_photos[$i]['photo_id'] . '&rdf_id=' . $tab_photos[$i]['rdf_id'];
					else $image = '';
	
				$size = getimagesize($url_image);
	
				if($tab_photos[$i]['description'] == "" && $tab_photos[$i]['photographe']== "")
					$height = $size[1]+30;
				else $height = $size[1]+180;		

			$onclick = "window.open('photo.php?photo_id=".$tab_photos[$i]['photo_id']." ','name','noresizable,scrollbars=no,menubar=auto,width=".($size[0]+20).",height=".$height.",left=100,top=100')";
				
		$template->assign_block_vars('photos_row.photos_column',array(
							'ILLU' => $image,
							'ONCLICK' => $onclick,
							'PHOTOGRAPHE' => sprintf($lang['photographe'],$tab_photos[$i]['photographe']),
							'L_MONTER' => $l_monter,
							'U_MONTER' => $u_monter,
							'L_DESCENDRE' => $l_descendre,
							'U_DESCENDRE' => $u_descendre,
							'L_MODIFIER' => $l_modifier,
							'U_MODIFIER' => $u_modifier,
							)
						);
		$i++;
	}
}

for ($i=0;$i<count($tab_photos_count);$i++)
{
		
		if($tab_photos_count[$i]['nb_photos']==1)
			$photos = $lang['photo'];
		elseif($tab_photos_count[$i]['nb_photos']>1)
			$photos = $lang['photos'];
		
		$template->assign_block_vars('switch_count',array(
						'U_USER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$tab_photos_count[$i]['user_id']),
						'L_PHOTO' => '<b>'.$tab_photos_count[$i]['nb_photos'].'</b>&nbsp;'.$photos.'&nbsp;'.$lang['de'],
						'L_USER' => $tab_photos_count[$i]['username'],
			)
		);
}

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'famille/edit_mascotte.php'),
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

for ($i=0;$i<count($tab_rub);$i++)
{
		
		$template->assign_block_vars('switch_rub',array(
						"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub[$i]['rub_id']),
						"L_RUB" =>  $tab_rub[$i]['name'],
						)
					);
}

require_once( $phpbb_root_path . 'functions/functions_rubrikopif.php');
$sitopif = short_desc('rdf','opif');
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