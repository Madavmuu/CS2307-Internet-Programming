<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$sql = "SELECT * FROM orders ORDER BY order_date DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
</head>
<body>

<h2>All Orders</h2>

<table border="1" cellpadding="10">

<tr>
    <th>Order ID</th>
    <th>Customer Name</th>
    <th>Product Name</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Order Date</th>
</tr>

<?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        echo "<tr>";

        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";

        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";

        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";

        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";

        echo "<td>" . htmlspecialchars($row['price']) . "</td>";

        echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";

        echo "</tr>";
    }

} else {

    echo "<tr>";
    echo "<td colspan='6'>No orders found.</td>";
    echo "</tr>";

}

?>

</table>

<br>

<a href="order_form.php">Place New Order</a> |
<a href="logout.php">Logout</a>

</body>
</html>

<?php
$conn->close();
?>