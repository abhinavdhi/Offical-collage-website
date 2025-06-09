<?php
session_start();

$verificationError = '';
$isVerified = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputCode = $_POST['verificationCode'];

    // Check if the entered code matches the one stored in the session
    if ($inputCode == $_SESSION['verification_code']) {
        // Email verified successfully, proceed to show the student data
        $studentData = $_SESSION['student_data'];
        $isVerified = true;
    } else {
        $verificationError = "Invalid verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f0fe, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            position: relative;
            animation: fadeIn 1s ease-in-out;
            <?php echo $isVerified ? 'display: none;' : ''; ?>
        }@keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .login-container .error {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .login-container input {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
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
            transition: all 0.3s ease;
        }

        .login-container button:hover {
            background: linear-gradient(135deg, #5a4de2, #0056b3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .student-details {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            text-align: left;
        }

        .student-details h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .student-details p {
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }

        .student-details strong {
            color: #333;
        }

        .download-btn {
            margin-top: 20px;
            text-align: center;
        }

        .download-btn button {
            background: #28a745;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .download-btn button:hover {
            background: #218838;
        }

        @media (max-width: 600px) {
            .login-container {
                padding: 30px;
                max-width: 350px;
            }

            .student-details {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
 <div class="login-container">
        <h2>Email Verification</h2>
        <?php if ($verificationError): ?>
            <div class="error"><?php echo $verificationError; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="verificationCode" placeholder="Enter Verification Code" required>
            <button type="submit">Verify</button>
        </form>
    </div>

    <?php if ($isVerified): ?>
        <div class="student-details">
            <h3>Welcome, <?php echo $studentData['fullName']; ?></h3>
            <p><strong>Roll Number:</strong> <?php echo $studentData['rollNumber']; ?></p>
            <p><strong>Father's Name:</strong> <?php echo $studentData['fathersName']; ?></p>
            <p><strong>Programme:</strong> <?php echo $studentData['nameOfProgramme']; ?></p>
            <p><strong>Branch/Specialization:</strong> <?php echo $studentData['branchSpecialization']; ?></p>
            <p><strong>Year:</strong> <?php echo $studentData['year']; ?></p>
            <p><strong>Semester:</strong> <?php echo $studentData['semester']; ?></p>
            <p><strong>Gender:</strong> <?php echo $studentData['gender']; ?></p>
            <p><strong>State Domicile:</strong> <?php echo $studentData['stateDomicile']; ?></p>
            <p><strong>Email:</strong> <?php echo $studentData['studentEmail']; ?></p>
            <p><strong>Contact:</strong> <?php echo $studentData['studentContact']; ?></p>

            <div class="download-btn">
                <a href="generate_registration_slip.php?rollNumber=<?php echo $studentData['rollNumber']; ?>">
                    <button type="button">Download Registration Slip</button>
                </a>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>