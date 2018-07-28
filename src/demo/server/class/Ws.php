<?php


class Ws
{
    const HOST = '0.0.0.0';
    const PORT = '9504';

    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, 'onClose']);
        $this->ws->start();
    }

    /**
    * 监听websocket打开事件
    * @param  swoole_websocket_server $server  [description]
    * @param  [type]                  $request [description]
    * @return string
    */
    public function onOpen($ws, $request)
    {
        echo "server: handshake success with fd#{$request->fd}\n";
    }

    /**
     * 监听websocket消息事件
     * @param swoole_websocket_server $server [description]
     * @param [type]                  $frame  [description]
     */
    public function onMessage($ws, $frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $ws->push($frame->fd, "server push success.");
    }

    /**
     * 客户端关闭连接事件
     * @param  [type] $ser [description]
     * @param  [type] $fd  [description]
     * @return [type]      [description]
     */
    public function onClose($ser, $fd)
    {
        echo "client {$fd} closed\n";
    }
}

$ws = new Ws();
