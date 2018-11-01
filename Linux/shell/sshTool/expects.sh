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
