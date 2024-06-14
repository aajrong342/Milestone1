<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the profile photo for the logged-in user
$stmt = $conn->prepare("SELECT profilePhoto FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($profilePhoto);
$stmt->fetch();
$stmt->close();
$conn->close();

// Convert the binary data to a base64-encoded string
$profilePhotoData = base64_encode($profilePhoto);
$profilePhotoSrc = 'data:image/jpeg;base64,' . $profilePhotoData;
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
      max-width: 200px;
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
    <a href="profile.php"><img src="<?php echo $profilePhotoSrc; ?>" alt="User Image"></a>
  </div>

  <div class="welcome-container">
    <h2>Welcome Admin, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>You have successfully logged in.</p>
    <a href="logout.php" class="return-button">Logout</a>
  </div>
  <script>
    // Disable back button functionality
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };

    // Ensure that the user cannot navigate back
    window.location.replace("#");
</script>
</body>
</html>
