K-Means Clustering Algorithm for PHP
==========

A PHP implementation of the k-means clustering algorithm.

This algorithm groups data into clusters, based on the within-cluster sum of squares (intuitively, the squared Euclidean distance in the case of two-dimensional analysis). For example, a dataset containing the locations of many fish could be grouped into discrete schools of fish.

Limitations
-----

* This library currently only supports two-dimensional clustering, but hopefully soon it will allow analysis on an arbitrary number of dimensions.
* The number of clusters to be used in the analysis must be manually configured. 

Usage
-----

Here is some example data:

	$data = array(
		array(
			'name'	=> 'Foo',
			'x'		=> 3,
			'y'		=> 4
		),
		array(
			'name'	=> 'Bar',
			'x'		=> 5,
			'y'		=> 3
		),
		array(
			'name'	=> 'Baz',
			'x'		=> 12,
			'y'		=> 16
		),
	)
	
We want to perform clustering on the <strong>x</strong> and <strong>y</strong> keys, and this data has two (very small) clusters. We configure the class like this:

	$kmeans = new KMeans();
	$kmeans
		->setData($data)
		->setXKey('x')
		->setYKey('y')
		->setClusterCount(2)
		->solve()
		
We retrieve the clusters like this:

	$clusters = $kmeans->getClusters();
	
A cluster has data on its centroid:

	foreach ($clusters as $cluster) {
		$x = $cluster->getX();
		$y = $cluster->getY();
	}
	
And the points belonging to it:

	$data = $cluster->getData();
	
Note that the original data arrays are preserved, so in our example, we could do this:

	// print names of the objects in the first cluster
	$names = array();
	foreach ($clusters[0]->getData() as $ra) {
		$names[] = $ra['name'];
	}
	echo implode(', ', $names);

Which would output <em>Foo, Bar</em>.

License
-------

This library is released under the MIT license. You may use it in personal or commercial projects. For more information, see the <a href="https://github.com/simonrobb/php-kmeans/blob/master/LICENSE">license file</a>.