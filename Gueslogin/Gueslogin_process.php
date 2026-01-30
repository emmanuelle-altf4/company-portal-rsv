<?php
session_start();

<<<<<<< HEAD
// Database connection
$host = 'localhost';
$dbname = 'logindata';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
=======
$host = 'localhost';
$dbname = 'logindata';
$username = 'root'; 
$password = ''; 

//  connection parang sa ml kasi mahihina kayo
$conn = new mysqli($host, $username, $password, $dbname);

>>>>>>> 8dc5fd31c5ccec86e7047c9bff49eada89c3bfce
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

<<<<<<< HEAD
// Handle login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cxname = trim($_POST['cxname']);
   $password = $_POST['password'] ?? '';


    // Correct table name here
    $stmt = $conn->prepare("SELECT * FROM customerdata WHERE cxname = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

=======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cxname = $_POST['cxname'];
    $cxemail = $_POST['cxemail'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM cxname WHERE cxname = ?"); //dito ung sa database kung saan i seselect all nya kasama ung empl#
>>>>>>> 8dc5fd31c5ccec86e7047c9bff49eada89c3bfce
    $stmt->bind_param("s", $cxname);
    $stmt->execute();
    $result = $stmt->get_result();

<<<<<<< HEAD
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
=======
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

       
        if (password_verify($password, $user['password'])) {
            $_SESSION['cxemail'] = $user['cxemail'];
            $_SESSION['cxname'] = $user['cxname'];
            header('Location: cottageinfo.php');
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "email not found.";
>>>>>>> 8dc5fd31c5ccec86e7047c9bff49eada89c3bfce
    }

    $stmt->close();
}

$conn->close();
?>
