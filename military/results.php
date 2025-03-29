<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Set your DB password
$dbname = "manoraksha";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, q17, q18, q19, q20 FROM loneliness_test";
$result = $conn->query($sql);

$questions = ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20'];
$counts = [];

foreach ($questions as $q) {
    $counts[$q] = ['R' => 0, 'O' => 0, 'N' => 0, 'S' => 0];
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($questions as $q) {
            if (isset($row[$q]) && array_key_exists($row[$q], $counts[$q])) {
                $counts[$q][$row[$q]]++;
            }
        }
    }
}

$conn->close();

// Prepare data for Chart.js
$labels = json_encode(array_keys($counts));
$rData = json_encode(array_map(fn($q) => $q['R'], $counts));
$oData = json_encode(array_map(fn($q) => $q['O'], $counts));
$nData = json_encode(array_map(fn($q) => $q['N'], $counts));
$sData = json_encode(array_map(fn($q) => $q['S'], $counts));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response Summary - ManoRaksha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: #121212;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .table-dark {
            background: #1e1e1e;
        }
        canvas {
            max-width: 100%;
            background: #1e1e1e;
            padding: 10px;
            border-radius: 10px;
        }
        .collapsible {
            cursor: pointer;
            font-weight: bold;
            background-color: #343a40;
            color: white;
            padding: 10px;
            border: none;
            text-align: left;
            width: 100%;
        }
        .content {
            display: none;
            padding: 10px;
            border: 1px solid #444;
            border-top: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Response Summary</h2>

        <!-- Chart Container -->
        <div class="my-4">
            <canvas id="responseChart"></canvas>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-dark table-striped">
                <thead>
                    <tr>
                        <th>Question</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($counts as $question => $data) { ?>
                        <tr>
                            <td>
                                <button class="collapsible"><?php echo ucfirst($question); ?></button>
                                <div class="content">
                                    <p><strong>R:</strong> <?php echo $data['R']; ?></p>
                                    <p><strong>O:</strong> <?php echo $data['O']; ?></p>
                                    <p><strong>N:</strong> <?php echo $data['N']; ?></p>
                                    <p><strong>S:</strong> <?php echo $data['S']; ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Collapsible table rows
        $(document).ready(function(){
            $(".collapsible").click(function(){
                $(this).next(".content").slideToggle("fast");
            });
        });

        // Chart.js for response visualization
        const ctx = document.getElementById('responseChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $labels; ?>,
                datasets: [
                    {
                        label: 'R Count',
                        data: <?php echo $rData; ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'O Count',
                        data: <?php echo $oData; ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'N Count',
                        data: <?php echo $nData; ?>,
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'S Count',
                        data: <?php echo $sData; ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { labels: { color: 'white' } }
                }
            }
        });
    </script>
</body>
</html>
