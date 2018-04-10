
/*
//---------------------------kali安装后的网络设置教程（必需）-------------------------------

//来自https://www.cnblogs.com/dreamofus/p/5964814.html?utm_source=itdadao&utm_medium=referral


1.写入dhcp服务

1.进行DNS设置


在终端检查ip，输入：ifconfig -a
如果没有ip
首先输入命令： gedit /etc/network/interfaces  #用gedit进行编辑

输入框选部分：
在iface lo inet loopback 后面输入
   auto eth0

   iface eth0 inet dhcp

再输入命令： gedit /etc/resolv.conf #进行DNS编辑
nameserver 192.168.8.2


再输入命令 /etc/init.d/networking restart 进行网络服务重启就完成。

如果还是没有解决的话，还有教程提示可能是宿主机的VMx相关服务未开启，可以去查看并设置一下

最后，是个人的一点感想：

进入大学学习后，几乎都是自学，尤其是计算机相关专业进行实验一定需要环境，而在安装环境问题中会碰见很多问题，
大多数问题不是小白的知识水平能解决的，而大学的学习环境就决定了遇见这类非学术性问题就要自己解决，
百度，Google各种教程，而教程又只是针对个别人，肯定不能完全直接的解决。
说这么多，一是十分感谢那些愿意带我们在上课时间安装环境的老师，这种一般是和我们有相同经验的；
二是，鼓励阅读者，也鼓励自己，万事开头难，慢慢来总会好起来的，大家都在经历这个过程；
三是，一句话，路漫漫其修远兮，吾将上下而求索。

*/