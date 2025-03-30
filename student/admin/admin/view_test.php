<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "manoraksha");

// Check if parameters are passed
if (isset($_GET['user_id']) && isset($_GET['test'])) {
    $user_id = intval($_GET['user_id']);
    $test = $_GET['test'];

    // Map test types to database tables
    $test_tables = [
        "loneliness" => "loneliness_test",
        "stress" => "stress_assessment",
        "dass" => "dass_stress_assessment",
        "who5" => "who5_assessment",
        "cage" => "cage_assessment",
        "gad7" => "gad7_assessment",
        "phq9" => "phq9_assessment",
        "ptsd" => "ptsd_assessment",
        "iesr" => "iesr_assessment",
        "cope" => "brief_cope_assessment"
    ];

    $test_display_names = [
        "loneliness" => "UCLA Loneliness Assessment",
        "stress" => "PSS Stress Test",
        "dass" => "DASS-21 Stress Assessment",
        "who5" => "WHO-5 Assessment",
        "cage" => "CAGE Assessment",
        "gad7" => "GAD-7 Assessment",
        "phq9" => "PHQ-9 Assessment",
        "ptsd" => "PTSD Assessment",
        "iesr" => "IES-R Assessment",
        "cope" => "Brief COPE Assessment"
    ];

    // Define test questions
    $test_questions = [
        "loneliness" => [
            "I am unhappy doing so many things alone.",
    "I have nobody to talk to.",
    "I cannot tolerate being so alone.",
    "I lack companionship.",
    "I feel as if nobody really understands me.",
    "I find myself waiting for people to call or write.",
    "There is no one I can turn to.",
    "I am no longer close to anyone.",
    "My interests and ideas are not shared by those around me.",
    "I feel left out.",
    "I feel completely alone.",
    "I am unable to reach out and communicate with those around me.",
    "My social relationships are superficial.",
    "I feel starved for company.",
    "No one really knows me well.",
    "I feel isolated from others.",
    "I am unhappy being so withdrawn.",
    "It is difficult for me to make friends.",
    "I feel shut out and excluded by others.",
    "People are around me but not with me."
        ],
        "stress" => [
            "In the last month, how often have you been upset because of something that happened unexpectedly?", 
"In the last month, how often have you felt that you were unable to control the important things in your life?", 
"In the last month, how often have you felt nervous and stressed?", 
"In the last month, how often have you felt confident about your ability to handle your personal problems?", 
"In the last month, how often have you felt that things were going your way?", 
"In the last month, how often have you found that you could not cope with all the things that you had to do?", 
"In the last month, how often have you been able to control irritations in your life?", 
"In the last month, how often have you felt that you were on top of things?", 
"In the last month, how often have you been angered because of things that were outside of your control?", 
"In the last month, how often have you felt difficulties were piling up so high that you could not overcome them?"
        ],
        "dass" => [
            "I found it hard to wind down",
    "I was aware of dryness of my mouth",
    "I couldn’t seem to experience any positive feeling at all",
    "I experienced breathing difficulty (e.g. excessively rapid breathing, breathlessness in the absence of physical exertion)",
    "I found it difficult to work up the initiative to do things",
    "I tended to over-react to situations",
    "I experienced trembling (e.g. in the hands)",
    "I felt that I was using a lot of nervous energy",
    "I was worried about situations in which I might panic and make a fool of myself",
    "I felt that I had nothing to look forward to",
    "I found myself getting agitated",
    "I found it difficult to relax",
    "I felt down-hearted and blue",
    "I was intolerant of anything that kept me from getting on with what I was doing",
    "I felt I was close to panic",
    "I was unable to become enthusiastic about anything",
    "I felt I wasn’t worth much as a person",
    "I felt that I was rather touchy",
    "I was aware of the action of my heart in the absence of physical exertion (e.g. sense of heart rate increase, heart missing a beat)",
    "I felt scared without any good reason",
    "I felt that life was meaningless"
        ],
        "who5" => [
            "I have felt cheerful and in good spirits.",
    "I have felt calm and relaxed.",
    "I have felt active and vigorous.",
    "I woke up feeling fresh and rested.",
    "My daily life has been filled with things that interest me."
        ],
        "cage" => [
            "Have you ever felt you needed to Cut down on your drinking?",
            "Have people Annoyed you by criticizing your drinking?",
            "Have you ever felt Guilty about drinking?",
            "Have you ever felt you needed a drink first thing in the morning (Eye-opener) to steady your nerves or to get rid of a hangover?"
        ],
        "gad7" => [
            "Feeling nervous, anxious, or on edge",
    "Not being able to stop or control worrying",
    "Worrying too much about different things",
    "Trouble relaxing",
    "Being so restless that it is hard to sit still",
    "Becoming easily annoyed or irritable",
    "Feeling afraid, as if something awful might happen"
        ],
    "phq9" => [
        "Little interest or pleasure in doing things",
    "Feeling down, depressed, or hopeless",
    "Trouble falling or staying asleep, or sleeping too much",
    "Feeling tired or having little energy",
    "Poor appetite or overeating",
    "Feeling bad about yourself or that you are a failure or have let yourself or your family down",
    "Trouble concentrating on things, such as reading the newspaper or watching television",
    "Moving or speaking so slowly that other people could have noticed. Or the opposite, being so fidgety or restless that you have been moving around a lot more than usual",
    "Thoughts that you would be better off dead, or of hurting yourself"
    ],
    "ptsd" => [
        "Repeated, disturbing, and unwanted memories of the stressful experience?",
    "Repeated, disturbing dreams of the stressful experience?",
    "Suddenly feeling or acting as if the stressful experience were actually happening again (as if you were actually back there reliving it)?",
    "Feeling very upset when something reminded you of the stressful experience?",
    "Having strong physical reactions when something reminded you of the stressful experience (for example, heart pounding, trouble breathing, sweating)?",
    "Avoiding memories, thoughts, or feelings related to the stressful experience?",
    "Avoiding external reminders of the stressful experience (for example, people, places, conversations, activities, objects, or situations)?",
    "Trouble remembering important parts of the stressful experience?",
    "Having strong negative beliefs about yourself, other people, or the world (for example, having thoughts such as: I am bad, there is something seriously wrong with me, no one can be trusted, the world is completely dangerous)?",
    "Blaming yourself or someone else for the stressful experience or what happened after it?",
    "Having strong negative feelings such as fear, horror, anger, guilt, or shame?",
    "Loss of interest in activities that you used to enjoy?",
    "Feeling distant or cut off from other people?",
    "Trouble experiencing positive feelings (for example, being unable to feel happiness or have loving feelings for people close to you)?",
    "Irritable behavior, angry outbursts, or acting aggressively?",
    "Taking too many risks or doing things that could cause you harm?",
    "Being “superalert” or watchful or on guard?",
    "Feeling jumpy or easily startled?",
    "Having difficulty concentrating?",
    "Trouble falling, or staying asleep?"
    ],
    "iesr" => [
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
    ],
    "cope" => [
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
    ]
    
    ];
    

    // Initialize variables
$person_name = "Not Available";
$person_age = "Not Available";
$person_gender = "Not Available";
$person_rank = "Not Available";

    // Check if test type is valid
    if (array_key_exists($test, $test_tables)) {
        $table = $test_tables[$test];
        $test_name = $test_display_names[$test];

        // Prepare SQL query
        $stmt = $conn->prepare("SELECT * FROM $table WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $sql_query = "SELECT name, age, gender, rank FROM user_details WHERE user_id = ?";
        $prepare_stmt = $conn->prepare($sql_query);
        $prepare_stmt->bind_param("i", $user_id);
        $prepare_stmt->execute();
        $fetch_result = $prepare_stmt->get_result();
        
        if ($fetch_result->num_rows > 0) {
            $user_details = $fetch_result->fetch_assoc();
            $person_name = htmlspecialchars($user_details['name']);
            $person_age = htmlspecialchars($user_details['age']);
            $person_gender = htmlspecialchars($user_details['gender']);
            $person_rank = htmlspecialchars($user_details['rank']);
        }
        $prepare_stmt->close();


        
        

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Test Results - SoumiTattva</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background: linear-gradient(to bottom right, #283c46, #1d262f);
                    color: white;
                    font-family: 'Poppins', sans-serif;
                }
                .container {
                    max-width: 700px;
                    margin-top: 50px;
                    background: rgba(255, 255, 255, 0.08);
                    padding: 30px;
                    border-radius: 15px;
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
                }
                .btn-custom {
                    background: rgba(255, 255, 255, 0.2);
                    color: white;
                    border-radius: 8px;
                }
                .btn-custom:hover {
                    background: rgba(255, 255, 255, 0.3);
                }
                #flagButton {
    background: linear-gradient(135deg, #ff416c, #ff4b2b); /* Gradient Red-Orange */
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    padding: 12px 20px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
}

#flagButton:hover {
    background: linear-gradient(135deg, #ff4b2b, #ff416c);
    transform: scale(1.05);
}

#flagButton:active {
    transform: scale(0.95);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

            </style>
        </head>
        <body>
            <div class="container text-center">
                <?php if ($result->num_rows > 0): 
                    $data = $result->fetch_assoc();
                ?>
                    <h2 class="mb-4">Results for <br><?php echo ($test_name); ?> Test</h2>
                    <table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Rank</th>
        </tr>
    </thead>
    <tbody>
    <tr>
            <td><?php echo $person_name; ?></td>
            <td><?php echo $person_age; ?></td>
            <td><?php echo $person_gender; ?></td>
            <td><?php echo $person_rank; ?></td>
        </tr>
    </tbody>
</table>

<button id="flagButton" data-userid="<?= $user_id; ?>" data-test="<?= $test; ?>">Flag User</button><p></p>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#flagButton").click(function(){
            var userId = $(this).data("userid");
            var test = $(this).data("test");

            $.ajax({
                url: "flag_test.php",
                type: "POST",
                data: { user_id: userId, test: test },
                success: function(response) {
                    alert(response); // Show success message
                }
            });
        });
    });
</script>



                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>Q. No</th>
                                <th>Question</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $questions = $test_questions[$test];
                        $index = 1;
                        $sum=0;

                        foreach ($questions as $key => $question): 
                            // Fetch response column dynamically (assuming column names are `q1`, `q2`, etc.)
                            $response_key = "q" . ($key + 1);
                            $response = isset($data[$response_key]) ? htmlspecialchars($data[$response_key]) : "N/A";
                            
                                $sum += $response;
                        ?>
                            <tr>
                                <td><?php echo $index++; ?></td>
                                <td><?php echo htmlspecialchars($question); ?></td>
                                <td><?php echo $response; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-warning">No records found.</p>
                <?php endif; ?>
                <?php
if ($test != "dass" && $test != "cope") { 
    echo "<h4>Score = $sum</h4>";
} 
?>

                <?php

$allowed_tests = ["dass", "loneliness", "stress", "ptsd", "iesr", "gad7", "cage", "phq9", "who5"];

if (in_array($test, $allowed_tests)) {
    if ($test == "ptsd") {
        $average = $sum / 20;

        if ($average <= 1.23) {
            $result = "Normal Range";
        } elseif ($average > 1.23 && $average <= 1.64) {
            $result = "Mild";
        } elseif ($average > 1.64 && $average <= 2.455) {
            $result = "Moderate";
        } elseif ($average > 2.455 && $average <= 3.265) {
            $result = "Severe";
        } else {
            $result = "Extremely Severe";
        }
    } elseif ($test == "phq9") {
        if ($sum >= 1 && $sum <= 4) {
            $result = "Minimal Depression";
        } elseif ($sum >= 5 && $sum <= 9) {
            $result = "Mild Depression";
        } elseif ($sum >= 10 && $sum <= 14) {
            $result = "Moderate Depression";
        } elseif ($sum >= 15 && $sum <= 19) {
            $result = "Moderately Severe Depression";
        } elseif ($sum >= 20 && $sum <= 27) {
            $result = "Severe Depression";
        }
    } elseif ($test == "cage") {
        if ($sum <= 1) {
            $result = "Normal";
        } elseif ($sum >= 2) {
            $result = "Indication of Alcohol Problems";
        }
    } elseif ($test == "gad7") {
        if ($sum >= 0 && $sum <= 4) {
            $result = "Minimal Anxiety";
        } elseif ($sum >= 5 && $sum <= 9) {
            $result = "Mild Anxiety";
        } elseif ($sum >= 10 && $sum <= 14) {
            $result = "Moderate Anxiety";
        } elseif ($sum >= 15 && $sum <= 21) {  // Fixed incorrect range (previously 121)
            $result = "Severe Anxiety";
        }
    } elseif ($test == "stress") {
        if ($sum >= 0 && $sum <= 13) {
            $result = "Low Stress";
        } elseif ($sum >= 14 && $sum <= 26) {
            $result = "Moderate Stress";
        } elseif ($sum >= 27 && $sum <= 40) {
            $result = "High Perceived Stress";
        } 
    } elseif ($test == "iesr") {
        if ($sum >= 37) {
            $result = "Score can suppress the immune system's functioning";
        } elseif ($sum >= 33) {
            $result = "Probable diagnosis of PTSD";
        } elseif ($sum >= 24) {
            $result = "Clinical concern for PTSD";
        } else {
            $result = "No significant PTSD concern";
        }
    } elseif ($test == "dass") {
        $query = "SELECT stress_score, anxiety_score, depression_score FROM dass_stress_assessment WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stress = $row['stress_score'];
    $anxiety = $row['anxiety_score'];
    $depression = $row['depression_score'];

    // Stress Level
if ($stress >= 0 && $stress <= 10) {
    $stress_level = "Normal";
} elseif ($stress >= 11 && $stress <= 18) {
    $stress_level = "Mild";
} elseif ($stress >= 19 && $stress <= 26) {
    $stress_level = "Moderate";
} elseif ($stress >= 27 && $stress <= 34) {
    $stress_level = "Severe";
} else {
    $stress_level = "Extremely Severe";
}

// Anxiety Level
if ($anxiety >= 0 && $anxiety <= 6) {
    $anxiety_level = "Normal";
} elseif ($anxiety >= 7 && $anxiety <= 9) {
    $anxiety_level = "Mild";
} elseif ($anxiety >= 10 && $anxiety <= 14) {
    $anxiety_level = "Moderate";
} elseif ($anxiety >= 15 && $anxiety <= 19) {
    $anxiety_level = "Severe";
} else {
    $anxiety_level = "Extremely Severe";
}

// Depression Level
if ($depression >= 0 && $depression <= 9) {
    $depression_level = "Normal";
} elseif ($depression >= 10 && $depression <= 12) {
    $depression_level = "Mild";
} elseif ($depression >= 13 && $depression <= 20) {
    $depression_level = "Moderate";
} elseif ($depression >= 21 && $depression <= 27) {
    $depression_level = "Severe";
} else {
    $depression_level = "Extremely Severe";
}

echo "<h3>Your DASS-21 Results</h3>";
echo "<p><strong>Stress Score:</strong> $stress ($stress_level)</p>";
echo "<p><strong>Anxiety Score:</strong> $anxiety ($anxiety_level)</p>";
echo "<p><strong>Depression Score:</strong> $depression ($depression_level)</p>";


   
} else {
    echo "No assessment found for this user.";
}


    }
    elseif ($test == "loneliness") {
        if ($sum >= 20 && $sum <=34) {
            $result = "A low degree of loneliness";
        } elseif ($sum >= 35 && $sum <=49) {
            $result = "A moderate degree of loneliness";
        } elseif ($sum >= 50 && $sum <=64) {
            $result = "A moderately high degree of loneliness";
        } elseif ($sum >= 65) {
            $result = "A high degree of loneliness";
        }
    } 
    if ($test == "who5") {
        // WHO-5 Score Interpretation
        if ($sum >= 0 && $sum <= 25) {
            echo "<p>Your WHO-5 raw score is $sum. 0 represents the worst possible quality of life, while 25 represents the best.</p>";
        }
    }
    elseif ($test != "dass" && $test != "cope"){
    echo "<h4>Report = $result</h4>";}
} 

?>

                <a href="results.php" class="btn btn-custom mt-3">Back to Dashboard</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p class='text-danger'>Invalid test type.</p>";
    }
} else {
    echo "<p class='text-danger'>Missing parameters.</p>";
}
?>
