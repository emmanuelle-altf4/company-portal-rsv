<?php
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

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM admins WHERE Adminname = ?");
    $stmt->bind_param("s", $Adminname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($Password, $user['Password'])) {
            $_SESSION['Adminname'] = $user['Adminname'];
            header('Location: Admindashboard.php');
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Admin not found.";
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>
