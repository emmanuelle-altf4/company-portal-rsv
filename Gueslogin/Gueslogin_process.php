<?php
session_start();

$host = 'localhost';
$dbname = 'logindata';
$username = 'root'; 
$password = ''; 

//  connection parang sa ml kasi mahihina kayo
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cxname = $_POST['cxname'];
    $cxemail = $_POST['cxemail'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM cxname WHERE cxname = ?"); //dito ung sa database kung saan i seselect all nya kasama ung empl#
    $stmt->bind_param("s", $cxname);
    $stmt->execute();
    $result = $stmt->get_result();

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
    }

    $stmt->close();
}

$conn->close();
?>
