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

$tab_rub = select_liste("SELECT * FROM famille_rub ORDER BY rub_id");
$tab_equipe = select_liste("SELECT A.user_id,A.username FROM phpbb_users A,phpbb_user_group B WHERE A.user_id = B.user_id AND B.group_id = 10 AND user_rank <> 1");
$tab_equipe_admin = select_liste("SELECT user_id,username FROM phpbb_users WHERE user_rank = 1 AND user_id <> 2");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_famille'],'famille');

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array());

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['equipe'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/famille/equipe.tpl',
	'rubrikopif' => 'site/rubrikopif/rubrikopif.tpl',
	'colonneGauche' => 'site/famille/colonne_gauche.tpl')
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

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['Famille'],
				'EQUIPE' => $lang['equipe'],
				'L_EQUIPE' => $lang['equipe'],
				'U_EQUIPE' => append_sid($phpbb_root_path . 'famille/equipe.php'),
				'L_RETOUR' => $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'famille/index.php'),
				'L_RDF' => $lang['Réunion De Famille'],
				'U_RDF' => append_sid($phpbb_root_path . 'famille/rdf.php'),
			)
);

if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'famille/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

//// Les admins

for ($i=0;$i<count($tab_equipe_admin);$i++)
{
		
		$val_user = select_element("SELECT user_avatar FROM phpbb_users WHERE user_id = ".$tab_equipe_admin[$i]['user_id']."",'',false);
		
		$img = '../images/forum/photos/photo_' . $tab_equipe_admin[$i]['user_id'].'.';
		$ext = find_image($img);
		$img .= $ext;
		
		if (is_file($img))
		{
			$avatar = $img;
		}
		else
		{
			if (is_file('../images/forum/avatars/' . $val_user['user_avatar']))
			{
			
				$avatar = '../images/forum/avatars/' . $val_user['user_avatar'];
			}
			else
			{
				$avatar = '../templates/jjgfamille/images/site/px.png';	
			}
		}
		
			$template->assign_block_vars('switch_equipe_admin',array(
							'U_USER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$tab_equipe_admin[$i]['user_id']),
							'L_USER' => $tab_equipe_admin[$i]['username'],
							'MEMBRE' => '<b>'.$lang['Administrateur'].'</b>',
							'AVATAR' => $avatar,
							)
						);
	
			$tab_job = select_liste("SELECT * FROM famille_access WHERE user_id = ".$tab_equipe_admin[$i]['user_id']."");
		
			for ($j=0;$j<count($tab_job);$j++)
			{
			
			Switch ($tab_job[$j]['rub'])
			{
				case "edito":
					$job=", Editorialiste";
					break;
				Case "tournee":
					$job=", Responsable rubrique Tournées";
					break;
				Case "media":
					$job=", Responsable rubrique medias";
					break;
				Case "sam":
					$job=", Responsable Discographie";
					break;
				Case "photo":
					$job=", Responsable Illustrations";
					break;
				Case "creation":
					$job=", Responsable rubrique créations";
					break;
				Case "biophoto":
					$job=", Illustrations biographie";
					break;
				Case "biotexte":
					$job=", Biographie";
					break;
				Case "autrehistoire":
					$job=", Responsable rubrique \"Une autre histoire\"";
					break;
				Case "maj":
					$job=", Responsable Mises à Jours";
					break;
				Case "news":
					$job=", Responsable des News";
					break;
				Case "liens":
					$job=", Responsable rubrique liens";
					break;
				Case "biblio":
					$job=", Responsable bibliothèque";
					break;
				Case "photos":
					$job=", Responsable galerie photos";
					break;
				Case "mascotte":
					$job=", Responsable mascotte";
					break;
				Case "more":
					$job=", Responsable rubrique En++";
					break;
				Case "chat":
					$job=", Responsable du chat famille";
					break;
				Case "rdn":
					$job=", Responsable Revue du net";
					break;
				Case "rdf":
					$job=", Responsable rubrique RDF"; 
					break;
				default:
					$job = "";
			}
			
			
					$template->assign_block_vars('switch_equipe_admin.switch_job',array(
							'JOB' => $job,
							)
						);
			}
}

//////// Les membres

for ($i=0;$i<count($tab_equipe);$i++)
{
		
		$val_user = select_element("SELECT user_avatar FROM phpbb_users WHERE user_id = ".$tab_equipe[$i]['user_id']."",'',false);
		
		$img = '../images/forum/photos/photo_' . $tab_equipe[$i]['user_id'].'.';
		$ext = find_image($img);
		$img .= $ext;
		
		if (is_file($img))
		{
			$avatar = $img;
		}
		else
		{
			if (is_file('../images/forum/avatars/' . $val_user['user_avatar']))
			{
			
				$avatar = '../images/forum/avatars/' . $val_user['user_avatar'];
			}
			else
			{
				$avatar = '../templates/jjgfamille/images/site/px.png';	
			}
		}
		
			$template->assign_block_vars('switch_equipe',array(
							'U_USER' => append_sid($phpbb_root_path . 'forum/privmsg.php?mode=post&u='.$tab_equipe[$i]['user_id']),
							'L_USER' => $tab_equipe[$i]['username'],
							'MEMBRE' => $lang['Membre'],
							'AVATAR' => $avatar,
							)
						);
	
			$tab_job = select_liste("SELECT * FROM famille_access WHERE user_id = ".$tab_equipe[$i]['user_id']."");
		
			for ($j=0;$j<count($tab_job);$j++)
			{
			
			Switch ($tab_job[$j]['rub'])
			{
				case "edito":
					$job=", Editorialiste";
					break;
				Case "revue":
					$job=", Responsable Revue du net";
					break;
				Case "tournee":
					$job=", Responsable rubrique Tournées";
					break;
				Case "media":
					$job=", Responsable rubrique medias";
					break;
				Case "sam":
					$job=", Responsable Discographie";
					break;
				Case "photo":
					$job=", Responsable Illustrations";
					break;
				Case "creation":
					$job=", Responsable rubrique créations";
					break;
				Case "biophoto":
					$job=", Illustrations biographie";
					break;
				Case "biotexte":
					$job=", Biographie";
					break;
				Case "autrehistoire":
					$job=", Responsable rubrique \"Une autre histoire\"";
					break;
				Case "maj":
					$job=", Responsable Mises à Jours";
					break;
				Case "news":
					$job=", Responsable des News";
					break;
				Case "liens":
					$job=", Responsable rubrique liens";
					break;
				Case "biblio":
					$job=", Responsable bibliothèque";
					break;
				Case "photos":
					$job=", Responsable galerie photos";
					break;
				Case "mascotte":
					$job=", Responsable mascotte";
					break;
				Case "more":
					$job=", Responsable rubrique En++";
					break;
				Case "chat":
					$job=", Responsable du chat famille";
					break;
				Case "rdn":
					$job=", Responsable Revue du net";
					break;
				Case "rdf":
					$job=", Responsable rubrique RDF";
					break;
				default:
					$job = "";
			}
			
			
					$template->assign_block_vars('switch_equipe.switch_job',array(
							'JOB' => $job,
							)
						);
			}
}

for ($i=0;$i<count($tab_rub);$i++)
{
		
		$template->assign_block_vars('switch_rub',array(
						"U_RUB" => append_sid($phpbb_root_path . 'famille/rub.php?rub_id='.$tab_rub[$i]['rub_id']),
						"L_RUB" =>  $tab_rub[$i]['name'],
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