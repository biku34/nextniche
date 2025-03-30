<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manoraksha";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!function_exists('getEmotionCellClass')) {
    function getEmotionCellClass($emotion) {
        $negativeEmotions = ["anger", "disgust", "sadness"];
        
        if ($emotion === "No text provided") {
            return "";
        } elseif (in_array(strtolower($emotion), $negativeEmotions)) {
            return 'style="background-color: #e74c3c; color: white; padding: 5px; border-radius: 8px;"';
        } else {
            return "";
        }
    }
}

$entry_query = "SELECT * FROM weekly_journal ORDER BY created_at DESC";
$entry_statement = $conn->prepare($entry_query);
$entry_statement->execute();
$entries = $entry_statement->get_result();
$entry_statement->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Entries - SoumiTattva</title>
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
        <h2>Journal Entries</h2>
        <p>View and reflect on past entries.</p>
        <hr>
        <div class="table-container">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Entry</th>
                        <th>Family Relationship</th>
                        <th>Created At</th>
                        <th>Entry Emotion</th>
                        <th>Family Emotion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($entry = $entries->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $entry['user_id']; ?></td>
                            <td><?php echo htmlspecialchars($entry['entry']); ?></td>
                            <td><?php echo htmlspecialchars($entry['family_relationship']); ?></td>
                            <td><?php echo $entry['created_at']; ?></td>
                            <td <?php echo getEmotionCellClass($entry['entry_emotion']); ?>>
                                <?php echo ($entry['entry_emotion'] === "No text provided") ? "-" : htmlspecialchars($entry['entry_emotion']); ?>
                            </td>
                            <td <?php echo getEmotionCellClass($entry['family_emotion']); ?>>
                                <?php echo ($entry['family_emotion'] === "No text provided") ? "-" : htmlspecialchars($entry['family_emotion']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>