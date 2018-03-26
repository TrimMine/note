<?php
namespace App\MessageEvent;
use App\Storage\Redis;
use Core\Component\Di;

class Storage {
	protected $redis;
	public function __construct($config = []) {
		$redis       = Di::getInstance()->get('redis');
		$this->redis = $redis->getConnect();
	}
	/**
	 * 设置用户
	 * @datetime 2017-10-08T20:30:16+0800
	 * @author 韩文博
	 * @param    int $user_id
	 */
	public function setUser(int $user_id, array $user_info) {
		$this->redis->set('user:' . $user_id, json_encode($user_info));
		return true;
	}
	/**
	 * 删除用户并删除所有相关客户端
	 * @datetime 2017-10-08T20:10:41+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @return   [type]
	 */
	public function delUser(int $user_id) {
		$this->redis->delete('user:' . $user_id);
		$this->delUserAllClient($user_id);
		return true;
	}
	/**
	 * 删除用户所有的客户端
	 * @http     get
	 * @datetime 2017-10-08T20:41:36+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @return   bool
	 */
	public function delUserAllClient(int $user_id) {
		$user_clients = $this->getUserAllClient($user_id);
		if (!empty($user_clients)) {
			foreach ($user_clients as $client_id) {
				$this->delUserClient($user_id, $client_id);
			}
		}
		return true;
	}
	/**
	 * 获得用户的所有client
	 * @http     get
	 * @datetime 2017-10-08T20:18:59+0800
	 * @param    int $user_id
	 * @author 韩文博
	 * @return   array
	 */
	public function getUserClients(int $user_id) {
		return $this->redis->sMembers('user_client:' . $user_id);
	}
	/**
	 * 添加用户客户端
	 * @datetime 2017-09-25T18:27:16+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @param int $client_id 客户端id
	 * @return   bool
	 */
	public function addUserClient(int $user_id, int $client_id) {
		$this->redis->sAdd('user_client:' . $user_id, $client_id);
		return true;
	}
	/**
	 * 删除用户客户端
	 * @datetime 2017-10-08T19:46:28+0800
	 * @author 韩文博
	 * @param int $user_id
	 * @param int $client_id
	 * @return   bool
	 */
	public function delUserClient(int $user_id, int $client_id) {
		$this->redis->sRem('user_client:' . $user_id, $client_id);
		return true;
	}
	/**
	 * 批量获取用户信息
	 * @param array $user_ids 用户id
	 * @return array
	 */
	function getUsers($user_ids) {
		$keys = array();
		$ret  = array();

		foreach ($user_ids as $user_id) {
			$keys[] = 'user:' . $user_id;
		}

		$info = $this->redis->mget($keys);
		foreach ($info as $user_id) {
			$ret[] = json_decode($user_id, true);
		}

		return $ret;
	}

	/**
	 * 获取单个用户信息
	 * @param $user_id
	 * @return bool|array
	 */
	function getUser(int $user_id) {
		// {info用户信息  client_ids 终端id集合去重的}
		$ret  = $this->redis->get('user:' . $user_id);
		$info = json_decode($ret, true);

		return $info;
	}
	/**
	 * 是否存在某用户
	 * @http     get
	 * @datetime 2017-09-25T18:29:23+0800
	 * @author 韩文博
	 * @param    int $user_id
	 */
	function exists(int $user_id) {
		return $this->redis->exists('user:' . $user_id);
	}

	/**
	 * 重置数据
	 * 用户服务器宕机或者服务器重启 client_id 匹配不上的问题
	 * @http     get
	 * @datetime 2017-10-08T17:37:20+0800
	 * @author 韩文博
	 * @return   [type]
	 */
	function resetData() {
		$all_user = $this->redis->keys('user:*');
		if (!empty($all_user)) {
			foreach ($all_user as $user_id) {
				$this->delUserAllClient($user_id);
			}
		}
		return true;
	}
	/**
	 * 创建用户的会话关系
	 * @datetime 2017-10-09T13:42:54+0800
	 * @author 韩文博
	 * @param    int $user_id
	 * @param    int $relation_id
	 * @param    string $type 如：user,group
	 */
	public function setUserSession(int $user_id, int $relation_id, string $type) {

	}
}