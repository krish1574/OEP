<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login-page.php");
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";  // Your database password
$dbname = "blood";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $patient_name = $conn->real_escape_string($_POST['patient_name']);
    $age = (int)$_POST['age'];
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $required_blood_group = $conn->real_escape_string($_POST['required_blood_group']);
    $hospital_name = $conn->real_escape_string($_POST['select_hospital']);
    $required_date = !empty($_POST['required_date']) ? $conn->real_escape_string($_POST['required_date']) : NULL;

    // Construct the SQL query to insert data
    $sql = "INSERT INTO Request (user_id, patient_name, age, phone_number, required_blood_group, hospital_name, required_date) 
            VALUES ('$user_id', '$patient_name', '$age', '$phone_number', '$required_blood_group', '$hospital_name', " . 
            ($required_date ? "'$required_date'" : "NULL") . ")";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Get the last inserted request ID
        $last_id = $conn->insert_id;

        // Retrieve the data for confirmation display
        $result = $conn->query("SELECT * FROM Request WHERE request_id = $last_id");
        if ($result->num_rows > 0) {
            // Fetch the row data
            $row = $result->fetch_assoc();
            
            // Display the submitted data
            echo "<h1>Request Submitted Successfully!</h1>";
            echo "<p><strong>Patient Name:</strong> " . $row['patient_name'] . "</p>";
            echo "<p><strong>Age:</strong> " . $row['age'] . "</p>";
            echo "<p><strong>Phone Number:</strong> " . $row['phone_number'] . "</p>";
            echo "<p><strong>Required Blood Group:</strong> " . $row['required_blood_group'] . "</p>";
            echo "<p><strong>Hospital Name:</strong> " . $row['hospital_name'] . "</p>";
            echo "<p><strong>Required Date:</strong> " . ($row['required_date'] ? $row['required_date'] : "Not specified") . "</p>";
        } else {
            echo "<p>Error retrieving the data.</p>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "<p>No data submitted.</p>";
}
?>
