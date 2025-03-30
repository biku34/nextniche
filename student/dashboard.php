<?php
session_start();
include "db_connect.php"; // Ensure database connection works

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SoumiTattva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(to bottom right, #f5f7fa, #c3cfe2); 
            color: #222; 
            font-family: 'Poppins', sans-serif; 
            overflow-x: hidden;
        }
        
        /* Sidebar Styling */
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

        .test-card a {
            color: inherit;
            text-decoration: none;
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

        /* Test Cards */
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
        <p>"Take care of your mind, and it will take care of you."</p>
        <hr>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
        <a href="http://localhost:8501/">Study Planner</a>
    </div>

    <div class="main-content">
        <h2>Welcome to Your Mental Health Dashboard</h2>
        <p>Select an assessment to begin.</p>
        <hr>

        <h4>Your Personal Journal</h4>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="week.php">
                    <div class="test-card" style="width: 200%; max-width: 5000px; color: inherit; text-decoration: none;"><div class="test-card">
                        <h3>Express Your Feelings</h3>
                    </div>
                </a>
            </div>
        </div>


        <h4>Well-Being & Resilience Tests</h4>
        <div class="row">
        <div class="row">
        <div class="col-md-6 mb-4"><a href="test3.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Happiness & Positivity Scale</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Mind & Relationship Health</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test1.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Lifestyle & Thought Patterns Survey</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test9.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Daily Challenges & Response Reflection</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test2.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Inner Stability & Coping Skills Evaluation</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test5.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Life Balance & Mindset Evaluation</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test6.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Self Awareness Test</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test4.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Self-Control & Routine Evaluation</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test8.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Emotional Balance Test</h3></div></a></div>
        <div class="col-md-6 mb-4"><a href="test7.php" style="color: inherit; text-decoration: none;"><div class="test-card"><h3>Life Experiences & Resilience Quiz</h3></div></a></div>
        </div>
        <!-- Start of  Engage Bot code -->
    <!--(optional) You can pass visitor's name, email and phone as window object window.name, window.email and window.phone -->
    <script type='module'>
    window.botId =  '83ad539b-499b-461a-b48b-72c34cf45dc7';
    window.baseUrl = 'https://app.engagebot.works';
    window.isOpenChat = false;
    import engage from 'https://app.engagebot.works/api/file/plugin.js';
    engage();
  </script>
    <!-- End of Engage Bot code -->
            
        </div>
    </div>
</body>
</html>
