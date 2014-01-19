<?
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


/**
Cette partie du script a été réalisée par Olivier Doucet ak Ez4Me2KU
	http://www.ajeux.com
Puis modifiée par WebRankInfo à partir de la version 1.1
*/

// inclusions liees a RobotStats
include('./admin/config.php');
include($DOCUMENT_ROOT.'/'.$RS_DIR.'/lib.php');
include($DOCUMENT_ROOT.'/'.$RS_DIR.'/lang.'.$RS_LANGUE.'.php');

// inclusions liees a JpGraph
include($DOCUMENT_ROOT.'/'.$RS_DIR.'/jpgraph/jpgraph.php');
include($DOCUMENT_ROOT.'/'.$RS_DIR.'/jpgraph/jpgraph_log.php');
include($DOCUMENT_ROOT.'/'.$RS_DIR.'/jpgraph/jpgraph_bar.php');
include($DOCUMENT_ROOT.'/'.$RS_DIR.'/jpgraph/jpgraph_gradient.php');

// recuperation des variables passees dans l'URL
$robot = $_GET["robot"];
$nbm   = $_GET["nbm"];

// reglage du temps d'execution max (cf. admin/config.php)
if ($SET_EXEC_TIME == 'y')
  ini_set("MAX_EXECUTION_TIME", "5");

DEFINE ("USE_CACHE", false); 

// espacement en jours des etiquettes sur l'axe des abscisses
// en fonction du nb de mois à afficher
switch ($nbm)
{
  case 1:
  $TextTickInterval = 7;
  break;

  case 2:
  $TextTickInterval = 7;
  break;

  case 3:
  $TextTickInterval = 14;
  break;

  case 6:
  $TextTickInterval = 30;
  break;

  case 12:
  $TextTickInterval = 30;
  break;
}

// l'axe X est au format text et l'axe Y au format lin ou log
$Scale = "text".$RS_GRAPH_SCALE;

// gestion des dates en fonction de la RS_LANGUE
switch ($RS_LANGUE)
{
  case "fr":
    $var_locale = "fr_FR@euro";
    break;

  case "en":
    $var_locale = "en_US";
    break;
}
if (version_compare(phpversion(), "4.3.0") >= 0)
{
  setlocale(LC_ALL, $var_locale);
}
else
{
  setlocale("LC_ALL", $var_locale);
}

/**********************************************************************/

$imax    = 30 * $nbm; 

$sql  = "SELECT TO_DAYS(date), date, count(id) AS 'nb'"; 
$sql .= " FROM ".$RS_TABLE_LOG; 
$sql .= " WHERE robot=".$robot; 
$sql .= "   AND TO_DAYS(NOW()) - TO_DAYS(date) <= ".$imax; 
$sql .= " GROUP BY TO_DAYS(date)"; 
$res  = mysql_query($sql) or erreurServeurMySQL($sql); 

$i       = 0; 
$xLabels = array(); 
$ydata   = array(); 
while( $enr = mysql_fetch_array($res) ) 
{ 
  if ( $i > 0 )
  while( $suiv < $enr[0] )
  { 
    $xLabels[$i] = ""; 
    $ydata[$i]   = 0; 
    $suiv++; 
    $i++; 
  } 
  $xLabels[$i] = substr($enr["date"], 0, 10); 
  $ydata[$i]   = abs($enr["nb"]); 
  $suiv = $enr[0] + 1; 
  $i++; 
}

// on comble les trous...
if( $i > 0 ) while( $suiv < $enr[0] )
{ 
  $xLabels[$i] = ""; 
  $ydata[$i]   = 10; 
  $suiv++; 
  $i++; 
}
//$mmm = strftime("%B", mktime(0, 0, 0, $_GET[mois], 1, $_GET[annee]));
//$title = "$mmm $_GET[annee]";

// gestion du graphique
$graph = new Graph(500, 350);	
$graph->SetScale($Scale);
$graph->img->SetMargin(60, 20, 20, 70);
$graph->title->Set($title);
$graph->xaxis->SetTickLabels($xLabels);
$graph->xaxis->SetFont(FF_FONT1);
$graph->xaxis->SetTextTickInterval($TextTickInterval);
$graph->xaxis->SetLabelAngle(90);
$graph->yaxis->SetColor("darkblue");
$graph->yaxis->SetWeight(2);
$graph->SetColor("azure");
$graph->SetShadow();

// diagramme en barres (nb de visites)
$barplot = new BarPlot($ydata);
$barplot->SetWeight(2);
$barplot->SetColor("darkblue");
if ( ($RS_VALEURS_GRAPH == 'y') && ($nbm == 1) )
{
  $barplot->value->SetColor("darkblue");
  $barplot->value->SetFont(FF_FONT1);
  $barplot->value->SetFormat("%d");
  $barplot->value->Show();
}

// Add the plot to the graph
$graph->Add($barplot);

// Display the graph
$graph->Stroke();

?>
