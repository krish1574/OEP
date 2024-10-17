<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: Login-page.php");
exit(); // Ensure no further code is executed after the redirect
?>
