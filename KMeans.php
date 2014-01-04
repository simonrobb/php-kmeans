<?php

require('KMeans/Cluster.php');
require('KMeans/Config.php');

class KMeans
{
	private $_data = array();
	private $_clusters = array();
	private $_config;
	
	public function setData($data)
	{
		$this->_data = $data;
		return $this;
	}
	
	public function setXKey($xKey)
	{
		$this->getConfig ()->setXKey($xKey);
		return $this;
	}
	
	public function setYKey($yKey)
	{
		$this->getConfig ()->setYKey($yKey);
		return $this;
	}
	
	public function setClusterCount($count)
	{
		$this->getConfig ()->setClusterCount($count);
		return $this;
	}
	
	public function getConfig()
	{
		if (!$this->_config) {
			
			$this->_config = new KMeans_Config();
		}
		
		return $this->_config;
	}
	
	public function toArray()
	{
		$result = array ();
		
		foreach ($this->_clusters as $cluster) {
			
			$result[] = $cluster->toArray ();
		}
		
		return $result;
	}
	
	public function solve()
	{
		
		$this->_initialiseClusters();
		while($this->_iterate()) { }
		
		return $this;
	}
	
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
	
	private function _getWcss($point, $cluster)
	{
		
		return pow($point[$this->getConfig()->getXKey()] - $cluster->getX(), 2)
			+ pow($point[$this->getConfig()->getYKey()] - $cluster->getY(), 2);
	}
}