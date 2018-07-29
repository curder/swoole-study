<?php

// 进程
$process = new swoole_process('callback_function', true);

$pid = $process->start();

echo $pid, PHP_EOL;


function callback_function(swoole_process $worker)
{
    $worker->exec('/usr/local/php/bin/php', [__DIR__ . '/../server/http.php']);
}

swoole_process::wait();
