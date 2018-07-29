<?php

// 创建内容表
$table = new swoole_table(1024);

// 创建行
$table->column('id', swoole_table::TYPE_INT);
$table->column('name', swoole_table::TYPE_STRING, 10);
$table->column('age', swoole_table::TYPE_INT);

// 创建表
$table->create();


// 增、删、改查数据
$table->set('1', ['id' => 1, 'name' => 'test1', 'age' => 20]);
$table->set('2', ['id' => 2, 'name' => 'test2', 'age' => 21]);
$table->set('3', ['id' => 3, 'name' => 'test3', 'age' => 19]);

// 从内存中获取数据
print_r($table->get('1'));
