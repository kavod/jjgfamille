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

if (date('Hi')<2 || date('Hi')==2359)
	die("En cours de maintenance, merci de revenir dans 2-3 minutes<br />Pas de panique, vous n'avez perdu aucun point");


// Sélection de tous les joueurs
$sql1_score="SELECT quizz_users.*, phpbb_users.username FROM quizz_users, phpbb_users WHERE quizz_users.user_id = phpbb_users.user_id AND nb_quest > 24 ORDER BY score/nb_quest DESC,nb_quest DESC";
$result1_score = mysql_query($sql1_score) or die("Exécution de la requête impossible");

//Gestion du score
//requete qui selectionne le nombre de rep jouer et le nb de bonne rep
// On va prendre le score du joueur dans une autre table (histoire de ne pas trop toucher à la table utilisateurs actuelle)
$sql_score = "SELECT * FROM quizz_users WHERE user_id = ".$userdata['user_id'];
$result_score = mysql_query($sql_score) or die("Erreur dans la récupération du score du joueur<br>Requète : ".$sql_score);
if ($val_score = mysql_fetch_array($result_score))
{
	// Si on l'a trouvé : on va lui ajouter un nouvel essai (puisque qu'a priori, il est en train de tenter une question)
	$sql_update = "UPDATE quizz_users SET nb_quest=".($val_score['nb_quest'] + 1)." WHERE user_id = ".$userdata['user_id'];
} else
{
	// Si il n'y a pas d'enregistrement, c'est que l'utilisateur n'a jamais joué, on va lui créer une nouvelle entrée
	$sql_update = "INSERT INTO quizz_users (user_id,score,nb_quest) VALUES (".$userdata['user_id'].",0,1)";
	$val_score['nb_quest'] =0;
	$val_score['score'] = 0;
}
mysql_query($sql_update) or die("Erreur de l'update du score<br>Requète SQL : ".$sql_update);



/************************
 * Choix de la question *
 ************************/
 $verif = 0;
 
 while($verif==0)
{
	$verif=1;
	//requete de recherche d'une chanson de maniere aleatoire
	// Cette chanson doit avoir pour auteur ou compositeur ou interprète l'artiste N°1 (ici Goldman)
	// On va aussi virer les chansons sans textes (ca peut arriver)
	$sql_song="SELECT * FROM disco_songs,disco_artists_job WHERE disco_songs.song_id=disco_artists_job.project AND disco_artists_job.artist_id = 1 ORDER BY RAND() LIMIT 1"; 
	$result_song = mysql_query($sql_song) or die("Exécution de la requête impossible<br>Requète SQL : ".$sql_song);
	$val_song = mysql_fetch_array($result_song);
	
	//Gestion de recherche d'une phrase de maniere aleatoire en fonction de la chanson choisie
	$lyrics1 = $val_song['lyrics']."\n"; // on rajoute des retours à la ligne à la fin pour que les dernières phrases soient retenues.
	
	preg_match_all("|(.+)\n|",$lyrics1,$phrase);
	/* la première expression est le masque de recherche (cf. manuels)
	les | délimitent le masque
	les ( ) délimitent l'expression à enregistrer
	comme c'est la première (et la seule) ce sera la N°1
	le . représente n'importe quel caractères non spécial
	le + signifie qu'il peut y en avoir un nombre > 1
	le \n représente une fin de ligne
	
	Pour résumer, ca s'applique en premier au "Bonjour\n" car c'est un nombre de caractères non spéciaux suppérieur à 1 suivit
	d'une chaine de caractères
	*/
	
	//initialisation des variables test a bon
	$test1 = 1;//test pour si la phrase est une ligne blanche
	$test2 = 1;//test si le titre est contenu dans la phrase
	$test3 = 1;//on elimine les "..." et les phrase de 1 ou 2 mots
	
	$random = rand(0,count($phrase[1])-1);	// on prend un nombre aléatoire entre 0 et le nombre de cellules dans le tableau
	$phrase1=$phrase[1][$random];
	
	//test1
	if(trim($phrase1)=='')
	{
		$test1=0;
	}
	
	//test2 //on met tout en minuscule pour tester car la fonction ne le gere pas
	$mystring=strtolower(trim($phrase1));
	$findme=strtolower( $val_song['title']);
	$pos = strpos($mystring,$findme);
	
	if ($pos ===false) 
	{
		$test2=0;
	}
	
	//test3   
	$mots = split(" ",trim($phrase1));  
	$nombre_mots = count($mots); 
	
	if ($nombre_mots<3) 
	{
		$test3=0;
	}
	
	//concluons
	if ($test1 == 0 or $test2 == 1 or $test3 == 0)
	{
		$verif=0;
	}

}//fin de boucle 

/*******************************************
 * La question est maintenant sélectionnée *
 *******************************************/

// La nouvelle question va être enregistrée dans la table quizz_question.
// Ce qui nous permettra de ne pas faire passer de variable sur la réponse... qui serait source de triche
// De plus, si l'utilisateur est déjà en train de faire une question, on va pouvoir la virer de la table
$sql_del_question = "DELETE FROM quizz_question WHERE sid = '".$userdata['session_id']."' OR heure < '".date('H:i:s',mktime ( date('H') , (date('i') - 2), date('s')))."' OR heure > '".date('H:i:s',mktime ( date('H') , (date('i') + 1), date('s')))."'";
mysql_query($sql_del_question) or die("Erreur durant la mise à jour de vos résultats");

$sql_add_question = "INSERT INTO quizz_question (sid,song_id,heure) VALUES ('".$userdata['session_id']."',".$val_song['song_id'].",'".date('H:i:s')."')";
mysql_query($sql_add_question) or die("Erreur durant le choix de la question");

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
	'body' => 'site/more/quizz_question.tpl',
	'opif' => 'site/rubrikopif/rubrikopif_element.tpl',
	'colonneGauche' => 'site/more/colonne_gauche.tpl')
);

if ($img_mascotte)
$mascotte = $img_mascotte;

$your_score = '<b>'.$lang['Ton']."&nbsp;".$lang['score']."</b>&nbsp;:&nbsp;"."(".$val_score['score']."/".$val_score['nb_quest'].")&nbsp;";


if($val_score['nb_quest']==0)
{
	$your_score=$your_score."0&nbsp;%";
}
else
{
	$pourcent = round(($val_score['score']/$val_score['nb_quest'])*10000)/100;
	$your_score=$your_score.$pourcent."&nbsp;%";
} 
      

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
				"ON_SUBMIT" => "document.getElementById('Submit').style.display='none';document.getElementById('Submit1').style.display='none'",
				"TITRE" => $lang['titre_quizz'],
				"START" => $lang['Commencer_la_partie'],
				"JOUEUR" => $lang['Joueur'],
				"SCORE" => $lang['Score'],
				"POURCENTAGE" => $lang['Pourcentage'],
				"CLASSEMENT"=>$lang['Classement_actuel'],
				"HORS" => $lang['Hors_Classement'],
				"TEXTE" => $lang['Reglement_quizz'],
				"SCORE_CLASSEMENT" => $lang['Score']."&nbsp;&&nbsp;".$lang['Classement'],
				"IMG" => '../images/more/jjgquizz.jpg',
				"WELCOME" =>  '<b>'.$userdata['username']."</b>&nbsp;".$lang['welcome_quizz'],
				"YOUR_SCORE" => $your_score,
				"QUESTION" => '<b>'.$lang['Question'].($val_score['nb_quest']+1).'</b>',
				"PHRASE" => sprintf($lang['phraseopif'],trim($phrase1)),
				"U_FORM" => append_sid('quizz_reponse.php'),
				"NB_SECONDES" => $lang['nb_secondes'],  
				"CHOOSE_SONG" => $lang['choose_song'],
				"TEMPS_ECOULE"	=> $lang['temps_ecoules'],
				"L_SUBMIT" => $lang['Submit'],
				"ONLOAD" => "compte();",
				"L_LISTE" => $lang['liste_cate'],
				'L_RETOUR'=> $lang['retour'],
				'U_RETOUR' => append_sid($phpbb_root_path . 'more/index.php'),
			)
);

//Gestion de la liste déroulante
//requete qui remplie toutes les chansons de la bdd ds l'ordre alphabetique
$tab_liste = select_liste("select distinct disco_songs.* from disco_songs,disco_artists_job WHERE disco_songs.song_id=disco_artists_job.project AND disco_artists_job.artist_id = 1 ORDER BY title");


$title = "";
for ($i=0;$i<count($tab_liste);$i++)
{
	// Problème : certaines reprises ont le même nom que la chanson originale.
	// On ne va donc ajouter que les chansons à titre différent.
	// Il faudra tenir compte de cette contrainte dans les résultats.
	if($title != $tab_liste[$i]['title'])
	{
	$template->assign_block_vars('switch_liste',array(
						"VALUE" => $tab_liste[$i]['song_id'],
						"INTITULE" =>  $tab_liste[$i]['title'],
						)
					);
	}
	$title = $tab_liste[$i]['title'];
}


if ( $userdata['user_level'] == ADMIN || is_responsable($userdata['user_id'],'mascotte'))
{

		
		$template->assign_block_vars('switch_mascotte',array(
						"U_MASCOTTE" => append_sid($phpbb_root_path . 'more/edit_mascotte.php'),
						"L_MASCOTTE" =>  $lang['Change_mascotte'],
						)
					);
}

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