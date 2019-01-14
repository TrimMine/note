#!/bin/bash
progressBar()
{
i=0
bar=''
index=0
arr=( "|" "/" "-" "\\" )
while [ $i -le 100 ]
do
    let index=index%4
    printf "[%-100s][%d%%][\e[43;46;1m%c\e[0m]\r" "$bar" "$i" "${arr[$index]}"
    let i++
    let index++
    sleep 0.003
    bar+='#'
done
printf "\n"
}

#本文件为进度条 可有可无