<?php
session_start();
include "db_connect.php"; // Ensure database connection works

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = "SELECT name, age, gender, rank FROM user_details WHERE user_id = ?";
$user_statement = $conn->prepare($user_query);
$user_statement->bind_param("i", $user_id);
$user_statement->execute();
$user_result = $user_statement->get_result();
$user_details = $user_result->fetch_assoc();

$user_statement->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - SoumiTattva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(to bottom right, #283c46, #1d262f); color: white; font-family: 'Poppins', sans-serif; }
        .sidebar { width: 250px; background: rgba(28, 44, 58, 0.8); height: 100vh; padding: 20px; position: fixed; }
        .sidebar a { color: white; text-decoration: none; padding: 15px; display: block; margin-bottom: 10px; border-radius: 10px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.1); }
        .main-content { margin-left: 270px; padding: 40px; }
        .profile-card { background: rgba(255, 255, 255, 0.08); border-radius: 20px; padding: 30px; text-align: center; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>SoumiTattva</h3>
        <hr>
        <p>"No real change in history has ever been achieved by discussions"<br>-Subhas Chandra Bose</p>
        <hr>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h2>Your Profile</h2>
        <div class="profile-card">
            <h3><?php echo htmlspecialchars($user_details['name']); ?></h3>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user_details['age']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_details['gender']); ?></p>
            <p><strong>Rank:</strong> <?php echo htmlspecialchars($user_details['rank']); ?></p>
            
        </div>
    </div>
</body>
</html>
