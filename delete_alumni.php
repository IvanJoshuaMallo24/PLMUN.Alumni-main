<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumni_id = $_POST['alumni_id'];

    $deleteQuery = "DELETE FROM `2024-2025` WHERE alumni_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $alumni_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Record deleted successfully'); window.location.href='edit_alumni.php';</script>";
    } else {
        echo "<script>alert('Record not found'); window.location.href='edit_alumni.php';</script>";
    }
    $stmt->close();
}

$alumni_id = $_GET['id'];
$query = "SELECT * FROM `2024-2025` WHERE alumni_id = ?";
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
    <title>Delete Alumni</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { padding: 20px; text-align: center; }
        h2 { margin-bottom: 20px; }
        .button { padding: 10px 20px; background-color: #006400; color: white; border: none; cursor: pointer; }
        .button:hover { background-color: #004d00; }
    </style>
</head>
<body>

<div class="container">
    <h2>Delete Alumni</h2>
    <p>Are you sure you want to delete the alumni record for <strong><?= htmlspecialchars($alumni['first_name'] . ' ' . $alumni['last_name']) ?></strong>?</p>
    <form method="POST" action="">
        <input type="hidden" name="alumni_id" value="<?= htmlspecialchars($alumni['alumni_id']) ?>">
        <button type="submit" class="button">Yes, Delete</button>
        <a href="edit_alumni.php" class="button" style="margin-left: 10px;">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
$conn->close();
?>
