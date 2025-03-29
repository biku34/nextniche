<?php
session_start();
include "db_connect.php"; // Ensure database connection works

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $weekly_entry = trim($_POST['weekly_entry']);
    $family_relationship = trim($_POST['family_relationship']);

  

    if (!empty($weekly_entry) || !empty($family_relationship)) {
        $stmt = $conn->prepare("INSERT INTO weekly_journal (user_id, entry, family_relationship, created_at) VALUES (?, ?, ?, NOW())");

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("iss", $user_id, $weekly_entry, $family_relationship);

        if ($stmt->execute()) {
            
        } else {
            die("<p style='color: red;'>Error executing statement: " . $stmt->error . "</p>");
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Both fields cannot be empty!</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Journal - SoumiTattva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(to bottom right, #283c46, #1d262f); color: white; font-family: 'Poppins', sans-serif; }
        .sidebar { width: 250px; background: rgba(28, 44, 58, 0.8); height: 100vh; padding: 20px; position: fixed; }
        .sidebar a { color: white; text-decoration: none; padding: 15px; display: block; margin-bottom: 10px; border-radius: 10px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.1); }
        .main-content { margin-left: 270px; padding: 40px; }
        .entry-box { background: rgba(255, 255, 255, 0.08); border-radius: 20px; padding: 30px; }
        textarea { width: 100%; background: rgba(255, 255, 255, 0.1); border: none; color: white; padding: 10px; border-radius: 10px; resize: none; }
        .btn-custom { background: #1d262f; color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; text-decoration: none; }
        .btn-custom:hover { background: #283c46; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>SoumiTattva</h3>
        <hr>
        <p>"Build up your health. Do not dwell in silence upon your sorrows."<br>-Swami Vivekananda</p>
        <hr>
    </div>

    <div class="main-content">
        <h2>Your Weekly Journal</h2>
        <p>Write about your experiences and emotions from the past week.</p>
        <hr>
        <form method="POST">
            <div class="entry-box">
                <label for="weekly_entry"><b>How was your past week?</b></label>
                <textarea name="weekly_entry" rows="6" placeholder="Describe your emotions, experiences, and any highlights from the week..."></textarea>
                <br><br>

                <label for="family_relationship"><b>How is your relationship with your close family?</b></label>
                <textarea name="family_relationship" rows="4" placeholder="Write about any positive or difficult moments with your family this week..."></textarea>
                <br><br>

                <button type="submit" class="btn-custom">Submit</button>
                <a href="dashboard.php" class="btn-custom">Go Back</a>
            </div>
        </form>
    </div>
</body>
</html>
