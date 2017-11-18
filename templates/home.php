<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
 </head>
 
<body>

<?php $products = getProducts(); ?>
<?php foreach($products as $product): ?>
    <?= $product['id'] ?>
    <?= $product['title'] ?>
    <?= $product['description'] ?>
    <?= $product['price'] ?>
    <?= $product['image_url'] ?>
    <br>
<?php endforeach; ?>
    
</body>

</html>
