<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manoraksha";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$test_tables = [
    "cage_assessment" => "CAGE",
    "dass_stress_assessment" => "DASS-21",
    "gad7_assessment" => "GAD-7",
    "iesr_assessment" => "IES_R",
    "loneliness_test" => "UCLA",
    "phq9_assessment" => "PHQ-9",
    "ptsd_assessment" => "PTSD",
    "stress_assessment" => "PSS",
    "who5_assessment" => "WHO-5",
    "brief_cope_assessment" => "COPE"
];

$test_counts = [];
$total_users_per_test = [];

foreach ($test_tables as $table => $test_name) {
    $query = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $test_counts[$test_name] = $row['count'];
}

$total_users_query = "SELECT COUNT(*) as total FROM users";
$result = $conn->query($total_users_query);
$row = $result->fetch_assoc();
$total_users = $row['total'];

foreach ($test_tables as $test_name) {
    $total_users_per_test[$test_name] = $total_users;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SoumiTattva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #f5f7fa, #c3cfe2);
            color: #333;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.95);
            height: 100vh;
            padding: 20px;
            position: fixed;
            backdrop-filter: blur(12px);
            border-right: 2px solid rgba(0, 0, 0, 0.1);
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
        }
        .sidebar h3 {
            font-weight: 700;
            text-align: center;
            color: #333;
        }
        .sidebar a {
            color: #00796b;
            text-decoration: none;
            padding: 15px;
            display: block;
            margin-bottom: 10px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s ease-in-out;
            background: rgba(0, 0, 0, 0.05);
        }
        .sidebar a:hover {
            background: #00796b;
            color: white;
            transform: scale(1.05);
        }
        
        .content {
            margin-left: 270px;
            padding: 40px;
            flex-grow: 1;
        }
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .footer {
            background: #00796b;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>SoumiTattva</h2>
        <hr>
        <p>"A nation’s culture resides in the hearts and in the soul of its people."<br>-Mahatma Gandhi</p>
        <hr>
        <a href="admin.html">Home</a>
        <a href="users.php">Manage Users</a>
        <a href="score.php">Assessments</a>
        <a href="results.php">Reports</a>
        <a href="plot.php">Statistics</a>
        <a href="flag.php">Flagged Users</a>
        <a href="reaction.php">Emotion Analysis</a>
    </div>
    <div class="content">
        <h2>Welcome, Admin</h2>
        <p>Manage users, assessments, and system settings from here.</p>
        <hr>
        <div class="container mt-5">
            <h2 class="text-center">Test Participation Statistics</h2>
            <div class="row">
                <?php foreach ($test_counts as $test_name => $count): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <h3><?php echo htmlspecialchars($test_name); ?></h3>
                            <p><strong>Users Taken Test:</strong> <?php echo $count; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 SoumiTattva Admin Panel. All rights reserved.</p>
    </footer>
</body>
</html>
