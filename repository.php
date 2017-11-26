<?php
    const VERSION_KEY = "version";

    $sqlConnection = mysqli_connect(config('sql_host'), config('sql_user'),  config('sql_password'), config('sql_dbname'));
    $memcacheConnection = memcache_pconnect(config('memcache_host'), config('memcache_port'));
    initProducts();
    initCache();

    function createProduct($title, $description, $price, $imageUrl)
    {
        global $sqlConnection;
        global $memcacheConnection; 

        $title = mysqli_real_escape_string($sqlConnection, $title);
        $description = mysqli_real_escape_string($sqlConnection, $description);
        $price = mysqli_real_escape_string($sqlConnection, $price);
        $imageUrl = mysqli_real_escape_string($sqlConnection, $imageUrl);

        if (mysqli_query($sqlConnection, "INSERT INTO `products` (`title`, `description`, `price`, `image_url`)
            VALUES ('$title', '$description', '$price', '$imageUrl')"
        ))
        {
            memcache_increment($memcacheConnection, VERSION_KEY);
        }
        else
        {
            return mysqli_error($sqlConnection);
        }
    }

    function updateProduct($id, $title, $description, $price, $imageUrl)
    {
        global $sqlConnection;
        global $memcacheConnection; 

        $id = mysqli_real_escape_string($sqlConnection, $id);
        $title = mysqli_real_escape_string($sqlConnection, $title);
        $description = mysqli_real_escape_string($sqlConnection, $description);
        $price = mysqli_real_escape_string($sqlConnection, $price);
        $imageUrl = mysqli_real_escape_string($sqlConnection, $imageUrl);

        if (mysqli_query($sqlConnection, "UPDATE `products` 
            SET `title` = '$title', 
                `description` = '$description',
                `price` = '$price',
                `image_url` = '$imageUrl'
            WHERE `id` = '$id'"
        ))
        {
            memcache_increment($memcacheConnection, VERSION_KEY);
        }
        else
        {
            return mysqli_error($sqlConnection);
        }
    }
    
    function deleteProduct($id)
    {
        global $sqlConnection;
        global $memcacheConnection; 
        
        $id = mysqli_real_escape_string($sqlConnection, $id);

        if (mysqli_query($sqlConnection, "DELETE FROM `products` 
            WHERE `id` = '$id'"
        ))
        {
            memcache_increment($memcacheConnection, VERSION_KEY);
        }
        else
        {
            return mysqli_error($sqlConnection);
        }
    }

    function getProduct($id)
    {
        global $sqlConnection;

        $id = mysqli_real_escape_string($sqlConnection, $id);

        $result = mysqli_query($sqlConnection, "SELECT `title`, `description`, `price`, `image_url`
                FROM `products`
                WHERE `id` = $id"
        );

        $product = mysqli_fetch_array($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        return $product;
    }    

    function getProducts($id, $isForward, $order, $field, $price)
    {
        global $sqlConnection;
        global $memcacheConnection;       

        $id = mysqli_real_escape_string($sqlConnection, $id);
        $price = mysqli_real_escape_string($sqlConnection, $price);
        
        $version = memcache_get($memcacheConnection, VERSION_KEY);
        $key = $id."_".$price."_".$field."_".$order."_".$isForward."_".$version;

        if ($rows = memcache_get($memcacheConnection, $key))
        {
            return $rows;
        }
        
        if ($id != 0)
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
        memcache_set($memcacheConnection, $key, $rows, 0, config('memcache_expiration'));

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

    function initCache()
    {   
        global $memcacheConnection;  
        
        $version = memcache_get($memcacheConnection, VERSION_KEY);
        if (!$version)
        {
            memcache_set($memcacheConnection, VERSION_KEY, 0);
        }
    }
?>