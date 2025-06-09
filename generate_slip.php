<?php
// Database connection details
$servername = "localhost";
$username = "u446285377_reg";
$password = "Volunned@2024";
$dbname = "u446285377_reg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is passed in URL, otherwise fall back to 'rollNumber'
if (isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM registrations WHERE id = ?");
    $stmt->bind_param("i", $studentId); // 'i' means integer
} elseif (isset($_GET['rollNumber'])) {
    $rollNumber = $_GET['rollNumber'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM registrations WHERE rollNumber = ?");
    $stmt->bind_param("s", $rollNumber); // 's' means string
} else {
    echo "No valid parameters provided.";
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $studentData = $result->fetch_assoc();
    
    // Now use the fetched data to populate the registration slip
    $rollNumber = $studentData['rollNumber'];
    $fullName = $studentData['fullName'];
    $fathersName = $studentData['fathersName'];
    $nameOfProgramme = $studentData['nameOfProgramme'];
    $branchSpecialization = $studentData['branchSpecialization'];
    $year = $studentData['year'];
    $semester = $studentData['semester'];
    $category = $studentData['category'];
    $gender = $studentData['gender'];
    $state = $studentData['stateDomicile'];
    $aadhar = $studentData['aadharCard'];
    $permanentAddress = $studentData['permanentAddress'];
    $hostelAddress = $studentData['hostelAddress'];
    $studentContact = $studentData['studentContact'];
    $studentEmail = $studentData['studentEmail'];
    $fatherContact = $studentData['fatherContact'];
    $fatherEmail = $studentData['fatherEmail'];
    $motherContact = $studentData['motherContact'];
    $motherEmail = $studentData['motherEmail'];
    $category = $studentData['category'];
    
    // Semester Payment Information
    $oddSemesterAmount = $studentData['oddSemesterAmount'];
    $oddSemesterRemaining = $studentData['oddSemesterRemaining'];
    $oddSemesterDetails = $studentData['oddSemesterDetails'];
    $oddSemesterTxnDetails = $studentData['oddSemesterTxnDetails'];
    $oddSemesterPlatform = $studentData['oddSemesterPlatform'];
    $oddSemesterDate = $studentData['oddSemesterDate'];

    $evenSemesterAmount = $studentData['evenSemesterAmount'];
    $evenSemesterRemaining = $studentData['evenSemesterRemaining'];
    $evenSemesterDetails = $studentData['evenSemesterDetails'];
    $evenSemesterTxnDetails = $studentData['evenSemesterTxnDetails'];
    $evenSemesterPlatform = $studentData['evenSemesterPlatform'];
    $evenSemesterDate = $studentData['evenSemesterDate'];

    // Hostel Payment Information
    $hostelAmount = $studentData['hostelAmount'];
    $hostelRemaining = $studentData['hostelRemaining'];
    $hostelPaymentMode = $studentData['hostelPaymentMode'];
    $hostelTxnDetails = $studentData['hostelTxnDetails'];
    $hostelPlatform = $studentData['hostelPlatform'];
    $hostelDate = $studentData['hostelDate'];

    // Mess Payment Information
    $messAmount = $studentData['messAmount'];
    $messRemaining = $studentData['messRemaining'];
    $messPaymentMode = $studentData['messPaymentMode'];
    $messTxnDetails = $studentData['messTxnDetails'];
    $messPlatform = $studentData['messPlatform'];
    $messDate = $studentData['messDate'];

    // Generate the registration slip
    echo "
    <html>
    <head>
        <title>Registration Slip</title>
        <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: white;
        color: #333;
        padding: 0;
        margin: 0;
    }

    .slip-container {
        width: 100%;
        max-width: 100%;
        padding: 20px;
        padding-left: 2cm;
    }

    .slip-header,
    .details-section,
    .payment-section,
    .registration-summary {
        margin-bottom: 15px;
    }

    .slip-header {
        text-align: center;
    }

    .slip-header img {
        width: 80px;
        margin-bottom: 10px;
    }

    .slip-header h2 {
        font-size: 20px;
        color: #0056b3;
    }

    .slip-header h3 {
        font-size: 16px;
        color: #333;
    }

    .details-section h4,
    .payment-section h4,
    .registration-summary h4 {
        font-size: 16px;
        color: #0056b3;
        border-bottom: 1px solid #0056b3;
        margin-bottom: 10px;
    }

    .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .row div {
        width: 48%;
        font-size: 14px;
    }

.footer-section {
    display: flex;
    justify-content: flex-end;
    margin-top: 40px; /* Increased from 20px */
    font-size: 14px;
    padding-right: 2cm;
}

.signature-box {
    width: 30%;
    text-align: center;
    margin-left: auto;
    margin-top: 20px; /* Added margin-top */
}

.student-signature {
    margin-top: 30px; /* Specific margin for student signature */
}

.member-signature {
    margin-top: 30px; /* Specific margin for member signature */
}

@media print {
    .footer-section {
        padding-right: 2cm;
        margin-top: 40px;
    }
}
    .download-button {
        text-align: center;
        margin-top: 20px;
    }

    .download-button button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #0056b3;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .slip-container {
            width: 100%;
            max-width: 100%;
            padding-left: 2cm;
        }

        .slip-header img {
            width: 70px;
        }

        .footer-section {
            margin-top: 15px;
            font-size: 12px;
        }

        .download-button {
            display: none;
        }

        @page {
            size: A4;
            margin: 0;
        }
    }
</style>
    </head>
    <body>
        <div class='slip-container'>
            <div class='slip-header'>
                <img src='images/GBU logo.png' alt='University Logo'>
                <h2>University School of Information and Communication Technology</h2>
                <h3>Gautam Buddha University, Greater Noida 2024-25</h3>
                <p><strong>Date:</strong> " . date("d-m-Y") . "</p>
            </div>

            <div class='details-section'>
                <div class='row'>
                    <div><strong>Roll Number:</strong> $rollNumber</div>
                    <div><strong>Student Name:</strong> $fullName</div>
                </div>
                <div class='row'>
                    <div><strong>Father's Name:</strong> $fathersName</div>
                    <div><strong>Programme:</strong> $nameOfProgramme</div>
                </div>
                <div class='row'>
                    <div><strong>Branch/Specialization:</strong> $branchSpecialization</div>
                    <div><strong>Year:</strong> $year</div>
                </div>
                <div class='row'>
                    <div><strong>Semester:</strong> $semester</div>
                    <div><strong>Academic Session:</strong> 2024-2025</div>
                </div>
                <div class='row'>
                    <div><strong>Gender:</strong> $gender</div>
                    <div><strong>State Domicile:</strong> $state</div>
                </div>
                <div class='row'>
                    <div><strong>Aadhar Card No:</strong> $aadhar</div>
                    <div><strong>Permanent Address:</strong> $permanentAddress</div>
                </div>
                <div class='row'>
                    <div><strong>Hostel Address:</strong> $hostelAddress</div>
                    <div><strong>Student Contact:</strong> $studentContact</div>
                </div>
                <div class='row'>
                    <div><strong>Father's Contact:</strong> $fatherContact</div>
                    <div><strong>Category:</strong> $category</div>
                </div>
                <div class='row'>
                    <div><strong>Student Email:</strong> $studentEmail</div>
                    <div><strong>Father's Email:</strong> $fatherEmail</div>
                </div>
                <div class='row'>
                    <div><strong>Mother's Contact:</strong> $motherContact</div>
                    <div><strong>Mother's Email:</strong> $motherEmail</div>
                </div>
            </div>

            <div class='footer-section'>
                <div class='signature-box student-signature'>
                    <p><strong></strong></p>
                    <hr>
                    <p>(Signed by Student with Date)</p>
                </div>
            </div>

            <div class='payment-section'>
                <h4>Fees Details</h4>
                <div class='row'>
                    <div><strong>Odd Semester Amount:</strong> $oddSemesterAmount</div>
                    <div><strong>Odd Semester Remaining:</strong> $oddSemesterRemaining</div>
                </div>
                <div class='row'>
                    <div><strong>Odd Semester Details:</strong> $oddSemesterDetails</div>
                    <div><strong>Odd Semester Platform:</strong> $oddSemesterPlatform</div>
                </div>
                <div class='row'>
                    <div><strong>Odd Semester Transaction Details:</strong> $oddSemesterTxnDetails</div>
                    <div><strong>Odd Semester Date:</strong> $oddSemesterDate</div>
                </div>

                <div class='row'>
                    <div><strong>Even Semester Amount:</strong> $evenSemesterAmount</div>
                    <div><strong>Even Semester Remaining:</strong> $evenSemesterRemaining</div>
                </div>
                <div class='row'>
                    <div><strong>Even Semester Details:</strong> $evenSemesterDetails</div>
                    <div><strong>Even Semester Platform:</strong> $evenSemesterPlatform</div>
                </div>
                <div class='row'>
                    <div><strong>Even Semester Transaction Details:</strong> $evenSemesterTxnDetails</div>
                    <div><strong>Even Semester Date:</strong> $evenSemesterDate</div>
                </div>

                <div class='row'>
                    <div><strong>Hostel Amount:</strong> $hostelAmount</div>
                    <div><strong>Hostel Remaining:</strong> $hostelRemaining</div>
                </div>
                <div class='row'>
                    <div><strong>Hostel Payment Mode:</strong> $hostelPaymentMode</div>
                    <div><strong>Hostel Platform:</strong> $hostelPlatform</div>
                </div>
                <div class='row'>
                    <div><strong>Hostel Transaction Details:</strong> $hostelTxnDetails</div>
                    <div><strong>Hostel Date:</strong> $hostelDate</div>
                </div>
            </div>

            <div class='footer-section'>
                <div class='signature-box member-signature'>
                    <p><strong></strong></p>
                    <hr>
                    <p>(Signed by Staff Member with Date)</p>
                </div>
            </div>

            <div class='registration-summary'>
                <h4>Registration Slip</h4>
                <div class='row'>
                    <div><strong>Roll Number:</strong> $rollNumber</div>
                    <div><strong>Student Name:</strong> $fullName</div>
                </div>
                <div class='row'>
                    <div><strong>Father's Name/Husband:</strong> $fathersName</div>
                    <div><strong>Programme:</strong> $nameOfProgramme</div>
                </div>
                <div class='row'>
                    <div><strong>Year:</strong> $year</div>
                    <div><strong>Semester:</strong> $semester</div>
                </div>
                <div class='row'>
                    <div><strong>Branch:</strong> $branchSpecialization</div>
                    <div><strong>Academic Session:</strong> 2024-2025</div>
                </div>
            </div>

            <div class='footer-section'>
                <div class='signature-box'>
                    <div>
                        <hr>
                        <p><strong>Signature of Registration Coordinator</strong></p>
                    </div>
                </div>
            </div>

            <div class='download-button'>
                <button onclick='window.print();'>Print Registration Slip</button>
            </div>
        </div>
    </body>
    </html>";
} else {
    echo "<p>No data found for the provided Roll Number.</p>";
}

$conn->close();
?>