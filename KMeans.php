<?php

/**
 * KMeans.php
 *
 * Performs clustering analysis on data using the k-means clustering algorithm.
 *
 * Copyright (C) 2014 Simon Robb
 *
 * @package KMeans
 * @author Simon Robb <simon@simonrobb.com.au>
 * @link https://github.com.au/simonrobb/php-kmeans
 */

require('KMeans/Cluster.php');
require('KMeans/Config.php');

class KMeans
{
	private $_data = array();
	private $_clusters = array();
	private $_config;
	
	/**
	 * Set the source data
	 *
	 * @param $data array
	 * @return KMeans Implements fluent interface
	 */
	public function setData($data)
	{
		$this->_data = $data;
		return $this;
	}
	
	/**
	 * Set the key in the source data corresponding to the value that should 
	 * be used as the x-value in analysis
	 *
	 * @param $xKey mixed
	 * @return KMeans Implements fluent interface
	 */
	public function setXKey($xKey)
	{
		$this->getConfig ()->setXKey($xKey);
		return $this;
	}
	
	/**
	 * Set the key in the source data corresponding to the value that should 
	 * be used as the y-value in analysis
	 *
	 * @param $yKey mixed
	 * @return KMeans Implements fluent interface
	 */
	public function setYKey($yKey)
	{
		$this->getConfig ()->setYKey($yKey);
		return $this;
	}
	
	/**
	 * Set the number of clusters to be used in the analysis
	 *
	 * @param $count int
	 * @return KMeans Implements fluent interface
	 */
	public function setClusterCount($count)
	{
		$this->getConfig ()->setClusterCount($count);
		return $this;
	}
	
	/**
	 * Get the clusters returned by the analysis
	 *
	 * @return array
	 */
	public function getClusters()
	{
		return $this->_clusters;
	}
	
	/**
	 * Get the config object for this analysis
	 *
	 * @return KMeans_Config
	 */
	public function getConfig()
	{
		if (!$this->_config) {
			
			$this->_config = new KMeans_Config();
		}
		
		return $this->_config;
	}
	
	/**
	 * Returns analysis results as an array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$result = array ();
		
		foreach ($this->_clusters as $cluster) {
			
			$result[] = $cluster->toArray ();
		}
		
		return $result;
	}
	
	/**
	 * Perform analysis
	 *
	 * @return KMeans Implements fluent interface
	 */
	public function solve()
	{
		
		$this->_initialiseClusters();
		while($this->_iterate()) { }
		
		return $this;
	}
	
	/**
	 * The guts of the algorithm
	 *
	 * @return bool True if another iteration should occur
	 */
	private function _iterate()
	{
		$continue = false;
		
		foreach ($this->_clusters as $c) {
			
			foreach ($c->getData() as $point) {
				
				$leastWcss = 2147483647;
				$nearestCluster = null;
				
				foreach ($this->_clusters as $cluster) {

					$wcss = $this->_getWcss($point, $cluster);

					if ($wcss < $leastWcss) {

						$leastWcss = $wcss;
						$nearestCluster = $cluster;
					}
				}
				
				if ($nearestCluster != $c) {
					
					$c->removeData($point);
					$nearestCluster->addData($point);
					$continue = true;
				}
			}
		}

		foreach ($this->_clusters as $cluster) {
			
			$cluster->updateCentroid();
		}
		
		return $continue;
	}
	
	/**
	 * Initialise clusters to begin analysis
	 *
	 * @return null
	 */
	private function _initialiseClusters()
	{
		$this->_clusters = array();
		
		$maxX = $this->_getMaxX();
		$maxY = $this->_getMaxY();
		
		for ($i=0; $i<$this->getConfig()->getClusterCount(); $i++) {
			
			$cluster = new KMeans_Cluster($this->getConfig());
			$cluster
				->setX(mt_rand(0, $maxX))
				->setY(mt_rand(0, $maxY));
				
			$this->_clusters[] = $cluster;
		}
		
		if ($this->getConfig()->getClusterCount()) {
			
			$this->_clusters[0]->setData($this->_data);
		}
	}
	
	/**
	 * Get the x-bounds of the source data
	 *
	 * @return float
	 */
	private function _getMaxX()
	{
		$max = 0;
		
		foreach ($this->_data as $point) {
			
			if ($point[$this->getConfig()->getXKey()] > $max) {
				
				$max = $point[$this->getConfig()->getXKey()];
			}
		}
		
		return $max;
	}
	
	/**
	 * Get the y-bounds of the source data
	 *
	 * @return float
	 */
	private function _getMaxY()
	{
		$max = 0;
		
		foreach ($this->_data as $point) {
			
			if ($point[$this->getConfig()->getYKey()] > $max) {
				
				$max = $point[$this->getConfig()->getYKey()];
			}
		}
		
		return $max;
	}
	
	/**
	 * Get the within-cluster sum of squares for a data point/cluster centroid
	 *
	 * @param array $point An element from the source data
	 * @param KMeans_Cluster $cluster A cluster to calculate the distance to
	 * @return float
	 */
	private function _getWcss($point, $cluster)
	{
		
		return pow($point[$this->getConfig()->getXKey()] - $cluster->getX(), 2)
			+ pow($point[$this->getConfig()->getYKey()] - $cluster->getY(), 2);
	}
}