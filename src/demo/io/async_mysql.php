<?php

class AsyncMysql
{
    protected $db = null;

    // grant all privileges on swoole.* to swoole@localhost identified by '!Swoole1';
    protected $config = null;

    public function __construct()
    {
        $this->db = new swoole_mysql;
        $this->config = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'swoole',
            'password' => '!Swoole1',
            'database' => 'swoole',
            'charset' => 'utf8', //指定字符集
            'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
        ];
    }

    /**
     * 执行SQL
     *
     * @return
     */
    public function execute()
    {
        $this->db->connect($this->config, function ($db, $result) {
            if ($result === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die;
            }

            $sql = "show tables";
            $db->query($sql, function (swoole_mysql $db, $result) {
                if ($result === false) {
                    var_dump($db->error, $db->errno);
                } elseif ($result === true) {
                    var_dump($db->affected_rows, $db->insert_id);
                }
                var_dump($result);
                $db->close();
            });
        });
        return true;
    }
}

$mysql = new AsyncMysql;

$mysql->execute();
