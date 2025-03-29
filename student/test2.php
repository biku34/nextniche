<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASS21</title>
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
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
        }
        .navbar-brand {
            font-weight: 600;
            color: #222 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">SoumiTattva</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <h2 class="text-center">Inner Stability & Coping Skills Evaluation</h2>
            <hr>
            <form id="lonelinessTest" action="save_test2.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div id="questions"></div>
                <button type="submit" class="btn btn-custom w-100 mt-3">Submit</button>
            </form>            
            <p id="message" class="text-center mt-2"></p>
        </div>
    </div>
    <script>
        const questions = [
            "1. I found it hard to wind down",
            "2. I was aware of dryness of my mouth",
            "3. I couldn’t seem to experience any positive feeling at all",
            "4. I experienced breathing difficulty (e.g. excessively rapid breathing, breathlessness in the absence of physical exertion)",
            "5. I found it difficult to work up the initiative to do things",
            "6. I tended to over-react to situations",
            "7. I experienced trembling (e.g. in the hands)",
            "8. I felt that I was using a lot of nervous energy",
            "9. I was worried about situations in which I might panic and make a fool of myself",
            "10. I felt that I had nothing to look forward to",
            "11. I found myself getting agitated",
            "12. I found it difficult to relax",
            "13. I felt down-hearted and blue",
            "14. I was intolerant of anything that kept me from getting on with what I was doing",
            "15. I felt I was close to panic",
            "16. I was unable to become enthusiastic about anything",
            "17. I felt I wasn’t worth much as a person",
            "18. I felt that I was rather touchy",
            "19. I was aware of the action of my heart in the absence of physical exertion (e.g. sense of heart rate increase, heart missing a beat)",
            "20. I felt scared without any good reason",
            "21. I felt that life was meaningless"
        ];

        const options = ["0 (Never)", "1 (Sometimes)", "2 (FairlyOften)", "3 (Very Often)"];

        let questionContainer = document.getElementById("questions");

        questions.forEach((question, index) => {
            let div = document.createElement("div");
            div.classList.add("mb-3");
            div.innerHTML = `
                <p>${question}</p>
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
