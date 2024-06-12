<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
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
  </style>
</head>
<body>
  <div class="header">
    <!-- Image in the top right corner, clickable -->
    <a href="profile.php"><img src="placeholder.png" alt="User Image"></a>
  </div>

  <div class="welcome-container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>You have successfully logged in.</p>
    <a href="logout.php" class="return-button">Logout</a>
  </div>
</body>
</html>
