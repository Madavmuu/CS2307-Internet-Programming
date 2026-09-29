<?php

session_start();

include "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users
        WHERE username = ?
        AND password = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $_SESSION['username'] = $username;

    echo "<h2>Login successful</h2>";
    echo "<p>Welcome, " . htmlspecialchars($username) . "!</p>";

    echo '<a href="order_form.php">Place Order</a><br>';
    echo '<a href="view_orders.php">View Orders</a><br>';
    echo '<a href="logout.php">Logout</a>';

} else {

    echo "<h2>Invalid Username or Password</h2>";
    echo '<a href="login.php">Try Again</a>';

}

$stmt->close();
$conn->close();

?>