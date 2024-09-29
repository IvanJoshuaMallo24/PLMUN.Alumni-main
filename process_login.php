php
<?php
// process_login.php
include 'db.php'; // Include your database connection

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_input = $_POST['login_input']; // Username or Email
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM Users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $login_input, $login_input);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $login_input; // Store username in session
            header("Location: landing.php"); // Redirect to landing page
            exit();
        } else {
            echo "Invalid Password";
        }
    } else {
        echo "No user found with that username or email.";
    }

    $stmt->close();
}
?>