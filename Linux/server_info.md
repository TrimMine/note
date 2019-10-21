

1.宝塔域名访问
2.限制ip登录宝塔
3.修改ssh端口  
4.宝塔用户名
5.密码大小写字母特殊符号
6.域名ssl  
7.网站禁ping 防止服务器被知道真实ip,ping攻击
8.平时禁用ssh 
9.设置目录权限 除了入口文件其他的权限都是读和写
10.linu的用户列表
11.上传目录的权限
12.安装完宝塔阿里云后台检查漏洞 升级内核等(以下内容必须执行)
	严重(必须)
		yum update gnutls
		
	高危(必须)
		软件: libnl3 3.2.28-3.el7_3
		命中: libnl3 version less than 0:3.2.28-4.el7
		yum update libnl3
		yum update libnl3-cli
		yum update NetworkManager
		yum update NetworkManager-libnm
		yum update NetworkManager-team
		yum update NetworkManager-tui
		yum update NetworkManager-wifi
	高危(必须)
		软件: kernel 3.10.0-514.26.2.el7
		命中: kernel version less than 0:3.10.0-693.el7
		yum update kernel
		yum update kernel-headers
		yum update kernel-tools
		yum update kernel-tools-libs
		yum update python-perf

13.定时脚本 (比如定时清理 一句话木马,定时检查上传目录文件权限,定时 扫描代码改动)
14.漏洞扫描
15.函数禁用eval system exec phpinfo
16.waf或者iptables防火墙策略
17.socket监听文件是否改变 node
18.网站文件 数据库备份(1小时)
19.chattr -R =i /www/wwwroot/web/ 
   chattr -R -i /www/wwwroot/web/ 
   chattr -R +i /www/wwwroot/web/ 
   chattr -R =a /www/wwwroot/web/Runtime/log
   lschattr -R 
20.服务器攻击测试 charles 菜刀
21.服务器并发测试 ,负载均衡,数据是否读写分离,是否升级,磁盘io读写是否足够