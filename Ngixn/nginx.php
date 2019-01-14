<?php
/*
------------------------------nginx 安装选项-----------------------------------
./configure \
--prefix=/usr \
--sbin-path=/usr/sbin/nginx \
--conf-path=/etc/nginx/nginx.conf \
--error-log-path=/var/log/nginx/error.log \
--http-log-path=/var/log/nginx/access.log \
--pid-path=/var/run/nginx/nginx.pid \
--lock-path=/var/lock/nginx.lock \
--user=nginx \
--group=nginx \
--with-http_ssl_module \
--with-http_stub_status_module \
--with-http_gzip_static_module \
--http-client-body-temp-path=/var/tmp/nginx/client/ \
--http-proxy-temp-path=/var/tmp/nginx/proxy/ \
--http-fastcgi-temp-path=/var/tmp/nginx/fcgi/ \
--http-uwsgi-temp-path=/var/tmp/nginx/uwsgi \
--with-pcre=../pcre-7.8
--with-zlib=../zlib-1.2.3

------------------------------nginx 加入开机启动-----------------------------------
第一步:

编写nginx文件，放入/etc/init.d/
脚本内容 同目录下文件nginx内容  /www/server/ 内容为自己的nginx目录

第二步：

执行

chkconfig --add /etc/init.d/nginx
chmod 755 /etc/init.d/nginx
chkconfig --add nginx
如果想随系统启动就执行

/sbin/chkconfig --level 345 nginx on