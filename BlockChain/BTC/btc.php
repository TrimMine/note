<?php
/*
------------------------------ BTC安装  ------------------------------
我的服务器是 centos  ubantu和debian 参考官方文档 https://github.com/bitcoin/bitcoin/blob/master/doc/build-unix.md
可安装的库 
sudo dnf install gcc-c++ libtool make autoconf automake openssl-devel libevent-devel boost-devel libdb4-devel libdb4-cxx-devel

如果你是基于最小化安装的linux系统，需要执行如下命令，安装必要的库，如果是安装过的可以跳过此步骤 

yum -y install wget vim git texinfo patch make cmake gcc gcc-c++ gcc-g77 flex bison file libtool boost-devel libtool-libs automake autoconf kernel-devel libjpeg libjpeg-devel libpng libpng-devel libpng10 libpng10-devel gd gd-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glib2 glib2-devel bzip2 bzip2-devel libevent libevent-devel ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel krb5 krb5-devel libidn libidn-devel openssl openssl-devel vim-minimal nano fonts-chinese gettext gettext-devel ncurses-devel gmp-devel pspell-devel unzip libcap diffutils vim lrzsz net-tools

源码编译和下载二进制两种 安装方法

一.源码编译
	
	没有git 要安装git centos 安装git yum install  git 
	
	1- git clone git@github.com:bitcoin/bitcoin.git

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
	configure: error: libdb_cxx headers missing, Bitcoin Core requires this library for wallet functionality (--disable-wallet to disable wallet functionality)
	
	根据文章https://blog.csdn.net/terminatorsong/article/details/74089911 如下解决方案

    看了下文档，提示需要libdb5.1。查查问题的时候都是关于bitcoin的，提到的都是要使用BerkeleyDb4.8NC。CentOS没有libdb，只能手动安装BerkeleyDb5.1。在doc/build-unix.md文档里有详细的说明，按说明操作安装即可。

	wget 'http://download.oracle.com/berkeley-db/db-5.1.29.NC.tar.gz'
	echo '08238e59736d1aacdd47cfb8e68684c695516c37f4fbe1b8267dde58dc3a576c db-5.1.29.NC.tar.gz' | sha256sum -c  效验下载的压缩包完整性
	tar -xzvf db-5.1.29.NC.tar.gz 
	cd db-5.1.29.NC/build_unix/
	../dist/configure --enable-cxx --disable-shared --with-pic --prefix=/usr/local
	make install

	报错  
	configure: error: Found Berkeley DB other than 4.8, required for portable wallets (--with-incompatible-bdb to ignore or --disable-wallet to disable wallet functionality)
    加上编译参数 --with-incompatible-bdb

    报错
    configure: error: No working boost sleep implementation found.
    yum install boost-devel


    最后
    make 
    make install

    创建软链  可省略看个人喜好
    ln -s ~/btc/bitcoin/src/bitcoin-cli /usr/bin/btc  
    ln -s ~/btc/bitcoin/src/bitcoind /usr/bin/btc-start

    btc-start -daemon #后台启动 如果没有创建软链就使用 bitcoind -daemon 
   
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
-rpcallowip=   允许来自指定 地址的 JSON-RPC 连接
-rpcconnect=   发送命令到运行在 地址的节点（默认：127.0.0.1）
-blocknotify=<命令> 当最好的货币块改变时执行命令（命令中的 %s 会被替换为货币块哈希值）
-upgradewallet     将钱包升级到最新的格式
-keypool=       将密匙池的尺寸设置为 （默认：100）
-rescan            重新扫描货币块链以查找钱包丢失的交易
-checkblocks=   启动时检查多少货币块（默认：2500，0 表示全部）
-checklevel=    货币块验证的级别（0-6，默认：1）

----------------------------------------PDCC 节点6启动命令  ------------------------------------


prexd -conf=/root/.PDCC/predix.conf -daemon



-------------------- bitcoin-cli 当配置用户名和密码的时候需要加参数才能进行查询-------------------------

bitcoin-cli -rpcuser=REPLACED -rpcpassword=REPLACED -rpcconnect=127.0.0.1 -rpcport=8332 -datadir=/data/btc getblockchaininfo

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



