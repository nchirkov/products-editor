<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
 </head>
 
<body>

<a href="?id&asc">Sort by Id ASC</a>
<a href="?id&desc">Sort by Id DESC</a>
<a href="?price&asc">Sort by Price ASC</a>
<a href="?price&desc">Sort by Price DESC</a>
<br>

<?php 
    $products = getProducts($id, $isForward, $order, $field, $price);
    $previousId = $isForward ? $products[0]['id'] : $products[count($products) - 1]['id'];
    $nextId = $isForward ? $products[count($products) - 1]['id'] : $products[0]['id'];
    $previousPrice = $isForward ? $products[0]['price'] : $products[count($products) - 1]['price'];
    $nextPrice =  $isForward ? $products[count($products) - 1]['price'] : $products[0]['price'];

    if ($isForward)
    {
        for ($i = 0; $i < count($products) ; $i++)
        { 
            echo $products[$i]['id'];
            echo "   ";
            echo $products[$i]['title'];
            echo "   ";
            echo $products[$i]['description'];
            echo "   ";
            echo $products[$i]['price'];
            echo "   ";
            echo $products[$i]['image_url'];
            echo "<br>";
        }
    }
    else
    {
        for ($i = count($products) - 1; $i >=0; $i--)
        { 
            echo $products[$i]['id'];
            echo "   ";
            echo $products[$i]['title'];
            echo "   ";
            echo $products[$i]['description'];
            echo "   ";
            echo $products[$i]['price'];
            echo "   ";
            echo $products[$i]['image_url'];
            echo "<br>";
        }
    }
?>

<a href="?first&<?= $order ?>&<?= $field ?>">First</a>
<a href="?previousId=<?= $previousId ?>&previousPrice=<?= $previousPrice ?>&<?= $order ?>&<?= $field ?>">Previous</a>
<a href="?nextId=<?= $nextId ?>&nextPrice=<?= $nextPrice ?>&<?= $order ?>&<?= $field ?>">Next</a>
<a href="?last&<?= $order ?>&<?= $field ?>">Last</a>

</body>

</html>
