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

// Fetch gender-wise counts for flagged users
$genderQuery = "SELECT u.gender, COUNT(*) AS count 
                FROM flagged_tests f
                JOIN user_details u ON f.user_id = u.user_id 
                GROUP BY u.gender";
$genderStmt = $pdo->prepare($genderQuery);
$genderStmt->execute();
$genderData = $genderStmt->fetchAll(PDO::FETCH_ASSOC);

$genderCounts = [];
foreach ($genderData as $row) {
    $genderCounts[$row['gender']] = $row['count'];
}

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

// Fetch age-wise counts for flagged users
$ageQuery = "SELECT u.age, COUNT(*) AS count 
             FROM flagged_tests f
             JOIN user_details u ON f.user_id = u.user_id 
             GROUP BY u.age ORDER BY u.age ASC";
$ageStmt = $pdo->prepare($ageQuery);
$ageStmt->execute();
$ageData = $ageStmt->fetchAll(PDO::FETCH_ASSOC);

$ageLabels = [];
$ageCounts = [];
foreach ($ageData as $row) {
    $ageLabels[] = $row['age'];
    $ageCounts[] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flagged Tests - SoumiTattva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(to bottom right, #283c46, #1d262f);
            color: white;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: rgba(28, 44, 58, 0.9);
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .content {
            margin-left: 270px;
            padding: 40px;
            flex-grow: 1;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            color: white;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid white;
            text-align: center;
        }
        th {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .chart-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .chart-box {
            width: 30%;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .footer {
            background-color: #1d262f;
            color: #ced4da;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>SoumiTattva</h3>
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
        <h2>Flagged Tests & User Details</h2>
        <hr>
        <div class="card">
            <table>
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
                            <td>
                                <?php 
                                    echo htmlspecialchars($custom_test_names[$row['test']] ?? $row['test']); 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Charts Section -->
        <h2>Statistics</h2>
        <hr>
        <div class="chart-container">
            <div class="chart-box">
                <h4>Gender Distribution (Flagged Users)</h4><hr>
                <canvas id="genderChart" width="20px" height="200px"></canvas>
            </div>
            <div class="chart-box">
                <h4>Age Distribution (Flagged Users)</h4><hr>
                <canvas id="ageChart" width="20px" height="20px"></canvas>
            </div>
            
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 SoumiTattva Admin Panel. All rights reserved.</p>
    </footer>

    <script>
        // Gender Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($genderCounts)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($genderCounts)); ?>,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56'],
                }]
            }
        });

        // Age Chart
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($ageLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($ageCounts); ?>,
                    backgroundColor: '#4bc0c0'
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>
