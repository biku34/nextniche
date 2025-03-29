<?php
session_start();
include "db_connect.php"; // Ensure database connection works

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}

$user_id = $_SESSION['user_id'];

// Step 2: Ensure all answers are set and store only the first letter as integers (0-3 or N for missing)
$answers = [];
for ($i = 1; $i <= 21; $i++) {
    $answers[$i] = isset($_POST["q$i"]) ? intval(substr($_POST["q$i"], 0, 1)) : 0;  
}

// Step 3: Compute Stress, Anxiety, and Depression scores
$stress_score = ($answers[1] + $answers[6] + $answers[8] + $answers[11] + $answers[12] + $answers[14] + $answers[18]) * 2 ;
$anxiety_score = ($answers[2] + $answers[4] + $answers[7] + $answers[9] + $answers[15] + $answers[19] + $answers[20]) * 2;
$depression_score = ($answers[3] + $answers[5] + $answers[10] + $answers[13] + $answers[16] + $answers[17] + $answers[21]) * 2;

// Step 4: Check if user already attempted the test
$check_query = "SELECT id FROM dass_stress_assessment WHERE user_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header("Location: dashboard.php");
    exit;  // Important: Stop further execution
}

// Step 5: Insert answers and computed scores into the database
$query = "INSERT INTO dass_stress_assessment (user_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20, q21, stress_score, anxiety_score, depression_score) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$bind_params = array_merge([$user_id], array_values($answers), [$stress_score, $anxiety_score, $depression_score]);
$bind_types = "i" . str_repeat("i", count($answers) + 3); // "i" for all integers

$stmt->bind_param($bind_types, ...$bind_params);

// Execute the query
if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit;  // Important: Stop further execution
} else {
    echo "Error submitting test: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
