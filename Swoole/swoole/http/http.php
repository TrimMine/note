<?php
/**
 * Created by PhpStorm.
 * User: laotianye
 * Date: 18-4-20
 * Time: 下午4:52
 * swoole httpServer
 */

/**
 * 基于server的http服务
 */
 $http = new swoole_http_server('127.0.0.1',8080);

 $http->set([
     'enable_static_handler'=>true,
     'document_root'=>'/home/laotianye/www/wwwroot/swoole/static'
 ]);
/**
 * 配置参数
 */

/**
 * 设置请求 接受请求参数
 */
 $http->on('request',function($request,$response){
     $response->header('Content-type','text/html;charset=utf-8');
     //接受get值
     $client_info = $request->get;
     $response->cookie('swoole_cookie','test',time()+3600);
     $response->end('helle swoole http'.json_encode($client_info));
 });
 $http->start();