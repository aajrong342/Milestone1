<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $profilePhoto = $_FILES['profilePhoto'];
    $role = 'user'; // Default role
    $error = '';

    if ($password !== $confirmPassword) {
      $error = 'Passwords do not match.';
  } else {
      // Generate a random salt
      $salt = bin2hex(random_bytes(4));
      // Combine the salt with the password
      $saltedPassword = $password . $salt;
      // Hash the combined salted password
      $hashedPassword = password_hash($saltedPassword, PASSWORD_BCRYPT);
    
        // Validate and upload profile photo
        $allowedMimeTypes = ['image/jpeg'];
        $allowedExtensions = ['jpg', 'jpeg'];
        $detectedMimeType = mime_content_type($profilePhoto['tmp_name']);
        $fileExtension = strtolower(pathinfo($profilePhoto['name'], PATHINFO_EXTENSION));

        if (in_array($detectedMimeType, $allowedMimeTypes) && in_array($fileExtension, $allowedExtensions)) {
            if ($profilePhoto['error'] == UPLOAD_ERR_OK && is_uploaded_file($profilePhoto['tmp_name'])) {
                $photoContent = addslashes(file_get_contents($profilePhoto['tmp_name']));
                $sql = "INSERT INTO users (fullName, username, email, phone, password, salt, profilePhoto, role) VALUES ('$fullName', '$username', '$email', '$phone', '$hashedPassword', '$salt', '$photoContent', '$role')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>
                            if (confirm('Are you sure that you\\'ve put down all the correct information?')) {
                                window.location.href = 'login.php';
                            }
                          </script>";
                    exit;
                } else {
                    $error = 'Failed to save user data: ' . $conn->error;
                }
            } else {
                $error = 'Profile photo upload error.';
            }
        } else {
            $error = 'Invalid file type. Only JPG files are allowed.';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      color: #fff;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Registration</h2>
    <?php if (isset($error)) { ?>
      <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <form id="registrationForm" method="POST" action="registration.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
      </div>
      <div class="form-group">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
        <small>Format: 123-456-7890</small>
      </div>
      <div class="form-group">
        <label for="profilePhoto">Profile Photo:</label>
        <input type="file" id="profilePhoto" name="profilePhoto" accept=".jpg, .jpeg" required>
      </div>
      <input type="submit" value="Register">
    </form>
  </div>
</body>
</html>
