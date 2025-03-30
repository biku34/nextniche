<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'manoraksha';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Fetch flagged tests and corresponding user details
$query = "SELECT u.user_id, u.name, u.gender, u.rank, u.age, f.test 
          FROM flagged_tests f
          JOIN user_details u ON f.user_id = u.user_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$flagged_tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$custom_test_names = [
    "loneliness" => "UCLA Loneliness Assessment",
    "stress" => "PSS Stress Test",
    "dass" => "DASS-21 Stress Assessment",
    "who5" => "WHO-5 Assessment",
    "cage" => "CAGE Assessment",
    "gad7" => "GAD-7 Assessment",
    "phq9" => "PHQ-9 Assessment",
    "ptsd" => "PTSD Assessment",
    "iesr" => "IES-R Assessment",
    "cope" => "Brief COPE Assessment"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flagged Tests - SoumiTattva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(to bottom right, #f5f7fa, #c3cfe2); 
            color: #222; 
            font-family: 'Poppins', sans-serif; 
            overflow-x: hidden;
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
            margin-bottom: 10px;
            letter-spacing: 1px;
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
        .main-content { 
            margin-left: 270px; 
            padding: 40px;
            transition: margin-left 0.3s;
        }
        h2 {
            font-weight: 700;
            color: #004d40;
        }
        .test-card {
            background: rgba(255, 255, 255, 0.95); 
            border-radius: 20px; 
            padding: 30px; 
            text-align: center; 
            cursor: pointer;
            transition: 0.4s ease-in-out;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .test-card:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 1);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>SoumiTattva</h3>
        <hr>
        <p>"A nation’s culture resides in the hearts and in the soul of its people."<br>- Mahatma Gandhi</p>
        <hr>
        <a href="admin.html">Home</a>
        <a href="users.php">Manage Users</a>
        <a href="score.php">Assessments</a>
        <a href="results.php">Reports</a>
        <a href="plot.php">Statistics</a>
        <a href="flag.php">Flagged Users</a>
        <a href="reaction.php">Emotion Analysis</a>
    </div>
    <div class="main-content">
        <h2>Flagged Tests & User Details</h2>
        <hr>
        <div class="test-card">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Rank</th>
                        <th>Age</th>
                        <th>Test Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flagged_tests as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['rank']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($custom_test_names[$row['test']] ?? $row['test']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
