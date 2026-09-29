<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
</head>
<body>

<h2>Place Your Order</h2>

<p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

<form action="insert_order.php" method="POST">

    <label>Customer Name:</label>
    <input type="text" name="customer_name" required>
    <br><br>

    <label>Product Name:</label>
    <input type="text" name="product_name" required>
    <br><br>

    <label>Quantity:</label>
    <input type="number" name="quantity" min="1" required>
    <br><br>

    <label>Price:</label>
    <input type="number" name="price" step="0.01" min="0" required>
    <br><br>

    <input type="submit" value="Place Order">

</form>

<br>

<a href="view_orders.php">View Orders</a> |
<a href="logout.php">Logout</a>

</body>
</html>