<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$category_id = isset($_GET["category_id"])
    ? (int) $_GET["category_id"]
    : 0;

if ($category_id <= 0) {
    die("Invalid quiz category.");
}

$stmt = $conn->prepare(
    "SELECT id, question_text, option_a, option_b,
            option_c, option_d
     FROM questions
     WHERE category_id = ?
     ORDER BY RAND()"
);

$stmt->bind_param("i", $category_id);
$stmt->execute();

$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (count($questions) === 0) {
    die("No questions found for this category.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz - Quiz</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .question {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .option {
            margin: 10px 0;
        }

        #timer {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<h1>QuizWiz Quiz</h1>

<div id="timer">
    Time Remaining: 05:00
</div>

<form id="quizForm" method="POST" action="submit_quiz.php">

    <input type="hidden"
           name="category_id"
           value="<?php echo $category_id; ?>">

    <?php foreach ($questions as $index => $question): ?>

        <div class="question">

            <h3>
                <?php echo ($index + 1) . ". "; ?>

                <?php
                echo htmlspecialchars(
                    $question["question_text"]
                );
                ?>
            </h3>

            <div class="option">
                <label>
                    <input
                        type="radio"
                        name="answer_<?php echo $question["id"]; ?>"
                        value="A"
                        required
                    >
                    <?php echo htmlspecialchars($question["option_a"]); ?>
                </label>
            </div>

            <div class="option">
                <label>
                    <input
                        type="radio"
                        name="answer_<?php echo $question["id"]; ?>"
                        value="B"
                    >
                    <?php echo htmlspecialchars($question["option_b"]); ?>
                </label>
            </div>

            <div class="option">
                <label>
                    <input
                        type="radio"
                        name="answer_<?php echo $question["id"]; ?>"
                        value="C"
                    >
                    <?php echo htmlspecialchars($question["option_c"]); ?>
                </label>
            </div>

            <div class="option">
                <label>
                    <input
                        type="radio"
                        name="answer_<?php echo $question["id"]; ?>"
                        value="D"
                    >
                    <?php echo htmlspecialchars($question["option_d"]); ?>
                </label>
            </div>

        </div>

    <?php endforeach; ?>

    <button type="submit">
        Submit Quiz
    </button>

</form>

<script>
let duration = 5 * 60;

const timerElement = document.getElementById("timer");
const quizForm = document.getElementById("quizForm");

function updateTimer() {

    const minutes = Math.floor(duration / 60);
    const seconds = duration % 60;

    const formattedMinutes =
        String(minutes).padStart(2, "0");

    const formattedSeconds =
        String(seconds).padStart(2, "0");

    timerElement.textContent =
        "Time Remaining: " +
        formattedMinutes +
        ":" +
        formattedSeconds;

    if (duration <= 0) {
        clearInterval(timerInterval);
        quizForm.submit();
        return;
    }

    duration--;
}

updateTimer();

const timerInterval = setInterval(
    updateTimer,
    1000
);
</script>

</body>
</html>