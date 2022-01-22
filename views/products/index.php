<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>
<h1>Products Crud</h1>
<p>
    <a href='/products/create' class='btn btn-success'>Create Product</a>
</p>
<form action="" method="get">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $_GET['search'] ?? '' ?>">
        <button class="btn btn-outline-secondary" type="submit">Button</button>
    </div>
</form>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">image</th>
            <th scope="col">title</th>
            <th scope="col">price</th>
            <th scope="col">create date</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $i => $product) : ?>
            <tr>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td>
                    <img src="/<?php echo $product['image'] ?>" alt="" class="thumb-image">
                </td>
                <td><?php echo $product['title'] ?></td>
                <td><?php echo $product['price'] ?></td>
                <td><?php echo $product['create_date'] ?></td>
                <td>
                    <a href="/products/update?id=<?php echo $product['id'] ?>" class='btn btn-sm btn-outline-primary'>Edit</a>
                    <form style="display:inline-block;" method="post" action="/products/delete">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>