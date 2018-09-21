<?php		
/*生成 SSH 公钥
如前所述，许多 Git 服务器都使用 SSH 公钥进行认证。 为了向 Git 服务器提供 SSH 公钥，如果某系统用户尚未拥有密钥，必须事先为其生成一份。 这个过程在所有操作系统上都是相似的。 首先，你需要确认自己是否已经拥有密钥。 默认情况下，用户的 SSH 密钥存储在其 ~/.ssh 目录下。 进入该目录并列出其中内容，你便可以快速确认自己是否已拥有密钥：
*/
$ cd ~/.ssh
$ ls
/*authorized_keys2  id_dsa       known_hosts
config            id_dsa.pub
我们需要寻找一对以 id_dsa 或 id_rsa 命名的文件，其中一个带有 .pub 扩展名。 .pub 文件是你的公钥，另一个则是私钥。 如果找不到这样的文件（或者根本没有 .ssh 目录），你可以通过运行 ssh-keygen 程序来创建它们。在 Linux/Mac 系统中，ssh-keygen 随 SSH 软件包提供；在 Windows 上，该程序包含于 MSysGit 软件包中。*/
$ ssh-keygen
/*Generating public/private rsa key pair.
Enter file in which to save the key (/home/schacon/.ssh/id_rsa):
Created directory '/home/schacon/.ssh'.
Enter passphrase (empty for no passphrase):
Enter same passphrase again:
Your identification has been saved in /home/schacon/.ssh/id_rsa.
Your public key has been saved in /home/schacon/.ssh/id_rsa.pub.
The key fingerprint is:
d0:82:24:8e:d7:f1:bb:9b:33:53:96:93:49:da:9b:e3 schacon@mylaptop.local
首先 ssh-keygen 会确认密钥的存储位置（默认是 .ssh/id_rsa），然后它会要求你输入两次密钥口令。php*/

****如果你不想在使用密钥时输入口令，将其留空即可****。  如果输入密码github所建的仓库每次推送都会要求输入该密码
/*
现在，进行了上述操作的用户需要将各自的公钥发送给任意一个 Git 服务器管理员（假设服务器正在使用基于公钥的 SSH 验证设置）。 他们所要做的就是复制各自的 .pub 文件内容，并将其通过邮件发送。 公钥看起来是这样的：
*/
$ cat ~/.ssh/id_rsa.pub




/*----------------------------------------   git 命令行基本操作  ------------------------------------*/
/*
1.创建新的文件夹 							$ mdkir test
2.进入文件夹  							$ git init
3.创建本地分支然后从地址拉取 				$ git remote add master1 仓库地址 
4.添加文件或文件夹跟踪  					$ git add . (每次提交都需要git add .     .代表追踪全部)
5.拉取文件从地址  						$ git pull 地址 
6.提交修改 								$ git commit -m '提交信息'
7.选择推送分支							$ git push master 
8.设置分支								$ git push --set-upstream master1 master
9.推送之前最好先拉取一下 					$ git pull
10.查看两个分支有何不同					$ git log branch_1...branch2
11.分支创建分支：             			$ git branch mybranch
12.查看日志								$ git log　　　　　
　
--查看修改历史 git show <hash值> 可以显示出这条commit修改的内容。
(git log内容其中commit后面的64个字符16进制的字符串，称为commit hash, 是这条的commit的唯一标识，全球唯一)
	commit 85b6d9de45e4efe8220508f845a2a3d11ca609b2
　　Author: YuanSuyi<tech31@hzdusun.com>
　　Date:   Mon May 22 14:51:13 2017 +0800

12.git reset --hard　　　　　　
--撤消一切本地的修改，将本地目录恢复为最后一次提交时的状态。包括被修改的文件，删除的文件都会被恢复原样。我们称之为hard reset。

13.git branch -a  查看远程分支

14.git checkout xf  切换本地分支：git checkout <分支名>

15.git pull origin xf:xf   把远程分支的代码pull到本地分支：git pull <远程主机名> <远程分支名>:<本地分支名>

16.git push origin xf:xf   最后一步：git push <远程主机名> <本地分支名>:<远程分支名>

第二种写法 :git push origin test
如果省略远程分支名，则表示将本地分支推送与之存在"追踪关系"的远程分支（通常两者同名），如果该远程分支不存在，则会被新建。
17.git branch -d 分支名  删除本地分支

18.git push origin --delete 分支名   删除远程分支,若分支有修改还未合并，会提示你还没合并
   git branch -D Su-modify 强行删除本地分支

/*-----------------------   git GIT PUSH/PULL时总需要输入用户名密码的解决方案  ------------------------*/
/*
1.git config --global credential.helper store  
2.git push origin your-branch
会让你输入用户名和密码，这时你输入就好了，然后下次再git push /pull 的时候就不用密码了

检验方式：C:\Users\你的电脑名;   这个文件夹(如下)下面是否能找到.git-credentials文件，
如果文件的内容是有关你的gitlab的设置，格式为：http://{用户名}:{密码}@{git 网址}



/*-----------------------   git 搭建钩子  ------------------------*/

/*
第一种

  钩子只是在你提交或推送的时候一种事件 
  在第三方的git服务器上 都有设置回调脚本路径的地方  webhook  阿里code和github都有  脚本内容 
  
  此脚本需要执行shell 作者用的是宝塔插件 宝塔hooks触发的

  脚本内容
  cd /www/wwwroot/www.aaa.com/
  git pull
  chown -R www:www ./*
  
   此方法简单粗暴
 
第二种  自己搭建git 服务器 自己创建钩子

安装git
1.查看yum源仓库git信息：

 yum info git
初始化的阿里云contos7的yum是1.8.3.1版本的；和官网不匹配；

2.依赖库安装
yum install curl-devel expat-devel gettext-devel openssl-devel zlib-deve
yum install gcc perl-ExtUtils-MakeMaker
3.卸载低版本git（未安装可跳过）

通过命令：git –-version 查看系统带的版本，Git 版本是： 1.8.3.1，所以先要卸载低版本的 Git，命令：
 yum remove git;

3.下载最新版git源码包

cd  /usr/local/git       #进入文件位置，自定义，个人安装包存放位置,

wget https://github.com/git/git/archive/v2.9.2.tar.gz #下载最新源码包

tar -xzvf v2.9.2.tar.gz                    #解压目录
cd git-2.9.2
# make prefix=/usr/local/git all
# make prefix=/usr/local/git install        #进行编译安装

vi /etc/profile      #添加环境变量 
export PATH="/usr/local/git/bin:$PATH"      #添加到文本中；
source /etc/profile   #是配置立即生效
git --version        #查看版本号
将git设置为默认路径，不然后面克隆时会报错
ln -s /usr/local/git/bin/git-upload-pack /usr/bin/git-upload-pack 
ln -s /usr/local/git/bin/git-receive-pack /usr/bin/git-receive-pack 


服务器自己搭建git服务器的时候最需要注意的一点就是git权限 
有的服务器在安装git软件的时候默认有git用户 而有的不会创建git用户
这个时候需要手动创建git 
$ groupadd git
$ useradd git -g git
$ passwd git  给git设置密码
(完工之后要将git用户改成不可登录状态 /etc/passwd/ 只能执行shell即可 自行百度)

在Git服务器上首先需要将/etc/ssh/sshd_config中将RSA认证打开，(高版本的git 有RSA 低版本没有)
1.RSAAuthentication yes
2.PubkeyAuthentication yes
3.AuthorizedKeysFile .ssh/authorized_keys

进入/home/git/ 
创建.ssh文件夹 

cd /home/git/
$ mkdir .ssh #新建文件夹
$ chmod 700 .ssh 
$ touch .ssh/authorized_keys  #新建文件
$ chmod 600 .ssh/authorized_keys

初始化仓库
$ cd /home/git
$ git init --bare ceshi.git   也可使用git init  ceshi.git  这两种方式区别
(--bare 不会有节点的文件,只保存节点合并提交推送等记录,而不会保存文件,这种比较推荐,且不容易出错,直接init也可以使用)


在进行git 搭建的时候最好使用git用户这样权限不会错
如果使用root用户 在创建之后需要将/home/git/下的文件改成git权限  chown -R git:git ./*

因为本地push 的时候是git执行的shell 要在本地和服务器生成ssh 将公钥导入到/home/git/.ssh/authorized_kyes文件里
并且 网站目录git要有权限进入 可以将git用户加入到网站用户的组中

网站目录

/www/wwwroot/test.com
git clone git@127.0.0.1:/home/git/ceshi.git
会提示拉取了一个空的仓库

最好创建一个README.md文件 提交一次 这样就会默认生成master分支  以免本地提交git失败


服务器/home/git/hooks/post-update 文件内容  
没有就创建 有就将.smaple后缀去掉 然后修改内容 
文件在从本地推送到服务器的时候会触发此文件
要将其改为可执行 chmod +x ./post-update  
如果是root用户创建的文件需要将其 chown -R git:git ./*

#!/bin/bash
#  
# An example hook script for the "post-receive" event.  
#  
# The "post-receive" script is run after receive-pack has accepted a pack  
# and the repository has been updated.  It is passed arguments in through  
# stdin in the form  
#  <oldrev> <newrev> <refname>  
# For example:  
#  aa453216d1b3e49e7f6f98441fa56946ddcd6a20 68f7abf4e6f922807889f52bc043ecd31b79f814 refs/heads/master  
#  
# see contrib/hooks/ for a sample, or uncomment the next line and  
# rename the file to "post-receive".  

#. /usr/share/git-core/contrib/hooks/post-receive-email  
cd /www/wwwroot/xiaochengxu.com/
unset GIT_DIR
whoami
git pull
 */

//unset GIT_DIR  因为git在进入此文件的时候作用git域是/home/git 所以unset
//whoami 是输出当前用户

//其中一定要细心  可能会出错误 要认真检查和分析 权限和公钥  我做的时候弄了好几遍,比较笨....

/*参考文献 
 https://blog.csdn.net/naruto227/article/details/53750282
 https://blog.csdn.net/sfnes/article/details/79063805
 https://blog.csdn.net/baidu_30000217/article/details/51327289

 前面三篇都是讲解搭建服务器git和完成钩子的

 https://www.cnblogs.com/alex-415/p/6912294.html  新仓库拉取失败解决办法

 https://blog.csdn.net/ljchlx/article/details/21805231   init --bare  和 init 区别

 https://my.oschina.net/shede333/blog/299032  给git添加多个仓库 
 我觉得这也是一种实现方式  只需要本地同时向两个仓库推送 也能达到同步到服务器网站的效果  还没有实践  后续更新

 最简单的就是通过第三方提供的脚本回调也就是第一种
/*----------------------------------------   git 添加秘钥  ------------------------------------*/

/*通过ssh连接的时候要向目标服务器添加ssh秘钥 

ssh-keygen -t rsa -C "chinesebigcabbage@163.com"

连续按回车即可  如果本地已经有了会提示是否覆盖

这个时候生成的秘钥是在当前用户家目录下的 .ssh文件里

有个需要区分的事情 
当你用钩子时如果执行shell拉取事件的是git用户需要将git用户的ssh私钥也加入到目标git服务器 
 
 给git用户也生成一个ssh秘钥
 sudo -u git ssh-keygen -t rsa -C "chinesebigcabbage@163.com" 
 此时的秘钥位置在/hoem/git/.ssh/下
 一定要去分开秘钥位置和用户  进行clone 或者push 操作时只会检测当前用户的秘钥  如果对应git服务器没有则会权限被拒绝

 私有的项目clone需要秘钥 公开的项目clone不需要但是push 需要  

/*----------------------------------------   git fatal: refusing to merge unrelated histories  致命的：拒绝合并不相关的历史------------------------------------*/
 
/*
我在Github新建一个仓库，写了License，然后把本地一个写了很久仓库上传。

先pull，因为两个仓库不同，发现refusing to merge unrelated histories，无法pull

因为他们是两个不同的项目，要把两个不同的项目合并，git需要添加一句代码，在git pull，
这句代码是在git 2.9.2版本发生的，最新的版本需要添加

 --allow-unrelated-histories

 git pull origin master --allow-unrelated-histories


/*----------------------------------------   git 放弃修改 ------------------------------------*/
/*
git checkout -- 文件名
