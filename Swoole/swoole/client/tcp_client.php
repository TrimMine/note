<?php
/**
 * client 端 tcp
 * 和telnet一样作用
 */

/**
 * 连接
 */
$client = new swoole_client(SWOOLE_SOCK_TCP);

if (!$client->connect('127.0.0.1',9501)){
    echo '连接失败！';
    exit;
}
//php 内置的cli常量 STDOUT cli输出消息 STDIN cli接收消息
fwrite(STDOUT,'请输入指令');
$message = trim(fgets(STDIN));

//给服务端发送消息
$client->send($message);

//接受server的数据
$result = $client->recv();
echo $result."\n";