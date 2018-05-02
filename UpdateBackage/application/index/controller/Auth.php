<?php
/**
 * Created by PhpStorm.
 * User: kali
 * Date: 2018/4/27
 * Title: 登录 注册
 * Time: 9:53
 */

namespace app\index\controller;

use app\index\controller\Checkauth;
use think\Controller;

class Auth extends Controller
{
    /**
     * 用户登录
     * $param phone 手机号
     * $param password 密码
     */
    public function login()
    {
        $mobile = input('phone');
        $password = input('password');
        //检查参数
        if (!Checkauth::check_param($mobile)){
            return json(['status'=>201,'message'=>'手机号码不正确!']);
        }
        //检查密码
        $res = Checkauth::check_password($mobile,$password);
        if($res['status'] != 200){
            return json($res);
        }
        //存储session
        session('home.user_id',$res['data']['id']);

        return json(['status'=>200,'message'=>'登录成功!']);

    }
    /**
     * 检查用户名和密码
     */
    /**
     * 用户注册 TODO
     * $param phone 手机号
     * $param password 密码
     */
    public function register()
    {
    }


}