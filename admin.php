<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to the login page
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .header {
      background-color: #f4f4f4;
      padding: 20px;
      text-align: right;
    }
    .header img {
      max-width: 50px;
      border-radius: 50%;
      cursor: pointer;
      transition: transform 0.3s ease-in-out;
    }
    .header img:hover {
      transform: scale(1.1);
    }
    .welcome-container {
      max-width: 800px;
      margin: 50px auto;
      background: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    .return-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease-in-out;
    }
    .return-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="header">
    <!-- Image in the top right corner, clickable -->
    <a href="profile.php"><img src="placeholder.png" alt="User Image"></a>
  </div>

  <div class="welcome-container">
    <h2>Welcome Admin, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>You have successfully logged in.</p>
    <a href="logout.php" class="return-button">Logout</a>
  </div>
</body>
</html>
