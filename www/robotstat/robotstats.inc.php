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

if (!defined("robotstats_inc"))
{
	define("robotstats_inc", "robotstats_inc_ok");
  //-------------------------------------------------------------------------
  // inclusions
  //-------------------------------------------------------------------------
  // fichier de configuration
  include($DOCUMENT_ROOT.'robotstat/admin/config.php');
  // fichier de dictionnaire
  include($DOCUMENT_ROOT.''.$RS_DIR.'/lang.'.$RS_LANGUE.'.php');

  //-------------------------------------------------------------------------
  // fonction d'envoi d'un message par mail pour les erreurs MySQL
  //-------------------------------------------------------------------------
  function sendErrorMySQL($sql)
  {
    global $RS_SEND_ERROR_MYSQL, $RS_ADRESSE_EMAIL, $RS_LANG;

    if ($RS_SEND_ERROR_MYSQL == 'y')
    {
      @mail($RS_ADRESSE_EMAIL, $RS_LANG["MySQLErrorSubject"],
        $RS_LANG["MySQLErrorBody1"].$sql."\n".$RS_LANG["MySQLErrorBody2"],
        "From: $RS_ADRESSE_EMAIL");
    }
  }

  //-------------------------------------------------------------------------
  // debut du script
  //-------------------------------------------------------------------------

  // pour compatibilité avec les anciennes versions de PHP
  if (!isset($_SERVER))
    $_SERVER = $HTTP_SERVER_VARS;

  // par defaut le robot n'est pas détecté
  $detecte = false;

  // pour chaque robot (sauf ceux qui sont désactivés)
  $sql  = "SELECT *";
  $sql .= " FROM ".$RS_TABLE_ROBOTS;
  $sql .= " WHERE actif=1";
  $res  = mysql_query($sql) or sendErrorMySQL($sql);
  // tant qu'aucun robot n'a été détecté, et qu'il y en a à tester
  while ( !($detecte) && ($enr = @mysql_fetch_array($res)) )
  {
    // selon le mode de détection du robot :
    if ($enr["detection"] == $RS_DETECTION_USER_AGENT)
    {
      // on détecte le robot en regardant son User Agent
      $detecte = (strpos($_SERVER["HTTP_USER_AGENT"], $enr["user_agent"]) !== false);
    }
    else if ($enr["detection"] == $RS_DETECTION_IP)
    {
      // on détecte le robot par son adresse IP
      $detecte = false;
      if ($enr["ip1"] != "")
      {
        $detecte |= ( strpos($enr["ip1"],$_SERVER["REMOTE_ADDR"]) === 0 );
      }
      if ($enr["ip2"] != "")
      {
        $detecte |= ( strpos($enr["ip2"],$_SERVER["REMOTE_ADDR"]) === 0 );
      }
    }

    // si le robot a été détecté, on enregistre sa visite
    if ($detecte)
    {
      // date, adresse IP du robot et nom de domaine
      $robot_ = $enr["id"];
      $date_  = date("Y-m-d H:i:s");
      $ip_    = $_SERVER["REMOTE_ADDR"];
      $dns_   = @gethostbyaddr($ip_);
      $code_  = $_SERVER["REDIRECT_STATUS"]; 

      // récupération de l'URL (située après le nom de domaine)
      if ($RS_URL_REWRITING == 'y')
      {
        $url_ = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
      }
      else
      {
        $url_ = $_SERVER["SCRIPT_NAME"];
        if ($_SERVER["QUERY_STRING"] != "")
          $url_ .= "?".$_SERVER["QUERY_STRING"];
      }

      // test du debut du Full Crawl
      if ($RS_TEST_FULL_CRAWL == 'y')
      {
        // si le robot est le GoogleBot Full Crawl
        if ( strstr($_SERVER["REMOTE_ADDR"], $RS_FULL_CRAWL_IP) !== false )
        {
          // on va chercher s'il est déjà venu dans les $RS_NB_J_DET_FULL_CRAWL
          // derniers jours
          $sql3  = "SELECT id";
          $sql3 .= " FROM ".$RS_TABLE_LOG;
          $sql3 .= " WHERE ip LIKE '".$RS_FULL_CRAWL_IP."%'";
          $sql3 .= " AND (TO_DAYS(NOW()) - TO_DAYS(date)) <= ".$RS_NB_J_DET_FULL_CRAWL;

          $res3  = mysql_query($sql3) or sendErrorMySQL($sql3);

          // si la requete n'a donné aucun résultat, c'est sans doute le
          // début du Full Crawl : on envoie un mail
          if ( (mysql_num_rows($res3) == 0) &&
               !file_exists($_SERVER['DOCUMENT_ROOT'].'/robotstats.txt') ) 
          {
            @mail($RS_ADRESSE_EMAIL,
              $RS_LANG["FullCrawlBeginSubject"],
              $RS_LANG["FullCrawlBeginBody"],
              "From: $RS_ADRESSE_EMAIL");
            $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/robotstats.txt', 'w');
            fclose($fp); 
          }
        }

      } // fin du test sur le Full Crawl
      // requete MySQL d'insertion de la visite
      $sql2  = "INSERT INTO ".$RS_TABLE_LOG;
      $sql2 .= " (robot, url, date, ip, dns, code) VALUES ('$robot_', '$url_', '$date_', '$ip_', '$dns_', '$code_')";
      $res2  = mysql_query($sql2) or sendErrorMySQL($sql2);

    } // fin du cas où un robot a été détecté

  } // fin de la boucle sur les robots

}
?>