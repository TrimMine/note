<?php
/*
------------------------------ BTC安装  ------------------------------


我的服务器是 centos  ubantu和debian 参考官方文档 https://github.com/bitcoin/bitcoin/blob/master/doc/build-unix.md
可安装的库 

sudo yum install gcc-c++ libtool make autoconf automake openssl-devel libevent-devel boost-devel libdb4-devel libdb4-cxx-devel


如果你是基于最小化安装的linux系统，需要执行如下命令，安装必要的库，如果是安装过的可以跳过此步骤 

yum -y install wget vim git texinfo patch make cmake gcc gcc-c++ gcc-g77 flex bison file libtool boost-devel libtool-libs automake autoconf kernel-devel libjpeg libjpeg-devel libpng libpng-devel libpng10 libpng10-devel gd gd-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glib2 glib2-devel bzip2 bzip2-devel libevent libevent-devel ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel krb5 krb5-devel libidn libidn-devel openssl openssl-devel vim-minimal nano fonts-chinese gettext gettext-devel ncurses-devel gmp-devel pspell-devel unzip libcap diffutils vim lrzsz net-tools

源码编译和下载二进制两种 安装方法

一.源码编译
	
	没有git 要安装git centos 安装git yum install  git 
	
	1- git clone https://github.com/bitcoin/bitcoin.git

	2- ./autogen.sh 
	报错 
	which: no autoreconf in (/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/root/bin)
	configuration failed, please install autoconf first
	或
	Makefile.am:3: Libtool library used but `LIBTOOL' is undefined
	Makefile.am:3:   The usual way to define `LIBTOOL' is to add `AC_PROG_LIBTOOL'
	Makefile.am:3:   to `configure.ac' and run `aclocal' and `autoconf' again.
	Makefile.am:3:   If `AC_PROG_LIBTOOL' is in `configure.ac', make sure
	Makefile.am:3:   its definition is in aclocal's search path.
	autoreconf: automake failed with exit status: 1
	
	安装autoreconf 和libtool 
	yum install autoconf automake libtool 
    
    安装完成执行上个未执行的步骤

    3- ./configure -without-gui   不安装gui图形界面
	
	报错
	checking whether the C++ compiler works... no
	configure: error: in `/home/ljw/bitcoin-master':
	configure: error: C++ compiler cannot create executables
	See `config.log' for more details
	[root@localhost bitcoin-master]#yum install gcc-c++
	
	报错 
	configure: error: libdb_cxx headers missing, Bitcoin Core requires this library for wallet functionality (--disable-wallet to disable wallet functionality)
	
	根据文章https://blog.csdn.net/terminatorsong/article/details/74089911 如下解决方案

    看了下文档，提示需要libdb5.1。查查问题的时候都是关于bitcoin的，提到的都是要使用BerkeleyDb4.8NC。CentOS没有libdb，只能手动安装BerkeleyDb5.1。在doc/build-unix.md文档里有详细的说明，按说明操作安装即可。

    方案:
	wget 'http://download.oracle.com/berkeley-db/db-5.1.29.NC.tar.gz'
	echo '08238e59736d1aacdd47cfb8e68684c695516c37f4fbe1b8267dde58dc3a576c db-5.1.29.NC.tar.gz' | sha256sum -c  效验下载的压缩包完整性
	tar -xzvf db-5.1.29.NC.tar.gz 
	cd db-5.1.29.NC/build_unix/
	../dist/configure --enable-cxx --disable-shared --with-pic --prefix=/usr/local
	make install

	报错  
	configure: error: Found Berkeley DB other than 4.8, required for portable wallets (--with-incompatible-bdb to ignore or --disable-wallet to disable wallet functionality)
    加上编译参数 --with-incompatible-bdb 
    ./configure -without-gui --with-incompatible-bdb 

    报错
    configure: error: No working boost sleep implementation found.
    yum install boost-devel


    最后
    make  执行时间较长
    make install

    创建软链  可省略看个人喜好
    ln -s ~/bitcoin/src/bitcoin-cli /usr/bin/btc  
    ln -s ~/bitcoin/src/bitcoind /usr/bin/btc-start

    btc-start -daemon #后台启动 如果没有创建软链就使用 bitcoind -daemon 

	新建配置文件 -conf=/root/bitcoin.conf 将配置项写入  设置RPC用户名和密码 端口 servcer=1 rpcallowip=0.0.0.0/0
	切记要写入RPC的配置文件 个别版本遇到过拉取区块同步之后在设置rpc账号和密码不能使用 connect refused 最好拉取之前就设置好

	btc-start -conf=/root/bitcoin.conf -daemon

   
    可在 ~/.bitcoin/debug.log 查看日志信息
     
     btc stop 如果没有创建软链就使用  bitcoin-cli stop
	

    具体操作参考 api文档   https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_calls_list 操作api

    安装参考文献 https://bitshuo.com/topic/595783eb4a7a061b785db747
    官方github文档 https://github.com/bitcoin/bitcoin/blob/master/doc/build-unix.md

    比特币中国官网 有接口提供和查询等 也可测试发送交易hash   https://www.blockchain.com/zh-cn/explorer


    二进制安装

    二进制包下载后可直接使用 
    参考文献 
    官方: https://bitcoin.org/en/full-node#configuring-dhcp
    其他: https://www.jianshu.com/p/63cc72b27e72

---------- bitcoin-cli 在启动bitcoind客户端的时候，如何设置启动参数，常见的有以下的  ----------------


-rpcuser=<用户名>  JSON-RPC 连接使用的用户名
-rpcpassword=<密码>  JSON-RPC 连接使用的密码
-rpcport=    JSON-RPC 连接所监听的 <端口>（默认：8332）
-rpcallowip=   允许来自指定 地址的 JSON-RPC 连接  可以设置多个  rpcallowip=34.65.23.23 rpcallowip=37.89.23.2 
-rpcconnect=   发送命令到运行在 地址的节点（默认：127.0.0.1）
-blocknotify=<命令> 当最好的货币块改变时执行命令（命令中的 %s 会被替换为货币块哈希值）
-upgradewallet     将钱包升级到最新的格式
-keypool=       将密匙池的尺寸设置为 （默认：100）
-rescan            重新扫描货币块链以查找钱包丢失的交易
-checkblocks=   启动时检查多少货币块（默认：2500，0 表示全部）
-checklevel=    货币块验证的级别（0-6，默认：1）


  bitcoind [选项]
  bitcoind [选项] <命令> [参数]  将命令发送到 -server 或 bitcoind
  bitcoind [选项] help           列出命令
  bitcoind [选项] help <命令>    获取该命令的帮助

选项：

  -conf=<文件名>     指定配置文件（默认：bitcoin.conf）
  -pid=<文件名>      指定 pid （进程 ID）文件（默认：bitcoind.pid）
  -gen               生成比特币
  -gen=0             不生成比特币
  -min               启动时最小化
  -splash            启动时显示启动屏幕（默认：1）
  -datadir=<目录名>  指定数据目录
  -dbcache=<n>       设置数据库缓存大小，单位为兆字节（MB）（默认：25）
  -dblogsize=<n>     设置数据库磁盘日志大小，单位为兆字节（MB）（默认：100）
  -timeout=<n>       设置连接超时，单位为毫秒
  -proxy=<ip:端口>   通过 Socks4 代理链接
  -dns               addnode 允许查询 DNS 并连接
  -port=<端口>       监听 <端口> 上的连接（默认：8333，测试网络 testnet：18333）
  -maxconnections=<n>  最多维护 <n> 个节点连接（默认：125）
  -addnode=<ip>      添加一个节点以供连接，并尝试保持与该节点的连接
  -connect=<ip>      仅连接到这里指定的节点
  -irc               使用 IRC（因特网中继聊天）查找节点（默认：0）
  -listen            接受来自外部的连接（默认：1）
  -dnsseed           使用 DNS 查找节点（默认：1）
  -banscore=<n>      与行为异常节点断开连接的临界值（默认：100）
  -bantime=<n>       重新允许行为异常节点连接所间隔的秒数（默认：86400）
  -maxreceivebuffer=<n>  最大每连接接收缓存，<n>*1000 字节（默认：10000）
  -maxsendbuffer=<n>  最大每连接发送缓存，<n>*1000 字节（默认：10000）
  -upnp              使用全局即插即用（UPNP）映射监听端口（默认：0）
  -detachdb          分离货币块和地址数据库。会增加客户端关闭时间（默认：0）
  -paytxfee=<amt>    您发送的交易每 KB 字节的手续费
  -testnet           使用测试网络
  -debug             输出额外的调试信息
  -logtimestamps     调试信息前添加时间戳
  -printtoconsole    发送跟踪/调试信息到控制台而不是 debug.log 文件
  -printtodebugger   发送跟踪/调试信息到调试器
  -rpcuser=<用户名>  JSON-RPC 连接使用的用户名
  -rpcpassword=<密码>  JSON-RPC 连接使用的密码
  -rpcport=<port>    JSON-RPC 连接所监听的 <端口>（默认：8332）
  -rpcallowip=<ip>   允许来自指定 <ip> 地址的 JSON-RPC 连接
  -rpcconnect=<ip>   发送命令到运行在 <ip> 地址的节点（默认：127.0.0.1）
  -blocknotify=<命令> 当最好的货币块改变时执行命令（命令中的 %s 会被替换为货币块哈希值）
  -upgradewallet     将钱包升级到最新的格式
  -keypool=<n>       将密匙池的尺寸设置为 <n>（默认：100）
  -rescan            重新扫描货币块链以查找钱包丢失的交易
  -checkblocks=<n>   启动时检查多少货币块（默认：2500，0 表示全部）
  -checklevel=<n>    货币块验证的级别（0-6，默认：1）

  -server=1 告知 Bitcoin-QT 接受 JSON-RPC 命令

示例

server=1
rpcuser=user
rpcpassword=user
rpcallowip=47.75.42.52
rpcallowip=47.52.189.164
rpcallowip=172.31.190.56
rpcallowip=172.31.190.55
rpcport=8332

            
----------------------------------------PDCC 节点6启动命令  ------------------------------------


prexd -conf=/root/.PDCC/predix.conf -daemon

----------------------------------------PDCC php 节点  ------------------------------------


composer require denpa/php-bitcoinrpc


-------------------- bitcoin-cli 当配置用户名和密码的时候需要加参数才能进行查询-------------------------

bitcoin-cli -rpcuser=REPLACED -rpcpassword=REPLACED -rpcconnect=127.0.0.1 -rpcport=8332 -datadir=/data/btc getblockchaininfo

bitcoin-cli -rpcuser=user -rpcpassword=user -rpcconnect=0.0.0.0 -rpcport=8332 start getblockchaininfo



------------------------------ bitcoin-cli 使用的为最新版本时会提示有些命令已经删除   ------------------------------

getaccountaddress is deprecated and will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts

在配置文件加入 deprecatedrpc=accounts
或在启动命令后 -deprecatedrpc=accounts

------------------------------ bitcoin-cli 参数  ------------------------------

== Blockchain ==
getbestblockhash
getblock "blockhash" ( verbosity ) 
getblockchaininfo
getblockcount
getblockhash height
getblockheader "hash" ( verbose )
getblockstats hash_or_height ( stats )
getchaintips
getchaintxstats ( nblocks blockhash )
getdifficulty
getmempoolancestors txid (verbose)
getmempooldescendants txid (verbose)
getmempoolentry txid
getmempoolinfo
getrawmempool ( verbose )
gettxout "txid" n ( include_mempool )
gettxoutproof ["txid",...] ( blockhash )
gettxoutsetinfo
preciousblock "blockhash"
pruneblockchain
savemempool
scantxoutset <action> ( <scanobjects> )
verifychain ( checklevel nblocks )
verifytxoutproof "proof"

== Control ==
getmemoryinfo ("mode")
help ( "command" )
logging ( <include> <exclude> )
stop
uptime

== Generating ==
generate nblocks ( maxtries )
generatetoaddress nblocks address (maxtries)

== Mining ==
getblocktemplate ( TemplateRequest )
getmininginfo
getnetworkhashps ( nblocks height )
prioritisetransaction <txid> <dummy value> <fee delta>
submitblock "hexdata"  ( "dummy" )
submitheader "hexdata"

== Network ==
addnode "node" "add|remove|onetry"
clearbanned
disconnectnode "[address]" [nodeid]
getaddednodeinfo ( "node" )
getconnectioncount
getnettotals
getnetworkinfo
getpeerinfo
listbanned
ping
setban "subnet" "add|remove" (bantime) (absolute)
setnetworkactive true|false

== Rawtransactions ==
combinepsbt ["psbt",...]
combinerawtransaction ["hexstring",...]
converttopsbt "hexstring" ( permitsigdata iswitness )
createpsbt [{"txid":"id","vout":n},...] [{"address":amount},{"data":"hex"},...] ( locktime ) ( replaceable )
createrawtransaction [{"txid":"id","vout":n},...] [{"address":amount},{"data":"hex"},...] ( locktime ) ( replaceable )
decodepsbt "psbt"
decoderawtransaction "hexstring" ( iswitness )
decodescript "hexstring"
finalizepsbt "psbt" ( extract )
fundrawtransaction "hexstring" ( options iswitness )
getrawtransaction "txid" ( verbose "blockhash" )
sendrawtransaction "hexstring" ( allowhighfees )
signrawtransaction "hexstring" ( [{"txid":"id","vout":n,"scriptPubKey":"hex","redeemScript":"hex"},...] ["privatekey1",...] sighashtype )
signrawtransactionwithkey "hexstring" ["privatekey1",...] ( [{"txid":"id","vout":n,"scriptPubKey":"hex","redeemScript":"hex"},...] sighashtype )
testmempoolaccept ["rawtxs"] ( allowhighfees )

== Util ==
createmultisig nrequired ["key",...] ( "address_type" )
estimatesmartfee conf_target ("estimate_mode")
signmessagewithprivkey "privkey" "message"
validateaddress "address"
verifymessage "address" "signature" "message"

== Wallet ==
abandontransaction "txid"
abortrescan
addmultisigaddress nrequired ["key",...] ( "label" "address_type" )
backupwallet "destination"
bumpfee "txid" ( options ) 
createwallet "wallet_name" ( disable_private_keys )
dumpprivkey "address"
dumpwallet "filename"
encryptwallet "passphrase"
getaccount (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
getaccountaddress (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
getaddressbyaccount (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
getaddressesbylabel "label"
getaddressinfo "address"
getbalance ( "(dummy)" minconf include_watchonly )
getnewaddress ( "label" "address_type" )
getrawchangeaddress ( "address_type" )
getreceivedbyaccount (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
getreceivedbyaddress "address" ( minconf )
gettransaction "txid" ( include_watchonly )
getunconfirmedbalance
getwalletinfo
importaddress "address" ( "label" rescan p2sh )
importmulti "requests" ( "options" )
importprivkey "privkey" ( "label" ) ( rescan )
importprunedfunds
importpubkey "pubkey" ( "label" rescan )
importwallet "filename"
keypoolrefill ( newsize )
listaccounts (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
listaddressgroupings
listlabels ( "purpose" )
listlockunspent
listreceivedbyaccount (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
listreceivedbyaddress ( minconf include_empty include_watchonly address_filter )
listsinceblock ( "blockhash" target_confirmations include_watchonly include_removed )
listtransactions (dummy count skip include_watchonly)
listunspent ( minconf maxconf  ["addresses",...] [include_unsafe] [query_options])
listwallets
loadwallet "filename"
lockunspent unlock ([{"txid":"txid","vout":n},...])
move (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
removeprunedfunds "txid"
rescanblockchain ("start_height") ("stop_height")
sendfrom (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
sendmany "" {"address":amount,...} ( minconf "comment" ["address",...] replaceable conf_target "estimate_mode")
sendtoaddress "address" amount ( "comment" "comment_to" subtractfeefromamount replaceable conf_target "estimate_mode")
setaccount (Deprecated, will be removed in V0.18. To use this command, start bitcoind with -deprecatedrpc=accounts)
sethdseed ( "newkeypool" "seed" )
settxfee amount
signmessage "address" "message"
signrawtransactionwithwallet "hexstring" ( [{"txid":"id","vout":n,"scriptPubKey":"hex","redeemScript":"hex"},...] sighashtype )
unloadwallet ( "wallet_name" )
walletcreatefundedpsbt [{"txid":"id","vout":n},...] [{"address":amount},{"data":"hex"},...] ( locktime ) ( replaceable ) ( options bip32derivs )
walletlock
walletpassphrase "passphrase" timeout
walletpassphrasechange "oldpassphrase" "newpassphrase"
walletprocesspsbt "psbt" ( sign "sighashtype" bip32derivs )



