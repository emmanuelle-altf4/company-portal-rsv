<?php
include 'db.php';
session_start();

// Ensure only admin can access this page.
//if ($_SESSION['role'] != '') {
  //  die("Access denied!");
//}

// Fetch all payment records from the database.
$payments = $conn->query("
    SELECT payments.id, reservations.id AS reservation_id, users.username, 
           payments.amount_paid, payments.payment_method, payments.payment_date
    FROM payments
    JOIN reservations ON payments.reservation_id = reservations.id
    JOIN users ON reservations.user_id = users.id
")->fetchAll();

// Handle payment deletion.
if (isset($_GET['delete'])) {
    $payment_id = $_GET['delete'];
    $conn->prepare("DELETE FROM payments WHERE id = ?")->execute([$payment_id]);
    header('Location: payments_dashboard.php'); // Refresh the page.
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Payments Dashboard</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Payment ID</th>
                    <th>Reservation ID</th>
                    <th>User</th>
                    <th>Amount Paid</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= $payment['id'] ?></td>
                        <td><?= $payment['reservation_id'] ?></td>
                        <td><?= $payment['username'] ?></td>
                        <td>₱<?= number_format($payment['amount_paid'], 2) ?></td>
                        <td><?= $payment['payment_method'] ?></td>
                        <td><?= $payment['payment_date'] ?></td>
                        <td>
                            <a href="payments_dashboard.php?delete=<?= $payment['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this payment?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
