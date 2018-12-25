

# No.1--------------------------- 查找可用镜像列表 ---------------------------

docker search name   
docker search ngixn

#下载安装
docker pull nginx

# No.2--------------------------- 查看本地已下载镜像 ---------------------------
docker images

运行镜像
docker container run hello-world   #如果本地没有此容器 会自动拉取该容器
docker run hello-world   #如果本地没有此容器 会自动拉取该容器
一般的容器运行后会自动停止
但是一些特殊的容器是不会停止的 比如 ubantu 的bash
对于不会终止的容器可采用
docekr container kill NAME_ID
# No.3--------------------------- 修改镜像源地址 ---------------------------

镜像源
<< 'Notes' 
1.Docker 官方中国区
https://registry.docker-cn.com
2.网易
http://hub-mirror.c.163.com
3.ustc
https://docker.mirrors.ustc.edu.cn
Notes
修改方法

#1.直接设置 –registry-mirror 参数，仅对当前的命令有效 
docker run hello-world --registry-mirror=https://docker.mirrors.ustc.edu.cn

2.支持 systemctl 的系统，通过 sudo systemctl edit docker.service，会生成 etc/systemd/system/docker.service.d/override.conf 覆盖默认的参数，在该文件中加入如下内容： 
[Service] 
ExecStart= 
ExecStart=/usr/bin/docker -d -H fd:// --registry-mirror=https://docker.mirrors.ustc.edu.cn
3.新版的 Docker 推荐使用 json 配置文件的方式，默认为 /etc/docker/daemon.json，非默认路径需要修改 dockerd 的 –config-file，在该文件中加入如下内容： 
{ 
"registry-mirrors": ["https://docker.mirrors.ustc.edu.cn"] 
}

# No.3--------------------------- 查看 删除容器 ---------------------------

#查看 -a 参数可查看隐藏的容器
docker ps -a    

#删除  加入-f可强制删除 不加入-f不能删除正在运行的容器 一般不要加-f
docker rm names  

#删除镜像
docker rmi name   #imageID的名字 -f强制


# No.4--------------------------- 启动nginx容器 ---------------------------


#其中 127.0.0.2 这个ip需要填自己的内网ip 使用ifconfig查看

#如果把这个容器终止，由于--rm参数的作用，容器文件会自动删除。

-d：在后台运行
-p ：容器的80端口映射到127.0.0.2:8080
--rm：容器停止运行后，自动删除容器文件  如果经常使用 不要加--rm参数
--name：容器的名字为mynginx

docker container run   -d   -p 192.168.0.3:8081:80   --rm   --name mynginxss   nginx

等同于下面

  docker container run \
  -d \
  -p 127.0.0.2:8080:80 \
  --rm \
  --name mynginx \
  nginx

#启动nginx 并映射目录到nginx下  test.com 是创建的网站文件夹 $PWD是我的位置
docker container run   -d   -p 192.168.8.102:80   --rm   --name mynginx   --volume "$PWD/test.com":/www/wwwroot/test.com   nginx

docker run --name mynginx -d -p 8080:80  -v /Users/cabbage/Code/docker_data/nginx/conf/nginx.conf:/etc/nginx/nginx.conf  -v /Users/cabbage/Code/docker_data/nginx/logs:/var/log/nginx -d docker.io/nginx
docker run --detach \
    --name localnginx \
    --publish 127.0.0.1:80:80 \
    --link dkphp:php \
    -v /Users/cabbage/Code/docker_data/www:/usr/share/nginx/html \
    -v /Users/cabbage/Code/jbs:/usr/share/nginx/www \
    -v /Users/cabbage/Code/docker_data/nginx/conf/nginx.conf:/etc/nginx/nginx.conf:rw \
    -v /Users/cabbage/Code/docker_data/nginx/conf/enable-php-71.conf:/etc/nginx/enable-php-71.conf:rw \
    -v /Users/cabbage/Code/docker_data/nginx/conf/fastcgi.conf:/etc/nginx/fastcgi.conf:rw \
    -v /Users/cabbage/Code/docker_data/nginx/conf/pathinfo.conf:/etc/nginx/pathinfo.conf:rw \
    -v /Users/cabbage/Code/docker_data/nginx/conf/vhost:/etc/nginx/conf.d \
    -v /Users/cabbage/Code/docker_data/nginx/logs/error.log:/var/log/nginx/error.log:rw \
    -d nginx
进入该镜像命令行  docker exec -i -t  localnginx /bin/bash

docker container run   -d   -p 192.168.8.102:80     --name mynginx   --volume "$PWD/www":/www/wwwroot/test.com   nginx

等同于下面

  docker container run \
  -d \
  -p 127.0.0.2:8080:80 \
  --rm \
  --name mynginx \
  --volume "$PWD/html":/usr/share/nginx/html \
  nginx

启动 php-fpm

# No.5--------------------------- 容器的操作 ---------------------------


docker ps         # 查看正在运行的容器
docker ps -a      # 查看所有容器
docker ps -l      # 查看最近一次运行的容器

docker create 容器名或者容器ID    # 创建容器
docker start [-i] 容器名        # 启动容器
docker run 容器名或者容器ID       # 运行容器，相当于docker create + docker start
docker attach 容器名或者容器ID bash     # 进入容器的命令行（退出容器后容器会停止）
docker exec -it 容器名或者容器ID bash   # 进入容器的命令行
docker stop 容器名                    # 停止容器
docker rm 容器名                      # 删除容器

docker top 容器名                    # 查看WEB应用程序容器的进程
docker inspect 容器名                # 查看Docker的底层信息

进入容器内部
docker exec -it nginx1.0 bash


docker run -d --name ethereum-node -v /Users/alice/ethereum:/root -p 8545:8545 -p 30303:30303 ethereum/client-go

# No.6--------------------------- PHP 容器 ---------------------------

拉取容器
docker pull php:7.1-fpm
查看
docker images 

解释执行 php 需要 php-fpm，先让它运行起来：

docker run --name dkphp -d \
    -v  /Users/cabbage/Code/jbs:/var/www/html:ro \
    php:7.1-fpm

# No.7--------------------------- 安装centos容器 安装宝塔 bt ---------------------------



1.拉取纯净系统镜像
docker pull centos:7.2.1511

2.启动镜像，映射主机与容器内8888端口  
docker 开启范围端口可以这样写 -p 35000-36000:35000-36000  如果镜像名称一致后面可以跟镜像的标志 默认是 latest
docker run -i -t -d --name bt-pure -p 20:20 -p 21:21 -p 80:80 -p 8080:8080  -p 8081:8081 -p 8332:8332 -p 8545:8545  -p 443:443 -p 888:888 -p 3306:3306 -p 8888:8888 --privileged=true -v /Users/cabbage/Code/jbs:/www/wwwroot chinesebigcabbage/bt-pure:latest  

docker run -i -t -d --name bt-v6 -p 20:20 -p 21:21 -p 22:22 -p 80:80 -p 8080:8080  -p 8081:8081 -p 8332:8332 -p 8545:8545  -p 443:443 -p 888:888 -p 3306:3306 -p 8888:8888 -p 9500-9520:9500-9520  -p 39000-39500:39000-39500 --privileged=true -v /Users/cabbage/Code/jbs:/www/wwwroot chinesebigcabbage/bt-v6:2018-12-v6

此处安装的镜像为centos安装宝塔后的镜像 如果有ftp服务需要修改 ftp被动模式的端口范围
3.查看容器id，并进入容器
docker exec -it 容器ID bash

4.执行宝塔面板Centos安装命令 (可选择其他linux版本安装 必须和系统版本对应)
安装必要的软件
yum check-update -y && yum update -y && yum install initscripts screen wget -y 

yum install -y wget && wget -O install.sh http://download.bt.cn/install/install.sh && sh install.sh



https://www.cnblogs.com/Basu/p/7945166.html 摘自

# No.7--------------------------- 制作自己的镜像 ---------------------------
https://www.cnblogs.com/wherein/p/6862911.html 转自

1.将自己本地的容易提交
docker ps -a 查看容器id
提交容器
docker commit 容器ID chinesebigcabbage/bt-pure 

2.登录dockerhup 账户 
docker login 
输入账号 密码 如果没有的话需要去注册一下  (https://hub.docker.com/)
3.推送到仓库(latest(最新的) tag备注)  如果比较大 推送过程可能会断 就再次push一下 会自动断点续传
docker push chinesebigcabbage/bt-pure:latest

4.现在验证一下是否有次镜像 
docker inspect wherein/ubuntu

5.最后看一下你的hub中的tags 是否有了新的更新
我们用的镜像都是公共的 私有的需要付费

 重命名镜像名称
 docker tag IMAGEID(镜像id) REPOSITORY:TAG（仓库：标签）
 docker tag 722ee4cff42c chinesebigcabbage/bt-pure:new
