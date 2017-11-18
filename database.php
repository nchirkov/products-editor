<?php
    $mysqli = mysqli_connect(config('host'), config('user'),  config('password'), config('dbname'));

    function createProduct()
    {}

    function updateProduct()
    {}
    
    function deleteProduct()
    {}

    function getProduct()
    {}

    function initProducts()
    {
        global $mysqli;

        $result =  mysqli_query($mysqli, "SELECT NULL FROM `products` LIMIT 1");
        if (mysqli_num_rows($result) > 0)
            exit;

        for ($i = 0; $i <= 1000; $i++) {
            mysqli_query($mysqli, "INSERT INTO `products` (`title`, `description`, `price`, `image_url`)
                VALUES ('Product$i', 'Description$i', '$i', 'image$i.png')"
            );
        }
    }
?>