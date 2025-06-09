<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit;
}


$host = "localhost";
$user = "u446285377_reg";
$pass = "Volunned@2024";
$db = "u446285377_reg";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM registrations WHERE id = $id";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();
} else {
    header("Location: student_data.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fieldsToUpdate = [];

    // Check each field and add to update array if not empty
    if (!empty($_POST['rollNumber'])) {
        $rollNumber = $conn->real_escape_string($_POST['rollNumber']);
        $fieldsToUpdate[] = "rollNumber='$rollNumber'";
    }
    if (!empty($_POST['fullName'])) {
        $fullName = $conn->real_escape_string($_POST['fullName']);
        $fieldsToUpdate[] = "fullName='$fullName'";
    }
    if (!empty($_POST['fathersName'])) {
        $fathersName = $conn->real_escape_string($_POST['fathersName']);
        $fieldsToUpdate[] = "fathersName='$fathersName'";
    }
    if (!empty($_POST['nameOfProgramme'])) {
        $nameOfProgramme = $conn->real_escape_string($_POST['nameOfProgramme']);
        $fieldsToUpdate[] = "nameOfProgramme='$nameOfProgramme'";
    }
    if (!empty($_POST['branchSpecialization'])) {
        $branchSpecialization = $conn->real_escape_string($_POST['branchSpecialization']);
        $fieldsToUpdate[] = "branchSpecialization='$branchSpecialization'";
    }
    if (!empty($_POST['year'])) {
        $year = $conn->real_escape_string($_POST['year']);
        $fieldsToUpdate[] = "year='$year'";
    }
    if (!empty($_POST['semester'])) {
        $semester = $conn->real_escape_string($_POST['semester']);
        $fieldsToUpdate[] = "semester='$semester'";
    }
    if (!empty($_POST['category'])) {
        $category = $conn->real_escape_string($_POST['category']);
        $fieldsToUpdate[] = "category='$category'";
    }
    if (!empty($_POST['gender'])) {
        $gender = $conn->real_escape_string($_POST['gender']);
        $fieldsToUpdate[] = "gender='$gender'";
    }
    if (!empty($_POST['stateDomicile'])) {
        $stateDomicile = $conn->real_escape_string($_POST['stateDomicile']);
        $fieldsToUpdate[] = "stateDomicile='$stateDomicile'";
    }
    if (!empty($_POST['aadharCard'])) {
        $aadharCard = $conn->real_escape_string($_POST['aadharCard']);
        $fieldsToUpdate[] = "aadharCard='$aadharCard'";
    }
    if (!empty($_POST['permanentAddress'])) {
        $permanentAddress = $conn->real_escape_string($_POST['permanentAddress']);
        $fieldsToUpdate[] = "permanentAddress='$permanentAddress'";
    }
    if (!empty($_POST['hostelAddress'])) {
        $hostelAddress = $conn->real_escape_string($_POST['hostelAddress']);
        $fieldsToUpdate[] = "hostelAddress='$hostelAddress'";
    }
    if (!empty($_POST['studentContact'])) {
        $studentContact = $conn->real_escape_string($_POST['studentContact']);
        $fieldsToUpdate[] = "studentContact='$studentContact'";
    }
    if (!empty($_POST['studentEmail'])) {
        $studentEmail = $conn->real_escape_string($_POST['studentEmail']);
        $fieldsToUpdate[] = "studentEmail='$studentEmail'";
    }
    if (!empty($_POST['fatherContact'])) {
        $fatherContact = $conn->real_escape_string($_POST['fatherContact']);
        $fieldsToUpdate[] = "fatherContact='$fatherContact'";
    }
    if (!empty($_POST['fatherEmail'])) {
        $fatherEmail = $conn->real_escape_string($_POST['fatherEmail']);
        $fieldsToUpdate[] = "fatherEmail='$fatherEmail'";
    }
    if (!empty($_POST['motherContact'])) {
        $motherContact = $conn->real_escape_string($_POST['motherContact']);
        $fieldsToUpdate[] = "motherContact='$motherContact'";
    }
    if (!empty($_POST['motherEmail'])) {
        $motherEmail = $conn->real_escape_string($_POST['motherEmail']);
        $fieldsToUpdate[] = "motherEmail='$motherEmail'";
    }
    if (!empty($_POST['fatherOccupation'])) {
        $fatherOccupation = $conn->real_escape_string($_POST['fatherOccupation']);
        $fieldsToUpdate[] = "fatherOccupation='$fatherOccupation'";
    }
    if (!empty($_POST['oddSemesterAmount'])) {
        $oddSemesterAmount = $conn->real_escape_string($_POST['oddSemesterAmount']);
        $fieldsToUpdate[] = "oddSemesterAmount='$oddSemesterAmount'";
    }
    if (!empty($_POST['oddSemesterRemaining'])) {
        $oddSemesterRemaining = $conn->real_escape_string($_POST['oddSemesterRemaining']);
        $fieldsToUpdate[] = "oddSemesterRemaining='$oddSemesterRemaining'";
    }
    if (!empty($_POST['oddSemesterDetails'])) {
        $oddSemesterDetails = $conn->real_escape_string($_POST['oddSemesterDetails']);
        $fieldsToUpdate[] = "oddSemesterDetails='$oddSemesterDetails'";
    }
    if (!empty($_POST['oddSemesterTxnDetails'])) {
        $oddSemesterTxnDetails = $conn->real_escape_string($_POST['oddSemesterTxnDetails']);
        $fieldsToUpdate[] = "oddSemesterTxnDetails='$oddSemesterTxnDetails'";
    }
    if (!empty($_POST['oddSemesterPlatform'])) {
        $oddSemesterPlatform = $conn->real_escape_string($_POST['oddSemesterPlatform']);
        $fieldsToUpdate[] = "oddSemesterPlatform='$oddSemesterPlatform'";
    }
    if (!empty($_POST['oddSemesterDate'])) {
        $oddSemesterDate = $conn->real_escape_string($_POST['oddSemesterDate']);
        $fieldsToUpdate[] = "oddSemesterDate='$oddSemesterDate'";
    }
    if (!empty($_POST['evenSemesterAmount'])) {
        $evenSemesterAmount = $conn->real_escape_string($_POST['evenSemesterAmount']);
        $fieldsToUpdate[] = "evenSemesterAmount='$evenSemesterAmount'";
    }
    if (!empty($_POST['evenSemesterRemaining'])) {
        $evenSemesterRemaining = $conn->real_escape_string($_POST['evenSemesterRemaining']);
        $fieldsToUpdate[] = "evenSemesterRemaining='$evenSemesterRemaining'";
    }
    if (!empty($_POST['evenSemesterDetails'])) {
        $evenSemesterDetails = $conn->real_escape_string($_POST['evenSemesterDetails']);
        $fieldsToUpdate[] = "evenSemesterDetails='$evenSemesterDetails'";
    }
    if (!empty($_POST['evenSemesterTxnDetails'])) {
        $evenSemesterTxnDetails = $conn->real_escape_string($_POST['evenSemesterTxnDetails']);
        $fieldsToUpdate[] = "evenSemesterTxnDetails='$evenSemesterTxnDetails'";
    }
    if (!empty($_POST['evenSemesterPlatform'])) {
        $evenSemesterPlatform = $conn->real_escape_string($_POST['evenSemesterPlatform']);
        $fieldsToUpdate[] = "evenSemesterPlatform='$evenSemesterPlatform'";
    }
    if (!empty($_POST['evenSemesterDate'])) {
        $evenSemesterDate = $conn->real_escape_string($_POST['evenSemesterDate']);
        $fieldsToUpdate[] = "evenSemesterDate='$evenSemesterDate'";
    }
    if (!empty($_POST['hostelAmount'])) {
        $hostelAmount = $conn->real_escape_string($_POST['hostelAmount']);
        $fieldsToUpdate[] = "hostelAmount='$hostelAmount'";
    }
    if (!empty($_POST['hostelRemaining'])) {
        $hostelRemaining = $conn->real_escape_string($_POST['hostelRemaining']);
        $fieldsToUpdate[] = "hostelRemaining='$hostelRemaining'";
    }
    if (!empty($_POST['hostelPaymentMode'])) {
        $hostelPaymentMode = $conn->real_escape_string($_POST['hostelPaymentMode']);
        $fieldsToUpdate[] = "hostelPaymentMode='$hostelPaymentMode'";
    }
    if (!empty($_POST['hostelTxnDetails'])) {
        $hostelTxnDetails = $conn->real_escape_string($_POST['hostelTxnDetails']);
        $fieldsToUpdate[] = "hostelTxnDetails='$hostelTxnDetails'";
    }
    if (!empty($_POST['hostelPlatform'])) {
        $hostelPlatform = $conn->real_escape_string($_POST['hostelPlatform']);
        $fieldsToUpdate[] = "hostelPlatform='$hostelPlatform'";
    }
    if (!empty($_POST['hostelDate'])) {
        $hostelDate = $conn->real_escape_string($_POST['hostelDate']);
        $fieldsToUpdate[] = "hostelDate='$hostelDate'";
    }
    if (!empty($_POST['messAmount'])) {
        $messAmount = $conn->real_escape_string($_POST['messAmount']);
        $fieldsToUpdate[] = "messAmount='$messAmount'";
    }
    if (!empty($_POST['messRemaining'])) {
        $messRemaining = $conn->real_escape_string($_POST['messRemaining']);
        $fieldsToUpdate[] = "messRemaining='$messRemaining'";
    }
    if (!empty($_POST['messPaymentMode'])) {
        $messPaymentMode = $conn->real_escape_string($_POST['messPaymentMode']);
        $fieldsToUpdate[] = "messPaymentMode='$messPaymentMode'";
    }
    if (!empty($_POST['messTxnDetails'])) {
        $messTxnDetails = $conn->real_escape_string($_POST['messTxnDetails']);
        $fieldsToUpdate[] = "messTxnDetails='$messTxnDetails'";
    }
    if (!empty($_POST['messPlatform'])) {
        $messPlatform = $conn->real_escape_string($_POST['messPlatform']);
        $fieldsToUpdate[] = "messPlatform='$messPlatform'";
    }
    if (!empty($_POST['messDate'])) {
        $messDate = $conn->real_escape_string($_POST['messDate']);
        $fieldsToUpdate[] = "messDate='$messDate'";
    }

    // If there are fields to update, construct the SQL query
    if (!empty($fieldsToUpdate)) {
        $updateSql = "UPDATE registrations SET " . implode(", ", $fieldsToUpdate) . " WHERE id=$id";

        if ($conn->query($updateSql) === TRUE) {
            header("Location: student_data.php");
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No fields were updated.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eaeaea;
            margin: 0;
            padding: 0;
            color: #4b4b4b;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 36px;
            margin-top: 50px;
            font-weight: 600;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 20px 50px rgba(0, 0, 0, 0.2);
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-size: 18px;
            color: #555;
            font-weight: 500;
            margin-bottom: 6px;
        }

        input[type="text"], input[type="email"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="number"]:focus {
            border-color: #6c5ce7;
            box-shadow: 0px 0px 10px rgba(108, 92, 231, 0.3);
            outline: none;
        }

        button[type="submit"] {
            background-color: #6c5ce7;
            color: white;
            border: none;
            padding: 16px 35px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 12px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #5a47c0;
        }

        .form-footer {
            text-align: center;
            margin-top: 30px;
        }

        .form-footer a {
            color: #6c5ce7;
            text-decoration: none;
            font-size: 16px;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <h1>Edit Student</h1>
    <form method="POST" action="">
        <label for="rollNumber">Roll Number:</label>
        <input type="text" id="rollNumber" name="rollNumber" value="<?php echo htmlspecialchars($student['rollNumber']); ?>">
        
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($student['fullName']); ?>">
        
        <label for="fathersName">Father's Name:</label>
        <input type="text" id="fathersName" name="fathersName" value="<?php echo htmlspecialchars($student['fathersName']); ?>">
        
        <label for="nameOfProgramme">Programme:</label>
        <input type="text" id="nameOfProgramme" name="nameOfProgramme" value="<?php echo htmlspecialchars($student['nameOfProgramme']); ?>">
        
        <label for="branchSpecialization">Branch:</label>
        <input type="text" id="branchSpecialization" name="branchSpecialization" value="<?php echo htmlspecialchars($student['branchSpecialization']); ?>">
        
        <label for="year">Year:</label>
        <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($student['year']); ?>">
        
        <label for="semester">Semester:</label>
        <input type="text" id="semester" name="semester" value="<?php echo htmlspecialchars($student['semester']); ?>">
        
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($student['category']); ?>">
        
        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($student['gender']); ?>">
        
        <label for="stateDomicile">Domicile:</label>
        <input type="text" id="stateDomicile" name="stateDomicile" value="<?php echo htmlspecialchars($student['stateDomicile']); ?>">
        
        <label for="aadharCard">Aadhar Card:</label>
        <input type="text" id="aadharCard" name="aadharCard" value="<?php echo htmlspecialchars($student['aadharCard']); ?>">
        
        <label for="permanentAddress">Permanent Address:</label>
        <input type="text" id="permanentAddress" name="permanentAddress" value="<?php echo htmlspecialchars($student['permanentAddress']); ?>">
        
        <label for="hostelAddress">Hostel Address:</label>
        <input type="text" id="hostelAddress" name="hostelAddress" value="<?php echo htmlspecialchars($student['hostelAddress']); ?>">
        
        <label for="studentContact">Student Contact:</label>
        <input type="text" id="studentContact" name="studentContact" value="<?php echo htmlspecialchars($student['studentContact']); ?>">
        
        <label for="studentEmail">Student Email:</label>
        <input type="email" id="studentEmail" name="studentEmail" value="<?php echo htmlspecialchars($student['studentEmail']); ?>">
        
        <label for="fatherContact">Father Contact:</label>
        <input type="text" id="fatherContact" name="fatherContact" value="<?php echo htmlspecialchars($student['fatherContact']); ?>">
        
        <label for="fatherEmail">Father Email:</label>
        <input type="email" id="fatherEmail" name="fatherEmail" value="<?php echo htmlspecialchars($student['fatherEmail']); ?>">
        
        <label for="motherContact">Mother Contact:</label>
        <input type="text" id="motherContact" name="motherContact" value="<?php echo htmlspecialchars($student['motherContact']); ?>">
        
        <label for="motherEmail">Mother Email:</label>
        <input type="email" id="motherEmail" name="motherEmail" value="<?php echo htmlspecialchars($student['motherEmail']); ?>">
        
        <label for="fatherOccupation">Father's Occupation:</label>
        <input type="text" id="fatherOccupation" name="fatherOccupation" value="<?php echo htmlspecialchars($student['fatherOccupation']); ?>">
        
        <label for="oddSemesterAmount">Odd Semester Amount:</label>
        <input type="text" id="oddSemesterAmount" name="oddSemesterAmount" value="<?php echo htmlspecialchars($student['oddSemesterAmount']); ?>">
        
        <label for="oddSemesterRemaining">Odd Semester Remaining:</label>
        <input type="text" id="oddSemesterRemaining" name="oddSemesterRemaining" value="<?php echo htmlspecialchars($student['oddSemesterRemaining']); ?>">
        
        <label for="oddSemesterDetails">Odd Semester Details:</label>
        <input type="text" id="oddSemesterDetails" name="oddSemesterDetails" value="<?php echo htmlspecialchars($student['oddSemesterDetails']); ?>">
        
        <label for="oddSemesterTxnDetails">Odd Semester Txn Details:</label>
        <input type="text" id="oddSemesterTxnDetails" name="oddSemesterTxnDetails" value="<?php echo htmlspecialchars($student['oddSemesterTxnDetails']); ?>">
        
        <label for="oddSemesterPlatform">Odd Semester Platform:</label>
        <input type="text" id="oddSemesterPlatform" name="oddSemesterPlatform" value="<?php echo htmlspecialchars($student['oddSemesterPlatform']); ?>">
        
        <label for="oddSemesterDate">Odd Semester Date:</label>
        <input type="date" id="oddSemesterDate" name="oddSemesterDate" value="<?php echo htmlspecialchars($student['oddSemesterDate']); ?>">
        
        <label for="evenSemesterAmount">Even Semester Amount:</label>
        <input type="text" id="evenSemesterAmount" name="evenSemesterAmount" value="<?php echo htmlspecialchars($student['evenSemesterAmount']); ?>">
        
        <label for="evenSemesterRemaining">Even Semester Remaining:</label>
        <input type="text" id="evenSemesterRemaining" name="evenSemesterRemaining" value="<?php echo htmlspecialchars($student['evenSemesterRemaining']); ?>">
        
        <label for="evenSemesterDetails">Even Semester Details:</label>
        <input type="text" id="evenSemesterDetails" name="evenSemesterDetails" value="<?php echo htmlspecialchars($student['evenSemesterDetails']); ?>">
        
        <label for="evenSemesterTxnDetails">Even Semester Txn Details:</label>
        <input type="text" id="evenSemesterTxnDetails" name="evenSemesterTxnDetails" value="<?php echo htmlspecialchars($student['evenSemesterTxnDetails']); ?>">
        
        <label for="evenSemesterPlatform">Even Semester Platform:</label>
        <input type="text" id="evenSemesterPlatform" name="evenSemesterPlatform" value="<?php echo htmlspecialchars($student['evenSemesterPlatform']); ?>">
        
        <label for="evenSemesterDate">Even Semester Date:</label>
        <input type="date" id="evenSemesterDate" name="evenSemesterDate" value="<?php echo htmlspecialchars($student['evenSemesterDate']); ?>">
        
        <label for="hostelAmount">Hostel Amount:</label>
        <input type="text" id="hostelAmount" name="hostelAmount" value="<?php echo htmlspecialchars($student['hostelAmount']); ?>">
        
        <label for="hostelRemaining">Hostel Remaining:</label>
        <input type="text" id="hostelRemaining" name="hostelRemaining" value="<?php echo htmlspecialchars($student['hostelRemaining']); ?>">
        
        <label for="hostelPaymentMode">Hostel Payment Mode:</label>
        <input type="text" id="hostelPaymentMode" name="hostelPaymentMode" value="<?php echo htmlspecialchars($student['hostelPaymentMode']); ?>">
        
        <label for="hostelTxnDetails">Hostel Txn Details:</label>
        <input type="text" id="hostelTxnDetails" name="hostelTxnDetails" value="<?php echo htmlspecialchars($student['hostelTxnDetails']); ?>">
        
        <label for="hostelPlatform">Hostel Platform:</label>
        <input type="text" id="hostelPlatform" name="hostelPlatform" value="<?php echo htmlspecialchars($student['hostelPlatform']); ?>">
        
        <label for="hostelDate">Hostel Date:</label>
        <input type="date" id="hostelDate" name="hostelDate" value="<?php echo htmlspecialchars($student['hostelDate']); ?>">
        
        <label for="messAmount">Mess Amount:</label>
        <input type="text" id="messAmount" name="messAmount" value="<?php echo htmlspecialchars($student['messAmount']); ?>">
        
        <label for="messRemaining">Mess Remaining:</label>
        <input type="text" id="messRemaining" name="messRemaining" value="<?php echo htmlspecialchars($student['messRemaining']); ?>">
        
        <label for="messPaymentMode">Mess Payment Mode:</label>
        <input type="text" id="messPaymentMode" name="messPaymentMode" value="<?php echo htmlspecialchars($student['messPaymentMode']); ?>">
        
        <label for="messTxnDetails">Mess Txn Details:</label>
        <input type="text" id="messTxnDetails" name="messTxnDetails" value="<?php echo htmlspecialchars($student['messTxnDetails']); ?>">
        
        <label for="messPlatform">Mess Platform:</label>
        <input type="text" id="messPlatform" name="messPlatform" value="<?php echo htmlspecialchars($student['messPlatform']); ?>">
        
        <label for="messDate">Mess Date:</label>
        <input type="date" id="messDate" name="messDate" value="<?php echo htmlspecialchars($student['messDate']); ?>">
        
        <button type="submit">Update</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>