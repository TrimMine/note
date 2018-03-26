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
1.创建新的文件夹 						$ mdkir test
2.进入文件夹  							$ git init
3.创建本地分支然后从地址拉取 			$ git remote add master1 仓库地址 
4.添加文件或文件夹跟踪  				$ git add . (每次提交都需要git add .     .代表追踪全部)
5.拉取文件从地址  						$ git pull 地址 
6.提交修改 								$ git commit -m '提交信息'
7.选择推送分支							$ git push master 
8.设置分支								$ git push --set-upstream master1 master
9.推送之前最好先拉取一下 				$ git pull
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
/*-----------------------   git GIT PUSH/PULL时总需要输入用户名密码的解决方案  ------------------------*/
/*
1.git config --global credential.helper store  
2.git push origin your-branch
会让你输入用户名和密码，这时你输入就好了，然后下次再git push /pull 的时候就不用密码了

检验方式：C:\Users\你的电脑名;   这个文件夹(如下)下面是否能找到.git-credentials文件，
如果文件的内容是有关你的gitlab的设置，格式为：http://{用户名}:{密码}@{git 网址}