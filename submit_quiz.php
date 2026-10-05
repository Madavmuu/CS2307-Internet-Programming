<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$category_id = isset($_POST["category_id"])
    ? (int) $_POST["category_id"]
    : 0;

if ($category_id <= 0) {
    die("Invalid quiz category.");
}

/*
 * Get the correct answers for this category.
 */
$stmt = $conn->prepare(
    "SELECT id, question_text, option_a, option_b,
            option_c, option_d, correct_option
     FROM questions
     WHERE category_id = ?"
);

$stmt->bind_param("i", $category_id);
$stmt->execute();

$result = $stmt->get_result();

$questions = $result->fetch_all(MYSQLI_ASSOC);

if (count($questions) === 0) {
    die("No questions found.");
}

/*
 * Calculate the score.
 */
$score = 0;
$review = [];

foreach ($questions as $question) {

    $qid = $question["id"];

    $user_answer = $_POST["answer_" . $qid] ?? null;

    $correct_answer = $question["correct_option"];

    if ($user_answer === $correct_answer) {
        $score++;
    }

    $review[] = [
        "question" => $question["question_text"],
        "user_answer" => $user_answer,
        "correct_answer" => $correct_answer
    ];
}

$total = count($questions);

/*
 * Save the quiz attempt.
 */
$stmt = $conn->prepare(
    "INSERT INTO quiz_attempts
     (user_id, category_id, score, total_questions)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param(
    "iiii",
    $user_id,
    $category_id,
    $score,
    $total
);

$stmt->execute();

/*
 * Save result temporarily in the session.
 */
$_SESSION["quiz_result"] = [
    "score" => $score,
    "total" => $total,
    "category_id" => $category_id,
    "review" => $review
];

/*
 * Go to result page.
 */
header("Location: result.php");
exit;
?>