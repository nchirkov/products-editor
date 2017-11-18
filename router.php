<?php
    $nextId = -1;
    if (isset($_GET['nextId'])) {
        $nextId = $_GET['nextId'];
    }

    $previousId = -1;
    if (isset($_GET['previousId'])) {
        $previousId = $_GET['previousId'];
    }

    require_once config('template_path').'/list.php';
?>