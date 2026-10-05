<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION["quiz_result"])) {
    header("Location: dashboard.php");
    exit;
}

$result = $_SESSION["quiz_result"];

$score = $result["score"];
$total = $result["total"];
$review = $result["review"];

$percentage = $total > 0
    ? round(($score / $total) * 100)
    : 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title>QuizWiz - Result</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .result {
            padding: 20px;
            border: 1px solid #ccc;
            margin-bottom: 30px;
        }

        .correct {
            color: green;
        }

        .wrong {
            color: red;
        }

        .question {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
        }

        button,
        a {
            padding: 10px 15px;
        }
    </style>
</head>

<body>

<h1>QuizWiz - Result</h1>

<div class="result">

    <h2>Your Score</h2>

    <h3>
        <?php echo $score; ?>
        /
        <?php echo $total; ?>
    </h3>

    <h3>
        <?php echo $percentage; ?>%
    </h3>

</div>

<h2>Answer Review</h2>

<?php foreach ($review as $index => $item): ?>

    <div class="question">

        <h3>
            <?php echo ($index + 1) . ". "; ?>

            <?php
            echo htmlspecialchars($item["question"]);
            ?>
        </h3>

        <p>
            Your answer:

            <?php if ($item["user_answer"] !== null): ?>

                <?php echo htmlspecialchars($item["user_answer"]); ?>

            <?php else: ?>

                Not answered

            <?php endif; ?>
        </p>

        <p>
            Correct answer:

            <?php
            echo htmlspecialchars($item["correct_answer"]);
            ?>
        </p>

        <?php if (
            $item["user_answer"] ===
            $item["correct_answer"]
        ): ?>

            <p class="correct">
                Correct!
            </p>

        <?php else: ?>

            <p class="wrong">
                Incorrect
            </p>

        <?php endif; ?>

    </div>

<?php endforeach; ?>

<br>

<a href="dashboard.php">
    Back to Dashboard
</a>

</body>

</html>