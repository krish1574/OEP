<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: Login-page.php");
    exit();
}

// If the user is logged in, retrieve their email or other info
$user_email = $_SESSION['user_email'];

// Handle logout
if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: Login-page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f8ff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            color: #921A40;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        .logout-button {
            padding: 10px 20px;
            background-color: #921A40;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-button:hover {
            background-color: #C75B7A;
        }
    </style>
</head>
<body>
    <h1>Welcome to Blood Aid Portal!</h1>
    <p>Hello, <?php echo htmlspecialchars($user_email); ?>! You have successfully logged in.</p>

    <form action="welcome.php" method="post">
        <button type="submit" name="logout" class="logout-button">Log Out</button>
    </form>
</body>
</html>
