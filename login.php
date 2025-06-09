<?php
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

// Initialize variables
$rollNumber = '';
$studentEmail = '';
$loginError = '';
$emailVerificationError = '';
$studentData = null;
$verificationCode = '';

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $rollNumber = $_POST['rollNumber'];
    $studentEmail = $_POST['studentEmail'];

    // SQL query to check if the roll number and email ID match
    $sql = "SELECT * FROM registrations WHERE rollNumber = '$rollNumber' AND studentEmail = '$studentEmail'";
    $result = $conn->query($sql);

    // Check if a record was found
    if ($result->num_rows > 0) {
        // Fetch student data
        $studentData = $result->fetch_assoc();
        
        // Generate a random verification code
        $verificationCode = rand(100000, 999999);
        
        // Send the verification code to the student's email
        $subject = "Email Verification Code";
        $message = "Your email verification code is: $verificationCode";
        $headers = "From: no-reply@reg.mygbu.in";
        
        // Use PHP's mail function to send the email (ensure your server is configured to send emails)
        if (mail($studentEmail, $subject, $message, $headers)) {
            // Save verification code and student data to session
            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['student_data'] = $studentData;
            header("Location: verify_email.php"); // Redirect to a page for email verification
            exit();
        } else {
            $emailVerificationError = "Failed to send verification code to your email. Please try again.";
        }
    } else {
        $loginError = 'Invalid Roll Number or Email Address.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ffffff, #e8f0fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow-y: auto; /* Allow vertical scrolling */
        }

        .login-container {
            background: #ffffff;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 90%; /* Use relative width for responsiveness */
            max-width: 400px;
            text-align: center;
            position: relative;
            animation: fadeIn 1.5s ease-in-out;
            overflow-y: auto; /* Allow scrolling inside the container if needed */
            max-height: 90vh; /* Limit the height to 90% of the viewport */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container h2 {
            font-size: 26px;
            color: #333;
            margin-bottom: 30px;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: #f9f9f9;
            font-size: 16px;
            transition: all 0.3s;
        }

        .login-container input:focus {
            border-color: #007bff;
            background: #fff;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        .login-container button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(135deg, #6c63ff, #007bff);
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Student Login</h2>
        <?php if ($loginError): ?>
            <div class="error" style="color: red; font-weight: bold;"><?php echo $loginError; ?></div>
        <?php endif; ?>
        <?php if ($emailVerificationError): ?>
            <div class="error" style="color: red; font-weight: bold;"><?php echo $emailVerificationError; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="rollNumber" placeholder="Enter Roll Number" required>
            <input type="email" name="studentEmail" placeholder="Enter Email Address" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>