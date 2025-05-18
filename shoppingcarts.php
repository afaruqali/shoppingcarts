<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    $_SESSION['todo'] = [];
}

// Products list
$products = [
    ['name' => 'Headphones', 'price' => 50, 'image' => 'https://via.placeholder.com/150?text=Headphones'],
    ['name' => 'Smartwatch', 'price' => 120, 'image' => 'https://via.placeholder.com/150?text=Smartwatch'],
    ['name' => 'Shoes', 'price' => 80, 'image' => 'https://via.placeholder.com/150?text=Shoes'],
    ['name' => 'Backpack', 'price' => 40, 'image' => 'https://via.placeholder.com/150?text=Backpack'],
    ['name' => 'Sunglasses', 'price' => 30, 'image' => 'https://via.placeholder.com/150?text=Sunglasses'],
];

// Handle add to cart
if (isset($_POST['buy'])) {
    $productId = $_POST['buy'];
    $_SESSION['cart'][] = $products[$productId];
}

// Handle clear cart
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
}

// Handle todo
if (isset($_POST['todo_item']) && !empty($_POST['todo_item'])) {
    $_SESSION['todo'][] = htmlspecialchars($_POST['todo_item']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Shop & To-Do</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; margin: 20px; }
        h2 { color: #333; }
        .container { display: flex; gap: 30px; }
        .product, .cart, .todo { padding: 15px; background: white; border-radius: 10px; box-shadow: 0 0 5px #ccc; }
        .product img { width: 150px; height: 150px; object-fit: cover; }
        .product button, .todo button, .cart button { padding: 8px 12px; margin-top: 5px; border: none; background: #007BFF; color: white; cursor: pointer; border-radius: 5px; }
        .product button:hover, .todo button:hover, .cart button:hover { background: #0056b3; }
        .product { width: 180px; text-align: center; }
        .cart, .todo { flex: 1; }
        ul { list-style: none; padding-left: 0; }
        li { padding: 5px 0; }
    </style>
</head>
<body>

<h2>🛒 Simple PHP Shop + 📝 To-Do List</h2>
<div class="container">
    <!-- Product List -->
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php foreach ($products as $index => $p): ?>
            <div class="product">
                <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>">
                <p><strong><?= $p['name'] ?></strong></p>
                <p>$<?= $p['price'] ?></p>
                <form method="POST">
                    <button type="submit" name="buy" value="<?= $index ?>">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Cart -->
    <div class="cart">
        <h3>🛍 Your Cart</h3>
        <ul>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                echo "<li>{$item['name']} - \${$item['price']}</li>";
                $total += $item['price'];
            }
            ?>
        </ul>
        <p><strong>Total: $<?= $total ?></strong></p>
        <form method="POST">
            <button type="submit" name="clear_cart">Clear Cart</button>
        </form>
    </div>

    <!-- To-Do List -->
    <div class="todo">
        <h3>📋 To-Do List</h3>
        <form method="POST">
            <input type="text" name="todo_item" placeholder="New task" required>
            <button type="submit">Add</button>
        </form>
        <ul>
            <?php foreach ($_SESSION['todo'] as $task): ?>
                <li><?= $task ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>
