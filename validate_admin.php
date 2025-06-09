<?php
session_start();

// Define admin credentials
$admins = [
    'super_admin' => [
        'username' => 'mainadmin',
        'password' => 'soict@987'
    ],
    'office_admin' => [
        'username' => 'officeadmin',
        'password' => 'office@363'
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    foreach ($admins as $role => $credentials) {
        if ($username === $credentials['username'] && $password === $credentials['password']) {
            // Successful login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_role'] = $role; // Store the role of the admin
            header("Location: summary_dash.php");
            exit;
        }
    }

    // Failed login
    echo "<script>alert('Invalid username or password.'); window.location.href = 'admin_login.html';</script>";
    exit;
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = 'admin_login.html';</script>";
    exit;
}
?>