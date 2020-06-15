# Linux 命令及常见问题


#### awk
```sh
$ awk sort
    
#$1表示以空格为分割符的第一个匹配项，也就是文件中的ip地址。使用sort对结果排序，uniq -c进行技术，最后sort -n是以“数字”来排序，针对统计后的访问次数来排序
    
$ awk '{print $1}' access.log.1 |sort|uniq -c|sort -n
    
$ awk for     
    
#默认变量为0，对每一行的$1作为key，cnt数组++，实现ip的计数。计数结束后END。然后把结果打印出来，最后sort -n以“数字”排序。
    
$ awk '{cnt[$1]++;}END{for(i in cnt){printf("%s\t%s\n", cnt[i], i);}}' access.log.1|sort -n
```  
### tail -f 时匹配字符串显示颜色

- 单个颜色匹配改变
```sh
$ tail -f ./site.log | perl -pe 's/(Served eth_signTransaction)/\e[1;31m$1\e[0m/g'
```
`Served eth_signTransaction` 为字符串 多个用 | 分隔
`\e[1;31m$1\e[0m`  `31m`为颜色 `$1`为第一个颜色
- 多个颜色匹配改变
```sh
$ tail -f ./site.log | perl -pe 's/(Served eth_signTransaction)|(authentication needed: password or unlock)/\e[1;31m$1\e[0m\e[1;32m$2\e[0m/g'

$ tail -f ./site.log | perl -pe 's/(Served eth_signTransaction)|(authentication needed: password or unlock)|(Failed account unlock attempt)/\e[1;31m$1\e[0m\e[1;32m$2\e[0m\e[1;33m$1\e[0m/g'

```
- 颜色列举
```
30m：黑 
31m：红 
32m：绿 
33m：黄 
34m：蓝 
35m：紫 
36m：青 
37m：白

背景颜色设置：40-47 黑、红、绿、黄、蓝、紫、青、白 
40：黑 
41：红 
42：绿 
43：黄 
44：蓝 
45：紫 
46：青 
47：白
- 例子:
  - 黄字，高亮加粗显示 
[1;33m 
  - 红底黄字，高亮加粗显示 
[1;41;33m
```
(文字资料来源CSND博客-天命ming)[https://blog.csdn.net/qq_27686779/article/details/81180254]

### Linux 死循环

```sh
#!/bin/bash

while(true)
do
  echo 1;
done

```

### pm2启动一个项目

```sh
$ pm2 start "脚本或可执行文件名" --name "别名" -- start .
```



-------------------------

### tail 命令

- 实时查看日志文件
  
       tail -f filepath.log

 - 还可以使用 
    
        watch -d -n 1 cat /var/log/messages 

        -d 表示高亮不同的地方
        -n 表示多少秒刷新一次。 

-------------------------
### netstat

##### 主要用于查看端口

- 查看 TCP 80 是否被监听。
    
       netstat -an | grep 80

       返回以下结果，说明 TCP 80 端口的 Web 服务启动。

       tcp        0      0 0.0.0.0:80      0.0.0.0:*                   LISTEN

-  也可以使用 nmap 来查看对外开放的端口及服务
        
        nmap 127.0.0.1

        #安装nmap
        yum install -y nmap

-----------------------------
### history
- 让history能显示执行的时间  
1. 编辑/etc/bashrc文件，添加以下四行： 

        HISTFILESIZE=2000  
        HISTSIZE=2000  
        HISTTIMEFORMAT='%F %T '  
        export HISTTIMEFORMAT 

 2. `source /etc/bashrc`  重新加载文件即生效

---------------------------
####   sublime gbk 查看中文 
 - 为了解决编码问题，需要安装ConvertToUTF8插件

 - 在下载的时候不能下载 在下面加入即可
`"remote_encoding": "cp1252",`

----------------------------------------------------
### find
- 查找文件
  
      find ./ -type f

- 查找目录

      find ./ -type d

- 查找名字为test的文件或目录
        
      find ./ -name test

- 查找名字符合正则表达式的文件,注意前面的`.*`(查找到的文件带有目录)

      find ./ -regex .*so.*\.gz

- 查找目录并列出目录下的文件(为找到的每一个目录单独执行ls命令，没有选项-print时文件列表前一行不会显示目录名称)

      find ./ -type d -print -exec ls {} \;

- 递归查询目录 `-print`
W
- 查找目录并列出目录下的文件(为找到的每一个目录单独执行ls命令,执行命令前需要确认)

       find ./ -type d -ok ls {} \;

- 查找目录并列出目录下的文件(将找到的目录添加到ls命令后一次执行，参数过长时会分多次执行)
>      find ./ -type d -exec ls {} +
>
>      #查找所有文件 包含 aaaa的  没有文件名
>      find  ./* -type f  -exec cat {} + | grep aaaa
>
>      #查找所有文件包含 s888的文件  含有文件名
>      find ./* -type f -print  | xargs grep "s888." 
>      find ./* -type f   | xargs grep "@eval($_POST" 
>      find ./* -type f   | xargs grep "hzc_root"
>
>      #从根目录开始查找所有扩展名为.log的文本文件，并找出包含”ERROR”的行
>      find / -type f -name "*.log" | xargs grep "ERROR"  
>
###### 配合grep遍历查询
 >     grep -lr 'string' /etc/   进入子目录在所有文件中搜索字符串
 >     -i，乎略大小写
 >     -l，找出含有这个字符串的文件
 >     -r，不放过子目录
 >   
 >     find /www/* -iname “*.php” | xargs grep -H -n "eval(base64_decode"
 >     find /www/* -iname “*.php” | xargs grep -H -n "eval(base64_decode"
 >
 >
 >
- 查找文件名匹配`*.c`的文件

      find ./ -name \*.c

- 打印test文件名后，打印test文件的内容

      find ./ -name test -print -exec cat {} \;

- 不打印test文件名，只打印test文件的内容

      find ./ -name test -exec cat {} \;

- 查找文件更新日时在距现在时刻二天以内的文件

      find ./ -mtime -2

- 查找文件更新日时在距现在时刻二天以上的文件

      find ./ -mtime +2

- 查找文件更新日时在距现在时刻一天以上二天以内的文件
    
      find ./ -mtime 2

- 查找文件更新日时在距现在时刻二分以内的文件
      
      find ./ -mmin -2

- 查找文件更新日时在距现在时刻二分以上的文件

      find ./ -mmin +2

- 查找文件更新日时在距现在时刻一分以上二分以内的文件

      find ./ -mmin 2

- 查找文件更新时间比文件abc的内容更新时间新的文件

      find ./ -newer abc

- 查找文件访问时间比文件abc的内容更新时间新的文件

      find ./ -anewer abc

- 查找空文件或空目录

      find ./ -empty

- 查找空文件并删除

      find ./ -empty -type f -print -delete

- 查找权限为644的文件或目录(需完全符合)

      find ./ -perm 664

- 查找用户/组权限为读写，其他用户权限为读(其他权限不限)的文件或目录

      find ./ -perm -664

- 查找用户有写权限或者组用户有写权限的文件或目录

      find ./ -perm /220
      find ./ -perm /u+w,g+w
      find ./ -perm /u=w,g=w

- 查找所有者权限有读权限的目录或文件

      find ./ -perm -u=r

- 查找用户组权限有读权限的目录或文件

      find ./ -perm -g=r

- 查找其它用户权限有读权限的目录或文件

      find ./ -perm -o=r

- 查找所有者为lzj的文件或目录

      find ./ -user lzj

- 查找组名为gname的文件或目录

      find ./ -group gname

- 查找文件的用户ID不存在的文件

      find ./ -nouser

- 查找文件的组ID不存在的文件

      find ./ -nogroup

- 查找有执行权限但没有可读权限的文件

      find ./ -executable \! -readable

- 查找文件size小于10个字节的文件或目录

      find ./ -size -10c

- 查找文件size等于10个字节的文件或目录

      find ./ -size 10c

- 查找文件size大于10个字节的文件或目录

      find ./ -size +10c

- 查找文件size小于10k的文件或目录

      find ./ -size -10k

- 查找文件size小于10M的文件或目录

      find ./ -size -10M

- 查找文件size小于10G的文件或目录

      find ./ -size -10G

-------------------------
### chattr
- chattr命令的用法：`chattr [ -RVf ] [ -v version ] [ mode ] files…`
- 最关键的是在[mode]部分，[mode]部分是由+-=和[ASacDdIijsTtu]这些字符组合的，这部分是用来控制文件的
属性。

      
       - ：在原有参数设定基础上，移除参数。
      
       = ：更新为指定参数设定。
      
       + ：在原有参数设定基础上，追加参数。
      
       A：文件或目录的 atime (access time)不可被修改(modified), 可以有效预防例如手提电脑磁盘I/O错误的发生。
      
       S：硬盘I/O同步选项，功能类似sync。
      
       a：即append，设定该参数后，只能向文件中添加数据，而不能删除，多用于服务器日志文件安全，只有root才能设定这个属性。
      
       c：即compresse，设定文件是否经压缩后再存储。读取时需要经过自动解压操作。
      
       d：即no dump，设定文件不能成为dump程序的备份目标。
      
       i：设定文件不能被删除、改名、设定链接关系，同时不能写入或新增内容。i参数对于文件 系统的安全设置有很大帮助。
      
       j：即journal，设定此参数使得当通过mount参数：data=ordered 或者 data=writeback 挂 载的文件系统，文件在写入时会先被记录(在journal中)。如果filesystem被设定参数为 data=journal，则该参数自动失效。
      
       s：保密性地删除文件或目录，即硬盘空间被全部收回。
      
       u：与s相反，当设定为u时，数据内容其实还存在磁盘中，可以用于undeletion。
        
###### 各参数选项中常用到的是a和i。

      - a选项强制只可添加不可删除，多用于日志系统的安全设定
      - i是更为严格的安全设定，只有superuser (root) 或具有CAP_LINUX_IMMUTABLE处理能力（标识）的进程能够施加该选项。

##### 应用举例：

1. 用chattr命令防止系统中某个关键文件被修改：

        chattr +i /etc/resolv.conf

        然后用mv /etc/resolv.conf等命令操作于该文件，都是得到Operation not permitted 的结果。
        vim编辑该文件时会提示W10: Warning: Changing a readonly file错误。要想修改此文件就要把i属性去掉： 
        chattr -i /etc/resolv.conf

2. lsattr /etc/resolv.conf

        会显示如下属性
        ----i-------- /etc/resolv.conf

3. 让某个文件只能往里面追加数据，但不能删除，适用于各种日志文件：

        chattr +a /var/log/messages


------------------------
### nmcli

- 要检查网络连接，使用 `sudo nmcli d` 命令。

- 如果断开连接，使用 `sudo nmtui` 编辑连接，选择您的网络接口并选择“自动连接”选项（按空格键），然后选择确定。

- `sudo reboot now` 登录后，执行`ping www.google.com`。

 -------------------------

### Linux 配置静态ip

一. 设置静态ip
1. 立即临时生效，重启后配置丢失
```sh
$ ifconfig ens33 192.168.0.10 netmask 255.255.255.0
$ ifconfig ens33 up
```

2. 重启后生效，重启电脑，IP不会丢失  /etc/sysconfig/network-scripts/ifcfg-ens33
//虚拟机根据情况使用NET模式 
```
DEVICE=ens33
BOOTPROTO=static
TYPE=Ethernet
BROADCAST=192.168.24.2
IPADDR=192.168.24.130
IPV6INIT=yes
IPV6_AUTOCONF=yes
NETMASK=255.255.255.0
GATEWAY=192.168.24.2  //点击NET记住里面的ip网关 填写到此处
ONBOOT=yes
DNS1=8.8.8.8
DNS2=8.8.8.4

```
//如果此处不设置dns无法ping通   name or service not known


二. 此处也要设置  DNS配置文件  /etc/resolv.conf 
```
nameserver 8.8.8.8
nameserver 8.8.4.4
```

三. hostname设置  /etc/sysconfig/network
```
NETWORKING=yes
HOSTNAME=localhost.localdomain
GATWAY=192.168.24.2
```

-------------------------
	

### journalctl查看网络信息 

`journalctl -xe  或 systemctl status network.service `

在虚拟机的环境中，重启网络，命令为
```sh
　　service NetworkManager stop

　　service network restart

　　service NetworkManager start
```

### .swp是什么文件
编辑文件异常退出 出现.swp文件 
.文件名.swp

-------------------

### linux 配置虚拟主机 

      设置dns服务器用于域名解析和上网，但是对于某些特殊的需求我们需要让某个地址解析到特定的地址  
      可以通过编辑 /etc/hosts文件来实现。类型和windows下的主机头一样

      /etc/hosts 修改完就能生效

      127.0.0.1  swoole.host

-------------------

####  du 用法
```sh
#1.输出当前目录下各个子目录所使用的空间 常用
du -h  --max-depth=1

#2.按照空间大小排序
du|sort -nr|more

#3.显示几个文件或目录各自占用磁盘空间的大小，还统计它们的总和
du -c log30.tar.gz log31.tar.gz
```
###### 参数
``` sh
--max-depth=<目录层数> 超过指定层数的目录后，予以忽略

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
```

-------------------

####  rsync 快速删除
``` sh
$ rsync --help | grep delete
    --del                                an alias for --delete-during
    --delete                          delete extraneous files from destination dirs
    --delete-before            receiver deletes before transfer, not during
    --delete-during            receiver deletes during transfer (default)
    --delete-delay              find deletions during, delete after
    --delete-after                receiver deletes after transfer, not during
    --delete-excluded        also delete excluded files from destination dirs
    --ignore-errors            delete even if there are I/O errors
    --max-delete=NUM    don't delete more than NUM files
```

清空目录或文件，如下： 
1. 先建立一个空目录
```sh
$ mkdir /data/blank 
```
2. 用rsync删除目标目录
```sh
$ rsync --delete-before -d -a -H -v --progress --stats /data/blank/ /var/edatacache/
#或者
$ rsync --delete-before -d /data/blank/ /var/edatacache/
```
这样/var/edatacache目录就被快速的清空了。


```
选项说明:

–delete-before 接收者在传输之前进行删除操作
–progress          在传输时显示传输过程
-a                      归档模式，表示以递归方式传输文件，并保持所有文件属性
-H                      保持硬连接的文件
-v                      详细输出模式
–stats                给出某些文件的传输状态
-d                      transfer directories without recursing
```

3. 也可以用来删除大文件

###### 假如我们在/root/下有一个几十G甚至上百G的文件data，现在我们要删除它
```sh
# 创建一个空文件
$ touch /root/empty
# 用rsync清空/root/data文件
$ rsync --delete-before -d --progess --stats /root/empty /root/data
```

------------------------
### linux vim vi中查找字符内容的方法 

查找字符串等 `:/名称`

 
1. 命令模式下输入“/字符串”，例如“/Section 3”。

2. 如果查找下一个，按“n”即可。

要自当前光标位置向上搜索，请使用以下命令：

      /pattern Enter

其中，pattern表示要搜索的特定字符序列。

要自当前光标位置向下搜索，请使用以下命令：

      ?pattern Enter

按下 Enter键后，vi 将搜索指定的pattern，并将光标定位在 pattern的第一个字符处。例如，要向上搜索 place一词，请键入 ：


查找到结果后，如何退出查找呢？输入`:noh`命令 取消搜索。


------------------------
### linux ls  命令 
```sh
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
```
------------------------  
### linux 目录颜色
最后说一下linux下文件的一些文件颜色的含义（默认，颜色在CRT客户端可以修改）
绿色---->代表可执行文件，
红色---->代表压缩文件
深蓝色---->代表目录
浅蓝色----->代表链接文件
灰色---->代表其它的一些文件
```
### linux rwx 文件权限说明
```sh

421 421 421
rwx rwx rwx
读写执
```
------------------------ 
### linux 查看mysql状态 
#mysql进程
ps -ef | grep mysql

#mysql状态
service mysql status

journalctl -xe 错误信息

#查看数据版本信息
cat /www/server/mysql/version.pl

#宝塔数据库日志 在
/www/server/data/用户名.err  文件

#要保证 data  和 mysql 所属组都是 mysql
chown -R mysql.mysql /www/server/data/
chown -R mysql.mysql /www/server/mysql/
------------------------
### linux chmod 修改文件权限
```sh
chmod 改变文件或目录的权限

chmod 755 abc：赋予abc权限rwxr-xr-x

chmod u=rwx，g=rx，o=rx abc：同上u=用户权限，g=组权限，o=不同组其他用户权限

chmod u-x，g+w abc：给abc去除用户执行的权限，增加组写的权限

chmod a+r abc：给所有用户添加读的权限
```
------------------------

### linux ssh连接时间 保持服务器连接 

1. 修改/etc/ssh/sshd_config配置文件,在这个配置文件里，我们需要关注的配置选项有3个，分别是：
```sh
 
TCPKeepAlive yes

ClientAliveInterval 0

ClientAliveCountMax 3

可以看到这三个配置，默认情况下都是被注释起来的。

这3个配置选项的含义分别是：

是否保持TCP连接，默认值是yes。

多长时间向客户端发送一次数据包判断客户端是否在线，默认值是0，表示不发送；

发送连接后如果客户端没有响应，多少次没有响应后断开连接。默认是3次。

第一个 TCPKeepAlive默认值是yes，因此不用修改。需要修改的是下面的两个值，一般情况下的设置是：

ClientAliveInterval  60

ClientAliveCountMax  60

即60s向客户端发送一次数据包，失败60次以后才会断开连接。也就是说如果什么都不操作，长达一个小时的时间才会断开连接。如果你觉得这个时间太短了，你还可以把第二个参数的值改成更大的值，比如说120，240这样的

上和下面这两种情况，不管是修改客户端的配置，还是修改服务端的配置，在修改完成后，都需要重启sshd进程，让对应的配置生效
```

然后重启ssh服务使生效：`service sshd reload `
或者  `/bin/systemctl reload sshd.service`
如果是CentOS 6.x进程，可能就需要使用`/etc/init.d/sshd` 命令来重启了。


2. 客户端修改 修改自己电脑上的配置
找到所在用户的.ssh目录,如root用户该目录在：`~/.ssh/`
在该目录创建config文件 `vi ~/.ssh/config`
加入下面一句：`ServerAliveInterval 60`
 
重启 `/bin/systemctl restart sshd`

保存退出，重新开启root用户的shell，则再ssh远程服务器的时候，不会因为长时间操作断开。应该是加入这句之后，ssh客户端会每隔一段时间自动与ssh服务器通信一次，所以长时间操作不会断开。

3. 此外，除了将这个参数写入配置文件固定起来以外，ssh客户端还支持临时设置这个参数，命令的用法是：

`ssh -o "ServerAliveInterval 60"  ip_address`

ip_address指的是对应的服务器IP，这种情况下，会临时将这个链接设置为`60*60=3600`秒的时间不会出现超时断开的情况。比较适用于公网服务器，不需要修改公网服务器配置

------------------------

### linux 安装swoole运行phpize错误 


- 如果在安装php扩展的时候出现如题的错误：只需到php的安装目录下如：
      
      cd /usr/local/php/php-7.0.4/ext/openssl 
      cp ./config0.m4 ./config.m4 
      即可解决


- 转换证书 cer pem

      openssl x509 -inform DER -in allinpay-pds.cer  -out allinpay-pds.pem
------------------------

### linux 安装swoole config

- configure: error: Cannot find php-config. Please use --with-php-config=PATH

- 一般出现这个错误说明你执行 `./configure` 时  `--with-php-config` 这个参数配置路径错误导致的。
- 查找:
      
      find / -name  php-config
- 修改为：
      
      ./configure --with-php-config=/usr/local/php/bin/php-config

就可以解决问题

- 上面的 /usr/local/php/ 是你的 php 安装路径

------------------------ 
### linux 开放端口
- Centos7以前 可以用iptables命令 Centos以后用firewall

- iptables命令行方式：

       1. 开放端口命令： /sbin/iptables -I INPUT -p tcp --dport 8080 -j ACCEPT

       2. 保存：/etc/rc.d/init.d/iptables save

       3. 重启服务：/etc/init.d/iptables restart

       4. 查看端口是否开放：/sbin/iptables -L -n

          查看端口是否开放：sudo netstat -tnlp | grep 21 如果是linsten状态则是已开启

      开启全部 入方向
      iptables -P INPUT ACCEPT
      开启全部 出方向
      iptables -P OUTPUT ACCEPT
      开启部分端口段

      -A RH-Firewall-1-INPUT -m state --state NEW -m tcp -p tcp --dport 700:800 -j ACCEPT

      一、 700:800 表示700到800之间的所有端口

      二、 :800 表示800及以下所有端口

      三、 700: 表示700以及以上所有端

      开启关闭 iptables
      service iptables stop

Centos7 firewall 

      systemctl stop firewalld.service    服务名字叫做firewalld 不是 iptables (iptables只是centos7中只是命令没有服务)


      配置文件 /etc/firewalld/

      端口规则文件 /etc/firewalld/zones/

      查看版本： firewall-cmd --version

      查看帮助： firewall-cmd --help

      显示状态： firewall-cmd --state  或  systemctl status firewalld.service

      查看所有打开的端口： firewall-cmd --zone=public --list-ports

      更新防火墙规则： firewall-cmd  --reload

      查看区域信息:  firewall-cmd --get-active-zones

      查看指定接口所属区域： firewall-cmd --get-zone-of-interface=eth0

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


出现Failed to start firewalld.service: Unit firewalld.service is masked
尝试卸载
systemctl unmask firewalld.service
再开启
systemctl status firewalld

-------------------

### nginx 代理转发端口
1. 直接转发
  location / {
     proxy_pass  http://localhost:2010;
  }
2. 带cookie发(不会丢失ssession)

  location / {

   proxy_pass   http:// www.baidu.com:8080/;
   proxy_redirect  off;     
   proxy_set_header        Host    $http_host;     
   proxy_set_header        X-Real-IP       $remote_addr;     
   proxy_set_header        X-Forwarded-For $proxy_add_x_forwarded_for;     
   proxy_set_header   Cookie $http_cookie;  
   chunked_transfer_encoding       off;   
}

------------------------ 
### linux 服务器拒绝允许名单  

 - 允许名单: `/etc/hosts.allow`

 - 拒绝名单: `/etc/hosts.deny`


- 编辑允许规则：

      vim /etc/hosts.allow
      #允许主机  
      httpd:192.168.10.
- 拒绝其他所有的主机：

      vim /etc/hosts.deny
      httpd:*
------------------------ 
### linux tail -F 查看动态内容显示行号

命令:
     
      tail -F   FileName | nl

------------------------ 
### linux systemctl 查看服务状态和操作


查看
      
      systemctl status sshd.service

启动
      
      systemctl start sshd.service

重启
      
      systemctl restart sshd.service

自启
      
      systemctl enable sshd.service


------------------------ 
### linux 查看对应端口证书  

      openssl s_client -showcerts -connect smtp.qq.com:455
      openssl s_client -showcerts -connect smtp.qq.com:587



------------------------ 
### linux 查看日志文件保存  

一般日志都在 /var/log/名字(例如:maillog)
或者在 /tmp/log/

------------------------ 
### linux 检查配置  chkconfig命令

      chkconfig sendmail on

      --add：增加所指定的系统服务，让chkconfig指令得以管理它，并同时在系统启动的叙述文件内增加相关数据；
      --del：删除所指定的系统服务，不再由chkconfig指令管理，并同时在系统启动的叙述文件内删除相关数据；
      --level<等级代号>：指定读系统服务要在哪一个执行等级中开启或关毕。

      等级代号列表：

      等级0表示：表示关机
      等级1表示：单用户模式
      等级2表示：无网络连接的多用户命令行模式
      等级3表示：有网络连接的多用户命令行模式
      等级4表示：不可用
      等级5表示：带图形界面的多用户模式
      等级6表示：重新启动


      chkconfig --list             #列出所有的系统服务。
      chkconfig --add httpd        #增加httpd服务。
      chkconfig --del httpd        #删除httpd服务。
      chkconfig --level httpd 2345 on        #设置httpd在运行级别为2、3、4、5的情况下都是on（开启）的状态。
      chkconfig --list               #列出系统所有的服务启动情况。
      chkconfig --list mysqld        #列出mysqld服务设置情况。
      chkconfig --level 35 mysqld on #设定mysqld在等级3和5为开机运行服务，--level 35表示操作只在等级3和5执行，on表示启动，off表示关闭。
      chkconfig `mysqld` on            #设定mysqld在各等级为on，“各等级”包括2、3、4、5等级。


------------------------ 
### linux 查找软件位置  

`whereis oracle`  可以查找文件安装路径

`which oracle`    可以查找文件运行路径

- 列出所有被安装的软件包

      rpm -qa | grep 软件包
      rpm -qa  软件包

- `rpm -q 包名`  如果输出包名则已被安装
- `find / -name 软件包`

- 用yum命令
      
      yum search  软件包

- `yum remove 软件包` 移除软件包

------------------------
### Docker 容器中自启动宝塔应用
```sh
#!/bin/bash
bt=`/etc/init.d/bt status | grep "already running" |wc -l`
if [ $bt -ne 2 ]
then
/etc/init.d/bt start
fi
nginx=`/etc/init.d/nginx status |grep "already running" | wc -l`
if [ $nginx -ne 1 ]
then
/etc/init.d/nginx start
fi
mysql=`/etc/init.d/mysqld status |grep "SUCCESS" | wc -l`
if [ $mysql -ne 1 ]
then
 /etc/init.d/mysqld start
fi

php_72=`/etc/init.d/php-fpm-72 status  |grep "running" | wc -l`
if [ $php_72 -ne 1 ]
then
 /etc/init.d/php-fpm-72 start
fi
php_70=`/etc/init.d/php-fpm-70 status |grep "running" | wc -l`
if [ $php_70 -ne 1 ]
then
 /etc/init.d/php-fpm-70 start
fi
```
------------------------

### linux 配置邮件服务器testsaslauthd可用于代理认证 testsaslauthd输入报错  NO "authentication failed"

`/usr/sbin/testsaslauthd –u user –p ‘password’`
这时总是出错：0: NO "authentication failed"
该怎么办呢？
其实很简单：`vi /etc/sysconfig/saslauthd`
`#MECH=pam`
改成：
`MECH=shadow`
`FLAGS=`
然后重启saslauthd: `service saslauthd restart`
再来测试 `/usr/sbin/testsaslauthd –u myuserid –p ‘mypassword’`  //这里的账号和密码要换成你的linux 的用户名和密码
0: OK "Success."
终于成功了。




------------------------ 
### linux  crontab 
crontab 内置的定时任务
- 定时任务最小能达到1分钟 可以用shell或者python等语音精确到1秒每次
- 
```sh
 crontab -e 编辑定时任务
 crontab -l 表示列出所有的定时任务
 crontab -r 表示删除用户的定时任务，当执行此命令后，所有用户下面的定时任务会被删除
```
------------------------ 

### linux  grep命令 部分转载

#### 选项与参数：
```
grep [-acinv] [--color=auto] '搜寻字符串' filename

-a ：将 binary 文件以 text 文件的方式搜寻数据
-c ：计算找到 '搜寻字符串' 的次数
-i ：忽略大小写的不同，所以大小写视为相同
-n ：顺便输出行号
-v ：反向选择，亦即显示出没有 '搜寻字符串' 内容的那一行
--color=auto ：可以将找到的关键词部分加上颜色的显示
```
<!--more-->


#### grep搜索字符串 常用
- 搜索某个文件里面是否包含字符串，使用
```
grep "查找的文本"  文件名
grep "查找的文本"  ./* 本目录全部文件
```
- 输出文件2中的内容，但是剔除包含在文件1中的内容
```
grep -v -f file1 file2
```
- 精确匹配
```
用grep -w "abc" 或者是grep "\<abc\>"都可以实现
```


#### grep与正规表达式

- 字符类的搜索：如果我想要搜寻 test 或 taste 这两个单字时，可以发现到，其实她们有共通的 't?st' 存在～这个时候，我可以这样来搜寻：
```sh
[root@www ~]# grep -n 't[ae]st' regular_express.txt
8:I can,t finish the test.
9:Oh! The soup taste good.
```

- 字符类的反向选择 [^] ：如果想要搜索到有 oo 的行，但不想要 oo 前面有 g，如下
```sh
[root@www ~]# grep -n '[^g]oo' regular_express.txt
2:apple is my favorite food.
3:Football game is not use feet only.
18:google is the best tools for search keyword.
19:goooooogle yes!
```



#### fgrep 查询
- fgrep 查询速度比grep命令快，但是不够灵活：它只能找固定的文本，而不是规则表达式。

- 如果你想在一个文件或者输出中找到包含星号字符的行
```sh
fgrep  '*' /etc/profile
for i in /etc/profile.d/*.sh ; do

或
grep -F '*' /etc/profile
for i in /etc/profile.d/*.sh ; do
```

------------------------ 

### linux  查看用户属组和用户 id uid 
```sh
$ id  user

$ groups user
```

------------------------ 

### linux 发送邮件  
1. `yum install -y mailx`

2. `vim /etc/mail.rc`
```sh
set from=****@qq.com 邮箱账号 务必和邮箱号一直
set smtp=smtp.qq.com
set smtp-auth-user=****@qq.com 邮箱账号 务必和邮箱号一直
set smtp-auth-password= 客户端授权码
set smtp-auth=login 默认
```
- 发送邮件
```sh
$ echo '111' | mail -s 'localbt1' chinesebigcabbage@163.com
$ cat 1.txt  | mail -s 'localbt' chinesebigcabbage@163.com
或者
$ mail -s 'localbt1' chinesebigcabbage@163.com < 1.txt

#注释
echo '111' 和 cat 1.txt 为邮件内容
mail -s 'localbt' 为邮件标题
chinesebigcabbage@163.com 收件人
```

- 当邮件内容无法识别或者为中文的时候 会转为附件的形式分发出

- qq邮箱不会出现此信息 网易可能会

       如遇：554 DT:SPM 发送的邮件内容包含了未被网易许可的信息，或违背了网易的反垃圾服务条款，可以自己邮箱发给自己！
- 163的配置同理 只要打开邮箱的SMTP服务 获取授权码就能使用

------------------------ 

### linux  命令行上传下载文件  转载
1. sftp
```
建立连接：sftp user@host

从本地上传文件：put localpath

下载文件：get remotepath
```
<!--more-->
- 与远程相对应的本地操作，只需要在命令前加上”l” 即可，方便好记。

例如：`lcd lpwd lmkdir`

2. scp

SCP ：secure copy (remote file copy program) 也是一个基于SSH安全协议的文件传输命令。与sftp不同的是，它只提供主机间的文件传输功能，没有文件管理的功能。

- 复制local_file 到远程目录remote_folder下
```
scp local_file remote_user@host:remote_folder
```
- 复制local_folder 到远程remote_folder（需要加参数 -r 递归）
```
scp –r local_folder remote_user@host:remote_folder
scp -r local_folder remote_ip:remote_folder
```
- 没有指定用户名后续会输入 用户名和密码 指定后只会输入密码

- 以上命令反过来写就是远程复制到本地

例如: 
```
#默认端口端口 -P 22 可不加
$ scp remote_user@host:remote_folder local_folder
$ scp -P 7789 root@172.31.1.22:/www/backup/site/www.baidu.com_20180522_185755.zip  /www/wwwroot/wap.baidu.com/
$ scp -P 7789 root@172.31.1.22:/www/wwwroot/chain/chain.tar.gz  /www/wwwroot/chain
$ scp  root@47.94.81.150:/www/wwwroot/easyswoole/  ./
```
- scp -r 可递归上传文件夹

相关资料：

2.XMODEM、YMODEM、ZMODEM : http://web.cecs.pdx.edu/~rootd/catdoc/guide/TheGuide_226.html

3.Wiki SCP :http://en.wikipedia.org/wiki/Secure_copy

------------------------

### linux  windows商店命令行 保存的本地文件路径 

C:\Users\chine\AppData\Local\Packages\46932SUSE.openSUSELeap42.2_022rs5jcyhyac\LocalState\rootfs\home

------------------------

### linux  解压缩 
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

压缩命令

tar -zcvf ./filename.tar.gz ./* 压缩本文件夹下的所有
```
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

```

-----


### linux  ln 添加软链名称 
```
        目标地址                    添加到命令 php72自定义名字
ln -s   /www/server/php/72/bin/php /usr/bin/php72
```
<!--more-->
也可删除 `/usr/bin/ph`p  重新生成软链 `ln -s   /www/server/php/72/bin/php /usr/bin/php`

`ls -al` 可以查看到 软连指向的路径  `pecl -> /www/server/php/72/bin/pecl`

添加php永久命令
`$ vi /etc/profile`
```
#export PATH=/www/server/php/70/bin:$PATH
#source profile
```
如果需要立即生效的话，可以执行# source profile命令。

命令行输入`export PATH=/www/server/php/70/bin:$PATH `然后回车。这种只是临时有效


-----

### linux  修改添加PATH的三种方法 

备注:如果有多个目录下有相同的命令 以靠前的命令优先起作用
输入 type 命令可检测是哪个命令生效
type php
php is hashed (/www/server/php/72/bin/php)

一:修改添加PATH的三种方法
```
1. PATH=$PATH:/etc/apache/bin

使用这种方法,只对当前会话有效，也就是说每当登出或注销系统以后，PATH 设置就会失效

2. vi /etc/profile

在适当位置添加 PATH=$PATH:/etc/apache/bin (注意：= 即等号两边不能有任何空格)

这种方法最好,除非你手动强制修改PATH的值,否则将不会被改变

3. vi ~/.bash_profile
修改PATH行,把/etc/apache/bin添加进去
这种方法是针对用户起作用的
```
-----
### linux  PATH的优先级  

在Ubuntu中  可以设置环境变量有4个 优先级从高到底

1. /etc/profile:在登录时,操作系统定制用户环境时使用的第一个文件,此文件为系统的每个用户设置环境信息,当用户第一次登录时,该文件被执行。



2. /etc/environment:在登录时操作系统使用的第二个文件,系统在读取你自己的profile前,设置环境文件的环境变量。



3.` ~/.bash_profile `
在登录时用到的第三个文件是.profile文件,每个用户都可使用该文件输入专用于自己使用的shell信息,当用户登录时,该 文件仅仅执行一次!默认情况下,他设置一些环境变游戏量,执行用户的.bashrc文件。/etc/bashrc:为每一个运行bash shell的用户执行此文件.当bash shell被打开时,该文件被读取.



4、`~/.bashrc`:该文件包含专用于你的bash shell的bash信息,当登录时以及每次打开新的shell时,该该文件被读取。



几个环境变量的优先级

1>2>3>4
----
###  linux  linux将命令添加到PATH中 


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
当你发现新增路径`/usr/local/apache/bin`没用或不需要时，你可以在以前修改的`/etc/profile`或`~/.bash_profile`文件中删除你曾今自定义的路径。

如果配置 PATH配置错误了  并且执行了 source /etc/profile
可以直接在命令行执行
export PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin
然后再把配置文件改了

修改之前最好 cp 一份

-------

### linux  vim vi 删除命令 

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


----

### linux  curl post请求 参数为本地文件 

- d参数用于发送 POST 请求的数据体。
- 使用-d参数以后，HTTP 请求会自动加上标头Content-Type : application/x-www-form-urlencoded。并且会自动将请求转为 POST 方法，因此可以省略-X POST

```sh
curl -d @curl.xml http://api.zichends.com/webapi/bank_batch/test
```
- 读取data.txt文件的内容，作为数据体向服务器发送。

------

### linux  变量自增 

Linux Shell中写循环时，常常要用到变量的自增，现在总结一下整型变量自增的方法。
我所知道的，bash中，目前有五种方法：
1. i=`expr $i + 1`;
2. let i+=1;
3. ((i++));
4. i=$[$i+1];
5. i=$(( $i + 1 ))

------

### linux  后台运行进程 

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

$ `appending output to nohup.out`

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

使用了nohup之后，很多人就这样不管了，其实这样有可能在当前账户非正常退出或者结束的时候，命令还是自己结束了。所以在使用nohup命令后台运行命令之后，需要使用exit正常退出当前账户，这样才能保证命令一直在后台运行。

command >out.file 2>&1 &

command>out.file是将command的输出重定向到out.file文件，即输出内容不打印到屏幕上，而是输出到out.file文件中。

2>&1 是将标准出错重定向到标准输出，这里的标准输出已经重定向到了out.file文件，即将标准出错也输出到out.file文件中。最后一个&， 是让该命令在后台执行。

试想2>1代表什么，2与>结合代表错误重定向，而1则代表错误重定向到一个文件1，而不代表标准输出；换成2>&1，&与1结合就代表标准输出了，就变成错误重定向到标准输出.

------

###  linux 磁盘 查看

df -h 查看磁盘和空间

fdisk -l 查看当前磁盘及dev

cat /etc/fstab 查看挂载的磁盘

------

### linux 查看版本信息 

uname -a 详细 -r 内核版本 -s 操作系统

lsb_release -a 查看系统发行信息  -r 发行版本

------

### linux nice 

nice -10 调整进程优先级
renice  -10  调整正在进行的进程优先级

------

### linux  at 只执行一次定时任务  

at  时间
at  now + 1 minutes 执行事件

jobs 查看后台进行的进程

------

### linux  vmstat  

- vmstat命令是最常见的Linux/Unix监控工具，可以展现给定时间间隔的服务器的状态值,包括服务器的CPU使用率，内存使用，虚拟内存 交换情况,IO读写情况。相比top，通过vmstat可以看到整个机器的 CPU,内存,IO的使用情况，而不是单单看到各个进程的CPU使用率和内存使用率。
<!--more-->
##### 运行示例 :
一般vmstat工具的使用是通过两个数字参数来完成的，第一个参数是采样的时间间隔数，单位是秒，第二个参数是采样的次数，如:
```sh
$ vmstat 2 1
procs -----------memory---------- ---swap-- -----io---- -system-- ----cpu----
 r  b   swpd   free   buff  cache   si   so    bi    bo   in   cs us sy id wa
 0  0  97640  53884 192800 578212    0    0     3    20    1   12  1  2 93  3
```
2 表示每个两秒采集一次服务器状态，1表示只采集一次。

实际上，在应用过程中，我们会在一段时间内一直监控，不想监控直接结束vmstat就行了,例如:

$ vmstat 2


------

### linux  对文件大小排序 
```sh
#文件的大小排序--大---小
ll -Sh        
计算文件大小
du -sh              

#计算文件大小  -–max-depth=<目录层数> 超过指定层数的目录后，予以忽略
du -h --max-depth=1 

#文件的大小排序 只显示20行
du -h | sort -hr | head(或tail) -20  
```

------

### linux文件按时间排序 (转)
```sh
ls -alt # 按修改时间排序

ls --sort=time -la # 等价于 ls -alt

ls -alc # 按创建时间排序

ls -alu # 按访问时间排序

```

#### 以上均可使用-r实现逆序排序
```sh
ls -alrt # 按修改时间排序

ls --sort=time -lra # 等价于ls -alrt

ls -alrc # 按创建时间排序

ls -alru # 按访问时间排序

```

------

1：搜索某个文件里面是否包含字符串，使用

grep "查找的文本"  文件名
grep "查找的文本"  ./* 本目录全部文件

### linux  在 Linux 系统中查看 inode  

------

在 Linux 系统中查看 inode 号可使用命令 stat 或 ls -i（若是 AIX 系统，则使用命令 istat）
文件inode号是唯一的 文件名只是方便记忆

-----


### linux  恢复删的的文件

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

--------
### linux 虚拟主机 ECS云服务器 VPS 他们的区别

1. 虚拟主机

虚拟主机就是利用虚拟化的技术，将一台服务器划分出一定大小的空间，每个空间都给予单独的 FTP 权限和 Web 访问权限，多个用户共同平均使用这台服务器的硬件资源。不同配置的虚拟主机主要是在磁盘空间、数据库大小、流量上面的区别。虚拟主机也有可以分为独享的虚拟主机，和共享的虚拟主机。顾名思义，两者之间的区别在于服务器资源的独享和共享。网站主机、空间、都是一个意思。这一类的主机用户的权限很低，没有远程桌面，只有FTP权限供用户上传文档等操作。优势是比较价格便宜。

<!--more-->

2. VPS

先说一下vps，Virtual Private Server 虚拟专用服务器,一般是将一个独立服务器通过虚拟化技术虚拟成多个虚拟专用服务器。与虚拟主机不同的是，你拥有的是一台虚拟的服务器，类似于Windows上的虚拟机一样，虽然是虚拟的，但是使用起来，和使用客户机没有什么区别。同理，VPS可以使用远程桌面登录对服务器进行维护操作。

3. ECS云服务器

现在的主流的服务器解决方案，一般理解云服务器和VPS一样，同样是虚拟化的技术虚拟出来的服务器。也有人说以前的VPS就是现在的ECS，其实不然，云服务器是一个计算，网络，存储的组合。简单点说就是通过多个CPU，内存，硬盘组成的计算池和存储池和网络的组合；在这样的平台上虚拟出的服务器，用户可以根据自己的运算需要选择配置不同的云服务器。具体区别总结如下：

-------

### linux 端口占用查看  

- 需要切换到root用户  
- 专享主机等或godaddy.com买的主机需要 su 切换到root才能看到占用的进程
```sh
#查看80端口占用的程序
lsof -i :80  
#查看所有 lsof -i -p -n
lsof -i 
```
##### 例: nginx端口被占用
nginx: [emerg] bind() to 0.0.0.0:80 failed (98: Address already in use)
```sh
#查看 
lsof -i :80
#强制杀掉
kill -9 PID
#启动服务
service nginx start
```
##### 备注:

如果以上方法 kill不能杀死程序,可使用命令关闭占用80端口的程序

`sudo fuser -k 80/tcp`

-----



### linux  宝塔的域名配置文件及重写规则路径  

www/server/panel/vhost/rewrite/站点名称 站点域名配置
www/server/panel/vhost/vhost/站点名称   站点重写规则配置

----

### nginx  重写规则  

1. 老版 nginx
```
if (!-d $request_filename){
  set $rule_0 1$rule_0;
}
if (!-f $request_filename){
  set $rule_0 2$rule_0;
}
if ($rule_0 = "21"){
  rewrite ^/(.*)$ /index.php/$1 last;
}
```
2. tp5
```
location / {
  if (!-e $request_filename){
    rewrite  ^(.*)$  /index.php?s=$1  last;   break;
  }
}
```
3. laravel5
```
location / {
  try_files $uri $uri/ /index.php$is_args$query_string;
}
```
4. vue前端
```
location ~* \.(eot|otf|ttf|woff)$ {
    add_header Access-Control-Allow-Origin *;
}
location /{
    if (!-e $request_filename){

        rewrite  ^/(.*)$  /index.html  last;
    }
}
```
5. apache
```
<IfModule mod_rewrite.c>
  Options +FollowSymlinks
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
```
如果出现
`No input file specified.`，是没有得到有效的文件路径造成的。
修改后的伪静态规则，如下：
```
<IfModule mod_rewrite.c>
  Options +FollowSymlinks
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php?/$1 [QSA,PT,L]
</IfModule>
```
在正则结果`/$1`前面多加了一个`?`号

-------------------------

### linux  杀掉进程的几个方式 kill killall pkill xkill

[转载-点击跳转](http://os.51cto.com/art/200910/158639.htm)
1. kill ［信号代码］ 进程ID
```
#强制终止退出
kill -9 来

#特殊用法
#发送SIGSTOP (17,19,23)停止一个进程，而并不linux杀死进程。
kill -STOP [pid]

#发送SIGCONT (19,18,25)重新开始一个停止的进程。
kill -CONT [pid]

#发送SIGKILL (9)强迫进程立即停止，并且不实施清理操作。
kill -KILL [pid]

#终止你拥有的全部进程。
kill -9 -1
```
2. killall
```
作用：通过程序的名字，直接杀死所有进程
用法：killall 正在运行的程序名
举例：
[root@localhost beinan]# pgrep -l gaim 2979 gaim
[root@localhost beinan]# killall gaim
注意：该命令可以使用 -9 参数来强制杀死进程
```
3. pkill

```
作用：通过程序的名字，直接杀死所有进程
用法：#pkill 正在运行的程序名
$ pgrep -l gaim 
  输出:2979 gaim
$ pkill gaim

$ps aft | grep tcp.php 查看所有该文件产生的进程

$pkill php  杀死所有php 的进程

$pkill -u user 杀死所有该用户下面的进程
```
4. xkill

```
作用：杀死桌面图形界面的程序。
应用情形实例：firefox出现崩溃不能退出时，点鼠标就能杀死firefox 。
当xkill运行时出来和个人脑骨的图标，哪个图形程序崩溃一点就OK了。
如果您想终止xkill ，就按右键取消；
调用方法：
[root@localhost ~]# xkill
```

---------------------------

### linux 查看登录用户/踢人下线 

- w 查看当前登录所有用户(who)

- 强制下线的命令 
    ```
    pkill -kill -t tty

    tty　所踢用户的TTY (一般是pts/1 或pts/2)

    #如上踢出用户的命令为
    pkill -kill -t pts/1
    ```
- 只有root用户才能踢人，用户都可以踢掉自己

   首先用命令查看pts/0的进程号，命令如下：
   ```
   [root@Wang ~]# ps -ef | grep pts/0
   root     15846 15842 0 10:04 pts/0    00:00:00 bash
   root     15876 15846 0 10:06 pts/0    00:00:00 ps -ef
   root     15877 15846 0 10:06 pts/0    00:00:00 grep pts/0
   ```
   踢掉用户的命令：
   `kill -9 15846 (bash那一列)`

   [转载-点击跳转](http://blog.chinaunix.net/uid-639516-id-2692539.html)

---------------------------


### 常用的ps命令

`ps aux | grep 进程名`

#### linux  ps 五种进程状态 

linux上进程有5种状态:
1. 运行(正在运行或在运行队列中等待)
2. 中断(休眠中, 受阻, 在等待某个条件的形成或接受到信号)
3. 不可中断(收到信号不唤醒和不可运行, 进程必须等待直到有中断发生)
4. 僵死(进程已终止, 但进程描述符存在, 直到父进程调用wait4()系统调用后释放)
5. 停止(进程收到SIGSTOP, SIGSTP, SIGTIN, SIGTOU信号后停止运行运行)

```
ps工具标识进程的5种状态码:
D 不可中断 uninterruptible sleep (usually IO)
R 运行 runnable (on run queue)
S 中断 sleeping
T 停止 traced or stopped
Z 僵死 a defunct (”zombie”) process

```

---------------------------

#### linux  ps au(x) 输出格式 

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
```
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
```

---------------------------



### linux  查看多核CPU命令 

- 查看多核CPU命令
`mpstat -P ALL  和  sar -P ALL`

---------------------------

### linux  alias命令 


家目录 `.bashrc`   添加  `alias ll='ls -l'`

---------------------------


### linux  星期和月份缩写 

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

---------------------------

### linux pgrep  

pgrep(选项)(参数)

-o：仅显示找到的最小（起始）进程号；
-n：仅显示找到的最大（结束）进程号；
-l：显示进程名称；
-P：指定父进程号；
-g：指定进程组；
-t：指定开启进程的终端；
-u：指定进程的有效用户ID。

- 获取php的进程名和进程号
pgrep -l  php 

---------------------------

### linux 系统shell查看

- 查看 shell

`cat /etc/shells`  查看系统安装了那些`bash shell`

`bash -version` 查看系统shell版本

`cat /bin/*sh ` 查看所有的shell

---------------------------


### linux  安装 pure-ftpd 
##### 选择下载地址  
-  1.4版本以前  编译之后没有etc文件夹
[进入下载页面](https://download.pureftpd.org/pure-ftpd/releases/obsolete)

- 1.4版本以后  编译后有etc文件夹 但是没有configuration-file文件
[进入下载页面](https://download.pureftpd.org/pure-ftpd/releases/)

- 无论下载哪个都可以使用
##### 配置
<!--more-->
```sh
./configure \
--prefix=/www/server/pure-ftp/ \
--without-inetd \
--with-altlog \
--with-puredb \
--with-throttling \
--with-peruserlimits  \
--with-tls
```
##### 部分解释
```
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
```
##### 可能出现的error
```
若出现configure: error: OpenSSL headers not found  需 yum install openssl-devel

若出现configure: error: liblber is needed for LDAP support，需安装openldap-devel

若出现configure: error: Your MySQL client libraries aren't properly installed, 需要安装mysql-devel

出现类似configure: error: Your MySQL client libraries aren't properly installed 的错误,请将mysql目录下的 include/mysql下的mysql.h文件以及lib/mysql下的全部文件,连接(直接复制过去或许也可)到 /usr/lib 目录下

```

`mkdir -p  /www/server/ftp/pure-ftpd/` 递归建立文件夹


------------------------

### linux ftp 主动模式和被动模式  

- 被动模式端口设置
pure-ftpd.conf 文件中  (此处为pure-ftpd软件)
PassivePortRange          39000 40000

- 被动和主动都需要 21
- 20是主动模式传输数据用的

>他们都需要先通过21端口连接认证服务器
由客户端发起 当由公网ip直接发起的 而不是路由器后的ip发起的为主动模式
主动传输通过20端口 被动通过设置的被动端口传输 端口号不得小于1024
在传输完成后需要再通过21端口进行一次认证

- fpt的种类

>ftp(普通)   
ftps(ssl加密)     
sftp(ssh传输协议)


------------------------



### linux  最小化安装 需要安装的软件   


- 如果你是基于最小化安装的linux系统，需要执行如下命令，安装必要的库，如果是安装过的可以跳过此步骤
```
yum -y install wget vim git texinfo patch make cmake gcc gcc-c++ gcc-g77 flex bison file libtool libtool-libs autoconf kernel-devel libjpeg libjpeg-devel libpng libpng-devel libpng10 libpng10-devel gd gd-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glib2 glib2-devel bzip2 bzip2-devel libevent libevent-devel ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel krb5 krb5-devel libidn libidn-devel openssl openssl-devel vim-minimal nano fonts-chinese gettext gettext-devel ncurses-devel gmp-devel pspell-devel unzip libcap diffutils vim lrzsz net-tools
```

----------------


### linux 宝塔申请https注意事项   


1. 申请的时候要带www的域名  TrustAsia DV SSL CA - G5  第一个证书  会默认申请不带www的证书

申请此证书不许要目录和域名对应
<!--more-->
2. 申请免费 let's encrypt 证书 网站目录名必须和域名对应 且域名已经解析到该服务器

否则会报错 域名未解析

如果还不行 则需要把主域名先绑定到该目录 开启https  然后申请证书

3. 网站已经建立过 此时可以新建站点 建立和域名对应的网站名目录  解析绑定之后申请证书 然后将证书文件负责到对应网站开启即可

- 在未指定SSL默认站点时,未开启SSL的站点使用HTTPS会直接访问到已开启SSL的站点


----------------


### linux nginx wss 端口转发  

  location /wss {
      proxy_pass http://127.0.0.1:2345;
      proxy_http_version 1.1;
      proxy_set_header Upgrade $http_upgrade;
      proxy_set_header Connection "Upgrade";
      proxy_set_header X-Real-IP $remote_addr;
  }


----------------


### Linux 服务器基本信息查看   


####  linux信息查询
1.  查看磁盘和空间 `df -h`

2.  查看当前磁盘及dev `fdisk -l`

3.  查看挂载的磁盘 `cat /etc/fstab`

<!--more-->
4. 查看版本信息 
    uname 
    -a 详细 
    -r 内核版本 
    -s 操作系统
5. 查看系统发行信息   `lsb_release -a ` -r 发行版本
6. 内存使用情况 free -h 
7. 查看cpu信息 `cat /proc/cpuinfo` 可以数一下cpu的数量 一般显示的都是逻辑cpu 的数量
    参考信息(网上摘抄)
    ```
        显示物理CPU个数

   　　　cat /proc/cpuinfo |grep "physical id"|sort|uniq|wc -l

　　     显示每个物理CPU的个数(核数)

　　　　　cat /proc/cpuinfo |grep "cpu cores"|uniq

　    　 显示逻辑CPU个数

    　　　cat /proc/cpuinfo|grep "processor"|wc -l
        理论上不使用超线程技术的前提下有如下结论:

    　　 物理CPU个数*核数=逻辑CPU个数

        配置服务器的应用时，以逻辑CPU个数为准
    ```
----------------

### linux  sed命令删除或替换内容

`sed [-hnV][-e<script>][-f<script文件>][文本文件]`

1. 删除文件中的某字符串
　　sed -i '/string/d' file.txt

2. 替换指定内容的方法

   sed -i "s/原字符串/新字符串/g" `grep 原字符串 -rl 所在目录`

   sed -i "s/oldString/newString/g"  `grep oldString -rl /path`
  <!--more-->

  补充：

  sed -i "s/oldString/newString/g"  `grep oldString -rl /path`
  对多个文件的处理可能不支持，需要用 xargs变种如下：

  grep oldString -rl /path | xargs sed -i "s/oldString/newString/g"

  例:
  grep "宝足" -rl /mnt/zuapi.ech.com/ | xargs sed -i "s/宝足/案例/g"

  grep "zuweb.yun.com" -rl /mnt/zuweb.ech.com/ | xargs sed -i "s/zuweb.yun.com/zuapi.yun.com/g"

  3. 如果删除一个变量的
　　sed -i '/'"$variable"'/d' file.txt

----------------


### linux  查看cpu占用率  

1. ps命令
ps -aux | sort -k4nr | head -10     查看  %MEM
ps -aux | sort -k3nr | head -10     查看  %CPU
<!--more-->
##### 命令详解：
1. head：-N可以指定显示的行数，默认显示10行。
2. ps：参数a指代all——所有的进程，u指代userid——执行该进程的用户id，x指代显示所有程序，不以终端机来区分。ps -aux的输出格式如下：
    ```
    USER       PID %CPU %MEM    VSZ   RSS TTY      STAT START   TIME COMMAND
    root         1  0.0  0.0  19352  1308 ?        Ss   Jul29   0:00 /sbin/init
    root         2  0.0  0.0      0     0 ?        S    Jul29   0:00 [kthreadd]
    root         3  0.0  0.0      0     0 ?        S    Jul29   0:11 [migration/0]
    ```
3. sort -k4nr中（k代表从根据哪一个关键词排序，后面的数字4表示按照第四列排序；n指代numberic sort，根据其数值排序；r指代reverse，这里是指反向比较结果，输出时默认从小到大，反向后从大到小。）。本例中，可以看到%MEM在第4个位置，根据%MEM的数值进行由大到小的排序。-k3表示按照cpu占用率排序。

2. top工具
命令行输入top回车，然后按下大写M按照memory排序，按下大写P按照CPU排序。


----------------


### linux  >&的用法标准输出和错误输出

1. `2>&1 file`和 `> file 2>&1`区别
2. `cat food 2>&1 >file` 错误输出到终端，标准输出被重定向到文件file。
3. `cat food >file 2>&1` 标准输出被重定向到文件file，然后错误输出也重定向到和标准输出一样，所以也错误输出到文件file。(例如程序错误和sql语句错误等也会输出到文件)

- 备注: `>>`  是追加写入  `> `是覆盖写入
<!--more-->


#### 输出知识

1. 默认地，标准的输入为键盘，但是也可以来自文件或管道（pipe |)
2. 默认地，标准的输出为终端（terminal)，但是也可以重定向到文件，管道或后引号（backquotes `)
3. 默认地，标准的错误输出到终端，但是也可以重定向到文件。
4. 标准的输入，输出和错误输出分别表示为STDIN,STDOUT,STDERR，也可以用0,1,2来表示。
5. 其实除了以上常用的3中文件描述符，还有3~9也可以作为文件描述符。3~9你可以认为是执行某个地方的文件描述符，常被用来作为临时的中间描述符。

----------------

### linux  阿里云ecs CentOS 7 安装图形化桌面

1. 先安装 MATE Desktop
```sh
yum groups install "MATE Desktop"
```
显示complete为完成安装

2. 安装好 MATE Desktop 后，再安装 X Window System。
```sh
yum groups install "X Window System"
```
3. 设置默认通过桌面环境启动服务器：
```shell
systemctl  set-default  graphical.target

systemctl set-default multi-user.target  //设置成命令模式

systemctl set-default graphical.target  //设置成图形模式
```
安装完成后，通过`reboot`等指令重启服务器，或者在 ECS 服务器控制台重启服务器。 通过控制台远程连接


----------------


### linux 通过 yum provides 查找在哪能找到安装源

1. 只适用于centos环境 

`yum provides */lsb_release`

如果展示结果中有可以安装的包那就标识能安装

yum install redhat-lsb-core-4.0-7.el6.centos.x86_64

2. 安装其他软件包也可以使用这个命令来警醒查找然后安装

----------------


### linux  查看服务器外网ip 
```
curl icanhazip.com
curl ifconfig.me
curl curlmyip.com
curl ip.appspot.com
curl ipinfo.io/ip
curl ipecho.net/plain
curl www.trackip.net/i
```

----------------

### linux 一次性安装服务器开发工具

centos
yum groupinstall Development Tools

ubantu
sudo apt-get install -y build-essential

<!--more-->
#### 扩展知识
1. yum grouplist | more 以分组形式列出所有的的包
2. yum grouplist | grep Development 筛选出开发包组
3. yum groupinfo Development tools 列出开发工具包

----------------


### linux uniq 命令
- 参数
```
-c :在每列旁边显示该行重复出现的次数
-d :仅显示重复出现的行列
-f <栏位> :忽略比较指定的栏位
-s <字符位置> :忽略比较指定的字符
-w <字符位置> :指定要比较的字符
-u :仅显示出一次的行列
```

- 统计各行在文件中出现的次数
```sh
sort file.txt | uniq -c  
```
<!--more-->
- 只显示单一行
```sh
uniq -u file.txt  
```
- 在文件中找出重复的行
```sh
sort file.txt | uniq -d  
```
- 删除重复行
```sh
uniq file.txt  
```

----------------

### linux wc 命令 (转)

- wc 命令用来计算数字。利用wc指令我们可以计算文件的Byte数、字数或是列数，若不指定文件名称，或是所给予的文件名为“-”，则wc指令会从标准输入设备读取数据。

语法 wc (选项) (文件)
<!--more-->
```
-c 或 --bytes或——chars：只显示Bytes数
-l 或 ——lines：只显示列数
-w 或 ——words：只显示字数
```

----------------

### linux date 修改时间 


  date -s  7/26/2018 日期
  date -s  16:00:3   时间
  hwclock -w  使重启也能失效 ( 将当前时间写入BIOS永久生效（避免重启后失效）)

----------------

### linux nslookup 查询 

查询域名的解析地址 如果有多个会返回多个

cmd命令  nslookup进入命令输入
输入域名 返回信息

----------------

### 登录亚马逊aws方法
- 创建aws ec2会给一个秘钥文件 
- `chmod 400 filename.pem` 修改秘钥为不可见才能使用
- 连接 ssh -i "filename.pem" ubuntu@ec2-54-183-119-93.us-west-1.compute.amazonaws.com


#### aws使用密码登录

- 亚马逊aws ec2 为了安全起见是禁止密码登录 在创建主机的时候会给出.pem文件 登录也是使用此文件登录
- 如果想使用密码登录 需要登录上之后设置以下内容  vim /etc/ssh/sshd_config
- 
  1.  先切换到root `su root` (如果不行使用 sudo su切换成root用户 无需使用密码)
  2. `PasswordAuthentication no` 改成 `yes`
  3. `PermitRootLogin no` 改成`yes` 此为允许root用户登录 也可以不加 使用其他用户登录 使用过哪个用户登录就修改哪个用户的密码
  4. `passwd root` 设置root密码
  5. service sshd restart 重新启动sshd服务
- 注意事项 初次使用aws需要注意他们的初始用户是系统名 比如 `centos`用户名 就是 centos `ubuntu`就是ubuntu 



#### AWS使用注意事项 

EC2 没有中国区域 可选择东京(在右上角)  选择配置的时候注意加磁盘空间 默认8G

CDN cloudFront  服务  加速静态资源
第一个origin domain 是源地址用于获取资源 解析到原服务器地址
第二个 Alternate Domain Names (CNAMEs) 填写域名可用于域名转接相当于系统生成的域名被替换为此域名  解析的时候也是将cname值解析到此域名上

有白名单和黑名单选项 但是只能选一个  只允许白名单访问 或者只拒绝黑名单

上面是web的访问源  也可以用亚马逊S3服务将资源传到S3  第一个origin domain 就需要选择此S3路径下面不变



------------------------


###  在AWS亚马逊服务器上搭建负载均衡 

- redis 授权对安全组访问

- [官方地址](https://docs.aws.amazon.com/AmazonElastiCache/latest/red-ug/nodes-connecting.html)  测试是否连接成功   需要 gcc 和 redis-cli 包
<!--more-->
连接时不需要密码

- [redis-cli-命令操作](https://www.cnblogs.com/kongzhongqijing/p/6867960.html)


------------------------


### 在本地使用shell登录服务器脚本

>下载 expect
>- mac -  `brew install expect`
>- linux - `yum install expect`
<!--more-->

### 简易版
- 安装完成看一下expect的真实路径 `which expect`
1. 建立脚本 login.sh 下面是内容
    ```sh
    #!/usr/bin/expect -f
    # 设置ssh连接的用户名
    set user root
    # 设置ssh连接的host地址
    set host 10.211.55.4
    # 设置ssh连接的port端口号
    set port 22
    # 设置ssh连接的登录密码
    set password admin123
    # 设置ssh连接的超时时间
    set timeout -1

    spawn ssh $user@$host -p $port
    expect "*password:"
    # 提交密码
    send "$password\r"
    # 控制权移交
    interact
    ```

2. 保存后加入执行权限 `chmod +x login.sh`
3. 执行 `./login.sh`

### 综合版 本地存储账号 多账户登录

- 本次建立的文件一共3个,在同一目录下,其他需要自己更改
- expects.sh 登录控制 改动简易版的参数为接收的形式
- ssh.sh   接收参数 处理逻辑
- host.txt 存储账号和密码 一旦登录过一次就会存储到此处 有过的不会再写入

1. expects.sh 无需更改
    ```sh
    #!/usr/local/bin/expect -f
    # 设置ssh连接的用户名
    set user [lindex $argv 0]
    # 设置ssh连接的host地址
    set host [lindex $argv 1]
    # 设置ssh连接的port端口号
    set port [lindex $argv 2]
    # 设置ssh连接的登录密码
    set password [lindex $argv 3]
    # 设置ssh连接的超时时间
    set timeout -1
    spawn ssh $user@$host -p $port
    #判断是否需要确认连接
    expect {
        "(yes/no)?" {
            send "yes\n"
            expect "password:"
            send "$password\n"
        }
        "password:" {
            send "$password\n"
        }
    }

    # 控制权移交
    interact

    #本文件需要安装 expect 基于tcl

    ```
2. ssh.sh 方法中文字为询问 可自行更改 `pwds` 这个变量定义的是我这3个文件的目录 为了从外部访问方便 给出的是绝对路径 一定要改成自己的目录路径
    ```sh
    #!/bin/bash
    arr[0]=''
    #这个变量定义的是我这3个文件的目录 为了从外部访问方便 给出的是绝对路径
    pwds='/Users/cabbage/Code/mine/Linux/shell/sshTool/' 
    readServerInfo()
    {
    read -p "请输入服务器端口 不填写为默认22 按回车跳过:" port
    if  [ ! -n "$port" ] ;then
        port=22
    fi
    arr[1]=$port

    read -p "请输入服务器IP  :" ip
    arr[2]=$ip

    read -p "请输入服务器用户 不填写为默认root 按回车跳过 :" user
    if  [ ! -n "$user" ] ;then
        user=root
    fi
    arr[3]=$user

    read -p "请输入服务器密码 :" password
    arr[4]=$password
    }

    echo "正在查找服务器$1..... "

    #source $pwds/progress.sh #加载进度条文件 可以不用
    str=$(cat $pwds/host.txt |grep -w $1) #读取文件 匹配相应的账号密码

    #progressBar #调用进度条 进度条文件方法 可以不用

    if [ -z $str ] #判断是否找到相应账号密码
    then
    echo "找不到该服务器 - -"

    readServerInfo #服务器信息

    echo "$1|${arr[1]}|${arr[2]}|${arr[3]}|${arr[4]}" >> $pwds/host.txt #写入文件
    else

    arr=(${str//|/ }) # 表示'|'替换为' '空格 并转为数组

    fi

    port=${arr[1]}
    host=${arr[2]}
    user=${arr[3]}
    password=${arr[4]}
    $pwds/expects.sh $user $host $port $password

    #本文件为登录控制

    ```
3. host.sh 存储路径
- 存储的形式
```
cabbage1|22|47.15.211.32|root|password123
cabbage2|22|47.15.211.32|root|password123
cabbage3|22|47.15.211.32|root|password123
cabbage4|22|47.15.211.32|root|password123

- 备注
- cabbage1     备注名      以后登录用这个名字
- 22           端口        默认的22
- 47.15.211.3  ip 
- root         服务器用户名  默认root
- password123  密码 
```

4. 登录 
- 在bash中设置别名 快捷方法 写入家目录 .bashrc文件或者bash_profile文件 可自行处理
    ```
    alias login='/Users/cabbage/Code/mine/Linux/shell/sshTool/ssh.sh'
    ```
- 登录例子: `login cabbage1` 此处的cabbage1为备注名 没有此服务器会写入 以后登录也用这个 如果每次名字输入的不一致会重新录入多个

5. 完成啦 试试吧 

###### 备注
-  因为是本地存储的密码 并且是明文 所以最好只是本地使用 刚开始写这个也是用软件没有自己喜欢的
- 扩展 (网上摘抄)
    ```
    send：用于向进程发送字符串
    expect：从进程接收字符串
    spawn：启动新的进程
    interact：允许用户交互

    1. 定义脚本执行的shell
    #!/usr/bin/expect
    
    2.set timeout 30
    设置超时时间，单位是秒，如果设为timeout -1 意为永不超时

    3.spawn
    spawn 是进入expect环境后才能执行的内部命令，不能直接在默认的shell环境中进行执行

    主要功能：传递交互指令

    3.expect
    这里的expect同样是expect的内部命令
    主要功能：判断输出结果是否包含某项字符串，没有则立即返回，否则就等待一段时间后返回，等待时间通过timeout进行设置

    5.send
    执行交互动作，将交互要执行的动作进行输入给交互指令
    命令字符串结尾要加上"r"，如果出现异常等待的状态可以进行核查

    6.interact
    执行完后保持交互状态，把控制权交给控制台
    如果不加这一项，交互完成会自动退出

    7. $argv
    expect 脚本可以接受从bash传递过来的参数，可以使用 [lindex $argv n]获得，n从0开始，分别表示第一个，第二个，第三个……参数

    ```

-------------------------

### linux 判断是否是ssd硬盘  转载 

- (注意! 阿里云的ssd方法一和方法二都不符合 方法三符合 最好以服务器商提供的参数为准)

1. 方法一
判断 `cat /sys/block/(*)名字/queue/rotational` 的返回值（其中`*`为你的硬盘设备名称,例如sda,vda等等）,
如果返回1则表示磁盘可旋转,那么就是HDD了;反之,如果返回0,则表示磁盘不可以旋转,那么就有可能是SSD了
    ```
    cat /sys/block/磁盘名(vda,vdb等)/queue/rotational
    ```

2. 方法二

- 使用`lsblk`命令进行判断,参数-d表示显示设备名称,参数-o表示仅显示特定的列。
    ```
    [root@izc2mjnp7hy36fz ~]# lsblk -d -o name,rota
    NAME ROTA
    vda     1
    vdb     1
    ```
- 这种方法的优势在于它只列出了你要看的内容,结果比较简洁明了。还是那个规则,ROTA是1的表示可以旋转,反之则不能旋转

3. 方法三

- 可以通过fdisk命令查看,参数-l表示列出磁盘详情。在输出结果中,以Disk开头的行表示磁盘简介,下面是一些详细参数,我们可以试着在这些参数中寻找一些HDD特有的关键字,比如：`heads`（磁头）,`track`（磁道）和`cylinders`（柱面）。
- 下面分别是HDD和SSD的输出结果,HDD拷贝自网络。

    ```
    Disk /dev/sda: 120.0 GB, 120034123776 bytes
    255 heads, 63 sectors/track, 14593 cylinders
    Units = cylinders of 16065 * 512 = 8225280 bytes
    Sector size (logical/physical): 512 bytes / 512 bytes
    I/O size (minimum/optimal): 512 bytes / 512 bytes
    Disk identifier: 0x00074f7d123456


    [cheshi@cheshi-laptop2 ~]$ sudo fdisk -l
    Disk /dev/nvme0n1: 238.5 GiB, 256060514304 bytes, 500118192 sectors
    Units: sectors of 1 * 512 = 512 bytes
    Sector size (logical/physical): 512 bytes / 512 bytes
    I/O size (minimum/optimal): 512 bytes / 512 bytes
    Disklabel type: dos
    Disk identifier: 0xad91c214
    ......
    ```

3. 其他方法

- 可以使用第三方工具判断,比如smartctl,这些工具的结果展示比较直观,但是需要单独安装。

转载 下面是作者信息和文章信息 
作者：Charles_Shih
来源：CSDN
原文：https://blog.csdn.net/sch0120/article/details/77725658?utm_source=copy


---------------------------------

### linux top/htop系统工具
- top 动态查看服务器的运行状态和进程
- htop 是top的改进版 看起来更清晰 很小很便捷
- 安装htop
    - mac `brew install htop`
    - centos `yum install htop`
    - ubuntu `apt-get install htop`

<!--more-->

-----------------------



### linux  centos登录出现错误 
```
bash: warning: setlocale: LC_CTYPE: cannot change locale (en_US.UTF-8): No such file or directory
bash: warning: setlocale: LC_COLLATE: cannot change locale (en_US.UTF-8): No such file or directory
bash: warning: setlocale: LC_MESSAGES: cannot change locale (en_US.UTF-8): No such file or directory
bash: warning: setlocale: LC_NUMERIC: cannot change locale (en_US.UTF-8): No such file or directory
bash: warning: setlocale: LC_TIME: cannot change locale (en_US.UTF-8): No such file or directory
```
- 输入 locale 发现上面报错
<!--more-->

- centos 7没有百度以上一堆人抄袭的文章说的 /etc/sysconfig/i18n 这个文件
- 输入whereis locale 找到 /etc/locale.conf
- 编辑文件
    ```
    LANG=en_US.UTF-8 改为 LANG=zh_CN.UTF-8 重新登录即可
    ```

-----------------------


### linux vim vi 编辑二进制文件 

vi -b 或vim -b 告诉系统打开的是二进制文件

vim 输入 %!xxd 转换 vi 输入 %xxd 转换
修改完成之后在上面命令的基础上加入 -r 然后wq保存退出


-----------------------

###  pidof 命令用于查找指定名称的进程的进程号id号
  如果找不到该命令则安装
####centos 安装
  ```sh
  yum install sysvinit-tools
  ```
#### 语法:
  pidof(选项)(参数)
#### 选项
-s：仅返回一个进程号；
-c：仅显示具有相同“root”目录的进程；
-x：显示由脚本开启的进程；
-o：指定不显示的进程ID。
#### 示例:
```
  pidof nginx
  13312 5371
```

-----------------------

### shadowsocks 一键安装脚本(转)

- shadowsocks 用于代理本地网络连接到远程服务器

- Shadowsocks 一键安装脚本（四合一）
    ```
    wget --no-check-certificate -O shadowsocks-all.sh https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocks-all.sh
    chmod +x shadowsocks-all.sh
    ./shadowsocks-all.sh 2>&1 | tee shadowsocks-all.log
    ```

- L2TP/IPSec一键安装脚本
    ```
    wget --no-check-certificate https://raw.githubusercontent.com/teddysun/across/master/l2tp.sh
    chmod +x l2tp.sh
    ./l2tp.sh
    ```

- Shadowsocks-go 一键安装脚本
    ```
    wget --no-check-certificate -O shadowsocks-go.sh https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocks-go.sh
    chmod +x shadowsocks-go.sh
    ./shadowsocks-go.sh 2>&1 | tee shadowsocks-go.log
    ```

- ShadowsocksR 一键安装脚本
    ```
    wget --no-check-certificate https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocksR.sh
    chmod +x shadowsocksR.sh
    ./shadowsocksR.sh 2>&1 | tee shadowsocksR.log
    ```

- Shadowsocks Python版一键安装脚本
    ```
    wget --no-check-certificate -O shadowsocks.sh https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocks.sh
    chmod +x shadowsocks.sh
    ./shadowsocks.sh 2>&1 | tee shadowsocks.log
    ```

- Debian下shadowsocks-libev 一键安装脚本
    ```
    wget --no-check-certificate -O shadowsocks-libev-debian.sh https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocks-libev-debian.sh
    chmod +x shadowsocks-libev-debian.sh
    ./shadowsocks-libev-debian.sh 2>&1 | tee shadowsocks-libev-debian.log
    ```
    
- CentOS下shadowsocks-libev 一键安装脚本
    ```
    wget --no-check-certificate -O shadowsocks-libev.sh https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocks-libev.sh
    chmod +x shadowsocks-libev.sh
    ./shadowsocks-libev.sh 2>&1 | tee shadowsocks-libev.log
    ```

-----------------------


### yum 一个安装包 安装出错 说是已经安装过了

错误：软件包：glibc-2.17-196.el7.i686 (centos7)
需要：glibc-common = 2.17-196.el7
已安装: glibc-common-2.17-222.el7.x86_64 (@anaconda)
glibc-common = 2.17-222.el7
可用: glibc-common-2.17-196.el7.x86_64 (centos7)

原文链接：https://blog.csdn.net/qq_38900565/article/details/83869112
```
 wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
 sed -i  's/$releasever/7/g' /etc/yum.repos.d/CentOS-Base.repo
 yum repolist 
 ```

-----------------------

### centos7 时间差了8小时 自己服务器时区却是正确的
- 连接阿里云服务 因为时间问题不能使用 时间上差了8小时 看了一下服务器时区却是正确的 网上很多都是改时区的
- 网上很多的例子很繁琐 
- 简单的方法 
    - `date -s "-8hour"` 当前时间直接减掉8小时
    这就可以了 
<!--more-->


-----------------------




### 查询是否是内存溢出被系统杀死
- 命令 
```
  egrep -i -r 'killed process' /var/log

```

- 日志内容
```
  /var/log/messages:Jun  1 22:32:51 iZj6c3tg504x0j75q3prvyZ kernel: Out of memory: Killed process 27204 (geth) total-vm:9291304kB, anon-rss:7085704kB, file-rss:0kB, shmem-rss:0kB
```
- 当报出`OOM(Out of memory)`的时候，系统的内存已经不足了，于是linux会决定杀掉进程，但是linux采用的策略并非是杀掉最占用内存的进程(Android是这样)。
- linux会给每个进程评分：oom_score 根据这个评分去kill，决定这个分数的因素除了内存占用大小之外，还有内存增加的速率，内存的占用会突然爆发式增长！发现这时候的分数很高,然后就把它kill了


### gcc8 更新或者安装

```
yum install centos-release-scl scl-utils-build

yum list all --enablerepo='centos-sclo-rh'

yum list all --enablerepo='centos-sclo-rh' | grep "devtoolset-"

yum install -y devtoolset-8-toolchain

scl enable devtoolset-8 bash

gcc -v
```
 


