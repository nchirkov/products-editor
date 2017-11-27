<?php
    function config($key = "")
    {
        $config = [
            "template_path" => "templates",
            "sql_host" => "localhost",
            "sql_user" => "root",
            "sql_password" => "***",
            "sql_dbname" => "store",
            "memcache_host" => "localhost",
            "memcache_port" => "11211",
            "memcache_expiration" => 900,
            "itemPerPage" => 10
        ];

        return isset($config[$key]) ? $config[$key] : null;
    }
?>