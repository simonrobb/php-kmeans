<?php

/**
 * KMeans/Cluster.php
 *
 * A cluster of points returned by analysis
 *
 * Copyright (C) 2014 Simon Robb
 *
 * @package KMeans
 * @author Simon Robb <simon@simonrobb.com.au>
 * @link https://github.com.au/simonrobb/php-kmeans
 */

class KMeans_Cluster
{
	private $_x;
	private $_y;
	private $_data = array();
	private $_config;
	
	public function __construct ($config)
	{
		$this->_config = $config;
	}
	
	/**
	 * Get the x-coordinate of the cluster centroid
	 *
	 * @return float
	 */
	public function getX()
	{
		return $this->_x;
	}
	
	/**
	 * Set the x-coordinate of the cluster centroid
	 *
	 * @param float $x
	 * @return KMeans_Cluster Implements fluent interface
	 */
	public function setX($x)
	{
		$this->_x = $x;
		return $this;
	}
	
	/**
	 * Get the y-coordinate of the cluster centroid
	 *
	 * @return float
	 */
	public function getY()
	{
		return $this->_y;
	}
	
	/**
	 * Set the y-coordinate of the cluster centroid
	 *
	 * @param float $y
	 * @return KMeans_Cluster Implements fluent interface
	 */
	public function setY($y)
	{
		$this->_y = $y;
		return $this;
	}
	
	/**
	 * Get the data points belonging to this cluster
	 *
	 * @return array
	 */
	public function getData()
	{
		return $this->_data;
	}
	
	/**
	 * Set the data points belonging to this cluster
	 *
	 * @param array $data An array of data points
	 * @return KMeans_Cluster Implements fluent interface
	 */
	public function setData($data)
	{
		$this->_data = $data;
		return $this;
	}
	
	/**
	 * Add a data point to the cluster
	 *
	 * @param array $data The data point to add
	 * @return KMeans_Cluster Implements fluent interface
	 */
	public function addData($data)
	{
		$this->_data[] = $data;
		return $this;
	}
	
	/**
	 * Remove a data point from the cluster
	 *
	 * @param array $data The data point to remove
	 * @return KMeans_Cluster Implements fluent interface
	 */
	public function removeData($data)
	{
		if (($key = array_search($data, $this->_data)) !== false) {
			
			unset ($this->_data[$key]);
		}
		
		return $this;
	}
	
	/**
	 * Recalculate the cluster centroid from its data points
	 *
	 * @return KMeans_Cluster Implements fluent interface
	 */
	public function updateCentroid()
	{
		if (!count($this->_data)) {
			
			return;
		}
		
		$xTotal = 0;
		$yTotal = 0;
		
		foreach ($this->_data as $point) {
			$xTotal += $point[$this->_config->getXKey()];
			$yTotal += $point[$this->_config->getYKey()];
		}
		
		$this->_x = $xTotal / count($this->_data);
		$this->_y = $yTotal / count($this->_data);
		
		return $this;
	}
	
	/**
	 * Returns cluster data as an array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return array (
			$this->_config->getXKey()	=> $this->_x,
			$this->_config->getYKey()	=> $this->_y,
			'data'						=> $this->_data
		);
	}
}