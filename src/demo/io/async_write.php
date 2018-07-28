<?php

/*
// 简单的异步写文件操作
$content = date('Y-m-d H:i:s') . "\n";

swoole_async_writefile(__DIR__ .'/../../data/static/date.log', $content, function ($filename) {
    echo 'success' . PHP_EOL;
}, FILE_APPEND);

echo 'start write' . PHP_EOL;
*/

// 异步写访问日志内容到文件

$http = new swoole_http_server('0.0.0.0', 9505);

// 配置静态文件目录
$http->set([
    'enable_static_handler' => true, // 启用静态资源处理
    'document_root' => './../data/static', // 设置静态资源默认路径
]);

$http->on('request', function ($request, $response) {
    // 写日志
    $log = [
        'date:' => date('Y-m-d H:i:s'),
        'get:' => $request->get,
        'post:' => $request->post,
        'header:' => $request->header,
    ];

    swoole_async_writefile(__DIR__ . '/../../data/static/access.log', json_encode($log) . PHP_EOL, function () {
    }, FILE_APPEND);

    $response->end('<h1>Async Write access log/h1>');
});

// 开启服务
$http->start();
