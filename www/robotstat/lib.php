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

// ---------------------------------------------------------------------------
// retourne une variable globale
// ---------------------------------------------------------------------------
function getVar($var)
{
  global $HTTP_GET_VARS;
  if (!isset($_GET))
  {
    $_GET = $HTTP_GET_VARS;
  }
  if (isset($_GET[$var]))
  {
    return $_GET[$var];
  }
  else
  {
    return "";
  } 
}

// ---------------------------------------------------------------------------
// gestion des erreurs MySQL
// ---------------------------------------------------------------------------
function erreurServeurMySQL($sql)
{
  global $RS_LANG;
  die ("<span class='erreur'>&nbsp;".$RS_LANG["Error"].":&nbsp;</span><span class='fixe-gauche'>".$sql.' '.mysql_error()."</span>");
}

// ------------------------------------------------------------------------
// retourne le champ
// ------------------------------------------------------------------------
function donneChamp( $table, $champ_affiche, $champ_cible, $valeur )
{
  $sql  = "SELECT ".$champ_affiche;
  $sql .= " FROM ".$table;
  $sql .= " WHERE ".$champ_cible."='".$valeur."'";
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  $enr  = mysql_fetch_object($res);
  return $enr->$champ_affiche;
}

// ---------------------------------------------------------------------------
// renvoie le nombre d'enregistrements d'une table
// ---------------------------------------------------------------------------
function nbEnr($table)
{
  $sql  = "SELECT id";
  $sql .= " FROM ".$table;
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  return mysql_num_rows($res);
}

// ---------------------------------------------------------------------------
// affichage du début du tableau principal
// ---------------------------------------------------------------------------
function afficherDebutTableau($rub, $lien)
{
  global $RS_LANG;

  $table_width = 700;
  $left_width  = 200;

  echo "<table width=\"$table_width\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\" align=\"center\">";
  echo "<tr>";
  echo "<td width=\"$left_width\">&nbsp;</td>";

  $tab_rub = array(
    "bilan" => $RS_LANG["Summary"],
    "pages" => $RS_LANG["Pages"],
    "graph" => $RS_LANG["Graph"]);

  $width = intval(($table_width - $left_width) / count($tab_rub));
  foreach ($tab_rub as $rubrique => $nom_rub)
  {
    $onglet = ($rubrique == $rub) ? "actif" : "inactif";
    echo "<td align=\"center\" class=\"onglet-".$onglet."\" width=\"".$width."\">";
    echo "<a href=\"index.php?rub=".$rubrique.$lien."\">".$nom_rub."</a></td>";
  }
  echo "</tr>";
  echo "<tr>";
  echo "<td width=\"$left_width\" valign=\"top\" align=\"center\">";
}

// ---------------------------------------------------------------------------
// affichage de la liste des robots avec celui qui est sélectionné
// ---------------------------------------------------------------------------
function afficherRobots($robot)
{
  global $RS_LANG, $RS_TABLE_ROBOTS;

  $nbRobots = nbEnr($RS_TABLE_ROBOTS);
  if ($nbRobots == 0)
  {
    echo "<p class=\"normal\">".$RS_LANG["NoRobotDefined"]."<p/>";
  }
  else
  {
    $ordre = getVar("ordre");
    $sens  = getVar("sens");
    $d     = getVar("d");
    $m     = getVar("m");
    $s     = getVar("s");
    $rub   = getVar("rub");
    $lien  = "&amp;d=".$d."&amp;s=".$s."&amp;m=".$m."&amp;ordre=".$ordre."&amp;sens=".$sens;

    // robots activés
    $sql  = "SELECT id, nom";
    $sql .= " FROM ".$RS_TABLE_ROBOTS;
    $sql .= " WHERE actif=1";
    $sql .= " ORDER BY nom ASC";
    $res  = mysql_query($sql) or erreurServeurMySQL($sql);
    $html  = "<p class=\"normal\">".$RS_LANG["ActiveRobots"].":";
    $html .= "<ul>";
    while ($enr = mysql_fetch_array($res))
    {
      $html .= "<li class=\"normal\"><a href=\"index.php?rub=".$rub."&amp;robot=".$enr["id"].$lien."\">";
      if ($enr["id"] == $robot)
      {
        $html .= "<img src=\"img/d.gif\" alt=\"".$RS_LANG["SelectedRobot"]."\" width=\"13\" height=\"13\" border=\"0\" />&nbsp;<b><u>".$enr["nom"]."</u></b>";
      }
      else
      {
        $html .= $enr["nom"];
      }
      $html .= '</a>&nbsp;<a href="#" class="petit" onClick="window.open(\'info-robot.php?robot='.$enr["id"].'\',\'\',\'width=400,height=500,resize=1,toolbar=0\');">[info]</a></li>';
    }
    $html .= "</ul></p>";

    // robots désactivés
    $sql  = "SELECT id, nom";
    $sql .= " FROM ".$RS_TABLE_ROBOTS;
    $sql .= " WHERE actif=0";
    $sql .= " ORDER BY nom ASC";
    $res  = mysql_query($sql) or erreurServeurMySQL($sql);
    $html .= "<p class=\"normal\">".$RS_LANG["NonActiveRobots"].":";
    $html .= "<ul>";
    while ($enr = mysql_fetch_array($res))
    {
      $html .= "<li class=\"normal\"><a href=\"index.php?rub=".$rub."&amp;robot=".$enr["id"].$lien."\">";
      if ($enr["id"] == $robot)
      {
        $html .= "<img src=\"img/d.gif\" alt=\"".$RS_LANG["SelectedRobot"]."\" width=\"13\" height=\"13\" border=\"0\" />&nbsp;<b><u>".$enr["nom"]."</u></b>";
      }
      else
      {
        $html .= $enr["nom"];
      }
      $html .= '</a>&nbsp;<a href="#" onClick="window.open(\'info-robot.php?robot='.$enr["id"].'\',\'\',\'width=400,height=500,resize=1,toolbar=0\');">[info]</a></li>';
    }
    $html .= "</ul></p>";
    echo $html;
  }
}

// ---------------------------------------------------------------------------
// renvoie le nombre de visites de Googlebot entre 2 dates
// ---------------------------------------------------------------------------
function nbVisites($robot)
{
  global $RS_TABLE_LOG;

  $d = getVar("d");
  $m = getVar("m");
  $s = getVar("s");
  if ($d == "")
  {
    $today = getdate(); 
    $a = $today['year'];
  }
  else
  {
    $a = substr($d, 0, 4);
  }

  // choix des dates pour la requete...
  if ($s != "")
  {
    // cas d'une semaine
    $sql_date = "(WEEK(date,1) = ".$s.") AND (YEAR(date) = ".$a.")";
  }
  else if ($m != "")
  {
    // cas d'un mois
    $sql_date = "(MONTH(date) = ".$m.") AND (YEAR(date) = ".$a.")";
  }
  else
  {
    // cas d'un jour
    if ($d == "")
    {
      $today = getdate(); 
      $year  = $today['year']; 
      $month = $today['mon']; 
      $day   = $today['mday']; 
      $d = sprintf("$year%02d%02d", $month, $day);;
    }
    else
    {
      $month  = substr($d, 4, 2);
      $day    = substr($d, 6, 2);
      $year   = substr($d, 0, 4);
    }
    $sql_date = "TO_DAYS(date) = TO_DAYS('".$year."-".$month."-".$day."')";
  }

  $sql  = "SELECT id";
  $sql .= " FROM ".$RS_TABLE_LOG;
  $sql .= " WHERE ".$sql_date;
  $sql .= "   AND robot=".$robot;
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  return mysql_num_rows($res);
}

// --------------------------------------------------------------------------- 
// liste des robots activés ayant visité le site dans la période considérée 
// --------------------------------------------------------------------------- 
function listeVisitesRobots() 
{ 
  global $RS_TABLE_ROBOTS, $RS_TABLE_LOG, $RS_LANG, $RS_DISPLAY_PIE_PLOT; 

  $ordre = getVar("ordre"); 
  $sens  = getVar("sens"); 
  $d     = getVar("d"); 
  $m     = getVar("m"); 
  $s     = getVar("s"); 
  $rub   = getVar("rub"); 
  $lien  = "index.php?rub=".$rub."&d=".$d."&s=".$s."&m=".$m."&ordre=".$ordre."&sens=".$sens; 

  $tab_noms_robots    = array(); 
  $tab_visites_robots = array(); 

  if ($d == "") 
  { 
    $today = getdate(); 
    $a = $today['year']; 
  } 
  else 
  { 
    $a = substr($d, 0, 4); 
  } 

  // choix des dates pour la requete... 
  if ($s != "") 
  { 
    // cas d'une semaine 
    $sql_date = "(WEEK(date,1) = ".$s.") AND (YEAR(date) = ".$a.")"; 
  } 
  else if ($m != "") 
  { 
    // cas d'un mois 
    $sql_date = "(MONTH(date) = ".$m.") AND (YEAR(date) = ".$a.")"; 
  } 
  else 
  { 
    // cas d'un jour 
    if ($d == "") 
    { 
      $today = getdate(); 
      $year  = $today['year']; 
      $month = $today['mon']; 
      $day   = $today['mday']; 
      $d = sprintf("$year%02d%02d", $month, $day);; 
    } 
    else 
    { 
      $month  = substr($d, 4, 2); 
      $day    = substr($d, 6, 2); 
      $year   = substr($d, 0, 4); 
    } 
    $sql_date = "TO_DAYS(date) = TO_DAYS('".$year."-".$month."-".$day."')"; 
  } 
  
  $sql  = "SELECT ".$RS_TABLE_ROBOTS.".id, ".$RS_TABLE_ROBOTS.".nom, COUNT( * ) AS 'nb_visites'"; 
  $sql .= " FROM ".$RS_TABLE_LOG; 
  $sql .= " LEFT JOIN ".$RS_TABLE_ROBOTS." ON ".$RS_TABLE_ROBOTS.".id = ".$RS_TABLE_LOG.".robot"; 
  $sql .= " WHERE ".$sql_date; 
  $sql .= " GROUP BY ".$RS_TABLE_ROBOTS.".id"; 
  
  $res  = mysql_query($sql) or sendErrorMySQL($sql); 

  // liste des robots 
  $html = "<br /><span class=\"moyen-gauche\">".$RS_LANG["ListeRobotsVenus"]."<br />"; 
  while ($enr = mysql_fetch_array($res)) 
  { 
      $html .= "- <a href=\"".$lien."&robot=".$enr["id"]."\">".$enr["nom"]."</a> [".$enr["nb_visites"]."]<br />"; 
      $tab_noms_robots[]    = $enr["nom"]; 
      $tab_visites_robots[] = $enr["nb_visites"]; 
  } 
  $html .= "</span><br />"; 

  // graphique de répartition des robots 
  if ($RS_DISPLAY_PIE_PLOT == "y") 
  { 
    $liste_data = implode('_', $tab_visites_robots); 
    $liste_noms = urlencode(implode('_', $tab_noms_robots)); 
    $html .= "<img src=\"graph_robots.php?data=$liste_data&noms=$liste_noms\" width=\"500\" height=\"250\" alt=\"".$RS_LANG["RobotsPie"]."\" /><br />"; 
  } 

  return $html; 
}


// ---------------------------------------------------------------------------
// renvoie le nombre de pages différentes vues par Googlebot
// ---------------------------------------------------------------------------
function nbPagesDifferentes($robot)
{
  global $RS_TABLE_LOG;

  $d = getVar("d");
  $m = getVar("m");
  $s = getVar("s");
  if ($d == "")
  {
    $today = getdate(); 
    $a = $today['year'];
  }
  else
  {
    $a = substr($d, 0, 4);
  }

  // choix des dates pour la requete...
  if ($s != "")
  {
    // cas d'une semaine
    $sql_date = "(WEEK(date,1) = ".$s.") AND (YEAR(date) = ".$a.")";
  }
  else if ($m != "")
  {
    // cas d'un mois
    $sql_date = "(MONTH(date) = ".$m.") AND (YEAR(date) = ".$a.")";
  }
  else
  {
    // cas d'un jour
    if ($d == "")
    {
      $today = getdate(); 
      $year  = $today['year']; 
      $month = $today['mon']; 
      $day   = $today['mday']; 
      $d = sprintf("$year%02d%02d", $month, $day);;
    }
    else
    {
      $month  = substr($d, 4 ,2);
      $day    = substr($d, 6, 2);
      $year   = substr($d, 0 ,4);
    }
    $sql_date = "TO_DAYS(date) = TO_DAYS('".$year."-".$month."-".$day."')";
  }

  $sql  = "SELECT id";
  $sql .= " FROM ".$RS_TABLE_LOG;
  $sql .= " WHERE ".$sql_date;
  $sql .= "   AND robot=".$robot;
  $sql .= " GROUP BY url";
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  return mysql_num_rows($res);
}

// ---------------------------------------------------------------------------
// renvoie les différentes adresses IP utilisees par Googlebot
// ---------------------------------------------------------------------------
function adressesIP($robot)
{
  global $RS_TABLE_LOG;

  $d = getVar("d");
  $m = getVar("m");
  $s = getVar("s");
  if ($d == "")
  {
    $today = getdate(); 
    $a = $today['year'];
  }
  else
  {
    $a = substr($d, 0, 4);
  }

  // choix des dates pour la requete...
  if ($s != "")
  {
    // cas d'une semaine
    $sql_date = "(WEEK(date,1) = ".$s.") AND (YEAR(date) = ".$a.")";
  }
  else if ($m != "")
  {
    // cas d'un mois
    $sql_date = "(MONTH(date) = ".$m.") AND (YEAR(date) = ".$a.")";
  }
  else
  {
    // cas d'un jour
    if ($d == "")
    {
      $today = getdate(); 
      $year  = $today['year']; 
      $month = $today['mon']; 
      $day   = $today['mday']; 
      $d = sprintf("$year%02d%02d", $month, $day);;
    }
    else
    {
      $month  = substr($d, 4 ,2);
      $day    = substr($d, 6, 2);
      $year   = substr($d, 0 ,4);
    }
    $sql_date = "TO_DAYS(date) = TO_DAYS('".$year."-".$month."-".$day."')";
  }

  $sql  = "SELECT ip, count(ip) AS 'occurrence'";
  $sql .= " FROM ".$RS_TABLE_LOG;
  $sql .= " WHERE ".$sql_date;
  $sql .= "   AND robot=".$robot;
  $sql .= " GROUP BY ip ASC";
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  $html = "<table width=\"100%\" cellspacing=\"5\" cellpadding=\"5\"><tr><td class=\"normal\">";
  $rec_count = 0;
  while ($enr = mysql_fetch_array($res))
  {
    $ip_occurrence[$rec_count] = $enr["occurrence"];
    $ip_entry[$rec_count++] = $enr["ip"];
  }
  for ($i = 0; $i < $rec_count/2; $i++)
    	$html .= sprintf("&nbsp;[%'_3s]&nbsp;&nbsp;%s<br>", $ip_occurrence[$i], $ip_entry[$i]);
  $html .= "</td><td class=\"normal\">";
  for ($i = (int)ceil($rec_count/2); $i < $rec_count; $i++)
    	$html .= sprintf("&nbsp;[%'_3s]&nbsp;&nbsp;%s<br>", $ip_occurrence[$i], $ip_entry[$i]);
  $html .= "</td/</tr></table>";
  return $html;

}

// ---------------------------------------------------------------------------
// renvoie le nombre de jours sur lequel porte l'analyse
// ---------------------------------------------------------------------------
function nbJours()
{
  global $RS_TABLE_LOG;

  $d = getVar("d");
  $m = getVar("m");
  $s = getVar("s");

  // choix des dates pour la requete...
  if ($s != 0)
  {
    return 7;
  }
  else if ($m != 0)
  {
    $today = getdate();
    if ($m == $today['mon'])
    {
      return $today['mday']; 
    }
    else
    {
      $month     = substr($d, 4 ,2);
      $day       = substr($d, 6, 2);
      $year      = substr($d, 0 ,4);
      $timestamp = mktime(0, 0, 0, $month, $day, $year);
      return date("t", $timestamp);
    }
  }
  else
  {
    return 1;
  }
}

// ---------------------------------------------------------------------------
// affiche un commentaire sur la période analysée
// ---------------------------------------------------------------------------
function afficherPeriodeAnalysee()
{
  global $TAB_MONTHS, $TAB_DAYS, $RS_LANG;

  $d = getVar("d");
  $m = getVar("m");
  $s = getVar("s");

  $html = "<p class=\"normal\"><b><u>";

  if ($s != "")
  {
    // cas d'une semaine
    $html .= $RS_LANG["Week"]." ".$s;
  }
  else if ($m != "")
  {
    // cas d'un mois
    (version_compare(phpversion(), "4.2.0") >= 0)
      ? @settype($m, "int")
      : @settype($m, "integer");
    $html .= $TAB_MONTHS[$m];
  }
  else
  {
    // cas d'un jour
    if ($d == "")
    {
      $today = getdate(); 
      $year  = $today['year']; 
      $month = $today['mon']; 
      $day   = $today['mday']; 
    }
    else
    {
      $month  = substr($d, 4 ,2);
      $day    = substr($d, 6, 2);
      $year   = substr($d, 0 ,4);
      $timestamp = mktime(0, 0, 0, $month, $day, $year);
      $today = getdate($timestamp); 
    }
    (version_compare(phpversion(), "4.2.0") >= 0)
      ? @settype($month, "int")
      : @settype($month, "integer");
    $nom_jour = $TAB_DAYS[$today["wday"]];
    $html .= $nom_jour." ".$day." ".$TAB_MONTHS[$month]." ".$year;
  }

  $html .= "</u></b></p>\n";
  echo $html;
}


// ---------------------------------------------------------------------------
// affichage de la partie bilan
// ---------------------------------------------------------------------------
function afficherBilan($robot)
{
  global $RS_LANG, $RS_TABLE_ROBOTS;

  // nom du robot
  $nom_robot = donneChamp($RS_TABLE_ROBOTS, "nom", "id", $robot);

  $html  = "<table width=\"100%\" align=\"left\" border=\"1\" bordercolor=\"#55AAFF\" cellspacing=\"0\" cellpadding=\"5\">\n";
  $html .= "<tr><td class=\"normal\">";

  // rappel du nom du robot
  $html .= "<span class=\"normal\"><b>".$nom_robot." :</b></span><br />";

  // nombre total de visites
  $nbVisites = nbVisites($robot);
  $html .= $RS_LANG["Visites"].": ".$nbVisites."<br>";

  // nombre de pages différentes
  $nbPagesDifferentes = nbPagesDifferentes($robot);
  $html .= $RS_LANG["Pages"].": ".$nbPagesDifferentes."<br>";

  // nombre de pages vues / jour
  if ($nbVisites > 0)
  {
    $moyenne = sprintf("%.1f", $nbVisites / nbJours());
  }
  else
    $moyenne = "-";
  $html .= $RS_LANG["VisitsPerDay"].": ".$moyenne."<br>";

  // liste des robots activés ayant visité le site dans la période considérée
  $html .= listeVisitesRobots();

  if ($nbVisites > 0)
  {
    // adresses IP
    $html .= $RS_LANG["IPAddresses"]." ".$RS_LANG["Of"]." ".$nom_robot." :<br />";
    $html .= adressesIP($robot);
  }
  
  $html .= "</td></tr></table>";
  echo $html;
}

// ---------------------------------------------------------------------------
// affichage de la partie pages
// ---------------------------------------------------------------------------
function afficherPages()
{
  global $RS_TABLE_LOG, $RS_LANG;

  $ordre = getVar("ordre");
  $sens  = getVar("sens");
  $d     = getVar("d");
  $m     = getVar("m");
  $s     = getVar("s");
  $robot = getVar("robot");
  $lien  = "index.php?rub=pages&amp;robot=".$robot."&amp;d=".$d."&amp;s=".$s."&amp;m=".$m;

  if ($d == "")
  {
    $today = getdate(); 
    $a = $today['year'];
  }
  else
  {
    $a = substr($d, 0, 4);
  }

  // sens par défaut
  if ($sens == "")
    $sens = "ASC";

  // sens inverse
  if ($sens == "ASC")
    $sens2 = "DESC";
  else
    $sens2 = "ASC";

  // sens par defaut de chaque colonne
  $sens_url  = $sens;
  $sens_code = $sens;
  $sens_date = $sens;
  $sens_ip   = $sens;
  $sens_dns  = $sens;
  $sens_occurrence = $sens;

  // gestion du tri
  switch ($ordre)
  {
    case "url":
      $tri = "url ".$sens.", lastdate ASC, occurrence DESC, ip ASC, dns ASC";
      $sens_url = $sens2;
      break;
      
    case "code":
      $tri = "code ".$sens.", url ASC, lastdate ASC, occurrence DESC, ip ASC"; 
      $sens_code = $sens2; 
      break;

    case "date":
      $tri = "lastdate ".$sens.", url ASC, occurrence DESC, ip ASC, dns ASC";
      $sens_date = $sens2;
      break;

    case "occurrence":
      $tri = "occurrence ".$sens.", url ASC, lastdate ASC, ip ASC, dns ASC";
      $sens_occurrence = $sens2;
      break;

    case "ip":
      $tri = "ip ".$sens.", url ASC, lastdate ASC, occurrence DESC, dns ASC";
      $sens_ip = $sens2;
      break;

    case "dns":
      $tri = "dns ".$sens.", url ASC, lastdate ASC, occurrence DESC, ip ASC";
      $sens_dns = $sens2;
      break;

    default:
      $tri = "url ASC, lastdate ASC, occurrence DESC, ip ASC, dns ASC";
    break;
  }

  // choix des dates pour la requete...
  if ($s != "")
  {
    // cas d'une semaine
    $sql_date = "(WEEK(date, 1) = ".$s.") AND (YEAR(date) = ".$a.")";
  }
  else if ($m != "")
  {
    // cas d'un mois
    $sql_date = "(MONTH(date) = ".$m.") AND (YEAR(date) = ".$a.")";
  }
  else
  {
    // cas d'un jour
    if ($d == "")
    {
      $today = getdate(); 
      $year  = $today['year']; 
      $month = $today['mon']; 
      $day   = $today['mday']; 
      $d = sprintf("$year%02d%02d", $month, $day);;
    }
    else
    {
      $month  = substr($d, 4 ,2);
      $day    = substr($d, 6, 2);
      $year   = substr($d, 0 ,4);
    }
    $sql_date = "TO_DAYS(date) = TO_DAYS('".$year."-".$month."-".$day."')";
    $analyse_jour = true;
  }

  // tableau de sortie
  $html  = "<table align=\"center\" border=\"1\" bordercolor=\"#55AAFF\" cellspacing=\"0\" cellpadding=\"1\" width=\"100%\">\n";
  $html .= "<tr><td>";
  $html .= "<p><table border=\"0\" cellspacing=\"2\" cellpadding=\"5\" width=\"100%\">\n";
  $html .= "<tr class=\"ligneB\">";
  $html .= "<td width=\"20\" class=\"normal-centre\"><b>n°</b></td>\n";
  $html .= "<td class=\"normal-gauche\"><b>";
  $html .= "<a href=\"".$lien."&amp;ordre=url&amp;sens=".$sens_url."\">".$RS_LANG["URL"]."</a></b></td>\n";
  $html .= "<td class=\"normal-centre\"><b>";
  $html .= "<a href=\"".$lien."&amp;ordre=code&amp;sens=".$sens_code."\">".$RS_LANG["Code"]."</a></b></td>\n";
  $html .= "<td class=\"normal-gauche\"><b>";
  $html .= "<a href=\"".$lien."&amp;ordre=date&amp;sens=".$sens_date."\">".$RS_LANG["Hour"]."</a></b></td>\n";
  $html .= "<td class=\"normal-centre\"><b>";
  $html .= "<a href=\"".$lien."&amp;ordre=occurrence&amp;sens=".$sens_occurrence."\">".$RS_LANG["NbOfVisits"]."</a></b></td>\n";
  $html .= "<td class=\"normal-centre\"><b>";
  $html .= "<a href=\"".$lien."&amp;ordre=ip&amp;sens=".$sens_ip."\">@ IP</a></b></td>\n";
  $html .= "<td class=\"normal-centre\"><b>";
  $html .= "<a href=\"".$lien."&amp;ordre=dns&amp;sens=".$sens_dns."\">DNS</a></b></td>\n";
  $html .= "</tr>\n";

  $sql  = "SELECT url, max(date) AS 'lastdate', count(id) AS 'occurrence', ip, dns, code";
  $sql .= " FROM ".$RS_TABLE_LOG;
  $sql .= " WHERE ".$sql_date;
  $sql .= "   AND robot=".$robot;
  $sql .= " GROUP BY url";
  $sql .= " ORDER BY ".$tri;
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  if (mysql_num_rows($res) == 0)
  {
    $html = "<p class=\"normal\">".$RS_LANG["NoData"].".</p>";
  }
  else
  {
    $n = 0;
    while ( $enr = mysql_fetch_array($res) )
    {
      (($n % 2) == 0) ? $type_ligne = "A" : $type_ligne = "B";
      $n++;

      // in case of 404 error code, the row is put in a particular color
      if ($enr["code"] == 404) $type_ligne = "404";

      $html .= "<tr class=\"ligne".$type_ligne."\">\n";
      $html .= "<td class=\"moyen-centre\">".$n."</td>\n";
      $html .= "<td class=\"moyen-gauche\">";
      $html .= "<a href=\"".$enr["url"]."\" target=\"_blank\">".$enr["url"]."</a></td>\n";
      $html .= "<td class=\"moyen-centre\">".( $enr["code"] > 0 ? $enr["code"] : "&nbsp;" )."</td>\n";
      $html .= "<td class=\"moyen-centre\">"."<span class=\"jour-centre\">[".substr($enr["lastdate"], 5 ,5)."]</span>"."<br>".substr($enr["lastdate"], 10 ,9)."</td>\n";
      $html .= "<td class=\"moyen-centre\">".$enr["occurrence"]."</td>\n";
      $html .= "<td class=\"fixe-centre\">".$enr["ip"]."</td>\n";
      $html .= "<td class=\"fixe-gauche\">".$enr["dns"]."</td>\n";
      $html .= "</tr>\n";
    }
    $html .= "</table>\n";
    $html .= "</td></tr></table>";
  }
  echo $html;
}

// ---------------------------------------------------------------------------
// affichage du texte de bas de page
// ---------------------------------------------------------------------------
function footer()
{
  global $RS_LANG, $RS_VERSION;
  echo "<p>&nbsp;</p>";
  echo "<p align=\"center\"><I>RobotStats ".$RS_VERSION.$RS_LANG["RS_Line1"]."<br />";
  echo $RS_LANG["RS_Line2"]." <a href=\"http://www.webrankinfo.com/\" target=\"_blank\">WebrankInfo, ".$RS_LANG["RS_desc"]."</a><br>";
  echo $RS_LANG["Info"]." <a href=\"http://www.robotstats.com/\" target=\"_blank\" title=\"RobotStats.com\">www.robotstats.com</a></I></p>";
}


// ---------------------------------------------------------------------------
// affichage de la page "BILAN"
// ---------------------------------------------------------------------------
function bilan()
{
  global $RS_LANG;

  $rub   = "bilan";
  $ordre = getVar("ordre");
  $sens  = getVar("sens");
  $d     = getVar("d");
  $m     = getVar("m");
  $s     = getVar("s");
  $robot = getVar("robot");
  if (intval($robot) == 0)
    $robot = 1;
  $lien = "&amp;robot=".$robot."&amp;d=".$d."&amp;s=".$s."&amp;m=".$m."&amp;ordre=".$ordre."&amp;sens=".$sens;

  // tableau
  afficherDebutTableau($rub, $lien);

  // calendrier
  afficherCalendrier($robot);

  // robots
  afficherRobots($robot);
  echo "</td>";
  echo "<td colspan=\"3\" valign=\"top\" align=\"left\">";
  
  afficherPeriodeAnalysee();

  // contenu
  afficherBilan($robot);

  echo "</td>";
  echo "</tr>";
  echo "</table>";
}

// ---------------------------------------------------------------------------
// affichage de la page "PAGES"
// ---------------------------------------------------------------------------
function pages()
{
  global $RS_LANG;

  $rub   = "pages";
  $ordre = getVar("ordre");
  $sens  = getVar("sens");
  $d     = getVar("d");
  $m     = getVar("m");
  $s     = getVar("s");
  $robot = getVar("robot");
  if (intval($robot) == 0)
    $robot = 1;
  $lien  = "&amp;robot=".$robot."&amp;d=".$d."&amp;s=".$s."&amp;m=".$m."&amp;ordre=".$ordre."&amp;sens=".$sens;

  // tableau
  afficherDebutTableau($rub, $lien);

  // calendrier
  afficherCalendrier($robot);

  // robots
  afficherRobots($robot);

  echo "</td>";
  echo "<td colspan=\"3\" valign=\"top\" align=\"center\">";
  
  afficherPeriodeAnalysee();

  // contenu
  afficherPages($robot);
    
  echo "</td>";
  echo "</tr>";
  echo "</table>";
}

// ---------------------------------------------------------------------------
// affichage de la page "GRAPHIQUE"
// ---------------------------------------------------------------------------
function graph()
{
  global $RS_LANG, $RS_TABLE_ROBOTS;

  $rub   = "graph";
  $ordre = getVar("ordre");
  $sens  = getVar("sens");
  $d     = getVar("d");
  $m     = getVar("m");
  $s     = getVar("s");
  $robot = getVar("robot");
  $nbm   = getVar("nbm");
  if (intval($robot) == 0)
    $robot = 1;
  $lien  = "&amp;robot=".$robot."&amp;d=".$d."&amp;s=".$s."&amp;m=".$m."&amp;ordre=".$ordre."&amp;sens=".$sens;

  // nb of months displayed on the graph
  if ($nbm == 0)
    $nbm = 1;

  // table
  afficherDebutTableau($rub, $lien);

  // calendar
  echo "<p class=\"normal-gauche\"><i>".$RS_LANG["InactiveCalendar"]."</i></p>";

  // robots
  afficherRobots($robot);
  echo "</td>";
  echo "<td colspan=\"3\" valign=\"top\" align=\"center\">";

  // content
  echo "<p class=\"normal\">".$RS_LANG["Graph1"]."<ul>";
  echo "<li class=\"normal\">";
  echo "<a href=\"index.php?rub=graph".$lien."&amp;nbm=1\">".$RS_LANG["Month_1"]."</a></li>";
  echo "<li class=\"normal\">";
  echo "<a href=\"index.php?rub=graph".$lien."&amp;nbm=2\">".$RS_LANG["Month_2"]."</a></li>";
  echo "<li class=\"normal\">";
  echo "<a href=\"index.php?rub=graph".$lien."&amp;nbm=3\">".$RS_LANG["Month_3"]."</a></li>";
  echo "<li class=\"normal\">";
  echo "<a href=\"index.php?rub=graph".$lien."&amp;nbm=6\">".$RS_LANG["Month_6"]."</a></li>";
  echo "<li class=\"normal\">";
  echo "<a href=\"index.php?rub=graph".$lien."&amp;nbm=12\">".$RS_LANG["Month_12"]."</a></li>";
  echo "</ul></p>";

  $m_range = "Month_".$nbm;
  echo "<p class=\"normal\">".$RS_LANG["GraphAlt"].donneChamp($RS_TABLE_ROBOTS, "nom", "id", $robot);
  echo " ".$RS_LANG["On"]." ".$RS_LANG[$m_range].":<br />";
  echo "<img src=\"graph.php?robot=".$robot."&amp;nbm=".$nbm."\" border=\"0\" alt=\"";
  echo $RS_LANG["GraphAlt"].donneChamp($RS_TABLE_ROBOTS, "nom", "id", $robot);
  echo " ".$RS_LANG["On"]." ".$RS_LANG[$m_range]."\" /></p>";

  echo "</td>";
  echo "</tr>";
  echo "</table>";
}

?>
