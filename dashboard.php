<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - KidsBuild.Tech</title>
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
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-left: 0;
      transition: margin-left 0.3s;
    }

    .main-content.menu-open {
      margin-left: 250px;
      /* Push content to the right when menu is open */
    }

    /* Info Section */
    .info-section {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .info-section:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .info-section h2 {
      margin-top: 0;
      color: #FF69B4;
      /* Pink */
      font-size: 1.5rem;
    }

    .info-section img {
      width: 100%;
      max-width: 100%;
      border: 5px solid #FF69B4;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .info-section p {
      text-align: center;
      margin: 0;
    }

    /* Circular Progress Indicator */
    .progress-circle {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: conic-gradient(#FF69B4 0%, #f0f0f0 0%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .progress-circle::after {
      content: attr(data-progress) "%";
      position: absolute;
      font-size: 20px;
      color: #333;
    }

    /* Banner */
    .banner {
      background: url('images/banner.jpg') center/cover no-repeat;
      height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.8rem;
      font-weight: bold;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    /* Fun Fact Box */
    .fun-fact {
      background-color: #FFECB3;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      font-size: 1.2rem;
      font-weight: bold;
      margin: 20px 0;
      border-left: 5px solid #FF9800;
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

      .main-content {
        grid-template-columns: 1fr;
        /* Single column for mobile */
      }

      .info-section {
        padding: 10px;
      }
    }
  </style>
</head>

<body class="primary-1-3"> <!-- Default theme for Primary 1-3 -->
  <div class="header">
    <button class="menu-button-header" id="menuButtonHeader" onclick="toggleMenu()">
      <span class="text">Menu</span>
      <span class="arrow">&#9664;</span> <!-- Left arrow icon -->
    </button>
    <h1>KidsBuild.Tech Dashboard</h1>
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

    <div class="banner">Welcome to Your Learning Hub 🚀</div>


    <!-- Quiz Encouragement Section -->
    <div class="info-section">
      <div class="fun-fact">Did you know? The first robot was built in 1495 by Leonardo da Vinci! 🤖</div>

      <h2>Test Yourself!</h2>
      <img src="images/quiz.jpg" alt="Quiz Image">
      <p>Take a quiz to test your knowledge!</p>
      <button class="btn" onclick="window.location.href='quiz_and_games.html'">Start Quiz</button>
    </div>



  </div>
  <footer>
    &copy; 2023 KidsBuild.Tech | Building the Future, One Robot at a Time
  </footer>
  <script>
    const menu = document.getElementById('menu');
    const menuButtonHeader = document.getElementById('menuButtonHeader');
    const menuButton = document.getElementById('menuButton');
    const mainContent = document.getElementById('mainContent');
    const arrow = document.querySelector('.arrow');

    function toggleMenu() {
      const isOpen = menu.classList.toggle('open');
      arrow.style.transform = isOpen ? 'rotate(90deg)' : 'rotate(0deg)';
    }
  </script>
</body>

</html>