#===============================================安装python==================================================
#下载 wget https://www.python.org/ftp/python/2.7.14/Python-2.7.14.tgz
#解压 tar zxvf ./Python-2.7.14/Python-2.7.14.taz 
#进入解压后的目录 z执行./configure
#make
#make install
#export PATH="$PATH:/usr/local/bin/python" 
#
#
#
#=============================================== python方法规范 ==================================================
# 开头注释声明 执行路径和编码
	#!/usr/bin/python
	# -*- coding: UTF-8 -*-

#=============================================== python 命令行开启一个http服务 ==================================================

python 2 
python -m SimpleHTTPServer 8080
python 3
python -m http.server 8080


