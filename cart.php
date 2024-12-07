<?php 
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$products = [
    1 => [
        'name' => 'Dark Milk Chocolate',
        'price' => 4.00,
        'image' => 'favoritesnack3.jpg'
    ],
    2 => [
        'name' => 'Grandma Chocolate chips',
        'price' => 1.99,
        'image' => 'favoritesnack2.jpg'
    ],
    3 => [
        'name' => 'Diary Milk Chocolate',
        'price' => 3.75,
        'image' => 'favoritesnack3.jpg'
    ],
    4 => [
        'name' => 'Chips Combo',
        'price' => 6.00,
        'image' => 'favoritesnack4.jpg'
    ]
];

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $products[$product_id]['name'],
            'price' => $products[$product_id]['price'],
            'quantity' => $quantity,
            'image' => $products[$product_id]['image']
        ];
    }
}

if (isset($_POST['delete_item'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

if (isset($_POST['delete_all'])) {
    unset($_SESSION['cart']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style(cart).css">
</head>
<body>

<h1>SnackTime Products<p><a href="SnackTime.php">Back Home</a><p> 
</h1>


<?php foreach ($products as $id => $product): ?>
    <div class="product">
        <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100">
        <h3><?php echo $product['name']; ?></h3>
        <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
        <form method="post" action="">
            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
            <input type="number" name="quantity" value="1" min="1" required>
            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
    </div>
<?php endforeach; ?>

<?php if (!empty($_SESSION['cart'])): ?>
    <div class="cart">
        <h2>Your Cart</h2>
        <table>
            <tr>
                <th>Snack</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $product_id => $cart_item):
                $total += $cart_item['price'] * $cart_item['quantity'];
            ?>
                <tr>
                    <td><?php echo $cart_item['name']; ?></td>
                    <td><?php echo $cart_item['quantity']; ?></td>
                    <td>$<?php echo number_format($cart_item['price'], 2); ?></td>
                    <td>$<?php echo number_format($cart_item['price'] * $cart_item['quantity'], 2); ?></td>
                    <td>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" name="delete_item">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </table>
        <form method="post" action="" style="margin-top: 20px;">
            <button type="submit" name="delete_all">Delete All Items</button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>