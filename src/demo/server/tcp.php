<?php

//创建Server对象，监听 0.0.0.0:9501端口
$serv = new swoole_server("0.0.0.0", 9501);

$serv->set([
    'worker_num' => 8, // worker进程数
    'max_request' => 10000, // 处理的最大进程数
]);

/**
 * 监听连接进入事件
 * @serv swoole_server对象
 * @fd TCP客户端连接的唯一标识符
 * @reactor_id TCP连接所在的Reactor线程ID
 */
$serv->on('connect', function ($serv, $fd, $reactor_id) {
    echo "Client: {$reactor_id} = {$fd} - Connect.\n";
});

/**
 * 监听数据接收事件
 *
 * @serv swoole_server对象
 * @fd TCP客户端连接的唯一标识符
 * @reactor_id TCP连接所在的Reactor线程ID
 * @data 收到的数据内容，可能是文本或者二进制内容
 */
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "Server: {$reactor_id} = {$fd} - ".$data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();
