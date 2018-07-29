<?php

$http = new swoole_http_server('0.0.0.0', 9506);

// 配置静态文件目录
$http->set([
    'enable_static_handler' => true, // 启用静态资源处理
    'document_root' => __DIR__ . '/../public/static', // 设置静态资源默认路径
    'worker_num' => 8,
]);

$http->on('workerStart', function ($server, $worker_id) {
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');
    // 加载框架引导文件
    require __DIR__ . '/../thinkphp/base.php';
});

$http->on('request', function ($request, $response) {
    $_SERVER = [];
    // 适配ThinkPHP框架
    if (isset($request->server)) {
        foreach ($request->server as $key => $value) {
            $_SERVER[strtoupper($key)] = $value;
        }
    }
    $_GET = [];
    if (isset($request->get)) {
        foreach ($request->get as $key => $value) {
            $_GET[$key] = $value;
        }
    }
    $_POST = [];
    if (isset($request->post)) {
        foreach ($request->post as $key => $value) {
            $_POST[$key] = $value;
        }
    }

    ob_start();

    // 执行应用并响应
    try {
        think\Container::get('app', [APP_PATH])->run()->send();
    } catch (\Exception $e) {
    }

    $content = ob_get_contents();
    ob_end_clean();

    $response->end($content);
});

// 开启服务
$http->start();
