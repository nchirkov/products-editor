<?php
    $sqlConnection = mysqli_connect(config('sql_host'), config('sql_user'),  config('sql_password'), config('sql_dbname'));
    $memcacheConnection = memcache_connect(config('memcache_host'), config('memcache_port'));
    initProducts();

    function createProduct()
    {}

    function updateProduct()
    {}
    
    function deleteProduct()
    {}

    function getProduct()
    {}    

    function getProducts($id, $isForward, $order)
    {
        global $sqlConnection;
        global $memcacheConnection;

        if (false && $rows = memcache_get($memcacheConnection, 'allProducts'))
        {
            return $rows;
        }
        
        if ($id !== 0)
        {
            if ($order === "asc")
            {
                if ($isForward)
                {
                    $whereClause =  "WHERE `id` > ".$id;
                    $sortOrder = "ASC";
                }
                else
                {
                    $whereClause =  "WHERE `id` < ".$id;
                    $sortOrder = "DESC";
                }
            }
            else
            {
                if ($isForward)
                {
                    $whereClause =  "WHERE `id` < ".$id;
                    $sortOrder = "DESC";
                }
                else
                {
                    $whereClause =  "WHERE `id` > ".$id;
                    $sortOrder = "ASC";
                }
            }
        }
        else
        {
            $whereClause = "";
            if ($order === "asc")
            {
                $sortOrder = $isForward ? "ASC" : "DESC";
            }
            else
            {
                $sortOrder = $isForward ? "DESC" : "ASC";
            }
        }

        $result = mysqli_query($sqlConnection, "SELECT `id`, `title`, `description`, `price`, `image_url`
            FROM `products`
           ".$whereClause."
            ORDER BY `id`".$sortOrder."
            LIMIT 10"
        );

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $rows[] = $row;
        }

        mysqli_free_result($result);
        memcache_set($memcacheConnection, 'allProducts', $rows);

        return $rows;
    }

    function initProducts()
    {
        global $sqlConnection;

        $result =  mysqli_query($sqlConnection, "SELECT NULL FROM `products` LIMIT 1");
        if (mysqli_num_rows($result) > 0)
        {
            return;
        }

        for ($i = 0; $i <= 1100000; $i++) {
            mysqli_query($sqlConnection, "INSERT INTO `products` (`title`, `description`, `price`, `image_url`)
                VALUES ('Product$i', 'Description$i', '$i', 'image$i.png')"
            );
        }

        mysqli_free_result($result);
    }
?>