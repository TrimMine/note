<?php
/**
 * Created by PhpStorm.
 * User: cabbage
 * Date: 9/19/18
 * Time: 5:25 PM
 */

namespace App\Btc;

/**
 * Class Instance
 * @package app\cion\controller
 * 单态/单例连接
 */
class Instance
{
    private static $connect;

    /**
     * Instance constructor.
     * 连接地址 防止被外部实例化
     */
    private function __construct()
    {
        self::$connect = new Bitcoin('user','password','4.2.1.1','8332');
    }
    //调用
    public static function getInstance()
    {
        //是否已经被实例化
        if (is_null(self::$connect) && !(self::$connect instanceof self)) {
            new self();
        }
        return self::$connect;
    }

    //创建__clone方法防止对象被复制克隆
    public function __clone()
    {
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }
}