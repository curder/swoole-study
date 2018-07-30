## 初始化

### 修改yum源
```
mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
curl -o /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
yum makecache
```

```
sudo yum upgrade
sudo yum install -y gcc wget git autoconf vim pcre-devel gcc-c++ net-tools psmisc libxml2-*
```

## 安装PHP
```
mkdir /vargrant/softwares
cd /vagrant/softwares && wget -O php-7.2.8.tar.gz http://hk2.php.net/get/php-7.2.8.tar.gz/from/this/mirror

tar xf php-7.2.8.tar.gz && cd php-7.2.8

./configure --prefix=/usr/local/php-7.2.8 # 编译php

make && make install # 安装php
```

## 配置PHP

### 配置php软连接

```
ln -s /usr/local/php-7.2.8 /usr/local/php
```

### 从源码目录中拷贝`php.ini`文件

```
cp /vagrant/softwares/php-7.2.8/php.ini-production /usr/local/php/lib/php.ini
```

### 命令行别名

```
echo 'alias php="/usr/local/php/bin/php"' >> ~/.bash_profile
source ~/.bash_profile
```

## 安装redis

```
cd /vagrant/softwares && wget -O redis-4.0.10.tar.gz http://download.redis.io/releases/redis-4.0.10.tar.gz

tar xf redis-4.0.10.tar.gz && cd redis-4.0.10

make && make PREFIX=/usr/local/redis-4.0.10 install

ln -s /usr/local/redis-4.0.10 /usr/local/redis

mkdir -p /usr/local/redis/conf && cp /vagrant/softwares/redis-4.0.10/redis.conf /usr/local/redis/conf/.

sed -i 's/daemonize no/daemonize yes/g' /usr/local/redis/conf/redis.conf # 后台运行Redis

/usr/local/redis/bin/redis-server /usr/local/redis/conf/redis.conf # 启动Redis
```


### 安装hiredis

> 安装hiredis，使swoole支持异步redis

```
cd /vagrant/softwares && wget -O hiredis-0.13.3.tar.gz https://github.com/redis/hiredis/archive/v0.13.3.tar.gz
tar xf hiredis-0.13.3.tar.gz && cd hiredis-0.13.3

make -j && sudo make install
sudo ldconfig
```
> 餐考这里： [https://wiki.swoole.com/wiki/page/p-redis.html](https://wiki.swoole.com/wiki/page/p-redis.html)

## 安装Swoole


### 下载swoole-src源代码
```
cd /vagrant/softwares/ && git clone https://github.com/swoole/swoole-src.git

```

### 编译并安装Swoole

```
cd /vagrant/softwares/swoole-src && make clean

/usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config --enable-async-redis

make && make install
```

### 配置php.ini

```
extension=swoole.so

php -m |grep swoole # 检查swoole是否成功加载
php --ri swoole | grep "async redis client" # 检查是否支持异步redis
```

## 一些命令

```
ps aft |grep php # 查看进程数量
pstree -p process_code # 查看进程树
```
