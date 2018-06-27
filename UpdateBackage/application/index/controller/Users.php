<?php
/**
 * Created by PhpStorm.
 * User: kali
 * Date: 2018/4/27
 * Title: 用户中心
 * Time: 9:52
 */

namespace app\index\controller;

use think\Request;
use app\index\model\UsersModel;

class Users extends Base
{
    protected $user_id;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->user_id = session('home.user_id');

    }

    /**
     * 个人中心
     */
    public function index()
    {

        $data = db('user')->where('id', $this->user_id)->field('pool,active_pool,mobile,token_address')->find();
        return json(['status'=>200,'data'=>$data]);
    }
}

