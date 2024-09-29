<?php
// Start session
session_start();

// Database configuration
$host = 'localhost';
$db = 'Alumni_Database';
$user = 'root';
$pass = '12345';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch user id
    $stmt = $pdo->prepare("SELECT id FROM accounts WHERE username = :username");
    $stmt->execute(['username' => $_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete the user account
    $deleteStmt = $pdo->prepare("DELETE FROM accounts WHERE id = :id");
    $deleteStmt->execute(['id' => $user['id']]);

    // Destroy session and redirect to login
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
</head>
<body>

<h1>Are you sure you want to delete your account?</h1>

<form method="post" action="delete_account.php">
    <button type="submit">Delete Account</button>
</form>

<a href="manage_account.php">Cancel</a>

</body>
</html>