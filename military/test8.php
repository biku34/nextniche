<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IES-R</title>
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
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            color: white;
        }
        .btn-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 12px 24px;
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
            background-color: rgba(28, 44, 58, 0.8); /* Semi-transparent navbar */
            backdrop-filter: blur(5px);  /* Subtle blur effect */
        }

        .navbar-brand {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">SoumiTattva</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <h2 class="text-center">Emotional Balance Test</h2>
            <h5 class="text-center">0 = Not at all , 1 = A little bit , 2 = Moderately , 3 = Quite a bit , 4 = Extremely <br><br>
        <p>DURING THE PAST SEVEN DAYS How much have you been
distressed or bothered by these difficulties? </p></h5>
            <hr>
            <form id="lonelinessTest" action="save_test8.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div id="questions"></div>
                <button type="submit" class="btn btn-custom w-100 mt-3">Submit</button>
            </form>            
            <p id="message" class="text-center mt-2"></p>
        </div>
    </div>
    <script>
        const questions = [
            "Any reminder brought back feelings about it",
    "I had trouble staying asleep",
    "Other things kept making me think about it",
    "I felt irritable and angry",
    "I avoided letting myself get upset when I thought about it or was reminded of it",
    "I thought about it when I didn't mean to",
    "I felt as if it hadn't happened or wasn't real",
    "I stayed away from reminders of it",
    "Pictures about it popped into my mind",
    "I was jumpy and easily startled",
    "I tried not to think about it",
    "I was aware that I still had a lot of feelings about it, but I didn't deal with them",
    "My feelings about it were kind of numb",
    "I found myself acting or feeling like I was back at that time",
    "I had trouble falling asleep",
    "I had waves of strong feelings about it",
    "I tried to remove it from my memory",
    "I had trouble concentrating",
    "Reminders of it caused me to have physical reactions, such as sweating, trouble breathing, nausea, or a pounding heart",
    "I had dreams about it",
    "I felt watchful and on-guard",
    "I tried not to talk about it"
];


        const options = ["0", "1", "2", "3", "4"];

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
            message.style.color = "#80bdff";
        });
    </script>
</body>
</html>
