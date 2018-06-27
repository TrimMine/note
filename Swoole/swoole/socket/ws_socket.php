<?php
/**
 * Created by PhpStorm.
 * User: laotianye
 * Date: 18-4-21
 * Time: 上午9:50
 * swoole_websocket_server 继承自 swoole_http_server
 */

/**
 * 创建对象实例 0.0.0.0 是所有地址 包括127.0.0.1 内网 外网地址
 */
$ws = new swoole_websocket_server('0.0.0.0', 9501);
/**
 *创建连接 握手成功返回消息
 */
$ws->on('open', function ($ws, $request) {
    echo 'Server: handshake is success! Client_id ->'.$request->fd;
//    $ws->push($request->fd,'this message is from Server on handshake');
});

/**
 * 接收消息
 * 发送消息
 */
$ws->on('message',function($ws,$frame){
    //接收来自客户端的消息
    echo " \n Receive from client_id : $frame->fd \n messgae  :$frame->data,\n opcode : $frame->opcode ,\n fin : $frame->finish";
    //发送给客户端消息
    $ws->push($frame->fd,'this message is from Server on receive message  form client');
});

//客户端关闭连接事件
$ws->on('close',function($ser,$fd){
   echo "\nClient -> $fd is closed \n";
});

//开启服务
$ws->start();