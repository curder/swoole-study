<?php

$http = new swoole_http_server('0.0.0.0', 9503);

$http->on('request', function ($request, $response) {
    // 获取get数据
    $get = $request->get;
    // 获取post数据
    $post = $request->post;

    // 设置cookie
    $response->cookie('client_user_cookie', json_encode(['user'=>['name'=>'curder', 'age'=>28]]), time() + 3600);

    $response->end('<h1>HttpServer</h1>' . json_encode(['get' => $get, 'post' => $post]));
});

// 开启服务
$http->start();
