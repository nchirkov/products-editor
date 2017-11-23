<?php
    $sqlConnection = mysqli_connect(config('sql_host'), config('sql_user'),  config('sql_password'), config('sql_dbname'));
    $memcacheConnection = memcache_pconnect(config('memcache_host'), config('memcache_port'));
    initProducts();

    function createProduct()
    {}

    function updateProduct()
    {}
    
    function deleteProduct()
    {}

    function getProduct()
    {}    

    function getProducts($id, $isForward, $order, $field, $price)
    {
        global $sqlConnection;
        global $memcacheConnection;
        
        $key = $id.$price.$field.$order.$isForward;
 
        if ($rows = memcache_get($memcacheConnection, $key))
        {
            return $rows;
        }
        
        if ($id !== 0)
        {
            if ($order === "asc")
            {
                if ($isForward)
                {
                    if ($field === "id")
                    {
                        $whereClause =  "WHERE `id` > ".$id;
                        $sortOrder = "ORDER BY `id` ASC";
                    }
                    else
                    {
                        $whereClause =  "WHERE `price` > ".$price." OR `price` = ".$price." AND `id` > ".$id;
                        $sortOrder = "ORDER BY `price` ASC, `id` ASC";
                    }
                }
                else
                {
                    if ($field === "id")
                    {
                        $whereClause =  "WHERE `id` < ".$id;
                        $sortOrder = "ORDER BY `id` DESC";
                    }
                    else
                    {
                        $whereClause =  "WHERE `price` < ".$price." OR `price` = ".$price." AND `id` < ".$id;
                        $sortOrder = "ORDER BY `price` DESC, `id` DESC";
                    }
                }
            }
            else
            {
                if ($isForward)
                {
                    if ($field === "id")
                    {
                        $whereClause =  "WHERE `id` < ".$id;
                        $sortOrder = "ORDER BY `id` DESC";
                    }
                    else
                    {
                        $whereClause =  "WHERE `price` < ".$price." OR `price` = ".$price." AND `id` < ".$id;
                        $sortOrder = "ORDER BY `price` DESC, `id` DESC";
                    }
                }
                else
                {
                    if ($field === "id")
                    {
                        $whereClause =  "WHERE `id` > ".$id;
                        $sortOrder = "ORDER BY `id` ASC";
                    }
                    else
                    {
                        $whereClause =  "WHERE `price` > ".$price." OR `price` = ".$price." AND `id` > ".$id;
                        $sortOrder = "ORDER BY `price` ASC, `id` ASC";
                    }
                }
            }
        }
        else
        {
            $whereClause = "";
            if ($order === "asc")
            {
                if ($field === "id")
                {
                    $sortOrder = $isForward ? "ORDER BY `id` ASC" : "ORDER BY `id` DESC";
                }
                else
                {
                    $sortOrder = $isForward ? "ORDER BY `price` ASC, `id` ASC" : "ORDER BY `price` DESC, `id` DESC";
                }
            }
            else
            {
                if ($field === "id")
                {
                    $sortOrder = $isForward ? "ORDER BY `id` DESC" : "ORDER BY `id` ASC";
                }
                else
                {
                    $sortOrder = $isForward ? "ORDER BY `price` DESC, `id` DESC" : "ORDER BY `price` ASC, `id` ASC";
                }
            }
        }

        $limitCount = config('itemPerPage') + 1;
        $result = mysqli_query($sqlConnection, "SELECT `id`, `title`, `description`, `price`, `image_url`
            FROM `products`
            ".$whereClause."
            ".$sortOrder."
            LIMIT $limitCount"
        );

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $rows[] = $row;
        }

        mysqli_free_result($result);
        memcache_set($memcacheConnection, $key, $rows);

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
            $price = $i % 10000;
            mysqli_query($sqlConnection, "INSERT INTO `products` (`title`, `description`, `price`, `image_url`)
                VALUES ('Product$i', 'Description$i', '$price', 'image$i.png')"
            );
        }

        mysqli_free_result($result);
    }
?>