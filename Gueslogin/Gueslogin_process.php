<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'logindata';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cxname = trim($_POST['cxname']);
   $password = $_POST['password'] ?? '';


    // Correct table name here
    $stmt = $conn->prepare("SELECT * FROM customerdata WHERE cxname = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $cxname);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['cxemail'] = $user['cxemail'];
            $_SESSION['cxname'] = $user['cxname'];

            // Redirect to cottageinfo.php
            header('Location: guessdashboard.php');
            exit();
        } else {
            echo "❌ Invalid password.";
        }
    } else {
        echo "❌ Customer name not found.";
    }

    $stmt->close();
}

$conn->close();
?>
