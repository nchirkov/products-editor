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
            if (isset($_POST['id']) )
            {
                $error = updateProduct($_POST['id'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['image_url']);
            }
            else
            {
                $error = createProduct($_POST['title'], $_POST['description'], $_POST['price'], $_POST['image_url']);
            }
       
            if ($error)
            {
                echo $error;
            }
            else
            {
                header('Location: /');
            }
        }

        if (isset($id))
        {
            $product = getProduct($id);
        }
    ?>
   
    <form method="post">

        <p>Product title:
            <input type="text" name="title" value="<?= isset($id) ? htmlspecialchars($product['title']) : "" ?>" />
        </p>
        <p>Product description:
            <input type="text" name="description" value="<?= isset($id) ? htmlspecialchars($product['description']) : "" ?>" />
        </p>
        <p>Product price:
            <input type="text" name="price" value="<?= isset($id) ? $product['price'] : "" ?>" />
        </p>
        <p>Product image url:
            <input type="text" name="image_url" value="<?= isset($id) ? htmlspecialchars($product['image_url']) : "" ?>" />
        </p>
        <p>
            <input type="submit" name="submit" value="<?= isset($id) ? "Edit" : "Add" ?>"/>
        </p>

        <?php if (isset($id)): ?>
            <input type="hidden" name="id" value="<?= $id ?>" />
        <?php endif; ?>
        
    </form>
</body>

</html>
