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
    $Employeename = $_POST['Employeename'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM employees WHERE Employeename = ?"); //dito ung sa database kung saan i seselect all nya kasama ung empl#
    $stmt->bind_param("s", $Employeename);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kuya mike, paro, pj ano sa password to
        if (password_verify($password, $user['password'])) {
            $_SESSION['Employeenumber'] = $user['Employeenumber'];
            $_SESSION['Employeename'] = $user['Employeename'];
            header('Location: STAFF DASHBOARD/dashboard.php');
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Employee not found.";
    }

    $stmt->close();
}

$conn->close();
?>
