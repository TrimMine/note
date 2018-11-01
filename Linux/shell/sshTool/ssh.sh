#!/bin/bash
arr[0]=''
pwds='/Users/cabbage/Code/mine/Linux/shell/sshTool/'
readServerInfo()
{
  read -p "请输入服务器端口 :" port
  if  [ ! -n "$port" ] ;then
    port=22
  fi
  arr[1]=$port

  read -p "请输入服务器IP :" ip
  arr[2]=$ip

  read -p "请输入服务器用户 :" user
  if  [ ! -n "$user" ] ;then
    user=root
  fi
  arr[3]=$user

  read -p "请输入服务器密码 :" password
  arr[4]=$password
}

echo "正在查找服务器$1..... "

#source $pwds/progress.sh #加载进度条文件 可以不用
str=$(cat $pwds/host.txt |grep $1) #读取文件 匹配相应的账号密码

#progressBar #调用进度条 进度条文件方法 可以不用

if [ -z $str ] #判断是否找到相应账号密码
then
  echo "找不到该服务器 - -"

  readServerInfo #服务器信息

  echo "$1|${arr[1]}|${arr[2]}|${arr[3]}|${arr[4]}" >>./host.txt #写入文件
else

arr=(${str//|/ }) # 表示'|'替换为' '空格 并转为数组

fi

port=${arr[1]}
host=${arr[2]}
user=${arr[3]}
password=${arr[4]}
$pwds/expects.sh $user $host $port $password 


#本文件为登录控制
