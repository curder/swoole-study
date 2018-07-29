<?php

$http = new swoole_http_server('0.0.0.0', 9506);

// 配置静态文件目录
$http->set([
    'enable_static_handler' => true, // 启用静态资源处理
    'document_root' => __DIR__ . '/../public/static', // 设置静态资源默认路径
]);

$http->on('request', function ($request, $response) {
    $response->end('<h1>HttpServer</h1>');
});

// 开启服务
$http->start();
