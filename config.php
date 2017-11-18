<?php
    function config($key = '')
    {
        $config = [
            'template_path' => 'templates'
        ];

        return isset($config[$key]) ? $config[$key] : null;
    }
?>