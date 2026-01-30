<?php
$host = 'localhost';
$dbname = 'logindata';
$username = 'root'; 
$password = ''; 

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cxname = $_POST['cxname'];
    $cxemail = $_POST['cxemail'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // encrytion

    // simula dito hagang baba checking ng variable 
    var_dump($cxname, $cxemail); // eto sa value kasi why non diba?

    
    $stmt = $conn->prepare("INSERT INTO cxname (cxname, cxemail, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $cxname, $cxemail, $password);

    if ($stmt->execute()) {
        header('Location: gueslogin.php');;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
