<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
    <style>
        .btn-link{
            border:none;
            outline:none;
            background:none;
            cursor:pointer;
            color:#0000EE;
            padding:0;
            text-decoration:underline;
            font-family:inherit;
            font-size:inherit;
        }

        form {
            display: inline-block;
        }
    </style>
 </head>
 
<body>

<a href="?id&asc">Sort by Id ASC</a>
<a href="?id&desc">Sort by Id DESC</a>
<a href="?price&asc">Sort by Price ASC</a>
<a href="?price&desc">Sort by Price DESC</a>
<br>

<a href="?action=add">Add</a>
<br>

<?php 
    $products = getProducts($id, $isForward, $order, $field, $price);

    $count = count($products);
    $limitCount = config('itemPerPage') + 1;
    
    if ($count === $limitCount)
    {
        if ($id !== 0)
        {
            $showNext = true;
            $showPrevious = true;
        }
        else
        {
            $showNext = $isForward;
            $showPrevious = !$isForward;
        }
       
        $count = $count - 1;
    }

    $previousId = $isForward ? $products[0]['id'] : $products[$count - 1]['id'];
    $nextId = $isForward ? $products[$count - 1]['id'] : $products[0]['id'];
    $previousPrice = $isForward ? $products[0]['price'] : $products[$count - 1]['price'];
    $nextPrice =  $isForward ? $products[$count - 1]['price'] : $products[0]['price'];
    
    if ($isForward)
    {
        for ($i = 0; $i < $count ; $i++)
        { 
            outputProduct($products[$i]);
        }
    }
    else
    {
        for ($i = $count - 1; $i >= 0; $i--)
        { 
            outputProduct($products[$i]);
        }
    }
?>

<?php function outputProduct($product) {  ?>
    <?= $product['id'] ?>
    <?= htmlspecialchars($product['title']) ?>
    <?= htmlspecialchars($product['description']) ?>
    <?= $product['price'] ?>
    <?= htmlspecialchars($product['image_url']) ?>
    <a href="?action=edit&id=<?= $product['id'] ?>">Edit</a>
    <form method="post" onclick="return confirm('Are you sure?')">
        <button name="delete" value="<?= $product['id'] ?>" class="btn-link">Delete</button>
    </form>
   <br>
<?php } ?>


<a href="?first&<?= $order ?>&<?= $field ?>">First</a>

<?php if ($showPrevious): ?>
<a href="?previousId=<?= $previousId ?>&previousPrice=<?= $previousPrice ?>&<?= $order ?>&<?= $field ?>">Previous</a>
<?php endif; ?>

<?php if ($showNext): ?>
<a href="?nextId=<?= $nextId ?>&nextPrice=<?= $nextPrice ?>&<?= $order ?>&<?= $field ?>">Next</a>
<?php endif; ?>

<a href="?last&<?= $order ?>&<?= $field ?>">Last</a>

</body>

</html>
