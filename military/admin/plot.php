<?php
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

// Array to store test counts
$test_counts = [];

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

// Array to store test counts and total users
$test_counts = [];
$total_users_per_test = [];

foreach ($test_tables as $table => $test_name) {
    $query = "SELECT COUNT(*) as count FROM $table"; 
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $test_counts[$test_name] = $row['count'];

    // Set total users as the same for all tests
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
            background: linear-gradient(to bottom right, #283c46, #1d262f);
            color: white;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .green-cell {
            background-color: green;
            color: white;
        }

        .red-cell {
            background-color: red;
            color: white;
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
        }

        .footer {
            background-color: #1d262f;
            color: #ced4da;
            text-align: center;
            padding: 10px;
            
        }

        h3,
        p {
            color: white;
        }

        table {
            width: 100%;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        th {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Modal styles */
        .modal-content {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(15px);
            color: white;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
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
        <h2 class="text-center">Test Participation Statistics<br>-----</h2>
       
        <div class="row">
            <?php foreach ($test_counts as $test_name => $count): ?>
                <div class="col-md-6 mb-4">
                    <div class="card p-3 shadow">
                        <h3><?php echo htmlspecialchars($test_name); ?></h3>
                        <p><strong>Users Taken Test:</strong> <?php echo $count; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Users Taking Tests</h5>
        </div>
        <div class="card-body">
            <canvas id="testChart" style="max-width: 100%; height: 250px;"></canvas>
        </div>
    </div>
</div>

        

    <footer class="footer">
        <p>&copy; 2025 SoumiTattva Admin Panel. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const testData = <?php echo json_encode($test_counts); ?>;
    const totalUsersData = <?php echo json_encode($total_users_per_test); ?>;

    const ctx = document.getElementById('testChart').getContext('2d');
    const testChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(testData),
            datasets: [
                {
                    label: 'Users Taken Test',
                    data: Object.values(testData),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Users',
                    data: Object.values(totalUsersData),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            layout: {
                padding: 5 
            }
        }
    });
</script>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Open the modal
        document.getElementById('addUserBtn').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
            modal.show();
        });

        // Handle form submission via AJAX
        document.getElementById('addUserForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('add_user', true);

            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add the new user row to the table without a page refresh
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${email}</td>
                        <td>${password}</td>
                        <td class="red-cell">No</td>
                        <td class="red-cell">No</td>
                    `;
                    document.querySelector('table tbody').appendChild(newRow);

                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                    modal.hide();
                } else {
                    console.error('Error adding user');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>

</html>
