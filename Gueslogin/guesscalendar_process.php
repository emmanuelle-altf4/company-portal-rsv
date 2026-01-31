<?php
// guesscalendar_process.php (handler nasa Guessreservation.php)
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    $_SESSION['reservation_errors'] = ['Database connection failed.'];
    header('Location: Guesreservation.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Guesreservation.php');
    exit;
}

$staffname = trim($_POST['staffname'] ?? '');
$reservation_date = trim($_POST['reservation_date'] ?? '');
$reservation_time = trim($_POST['reservation_time'] ?? '');
$customer_name = trim($_POST['customer_name'] ?? '');
$room_type = trim($_POST['room_type'] ?? '');

$errors = [];
if ($staffname === '') $errors[] = 'Staff name is required.';
if ($customer_name === '') $errors[] = 'Customer name is required.';
if ($reservation_time === '') $errors[] = 'Reservation time is required.';
if ($reservation_date === '') $errors[] = 'Reservation date is required.';

if ($reservation_date !== '') {
    $d = DateTime::createFromFormat('Y-m-d', $reservation_date);
    if (!($d && $d->format('Y-m-d') === $reservation_date)) {
        $errors[] = 'Reservation date must be in YYYY-MM-DD format.';
    }
}

if (!empty($errors)) {
    $_SESSION['reservation_errors'] = $errors;
    header('Location: Guesreservation.php');
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO reservations (staffname, reservation_date, reservation_time, customer_name, room_type)
     VALUES (?, ?, ?, ?, ?)"
);
if (!$stmt) {
    $_SESSION['reservation_errors'] = ['Database error.'];
    header('Location: Guesreservation.php');
    exit;
}
$stmt->bind_param('sssss', $staffname, $reservation_date, $reservation_time, $customer_name, $room_type);

if ($stmt->execute()) {
    $_SESSION['reservation_success'] = "Reservation saved (ID: {$stmt->insert_id}).";
    $stmt->close();
    $conn->close();
    header('Location: Guesreservation.php');
    exit;
} else {
    $_SESSION['reservation_errors'] = ['Database error: ' . $stmt->error];
    $stmt->close();
    $conn->close();
    header('Location: Guesreservation.php');
    exit;
}
