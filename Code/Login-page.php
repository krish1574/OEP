<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost";
$username = "root"; // Adjust as necessary
$password = ""; // Adjust as necessary
$dbname = "blood"; // Adjust as necessary

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variable to hold the success or error message
$message = "";

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Determine whether it's a signup or login based on the submit button name
    if (isset($_POST['Login']) && $_POST['Login'] === 'Sign Up') {
        // Sign-up logic
        $user_id = mysqli_real_escape_string($conn, $_POST['User_id']);
        $password = password_hash(mysqli_real_escape_string($conn, $_POST['Password']), PASSWORD_DEFAULT);
        $phone_number = mysqli_real_escape_string($conn, $_POST['Phone-Number']);
        
        // Check if the phone number already exists
        $checkPhoneNumber = "SELECT * FROM usertable WHERE phone_number = '$phone_number'";
        $result = $conn->query($checkPhoneNumber);

        if ($result->num_rows > 0) {
            // Phone number already exists, set an error message in session
            $_SESSION['message'] = "Error: Phone number already exists. Please use a different phone number.";
        } else {
            // Phone number doesn't exist, proceed with the insertion
            $sql = "INSERT INTO usertable (Email, password, phone_number)
                    VALUES ('$user_id', '$password', '$phone_number')";

            if ($conn->query($sql) === TRUE) {
                // Success message with a welcoming tone
                $_SESSION['message'] = "🎉 User created successfully! Now login to continue your journey with us! 🚀";
            } else {
                $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        // Redirect to the same page to display the message
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['Login']) && $_POST['Login'] === 'Login') {
        // Login logic
        $user_id = mysqli_real_escape_string($conn, $_POST['User_id']);
        $password = mysqli_real_escape_string($conn, $_POST['Password']);
        
        // Check if user exists
        $sql = "SELECT * FROM usertable WHERE Email = '$user_id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Login successful, set session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_email'] = $row['Email'];

                // Redirect to the welcome page
                header("Location: welcome.php");
                exit();
            } else {
                $_SESSION['message'] = "Error: Invalid password.";
            }
        } else {
            $_SESSION['message'] = "Error: User does not exist.";
        }

        // Redirect to the same page to display the message
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Check if a message is set in the session and clear it after displaying
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="../CSS/Login-page.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins" rel="stylesheet" />
    <style>
        /* Styles for the dialog box */
        .dialog-box {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #f0f8ff; /* Light blue background */
            border: 2px solid #921A40; /* Attractive border color */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            border-radius: 8px;
            text-align: center;
            animation: fadeIn 0.5s; /* Animation effect */
        }

        .dialog-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .dialog-button {
            background-color: #921A40;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px; /* Increase font size */
            margin-top: 15px; /* Add some space above */
        }

        .dialog-button:hover {
            background-color: #C75B7A;
        }

        /* Animation for dialog box */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="Image_1">
        <img id="img-donor" src="../Images/img_donor.jfif" alt="" srcset="" />
    </div>
    <div class="Imgage_2">
        <img id="Img-Syringe" src="../Images/blood-bag.jfif" alt="" srcset="" />
    </div>
    <div class="Outer-Box" id="container">
        <div class="Inner-Box">
            <h1 id="Title-Outer-Box">Login to Blood Aid Portal</h1>
            <div class="form_elements">
                <form action="Login-page.php" method="post" id="loginForm">
                    <input type="text" name="User_id" class="Field" placeholder="Username" required />
                    <input type="password" name="Password" class="Field" placeholder="Password" required />
                    <input type="submit" name="Login" value="Login" id="Btn-Login" />
                </form>
            </div>
        </div>
        <div class="Sign-Up-Component">
            <h1 id="Welcome-SU-Title">Hello, Friend!</h1>
            <p id="text_welcome">Are You a New User..?</p>
            <input type="button" value="Sign Up" id="Btn-SignUp" />
        </div>
        <div class="Sign-Up-Box">
            <div class="Inner-Box-Sign-Up">
                <h1 id="Title-Outer-Box">Sign Up to Blood Aid Portal</h1>
                <div class="form_elements">
                    <form action="Login-page.php" method="post" id="signupForm">
                        <input type="text" name="User_id" class="Field" placeholder="Username" required />
                        <input type="password" name="Password" class="Field" placeholder="Password" required />
                        <input type="text" name="Phone-Number" class="Field" placeholder="Phone-Number" required />
                        <input type="submit" name="Login" value="Sign Up" id="Btn-Sign-In" />
                    </form>
                </div>
            </div>
        </div>
        <div class="Back-Login">
            <h1 id="Title-Sign-Up">Hello, Friend!</h1>
            <p id="Text-Sign-Up">Already a User...??</p>
            <input type="button" value="Login" id="Btn-SignIn" />
        </div>
    </div>

    <!-- Dialog Box for displaying messages -->
    <div class="dialog-overlay" id="dialogOverlay"></div>
    <div class="dialog-box" id="dialogBox">
        <p id="dialogMessage"><?php echo htmlspecialchars($message); ?></p>
        <button class="dialog-button" id="closeDialog">Close</button>
    </div>

    <script>
        const signUpButton = document.getElementById("Btn-SignUp");
        const signInButton = document.getElementById("Btn-SignIn");
        const container = document.getElementById("container");
        const dialogBox = document.getElementById("dialogBox");
        const dialogOverlay = document.getElementById("dialogOverlay");
        const closeDialog = document.getElementById("closeDialog");

        // Show the dialog box if there's a message
        if ("<?php echo $message; ?>" !== "") {
            dialogBox.style.display = 'block';
            dialogOverlay.style.display = 'block';
        }

        signUpButton.addEventListener("click", () => {
            container.classList.add("active");
        });

        signInButton.addEventListener("click", () => {
            container.classList.remove("active");
        });

        closeDialog.addEventListener("click", () => {
            dialogBox.style.display = 'none';
            dialogOverlay.style.display = 'none';
        });

        // // Form validation for Sign Up
        // document.getElementById("signupForm").addEventListener("submit", function (e) {
        //     const userId = document.querySelector('input[name="User_id"]').value;
        //     const password = document.querySelector('input[name="Password"]').value;
        //     const phoneNumber = document.querySelector('input[name="Phone-Number"]').value;
        //    // const passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/; // Password must be at least 8 characters long, with at least one letter, one number, and one special character
        //     const phoneRegex = /^\+91[6-9]\d{9}$/; // Phone number must start with +91 and be followed by a 10-digit number starting with 6-9

        //     if (!passwordRegex.test(password)) {
        //         alert("Password must be at least 8 characters long and contain at least one letter, one number, and one special character.");
        //         e.preventDefault(); // Prevent form submission
        //     } else if (!phoneRegex.test(phoneNumber)) {
        //         alert("Phone number must be exactly 10 digits and start with +91.");
        //         e.preventDefault(); // Prevent form submission
        //     }
        // });

        // // Form validation for Login
        // document.getElementById("loginForm").addEventListener("submit", function (e) {
        //     const userId = document.querySelector('input[name="User_id"]').value;
        //     const password = document.querySelector('input[name="Password"]').value;

        //     if (!userId || !password) {
        //         alert("Please fill in both username and password.");
        //         e.preventDefault(); // Prevent form submission
        //     }
        // });
    </script>
</body>
</html>
