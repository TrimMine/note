<?php
/**
 * TOP API: rds.aliyuncs.com.DescribeDBInstances.2014-08-15 request
 * 
 * @author auto create
 * @since 1.0, 2015.04.21
 */
class Rds20140815DescribeDBInstancesRequest
{
	/** 
	 * ConnectionMode
	 **/
	private $connectionMode;
	
	/** 
	 * 逗号分隔，最多50
	 **/
	private $dBInstanceId;
	
	/** 
	 * 实例状态，取值参见附录：实例状态表。
不填默认返回所有
	 **/
	private $dBInstanceStatus;
	
	/** 
	 * Primary:主实例
Readonly：只读实例
	 **/
	private $dBInstanceType;
	
	/** 
	 * 数据库类型，取值范围MySQL|SQLServer，
不填，默认返回所有
	 **/
	private $engine;
	
	/** 
	 * VPC：VPC实例
Classic：Classic实例
	 **/
	private $instanceNetworkType;
	
	/** 
	 * 页码，大于0，且不超过Integer的最大值
默认值：1
	 **/
	private $pageNumber;
	
	/** 
	 * 每页记录数，取值：30|50|100
默认值：30
	 **/
	private $pageSize;
	
	/** 
	 * 实例的region
	 **/
	private $regionId;
	
	/** 
	 * 可基于实例ID或者实例备注模糊搜索
	 **/
	private $searchKey;
	
	/**
	 * 仅用于渠道商发起API调用时，指定访问的资源拥有者的ID
	 **/
	private $ownerId;
	
	/**
	 *仅用于渠道商发起API调用时，指定访问的资源拥有者的账号
	 **/
    private  $ownerAccount;
    
    /**
     *API调用者试图通过API调用来访问别人拥有但已经授权给他的资源时，
     *通过使用该参数来声明此次操作涉及到的资源是谁名下的,该参数仅官网用户可用
     **/
    private $resourceOwnerAccount;
    
	private $apiParas = array();
	
	public function setConnectionMode($connectionMode)
	{
		$this->connectionMode = $connectionMode;
		$this->apiParas["ConnectionMode"] = $connectionMode;
	}

	public function getConnectionMode()
	{
		return $this->connectionMode;
	}

	public function setdBInstanceId($dBInstanceId)
	{
		$this->dBInstanceId = $dBInstanceId;
		$this->apiParas["DBInstanceId"] = $dBInstanceId;
	}

	public function getdBInstanceId()
	{
		return $this->dBInstanceId;
	}

	public function setdBInstanceStatus($dBInstanceStatus)
	{
		$this->dBInstanceStatus = $dBInstanceStatus;
		$this->apiParas["DBInstanceStatus"] = $dBInstanceStatus;
	}

	public function getdBInstanceStatus()
	{
		return $this->dBInstanceStatus;
	}

	public function setdBInstanceType($dBInstanceType)
	{
		$this->dBInstanceType = $dBInstanceType;
		$this->apiParas["DBInstanceType"] = $dBInstanceType;
	}

	public function getdBInstanceType()
	{
		return $this->dBInstanceType;
	}

	public function setEngine($engine)
	{
		$this->engine = $engine;
		$this->apiParas["Engine"] = $engine;
	}

	public function getEngine()
	{
		return $this->engine;
	}

	public function setInstanceNetworkType($instanceNetworkType)
	{
		$this->instanceNetworkType = $instanceNetworkType;
		$this->apiParas["InstanceNetworkType"] = $instanceNetworkType;
	}

	public function getInstanceNetworkType()
	{
		return $this->instanceNetworkType;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
		$this->apiParas["PageNumber"] = $pageNumber;
	}

	public function getPageNumber()
	{
		return $this->pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
		$this->apiParas["PageSize"] = $pageSize;
	}

	public function getPageSize()
	{
		return $this->pageSize;
	}

	public function setRegionId($regionId)
	{
		$this->regionId = $regionId;
		$this->apiParas["RegionId"] = $regionId;
	}

	public function getRegionId()
	{
		return $this->regionId;
	}

	public function setSearchKey($searchKey)
	{
		$this->searchKey = $searchKey;
		$this->apiParas["SearchKey"] = $searchKey;
	}

	public function getSearchKey()
	{
		return $this->searchKey;
	}

	
	public function setOwnerId($ownerId)
	{
		$this->ownerId = $ownerId;
		$this->apiParas["OwnerId"] = $ownerId;
	}
	
	public function getOwnerId()
	{
		return $this->ownerId;
	}
	
	public function setOwnerAccount($ownerAccount)
	{
		$this->ownerAccount = $ownerAccount;
		$this->apiParas["OwnerAccount"] = $ownerAccount;
	}
	
	public function getOwnerAccount()
	{
		return $this->ownerAccount;
	}
	
	public function setResourceOwnerAccount($resourceOwnerAccount)
	{
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->apiParas["ResourceOwnerAccount"] = $resourceOwnerAccount;
	}
	
	public function getResourceOwnerAccount()
	{
		return $this->resourceOwnerAccount;
	}

	public function getApiMethodName()
	{
		return "rds.aliyuncs.com.DescribeDBInstances.2014-08-15";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkMaxValue($this->pageNumber,2147483647,"pageNumber");
		RequestCheckUtil::checkMinValue($this->pageNumber,0,"pageNumber");
		RequestCheckUtil::checkMaxValue($this->pageSize,100,"pageSize");
		RequestCheckUtil::checkMinValue($this->pageSize,1,"pageSize");
		RequestCheckUtil::checkNotNull($this->regionId,"regionId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}