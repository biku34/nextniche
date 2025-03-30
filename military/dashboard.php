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
        body { background: linear-gradient(to bottom right, #283c46, #1d262f); color: white; font-family: 'Poppins', sans-serif; }
        .sidebar { width: 250px; background: rgba(28, 44, 58, 0.8); height: 100vh; padding: 20px; position: fixed; color: white; }
        .sidebar a { color: white; text-decoration: none; padding: 15px; display: block; margin-bottom: 10px; border-radius: 10px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.1); }
        .main-content { margin-left: 270px; padding: 40px; color:white; }
        .test-card { background: rgba(255, 255, 255, 0.08); border-radius: 20px; padding: 30px; text-align: center; cursor: pointer; }
        .test-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); }
        a {
            text-decoration: none; 
            color: inherit;
            display: block;
        }

        /* Ensure test-card link looks normal */
        a .test-card {
            color: white;
        }

        /* Optional: Prevent hover effect on clicked links */
        a:hover {
            color: inherit;
            background: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>SoumiTattva</h3>
        <hr>
        <p>"Build up your health. Do not dwell in silence upon your sorrows."<br>-Swami Vivekananda</p>
        <hr>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h2>Welcome to Your Mental Health Dashboard</h2>
        <p>Select an assessment to begin.</p>
        <hr>
        <h4>Your Very Own Journal</h4>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="week.php">
                    <div class="test-card">
                        <h3>Write about how you feel</h3>
                    </div>
                </a>
            </div>
        </div>
        
        <h5>Resilience and Stress Assessment</h5>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test.php">
                    <div class="test-card">
                        <h3>Mind & Relationship Check</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test1.php">
                    <div class="test-card">
                        <h3>Lifestyle & Thought Patterns Survey</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test2.php">
                    <div class="test-card">
                        <h3>Inner Stability & Coping Skills Evaluation</h3>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test3.php">
                    <div class="test-card">
                        <h3>Happiness & Perspective Evaluation</h3>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test4.php">
                    <div class="test-card">
                        <h3>Self-Control & Routine Evaluation</h3>
                    </div>
                </a>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test5.php">
                    <div class="test-card">
                        <h3>Life Balance & Mindset Evaluation</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test6.php">
                    <div class="test-card">
                        <h3>Self Awareness Test</h3>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test7.php">
                    <div class="test-card">
                        <h3>Life Experiences & Resilience Quiz</h3>
                    </div>
                </a>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test8.php">
                    <div class="test-card">
                        <h3>Emotional Balance Test</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="test9.php">
                    <div class="test-card">
                        <h3>Daily Challenges & Response Reflection</h3>
                    </div>
                </a>
            </div>
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
    
</body>
</html>
