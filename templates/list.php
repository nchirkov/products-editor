<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
 </head>
 
<body>

<a href="?asc">Sort by Id ASC</a>
<a href="?desc">Sort by Id DESC</a>
<br>

<?php 
    $products = getProducts($id, $isForward, $order);
    $previousId = $isForward ? $products[0]['id'] : $products[count($products) - 1]['id'];
    $nextId = $isForward ? $products[count($products) - 1]['id'] : $products[0]['id'];
    if ($isForward)
    {
        for ($i = 0; $i < count($products) ; $i++)
        { 
            echo $products[$i]['id'];
            echo $products[$i]['title'];
            echo $products[$i]['description'];
            echo $products[$i]['price'];
            echo $products[$i]['image_url'];
            echo "<br>";
        }
    }
    else
    {
        for ($i = count($products) - 1; $i >=0; $i--)
        { 
            echo $products[$i]['id'];
            echo $products[$i]['title'];
            echo $products[$i]['description'];
            echo $products[$i]['price'];
            echo $products[$i]['image_url'];
            echo "<br>";
        }
    }
?>

<a href="?first&<?= $order ?>">First</a>
<a href="?previousId=<?= $previousId ?>&<?= $order ?>">Previous</a>
<a href="?nextId=<?= $nextId ?>&<?= $order ?>">Next</a>
<a href="?last&<?= $order ?>">Last</a>

</body>

</html>
