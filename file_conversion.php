<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];
    if ($file['error'] == 0) {
        $filename = $file['tmp_name'];
        $fileHandle = fopen($filename, 'r');
        fgetcsv($fileHandle); // Skip header row

        while (($row = fgetcsv($fileHandle)) !== false) {
            $alumni_id = $row[0];
            $last_name = $row[1];
            $first_name = $row[2];
            $college = $row[3];
            $department = $row[4];
            $section = $row[5];
            $year_graduated = $row[6];
            $contact_number = $row[7];
            $personal_email = $row[8];
            $working_status = $row[9];

            $query1 = "INSERT INTO `2024-2025` (alumni_id, last_name, first_name, college, department, section, year_graduated, contact_number, personal_email) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bind_param("sssssssss", $alumni_id, $last_name, $first_name, $college, $department, $section, $year_graduated, $contact_number, $personal_email);
            $stmt1->execute();

            $query2 = "INSERT INTO `2024-2025-ws` (alumni_id, last_name, first_name, working_status) VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("ssss", $alumni_id, $last_name, $first_name, $working_status);
            $stmt2->execute();
        }
        fclose($fileHandle);
        echo "<script>alert('File uploaded successfully!');</script>";
    } else {
        echo "<script>alert('Error uploading file.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Conversion</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        nav { display: flex; align-items: center; justify-content: space-between; background-color: #006400; padding: 10px 20px; }
        nav img { max-height: 50px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .container { padding: 20px; }
        h2 { text-align: center; font-size: 35px; }
        .button { padding: 10px 20px; background-color: #006400; color: white; text-decoration: none; font-weight: bold; border-radius: 5px; border: none; cursor: pointer; }
        .button:hover { background-color: #004d00; }
        .example { margin-top: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #006400; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
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
        <a href="manage_account.php">Account</a>
    </div>
</nav>

<div class="container">
    <h2>Upload CSV File</h2>
    <form method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center;">
        <input type="file" name="csv_file" accept=".csv" required style="margin-bottom: 10px;">
        <button type="submit" class="button">Upload</button>
    </form>

    <h2 class="example">Example CSV Format</h2>
    <p>Below is an example of how the CSV file should be formatted:</p>
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background-color: #006400; color: white;">
                <th>Alumni ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>College</th>
                <th>Department</th>
                <th>Section</th>
                <th>Year Graduated</th>
                <th>Contact Number</th>
                <th>Personal Email</th>
                <th>Working Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>A001</td>
                <td>Doe</td>
                <td>John</td>
                <td>Engineering</td>
                <td>Computer Science</td>
                <td>CS101</td>
                <td>2024</td>
                <td>1234567890</td>
                <td>johndoe@example.com</td>
                <td>Employed</td>
            </tr>
            <tr>
                <td>A002</td>
                <td>Smith</td>
                <td>Jane</td>
                <td>Arts</td>
                <td>Graphic Design</td>
                <td>GD201</td>
                <td>2023</td>
                <td>0987654321</td>
                <td>janesmith@example.com</td>
                <td>Unemployed</td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
