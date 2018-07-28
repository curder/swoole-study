<?php
$server = new swoole_websocket_server("0.0.0.0", 9504);

// 配置静态文件目录
$server->set([
    'enable_static_handler' => true, // 启用静态资源处理
    'document_root' => './../../data/static', // 设置静态资源默认路径
    'worker_num' => 8, // worker进程数
    'max_request' => 10000, // 处理的最大进程数
]);

$server->on('open', 'onOpen');

$server->on('message', 'onMessage');

$server->on('close', 'onClose');

$server->start();

/**
 * 监听websocket打开事件
 * @param  swoole_websocket_server $server  [description]
 * @param  [type]                  $request [description]
 * @return string
 */
function onOpen(swoole_websocket_server $server, $request)
{
    echo "server: handshake success with fd#{$request->fd}\n";
}

/**
 * 监听websocket消息事件
 * @param  swoole_websocket_server $server [description]
 * @param  [type]                  $frame  [description]
 */
function onMessage(swoole_websocket_server $server, $frame)
{
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "server push success.");
}

/**
 * 客户端关闭连接事件
 * @param  [type] $ser [description]
 * @param  [type] $fd  [description]
 * @return [type]      [description]
 */
function onClose($ser, $fd)
{
    echo "client {$fd} closed\n";
}
