<?php 
#---------------------------------------------- 安装swoole扩展 ------------------------------------------
/*
使用 PECL 快速安装
PECL 是一个PHP的拓展仓库，可以很方便的安装各种拓展，注意版本是可以指定的，替换短横线后面的版本即可，执行下面的命令行进行安装

pecl install swoole-1.9.23
扩展自动安装完成后，还需要编辑 php.ini 文件，在文件的最后面加入以下内容

[swoole]
extension=swoole.so
源码编译安装
可以从下面列出的任一地址下载到 Swoole 拓展的源码

https://github.com/swoole/swoole-src/releases
http://pecl.php.net/package/swoole
http://git.oschina.net/swoole/swoole
需要进入以上三个网站中的一个选择文件下载 选择格式 (是不是直接下载release)

将下载到的源代码解压到任意目录，并且进入目录，分别执行以下命令进行编译

phpize
./configure 
 如果不行 报错 configure: error: Cannot find php-config. Please use --with-php-config=PATH

 一般出现这个错误说明你执行 ./configure 时  --with-php-config 这个参数配置路径错误导致的。
查找:
find / -name  php-config
填写真实路径
./configure --with-php-config=/www/server/php/72/bin/php-config
333
make
make && install  如果不能执行 sudo make install
编译完成后，同样需要找到 php.ini 文件，在文件的最后面加入以下内容

[swoole]
extension=swoole.so
安装完成后可以通过命令行执行 php -m 确认是否成功加载了 Swoole 拓展，列出的模块列表中含有swoole模块就是加载成功了

 */

##
/*
 
 ln -s   /www/server/php/72/bin/php /usr/bin/php72 制作软链 制定php版本

 */
/*PHP 编译安装
 PHP 查看ini文件的路径 
 编译安装查看配置生效的路径  php -i | grep php.ini  然后将源码包里面的文件拷贝到该目录下
 如果编译的时候选择过etc的路径则放到指定目录下

 ps aft | grep tcp.php 
 查看启动了几个worker进程 显示结构
*/
#---------------------------------------------- easyswoole安装 ------------------------------------------

/* easyswoole安装   
第一种:

命令行快速安装：

bash <(curl https://www.easyswoole.com/installer.sh)

或是：

curl https://www.easyswoole.com/installer.php | php

第二种:
如果没有composer 先按装composer 有的话 引入

composer require easyswoole/easyswoole=2.x-dev
php vendor/easyswoole/easyswoole/bin/easyswoole install   //如果此句报错可执行 php vendor/easyswoole/easyswoole/bin/easyswoole install

php easyswoole start

中途没有报错的话，框架就安装完成了，此时可以访问 http://localhost:9501/ 看到框架的欢迎页面，表示框架已经安装成功


#---------------------------------------------- 启动框架 ------------------------------------------
/*
php server start
php server stop
php server reload
php server update

 */


#----------------------------------------------  websocket ------------------------------------------

//必须与http服务 
//socket端口必须和页面对应
//必须开启该服务

#----------------------------------------------  websocket ------------------------------------------


//使用Chrome浏览器会自动请求一次favicon.ico，所以确保你的网站根目录下面有存在favicon.ico文件，否则会产生一次404请求的错误日志。

#----------------------------------------------  定时任务 timer ------------------------------------------



class Timer
{
    public function tick()
    {
        //循环定时任务
        $timer_id = swoole_timer_tick(3000, function () {
            echo "after 3000ms.\n";

        });
    }

    public function after()
    {
        //一次定时
        $after_timer_id = swoole_timer_after(14000, function () {
            echo "after 14000ms.\n";
        });
    }

    public function clear($timer_id)
    {
        //清除定时任务
        if (swoole_timer_clear($timer_id)) {
            echo "清除成功 \n";
        }
    }
}
#---------------------------  原生sql 利用字段查询付款后超过15天的订单 ------------------------------

 $times = time();
 $gone_time = 15 * 24 * 3600;
 "select id,paytime,status from `xx_orders` where `status`=3 and `type`!=3 and (`paytime`+$gone_time)<=" . $times
