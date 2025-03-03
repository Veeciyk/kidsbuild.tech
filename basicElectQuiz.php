<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// The topic for this quiz
$quizTopic = 'Basics of Electricity';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intro to Robotics Quiz - KidsBuild.Tech</title>
    <style>
    /* General Styles */
    body {
        margin: 0;
        font-family: 'Comic Neue', cursive;
        background-color: #87CEEB;
        /* Sky Blue */
        color: #333;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow-x: hidden;
        /* Prevent horizontal scrolling */
    }

    /* Header */
    .header {
        background-color: #FF69B4;
        /* Pink */
        color: white;
        display: flex;
        align-items: center;
        padding: 20px 30px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        height: 80px;
        position: relative;
    }

    .header h1 {
        font-size: 24px;
        margin: 0;
        text-align: center;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .menu-button-header {
        background-color: white;
        color: #FF69B4;
        /* Pink */
        font-size: 20px;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
        position: absolute;
        left: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .menu-button-header:hover {
        background-color: #FF1493;
        /* Darker Pink */
        color: white;
    }

    .menu-button-header .arrow {
        font-size: 24px;
        transition: transform 0.3s;
        display: none;
        /* Hide arrow by default */
    }

    /* Menu */
    .menu {
        width: 250px;
        height: 100vh;
        background-color: #87CEEB;
        /* Sky Blue */
        color: white;
        position: fixed;
        top: 0;
        left: -250px;
        transition: left 0.3s;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
        z-index: 1000;
    }

    .menu.open {
        left: 0;
        /* Show menu */
    }

    .menu-button {
        background-color: white;
        color: #FF69B4;
        /* Pink */
        font-size: 20px;
        border: none;
        padding: 20px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s, color 0.3s;
        text-align: center;
        border-bottom: 1px solid rgba(255, 105, 180, 0.2);
    }

    .menu-button:hover {
        background-color: #FF1493;
        /* Darker Pink */
        color: white;
    }

    .menu a {
        text-decoration: none;
        color: white;
        padding: 20px;
        border-bottom: 1px solid rgba(255, 105, 180, 0.2);
        font-size: 18px;
        text-align: center;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .menu a:hover {
        background-color: #FF1493;
        /* Darker Pink */
        color: white;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        padding: 20px;
        margin-left: 0;
        transition: margin-left 0.3s;
    }

    .main-content.menu-open {
        margin-left: 250px;
        /* Push content to the right when menu is open */
    }

    /* Quiz Container */
    .quiz-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        margin: 0 auto;
    }

    .quiz-container h2 {
        color: #FF69B4;
        /* Pink */
        text-align: center;
    }

    .quiz-container .question {
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .quiz-container .options {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quiz-container .option {
        background-color: #f0f0f0;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .quiz-container .option:hover {
        background-color: #FF69B4;
        /* Pink */
        color: white;
    }

    .quiz-container .submit-btn {
        background-color: #FF69B4;
        /* Pink */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
        width: 100%;
        transition: background-color 0.3s;
    }

    .quiz-container .submit-btn:hover {
        background-color: #FF1493;
        /* Darker Pink */
    }

    /* Footer */
    footer {
        background-color: white;
        padding: 1rem;
        color: #333;
        font-size: 0.9rem;
        text-align: center;
        margin-top: auto;
        /* Push footer to the bottom */
        box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header h1 {
            font-size: 20px;
        }

        .menu-button-header {
            font-size: 16px;
            padding: 8px 16px;
        }

        .menu {
            width: 100%;
            /* Full width for smaller screens */
            height: auto;
            /* Auto height for smaller screens */
            top: -100%;
            /* Hide menu initially */
            left: 0;
            bottom: auto;
            transition: top 0.3s;
        }

        .menu.open {
            top: 80px;
            /* Show menu under the header */
        }

        .menu-button-header .arrow {
            display: inline;
            /* Show arrow on smaller screens */
        }

        .menu-button-header .text {
            display: none;
            /* Hide "Menu" text on smaller screens */
        }

        .menu a {
            padding: 15px;
            /* Thinner menu items */
            font-size: 16px;
        }

        .main-content.menu-open {
            margin-left: 0;
            /* No margin for smaller screens */
        }
    }

    @media (max-width: 480px) {
        .header h1 {
            font-size: 18px;
        }

        .menu-button-header {
            font-size: 14px;
            padding: 6px 12px;
        }

        .menu a {
            padding: 10px;
            /* Thinner menu items */
            font-size: 14px;
        }

        .quiz-container {
            padding: 10px;
        }
    }
    </style>
</head>

<body class="primary-1-3">
    <div class="header">
        <button class="menu-button-header" id="menuButtonHeader" onclick="toggleMenu()">
            <span class="text">Menu</span>
            <span class="arrow">&#9664;</span>
        </button>
        <h1>Intro to Robotics Quiz - KidsBuild.Tech</h1>
    </div>
    <div class="menu" id="menu">
        <button class="menu-button" id="menuButton" onclick="toggleMenu()">Back</button>
        <a href="dashboard.php">Home</a>
        <a href="Study.html">Study</a>
        <a href="quiz_and_games.html">Quiz</a>
        <a href="profile.php">Profile</a>
        <a href="learning_materials.html">Other Learning Materials</a>
        <a href="logout.php">Log Out</a>
    </div>
    <div class="main-content" id="mainContent">
        <!-- Quiz Container -->
        <div class="quiz-container">
            <h2>Intro to Robotics Quiz</h2>
            <div id="quiz-content">
                <!-- Questions will be loaded here via JavaScript -->
                <div id="loading">Loading questions...</div>
            </div>
            <button id="submit-quiz" class="submit-btn" style="display: none;">Submit Quiz</button>

            <!-- Results container -->
            <div id="result-container" class="result-container">
                <h3>Quiz Results</h3>
                <p id="score-display"></p>
                <button id="retry-btn" class="submit-btn">Try Again</button>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2023 KidsBuild.Tech | Building the Future, One Robot at a Time
    </footer>

    <script>
    // Menu toggle function
    const menu = document.getElementById('menu');
    const menuButtonHeader = document.getElementById('menuButtonHeader');
    const menuButton = document.getElementById('menuButton');
    const mainContent = document.getElementById('mainContent');
    const arrow = document.querySelector('.arrow');

    function toggleMenu() {
        const isOpen = menu.classList.toggle('open');
        arrow.style.transform = isOpen ? 'rotate(90deg)' : 'rotate(0deg)';
    }

    // Quiz functionality
    let questions = [];
    let userAnswers = {};
    const quizTopic = '<?php echo $quizTopic; ?>';

    // Fetch questions from server
    async function loadQuestions() {
        try {
            const response = await fetch(`getquestions.php?topic=${encodeURIComponent(quizTopic)}`);
            if (!response.ok) {
                throw new Error('Failed to fetch questions');
            }

            questions = await response.json();
            if (questions.length === 0) {
                document.getElementById('quiz-content').innerHTML = '<p>No questions available for this topic.</p>';
                return;
            }

            renderQuestions();
            document.getElementById('submit-quiz').style.display = 'block';
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('quiz-content').innerHTML =
                '<p>Error loading questions. Please try again later.</p>';
        }
    }

    // Render questions in the quiz container
    function renderQuestions() {
        const quizContent = document.getElementById('quiz-content');
        quizContent.innerHTML = '';

        questions.forEach((question, index) => {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'question';
            questionDiv.innerHTML = `
          <p><strong>Question ${index + 1}:</strong> ${question.question}</p>
          <div class="options" data-question-id="${question.id}">
            <label class="option">
              <input type="radio" name="question_${question.id}" value="A"> ${question.option_a}
            </label>
            <label class="option">
              <input type="radio" name="question_${question.id}" value="B"> ${question.option_b}
            </label>
            <label class="option">
              <input type="radio" name="question_${question.id}" value="C"> ${question.option_c}
            </label>
            <label class="option">
              <input type="radio" name="question_${question.id}" value="D"> ${question.option_d}
            </label>
          </div>
        `;
            quizContent.appendChild(questionDiv);

            // Add event listeners to the radio buttons
            const options = questionDiv.querySelectorAll('.option');
            options.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options in this question
                    options.forEach(opt => opt.classList.remove('selected'));
                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Store the user's answer
                    const questionId = this.parentElement.dataset.questionId;
                    const radioInput = this.querySelector('input[type="radio"]');
                    userAnswers[questionId] = radioInput.value;
                });
            });
        });
    }

    // Handle quiz submission
    async function submitQuiz() {
        // Calculate score
        let score = 0;
        questions.forEach(question => {
            if (userAnswers[question.id] === question.correct_answer) {
                score++;
            }
        });

        // Display results
        const scoreDisplay = document.getElementById('score-display');
        scoreDisplay.textContent = `You scored ${score} out of ${questions.length}!`;

        document.getElementById('quiz-content').style.display = 'none';
        document.getElementById('submit-quiz').style.display = 'none';
        document.getElementById('result-container').style.display = 'block';

        // Save score to server
        try {
            const response = await fetch('submitscore.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    topic: quizTopic,
                    score: score,
                    totalQuestions: questions.length
                }),
            });

            const result = await response.json();
            if (result.status !== 'success') {
                console.error('Error saving score:', result.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Retry quiz
    function retryQuiz() {
        userAnswers = {};
        document.getElementById('quiz-content').style.display = 'block';
        document.getElementById('submit-quiz').style.display = 'block';
        document.getElementById('result-container').style.display = 'none';

        // Clear selected answers
        const options = document.querySelectorAll('.option');
        options.forEach(option => {
            option.classList.remove('selected');
            const radio = option.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', loadQuestions);
    document.getElementById('submit-quiz').addEventListener('click', submitQuiz);
    document.getElementById('retry-btn').addEventListener('click', retryQuiz);
    </script>
</body>

</html>