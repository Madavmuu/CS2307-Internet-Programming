<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$customer_name = $_POST['customer_name'];
$product_name = $_POST['product_name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$sql = "INSERT INTO orders
        (customer_name, product_name, quantity, price)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssid",
    $customer_name,
    $product_name,
    $quantity,
    $price
);

if ($stmt->execute()) {

    echo "<h2>Order placed successfully!</h2>";

    echo "<a href='order_form.php'>Place Another Order</a><br>";
    echo "<a href='view_orders.php'>View Orders</a>";

} else {

    echo "Error: " . $stmt->error;

}

$stmt->close();
$conn->close();

?>