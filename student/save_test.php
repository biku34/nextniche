<?php
session_start();
include "db_connect.php"; // Ensure database connection works

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];

// Define reverse-scored questions
$reverse_scored = [1, 5, 6, 9, 10, 15, 16, 19, 20];

// Process user responses
$answers = [];
for ($i = 1; $i <= 20; $i++) {
    if (!isset($_POST["q$i"])) {
        die("All questions must be answered.");
    }
    
    $score = (int)$_POST["q$i"]; // Ensure numeric value (1-4)
    
    if ($score < 1 || $score > 4) {
        die("Invalid response detected.");
    }

    // Apply reverse scoring
    if (in_array($i, $reverse_scored)) {
        $score = 5 - $score; // Reverse scoring formula
    }
    
    $answers[] = $score;
}

// Check if user already attempted the test
$check_query = "SELECT id FROM loneliness_test WHERE user_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: dashboard.php");
    exit;
}

// Insert answers into database
$query = "INSERT INTO loneliness_test (user_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, 
                                       q11, q12, q13, q14, q15, q16, q17, q18, q19, q20) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$bind_types = str_repeat("i", 21); // 21 integers (user_id + 20 answers)
$stmt->bind_param($bind_types, $user_id, ...$answers);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit;
} else {
    echo "Error submitting test: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
