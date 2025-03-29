<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perceived Stress Scale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #007bff;
            color: #222;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 40px;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            color: #222;
        }
        .btn-custom {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
            padding: 14px 28px;
            font-size: 18px;
            border-radius: 30px;
            transition: 0.3s ease;
            color: white;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">SoumiTattva</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <h2 class="text-center">Lifestyle & Thought Patterns Survey</h2>
            <hr>
            <form id="lonelinessTest" action="save_test1.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div id="questions"></div>
                <button type="submit" class="btn btn-custom w-100 mt-3">Submit</button>
            </form>            
            <p id="message" class="text-center mt-2"></p>
        </div>
    </div>
    <script>
        const questions = [
    "1. In the last month, how often have you been upset because of something that happened unexpectedly?", 
    "2. In the last month, how often have you felt that you were unable to control the important things in your life?", 
    "3. In the last month, how often have you felt nervous and stressed?", 
    "4. In the last month, how often have you felt confident about your ability to handle your personal problems?", 
    "5. In the last month, how often have you felt that things were going your way?", 
    "6. In the last month, how often have you found that you could not cope with all the things that you had to do?", 
    "7. In the last month, how often have you been able to control irritations in your life?", 
    "8. In the last month, how often have you felt that you were on top of things?", 
    "9. In the last month, how often have you been angered because of things that were outside of your control?", 
    "10. In the last month, how often have you felt difficulties were piling up so high that you could not overcome them?"
];

        const options = [
            "0 (Never)", 
            "1 (Almost Never)", 
            "2 (Sometimes)", 
            "3 (Fairly Often)", 
            "4(Very Often)"];

        let questionContainer = document.getElementById("questions");

        questions.forEach((question, index) => {
            let div = document.createElement("div");
            div.classList.add("mb-3");
            div.innerHTML = `
                <p> ${question}</p>
                ${options.map(option => `
                    <label class="me-2">
                        <input type="radio" name="q${index + 1}" value="${option}" required> ${option}
                    </label>
                `).join('')}
            `;
            questionContainer.appendChild(div);
        });

        document.getElementById("lonelinessTest").addEventListener("submit", function(event) {
            
            let message = document.getElementById("message");
            message.textContent = "Thank you for completing the test!";
            message.style.color = "#1e3c72";
        });
    </script>
</body>
</html>
