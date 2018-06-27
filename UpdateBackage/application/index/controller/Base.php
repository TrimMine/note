<?php
/**
 * Created by PhpStorm.
 * User: laotianye
 * Date: 2018/4/27
 * Time: 15:13
 * 模拟中间件
 */

namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session('home.user_id') < 1) {
                return json(['status'=>2000,'message'=>'请先登录!'])->send();
        }
    }
}

