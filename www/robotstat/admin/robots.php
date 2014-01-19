<HTML>
<HEAD>
<TITLE>robots admin</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../styles.css" TYPE="TEXT/CSS">
</HEAD>

<BODY>

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

include "config.php";
include "../lib.php";
include "../lang.".$RS_LANGUE.".php";
include "robots.lib.php";

echo "<h2>".$RS_LANG["AdminRobots"]."</h2>";
echo "<p class='normal'><a href='robots.php?rub=nouveau'>".$RS_LANG["AddRobot"]."</a></p>";

// ---------------------------------------------------------------------------
// Nouveau robot
// ---------------------------------------------------------------------------
if ($rub == "nouveau")
{
  formulaireRobot(-1);
}

// ---------------------------------------------------------------------------
// Modifier une URL
// ---------------------------------------------------------------------------
else if ($rub == "modif")
{
  formulaireRobot($robot);
}

// ---------------------------------------------------------------------------
// Supprimer un robot
// ---------------------------------------------------------------------------
else if ($rub == "suppr")
{
  $sql  = "DELETE";
  $sql .= " FROM ".$RS_TABLE_ROBOTS;
  $sql .= " WHERE id=".$robot;
  $res  = mysql_query($sql) or erreurServeurMySQL($sql);
  echo "<p class='normal'><a class='erreur'>&nbsp;".$RS_LANG["RobotDeleted"]."&nbsp;</a><br />";
  echo "<a href='robots.php'>".$RS_LANG["BackToRobotsAdmin"]."</a></p>";
}

// ---------------------------------------------------------------------------
// Ajouter ou mettre à jour un robot dans la base
// ---------------------------------------------------------------------------
else if ($rub == "ajouter")
{
  updateDataBase($robot, $nom, $actif, $user_agent, $ip1, $ip2, $detection, $descr_fr, $descr_en, $url);
}

// ---------------------------------------------------------------------------
// Affichage des robots
// ---------------------------------------------------------------------------
else
{
  afficherListeRobots();
}
?>

</BODY>
</HTML>