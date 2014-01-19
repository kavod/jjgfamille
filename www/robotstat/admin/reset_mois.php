<HTML>
<HEAD>
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
include "config.php";
include "../lib.php";
include "../lang.".$RS_LANGUE.".php";
?>

<TITLE>admin</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../styles.css" TYPE="TEXT/CSS">
</HEAD>
<BODY>
<H1><?php echo $RS_LANG["AdminReset"]; ?></H1>

<?php
if ( (!isset($a)) || ($a < 2002) )
{
  // mauvaise annee
  $html = $RS_LANG["ResetMonthsNOK"];
}
else if ( (!isset($m)) || ($m < 0) || ($m > 12) )
{
  // mauvais mois
  $html = $RS_LANG["ResetMonthsNOK"];
}
else
{
  // suppression des données du mois $m de l'année $a
  $sql  = "DELETE FROM ".$RS_TABLE_LOG;
  $sql .= " WHERE (MONTH(date) = ".$m.") AND (YEAR(date) = ".$a.")";
  $res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );
  $html = "<P class='normal'>".$TAB_MONTHS[$m]." ".$a." : ".$RS_LANG["ResetMonthsOK"]."</p>\n";
}

echo $html;
?>

</BODY>
</HTML>
