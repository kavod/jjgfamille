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
// Affichage des robots
// ---------------------------------------------------------------------------
function afficherListeRobots()
{
  global $RS_LANG, $RS_LANGUE, $RS_TABLE_ROBOTS;

  $sql  = "SELECT *";
  $sql .= " FROM ".$RS_TABLE_ROBOTS;
  $sql .= " ORDER BY nom ASC";
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  $enr = mysql_fetch_array($res);

  if (!$enr)
  {
    echo "<center><a class='erreur'>&nbsp;".$RS_LANG["NoRobotDefined"]."&nbsp;</a><br /></p>";
  }
  else
  {
    $descr = "descr_".$RS_LANGUE;
    echo "<table border='1' cellspacing='0' cellpadding='10' width='100%'>\n";
    echo "<tr width='100%' bgcolor='#DDF5FF'>\n";
    echo "<td class='moyen-centre'><b>".$RS_LANG["Admin"]."</b></td>";
    echo "<td class='moyen-centre'><b>".$RS_LANG["RobotName"]."</b></td>";
    echo "<td class='moyen-centre'><b>".$RS_LANG["RobotActive"]."</b></td>";
    echo "<td class='moyen-centre'><b>".$RS_LANG["RobotUserAgent"]."</b></td>";
    echo "<td class='moyen-centre'><b>".$RS_LANG["RobotIP1"]."</b></td>";
    echo "<td class='moyen-centre'><b>".$RS_LANG["RobotIP2"]."</b></td>";
    echo "<td class='moyen-centre'><b>".$RS_LANG["RobotMode"]."</b></td>";
    echo "</tr>\n";
    $num_robot = 0;
    do
    {
      $num_robot ++;
      (($num_robot % 2) == 0) ? $bgcolor = "#DDF5FF" : $bgcolor = "#E0F0FF";

      echo "<tr width='100%' bgcolor='".$bgcolor."'>\n";
      echo "<td class='moyen-centre'><a href='robots.php?rub=suppr&robot=".$enr["id"]."'>".$RS_LANG["Delete"]."</a>&nbsp;/&nbsp;";
      echo "<a href='robots.php?rub=modif&robot=".$enr["id"]."'>".$RS_LANG["Modify"]."</a></td>";
      echo "<td class='moyen-centre'><span title=\"".$enr[$descr]."\">".$enr["nom"]."</span></td>";
      echo "<td class='moyen-centre'>".(($enr["actif"] == 1) ? $RS_LANG["YES"] : "<span class='erreur'><b>".$RS_LANG["NO"]."</b></span>")."</td>";
      echo "<td class='moyen-centre'><a href='".$enr["url"]."' target='_blank' title='".$RS_LANG["RobotURLInfo"]."'>&nbsp;".$enr["user_agent"]."</a></td>";
      echo "<td class='fixe-centre'>&nbsp;".$enr["ip1"]."</td>";
      echo "<td class='fixe-centre'>&nbsp;".$enr["ip2"]."</td>";
      echo "<td class='moyen-centre'>".$RS_LANG[$enr["detection"]]."</td>";
    }
    while ($enr = mysql_fetch_array($res));
    echo "</table>\n";

    echo "</td></tr>\n";
    echo "</table>";
  }
}

// ---------------------------------------------------------------------------
// formulaire d'ajout ou de modification d'un robot
// ---------------------------------------------------------------------------
function formulaireRobot($robot)
{
  global $RS_LANG, $RS_LANGUE, $RS_TABLE_ROBOTS, $RS_DETECTION_USER_AGENT, $RS_DETECTION_IP;

  if ($robot != -1)
  {
    $title = $RS_LANG["ModifyRobot"];
    $sql  = "SELECT *";
    $sql .= " FROM ".$RS_TABLE_ROBOTS;
    $sql .= " WHERE id=".$robot;
    $res  = mysql_query($sql) or erreurServeurMySQL($sql);
    $enr  = mysql_fetch_array($res);
    $rub  = "modif";
    $actif = $enr["actif"];
  }
  else
  {
    $title = $RS_LANG["AddRobot"];
    $rub   = "ajouter";
    $actif = 1;
  }

  // begin of form
  echo "<h2>".$title."</h2>";
  echo "<table border='0' cellspacing='0' cellpadding='2'>";
  echo "<form method='post' action='robots.php?rub=ajouter'>\n";
  echo "<input type='hidden' name='robot' value='".$robot."'>\n";

  // robot's name
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotName"]."</b></td>";
  echo "<td><input name='nom' type='text' size='80' class='normal' value=\"".$enr["nom"]."\"></td></tr>";

  // robot is active?
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotActive"]."</b></td>";
  echo "<td><select name='actif' size='1'>";
  echo "<option class='normal' value='1'";
  echo (($actif == 1) ? " selected" : " ");
  echo ">".$RS_LANG["YES"];
  echo "<option class='normal' value='0'";
  echo (($actif == 0) ? " selected" : " ");
  echo ">".$RS_LANG["NO"];
  echo "</select></td></tr>";

  // robot's user agent
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotUserAgent"]."</b></td>";
  echo "<td><input name='user_agent' type='text' size='80' class='normal' value=\"".$enr["user_agent"]."\"></td></tr>";

  // robot's address IP #1
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotIP1"]."</b></td>";
  echo "<td><input name='ip1' type='text' size='80' class='normal' value='".$enr["ip1"]."'></td></tr>";

  // robot's address IP #2
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotIP2"]."</b></td>";
  echo "<td><input name='ip2' type='text' size='80' class='normal' value='".$enr["ip2"]."'></td></tr>";

  // detection mode
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotMode"]."</b></td>";
  echo "<td><select name='detection' size='1'>";
  echo "<option class='normal' value='".$RS_DETECTION_USER_AGENT."'";
  echo (($enr["detection"] == $RS_DETECTION_USER_AGENT) ? " selected" : " ");
  echo ">".$RS_LANG[$RS_DETECTION_USER_AGENT];
  echo "<option class='normal' value='".$RS_DETECTION_IP."'";
  echo (($enr["detection"] == $RS_DETECTION_IP) ? " selected" : " ");
  echo ">".$RS_LANG[$RS_DETECTION_IP];
  echo "</select></td></tr>";

  // robot's description in french
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotDesc"]."</b></td>";
  echo "<td><textarea name='descr_fr' rows='7' cols='80' class='normal'>".$enr["descr_fr"]."</textarea></td></tr>";

  // robot's description in english
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotDesc"]."</b></td>";
  echo "<td><textarea name='descr_en' rows='7' cols='80' class='normal'>".$enr["descr_en"]."</textarea></td></tr>";

  // robot's URL
  echo "<tr><td class='normal'><b>".$RS_LANG["RobotURL"]."</b></td>";
  echo "<td><input name='url' type='text' size='80' class='normal' value='".$enr["url"]."'></td></tr>";

  // submit button
  echo "<tr><td colspan='2' align='center' class='normal'><center><input type='submit' class='bouton' value='".$RS_LANG["OK"]."'></center></td></tr>";

  // end of form
  echo "</form>\n";
  echo "</table>\n";
  echo "</td>";
  echo "</tr>";
  echo "</table>\n";
}

// ---------------------------------------------------------------------------
// Ajoute ou met à jour un robot dans la base
// ---------------------------------------------------------------------------
function updateDataBase($robot, $nom, $actif, $user_agent, $ip1, $ip2, $detection, $descr_fr, $descr_en, $url)
{
  global $RS_LANG, $RS_LANGUE, $RS_TABLE_ROBOTS, $RS_DETECTION_USER_AGENT, $RS_DETECTION_IP;

  // dans tous les cas :
  echo "<p class='normal'><a class='erreur'>&nbsp;";
  $msg = "";

  // test du nom
  if ($nom == '')
  {
    $msg = $RS_LANG["BadRobotName"];
  }

  // test selon le mode de detection
  if ($detection == $RS_DETECTION_USER_AGENT)
  {
    if ($user_agent == '')
    {
      $msg = $RS_LANG["BadUserAgent"];
    }
  }
  else if ($detection == $RS_DETECTION_IP)
  {
    if ( ($ip1 == '') && ($ip2 == '') )
    {
      $msg = $RS_LANG["IPNotSpecified"];
    }
  }
  else
  {
    $msg = $RS_LANG["BadDetectionMode"];
  }

  if ($msg != "")
  {
    echo $msg;
  }
  else
  {
    $liste_champs  = "nom, actif, user_agent, ip1, ip2, detection, descr_fr, descr_en, url";
    $liste_valeurs = "\"$nom\", \"$actif\", \"$user_agent\", \"$ip1\", \"$ip2\", \"$detection\", \"$descr_fr\", \"$descr_en\", \"$url\"";
    if ($robot > 0) // cas d'une modification et non d'un ajout
    {
      $liste_champs  .= ", id";
      $liste_valeurs .= ", '$robot'";
      $sql = "REPLACE INTO ".$RS_TABLE_ROBOTS." ($liste_champs) VALUES ($liste_valeurs)";
      $res = mysql_query($sql) or erreurServeurMySQL($sql);
      echo $RS_LANG["RobotUpdated"];
    }
    else
    {
      $sql = "INSERT INTO ".$RS_TABLE_ROBOTS." ($liste_champs) VALUES ($liste_valeurs)";
      $res = mysql_query($sql) or erreurServeurMySQL($sql);
      echo $RS_LANG["RobotAdded"];
    }
  }

  echo "&nbsp;</a><br /><a href='robots.php?robot=".$robot."'>".$RS_LANG["BackToRobotsAdmin"]."</a></p>";
}

?>