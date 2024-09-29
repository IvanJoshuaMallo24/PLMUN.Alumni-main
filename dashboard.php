<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$resultsPerPage = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startLimit = ($page - 1) * $resultsPerPage;

$collegeFilter = $_POST['college'] ?? '';
$departmentFilter = $_POST['department'] ?? '';
$sectionFilter = $_POST['section'] ?? '';

$query = "SELECT 
            a.alumni_id, 
            a.last_name AS student_last_name, 
            a.first_name AS student_first_name, 
            a.college, 
            a.department, 
            a.section, 
            a.year_graduated, 
            a.contact_number, 
            a.personal_email, 
            w.working_status 
          FROM 
            `2024-2025` a 
          LEFT JOIN 
            `2024-2025-ws` w 
          ON 
            a.alumni_id = w.alumni_id";

$conditions = [];
if ($collegeFilter) {
    $conditions[] = "a.college = '$collegeFilter'";
}
if ($departmentFilter) {
    $conditions[] = "a.department = '$departmentFilter'";
}
if ($sectionFilter) {
    $conditions[] = "a.section = '$sectionFilter'";
}

if ($conditions) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " LIMIT $startLimit, $resultsPerPage";

$totalQuery = "SELECT COUNT(*) as total FROM `2024-2025` a LEFT JOIN `2024-2025-ws` w ON a.alumni_id = w.alumni_id";
if ($conditions) {
    $totalQuery .= " WHERE " . implode(" AND ", $conditions);
}
$totalResult = $conn->query($totalQuery);
$totalAlumni = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalAlumni / $resultsPerPage);

$result = $conn->query($query);

$sectionsQuery = "SELECT DISTINCT section FROM `2024-2025`";
$sectionsResult = $conn->query($sectionsQuery);
$sections = [];
while ($row = $sectionsResult->fetch_assoc()) {
    $sections[] = $row['section'];
}

$departments = [
    'CAS' => ['PSYCHOLOGY', 'MASCOM'],
    'CBA' => ['HRM', 'MARKETING', 'OPERATIONS MANAGEMENT'],
    'CCJ' => ['CRIMINOLOGY'],
    'CTE' => ['ELEMENTARY EDUCATION', 'SECONDARY EDUCATION'],
    'CITCS' => ['COMPUTER SCIENCE', 'INFORMATION TECHNOLOGY', 'ACT']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNI DASHBOARD</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        nav { display: flex; align-items: center; justify-content: space-between; background-color: #006400; padding: 10px 20px; }
        nav img { max-height: 50px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .container { padding: 20px; }
        h2 { text-align: center; font-size: 35px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #006400; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .filter-container { display: flex; justify-content: center; margin-bottom: 20px; }
        .filter-container select { margin: 0 10px; padding: 5px; }
        .button { padding: 10px 20px; background-color: #006400; color: white; text-decoration: none; font-weight: bold; border-radius: 5px; border: none; cursor: pointer; }
        .button:hover { background-color: #004d00; }
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
    <h2>S.Y 2024-2025 ALUMNI LIST</h2>

    <div class="filter-container">
        <form method="POST" action="">
            <select name="college" id="college" onchange="updateDepartmentOptions()">
                <option value="">Select College</option>
                <option value="CAS" <?= $collegeFilter == 'CAS' ? 'selected' : '' ?>>CAS</option>
                <option value="CBA" <?= $collegeFilter == 'CBA' ? 'selected' : '' ?>>CBA</option>
                <option value="CCJ" <?= $collegeFilter == 'CCJ' ? 'selected' : '' ?>>CCJ</option>
                <option value="CTE" <?= $collegeFilter == 'CTE' ? 'selected' : '' ?>>CTE</option>
                <option value="CITCS" <?= $collegeFilter == 'CITCS' ? 'selected' : '' ?>>CITCS</option>
            </select>

            <select name="department" id="department" onchange="updateSectionOptions()">
                <option value="">Select Department</option>
                <?php if ($collegeFilter): ?>
                    <?php foreach ($departments[$collegeFilter] as $department): ?>
                        <option value="<?= $department ?>" <?= $departmentFilter == $department ? 'selected' : '' ?>><?= $department ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <select name="section" id="section">
                <option value="">Select Section</option>
                <?php foreach ($sections as $section): ?>
                    <option value="<?= $section ?>" <?= $sectionFilter == $section ? 'selected' : '' ?>><?= $section ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="button">Filter</button>
            <a href="dashboard.php" class="button" style="margin-left: 10px;">All Alumni</a>
        </form>
    </div>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="file_conversion.php" class="button" style="margin-right: 10px;">File Conversion</a>
        <a href="add_alumni.php" class="button">Add Alumni</a>
        <a href="edit_alumni.php" class="button" style="margin-left: 10px;">Edit Alumni</a>
    </div>

    <table>
        <thead>
            <tr>
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
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['alumni_id'] ?? 'N/A') . "</td>
                            <td>" . htmlspecialchars($row['student_last_name'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['student_first_name'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['college'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['department'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['section'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['year_graduated'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['contact_number'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['personal_email'] ?? '') . "</td>
                            <td>" . htmlspecialchars($row['working_status'] ?? 'Not Specified') . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 20px;">
        <a href="?page=1" class="button">&lt;&lt;</a>
        <a href="?page=<?= max(1, $page - 1) ?>" class="button">&lt;</a>
        <?php
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?page=$i' class='button'>" . $i . "</a>";
        }
        ?>
        <a href="?page=<?= min($totalPages, $page + 1) ?>" class="button">&gt;</a>
        <a href="?page=<?= $totalPages ?>" class="button">&gt;&gt;</a>
    </div>
</div>

</body>
</html>
