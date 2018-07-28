## 初始化

### 修改yum源
```
mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
curl -o /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
yum makecache
```

```
yum upgrade
yum install -y gcc wget git autoconf vim pcre-devel gcc-c++ net-tools  libxml2-*
```

## 安装PHP
```
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

## 安装Swoole

### 下载swoole-src源代码
```
cd /vagrant/softwares/ && git clone https://github.com/swoole/swoole-src.git

```

### 编译并安装Swoole

```
cd /vagrant/softwares/swoole-src

/usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config

make && make install
```

### 配置php.ini

```
extension=swoole.so

php -m |grep swoole # 检查swoole是否成功加载
```
