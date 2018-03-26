<?php

/**
 * 系统自动生成
 * @author auto create
 */
class AliyunDevice
{
	
	/** 
	 * 用户绑定账号
	 **/
	public $account;
	
	/** 
	 * 设备的防骚扰持续时间, 已分钟为单位
	 **/
	public $deviceAppAntiHarassEndTime;
	
	/** 
	 * 设备的防骚扰起始时间, 24*60分钟制，如果是-1，表示永久防骚扰
	 **/
	public $deviceAppAntiHarassStartTime;
	
	/** 
	 * 应用的扩展特性
	 **/
	public $deviceAppFeatures;
	
	/** 
	 * 设备的扩展特性
	 **/
	public $deviceFeatures;
	
	/** 
	 * 设备编号
	 **/
	public $deviceId;
	
	/** 
	 * ios的uuid
	 **/
	public $deviceToken;
	
	/** 
	 * 设备类型
	 **/
	public $deviceType;
	
	/** 
	 * IMEI
	 **/
	public $imei;
	
	/** 
	 * 地域
	 **/
	public $location;
	
	/** 
	 * MAC地址
	 **/
	public $mac;
	
	/** 
	 * 手机号码
	 **/
	public $phoneNumber;
	
	/** 
	 * 设备的当前状态
	 **/
	public $status;
	
	/** 
	 * 设备打上的标签名
	 **/
	public $tagList;	
}
?>