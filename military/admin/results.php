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

// SQL Query to fetch users with test status
$sql = "SELECT 
    u.email, 
    u.id, 
    CASE 
        WHEN lt.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS took_loneliness_test,
    CASE 
        WHEN sa.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS took_stress_assessment,
    CASE 
        WHEN da.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS took_dass_assessment,
    CASE 
        WHEN wa.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS who5_assessment, 
    CASE 
        WHEN ca.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS cage_assessment,
    CASE 
        WHEN ga.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS gad7_assessment,
    CASE 
        WHEN pa.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS phq9_assessment,
    CASE 
        WHEN pt.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS ptsd_assessment,
    CASE 
        WHEN ie.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS iesr_assessment,
    CASE 
        WHEN bc.user_id IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS brief_cope_assessment
FROM users u
LEFT JOIN loneliness_test lt ON u.id = lt.user_id
LEFT JOIN stress_assessment sa ON u.id = sa.user_id
LEFT JOIN dass_stress_assessment da ON u.id = da.user_id
LEFT JOIN who5_assessment wa ON u.id = wa.user_id
LEFT JOIN cage_assessment ca ON u.id = ca.user_id
LEFT JOIN gad7_assessment ga ON u.id = ga.user_id
LEFT JOIN phq9_assessment pa ON u.id = pa.user_id
LEFT JOIN ptsd_assessment pt ON u.id = pt.user_id
LEFT JOIN iesr_assessment ie ON u.id = ie.user_id
LEFT JOIN brief_cope_assessment bc ON u.id = bc.user_id";

$result = $conn->query($sql);


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

        h4,
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
        
        <table class="table table-dark">
            <thead>
                <tr>
                    <th style="border-right: 2px solid white;">Email</th>
                    
                    <th>UCLA</th>
                    <th>PSS</th>
                    <th>DASS 21</th>
                    <th>WHO-5</th>
                    <th>CAGE</th>
                    <th>GAD-7</th>
                    <th>PHQ-9</th>
                    <th>PTSD</th>
                    <th>IES-R</th>
                    <th>COPE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Determine cell colors based on test status
                        $loneliness_color = ($row['took_loneliness_test'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $stress_color = ($row['took_stress_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $dass_stress_color = ($row['took_dass_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $who5_color = ($row['who5_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $cage_color = ($row['cage_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $gad7_color = ($row['gad7_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $phq9_color = ($row['phq9_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $ptsd_color = ($row['ptsd_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $iesr_color = ($row['iesr_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';
                        $cope_color = ($row['brief_cope_assessment'] == 'Yes') ? 'background-color: green; color: white;' : 'background-color: red; color: white;';

                        echo "<tr>

        <td>{$row['email']}</td>

        <td>";
if ($row['took_loneliness_test'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=loneliness' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['took_stress_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=stress' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['took_dass_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=dass' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['who5_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=who5' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['cage_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=cage' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['gad7_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=gad7' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['phq9_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=phq9' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['ptsd_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=ptsd' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['iesr_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=iesr' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "<td>";
if ($row['brief_cope_assessment'] == 'Yes') {
    echo "<a href='view_test.php?user_id=" . $row['id'] . "&test=cope' class='btn btn-success'>View</a>";
} else {
    echo "-";
}
echo "</td>";

echo "</tr>";

                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        
    </div>
    



        

    <footer class="footer">
        <p>&copy; 2025 SoumiTattva Admin Panel. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
