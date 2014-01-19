<html>
<head>
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
include "calendrier.php";
?>

<title><?php echo $RS_LANG["TitleIndex"]; ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body bgcolor="#ffffff" text="#000000">
<h1 align="center"><a href="index.php">RobotStats</a></h1>

<?php
// ---------------------------------------------------------------------------
// rubriques possibles :
// 'bilan' : bilan
// 'pages' : liste des pages
// 'graph' : graphique
// ---------------------------------------------------------------------------

$rub = getVar('rub');

// ---------------------------------------------------------------------------
// rubrique BILAN
// ---------------------------------------------------------------------------
if ( ($rub == 'bilan') || ($rub == '') )
{
  bilan();
}

// ---------------------------------------------------------------------------
// rubrique PAGES
// ---------------------------------------------------------------------------
else if ($rub == 'pages')
{
  pages();
}

// ---------------------------------------------------------------------------
// rubrique GRAPH
// ---------------------------------------------------------------------------
else if ($rub == 'graph')
{
  graph();
}

// ---------------------------------------------------------------------------
// pied de page : MERCI DE LE LAISSER, C'EST UN LIEN VERS WebRankInfo :-)
// ---------------------------------------------------------------------------
footer();

?>
</body>
</html>