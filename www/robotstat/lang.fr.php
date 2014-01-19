<?php

/***************************************************************************
 *
 *   RobotStats
 *
 * Author:   Olivier Duffez, WebRankInfo ( http://www.webrankinfo.com )
 * Version:  1.0
 * Date:     2003-10-11
 * Homepage: http://www.robotstats.com    
 *
 ***************************************************************************/

$RS_LANG = array();

$RS_LANG["YES"]         = "Oui";
$RS_LANG["NO"]          = "Non";
$RS_LANG["Delete"]      = "Supprimer";
$RS_LANG["Modify"]      = "Modifier";
$RS_LANG["On"]          = "sur";
$RS_LANG["Of"]          = "de";
$RS_LANG["CloseWindow"] = "Fermer la fenêtre";
$RS_LANG["BackHome"]    = "Retour à la page d'accueil";
$RS_LANG["OK"]          = "OK";


// ---------------------------------------------------------------------------
// gestion des erreurs
// ---------------------------------------------------------------------------
$RS_LANG["MySQLErrorSubject"] = "Erreur sur RobotStats";
$RS_LANG["MySQLErrorBody1"]   = "La requête MySQL suivante a généré une erreur :\n";
$RS_LANG["MySQLErrorBody2"]   = "Consultez le forum RobotStats pour avoir de l'aide :\nhttp://www.webrankinfo.com/forums/forum_7.htm ";

// ---------------------------------------------------------------------------
// alertes par mail
// ---------------------------------------------------------------------------
$RS_LANG["FullCrawlBeginSubject"] = "RobotStats : debut du Full Crawl de Google";
$t  = "Bonjour,\n";
$t .= "Ceci est une alerte générée par l'outil RobotStats que vous avez installé\n";
$t .= "sur votre site, vous indiquant que le Full Crawl de Google a sans doute commencé.\n";
$t .= "En effet un robot GoogleBot dont l'adresse IP commence par 216. \n";
$t .= "vient de visiter votre site.\n\n";
$t .= "Pour plus d'informations, consultez le forum de WebRankInfo sur :\n";
$t .= "http://www.webrankinfo.com/forums/\n";
$RS_LANG["FullCrawlBeginBody"]    = $t;


// ---------------------------------------------------------------------------
// calendar
// ---------------------------------------------------------------------------
$RS_LANG["Error"]        = "Erreur";
$RS_LANG["Visites"]      = "Visites ";
$RS_LANG["Pages"]        = "Pages ";
$RS_LANG["VisitsPerDay"] = "Visites / jour ";
$RS_LANG["URL"]          = "URL";
$RS_LANG["Hour"]         = "Heure";
$RS_LANG["NbOfVisits"]   = "Nb visites";
$RS_LANG["NoData"]       = "Aucune donn&eacute;e";
$RS_LANG["Summary"]      = "Bilan";
$RS_LANG["Pages"]        = "Pages";
$RS_LANG["Graph"]        = "Graphique";
$RS_LANG["Monday1"]      = "L";
$RS_LANG["Tuesday1"]     = "M";
$RS_LANG["Wednesday1"]   = "M";
$RS_LANG["Thursday1"]    = "J";
$RS_LANG["Friday1"]      = "V";
$RS_LANG["Saturday1"]    = "S";
$RS_LANG["Sunday1"]      = "D";
$RS_LANG["PreviousDay"]  = "Jour pr&eacute;c&eacute;dent";
$RS_LANG["PreviousMonth"]= "Mois pr&eacute;c&eacute;dent";
$RS_LANG["NextDay"]      = "Jour suivant";
$RS_LANG["NextMonth"]    = "Mois suivant";
$RS_LANG["Week"]         = "Semaine";

// ---------------------------------------------------------------------------
// table
// ---------------------------------------------------------------------------
$RS_LANG["Code"]         = "Code HTTP";

// ---------------------------------------------------------------------------
// graph
// ---------------------------------------------------------------------------
$RS_LANG["GraphAlt"]     = "Graphique des visites de ";
$RS_LANG["Graph1"]       = "Choisissez le graphique à afficher en fonction de la durée :";
$RS_LANG["Month_1"]      = "1 mois";
$RS_LANG["Month_2"]      = "2 mois";
$RS_LANG["Month_3"]      = "3 mois";
$RS_LANG["Month_6"]      = "6 mois";
$RS_LANG["Month_12"]     = "1 an";
$RS_LANG["InactiveCalendar"] = "Calendrier inactif ";

// ---------------------------------------------------------------------------
// robots
// ---------------------------------------------------------------------------
$RS_LANG["RobotsAvailable"]  = "robot(s) configuré(s) :";
$RS_LANG["NoRobotDefined"]   = "Aucun robot configuré !!!";
$RS_LANG["SelectedRobot"]    = "Robot sélectionné";
$RS_LANG["RobotDescription"] = "Description du robot sélectionné";
$RS_LANG["UndefinedRobot"]   = "Robot inconnu !";
$RS_LANG["RobotName"]        = "Nom ";
$RS_LANG["RobotActive"]      = "Activé ?";
$RS_LANG["ActiveRobots"]     = "Robots activés ";
$RS_LANG["NonActiveRobots"]  = "Robots désactivés ";
$RS_LANG["RobotUserAgent"]   = "Nom d'agent ";
$RS_LANG["RobotIP1"]         = "Adresse IP #1 ";
$RS_LANG["RobotIP2"]         = "Adresse IP #2 ";
$RS_LANG["RobotMode"]        = "Mode de détection ";
$RS_LANG["RobotDesc"]        = "Description ";
$RS_LANG[$RS_DETECTION_USER_AGENT] = "Par le nom d'agent";
$RS_LANG[$RS_DETECTION_IP]         = "Par l'adresse IP";
$RS_LANG["RobotURL"]         = "URL ";
$RS_LANG["RobotURLInfo"]     = "Page officielle de ce robot";
$RS_LANG["ListeRobotsVenus"] = "Liste des robots venus dans cette période :";


// ---------------------------------------------------------------------------
// Index page
// ---------------------------------------------------------------------------
$RS_LANG["TitleIndex"]  = "RobotStats : analyse des visites des robots d'indexation";
$RS_LANG["IPAddresses"] = "Adresses IP ";
$RS_LANG["RobotsPie"]   = "Répartition des robots";

// ---------------------------------------------------------------------------
// footer
// ---------------------------------------------------------------------------
$RS_LANG["RS_Line1"] = " : analyse temps r&eacute;el compl&egrave;te des visites de Google et autres robots sur votre site";
$RS_LANG["RS_Line2"] = " Application gratuite et Open Source, d&eacute;velopp&eacute;e par";
$RS_LANG["RS_desc"]  = "le sp&eacute;cialiste du r&eacute;f&eacute;rencement sur Google";
$RS_LANG["Info"]     = "Pour plus d'informations, allez sur";

// ---------------------------------------------------------------------------
// install
// ---------------------------------------------------------------------------
$RS_LANG["Install OK"]     = "L'installation est termin&eacute;e. Pensez &agrave; supprimer le fichier install.php de votre serveur. Cliquez <A HREF='index.php'>ici</A> pour revenir &agrave; l'accueil.";
$RS_LANG["UpdateOK"]       = "La mise à jour est terminée.";

// ---------------------------------------------------------------------------
// admin
// ---------------------------------------------------------------------------
$RS_LANG["Admin"]             = "Administration";
$RS_LANG["TitleAdmin"]        = "Zone d'administration";
$RS_LANG["AdminTestVersion"]  = "Vérifier si une mise à jour existe";
$RS_LANG["AdminNothing"]      = "Vous êtes dans la zone d'administration. Cliquez sur un lien ci-dessus.";
$RS_LANG["AdminReset"]        = "Reset (supression d'enregistrements)";
$RS_LANG["AdminResetExplanations"] = "Cet outil vous permet de supprimer certains enregistrements stockés dans la base de données MySQL (les visites des robots). Vous pouvez supprimer un mois ou toutes les données.";
$RS_LANG["ResetMonths"]       = "Supprimer un mois";
$RS_LANG["ResetAll"]          = "Supprimer tout ";
$RS_LANG["ResetAllLink"]      = "Cliquez ici (attention, aucune confirmation n'est demandée)";
$RS_LANG["ResetNoData"]       = "Aucune donnée !";
$RS_LANG["ResetMonthsOK"]     = "Les données de ce mois ont été supprimées.";
$RS_LANG["ResetMonthsNOK"]    = "Suppression impossible : mauvais paramètres de dates";
$RS_LANG["ResetAllOK"]        = "Toutes les données ont été supprimées.";
$RS_LANG["AdminVersionTitle"] = "Vérifier si vous avez la dernière version de RobotStats";
$RS_LANG["AdminRobots"]       = "Gestion des robots ";
$RS_LANG["ModifyRobot"]       = "Modifier un robot";
$RS_LANG["AddRobot"]          = "Ajouter un nouveau robot";
$RS_LANG["BackToRobotsAdmin"] = "Retour à l'administration des robots.";
$RS_LANG["RobotAdded"]        = "Robot ajouté !";
$RS_LANG["RobotUpdated"]      = "Robot mis à jour !";
$RS_LANG["RobotDeleted"]      = "Robot supprimé !";
$RS_LANG["BadRobotName"]      = "Mauvais nom de robot !";
$RS_LANG["BadUserAgent"]      = "Mauvais nom d'agent !";
$RS_LANG["IPNotSpecified"]    = "Aucune adresse IP du robot n'est définie !";
$RS_LANG["BadDetectionMode"]  = "Mode de détection du robot inconnu !";


// ---------------------------------------------------------------------------
// other
// ---------------------------------------------------------------------------
$TAB_MONTHS = array( '','Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre' );
$TAB_DAYS = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
?>
