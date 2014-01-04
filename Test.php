<?php

include_once ('kmeans.php');

// form test data
$data = [
	array (
		'foo'	=> 12,
		'bar'	=> 8
	),
	array (
		'foo'	=> 25,
		'bar'	=> 16
	),
	array (
		'foo'	=> 5,
		'bar'	=> 24
	),
	array (
		'foo'	=> 8,
		'bar'	=> 23
	)
];

$kmeans = new KMeans();
var_dump ($kmeans
	->setData ($data)
	->setXKey ('foo')
	->setYKey ('bar')
	->setClusterCount (4)
	->solve()
	->toArray ());