<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTSD</title>
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
            <h2 class="text-center">Life Experiences & Resilience Quiz </h2>
            <h5 class="text-center">0 = Not at all , 1 = A little bit , 2 = Moderately , 3 = Quite a bit , 4 = Extremely <br><br>
        <p>In the past month, how much were you bothered by:</p></h5>
            <hr>
            <form id="lonelinessTest" action="save_test7.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div id="questions"></div>
                <button type="submit" class="btn btn-custom w-100 mt-3">Submit</button>
            </form>            
            <p id="message" class="text-center mt-2"></p>
        </div>
    </div>
    <script>
        const questions = [
            "1. Repeated, disturbing, and unwanted memories of the stressful experience?",
            "2. Suddenly feeling or acting as if the stressful experience were actually happening again (as if you were actually back there reliving it)?",
            "3. Feeling very upset when something reminded you of the stressful experience?",
            "4. Having strong physical reactions when something reminded you of the stressful experience (for example, heart pounding, trouble breathing, sweating)?",
            "5. Avoiding memories, thoughts, or feelings related to the stressful experience?",
            "6. Avoiding external reminders of the stressful experience (for example, people, places, conversations, activities, objects, or situations)?",
            "7. Trouble remembering important parts of the stressful experience?",
            "8. Having strong negative beliefs about yourself, other people, or the world (for example, having thoughts such as: I am bad, there is something seriously wrong with me, no one can be trusted, the world is completely dangerous)?",
            "9. Blaming yourself or someone else for the stressful experience or what happened after it?",
            "10. Having strong negative feelings such as fear, horror, anger, guilt, or shame?",
            "11. Loss of interest in activities that you used to enjoy?",
            "12. Feeling distant or cut off from other people?",
            "13. Trouble experiencing positive feelings (for example, being unable to feel happiness or have loving feelings for people close to you)?",
            "14. Irritable behavior, angry outbursts, or acting aggressively?",
            "15. Taking too many risks or doing things that could cause you harm?",
            "16. Being “superalert” or watchful or on guard?",
            "17. Feeling jumpy or easily startled?",
            "18. Having difficulty concentrating?",
            "19. Trouble falling or staying asleep?"
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
