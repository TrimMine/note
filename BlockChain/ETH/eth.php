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

nohup geth  --rpcapi admin,db,debug,eth,miner,net,personal,shh,txpool,web3 --rpc --rpcaddr 0.0.0.0 --rpccorsdomain "*" --syncmode "fast" --cache=4048 --maxpeers 9999 >> ./geth.log 2>&1 &  

//后台运行并输出到文件
nohup geth --datadir /mnt/.ethereum  --rpcapi admin,db,debug,eth,miner,net,personal,shh,txpool,web3 --rpc --rpcaddr 127.0.0.1 --rpccorsdomain api.jxym2.cn >> ./eth.log 2>&1 & 

--rpcaddr 0.0.0.0  //全部允许
--rpccorsdomain api.jicin.com //允许域名
--datadir  指定块的存储路径
开启阿里云和宝塔端口

nohup geth  --rpcapi admin,db,debug,eth,miner,net,personal,shh,txpool,web3 --rpc --rpcaddr 0.0.0.0 --rpccorsdomain "http://115.60.60.173,http://192.168.2.100,http://192.168.2.235" --syncmode "fast" --cache=4048 --maxpeers 9999 >> ./geth.log 2>&1 &


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


------------------------------ 如何获取节点 ID 信息和端口号 ------------------------------

# 连接到正在运行的 geth 节点上并进入命令行界面
geth attach

(如果指定了目录 --datadir /mnt/.ethereum 这样的使用时必须这样  geth attach ipc://mnt/.ethereum/geth.ipc)
#自己的全部信息
admin.nodeInfo

# 获取当前节点的 ID 和端口
admin.nodeInfo.id
admin.nodeInfo.ports.listener

# 退出命令行界面
exit

添加节点
> admin.addPeer("enode://d8f4c028b96eeb53dcd87448962599cc14686d94e341e3d3ff51a9d313fa822bb434f5227c2b5f6b74da26fb82b291e79b23535a9d7e998701d21f1201c9287d@47.52.16.149:30303")
true #返回true

#查看新添加的节点
> admin.peers

#连接数量
>net.peerCount

#是否是监听节点
>net.listening

 基链钱包节点
"enode://d8f4c028b96eeb53dcd87448962599cc14686d94e341e3d3ff51a9d313fa822bb434f5227c2b5f6b74da26fb82b291e79b23535a9d7e998701d21f1201c9287d@47.52.16.149:30303",

------------------------------ 稳定静态节点信息 ------------------------------

星火节点提供的稳定静态节点信息
https://ethfans.org/wikis/%E6%98%9F%E7%81%AB%E8%8A%82%E7%82%B9%E8%AE%A1%E5%88%92%E8%B6%85%E7%BA%A7%E8%8A%82%E7%82%B9%E5%88%97%E8%A1%A8

放到存放数据的目录(一般都是~/.ethereum/) 新建 static-nodes.json文件 将里面的数据放入 下面的文件是 2018-8-21日下载 

[
 "enode://d8f4c028b96eeb53dcd87448962599cc14686d94e341e3d3ff51a9d313fa822bb434f5227c2b5f6b74da26fb82b291e79b23535a9d7e998701d21f1201c9287d@47.52.16.149:30303",
 "enode://d8f4c028b96eeb53dcd87448962599cc14686d94e341e3d3ff51a9d313fa822bb434f5227c2b5f6b74da26fb82b291e79b23535a9d7e998701d21f1201c9287d@209.9.107.84:30303",
 "enode://d03335ec6b73fe55af464433361f6aa7b1aca92ad8cac24cbc76d88f16b39508c11b94de0ae9c6813dff7b18e3e3fcbb36124ab0273c92ba4c80eb32b2c0446c@222.210.114.171:30303",
 "enode://d5d953b27cd642436be70267157505230a9ff57423fe54d3249b804793514fb1d37dd48d3fa1abe7c01d53b1ffcf0f25b7ce0d0a62212b5e7e9565004b261ae4@222.210.114.171:30303",
 "enode://d3a88153add67753734154997da2dc61ce53a29565fbb0aaf22801e697c95000a7a625b760f60e0b87f959758380c3444a8d3712fa4a0767e1c4ea5252a34bed@211.83.110.142:30303",
 "enode://4b4e5013e0def80f893c7eaed4dab3ef92fa0d165db1a8ffa1bcaa4ac02d0bacc57d23ed10cbce5a54356a4e31bb8c171d1db1c76c40ace39a63acd1163d8bad@192.154.99.91:30303",
 "enode://ca33ab88e0db3965dc6faa77f9fd8d2a42b0f3ffbb8f87c4a45bb72103513681e428444b5079eed6e2b7cc8ae73b36165d0d0accba4b2c4f69523ffa9208f23e@123.57.234.11:30303",
 "enode://c7e3fc2774583e802357295d6937d904909c9318d2dbea41aaffa532030bf7fc001e13f9e951e0548e1b2b3df3039115c8f422a26a8c39ea3d7630ba6b7dd513@121.42.57.138:30303",
 "enode://4894cc9782242095b82d7097603738cdb964f515d0283f9a144a11cb87d7a3f019eaf9bd1370c19262426e1419191387476b531a217bf094bc5d052dd417790d@112.126.95.3:30303",
 "enode://12b3873357f59b4033d61ff03ec1eace647be8661daa2001a414984873c3db50433b203100a008c7888679accbdda89ebccff45d8b3ee82a0ed51a9791147e34@115.28.140.194:30303",
 "enode://c9ffd2250aea33e41ac63ca8d479ced251eaa8b1d66418e8219738fbcea50365fa3b3d958a49f2d3125b7712e318dba1c3775f2a886f44cf17f5193500ebf8cb@118.122.122.16:30303",
 "enode://d8909aa15b18eaaec9484b9a175545877300e257fb3acf17ad3b13b570d516753ca21a90ea690232896510f5fe2951aa6e3a2500ea130c616f70fe5cef9821c7@121.41.82.49:30303",
 "enode://2ecbd563b9a3a07d1836c6249a7f6d7f4599eda3e31ce120890a2916698081c94cf84823f528678bb28119bc0c51dd072c25209e735a00420fd78971e0c2d285@211.23.3.139:30303",
 "enode://b083d482ed096672e3da35e3d5ef90afba2b3376a49f2d910a4032f0f2ae86792c91a04eeb481b475c70fdfc516ef9e58892ef2c8ad656c7786382dc9b41387c@182.39.223.92:30303",
 "enode://4c0e5b783b4c92da51a9d49cb7658b5f1a19a98877baf27391fa3b936f42568569511a0c2f29a88f7db9ffd1a369ec1d86c7f627e2d3596fc109e3f97c19740f@119.29.251.168:30303",
 "enode://54f1a0232d0f94e121062f707d94ccb402ac578cba3146c3cdb2a93374ebf16b30c994b7ac9644e41bede645682f893acc868f2e256ce14cd815b0721c340659@172.104.116.223:30303",
 "enode://f21e1d5d2cad62c8a25d2d976b3ef514eb481a42d17fb26052961024fc9b5bcb1ee5e53027f254bdb994a53800161e07457bc1f8ee5983ab786fa583c32fa5ab@47.89.24.211:30303",
 "enode://3d4633df377f336357eb5673aefd3de238d9f8d2657e6a38259677cb29ad9696f0dfaf4d6cd4019920ef0481bf77cebae27840b5c57a853ada101c4646a125e6@47.52.35.140:30303",
 "enode://f21e1d5d2cad62c8a25d2d976b3ef514eb481a42d17fb26052961024fc9b5bcb1ee5e53027f254bdb994a53800161e07457bc1f8ee5983ab786fa583c32fa5ab@47.89.24.211:30303",
 "enode://a9406bbeb8f1915de82119977091335dbb7d79a738632cd2ad72392d5a0f0a540f2178ed99b4bfd1f5a563e4f72244ef77e0a4351103fed456f3239e41e54165@52.80.97.92:30303",
 "enode://9f8d509b69c9cfbbf5e3399cee4a14283b4c947a52b2bf43e8ea73e40a0b6d173dae34200348684f434f723e3beb4dead973cb2d1023987b9a77e77874241ef0@121.199.16.215:30303",
 "enode://fbb0b511ff75e04345a3583800a1ebe25fbbad404d1fbbefb27bae48f8851ea7ecb2058311fdd88cc5d9e40721d64e3d2f5b2574615b87ee6c2181794294a683@45.33.41.30:30303",
 "enode://706eb3cd25d676ceb1e30a7f738434d08804e4df111437ffa7b6b5ac086706dee122e7666f257cc8e1c9efac9a32d9c9d80551e780bbfe0175274af584451ad7@47.93.16.189:30303",
 "enode://cfc6ccea20c4317e3873757bf50de12a494eb53df105e7a402369122cb339f84d33a3e17cefc89d52ee079b8e150b89514ad8d087f733e5a365f98845e374412@47.52.112.23:30303",
 "enode://d4445c6dcd06ca0f281472b91de09ae96a6321b597096a5d15d62b00df26f88ebee00f46a0587cdcd44f5ac4b0c86ce9034dfc4f36c48403df4d32374d38d970@139.219.106.201:30303",
 "enode://931744f154bf81fe07d232abf6260160ae261367fa89c60f8b2334e55141fda64bd2759d948882603d49c7c46b41f67357654a4135c2e95806b1589ae1889b9a@218.82.68.138:30303",
 "enode://d48db6dc3a9839a5cbf48ef16eee15f8048077ae1ed11cbc5e02b5c8e88bce950f5161eb5cc810f5d9dca310c86945a96477cd9e88091f3764ca4eb7485ae5c6@119.28.71.192:30303",
 "enode://28e437e69ee86ace289749157ca7cb4b4e9f91b3903c027af75202a15cc52834790b2c54aa5bb6a4d504b977992c3ac77713b9202170dc40c6269c3ba65fd2c1@120.41.181.90:30303",
 "enode://4e7f80fea4c7e130d53f160d64fe3771ad037aa12c07b72c17b685f8eb26cc9e80050e80d576c8de1beb1930b94abe6043afb84cf1fdd5451ca1699234f08a2c@101.254.166.184:30303",
 "enode://ed2c476a23ec251cec9f05e99c7c921ffcb29f0557ea34277d717e91a2975e8e0ed97cb1c728d636c4163029b0d3d559024625af9e122113c7c33e85cd3051c9@101.254.166.184:30303",
 "enode://a9bc681d894b62ef5901c70b0881e2b7ba7a8d3cb47cf6ba79709a59dde7870daf3ce6162bed67254878ee9011d5e838d4aea82371956a463970c09edbf85ffb@121.41.122.33:30303",
 "enode://30d73df66207a4f4c000b8b7b8c8fa8cbb55783a31273c481c15ffb16775032134db9d7857701bec2ad45e55d88f2ac4f070ebfe9bd19f4db3b1f2b9e2abf330@23.88.147.138:30303",
 "enode://98bceb1bea2a515921557a25f0402d50cbec2da564069ea27888ca6ccfc43c5ed70caa1ad9e4f68bb836729b439cecea7a1422b15be4900043da105a1ab28d97@118.31.2.234:30303",
 "enode://d48db6dc3a9839a5cbf48ef16eee15f8048077ae1ed11cbc5e02b5c8e88bce950f5161eb5cc810f5d9dca310c86945a96477cd9e88091f3764ca4eb7485ae5c6@119.28.71.192:30303",
 "enode://98bceb1bea2a515921557a25f0402d50cbec2da564069ea27888ca6ccfc43c5ed70caa1ad9e4f68bb836729b439cecea7a1422b15be4900043da105a1ab28d97@118.31.2.234:30303",
 "enode://98bceb1bea2a515921557a25f0402d50cbec2da564069ea27888ca6ccfc43c5ed70caa1ad9e4f68bb836729b439cecea7a1422b15be4900043da105a1ab28d97@118.31.2.234:30303",
 "enode://d48db6dc3a9839a5cbf48ef16eee15f8048077ae1ed11cbc5e02b5c8e88bce950f5161eb5cc810f5d9dca310c86945a96477cd9e88091f3764ca4eb7485ae5c6@119.28.71.192:30303",
 "enode://98bceb1bea2a515921557a25f0402d50cbec2da564069ea27888ca6ccfc43c5ed70caa1ad9e4f68bb836729b439cecea7a1422b15be4900043da105a1ab28d97@118.31.2.234:30303",
 "enode://6141f1743c8678ea1f09b26f214c40ab2e800aff54fc86b48e240a0aaa23e6117170652cd5fe93555445cbe849e1b43b3aee8ebea32780827a5b4b45bb5a4111@101.37.152.90:30303",
 "enode://98bceb1bea2a515921557a25f0402d50cbec2da564069ea27888ca6ccfc43c5ed70caa1ad9e4f68bb836729b439cecea7a1422b15be4900043da105a1ab28d97@118.31.2.234:30303",
 "enode://30d73df66207a4f4c000b8b7b8c8fa8cbb55783a31273c481c15ffb16775032134db9d7857701bec2ad45e55d88f2ac4f070ebfe9bd19f4db3b1f2b9e2abf330@23.88.147.138:30303",
 "enode://0da14302955296f41057c7b0682248436320c09e2bc07a48a6ee734dad872939bd9527088072599a03a61e93ffb4d128817a476ec5a4e0417601affa96c6a3b8@120.41.165.225:30303",
 "enode://b0b43c96c71f7b63efbd6df33bf5004123a850d6715dbfb4dc182b6391d5e2a80187075b2fc441440d39e1209b9391b5b76c545e72bf8a54a808118cb570fb69@39.108.217.175:30303",
 "enode://1b022d71f5a927b73adec750b50dbf3c8fea2a669ed9789d74a10be146a975cbf37a4c6a29d0d4391ee6ab9ce5feb68e38d02edbbc37e349ec2e286e723e129c@47.100.64.6:30303",
 "enode://e8eb2aaa4241b9c80bfea9690d64e259ff3b920a59d3e556c84b34c47862d51b98a0f77c332bd82bef73a62ccef191cec9a418afb64ebdb6ca44d68fda3a228e@116.62.16.60:30303",
 "enode://86ec041317a097dcc46a97a9fbe454852cd666e5f9cb5ffca30155bf736d61f519e80cec0c3813d64fe7d10d7f03adf20a04d90dd53bdfbe31f8078672a24e3b@39.106.168.40:30303",
 "enode://bc5a938a88a57ac08d7e317e7b18b33a67207a9f6e538071e682c846eac35e9cfbbe1af5ef6373ae6defbb2e32484c704190595e33fb2c8f6b01cfbba3358024@47.74.153.126:30303",
 "enode://3ec36050c204d681a6af412bccc410389b69fbb9735849dcbfb44c3089d8b20b833915fec88225ed0f8d8095b2ce43db53cfbae38287efaa783a10fbbd8606be@47.97.34.118:30303",
 "enode://a290c2b866609b32a8eae8137b0358a1a2e8b0dc77ed1d514d572f80dfadce8df778fcae6732f72a22cc0f46cff973cf0fab5a427c95929bed22e15e3a36351e@180.169.186.133:30303",
 "enode://5a86679e02acf932157a1814cf43f20ca790638864e1c2d314296beedf4e85f53e269a59aa2b86112b41cf5b810450f93d4bf357eeec0a9045017d1cd7f5455e@120.77.43.67:30303",
 "enode://0fe1977c9758de06224299a73470b0996e016218d3b66c30d3be0a51179c1ad62905efbd9966b4f8dc461f3233d0276780ba5d53c5a64871276c06da2502897d@117.131.10.26:30303",
 "enode://0fe1977c9758de06224299a73470b0996e016218d3b66c30d3be0a51179c1ad62905efbd9966b4f8dc461f3233d0276780ba5d53c5a64871276c06da2502897d@117.131.10.26:30303",
 "enode://f42b0caa4a8970bf35b30d79e142fc3c722db77c9c4e16e50783c82425546d74d0ce99890b3db5d2d07767d61c0b735ded2079313c5459e4077b0bab4f57eed3@47.96.6.84:30303",
 "enode://b216087eb007b187b81adaa00477479dc4ccdc5a42440c6918677dab6656ae68adde9db67493e78d822bffd4070f8946ad9b1e47dacbae8add21c1076a79c2e0@47.74.13.238:30303",
 "enode://f42b0caa4a8970bf35b30d79e142fc3c722db77c9c4e16e50783c82425546d74d0ce99890b3db5d2d07767d61c0b735ded2079313c5459e4077b0bab4f57eed3@47.96.6.84:30303",
 "enode://1a3a271d0a5e0dc7ac3c5455c7d0fa14c20764e6450d5547b4d0903ba86845d31bfb5e8de89a083f1cee1bb2fa73f0a699bc59e8e655e3ec74d525fc05aca0ac@47.52.253.169:30303",
 "enode://b216087eb007b187b81adaa00477479dc4ccdc5a42440c6918677dab6656ae68adde9db67493e78d822bffd4070f8946ad9b1e47dacbae8add21c1076a79c2e0@47.74.13.238:30303",
 "enode://067c356ee903a7bfff953f8493711b59c94b18498f64f3cd02c4b3bb796f6d74c23fa6a644b3ec13f5d698158d48a8841f45349a6991adeab6d9d9b99b6739c4@47.52.253.169:30303",
 "enode://5195428e39402b2336dc45a6cb9e73878651fb09311baa88c7e3618b081268d29e5314ace3649f8f5267dc60cf03f9c1c3ec432b0b81e0765f073ce3bd3b10fc@118.190.137.139:30303",
 "enode://d5d390008523a6197ea09f5744d5d74cdf258cbe931da4f6da1fbbd30864a8a9b9055758ec93fea5eab0993ad5a7263da5bdb970fb799cd43818aea15288d861@123.207.45.82:30303",
 "enode://a9f33f0b1d20b27dca75bda041a416fe93382743754bb78e914295b1dac827d69161625fd633b988193eeb2088b7a25b23d544cb903661adc8295bc0af75dafc@123.134.80.8:30303",
 "enode://184ba64eabfe6d505671cad2c91f6104108a71499bdc3b594ec70b7c57fdd00dbefb21d51cd09152749110fbf9690e28a4d2a0cb787a1d4ae83cb25ceb778ae3@61.242.176.221:30303",
 "enode://7f7ecd2ecd3381e369e3c0001065fea0874d40ea6f188fa3ee6f1b3ca1e04edc8c2c50766957eb1690f151dda6f1438a47b092c0ee8536c14aa23041819153a9@222.182.199.104:30303",
 "enode://46f692c863849e3ebccff96bbe072330ce5db88bb6a9e3d71ef76b4210619e26d5273517370ddbd26ea6220abe08526e2031db4c1fadef2366af9fe147f7cd6d@121.201.119.209:30303",
 "enode://46f692c863849e3ebccff96bbe072330ce5db88bb6a9e3d71ef76b4210619e26d5273517370ddbd26ea6220abe08526e2031db4c1fadef2366af9fe147f7cd6d@121.201.119.212:30303",
 "enode://7263bacf91d43f1b17eb4f536ab7e80181ba80c509b5b248e650f9d3014cd8dcd12d96e8bb783f39ee72056b3971ef5d13a504dbde4d8b4a832d1e804587eb8c@111.199.6.132:30303",
 "enode://6f29e2fcb4dc5a721e792e91a5964212fda809072558161fa83104ee6eafef4c546e1834792d4a8d8e63de5ef98b4a33d6c6a7c6cf8c382bc99d13f48848064c@123.207.125.216:30303",
 "enode://2371a9a16830460d4a1364feb8d1ef5e9d4d56e3bd0f7b450b5a1bd69b3b7031ed4e5b783aa8d2ea37539e0b7ed53dedabe079f920fa2cb047eddaa0372e29a4@111.231.239.128:30303",
 "enode://25e452366488ba0becd03a257ba82189c8955210647d52701c60339eddd1aafebf48c1c2812f3c8ffa377d32152cb18a7902342db88e2c21fb19211c7af7c0b2@47.100.183.193:30303",
 "enode://e15d14f3af138d0f9ee89a862c62fe6a264417b11aabfa5fccdd8962379d936b505e1f8b45dc526d107855e13e5338c660fa48bace822d2b399202f1b5c23521@47.88.243.185:30303",
 "enode://e393e28e9891a8f9648360ec29b75b721a59bb5a1d5d3f9003741103dc700cf3c6cb5f3c8427a70d4198d40ea0045b03425501d222fd8bebf58f4076df44eafa@47.88.34.124:30303",
 "enode://e393e28e9891a8f9648360ec29b75b721a59bb5a1d5d3f9003741103dc700cf3c6cb5f3c8427a70d4198d40ea0045b03425501d222fd8bebf58f4076df44eafa@47.88.34.124:30303",
 "enode://997cb4f3ce3b2f51b5ffcb659721ae1418d135219c44aff8fc4f3e5afa2054d437db1e05f583398a5e781b08c6a0a9d8793cd9c1c29912c0edd6d1d438d0f7d9@119.3.0.5:30303",
 "enode://1a28e0cb83e397dd3a080a05bc54e6b12c3397de895646692aaa1e320a4664f7c7878d83ec839c69b02db7143606ffe43d68276701679aa80fe22809afcc5ed7@47.90.93.239:30303",
 "enode://ee7629d5381fc0e072d22cfce25577ba5ac4f48355315c0984dc7c13bd32cda96d97785506f3b5c3041a1e3fa472ddd866f88f630fc5f3cda8d4ac73fb5a68f2@222.179.145.90:30303",
 "enode://08a11bb849dede27e3d1373f2457fdd62ef848a5d6ca9f6f780de241656cee3de982f558621ce11278fdcb215cad9c3b9b854d25d4d9efe99fc463bc0d754a8b@47.75.85.209:30303",
 "enode://78de27823c8d6a4df7e80ed7ee2a2720e2f6f47cd247442ae1ef56d625af2620fe0f80dc70e53e26fd014f06e6ecc36c5d1363ab8c1740fddad45d854b1170c0@39.106.0.122:30303",
 "enode://9cf8af275bfe819ac6d0b800138152540213c4624274e85ab42616926094cfe0aae2a8c022a5604bcc7c2ea2acfe6d6c3d0262deb7eb408a1a6dddb25d4ccaae@120.26.221.201:30303",
 "enode://e737d293373621b0ee5cf3d785fcd5730459ffcdda80dc807242e28e3cdeefcfee546f383edc23e1aafc10d434157f37246c463c1a303a25d36983cd8d9cf6a8@118.24.163.183:30303",
 "enode://14bd3822a4a73c8a0d633202fe5ef6eaede6e8cd607f11e578ca332fedb54bb2a02de0434842ebbc19119687d3a6186038e8e06df9c344ed82f8a0722312d116@193.112.74.45:30303",
 "enode://74a7690de15e602fbc5bfe84ddb173006a6c4a4e57ecff1f63171a891150b25aaffc80c5389a60df62cbd8845f5166cc794c4282f2071a47fb6a89eb3fcc6fe4@47.52.29.226:30303",
 "enode://f0915704ae4109fccf85903a7eb009b846866ace2d4a59cee198101bf1d3f4138a3289262c95fd6cd93a453bf4c2904a017fa6e3464845a09507308033ec2859@202.103.210.186:30303"

] 







------------------------------------------ Ethereum geth 同步区块的三种模式 ------------------------------------------
https://blog.csdn.net/guokaikevin/article/details/79254785 链接

Ethereum（以太坊）当前交易多，截止当前（2018-02-04）已经有5029238个区块，区块大小在150G左右。

如果全部同步，并且严格逐个验证，需要太多的时间和计算。作者曾经用一台实体机，8核，16GB内存，2TB机械硬盘的dell立式服务器，在办公网络下同步区块，结果半个月没有同步完，同步的速度还没有新出区块的速度快。。。。

查找了一下，以太坊有三种同步的模式，full, fast, light。

full 模式，从开始到结束，获取区块的header，获取区块的body，从创始块开始校验每一个元素，需要下载所有区块数据信息。速度最慢，但是能获取到所有的历史数据。
//命令：
geth –syncmode full

fast模式，获取区块的header，获取区块的body，在同步到当前块之前不处理任何事务。下载的数据大小约为50GB（截止2018-02-04）。然后获得一个快照，此后，像full节点一样进行后面的同步操作。这种方法用得最多，目的在不要在意历史数据，将历史数据按照快照的方式，不逐一验证，沿着区块下载最近数据库中的交易，有可能丢失历史数据。此方法可能会对历史数据有部分丢失，但是不影响今后的使用。
//命令：
//使用此模式时注意需要设置–cache，默认16M，建议设置为1G（1024）到2G（2048）
geth –fast –cache 512


light模式，仅获取当前状态。验证元素需要向full节点发起相应的请求。
//命令：
geth –light

作者按照fast模式，在4核8G，SSD硬盘的云主机上，差不多2天时间就完成了以太坊区块的同步。


------------------------------------------ eth.syncing ------------------------------------------
https://blog.csdn.net/wo541075754/article/details/79649208 转自

eth.syncing
{
  currentBlock: 6186931,
  highestBlock: 6187005,
  knownStates: 74133755,
  pulledStates: 74110972,
  startingBlock: 6186822
}

Syncing方法的源代码很简单，注释说明也已经很清楚了。通过这段源代码我们可以得知一下信息： 
- 当然CurrentBlock大于等于HighestBlock时返回false，这也正是通常所说的同步完成之后，再执行eth.syncing()函数会返回false的原因。 
- startingBlock：开始同步的起始区块编号； 
- currentBlock：当前正在导入的区块编号； 
- highestBlock：通过所链接的节点获得的当前最高的区块高度； 
- pulledStates：当前已经拉取的状态条目数； 
- knownStates：当前已知的待拉取的总状态条目数；


------------------------------------------ eth 安装 ------------------------------------------

1.github 克隆源码
git clone https://github.com/ethereum/go-ethereum 
2.安装golang
yum install golang
3.执行命令  (进入源码目录)
make geth 或 make all



