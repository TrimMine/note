<?php
/**
 * 用户逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\MessageEvent;
use App\MessageEvent\Storage;

/**
 * 验证传入的数据格式
 * 返回的格式
 */
class MessageEvent {
	private static $instance;
	protected $server;
	protected $frame;
	protected $message;
	protected $user_id;
	protected $storage;

	function __construct(\swoole_websocket_server $server, \swoole_websocket_frame $frame) {
		$this->server  = $server;
		$this->frame   = $frame;
		$this->message = json_decode($frame->data, true);
		$this->init();
		$this->storage = new Storage();
	}

	static function init() {

	}

	public function empty() {
		$this->push($this->frame->fd, [
			'type' => 'message',
			'data' => ['state' => 'fail'],
			'code' => -1,
			'msg'  => '数据有误',
		]);
	}

	/**
	 * 推送至客户端
	 * @http     get
	 * @datetime 2017-10-14T18:16:38+0800
	 * @author 韩文博
	 * @param in $fd   client_id
	 * @param array $data
	 */
	public function push(int $fd, array $data) {
		return $this->server->push($fd, json_encode($data));
	}
	/**
	 * 客户端握手成功通知
	 * @http     get
	 * @datetime 2017-10-14T18:19:20+0800
	 * @author 韩文博
	 * @return   [type]
	 */
	public function open() {
		return $this->push($this->frame->fd, [
			'type' => 'open',
			'code' => 0,
			'msg'  => '🤝',
		]);
	}
	/**
	 * 客户端断开通知
	 * @http     get
	 * @datetime 2017-10-14T18:20:01+0800
	 * @author 韩文博
	 */
	public function close() {
		return $this->push($this->frame->fd, [
			'type' => 'close',
			'code' => 0,
			'msg'  => '服务器发起：断开服务器',
		]);
	}
	/**
	 * 向所有客户端或者client_id_array指定的客户端发送$send_data数据。如果指定的$client_id_array中的client_id不存在则自动丢弃
	 * @datetime 2017-09-25T18:10:10+0800
	 * @author 韩文博
	 * @param    array $send_data
	 * @param    array $client_id_array
	 * @param    array $exclude_client_id
	 */
	public function sendToAll(array $send_data, array $client_id_array, array $exclude_client_id) {
		// todo 存储
		$client_id_array = !empty($client_id_array) ? $client_id_array : $this->server->connections;
		foreach ($client_id_array as $fd) {
			$info = $this->server->connection_info($fd);
			if ($info['websocket_status'] == 3) {
				$this->push($fd, $send_data);
			}
		}
	}
	/**
	 * 向user_id绑定的所有在线client_id发送数据
	 * @datetime 2017-09-25T18:17:57+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @param    array $send_data
	 * @return   bool
	 */
	public function sendToUser(int $user_id, array $send_data) {
		$client_id_array = $this->getClientIdByUserId($user_id);
		if ($client_id_array) {
			// todo 存储
			$client_id_array = !empty($client_id_array) ? $client_id_array : $this->server->connections;
			foreach ($client_id_array as $fd) {
				$info = $this->server->connection_info($fd);
				if ($info['websocket_status'] == 3) {
					$this->push($fd, $send_data);
				}
			}
		}
		// todo 存储数据
		return true;
	}
	/**
	 * 向客户端client_id发送$send_data数据。如果client_id对应的客户端不存在或者不在线则自动丢弃发送数据
	 * @datetime 2017-09-25T18:10:38+0800
	 * @author 韩文博
	 * @param    int $client_id
	 * @param    array $send_data
	 */
	public function sendToClient(int $client_id, array $send_data) {
		// todo 存储
		return $this->push($client_id, $send_data);
	}
	/**
	 * 断开与client_id对应的客户端的连接
	 * @http     get
	 * @datetime 2017-09-25T18:13:45+0800
	 * @author 韩文博
	 * @param    int $client_id
	 */
	public function closeClient(int $client_id) {
		return $this->server->close($client_id);
	}
	/**
	 * 关闭用户所有的客户端
	 * @datetime 2017-10-08T17:43:03+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @return   bool
	 */
	public function closeUser(int $user_id) {
		$client_ids = $this->getClientIdByUserId($user_id);
		foreach ($client_ids as $client_id) {
			$this->closeClient($client_id);
		}
		// todo 删除存储里的user
		// client删除
		return true;
	}
	/**
	 * 判断客户端是否在线
	 * @datetime 2017-10-15T16:38:18+0800
	 * @author 韩文博
	 * @param    int $client_id
	 * @return   boolean
	 */
	public function isOnline(int $client_id) {
		$info = $this->server->connection_info($client_id);
		if ($info['websocket_status'] == 3) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 判断用户是否在线
	 * @http     get
	 * @datetime 2017-10-08T17:44:08+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @return   boolean
	 */
	public function isUserOnline(int $user_id) {
		$user = $this->storage->getUser($user_id);
		if (!$user || empty($user['client_ids'])) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * 将client_id与user_id绑定，以便通过Im::sendToUserId($user_id)发送数据，通过Im::isUserIdOnline($user_id)用户是否在线。
	 * user_id解释：这里user_id泛指用户id或者设备id，用来唯一确定一个客户端用户或者设备。
	 * @http     get
	 * @datetime 2017-09-25T18:14:47+0800
	 * @author 韩文博
	 * @param    int $client_id
	 * @param    int $user_id
	 */
	public function bindUserId(int $client_id, int $user_id) {
		$this->storage->addUserClient($user_id, $client_id);
		return $this->server->bind($client_id, $user_id);
	}
	/**
	 * 返回一个数组，数组元素为与user_id绑定的所有在线的client_id。如果没有在线的client_id则返回一个空数组。
	 * 此方法可以判断一个user_id是否在线。
	 * @datetime 2017-09-25T18:16:28+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @return   array
	 */
	public function getClientIdByUserId(int $user_id) {
		$client_ids = $this->storage->getUserClients($user_id);
		return $client_ids;
	}
	/**
	 * 根据客户端id获得用户id
	 * @datetime 2017-09-25T18:17:18+0800
	 * @author 韩文博
	 * @param    int $client_id
	 * @return   int false
	 * todo 如何swoole重启了 需要把user client_id 清空，不过这种情况还是要避免的
	 */
	public function getUserIdByClientId(int $client_id) {
		$info = $this->server->connection_info($client_id);
		return isset($info['uid']) ? $info['uid'] : false;
	}

	/***********************************************  群聊部分 ********************************************/
	/**
	 * 将client_id加入某个组，以便通过Im::sendToGroup发送数据
	 * @datetime 2017-09-25T18:18:23+0800
	 * @author 韩文博
	 * @param    int $client_id
	 * @param    mixed $group
	 * @return   [type]
	 */
	public function joinGroup(int $client_id, mixed $group) {

	}
	/**
	 * 将client_id从某个组中删除，不再接收该分组广播(Im::sendToGroup)发送的数据
	 * @datetime 2017-09-25T18:18:53+0800
	 * @author 韩文博
	 * @param    int $client_id
	 * @param    mixed $group
	 * @return   [type]
	 */
	public function leaveGroup(int $client_id, mixed $group) {

	}
	/**
	 * 向某个分组的所有在线client_id发送数据
	 * @datetime 2017-09-25T18:19:38+0800
	 * @author 韩文博
	 * @param    mixed $group
	 * @param    string $message
	 * @param    array|null $exclude_client_id
	 * @param    bool|boolean $raw
	 * @return   [type]
	 */
	public function sendToGroup(mixed $group, string $message, array $exclude_client_id = null, bool $raw = false) {

	}
	/**
	 * 获取某分组当前在线成员数（多少client_id在线）
	 * @datetime 2017-09-25T18:20:05+0800
	 * @author 韩文博
	 * @param    mixed $group
	 * @return   [type]
	 */
	public function getClientCountByGroup(mixed $group) {

	}
	/**
	 * 获取某个分组所有在线client_id信息
	 * @datetime 2017-09-25T18:20:39+0800
	 * @author 韩文博
	 * @param    mixed $group
	 * @return   [type]
	 */
	public function getClientSessionsByGroup(mixed $group) {

	}
	/**
	 * 获取当前在线连接总数
	 * @http     get
	 * @datetime 2017-09-25T18:21:00+0800
	 * @author 韩文博
	 * @return   [type]
	 */
	public function getAllClientCount() {

	}
	/**
	 * 获取当前所有在线client_id信息
	 * @datetime 2017-09-25T18:21:33+0800
	 * @author 韩文博
	 * @return   [type]
	 */
	public function getAllClientSessions() {

	}

}
