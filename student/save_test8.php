<?php
session_start();
include "db_connect.php"; // Ensure database connection works

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ensure all answers are set and store only the numerical value (0-4)
$answers = [];
for ($i = 1; $i <= 22; $i++) {
    $answers[] = isset($_POST["q$i"]) ? intval($_POST["q$i"]) : -1;  // Default to -1 if not set
}

// Check if user already attempted the test
$check_query = "SELECT id FROM iesr_assessment WHERE user_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header("Location: dashboard.php");
    exit;
}

// Insert answers into the database
$query = "INSERT INTO iesr_assessment (user_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20, q21, q22) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$bind_params = array_merge([$user_id], $answers);
$bind_types = "i" . str_repeat("i", count($answers)); // "i" for user_id and answers

$stmt->bind_param($bind_types, ...$bind_params);

// Execute the query
if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit;
} else {
    echo "Error submitting test: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
