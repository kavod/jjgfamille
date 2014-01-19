<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
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
<HEAD>
<TITLE>admin</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../styles.css" TYPE="TEXT/CSS">
</HEAD>
<BODY>
<DIV ALIGN="center">
<A HREF="reset.php" TARGET="main"><?php echo $RS_LANG["AdminReset"]; ?></A><br />

<?php
echo '<a href="http://www.webrankinfo.com/test-version.php?rs=1&v='.$RS_VERSION.'" target="main">';
echo $RS_LANG["AdminVersionTitle"].'</a><br />';
?>

<A HREF="robots.php" TARGET="main"><?php echo $RS_LANG["AdminRobots"]; ?></A>
</DIV>
</BODY>
</HTML>
