<?php
$redis_client = new swoole_redis;

$host = '127.0.0.1';
$port = 6379;

$redis_client->connect($host, $port, function ($redis, $result) {
    echo 'connect success.' . PHP_EOL;

    // 设置key
    $redis->set('time', time(), function ($redis, $result) {
        echo $result, PHP_EOL;
    });

    // 获取key
    $redis->get('time', function ($redis, $result) {
        echo $result, PHP_EOL;
    });

    // 获取所有key
    $redis->keys('*', function ($redis, $result) {
        print_r($result);
        echo PHP_EOL;
    });

    // 清空redis
    $redis->flushdb(function ($redis, $result) {
        var_dump($result);
    });

    $redis->close();
});

echo "start." . PHP_EOL;

// start.
// connect success.
// OK
// 1532863822
// Array
// (
//     [0] => time
// )

// string(2) "OK"
