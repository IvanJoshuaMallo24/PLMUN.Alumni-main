<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$dbname = "Alumni_Database";
$username = "root";
$password = "12345";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted_username = $_POST['username'];
    $submitted_password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $submitted_username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($submitted_password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Check user role and redirect accordingly
            switch (strtolower($user['role'])) {
                case 'registrar':
                    header("Location: landing.php");
                    break;
                case 'alumni':
                    header("Location: alumni_landing.php");
                    break;
                default:
                    $error = 'No valid role found. Please contact support.';
                    break;
            }
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
            background-color: rgba(0, 77, 0, 0.9);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            color: white;
            width: 300px;
            text-align: center;
        }
        .logo {
            width: 250px;
            margin-bottom: 1rem;
        }
        h2 {
            margin-bottom: 1rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        button {
            background-color: #ffffff;
            color: #004d00;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #cce5cc;
        }
        .error {
            color: #ffcc00;
            background-color: rgba(255, 0, 0, 0.3);
            padding: 0.5rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            width: 100%;
            text-align: center;
        }
        .signup-button {
            background-color: #cce5cc;
            color: #004d00;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 3px;
            display: inline-block;
            margin-top: 1rem;
        }
        .signup-button:hover {
            background-color: #99cc99;
        }
    </style>
</head>
<body>
<div class="login-container">
        <img src="images/plmun-logo.png" alt="School Logo" class="logo">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php" class="signup-button">Sign Up</a></p>
    </div>
</body>
</html>
