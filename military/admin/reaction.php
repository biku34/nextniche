<?php
session_start();
$servername = "localhost"; // Change as needed
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "manoraksha"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to style emotion cells (Avoid redeclaration)
if (!function_exists('getEmotionCellClass')) {
    function getEmotionCellClass($emotion) {
        $negativeEmotions = ["anger", "disgust", "sadness"];
        
        if ($emotion === "No text provided") {
            return ""; // No styling needed for "-"
        } elseif (in_array(strtolower($emotion), $negativeEmotions)) {
            return 'style="background-color: red; color: white; padding: 5px; border-radius: 8px;"';
        } else {
            return "";
        }
    }
}

// Fetch journal entries from the database
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
    <style>
        body { 
            background: linear-gradient(to bottom right, #283c46, #1d262f); 
            color: white; 
            font-family: 'Poppins', sans-serif; 
        }
        .sidebar { 
            width: 250px; 
            background: rgba(28, 44, 58, 0.8); 
            height: 100vh; 
            padding: 20px; 
            position: fixed; 
        }
        .sidebar a { 
            color: white; 
            text-decoration: none; 
            padding: 15px; 
            display: block; 
            margin-bottom: 10px; 
            border-radius: 10px; 
        }
        .sidebar a:hover { 
            background: rgba(255, 255, 255, 0.1); 
        }
        .main-content { 
            margin-left: 270px; 
            padding: 40px; 
        }
        .table-container { 
            background: rgba(255, 255, 255, 0.08); 
            padding: 20px; 
            border-radius: 15px; 
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            border-radius: 10px;
            overflow: hidden;
        }
        .table th { 
            background-color: #1d262f; 
            color: white; 
            text-align: left; 
            padding: 12px;
        }
        .table td { 
            padding: 12px; 
            border: 1px black solid 
        }
        .table tbody tr:hover { 
            background: rgba(255, 255, 255, 0.1); 
            transition: 0.3s;
            border-bottom: 5px solid rgba(255, 255, 255, 0.2);
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
        <h2>Journal Entries</h2>
        <p>View and reflect on past entries.</p>
        <hr>
        <div class="table-container">
            <table class="table table-hover">
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
