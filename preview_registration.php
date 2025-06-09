<?php

session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Store form data in session variables
    $_SESSION['formData'] = $_POST;
} else {
 
    header("Location: regis.html");
    exit();
}


$formData = $_SESSION['formData'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Registration</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Preview Registration Details</h1>
        <form action="process_registration.php" method="POST">
            <?php foreach ($formData as $key => $value): ?>
                <div class="form-field">
                    <label><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?>:</label>
                    <input type="text" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>" readonly>
                </div>
            <?php endforeach; ?>

            <div class="form-field">
                <button type="button" onclick="window.history.back();">Edit</button>
                <button type="submit">Finalize Submission</button>
            </div>
        </form>
    </div>
</body>
</html>