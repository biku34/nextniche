<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCLA Loneliness Test</title>
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
            <h2 class="text-center">Mind & Relationship Check</h2>
            <hr>
            <form id="lonelinessTest" action="save_test.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div id="questions"></div>
                <button type="submit" class="btn btn-custom w-100 mt-4">Submit</button>
            </form>            
            <p id="message" class="text-center mt-3"></p>
        </div>
    </div>
    <script>
        const questions = [
            "1. I feel in tune with the people around me",
            "2. I lack companionship",
            "3. There is no one I can turn to",
            "4. I do not feel alone",
            "5. I feel part of a group of friends",
            "6. I have a lot in common with the people around me",
            "7. I am no longer close to anyone",
            "8. My interests and ideas are not shared by those around me",
            "9. I am an outgoing person",
            "10. There are people I feel close to",
            "11. I feel left out",
            "12. My social relationships are superficial",
            "13. No one really knows me well",
            "14. I feel isolated from others",
            "15. I can find companionship when I want it",
            "16. There are people who really understand me",
            "17. I am unhappy being so withdrawn",
            "18. People are around me but not with me",
            "19. There are people I can talk to",
            "20. There are people I can turn to"
        ];

        const options = ["1 (Never)", "2 (Rarely)", "3 (Sometimes)", "4 (Often)"];

        let questionContainer = document.getElementById("questions");

        questions.forEach((question, index) => {
            let div = document.createElement("div");
            div.classList.add("mb-4");
            div.innerHTML = `
                <p>${question}</p>
                ${options.map(option => `
                    <label class="me-3">
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
