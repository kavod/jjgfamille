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

include("jpgraph/jpgraph.php"); 
include("jpgraph/jpgraph_pie.php"); 
include("jpgraph/jpgraph_pie3d.php"); 
include_once('jpgraph/jpgraph_gradient.php');

// reglage du temps d'execution max (cf. admin/config.php)
if ($SET_EXEC_TIME == 'y')
  ini_set("MAX_EXECUTION_TIME", "5");

DEFINE ("USE_CACHE", false); 


$data   = explode('_', $data);
$labels = explode('_', urldecode($noms));

$graph = new PieGraph(500, 250, "auto");
$graph->SetShadow();

$graph->title->Set($RS_LANG["RobotsPie"]);
$graph->title->SetFont(FF_FONT0);

$p1 = new PiePlot3D($data);
$p1->SetStartAngle(0); 
$p1->SetSize(0.5);
$p1->SetCenter(0.35, 0.5);
$p1->SetLegends($labels);

$graph->Add($p1);
$graph->Stroke();

?>
