<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            position: relative;
            min-height: 100vh;
        }
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
        .main-content {
            text-align: center;
            padding: 20px;
            background-color: #FFDA03;
            height: auto;
        }
        h2 {
            margin: 20px 0;
            font-size: 45px;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .gallery-item {
            margin: 15px;
            text-align: center;
        }
        .gallery-item img {
            width: 100px;
            height: 100px;
        }
        .divider {
            display: table;
            font-size: 24px;
            text-align: center;
            width: 75%;
            margin: 10px auto;
        }
        .philosophy {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            text-align: left;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        .philosophy-item {
            flex: 1;
            margin: 0 25px;
        }
        .philosophy h3 {
            font-size: 30px;
            margin-bottom: 10px;
            font-weight: normal;
        }
        .philosophy p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 15px;
            font-weight: normal;
        }
        footer {
            background-color: #006400;
            color: white;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        footer a {
            color: #FFDA03;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .contact {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 14px;
            color: #006400;
            background-color: #fff;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .greeting {
            font-size: 24px;
            margin: 20px 0;
            color: #006400;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
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

    <!-- Greeting Message -->
    <div class="greeting" style="text-align: center;">
    Hello Admin/Registrar <?php echo htmlspecialchars($username); ?>, Welcome to PLMUN Alumni Website!
</div>


    <!-- Main Content Area -->
    <div class="main-content">
        <h2>COLLEGES</h2>
        
        <!-- Gallery of College Icons -->
        <div class="gallery">
            <div class="gallery-item">
                <img src="images/cas-logo.png" alt="cas logo">
                <p>College of Arts & Sciences</p>
            </div>
            <div class="gallery-item">
                <img src="images/cba-logo.png" alt="cba logo">
                <p>College of Business Administration</p>
            </div>
            <div class="gallery-item">
                <img src="images/ccj-logo.png" alt="ccj logo">
                <p>College of Criminal Justice</p>
            </div>
            <div class="gallery-item">
                <img src="images/citcs-logo.png" alt="citcs logo">
                <p>College of Computer Studies</p>
            </div>
            <div class="gallery-item">
                <img src="images/cte-logo.png" alt="cte logo">
                <p>College of Teacher Education</p>
            </div>
        </div>

        <h2>EDUCATIONAL PHILOSOPHY</h2>
        <div class="philosophy">
            <div class="philosophy-item">
                <h3>Mission</h3>
                <p>To provide quality, affordable and relevant education responsive to the changing needs of the local and global communities through effective and efficient integration of instruction, research and extension; to develop productive and God-loving individuals in society.</p>
            </div>
            <div class="philosophy-item">
                <h3>Vision</h3>
                <p>A dynamic and highly competitive Higher Education Institution (HEI) committed to people empowerment towards building a humane society.</p>
            </div>
            <div class="philosophy-item">
                <h3>Quality Policy</h3>
                <p>“We, in the Pamantasan ng Lungsod ng Muntinlupa, commit to meet and even exceed our clients’ needs and expectations by adhering to good governance, productivity and continually improving the effectiveness of our Quality Management System in compliance to ethical standards and applicable statutory and regulatory requirements.”</p>
            </div>
        </div>
    </div>

    <!-- Contact Info in Bottom Corner -->
    <div class="contact">
        Email: <a href="mailto:plmuncomm@plmun.edu.ph">plmuncomm@plmun.edu.ph</a>
    </div>

    <!-- Footer with Website Link -->
    <footer>
        Visit our official website: <a href="https://www.plmun.edu.ph/#" target="_blank">https://www.plmun.edu.ph/#</a>
    </footer>

</body>
</html>
