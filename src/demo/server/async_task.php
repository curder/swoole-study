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
        $this->ws->set(['worker_num'=> 2,'task_worker_num' => 2]); // 设置异步任务的工作进程数量
        $this->ws->on('task', [$this, 'onTask']); // 监听异步任务事件
        $this->ws->on('finish', [$this, 'onFinish']); // 监听异步任务处理完成事件
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

        // 异步任务
        $data = [
            'task_id' => 1,
            'fd' => $frame->fd,
        ];
        $ws->task($data);

        $ws->push($frame->fd, "server push success.");
    }

    public function onTask($ws, $task_id, $src_worker_id, $data)
    {
        print_r($data);
        // 模拟程序耗时5s
        sleep(5);
        return 'task success.';
    }

    public function onFinish($ws, $task_id, $data)
    {
        echo "task_id: $task_id \n\n";

        echo "task return data: {$data} \n\n";
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
