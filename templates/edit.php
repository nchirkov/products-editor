<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
 </head>
 
<body>

    <?php
        if (isset($_POST['submit']))
        {
            createProduct($_POST['title'], $_POST['description'], $_POST['price'], $_POST['image_url']);
            header('Location: /');
        }
    ?>
   
    <form method="post">
        <p>Product title: <input type="text" name="title" /></p>
        <p>Product description: <input type="text" name="description" /></p>
        <p>Product price: <input type="text" name="price" /></p>
        <p>Product image url: <input type="text" name="image_url" /></p>
        <p><input type="submit" name="submit" value="Add"/></p>
    </form>
</body>

</html>
