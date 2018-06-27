

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
docker container run   -d   -p 192.168.0.3:8081:80   --rm   --name mynginx   --volume "$PWD/test.com":/usr/share/nginx/html   nginx
docker container run   -d   -p 192.168.0.3:8081:80   --rm   --name mynginx   --volume "$PWD/test.com":/www/wwwroot/test.com   nginx

等同于下面

  docker container run \
  -d \
  -p 127.0.0.2:8080:80 \
  --rm \
  --name mynginx \
  --volume "$PWD/html":/usr/share/nginx/html \
  nginx