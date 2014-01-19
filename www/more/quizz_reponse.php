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

require_once($phpbb_root_path . 'includes/log_necessary.php');

//
//Responsable(s) rubrique
//
$tab_access = select_liste("SELECT * FROM famille_access WHERE rub='more' ORDER BY user_id");

// Mascotte
$img_mascotte = affiche_mascotte($site_config['mascotte_more'],'more');

$rep_id = $_POST['rep_id']; //numero de la chanson repondu

// Bon, déjà, on va vider un peu notre table quizz_question...
// On va donc virer tous les enregistrements qui datent de plus de 2 min
$sql_del_question = "DELETE FROM quizz_question WHERE heure < '".date('H:i:s',mktime ( date('H') , (date('i') - 2), date('s')))."' OR heure > '".date('H:i:s',mktime ( date('H') , (date('i') + 2), date('s')))."'";
mysql_query($sql_del_question) or die("Erreur durant la mise à jour de vos résultats");

// Aller, on va vérifier la réponse de ce bonhomme
$sql_question = "SELECT * FROM quizz_question WHERE sid = '".$userdata['session_id']."'";
$result_question = mysql_query($sql_question) or die("Erreur durant le chargement de votre question");
$val_question = mysql_fetch_array($result_question) or die("Erreur Interne<br>Votre question est introuvable.<br>Merci de contacter <a href=\"../forum/privmsg.php?mode=post&u=725&sid=".$sid."\">Goldmanikou</a>");

	$quest_id = $val_question['song_id'];
	
	// On va virer l'enregistrement de cette question... car sinon un petit F5 et on a des points à volonté pendant 1 min ! ;)
	$sql_del_question = "DELETE FROM quizz_question WHERE sid='".$userdata['session_id']."' OR heure < '".date('H:i:s',mktime ( date('H') , (date('i') - 2), date('s')))."' OR heure > '".date('H:i:s',mktime ( date('H') , (date('i') + 2), date('s')))."'";
	mysql_query($sql_del_question) or die("Erreur durant la mise à jour de vos résultats");

	// Sélection de la réponse exacte
	$sql_song1 = "SELECT song_id,title,lyrics FROM disco_songs WHERE song_id = ".$quest_id;
	$result_song1 = mysql_query($sql_song1) or die("Erreur de la sélection de la réponse");
	$val_song1 = mysql_fetch_array($result_song1) or die("Erreur : chanson inexistante");
	
	// Rappatriement des scores
	$req_score="SELECT * FROM quizz_users WHERE user_id=".$userdata['user_id']; 
	$result_score = mysql_query($req_score) or die("Exécution de la requête impossible");
	$row_score = mysql_fetch_array($result_score) or die("Utilisateur inconnu");
	
	$bonrep=$row_score['score'];
	
	// Sélection de l'ensemble des réponses possibles (à propos des chansons de même titre)
	$sql_song2 = "SELECT * FROM disco_songs WHERE title = '".str_replace("'","\'",$val_song1['title'])."' ORDER BY RAND()";
	$result_song2 = mysql_query($sql_song2) or die("Erreur Interne");
	while ($val_song2 = mysql_fetch_array($result_song2))
	{
		if ($val_song2['song_id']==$rep_id)
		{
			$bonrep++;
			//$questjouer=$row_score['score']+1;
		
			//requete de mise a jour de la bdd pour le score
			$requete = "UPDATE quizz_users SET score=".$bonrep." WHERE user_id=".$userdata['user_id'];
			mysql_query($requete) or die("Erreur durant la mise à jour des scores");
		}
	}
	
	//requete pour rechercher l'album liée a la chanson a trouver
	$sql_albums = "SELECT disco_albums.title,disco_albums.album_id FROM disco_songs,disco_albums,disco_songs_albums WHERE  disco_songs_albums.song_id=disco_songs.song_id AND disco_songs_albums.album_id=disco_albums.album_id AND disco_songs.title = '".str_replace("'","\'",$val_song1['title'])."' AND (disco_albums.type='l\'album' OR disco_albums.type='le live' OR disco_albums.type='la compilation') ORDER BY RAND()";
	$result_albums = mysql_query($sql_albums) or die("Erreur de la sélection de l album<br>Requète SQL : ".$sql_albums);
	@$val_albums = mysql_fetch_array($result_albums);
	if (mysql_num_rows($result_albums)>0) 
	{
		//requete pour chercher l'artiste
		$sql_artists = "SELECT * FROM disco_artists,disco_albums WHERE disco_artists.artist_id = disco_albums.artist_id AND disco_albums.album_id = ".$val_albums[album_id].""; 
		$result_artists = mysql_query($sql_artists) or die("Erreur de la sélection de l artiste");
		$val_artists = mysql_fetch_array($result_artists) or die("Erreur : artiste inexistante");
		
		
		$sql_jack = "SELECT jack_id FROM disco_jacks WHERE album_id = ".$val_albums['album_id']." ORDER BY ordre"; 
		$result_jack = mysql_query($sql_jack) or die("Erreur de la sélection de pochette");
		@$val_jack = mysql_fetch_array($result_jack);
	}


//Gestion du score
//requete qui selectionne le nombre de rep jouer et le nb de bonne rep
$sql_score="SELECT * FROM quizz_users WHERE user_id=".$userdata['user_id'];
$result_score = mysql_query($sql_score) or die("Exécution de la requête impossible");
$val_score = mysql_fetch_array($result_score);

// Rubrikopif
include($phpbb_root_path . 'functions/functions_rubrikopif.php');
$rubrikopif = rubrikopif(array('more'));

//
//Liste des categories
//
$tab_cate = select_liste("SELECT * FROM more_cate ORDER BY ordre");

//
// Start output of page
//
define('SHOW_ONLINE', true);
$page_title = $lang['EnPlusPlus'].' :: '.$lang['Jeux'].' :: Goldman Quizz';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->set_filenames(array(
	'body' => 'site/more/quizz_reponse.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$your_score = '<b>'.$lang['Ton']."&nbsp;".$lang['score']."</b>&nbsp;:&nbsp;"."(".$val_score['score']."/".$val_score['nb_quest'].")&nbsp;";
$pourcent = round(($val_score['score']/$val_score['nb_quest'])*10000)/100;
$your_score=$your_score.$pourcent."&nbsp;%";

if($bonrep!=$row_score['score'])
{
	$good_or_bad = '<b>Bravo!</b> Il s\'agissait effectivement d\'une parole de la chanson <a href="../disco/view_song.php?song_id='.$val_song1['song_id'].'&sid='.$_GET['sid'].'"><b>'.$val_song1['title'].'</b></a>';
}
else
{

        $good_or_bad = '<b>Malheureusement, c\'est une mauvaise réponse</b><br>Il s\'agissait d\'une parole de la chanson <a href="../disco/view_song.php?song_id='.$val_song1['song_id'].'&sid='.$_GET['sid'].'"><b>'.$val_song1['title'].'</a></b>';
}     

if (mysql_num_rows($result_albums)>0) 
	{ 

        $result = 'Cette chanson est présente sur '.mysql_num_rows($result_song2).' albums, dont <b><a href="../disco/view_album.php?album_id='.$val_albums['album_id'].'&sid='.$_GET['sid'].'">'.$val_albums['title'].'</a></font></b> de <b>'.$val_artists['name'].'</b>';

	}	   

if (mysql_num_rows($result_albums)>0 && mysql_num_rows($result_jack)>0)
	{ 
      		$img = $phpbb_root_path . 'functions/miniature.php?mode=disco&jack_id='.$val_jack['jack_id'].'&album_id='.$val_albums['album_id']; 
        }

//Audio
$asso = select_element("SELECT id FROM disco_songs_albums WHERE song_id=".$val_song1['song_id']);
$midi_src = (is_file($phpbb_root_path.'audio/disco/midi_'.$asso['id'].'.mid')) ? $phpbb_root_path.'audio/disco/midi_'.$asso['id'].'.mid' : '';

$template->assign_vars(array(
				'IMG_MASCOTTE' => $mascotte,
				'NOM_RUB' => $lang['EnPlusPlus'],
				"RESPONSABLES" => $lang['Responsables'],
				"L_JEUX" => $lang['Jeux'],	
				"L_GOODIES" => $lang['Goodies'],	
				"L_FONDS" => $lang['Fonds'],	
				"U_JEUX" =>append_sid($phpbb_root_path . 'more/jeux.php'),	
				"U_GOODIES" => append_sid($phpbb_root_path . 'more/goodies.php'),	
				"U_FONDS" => append_sid($phpbb_root_path . 'more/fonds.php'),
				"L_ACCES_GOLDMANQUIZZ" => $lang['go_to_the_goldmanquizz'],
				"U_ACCES_GOLDMANQUIZZ" => append_sid($phpbb_root_path . 'more/start.php'),
				"U_FORM" => append_sid($phpbb_root_path . 'more/quizz_question.php'),
				"ONCLICK" => "this.style.display='none';document.location='quizz_question.php?sid=".$_GET['sid']."'",
				"TITRE" => $lang['titre_quizz'],
				"JOUEUR" => $lang['Joueur'],
				"SCORE" => $lang['Score'],
				"POURCENTAGE" => $lang['Pourcentage'],
				"CLASSEMENT"=>$lang['Classement_actuel'],
				"HORS" => $lang['Hors_Classement'],
				"TEXTE" => $lang['Reglement_quizz'],
				"SCORE_CLASSEMENT" => $lang['Score']."&nbsp;&&nbsp;".$lang['Classement'],
				"WELCOME" =>  '<b>'.$userdata['username']."</b>&nbsp;".$lang['welcome_quizz'],
				"YOUR_SCORE" => $your_score,
				"NEXT_QUESTION" => $lang['question suivante'],
				"U_STOP" => append_sid($phpbb_root_path . 'more/quizz.php'),
				"L_STOP" => $lang['Arretez le quizz'],
				"LYRICS" => $val_song1['lyrics'],
				"RESULT" => $result,
				"GOOD_OR_BAD" => $good_or_bad,
				"JACK" => $img, 
				"L_LISTE" => $lang['liste_cate'],
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/index.php'),
				'MIDI_SRC' => $midi_src,
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

//Score
$tab_score = select_liste("SELECT quizz_users.*, phpbb_users.username FROM quizz_users, phpbb_users WHERE quizz_users.user_id = phpbb_users.user_id AND nb_quest > 49 ORDER BY score/nb_quest DESC,nb_quest DESC");

for ($i=0;$i<count($tab_score);$i++)
{
	$template->assign_block_vars('switch_score',array(
						'JOUEUR' => ($i+1)."&nbsp;".$tab_score[$i]['username'],
						'SCORE' => $tab_score[$i]['score']."/".$tab_score[$i]['nb_quest'],
						'POURCENTAGE' => (round(($tab_score[$i]['score']/($tab_score[$i]['nb_quest']))*10000)/100)."%",
						)
					);
}

$num = $i;
//Hors classement
$tab_hors_score = select_liste("SELECT quizz_users.*, phpbb_users.username FROM quizz_users, phpbb_users WHERE quizz_users.user_id = phpbb_users.user_id AND nb_quest < 50 ORDER BY score/nb_quest DESC,nb_quest DESC");
for ($i=0;$i<count($tab_hors_score);$i++)
{
	$template->assign_block_vars('switch_hors_score',array(
						'JOUEUR' => ($i+1+$num)."&nbsp;".$tab_hors_score[$i]['username'],
						'SCORE' => $tab_hors_score[$i]['score']."/".$tab_hors_score[$i]['nb_quest'],
						'POURCENTAGE' => (round(($tab_hors_score[$i]['score']/($tab_hors_score[$i]['nb_quest']))*10000)/100)."%",
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