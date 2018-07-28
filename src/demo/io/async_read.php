<?php

/**
 * 异步文件读取
 * 默认大小限制4MB，如果要读取更大的文件内容，可以使用`swoole_async_read`异步读文件的方式。
 */
$result = swoole_async_readfile(__DIR__ . '/../../data/static/index.html', function ($filename, $content) {
    echo "$filename ",PHP_EOL,PHP_EOL;

    echo "$content",PHP_EOL;
});

var_dump($result);

echo "read start." , PHP_EOL;
