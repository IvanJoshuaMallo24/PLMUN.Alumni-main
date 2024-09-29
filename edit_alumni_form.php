<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumni_id = $_POST['alumni_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $college = $_POST['college'];
    $department = $_POST['department'];
    $section = $_POST['section'];
    $year_graduated = $_POST['year_graduated'];
    $contact_number = $_POST['contact_number'];
    $personal_email = $_POST['personal_email'];
    $working_status = $_POST['working_status'];

    // Update the alumni information in the 2024-2025 table
    $updateQuery1 = "UPDATE `2024-2025` SET 
                        last_name = ?, 
                        first_name = ?, 
                        college = ?, 
                        department = ?, 
                        section = ?, 
                        year_graduated = ?, 
                        contact_number = ?, 
                        personal_email = ? 
                    WHERE alumni_id = ?";
    
    $stmt1 = $conn->prepare($updateQuery1);
    $stmt1->bind_param("ssssssssi", $last_name, $first_name, $college, $department, $section, $year_graduated, $contact_number, $personal_email, $alumni_id);
    $stmt1->execute();

    // Check the current working status before updating
    $currentStatusQuery = "SELECT working_status FROM `2024-2025-ws` WHERE alumni_id = ?";
    $stmtStatus = $conn->prepare($currentStatusQuery);
    $stmtStatus->bind_param("i", $alumni_id);
    $stmtStatus->execute();
    $stmtStatus->bind_result($currentWorkingStatus);
    $stmtStatus->fetch();
    $stmtStatus->close();

    // Update the working status in the 2024-2025-ws table if it's different
    if ($working_status !== $currentWorkingStatus) {
        $updateQuery2 = "UPDATE `2024-2025-ws` SET 
                            working_status = ? 
                        WHERE alumni_id = ?";
        
        $stmt2 = $conn->prepare($updateQuery2);
        $stmt2->bind_param("si", $working_status, $alumni_id);
        $stmt2->execute();
        $statusAffectedRows = $stmt2->affected_rows;
        $stmt2->close();
    } else {
        $statusAffectedRows = 0;
    }

    if ($stmt1->affected_rows > 0 || $statusAffectedRows > 0) {
        echo "<script>alert('Record updated successfully'); window.location.href='edit_alumni.php';</script>";
    } else {
        echo "<script>alert('No changes made or record not found'); window.location.href='edit_alumni.php';</script>";
    }
    $stmt1->close();
}

$alumni_id = $_GET['id'];
$query = "SELECT a.*, w.working_status FROM `2024-2025` a LEFT JOIN `2024-2025-ws` w ON a.alumni_id = w.alumni_id WHERE a.alumni_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $alumni_id);
$stmt->execute();
$result = $stmt->get_result();
$alumni = $result->fetch_assoc();

if (!$alumni) {
    echo "No alumni found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alumni</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { padding: 20px; }
        h2 { text-align: center; }
        form { max-width: 600px; margin: auto; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; }
        .button { padding: 10px 20px; background-color: #006400; color: white; border: none; cursor: pointer; }
        .button:hover { background-color: #004d00; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Alumni</h2>
    <form method="POST" action="">
        <input type="hidden" name="alumni_id" value="<?= htmlspecialchars($alumni['alumni_id']) ?>">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($alumni['last_name']) ?>" required>

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($alumni['first_name']) ?>" required>

        <label for="college">College:</label>
        <input type="text" name="college" value="<?= htmlspecialchars($alumni['college']) ?>" required>

        <label for="department">Department:</label>
        <input type="text" name="department" value="<?= htmlspecialchars($alumni['department']) ?>" required>

        <label for="section">Section:</label>
        <input type="text" name="section" value="<?= htmlspecialchars($alumni['section']) ?>" required>

        <label for="year_graduated">Year Graduated:</label>
        <input type="text" name="year_graduated" value="<?= htmlspecialchars($alumni['year_graduated']) ?>" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" name="contact_number" value="<?= htmlspecialchars($alumni['contact_number']) ?>" required>

        <label for="personal_email">Personal Email:</label>
        <input type="email" name="personal_email" value="<?= htmlspecialchars($alumni['personal_email']) ?>" required>

        <label for="working_status">Working Status:</label>
        <select name="working_status" required>
            <option value="">Select Working Status</option>
            <option value="Employed" <?= ($alumni['working_status'] == 'Employed') ? 'selected' : '' ?>>Employed</option>
            <option value="Unemployed" <?= ($alumni['working_status'] == 'Unemployed') ? 'selected' : '' ?>>Unemployed</option>
            <option value="Self-Employed" <?= ($alumni['working_status'] == 'Self-Employed') ? 'selected' : '' ?>>Self-Employed</option>
        </select>

        <button type="submit" class="button">Update Alumni</button>
        <a href="edit_alumni.php" class="button" style="margin-left: 10px;">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
$conn->close();
?>
