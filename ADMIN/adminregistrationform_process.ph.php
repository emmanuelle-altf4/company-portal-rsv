<?php
// Start the session
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'admin_data';
$username = 'root'; // Change this if you have a different username
$password = ''; // Change this if you have a different password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Adminname = $_POST['Adminname'];
    $Password = $_POST['Password'];


    // Hash the password before storing it in the database
$hashedPassword = password_hash($Password, PASSWORD_BCRYPT);


    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO admins (Adminname, Password) VALUES (?, ?)");
    $stmt->bind_param("ss", $Adminname, $hashedPassword);

    // Execute the query
    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to login page after successful registration
        header('Location: Adminlogin.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>
