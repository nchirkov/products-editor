<?php
    function config($key = '')
    {
        $config = [
            'template_path' => 'templates',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '***',
            'dbname' => 'store'
        ];

        return isset($config[$key]) ? $config[$key] : null;
    }
?>