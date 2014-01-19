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

if (!defined("rs_config"))
{
	define("rs_config", "rs_config_ok");

  // ---------------------------------------------------------------------------
  // definition des variables pour les options
  // ---------------------------------------------------------------------------
  $RS_URL_REWRITING    = "y";   // mettre "y" en cas d'URL rewriting ("y", "n")
  $RS_GRAPH_SCALE      = "lin"; // echelle lineaire ou logarithmique ("lin", "log")
  $RS_VALEURS_GRAPH    = "y";   // affichage des valeurs sur le graphique ("y", "n")
  $RS_SET_EXEC_TIME    = "y";   // reglage de la duree max du script graph ("y", "n")
  $RS_TEST_FULL_CRAWL  = "y";   // mettre "y" pour detecter le Full Crawl ("y", "n")
  $RS_SEND_ERROR_MYSQL = "y";   // mettre "y" pour l'envoi d'email en cas d'erreur ("y", "n")
  $RS_DISPLAY_PIE_PLOT = "y";   // mettre "y" pour afficher le graphique camembert ("y", "n")

  // ---------------------------------------------------------------------------
  // definition des constantes A PERSONNALISER
  // ---------------------------------------------------------------------------
  $RS_LANGUE        = "fr";  // langue d'affichage de RobotStats ("fr", "en", "de", "es", "nl")
  $RS_ADRESSE_EMAIL = "webmaster@domain.com"; // adresse email du webmaster
  $RS_TABLE_LOG     = "rs_log";    // nom de la table stockant les visites
  $RS_TABLE_ROBOTS  = "rs_robots"; // nom de la table definissant les robots
  $RS_DIR           = "robotstat"; // chemin du répertoire d'installation de RobotStats, à partir de la racine

  // pour la détection du Full Crawl : on génère une alerte donnant le début
  // du Full Crawl dès qu'un robot du Full Crawl se présente et qu'aucune
  // visite de robot de Full Crawl n'a été enregistrée dans les
  // $RS_NB_J_DET_FULL_CRAWL derniers jours
  $RS_NB_J_DET_FULL_CRAWL  = 2;

  // ---------------------------------------------------------------------------
  // definition des constantes A NE PAS MODIFIER
  // ---------------------------------------------------------------------------
  $RS_DETECTION_USER_AGENT = "detection_user_agent";
  $RS_DETECTION_IP         = "detection_ip";
  $RS_FULL_CRAWL_IP        = "216.239.46.";
  $RS_VERSION              = "v1.0";

  // ---------------------------------------------------------------------------
  // connexion a la base de donnees : PENSEZ A REMPLACER LES "..." PAR VOTRE CONFIG !
  // ---------------------------------------------------------------------------
  $RS_CONNECT = @mysql_connect("db_server", "username", "password");
  $RS_DB = @mysql_select_db("db_name");
}
?>
