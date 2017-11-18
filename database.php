<?php
    $link = mysqli_connect(config('host'), config('user'),  config('password'), config('dbname'));

    function createProduct()
    {}

    function updateProduct()
    {}
    
    function deleteProduct()
    {}

    function getProduct()
    {}    

    function getProducts()
    {
        global $link;

        $result = mysqli_query($link, "SELECT `id`, `title`, `description`, `price`, `image_url` FROM `products` LIMIT 1000");
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $rows[] = $row;
        }
        mysqli_free_result($result);

        return $rows;
    }

    function initProducts()
    {
        global $link;

        $result =  mysqli_query($link, "SELECT NULL FROM `products` LIMIT 1");
        if (mysqli_num_rows($result) > 0)
            return;

        for ($i = 0; $i <= 1100000; $i++) {
            mysqli_query($link, "INSERT INTO `products` (`title`, `description`, `price`, `image_url`)
                VALUES ('Product$i', 'Description$i', '$i', 'image$i.png')"
            );
        }
    }
?>