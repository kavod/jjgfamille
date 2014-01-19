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
<P class='normal'><?php echo $RS_LANG["AdminResetExplanations"]; ?></P>
<P class='normal'><?php echo $RS_LANG["ResetAll"]; ?>: <a href="reset_all.php"><?php echo $RS_LANG["ResetAllLink"]; ?></a></P>
<P class='normal'><?php echo $RS_LANG["ResetMonths"]; ?>
  <blockquote>
  <?php
  // liste des mois a supprimer
  $sql  = "SELECT date";
  $sql .= " FROM ".$RS_TABLE_LOG;
  $sql .= " ORDER BY date ASC";
  $res  = mysql_query( $sql ) or erreurServeurMySQL( $sql );
  if (mysql_num_rows( $res ) == 0)
  {
    // aucune donnee n'est stockee
    $html = $RS_LANG["ResetNoData"];
  }
  else
  {
    // on va lister les mois supprimables
    $enr = mysql_fetch_array($res);
    $date_init    = $enr["date"];
    $an_init      = (int)substr($date_init, 0, 4);
    $mois_init    = (int)substr($date_init, 5, 2);
    $today        = getdate(); 
    $an_courant   = $today['year']; 
    $mois_courant = $today['mon'];
    $html = "";
    for ($an = $an_init; $an <= $an_courant; $an++)
    {
      ($an == $an_init)    ? $mois1 = $mois_init    : $mois1 = 1;
      ($an == $an_courant) ? $mois2 = $mois_courant : $mois2 = 12;
      for ($mois = $mois1; $mois <= $mois2; $mois++)
      {
        $html .= "<a href='reset_mois.php?a=".$an."&m=".$mois."'>".$TAB_MONTHS[$mois]." ".$an."</a><br>\n";
      }
    }
  }
  echo $html;
  ?>
  </blockquote>
</p>
</BODY>
</HTML>
