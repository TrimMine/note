<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
// 定义应用目录
define('WEB_DOMAIN_ONE', 'http://121.42.251.110:9696');
define('WEB_DOMAIN_TWO', 'http://192.168.10.112:8080');
define('WEB_DOMAIN_THREE', 'http://121.42.251.110:9955');
$arr = [
    WEB_DOMAIN_ONE,
    WEB_DOMAIN_TWO,
    WEB_DOMAIN_THREE,
];
$domain = $_SERVER['HTTP_ORIGIN'];
if ($domain && in_array($domain, $arr)) {
    header('Access-Control-Allow-Origin:' . $domain);
    header('Access-Control-Allow-Credentials:true');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
}

define('APP_PATH', __DIR__ . '/../application/');

// 判断是否安装FastAdmin
if (!is_file(APP_PATH . 'admin/command/Install/install.lock')) {
    header("location:./install.php");
    exit;
}
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
