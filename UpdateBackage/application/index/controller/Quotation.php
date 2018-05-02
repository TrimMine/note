<?php

/**
 * Created by PhpStorm.
 * User: laotianye
 * Date: 2018/4/27
 * Time: 18:30
 * 行情配置
 */

namespace app\index\controller;

class Quotation extends Base
{
    const CONFIG_ARR = [2,3,4,5,6,7];
    public function pick_info()
    {
        $info = db('config')->whereIn('id',self::CONFIG_ARR)->field('name,title,value')->select();
        return json(['status'=>200,'data'=>$info,'message'=>'获取行情成功']);
    }
}