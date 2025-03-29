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
    <title>Profile - Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #eef2f3, #8e9eab);
            color: #333;
            font-family: 'Poppins', sans-serif;
        }
        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.9);
            height: 100vh;
            padding: 30px;
            position: fixed;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
            border-right: 2px solid rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        .sidebar h3 {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
            color: #004d40;
        }
        .sidebar a {
            color: #00796b;
            text-decoration: none;
            padding: 15px;
            display: block;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
            text-align: center;
            background: rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            font-size: 18px;
        }
        .sidebar a:hover {
            background: #00796b;
            color: white;
            transform: scale(1.05);
        }
        .main-content {
            margin-left: 280px;
            padding: 50px;
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .profile-card h3 {
            font-size: 26px;
            font-weight: 700;
            color: #004d40;
        }
        .profile-card p {
            font-size: 20px;
            margin: 15px 0;
        }
        .btn-edit {
            background: #00796b;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            font-size: 18px;
        }
        .btn-edit:hover {
            background: #004d40;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Student Portal</h3>
        <a href="profile.php">Profile</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h2>Your Profile</h2>
        <div class="profile-card">
            <h3><?php echo htmlspecialchars($user_details['name']); ?></h3>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user_details['age']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_details['gender']); ?></p>
            <p><strong>Class:</strong> <?php echo htmlspecialchars($user_details['rank']); ?></p>
            <a href="edit_profile.php" class="btn-edit">Edit Profile</a>
        </div>
    </div>
</body>
</html>
