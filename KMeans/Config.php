<?php

/**
 * KMeans/Config.php
 *
 * Class to hold configuration of a k-means analysis
 *
 * Copyright (C) 2014 Simon Robb
 *
 * @package KMeans
 * @author Simon Robb <simon@simonrobb.com.au>
 * @link https://github.com.au/simonrobb/php-kmeans
 */
class KMeans_Config
{
	private $_xKey = '';
	private $_yKey = '';
	private $_clusterCount = 0;
	
	/**
	 * Set the key in the source data corresponding to the value that should 
	 * be used as the x-value in analysis
	 *
	 * @param $xKey mixed
	 * @return KMeans_Config Implements fluent interface
	 */
	public function setXKey($xKey)
	{
		$this->_xKey = $xKey;
		return $this;
	}
	
	/**
	 * Get the key in the source data corresponding to the value that should 
	 * be used as the x-value in analysis
	 *
	 * @return mixed
	 */
	public function getXKey()
	{
		return $this->_xKey;
	}
	
	/**
	 * Set the key in the source data corresponding to the value that should 
	 * be used as the y-value in analysis
	 *
	 * @param $yKey mixed
	 * @return KMeans_Config Implements fluent interface
	 */
	public function setYKey($yKey)
	{
		$this->_yKey = $yKey;
		return $this;
	}
	
	/**
	 * Get the key in the source data corresponding to the value that should 
	 * be used as the y-value in analysis
	 *
	 * @return mixed
	 */
	public function getYKey()
	{
		return $this->_yKey;
	}
	
	/**
	 * Set the number of clusters to be used in the analysis
	 *
	 * @param $count int
	 * @return KMeans_Config Implements fluent interface
	 */
	public function setClusterCount($count)
	{
		$this->_clusterCount = $count;
		return $this;
	}
	
	/**
	 * Get the number of clusters to be used in the analysis
	 *
	 * @return int
	 */
	public function getClusterCount()
	{
		return $this->_clusterCount;
	}
}