<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit;
}

// Database connection
$host = "localhost";
$user = "u446285377_reg";
$pass = "Volunned@2024";
$db = "u446285377_reg";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the selected branch from the GET or POST request
$selectedBranch = isset($_GET['branch']) ? $_GET['branch'] : '';

// Fetch data for summary dashboard
$sqlSummary = "SELECT COUNT(*) AS totalStudents, 
                      COUNT(DISTINCT nameOfProgramme) AS totalProgrammes,
                      COUNT(DISTINCT branchSpecialization) AS totalBranches,
                      SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS totalMales,
                      SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS totalFemales
               FROM registrations";
$resultSummary = $conn->query($sqlSummary);
$summaryData = $resultSummary->fetch_assoc();

// Fetch branch-wise student data if a branch is selected
$sqlBranchData = "";
if ($selectedBranch) {
    $sqlBranchData = "SELECT COUNT(*) AS branchStudents 
                      FROM registrations 
                      WHERE branchSpecialization = ?";
    $stmt = $conn->prepare($sqlBranchData);
    $stmt->bind_param("s", $selectedBranch);
    $stmt->execute();
    $branchResult = $stmt->get_result();
    $branchData = $branchResult->fetch_assoc();
    $branchStudentCount = $branchData['branchStudents'];
} else {
    $branchStudentCount = 0;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Summary Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            padding: 30px;
            margin: 0;
            position: relative; /* This allows positioning the home button */
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }

        .home-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 12px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .home-button:hover {
            background-color: #0056b3;
        }

        .summary-dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .summary-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 250px;
            text-align: center;
            transition: transform 0.3s;
        }

        .summary-card:hover {
            transform: scale(1.05);
        }

        .summary-card i {
            font-size: 40px;
            margin-bottom: 15px;
            color: #007bff;
        }

        .summary-card h3 {
            font-size: 36px;
            margin: 10px 0;
        }

        .summary-card p {
            font-size: 18px;
            color: #777;
        }

        .summary-card .sub-text {
            font-size: 14px;
            color: #aaa;
        }

        .btn {
            display: block;
            width: 250px;
            margin: 30px auto;
            padding: 12px;
            background-color: #28a745;
            color: white;
            text-align: center;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #218838;
        }

        .select-branch {
            margin-bottom: 30px;
            text-align: center;
        }

        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            width: 250px;
            border: 1px solid #ccc;
        }

        .chart {
            margin-top: 40px;
            text-align: center;
        }

        .chart h2 {
            margin-bottom: 20px;
        }

        .detailed-data {
            margin-top: 40px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .table td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <!-- Home Button -->
    <button class="home-button" onclick="window.location.href='index.html'">Home</button>

    <h1>Admin Summary Dashboard</h1>

    <!-- Branch Selection Form -->
    <div class="select-branch">
        <form method="GET" action="">
            <label for="branch">Select Branch:</label>
            <select name="branch" id="branch" onchange="this.form.submit()">
                <option value="">--All Branches--</option>
                <option value="CSE">CSE</option>
                <option value="CSE (AI)">CSE (AI)</option>
                <option value="CSE (Cyber Security)">CSE (Cyber Security)</option>
                <option value="CSE (Data Science)">CSE (Data Science)</option>
                <option value="CSE (Internet of Things)">CSE (IoT)</option>
                <option value="CSE (Machine Learning)">CSE (ML)</option>
                <option value="ECE">ECE</option>
                <option value="ECE (AI/ML)">ECE (AI/ML)</option>
                <option value="IT">IT</option>
                <option value="Integrated B.tech + M.tech CSE">Integrated B.tech + M.tech CSE</option>
                <option value="Integrated B.tech + M.tech CSE(AI and Robotics)">Integrated B.tech + M.tech CSE(AI and Robotics)</option>
                <option value="Integrated B.tech + M.tech CSE(Data Science)">Integrated B.tech + M.tech CSE(Data Science)</option>
                <option value="Integrated B.tech + M.tech CSE(Software Engineering)">Integrated B.tech + M.tech CSE(Software Engineering)</option>
                <option value="Integrated B.tech + M.tech CSE(Wireless Communication and Networks)">Integrated B.tech + M.tech CSE(Wireless Communication and Networks)</option>
                <option value="Integrated B.tech + M.tech ECE">Integrated B.tech + M.tech ECE</option>
                <option value="Integrated B.tech + M.tech ECE(Data Science)">Integrated B.tech + M.tech ECE(Data Science)</option>
                <option value="Integrated B.tech + M.tech ECE(AI and Robotics)">Integrated B.tech + M.tech ECE(AI and Robotics)</option>
                <option value="Integrated B.tech + M.tech ECE(VLSI Design)">Integrated B.tech + M.tech ECE(VLSI Design)</option>
                <option value="Integrated B.tech + M.tech ECE(Wireless Communication and Networks)">Integrated B.tech + M.tech ECE(Wireless Communication and Networks)</option>
                <option value="BCA">BCA</option>
                <option value="M.tech CSE(Software Engineering)">M.tech CSE (Software Engineering)</option>
                <option value="M.tech CSE(AI and Robotics)">M.tech CSE (AI and Robotics)</option>
                <option value="M.tech CSE (Data Science)">M.tech CSE (Data Science)</option>
                <option value="M.tech ECE (Wireless Communication and Networks)">M.tech ECE (Wireless Communication and Networks)</option>
                <option value="M.tech ECE(VLSI Design)">M.tech ECE (VLSI Design)</option>
                <option value="M.tech ECE(Railway Signaling Telecommunication and RAMS)">M.tech ECE (Railway Signaling Telecommunication and RAMS)</option>
                <option value="MCA">MCA</option>
                <option value="MCA (AI)">MCA (AI)</option>
                <option value="MCA (Data Science)">MCA (Data Science)</option>
                <option value="M.tech (Information and Communication Technology)">M.tech (Information and Communication Technology)</option>
                <option value="PHD (CSE)">PHD (CSE)</option>
                <option value="PHD (ECE)">PHD (ECE)</option>
            </select>
        </form>
    </div>

    <!-- Summary Dashboard -->
    <div class="summary-dashboard">
        <div class="summary-card">
            <i class="fas fa-users"></i>
            <h3><?php echo $summaryData['totalStudents']; ?></h3>
            <p>Total Students</p>
            <p class="sub-text">Registered Students across all programs</p>
        </div>
        <div class="summary-card">
            <i class="fas fa-graduation-cap"></i>
            <h3><?php echo $summaryData['totalProgrammes']; ?></h3>
            <p>Total Programs</p>
            <p class="sub-text">Distinct academic programs available</p>
        </div>
        <div class="summary-card">
            <i class="fas fa-branch"></i>
            <h3><?php echo $summaryData['totalBranches']; ?></h3>
            <p>Total Branches</p>
            <p class="sub-text">Different specializations offered</p>
        </div>
    </div>

    <!-- Gender Statistics -->
    <div class="summary-dashboard">
        <div class="summary-card">
            <i class="fas fa-male"></i>
            <h3><?php echo $summaryData['totalMales']; ?></h3>
            <p>Total Males</p>
        </div>
        <div class="summary-card">
            <i class="fas fa-female"></i>
            <h3><?php echo $summaryData['totalFemales']; ?></h3>
            <p>Total Females</p>
        </div>
    </div>

    <!-- Branch-specific Data -->
    <?php if ($selectedBranch): ?>
    <div class="detailed-data">
        <h2>Registered Students in <?php echo $selectedBranch; ?></h2>
        <p>Total Students in this Branch: <?php echo $branchStudentCount; ?></p>
    </div>
    <?php endif; ?>

    <!-- Link to go to detailed registration data -->
    <a href="student_data.php" class="btn">Go to Detailed Registration Data</a>

</body>
</html>
