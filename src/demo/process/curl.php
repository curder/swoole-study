<?php

$urls = [
    'https://www.baidu.com',
    'https://sina.com.cn',
    'https://taobao.com',
    'https://qq.com',
    'https://youku.com',
];

echo 'process start time: ' . date('H:i:s'), PHP_EOL;
$workers = [];
for ($i = 0; $i < 5; $i++) {
    $process = new swoole_process(function (swoole_process $worker) use ($urls, $i) {
        $content = curl($urls[$i]);
        $worker->write($content);
    }, true);
    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $process) {
    echo $process->read(); // 读取管道数据
}

echo 'process end time: ' . date('H:i:s'), PHP_EOL;

/**
 * 模拟请求url，耗时1s
 * @param  string $url URL
 * @return string
 */
function curl($url)
{
    sleep(1);
    return $url . PHP_EOL;
}

// Out put:
// process start time: 12:05:55
// https://www.baidu.com
// https://sina.com.cn
// https://taobao.com
// https://qq.com
// https://youku.com
// process end time: 12:05:56
