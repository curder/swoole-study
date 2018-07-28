<?php

// 连接swoole udp服务
$client = new swoole_client(SWOOLE_SOCK_UDP);
if ($client->connect('0.0.0.0', 9502)  === false) {
    exit('连接swoole_udp服务器失败');
}

fwrite(STDOUT, '请输入消息： ');
$msg = trim(fgets(STDIN));

// 发送消息给swoole的udp服务
if (!$client->send($msg)) {
    exit('发送失败，错误码：'. $client->errCode . "\n\n");
}

// 接收swoole的udp服务器发送的数据
if (!$result = $client->recv()) {
    exit('接收消息失败：错误码：' . $client->errCode . "\n\n");
}

echo $result, "\n\n";
