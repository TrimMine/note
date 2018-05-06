<?php 	
/*
解决方案

awk sort

$1表示以空格为分割符的第一个匹配项，也就是文件中的ip地址。使用sort对结果排序，uniq -c进行技术，最后sort -n是以“数字”来排序，针对统计后的访问次数来排序

awk '{print $1}' access.log.1 |sort|uniq -c|sort -n




awk for     规范详细

默认变量为0，对每一行的$1作为key，cnt数组++，实现ip的计数。计数结束后END。然后把结果打印出来，最后sort -n以“数字”排序。

awk '{cnt[$1]++;}END{for(i in cnt){printf("%s\t%s\n", cnt[i], i);}}' access.log.1|sort -n


#cat /var/log/*.log 

------------------------- tail ---------------------------

如果日志在更新，
如何实时查看 tail -f /var/log/messages
 还可以使用 watch -d -n 1 cat /var/log/messages 
 -d表示高亮不同的地方，-n表示多少秒刷新一次。 该指令，不会直接返回命令行，而是实时打印日志文件中新增加的内...

------------------------- netstat ---------------------------

远程连接 ECS 实例。
运行以下命令查看 TCP 80 是否被监听。
netstat -an | grep 80
如果返回以下结果，说明 TCP 80 端口的 Web 服务启动。
tcp        0      0 0.0.0.0:80                  0.0.0.0:*                   LISTEN

也可以用 nmap 127.0.0.1 来查看对外开放的端口及服务
yum install -y nmap
-------------------------history---------------------------
这两种方式虽然能看到执行的命令，但是不能看出执行的时间，我们进行以下操作，让history能显示执行的时间  
编辑/etc/bashrc文件，添加以下四行： 

HISTFILESIZE=2000  
HISTSIZE=2000  
HISTTIMEFORMAT='%F %T '  
export HISTTIMEFORMAT 

source /etc/bashrc  重新加载文件
-------------------------find---------------------------

查找文件
find ./ -type f

查找目录
find ./ -type d

查找名字为test的文件或目录
find ./ -name test

查找名字符合正则表达式的文件,注意前面的‘.*’(查找到的文件带有目录)
find ./ -regex .*so.*\.gz

查找目录并列出目录下的文件(为找到的每一个目录单独执行ls命令，没有选项-print时文件列表前一行不会显示目录名称)
find ./ -type d -print -exec ls {} \;

查找目录并列出目录下的文件(为找到的每一个目录单独执行ls命令,执行命令前需要确认)
find ./ -type d -ok ls {} \;

查找目录并列出目录下的文件(将找到的目录添加到ls命令后一次执行，参数过长时会分多次执行)
find ./ -type d -exec ls {} +

查找文件名匹配*.c的文件
find ./ -name \*.c

打印test文件名后，打印test文件的内容
find ./ -name test -print -exec cat {} \;

不打印test文件名，只打印test文件的内容
find ./ -name test -exec cat {} \;

查找文件更新日时在距现在时刻二天以内的文件
find ./ -mtime -2

查找文件更新日时在距现在时刻二天以上的文件
find ./ -mtime +2

查找文件更新日时在距现在时刻一天以上二天以内的文件
find ./ -mtime 2

查找文件更新日时在距现在时刻二分以内的文件
find ./ -mmin -2

查找文件更新日时在距现在时刻二分以上的文件
find ./ -mmin +2

查找文件更新日时在距现在时刻一分以上二分以内的文件
find ./ -mmin 2

查找文件更新时间比文件abc的内容更新时间新的文件
find ./ -newer abc

查找文件访问时间比文件abc的内容更新时间新的文件
find ./ -anewer abc

查找空文件或空目录
find ./ -empty

查找空文件并删除
find ./ -empty -type f -print -delete

查找权限为644的文件或目录(需完全符合)
find ./ -perm 664

查找用户/组权限为读写，其他用户权限为读(其他权限不限)的文件或目录
find ./ -perm -664

查找用户有写权限或者组用户有写权限的文件或目录
find ./ -perm /220
find ./ -perm /u+w,g+w
find ./ -perm /u=w,g=w

查找所有者权限有读权限的目录或文件
find ./ -perm -u=r

查找用户组权限有读权限的目录或文件
find ./ -perm -g=r

查找其它用户权限有读权限的目录或文件
find ./ -perm -o=r

查找所有者为lzj的文件或目录
find ./ -user lzj

查找组名为gname的文件或目录
find ./ -group gname

查找文件的用户ID不存在的文件
find ./ -nouser

查找文件的组ID不存在的文件
find ./ -nogroup

查找有执行权限但没有可读权限的文件
find ./ -executable \! -readable

查找文件size小于10个字节的文件或目录
find ./ -size -10c

查找文件size等于10个字节的文件或目录
find ./ -size 10c

查找文件size大于10个字节的文件或目录
find ./ -size +10c

查找文件size小于10k的文件或目录
find ./ -size -10k

查找文件size小于10M的文件或目录
find ./ -size -10M

查找文件size小于10G的文件或目录
find ./ -size -10G

-------------------------   chattr  --------------------------

chattr命令的用法：chattr [ -RVf ] [ -v version ] [ mode ] files…
最关键的是在[mode]部分，[mode]部分是由+-=和[ASacDdIijsTtu]这些字符组合的，这部分是用来控制文件的
属性。

+ ：在原有参数设定基础上，追加参数。
- ：在原有参数设定基础上，移除参数。
= ：更新为指定参数设定。
A：文件或目录的 atime (access time)不可被修改(modified), 可以有效预防例如手提电脑磁盘I/O错误的发生。
S：硬盘I/O同步选项，功能类似sync。
a：即append，设定该参数后，只能向文件中添加数据，而不能删除，多用于服务器日志文件安全，只有root才能设定这个属性。
c：即compresse，设定文件是否经压缩后再存储。读取时需要经过自动解压操作。
d：即no dump，设定文件不能成为dump程序的备份目标。
i：设定文件不能被删除、改名、设定链接关系，同时不能写入或新增内容。i参数对于文件 系统的安全设置有很大帮助。
j：即journal，设定此参数使得当通过mount参数：data=ordered 或者 data=writeback 挂 载的文件系统，文件在写入时会先被记录(在journal中)。如果filesystem被设定参数为 data=journal，则该参数自动失效。
s：保密性地删除文件或目录，即硬盘空间被全部收回。
u：与s相反，当设定为u时，数据内容其实还存在磁盘中，可以用于undeletion。
各参数选项中常用到的是a和i。a选项强制只可添加不可删除，多用于日志系统的安全设定。而i是更为严格的安全设定，只有superuser (root) 或具有CAP_LINUX_IMMUTABLE处理能力（标识）的进程能够施加该选项。

应用举例：

1、用chattr命令防止系统中某个关键文件被修改：
# chattr +i /etc/resolv.conf

然后用mv /etc/resolv.conf等命令操作于该文件，都是得到Operation not permitted 的结果。vim编辑该文件时会提示W10: Warning: Changing a readonly file错误。要想修改此文件就要把i属性去掉： chattr -i /etc/resolv.conf

# lsattr /etc/resolv.conf
会显示如下属性
----i-------- /etc/resolv.conf

2、让某个文件只能往里面追加数据，但不能删除，适用于各种日志文件：
# chattr +a /var/log/messages


------------------------ nmcli --------------------------
要检查网络连接，使用“ sudo nmcli d ”命令。

如果断开连接，使用“ sudo nmtui ” - >编辑连接，选择您的网络接口并选择“自动连接”选项（按空格键），然后选择确定。

“sudo reboot now”登录后，执行“ping www.google.com”。


-------------------------- 给Linux配ip -------------------------
1、立即临时生效，重启后配置丢失
ifconfig eth0 192.168.0.10 netmask 255.255.255.0
ifconfig eth0 up
2、重启后生效，重启电脑，IP不会丢失
vim /etc/sysconfig/network-scripts/ifcfg-eth0
参考配置文件
DEVICE=eth0
ONBOOT=yes
BOOTPROTO=static
IPADDR=192.168.0.10
NETMASK=255.255.255.0
GATEWAY=192.168.0.1
HWADDR=00:0c:29:dd:a6:00

-------------------------- 网络配置文件  -------------------------

DNS配置文件
/etc/resolv.conf
网络配置
/etc/sysconfig/network-scripts/sifcfg-ens33

输入ifconfig -a 可以查看当前网卡配置的IP地址


如果还不行找到 
/etc/sysconfig/network 配置文件如下图 (如果没有需要添加一个默认网关上去)

	

-------------------------- journalctl查看网络信息  -------------------------

journalctl -xe  或 systemctl status network.service 

在虚拟机的环境中，重启网络，命令为
　　service NetworkManager stop

　　service network restart

　　service NetworkManager start


------------------------ .swp --------------------
编辑文件异常退出 出现.swp文件 
.文件名.swp

------------------------ linux 配置虚拟主机 -------------------

设置dns服务器用于域名解析和上网，但是对于某些特殊的需求我们需要让某个地址解析到特定的地址，可以通过编辑 /etc/hosts文件来实现。类型和windows下的主机头一样

/etc/hosts 修改完就能生效

127.0.0.1  swoole.host

------------------------ linux du -------------------

1.输出当前目录下各个子目录所使用的空间
du -h  --max-depth=1

2.按照空间大小排序
du|sort -nr|more

3.显示几个文件或目录各自占用磁盘空间的大小，还统计它们的总和
du -c log30.tar.gz log31.tar.gz

-–max-depth=<目录层数> 超过指定层数的目录后，予以忽略

-a或-all  显示目录中个别文件的大小。   

-b或-bytes  显示目录或文件大小时，以byte为单位。   

-c或--total  除了显示个别目录或文件的大小外，同时也显示所有目录或文件的总和。 

-k或--kilobytes  以KB(1024bytes)为单位输出。

-m或--megabytes  以MB为单位输出。   

-s或--summarize  仅显示总计，只列出最后加总的值。

-h或--human-readable  以K，M，G为单位，提高信息的可读性。

-x或--one-file-xystem  以一开始处理时的文件系统为准，若遇上其它不同的文件系统目录则略过。 

-L<符号链接>或--dereference<符号链接> 显示选项中所指定符号链接的源文件大小。   

-S或--separate-dirs   显示个别目录的大小时，并不含其子目录的大小。 

-X<文件>或--exclude-from=<文件>  在<文件>指定目录或文件。   

--exclude=<目录或文件>         略过指定的目录或文件。    

-D或--dereference-args   显示指定符号链接的源文件大小。   

-H或--si  与-h参数相同，但是K，M，G是以1000为换算单位。   

-l或--count-links   重复计算硬件链接的文件。


------------------------ linux rsync -------------------

rsync --help | grep delete
    --del                                an alias for --delete-during
    --delete                          delete extraneous files from destination dirs
    --delete-before            receiver deletes before transfer, not during
    --delete-during            receiver deletes during transfer (default)
    --delete-delay              find deletions during, delete after
    --delete-after                receiver deletes after transfer, not during
    --delete-excluded        also delete excluded files from destination dirs
    --ignore-errors            delete even if there are I/O errors
    --max-delete=NUM    don't delete more than NUM files


清空目录或文件，如下： 
1、先建立一个空目录

mkdir /data/blank 
2、用rsync删除目标目录

rsync --delete-before -d -a -H -v --progress --stats /data/blank/ /var/edatacache/
或者
rsync --delete-before -d /data/blank/ /var/edatacache/


这样/var/edatacache目录就被快速的清空了。


选项说明：
–delete-before 接收者在传输之前进行删除操作
–progress          在传输时显示传输过程
-a                      归档模式，表示以递归方式传输文件，并保持所有文件属性
-H                      保持硬连接的文件
-v                      详细输出模式
–stats                给出某些文件的传输状态
-d                      transfer directories without recursing


3、也可以用来删除大文件
假如我们在/root/下有一个几十G甚至上百G的文件data，现在我们要删除它
一、创建一个空文件
    touch /root/empty
二、用rsync清空/root/data文件
    rsync --delete-before -d --progess --stats /root/empty /root/data

------------------------ linux vim 命令 ------------------------

查找字符串等   :/ 名称

------------------------ linux ls  命令 ------------------------

ls  列出文件及目录

-l 参数 以详细格式列表

-d 参数 仅列目录

-ld  是 -l -d 的简写

1. ls -a 列出文件下所有的文件，包括以“.“开头的隐藏文件（Linux下文件隐藏文件是以.开头的，如果存在..代表存在着父目录）。
2. ls -l 列出文件的详细信息，如创建者，创建时间，文件的读写权限列表等等。
3. ls -F 在每一个文件的末尾加上一个字符说明该文件的类型。"@"表示符号链接、"|"表示FIFOS、"/"表示目录、"="表示套接字。
4. ls -s 在每个文件的后面打印出文件的大小。  size(大小)
5. ls -t 按时间进行文件的排序  Time(时间)
6. ls -A 列出除了"."和".."以外的文件。
7. ls -R 将目录下所有的子目录的文件都列出来，相当于我们编程中的“递归”实现
8. ls -L 列出文件的链接名。Link（链接）
9. ls -S 以文件的大小进行排序

只列出文件下的子目录
[root@Gin gin]# ls -F ./|grep /$
scripts/
tools/
列出目前工作目录下所有名称是a 开头的文件，愈新的排愈后面，可以使用如下命令：
[root@Gin scripts]# ll -tr a*

------------------------ linux 目录颜色 ------------------------
最后说一下linux下文件的一些文件颜色的含义（默认，颜色在CRT客户端可以修改）
绿色---->代表可执行文件，
红色---->代表压缩文件
深蓝色---->代表目录
浅蓝色----->代表链接文件
灰色---->代表其它的一些文件

------------------------ linux rwx ------------------------


421 421 421
rwx rwx rwx
读写执

------------------------ linux 查看mysql状态 ------------------------
mysql进程
ps -ef | grep mysql

mysql状态
service mysql status

journalctl -xe 错误信息

查看数据版本信息
 cat /www/server/mysql/version.pl

宝塔数据库日志 在
/www/server/data/用户名.err  文件

要保证 data  和 mysql 所属组都是 mysql
chown -R mysql.mysql /www/server/data/
chown -R mysql.mysql /www/server/mysql/

------------------------ linux chmod ------------------------

chmod 改变文件或目录的权限

chmod 755 abc：赋予abc权限rwxr-xr-x

chmod u=rwx，g=rx，o=rx abc：同上u=用户权限，g=组权限，o=不同组其他用户权限

chmod u-x，g+w abc：给abc去除用户执行的权限，增加组写的权限

chmod a+r abc：给所有用户添加读的权限

------------------------ linux ssh连接时间 ------------------------

Method 1:
修改/etc/ssh/sshd_config配置文件，设置ClientAliveCountMax值大一点，单位是分钟。然后重启ssh服务使生效：service sshd reload 


Method 2:
找到所在用户的.ssh目录,如root用户该目录在：/root/.ssh/
在该目录创建config文件 vi /root/.ssh/config
加入下面一句：ServerAliveInterval 60
保存退出，重新开启root用户的shell，则再ssh远程服务器的时候，不会因为长时间操作断开。应该是加入这句之后，ssh客户端会每隔一段时间自动与ssh服务器通信一次，所以长时间操作不会断开。

------------------------ linux 安装swoole运行phpize错误 ------------------------


如果在安装php扩展的时候出现如题的错误：只需到php的安装目录下如：cd /usr/local/php/php-7.0.4/ext/openssl 执行命令：  cp ./config0.m4 ./config.m4 即可解决


转换证书 cer pem
openssl x509 -inform DER -in allinpay-pds.cer  -out allinpay-pds.pem

------------------------ linux 安装swoole config------------------------

configure: error: Cannot find php-config. Please use --with-php-config=PATH
一般出现这个错误说明你执行 ./configure 时  --with-php-config 这个参数配置路径错误导致的。
查找:
find / -name  php-config
修改为：
./configure --with-php-config=/usr/local/php/bin/php-config
就可以解决问题
上面的 /usr/local/php/ 是你的 php 安装路径
------------------------ linux 开放端口------------------------
Centos7以前 可以用iptables命令 Centos以后用firewall

iptables命令行方式：---------------------------------------

       1. 开放端口命令： /sbin/iptables -I INPUT -p tcp --dport 8080 -j ACCEPT

       2.保存：/etc/rc.d/init.d/iptables save

       3.重启服务：/etc/init.d/iptables restart

       4.查看端口是否开放：/sbin/iptables -L -n

       查看端口是否开放：sudo netstat -tnlp | grep 21 如果是linsten状态则是已开启
    
      开启全部 入方向
      iptables -P INPUT ACCEPT   
      开启全部 入方向
      iptables -P OUTPUT ACCEPT  
      开启部分端口段

      -A RH-Firewall-1-INPUT -m state --state NEW -m tcp -p tcp --dport 700:800 -j ACCEPT

      一、 700:800 表示700到800之间的所有端口

      二、 :800 表示800及以下所有端口

      三、 700: 表示700以及以上所有端

      开启关闭 iptables
      service iptables stop 

Centos7 firewall -------------------------------------

      systemctl stop firewalld.service    服务名字叫做firewalld 不是 iptables (iptables只是centos7中只是命令没有服务)
      

      配置文件 /etc/firewalld/
      
      端口规则文件 /etc/firewalld/zones/ 

      查看版本： firewall-cmd --version

      查看帮助： firewall-cmd --help

      显示状态： firewall-cmd --state  或  systemctl status firewalld.service

      查看所有打开的端口： firewall-cmd--zone=public --list-ports

      更新防火墙规则： firewall-cmd --reload

      查看区域信息:  firewall-cmd--get-active-zones

      查看指定接口所属区域： firewall-cmd--get-zone-of-interface=eth0

      拒绝所有包：firewall-cmd --panic-on

      取消拒绝状态： firewall-cmd --panic-off

      查看是否拒绝： firewall-cmd --query-panic

      1.直接添加服务

      firewall-cmd --permanent --zone=public --add-service=http
      firewall-cmd --reload

      firewall-cmd --list-all  查看所有

      iptables -L
       



      2.添加端口

      firewall-cmd --permanent --zone=public --add-port=80/tcp

      firewall-cmd --permanent --zone=public --add-port=80-90/tcp   //端口段
      
      firewall-cmd --reload
  
      当然，firewalld.service需要设为开机自启动。

      删除端口
      
      firewall-cmd --zone=public --remove-port=80/tcp --permanent
  

      3、如何自定义添加端口

      用户可以通过修改配置文件的方式添加端口，也可以通过命令的方式添加端口，注意，修改的内容会在/etc/firewalld/ 目录下的配置文件中还体现。

      1、命令的方式添加端口
      firewall-cmd --permanent --add-port=9527/tcp 
      参数介绍：

      1、firewall-cmd：是Linux提供的操作firewall的一个工具；
      2、--permanent：表示设置为持久；
      3、--add-port：标识添加的端口；

      另外，firewall中有Zone的概念，可以将具体的端口制定到具体的zone配置文件中。

      例如：添加8010端口

      firewall-cmd --zone=public --permanent --add-port=8010/tcp

      --zone=public：指定的zone为public；

      如果–zone=dmz 这样设置的话，会在dmz.xml文件中新增一条。
    
      
     4、修改配置文件的方式添加端口

      <rule family="ipv4">
      <source address="115.57.132.178"/> 指定ip  不填则为任意ip 所有人
      <port protocol="tcp" port="10050-10051"/> 协议类型  指定端口
      <accept/> 表示接受
      </rule>
  
      对应命令行 

      firewall-cmd --permanent --zone=public --add-rich-rule="rule family="ipv4"  source address="192.168.0.4/24" service name="http" accept"


      5.查看当前开了哪些端口

      其实一个服务对应一个端口，每个服务对应/usr/lib/firewalld/services下面一个xml文件。

      firewall-cmd --list-services

      查看还有哪些服务可以打开

      firewall-cmd --get-services

      查看所有打开的端口： 

      firewall-cmd --zone=public --list-ports

      更新防火墙规则： 

      firewall-cmd --reload



------------------------ linux 服务器拒绝允许名单  ------------------------

允许名单:/etc/hosts.allow

拒绝名单:/etc/hosts.deny


编辑允许规则：

[root@linuxprobe ~]# vim /etc/hosts.allow
httpd:192.168.10.
拒绝其他所有的主机：

[root@linuxprobe ~]# vim /etc/hosts.deny
httpd:*
------------------------ linux tail -F 查看动态内容显示行号------------------------

命令:
tail -F   FileName | nl



cat /etc/* | grep 文件名

ls  file  file  file  ....
------------------------ linux 查看服务状态  ------------------------

查看：systemctl status sshd.service

启动：systemctl start sshd.service

重启：systemctl restart sshd.service

自启：systemctl enable sshd.service


------------------------ linux 查看对应端口证书  ------------------------
 openssl s_client -showcerts -connect smtp.qq.com:455
 openssl s_client -showcerts -connect smtp.qq.com:587



------------------------ linux 查看日志文件保存  ------------------------

一般日志都在 /var/log/名字(例如:maillog)
或者在 /tmp/log/

------------------------ linux 检查配置  ------------------------

chkconfig sendmail on

------------------------ linux 查找软件位置  ------------------------

whereis oracle  都可以查找文件安装路径

which oracle   都可以查找文件运行路径
//列出所有被安装的软件包
rpm -qa | grep 软件包
rpm -qa  软件包

rpm -q 包名  如果输出包名则已被安装
find / -name 软件包

用yum命令yum search  软件包



rpm 等包方式的话,就要查其中的数据库了,比如 rpm -q 进行查询.
-q <== 查询(查询本机已经安装的包时不需要版本名称)
-qi #查询被安装的包的详细信息(information)
-qa | grep dhcp <== 列出所有被安装的rpm package
-qc 列出配置文件(/etc下的文件)
-qd 列出帮助文件(man)
-ql dhcp <== 查询指定 rpm 包中的文件列表
-qf /bin/ls <== 查询哪个库里包含了 ls 文件(注意，需要安装了 /bin/ls 后才能查到)
-qp < rpm package name> <== 根据rpm包查询(.rpm 文件),可以接其他参数(如i查详细信息，l查文件列表 等)
-qR 列出需要的依赖套件

------------------------ linux 配置邮件服务器testsaslauthd可用于代理认证 testsaslauthd输入报错  NO "authentication failed"------------------------

/usr/sbin/testsaslauthd –u user –p ‘password’
这时总是出错：0: NO "authentication failed"
该怎么办呢？
其实很简单：vi /etc/sysconfig/saslauthd
#MECH=pam
改成：
MECH=shadow
FLAGS=
然后重启saslauthd: service saslauthd restart
再来测试 /usr/sbin/testsaslauthd –u myuserid –p ‘mypassword’  //这里的账号和密码要换成你的linux 的用户名和密码
0: OK "Success."
终于成功了。



CentOS 6系统安装sendmail邮件服务器
发布时间：2013-12-09 来源：服务器之家

说一下，这个是我边找资料边安装边记录的内容，有些地方不完全都是正确的，但是这也确实能够学到很多东西。安装成功后只做了发送测试，但是没有做接受测试。至少把想要的功能实现了。如果想完整的安装请参考文章最后面的链接。找了很多资料，有价值的貌似就这么几篇。剩下的全部都是粘来粘去。当然我的也是粘贴拼凑的但是至少我测试过。

强调一点 centos 6 没有  /etc/dovecot.conf 文件 

在CentOS下，sendmail一般默认是随操作系统一起安装的。如果安装系统时没有安装sendmail服务，手动安装sendmail也很简单：

# yum install -y sendmail
# yum install -y sendmail-cf
2、 Senmail的SMTP认证配置（不需要认证的可忽略此步）
首先确认saslauthd服务是否安装或启动。

安装saslauthd服务：# yum install -y saslauthd

启动saslauthd服务：# service saslauthd start

testsaslauthd -u username -p password

如果显示0: OK “Success.”则表明saslauthd工作正常；

{输入 ./testsaslauthd -u userID -p 'yours.passwd' 用户名密码都感觉没输出，却报告

0: NO "authentication failed"

这里其实是让 输入 当前用户的 用字和密码 ==||| 我一开始就不知道
[root@localhost sasl2]# testsaslauthd -u username -p password
0: NO "authentication failed"

}

(1) 配置Senmail的SMTP认证

# vi /etc/mail/sendmail.mc

view plain   copy
dnl TRUST_AUTH_MECH(`EXTERNAL DIGEST-MD5 CRAM-MD5 LOGIN PLAIN')dnl

dnl define(`confAUTH_MECHANISMS', `EXTERNAL GSSAPI DIGEST-MD5 CRAM-MD5 LOGIN PLAIN')dnl

将上面两行的dnl去掉。在sendmail文件中，dnl表示该行为注释行，是无效的，因此通过去除行首的dnl字符串可以开启相应的设置行。

[这两行默认是被dnl(注释掉的)掉的，要去掉它的注释，TRUST_AUTH_MECH”的作用是使sendmail不管access文件中如何设置，都能relay那些通过EXTERNAL, LOGIN, PLAIN, CRAM-MD5或DIGEST-MD5等方式验证的邮件，注意这里是对需要relay的邮件进行验证，这点很重要，只有这样通过验证的邮件才会被relay以防止sendmail服务器被滥用，confAUTH_MECHANISMS的作用是确定系统的认证方式。Outlook Express支持的认证方式是LOGIN。

然后将DAEMON_OPTIONS(`Port=smtp,Addr=127.0.0.1, Name=MTA')dnl这行dnl(注释)掉，不然从其他计算机使用foxmail等客户端都将无法使用sendmail发邮件，因为这行的设置表示只接收本机的邮件。将这行注释掉也可以，或者改成DAEMON_OPTIONS(`Port=smtp,Name=MTA')dnl也可以。总之如果想进行邮件接收的话，就不要在这行里加入M=a的配置（注意大小写），因为它是对connection进行验证，这样对接收的邮件，sendmail也会先要求对这个连接验证，而其他邮箱发给你的邮件的这个连接是无法进行验证的。

]

#配置支持的认证方式，配置后通过验证的用户都可以发邮件，不用在access里配置Relay

DAEMON_OPTIONS(`Port=smtp,Addr=0.0.0.0, Name=MTA’)dnl    #修改侦听范围

DAEMON_OPTIONS(`Port=587,Name=MSA,M=a')dnl     #增加通过587端口发邮件

这里要说一句，不要改
dnl DAEMON_OPTIONS(`Port=submission, Name=MSA, M=Ea')dnl

m4 /etc/mail/sendmail.mc > /etc/mail/sendmail.cf      #生成配置

7.添加sendmail接受邮件的域名；

vi /etc/mail/local-host-names

添加域名如: an.test //每个域名一行

[打开/etc/mail/local-host-names
加入你 @后面的邮箱地址。比如我这里是otto@linuxedentest.com
那么，你要在local-host-names文件里的第二行添加：
linuxedentest.com
保存
当然
local-host-names还可以设置邮箱别名，这个不多说，大家查文档看看。]

{[telnet 安装

yum install telnet-server
步骤2：安装完毕之后，需要对你所开放的telnet服务的一些参数作出必要的设定。
在预设的/etc/xinetd.d/telnet内容是这样的：
[root@linux ~]# vi /etc/xinetd.d/telnetservice telnet
{ flags = REUSE <==额外的参数使用
REUSE socket_type = stream <==使用TCP的封包格式
wait = no <==可以有多个连线同时连进来
user = root <==启动者预设为
root server = /usr/sbin/in.telnetd <==使用的是这支程式！
log_on_failure += USERID <==若登入错误，『加计』记录使用者ID
disable = yes <==此服务预设关闭！
}

}

8.重新启动sendmail并验证能否正常使用；
service sendmail restart

chkconfig sendmail on

telnet smtp_server 25

HELO domainname

250 domainname Hello [10.57.28.221], pleased to meet you

AUTH LOGIN

#输入这个后，使用base64编码的用户名密码，使用下面一句话来生成

perl -MMIME::Base64 -e ‘print encode_base64(“word”)’

334 VXNlcm5hbWU6

dGVzdA== # base64编码后的test

334 UGFzc3dvcmQ6

YWJjZC4xMjM0 #base64编码后的abcd.1234

235 2.0.0 OK Authenticated

MAIL FROM:test@an.test

250 2.1.0 test@an.test… Sender ok

RCPT TO:test@an.test

250 2.1.5 test@an.test… Recipient ok

DATA # 开始邮件的内容

Subject:test #邮件标题

This a test email. #邮件正文

. #用一个.结束邮件

{我的操作

[root@localhost /]# telnet 127.0.0.1 25
Trying 127.0.0.1...
Connected to 127.0.0.1.
Escape character is '^]'.
220 localhost.localdomain ESMTP Sendmail 8.14.4/8.14.4; Fri, 18 Jan 2013 11:01:23 +0800
AUTH LOGIN
334 VXNlcm5hbWU6
dGVzdA==
501 5.5.4 cannot decode AUTH parameter dGVzdA==
MAIL FORM:TEST@guo.test
501 5.5.2 Syntax error in parameters scanning "FORM"
500 5.5.1 Command unre"ognized: "
MAIL FROM:test@guo.teset
250 2.1.0 test@guo.teset... Sender ok
RPCT TO:test@guo.test
500 5.5.1 Command unrecognized: "RPCT TO:test@guo.test"
RCPT TO:test@guo.com
250 2.1.5 test@guo.com... Recipient ok (will queue)
^]

}

9.安装dovecot支持pop3；
yum install dovecot

10.配置dovecot.conf
vi /etc/dovecot.conf

去掉以下几行前边的#并修改；

protocols = imap pop3

disable_plaintext_auth = no

mail_location = mbox:/var/mail:INBOX=/var/mail/%u

11.启动dovecot；
service dovecot start

chkconfig dovecot on

{[我的操作：

centos 6 没有 vi /etc/dovecot.conf

打开dovecot.conf文件，搜索include_try，可以发现以下代码
# Optional configurtaions, don't give an error if it's not found:
!include_try /etc/dovecot/conf.d/*.conf
，在/etc/dovecot/conf.d/目录下已经有一个

那么可以猜测他们是互相引用的。然后开始编辑 10-mail.cof 文件中  mail_location = mbox:/var/mail:INBOX=/var/mail/%u

和 vi 10-auth.conf 文件中的disable_plaintext_auth = no  修改

[root@localhost dovecot]# vi dovecot.conf

vi dovecot.conf
# Protocols we want to be serving.
#protocols = imap pop3 lmtp
protocols = imap pop3  最后改为这个
[root@localhost conf.d]# vi 10-ssl.conf
# SSL/TLS support: yes, no, required. <doc/wiki/SSL.txt>
ssl = no

]}

< 摘引：

日志出现tried to use disabled plaintext auth

outlook登陆不进

/etc/dovecot/conf.d目录下有一个10-mail.conf的文件。内容如下：
#   mail_location = maildir:~/Maildir
    mail_location = mbox:~/mail:INBOX=/var/mail/%u
#   mail_location = mbox:/var/mail/%d/%1n/%n:INDEX=/var/indexes/%d/%1n/%n
取消注释protocols = imap pop3 lmtp
disable_plaintext_auth=no
ssl_disable = no
取消注释，并添加你的文件中或许没有的内容。

我的是dovecot-2.1.1-2_132.el5,修改方法如下：vi /etc/dovecot/conf.d/10-auth.conf去掉disable_plaintext_auth前面#,修改为disable_plaintext_auth = novi /etc/dovecot/conf.d/10-ssl.conf修改为ssl = no重启dovecot服务,OKservice dovecot restart

>

<

配置Ubuntu邮件服务器，Ubuntu Server 10.04，安装postfix，安装dovecot-postfix，修改dovecot.conf配置文件，启用disable_plaintext_auth无效，经研究发现需要修改conf.d目录下的配置文件……

Ubuntu官方文档这部分的配置叙述得并不详细，相关信息是在一篇日文博客<ubuntu 10.04 をメールサーバーに (Dovecot 編)>中找到的。

9.10 以前の ubuntu で提供されている Dovecot では /etc/dovecot/dovecot.conf
ファイルを直接編集するしかなかった。
どのバージョンからかは調べていないが、少なくとも 10.04 の Dovecot では include_try
ディレクティブが導入され、/etc/dovecot/dovecot.conf ファイルの中で適宜この include_try
ディレクティブを使って、/etc/dovecot/conf.d ディレクトリにある拡張子が .conf
のファイルと、/etc/dovecot/auth.d ディレクトリにある拡張子が .auth
のファイルを読み込むようになった。
ただし、10.04 になった今でも一部の設定については /etc/dovecot/dovecot.conf
ファイルを直接編集する必要がある。

9.10以前的ubuntu提供的Dovecot只能直接编辑/etc/dovecot/dovecot.conf文件。
没有调查从哪个版本开始，至少10.04的Dovecot导入了inlude_try指令，/etc/dovecot/conf.d文件中使用include_try指令，读取/etc/dovecot/conf.d目录中扩展名为.conf的文件和/etc/dovecot/auth.d目录中扩展名为.auth的文件。
但是，目前10.04中的一部分设定仍然需要直接编辑/etc/dovecot/dovecot.conf文件。

打开dovecot.conf文件，搜索include_try，可以发现以下代码

# Optional configurtaions, don't give an error if it's not
found:
!include_try /etc/dovecot/conf.d/*.conf

因为是直接安装dovecot-postfix这个包，在/etc/dovecot/conf.d/目录下已经有一个经过配置的01-dovecot-postfix.conf文件，将disable_plaintext_auth设置添加到这个文件即可生效。没试过分别安装postfix和dovecot再整合是什么情况。

Ubuntu上的其它软件也启用了include_try，比如Apache：<Apache configuration files on Ubuntu>

Google了一下，CentOS的一些配置中也涉及到了conf.d目录。

Google关于Linux的include_try和Optional configurations的信息，返回的结果很少，难道这是很基础的Linux概念？

引入include_try的优点是：可以保持初始的.conf文件，conf.d目录下可以导入多个配置文件，可以将配置分配在不同的文件中，可以快速地隔离出一个错误的配置修改。

缺点方面，多个配置文件增加了复杂度。目前Ubuntu有些配置需要修改主配置文件，有些配置则只能添加在conf.d目录下的配置文件中才能生效。同时因为很多文档都基于单个conf配置文件编写，文档不能跟上更是增加了配置过程中的混乱。

>

touch mail.php

[code]

<?php

mail('your_email_addr@gmail.com','subject','message body');

?>

[/code]

chmod a+x mail.php

php mail.php

{[如果 php 里找不到 php.ini 需要CP 一个   源码里面的php.ini-development或php.ini-production 到/usr/local/php/lib  为 php.ini 我的这个主机以为不是我配置的所有就没有

用php内置函数通过sendmail发送信件的话，可以在php.ini中修改：

sendmail_path = /usr/sbin/sendmail -f service@domain.com -t –i //我设置了但是没有用

编辑 /etc/mail/sendmail.mc 开启下列各项

MASQUERADE_AS(`mydomain.com')dnl 是否对信息作伪装

修改 MASQUERADE_AS(`text.com')dnl 伪装成text.com域名

FEATURE(masquerade_envelope)dnl 是否对整个域（包括子域）做伪装

FEATURE(masquerade_entire_domain)dnl

MASQUERADE_DOMAIN(localhost)dnl 对localhost域做伪装

MASQUERADE_DOMAIN(localhost.localdomain)dnl

将locahost.com域伪装成text.com

斜体字部分 我做伪装结果不能用，不知道为什么  总是localhost.localdomain 最后是改 的host文件 才做出了伪装。

]}


------------------------ linux 发送邮件  ------------------------
 内容                   -v显示发送过程  -s邮件标题   对方邮件名
 echo 'hel1lo!' | mailx -v -s "hello t1est" chinesebigcabbage@163.com


 /usr/share/sendmail-cf/m4/cf.m4': No such file or directory
 linux 默认安装sendmail      yum install -y sendmail
 但是有的没有  sendmail-cf  需要安装  yum install -y sendmail-cf

认证saslauthd  代理认证服务 
安装后需要修改 vi /etc/sysconfig/saslauthd  
修改#MECH=pam
改成：
MECH=shadow


------------------------ linux  Started Sendmail Mail Transport Agent ------------------------

解决方法：其实就是你的主机没有设置hostname
mail发送邮件，默认调用的是sendmail，sendmail发送邮件，必须设置hostname，而hostname不能是一串字符串，而必须是格式正确的域名,例如mail.tome178.com

所以我们的解决方法是修改hostname，一种是临时的，一种是永久的

一般我们可以设置临时的

[plain] view plain copy
hostname mail.tome178.com  
永久的修改/etc/sysconfig/network


[plain] view plain copy
hostname=mail.tome178.com //主机名(没有这行？那就添加这一行吧)   
然后运行
hostname mail.tome178.com

然后重启sendmail就可以发送邮件了

------------------------ linux  设置自启动 ------------------------

在启动时关闭sendmail 服务 [其它服务也一样] 
在启动时关闭sendmail- -对其他的服务可以采取同样的措施。 
而对于那些不是从inetd启动的服务，则通过命令来关闭，例如需要关闭sendmail服务，则： 

/etc/rc.d/init.d/sendmail stop 

然后再设置其不在系统启动时启动： 

chkconfig -levels 12345 sendmail off 

如果设置其开机启动


chkconfig -levels 12345 sendmail on

------------------------ linux  iptables ------------------------

iptables -I INPUT -p tcp --dport 25 -j ACCEPT

------------------------ linux  crontab ------------------------

 crontab -l 表示列出所有的定时任务
 crontab -r 表示删除用户的定时任务，当执行此命令后，所有用户下面的定时任务会

------------------------ linux  grep ------------------------

[root@www ~]# grep [-acinv] [--color=auto] '搜寻字符串' filename
选项与参数：
-a ：将 binary 文件以 text 文件的方式搜寻数据
-c ：计算找到 '搜寻字符串' 的次数
-i ：忽略大小写的不同，所以大小写视为相同
-n ：顺便输出行号
-v ：反向选择，亦即显示出没有 '搜寻字符串' 内容的那一行！
--color=auto ：可以将找到的关键词部分加上颜色的显示喔！

grep与正规表达式

1.字符类的搜索：如果我想要搜寻 test 或 taste 这两个单字时，可以发现到，其实她们有共通的 't?st' 存在～这个时候，我可以这样来搜寻：
[root@www ~]# grep -n 't[ae]st' regular_express.txt
8:I can't finish the test.
9:Oh! The soup taste good.

2.字符类的反向选择 [^] ：如果想要搜索到有 oo 的行，但不想要 oo 前面有 g，如下
[root@www ~]# grep -n '[^g]oo' regular_express.txt
2:apple is my favorite food.
3:Football game is not use feet only.
18:google is the best tools for search keyword.
19:goooooogle yes!


3.不使用正则表达式

fgrep 查询速度比grep命令快，但是不够灵活：它只能找固定的文本，而不是规则表达式。

如果你想在一个文件或者输出中找到包含星号字符的行

fgrep  '*' /etc/profile
for i in /etc/profile.d/*.sh ; do

或
grep -F '*' /etc/profile
for i in /etc/profile.d/*.sh ; do

4.
（1.）grep -F YOURSTRING -R path 

功能：用grep搜索文档中的字符串

[root@SOR_SYS hahah]# grep -F 0576 -R /root/zy/hahah
/root/zy/hahah/b:05766798607

(2.)grep -v -f file1 file2

功能：输出文件2中的内容，但是剔除包含在文件1中的内容


------------------------ linux  shell ------------------------

一、该shell的作用主要是实现监控某个程序崩溃之后就自动重启该进程。
[html] view plain copy
#!/bin/bash  
  
while true  
do   
    procnum=` ps -ef|grep "test"|grep -v grep|wc -l`  
   if [ $procnum -eq 0 ]; then  
       /home/test&  
   fi  
   sleep 

   -eq意思是等于0，用于判断该test是否还在运行状态。监控/home/test这个程序是否运行。

二、由于该程序是window上的编写的，我们将它（名字用run._start.sh）拷贝到linux下之后需要对它赋予操作的权限

chmod 777 run_start.sh

   ./run_start.sh &

记得加上&，要不然得窗口退了，该脚本也退出了。
三、发现运行的时候有错误“-bash: ./run_start.sh: /bin/bash^M: bad interpreter: 没有那个文件或目录” ，根据提示，我以为没有这个shell没有安装，所以找不到“/bin/bash”，其实理解错误了，是linux上无法识别window的doc格式。以后记住了，如果遇到这bad interpreter的错误，一定要将字符做一下转换，方法如下：

1）编辑出错文件
        vi run_start.sh
 
2）查看该格式（报错文件格式是DOS）
        :set ff
3）修改格式
        :set ff=unix
 
4）保存退出
        :wq!

四、再重新运行脚本，可以看到正常了

五、设置开机自动启动脚本

  使用命令 vi  /etc/rc.local 在文件末尾添加这一行        /home/test.sh&



------------------------ linux  查看用户属组和用户 id uid ------------------------

id  user

groups user

------------------------ linux  vi中查找字符内容的方法------------------------


1、命令模式下输入“/字符串”，例如“/Section 3”。

2、如果查找下一个，按“n”即可。

要自当前光标位置向上搜索，请使用以下命令：

/pattern Enter

其中，pattern表示要搜索的特定字符序列。

要自当前光标位置向下搜索，请使用以下命令：

?pattern Enter

按下 Enter键后，vi 将搜索指定的pattern，并将光标定位在 pattern的第一个字符处。例如，要向上搜索 place一词，请键入 ：


查找到结果后，如何退出查找呢？输入:noh命令。

------------------------ linux  命令行上传下载文件 ------------------------
1.sftp
建立连接：sftp user@host

从本地上传文件：put localpath

下载文件：get remotepath

与远程相对应的本地操作，只需要在命令前加上”l” 即可，方便好记。

例如：lcd lpwd lmkdir

2.scp

SCP ：secure copy (remote file copy program) 也是一个基于SSH安全协议的文件传输命令。与sftp不同的是，它只提供主机间的文件传输功能，没有文件管理的功能。

复制local_file 到远程目录remote_folder下

scp local_file remote_user@host:remote_folder

复制local_folder 到远程remote_folder（需要加参数 -r 递归）

scp –r local_folder remote_user@host:remote_folder

以上命令反过来写就是远程复制到本地

3.sz/rz

sz/rz 是基于ZModem传输协议的命令。对传输的数据会进行核查，并且有很好的传输性能。使用起来更是非常方便，但前提是window端需要有能够支持ZModem的telnet或者SSH客户端，例如secureCRT。

首先需要在secureCRT中可以配置相关的本地下载和上传目录，然后用rz、sz命令即可方便的传输文件数据。

下载数据到本地下载目录：sz filename1 filename2 …

上传数据到远程：执行rz –be 命令，客户端会弹出上传窗口，用户自行选择(可多选)要上传的文件即可。

相关资料：

2.XMODEM、YMODEM、ZMODEM : http://web.cecs.pdx.edu/~rootd/catdoc/guide/TheGuide_226.html

3.Wiki SCP :http://en.wikipedia.org/wiki/Secure_copy
------------------------ linux  windows商店命令行 保存的本地文件路径 ------------------------

C:\Users\chine\AppData\Local\Packages\46932SUSE.openSUSELeap42.2_022rs5jcyhyac\LocalState\rootfs\home

------------------------ linux  解压缩 ------------------------
http://blog.csdn.net/x_iya/article/details/72889456  转载

tar -xvf file.tar //解压 tar包

tar -xzvf file.tar.gz //解压tar.gz

tar -xjvf file.tar.bz2   //解压 tar.bz2

tar -xZvf file.tar.Z   //解压tar.Z

unrar e file.rar //解压rar

unzip file.zip //解压zip

tar: bzip2：无法 exec: 没有那个文件或目录

缺少bzip2包
yum install -y bzip2


tar

-c: 建立压缩档案
-x：解压
-t：查看内容
-r：向压缩归档文件末尾追加文件
-u：更新原压缩包中的文件

这五个是独立的命令，压缩解压都要用到其中一个，可以和别的命令连用但只能用其中一个。下面的参数是根据需要在压缩或解压档案时可选的。

-z：有gzip属性的
-j：有bz2属性的
-Z：有compress属性的
-v：显示所有过程
-O：将文件解开到标准输出

下面的参数-f是必须的

-f: 使用档案名字，切记，这个参数是最后一个参数，后面只能接档案名。

# tar -cf all.tar *.jpg
这条命令是将所有.jpg的文件打成一个名为all.tar的包。-c是表示产生新的包，-f指定包的文件名。

# tar -rf all.tar *.gif
这条命令是将所有.gif的文件增加到all.tar的包里面去。-r是表示增加文件的意思。

# tar -uf all.tar logo.gif
这条命令是更新原来tar包all.tar中logo.gif文件，-u是表示更新文件的意思。

# tar -tf all.tar
这条命令是列出all.tar包中所有文件，-t是列出文件的意思

# tar -xf all.tar
这条命令是解出all.tar包中所有文件，-t是解开的意思

压缩

tar -cvf jpg.tar *.jpg //将目录里所有jpg文件打包成tar.jpg 

tar -czf jpg.tar.gz *.jpg   //将目录里所有jpg文件打包成jpg.tar后，并且将其用gzip压缩，生成一个gzip压缩过的包，命名为jpg.tar.gz

 tar -cjf jpg.tar.bz2 *.jpg //将目录里所有jpg文件打包成jpg.tar后，并且将其用bzip2压缩，生成一个bzip2压缩过的包，命名为jpg.tar.bz2

tar -cZf jpg.tar.Z *.jpg   //将目录里所有jpg文件打包成jpg.tar后，并且将其用compress压缩，生成一个umcompress压缩过的包，命名为jpg.tar.Z

rar a jpg.rar *.jpg //rar格式的压缩，需要先下载rar for linux

zip jpg.zip *.jpg //zip格式的压缩，需要先下载zip for linux

解压

tar -xvf file.tar //解压 tar包

tar -xzvf file.tar.gz //解压tar.gz

tar -xjvf file.tar.bz2   //解压 tar.bz2

tar -xZvf file.tar.Z   //解压tar.Z

unrar e file.rar //解压rar

unzip file.zip //解压zip

总结

1、*.tar 用 tar -xvf 解压

2、*.gz 用 gzip -d或者gunzip 解压

3、*.tar.gz和*.tgz 用 tar -xzf 解压

4、*.bz2 用 bzip2 -d或者用bunzip2 解压

5、*.tar.bz2用tar -xjf 解压

6、*.Z 用 uncompress 解压

7、*.tar.Z 用tar -xZf 解压

8、*.rar 用 unrar e解压

9、*.zip 用 unzip 解压




------------------------ linux  添加软链名称 ------------------------
        目标地址                    添加到命令 php72自定义名字
ln -s   /www/server/php/72/bin/php /usr/bin/php72

也可删除 /usr/bin/php  重新生成软链 ln -s   /www/server/php/72/bin/php /usr/bin/php

ls -al 可以查看到 软连指向的路径  pecl -> /www/server/php/72/bin/pecl

添加php永久命令
# vi /etc/profile
#export PATH=/www/server/php/70/bin:$PATH 
#source profile
如果需要立即生效的话，可以执行# source profile命令。

命令行输入export PATH=/www/server/php/70/bin:$PATH 然后回车。这种只是临时有效


------------------------ linux  修改添加PATH的三种方法 ------------------------

备注:如果有多个目录下有相同的命令 以靠前的命令优先起作用  
输入 type 命令可检测是哪个命令生效
type php
php is hashed (/www/server/php/72/bin/php)

一:修改添加PATH的三种方法
1.#PATH=$PATH:/etc/apache/bin 

使用这种方法,只对当前会话有效，也就是说每当登出或注销系统以后，PATH 设置就会失效 

2.#vi /etc/profile 

在适当位置添加 PATH=$PATH:/etc/apache/bin (注意：= 即等号两边不能有任何空格) 

这种方法最好,除非你手动强制修改PATH的值,否则将不会被改变 

3.#vi ~/.bash_profile 

修改PATH行,把/etc/apache/bin添加进去 

这种方法是针对用户起作用的 


------------------------ linux  PATH的优先级  ------------------------

在Ubuntu中  可以设置环境变量有4个 优先级从高到底

1、/etc/profile:在登录时,操作系统定制用户环境时使用的第一个文件,此文件为系统的每个用户设置环境信息,当用户第一次登录时,该文件被执行。



2、/etc/environment:在登录时操作系统使用的第二个文件,系统在读取你自己的profile前,设置环境文件的环境变量。



3、~/.bash_profile:在登录时用到的第三个文件是.profile文件,每个用户都可使用该文件输入专用于自己使用的shell信息,当用户登录时,该 文件仅仅执行一次!默认情况下,他设置一些环境变游戏量,执行用户的.bashrc文件。/etc/bashrc:为每一个运行bash shell的用户执行此文件.当bash shell被打开时,该文件被读取.



4、~/.bashrc:该文件包含专用于你的bash shell的bash信息,当登录时以及每次打开新的shell时,该该文件被读取。



几个环境变量的优先级

1>2>3>4
------------------------ linux  linux将命令添加到PATH中 ------------------------


简单说PATH就是一组路径的字符串变量，当你输入的命令不带任何路径时，LINUX会在PATH记录的路径中查找该命令。有的话则执行，不存在则提示命令找不到。比如在根目录/下可以输入命令ls,在/usr目录下也可以输入ls,但其实ls命令根本不在这个两个目录下，当你输入ls命令时LINUX会去/bin,/usr/bin,/sbin等目录寻找该命令。而PATH就是定义/bin:/sbin:/usr/bin等这些路劲的变量，其中冒号为目录间的分割符。
如何自定义路径： 
假设你新编译安装了一个apache在/usr/local/apache下，你希望每次启动的时候不用敲一大串字符（# /usr/local/apache/bin/apachectl start）才能使用它，而是直接像ls一样在任何地方都直接输入类似这样（# apachectl start）的简短命令。这时，你就需要修改环境变量PATH了，准确的说就是给PATH增加一个值/usr/local/apache/bin。将/usr/local/apache/bin添加到PATH中有三种方法：

1、直接在命令行中设置PATH
# PATH=$PATH:/usr/local/apache/bin
使用这种方法,只对当前会话有效，也就是说每当登出或注销系统以后，PATH设置就会失效。

2、在profile中设置PATH
# vi /etc/profile
找到export行，在下面新增加一行，内容为：export PATH=$PATH:/usr/local/apache/bin。
注：＝ 等号两边不能有任何空格。这种方法最好,除非手动强制修改PATH的值,否则将不会被改变。
编辑/etc/profile后PATH的修改不会立马生效，如果需要立即生效的话，可以执行# source profile命令。

3、在当前用户的profile中设置PATH
# vi ~/.bash_profile
修改PATH行,把/usr/local/apache/bin添加进去,如：PATH=$PATH:$HOME/bin:/usr/local/apache/bin。
# source ~/.bash_profile
让这次的修改生效。
注：这种方法只对当前用户起作用的,其他用户该修改无效。

 

去除自定义路径： 
当你发现新增路径/usr/local/apache/bin没用或不需要时，你可以在以前修改的/etc/profile或~/.bash_profile文件中删除你曾今自定义的路径。

如果配置 PATH配置错误了  并且执行了 source /etc/profile 
可以直接在命令行执行
export PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin    
然后再把配置文件改了

修改之前最好 cp 一份


------------------------ linux  删除命令 ------------------------

Linux Vi 删除全部内容，删除某行到结尾，删除某段内容 的方法
原创 2010年11月24日 14:51:00 标签：linux 91108
1.打开文件

vi filename  
2.转到文件结尾
G  
或转到第9行
9G  
3.删除所有内容(先用G转到文件尾) ，使用：

:1,.d  
或者删除第9行到第200行的内容(先用200G转到第200行) ，使用
:9,.d  
 

删除说明：这是在vi中 ，“.”当前行 ，“1,.”表示从第一行到当前行 ，“d”删除

------------------------ linux  curl post请求 参数为本地文件 ------------------------

curl -d @curl.xml http://api.zichends.com/webapi/bank_batch/test


------------------------ linux  变量自增 ------------------------

Linux Shell中写循环时，常常要用到变量的自增，现在总结一下整型变量自增的方法。
我所知道的，bash中，目前有五种方法：
1. i=`expr $i + 1`;
2. let i+=1;
3. ((i++));
4. i=$[$i+1];
5. i=$(( $i + 1 ))
可以实践一下，简单的实例如下：

------------------------ linux  后台运行进程 ------------------------

ps 列出系统中正在运行的进程；
　　kill 发送信号给一个或多个进程（经常用来杀死一个进程）；
　　jobs 列出当前shell环境中已启动的任务状态，若未指定jobsid，则显示所有活动的任务状态信息；如果报告了一个任务的终止(即任务的状态被标记为Terminated)，shell 从当前的shell环境已知的列表中删除任务的进程标识；
　　bg 将进程搬到后台运行（Background）；
　　fg 将进程搬到前台运行（Foreground）； 

　　将job转移到后台运行 
　　如果你经常在X图形下工作，你可能有这样的经历：通过终端命令运行一个GUI程序，GUI界面出来了，但是你的终端还停留在原地，你不能在shell中继续执行其他命令了，除非将GUI程序关掉。

　　为了使程序执行后终端还能继续接受命令，你可以将进程移到后台运行，使用如下命令运行程序： #假设要运行xmms

　　$xmms &

　　这样打开xmms后，终端的提示又回来了。现在xmms在后台运行着呢；但万一你运行程序时忘记使用“&”了，又不想重新执行；你可以先使用ctrl+z挂起程序，然后敲入bg命令，这样程序就在后台继续运行了。

*********************************
如果是有输出的内容 只用 & 是不能后台运行的 需要

nohup /root/start.sh &

************************************

在应用Unix/Linux时，我们一般想让某个程序在后台运行，于是我们将常会用 & 在程序结尾来让程序自动运行。比如我们要运行mysql在后台： /usr/local/mysql/bin/mysqld_safe –user=mysql &。可是有很多程序并不想mysqld一样，这样我们就需要nohup命令，怎样使用nohup命令呢？这里讲解nohup命令的一些用法。

nohup /root/start.sh &
在shell中回车后提示：

[~]$ appending output to nohup.out

原程序的的标准输出被自动改向到当前目录下的nohup.out文件，起到了log的作用。

但是有时候在这一步会有问题，当把终端关闭后，进程会自动被关闭，察看nohup.out可以看到在关闭终端瞬间服务自动关闭。

咨询红旗Linux工程师后，他也不得其解，在我的终端上执行后，他启动的进程竟然在关闭终端后依然运行。

在第二遍给我演示时，我才发现我和他操作终端时的一个细节不同：他是在当shell中提示了nohup成功后还需要按终端上键盘任意键退回到shell输入命令窗口，然后通过在shell中输入exit来退出终端；而我是每次在nohup执行成功后直接点关闭程序按钮关闭终端.。所以这时候会断掉该命令所对应的session，导致nohup对应的进程被通知需要一起shutdown。

这个细节有人和我一样没注意到，所以在这儿记录一下了。

附：nohup命令参考

nohup 命令

用途：不挂断地运行命令。

语法：nohup Command [ Arg … ] [　& ]

描述：nohup 命令运行由 Command 参数和任何相关的 Arg 参数指定的命令，忽略所有挂断（SIGHUP）信号。在注销后使用 nohup 命令运行后台中的程序。要运行后台中的 nohup 命令，添加 & （ 表示”and”的符号）到命令的尾部。

无论是否将 nohup 命令的输出重定向到终端，输出都将附加到当前目录的 nohup.out 文件中。如果当前目录的 nohup.out 文件不可写，输出重定向到 $HOME/nohup.out 文件中。如果没有文件能创建或打开以用于追加，那么 Command 参数指定的命令不可调用。如果标准错误是一个终端，那么把指定的命令写给标准错误的所有输出作为标准输出重定向到相同的文件描述符。

退出状态：该命令返回下列出口值：

126 可以查找但不能调用 Command 参数指定的命令。

127 nohup 命令发生错误或不能查找由 Command 参数指定的命令。

否则，nohup 命令的退出状态是 Command 参数指定命令的退出状态。

nohup命令及其输出文件

nohup命令：如果你正在运行一个进程，而且你觉得在退出帐户时该进程还不会结束，那么可以使用nohup命令。该命令可以在你退出帐户/关闭终端之后继续运行相应的进程。nohup就是不挂起的意思( n ohang up)。

该命令的一般形式为：nohup command &

使用nohup命令提交作业

如果使用nohup命令提交作业，那么在缺省情况下该作业的所有输出都被重定向到一个名为nohup.out的文件中，除非另外指定了输出文件：

nohup command > myout.file 2>&1 &

在上面的例子中，输出被重定向到myout.file文件中。

使用 jobs 查看任务。

使用 fg %n　关闭。

另外有两个常用的ftp工具ncftpget和ncftpput，可以实现后台的ftp上传和下载，这样就可以利用这些命令在后台上传和下载文件了。

Work for fun,Live for love!


------------------------- linux 磁盘 ---------------------------
df -h 查看磁盘和空间

fdisk -l 查看当前磁盘及dev

cat /etc/fstab 查看挂载的磁盘

------------------------- linux 查看版本信息 ---------------------------

uname -a 详细 -r 内核版本 -s 操作系统 

lsb_release -a 查看系统发行信息  -r 发行版本
      
------------------------- linux nice ---------------------------

nice -10 调整进程优先级
renice  -10  调整正在进行的进程优先级
------------------------- linux  at 只执行一次定时任务  ---------------------------

at  时间
at  now + 1 minutes 执行事件

jobs 查看后台进行的进程 

------------------------- linux  vmstat  ---------------------------

vmstat命令是最常见的Linux/Unix监控工具，可以展现给定时间间隔的服务器的状态值,包括服务器的CPU使用率，内存使用，虚拟内存 交换情况,IO读写情况。相比top，通过vmstat可以看到整个机器的 CPU,内存,IO的使用情况，而不是单单看到各个进程的CPU使用率和内存使用率。

运行示例
一般vmstat工具的使用是通过两个数字参数来完成的，第一个参数是采样的时间间隔数，单位是秒，第二个参数是采样的次数，如:
 
root@vm-199:~# vmstat 2 1
procs -----------memory---------- ---swap-- -----io---- -system-- ----cpu----
 r  b   swpd   free   buff  cache   si   so    bi    bo   in   cs us sy id wa
 0  0  97640  53884 192800 578212    0    0     3    20    1   12  1  2 93  3

 2表示每个两秒采集一次服务器状态，1表示只采集一次。

实际上，在应用过程中，我们会在一段时间内一直监控，不想监控直接结束vmstat就行了,例如:

root@vm-199:~# vmstat 2

------------------------- linux  宝塔端口  ---------------------------

 20 21 30000-40000 端口（FTP）  22 (SSH) 80 443 （网站及 SSL） 3306 （数据库远程连接） 888 （phpmyadmin）等等。

------------------------- linux  宝塔无法访问  ---------------------------

ls /etc/init.d/

地板
mingxue  准内测组成员 发表于 2017-8-23 10:10:57 | 只看该作者
提示functions  httpd  iprdump  iprinit  iprupdate  mysqld  netconsole  network  php-fpm-56  README

不正常 少了宝塔的启动文件
输入这条命令重新升级修复一下 启动面板即可
wget -O update.sh http://download.bt.cn/install/update.sh && sh update.sh 5.1.1


------------------------- linux  对文件大小排序 ---------------------------


ll   -Sh            文件的大小排序--大---小du -sh   #计算文件大小

du -h --max-depth=1  计算文件大小  -–max-depth=<目录层数> 超过指定层数的目录后，予以忽略

du -h | sort -hr | head(或tail) -20  文件的大小排序 只显示20行
------------------------- linux  LINUX的文件按时间排序 ---------------------------


转载 2014年12月29日 00:49:23 19635
> ls -alt # 按修改时间排序
> ls --sort=time -la # 等价于> ls -alt
> ls -alc # 按创建时间排序
> ls -alu # 按访问时间排序
 
# 以上均可使用-r实现逆序排序
> ls -alrt # 按修改时间排序
> ls --sort=time -lra # 等价于> ls -alrt
> ls -alrc # 按创建时间排序
> ls -alru # 按访问时间排序

------------------------- linux  某个文件里面是否包含字符串 ---------------------------


1：搜索某个文件里面是否包含字符串，使用 

grep "查找的文本"  文件名
grep "查找的文本"  ./* 本目录全部文件

------------------------- linux  在 Linux 系统中查看 inode  ---------------------------


在 Linux 系统中查看 inode 号可使用命令 stat 或 ls -i（若是 AIX 系统，则使用命令 istat）
文件inode号是唯一的 文件名只是方便记忆


------------------------- linux  恢复删的的文件  ---------------------------

在误删文件之后要马上停止系统的访问,暂停系统运行,防止新建的文件占用已被删除文件的inode号 

1.查看系统文件格式 
  lsb_release -a

2.查看被删除文件所在分区
  df /被删除文件所在目录

3.利用debugfs
  debugfs 

4.打开所在分区
  open /dev/vda1

5.查看被删除文件
 ls -d /被删除目录  其中<12121>中是被删除的文件 

6.显示有<>尖括号的就是我们要找的文件Inode 号 执行
 logdump –i  <19662057>
7.记住显示的信息中的 block 和offset
Inode 1026632 is at group 125, block 4097109, offset 896
Journal starts at block 28332, transaction 4220648
Found sequence 4217367 (not 4221502) at block 3461: end of journal.
8.退出debugfs 
dd if/dev/vda1 of=/被删目录/文件名 bs=offset(号码) count=1 skip=block(号码)

进入目录查看是否成功

------------------------- linux  虚拟主机、ECS云服务器、VPS区别汇总  ---------------------------

想做一个网站，但是在各种类型的服务器琳琅满目，现在总结一下市场上常见的几种服务器。

1、虚拟主机

虚拟主机就是利用虚拟化的技术，将一台服务器划分出一定大小的空间，每个空间都给予单独的 FTP 权限和 Web 访问权限，多个用户共同平均使用这台服务器的硬件资源。不同配置的虚拟主机主要是在磁盘空间、数据库大小、流量上面的区别。虚拟主机也有可以分为独享的虚拟主机，和共享的虚拟主机。顾名思义，两者之间的区别在于服务器资源的独享和共享。网站主机、空间、都是一个意思。这一类的主机用户的权限很低，没有远程桌面，只有FTP权限供用户上传文档等操作。优势是比较价格便宜。

 

2、VPS

先说一下vps，Virtual Private Server 虚拟专用服务器,一般是将一个独立服务器通过虚拟化技术虚拟成多个虚拟专用服务器。与虚拟主机不同的是，你拥有的是一台虚拟的服务器，类似于Windows上的虚拟机一样，虽然是虚拟的，但是使用起来，和使用客户机没有什么区别。同理，VPS可以使用远程桌面登录对服务器进行维护操作。

 

3、ECS云服务器

现在的主流的服务器解决方案，一般理解云服务器和VPS一样，同样是虚拟化的技术虚拟出来的服务器。也有人说以前的VPS就是现在的ECS，其实不然，云服务器是一个计算，网络，存储的组合。简单点说就是通过多个CPU，内存，硬盘组成的计算池和存储池和网络的组合；在这样的平台上虚拟出的服务器，用户可以根据自己的运算需要选择配置不同的云服务器。具体区别总结如下：


------------------------- linux  端口占用查看  ---------------------------
需要切换到root用户  专享主机等或godaddy.com买的主机需要 su 切换到root才能看到占用的进程

lsof -i :80  查看80端口占用的程序

nginx: [emerg] bind() to 0.0.0.0:80 failed (98: Address already in use)

查看 lsof -i :80 
kill -9 PID
kill -9 PID

service nginx start


如果以上方法 kill不能杀死程序 
可使用命令关闭占用80端口的程序

sudo fuser -k 80/tcp

------------------------- linux  fuser功能  ---------------------------

fuser 可以显示出当前哪个程序在使用磁盘上的某个文件、挂载点、甚至网络端口，并给出程序进程的详细信息. 
fuser显示使用指定文件或者文件系统的进程ID.默认情况下每个文件名后面跟一个字母表示访问类型。 
访问类型如下： 
c 代表当前目录 
e 将此文件作为程序的可执行对象使用 
f 打开的文件。默认不显示。 
F 打开的文件，用于写操作。默认不显示。 
r 根目录。 
m 映射文件或者共享库。


fuser 的返回值：
fuser如果没有找到任何进程正在使用指定的file, filesystem 或 socket, 或者在查找过程中发生了fatal error，则返回non-zero 值。

fuser如果找到至少一个进程正在使用指定的file, filesystem 或 socket，则返回zero。

fuser 常用场景
fuser通常被用在诊断系统的“resource busy”问题，通常是在你希望umount指定的挂载点得时候遇到。 如果你希望kill所有正在使用某一指定的file, file system or sockets的进程的时候，你可以使用-k option。

fuser –k /path/to/your/filename

这时fuser会向所以正在使用/path/to/your/filename的进程发送SIGKILL。如果你希望在发送之前得到提示，可以使用-i 选项。

fuser –k –i /path/to/your/filename


s 将此文件作为共享库（或其他可装载对象）使用
当指定的文件没有被访问，或者出现错误的时候，fuser会返回非零。 
为了查看使用tcp和udp套接字的进程，需要-n选项并指定名称空间。默认IpV4和IpV6都会显示。套接字可以是本地的或者是远程的端口，和远程的地址。所有的域是可选的，但是其前面的','必须存在。如下： 
[lcl_port][,[rmt_host][,[rmt_port]]] 
对于ip地址和port，名称和数字表示都可以使用。 
fuser只把PID输出到标准输出，其他的都输出到标准错误输出。 
常用选项
-a 显示所有命令行中指定的文件，默认情况下被访问的文件才会被显示。 
-c 和-m一样，用于POSIX兼容。 
-k 杀掉访问文件的进程。如果没有指定-signal就会发送SIGKILL信号。 
-i 杀掉进程之前询问用户，如果没有-k这个选项会被忽略。 
-l 列出所有已知的信号名称。 
-m name 指定一个挂载文件系统上的文件或者被挂载的块设备（名称name）。这样所有访问这个文件或者文件系统的进程都会被列出来。如果指定的是一个目录会自动转换成"name/",并使用所有挂载在那个目录下面的文件系统。 
-n space 指定一个不同的命名空间(space).这里支持不同的空间文件(文件名，此处默认)、tcp(本地tcp端口)、udp(本地udp端口)。对于端口， 可以指定端口号或者名称，如果不会引起歧义那么可以使用简单表示的形式，例如：name/space (即形如:80/tcp之类的表示)。 
-s 静默模式，这时候-u,-v会被忽略。-a不能和-s一起使用。 
-signal 使用指定的信号，而不是用SIGKILL来杀掉进程。可以通过名称或者号码来表示信号(例如-HUP,-1),这个选项要和-k一起使用，否则会被忽略。 
-u 在每个PID后面添加进程拥有者的用户名称。 
-v 详细模式。输出似ps命令的输出，包含PID,USER,COMMAND等许多域,如果是内核访问的那么PID为kernel. -V 输出版本号。 
-4 使用IPV4套接字,不能和-6一起应用，只在-n的tcp和udp的命名存在时不被忽略。 
-6 使用IPV6套接字,不能和-4一起应用，只在-n的tcp和udp的命名存在时不被忽略。 
- 重置所有的选项，把信号设置为SIGKILL.


(1)用fuser命令的四步:
1.确认挂接点有那些进程需要杀掉
#fuser -cu /mount_point
2.向进程发出SIGKILL信号:
#fuser -ck /mount_point
3.确认看是否还有进程在访问挂接点
#fuser -c /mount_point
4.umount挂接点
#umount /mount_point



------------------------- linux  宝塔的域名配置文件及重写规则路径  ---------------------------


在www/server/panel/vhost/rewrite/站点名称   站点域名配置
在www/server/panel/vhost/vhost/站点名称     站点重写规则配置


------------------------- nginx  重写规则  ---------------------------

1.老版nginx
if (!-d $request_filename){
  set $rule_0 1$rule_0;
}
if (!-f $request_filename){
  set $rule_0 2$rule_0;
}
if ($rule_0 = "21"){
  rewrite ^/(.*)$ /index.php/$1 last;
}

2.tp5
location / {
  if (!-e $request_filename){
    rewrite  ^(.*)$  /index.php?s=$1  last;   break;
  }
}

3.laravel5
location / {  
  try_files $uri $uri/ /index.php$is_args$query_string;  
}  

4.vue前端
location ~* \.(eot|otf|ttf|woff)$ {
    add_header Access-Control-Allow-Origin *;
}
location /{
if (!-e $request_filename){

      rewrite  ^/(.*)$  /index.html  last;
}
}

5.apache 
<IfModule mod_rewrite.c>
  Options +FollowSymlinks
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
如果出现
“No input file specified.”，是没有得到有效的文件路径造成的。
修改后的伪静态规则，如下：
IfModule mod_rewrite.c>
  Options +FollowSymlinks
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
</IfModule>

在正则结果“/$1”前面多加了一个“?”号



------------------------- linux kill ---------------------------
方法1：适用于嵌入式linux 脚本

http://bbs.csdn.net/topics/360151075?page=1

linux使用脚本杀死指定名称的进程

#!/bin/ksh
ps -ef|grep -v grep|grep process_name|while read u p o
do
kill -9 $p
done

------------------------- linux  kill 的几种方式 ---------------------------

二.命令
http://os.51cto.com/art/200910/158639.htm
1.kill ［信号代码］ 进程ID

kill -9 来强制终止退出

特殊用法：
kill -STOP [pid]
发送SIGSTOP (17,19,23)停止一个进程，而并不linux杀死进程。

kill -CONT [pid]
发送SIGCONT (19,18,25)重新开始一个停止的进程。

kill -KILL [pid]
发送SIGKILL (9)强迫进程立即停止，并且不实施清理操作。

kill -9 -1
终止你拥有的全部进程。

2. killall
作用：通过程序的名字，直接杀死所有进程
用法：killall 正在运行的程序名
举例：
[root@localhost beinan]# pgrep -l gaim 2979 gaim
[root@localhost beinan]# killall gaim
注意：该命令可以使用 -9 参数来强制杀死进程

3. pkill
作用：通过程序的名字，直接杀死所有进程
用法：#pkill 正在运行的程序名
举例：
[root@localhost beinan]# pgrep -l gaim 2979 gaim
[root@localhost beinan]# pkill gaim

4. xkill
作用：杀死桌面图形界面的程序。
应用情形实例：firefox出现崩溃不能退出时，点鼠标就能杀死firefox 。
当xkill运行时出来和个人脑骨的图标，哪个图形程序崩溃一点就OK了。
如果您想终止xkill ，就按右键取消；
调用方法：
[root@localhost ~]# xkill

------------------------- linux  killall 选项---------------------------

killall -l
killall -V  
DESCRIPTION (描述)
killall 发送一条信号给所有运行任意指定命令的进程. 如果没有指定信号名, 则发送SIGTERM.。
信号可以以名字 (如 -HUP ) 或者数字 (如 -1 ) 的方式指定. 信号 0 (检查进程是否存在)只能以数字方式指定。
如果命令名包括斜杠 (/), 那么执行该特定文件的进程将被杀掉, 这与进程名无关。
如果对于所列命令无进程可杀, 那么 killall 会返回非零值. 如果对于每条命令至少杀死了一个进程, killall 返回 0。Killall 进程决不会杀死自己 (但是可以杀死其它 killall 进程)。

OPTIONS (选项)

-e对于很长的名字, 要求准确匹配. 如果一个命令名长于 15 个字符, 则可能不能用整个名字 (溢出了). 在这种情况下, killall 会杀死所有匹配名字前 15 个字符的所有进程. 有了 -e 选项,这样的记录将忽略. 如果同时指定了 -v 选项, killall 会针对每个忽略的记录打印一条消息。

-g杀死属于该进程组的进程. kill 信号给每个组只发送一次, 即使同一进程组中包含多个进程。

-i交互方式，在linux杀死进程之前征求确认信息。

-l列出所有已知的信号名。

-q如果没有进程杀死, 不会提出抱怨。

-v报告信号是否成功发送。

-V显示版本信息。

-w等待所有杀的进程死去. killall 会每秒检查一次是否任何被杀的进程仍然存在, 仅当都死光后才返回. 注意: 如果信号被忽略或没有起作用, 或者进程停留在僵尸状态, killall 可能会永久等待。

FILES(相关文件)
/proc proc文件系统的存在位置。
KNOWN bugS (已知 BUGS)
以文件方式杀死只对那些在执行时一直打开的可执行文件起作用, 也即, 混杂的可执行文件不能够通过这种方式杀死。
要警告的是输入 killall name 可能不会在非 Linux 系统上产生预期的效果, 特别是特权用户执行时要小心。
在两次扫描的间隙, 如果进程消失了而被代之以一个有同样 PID 的新进程, killall -w 侦测不到。

------------------------- linux  kill 解释 ---------------------------

http://codingstandards.iteye.com/blog/986313

killall 解释

用途说明
killall命令用于杀死指定名字的进程（kill processes by name）。我们可以使用kill命令杀死指定进程PID的进程，如果要找到我们需要杀死的进程，我们还需要在之前使用ps等命令再配合grep来查找进程，而killall把这两个过程合二为一，这真是一个太好用的命令了。

常用参数
格式：killall <command-name>

杀死指定名字的进程。实际上是向名字为<command-name>的所有进程发送SIGTERM信号，如果这些进程没有捕获这个信号，那么这些进程就会直接被干掉了。

格式：killall -<signame> <command-name>

格式：killall -<signum> <command-name>

发送指定的信号到名字为<command-name>的所有进程。指定的信号可以是名称<signame>，也可以是信号对应的数字<signum>。下面是常用的信号：第一列为<signame>，第二列为<signum>，第三列为信号的含义。

HUP     1    终端断线
INT       2    中断（同 Ctrl + C）
QUIT    3    退出（同 Ctrl + \）
TERM    15    终止
KILL      9    强制终止
CONT   18    继续（与STOP相反， fg/bg命令）
STOP    19    暂停（同 Ctrl + Z）

格式：killall -l

列出支持的信号。

使用示例
示例一
[root@jfht ~]# killall -l
HUP INT QUIT ILL TRAP ABRT IOT BUS FPE KILL USR1 SEGV USR2 PIPE ALRM TERM
STKFLT CHLD CONT STOP TSTP TTIN TTOU URG XCPU XFSZ VTALRM PROF WINCH IO PWR SYS
UNUSED
[root@jfht ~]#

示例二
[root@jfht ~]# killall tail
[root@jfht ~]# killall tail
tail: no process killed
[root@jfht ~]#

示例三
这个例子展示怎样把所有的登录后的shell给杀掉，因为有些bash实际上已经没有终端相连接了。

[root@jfht ~]# w
21:56:35 up 452 days,  5:16,  3 users,  load average: 0.05, 0.06, 0.01
USER     TTY      FROM              LOGIN@   IDLE   JCPU   PCPU WHAT
root     pts/1    220.112.87.62    21:53    0.00s  0.02s  0.00s w
root     pts/9    220.112.87.62    21:53    2:44   0.02s  0.02s -bash
root     pts/10   220.112.87.62    21:53    3:13   0.01s  0.01s -bash
[root@jfht ~]# killall -9 bash
此bash也被·卡掉了，所以连接丢失了。现在重新连接并登录。


Last login: Mon Apr  4 21:53:23 2011 from 220.112.87.62
[root@jfht ~]# w
21:56:52 up 452 days,  5:16,  1 user,  load average: 0.28, 0.10, 0.02
USER     TTY      FROM              LOGIN@   IDLE   JCPU   PCPU WHAT
root     pts/1    220.112.87.62    21:56    0.00s  0.01s  0.00s w
[root@jfht ~]#


------------------------- linux  查看登录用户 ---------------------------

w 查看当前登录用户
who 也可以查看登录用户

    强制踢人命令格式：pkill -kill -t tty

    解释：

    pkill -kill -t 　踢人命令

    tty　所踢用户的TTY (一般是pts/1 或pts/2)

   如上踢出用户的命令为： pkill -kill -t pts/1

   只有root用户才能踢人，至少我测试的是这样的。如果同时有二个人用root用户登录，任何其中一个可以   踢掉另一个。任何用户都可以踢掉自己-_-
   如何踢掉用终端登陆的用户，如： 
   root     pts/0    :0.0             10:01    0.00s 0.03s 0.00s w
   
   首先用命令查看pts/0的进程号，命令如下：
   [root@Wang ~]# ps -ef | grep pts/0

   root     15846 15842 0 10:04 pts/0    00:00:00 bash
   root     15876 15846 0 10:06 pts/0    00:00:00 ps -ef
   root     15877 15846 0 10:06 pts/0    00:00:00 grep pts/0
   踢掉用户的命令：

   kill -9 15846 (bash那一列)

   http://blog.chinaunix.net/uid-639516-id-2692539.html


------------------------- linux  ps -ef 进程查看 ---------------------------


https://blog.csdn.net/x_i_y_u_e/article/details/38708481

PS是LINUX下最常用的也是非常强大的进程查看命令

//以下这条命令是检查java 进程是否存在.
ps -ef |grep java

下面对命令选项进行说明：
-e 显示所有进程。
-f 全格式。
ps e 列出程序时，显示每个程序所使用的环境变量。
ps f 用ASCII字符显示树状结构，表达程序间的相互关系
-e : 在命令执行后显示环境
　　-f : 完整显示输出
•        标为 C 的列是由 CPU 用于计算执行优先级的因子。 
•        STIME 是指进程的启动时间。 
•        问号表示这些进程不属于任何 TTY，因为它们是由系统启动的。


------------------------- linux  ps -ef 命令格式详解 ---------------------------


1) 进程用户ID（UID），
虽然 uid 通常是指数字型的标识，但在第一列下指定的是用户名，标记为 UID
2) 进程ID （PID）
3) 父进程ID （PPID）
PPID 是父进程的标识号。对于 Oracle 进程，这里的标识号为 1 — 它是 init 进程（所有进程的父进程）的 id，因为在本系统中安装的 Oracle 是作为登录进程的一部分而启动的
4) CPU 调度情况 （C）
即是是由 CPU 用于计算执行优先级的因子。
5) 进程启动的时间 （STIME） 
6) 进程共占用CPU的时间（TIME） 
7) 启动进程的命令 （CMD） 
8）问号表示这些进程不属于任何 TTY，因为它们是由系统启动的。

使用PS命令分析系统性能的方法主要有： 
1) 首先，根据用户ID寻找由同一用户执行的许多相似任务，这些任务很可能是因为用户运行的某个脚本程序在后台启动多个进程而造成的。 
2) 接下来，检查TIME域中各进程累计占用CPU的时间，如果有某个进程累计占用了大量的CPU时间，通常说明该进程可能陷入了无限循环，或该京城的某写逻辑出了错 
3) 找到那些已陷入死锁的进程ID后，就可以使用kill命令强制终止该进程了。 


------------------------- linux  ps 五种进程状态 ---------------------------

linux上进程有5种状态: 
1. 运行(正在运行或在运行队列中等待) 
2. 中断(休眠中, 受阻, 在等待某个条件的形成或接受到信号) 
3. 不可中断(收到信号不唤醒和不可运行, 进程必须等待直到有中断发生) 
4. 僵死(进程已终止, 但进程描述符存在, 直到父进程调用wait4()系统调用后释放) 
5. 停止(进程收到SIGSTOP, SIGSTP, SIGTIN, SIGTOU信号后停止运行运行)


ps工具标识进程的5种状态码: 
D 不可中断 uninterruptible sleep (usually IO) 
R 运行 runnable (on run queue) 
S 中断 sleeping 
T 停止 traced or stopped 
Z 僵死 a defunct (”zombie”) process



------------------------- linux  ps au(x) 输出格式 :： ---------------------------

名称：ps 
使用权限：所有使用者 
使用方式：ps [options] [--help] 
说明：显示瞬间行程 (process) 的动态 
参数： 
ps 的参数非常多, 在此仅列出几个常用的参数并大略介绍含义 
-A 列出所有的行程 
-w 显示加宽可以显示较多的资讯 
-au 显示较详细的资讯 
-aux 显示所有包含其他使用者的行程

USER PID %CPU %MEM VSZ RSS TTY STAT START TIME COMMAND 
USER: 行程拥有者 
PID: pid 
%CPU: 占用的 CPU 使用率 
%MEM: 占用的记忆体使用率 
VSZ: 占用的虚拟记忆体大小 
RSS: 占用的记忆体大小 
TTY: 终端的次要装置号码 (minor device number of tty) 
STAT: 该行程的状态: 
D: 不可中断的静止 
R: 正在执行中 
S: 静止状态 
T: 暂停执行 
Z: 不存在但暂时无法消除 
W: 没有足够的记忆体分页可分配 
<: 高优先序的行程 
N: 低优先序的行程 
L: 有记忆体分页分配并锁在记忆体内 (即时系统或捱A I/O) 
START: 行程开始时间 
TIME: 执行的时间 
COMMAND:所执行的指令

------------------------- linux  ps 具体命令解释如下： ---------------------------


具体命令解释如下： 
　　1）ps a 显示现行终端机下的所有程序，包括其他用户的程序。

　　2）ps -A 显示所有程序。

　　3）ps c 列出程序时，显示每个程序真正的指令名称，而不包含路径，参数或常驻服务的标示。

　　4）ps -e 此参数的效果和指定"A"参数相同。  例如：  ps -e|grep sshd

　　5）ps e 列出程序时，显示每个程序所使用的环境变量。

　　6）ps f 用ASCII字符显示树状结构，表达程序间的相互关系。

　　7）ps -H 显示树状结构，表示程序间的相互关系。

　　8）ps -N 显示所有的程序，除了执行ps指令终端机下的程序之外。

　　9）ps s 采用程序信号的格式显示程序状况。

　　10）ps S 列出程序时，包括已中断的子程序资料。

　　11）ps -t<终端机编号>

　　指定终端机编号，并列出属于该终端机的程序的状况。

　　12）ps u

　　以用户为主的格式来显示程序状况。

　　13）ps x

　　显示所有程序，不以终端机来区分。

　　最常用的方法是ps -aux,然后再利用一个管道符号导向到grep去查找特定的进程,然后再对特定的进程进行操作。

------------------------- linux  top命令 ---------------------------

查看多核CPU命令
mpstat -P ALL  和  sar -P ALL


https://blog.csdn.net/x_i_y_u_e/article/details/38708481


Ps 只为您提供当前进程的快照。要即时查看最活跃的进程，可使用 top。 

Top 实时地提供进程信息。它还拥有交互式的状态，允许用户输入命令，如 n 后面跟有 5 或 10 等数字。其结果是指示 top 显示 5 或 10 个最活跃的进程。 Top 持续运行，直到您按 "q" 退出 top 为止。 
Top中的几个隐含参数： 
top中按1键和F键的参数： 
按1键可以等到多个cpu的情况 
按F(f:当前状态，可以按相应的字母键做top的定制输出)后得参数： 
对F键和f键的区别： 
如果进入F键区可以做进程显示的排序，如果进入f键区的话则可以选择显示的多个项目: 
* A: PID        = Process Id                //进程ID          
  b: PPID       = Parent Process Pid        //父进程ID          
  c: RUSER      = Real user name            //真正的(Real)所属用户名称          
  d: UID        = User Id                   //用户ID          
  e: USER       = User Name                 //用户名称          
  f: GROUP      = Group Name             //组名称 
  g: TTY        = Controlling Tty           //控制          
  h: PR         = Priority                  //优先权          
  i: NI         = Nice value                //优先级得值(负数代表较高的优先级,正数是较低的优先级.0标志改优先级的值是不会被调整的)          
  j: #C         = Last used cpu (SMP)       //随后使用的cpu比率          
  k: %CPU       = CPU usage                 //cpu使用比率          
  l: TIME       = CPU Time                  //cpu占用时间          
  m: TIME+      = CPU Time, hundredths     //cpu%比 
  n: %MEM       = Memory usage (RES)        //内存使用率 
  o: VIRT       = Virtual Image (kb)        //虚拟镜像(VIRT = SWAP + RES:所有进程使用的虚拟内存值,包括所有的代码,数据,共享库已经被swapped out的) 
  p: SWAP       = Swapped size (kb)     //交换空间大小(所有虚拟内存中的镜像) 
  q: RES        = Resident size (kb)        //已经使用了的常驻内存(Resident size):RES = CODE + DATA 
  r: CODE       = Code size (kb)            //分配给执行代码的物理内存 
  s: DATA       = Data+Stack size (kb)      //data+stack:物理内存中非存放代码的空间,用于存放数据 
  t: SHR        = Shared Mem size (kb)      //共享内存大小.放映了一个task的潜在可以供别人使用的内存的大小 
  u: nFLT       = Page Fault count          //内存叶错误的数量 
  v: nDRT       = Dirty Pages count         //脏页的数量 
  w: S          = Process Status            //进程状态:( R )为运行或可执行的,( S )为该程序正在睡眠中,( T )正在侦测或者是停止了,( Z )僵尸程序 
  x: COMMAND    = Command name/line         //进程启动命令行参数 
  y: WCHAN      = Sleeping in Function      //在睡眠中 
  z: Flags      = Task Flags <sched.h>      //任务标志 
Note1: 
If a selected sort field can't be  shown due to screen width or your  field order, the '<' and '>' keys    
will be unavailable until a field  within viewable range is chosen.      
                                              
Note2:                                        
Field sorting uses internal values,  not those in column display.  Thus,  the TTY & WCHAN fields will violate  strict ASCII collating sequence.   (shame on you if WCHAN is chosen)    
                                              
Current Fields:  AEHIOQTWKNMbcdfgjplrsuvyzX  for window 1:Def 
Toggle fields via field letter, type any other key to return 
* A: PID        = Process Id 
* E: USER       = User Name 
* H: PR         = Priority 
* I: NI         = Nice value 
* O: VIRT       = Virtual Image (kb) 
* Q: RES        = Resident size (kb) 
* T: SHR        = Shared Mem size (kb) 
* W: S          = Process Status 
* K: %CPU       = CPU usage 
* N: %MEM       = Memory usage (RES) 
* M: TIME+      = CPU Time, hundredths 
  b: PPID       = Parent Process Pid 
  c: RUSER      = Real user name 
  d: UID        = User Id 
  f: GROUP      = Group Name 
  g: TTY        = Controlling Tty 
  j: #C         = Last used cpu (SMP) 
  p: SWAP       = Swapped size (kb) 
  l: TIME       = CPU Time 
  r: CODE       = Code size (kb) 
  s: DATA       = Data+Stack size (kb) 
  u: nFLT       = Page Fault count 
  v: nDRT       = Dirty Pages count 
  y: WCHAN      = Sleeping in Function 
  z: Flags      = Task Flags <sched.h> 
* X: COMMAND    = Command name/line 

Flags field: 
  0x00000001  PF_ALIGNWARN 
  0x00000002  PF_STARTING 
  0x00000004  PF_EXITING 
  0x00000040  PF_FORKNOEXEC 
  0x00000100  PF_SUPERPRIV 
  0x00000200  PF_DUMPCORE 
  0x00000400  PF_SIGNALED 
  0x00000800  PF_MEMALLOC 
  0x00002000  PF_FREE_PAGES (2.5) 
  0x00008000  debug flag (2.5) 
  0x00024000  special threads (2.5) 
  0x001D0000  special states (2.5) 
  0x00100000  PF_USEDFPU (thru 2.4)


------------------------- linux  alias命令 ---------------------------

家目录 .bashrc   添加  alias ll='ls -l'



------------------------- linux  星期和月份缩写 ---------------------------

一月份＝JAN.   Jan.=January
二月份＝FEB.   Feb.=February
三月份＝MAR.   Mar.=March 
四月份＝APR.   Apr.=April 
五月份＝MAY    May=May
六月份＝JUN.   Jun.=June
七月份＝JUL.   Jul.=July
八月份＝AUG.   Aug.=August 
九月份＝SEP.   Sept.=September
十月份＝OCT.   Oct.=October
十一月份＝NOV. Nov.=November
十二月份＝DEC. Dec.=December



星期一： Mon.=Monday 
星期二： Tues.=Tuesday 
星期三： Wed.=Wednesday 
星期四： Thur.=Thursday 
星期五： Fri.=Friday 
星期六： Sat.=Saturday 
星期天： Sun.=Sunday

------------------------- linux  shell 命令 ---------------------------


-e filename 如果 filename存在，则为真
-d filename 如果 filename为目录，则为真 
-f filename 如果 filename为常规文件，则为真
-L filename 如果 filename为符号链接，则为真
-r filename 如果 filename可读，则为真 
-w filename 如果 filename可写，则为真 
-x filename 如果 filename可执行，则为真
-s filename 如果文件长度不为0，则为真
-h filename 如果文件是软链接，则为真
filename1 -nt filename2 如果 filename1比 filename2新，则为真。
filename1 -ot filename2 如果 filename1比 filename2旧，则为真。

-eq 等于
-ne 不等于
-gt 大于
-ge 大于等于
-lt 小于
-le 小于等于



------------------------ linux 源码安装  ------------------------
 
 安装前需要提前安装 gcc 和 autoconfig
sudo ./configure --prefix=/www/...  指定到文件夹下   使用 ./configure --help 查看具体参数设置
示例如下
(sudo ./configure --prefix=/usr/local/php7 \
--enable-fpm \
--with-config-file-path=/usr/local/php7/etc \  
--with-iconv=/usr/local/lib/libiconv \)
sudo make
sudo make install

------------------------ linux 编译安装gd库  ------------------------

$ cd /root/software/php-5.6.5  进入编译的安装下载的包 (php包)
$ cd ext/gd //进入gd文件夹
$ /usr/local/php/bin/phpize  使用现在的php版本phpize生成 configure 文件
$ ./configure --with-php-config=你的php路径/php/bin/php-config --with-png-dir --with-freetype-dir --with-jpeg-dir --with-gd
$ make
$ make install

加入php.ini  extension=gd 

------------------------ linux pgrep  ------------------------

pgrep(选项)(参数)

-o：仅显示找到的最小（起始）进程号；
-n：仅显示找到的最大（结束）进程号；
-l：显示进程名称；
-P：指定父进程号；
-g：指定进程组；
-t：指定开启进程的终端；
-u：指定进程的有效用户ID。

pgrep -l  php

------------------------ linux pgrep  ------------------------


可以使用 ps aft | grep tcp.php 查看所有该文件产生的进程

pkill php  杀死所有php 的进程


------------------------ linux 查看python版本和shell版本  ------------------------

查看 shell

cat /etc/shells  查看系统安装了那些bash shell

bash -version 查看系统shell版本

cat /bin/*sh  查看所有的shell


查看 python 

python -V  查看Python 版本

------------------------ linux wget  ------------------------



wget命令用来从指定的URL下载文件。wget非常稳定，它在带宽很窄的情况下和不稳定网络中有很强的适应性，如果是由于网络的原因下载失败，wget会不断的尝试，直到整个文件下载完毕。如果是服务器打断下载过程，它会再次联到服务器上从停止的地方继续下载。这对从那些限定了链接时间的服务器上下载大文件非常有用。

语法
wget(选项)(参数)
选项
-a<日志文件>：在指定的日志文件中记录资料的执行过程；
-A<后缀名>：指定要下载文件的后缀名，多个后缀名之间使用逗号进行分隔；
-b：进行后台的方式运行wget；
-B<连接地址>：设置参考的连接地址的基地地址；
-c：继续执行上次终端的任务；
-C<标志>：设置服务器数据块功能标志on为激活，off为关闭，默认值为on；
-d：调试模式运行指令；
-D<域名列表>：设置顺着的域名列表，域名之间用“，”分隔；
-e<指令>：作为文件“.wgetrc”中的一部分执行指定的指令；
-h：显示指令帮助信息；
-i<文件>：从指定文件获取要下载的URL地址；
-l<目录列表>：设置顺着的目录列表，多个目录用“，”分隔；
-L：仅顺着关联的连接；
-r：递归下载方式；
-nc：文件存在时，下载文件不覆盖原有文件；
-nv：下载时只显示更新和出错信息，不显示指令的详细执行过程；
-q：不显示指令执行过程；
-nh：不查询主机名称；
-v：显示详细执行过程；
-V：显示版本信息；
--passive-ftp：使用被动模式PASV连接FTP服务器；
--follow-ftp：从HTML文件中下载FTP连接文件。
参数
URL：下载指定的URL地址。

实例
使用wget下载单个文件

wget http://www.linuxde.net/testfile.zip
以下的例子是从网络下载一个文件并保存在当前目录，在下载的过程中会显示进度条，包含（下载完成百分比，已经下载的字节，当前下载速度，剩余下载时间）。

下载并以不同的文件名保存

wget -O wordpress.zip http://www.linuxde.net/download.aspx?id=1080
wget默认会以最后一个符合/的后面的字符来命令，对于动态链接的下载通常文件名会不正确。

错误：下面的例子会下载一个文件并以名称download.aspx?id=1080保存:

wget http://www.linuxde.net/download?id=1
即使下载的文件是zip格式，它仍然以download.php?id=1080命令。

正确：为了解决这个问题，我们可以使用参数-O来指定一个文件名：

wget -O wordpress.zip http://www.linuxde.net/download.aspx?id=1080
wget限速下载

wget --limit-rate=300k http://www.linuxde.net/testfile.zip
当你执行wget的时候，它默认会占用全部可能的宽带下载。但是当你准备下载一个大文件，而你还需要下载其它文件时就有必要限速了。

使用wget断点续传

wget -c http://www.linuxde.net/testfile.zip
使用wget -c重新启动下载中断的文件，对于我们下载大文件时突然由于网络等原因中断非常有帮助，我们可以继续接着下载而不是重新下载一个文件。需要继续中断的下载时可以使用-c参数。

使用wget后台下载

wget -b http://www.linuxde.net/testfile.zip

Continuing in background, pid 1840.
Output will be written to `wget-log'.
对于下载非常大的文件的时候，我们可以使用参数-b进行后台下载，你可以使用以下命令来察看下载进度：

tail -f wget-log
伪装代理名称下载

wget --user-agent="Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16" http://www.linuxde.net/testfile.zip
有些网站能通过根据判断代理名称不是浏览器而拒绝你的下载请求。不过你可以通过--user-agent参数伪装。

测试下载链接

当你打算进行定时下载，你应该在预定时间测试下载链接是否有效。我们可以增加--spider参数进行检查。

wget --spider URL
如果下载链接正确，将会显示:

Spider mode enabled. Check if remote file exists.
HTTP request sent, awaiting response... 200 OK
Length: unspecified [text/html]
Remote file exists and could contain further links,
but recursion is disabled -- not retrieving.
这保证了下载能在预定的时间进行，但当你给错了一个链接，将会显示如下错误:

wget --spider url
Spider mode enabled. Check if remote file exists.
HTTP request sent, awaiting response... 404 Not Found
Remote file does not exist -- broken link!!!
你可以在以下几种情况下使用--spider参数：

定时下载之前进行检查
间隔检测网站是否可用
检查网站页面的死链接
增加重试次数

wget --tries=40 URL
如果网络有问题或下载一个大文件也有可能失败。wget默认重试20次连接下载文件。如果需要，你可以使用--tries增加重试次数。

下载多个文件

wget -i filelist.txt
首先，保存一份下载链接文件：

cat > filelist.txt
url1
url2
url3
url4
接着使用这个文件和参数-i下载。

镜像网站

wget --mirror -p --convert-links -P ./LOCAL URL
下载整个网站到本地。

--miror开户镜像下载。
-p下载所有为了html页面显示正常的文件。
--convert-links下载后，转换成本地的链接。
-P ./LOCAL保存所有文件和目录到本地指定目录。
过滤指定格式下载

wget --reject=gif ur
下载一个网站，但你不希望下载图片，可以使用这条命令。

把下载信息存入日志文件

wget -o download.log URL
不希望下载信息直接显示在终端而是在一个日志文件，可以使用。

限制总下载文件大小

wget -Q5m -i filelist.txt
当你想要下载的文件超过5M而退出下载，你可以使用。注意：这个参数对单个文件下载不起作用，只能递归下载时才有效。

下载指定格式文件

wget -r -A.pdf url
可以在以下情况使用该功能：

下载一个网站的所有图片。
下载一个网站的所有视频。
下载一个网站的所有PDF文件。
FTP下载

wget ftp-url
wget --ftp-user=USERNAME --ftp-password=PASSWORD url
可以使用wget来完成ftp链接的下载。

使用wget匿名ftp下载：

wget ftp-url
使用wget用户名和密码认证的ftp下载：

wget --ftp-user=USERNAME --ftp-password=PASSWORD url



------------------------ linux  使用./configure 出错   ------------------------

configure: error: no acceptable C compiler found in $PATH

yum install gcc


tar: bzip2：无法 exec: 没有那个文件或目录

缺少bzip2包
yum install -y bzip2

------------------------ linux  安装 pure-ftpd   ------------------------
下载地址 1.4版本以前  编译之后没有etc文件夹
https://download.pureftpd.org/pure-ftpd/releases/obsolete/

1.4版本以后  编译后有etc文件夹 但是没有configuration-file文件
https://download.pureftpd.org/pure-ftpd/releases/

两种都可以
配置1.

./configure \
--prefix=/www/server/pure-ftp/ \
--without-inetd \
--with-altlog \
--with-puredb \
--with-throttling \
--with-peruserlimits  \
--with-tls

部分解释
./configure \
--prefix=/usr/local/pureftpd \ //pureftpd安装目录

--with-everything \ //安装几乎所有的功能，包括altlog、cookies、throttling、ratios、ftpwho、upload script、virtual users（puredb）、quotas、virtual hosts、directory aliases、external authentication、Bonjour、privilege separation本次安装只使用这个选项。

--with-cookie \ //当用户登录时显示指定的横幅

--with-diraliases \ //支持目录别名，用快捷方式代cd命令

--with-extauth \ //编译支持扩展验证的模块,大多数用户不使用这个选项

--with-ftpwho \ //支持pure-ftpwho命令,启用这个功能需要更多的额外内存

--with-language=english \ //修改服务器语言，默认是英文，如果你要做修改，请翻译‘src/messages_en.h’文件

--with-ldap \   //LADP目录支持，需要安装openldap

--with-minimal \ //FTP最小安装，最基本的功能

--with-mysql \ //MySQL支持，如果MySQL安装在自定义目录上，你需要使用命令—with-mysql=/usr/local/mysq这类

--with-nonroot \   //不需要root用户就可以启动服务




若出现configure: error: OpenSSL headers not found  需 yum install openssl-devel

若出现configure: error: liblber is needed for LDAP support，需安装openldap-devel

若出现configure: error: Your MySQL client libraries aren't properly installed, 需要安装mysql-devel

出现类似configure: error: Your MySQL client libraries aren't properly installed 的错误,请将mysql目录下的 include/mysql下的mysql.h文件以及lib/mysql下的全部文件,连接(直接复制过去或许也可)到 /usr/lib 目录下


mkdir -p  /www/server/ftp/pure-ftpd/ 递归建立文件夹  



------------------------ linux  Centos7找不到 netstat   ------------------------


Centos7发布有一段时间了，最近使用中也发现一些问题，从Centos6换过来后感觉到不少细微的变化

例如默认没有ifconfig和netstat两个命令了，ifconfig其实使用ip addr命令可以代替，

在cenots6下的ss命令可以代替netstat，但是现在的ss和以前的完全是两样 ，还是得装上才行方便查看端口占用和tcp链接攻击等等。

把net-tools包装上就好了。

yum install net-tools

另外centos7引入了systemctl对服务管理，这个的确还是没原来的service好使，php默认5.4, apache默认2.4，此外 Mariadb代替了mysql 

netstat  comman not find
安装 
yum install net-tools




Linux的netstat查看端口是否开放见解（0.0.0.0与127.0.0.1的区别）
 

linux运维都需要对端口开放查看  netstat 就是对端口信息的查看

# netstat -nltp

p 查看端口挂的程序

复制代码
[root@iz2ze5is23zeo1ipvn65aiz ~]# netstat -nltp
Active Internet connections (only servers)
Proto Recv-Q Send-Q Local Address           Foreign Address         State       PID/Program name    
tcp        0      0 0.0.0.0:80              0.0.0.0:*               LISTEN      3346/nginx: master  
tcp        0      0 127.0.0.1:8081          0.0.0.0:*               LISTEN      2493/docker-proxy-c 
tcp        0      0 127.0.0.1:8082          0.0.0.0:*               LISTEN      5529/docker-proxy-c 
tcp        0      0 127.0.0.1:8083          0.0.0.0:*               LISTEN      17762/docker-proxy- 
tcp        0      0 127.0.0.1:8084          0.0.0.0:*               LISTEN      2743/docker-proxy-c 
tcp        0      0 0.0.0.0:22              0.0.0.0:*               LISTEN      2155/sshd    
复制代码
看到 查询的有Local、Address、Foregin、Program name

Local ：访问端口的方式，0.0.0.0 是对外开放端口，说明80端口外面可以访问；127.0.0.1 说明只能对本机访问，外面访问不了此端口；

Address：端口

Foregin Address：对外开放，一般都为0.0.0.0：* 

Program name：此端口是那个程序在用，程序挂载此端口

重点说明 0.0.0.0 是对外开放，通过服务域名、ip可以访问的端口

               127.0.0.1 只能对本机 localhost访问，也是保护此端口安全性

　　　　::: 这三个: 的前两个”::“，是“0:0:0:0:0:0:0:0”的缩写，相当于IPv6的“0.0.0.0”，就是本机的所有IPv6地址，第三个:是IP和端口的分隔符

------------------------ linux  最小化安装 需要安装的软件   ------------------------


1.如果你是基于最小化安装的linux系统，需要执行如下命令，安装必要的库，如果是安装过的可以跳过此步骤

yum -y install wget vim git texinfo patch make cmake gcc gcc-c++ gcc-g77 flex bison file libtool libtool-libs autoconf kernel-devel libjpeg libjpeg-devel libpng libpng-devel libpng10 libpng10-devel gd gd-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glib2 glib2-devel bzip2 bzip2-devel libevent libevent-devel ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel krb5 krb5-devel libidn libidn-devel openssl openssl-devel vim-minimal nano fonts-chinese gettext gettext-devel ncurses-devel gmp-devel pspell-devel unzip libcap diffutils vim lrzsz net-tools

------------------------ linux 宝塔申请https   ------------------------


1.申请的时候要带www的域名  TrustAsia DV SSL CA - G5  第一个证书  会默认申请不带www的证书

申请此证书不许要目录和域名对应  

2.申请免费 let's encrypt 证书 网站目录名必须和域名对应 且域名已经解析到该服务器 

否则会报错 域名未解析

如果还不行 则需要把主域名先绑定到该目录 开启https  然后申请证书

3.网站已经建立过 此时可以新建站点 建立和域名对应的网站名目录  解析绑定之后申请证书 然后将证书文件负责到对应网站开启即可


在未指定SSL默认站点时,未开启SSL的站点使用HTTPS会直接访问到已开启SSL的站点



------------------------ linux nginx wss 端口转发   ------------------------

  location /wss {
      proxy_pass http://127.0.0.1:2345;
      proxy_http_version 1.1;
      proxy_set_header Upgrade $http_upgrade;
      proxy_set_header Connection "Upgrade";
      proxy_set_header X-Real-IP $remote_addr;
  }