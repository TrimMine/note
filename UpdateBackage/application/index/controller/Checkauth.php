<?php
/**
 * Created by PhpStorm.
 * User: laotianye
 * Date: 2018/4/27
 * Time: 14:25
 */

namespace app\index\controller;

use think\controller;

class Checkauth extends controller
{
    /**
     * @param $phone
     * @param $password
     * 检查密码
     */
    public static function check_password($phone, $password)
    {
        //手机号是否存在
        $userinfo = db('user')->where('mobile', $phone)->find();
        if (!$userinfo) {
            return ['status' => 202, 'message' => '账号不存在!'];
        }
        //比对密码
        if (!$result = self::check_salt($password, $userinfo['salt'], $userinfo['password'])) {
            return ['status' => 203, 'message' => '账号或密码错误!'];
        }
        //是否禁用
        if ($userinfo['status'] != 'normal') {
            return ['status' => 204, 'message' => '账号已被锁定,请联系管理员!'];
        }
        return ['status' => 200, 'data' => $userinfo];
    }

    /**
     * @param $password
     * @param $user_salt
     * @param $user_pass
     * @return bool
     * 对比密码
     */
    public static function check_salt($password, $user_salt, $user_pass)
    {
        if (md5(md5($password) . $user_salt) != $user_pass) {
            return false;
        }
        return true;
    }

    /**
     * @param $param
     * @return bool
     * 检查手机号
     */
    public static function check_param($param)
    {
        if (!is_numeric($param) || $param < 0 || !preg_match('/^1[34578]{1}\d{9}$/', $param)) {
            return false;
        }
        return true;
    }

}