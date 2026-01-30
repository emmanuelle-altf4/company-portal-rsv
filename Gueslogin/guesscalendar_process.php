<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staffname = $_POST['staffname'];  // Staff name input
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];  
    $customer_name = $_POST['customer_name'];

    $sql = "INSERT INTO reservations (staffname, reservation_date, reservation_time, customer_name)
            VALUES ('$staffname', '$reservation_date', '$reservation_time', '$customer_name')";

    if ($conn->query($sql) === TRUE) {
        header('Location: Guesreservation.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
