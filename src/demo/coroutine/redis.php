<?php

// 协程
// 使用同步的代码，实现异步IO的操作

$http = new swoole\Http\Server('0.0.0.0', 9505);

$http->on('request', function ($request, $response) {
    $redis = new Swoole\Coroutine\Redis;

    $host = '127.0.0.1';
    $port = 6379;
    $redis->connect($host, $port);

    $key = $request->get['key'];
    $value = $redis->get($key);

    $response->header('Content-Type', 'text/plain');
    $response->end($value);
});

$http->start();
