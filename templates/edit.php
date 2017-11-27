<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
 </head>

<body>

    <?php
        if (isset($_POST["submit"]))
        {
            if (isset($_POST["id"]))
            {
                $error = updateProduct($_POST["id"], $_POST["title"], $_POST["description"], $_POST["price"], $_POST["image_url"]);
            }
            else
            {
                $error = createProduct($_POST["title"], $_POST["description"], $_POST["price"], $_POST["image_url"]);
            }
       
            if ($error)
            {
                echo $error;
            }
            else
            {
                header("Location: /");
            }
        }

        if (isset($id))
        {
            $product = getProduct($id);
        }
    ?>

   <div class="container">
        <div class="row">
            <form method="post">
                <div class="form-group">
                    <label>Product title</label>
                    <input type="text" class="form-control" name="title" value="<?= isset($id) ? htmlspecialchars($product["title"]) : "" ?>" />
                    <label>Product description</label>
                    <input type="text" class="form-control" name="description" value="<?= isset($id) ? htmlspecialchars($product["description"]) : "" ?>" />
                    <label>Product price</label>
                    <input type="text" class="form-control" name="price" value="<?= isset($id) ? $product["price"] : "" ?>" />
                    <label>Product image url</label>
                    <input type="text" class="form-control" name="image_url" value="<?= isset($id) ? htmlspecialchars($product["image_url"]) : "" ?>" />
                    <input type="submit" class="btn btn-primary my-2" name="submit" value="<?= isset($id) ? "Edit" : "Add" ?>"/>
                    <?php if (isset($id)): ?>
                        <input type="hidden" name="id" value="<?= $id ?>" />
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

</body>

</html>