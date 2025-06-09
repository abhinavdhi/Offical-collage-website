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

// Initialize search parameters
$searchQuery = '';
$filters = [];

// Check if filters are provided in the search form
if (isset($_GET['rollNumber']) && !empty($_GET['rollNumber'])) {
    $rollNumber = $conn->real_escape_string($_GET['rollNumber']);
    $filters[] = "rollNumber = '$rollNumber'";
}

if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = $conn->real_escape_string($_GET['name']);
    $filters[] = "fullName LIKE '%$name%'";
}

if (isset($_GET['programme']) && !empty($_GET['programme'])) {
    $programme = $conn->real_escape_string($_GET['programme']);
    $filters[] = "nameOfProgramme = '$programme'";
}

if (isset($_GET['branch']) && !empty($_GET['branch'])) {
    $branch = $conn->real_escape_string($_GET['branch']);
    $filters[] = "branchSpecialization = '$branch'";
}

if (isset($_GET['year']) && !empty($_GET['year'])) {
    $year = $conn->real_escape_string($_GET['year']);
    $filters[] = "year = '$year'";
}

if (isset($_GET['semester']) && !empty($_GET['semester'])) {
    $semester = $conn->real_escape_string($_GET['semester']);
    $filters[] = "semester = '$semester'";
}

// Build the search query
if (!empty($filters)) {
    $searchQuery = " WHERE " . implode(' AND ', $filters);
}

// Fetch all data from registrations table with optional filter
$sql = "SELECT * FROM registrations" . $searchQuery;
$result = $conn->query($sql);

// Determine if the logged-in user is a Super Admin
$isSuperAdmin = ($_SESSION['admin_role'] === 'super_admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .registration-portal {
            text-align: center;
            margin-bottom: 20px;
        }

        .registration-portal a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        form label {
            flex: 1 1 100%;
            margin-bottom: 5px;
        }

        form input, form select, form button {
            flex: 1 1 48%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons a {
            text-decoration: none;
            color: #007bff;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .action-buttons a:hover {
            background-color: #007bff;
            color: white;
        }

        @media (max-width: 768px) {
            form input, form select, form button {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Student Dashboard</h1>
    
    <!-- Search form -->
    <form method="GET" action="">
        <label for="rollNumber">Roll Number:</label>
        <input type="text" id="rollNumber" name="rollNumber" placeholder="Enter Roll Number">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Full Name">
        
        <label for="programme">Programme:</label>
        <select id="programme" name="programme">
            <option value="">Select Programme</option>
            <option value="B.tech">B.TECH</option>
            <option value="Integrated B.tech + M.tech">Integrated B.tech + M.tech</option>
            <option value="BCA">BCA</option>
            <option value="M.tech">M.tech</option>
            <option value="MCA">MCA</option>
            <option value="PHD">PHD</option>
        </select>
        
        <label for="branch">Branch:</label>
        <select id="branch" name="branch">
            <option value="">Select Branch</option>
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
                        <option value="Integrated B.tech + M.tech ECE(Wireless Communication and Networks)">Integrated B.tech + M.tech CSE(Wireless Communication and Networks)</option>
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
        
        <label for="year">Year:</label>
        <select id="year" name="year">
            <option value="">Select Year</option>
            <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                        <option value="5">5th Year</option>
        </select>
        
        <label for="semester">Semester:</label>
        <select id="semester" name="semester">
            <option value="">Select Semester</option>
 <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                        <option value="3">Semester 3</option>
                        <option value="4">Semester 4</option>
                        <option value="5">Semester 5</option>
                        <option value="6">Semester 6</option>
                        <option value="7">Semester 7</option>
                        <option value="8">Semester 8</option>
                        <option value="9">Semester 9</option>
                        <option value="10">Semester 10</option>
        </select>
        
        <button type="submit">Search</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Roll Number</th>
                <th>Full Name</th>
                <th>Father's Name</th>
                <th>Father's Occupation</th>
                <th>Programme</th>
                <th>Branch</th>
                <th>Year</th>
                <th>Semester</th>
                <th>Category</th>
                <th>Gender</th>
                <th>Domicile</th>
                <th>Aadhar Card</th>
                <th>Permanent Address</th>
                <th>Hostel Address</th>
                <th>Student Contact</th>
                <th>Student Email</th>
                <th>Father Contact</th>
                <th>Father Email</th>
                <th>Mother Contact</th>
                <th>Mother Email</th>
                <th>Odd Semester Amount</th>
                <th>Odd Semester Remaining</th>
                <th>Odd Semester Details</th>
                <th>Odd Semester Txn Details</th>
                <th>Odd Semester Platform</th>
                <th>Odd Semester Date</th>
                <th>Even Semester Amount</th>
                <th>Even Semester Remaining</th>
                <th>Even Semester Details</th>
                <th>Even Semester Txn Details</th>
                <th>Even Semester Platform</th>
                <th>Even Semester Date</th>
                <th>Hostel Amount</th>
                <th>Hostel Remaining</th>
                <th>Hostel Payment Mode</th>
                <th>Hostel Txn Details</th>
                <th>Hostel Platform</th>
                <th>Hostel Date</th>
                <th>Mess Amount</th>
                <th>Mess Remaining</th>
                <th>Mess Payment Mode</th>
                <th>Mess Txn Details</th>
                <th>Mess Platform</th>
                <th>Mess Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['rollNumber']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullName']); ?></td>
                        <td><?php echo htmlspecialchars($row['fathersName']); ?></td>
                        <td><?php echo htmlspecialchars($row['fatherOccupation']); ?></td>
                        <td><?php echo htmlspecialchars($row['nameOfProgramme']); ?></td>
                        <td><?php echo htmlspecialchars($row['branchSpecialization']); ?></td>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                        <td><?php echo htmlspecialchars($row['semester']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['stateDomicile']); ?></td>
                        <td><?php echo htmlspecialchars($row['aadharCard']); ?></td>
                        <td><?php echo htmlspecialchars($row['permanentAddress']); ?></td>
                        <td><?php echo htmlspecialchars($row['hostelAddress']); ?></td>
                        <td><?php echo htmlspecialchars($row['studentContact']); ?></td>
                        <td><?php echo htmlspecialchars($row['studentEmail']); ?></td>
                        <td><?php echo htmlspecialchars($row['fatherContact']); ?></td>
                        <td><?php echo htmlspecialchars($row['fatherEmail']); ?></td>
                        <td><?php echo htmlspecialchars($row['motherContact']); ?></td>
                        <td><?php echo htmlspecialchars($row['motherEmail']); ?></td>
                        <td><?php echo htmlspecialchars($row['oddSemesterAmount']); ?></td>
                        <td><?php echo htmlspecialchars($row['oddSemesterRemaining']); ?></td>
                        <td><?php echo htmlspecialchars($row['oddSemesterDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['oddSemesterTxnDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['oddSemesterPlatform']); ?></td>
                        <td><?php echo htmlspecialchars($row['oddSemesterDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['evenSemesterAmount']); ?></td>
                        <td><?php echo htmlspecialchars($row['evenSemesterRemaining']); ?></td>
                        <td><?php echo htmlspecialchars($row['evenSemesterDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['evenSemesterTxnDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['evenSemesterPlatform']); ?></td>
                        <td><?php echo htmlspecialchars($row['evenSemesterDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['hostelAmount']); ?></td>
                        <td><?php echo htmlspecialchars($row['hostelRemaining']); ?></td>
                        <td><?php echo htmlspecialchars($row['hostelPaymentMode']); ?></td>
                        <td><?php echo htmlspecialchars($row['hostelTxnDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['hostelPlatform']); ?></td>
                        <td><?php echo htmlspecialchars($row['hostelDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['messAmount']); ?></td>
                        <td><?php echo htmlspecialchars($row['messRemaining']); ?></td>
                        <td><?php echo htmlspecialchars($row['messPaymentMode']); ?></td>
                        <td><?php echo htmlspecialchars($row['messTxnDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['messPlatform']); ?></td>
                        <td><?php echo htmlspecialchars($row['messDate']); ?></td>
                       <td>
    <?php if ($isSuperAdmin): ?>
        <div class="action-buttons">
            <a href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a href="delete_student.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
            <!-- Generate Slip Button -->
            <a href="generate_slip.php?id=<?php echo $row['id']; ?>" target="_blank">Generate Slip</a>
        </div>
    <?php else: ?>
        <span>View Only</span>
    <?php endif; ?>
</td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="45">No data found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$conn->close();
?>