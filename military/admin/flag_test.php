<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "manoraksha");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $test = isset($_POST['test']) ? $_POST['test'] : '';

    if ($user_id && !empty($test)) {
        // Check if entry already exists
        $check_sql = "SELECT * FROM flagged_tests WHERE user_id = ? AND test = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("is", $user_id, $test);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die("Query failed: " . $conn->error);
        }

        if ($result->num_rows === 0) { // No duplicate found
            $insert_sql = "INSERT INTO flagged_tests (user_id, test) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("is", $user_id, $test);

            if ($stmt->execute()) {
                echo "Added to flagged list";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Already in flagged list";
        }

        $stmt->close();
    } else {
        echo "Invalid data received";
    }
}

$conn->close();
?>
