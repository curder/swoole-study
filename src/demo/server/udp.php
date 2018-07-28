<?php

//创建Server对象，监听 0.0.0.0:9502端口，类型为SWOOLE_SOCK_UDP
$serv = new swoole_server("0.0.0.0", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

//监听数据接收事件
$serv->on('packet', function ($serv, $data, $clientInfo) {
    $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server " . $data);
    print_r($clientInfo);
    echo "\n\n";
});

//启动服务器
$serv->start();
