<?php
/*
//以太坊官网地址接口 获取余额 参数 address
https://api.etherscan.io/api?module=account&action=balance&address=0x0975CA9F986EeE35F5CbbA2d672ad9bc8D2a0844&tag=latest&apikey=GZQ3UXNYP6BSAA9HFGZHYNY6PRMK8PRDU2


1871 207730463448924228

1,871.207730463448924228 Ether

001028999999790000 如果不到18位在第一位向前补0到18位
0.001028999999790000

//启动命令
geth  --rpcapi admin,db,debug,eth,miner,net,personal,shh,txpool,web3 --rpc --rpcaddr 127.0.0.1 --rpccorsdomain api.jhain.com

//后台运行并输出到文件
nohup geth  --rpcapi admin,db,debug,eth,miner,net,personal,shh,txpool,web3 --rpc --rpcaddr 127.0.0.1 --rpccorsdomain api.jian.com >> ./execute_eth.log 2>&1 & 

--rpcaddr 0.0.0.0  //全部允许
--rpccorsdomain api.jicin.com //允许域名
开启阿里云和宝塔端口


香港可用区 B 
实例 ： 计算网络增强型 sn1ne / ecs.sn1ne.2xlarge(8vCPU 16GiB)
购买数量 ： 1 台
镜像 ： CentOS 7.4 64位
系统盘 ： 高效云盘 500GiB
网络 ： 专有网络VPC ： 
公网带宽 ： 按固定带宽 5Mbps
安全组 ：  / sg-j6c5whqo9wn6i68f4qfe

￥ 1683.09






personal_importRawKey([keydata, passphrase])

将给定的未加密私钥（十六进制字符串）导入密钥存储区，并使用密码对其进行加密。
返回账户地址



   