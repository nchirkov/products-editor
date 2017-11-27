<?php
    if (isset($_GET['action']) && $_GET['action'] === "add")
    {
        require_once config('template_path').'/edit.php';
    } 
    elseif (isset($_GET['action']) && $_GET['action'] === "edit" && isset($_GET['id']))
    {
        $id = $_GET['id'];
        require_once config('template_path').'/edit.php';
    }
    elseif (isset($_POST['delete']))
    {
        deleteProduct($_POST['delete']);
        header('Location: /');
    }
    else
    {
        $id = 0;
        $price = 0;
        $isForward = true;
        $showNext = false;
        $showPrevious = false;
    
        if (isset($_GET['nextId'])) {
            $id = $_GET['nextId'];
            $showPrevious = true;
        }

        if (isset($_GET['previousId'])) {
            $id = $_GET['previousId'];
            $isForward = false;
            $showNext = true;
        }

        if (isset($_GET['nextPrice'])) {
            $price = $_GET['nextPrice'];
        }

        if (isset($_GET['previousPrice'])) {
            $price = $_GET['previousPrice'];
            $isForward = false;
        }
    
        if (isset($_GET['last']))
        {
            $isForward = false;
        }
        
        $order = "asc";
        if (isset($_GET['desc']))
        {
            $order = "desc";  
        };

        $orderField = "id";
        if (isset($_GET['price']))
        {
            $orderField = "price";  
        };

        require_once config('template_path').'/list.php';
    }
?>