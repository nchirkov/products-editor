<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products Editor</title>
    <meta name="description" content="Simple Products Editor">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
 </head>
 
<body>
    <div class="container">
        <div class="row">
            <a class="btn btn-primary my-2" href="?action=add">Add</a>
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>#<a href=<?= $order === "asc" ? "?id&desc" : "?id&asc" ?>><i class="fa fa-fw fa-sort"></i></a></th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price<a href=<?= $order === "asc" ? "?price&desc" : "?price&asc" ?>><i class="fa fa-fw fa-sort"></i></a></th>
                        <th>Image Url</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
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
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= htmlspecialchars($product['title']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><?= htmlspecialchars($product['image_url']) ?></td>
                        <td><a href="?action=edit&id=<?= $product['id'] ?>">Edit</a></td>
                        <td>
                            <form method="post" onclick="return confirm('Are you sure?')">
                                <button  name="delete" value="<?= $product['id'] ?>" class="btn btn-link p-0">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="?first&<?= $order ?>&<?= $field ?>">First</a>
                </li>
                <li class="page-item <?= $showPrevious ? "" : "disabled" ?>">
                    <a class="page-link" href="?previousId=<?= $previousId ?>&previousPrice=<?= $previousPrice ?>&<?= $order ?>&<?= $field ?>">Previous</a>
                </li>
                <li class="page-item <?= $showNext ? "" : "disabled" ?>">
                    <a class="page-link" href="?nextId=<?= $nextId ?>&nextPrice=<?= $nextPrice ?>&<?= $order ?>&<?= $field ?>">Next</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?last&<?= $order ?>&<?= $field ?>">Last</a>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>