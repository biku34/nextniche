<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brief-COPE</title>
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
            <h2 class="text-center">Daily Challenges & Response Reflection </h2>
            <h5 class="text-center">1 = I haven't been
            doing this at all , 2 = A little bit , 3 = A medium amount , 4 = I’ve been doing
            this a lot  <br><br> 
        </h5>
            <hr>
            <form id="lonelinessTest" action="save_test9.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div id="questions"></div>
                <button type="submit" class="btn btn-custom w-100 mt-3">Submit</button>
            </form>            
            <p id="message" class="text-center mt-2"></p>
        </div>
    </div>
    <script>
        const questions = [
            "I've been turning to work or other activities to take my mind off things.",
    "I've been concentrating my efforts on doing something about the situation I'm in.",
    "I've been saying to myself 'this isn't real'.",
    "I've been using alcohol or other drugs to make myself feel better.",
    "I've been getting emotional support from others.",
    "I've been giving up trying to deal with it.",
    "I've been taking action to try to make the situation better.",
    "I've been refusing to believe that it has happened.",
    "I've been saying things to let my unpleasant feelings escape.",
    "I've been getting help and advice from other people.",
    "I've been using alcohol or other drugs to help me get through it.",
    "I've been trying to see it in a different light, to make it seem more positive.",
    "I've been criticizing myself.",
    "I've been trying to come up with a strategy about what to do.",
    "I've been getting comfort and understanding from someone.",
    "I've been giving up the attempt to cope.",
    "I've been looking for something good in what is happening.",
    "I've been making jokes about it.",
    "I've been doing something to think about it less, such as going to movies, watching TV, reading, daydreaming, sleeping, or shopping.",
    "I've been accepting the reality of the fact that it has happened.",
    "I've been expressing my negative feelings.",
    "I've been trying to find comfort in my religion or spiritual beliefs.",
    "I've been trying to get advice or help from other people about what to do.",
    "I've been learning to live with it.",
    "I've been thinking hard about what steps to take.",
    "I've been blaming myself for things that happened.",
    "I've been praying or meditating.",
    "I've been making fun of the situation."
];


        const options = ["1", "2", "3", "4"];

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
