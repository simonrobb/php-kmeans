<?php

include_once ('KMeans.php');

$xKey = 0;
$yKey = 1;

// form test data
$data = array();
$fh = fopen(dirname(__FILE__) . '/TestData.csv', 'r');

while(!feof($fh)) {
	
	$data[] = fgetcsv($fh, 1024);
}
fclose($fh);

// perform analysis
$kmeans = new KMeans();
$kmeans
	->setData ($data)
	->setXKey ($xKey)
	->setYKey ($yKey)
	->setClusterCount (3)
	->solve();
	
$clusters = $kmeans->getClusters();
foreach ($clusters as $cluster) {
	
	echo $cluster->getX() . ',' . $cluster->getY() . "\n\r";
}