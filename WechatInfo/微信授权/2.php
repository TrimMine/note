<?php
include './config.php';
$code = $_GET['code'];
$state = $_GET['state'];
$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code ';
$res = json_decode(file_get_contents($url),true);
$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'&lang=zh_CN';

$userinfo = json_decode(file_get_contents($url),true);
echo "<pre>";
var_dump($userinfo);
echo "</pre>";