<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Confirmation</title>
</head>
<body>
<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    header("Location: Login-page.php");
    exit();  // Ensure no further code is executed
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Database connection details
$host = 'localhost';  // Your database host
$dbname = 'blood';    // Your database name
$username = 'root';   // Your MySQL username
$password = '';       // Your MySQL password (set this accordingly)

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get form data and trim leading/trailing whitespace
    $name = trim($_GET['name'] ?? '');
    $age = trim($_GET['age'] ?? '');
    $phone = trim($_GET['phone_number'] ?? '');
    $blood_group = $_GET['blood_group'] ?? '';
    $hospital = $_GET['hospital'] ?? '';
    $date = $_GET['date'] ?? '';
    $time_slot = $_GET['time_slot'] ?? '';
    $last_donated = $_GET['last_donated'] ?? NULL;  // Set to NULL if not available

    // Insert into the Donation table with user_id
    $sql = "INSERT INTO Donation (user_id, name, age, phone_number, blood_group, hospital_name, preferred_donation_date, time_slot, last_donated) 
            VALUES ('$user_id', '$name', '$age', '$phone', '$blood_group', '$hospital', '$date', '$time_slot', '$last_donated')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        echo "Your slot has been booked successfully!<br>";
        echo "Name: $name<br>";
        echo "Hospital: $hospital<br>";
        echo "Date: $date<br>";
        echo "Time slot: $time_slot<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();

?>

</body>
</html>
