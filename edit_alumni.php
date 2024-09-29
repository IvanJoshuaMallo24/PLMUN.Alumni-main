<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

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

$result = $conn->query($query);

$departments = [
    'CAS' => ['PSYCHOLOGY', 'MASCOM'],
    'CBA' => ['HRM', 'MARKETING', 'OPERATIONS MANAGEMENT'],
    'CCJ' => ['CRIMINOLOGY'],
    'CTE' => ['ELEMENTARY EDUCATION', 'SECONDARY EDUCATION'],
    'CITCS' => ['COMPUTER SCIENCE', 'INFORMATION TECHNOLOGY', 'ACT']
];

$sectionsQuery = "SELECT DISTINCT section FROM `2024-2025`";
$sectionsResult = $conn->query($sectionsQuery);
$sections = [];
while ($row = $sectionsResult->fetch_assoc()) {
    $sections[] = $row['section'];
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
        nav { display: flex; align-items: center; justify-content: space-between; background-color: #006400; padding: 10px 20px; }
        nav img { max-height: 50px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .container { padding: 20px; }
        h2 { text-align: center; font-size: 35px; }
        .message { text-align: center; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #006400; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .filter-container { display: flex; justify-content: center; margin-bottom: 20px; }
        .filter-container select { margin: 0 10px; padding: 5px; }
        .button { padding: 10px 20px; background-color: #006400; color: white; text-decoration: none; font-weight: bold; border-radius: 5px; border: none; cursor: pointer; }
        .button:hover { background-color: #004d00; }
        .action-buttons { display: flex; gap: 5px; } 
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
    <h2>Edit Alumni Section</h2>

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
            <a href="edit_alumni.php" class="button" style="margin-left: 10px;">All Alumni</a>
        </form>
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
                <th>Actions</th>
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
                            <td class='action-buttons'>
                                <a href='edit_alumni_form.php?id=" . $row['alumni_id'] . "' class='button'>Edit</a>
                                <a href='delete_alumni.php?id=" . $row['alumni_id'] . "' class='button' style='background-color: red;'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function updateDepartmentOptions() {
        const collegeSelect = document.getElementById('college');
        const departmentSelect = document.getElementById('department');
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        const selectedCollege = collegeSelect.value;
        const departments = {
            'CAS': ['PSYCHOLOGY', 'MASCOM'],
            'CBA': ['HRM', 'MARKETING', 'OPERATIONS MANAGEMENT'],
            'CCJ': ['CRIMINOLOGY'],
            'CTE': ['ELEMENTARY EDUCATION', 'SECONDARY EDUCATION'],
            'CITCS': ['COMPUTER SCIENCE', 'INFORMATION TECHNOLOGY', 'ACT']
        };
        if (selectedCollege && departments[selectedCollege]) {
            departments[selectedCollege].forEach(department => {
                departmentSelect.innerHTML += `<option value="${department}">${department}</option>`;
            });
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
