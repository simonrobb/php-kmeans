<?php

class KMeans_Config
{
	private $_xKey = '';
	private $_yKey = '';
	private $_clusterCount = 0;
	
	public function setXKey($xKey)
	{
		$this->_xKey = $xKey;
		return $this;
	}
	
	public function getXKey()
	{
		return $this->_xKey;
	}
	
	public function setYKey($yKey)
	{
		$this->_yKey = $yKey;
		return $this;
	}
	
	public function getYKey()
	{
		return $this->_yKey;
	}
	
	public function setClusterCount($count)
	{
		$this->_clusterCount = $count;
		return $this;
	}
	
	public function getClusterCount()
	{
		return $this->_clusterCount;
	}
}