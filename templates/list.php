<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
 </head>
 
<body>

<?php 
    $products = getProducts($id, $isForward);
    $previousId = $isForward ? $products[0]['id'] : $products[count($products) - 1]['id'];
    $nextId = $isForward ? $products[count($products) - 1]['id'] : $products[0]['id'];
?>

<?php 
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

<a href="?first">First</a>
<a href="?previousId=<?= $previousId ?>">Previous</a>
<a href="?nextId=<?= $nextId ?>">Next</a>
<a href="?last">Last</a>

</body>

</html>
