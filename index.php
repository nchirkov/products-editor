<?php
    require_once 'config.php';
    require_once 'database.php';
    initProducts();

    require_once config('template_path').'/home.php';
?>