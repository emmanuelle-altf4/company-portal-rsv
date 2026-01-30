<?php
include 'db.php';
session_start();

// Ensure only admin can access this page.
if ($_SESSION['role'] != '') {
    die("Access denied!");
}

// Handle form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $amount_paid = $_POST['amount_paid'];
    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("
        INSERT INTO payments (reservation_id, amount_paid, payment_method) 
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$reservation_id, $amount_paid, $payment_method]);

    echo "Payment added successfully!";
}

$reservations = $conn->query("SELECT id FROM reservations")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Payment</h2>
        <form method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="reservation_id" class="form-label">Reservation ID</label>
                <select name="reservation_id" id="reservation_id" class="form-select" required>
                    <option value="">Select Reservation</option>
                    <?php foreach ($reservations as $res): ?>
                        <option value="<?= $res['id'] ?>">Reservation <?= $res['id'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount_paid" class="form-label">Amount Paid</label>
                <input type="number" step="0.01" name="amount_paid" id="amount_paid" 
                       class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" 
                       class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Payment</button>
        </form>
    </div>
</body>
</html>
