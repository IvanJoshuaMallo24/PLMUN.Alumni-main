<?php
session_start(); // Start the session
include 'db.php'; // Include database connection

// Initialize error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $role = $_POST['role']; // Get the selected role

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect to login page after successful signup
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error; // Show error if registration fails
    }

    $stmt->close(); // Close the statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/bgimage.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-position: center;
        }
        .signup-container {
            background-color: rgba(0, 77, 0, 0.9); /* Dark green with slight transparency */
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            color: white; /* White text */
            width: 300px; /* Fixed width */
            text-align: center; /* Centered text */
        }
        .logo {
            width: 250px; /* Set your logo width */
            margin-bottom: 1rem; /* Space below the logo */
        }
        .school-name {
            font-size: 1.5rem; /* Font size for school name */
            margin-bottom: 1rem; /* Space below the school name */
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        button {
            background-color: #ffffff; /* White button */
            color: #004d00; /* Dark green text */
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #cce5cc; /* Light green on hover */
        }
        .error {
            color: #ffcc00; /* Yellow for error messages */
            background-color: rgba(255, 0, 0, 0.3); /* Semi-transparent background for the error */
            padding: 0.5rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            display: inline-block; /* Center align */
            width: 100%; /* Full width */
            text-align: center; /* Center the text */
        }
        .login-button {
            background-color: #cce5cc; /* Light green */
            color: #004d00; /* Dark green text */
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 3px;
            display: inline-block;
            margin-top: 1rem;
        }
        .login-button:hover {
            background-color: #99cc99; /* Darker light green on hover */
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <img src="images/plmun-logo.png" alt="School Logo" class="logo"> <!-- Replace 'logo.png' with your logo file -->
        <h2>Sign Up</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p> <!-- Display error message -->
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="role">User Role:</label>
            <select id="role" name="role" required>
                <option value="alumni">Alumni</option>
                <option value="registrar">Registrar</option>
            </select>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php" class="login-button">Log In</a></p>
    </div>
</body>
</html>
