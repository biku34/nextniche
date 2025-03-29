<?php
session_start();
include "db_connect.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$test_id = $_POST['test_id'];  // Get the test ID from the hidden field

// Process each question's answer
foreach ($_POST as $key => $value) {
    // Skip the test_id field
    if ($key == 'test_id') {
        continue;
    }

    // Extract the question ID
    $question_id = str_replace('question_', '', $key); // Example: question_1 becomes 1

    // Prepare the answer data
    $answer_text = null;
    $answer_option_id = null;

    // Check if it's an MCQ (radio button) question
    if (is_numeric($value)) {
        // Store the selected option ID for MCQ
        $answer_option_id = $value;
    } else {
        // Store the subjective answer
        $answer_text = $value;
    }

    // Insert the answer into the database
    $answer_query = "INSERT INTO user_answers (user_id, test_id, question_id, answer_text, answer_option_id) 
                     VALUES (?, ?, ?, ?, ?)";
    $answer_statement = $conn->prepare($answer_query);
    $answer_statement->bind_param("iiiss", $user_id, $test_id, $question_id, $answer_text, $answer_option_id);
    $answer_statement->execute();
    $answer_statement->close();
}

// Redirect the user to the dashboard or a confirmation page
header("Location: dashboard.php?status=success");
exit;
?>
