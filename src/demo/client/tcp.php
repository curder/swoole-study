<?php

// 连接swoole tcp服务
$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('0.0.0.0', 9501)) {
    die('连接swoole_tcp服务器失败');
}

fwrite(STDOUT, '请输入消息： ');
$msg = trim(fgets(STDIN));

// 发送消息给swoole的tcp服务
if (!$client->send($msg)) {
    exit('发送失败，错误码：'. $client->errCode);
}

// 接收swoole的tcp服务器发送的数据
$result = $client->recv();

echo $result, "\n\n";
