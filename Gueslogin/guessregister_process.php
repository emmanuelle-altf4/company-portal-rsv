<?php session_start(); 
// Database connection settings 
$host = 'localhost'; 
$dbname = 'logindata'; 
$username = 'root'; 
$password = ''; // Create connection 
$conn = new mysqli($host, $username, $password, $dbname); 
// Check connection 
if ($conn->connect_error) 
{ 
    die("Connection failed: " . $conn->connect_error); 
    } 
// Handle form submission 
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{ 
// Collect form data safely 
$cxname = trim($_POST['cxname']); 
$cxemail = trim($_POST['cxemail']); 
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // secure hash 
// Prepare insert statement 
$stmt = $conn->prepare("INSERT INTO customerdata (cxname, cxemail, password) 
VALUES (?, ?, ?)"); if (!$stmt) { die("Prepare failed: " . $conn->error); } 
$stmt->bind_param("sss", $cxname, $cxemail, $password); 
// Execute and redirect 
if ($stmt->execute()) { 
    // Store session values if needed 
$_SESSION['cxname'] = $cxname; 
$_SESSION['cxemail'] = $cxemail; // Redirect to login page inside Gueslogin folder 
header('Location: gueslogin.php'); 
exit(); 
} 
else 
{ echo "Error: " . $stmt->error; } 
$stmt->close(); 
} 
$conn->close(); ?>
