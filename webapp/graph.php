<?php
include('phpgraphlib/phpgraphlib.php');
$a = $_GET['a'];
$graph = new PHPGraphLib(350,280);
$graph->setBackgroundColor("white");
$graph->addData($a);
$graph->setBarColor('255, 255, 204');
$graph->setTitle('Quantity left vs Days');
$graph->setTitleColor('#e24b4e');
$graph->setupYAxis(12, '#e24b4e');
$graph->setupXAxis(20, '#e24b4e');
$graph->setGrid(false);
$graph->setGradient('silver', 'gray');
$graph->setBarOutlineColor('black');
$graph->setTextColor('black');
$graph->setDataPoints(true);
$graph->setDataPointColor('#e24b4e');
$graph->setLine(true);
$graph->setLineColor('#e24b4e');
$graph->createGraph();
?>
