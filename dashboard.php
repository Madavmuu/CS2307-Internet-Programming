<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];

$result = $conn->query(
    "SELECT id, name, description FROM categories ORDER BY id"
);

$categories = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz - Dashboard</title>
</head>

<body>

<h1>Welcome to QuizWiz</h1>

<p>
    Welcome, <?php echo htmlspecialchars($username); ?>!
</p>

<h2>Choose a Quiz Category</h2>

<?php if (count($categories) > 0): ?>

    <?php foreach ($categories as $category): ?>

        <div>
            <h3>
                <?php echo htmlspecialchars($category["name"]); ?>
            </h3>

            <p>
                <?php echo htmlspecialchars($category["description"]); ?>
            </p>

            <a href="quiz.php?category_id=<?php echo $category["id"]; ?>">
                Start Quiz
            </a>
        </div>

        <hr>

    <?php endforeach; ?>

<?php else: ?>

    <p>No quiz categories available.</p>

<?php endif; ?>

<p>
    <a href="login.php">Back to Login</a>
</p>

</body>
</html>