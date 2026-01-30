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
    $Employeename = $_POST['Employeename'];
    $Employeenumber = $_POST['Employeenumber'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // encrytion

    // simula dito hagang baba checking ng variable 
    var_dump($Employeename, $Employeenumber); // eto sa value kasi why non diba?

    
    $stmt = $conn->prepare("INSERT INTO employees (Employeename, Employeenumber, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $Employeename, $Employeenumber, $password);

    if ($stmt->execute()) {
        header('Location: LogInAndregistrationform.php');;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
