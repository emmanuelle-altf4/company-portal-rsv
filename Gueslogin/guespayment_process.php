<?php
// guespayment.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'resortpayment_db'; // <- database name you requested

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die('DB connect error: ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}

// Collect and trim inputs
$customer_name  = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
$customer_email = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
$amount         = isset($_POST['amount']) ? trim($_POST['amount']) : '';
$method         = isset($_POST['method']) ? trim($_POST['method']) : '';
$invoice        = isset($_POST['invoice']) ? trim($_POST['invoice']) : null;
$payment_date   = isset($_POST['payment_date']) ? trim($_POST['payment_date']) : date('Y-m-d H:i:s');

// Basic validation
$errors = [];
if ($customer_name === '') $errors[] = 'Customer name is required.';
if ($customer_email === '' || !filter_var($customer_email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if ($amount === '' || !is_numeric($amount) || (float)$amount <= 0) $errors[] = 'Valid amount is required.';
if ($method === '') $errors[] = 'Payment method is required.';

if (!empty($errors)) {
    echo '<h3>Validation errors</h3><ul>';
    foreach ($errors as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
    echo '</ul>';
    exit;
}

// Auto-generate invoice if empty
if (empty($invoice)) {
    $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
}

// Prepare insert
$sql = "INSERT INTO payments (customer_name, customer_email, amount, payment_method, invoice_number, payment_date, status)
        VALUES (?, ?, ?, ?, ?, ?, 'completed')";

$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die('Prepare failed: ' . $mysqli->error);
}

// Bind parameters: s = string, d = double
$amt = number_format((float)$amount, 2, '.', '');
$stmt->bind_param('ssdsss', $customer_name, $customer_email, $amt, $method, $invoice, $payment_date);

if ($stmt->execute()) {
    // Success: redirect back to dashboard or show success
    header('Location: paymentsdashboard.php');
    exit;
} else {
    echo 'Database error: ' . $stmt->error;
    exit;
}
