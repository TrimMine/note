<?php

/**
 * tcp服务器
 * 18-4-19
 */
/**
 * 实例化对象 swoole_server tcp服务
 */
$server = new swoole_server('127.0.0.1',9501);
/**
 * 设置参数
 *'reactor_num' => 2, //reactor thread num
 *'worker_num' => 4,    //worker process num
 *'backlog' => 128,   //listen backlog
 *'max_request' => 50,
 *'dispatch_mode' => 1,
 */
$server->set([
    'max_request'=>1000,
    'worker_num'=>8, //可以使用 ps aft | grep tcp.php 查看所有该文件产生的进程
]);
/**
 * 连接参数和连接成功回调
 * $server  对象
 * $client_id  客户端唯一标示
 * $reactor_id 线程id
 */
//监听连接进入事件
$server->on('connect',function($server,$client_id,$reactor_id){
        echo "\nClient is Connect now \n 客户端id -> ".$client_id."\n 线程id ->".$reactor_id;
});

/**
 * 客户端发送消息接受事件回调
 * $server->send 发送给指定客户端消息
 * $server  对象
 * $client_id  客户端唯一标示
 * $reactor_id 线程id
 */
//监听数据接收事件
$server->on('receive',function($server,$client_id,$reactor_id,$data){
    echo "\nClient is receive message \n 客户端id -> ".$client_id."\n 线程id ->".$reactor_id;
    echo "\nthe Client message is : $data";
    //发送消息给客户端 $client_id
    $server->send($client_id, "\nServer send to client message is  : ".$data);
});

/**
 * 客户端断开连接事件回调
 * $server  对象
 * $client_id  客户端唯一标示
 * $reactor_id 线程id
 */
//连接关闭事件
$server->on('close',function($server,$client_id,$reactor_id){
    echo "\nClient is close  \n 客户端id -> ".$client_id."\n 线程id ->".$reactor_id;
});

$server->start();