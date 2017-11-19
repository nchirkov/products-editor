<?php
    $nextId = -1;
    if (isset($_GET['nextId'])) {
        $nextId = $_GET['nextId'];
    }

    $previousId = -1;
    if (isset($_GET['previousId'])) {
        $previousId = $_GET['previousId'];
    }
 
    if ($nextId > 0)
    {
        $id = $nextId;
        $isForward = true;
    }
    elseif ($previousId > 0)
    {
        $id = $previousId;
        $isForward = false;
    }
    elseif (isset($_GET['last']))
    {
        $id = 0;
        $isForward = false;
    }
    else
    {
        $id = 0;
        $isForward = true;
    }

    require_once config('template_path').'/list.php';
?>