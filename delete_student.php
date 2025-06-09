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
    $sql = "DELETE FROM registrations WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: student_data.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: student_data.php");
    exit;
}
$conn->close();
?>