<?php
session_start(); // Start the session

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.html');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - KidsBuild.Tech</title>
  <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
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

    /* Profile Section */
    .profile-section {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 600px;
      margin: 0 auto;
    }

    .profile-picture-container {
      position: relative;
      width: 120px;
      height: 120px;
      margin: 0 auto 20px;
    }

    .profile-picture {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      border: 5px solid #FF69B4;
      object-fit: cover;
      background-color: #f0f0f0;
    }

    .profile-details {
      margin-bottom: 30px;
    }

    .profile-details h2 {
      color: #FF69B4;
      /* Pink */
      margin: 0;
      font-size: 28px;
    }

    .profile-details p {
      margin: 10px 0;
      font-size: 16px;
    }

    .profile-picture-upload {
      margin-bottom: 25px;
    }

    .custom-file-upload {
      display: inline-block;
      padding: 10px 20px;
      background-color: #FF69B4;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
      margin-right: 10px;
    }

    .custom-file-upload:hover {
      background-color: #FF1493;
    }

    input[type="file"] {
      display: none;
    }

    button[type="submit"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }

    #fileSelectedText {
      display: block;
      margin-top: 8px;
      font-size: 14px;
      color: #666;
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
        padding: 10px;
      }

      .profile-picture-container {
        width: 100px;
        height: 100px;
      }
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <button class="menu-button-header" id="menuButtonHeader" onclick="toggleMenu()">
      <span class="text">Menu</span>
      <span class="arrow">&#9664;</span>
    </button>
    <h1>Profile - KidsBuild.Tech</h1>
  </div>

  <!-- Menu -->
  <div class="menu" id="menu">
    <button class="menu-button" id="menuButton" onclick="toggleMenu()">Back</button>
    <a href="dashboard.php">Home</a>
    <a href="study.html">Study</a>
    <a href="quiz_and_games.html">Quiz</a>
    <a href="profile.php">Profile</a>
    <a href="learning_materials.html">Learning Materials</a>
    <a href="logout.php">Log Out</a>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <div class="profile-section">
      <!-- Profile Picture -->
      <div class="profile-picture-container">
        <img src="images/default-profile.jpg" alt="Profile Picture" class="profile-picture" id="profilePicture">
      </div>

      <!-- Profile Picture Upload -->
      <div class="profile-picture-upload">
        <form id="uploadForm" enctype="multipart/form-data">
          <label for="profilePictureInput" class="custom-file-upload">
            Choose File
          </label>
          <input type="file" name="profilePicture" id="profilePictureInput" accept="image/*">
          <button type="submit">Upload Picture</button>
          <span id="fileSelectedText">No file selected</span>
        </form>
      </div>

      <!-- Profile Details -->
      <div class="profile-details">
        <h2 id="profileName">Loading...</h2>
        <p id="profileAge">Age: Loading...</p>
        <p id="profileEmail">Email: Loading...</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; 2023 KidsBuild.Tech | Building the Future, One Robot at a Time
  </footer>

  <script>
    // Fetch user data from the backend
    async function fetchUserData() {
      try {
        const response = await fetch('get_profile.php');
        const user = await response.json();

        if (user.error) {
          console.error(user.error);
          return;
        }

        // Update profile details
        document.getElementById('profileName').textContent = user.name;
        document.getElementById('profileAge').textContent = `Age: ${user.age}`;
        document.getElementById('profileEmail').textContent = `Email: ${user.email}`;

        // Update profile picture
        const profilePicture = document.getElementById('profilePicture');
        if (user.profile_picture && user.profile_picture !== '') {
          profilePicture.src = user.profile_picture;
        } else {
          profilePicture.src = 'images/default-profile.jpg'; // Use default image if no picture is set
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    }

    // Update file selection text when user selects a file
    document.getElementById('profilePictureInput').addEventListener('change', function() {
      const fileName = this.files[0] ? this.files[0].name : 'No file selected';
      document.getElementById('fileSelectedText').textContent = fileName;
    });
    
    // Handle profile picture upload
    document.getElementById('uploadForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const fileInput = document.getElementById('profilePictureInput');
      if (!fileInput.files.length) {
        alert('Please select a file to upload.');
        return;
      }

      const formData = new FormData();
      formData.append('profilePicture', fileInput.files[0]);

      try {
        const response = await fetch('upload_profile_picture.php', {
          method: 'POST',
          body: formData,
        });
        const result = await response.json();

        if (result.success) {
          alert('Profile picture updated successfully!');
          document.getElementById('profilePicture').src = result.filePath + '?t=' + new Date().getTime(); // Add timestamp to prevent caching
          document.getElementById('fileSelectedText').textContent = 'No file selected';
          fileInput.value = ''; // Reset file input
        } else {
          alert('Error uploading profile picture: ' + result.error);
        }
      } catch (error) {
        console.error('Error uploading profile picture:', error);
        alert('An error occurred while uploading the profile picture.');
      }
    });

    // Toggle Menu Functionality
    const menu = document.getElementById('menu');
    const menuButtonHeader = document.getElementById('menuButtonHeader');
    const menuButton = document.getElementById('menuButton');
    const mainContent = document.getElementById('mainContent');
    const arrow = document.querySelector('.arrow');

    function toggleMenu() {
      const isOpen = menu.classList.toggle('open');
      if (arrow) {
        arrow.style.transform = isOpen ? 'rotate(90deg)' : 'rotate(0deg)';
      }
      mainContent.classList.toggle('menu-open', isOpen);
    }

    // Fetch and display user data when the page loads
    document.addEventListener('DOMContentLoaded', function() {
      fetchUserData();
    });
  </script>
</body>

</html>