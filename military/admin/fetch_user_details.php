<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "manoraksha";

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Establish database connection
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Fetch and sanitize `id` from POST (instead of `user_id`)
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    
    
    // Ensure `id` is valid
    if (!$id || !ctype_digit($id)) {
        throw new Exception("Invalid or missing ID.");
    }

    $id = (int) $id; // Convert to integer for security

    // Prepare and execute the query
    $query = "SELECT name, gender, rank, age FROM user_details WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate HTML response
        //echo "<h2>User Details</h2>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>";
        echo "<p><strong>Rank:</strong> " . htmlspecialchars($row['rank']) . "</p>";
        echo "<p><strong>Age:</strong> " . htmlspecialchars($row['age']) . "</p>";
    } else {
        echo "<p>No details found for this user.</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
