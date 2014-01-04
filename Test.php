<?php

include_once ('KMeans.php');

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
	->setXKey (0)
	->setYKey (1)
	->setClusterCount (2)
	->solve();
	
var_dump ($kmeans->toArray ());