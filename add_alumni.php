<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumni_id = $_POST['alumni_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $college = $_POST['college'];
    $department = $_POST['department'];
    $section = $_POST['section'];
    $year_graduated = $_POST['year_graduated'];
    $contact_number = $_POST['contact_number'];
    $working_status = $_POST['working_status'];
    $personal_email = $_POST['personal_email'];

    $conn = new mysqli('localhost', 'root', '12345', 'Alumni_Database');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_sql = "SELECT * FROM `2024-2025` WHERE Alumni_id = '$alumni_id'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "Error: Alumni ID $alumni_id already exists.";
    } else {
        $sql1 = "INSERT INTO `2024-2025` (Alumni_id, Last_name, First_name, College, Department, Section, Year_graduated, Contact_number, Personal_email)
                VALUES ('$alumni_id', '$last_name', '$first_name', '$college', '$department', '$section', '$year_graduated', '$contact_number', '$personal_email')";

        $sql2 = "INSERT INTO `2024-2025-ws` (Alumni_id, Last_name, First_name, Working_status)
                VALUES ('$alumni_id', '$last_name', '$first_name', '$working_status')";

        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            header('Location: dashboard.php');
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Alumni</title>
    <style>
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #006400;
            padding: 10px 20px;
        }
        nav .logo {
            flex: 1;
        }
        nav img {
            max-height: 50px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #006400;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #005000;
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">
            <img src="images/plmun-logo.png" alt="School Logo">
        </div>
        <div>
            <a href="landing.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="account.php">Account</a>
        </div>
    </nav>

    <div class="container">
        <h2>Add Alumni</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="alumni_id">Alumni ID:</label>
            <input type="text" name="alumni_id" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>

            <label for="college">College:</label>
            <input type="text" name="college" required>

            <label for="department">Department:</label>
            <input type="text" name="department" required>

            <label for="section">Section:</label>
            <input type="text" name="section" required>

            <label for="year_graduated">Year Graduated:</label>
            <input type="number" name="year_graduated" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" required>

            <label for="personal_email">Personal Email:</label>
            <input type="email" name="personal_email" required>

            <label for="working_status">Working Status:</label>
            <select name="working_status" required>
                <option value="">Select Working Status</option>
                <option value="Employed">Employed</option>
                <option value="Unemployed">Unemployed</option>
                <option value="Self-Employed">Self-Employed</option>
            </select>

            <input type="submit" value="Add Alumni">
        </form>
    </div>

</body>
</html>
