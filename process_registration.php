<?php
// Start the session to access form data
session_start();

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

// Check if form data is set in session
if (!isset($_SESSION['formData'])) {
    header("Location: regis.html");
    exit();
}

// Collect form data from session
$formData = $_SESSION['formData'];

$rollNumber = $formData['rollNumber'];
$fullName = $formData['fullName'];
$fathersName = $formData['fathersName'];
$nameOfProgramme = $formData['nameOfProgramme'];
$branchSpecialization = $formData['branchSpecialization'];
$year = $formData['year'];
$semester = $formData['semester'];
$category = $formData['category'];
$gender = $formData['gender'];
$stateDomicile = $formData['stateDomicile'];
$aadharCard = $formData['aadharCard'];
$permanentAddress = $formData['permanentAddress'];
$hostelAddress = $formData['hostelAddress'];
$studentContact = $formData['studentContact'];
$studentEmail = $formData['studentEmail'];
$fatherContact = $formData['fatherContact'];
$fatherEmail = $formData['fatherEmail'];
$motherContact = $formData['motherContact'];
$motherEmail = $formData['motherEmail'];
$fatherOccupation = $formData['fatherOccupation'];

$oddSemesterAmount = $formData['oddSemesterAmount'];
$oddSemesterRemaining = $formData['oddSemesterRemaining'];
$oddSemesterDetails = $formData['oddSemesterDetails'];
$oddSemesterTxnDetails = $formData['oddSemesterTxnDetails'];
$oddSemesterPlatform = $formData['oddSemesterPlatform'];
$oddSemesterDate = $formData['oddSemesterDate'];
$evenSemesterAmount = $formData['evenSemesterAmount'];
$evenSemesterRemaining = $formData['evenSemesterRemaining'];
$evenSemesterDetails = $formData['evenSemesterDetails'];
$evenSemesterTxnDetails = $formData['evenSemesterTxnDetails'];
$evenSemesterPlatform = $formData['evenSemesterPlatform'];
$evenSemesterDate = $formData['evenSemesterDate'];
$hostelAmount = $formData['hostelAmount'];
$hostelRemaining = $formData['hostelRemaining'];
$hostelPaymentMode = $formData['hostelPaymentMode'];
$hostelTxnDetails = $formData['hostelTxnDetails'];
$hostelPlatform = $formData['hostelPlatform'];
$hostelDate = $formData['hostelDate'];

$messAmount = $formData['messAmount'];
$messRemaining = $formData['messRemaining'];
$messPaymentMode = $formData['messPaymentMode'];
$messTxnDetails = $formData['messTxnDetails'];
$messPlatform = $formData['messPlatform'];
$messDate = $formData['messDate'];

// Check if roll number already exists in the database
$sqlCheck = "SELECT * FROM registrations WHERE rollNumber = '$rollNumber'";
$resultCheck = $conn->query($sqlCheck);

// If the roll number already exists, show a popup and stop the registration
if ($resultCheck->num_rows > 0) {
    echo "<script>
            alert('Roll Number already exists. Please check your details or contact the admin.');
            window.location.href = 'regis.html';
          </script>";
    exit(); // Stop further execution
}

// SQL query to insert form data into the database
$sql = "INSERT INTO registrations (
    rollNumber, fullName, fathersName, nameOfProgramme, branchSpecialization, year, semester, 
    category, gender, stateDomicile, aadharCard, permanentAddress, hostelAddress, studentContact, 
    studentEmail, fatherContact, fatherEmail, fatherOccupation, motherContact, motherEmail, 
    oddSemesterAmount, oddSemesterRemaining, oddSemesterDetails, oddSemesterTxnDetails, 
    oddSemesterPlatform, oddSemesterDate, evenSemesterAmount, evenSemesterRemaining, 
    evenSemesterDetails, evenSemesterTxnDetails, evenSemesterPlatform, evenSemesterDate, 
    hostelAmount, hostelRemaining, hostelPaymentMode, hostelTxnDetails, hostelPlatform, hostelDate, 
    messAmount, messRemaining, messPaymentMode, messTxnDetails, messPlatform, messDate
) VALUES (
    '$rollNumber', '$fullName', '$fathersName', '$nameOfProgramme', '$branchSpecialization', 
    '$year', '$semester', '$category', '$gender', '$stateDomicile', '$aadharCard', '$permanentAddress', 
    '$hostelAddress', '$studentContact', '$studentEmail', '$fatherContact', '$fatherEmail', '$fatherOccupation', 
    '$motherContact', '$motherEmail', '$oddSemesterAmount', '$oddSemesterRemaining', '$oddSemesterDetails', '$oddSemesterTxnDetails', 
    '$oddSemesterPlatform', '$oddSemesterDate', '$evenSemesterAmount', 
    '$evenSemesterRemaining', '$evenSemesterDetails', '$evenSemesterTxnDetails', 
    '$evenSemesterPlatform', '$evenSemesterDate', '$hostelAmount', 
    '$hostelRemaining', '$hostelPaymentMode', '$hostelTxnDetails', 
    '$hostelPlatform', '$hostelDate', '$messAmount', '$messRemaining', 
    '$messPaymentMode', '$messTxnDetails', '$messPlatform', '$messDate'
)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    // Registration successful, now redirect to login page
    header("Location: welcome.html");
    exit(); // Make sure no further code is executed
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Clear the session data after processing
unset($_SESSION['formData']);

// Close the connection
$conn->close();
?>
