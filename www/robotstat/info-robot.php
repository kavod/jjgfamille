<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.css" type="text/css">
<body>

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
// inclusions
// ---------------------------------------------------------------------------
include "admin/config.php";
include "lib.php";
include "lang.".$RS_LANGUE.".php";

$descr = "descr_".$RS_LANGUE;
$sql  = "SELECT *";
$sql .= " FROM ".$RS_TABLE_ROBOTS;
$sql .= " WHERE id=".$robot;
$res  = mysql_query($sql) or erreurServeurMySQL($sql);
if ($enr  = mysql_fetch_array($res))
{
  $html  = "<p class='normal-centre'>".$RS_LANG["RobotDescription"]."</p>";
  $html .= "<h2><center>".$enr["nom"]."</center></h2>";
  $html .= "<p class='normal'>";
  $html .= "<b>".$RS_LANG["RobotName"]."</b>: ".$enr["nom"]."<br />\n";
  $html .= "<b>".$RS_LANG["RobotUserAgent"]."</b>: ".$enr["user_agent"]."<br />\n";
  $html .= "<b>".$RS_LANG["RobotIP1"]."</b>: ".$enr["ip1"]."<br />\n";
  $html .= "<b>".$RS_LANG["RobotIP2"]."</b>: ".$enr["ip2"]."<br />\n";
  $html .= "<b>".$RS_LANG["RobotActive"]."</b> ".(($enr["actif"] == 1) ? $RS_LANG["YES"] : $RS_LANG["NO"])."<br />\n";
  $html .= "<b>".$RS_LANG["RobotMode"]."</b>: ".$RS_LANG[$enr["detection"]]."<br />\n";
  $html .= "<b>".$RS_LANG["RobotDesc"]."</b>: ".$enr[$descr]."<br />\n";
  $html .= "<b>".$RS_LANG["RobotURL"]."</b>: <a href='".$enr["url"]."' target='_blank' title='".$RS_LANG["RobotURLInfo"]."'>".$enr["url"]."</a><br />\n";
}
else
{
  $html = "<P CLASS='normal'><SPAN CLASS='erreur'>&nbsp;".$RS_LANG["UndefinedRobot"]."&nbsp;</SPAN></P>\n";
}
$html .= "<P class='normal-centre'><a href='javascript:window.close()'>".$RS_LANG["CloseWindow"]."</a></p>";
echo $html;

?>

</body>
</html>
