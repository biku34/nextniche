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
        body { background: linear-gradient(to bottom right, #eef2f3, #8e9eab); color: #333; font-family: 'Poppins', sans-serif; font-size: 18px; }
        .sidebar { width: 280px; background: rgba(255, 255, 255, 0.9); height: 100vh; padding: 25px; position: fixed; box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1); border-right: 2px solid rgba(0, 0, 0, 0.1); backdrop-filter: blur(10px); }
        .sidebar h3 { font-weight: 700; text-align: center; margin-bottom: 20px; color: #004d40; font-size: 22px; }
        .sidebar p { text-align: center; font-style: italic; color: #00796b; font-size: 16px; }
        .main-content { margin-left: 300px; padding: 50px; }
        .journal-card { background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 35px; text-align: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); max-width: 700px; margin: auto; font-size: 18px; }
        .journal-card h2 { font-weight: 700; color: #004d40; font-size: 24px; }
        .journal-card label { font-weight: 600; color: #00796b; font-size: 18px; }
        textarea { width: 100%; background: rgba(0, 0, 0, 0.05); border: none; color: #333; padding: 15px; border-radius: 10px; resize: none; font-size: 16px; }
        .btn-custom { background: #00796b; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 18px; }
        .btn-custom:hover { background: #004d40; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>SoumiTattva</h3>
        <hr>
        <p>"Build up your health. Do not dwell in silence upon your sorrows."<br>- Swami Vivekananda</p>
        <hr>
    </div>

    <div class="main-content">
        <h2>Your Weekly Journal</h2>
        <p>Write about your experiences and emotions from the past week.</p>
        <hr>
        <form method="POST">
            <div class="journal-card">
                <label for="weekly_entry"><b>How was your past week?</b></label>
                <textarea name="weekly_entry" rows="6" placeholder="Describe your emotions, experiences, and any highlights from the week that impacted your studies..."></textarea>
                <br><br>

                <label for="family_relationship"><b>How is your academics going?</b></label>
                <textarea name="family_relationship" rows="4" placeholder="Write about any positive or difficult moments you faced in academics..."></textarea>
                <br><br>

                <button type="submit" class="btn-custom">Submit</button>
                <a href="dashboard.php" class="btn-custom">Go Back</a>
            </div>
        </form>
    </div>
</body>
</html>
